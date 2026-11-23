@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="color:#fff;font-weight:700;margin:0;">Users & Admins</h4>
        <p style="color:#94a3b8;font-size:13px;margin:2px 0 0;">Manage all accounts on the platform</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus"></i> Add User
    </button>
</div>

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

<div class="table-container">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Bookings</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $user->id }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:34px;height:34px;border-radius:50%;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,{{ $user->role==='admin' ? '#8b5cf6,#6366f1' : '#0ea5e9,#06b6d4' }});display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:14px;">
                            @if($user->avatar)
                                <img src="{{ asset('storage/'.$user->avatar) }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                {{ strtoupper(substr($user->name,0,1)) }}
                            @endif
                        </div>
                        <span style="font-weight:600;color:#1e293b;">{{ $user->name }}</span>
                    </div>
                </td>
                <td style="color:#475569;font-size:13px;">{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="badge bg-primary"><i class="bi bi-shield-check"></i> Admin</span>
                    @else
                        <span class="badge bg-secondary"><i class="bi bi-person"></i> User</span>
                    @endif
                </td>
                <td>
                    @if($user->role === 'user')
                        <a href="{{ route('admin.users.bookings', $user->id) }}" style="color:#0ea5e9;font-weight:600;text-decoration:none;">
                            {{ $user->bookings_count }} booking{{ $user->bookings_count != 1 ? 's' : '' }}
                        </a>
                    @else
                        <span style="color:#64748b;">—</span>
                    @endif
                </td>
                <td style="color:#64748b;font-size:12px;">{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                          onsubmit="return confirm('Delete {{ addslashes($user->name) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);border-radius:8px;padding:4px 12px;font-size:12px;font-weight:600;">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                    @else
                        <span style="color:#64748b;font-size:12px;">You</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5">
                    <i class="bi bi-people" style="font-size:3rem;opacity:0.3;"></i>
                    <p class="text-muted mt-2">No users found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $users->links() }}</div>

{{-- ── Add User Modal ── --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,0.08);">
                <h5 class="modal-title" style="color:#fff;font-weight:700;">
                    <i class="bi bi-person-plus" style="color:#0ea5e9;"></i> Add New Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.create') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:24px;">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="user">👤 User</option>
                            <option value="admin">🛡️ Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,0.08);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-check"></i> Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
