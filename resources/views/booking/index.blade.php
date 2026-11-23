@extends('layout')

@section('content')
<div class="row justify-content-center" style="margin-top:20px; margin-bottom:80px;">
    <div class="col-lg-11">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; align-items:start;">

            {{-- ── LEFT: Booking Form ── --}}
            <div style="background:rgba(30,41,59,0.9); border:1px solid rgba(14,165,233,0.3); border-radius:20px; padding:32px;">

                {{-- Aquarium info --}}
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.08);">
                    @if($aquarium->image)
                        <img src="{{ asset('storage/'.$aquarium->image) }}" style="width:64px;height:64px;border-radius:12px;object-fit:cover;flex-shrink:0;">
                    @endif
                    <div>
                        <div style="font-size:18px;font-weight:700;color:#fff;">{{ $aquarium->name }}</div>
                        <div style="color:#94a3b8;font-size:13px;">{{ $aquarium->location }}</div>
                        <div style="color:#38bdf8;font-weight:700;margin-top:2px;">
                            {{ $khqrData['currency'] === 'KHR' ? number_format($aquarium->price,0).' ៛' : '$'.number_format($aquarium->price,2) }} / ticket
                        </div>
                    </div>
                </div>

                <h4 style="color:#fff;font-weight:700;margin-bottom:20px;">Booking Details</h4>

                <form method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data" id="bookingForm">
                    @csrf
                    <input type="hidden" name="aquarium_id" value="{{ $aquarium->id }}">
                    <input type="hidden" id="pricePerTicket" value="{{ $aquarium->price }}">

                    @foreach([
                        ['customer_name',  'text',   'Full Name',       'Enter your full name',       true],
                        ['customer_email', 'email',  'Email Address',   'your@email.com',             true],
                        ['visit_date',     'date',   'Visit Date',      '',                           true],
                    ] as [$name, $type, $label, $placeholder, $req])
                    <div style="margin-bottom:16px;">
                        <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:6px;">{{ $label }}</label>
                        <input type="{{ $type }}" name="{{ $name }}"
                               @if($placeholder) placeholder="{{ $placeholder }}" @endif
                               @if($type === 'date') min="{{ date('Y-m-d') }}" @endif
                               @if($name === 'customer_name') value="{{ auth()->user()->name }}" @endif
                               @if($name === 'customer_email') value="{{ auth()->user()->email }}" @endif
                               style="width:100%;background:rgba(255,255,255,0.07);border:1px solid rgba(14,165,233,0.35);color:#fff;border-radius:10px;padding:11px 14px;font-size:14px;outline:none;"
                               @if($req) required @endif>
                        @error($name)<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                    </div>
                    @endforeach

                    <div style="margin-bottom:16px;">
                        <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:6px;">Number of Tickets</label>
                        <input type="number" name="tickets" id="tickets" min="1" value="1"
                               style="width:100%;background:rgba(255,255,255,0.07);border:1px solid rgba(14,165,233,0.35);color:#fff;border-radius:10px;padding:11px 14px;font-size:14px;outline:none;"
                               required>
                    </div>

                    {{-- Total --}}
                    <div style="background:rgba(14,165,233,0.12);border:1px solid rgba(14,165,233,0.3);border-radius:10px;padding:14px 16px;margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;">
                        <span style="color:#cbd5e1;font-size:14px;">Total Amount</span>
                        <span id="totalDisplay" style="color:#38bdf8;font-size:22px;font-weight:800;">
                            {{ $khqrData['currency'] === 'KHR' ? number_format($aquarium->price,0).' ៛' : '$'.number_format($aquarium->price,2) }}
                        </span>
                    </div>

                    {{-- Payment proof upload --}}
                    <div style="margin-bottom:20px;">
                        <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:8px;">
                            Payment Screenshot <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="file" name="payment_proof" id="proofInput" accept="image/*"
                               style="display:none;" onchange="previewProof(this)" required>
                        <label for="proofInput" style="
                            display:flex;align-items:center;justify-content:center;gap:10px;
                            padding:13px;border-radius:12px;cursor:pointer;
                            background:rgba(14,165,233,0.08);
                            border:2px dashed rgba(14,165,233,0.4);
                            color:#38bdf8;font-weight:600;font-size:14px;
                        "
                        onmouseover="this.style.background='rgba(14,165,233,0.18)'"
                        onmouseout="this.style.background='rgba(14,165,233,0.08)'">
                            <i class="bi bi-image" style="font-size:18px;"></i>
                            <span id="proofLabel">Upload Payment Screenshot</span>
                        </label>
                        <div id="proofPreviewWrap" style="display:none;margin-top:10px;text-align:center;">
                            <img id="proofPreview" src="" style="max-width:100%;max-height:160px;border-radius:10px;border:2px solid rgba(14,165,233,0.4);">
                        </div>
                        @error('payment_proof')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:6px;">
                            Transaction ID <span style="color:#94a3b8;">(optional)</span>
                        </label>
                        <input type="text" name="transaction_id" placeholder="e.g. TXN123456"
                               style="width:100%;background:rgba(255,255,255,0.07);border:1px solid rgba(14,165,233,0.35);color:#fff;border-radius:10px;padding:11px 14px;font-size:14px;outline:none;">
                    </div>

                    <button type="submit" style="width:100%;background:linear-gradient(135deg,#0ea5e9,#06b6d4);border:none;color:#fff;font-weight:700;font-size:15px;padding:14px;border-radius:50px;cursor:pointer;">
                        <i class="bi bi-check-circle"></i> Confirm Booking & Submit Payment
                    </button>
                </form>
            </div>

            {{-- ── RIGHT: KHQR Panel ── --}}
            <div style="background:rgba(30,41,59,0.9); border:1px solid rgba(14,165,233,0.3); border-radius:20px; padding:32px; text-align:center; position:sticky; top:90px;">

                <div style="font-size:13px;color:#cbd5e1;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Pay to</div>
                <div style="font-size:17px;font-weight:700;color:#fff;margin-bottom:20px;">NEANG ROTHANA (ABA Bank)</div>

                {{-- QR Image - Static ABA PAY QR --}}
                <div style="display:inline-block;background:#fff;padding:12px;border-radius:16px;margin-bottom:20px;">
                    <img src="{{ asset('images/qr.jpg') }}" alt="ABA PAY QR"
                         style="width:220px;height:220px;object-fit:contain;display:block;">
                </div>

                {{-- Amount display --}}
                <div style="background:linear-gradient(135deg,rgba(14,165,233,0.2),rgba(6,182,212,0.2));border:1px solid rgba(14,165,233,0.4);border-radius:12px;padding:14px;margin-bottom:20px;">
                    <div id="qrAmount" style="font-size:28px;font-weight:800;color:#38bdf8;">
                        {{ $khqrData['currency'] === 'KHR' ? number_format($aquarium->price,0).' ៛' : '$'.number_format($aquarium->price,2) }}
                    </div>
                    <div style="color:#cbd5e1;font-size:12px;margin-top:2px;">Scan with ABA, Wing, ACLEDA or any Bakong app</div>
                </div>

                {{-- Steps --}}
                <div style="text-align:left;">
                    @foreach(['Open your banking app', 'Tap Scan QR / Pay', 'Scan the QR code above', 'Confirm & complete payment', 'Screenshot & upload on the left'] as $i => $step)
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;font-size:13px;color:#cbd5e1;">
                        <span style="background:rgba(14,165,233,0.3);color:#38bdf8;border-radius:50%;width:20px;height:20px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0;">{{ $i+1 }}</span>
                        {{ $step }}
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<script>
const pricePerTicket = parseFloat(document.getElementById('pricePerTicket').value);
const currency       = '{{ $khqrData['currency'] }}';
let qrTimer          = null;

