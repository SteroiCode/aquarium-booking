# Bakong KHQR Payment Integration - Complete Guide

## ✅ What's Been Implemented

Your Bakong KHQR payment system is now fully integrated! Here's what works:

### 1. Payment Flow
- After booking, users are redirected to payment page
- QR code is generated with booking details
- Users scan with their banking app (ABA, ACLEDA, Wing, etc.)
- Users upload payment screenshot as proof
- Admin verifies payment and confirms booking

### 2. User Features
- **Payment Page**: Shows KHQR code with booking details
- **Upload Proof**: Users can upload payment screenshot
- **Transaction ID**: Optional field for transaction reference
- **Receipt**: Shows payment status and details
- **Booking History**: Shows payment status for all bookings

### 3. Admin Features
- **Payment Verification**: View payment proofs
- **Approve/Reject**: Verify or reject payments
- **Payment Status**: Track all payment statuses
- **Auto-Confirm**: Booking auto-confirms when payment verified

## 🔄 Complete User Journey

### Step 1: User Books Aquarium
1. User selects aquarium and fills booking form
2. Booking is created with status "Pending"
3. User redirected to pending page

### Step 2: User Proceeds to Payment
1. On pending page, user clicks "Proceed to Payment"
2. Payment page shows:
   - Booking reference (e.g., AQ-000001)
   - KHQR code to scan
   - Payment instructions
   - Upload form for payment proof

### Step 3: User Pays
1. User opens banking app (ABA, ACLEDA, Wing, etc.)
2. Scans the KHQR code
3. Confirms payment amount
4. Takes screenshot of successful transaction
5. Uploads screenshot on payment page
6. Optionally enters transaction ID

### Step 4: Admin Verifies
1. Admin sees booking with "Pending Verification" status
2. Admin clicks "View Proof" to see screenshot
3. Admin verifies payment is legitimate
4. Admin clicks "✓ Verify Payment"
5. Booking status changes to "Confirmed"
6. User can now view receipt

## 📁 Files Modified/Created

### Routes (routes/web.php)
```php
// Payment routes added
Route::get('/payment/{bookingId}', [PaymentController::class, 'showPayment'])
Route::post('/payment/{bookingId}/upload', [PaymentController::class, 'uploadProof'])
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])

// Admin payment verification routes
Route::post('/bookings/{id}/verify-payment', [PaymentController::class, 'verifyPayment'])
Route::post('/bookings/{id}/reject-payment', [PaymentController::class, 'rejectPayment'])
```

### Controller (app/Http/Controllers/PaymentController.php)
- `showPayment()`: Displays KHQR payment page
- `uploadProof()`: Handles payment screenshot upload
- `verifyPayment()`: Admin verifies payment
- `rejectPayment()`: Admin rejects payment
- `generateKHQR()`: Generates QR code data
- `webhook()`: Placeholder for Bakong API webhook

### Views Updated
1. **resources/views/payment/khqr.blade.php**
   - Shows KHQR code
   - Upload form for payment proof
   - Payment instructions

2. **resources/views/booking/pending.blade.php**
   - Added "Proceed to Payment" button
   - Removed auto-refresh (no longer needed)

3. **resources/views/booking/receipt.blade.php**
   - Added payment information section
   - Shows payment status, method, transaction ID

4. **resources/views/booking/history.blade.php**
   - Shows payment status badges
   - "Pay Now" button for unpaid bookings
   - "View Payment Status" for pending verification

5. **resources/views/admin/bookings/index.blade.php**
   - Added payment status column
   - "View Proof" link to see screenshots
   - "Verify Payment" and "Reject Payment" buttons

## 🗄️ Database Fields Used

The `bookings` table already has these fields (from migration):
- `payment_method`: Payment method used (e.g., "Bakong KHQR")
- `payment_status`: Status (null, pending_verification, verified, rejected)
- `payment_proof`: Path to uploaded screenshot
- `transaction_id`: Transaction reference from banking app
- `paid_at`: Timestamp when payment was made

## 🚀 How to Test

### Test as User:
1. Login as regular user
2. Book an aquarium
3. Click "Proceed to Payment"
4. See the KHQR code
5. Upload a test image as payment proof
6. Check "My Bookings" to see status

