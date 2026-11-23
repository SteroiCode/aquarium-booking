<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Aquarium;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function show($id)
    {
        $aquarium = Aquarium::findOrFail($id);

        // Pre-generate KHQR data for the form (amount=0 for static display, updated via JS)
        $khqrData = $this->buildKhqrData($aquarium);

        return view('booking.index', compact('aquarium', 'khqrData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aquarium_id'    => 'required',
            'customer_name'  => 'required',
            'customer_email' => 'required|email',
            'visit_date'     => 'required|date',
            'tickets'        => 'required|integer|min:1',
            'payment_proof'  => 'required|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        $aquarium = Aquarium::findOrFail($request->aquarium_id);
        $total    = $aquarium->price * $request->tickets;

        $booking = Booking::create([
            'user_id'        => auth()->id(),
            'aquarium_id'    => $aquarium->id,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'visit_date'     => $request->visit_date,
            'tickets'        => $request->tickets,
            'total_price'    => $total,
            'status'         => 'Pending',
        ]);

        // Save payment proof immediately
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $booking->update([
            'payment_method' => 'Bakong KHQR',
            'payment_status' => 'pending_verification',
            'payment_proof'  => $path,
            'transaction_id' => $request->transaction_id ?? 'KHQR-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'paid_at'        => now(),
        ]);

        // Send Telegram notification to admin
        try {
            (new \App\Services\TelegramService())->newBooking($booking->load('aquarium'));
        } catch (\Exception $e) {}

        return redirect()->route('booking.pending', $booking->id)
            ->with('success', 'Booking submitted! Your payment is being verified by admin.');
    }

    private function buildKhqrData(Aquarium $aquarium): array
    {
        $bakongAccountID = env('BAKONG_ACCOUNT_ID', 'yourname@wing');
        $merchantName    = env('BAKONG_MERCHANT_NAME', 'Aquarium Booking');
        $merchantCity    = env('BAKONG_MERCHANT_CITY', 'PHNOM PENH');
        $currencyEnv     = strtoupper(env('BAKONG_CURRENCY', 'USD'));
        $currency        = $currencyEnv === 'KHR'
            ? \KHQR\Helpers\KHQRData::CURRENCY_KHR
            : \KHQR\Helpers\KHQRData::CURRENCY_USD;

        return [
            'bakong_account_id' => $bakongAccountID,
            'merchant_name'     => $merchantName,
            'merchant_city'     => $merchantCity,
            'currency'          => $currencyEnv,
            'currency_code'     => $currency,
            'price_per_ticket'  => $aquarium->price,
        ];
    }

    public function pending($id)
    {
        $booking = Booking::with('aquarium')->findOrFail($id);
        
        // Check if user owns this booking (admins can access any booking)
        if (!auth()->user()->isAdmin() && $booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this booking');
        }
        
        return view('booking.pending', compact('booking'));
    }

    public function receipt($id)
    {
        $booking = Booking::with('aquarium')->findOrFail($id);
        return view('booking.receipt', compact('booking'));
    }

    public function history()
    {
        $bookings = Booking::with('aquarium')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.history', compact('bookings'));
    }
}