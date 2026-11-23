# Login System - Simple Summary

## How It Works

### User Login
1. Go to: `/login`
2. Enter user credentials
3. ✅ **Redirects to: `/home` (web)**

### Admin Login
1. Go to: `/admin/login` (or `/login`)
2. Enter admin credentials
3. ✅ **Redirects to: `/admin/dashboard`**

## Test Accounts

### Regular User
```
Email: user@example.com
Password: password
Login at: /login
Goes to: /home (web)
```

### Admin
```
Email: admin@example.com
Password: password
Login at: /admin/login
Goes to: /admin/dashboard
```

## Access Rules

| User Type | Can Access Web (/home) | Can Access Dashboard (/admin) |
|-----------|------------------------|-------------------------------|
| User      | ✅ Yes                 | ❌ No                         |
| Admin     | ✅ Yes                 | ✅ Yes                        |

## That's It!

The system is already working as you requested:
- Users → Web
- Admins → Dashboard

Both can logout and login as different accounts anytime.
