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
        return view('booking.index', compact('aquarium'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aquarium_id'    => 'required',
            'customer_name'  => 'required',
            'customer_email' => 'required|email',
            'visit_date'     => 'required|date',
            'tickets'        => 'required|integer|min:1'
        ]);

        $aquarium = Aquarium::findOrFail($request->aquarium_id);
        $total = $aquarium->price * $request->tickets;

        $booking = Booking::create([
            'aquarium_id'    => $aquarium->id,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'visit_date'     => $request->visit_date,
            'tickets'        => $request->tickets,
            'total_price'    => $total,
            'status'         => 'Pending'
        ]);

        // Redirect using correct route
        return redirect()->route('booking.pending', $booking->id);
    }

    public function pending($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking.pending', compact('booking'));
    }

    public function receipt($id)
    {
        $booking = Booking::with('aquarium')->findOrFail($id);
        return view('booking.receipt', compact('booking'));
    }
}