@extends('admin.layout')

@section('content')
<div style="max-width:720px;margin:0 auto;">

    <div style="margin-bottom:24px;">
        <h4 style="color:#fff;font-weight:700;margin:0;"><i class="bi bi-cart3" style="color:#0ea5e9;"></i> Walk-in POS</h4>
        <p style="color:#94a3b8;font-size:13px;margin:4px 0 0;">Create instant confirmed booking for walk-in customers</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i>
            <ul class="mb-0 mt-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.pos.checkout') }}" method="POST" id="posForm">
        @csrf
        {{-- Hidden field for cash received (filled by modal) --}}
        <input type="hidden" name="cash_received" id="cashReceivedInput" value="0">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

            {{-- LEFT --}}
            <div style="display:flex;flex-direction:column;gap:16px;">

                <div style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;padding:20px;">
                    <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Select Aquarium</div>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        @foreach($aquariums as $aq)
                        <label style="display:flex;align-items:center;gap:12px;background:rgba(255,255,255,0.04);border:2px solid transparent;border-radius:10px;padding:10px 14px;cursor:pointer;transition:all 0.2s;"
                               class="aq-option" data-price="{{ $aq->price }}">
                            <input type="radio" name="aquarium_id" value="{{ $aq->id }}" style="display:none;" required>
                            @if($aq->image)
                                <img src="{{ asset('storage/'.$aq->image) }}" style="width:40px;height:40px;border-radius:8px;object-fit:cover;flex-shrink:0;">
                            @else
                                <div style="width:40px;height:40px;border-radius:8px;background:rgba(14,165,233,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-building" style="color:#0ea5e9;"></i></div>
                            @endif
                            <div style="flex:1;">
                                <div style="font-size:14px;font-weight:700;color:#fff;">{{ $aq->name }}</div>
                                <div style="font-size:11px;color:#94a3b8;">{{ $aq->location }}</div>
                            </div>
                            <div style="font-size:14px;font-weight:800;color:#38bdf8;">${{ number_format($aq->price,2) }}</div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;padding:20px;">
                    <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Booking Details</div>
                    <div style="margin-bottom:14px;">
                        <label class="form-label">Visit Date *</label>
                        <input type="date" name="visit_date" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <label class="form-label">Tickets *</label>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <button type="button" onclick="changeTickets(-1)"
                                style="width:40px;height:40px;border-radius:50%;background:rgba(14,165,233,0.15);border:1px solid rgba(14,165,233,0.4);color:#38bdf8;font-size:22px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;">−</button>
                        <input type="number" name="tickets" id="ticketCount" value="1" min="1" max="50"
                               style="width:70px;text-align:center;background:rgba(255,255,255,0.07);border:1px solid rgba(14,165,233,0.35);color:#fff;border-radius:10px;padding:10px;font-size:20px;font-weight:700;"
                               oninput="updateTotal()" required>
                        <button type="button" onclick="changeTickets(1)"
                                style="width:40px;height:40px;border-radius:50%;background:rgba(14,165,233,0.15);border:1px solid rgba(14,165,233,0.4);color:#38bdf8;font-size:22px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;">+</button>
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div style="display:flex;flex-direction:column;gap:16px;">

                <div style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;padding:20px;">
                    <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Customer Info</div>
                    <div style="margin-bottom:12px;">
                        <label class="form-label">Name *</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Walk-in customer name" required>
                    </div>
                    <div>
                        <label class="form-label">Email <span style="color:#64748b;font-size:11px;">(optional)</span></label>
                        <input type="email" name="customer_email" class="form-control" placeholder="customer@email.com">
                    </div>
                </div>

                <div style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;padding:20px;">
                    <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Payment Method</div>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        @foreach([['Cash','bi-cash-coin','#10b981'],['Bakong KHQR','bi-qr-code','#0ea5e9'],['Card','bi-credit-card','#8b5cf6']] as [$method,$icon,$color])
                        @php $pid = 'pay_'.Str::slug($method); @endphp
                        <label for="{{ $pid }}" class="pay-option"
                               style="display:flex;align-items:center;gap:12px;background:rgba(255,255,255,0.04);border:2px solid transparent;border-radius:10px;padding:12px 14px;cursor:pointer;transition:all 0.2s;">
                            <input type="radio" name="payment_method" id="{{ $pid }}" value="{{ $method }}" style="display:none;" {{ $method==='Cash' ? 'checked' : '' }}>
                            <i class="bi {{ $icon }}" style="font-size:20px;color:{{ $color }};"></i>
                            <span style="font-size:14px;font-weight:600;color:#fff;">{{ $method }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div style="background:linear-gradient(135deg,rgba(14,165,233,0.15),rgba(6,182,212,0.1));border:1px solid rgba(14,165,233,0.4);border-radius:16px;padding:20px;">

                    {{-- Discount row --}}
                    <div style="margin-bottom:14px;">
                        <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Discount</div>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <input type="number" name="discount_value" id="discountValue" value="0" min="0"
                                   oninput="updateTotal()"
                                   style="width:90px;background:rgba(255,255,255,0.07);border:1px solid rgba(14,165,233,0.35);color:#fff;border-radius:10px;padding:8px 10px;font-size:15px;font-weight:700;text-align:center;">
                            <div style="display:flex;gap:4px;">
                                <button type="button" id="btnPct" onclick="setDiscountType('percent')"
                                        style="padding:8px 14px;border-radius:8px;border:1px solid rgba(14,165,233,0.4);background:rgba(14,165,233,0.2);color:#38bdf8;font-weight:700;font-size:13px;cursor:pointer;">%</button>
                                <button type="button" id="btnFixed" onclick="setDiscountType('fixed')"
                                        style="padding:8px 14px;border-radius:8px;border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.05);color:#94a3b8;font-weight:700;font-size:13px;cursor:pointer;">$</button>
                            </div>
                            <input type="hidden" name="discount_type" id="discountType" value="percent">
                        </div>
                        {{-- Quick discount presets --}}
                        <div style="display:flex;gap:6px;margin-top:8px;flex-wrap:wrap;">
                            @foreach([0,5,10,15,20,50] as $pct)
                            <button type="button" onclick="applyPreset({{ $pct }})"
                                    style="padding:4px 10px;border-radius:6px;border:1px solid rgba(14,165,233,0.25);background:rgba(14,165,233,0.08);color:#94a3b8;font-size:12px;font-weight:600;cursor:pointer;">
                                {{ $pct }}%
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price breakdown --}}
                    <div style="border-top:1px dashed rgba(255,255,255,0.1);padding-top:12px;margin-bottom:14px;">
                        <div style="display:flex;justify-content:space-between;font-size:13px;color:#94a3b8;margin-bottom:4px;">
                            <span>Subtotal</span>
                            <span id="subtotalDisplay">$0.00</span>
                        </div>
                        <div id="discountRow" style="display:none;justify-content:space-between;font-size:13px;color:#f59e0b;margin-bottom:4px;">
                            <span id="discountLabel">Discount</span>
                            <span id="discountDisplay">-$0.00</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:6px;">
                            <span style="color:#94a3b8;font-size:14px;">Total</span>
                            <span id="totalDisplay" style="font-size:30px;font-weight:800;color:#38bdf8;">$0.00</span>
                        </div>
                    </div>

                    <button type="button" id="confirmBtn" onclick="handleConfirm()"
                            style="width:100%;background:linear-gradient(135deg,#0ea5e9,#06b6d4);color:#fff;border:none;padding:14px;border-radius:12px;font-size:16px;font-weight:800;cursor:pointer;box-shadow:0 4px 20px rgba(14,165,233,0.4);">
                        <i class="bi bi-check-circle"></i> Confirm & Pay
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ── CASH PAYMENT MODAL ── --}}
<div class="modal fade" id="cashModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
        <div class="modal-content" style="background:#1e293b;border:1px solid rgba(16,185,129,0.4);border-radius:20px;overflow:hidden;">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#065f46,#047857);padding:20px 24px;">
            <div style="font-size:11px;color:rgba(255,255,255,0.95);letter-spacing:2px;text-transform:uppercase;">Cash Payment</div>
                <div style="font-size:22px;font-weight:800;color:#fff;margin-top:4px;">
                    Amount Due: <span id="modalTotal" style="color:#6ee7b7;">$0.00</span>
                </div>
            </div>

            <div style="padding:24px;">

                {{-- Quick cash buttons --}}
                <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px;">Quick Amount</div>
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:20px;" id="quickBtns"></div>

                {{-- Cash received input --}}
                <div style="margin-bottom:16px;">
                    <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:6px;">Cash Received ($)</label>
                    <input type="number" id="cashInput" step="0.01" min="0" placeholder="0.00"
                           oninput="calcChange()"
                           style="width:100%;background:rgba(255,255,255,0.08);border:2px solid rgba(16,185,129,0.4);color:#fff;border-radius:12px;padding:14px 16px;font-size:24px;font-weight:800;text-align:center;outline:none;">
                </div>

                {{-- Change display --}}
                <div style="background:rgba(255,255,255,0.05);border-radius:12px;padding:16px;text-align:center;margin-bottom:20px;">
                    <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Change to Return</div>
                    <div id="changeDisplay" style="font-size:32px;font-weight:800;color:#34d399;">$0.00</div>
                    <div id="changeNote" style="font-size:12px;color:#94a3b8;margin-top:4px;"></div>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeCashModal()"
                            style="flex:1;background:rgba(255,255,255,0.07);color:#94a3b8;border:1px solid rgba(255,255,255,0.1);padding:12px;border-radius:10px;font-weight:600;cursor:pointer;font-size:14px;">
                        Cancel
                    </button>
                    <button type="button" id="cashConfirmBtn" onclick="submitCash()" disabled
                            style="flex:2;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;padding:12px;border-radius:10px;font-weight:800;cursor:pointer;font-size:14px;opacity:0.5;">
                        <i class="bi bi-check-circle"></i> Confirm Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.aq-option.selected { border-color:#0ea5e9 !important; background:rgba(14,165,233,0.1) !important; }
.pay-option.selected { border-color:#0ea5e9 !important; background:rgba(14,165,233,0.1) !important; }
.quick-btn {
    background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);
    color:#6ee7b7;border-radius:8px;padding:8px 14px;font-weight:700;font-size:13px;cursor:pointer;
    transition:all 0.15s;
}
.quick-btn:hover { background:rgba(16,185,129,0.3); }
</style>

<script>
let selectedPrice  = 0;
let totalAmount    = 0;
let subtotal       = 0;
let discountType   = 'percent';
let cashModal      = null;

document.addEventListener('DOMContentLoaded', () => {
    cashModal = new bootstrap.Modal(document.getElementById('cashModal'));

    document.querySelectorAll('.aq-option').forEach(label => {
        label.addEventListener('click', function() {
            document.querySelectorAll('.aq-option').forEach(l => l.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input[type=radio]').checked = true;
            selectedPrice = parseFloat(this.dataset.price);
            updateTotal();
        });
    });

    document.querySelectorAll('.pay-option').forEach(label => {
        label.addEventListener('click', function() {
            document.querySelectorAll('.pay-option').forEach(l => l.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input[type=radio]').checked = true;
        });
        if (label.querySelector('input[type=radio]').checked) label.classList.add('selected');
    });
});

function setDiscountType(type) {
    discountType = type;
    document.getElementById('discountType').value = type;
    document.getElementById('btnPct').style.background   = type === 'percent' ? 'rgba(14,165,233,0.2)' : 'rgba(255,255,255,0.05)';
    document.getElementById('btnPct').style.color        = type === 'percent' ? '#38bdf8' : '#94a3b8';
    document.getElementById('btnPct').style.borderColor  = type === 'percent' ? 'rgba(14,165,233,0.4)' : 'rgba(255,255,255,0.1)';
    document.getElementById('btnFixed').style.background = type === 'fixed'   ? 'rgba(14,165,233,0.2)' : 'rgba(255,255,255,0.05)';
    document.getElementById('btnFixed').style.color      = type === 'fixed'   ? '#38bdf8' : '#94a3b8';
    document.getElementById('btnFixed').style.borderColor= type === 'fixed'   ? 'rgba(14,165,233,0.4)' : 'rgba(255,255,255,0.1)';
    updateTotal();
}

function applyPreset(pct) {
    setDiscountType('percent');
    document.getElementById('discountValue').value = pct;
    updateTotal();
}

function changeTickets(delta) {
    const input = document.getElementById('ticketCount');
    input.value = Math.max(1, parseInt(input.value || 1) + delta);
    updateTotal();
}

function updateTotal() {
    const tickets  = parseInt(document.getElementById('ticketCount').value) || 1;
    subtotal       = selectedPrice * tickets;
    const dVal     = parseFloat(document.getElementById('discountValue').value) || 0;
    let discountAmt = 0;

    if (discountType === 'percent') {
        discountAmt = subtotal * Math.min(dVal, 100) / 100;
    } else {
        discountAmt = Math.min(dVal, subtotal);
    }

    totalAmount = Math.max(0, subtotal - discountAmt);

    document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('totalDisplay').textContent    = '$' + totalAmount.toFixed(2);

    const discountRow = document.getElementById('discountRow');
    if (discountAmt > 0) {
        discountRow.style.display = 'flex';
        document.getElementById('discountLabel').textContent   = discountType === 'percent' ? `Discount (${dVal}%)` : 'Discount';
        document.getElementById('discountDisplay').textContent = '-$' + discountAmt.toFixed(2);
    } else {
        discountRow.style.display = 'none';
    }
}

function handleConfirm() {
    const method = document.querySelector('input[name=payment_method]:checked')?.value;

    if (method === 'Cash') {
        // Open cash modal
        document.getElementById('modalTotal').textContent = '$' + totalAmount.toFixed(2);
        document.getElementById('cashInput').value = '';
        document.getElementById('changeDisplay').textContent = '$0.00';
        document.getElementById('changeNote').textContent = '';
        document.getElementById('cashConfirmBtn').disabled = true;
        document.getElementById('cashConfirmBtn').style.opacity = '0.5';

        // Build quick amount buttons
        const quickAmounts = buildQuickAmounts(totalAmount);
        const container = document.getElementById('quickBtns');
        container.innerHTML = '';
        quickAmounts.forEach(amt => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'quick-btn';
            btn.textContent = '$' + amt.toFixed(2);
            btn.onclick = () => {
                document.getElementById('cashInput').value = amt.toFixed(2);
                calcChange();
            };
            container.appendChild(btn);
        });

        cashModal.show();
    } else {
        // KHQR or Card — submit directly
        document.getElementById('cashReceivedInput').value = totalAmount.toFixed(2);
        document.getElementById('posForm').submit();
    }
}

function buildQuickAmounts(total) {
    const amounts = [];
    const bases = [1, 5, 10, 20, 50, 100];
    bases.forEach(b => {
        const rounded = Math.ceil(total / b) * b;
        if (rounded >= total && !amounts.includes(rounded)) amounts.push(rounded);
    });
    return amounts.slice(0, 5);
}

function calcChange() {
    const received = parseFloat(document.getElementById('cashInput').value) || 0;
    const change   = received - totalAmount;
    const display  = document.getElementById('changeDisplay');
    const note     = document.getElementById('changeNote');
    const btn      = document.getElementById('cashConfirmBtn');

    if (received <= 0) {
        display.textContent = '$0.00';
        display.style.color = '#34d399';
        note.textContent = '';
        btn.disabled = true;
        btn.style.opacity = '0.5';
        return;
    }

    if (change < 0) {
        display.textContent = '-$' + Math.abs(change).toFixed(2);
        display.style.color = '#ef4444';
        note.textContent = 'Not enough cash';
        btn.disabled = true;
        btn.style.opacity = '0.5';
    } else {
        display.textContent = '$' + change.toFixed(2);
        display.style.color = change === 0 ? '#38bdf8' : '#34d399';
        note.textContent = change === 0 ? 'Exact amount ✓' : 'Return this to customer';
        btn.disabled = false;
        btn.style.opacity = '1';
    }
}

function closeCashModal() {
    cashModal.hide();
}

function submitCash() {
    const received = parseFloat(document.getElementById('cashInput').value) || 0;
    document.getElementById('cashReceivedInput').value = received.toFixed(2);
    cashModal.hide();
    document.getElementById('posForm').submit();
}
</script>
@endsection
