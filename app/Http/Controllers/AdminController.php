<?php

namespace App\Http\Controllers;

use App\Models\Aquarium;
use App\Models\Booking;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch real data from database
        $totalAquariums = Aquarium::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'Confirmed')->sum('total_price') ?? 0;
        $totalPending = Booking::where('status', 'Pending')->count();
        $totalConfirmed = Booking::where('status', 'Confirmed')->count();
        $totalCancelled = Booking::where('status', 'Cancelled')->count();
        $totalUsers = \App\Models\User::where('role', 'user')->count();

        // Pending approvals (payment verification needed)
        $pendingApprovals = Booking::where('payment_status', 'pending_verification')->count();
        
        // Failed payments
        $failedPayments = Booking::where('payment_status', 'rejected')->count();

        // Today's bookings
        $todayBookings = Booking::whereDate('created_at', today())->count();
        
        // This month's bookings
        $monthBookings = Booking::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // Today's new users
        $todayUsers = \App\Models\User::where('role', 'user')
            ->whereDate('created_at', today())
            ->count();
        
        // This month's new users
        $monthUsers = \App\Models\User::where('role', 'user')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // Revenue breakdown by aquarium
        $revenueByAquarium = Booking::where('status', 'Confirmed')
            ->join('aquariums', 'bookings.aquarium_id', '=', 'aquariums.id')
            ->selectRaw('aquariums.name, SUM(bookings.total_price) as revenue')
            ->groupBy('aquariums.id', 'aquariums.name')
            ->get();

        // Get monthly revenue data for current year
        $monthlyRevenue = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => 0];
        });

        $actualRevenue = Booking::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->where('status', 'Confirmed')
            ->whereNotNull('created_at')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyRevenue = $monthlyRevenue->merge($actualRevenue);

        // Low performing aquariums (less than 5 bookings)
        $lowPerformingAquariums = Aquarium::withCount('bookings')
            ->having('bookings_count', '<', 5)
            ->count();

        return view('admin.dashboard', compact(
            'totalAquariums',
            'totalBookings',
            'totalRevenue',
            'totalPending',
            'totalConfirmed',
            'totalCancelled',
            'monthlyRevenue',
            'totalUsers',
            'todayBookings',
            'monthBookings',
            'todayUsers',
            'monthUsers',
            'revenueByAquarium',
            'pendingApprovals',
            'failedPayments',
            'lowPerformingAquariums'
        ));
    }

    public function manageUsers()
    {
        $users = \App\Models\User::withCount('bookings')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:user,admin',
        ]);

        \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', ucfirst($request->role) . ' "' . $request->name . '" created successfully.');
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    public function updateRole(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $request->validate(['role' => 'required|in:user,admin']);
        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', '"' . $user->name . '" is now ' . ucfirst($request->role) . '.');
    }

    public function userBookings($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $bookings = Booking::where('user_id', $userId)
            ->with('aquarium')
            ->latest()
            ->paginate(10);

        return view('admin.users.bookings', compact('user', 'bookings'));
    }

    public function manageBookings(Request $request)
    {
        $query = Booking::with('aquarium', 'user');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('visit_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('visit_date', '<=', $request->date_to);
        }

        $bookings = $query->latest()->paginate(15);

        $totalBookings = Booking::count();
        $confirmed = Booking::where('status','Confirmed')->count();
        $pending = Booking::where('status','Pending')->count();
        $totalRevenue = Booking::where('status','Confirmed')->sum('total_price');

        return view('admin.bookings.index', compact(
            'bookings',
            'totalBookings',
            'confirmed',
            'pending',
            'totalRevenue'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->status;
        $booking->status = $request->status;
        $booking->save();

        ActivityLog::log(
            'update',
            "Updated booking #{$id} status from {$oldStatus} to {$request->status}",
            Booking::class,
            $id,
            ['old_status' => $oldStatus, 'new_status' => $request->status]
        );

        return back()->with('success', 'Booking status updated!');
    }

    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled',
            'booking_ids' => 'nullable|array',
            'include_all_filtered' => 'nullable|boolean'
        ]);

        $count = 0;

        if ($request->has('include_all_filtered') && $request->include_all_filtered) {
            // Update all bookings matching the current filters
            $query = Booking::query();

            // Apply the same filters as in manageBookings
            if ($request->filled('filter_search')) {
                $search = $request->filter_search;
                $query->where(function($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_email', 'like', "%{$search}%")
                      ->orWhere('id', $search);
                });
            }

            if ($request->filled('filter_status')) {
                $query->where('status', $request->filter_status);
            }

            if ($request->filled('filter_payment_status')) {
                $query->where('payment_status', $request->filter_payment_status);
            }

            if ($request->filled('filter_date_from')) {
                $query->whereDate('visit_date', '>=', $request->filter_date_from);
            }

            if ($request->filled('filter_date_to')) {
                $query->whereDate('visit_date', '<=', $request->filter_date_to);
            }

            $count = $query->update(['status' => $validated['status']]);

            ActivityLog::log(
                'bulk_update',
                "Bulk updated {$count} filtered bookings to status: {$validated['status']}",
                null,
                null,
                ['filters' => $request->only(['filter_search', 'filter_status', 'filter_payment_status', 'filter_date_from', 'filter_date_to'])]
            );
        } else {
            // Update only selected bookings
            if (!$request->has('booking_ids') || empty($request->booking_ids)) {
                return back()->with('error', 'Please select at least one booking');
            }

            $count = Booking::whereIn('id', $validated['booking_ids'])
                ->update(['status' => $validated['status']]);

            ActivityLog::log(
                'bulk_update',
                "Bulk updated {$count} bookings to status: {$validated['status']}",
                null,
                null,
                ['booking_ids' => $validated['booking_ids']]
            );
        }

        return back()->with('success', "{$count} bookings updated successfully!");
    }
}