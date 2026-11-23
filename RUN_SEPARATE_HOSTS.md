# Running Admin and User on Different Hosts

## Option 1: Two Different Ports (Easiest)

### Step 1: Run User Website on Port 8000
```bash
php artisan serve --port=8000
```
Access at: `http://127.0.0.1:8000`

### Step 2: Run Admin Panel on Port 8001 (New Terminal)
```bash
php artisan serve --port=8001
```
Access at: `http://127.0.0.1:8001/admin`

**Result:**
- User website: `http://127.0.0.1:8000/home`
- Admin panel: `http://127.0.0.1:8001/admin/dashboard`

**Note:** Both use the same database, so bookings sync automatically!

---

## Option 2: Virtual Hosts (Professional Setup)

### For Windows with XAMPP/WAMP

#### Step 1: Edit hosts file
Open: `C:\Windows\System32\drivers\etc\hosts` (as Administrator)

Add these lines:
```
127.0.0.1    aquarium-user.local
127.0.0.1    aquarium-admin.local
```

#### Step 2: Configure Apache Virtual Hosts
Edit: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

Add:
```apache
# User Website
<VirtualHost *:80>
    ServerName aquarium-user.local
    DocumentRoot "C:/path/to/your/project/public"
    <Directory "C:/path/to/your/project/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

# Admin Panel
<VirtualHost *:80>
    ServerName aquarium-admin.local
    DocumentRoot "C:/path/to/your/project/public"
    <Directory "C:/path/to/your/project/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Step 3: Restart Apache

**Access:**
- User website: `http://aquarium-user.local/home`
- Admin panel: `http://aquarium-admin.local/admin/dashboard`

---

## Option 3: Using Laravel Valet (Mac/Linux)

```bash
# Install Valet
composer global require laravel/valet
valet install

# In your project directory
valet link aquarium-user
valet link aquarium-admin

# Access
# http://aquarium-user.test/home
# http://aquarium-admin.test/admin/dashboard
```

---

## Recommended: Simple Two-Port Setup

**For development, use Option 1 (two ports):**

### Terminal 1 (User Website):
```bash
php artisan serve --port=8000
```

### Terminal 2 (Admin Panel):
```bash
php artisan serve --port=8001
```

### Usage:
- **Users access:** `http://127.0.0.1:8000`
  - Login at: `http://127.0.0.1:8000/login`
  - After login: `http://127.0.0.1:8000/home`

- **Admins access:** `http://127.0.0.1:8001`
  - Login at: `http://127.0.0.1:8001/admin/login`
  - After login: `http://127.0.0.1:8001/admin/dashboard`

**Both share the same:**
- ✅ Database
- ✅ Session storage
- ✅ File uploads
- ✅ Everything syncs automatically!

---

## Important Notes

1. **Same Codebase:** Both ports run the same Laravel application
2. **Same Database:** All data is shared (bookings, users, aquariums)
3. **Different URLs:** Users and admins access different URLs
4. **Sessions:** Each port has separate sessions (users can't accidentally access admin)

---

## Quick Start Commands

```bash
# Terminal 1 - User Website
php artisan serve --port=8000

# Terminal 2 - Admin Panel  
php artisan serve --port=8001
```

Then:
- Give users: `http://127.0.0.1:8000`
- Give admins: `http://127.0.0.1:8001/admin`

Done!
