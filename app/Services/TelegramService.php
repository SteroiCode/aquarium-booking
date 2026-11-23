<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private string $token;
    private string $chatId;

    public function __construct()
    {
        $this->token  = env('TELEGRAM_BOT_TOKEN', '');
        $this->chatId = env('TELEGRAM_CHAT_ID', '');
    }

    public function send(string $message): bool
    {
        if (empty($this->token) || empty($this->chatId)) {
            Log::warning('Telegram not configured: missing TELEGRAM_BOT_TOKEN or TELEGRAM_CHAT_ID');
            return false;
        }

        try {
            $response = Http::timeout(5)->post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                'chat_id'    => $this->chatId,
                'text'       => $message,
                'parse_mode' => 'HTML',
            ]);

            if (!$response->successful()) {
                Log::error('Telegram send failed: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Telegram exception: ' . $e->getMessage());
            return false;
        }
    }

    public function newBooking(\App\Models\Booking $booking): bool
    {
        $message = "🎫 <b>New Booking Received!</b>\n\n"
            . "👤 <b>Customer:</b> {$booking->customer_name}\n"
            . "📧 <b>Email:</b> {$booking->customer_email}\n"
            . "🏛️ <b>Aquarium:</b> {$booking->aquarium->name}\n"
            . "📅 <b>Visit Date:</b> " . \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') . "\n"
            . "🎟️ <b>Tickets:</b> {$booking->tickets}\n"
            . "💰 <b>Total:</b> \${$booking->total_price}\n"
            . "🕐 <b>Booked At:</b> " . now()->format('d M Y, h:i A') . "\n\n"
            . "⚠️ <i>Waiting for payment verification</i>\n"
            . "🔗 Review: " . env('APP_URL', '') . "/admin/bookings";

        return $this->send($message);
    }

    public function bookingConfirmed(\App\Models\Booking $booking): bool
    {
        $message = "✅ <b>Booking Confirmed!</b>\n\n"
            . "👤 <b>Customer:</b> {$booking->customer_name}\n"
            . "🏛️ <b>Aquarium:</b> {$booking->aquarium->name}\n"
            . "📅 <b>Visit Date:</b> " . \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') . "\n"
            . "🎟️ <b>Tickets:</b> {$booking->tickets}\n"
            . "💰 <b>Total:</b> \${$booking->total_price}\n"
            . "✔️ <b>Payment:</b> Verified";

        return $this->send($message);
    }

    public function bookingCancelled(\App\Models\Booking $booking): bool
    {
        $message = "❌ <b>Booking Cancelled</b>\n\n"
            . "👤 <b>Customer:</b> {$booking->customer_name}\n"
            . "🏛️ <b>Aquarium:</b> {$booking->aquarium->name}\n"
            . "📅 <b>Visit Date:</b> " . \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') . "\n"
            . "💰 <b>Total:</b> \${$booking->total_price}";

        return $this->send($message);
    }
}
