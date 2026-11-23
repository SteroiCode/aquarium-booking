<!DOCTYPE html>
<html>
<head>
    <title>Test Page</title>
</head>
<body>
    <h1>Admin Test Page</h1>
    <p>If you see this, the view is working!</p>
    <p>User: {{ auth()->user()->name ?? 'Not logged in' }}</p>
    <p>Is Admin: {{ auth()->user()->isAdmin() ? 'Yes' : 'No' }}</p>
</body>
</html>
