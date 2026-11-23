<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AquariumController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\FishSpeciesController;
use App\Http\Controllers\Admin\CoralPlantController;
use App\Http\Controllers\Admin\WaterQualityController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\PosController;

/*
|--------------------------------------------------------------------------
| ROOT - Redirect to Login
|--------------------------------------------------------------------------
*/

// Language switcher
Route::get('/lang/{locale}', function ($locale) {
    $locale = in_array($locale, ['en', 'km', 'es', 'zh']) ? $locale : 'en';
    return redirect()->back()->withCookie(cookie()->forever('locale', $locale));
})->name('lang.switch');

// Debug route - remove after testing
Route::get('/lang-test', function () {
    return response()->json([
        'cookie_locale' => request()->cookie('locale'),
        'app_locale'    => app()->getLocale(),
        'translation'   => __('app.home'),
    ]);
});

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin() 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    }
    return redirect()->route('login');
})->middleware('user.session');

/*
|--------------------------------------------------------------------------
| HOME (Requires Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['user.session', 'auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Contact & About Pages
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'sendMessage'])->name('contact.send');
    Route::get('/about', [ContactController::class, 'about'])->name('about');

    // User Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
});

// Debug route - remove after testing
Route::get('/test-auth', function() {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
    ]);
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

// User Authentication
Route::middleware('user.session')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// Admin Authentication (Separate)
Route::prefix('admin')->name('admin.')->middleware('admin.session')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES - Accessible from homepage (Requires Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['user.session', 'auth'])->group(function () {
    Route::get('/fish-species', [FishSpeciesController::class, 'index'])
        ->name('fish_species.index');

    Route::get('/coral-plants', [CoralPlantController::class, 'index'])
        ->name('coral_plants.index');

    Route::get('/water-quality', [WaterQualityController::class, 'index'])
        ->name('water_quality.index');
});

/*
|--------------------------------------------------------------------------
| FRONTEND BOOKING ROUTES (Requires Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['user.session', 'auth'])->group(function () {
    // Static routes MUST come before wildcard {id} routes
    Route::post('/booking/store', [BookingController::class, 'store'])
        ->name('booking.store');

    Route::get('/my-bookings', [BookingController::class, 'history'])
        ->name('booking.history');

    // Generate KHQR string for a given amount (used by booking form JS)
    Route::get('/booking/generate-qr', function () {
        $amount = (float) request('amount', 0);
        $ref    = request('ref', 'BOOKING');

        $bakongAccountID = env('BAKONG_ACCOUNT_ID', 'yourname@wing');
        $merchantName    = env('BAKONG_MERCHANT_NAME', 'Aquarium Booking');
        $merchantCity    = env('BAKONG_MERCHANT_CITY', 'PHNOM PENH');
        $currencyEnv     = strtoupper(env('BAKONG_CURRENCY', 'USD'));
        $currency        = $currencyEnv === 'KHR'
            ? \KHQR\Helpers\KHQRData::CURRENCY_KHR
            : \KHQR\Helpers\KHQRData::CURRENCY_USD;

        try {
            $info = new \KHQR\Models\IndividualInfo(
                $bakongAccountID,
                $merchantName,
                $merchantCity,
                env('BAKONG_ACQUIRING_BANK') ?: null,
                null,
                $currency,
                $amount,
                $ref,
                'AquaDiveDeep'
            );
            $response = \KHQR\BakongKHQR::generateIndividual($info);
            $qrString = $response->data['qr'] ?? null;
        } catch (\Throwable $e) {
            return response()->json(['qr_url' => null, 'error' => $e->getMessage()]);
        }

        $imageUrl = $qrString
            ? 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($qrString)
            : null;

        return response()->json(['qr_url' => $imageUrl]);
    })->name('booking.generateQr');

    // Live status check
    Route::get('/booking/status/{id}', function ($id) {
        $booking = \App\Models\Booking::findOrFail($id);
        if (!auth()->user()->isAdmin() && $booking->user_id !== auth()->id()) {
            abort(403);
        }
        return response()->json(['status' => $booking->status]);
    })->name('booking.status');

    // Wildcard {id} routes LAST
    Route::get('/booking/{id}', [BookingController::class, 'show'])
        ->name('booking.form');

    Route::get('/booking/pending/{id}', [BookingController::class, 'pending'])
        ->name('booking.pending');

    Route::get('/booking/receipt/{id}', [BookingController::class, 'receipt'])
        ->name('booking.receipt');
});

/*
|--------------------------------------------------------------------------
| PAYMENT ROUTES (Requires Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['user.session', 'auth'])->group(function () {
    Route::get('/payment/{bookingId}', [PaymentController::class, 'showPayment'])
        ->name('payment.show');

    Route::post('/payment/{bookingId}/upload', [PaymentController::class, 'uploadProof'])
        ->name('payment.upload');
});

// Bakong Webhook (No auth required - external callback)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])
    ->name('payment.webhook');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

// Redirect /admin to /admin/dashboard
Route::redirect('/admin', '/admin/dashboard')->middleware('admin.session');

Route::prefix('admin')->name('admin.')->middleware(['admin.session', 'auth', 'admin'])->group(function () {

    // Test route
    Route::get('/test', function() {
        return view('admin.test-simple');
    })->name('test');

    // Profile Routes
    Route::get('/profile', [AdminAuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AdminAuthController::class, 'updatePassword'])->name('profile.password');

    // POS System
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
    Route::get('/pos/receipt/{id}', [PosController::class, 'receipt'])->name('pos.receipt');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Booking notification polling
    Route::get('/notifications/latest-booking', function () {
        $latest = \App\Models\Booking::latest()->first();
        return response()->json([
            'latest_id'      => $latest?->id ?? 0,
            'customer_name'  => $latest?->customer_name ?? '',
            'aquarium'       => $latest?->aquarium?->name ?? '',
            'tickets'        => $latest?->tickets ?? 0,
        ]);
    })->name('notifications.latestBooking');

    // Live booking stats
    Route::get('/notifications/booking-stats', function () {
        return response()->json([
            'total'    => \App\Models\Booking::count(),
            'pending'  => \App\Models\Booking::where('status', 'Pending')->count(),
            'confirmed'=> \App\Models\Booking::where('status', 'Confirmed')->count(),
            'revenue'  => \App\Models\Booking::where('payment_status', 'verified')->sum('total_price'),
        ]);
    })->name('notifications.bookingStats');

    // Analytics Routes
    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('analytics.index');
    
    Route::get('/analytics/calendar', [AnalyticsController::class, 'calendar'])
        ->name('analytics.calendar');

    // Export Routes
    Route::get('/export/bookings', [ExportController::class, 'exportBookings'])
        ->name('export.bookings');
    
    Route::get('/export/users', [ExportController::class, 'exportUsers'])
        ->name('export.users');
    
    Route::get('/export/revenue', [ExportController::class, 'exportRevenue'])
        ->name('export.revenue');

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
        ->name('activity_logs.index');

    // System Settings
    Route::get('/settings', [SystemSettingsController::class, 'index'])
        ->name('settings.index');
    
    Route::post('/settings', [SystemSettingsController::class, 'update'])
        ->name('settings.update');
    
    Route::post('/settings/bulk-email', [SystemSettingsController::class, 'sendBulkEmail'])
        ->name('settings.bulk_email');

    Route::get('/bookings', [AdminController::class, 'manageBookings'])
        ->name('bookings.index');

    Route::put('/bookings/{id}/status', [AdminController::class, 'updateStatus'])
        ->name('bookings.updateStatus');
    
    Route::post('/bookings/bulk-update', [AdminController::class, 'bulkUpdateStatus'])
        ->name('bookings.bulkUpdate');

    // Users Management Routes
    Route::get('/users', [AdminController::class, 'manageUsers'])
        ->name('users.index');

    Route::post('/users', [AdminController::class, 'createUser'])
        ->name('users.create');

    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])
        ->name('users.delete');

    Route::put('/users/{id}/role', [AdminController::class, 'updateRole'])
        ->name('users.role');

    Route::get('/users/{id}/bookings', [AdminController::class, 'userBookings'])
        ->name('users.bookings');

    // Payment Verification Routes
    Route::post('/bookings/{id}/verify-payment', [PaymentController::class, 'verifyPayment'])
        ->name('bookings.verifyPayment');

    Route::post('/bookings/{id}/reject-payment', [PaymentController::class, 'rejectPayment'])
        ->name('bookings.rejectPayment');

    // Aquariums Routes
    Route::get('/aquariums', [AquariumController::class, 'index'])
        ->name('aquariums.index');

    Route::get('/aquariums/create', [AquariumController::class, 'create'])
        ->name('aquariums.create');

    Route::post('/aquariums/store', [AquariumController::class, 'store'])
        ->name('aquariums.store');

    Route::get('/aquariums/{id}/edit', [AquariumController::class, 'edit'])
        ->name('aquariums.edit');

    Route::put('/aquariums/{id}', [AquariumController::class, 'update'])
        ->name('aquariums.update');

    Route::delete('/aquariums/{id}', [AquariumController::class, 'destroy'])
        ->name('aquariums.destroy');

    // Fish Species Routes
    Route::get('/fish-species', [FishSpeciesController::class, 'index'])
        ->name('fish_species.index');

    Route::get('/fish-species/create', [FishSpeciesController::class, 'create'])
        ->name('fish_species.create');

    Route::post('/fish-species/store', [FishSpeciesController::class, 'store'])
        ->name('fish_species.store');

    Route::get('/fish-species/{id}/edit', [FishSpeciesController::class, 'edit'])
        ->name('fish_species.edit');

    Route::put('/fish-species/{id}', [FishSpeciesController::class, 'update'])
        ->name('fish_species.update');

    Route::delete('/fish-species/{id}', [FishSpeciesController::class, 'destroy'])
        ->name('fish_species.destroy');

    // Coral & Plants Routes
    Route::get('/coral-plants', [CoralPlantController::class, 'index'])
        ->name('coral_plants.index');

    Route::get('/coral-plants/create', [CoralPlantController::class, 'create'])
        ->name('coral_plants.create');

    Route::post('/coral-plants/store', [CoralPlantController::class, 'store'])
        ->name('coral_plants.store');

    Route::get('/coral-plants/{id}/edit', [CoralPlantController::class, 'edit'])
        ->name('coral_plants.edit');

    Route::put('/coral-plants/{id}', [CoralPlantController::class, 'update'])
        ->name('coral_plants.update');

    Route::delete('/coral-plants/{id}', [CoralPlantController::class, 'destroy'])
        ->name('coral_plants.destroy');

    // Water Quality Routes
    Route::get('/water-quality', [WaterQualityController::class, 'index'])
        ->name('water_quality.index');

    Route::get('/water-quality/create', [WaterQualityController::class, 'create'])
        ->name('water_quality.create');

    Route::post('/water-quality/store', [WaterQualityController::class, 'store'])
        ->name('water_quality.store');

    Route::get('/water-quality/{id}/edit', [WaterQualityController::class, 'edit'])
        ->name('water_quality.edit');

    Route::put('/water-quality/{id}', [WaterQualityController::class, 'update'])
        ->name('water_quality.update');

    Route::delete('/water-quality/{id}', [WaterQualityController::class, 'destroy'])
        ->name('water_quality.destroy');

});