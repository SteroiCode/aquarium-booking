@extends('layout')

@section('content')
<div style="max-width:520px; margin:40px auto 80px;">

    {{-- Header --}}
    <div style="text-align:center; margin-bottom:24px;">
        <div style="font-size:48px; margin-bottom:8px;">📱</div>
        <h3 style="color:#fff; font-weight:700; margin:0;">Scan to Pay</h3>
        <p style="color:#94a3b8; margin:4px 0 0; font-size:14px;">
            Use ABA, Wing, ACLEDA or any Bakong-supported app
        </p>
    </div>

    {{-- QR Card --}}
    <div style="background:rgba(30,41,59,0.9); border:1px solid rgba(14,165,233,0.3); border-radius:20px; padding:28px; text-align:center; margin-bottom:20px;">

        {{-- Merchant info --}}
        <div style="margin-bottom:16px;">
            <div style="font-size:13px; color:#94a3b8; text-transform:uppercase; letter-spacing:1px;">Pay to</div>
            <div style="font-size:18px; font-weight:700; color:#fff; margin-top:4px;">{{ $khqrData['merchant_name'] }}</div>
        </div>

        {{-- QR Image --}}
        <div style="display:inline-block; background:#fff; padding:12px; border-radius:16px; margin-bottom:20px;">
            <img src="{{ $khqrData['qr_image_url'] }}"
                 alt="Bakong KHQR"
                 style="width:240px; height:240px; display:block;"
                 onerror="this.src='{{ asset(env('BAKONG_QR_CODE_PATH','images/qr.jpg')) }}'">
        </div>

        {{-- Amount --}}
        <div style="background:linear-gradient(135deg,rgba(14,165,233,0.2),rgba(6,182,212,0.2)); border:1px solid rgba(14,165,233,0.4); border-radius:12px; padding:16px; margin-bottom:16px;">
            <div style="font-size:32px; font-weight:800; color:#38bdf8;">
                {{ $khqrData['currency'] === 'KHR' ? number_format($khqrData['amount'], 0) . ' ៛' : '$' . number_format($khqrData['amount'], 2) }}
            </div>
            <div style="color:#94a3b8; font-size:13px; margin-top:4px;">
                {{ $booking->aquarium->name }} &bull; {{ $booking->tickets }} ticket(s) &bull; {{ \Carbon\Carbon::parse($booking->visit_date)->format('d M Y') }}
            </div>
        </div>

        {{-- Reference --}}
        <div style="font-size:12px; color:#94a3b8;">
            Reference: <span style="color:#cbd5e1; font-family:monospace;">{{ $khqrData['reference'] }}</span>
        </div>
    </div>

    {{-- Steps --}}
    <div style="background:rgba(14,165,233,0.08); border:1px solid rgba(14,165,233,0.2); border-radius:14px; padding:18px 20px; margin-bottom:20px;">
        <div style="font-size:13px; font-weight:700; color:#38bdf8; margin-bottom:10px; text-transform:uppercase; letter-spacing:0.5px;">
            How to pay
        </div>
        @foreach(['Open your banking app (ABA, Wing, ACLEDA, etc.)', 'Tap "Scan QR" or "Pay"', 'Scan the QR code above', 'Confirm the amount and complete payment', 'Take a screenshot and upload below'] as $i => $step)
        <div style="display:flex; align-items:flex-start; gap:10px; margin-bottom:8px; font-size:13px; color:#cbd5e1;">
            <span style="background:rgba(14,165,233,0.3); color:#38bdf8; border-radius:50%; width:20px; height:20px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:11px; flex-shrink:0;">{{ $i+1 }}</span>
            {{ $step }}
        </div>
        @endforeach
    </div>

    {{-- Upload Form --}}
    <div style="background:rgba(30,41,59,0.9); border:1px solid rgba(14,165,233,0.3); border-radius:20px; padding:28px;">
        <h5 style="color:#fff; font-weight:700; margin-bottom:20px;">
            <i class="bi bi-upload" style="color:#0ea5e9;"></i> Upload Payment Screenshot
        </h5>

        <form action="{{ route('payment.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Screenshot upload --}}
            <div style="margin-bottom:16px;">
                <input type="file" name="payment_proof" id="proofInput" accept="image/*"
                       style="display:none;" onchange="previewProof(this)" required>
                <label for="proofInput" style="
                    display:flex; align-items:center; justify-content:center; gap:10px;
                    padding:14px; border-radius:12px; cursor:pointer;
                    background:rgba(14,165,233,0.08);
                    border:2px dashed rgba(14,165,233,0.4);
                    color:#38bdf8; font-weight:600; font-size:14px;
                    transition:all 0.2s;
                "
                onmouseover="this.style.background='rgba(14,165,233,0.18)'"
                onmouseout="this.style.background='rgba(14,165,233,0.08)'">
                    <i class="bi bi-image" style="font-size:20px;"></i>
                    <span id="proofLabel">Choose Screenshot</span>
                </label>
                {{-- Preview --}}
                <div id="proofPreviewWrap" style="display:none; margin-top:10px; text-align:center;">
                    <img id="proofPreview" src="" style="max-width:100%; max-height:200px; border-radius:10px; border:2px solid rgba(14,165,233,0.4);">
                </div>
                @error('payment_proof')
                    <div style="color:#ef4444; font-size:13px; margin-top:6px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Transaction ID --}}
            <div style="margin-bottom:20px;">
                <label style="color:#e2e8f0; font-weight:600; font-size:13px; display:block; margin-bottom:6px;">
                    Transaction ID <span style="color:#94a3b8;">(optional)</span>
                </label>
                <input type="text" name="transaction_id"
                       placeholder="e.g. TXN123456"
                       style="width:100%; background:rgba(255,255,255,0.06); border:1px solid rgba(14,165,233,0.3); color:#fff; border-radius:10px; padding:10px 14px; font-size:14px; outline:none;">
            </div>

            <button type="submit" class="btn btn-primary w-100" style="border-radius:50px; padding:12px; font-size:15px; font-weight:700;">
                <i class="bi bi-check-circle"></i> Submit Payment Proof
            </button>
            <a href="{{ route('booking.history') }}" style="display:block; text-align:center; margin-top:12px; color:#94a3b8; font-size:13px; text-decoration:none;">
                Cancel &amp; pay later
            </a>
        </form>
    </div>

</div>

<script>
function previewProof(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('proofPreview').src = e.target.result;
            document.getElementById('proofPreviewWrap').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('proofLabel').textContent = input.files[0].name;
    }
}
</script>
@endsection
