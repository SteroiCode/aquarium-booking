@extends('layout')

@section('content')
<div style="max-width:720px; margin:40px auto 80px;">

    {{-- Header --}}
    <div style="margin-bottom:28px;">
        <h2 style="color:#fff; font-weight:700; font-size:26px; margin:0;">
            <i class="bi bi-person-circle" style="color:#0ea5e9;"></i> My Profile
        </h2>
        <p style="color:#94a3b8; margin:4px 0 0;">Manage your account information and password.</p>
    </div>

    {{-- Avatar Card --}}
    <div class="card mb-4" style="background:rgba(30,41,59,0.9) !important; border:1px solid rgba(14,165,233,0.3);">
        <div class="card-body" style="padding:28px;">
            <h5 style="color:#fff;font-weight:700;margin-bottom:20px;">
                <i class="bi bi-image" style="color:#0ea5e9;"></i> Profile Photo
            </h5>
            <div class="d-flex align-items-center gap-4 flex-wrap">
                <div style="flex-shrink:0;">
                    @if(auth()->user()->avatar)
                        <img id="avatarPreview" src="{{ asset('storage/' . auth()->user()->avatar) }}"
                             style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #0ea5e9;">
                    @else
                        <div id="avatarInitial" style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#0ea5e9,#06b6d4);
                             display:flex;align-items:center;justify-content:center;font-size:38px;font-weight:700;color:#fff;border:3px solid #0ea5e9;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <img id="avatarPreview" src="" style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #0ea5e9;display:none;">
                    @endif
                </div>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="flex:1;">
                    @csrf @method('PUT')
                    <input type="hidden" name="name"  value="{{ auth()->user()->name }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <label style="color:#e2e8f0;font-weight:600;display:block;margin-bottom:6px;">
                        Upload new photo (JPG, PNG, WEBP — max 2MB)
                    </label>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <input type="file" name="avatar" id="avatarInput" accept="image/*"
                               onchange="previewAvatar(this)"
                               class="@error('avatar') is-invalid @enderror"
                               style="display:none;">
                        <label for="avatarInput" style="
                            display:inline-flex;align-items:center;gap:8px;
                            padding:9px 18px;border-radius:50px;cursor:pointer;
                            background:rgba(14,165,233,0.12);
                            border:2px dashed rgba(14,165,233,0.5);
                            color:#38bdf8;font-weight:600;font-size:14px;
                            transition:all 0.2s;
                        "
                        onmouseover="this.style.background='rgba(14,165,233,0.22)';this.style.borderColor='#0ea5e9'"
                        onmouseout="this.style.background='rgba(14,165,233,0.12)';this.style.borderColor='rgba(14,165,233,0.5)'">
                            <i class="bi bi-image" style="font-size:16px;"></i>
                            <span id="fileLabel">Choose Photo</span>
                        </label>
                        <button type="submit" class="btn btn-primary btn-sm" style="border-radius:50px;padding:9px 20px;">
                            <i class="bi bi-upload"></i> Upload
                        </button>
                    </div>
                    @error('avatar')<div style="color:#ef4444;font-size:13px;margin-top:4px;">{{ $message }}</div>@enderror
                </form>
            </div>
        </div>
    </div>

    {{-- Profile Info --}}
    <div class="card mb-4" style="background:rgba(30,41,59,0.9) !important; border:1px solid rgba(14,165,233,0.3);">
        <div class="card-body" style="padding:28px;">
            <h5 style="color:#fff;font-weight:700;margin-bottom:20px;">
                <i class="bi bi-pencil-square" style="color:#0ea5e9;"></i> Profile Information
            </h5>

            @if(session('success') && !str_contains(session('success'), 'Password'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label style="color:#e2e8f0;font-weight:600;display:block;margin-bottom:6px;">Full Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', auth()->user()->name) }}"
                           style="background:rgba(255,255,255,0.08);border:1px solid rgba(14,165,233,0.4);color:#fff;border-radius:8px;padding:10px 14px;"
                           required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label style="color:#e2e8f0;font-weight:600;display:block;margin-bottom:6px;">Email Address</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', auth()->user()->email) }}"
                           style="background:rgba(255,255,255,0.08);border:1px solid rgba(14,165,233,0.4);color:#fff;border-radius:8px;padding:10px 14px;"
                           required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save Changes
                </button>
            </form>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="card" style="background:rgba(30,41,59,0.9) !important; border:1px solid rgba(14,165,233,0.3);">
        <div class="card-body" style="padding:28px;">
            <h5 style="color:#fff;font-weight:700;margin-bottom:20px;">
                <i class="bi bi-shield-lock" style="color:#0ea5e9;"></i> Change Password
            </h5>

            @if(session('success') && str_contains(session('success'), 'Password'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label style="color:#e2e8f0;font-weight:600;display:block;margin-bottom:6px;">Current Password</label>
                    <input type="password" name="current_password"
                           class="form-control @error('current_password') is-invalid @enderror"
                           style="background:rgba(255,255,255,0.08);border:1px solid rgba(14,165,233,0.4);color:#fff;border-radius:8px;padding:10px 14px;"
                           required>
                    @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label style="color:#e2e8f0;font-weight:600;display:block;margin-bottom:6px;">New Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           style="background:rgba(255,255,255,0.08);border:1px solid rgba(14,165,233,0.4);color:#fff;border-radius:8px;padding:10px 14px;"
                           required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label style="color:#e2e8f0;font-weight:600;display:block;margin-bottom:6px;">Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           style="background:rgba(255,255,255,0.08);border:1px solid rgba(14,165,233,0.4);color:#fff;border-radius:8px;padding:10px 14px;width:100%;"
                           class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-lock"></i> Update Password
                </button>
            </form>
        </div>
    </div>

</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatarPreview');
            const initial = document.getElementById('avatarInitial');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initial) initial.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('fileLabel').textContent = input.files[0].name;
    }
}
</script>
@endsection
