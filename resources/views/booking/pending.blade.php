@extends('layout')

@section('content')
<div style="max-width:560px; margin:50px auto 80px;">

    <div style="background:rgba(30,41,59,0.9); border:1px solid rgba(14,165,233,0.3); border-radius:20px; padding:40px; text-align:center;">

        @if($booking->status == 'Confirmed')
            {{-- ── CONFIRMED ── --}}
            <div style="font-size:64px; margin-bottom:12px;">✅</div>
            <h3 style="color:#10b981; font-weight:700; margin-bottom:8px;">Payment Verified!</h3>
            <p style="color:#94a3b8; margin-bottom:24px;">Your booking has been confirmed by the admin.</p>

            <div style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3); border-radius:12px; padding:16px; margin-bottom:24px;">
                <div style="color:#94a3b8; font-size:13px;">Reference</div>
                <div style="color:#fff; font-size:20px; font-weight:700; font-family:monospace;">
                    AQ-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <a href="{{ route('booking.receipt', $booking->id) }}"
               style="display:inline-block; background:linear-gradient(135deg,#10b981,#059669); color:#fff; font-weight:700; padding:14px 32px; border-radius:50px; text-decoration:none; font-size:15px;">
                <i class="bi bi-receipt"></i> View Receipt
            </a>

        @elseif($booking->status == 'Cancelled')
            {{-- ── CANCELLED ── --}}
            <div style="font-size:64px; margin-bottom:12px;">❌</div>
            <h3 style="color:#ef4444; font-weight:700; margin-bottom:8px;">Booking Cancelled</h3>
            <p style="color:#94a3b8; margin-bottom:24px;">Your booking has been cancelled by the admin.</p>

            <a href="{{ route('home') }}"
               style="display:inline-block; background:linear-gradient(135deg,#0ea5e9,#06b6d4); color:#fff; font-weight:700; padding:14px 32px; border-radius:50px; text-decoration:none;">
                Back to Home
            </a>

        @else
            {{-- ── PENDING VERIFICATION ── --}}
            <div style="font-size:64px; margin-bottom:12px;" id="pendingIcon">⏳</div>
            <h3 style="color:#f59e0b; font-weight:700; margin-bottom:8px;">Awaiting Verification</h3>
            <p style="color:#94a3b8; margin-bottom:24px;">
                Your payment screenshot has been submitted.<br>
                Please wait while the admin verifies your payment.
            </p>

            {{-- Reference --}}
            <div style="background:rgba(14,165,233,0.1); border:1px solid rgba(14,165,233,0.3); border-radius:12px; padding:16px; margin-bottom:20px;">
                <div style="color:#94a3b8; font-size:13px; margin-bottom:4px;">Reference Number</div>
                <div style="color:#38bdf8; font-size:22px; font-weight:700; font-family:monospace;">
                    AQ-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            {{-- Booking summary --}}
            <div style="background:rgba(255,255,255,0.04); border-radius:12px; padding:16px; margin-bottom:24px; text-align:left;">
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid rgba(255,255,255,0.06); font-size:14px;">
                    <span style="color:#94a3b8;">Aquarium</span>
                    <span style="color:#fff; font-weight:600;">{{ $booking->aquarium->name }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid rgba(255,255,255,0.06); font-size:14px;">
                    <span style="color:#94a3b8;">Visit Date</span>
                    <span style="color:#fff; font-weight:600;">{{ \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid rgba(255,255,255,0.06); font-size:14px;">
                    <span style="color:#94a3b8;">Tickets</span>
                    <span style="color:#fff; font-weight:600;">{{ $booking->tickets }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:6px 0; font-size:14px;">
                    <span style="color:#94a3b8;">Amount Paid</span>
                    <span style="color:#38bdf8; font-weight:700;">${{ number_format($booking->total_price, 2) }}</span>
                </div>
            </div>

            {{-- Pulse indicator --}}
            <div style="display:flex; align-items:center; justify-content:center; gap:8px; color:#f59e0b; font-size:13px; margin-bottom:24px;">
                <span id="pulseIcon" style="display:inline-block; width:10px; height:10px; background:#f59e0b; border-radius:50; animation:pulse 1.5s infinite;"></span>
                Checking status automatically...
            </div>

            <a href="{{ route('home') }}"
               style="color:#94a3b8; font-size:13px; text-decoration:none;">
                ← Back to Home
            </a>
        @endif

    </div>
</div>

@if($booking->status == 'Pending')
<style>
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(1.4); }
}
#pulseIcon { border-radius: 50%; }
</style>
<script>
(function() {
    const bookingId = {{ $booking->id }};
    setInterval(function() {
        fetch('/booking/status/' + bookingId)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'Confirmed') {
                    window.location.href = '{{ route('booking.receipt', $booking->id) }}';
                } else if (data.status === 'Cancelled') {
                    window.location.reload();
                }
            }).catch(() => {});
    }, 3000);
})();
</script>
@endif

@endsection
