# How to Update Contact & About Information

## 📍 Quick Guide to Customize Your Information

---

## 1. Update Contact Information

### Option A: Through Admin Panel (Recommended)
1. Login to admin panel: `/admin/login`
2. Go to **Settings** page
3. Update the following fields:
   - Site Name
   - Contact Email
   - Contact Phone
   - Business Hours

### Option B: Directly in Database
Run these SQL commands or use phpMyAdmin:

```sql
UPDATE system_settings SET value = 'Your Aquarium Name' WHERE key = 'site_name';
UPDATE system_settings SET value = 'your@email.com' WHERE key = 'contact_email';
UPDATE system_settings SET value = '+855 12 345 678' WHERE key = 'contact_phone';
UPDATE system_settings SET value = '09:00' WHERE key = 'business_hours_start';
UPDATE system_settings SET value = '18:00' WHERE key = 'business_hours_end';
```

---

## 2. Update Google Maps Location

### Step-by-Step:

1. **Go to Google Maps**
   - Visit: https://www.google.com/maps

2. **Find Your Location**
   - Search for your aquarium address
   - Click on the location marker

3. **Get Embed Code**
   - Click "Share" button
   - Select "Embed a map" tab
   - Copy the `<iframe>` code

4. **Update in Your Code**
   - Open file: `resources/views/contact.blade.php`
   - Find line ~150 (the iframe section)
   - Replace the entire `<iframe>` tag with your copied code

### Current Map Location:
```
Phnom Penh, Cambodia (Default)
```

### Example Embed Code:
```html
<iframe 
    src="https://www.google.com/maps/embed?pb=YOUR_EMBED_CODE_HERE" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy">
</iframe>
```

---

## 3. Update Address in Contact Page

**File:** `resources/views/contact.blade.php`

**Find this section (around line 30):**
```html
<p class="text-muted mb-0">
    123 Ocean Boulevard<br>
    Phnom Penh, Cambodia<br>
    12000
</p>
```

**Replace with your address:**
```html
<p class="text-muted mb-0">
    Your Street Address<br>
    Your City, Your Country<br>
    Your Postal Code
</p>
```

---

## 4. Update About Us Content

**File:** `resources/views/about.blade.php`

### Update Company Story (Line ~15)
```html
<p class="text-muted">
    Founded in 2020, {{ $siteName }} has become...
    [Replace with your story]
</p>
```

### Update Statistics (Line ~80)
```html
<div class="display-4 fw-bold text-primary">10K+</div>
<p class="text-muted mb-0">Marine Animals</p>
```
Change numbers to match your aquarium.

### Update Team Members (Line ~150)
```html
<h5 class="mb-1">Dr. Sophea Chan</h5>
<p class="text-muted small mb-2">Director & Marine Biologist</p>
```
Replace with your actual team members.

### Update Achievements (Line ~220)
```html
<h5>Best Aquarium in Southeast Asia 2024</h5>
<p class="text-muted mb-0">Awarded by International Aquarium Association</p>
```
Replace with your actual achievements.

---

## 5. Update Social Media Links

**File:** `resources/views/contact.blade.php` (Line ~90)

```html
<a href="#" class="btn btn-outline-primary btn-sm">
    <i class="bi bi-facebook"></i>
</a>
```

**Replace `#` with your social media URLs:**
```html
<a href="https://facebook.com/yourpage" class="btn btn-outline-primary btn-sm">
    <i class="bi bi-facebook"></i>
</a>
<a href="https://twitter.com/yourhandle" class="btn btn-outline-info btn-sm">
    <i class="bi bi-twitter"></i>
</a>
<a href="https://instagram.com/yourhandle" class="btn btn-outline-danger btn-sm">
    <i class="bi bi-instagram"></i>
</a>
```

---

## 6. Update Images

### Hero Image (About Page)
**File:** `resources/views/about.blade.php` (Line ~12)

```html
<img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&h=600&fit=crop" 
     alt="Aquarium" class="img-fluid rounded shadow">
```

**Replace with your image:**
```html
<img src="{{ asset('images/your-aquarium.jpg') }}" 
     alt="Your Aquarium" class="img-fluid rounded shadow">
```

