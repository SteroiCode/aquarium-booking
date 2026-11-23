<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::all()->keyBy('key');
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'max_tickets_per_booking' => 'nullable|integer|min:1',
            'advance_booking_days' => 'nullable|integer|min:1',
            'booking_cancellation_hours' => 'nullable|integer|min:0',
            'enable_email_notifications' => 'nullable|boolean',
            'business_hours_start' => 'nullable|date_format:H:i',
            'business_hours_end' => 'nullable|date_format:H:i',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                SystemSetting::set($key, $value);
            }
        }

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('logos', 'public');
            SystemSetting::set('site_logo', $path, 'file');
        }

        ActivityLog::log('update', 'Updated system settings');

        return back()->with('success', 'Settings updated successfully!');
    }

    public function sendBulkEmail(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'recipient_type' => 'required|in:all,active,inactive'
        ]);

        // This is a placeholder - you'd integrate with your email service
        $count = \App\Models\User::where('role', 'user')->count();

        ActivityLog::log('email', "Sent bulk email to {$count} users: {$validated['subject']}");

        return back()->with('success', "Email queued for {$count} recipients!");
    }
}
