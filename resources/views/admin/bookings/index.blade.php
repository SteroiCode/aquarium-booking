@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-ticket-perforated"></i> Manage Bookings</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.export.bookings') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Export
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3" style="background: linear-gradient(135deg, #0ea5e9, #06b6d4) !important; border: none;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-ticket-perforated" style="font-size:22px;color:#fff;"></i>
                </div>
                <div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.8);font-weight:600;text-transform:uppercase;">Total Bookings</div>
                    <div style="font-size:28px;font-weight:800;color:#fff;" id="stat-total">{{ $totalBookings }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="background: linear-gradient(135deg, #f59e0b, #d97706) !important; border: none;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-hourglass-split" style="font-size:22px;color:#fff;"></i>
                </div>
                <div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.8);font-weight:600;text-transform:uppercase;">Pending</div>
                    <div style="font-size:28px;font-weight:800;color:#fff;" id="stat-pending">{{ $pending }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="background: linear-gradient(135deg, #10b981, #059669) !important; border: none;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-check-circle" style="font-size:22px;color:#fff;"></i>
                </div>
                <div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.8);font-weight:600;text-transform:uppercase;">Confirmed</div>
                    <div style="font-size:28px;font-weight:800;color:#fff;" id="stat-confirmed">{{ $confirmed }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="background: linear-gradient(135deg, #8b5cf6, #6366f1) !important; border: none;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-cash-stack" style="font-size:22px;color:#fff;"></i>
                </div>
                <div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.8);font-weight:600;text-transform:uppercase;">Total Revenue</div>
                    <div style="font-size:28px;font-weight:800;color:#fff;" id="stat-revenue">${{ number_format($totalRevenue, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card p-4 mb-4">
    <form method="GET" action="{{ route('admin.bookings.index') }}" id="filterForm">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label text-dark">Search</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Name, Email, or ID" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label text-dark">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label text-dark">Payment</label>
                <select name="payment_status" class="form-select">
                    <option value="">All Payments</option>
                    <option value="verified" {{ request('payment_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="pending_verification" {{ request('payment_status') == 'pending_verification' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('payment_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label text-dark">From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label text-dark">To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Bulk Actions -->
<form method="POST" action="{{ route('admin.bookings.bulkUpdate') }}" id="bulkForm">
    @csrf
    <div class="card p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <input type="checkbox" id="selectAll" class="form-check-input">
                <label for="selectAll" class="form-label mb-0">Select All on Page</label>
                <span id="selectedCount" class="badge bg-info">0 selected</span>
                
                <!-- Option to include all filtered results -->
                <div class="form-check ms-3">
                    <input type="checkbox" id="includeAllFiltered" name="include_all_filtered" value="1" class="form-check-input">
                    <label for="includeAllFiltered" class="form-check-label">
                        Include all filtered results ({{ $bookings->total() }} bookings)
                    </label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm" style="width: auto;" required>
                    <option value="">Bulk Action...</option>
                    <option value="Confirmed">Mark as Confirmed</option>
                    <option value="Cancelled">Mark as Cancelled</option>
                    <option value="Pending">Mark as Pending</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary" id="bulkBtn" disabled>
                    <i class="bi bi-check-all"></i> Apply
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden inputs to pass filter parameters -->
    <input type="hidden" name="filter_search" value="{{ request('search') }}">
    <input type="hidden" name="filter_status" value="{{ request('status') }}">
    <input type="hidden" name="filter_payment_status" value="{{ request('payment_status') }}">
    <input type="hidden" name="filter_date_from" value="{{ request('date_from') }}">
    <input type="hidden" name="filter_date_to" value="{{ request('date_to') }}">

    <!-- Bookings Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background: linear-gradient(135deg,#0ea5e9,#06b6d4);">
                    <tr>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;" width="30"></th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">ID</th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Customer</th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Aquarium</th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Visit Date</th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Tickets</th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Price</th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Payment</th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Status</th>
                        <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <input type="checkbox" name="booking_ids[]" value="{{ $booking->id }}" 
                                       class="form-check-input booking-checkbox">
                            </td>
                            <td><strong>#{{ $booking->id }}</strong></td>
                            <td>
                                {{ $booking->customer_name }}<br>
                                <small class="text-muted">{{ $booking->customer_email }}</small>
                            </td>
                            <td>{{ $booking->aquarium->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->visit_date)->format('M d, Y') }}</td>
                            <td>{{ $booking->tickets }}</td>
                            <td>${{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                @if($booking->payment_status == 'verified')
                                    <span class="badge bg-success">Verified</span>
                                @elseif($booking->payment_status == 'pending_verification')
                                    <span class="badge bg-warning">Pending</span>
                                    @if($booking->payment_proof)
                                        <br><a href="{{ asset('storage/' . $booking->payment_proof) }}" 
                                           target="_blank" class="btn btn-sm btn-link p-0">View</a>
                                    @endif
                                @elseif($booking->payment_status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">Unpaid</span>
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
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown"
                                            style="background:linear-gradient(135deg,#0ea5e9,#06b6d4);color:#fff;font-weight:600;border:none;">
                                        <i class="bi bi-gear"></i> Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);min-width:160px;">

                                        @if($booking->payment_status == 'pending_verification')
                                        <li>
                                            <a class="dropdown-item" href="#" style="color:#10b981;"
                                               onclick="submitAction('{{ route('admin.bookings.verifyPayment', $booking->id) }}', 'POST'); return false;">
                                                <i class="bi bi-check-circle"></i> Verify Payment
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" style="color:#ef4444;"
                                               onclick="submitAction('{{ route('admin.bookings.rejectPayment', $booking->id) }}', 'POST'); return false;">
                                                <i class="bi bi-x-circle"></i> Reject Payment
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider" style="border-color:rgba(255,255,255,0.1);"></li>
                                        @endif

                                        <li>
                                            <a class="dropdown-item" href="#" style="color:#10b981;"
                                               onclick="submitAction('{{ route('admin.bookings.updateStatus', $booking->id) }}', 'PUT', 'Confirmed'); return false;">
                                                <i class="bi bi-check2-circle"></i> Set Confirmed
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" style="color:#f59e0b;"
                                               onclick="submitAction('{{ route('admin.bookings.updateStatus', $booking->id) }}', 'PUT', 'Pending'); return false;">
                                                <i class="bi bi-hourglass-split"></i> Set Pending
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" style="color:#ef4444;"
                                               onclick="submitAction('{{ route('admin.bookings.updateStatus', $booking->id) }}', 'PUT', 'Cancelled'); return false;">
                                                <i class="bi bi-slash-circle"></i> Set Cancelled
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="text-muted mt-2">No bookings found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</form>

<div class="mt-4">
    {{ $bookings->links() }}
</div>

<script>
// Bulk selection
const selectAll = document.getElementById('selectAll');
const checkboxes = document.querySelectorAll('.booking-checkbox');
const selectedCount = document.getElementById('selectedCount');
const bulkBtn = document.getElementById('bulkBtn');
const includeAllFiltered = document.getElementById('includeAllFiltered');

selectAll.addEventListener('change', function() {
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateCount();
});

checkboxes.forEach(cb => {
    cb.addEventListener('change', updateCount);
});

includeAllFiltered.addEventListener('change', function() {
    if (this.checked) {
        // Uncheck individual selections when "include all" is checked
        selectAll.checked = false;
        checkboxes.forEach(cb => cb.checked = false);
    }
    updateCount();
});

function updateCount() {
    const includeAll = includeAllFiltered.checked;
    const count = document.querySelectorAll('.booking-checkbox:checked').length;
    
    if (includeAll) {
        const totalBookings = {{ $bookings->total() }};
        selectedCount.textContent = `All ${totalBookings} filtered bookings`;
        selectedCount.classList.remove('bg-info');
        selectedCount.classList.add('bg-warning');
        bulkBtn.disabled = false;
    } else {
        selectedCount.textContent = count + ' selected';
        selectedCount.classList.remove('bg-warning');
        selectedCount.classList.add('bg-info');
        bulkBtn.disabled = count === 0;
    }
}

document.getElementById('bulkForm').addEventListener('submit', function(e) {
    const includeAll = includeAllFiltered.checked;
    const count = document.querySelectorAll('.booking-checkbox:checked').length;
    
    if (!includeAll && count === 0) {
        e.preventDefault();
        alert('Please select at least one booking or check "Include all filtered results"');
        return false;
    }
    
    if (includeAll) {
        const totalBookings = {{ $bookings->total() }};
        const statusSelect = document.querySelector('select[name="status"]');
        const selectedStatus = statusSelect.options[statusSelect.selectedIndex].text;
        
        if (!confirm(`Are you sure you want to ${selectedStatus.toLowerCase()} ALL ${totalBookings} filtered bookings?\n\nThis action cannot be undone.`)) {
            e.preventDefault();
            return false;
        }
    }
});

// Payment verification functions removed — actions now use inline forms

function submitAction(url, method, status) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    if (method === 'PUT') {
        const m = document.createElement('input');
        m.type = 'hidden';
        m.name = '_method';
        m.value = 'PUT';
        form.appendChild(m);
    }

    if (status) {
        const s = document.createElement('input');
        s.type = 'hidden';
        s.name = 'status';
        s.value = status;
        form.appendChild(s);
    }

    document.body.appendChild(form);
    form.submit();
}

</script>

<script>
    // ── Auto-refresh bookings table + stats every 3 seconds ──
    (function () {
        let paused = false;

        document.addEventListener('mousedown', () => { paused = true; });
        document.addEventListener('mouseup', () => { setTimeout(() => paused = false, 2000); });

        // Update stats cards via lightweight JSON endpoint
        function refreshStats() {
            fetch('/admin/notifications/booking-stats')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('stat-total').textContent     = data.total;
                    document.getElementById('stat-pending').textContent   = data.pending;
                    document.getElementById('stat-confirmed').textContent = data.confirmed;
                    document.getElementById('stat-revenue').textContent   = '$' + parseFloat(data.revenue).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }).catch(() => {});
        }

        // Update table rows via full page fetch
        function refreshTable() {
            if (paused) return;
            const url = new URL(window.location.href);
            fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTbody = doc.querySelector('tbody');
                    const curTbody = document.querySelector('tbody');
                    if (newTbody && curTbody && newTbody.innerHTML !== curTbody.innerHTML) {
                        curTbody.innerHTML = newTbody.innerHTML;
                    }
                }).catch(() => {});
        }

        // Stats refresh every 3s, table every 5s
        setInterval(refreshStats, 3000);
        setInterval(refreshTable, 5000);
    })();
</script>

@endsection