**To add your own images:**
1. Place images in `public/images/` folder
2. Reference them using `{{ asset('images/filename.jpg') }}`

---

## 7. Update FAQ Section

**File:** `resources/views/contact.blade.php` (Line ~180)

```html
<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
    What are your visiting hours?
</button>
```

**Add/Edit/Remove FAQ items:**
- Copy an entire `<div class="accordion-item">` block
- Change the question and answer
- Update the `data-bs-target` ID to be unique (faq1, faq2, etc.)

---

## 8. Update Contact Form Email Destination

**File:** `app/Http/Controllers/ContactController.php`

Currently, the form just shows a success message. To actually send emails:

```php
public function sendMessage(Request $request)
{
    $validated = $request->validate([...]);

    // Add email sending code here
    Mail::to('your@email.com')->send(new ContactMessage($validated));

    return back()->with('success', 'Thank you for your message!');
}
```

---

## 9. Quick Customization Checklist

- [ ] Update site name in Admin Settings
- [ ] Update contact email and phone
- [ ] Update business hours
- [ ] Change Google Maps location
- [ ] Update physical address
- [ ] Update company story in About page
- [ ] Update statistics (animals, species, visitors)
- [ ] Update team member names and roles
- [ ] Update achievements and awards
- [ ] Add your social media links
- [ ] Replace placeholder images
- [ ] Customize FAQ questions and answers
- [ ] Test contact form submission

---

## 10. Testing Your Changes

After making updates:

1. **Clear Cache:**
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

2. **Test Pages:**
- Visit `/contact` - Check all information displays correctly
- Visit `/about` - Verify content is updated
- Test contact form submission
- Check map loads correctly
- Verify social media links work

3. **Mobile Testing:**
- Open pages on mobile device
- Check responsive layout
- Test form on mobile

---

## 11. Common Issues & Solutions

### Map Not Loading
- Check if iframe code is complete
- Verify no extra quotes or brackets
- Ensure internet connection (map loads from Google)

### Contact Form Not Working
- Check validation rules in controller
- Verify route is registered
- Check for JavaScript errors in browser console

### Images Not Showing
- Verify image path is correct
- Check file exists in `public/images/`
- Run `php artisan storage:link` if using storage

### Settings Not Saving
- Check database connection
- Verify `system_settings` table exists
- Check for validation errors

---

## 12. File Locations Reference

```
Contact Page:
└── resources/views/contact.blade.php

About Page:
└── resources/views/about.blade.php

Contact Controller:
└── app/Http/Controllers/ContactController.php

System Settings:
└── Admin Panel → Settings
└── Database: system_settings table

Images:
└── public/images/

Routes:
└── routes/web.php
```

---

## 13. Default Fake Information Provided

### Contact Details:
- **Address:** 123 Ocean Boulevard, Phnom Penh, Cambodia 12000
- **Phone:** +855 23 456 789, +855 12 345 678
- **Email:** info@oceanblue.com, support@oceanblue.com
- **Hours:** Mon-Fri 9:00-18:00, Sat 10:00-20:00, Sun 10:00-18:00

### About Information:
- **Founded:** 2020
- **Animals:** 10,000+
- **Species:** 500+
- **Aquarium Zones:** 12
- **Annual Visitors:** 100,000+

### Team Members:
- Dr. Sophea Chan - Director & Marine Biologist
- Virak Phan - Head of Conservation
- Sreymom Lim - Education Coordinator
- Dara Sok - Operations Manager

### Achievements:
- Best Aquarium in Southeast Asia 2024
- Conservation Excellence Award 2023
- TripAdvisor Certificate of Excellence
- Green Tourism Certification

---

## 14. Pro Tips

1. **Use Admin Panel First** - Update basic info through settings before editing files
2. **Backup Before Editing** - Copy files before making changes
3. **Test Locally** - Make changes on local environment first
4. **Use Version Control** - Commit changes to git
5. **Keep It Real** - Use actual information, not fake data in production
6. **Optimize Images** - Compress images before uploading
7. **Mobile First** - Always check mobile view
8. **SEO Friendly** - Use descriptive alt text for images

---

## Need Help?

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify file permissions
4. Clear all caches
5. Check database connection

---

**Last Updated:** March 12, 2026
**Version:** 1.0.0
