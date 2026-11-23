# Bakong KHQR Testing Checklist

## ✅ Quick Test Guide

### Prerequisites
- [ ] Server is running (`php artisan serve`)
- [ ] Database is set up
- [ ] Storage link created (`php artisan storage:link`)
- [ ] You have both user and admin accounts

### Test 1: User Payment Flow

1. **Login as User**
   - [ ] Go to http://localhost:8000
   - [ ] Login with your user account

2. **Make a Booking**
   - [ ] Click on an aquarium
   - [ ] Fill booking form
   - [ ] Submit booking
   - [ ] You should see "Booking Submitted Successfully" page

3. **Proceed to Payment**
   - [ ] Click "Proceed to Payment" button
   - [ ] You should see the KHQR payment page
   - [ ] Verify QR code is displayed
   - [ ] Verify booking details are correct

4. **Upload Payment Proof**
   - [ ] Prepare any test image (screenshot, photo, etc.)
   - [ ] Optionally enter a transaction ID (e.g., "TEST123456")
   - [ ] Select the image file
   - [ ] Click "Upload & Submit"
   - [ ] You should be redirected to receipt page
   - [ ] Verify payment status shows "Pending Verification"

5. **Check Booking History**
   - [ ] Go to "My Bookings" from navigation
   - [ ] Find your booking
   - [ ] Verify it shows "⏳ Verifying Payment" badge
   - [ ] Click "View Payment Status"
   - [ ] Verify receipt shows payment information

### Test 2: Admin Verification Flow

1. **Login as Admin**
   - [ ] Logout from user account
   - [ ] Go to http://localhost:8000/admin/login
   - [ ] Login with: admin@admin.com / password

2. **View Bookings**
   - [ ] Go to "Manage Bookings"
   - [ ] Find the booking you just created
   - [ ] Verify it shows in the list

3. **Check Payment Status**
   - [ ] Look at "Payment Status" column
   - [ ] Should show "⏳ Pending" badge
   - [ ] Click "View Proof" link
   - [ ] New tab opens showing the uploaded image

4. **Verify Payment**
   - [ ] Click "✓ Verify Payment" button
   - [ ] Page refreshes
   - [ ] Payment status changes to "✓ Verified"
   - [ ] Booking status changes to "Confirmed"

### Test 3: User Sees Confirmation

1. **Back to User Account**
   - [ ] Logout from admin
   - [ ] Login as user again

2. **Check Updated Status**
   - [ ] Go to "My Bookings"
   - [ ] Find your booking
   - [ ] Should show "✅ Confirmed" and "💳 Paid" badges
   - [ ] Click "View Receipt"
   - [ ] Verify payment status shows "✓ Verified"
   - [ ] Verify transaction ID is displayed
   - [ ] Verify payment date is shown

### Test 4: Payment Rejection (Optional)

1. **Make Another Booking**
   - [ ] Create a new booking as user
   - [ ] Upload payment proof

2. **Reject Payment as Admin**
   - [ ] Login as admin
   - [ ] Find the new booking
   - [ ] Click "✗ Reject Payment"
   - [ ] Confirm rejection
   - [ ] Payment status changes to "Rejected"
   - [ ] Booking status changes to "Cancelled"

3. **User Sees Rejection**
   - [ ] Login as user
   - [ ] Go to "My Bookings"
   - [ ] Should show "❌ Payment Rejected" badge
   - [ ] Can click "Retry Payment" to try again

## 🐛 Common Issues & Solutions

### Issue: QR Code Not Showing
**Solution**: Check internet connection (QR code uses external API)

### Issue: Image Upload Fails
**Solution**: 
```bash
php artisan storage:link
chmod -R 775 storage
```

### Issue: "Unauthorized access" Error
**Solution**: Make sure you're logged in and accessing your own bookings

### Issue: Payment Proof Link Shows 404
**Solution**: 
```bash
php artisan storage:link
```

### Issue: Routes Not Found
**Solution**: 
```bash
php artisan route:clear
php artisan cache:clear
```

## 📸 What to Look For

### Payment Page Should Show:
- ✅ Booking reference (e.g., AQ-000001)
- ✅ QR code image (400x400px)
- ✅ Merchant name
- ✅ Total amount
- ✅ Payment instructions
- ✅ Upload form

### Admin Panel Should Show:
- ✅ Payment Status column
- ✅ "View Proof" link (when proof uploaded)
- ✅ "Verify Payment" button (when pending)
- ✅ "Reject Payment" button (when pending)

### Receipt Should Show:
- ✅ Payment Information section
- ✅ Payment Method: "Bakong KHQR"
- ✅ Payment Status badge
- ✅ Transaction ID (if provided)
- ✅ Payment Date

## ✨ Success Criteria

Your KHQR integration is working if:
1. ✅ Users can see QR code after booking
2. ✅ Users can upload payment proof
3. ✅ Admin can view uploaded proofs
4. ✅ Admin can verify/reject payments
5. ✅ Booking auto-confirms after verification
6. ✅ Payment status shows correctly everywhere
7. ✅ Receipt displays payment information

## 🎯 Next Steps After Testing

Once everything works:
1. Test with multiple bookings
2. Test with different image formats (JPG, PNG)
3. Test with large images (should be under 2MB)
4. Show to your professor/client
5. Consider adding email notifications
6. Plan for real Bakong API integration (if needed)

## 📝 Notes

- Test images can be any JPG/PNG under 2MB
- Transaction ID is optional
- Payment proofs stored in: `storage/app/public/payment_proofs`
- Admin can verify multiple payments at once
- Users can only see their own bookings

Happy Testing! 🚀
