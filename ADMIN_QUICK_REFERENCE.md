# Admin Panel - Quick Reference Card

## 🔗 Direct Links

| Feature | URL | Description |
|---------|-----|-------------|
| Dashboard | `/admin/dashboard` | Main overview with alerts |
| Analytics | `/admin/analytics` | Advanced metrics & charts |
| Calendar | `/admin/analytics/calendar` | Visual booking calendar |
| Bookings | `/admin/bookings` | Manage all bookings |
| Users | `/admin/users` | User management |
| Aquariums | `/admin/aquariums` | Aquarium management |
| Activity Logs | `/admin/activity-logs` | Audit trail |
| Settings | `/admin/settings` | System configuration |

---

## 📊 Dashboard Alerts

| Alert Color | Meaning | Action |
|-------------|---------|--------|
| 🟡 Yellow | Pending payment verifications | Click "Review Now" |
| 🔴 Red | Rejected payments | Click "View Details" |
| 🔵 Blue | Low-performing aquariums | Click "View Aquariums" |

---

## 🔍 Booking Filters

```
Search: Name, Email, or ID
Status: Pending / Confirmed / Cancelled
Payment: Verified / Pending / Rejected
Date Range: From → To
```

---

## ☑️ Bulk Actions

1. ✅ Check boxes next to bookings
2. 📋 Select action from dropdown
3. ✨ Click "Apply"

**Available Actions:**
- Mark as Confirmed
- Mark as Cancelled  
- Mark as Pending

---

## 📥 Export Options

| Export Type | Includes |
|-------------|----------|
| Bookings | ID, Customer, Aquarium, Date, Tickets, Price, Status, Payment |
| Users | ID, Name, Email, Booking Count, Registration Date |
| Revenue | Date, Booking ID, Aquarium, Customer, Amount, Payment Method |

**Format:** CSV (Excel compatible)

---

## ⚙️ System Settings

### Booking Rules
- `max_tickets_per_booking` - Default: 10
- `advance_booking_days` - Default: 30
- `booking_cancellation_hours` - Default: 24

### Business Hours
- `business_hours_start` - Default: 09:00
- `business_hours_end` - Default: 18:00

### Contact
- `contact_email`
- `contact_phone`
- `site_name`
- `site_logo`

---

## 📊 Analytics Metrics

### KPIs
- Customer Retention Rate (%)
- Average Booking Value ($)
- Cancellation Rate (%)
- Total Customers

### Charts
- Peak Booking Hours (Bar)
- Day of Week Analysis (Doughnut)
- Monthly Trends (Line)
- Top 10 Aquariums (Table)

---

## 📧 Bulk Email

**Recipient Types:**
- All Users
- Active Users (with bookings)
- Inactive Users (no bookings)

**Fields:**
- Subject (required)
- Message (required)
- Recipient Type (required)

---

## 💳 Payment Verification

**Statuses:**
- ✅ Verified - Payment confirmed
- ⏳ Pending - Awaiting review
- ❌ Rejected - Payment declined
- ⚪ Unpaid - No payment yet

**Quick Actions:**
- View payment proof image
- Verify payment (green button)
- Reject payment (red button)

---

## 📋 Activity Log Actions

| Action | Description |
|--------|-------------|
| `create` | New record created |
| `update` | Record modified |
| `delete` | Record removed |
| `export` | Data exported |
| `bulk_update` | Multiple records updated |
| `email` | Bulk email sent |

---

## 🎯 Keyboard Shortcuts

| Action | Shortcut |
|--------|----------|
| Select All Bookings | Click "Select All" checkbox |
| Clear Filters | Refresh page |
| Quick Search | Focus search box |

---

## 🔧 Common Tasks

### Verify a Payment
1. Go to Bookings
2. Find booking with "Pending" payment
3. Click "View" to see proof
4. Click green ✓ to verify OR red ✗ to reject

### Export Filtered Data
1. Go to Bookings
2. Apply filters (status, date, etc.)
3. Click "Export" button
4. CSV downloads automatically

### Send Bulk Email
1. Go to Settings
2. Scroll to "Bulk Email" section
3. Select recipient type
4. Enter subject and message
5. Click "Send Email"

### View Analytics
1. Go to Analytics
2. Review KPIs at top
3. Scroll through charts
4. Click "Calendar View" for visual schedule

### Check Activity Logs
1. Go to Activity Logs
2. Filter by action, user, or date
3. Click eye icon to view change details
4. Use for troubleshooting or audits

---

## 🚨 Troubleshooting

| Issue | Solution |
|-------|----------|
| No data in analytics | Create some bookings first |
| Export not downloading | Check browser popup blocker |
| Calendar not loading | Check internet connection (uses CDN) |
| Settings not saving | Check form validation errors |
| Activity logs empty | Perform some actions first |

---

## 📱 Mobile Responsive

All admin features work on:
- ✅ Desktop (1920x1080+)
- ✅ Laptop (1366x768+)
- ✅ Tablet (768x1024+)
- ⚠️ Mobile (limited - use desktop for best experience)

---

## 🔐 Security Notes

- All actions are logged with user ID and IP
- Activity logs cannot be deleted
- Exports are logged for compliance
- Settings changes are tracked
- Bulk actions require confirmation

---

## 💡 Best Practices

1. **Check dashboard alerts daily** - Stay on top of pending tasks
2. **Review activity logs weekly** - Monitor admin actions
3. **Export data monthly** - Keep backup records
4. **Update settings as needed** - Adjust booking rules seasonally
5. **Use analytics for decisions** - Data-driven management
6. **Verify payments promptly** - Better customer experience
7. **Use bulk actions carefully** - Always double-check selection

---

## 📞 Need Help?

1. Check `ADMIN_PANEL_FEATURES.md` for detailed documentation
2. Review activity logs for error tracking
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify database migrations: `php artisan migrate:status`

---

**Quick Start Checklist:**
- ✅ Migrations run
- ✅ Settings seeded
- ✅ Routes configured
- ✅ Views created
- ✅ Controllers ready
- ✅ Models defined

**You're all set! 🚀**
