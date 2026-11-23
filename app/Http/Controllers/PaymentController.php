<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use KHQR\BakongKHQR;
use KHQR\Models\IndividualInfo;
use KHQR\Helpers\KHQRData;

class PaymentController extends Controller
{
    public function showPayment($bookingId)
    {
        $booking = Booking::with('aquarium')->findOrFail($bookingId);

        if (!auth()->user()->isAdmin() && $booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking');
        }

        $khqrData = $this->generateKHQR($booking);

        return view('payment.khqr', compact('booking', 'khqrData'));
    }

    public function uploadProof(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if (!auth()->user()->isAdmin() && $booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking');
        }

        $request->validate([
            'payment_proof'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            $booking->update([
                'payment_method' => 'Bakong KHQR',
                'payment_status' => 'pending_verification',
                'payment_proof'  => $path,
                'transaction_id' => $request->transaction_id ?? 'KHQR-' . strtoupper(Str::random(12)),
                'paid_at'        => now(),
            ]);
        }

        return redirect()->route('booking.receipt', $booking->id)
            ->with('success', 'Payment proof uploaded! Waiting for admin verification.');
    }

    public function verifyPayment($bookingId)
    {
        $booking = Booking::with('aquarium')->findOrFail($bookingId);
        $booking->update(['payment_status' => 'verified', 'status' => 'Confirmed']);

        // Telegram notification
        try {
            (new \App\Services\TelegramService())->bookingConfirmed($booking);
        } catch (\Exception $e) {}

        return redirect()->back()->with('success', 'Payment verified and booking confirmed!');
    }

    public function rejectPayment(Request $request, $bookingId)
    {
        $booking = Booking::with('aquarium')->findOrFail($bookingId);
        $booking->update(['payment_status' => 'rejected', 'status' => 'Cancelled']);

        // Telegram notification
        try {
            (new \App\Services\TelegramService())->bookingCancelled($booking);
        } catch (\Exception $e) {}

        return redirect()->back()->with('success', 'Payment rejected.');
    }

    private function generateKHQR(Booking $booking): array
    {
        $bakongAccountID = env('BAKONG_ACCOUNT_ID', 'yourname@wing');
        $merchantName    = env('BAKONG_MERCHANT_NAME', 'Aquarium Booking');
        $merchantCity    = env('BAKONG_MERCHANT_CITY', 'PHNOM PENH');
        $acquiringBank   = env('BAKONG_ACQUIRING_BANK') ?: null;
        $reference       = 'AQ-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);

        $currencyEnv = strtoupper(env('BAKONG_CURRENCY', 'USD'));
        $currency    = $currencyEnv === 'KHR' ? KHQRData::CURRENCY_KHR : KHQRData::CURRENCY_USD;
        $amount      = (float) $booking->total_price;

        $qrString = null;
        $md5      = null;

        try {
            $info = new \KHQR\Models\IndividualInfo(
                bakongAccountID:    $bakongAccountID,
                merchantName:       $merchantName,
                merchantCity:       $merchantCity,
                acquiringBank:      $acquiringBank,
                accountInformation: null,
                currency:           $currency,
                amount:             $amount,
                billNumber:         $reference,
                storeLabel:         'AquaDiveDeep',
            );

            $response = BakongKHQR::generateIndividual($info);
            $qrString = $response->data['qr'] ?? null;
            $md5      = $response->data['md5'] ?? null;
        } catch (\Throwable $e) {
            // fallback to static image
        }

        $qrImageUrl = $qrString
            ? 'https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=' . urlencode($qrString)
            : asset(env('BAKONG_QR_CODE_PATH', 'images/qr.jpg'));

        return [
            'qr_string'    => $qrString,
            'qr_image_url' => $qrImageUrl,
            'md5'          => $md5,
            'amount'       => $amount,
            'currency'     => $currencyEnv,
            'merchant_name'=> $merchantName,
            'reference'    => $reference,
            'booking_id'   => $booking->id,
        ];
    }

    public function webhook(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $status        = $request->input('status');
        $reference     = $request->input('reference');

        if ($status === 'success') {
            $bookingId = (int) str_replace('AQ-', '', ltrim($reference, '0'));
            $booking   = Booking::find($bookingId);

            if ($booking) {
                $booking->update([
                    'payment_status' => 'verified',
                    'transaction_id' => $transactionId,
                    'paid_at'        => now(),
                    'status'         => 'Confirmed',
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
