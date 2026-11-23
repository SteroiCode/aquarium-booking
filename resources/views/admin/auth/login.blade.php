<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Aquarium Booking</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .login-header h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .login-body {
            padding: 2.5rem 2rem;
            color: #e2e8f0;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            color: white;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
            color: white;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .btn-login {
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            border: none;
            border-radius: 12px;
            padding: 0.875rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
        }

        .test-credentials {
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <h2><i class="bi bi-shield-lock"></i> Admin Login</h2>
        <p>Access the administration panel</p>
    </div>

    <div class="login-body">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> <strong>Error!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" id="adminLoginForm">
            @csrf

            <div class="mb-3">
                <label class="form-label"><i class="bi bi-envelope"></i> Admin Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', 'admin@admin.com') }}" required placeholder="admin@admin.com" autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="bi bi-key"></i> Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Enter password">
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember" style="color: #94a3b8;">Remember me</label>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Login to Admin Panel
            </button>
        </form>

        <div class="text-center mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
            <p class="text-muted mb-2">Not an admin?</p>
            <a href="{{ route('login') }}" style="color: #0ea5e9; text-decoration: none;">
                <i class="bi bi-arrow-left"></i> Go to User Login
            </a>
        </div>

        <div class="test-credentials">
            <p class="mb-1" style="color: #0ea5e9; font-weight: 600;">
                <i class="bi bi-key-fill"></i> Test Admin Account:
            </p>
            <p class="mb-0 small">Email: admin@admin.com</p>
            <p class="mb-0 small">Password: password</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Debug: Check if CSRF token exists
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('input[name="_token"]');
        if (!csrfToken) {
            console.error('CSRF token not found!');
        } else {
            console.log('CSRF token found:', csrfToken.value.substring(0, 10) + '...');
        }

        // Add form submit handler for debugging
        const form = document.getElementById('adminLoginForm');
        form.addEventListener('submit', function(e) {
            console.log('Form submitting...');
            console.log('Action:', form.action);
            console.log('Method:', form.method);
        });
    });
</script>
</body>
</html>
