# How the Login System Works

## Overview
This system uses **single authentication** - one user logged in at a time, but with **role-based access**.

## User Types

### 1. Admin Users (role = 'admin')
**Can access:**
- ✅ Admin Dashboard: `/admin/dashboard`
- ✅ Admin Panel: All admin features
- ✅ User Website: `/home`
- ✅ Make Bookings: Like a regular user
- ✅ View all content

**Login Options:**
- Login at `/login` → Redirects to admin dashboard
- Login at `/admin/login` → Redirects to admin dashboard

### 2. Regular Users (role = 'user')
**Can access:**
- ✅ User Website: `/home`
- ✅ Make Bookings
- ✅ View aquariums, fish, coral, water quality
- ❌ Cannot access admin panel

**Login Options:**
- Login at `/login` → Redirects to home page
- Cannot login at `/admin/login` (admin only)

## How It Works

### When you open the website (`/`)
1. If not logged in → Redirects to `/login`
2. If logged in as admin → Redirects to `/admin/dashboard`
3. If logged in as user → Redirects to `/home`

### Navigation for Admins
When logged in as admin, you'll see:
- **In Admin Panel:** Link to "View Website" (opens user view)
- **In User Website:** Link to "Admin" (goes to dashboard)

### Navigation for Regular Users
When logged in as regular user, you'll see:
- **In User Website:** Only "Home" and "Logout"
- No admin links

## Why You DON'T Need to Logout

**Scenario:** You're logged in as admin

✅ **You can:**
- Go to `/admin/dashboard` (admin panel)
- Click "View Website" to see `/home` (user view)
- Make bookings as a user
- Switch between admin and user views freely
- All while staying logged in as the same admin account

❌ **You CANNOT:**
- Be logged in as two different people at once
- Login as admin AND user simultaneously
- That would require separate sessions (not standard)

## Testing

### Test Admin Account
```
Email: admin@example.com
Password: password
```

**What to test:**
1. Login at `/login` or `/admin/login`
2. You'll be at `/admin/dashboard`
3. Click "View Website" in sidebar
4. You'll see `/home` with all aquariums
5. You can make bookings
6. Click "Admin" in navbar to go back to dashboard
7. **No logout needed!**

### Test Regular User Account
```
Email: user@example.com
Password: password
```

**What to test:**
1. Login at `/login`
2. You'll be at `/home`
3. You can browse and make bookings
4. Try to access `/admin/dashboard` → You'll get 403 Forbidden
5. No admin links visible

## Summary

**You DON'T need to logout!** 

- Admins have access to BOTH admin panel and user website
- Just use the navigation links to switch between views
- You stay logged in as the same admin account
- Regular users only see the user website

The system is working correctly - admins are meant to access both areas!
