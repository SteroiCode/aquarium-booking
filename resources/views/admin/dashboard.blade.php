@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Dashboard Overview</h2>
        <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}</p>
    </div>
    <div class="text-end">
        <small class="text-muted d-block">{{ now()->format('l') }}</small>
        <small class="text-muted">{{ now()->format('F j, Y') }}</small>
    </div>
</div>

<!-- Main Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-4" style="background: linear-gradient(135deg, #0ea5e9, #06b6d4); border: none;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-white-50 mb-2" style="font-size: 13px; font-weight: 500;">Total Aquariums</div>
                    <h2 class="fw-bold mb-0" style="font-size: 32px;">{{ $totalAquariums }}</h2>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-building" style="font-size: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4" style="background: linear-gradient(135deg, #8b5cf6, #6366f1); border: none;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-white-50 mb-2" style="font-size: 13px; font-weight: 500;">Total Bookings</div>
                    <h2 class="fw-bold mb-0" style="font-size: 32px;">{{ $totalBookings }}</h2>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-ticket-perforated" style="font-size: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4" style="background: linear-gradient(135deg, #ec4899, #db2777); border: none;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-white-50 mb-2" style="font-size: 13px; font-weight: 500;">Total Customers</div>
                    <h2 class="fw-bold mb-0" style="font-size: 32px;">{{ $totalUsers }}</h2>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-people" style="font-size: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-4" style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-white-50 mb-2" style="font-size: 13px; font-weight: 500;">Total Revenue</div>
                    <h2 class="fw-bold mb-0" style="font-size: 32px;">${{ number_format($totalRevenue, 0) }}</h2>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-cash-stack" style="font-size: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Time-based Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card p-3" style="background: rgba(251, 191, 36, 0.15); border-left: 3px solid #fbbf24;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-warning mb-1" style="font-size: 12px; font-weight: 600;">
                        <i class="bi bi-calendar-day"></i> TODAY'S BOOKINGS
                    </div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">{{ $todayBookings }}</h3>
                    <small class="text-muted" style="font-size: 11px;">{{ date('F d, Y') }}</small>
                </div>
                <i class="bi bi-calendar-check" style="font-size: 32px; opacity: 0.2; color: #fbbf24;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3" style="background: rgba(59, 130, 246, 0.15); border-left: 3px solid #3b82f6;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-info mb-1" style="font-size: 12px; font-weight: 600;">
                        <i class="bi bi-calendar-month"></i> THIS MONTH
                    </div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">{{ $monthBookings }}</h3>
                    <small class="text-muted" style="font-size: 11px;">{{ date('F Y') }}</small>
                </div>
                <i class="bi bi-calendar3" style="font-size: 32px; opacity: 0.2; color: #3b82f6;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3" style="background: rgba(236, 72, 153, 0.15); border-left: 3px solid #ec4899;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-danger mb-1" style="font-size: 12px; font-weight: 600;">
                        <i class="bi bi-person-plus"></i> NEW TODAY
                    </div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">{{ $todayUsers }}</h3>
                    <small class="text-muted" style="font-size: 11px;">New customers</small>
                </div>
                <i class="bi bi-person-check" style="font-size: 32px; opacity: 0.2; color: #ec4899;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3" style="background: rgba(139, 92, 246, 0.15); border-left: 3px solid #8b5cf6;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-primary mb-1" style="font-size: 12px; font-weight: 600;">
                        <i class="bi bi-people-fill"></i> MONTH TOTAL
                    </div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">{{ $monthUsers }}</h3>
                    <small class="text-muted" style="font-size: 11px;">New this month</small>
                </div>
                <i class="bi bi-person-lines-fill" style="font-size: 32px; opacity: 0.2; color: #8b5cf6;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Alerts Section -->
@if($pendingApprovals > 0 || $failedPayments > 0 || $lowPerformingAquariums > 0)
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card p-4">
            <h5 class="mb-3"><i class="bi bi-bell"></i> Notifications & Alerts</h5>
            
            @if($pendingApprovals > 0)
            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-3" style="border-left: 4px solid #fbbf24;">
                <div>
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>{{ $pendingApprovals }} Payment{{ $pendingApprovals > 1 ? 's' : '' }} Awaiting Verification</strong>
                    <p class="mb-0 mt-1 small text-muted">Review and approve pending payment submissions</p>
                </div>
                <a href="{{ route('admin.bookings.index', ['payment_status' => 'pending_verification']) }}" 
                   class="btn btn-warning btn-sm">
                    <i class="bi bi-eye"></i> Review Now
                </a>
            </div>
            @endif

            @if($failedPayments > 0)
            <div class="alert alert-danger d-flex justify-content-between align-items-center mb-3" style="border-left: 4px solid #ef4444;">
                <div>
                    <i class="bi bi-x-circle-fill"></i>
                    <strong>{{ $failedPayments }} Rejected Payment{{ $failedPayments > 1 ? 's' : '' }}</strong>
                    <p class="mb-0 mt-1 small text-muted">Payments that were rejected and need attention</p>
                </div>
                <a href="{{ route('admin.bookings.index', ['payment_status' => 'rejected']) }}" 
                   class="btn btn-danger btn-sm">
                    <i class="bi bi-list-ul"></i> View Details
                </a>
            </div>
            @endif

            @if($lowPerformingAquariums > 0)
            <div class="alert alert-info d-flex justify-content-between align-items-center mb-0" style="border-left: 4px solid #3b82f6;">
                <div>
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>{{ $lowPerformingAquariums }} Low-Performing Aquarium{{ $lowPerformingAquariums > 1 ? 's' : '' }}</strong>
                    <p class="mb-0 mt-1 small text-muted">Aquariums with less than 5 bookings need attention</p>
                </div>
                <a href="{{ route('admin.aquariums.index') }}" class="btn btn-info btn-sm">
                    <i class="bi bi-building"></i> View Aquariums
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Charts Section -->
<div class="row g-4 mb-4">
    <div class="col-md-7">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0"><i class="bi bi-graph-up"></i> Monthly Revenue Trend</h6>
                <span class="badge bg-primary">{{ date('Y') }}</span>
            </div>
            <canvas id="revenueChart" style="max-height: 280px;"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card p-4">
            <h6 class="mb-3"><i class="bi bi-pie-chart"></i> Revenue by Aquarium</h6>
            <div class="row">
                <div class="col-6">
                    <canvas id="revenueChart2" style="max-height: 220px;"></canvas>
                </div>
                <div class="col-6 d-flex align-items-center">
                    <div class="w-100">
                        @foreach($revenueByAquarium->take(5) as $index => $item)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <span style="font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <i class="bi bi-circle-fill" style="font-size: 8px; color: {{ ['#0ea5e9', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444'][$index % 5] }}"></i> 
                                    {{ Str::limit($item->name, 12) }}
                                </span>
                                <strong style="font-size: 14px;">${{ number_format($item->revenue, 0) }}</strong>
                            </div>
                        @endforeach
                        @if($revenueByAquarium->count() == 0)
                            <p class="text-muted small mb-0">No revenue data available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4">
    <div class="col-12">
        <div class="card p-4">
            <h5 class="mb-3"><i class="bi bi-lightning-fill"></i> Quick Actions</h5>
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">
                    <i class="bi bi-ticket-perforated"></i> Manage Bookings
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-info">
                    <i class="bi bi-people"></i> Manage Customers
                </a>
                <a href="{{ route('admin.aquariums.index') }}" class="btn btn-success">
                    <i class="bi bi-building"></i> Manage Aquariums
                </a>
                <a href="{{ route('admin.analytics.index') }}" class="btn btn-secondary">
                    <i class="bi bi-graph-up-arrow"></i> View Analytics
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-dark">
                    <i class="bi bi-gear"></i> System Settings
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue ($)',
                data: {!! json_encode(array_values($monthlyRevenue->toArray())) !!},
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#0ea5e9',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(14, 165, 233, 0.5)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        color: '#94a3b8',
                        font: { size: 11 },
                        callback: function(value) {
                            return '$' + value;
                        }
                    },
                    grid: { color: 'rgba(255, 255, 255, 0.05)' }
                },
                x: {
                    ticks: { 
                        color: '#94a3b8',
                        font: { size: 11 }
                    },
                    grid: { color: 'rgba(255, 255, 255, 0.05)' }
                }
            }
        }
    });

    const statusCtx = document.getElementById('revenueChart2').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($revenueByAquarium->pluck('name')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($revenueByAquarium->pluck('revenue')->toArray()) !!},
                backgroundColor: ['#0ea5e9', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#ec4899'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(14, 165, 233, 0.5)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return context.label + ': $' + context.parsed;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection

