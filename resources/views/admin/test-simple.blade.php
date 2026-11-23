<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <style>
        body { background: #1e293b; color: white; padding: 50px; }
    </style>
</head>
<body>
    <h1>TEST PAGE - If you see this, views are working!</h1>
    <p>User: {{ auth()->user()->name }}</p>
    <p>Is Admin: {{ auth()->user()->isAdmin() ? 'YES' : 'NO' }}</p>
    <hr>
    <h2>Database Connection Test:</h2>
    <p>Total Aquariums: {{ \App\Models\Aquarium::count() }}</p>
    <p>Total Bookings: {{ \App\Models\Booking::count() }}</p>
</body>
</html>
