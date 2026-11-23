@extends('admin.layout')

@section('content')
<h2 class="mb-4">Dashboard Overview</h2>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card p-4">
            <h3>{{ $totalAquariums }}</h3>
            <p class="mb-0">Total Aquariums</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4">
            <h3>{{ $totalBookings }}</h3>
            <p class="mb-0">Total Bookings</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4">
            <h3>{{ $totalPending }}</h3>
            <p class="mb-0">Pending</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4">
            <h3>${{ number_format($totalRevenue, 2) }}</h3>
            <p class="mb-0">Total Revenue</p>
        </div>
    </div>
</div>
@endsection
