@extends('admin.layout')

@section('content')
<h2 class="mb-4"><i class="bi bi-gear"></i> System Settings</h2>

<div class="row g-4">
    <!-- General Settings -->
    <div class="col-md-8">
        <div class="card p-4 mb-4">
            <h5 class="mb-3"><i class="bi bi-sliders"></i> General Settings</h5>
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Site Name</label>
                    <input type="text" name="site_name" class="form-control" 
                           value="{{ $settings->get('site_name')->value ?? 'Aquarium Booking System' }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control" 
                               value="{{ $settings->get('contact_email')->value ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" 
                               value="{{ $settings->get('contact_phone')->value ?? '' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Site Logo</label>
                    <input type="file" name="site_logo" class="form-control" accept="image/*">
                    @if($settings->has('site_logo'))
                        <small class="text-muted">Current: {{ basename($settings->get('site_logo')->value) }}</small>
                    @endif
                </div>

                <hr class="my-4">

                <h6 class="mb-3">Booking Rules</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Max Tickets per Booking</label>
                        <input type="number" name="max_tickets_per_booking" class="form-control" 
                               value="{{ $settings->get('max_tickets_per_booking')->value ?? 10 }}" min="1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Advance Booking Days</label>
                        <input type="number" name="advance_booking_days" class="form-control" 
                               value="{{ $settings->get('advance_booking_days')->value ?? 30 }}" min="1">
                        <small class="text-muted">How many days in advance</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cancellation Hours</label>
                        <input type="number" name="booking_cancellation_hours" class="form-control" 
                               value="{{ $settings->get('booking_cancellation_hours')->value ?? 24 }}" min="0">
                        <small class="text-muted">Hours before visit</small>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="mb-3">Business Hours</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Opening Time</label>
                        <input type="time" name="business_hours_start" class="form-control" 
                               value="{{ $settings->get('business_hours_start')->value ?? '09:00' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Closing Time</label>
                        <input type="time" name="business_hours_end" class="form-control" 
                               value="{{ $settings->get('business_hours_end')->value ?? '18:00' }}">
                    </div>
                </div>

                <hr class="my-4">

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="enable_email_notifications" 
                           id="emailNotif" value="1"
                           {{ ($settings->get('enable_email_notifications')->value ?? '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="emailNotif">
                        Enable Email Notifications
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save Settings
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-4">
        <!-- Bulk Email -->
        <div class="card p-4 mb-4">
            <h5 class="mb-3"><i class="bi bi-envelope"></i> Bulk Email</h5>
            <form method="POST" action="{{ route('admin.settings.bulk_email') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Recipients</label>
                    <select name="recipient_type" class="form-select" required>
                        <option value="all">All Users</option>
                        <option value="active">Active Users (with bookings)</option>
                        <option value="inactive">Inactive Users</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-info w-100">
                    <i class="bi bi-send"></i> Send Email
                </button>
            </form>
        </div>

        <!-- Export Data -->
        <div class="card p-4">
            <h5 class="mb-3"><i class="bi bi-download"></i> Export Data</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.export.bookings') }}" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export Bookings
                </a>
                <a href="{{ route('admin.export.users') }}" class="btn btn-outline-info">
                    <i class="bi bi-people"></i> Export Users
                </a>
                <a href="{{ route('admin.export.revenue') }}" class="btn btn-outline-success">
                    <i class="bi bi-cash-stack"></i> Export Revenue
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
