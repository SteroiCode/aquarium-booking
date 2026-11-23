<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Aquarium Booking System', 'type' => 'text', 'description' => 'Website name'],
            ['key' => 'max_tickets_per_booking', 'value' => '10', 'type' => 'number', 'description' => 'Maximum tickets per booking'],
            ['key' => 'advance_booking_days', 'value' => '30', 'type' => 'number', 'description' => 'Days in advance for booking'],
            ['key' => 'booking_cancellation_hours', 'value' => '24', 'type' => 'number', 'description' => 'Hours before visit for cancellation'],
            ['key' => 'enable_email_notifications', 'value' => '1', 'type' => 'boolean', 'description' => 'Enable email notifications'],
            ['key' => 'business_hours_start', 'value' => '09:00', 'type' => 'time', 'description' => 'Business opening time'],
            ['key' => 'business_hours_end', 'value' => '18:00', 'type' => 'time', 'description' => 'Business closing time'],
            ['key' => 'contact_email', 'value' => 'admin@aquarium.com', 'type' => 'email', 'description' => 'Contact email'],
            ['key' => 'contact_phone', 'value' => '+1234567890', 'type' => 'text', 'description' => 'Contact phone'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
