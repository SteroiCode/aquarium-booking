@extends('layout')

@section('title', 'Login')

@section('hero')
<div class="hero" style="padding: 80px 0;">
    <h1 class="display-5 fw-bold">Welcome to AquaDiveDeep</h1>
    <p class="lead">Please login to explore our aquarium experiences</p>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                
                <!-- Card Header with Ocean Gradient -->
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <h3 class="mb-0 fw-bold">🐠 Login to Your Account</h3>
                </div>

                <div class="card-body p-5" style="background: rgba(255,255,255,0.95);">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('message'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="bi bi-info-circle"></i> {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="bi bi-exclamation-triangle"></i> Oops!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info border-0" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                        <strong>🔐 Login Required</strong>
                        <p class="mb-0 small mt-1">You must login to access the aquarium booking system.</p>
                        <p class="mb-0 small">Don't have an account? <a href="{{ route('register') }}" class="fw-bold" style="color: #667eea;">Register here</a></p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-dark">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   class="form-control form-control-lg"
                                   style="border-radius: 10px; border: 2px solid #e0e0e0;"
                                   placeholder="your@email.com">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required
                                   class="form-control form-control-lg"
                                   style="border-radius: 10px; border: 2px solid #e0e0e0;"
                                   placeholder="Enter your password">
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember" style="border-radius: 5px;">
                            <label class="form-check-label text-dark" for="remember">
                                Remember me for 30 days
                            </label>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 text-white fw-bold" 
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 10px; padding: 12px;">
                            <i class="bi bi-box-arrow-in-right"></i> Login Now
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-2">Don't have an account?</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg w-100" style="border-radius: 10px; border-width: 2px;">
                            <i class="bi bi-person-plus"></i> Create New Account
                        </a>
                    </div>

                    <!-- Test Accounts Info -->
                    <div class="mt-4 p-3" style="background: rgba(0,0,0,0.05); border-radius: 10px;">
                        <p class="small text-muted mb-2 fw-bold">🔑 Test Accounts:</p>
                        <p class="small text-muted mb-1"><strong>User:</strong> user@aquarium.com / password</p>
                        <p class="small text-muted mb-0"><strong>Admin:</strong> admin@aquarium.com / password</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-outline-primary {
        color: #667eea;
        border-color: #667eea;
    }
    
    .btn-outline-primary:hover {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }
</style>
@endsection
