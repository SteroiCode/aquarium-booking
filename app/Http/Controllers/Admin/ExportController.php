<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportBookings(Request $request)
    {
        $query = Booking::with(['aquarium', 'user']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('visit_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('visit_date', '<=', $request->date_to);
        }

        $bookings = $query->get();

        $filename = 'bookings_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'ID', 'Customer Name', 'Email', 'Aquarium', 'Visit Date', 
                'Tickets', 'Total Price', 'Status', 'Payment Method', 
                'Payment Status', 'Transaction ID', 'Booked At'
            ]);

            // Data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->customer_name,
                    $booking->customer_email,
                    $booking->aquarium->name ?? 'N/A',
                    $booking->visit_date,
                    $booking->tickets,
                    $booking->total_price,
                    $booking->status,
                    $booking->payment_method ?? 'N/A',
                    $booking->payment_status ?? 'N/A',
                    $booking->transaction_id ?? 'N/A',
                    $booking->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('export', 'Exported bookings data');

        return response()->stream($callback, 200, $headers);
    }

    public function exportUsers(Request $request)
    {
        $users = User::where('role', 'user')
            ->withCount('bookings')
            ->get();

        $filename = 'users_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'Name', 'Email', 'Total Bookings', 'Registered At']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->bookings_count,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('export', 'Exported users data');

        return response()->stream($callback, 200, $headers);
    }

    public function exportRevenue(Request $request)
    {
        $query = Booking::where('status', 'Confirmed')->with('aquarium');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $bookings = $query->get();

        $filename = 'revenue_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Date', 'Booking ID', 'Aquarium', 'Customer', 
                'Tickets', 'Amount', 'Payment Method', 'Transaction ID'
            ]);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->created_at->format('Y-m-d'),
                    $booking->id,
                    $booking->aquarium->name ?? 'N/A',
                    $booking->customer_name,
                    $booking->tickets,
                    $booking->total_price,
                    $booking->payment_method ?? 'N/A',
                    $booking->transaction_id ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('export', 'Exported revenue data');

        return response()->stream($callback, 200, $headers);
    }
}
