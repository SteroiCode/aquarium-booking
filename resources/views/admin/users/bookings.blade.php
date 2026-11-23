@extends('admin.layout')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to Users
    </a>
    
    <div class="card mb-4">
        <div class="card-body">
            <h4><i class="bi bi-person"></i> {{ $user->name }}</h4>
            <p class="text-muted mb-0">{{ $user->email }}</p>
            <small class="text-muted">Member since {{ $user->created_at->format('M d, Y') }}</small>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-ticket-perforated"></i> Booking History ({{ $bookings->total() }})</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead style="background: linear-gradient(135deg,#0ea5e9,#06b6d4);">
                <tr>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Reference</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Aquarium</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Visit Date</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Tickets</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Total</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Payment</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Status</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Booked On</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td><strong>AQ-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $booking->aquarium->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->visit_date)->format('M d, Y') }}</td>
                        <td>{{ $booking->tickets }}</td>
                        <td>${{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            @if($booking->payment_status == 'verified')
                                <span class="badge bg-success">Verified</span>
                            @elseif($booking->payment_status == 'pending_verification')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-secondary">Not Paid</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge 
                                @if($booking->status == 'Confirmed') bg-success
                                @elseif($booking->status == 'Pending') bg-warning
                                @else bg-danger
                                @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td>{{ $booking->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No bookings found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $bookings->links() }}
</div>
@endsection
