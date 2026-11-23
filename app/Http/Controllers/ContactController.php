<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;

class ContactController extends Controller
{
    public function index()
    {
        // Get contact info from system settings (can be updated in admin panel)
        $siteName = SystemSetting::get('site_name', 'Ocean Blue Aquarium');
        $contactEmail = SystemSetting::get('contact_email', 'info@oceanblue.com');
        $contactPhone = SystemSetting::get('contact_phone', '+855 23 456 789');
        $businessHoursStart = SystemSetting::get('business_hours_start', '09:00');
        $businessHoursEnd = SystemSetting::get('business_hours_end', '18:00');

        return view('contact', compact(
            'siteName',
            'contactEmail',
            'contactPhone',
            'businessHoursStart',
            'businessHoursEnd'
        ));
    }

    public function about()
    {
        $siteName = SystemSetting::get('site_name', 'Ocean Blue Aquarium');
        
        return view('about', compact('siteName'));
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        // Here you would send the email or store in database
        // For now, just return success message

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
