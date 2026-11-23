@extends('admin.layout')

@section('content')
<style>
@media print {
    .sidebar, .main-content > *:not(.pos-receipt-wrap), .no-print { display:none !important; }
    .main-content { margin-left:0 !important; padding:0 !important; }
    .pos-receipt-wrap { max-width:100% !important; }
    @page { size: 80mm auto; margin: 4mm; }
}
</style>

<div class="pos-receipt-wrap" style="max-width:360px;margin:0 auto;">

    <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,0.4);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#0ea5e9,#06b6d4);padding:20px;text-align:center;">
            <div style="font-size:10px;color:rgba(255,255,255,0.95);letter-spacing:2px;text-transform:uppercase;">AquaDiveDeep</div>
            <div style="font-size:18px;font-weight:800;color:#fff;margin-top:2px;">Walk-in Receipt</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.95);margin-top:4px;">{{ now()->format('d M Y, h:i A') }}</div>
        </div>

        {{-- Tear line --}}
        <div style="display:flex;align-items:center;background:#fff;">
            <div style="width:16px;height:16px;background:#0f172a;border-radius:50%;margin-left:-8px;flex-shrink:0;"></div>
            <div style="flex:1;border-top:2px dashed #cbd5e1;"></div>
            <div style="width:16px;height:16px;background:#0f172a;border-radius:50%;margin-right:-8px;flex-shrink:0;"></div>
        </div>

        {{-- Body --}}
        <div style="padding:16px 20px;background:#fff;">

            <div style="text-align:center;margin-bottom:14px;">
                <div style="font-size:16px;font-weight:800;color:#0f172a;">{{ $booking->aquarium->name }}</div>
                <div style="font-size:11px;color:#64748b;">{{ $booking->aquarium->location ?? '' }}</div>
            </div>

            @foreach([
                ['Customer',   $booking->customer_name],
                ['Visit Date', \Carbon\Carbon::parse($booking->visit_date)->format('d M Y')],
                ['Tickets',    $booking->tickets . ' pax'],
                ['Payment',    $booking->payment_method],
                ['Ref No.',    'AQ-'.str_pad($booking->id,6,'0',STR_PAD_LEFT)],
            ] as [$label, $value])
            <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed #e2e8f0;font-size:13px;">
                <span style="color:#94a3b8;font-weight:600;">{{ $label }}</span>
                <span style="color:#0f172a;font-weight:700;">{{ $value }}</span>
            </div>
            @endforeach

            @if(session('subtotal') && session('discount_amt') > 0)
            <div style="display:flex;justify-content:space-between;padding:8px 0 4px;font-size:13px;">
                <span style="color:#94a3b8;font-weight:600;">Subtotal</span>
                <span style="color:#0f172a;font-weight:700;">${{ number_format(session('subtotal'),2) }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:4px 0;font-size:13px;">
                <span style="color:#f59e0b;font-weight:600;">Discount ({{ session('discount_label') }})</span>
                <span style="color:#f59e0b;font-weight:700;">-${{ number_format(session('discount_amt'),2) }}</span>
            </div>
            @endif

            <div style="display:flex;justify-content:space-between;padding:8px 0 4px;font-size:16px;border-top:2px solid #e2e8f0;margin-top:4px;">
                <span style="color:#0f172a;font-weight:700;">TOTAL</span>
                <span style="color:#0ea5e9;font-weight:800;">${{ number_format($booking->total_price,2) }}</span>
            </div>

            @if(session('cash_received') && $booking->payment_method === 'Cash')
            <div style="display:flex;justify-content:space-between;padding:4px 0;font-size:13px;">
                <span style="color:#94a3b8;font-weight:600;">Cash Received</span>
                <span style="color:#0f172a;font-weight:700;">${{ number_format(session('cash_received'),2) }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:4px 0 8px;font-size:15px;">
                <span style="color:#0f172a;font-weight:800;">CHANGE</span>
                <span style="color:#10b981;font-weight:800;">${{ number_format(session('change'),2) }}</span>
            </div>
            @endif

            {{-- Tear line --}}
            <div style="display:flex;align-items:center;margin:10px -20px;">
                <div style="width:16px;height:16px;background:#0f172a;border-radius:50%;margin-left:-8px;flex-shrink:0;"></div>
                <div style="flex:1;border-top:2px dashed #cbd5e1;"></div>
                <div style="width:16px;height:16px;background:#0f172a;border-radius:50%;margin-right:-8px;flex-shrink:0;"></div>
            </div>

            {{-- QR --}}
            <div style="text-align:center;padding-top:10px;">
                <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Scan at Entrance</div>
                <div style="display:inline-block;background:#fff;padding:6px;border-radius:10px;border:2px solid #e2e8f0;">
                    @php
                        $qrData = 'AQ-'.str_pad($booking->id,6,'0',STR_PAD_LEFT)
                            .'|'.$booking->customer_name
                            .'|'.$booking->aquarium->name
                            .'|'.\Carbon\Carbon::parse($booking->visit_date)->format('d-M-Y')
                            .'|'.$booking->tickets.'tix';
                    @endphp
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($qrData) }}"
                         style="width:120px;height:120px;display:block;">
                </div>
                <div style="font-size:13px;font-weight:800;color:#0ea5e9;font-family:monospace;letter-spacing:2px;margin-top:8px;">
                    AQ-{{ str_pad($booking->id,6,'0',STR_PAD_LEFT) }}
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background:#f8fafc;padding:10px;text-align:center;border-top:1px solid #e2e8f0;">
            <div style="font-size:10px;color:#94a3b8;">Thank you for visiting AquaDiveDeep!</div>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="no-print" style="display:flex;gap:10px;margin-top:14px;justify-content:center;">
        <button onclick="window.print()"
                style="background:linear-gradient(135deg,#0ea5e9,#06b6d4);color:#fff;border:none;padding:10px 24px;border-radius:50px;font-weight:700;cursor:pointer;font-size:13px;">
            <i class="bi bi-printer"></i> Print Receipt
        </button>
        <a href="{{ route('admin.pos.index') }}"
           style="background:rgba(255,255,255,0.07);color:#94a3b8;border:1px solid rgba(255,255,255,0.1);padding:10px 24px;border-radius:50px;font-weight:600;text-decoration:none;font-size:13px;">
            + New Sale
        </a>
        <a href="{{ route('admin.bookings.index') }}"
           style="background:rgba(255,255,255,0.07);color:#94a3b8;border:1px solid rgba(255,255,255,0.1);padding:10px 24px;border-radius:50px;font-weight:600;text-decoration:none;font-size:13px;">
            Bookings
        </a>
    </div>
</div>
@endsection
