@extends('layout')

@section('hero')
<div class="hero" style="padding:60px 0;">
    <h1 class="display-5 fw-bold">Join AquaDiveDeep</h1>
    <p class="lead" style="color:#94a3b8;">Create an account to start booking amazing aquarium experiences</p>
</div>
@endsection

@section('content')
<div style="display:flex;justify-content:center;padding-bottom:80px;">
<div style="width:100%;max-width:460px;">

    <div style="background:rgba(30,41,59,0.9);border:1px solid rgba(14,165,233,0.3);border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.4);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#0ea5e9,#06b6d4);padding:24px;text-align:center;">
            <div style="font-size:28px;margin-bottom:6px;">🌊</div>
            <div style="font-size:20px;font-weight:800;color:#fff;">Create Your Account</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.92);margin-top:4px;">
                Already have an account?
                <a href="{{ route('login') }}" style="color:#fff;font-weight:700;text-decoration:underline;">Sign in</a>
            </div>
        </div>

        <div style="padding:28px;">

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" style="border-radius:10px;font-size:13px;">
                    <i class="bi bi-exclamation-triangle"></i>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- 1. Full Name --}}
                <div style="margin-bottom:16px;">
                    <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:6px;">
                        <i class="bi bi-person" style="color:#0ea5e9;"></i> Full Name
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Enter your full name"
                           class="form-control @error('name') is-invalid @enderror"
                           required autofocus>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- 2. Email --}}
                <div style="margin-bottom:16px;">
                    <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:6px;">
                        <i class="bi bi-envelope" style="color:#0ea5e9;"></i> Email Address
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="your@email.com"
                           class="form-control @error('email') is-invalid @enderror"
                           required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- 3. Password --}}
                <div style="margin-bottom:16px;">
                    <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:6px;">
                        <i class="bi bi-lock" style="color:#0ea5e9;"></i> Password
                    </label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="password"
                               placeholder="Minimum 8 characters"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        <button type="button" onclick="togglePwd('password','eyeIcon1')"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:0;">
                            <i class="bi bi-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- 4. Confirm Password --}}
                <div style="margin-bottom:20px;">
                    <label style="color:#e2e8f0;font-weight:600;font-size:13px;display:block;margin-bottom:6px;">
                        <i class="bi bi-lock-fill" style="color:#0ea5e9;"></i> Confirm Password
                    </label>
                    <div style="position:relative;">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               placeholder="Repeat your password"
                               class="form-control"
                               required>
                        <button type="button" onclick="togglePwd('password_confirmation','eyeIcon2')"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:0;">
                            <i class="bi bi-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                </div>

                {{-- 5. Terms --}}
                <div style="margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;">
                    <input type="checkbox" id="terms" required
                           style="margin-top:3px;width:16px;height:16px;flex-shrink:0;accent-color:#0ea5e9;">
                    <label for="terms" style="color:#94a3b8;font-size:13px;cursor:pointer;">
                        I agree to the <a href="#" style="color:#38bdf8;">Terms of Service</a> and <a href="#" style="color:#38bdf8;">Privacy Policy</a>
                    </label>
                </div>

                {{-- 6. Submit --}}
                <button type="submit"
                        style="width:100%;background:linear-gradient(135deg,#0ea5e9,#06b6d4);color:#fff;border:none;padding:13px;border-radius:12px;font-size:15px;font-weight:800;cursor:pointer;box-shadow:0 4px 20px rgba(14,165,233,0.35);">
                    <i class="bi bi-person-check"></i> Create Account
                </button>
            </form>

            {{-- Benefits --}}
            <div style="margin-top:20px;padding:14px;background:rgba(14,165,233,0.06);border:1px solid rgba(14,165,233,0.15);border-radius:12px;">
                <div style="font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Why join?</div>
                @foreach(['Easy aquarium booking','View your booking history','Get entry QR tickets','Exclusive member offers'] as $benefit)
                <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#cbd5e1;margin-bottom:4px;">
                    <i class="bi bi-check-circle-fill" style="color:#0ea5e9;font-size:11px;"></i> {{ $benefit }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
</div>

<script>
function togglePwd(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endsection