function formatAmount(amount) {
    return currency === 'KHR'
        ? amount.toLocaleString('en-US', {maximumFractionDigits:0}) + ' ៛'
        : '$' + amount.toFixed(2);
}

function updateQR() {
    const tickets = parseInt(document.getElementById('tickets').value) || 1;
    const amount  = pricePerTicket * tickets;

    document.getElementById('totalDisplay').textContent = formatAmount(amount);
    document.getElementById('qrAmount').textContent     = formatAmount(amount);

    // Debounce QR generation
    clearTimeout(qrTimer);
    document.getElementById('qrImage').style.display   = 'none';
    document.getElementById('qrLoading').style.display = 'flex';
    document.getElementById('qrLoading').innerHTML     = '<div><div style="font-size:32px;margin-bottom:6px;">⏳</div><div style="font-size:13px;color:#94a3b8;">Generating QR...</div></div>';

    qrTimer = setTimeout(() => {
        fetch(`/booking/generate-qr?amount=${amount}&ref=BOOKING`)
            .then(r => r.json())
            .then(data => {
                if (data.qr_url) {
                    const img = document.getElementById('qrImage');
                    img.onload = () => {
                        img.style.display = 'block';
                        document.getElementById('qrLoading').style.display = 'none';
                    };
                    img.src = data.qr_url;
                } else {
                    const msg = data.error ? `Error: ${data.error}` : 'QR generation failed — check BAKONG_ACCOUNT_ID in .env';
                    document.getElementById('qrLoading').innerHTML = `<div style="font-size:12px;color:#ef4444;padding:10px;">${msg}</div>`;
                }
            })
            .catch(err => {
                document.getElementById('qrLoading').innerHTML = `<div style="font-size:12px;color:#ef4444;padding:10px;">Network error: ${err.message}</div>`;
            });
    }, 600);
}

document.getElementById('tickets').addEventListener('input', updateQR);

// Generate on page load
updateQR();

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
