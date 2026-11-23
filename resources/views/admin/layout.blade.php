<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - AquaDiveDeep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* ── Base ── */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; padding: 0;
        }

        /* ── Sidebar ── */
        .sidebar {
            background: #0a1628;
            border-right: 1px solid rgba(255,255,255,0.05);
            height: 100vh; position: fixed; width: 280px;
            z-index: 1000; overflow-y: auto; overflow-x: hidden;
            display: flex; flex-direction: column;
        }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }
        .sidebar .logo { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
        .sidebar .logo .logo-icon { width: 48px; height: 48px; background: linear-gradient(135deg,#0ea5e9,#06b6d4); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .sidebar .logo .logo-text { font-size: 20px; font-weight: 700; color: white; }
        .sidebar .logo .logo-text span { color: #0ea5e9; }
        .role-toggle { padding: 12px 20px; display: flex; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 8px; flex-shrink: 0; }
        .role-toggle .role-btn { flex: 1; padding: 8px 12px; border-radius: 8px; background: rgba(255,255,255,0.05); color: #cbd5e1; border: none; font-size: 13px; font-weight: 500; cursor: pointer; }
        .role-toggle .role-btn.active { background: linear-gradient(135deg,#0ea5e9,#06b6d4); color: white; }
        .sidebar-nav { flex: 1; overflow-y: auto; padding-bottom: 20px; }
        .nav-section { padding: 20px 20px 8px; }
        .nav-section-title { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; padding-left: 12px; }
        .nav-link { color: #cbd5e1; padding: 10px 20px; margin: 2px 12px; border-radius: 8px; transition: all 0.3s; display: flex; align-items: center; gap: 12px; text-decoration: none; font-size: 14px; font-weight: 500; }
        .nav-link i { font-size: 18px; width: 20px; text-align: center; }
        .nav-link:hover { background: rgba(14,165,233,0.15); color: #38bdf8; }
        .nav-link.active { background: linear-gradient(135deg,#0ea5e9,#06b6d4); color: white; box-shadow: 0 4px 12px rgba(14,165,233,0.3); }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.05); flex-shrink: 0; background: #0a1628; }
        .user-profile { display: flex; align-items: center; gap: 12px; padding: 12px; background: rgba(255,255,255,0.05); border-radius: 10px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg,#8b5cf6,#6366f1); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 16px; flex-shrink: 0; }
        .user-name { font-size: 14px; font-weight: 600; color: white; }
        .user-role { font-size: 11px; color: #94a3b8; }

        /* ── Main Content ── */
        .main-content { margin-left: 280px; padding: 30px; min-height: 100vh; }

        /* ── Cards: white bg, dark text ── */
        .card {
            border: 2px solid rgba(14,165,233,0.3);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }
        /* Only apply white bg/dark text when no inline style overrides it */
        .card:not([style*="background"]) {
            background: #ffffff !important;
            color: #1e293b !important;
        }
        .card-body { background: transparent !important; }

        /* ── Tables ── */
        .table-container {
            background: #ffffff;
            border: 2px solid rgba(14,165,233,0.3);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        }
        .table {
            background: #ffffff;
            color: #1e293b !important;
            margin-bottom: 0;
            font-size: 15px;
        }
        table.table > thead > tr > th,
        .table-responsive > table > thead > tr > th,
        .card table thead th,
        .table thead th {
            --bs-table-bg: transparent !important;
            --bs-table-color: #ffffff !important;
            background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important;
            background-color: #0ea5e9 !important;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px 18px;
            border: none !important;
            white-space: nowrap;
        }
        .table tbody tr {
            background: #ffffff !important;
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.2s;
        }
        .table tbody tr:hover { background: #f8fafc !important; }
        .table tbody tr:last-child { border-bottom: none; }
        .table tbody td {
            color: #1e293b !important;
            padding: 16px 18px;
            vertical-align: middle;
            border: none;
            font-weight: 500;
        }
        .table-striped tbody tr:nth-of-type(odd) { background: #f1f5f9 !important; }

        /* ── Badges ── */
        .badge { padding: 6px 14px; border-radius: 6px; font-weight: 700; font-size: 13px; color: #ffffff !important; }
        .badge.bg-success { background: linear-gradient(135deg,#10b981,#059669) !important; }
        .badge.bg-warning { background: linear-gradient(135deg,#f59e0b,#d97706) !important; }
        .badge.bg-danger  { background: linear-gradient(135deg,#ef4444,#dc2626) !important; }
        .badge.bg-info    { background: linear-gradient(135deg,#3b82f6,#2563eb) !important; }
        .badge.bg-secondary { background: linear-gradient(135deg,#6b7280,#4b5563) !important; }
        .badge.bg-primary { background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; }

        /* ── Buttons ── */
        .btn-primary { background: linear-gradient(135deg,#0ea5e9,#06b6d4); border: none; font-weight: 600; color: #fff !important; }
        .btn-info    { background: linear-gradient(135deg,#8b5cf6,#6366f1); border: none; color: #fff !important; font-weight: 600; }
        .btn-success { background: linear-gradient(135deg,#10b981,#059669); border: none; color: #fff !important; font-weight: 600; }
        .btn-sm { padding: 6px 14px; font-size: 13px; border-radius: 6px; font-weight: 600; }

        /* ── Pagination ── */
        .page-link { background: #1e293b; border: 2px solid rgba(14,165,233,0.3); color: #ffffff; border-radius: 6px; padding: 8px 14px; font-weight: 600; }
        .page-link:hover { background: rgba(14,165,233,0.2); color: #60d5f8; }
        .page-item.active .page-link { background: linear-gradient(135deg,#0ea5e9,#06b6d4); border-color: #0ea5e9; color: white; }
        .page-item.disabled .page-link { background: rgba(30,41,59,0.5); color: #94a3b8; }

        /* ── Forms ── */
        .form-control, .form-select { background: #1e293b; border: 2px solid rgba(14,165,233,0.3); color: #ffffff; border-radius: 8px; padding: 10px 14px; }
        .form-control:focus, .form-select:focus { background: #1e293b; border-color: #0ea5e9; color: #ffffff; box-shadow: 0 0 0 3px rgba(14,165,233,0.2); }
        .form-control::placeholder { color: #94a3b8; }
        .form-label { color: #ffffff; font-weight: 600; margin-bottom: 6px; }
        .form-select option { background: #1e293b; color: #ffffff; }
        .filter-bar { background: #1e293b; padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 2px solid rgba(14,165,233,0.3); }

        /* ── Notification Bell ── */
        .notif-bell-wrap { display: inline-flex; }
        .notif-bell-btn { background: rgba(255,255,255,0.08); border: 1.5px solid rgba(14,165,233,0.4); color: #fff; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 18px; cursor: pointer; position: relative; }
        .notif-badge { position: absolute; top: -4px; right: -4px; background: #ef4444; color: #fff; border-radius: 50%; width: 17px; height: 17px; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center; }
        /* ── Toast ── */
        .booking-toast { position: fixed; bottom: 28px; right: 28px; z-index: 99999; background: #0f172a; border: 2px solid #0ea5e9; border-radius: 14px; padding: 16px 20px; min-width: 300px; max-width: 360px; box-shadow: 0 8px 32px rgba(14,165,233,0.3); display: none; animation: slideIn 0.4s ease; }
        .booking-toast.show { display: flex; gap: 14px; align-items: flex-start; }
        .booking-toast .toast-icon { font-size: 28px; color: #0ea5e9; flex-shrink: 0; }
        .booking-toast .toast-body .toast-title { font-weight: 700; color: #fff; font-size: 15px; }
        .booking-toast .toast-body .toast-msg { color: #94a3b8; font-size: 13px; margin-top: 3px; }
        .booking-toast .toast-close { margin-left: auto; background: none; border: none; color: #94a3b8; font-size: 18px; cursor: pointer; padding: 0; flex-shrink: 0; }
        @keyframes slideIn { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        /* text-muted on white cards needs to be dark enough to read */
        .text-muted { color: #475569 !important; }
        /* text-muted inside gradient/dark stat cards should stay light */
        [style*="background:linear-gradient"] .text-muted,
        [style*="background: linear-gradient"] .text-muted { color: #cbd5e1 !important; }
        /* text-white-50 on gradient cards — bump to 90% */
        .text-white-50 { color: rgba(255,255,255,0.9) !important; }
        /* small muted labels on gradient cards */
        [style*="background:linear-gradient"] small,
        [style*="background: linear-gradient"] small { color: rgba(255,255,255,0.9) !important; }
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 64px; margin-bottom: 16px; opacity: 0.4; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .status-dot.success { background: #10b981; }
        .status-dot.warning { background: #f59e0b; }
        .status-dot.danger  { background: #ef4444; }
        .status-dot.info    { background: #3b82f6; }
        /* FORCE table headers - override Bootstrap */
        thead tr th { background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; background-color: #0ea5e9 !important; color: #fff !important; border: none !important; }
        /* Nuclear override for Bootstrap 5 table headers */
        .table > :not(caption) > * > * {
            --bs-table-bg: transparent;
        }
        thead tr th {
            --bs-table-color: #ffffff !important;
            --bs-table-bg: #0ea5e9 !important;
            background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important;
            color: #ffffff !important;
            border: none !important;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <div class="logo-icon"><i class="bi bi-water"></i></div>
            <div class="logo-text">Aqua<span>DiveDeep</span></div>
        </div>
        <a href="/admin/profile" style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.05);text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='rgba(14,165,233,0.1)'" onmouseout="this.style.background='transparent'">
            <div style="width:40px;height:40px;border-radius:50%;overflow:hidden;flex-shrink:0;border:2px solid #0ea5e9;">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div style="width:100%;height:100%;background:linear-gradient(135deg,#8b5cf6,#6366f1);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;color:#fff;">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                @endif
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:14px;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name ?? 'Administrator' }}</div>
                <div style="font-size:11px;color:#94a3b8;">View Profile</div>
            </div>
            <i class="bi bi-chevron-right" style="color:#94a3b8;font-size:12px;"></i>
        </a>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Overview</div>
                <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i><span>{{ __('app.dashboard') }}</span></a>
            </div>
            <div class="nav-section">
                <div class="nav-section-title">Management</div>
                <a href="/admin/bookings" class="nav-link"><i class="bi bi-ticket-perforated"></i><span>{{ __('app.manage_bookings') }}</span></a>
                <a href="/admin/users" class="nav-link"><i class="bi bi-people"></i><span>{{ __('app.customers') }}</span></a>
                <a href="/admin/aquariums" class="nav-link"><i class="bi bi-building"></i><span>{{ __('app.aquariums') }}</span></a>
            </div>
            <div class="nav-section">
                <div class="nav-section-title">Aquarium Data</div>
                <a href="/admin/fish-species" class="nav-link"><i class="bi bi-fish"></i><span>{{ __('app.fish_species') }}</span></a>
                <a href="/admin/coral-plants" class="nav-link"><i class="bi bi-flower1"></i><span>{{ __('app.coral_plants') }}</span></a>
                <a href="/admin/water-quality" class="nav-link"><i class="bi bi-droplet"></i><span>{{ __('app.water_quality') }}</span></a>
            </div>
            <div class="nav-section">
                <div class="nav-section-title">Analytics</div>
                <a href="/admin/analytics" class="nav-link"><i class="bi bi-graph-up-arrow"></i><span>{{ __('app.reports') }}</span></a>
                <a href="/admin/analytics/calendar" class="nav-link"><i class="bi bi-calendar3"></i><span>Calendar View</span></a>
                <a href="/admin/activity-logs" class="nav-link"><i class="bi bi-clock-history"></i><span>{{ __('app.activity_logs') }}</span></a>
            </div>
            <div class="nav-section">
                <div class="nav-section-title">System</div>
                <a href="/admin/pos" class="nav-link"><i class="bi bi-cart3"></i><span>POS / Walk-in</span></a>
                <a href="/admin/settings" class="nav-link"><i class="bi bi-gear"></i><span>{{ __('app.settings') }}</span></a>
            </div>
        </nav>
        <div class="sidebar-footer">
            {{-- Language Switcher Dropdown --}}
            <div style="padding: 8px 12px; margin-bottom:8px; position:relative;">
                @php
                    $loc2 = request()->cookie('locale','en');
                    $flagMap = ['en'=>'us','km'=>'kh','es'=>'es','zh'=>'cn'];
                    $nameMap = ['en'=>'English','km'=>'ខ្មែរ','es'=>'Español','zh'=>'中文'];
                @endphp
                <div class="dropup">
                    <button class="btn w-100 d-flex align-items-center justify-content-between"
                            style="background:rgba(255,255,255,0.06);border:1px solid rgba(14,165,233,0.3);color:#fff;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:600;"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-flex align-items-center gap-2">
                            <img src="https://flagcdn.com/20x15/{{ $flagMap[$loc2] ?? 'us' }}.png"
                                 width="20" height="15" style="border-radius:2px;object-fit:cover;">
                            {{ $nameMap[$loc2] ?? 'English' }}
                        </span>
                        <i class="bi bi-chevron-up" style="font-size:11px;color:#94a3b8;"></i>
                    </button>
                    <ul class="dropdown-menu w-100 p-2" style="background:#0a1628;border:1px solid rgba(14,165,233,0.3);border-radius:12px;margin-bottom:4px;" data-bs-popper="none">
                        @foreach([
                            ['en', 'us', 'English'],
                            ['km', 'kh', 'ខ្មែរ'],
                            ['es', 'es', 'Español'],
                            ['zh', 'cn', '中文'],
                        ] as [$code, $flag, $label])
                        @php $active = $loc2 == $code; @endphp
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 rounded-3"
                               href="{{ route('lang.switch', $code) }}"
                               style="color:{{ $active ? '#38bdf8' : '#cbd5e1' }};font-size:13px;padding:8px 12px;font-weight:{{ $active ? '700' : '500' }};background:{{ $active ? 'rgba(14,165,233,0.15)' : 'transparent' }};">
                                <img src="https://flagcdn.com/20x15/{{ $flag }}.png"
                                     width="20" height="15" style="border-radius:2px;object-fit:cover;">
                                {{ $label }}
                                @if($active)<i class="bi bi-check2 ms-auto" style="color:#38bdf8;"></i>@endif
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="user-profile">
                <div class="user-avatar" style="overflow:hidden;padding:0;">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    @endif
                </div>
                <div style="flex:1; min-width:0;">
                    <div class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="user-role">{{ __('app.administrator') }}</div>
                </div>
                <div class="notif-bell-wrap">
                    <button class="notif-bell-btn" id="notifBell" title="New Bookings">
                        <i class="bi bi-bell-fill"></i>
                        <span class="notif-badge" id="notifBadge">1</span>
                    </button>
                </div>
                <form action="/admin/logout" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0" style="font-size:18px;" title="Logout"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Booking notification toast --}}
    <div class="booking-toast" id="bookingToast">
        <div class="toast-icon"><i class="bi bi-ticket-perforated-fill"></i></div>
        <div class="toast-body">
            <div class="toast-title">New Booking!</div>
            <div class="toast-msg" id="toastMsg">A customer just made a booking.</div>
        </div>
        <button class="toast-close" onclick="dismissToast()">×</button>
    </div>

    <script>
        // ── Active nav link ──
        document.addEventListener('DOMContentLoaded', function () {
            const path = window.location.pathname;
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href') === path) link.classList.add('active');
            });
        });

        // ── Booking notification polling ──
        // Clear stale localStorage if DB was reseeded (version check)
        const NOTIF_VERSION = '{{ \App\Models\Booking::max("id") ?? 0 }}';
        const storedVersion = localStorage.getItem('notifDbVersion');
        if (storedVersion !== NOTIF_VERSION && NOTIF_VERSION === '0') {
            // DB was wiped/reseeded - reset state
            localStorage.removeItem('lastBookingId');
            localStorage.removeItem('unreadCount');
        }
        localStorage.setItem('notifDbVersion', NOTIF_VERSION);

        let lastBookingId = parseInt(localStorage.getItem('lastBookingId') || '0');
        let unreadCount   = parseInt(localStorage.getItem('unreadCount')   || '0');
        let toastTimer = null;

        function updateBadge() {
            const badge = document.getElementById('notifBadge');
            if (unreadCount > 0) {
                badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        // Show badge count on page load if there are unread
        updateBadge();

        function playNotifSound() {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            [880, 1100].forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.type = 'sine';
                osc.frequency.value = freq;
                gain.gain.setValueAtTime(0.4, ctx.currentTime + i * 0.18);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + i * 0.18 + 0.5);
                osc.start(ctx.currentTime + i * 0.18);
                osc.stop(ctx.currentTime + i * 0.18 + 0.5);
            });
        }

        function showToast(msg) {
            const toast = document.getElementById('bookingToast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(dismissToast, 8000);
        }

        function dismissToast() {
            document.getElementById('bookingToast').classList.remove('show');
        }

        document.getElementById('notifBell').addEventListener('click', function () {
            unreadCount = 0;
            localStorage.setItem('unreadCount', '0');
            updateBadge();
            window.location.href = '/admin/bookings';
        });

        async function checkNewBookings() {
            try {
                const res = await fetch('/admin/notifications/latest-booking');
                if (!res.ok || res.headers.get('content-type')?.indexOf('application/json') === -1) return;
                const data = await res.json();
                if (data.latest_id > lastBookingId && lastBookingId !== 0) {
                    unreadCount++;
                    localStorage.setItem('unreadCount', unreadCount);
                    updateBadge();
                    const aquarium = data.aquarium || 'an aquarium';
                    const msg = `${data.customer_name} booked ${data.tickets} ticket(s) for ${aquarium}.`;
                    showToast(msg);
                    playNotifSound();
                }
                if (data.latest_id > 0) {
                    lastBookingId = data.latest_id;
                    localStorage.setItem('lastBookingId', lastBookingId);
                }
            } catch (e) {}
        }

        // Init — seed lastBookingId from server so we don't alert for existing bookings
        fetch('/admin/notifications/latest-booking')
            .then(r => r.ok ? r.json() : null)
            .then(data => {
                if (data && lastBookingId === 0 && data.latest_id > 0) {
                    lastBookingId = data.latest_id;
                    localStorage.setItem('lastBookingId', lastBookingId);
                }
                setInterval(checkNewBookings, 3000);
            }).catch(() => setInterval(checkNewBookings, 3000));
    </script>
</body>
</html>
