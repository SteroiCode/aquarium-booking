@extends('layout')

@section('content')

<div class="container mt-5 mb-5">
    <h2 class="fw-bold mb-4">📋 My Booking History</h2>

    @if($bookings->count() > 0)
        <div class="row g-4">
            @foreach($bookings as $booking)
                <div class="col-md-6">
                    <div class="card shadow h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>AQ-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                            
                            <div>
                                @if($booking->status == 'Confirmed')
                                    <span class="badge bg-success">✅ Confirmed</span>
                                @elseif($booking->status == 'Pending')
                                    <span class="badge bg-warning text-dark">⏳ Pending</span>
                                @else
                                    <span class="badge bg-danger">❌ Cancelled</span>
                                @endif
                                
                                @if($booking->payment_status == 'verified')
                                    <span class="badge bg-success">💳 Paid</span>
                                @elseif($booking->payment_status == 'pending_verification')
                                    <span class="badge bg-info">⏳ Verifying Payment</span>
                                @elseif($booking->payment_status == 'rejected')
                                    <span class="badge bg-danger">❌ Payment Rejected</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $booking->aquarium->name ?? 'N/A' }}</h5>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    <strong>📍 Location:</strong> {{ $booking->aquarium->location ?? 'N/A' }}
                                </small>
                                <small class="text-muted d-block">
                                    <strong>📅 Visit Date:</strong> {{ \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') }}
                                </small>
                                <small class="text-muted d-block">
                                    <strong>🎫 Tickets:</strong> {{ $booking->tickets }}
                                </small>
                                <small class="text-muted d-block">
                                    <strong>💰 Total:</strong> ${{ number_format($booking->total_price, 2) }}
                                </small>
                                <small class="text-muted d-block">
                                    <strong>📧 Email:</strong> {{ $booking->customer_email }}
                                </small>
                                <small class="text-muted d-block">
                                    <strong>🕒 Booked:</strong> {{ $booking->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <div class="d-flex gap-2">
                                @if($booking->status == 'Confirmed')
                                    <a href="{{ route('booking.receipt', $booking->id) }}" 
                                       class="btn btn-success btn-sm">
                                        View Receipt
                                    </a>
                                @elseif($booking->status == 'Pending')
                                    @if($booking->payment_status == 'pending_verification')
                                        <a href="{{ route('booking.receipt', $booking->id) }}" 
                                           class="btn btn-info btn-sm">
                                            View Payment Status
                                        </a>
                                    @elseif($booking->payment_status == 'rejected')
                                        <a href="{{ route('payment.show', $booking->id) }}" 
                                           class="btn btn-warning btn-sm">
                                            Retry Payment
                                        </a>
                                    @else
                                        <a href="{{ route('payment.show', $booking->id) }}" 
                                           class="btn btn-primary btn-sm">
                                            Pay Now
                                        </a>
                                    @endif
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        Cancelled
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            <h4>No bookings yet</h4>
            <p>You haven't made any bookings. Start exploring our aquariums!</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                Browse Aquariums
            </a>
        </div>
    @endif
</div>

@endsection
