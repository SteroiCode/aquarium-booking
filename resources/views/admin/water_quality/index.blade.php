@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="color:#fff;font-weight:700;margin:0;">Water Quality</h4>
        <p style="color:#94a3b8;font-size:13px;margin:2px 0 0;">Monitor aquarium water conditions</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWaterModal">
        <i class="bi bi-plus-lg"></i> Add Record
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
                <th>Aquarium</th><th>pH</th><th>Temp</th>
                <th>Ammonia</th><th>Nitrite</th><th>Nitrate</th>
                <th>Salinity</th><th>Tested At</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($waterQualities as $quality)
            <tr>
                <td>{{ $quality->aquarium->name ?? 'N/A' }}</td>
                <td><span class="badge bg-info">{{ $quality->ph_level }}</span></td>
                <td>{{ $quality->temperature }}°C</td>
                <td>
                    <span class="badge {{ $quality->ammonia > 0.5 ? 'bg-danger' : 'bg-success' }}">{{ $quality->ammonia }}</span>
                </td>
                <td>
                    <span class="badge {{ $quality->nitrite > 0.5 ? 'bg-danger' : 'bg-success' }}">{{ $quality->nitrite }}</span>
                </td>
                <td>
                    <span class="badge {{ $quality->nitrate > 40 ? 'bg-warning' : 'bg-success' }}">{{ $quality->nitrate }}</span>
                </td>
                <td>{{ $quality->salinity ?? '-' }}</td>
                <td style="font-size:12px;">{{ $quality->tested_at->format('d M Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.water_quality.edit', $quality->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.water_quality.destroy', $quality->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center py-4 text-muted">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Add Water Quality Modal --}}
<div class="modal fade" id="addWaterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background:#1e293b;border:1px solid rgba(14,165,233,0.3);border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,0.08);">
                <h5 class="modal-title" style="color:#fff;font-weight:700;"><i class="bi bi-droplet" style="color:#0ea5e9;"></i> Add Water Quality Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.water_quality.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:24px;">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Aquarium *</label>
                            <select name="aquarium_id" class="form-select" required>
                                <option value="">-- Select Aquarium --</option>
                                @foreach($aquariums as $aq)
                                    <option value="{{ $aq->id }}">{{ $aq->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">pH Level *</label>
                            <input type="number" step="0.01" name="ph_level" class="form-control" placeholder="e.g., 8.0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Temperature (°C) *</label>
                            <input type="number" step="0.1" name="temperature" class="form-control" placeholder="e.g., 25.5" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Salinity</label>
                            <input type="number" step="0.1" name="salinity" class="form-control" placeholder="e.g., 35">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ammonia (ppm) *</label>
                            <input type="number" step="0.001" name="ammonia" class="form-control" placeholder="e.g., 0.25" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nitrite (ppm) *</label>
                            <input type="number" step="0.001" name="nitrite" class="form-control" placeholder="e.g., 0.1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nitrate (ppm) *</label>
                            <input type="number" step="0.01" name="nitrate" class="form-control" placeholder="e.g., 20" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,0.08);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
