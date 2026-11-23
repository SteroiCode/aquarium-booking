@extends('layout')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;800&display=swap');

.pass-wrap { font-family:'Space Grotesk',sans-serif; max-width:340px; margin:0 auto; }

.pass {
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 0 0 1px rgba(99,102,241,0.4), 0 24px 60px rgba(0,0,0,0.6);
}

/* ── Header strip ── */
.pass-header {
    background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 50%,#0ea5e9 100%);
    padding:18px 20px 14px;
    position:relative;
    overflow:hidden;
}
.pass-header::after {
    content:'🐠';
    position:absolute;right:16px;top:50%;transform:translateY(-50%);
    font-size:40px;opacity:0.18;
}

/* ── Body ── */
.pass-body {
    background:#0f172a;
    padding:16px 20px;
}

/* ── Row ── */
.pass-row {
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    margin-bottom:12px;
}
.pass-field { flex:1; }
.pass-field + .pass-field { margin-left:12px; }
.pass-field-label {
    font-size:9px;font-weight:700;
    color:#94a3b8;text-transform:uppercase;letter-spacing:1px;
    margin-bottom:3px;
}
.pass-field-value {
    font-size:13px;font-weight:700;color:#e2e8f0;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
.pass-field-value.accent { color:#a78bfa; }
.pass-field-value.green  { color:#34d399; }

/* ── Divider ── */
.pass-divider {
    display:flex;align-items:center;margin:14px -20px;
}
.pass-divider-circle {
    width:18px;height:18px;
    background:#0f172a;
    border:2px solid rgba(99,102,241,0.3);
    border-radius:50%;flex-shrink:0;
}
.pass-divider-line {
    flex:1;
    border-top:2px dashed rgba(99,102,241,0.25);
}

/* ── QR section ── */
.pass-qr {
    background:#1e293b;
    border-radius:14px;
    padding:14px;
    display:flex;
    align-items:center;
    gap:14px;
    margin-top:4px;
}

/* ── Footer ── */
.pass-footer {
    background:#080f1e;
    padding:10px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

@media print {
    nav,.navbar,footer,.no-print,
    .particles,.waves,.fish,.bubble,.orb,.particle{display:none!important;}
    body,html{background:#fff!important;}
    body::before,body::after{display:none!important;}
    .pass{box-shadow:none!important;}
    @page{size:80mm auto;margin:4mm;}
}
</style>

<div style="display:flex;justify-content:center;padding:44px 16px 80px;">
<div class="pass-wrap">

@if($booking->status == 'Confirmed')
@php
    $ref    = 'AQ-'.str_pad($booking->id,6,'0',STR_PAD_LEFT);
    $qrData = $ref.'|'.$booking->customer_name.'|'.$booking->aquarium->name
              .'|'.\Carbon\Carbon::parse($booking->visit_date)->format('d-M-Y')
              .'|'.$booking->tickets.'tix';
@endphp

<div class="pass">

    {{-- Header --}}
    <div class="pass-header">
        <div style="font-size:9px;font-weight:700;color:rgba(255,255,255,0.95);letter-spacing:2px;text-transform:uppercase;">AquaDiveDeep · Admission</div>
        <div style="font-size:19px;font-weight:800;color:#fff;margin-top:3px;line-height:1.2;">{{ $booking->aquarium->name }}</div>
        <div style="margin-top:6px;display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.15);border-radius:20px;padding:3px 10px;">
            <span style="width:6px;height:6px;background:#34d399;border-radius:50%;display:inline-block;"></span>
            <span style="font-size:10px;font-weight:700;color:#fff;">VERIFIED &amp; CONFIRMED</span>
        </div>
    </div>

    {{-- Body --}}
    <div class="pass-body">

        {{-- Row 1 --}}
        <div class="pass-row">
            <div class="pass-field">
                <div class="pass-field-label">Passenger</div>
                <div class="pass-field-value">{{ $booking->customer_name }}</div>
            </div>
            <div class="pass-field" style="text-align:right;">
                <div class="pass-field-label">Ref No.</div>
                <div class="pass-field-value accent" style="font-family:monospace;font-size:12px;">{{ $ref }}</div>
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="pass-row">
            <div class="pass-field">
                <div class="pass-field-label">Visit Date</div>
                <div class="pass-field-value">{{ \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') }}</div>
            </div>
            <div class="pass-field">
                <div class="pass-field-label">Tickets</div>
                <div class="pass-field-value">{{ $booking->tickets }} pax</div>
            </div>
            <div class="pass-field" style="text-align:right;">
                <div class="pass-field-label">Total</div>
                <div class="pass-field-value green">${{ number_format($booking->total_price,2) }}</div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="pass-divider">
            <div class="pass-divider-circle" style="margin-left:-29px;"></div>
            <div class="pass-divider-line"></div>
            <div class="pass-divider-circle" style="margin-right:-29px;"></div>
        </div>

        {{-- QR + scan label --}}
        <div class="pass-qr">
            <div style="background:#fff;padding:6px;border-radius:10px;flex-shrink:0;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data={{ urlencode($qrData) }}"
                     style="width:90px;height:90px;display:block;">
            </div>
            <div>
                <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">Scan at Entrance</div>
                <div style="font-size:11px;color:#cbd5e1;line-height:1.5;">Show this QR code to staff when you arrive at the aquarium.</div>
                @if($booking->paid_at)
                <div style="font-size:10px;color:#94a3b8;margin-top:6px;">Paid {{ \Carbon\Carbon::parse($booking->paid_at)->format('d M Y') }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="pass-footer">
        <div style="font-size:9px;color:#94a3b8;font-weight:600;letter-spacing:1px;text-transform:uppercase;">AquaDiveDeep © {{ date('Y') }}</div>
        <div style="font-size:9px;color:#94a3b8;">{{ $booking->payment_method ?? 'Bakong KHQR' }}</div>
    </div>
</div>

@else
<div style="background:rgba(30,41,59,0.9);border:1px solid rgba(99,102,241,0.3);border-radius:20px;padding:36px 24px;text-align:center;">
    @if($booking->status == 'Cancelled')
        <div style="font-size:44px;margin-bottom:10px;">❌</div>
        <div style="font-size:16px;font-weight:700;color:#ef4444;">Booking Cancelled</div>
    @else
        <div style="font-size:44px;margin-bottom:10px;">⏳</div>
        <div style="font-size:16px;font-weight:700;color:#f59e0b;">Awaiting Confirmation</div>
        <div style="color:#94a3b8;font-size:12px;margin-top:6px;">Admin is reviewing your payment.</div>
    @endif
    <div style="margin-top:16px;font-size:15px;font-weight:800;color:#a78bfa;font-family:monospace;letter-spacing:2px;">
        AQ-{{ str_pad($booking->id,6,'0',STR_PAD_LEFT) }}
    </div>
</div>
@endif

{{-- Buttons --}}
<div class="no-print" style="display:flex;gap:8px;margin-top:14px;justify-content:center;">
    @if($booking->status == 'Confirmed')
    <button onclick="window.print()"
            style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border:none;padding:9px 22px;border-radius:50px;font-weight:700;cursor:pointer;font-size:13px;box-shadow:0 4px 14px rgba(99,102,241,0.4);">
        <i class="bi bi-printer"></i> Print
    </button>
    @endif
    <a href="{{ route('booking.history') }}"
       style="background:rgba(255,255,255,0.06);color:#94a3b8;border:1px solid rgba(255,255,255,0.1);padding:9px 22px;border-radius:50px;font-weight:600;text-decoration:none;font-size:13px;">
        ← Bookings
    </a>
</div>

</div>
</div>
@endsection
