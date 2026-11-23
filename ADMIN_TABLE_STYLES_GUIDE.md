# Admin Table Styles Guide

Your admin panel now has beautiful, modern table styling! Here's how to use it.

## Basic Table Structure

```blade
<div class="card p-4">
    <h5 class="mb-4"><i class="bi bi-table"></i> Your Title</h5>
    
    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#001</td>
                    <td>John Doe</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary">Edit</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

## Status Badges

Use these badge classes for different statuses:

```blade
<!-- Success/Confirmed/Active -->
<span class="badge bg-success">
    <span class="status-dot success"></span>Confirmed
</span>

<!-- Warning/Pending -->
<span class="badge bg-warning">
    <span class="status-dot warning"></span>Pending
</span>

<!-- Danger/Cancelled/Rejected -->
<span class="badge bg-danger">
    <span class="status-dot danger"></span>Cancelled
</span>

<!-- Info -->
<span class="badge bg-info">
    <span class="status-dot info"></span>Processing
</span>

<!-- Secondary -->
<span class="badge bg-secondary">Inactive</span>

<!-- Primary -->
<span class="badge bg-primary">New</span>
```

## Search & Filter Bar

```blade
<div class="filter-bar">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search...">
        </div>
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Date From</label>
            <input type="date" name="date_from" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Filter
            </button>
        </div>
    </form>
</div>
```

## Action Buttons

```blade
<!-- Single buttons -->
<button class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</button>
<button class="btn btn-sm btn-success"><i class="bi bi-check"></i> Approve</button>
<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button>
<button class="btn btn-sm btn-info"><i class="bi bi-eye"></i> View</button>

<!-- Button group -->
<div class="btn-group btn-group-sm">
    <button class="btn btn-primary"><i class="bi bi-pencil"></i></button>
    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
</div>
```

## Empty State

When there's no data:

```blade
<div class="table-container">
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h5>No Data Found</h5>
        <p>There are no records to display at the moment.</p>
        <a href="{{ route('admin.create') }}" class="btn btn-primary mt-3">
            <i class="bi bi-plus-circle"></i> Add New
        </a>
    </div>
</div>
```

## Pagination

Laravel pagination will automatically use the new styles:

```blade
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
        Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} entries
    </div>
    {{ $items->links() }}
</div>
```

## Striped Tables

For alternating row colors:

```blade
<table class="table table-hover table-striped">
    <!-- ... -->
</table>
```

## Responsive Tables

For mobile responsiveness:

```blade
<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover">
            <!-- ... -->
        </table>
    </div>
</div>
```

## Complete Example

```blade
@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Manage Users</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add New User
    </a>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Filter
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">
                <i class="bi bi-x-circle"></i> Clear
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="card p-4">
    <div class="table-container">
        @if($users->count() > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: 14px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            {{ $user->name }}
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->status == 'active')
                            <span class="badge bg-success">
                                <span class="status-dot success"></span>Active
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <span class="status-dot"></span>Inactive
                            </span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h5>No Users Found</h5>
            <p>There are no users matching your criteria.</p>
        </div>
        @endif
    </div>
    
    @if($users->count() > 0)
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
        </div>
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
```

## Features Included

✅ Modern gradient backgrounds
✅ Smooth hover effects
✅ Beautiful status badges with glowing dots
✅ Styled form controls
✅ Responsive design
✅ Custom pagination styling
✅ Empty state designs
✅ Action button groups
✅ Filter bars
✅ Striped table option

All tables in your admin panel will now automatically look modern and professional!