### Test as Admin:
1. Login as admin (admin@admin.com / password)
2. Go to "Manage Bookings"
3. See bookings with "Pending Verification" status
4. Click "View Proof" to see uploaded screenshot
5. Click "✓ Verify Payment" to approve
6. Booking status changes to "Confirmed"

## 🔧 Current Implementation (Demo Mode)

Right now, the system uses:
- **QR Code API**: Free service (api.qrserver.com) to generate QR codes
- **Mock KHQR**: Simulated KHQR format (not real Bakong API)
- **Manual Verification**: Admin manually checks payment screenshots

This is perfect for:
- University projects
- Demonstrations
- Testing the flow
- Development

## 🏦 Upgrading to Real Bakong API

When you get real Bakong merchant credentials:

### Step 1: Get Credentials
Register at: https://www.nbc.gov.kh/
You'll receive:
- Merchant ID
- API Key
- API Secret

### Step 2: Add to .env
```env
BAKONG_MERCHANT_ID=your_merchant_id
BAKONG_API_KEY=your_api_key
BAKONG_API_SECRET=your_api_secret
BAKONG_ENVIRONMENT=sandbox
```

### Step 3: Install Bakong SDK
```bash
composer require bakong/khqr-sdk
```

### Step 4: Update PaymentController
Replace the `generateKHQR()` method to use real Bakong API:
```php
use Bakong\KHQR\Client;

private function generateKHQR($booking)
{
    $client = new Client([
        'merchant_id' => config('services.bakong.merchant_id'),
        'api_key' => config('services.bakong.api_key'),
    ]);
    
    $qr = $client->generateQR([
        'amount' => $booking->total_price,
        'currency' => 'USD',
        'reference' => 'AQ-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
    ]);
    
    return [
        'qr_code_url' => $qr->getImageUrl(),
        'amount' => $booking->total_price,
        // ... rest of data
    ];
}
```

### Step 5: Enable Webhook
Update the `webhook()` method to handle real Bakong callbacks:
```php
public function webhook(Request $request)
{
    // Verify webhook signature
    $signature = $request->header('X-Bakong-Signature');
    
    if (!$this->verifySignature($signature, $request->all())) {
        return response()->json(['error' => 'Invalid signature'], 401);
    }
    
    // Process payment
    $transactionId = $request->input('transaction_id');
    $status = $request->input('status');
    $reference = $request->input('reference');
    
    if ($status === 'success') {
        $bookingId = (int) str_replace('AQ-', '', $reference);
        $booking = Booking::find($bookingId);
        
        if ($booking) {
            $booking->update([
                'payment_status' => 'verified',
                'transaction_id' => $transactionId,
                'paid_at' => now(),
                'status' => 'Confirmed'
            ]);
        }
    }
    
    return response()->json(['status' => 'ok']);
}
```

## 📊 Payment Status Flow

```
User Books → Pending (no payment)
    ↓
User Pays & Uploads Proof → Pending Verification
    ↓
Admin Verifies → Verified → Booking Confirmed ✅
    OR
Admin Rejects → Rejected → User can retry ❌
```

## 🎯 Key Features

✅ QR code generation with booking details
✅ Payment proof upload
✅ Admin verification system
✅ Payment status tracking
✅ Transaction ID recording
✅ Automatic booking confirmation
✅ Payment history in user dashboard
✅ Payment status in admin panel
✅ Receipt with payment details
✅ Webhook endpoint for future API integration

## 💡 Tips

1. **For Demo**: Current implementation is perfect - no API needed
2. **For Production**: Follow upgrade steps when you have Bakong credentials
3. **Testing**: Use any image as payment proof for testing
4. **Admin Access**: admin@admin.com / password
5. **Storage**: Payment proofs saved in `storage/app/public/payment_proofs`

## 🔐 Security Notes

- User can only access their own bookings
- Payment proofs are validated (image, max 2MB)
- Admin authentication required for verification
- Webhook signature verification (when using real API)

## 📞 Support

If you need help:
1. Check this guide first
2. Test the flow step by step
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify file permissions for uploads

## ✨ What's Next?

Your payment system is complete! You can now:
1. Test the entire booking → payment → verification flow
2. Demonstrate to your professor/client
3. Add more features if needed (email notifications, SMS, etc.)
4. Upgrade to real Bakong API when ready

Enjoy your fully functional aquarium booking system with Bakong KHQR payments! 🐠💳
