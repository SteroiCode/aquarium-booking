<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Aquarium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Peak booking times
        $hourlyBookings = Booking::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour');

        // Fill missing hours with 0
        $peakHours = collect(range(0, 23))->mapWithKeys(function($hour) use ($hourlyBookings) {
            return [$hour => $hourlyBookings->get($hour, 0)];
        });

        // Popular aquariums
        $popularAquariums = Booking::select('aquarium_id', DB::raw('COUNT(*) as booking_count'))
            ->with('aquarium')
            ->groupBy('aquarium_id')
            ->orderByDesc('booking_count')
            ->limit(10)
            ->get();

        // Customer retention (repeat customers)
        $repeatCustomers = User::where('role', 'user')
            ->withCount('bookings')
            ->having('bookings_count', '>', 1)
            ->count();
        
        $totalCustomers = User::where('role', 'user')->count();
        $retentionRate = $totalCustomers > 0 ? ($repeatCustomers / $totalCustomers) * 100 : 0;

        // Average booking value
        $avgBookingValue = Booking::where('status', 'Confirmed')->avg('total_price') ?? 0;

        // Cancellation rate
        $totalBookings = Booking::count();
        $cancelledBookings = Booking::where('status', 'Cancelled')->count();
        $cancellationRate = $totalBookings > 0 ? ($cancelledBookings / $totalBookings) * 100 : 0;

        // Monthly trends
        $monthlyTrends = Booking::selectRaw('
                MONTH(created_at) as month,
                COUNT(*) as total_bookings,
                SUM(CASE WHEN status = "Confirmed" THEN total_price ELSE 0 END) as revenue,
                AVG(total_price) as avg_value
            ')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fill missing months
        $trends = collect(range(1, 12))->map(function($month) use ($monthlyTrends) {
            $data = $monthlyTrends->firstWhere('month', $month);
            return [
                'month' => $month,
                'total_bookings' => $data->total_bookings ?? 0,
                'revenue' => $data->revenue ?? 0,
                'avg_value' => $data->avg_value ?? 0
            ];
        });

        // Day of week analysis
        $dayOfWeekBookings = Booking::selectRaw('DAYOFWEEK(visit_date) as day, COUNT(*) as count')
            ->groupBy('day')
            ->get()
            ->pluck('count', 'day');

        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $weekdayData = collect(range(1, 7))->mapWithKeys(function($day) use ($dayOfWeekBookings, $daysOfWeek) {
            return [$daysOfWeek[$day - 1] => $dayOfWeekBookings->get($day, 0)];
        });

        return view('admin.analytics.index', compact(
            'peakHours',
            'popularAquariums',
            'retentionRate',
            'avgBookingValue',
            'cancellationRate',
            'trends',
            'weekdayData',
            'repeatCustomers',
            'totalCustomers'
        ));
    }

    public function calendar()
    {
        $bookings = Booking::with('aquarium')
            ->whereMonth('visit_date', date('m'))
            ->whereYear('visit_date', date('Y'))
            ->get();

        $events = $bookings->map(function($booking) {
            return [
                'title' => $booking->aquarium->name . ' - ' . $booking->tickets . ' tickets',
                'start' => $booking->visit_date,
                'color' => $booking->status === 'Confirmed' ? '#10b981' : 
                          ($booking->status === 'Pending' ? '#f59e0b' : '#ef4444'),
                'url' => route('admin.bookings.index')
            ];
        });

        return view('admin.analytics.calendar', compact('events'));
    }
}
