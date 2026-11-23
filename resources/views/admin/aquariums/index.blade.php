@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="color:#fff;font-weight:700;margin:0;">Aquariums</h4>
        <p style="color:#94a3b8;font-size:13px;margin:2px 0 0;">Manage all aquarium listings</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAquariumModal">
        <i class="bi bi-plus-lg"></i> Add Aquarium
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-container">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aquariums as $aqua)
            <tr>
                <td>{{ $aqua->name }}</td>
                <td>{{ $aqua->location }}</td>
                <td>{{ Str::limit($aqua->description, 60) }}</td>
                <td>${{ number_format($aqua->price, 2) }}</td>
                <td>
                    @if($aqua->image)
                        <img src="{{ asset('storage/'.$aqua->image) }}" width="60" height="60" style="object-fit:cover;border-radius:8px;">
                    @else
                        <span class="badge bg-secondary">No Image</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.aquariums.edit', $aqua->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.aquariums.destroy', $aqua->id) }}" method="POST"
                          style="display:inline;" onsubmit="return confirm('Delete {{ $aqua->name }}?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Add Aquarium Modal --}}
<div class="modal fade" id="addAquariumModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,0.08);">
                <h5 class="modal-title" style="color:#fff;font-weight:700;">
                    <i class="bi bi-building" style="color:#0ea5e9;"></i> Add Aquarium
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.aquariums.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding:24px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Ocean World" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location *</label>
                            <input type="text" name="location" class="form-control" placeholder="e.g., Phnom Penh" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price per Ticket ($) *</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" placeholder="e.g., 15.00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" id="aqImgInput" class="form-control" accept="image/*" onchange="previewImg(this,'aqImgPreview')">
                            <img id="aqImgPreview" src="" style="display:none;margin-top:8px;max-height:80px;border-radius:8px;">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Describe the aquarium..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,0.08);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Aquarium</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
