<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaDiveDeep - Explore Ocean Wonders</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0ea5e9;
            --secondary-color: #06b6d4;
            --dark-bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.8);
            --text-light: #e2e8f0;
            --text-muted: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            background-attachment: fixed;
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(6, 182, 212, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        /* Animated Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(14, 165, 233, 0.3);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 100px; height: 100px; left: 35%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 50px; height: 50px; left: 50%; animation-delay: 6s; }
        .particle:nth-child(5) { width: 70px; height: 70px; left: 65%; animation-delay: 8s; }
        .particle:nth-child(6) { width: 90px; height: 90px; left: 80%; animation-delay: 10s; }
        .particle:nth-child(7) { width: 40px; height: 40px; left: 15%; animation-delay: 12s; }
        .particle:nth-child(8) { width: 110px; height: 110px; left: 70%; animation-delay: 14s; }

        @keyframes float {
            0%, 100% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.3;
            }
            90% {
                opacity: 0.3;
            }
            50% {
                transform: translateY(-20vh) translateX(50px) rotate(180deg);
                opacity: 0.5;
            }
        }

        /* Floating Fish */
        .fish {
            position: absolute;
            font-size: 2rem;
            animation: swim 25s infinite linear;
            opacity: 0.4;
            filter: drop-shadow(0 0 10px rgba(14, 165, 233, 0.5));
        }

        .fish:nth-child(odd) {
            animation-direction: reverse;
        }

        @keyframes swim {
            0% {
                transform: translateX(-100px) translateY(0) scaleX(1);
            }
            48% {
                transform: translateX(calc(100vw + 100px)) translateY(-30px) scaleX(1);
            }
            50% {
                transform: translateX(calc(100vw + 100px)) translateY(-30px) scaleX(-1);
            }
            98% {
                transform: translateX(-100px) translateY(0) scaleX(-1);
            }
            100% {
                transform: translateX(-100px) translateY(0) scaleX(1);
            }
        }

        /* Wave Animation */
        .waves {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            pointer-events: none;
            z-index: 0;
        }

        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='rgba(14, 165, 233, 0.1)'/%3E%3C/svg%3E");
            background-size: 50% 100%;
            animation: wave 15s linear infinite;
        }

        .wave:nth-child(2) {
            opacity: 0.5;
            animation-delay: -5s;
            animation-duration: 20s;
        }

        .wave:nth-child(3) {
            opacity: 0.3;
            animation-delay: -10s;
            animation-duration: 25s;
        }

        @keyframes wave {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        /* Bubbles */
        .bubble {
            position: absolute;
            bottom: -100px;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.8), rgba(14, 165, 233, 0.3));
            border-radius: 50%;
            animation: rise 15s infinite ease-in;
            box-shadow: 0 0 10px rgba(14, 165, 233, 0.3);
        }

        .bubble:nth-child(1) { width: 40px; height: 40px; left: 10%; animation-delay: 0s; }
        .bubble:nth-child(2) { width: 20px; height: 20px; left: 20%; animation-delay: 2s; }
        .bubble:nth-child(3) { width: 50px; height: 50px; left: 35%; animation-delay: 4s; }
        .bubble:nth-child(4) { width: 30px; height: 30px; left: 50%; animation-delay: 6s; }
        .bubble:nth-child(5) { width: 25px; height: 25px; left: 65%; animation-delay: 8s; }
        .bubble:nth-child(6) { width: 35px; height: 35px; left: 80%; animation-delay: 10s; }
        .bubble:nth-child(7) { width: 45px; height: 45px; left: 90%; animation-delay: 12s; }

        @keyframes rise {
            0% {
                bottom: -100px;
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                bottom: 110vh;
                opacity: 0;
                transform: translateX(100px);
            }
        }

        /* Glowing Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            animation: pulse 8s infinite ease-in-out;
            pointer-events: none;
        }

        .orb:nth-child(1) {
            width: 300px;
            height: 300px;
            background: rgba(14, 165, 233, 0.2);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb:nth-child(2) {
            width: 400px;
            height: 400px;
            background: rgba(6, 182, 212, 0.15);
            top: 60%;
            right: 10%;
            animation-delay: 4s;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.6;
            }
        }

        /* Ensure all content is above background */
        .container, .card, form, input, textarea, select, button {
            position: relative;
            z-index: 1;
        }

        /* Make sure inputs are clickable */
        input, textarea, select {
            pointer-events: auto !important;
            cursor: text !important;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.5);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--text-light) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(14, 165, 233, 0.1);
        }

        /* Search Bar */
        .search-form {
            max-width: 400px;
            position: relative;
        }

        .search-form input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 0.6rem 1.2rem;
            color: white;
            transition: all 0.3s ease;
        }

        .search-form input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
            outline: none;
        }

        .search-form input::placeholder {
            color: var(--text-muted);
        }

        .search-form button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 50px;
            padding: 0.4rem 1.2rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .search-form button:hover {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
        }

        /* ===== HERO SECTION ===== */
        .hero {
            position: relative;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(30, 41, 59, 0.9)),
                        url('https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 150px 0 100px;
            text-align: center;
            margin-bottom: 80px;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, transparent 0%, rgba(15, 23, 42, 0.8) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff, var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(6, 182, 212, 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.3);
            border-color: rgba(14, 165, 233, 0.5);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.1);
        }

        .card-body {
            position: relative;
            z-index: 1;
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: white;
        }

        .card-text {
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ===== BUTTONS ===== */
        .btn {
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.5);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }

        /* ===== BADGES ===== */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* ===== TABLES ===== */
        .table {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            overflow: hidden;
            color: var(--text-light);
        }

        .table thead {
            background: rgba(14, 165, 233, 0.2);
        }

        .table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(14, 165, 233, 0.1);
            transform: scale(1.01);
        }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: 15px;
            border: none;
            backdrop-filter: blur(20px);
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== FOOTER ===== */
        footer {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 3rem 0;
            margin-top: 100px;
        }

        .footer-content {
            text-align: center;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            margin: 0 1rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        /* ===== SCROLL ANIMATIONS ===== */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== LOADING ANIMATION ===== */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1rem;
            }

            .search-form {
                max-width: 100%;
                margin: 1rem 0;
            }
        }

        /* ===== PRINT STYLES ===== */
        @media print {
            /* Hide all animated background elements */
            .particles, .waves, .fish, .bubble, .orb, .particle {
                display: none !important;
            }
            
            /* Hide navigation and footer */
            nav, .navbar, footer {
                display: none !important;
            }
            
            /* Clean background for printing */
            body {
                background: white !important;
                color: black !important;
            }
            
            body::before, body::after {
                display: none !important;
            }
            
            /* Remove shadows and effects */
            .card {
                background: white !important;
                box-shadow: none !important;
                border: 1px solid #000 !important;
                backdrop-filter: none !important;
            }
            
            /* Optimize text for print */
            * {
                color: black !important;
                background: transparent !important;
            }
            
            .text-muted {
                color: #666 !important;
            }
        }

        /* Container */
        .container {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>

<!-- ===== ANIMATED BACKGROUND ELEMENTS ===== -->
<!-- Particles -->
<div class="particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
</div>

<!-- Glowing Orbs -->
<div class="particles">
    <div class="orb"></div>
    <div class="orb"></div>
</div>

<!-- Floating Fish -->
<div class="particles">
    <div class="fish" style="top: 20%;">🐠</div>
    <div class="fish" style="top: 40%;">🐟</div>
    <div class="fish" style="top: 60%;">🐡</div>
    <div class="fish" style="top: 80%;">🦈</div>
</div>

<!-- Bubbles -->
<div class="particles">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
</div>

<!-- Waves -->
<div class="waves">
    <div class="wave"></div>
    <div class="wave"></div>
    <div class="wave"></div>
</div>

<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-water"></i> AquaDiveDeep
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Search -->
            <form method="GET" action="{{ route('home') }}" class="search-form mx-auto my-3 my-lg-0">
                <input type="text" name="search" class="form-control" placeholder="Search aquariums..." value="{{ request('search') }}">
                <button type="submit" class="btn">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <!-- Navigation Links -->
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="bi bi-house-door"></i> {{ __('app.home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">
                        <i class="bi bi-info-circle"></i> {{ __('app.about') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">
                        <i class="bi bi-envelope"></i> Contact
                    </a>
                </li>
                
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('booking.history') }}">
                            <i class="bi bi-clock-history"></i> {{ __('app.my_bookings') }}
                        </a>
                    </li>
                    
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Admin Panel
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                     style="width:28px;height:28px;border-radius:50%;object-fit:cover;border:2px solid #0ea5e9;">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="background: rgba(30, 41, 59, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1);">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}" style="color: var(--text-light);">
                                    <i class="bi bi-person-circle"></i> My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="color: var(--text-light);">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> {{ __('app.login') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm ms-2">
                            <i class="bi bi-person-plus"></i> {{ __('app.register') }}
                        </a>
                    </li>
                @endauth

                {{-- Language Switcher --}}
                <li class="nav-item dropdown ms-2">
                    @php $loc = request()->cookie('locale', 'en'); @endphp
                    @php $flags = ['en'=>'us','km'=>'kh','es'=>'es','zh'=>'cn']; @endphp
                    @php $labels = ['en'=>'EN','km'=>'KM','es'=>'ES','zh'=>'ZH']; @endphp
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown"
                       style="background:rgba(14,165,233,0.12);border:1px solid rgba(14,165,233,0.35);border-radius:50px;padding:6px 14px;font-weight:600;font-size:13px;">
                        <img src="https://flagcdn.com/20x15/{{ $flags[$loc] ?? 'us' }}.png"
                             width="20" height="15" style="border-radius:2px;object-fit:cover;">
                        <span>{{ $labels[$loc] ?? 'EN' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2"
                        style="background:rgba(15,23,42,0.98);backdrop-filter:blur(20px);border:1px solid rgba(14,165,233,0.3);border-radius:14px;min-width:160px;box-shadow:0 8px 32px rgba(0,0,0,0.4);">
                        @foreach([
                            ['en', 'us', 'English'],
                            ['km', 'kh', 'ខ្មែរ'],
                            ['es', 'es', 'Español'],
                            ['zh', 'cn', '中文'],
                        ] as [$code, $flag, $label])
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 rounded-3 px-3 py-2"
                               href="{{ route('lang.switch', $code) }}"
                               style="color:{{ $loc==$code ? '#38bdf8' : '#cbd5e1' }};font-weight:{{ $loc==$code ? '700' : '500' }};font-size:14px;background:{{ $loc==$code ? 'rgba(14,165,233,0.15)' : 'transparent' }};transition:all 0.2s;"
                               onmouseover="this.style.background='rgba(14,165,233,0.12)';this.style.color='#38bdf8'"
                               onmouseout="this.style.background='{{ $loc==$code ? 'rgba(14,165,233,0.15)' : 'transparent' }}';this.style.color='{{ $loc==$code ? '#38bdf8' : '#cbd5e1' }}'">
                                <img src="https://flagcdn.com/20x15/{{ $flag }}.png" width="20" height="15" style="border-radius:2px;object-fit:cover;">
                                <span>{{ $label }}</span>
                                @if($loc==$code)<i class="bi bi-check2 ms-auto" style="color:#38bdf8;"></i>@endif
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ===== HERO SECTION ===== -->
@hasSection('hero')
    @yield('hero')
@else
<section class="hero">
    <div class="hero-content container" data-aos="fade-up">
        <h1>Discover the Wonders of the Ocean</h1>
        <p>Book unforgettable aquarium experiences around the world</p>
        <a href="#aquariums" class="btn btn-primary btn-lg">
            <i class="bi bi-compass"></i> Explore Now
        </a>
    </div>
</section>
@endif

<!-- ===== CONTENT ===== -->
<div class="container">
    @yield('content')
</div>

<!-- ===== FOOTER ===== -->
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-links mb-3">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('contact') }}">Contact</a>
                <a href="#">Privacy Policy</a>
            </div>
            <div class="social-links mb-3">
                <a href="#" class="text-muted me-3"><i class="bi bi-facebook fs-4"></i></a>
                <a href="#" class="text-muted me-3"><i class="bi bi-twitter fs-4"></i></a>
                <a href="#" class="text-muted me-3"><i class="bi bi-instagram fs-4"></i></a>
                <a href="#" class="text-muted"><i class="bi bi-youtube fs-4"></i></a>
            </div>
            <p class="text-muted mb-0">
                © {{ date('Y') }} AquaDiveDeep. All rights reserved.
            </p>
            <p class="text-muted small">
                <i class="bi bi-mortarboard"></i> University Project
            </p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Mouse parallax effect for particles
    document.addEventListener('mousemove', (e) => {
        const particles = document.querySelectorAll('.particle');
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        particles.forEach((particle, index) => {
            const speed = (index + 1) * 0.5;
            const x = (mouseX - 0.5) * speed * 50;
            const y = (mouseY - 0.5) * speed * 50;
            
            particle.style.transform = `translate(${x}px, ${y}px)`;
        });
    });

    // Random fish movement
    function animateFish() {
        const fishes = document.querySelectorAll('.fish');
        fishes.forEach((fish, index) => {
            const randomDelay = Math.random() * 5;
            const randomDuration = 20 + Math.random() * 10;
            fish.style.animationDelay = `${randomDelay}s`;
            fish.style.animationDuration = `${randomDuration}s`;
        });
    }
    animateFish();

    // Create additional bubbles dynamically
    function createBubble() {
        const particles = document.querySelector('.particles');
        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        
        const size = Math.random() * 30 + 20;
        bubble.style.width = size + 'px';
        bubble.style.height = size + 'px';
        bubble.style.left = Math.random() * 100 + '%';
        bubble.style.animationDuration = (Math.random() * 10 + 10) + 's';
        
        particles.appendChild(bubble);
        
        setTimeout(() => bubble.remove(), 15000);
    }

    // Create bubbles periodically
    setInterval(createBubble, 3000);

    // Parallax effect on scroll
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.particle, .orb');
        
        parallaxElements.forEach((el, index) => {
            const speed = (index + 1) * 0.1;
            el.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });

    // Add sparkle effect on hover for cards
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function(e) {
            const sparkle = document.createElement('div');
            sparkle.style.position = 'absolute';
            sparkle.style.width = '4px';
            sparkle.style.height = '4px';
            sparkle.style.background = 'white';
            sparkle.style.borderRadius = '50%';
            sparkle.style.pointerEvents = 'none';
            sparkle.style.animation = 'sparkle 1s ease-out forwards';
            
            const rect = this.getBoundingClientRect();
            sparkle.style.left = (e.clientX - rect.left) + 'px';
            sparkle.style.top = (e.clientY - rect.top) + 'px';
            
            this.appendChild(sparkle);
            setTimeout(() => sparkle.remove(), 1000);
        });
    });

    // Add sparkle animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes sparkle {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            50% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(0);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>

</body>
</html>