# Quick Fix for Readable Tables

Add this CSS to your admin layout file AFTER the Bootstrap link:

```html
<style>
/* FORCE WHITE BACKGROUND AND BLACK TEXT FOR TABLES */
.table-container { 
    background: #ffffff !important; 
    border: 3px solid #0ea5e9 !important; 
}

.table { 
    background: #ffffff !important;
    color: #000000 !important; 
}

.table thead { 
    background: linear-gradient(135deg, #0ea5e9, #06b6d4) !important; 
}

.table thead th { 
    color: #ffffff !important; 
    font-weight: 700 !important;
    font-size: 16px !important;
}

.table tbody tr { 
    background: #ffffff !important; 
}

.table tbody tr:hover { 
    background: #f3f4f6 !important; 
}

.table tbody td { 
    color: #000000 !important; 
    font-weight: 600 !important;
    font-size: 16px !important;
}

.table tbody td * {
    color: #000000 !important;
}

.table-striped tbody tr:nth-of-type(odd) { 
    background: #f9fafb !important; 
}

/* BADGES - KEEP COLORED */
.badge { 
    color: #ffffff !important; 
}
</style>
```

This will give you:
- WHITE background for all tables
- BLACK text that's easy to read
- Cyan header with white text
- Gray hover effect
- All text forced to be visible with !important
