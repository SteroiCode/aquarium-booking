@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-graph-up-arrow"></i> Advanced Analytics</h2>
    <a href="{{ route('admin.analytics.calendar') }}" class="btn btn-primary">
        <i class="bi bi-calendar3"></i> Calendar View
    </a>
</div>

<!-- Key Metrics -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3" style="background: linear-gradient(135deg, #10b981, #059669);">
            <h6 class="text-white-50 mb-2">Customer Retention</h6>
            <h2 class="fw-bold mb-0">{{ number_format($retentionRate, 1) }}%</h2>
            <small class="text-white-50">{{ $repeatCustomers }} repeat customers</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="background: linear-gradient(135deg, #0ea5e9, #06b6d4);">
            <h6 class="text-white-50 mb-2">Avg Booking Value</h6>
            <h2 class="fw-bold mb-0">${{ number_format($avgBookingValue, 2) }}</h2>
            <small class="text-white-50">Per transaction</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
            <h6 class="text-white-50 mb-2">Cancellation Rate</h6>
            <h2 class="fw-bold mb-0">{{ number_format($cancellationRate, 1) }}%</h2>
            <small class="text-white-50">Of all bookings</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="background: linear-gradient(135deg, #8b5cf6, #6366f1);">
            <h6 class="text-white-50 mb-2">Total Customers</h6>
            <h2 class="fw-bold mb-0">{{ $totalCustomers }}</h2>
            <small class="text-white-50">Registered users</small>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="mb-3"><i class="bi bi-clock"></i> Peak Booking Hours</h5>
            <canvas id="peakHoursChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="mb-3"><i class="bi bi-calendar-week"></i> Bookings by Day of Week</h5>
            <canvas id="weekdayChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Popular Aquariums -->
<div class="row g-4 mb-4">
    <div class="col-md-12">
        <div class="card p-4">
            <h5 class="mb-3"><i class="bi bi-trophy"></i> Top 10 Popular Aquariums</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background: linear-gradient(135deg,#0ea5e9,#06b6d4);">
                        <tr>
                            <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Rank</th>
                            <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Aquarium</th>
                            <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Total Bookings</th>
                            <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Popularity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($popularAquariums as $index => $item)
                        <tr>
                            <td>
                                @if($index === 0)
                                    <i class="bi bi-trophy-fill text-warning"></i>
                                @elseif($index === 1)
                                    <i class="bi bi-trophy-fill text-secondary"></i>
                                @elseif($index === 2)
                                    <i class="bi bi-trophy-fill" style="color: #cd7f32;"></i>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>
                            <td>{{ $item->aquarium->name ?? 'Unknown' }}</td>
                            <td>{{ $item->booking_count }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" 
                                         style="width: {{ ($item->booking_count / $popularAquariums->first()->booking_count) * 100 }}%">
                                        {{ $item->booking_count }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Trends -->
<div class="row g-4">
    <div class="col-md-12">
        <div class="card p-4">
            <h5 class="mb-3"><i class="bi bi-graph-up"></i> Monthly Performance Trends</h5>
            <canvas id="trendsChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Peak Hours Chart
const peakHoursCtx = document.getElementById('peakHoursChart').getContext('2d');
new Chart(peakHoursCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($peakHours->toArray())) !!}.map(h => h + ':00'),
        datasets: [{
            label: 'Bookings',
            data: {!! json_encode(array_values($peakHours->toArray())) !!},
            backgroundColor: 'rgba(14, 165, 233, 0.8)',
            borderColor: '#0ea5e9',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { 
                beginAtZero: true,
                ticks: { color: '#94a3b8' },
                grid: { color: 'rgba(255, 255, 255, 0.1)' }
            },
            x: {
                ticks: { color: '#94a3b8' },
                grid: { color: 'rgba(255, 255, 255, 0.1)' }
            }
        }
    }
});

// Weekday Chart
const weekdayCtx = document.getElementById('weekdayChart').getContext('2d');
new Chart(weekdayCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($weekdayData->toArray())) !!},
        datasets: [{
            data: {!! json_encode(array_values($weekdayData->toArray())) !!},
            backgroundColor: [
                '#ef4444', '#f59e0b', '#10b981', '#0ea5e9', 
                '#8b5cf6', '#ec4899', '#06b6d4'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                position: 'right',
                labels: { color: '#e2e8f0' }
            }
        }
    }
});

// Trends Chart
const trendsCtx = document.getElementById('trendsChart').getContext('2d');
new Chart(trendsCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'Bookings',
                data: {!! json_encode($trends->pluck('total_bookings')->toArray()) !!},
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                yAxisID: 'y',
                tension: 0.4
            },
            {
                label: 'Revenue ($)',
                data: {!! json_encode($trends->pluck('revenue')->toArray()) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                yAxisID: 'y1',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { 
                labels: { color: '#e2e8f0' }
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                ticks: { color: '#94a3b8' },
                grid: { color: 'rgba(255, 255, 255, 0.1)' }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                ticks: { color: '#94a3b8' },
                grid: { drawOnChartArea: false }
            },
            x: {
                ticks: { color: '#94a3b8' },
                grid: { color: 'rgba(255, 255, 255, 0.1)' }
            }
        }
    }
});
</script>
@endsection
