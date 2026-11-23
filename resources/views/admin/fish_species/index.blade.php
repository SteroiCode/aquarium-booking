@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="color:#fff;font-weight:700;margin:0;">Fish Species</h4>
        <p style="color:#94a3b8;font-size:13px;margin:2px 0 0;">Manage aquarium fish species</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFishModal">
        <i class="bi bi-plus-lg"></i> Add Fish Species
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
                <th>Image</th><th>Name</th><th>Scientific Name</th>
                <th>Tank Size</th><th>Temperature</th><th>pH</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fishSpecies as $species)
            <tr>
                <td>
                    @if($species->image)
                        <img src="{{ asset('storage/'.$species->image) }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                    @else
                        <div style="width:48px;height:48px;background:#e2e8f0;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-fish text-muted"></i></div>
                    @endif
                </td>
                <td>{{ $species->name }}</td>
                <td><em>{{ $species->scientific_name }}</em></td>
                <td>{{ $species->tank_size }} L</td>
                <td>{{ $species->temperature }}</td>
                <td>{{ $species->ph_level }}</td>
                <td>
                    <a href="{{ route('admin.fish_species.edit', $species->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.fish_species.destroy', $species->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted">No fish species found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add Fish Modal --}}
<div class="modal fade" id="addFishModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,0.08);">
                <h5 class="modal-title" style="color:#fff;font-weight:700;"><i class="bi bi-fish" style="color:#0ea5e9;"></i> Add Fish Species</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.fish_species.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding:24px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Species Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Clownfish" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Scientific Name *</label>
                            <input type="text" name="scientific_name" class="form-control" placeholder="e.g., Amphiprion ocellaris" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Min Tank Size (L) *</label>
                            <input type="number" name="tank_size" class="form-control" placeholder="e.g., 20" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Temperature *</label>
                            <input type="text" name="temperature" class="form-control" placeholder="e.g., 24-26°C" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">pH Level *</label>
                            <input type="text" name="ph_level" class="form-control" placeholder="e.g., 8.0-8.4" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Brief description..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this,'fishImgPreview')">
                            <img id="fishImgPreview" src="" style="display:none;margin-top:8px;max-height:80px;border-radius:8px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,0.08);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Species</button>
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
