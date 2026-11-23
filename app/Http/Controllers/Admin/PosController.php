<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aquarium;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $aquariums = Aquarium::all();
        return view('admin.pos.index', compact('aquariums'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'aquarium_id'    => 'required|exists:aquariums,id',
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'tickets'        => 'required|integer|min:1',
            'visit_date'     => 'required|date',
            'payment_method' => 'required|in:Cash,Bakong KHQR,Card',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_type'  => 'nullable|in:percent,fixed',
        ]);

        $aquarium      = Aquarium::findOrFail($request->aquarium_id);
        $subtotal      = $aquarium->price * $request->tickets;
        $discountVal   = (float) ($request->discount_value ?? 0);
        $discountType  = $request->discount_type ?? 'percent';

        $discountAmt = $discountType === 'percent'
            ? $subtotal * min($discountVal, 100) / 100
            : min($discountVal, $subtotal);

        $total = max(0, $subtotal - $discountAmt);

        $booking = Booking::create([
            'user_id'        => null,
            'aquarium_id'    => $aquarium->id,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email ?: 'walkin@aquadivedeep.com',
            'visit_date'     => $request->visit_date,
            'tickets'        => $request->tickets,
            'total_price'    => $total,
            'status'         => 'Confirmed',
            'payment_method' => $request->payment_method,
            'payment_status' => 'verified',
            'transaction_id' => 'POS-' . strtoupper(Str::random(8)),
            'paid_at'        => now(),
        ]);

        $change = max(0, (float)$request->cash_received - $total);

        return redirect()->route('admin.pos.receipt', $booking->id)
            ->with('success', 'Booking confirmed! $' . number_format($total, 2) . ' received.')
            ->with('cash_received', $request->cash_received)
            ->with('change', $change)
            ->with('discount_amt', round($discountAmt, 2))
            ->with('subtotal', round($subtotal, 2))
            ->with('discount_label', $discountType === 'percent' ? $discountVal.'%' : '$'.number_format($discountAmt,2));
    }

    public function receipt($id)
    {
        $booking = Booking::with('aquarium')->findOrFail($id);
        return view('admin.pos.receipt', compact('booking'));
    }
}
