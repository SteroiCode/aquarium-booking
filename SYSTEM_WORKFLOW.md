# System Workflow - User Booking & Admin Approval

## How It Works

### User Side (Home Website)
**URL:** `http://127.0.0.1:8000/home`

1. User registers/logs in at `/login`
2. User browses aquariums at `/home`
3. User clicks "Book Now" on an aquarium
4. User fills booking form (date, tickets, etc.)
5. User submits booking
6. ✅ Booking created with status: "Pending"
7. User sees "Pending" confirmation page

### Admin Side (Admin Panel)
**URL:** `http://127.0.0.1:8000/admin/dashboard`

1. Admin logs in at `/admin/login`
2. Admin sees dashboard with booking statistics
3. Admin clicks "🎟 Bookings" in sidebar
4. Admin sees list of all bookings with status
5. Admin finds the pending booking
6. Admin clicks "Approve" or "Reject" button
7. ✅ Booking status updated to "Confirmed" or "Cancelled"
8. User can see updated status

## Current Setup

### ✅ User Website (`/home`)
- Users can browse aquariums
- Users can make bookings
- Users see their booking status
- Users CANNOT approve bookings

### ✅ Admin Panel (`/admin`)
- Admins can view all bookings
- Admins can approve/reject bookings
- Admins can manage aquariums
- Admins can view statistics

## Test Accounts

### Regular User
```
Email: user@example.com
Password: password
Login at: /login
Access: Home website only
```

### Admin
```
Email: admin@example.com
Password: password
Login at: /admin/login
Access: Both home website AND admin panel
```

## Complete Workflow Example

### Step 1: User Makes Booking
1. User logs in at `http://127.0.0.1:8000/login`
2. User goes to `http://127.0.0.1:8000/home`
3. User clicks "Book Now" on "Ocean Paradise Aquarium"
4. User fills form:
   - Date: 2026-03-15
   - Adults: 2
   - Children: 1
5. User submits
6. Booking created with status: "Pending"

### Step 2: Admin Approves Booking
1. Admin logs in at `http://127.0.0.1:8000/admin/login`
2. Admin goes to `http://127.0.0.1:8000/admin/bookings`
3. Admin sees the new booking in the list
4. Admin clicks "Approve" button
5. Booking status changes to "Confirmed"

### Step 3: User Sees Confirmation
1. User refreshes their booking page
2. User sees status: "Confirmed"
3. User can view receipt

## Database Flow

```
User makes booking
    ↓
bookings table: status = 'Pending'
    ↓
Admin views bookings
    ↓
Admin clicks approve
    ↓
bookings table: status = 'Confirmed'
    ↓
User sees confirmed booking
```

## Your System is Ready!

✅ Home website for users  
✅ Admin panel for admins  
✅ Users can make bookings  
✅ Admins can approve bookings  
✅ Both work on same server  
✅ Data syncs automatically  

Just run:
```bash
php artisan serve
```

Then:
- Users access: `http://127.0.0.1:8000`
- Admins access: `http://127.0.0.1:8000/admin`

Everything is working as you requested!
