@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="color:#fff;font-weight:700;margin:0;">Coral & Plants</h4>
        <p style="color:#94a3b8;font-size:13px;margin:2px 0 0;">Manage coral and plant species</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoralModal">
        <i class="bi bi-plus-lg"></i> Add Coral & Plant
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
                <th>Image</th><th>Name</th><th>Type</th>
                <th>Light</th><th>Water Flow</th><th>Compatibility</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coralPlants as $item)
            <tr>
                <td>
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                    @else
                        <div style="width:48px;height:48px;background:#e2e8f0;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-flower1 text-muted"></i></div>
                    @endif
                </td>
                <td>{{ $item->name }}</td>
                <td>
                    @if($item->type === 'coral')
                        <span class="badge bg-warning">Coral</span>
                    @else
                        <span class="badge bg-success">Plant</span>
                    @endif
                </td>
                <td>{{ $item->light_requirement }}</td>
                <td>{{ $item->water_flow }}</td>
                <td>{{ $item->compatibility ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.coral_plants.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.coral_plants.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted">No coral & plants found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add Coral Modal --}}
<div class="modal fade" id="addCoralModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,0.08);">
                <h5 class="modal-title" style="color:#fff;font-weight:700;"><i class="bi bi-flower1" style="color:#0ea5e9;"></i> Add Coral & Plant</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.coral_plants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding:24px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Brain Coral" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type *</label>
                            <select name="type" class="form-select" required>
                                <option value="">-- Select Type --</option>
                                <option value="coral">Coral</option>
                                <option value="plant">Plant</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Light Requirement *</label>
                            <input type="text" name="light_requirement" class="form-control" placeholder="e.g., High, Medium, Low" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Water Flow *</label>
                            <input type="text" name="water_flow" class="form-control" placeholder="e.g., Strong, Moderate" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Compatibility</label>
                            <input type="text" name="compatibility" class="form-control" placeholder="e.g., Reef-safe, Fish-only">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Brief description..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this,'coralImgPreview')">
                            <img id="coralImgPreview" src="" style="display:none;margin-top:8px;max-height:80px;border-radius:8px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,0.08);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add</button>
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
