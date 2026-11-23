@extends('admin.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Add Water Quality Record</h1>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Validation Error!</h4>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.water_quality.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="aquarium_id">Aquarium *</label>
                    <select class="form-control @error('aquarium_id') is-invalid @enderror" 
                            id="aquarium_id" name="aquarium_id" required>
                        <option value="">-- Select Aquarium --</option>
                        @forelse($aquariums ?? [] as $aquarium)
                            <option value="{{ $aquarium->id }}" {{ old('aquarium_id') == $aquarium->id ? 'selected' : '' }}>
                                {{ $aquarium->name }}
                            </option>
                        @empty
                            <option value="">No aquariums available</option>
                        @endforelse
                    </select>
                    @error('aquarium_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="ph_level">pH Level (0-14) *</label>
                    <input type="number" step="0.01" class="form-control @error('ph_level') is-invalid @enderror" 
                           id="ph_level" name="ph_level" placeholder="e.g., 8.0" value="{{ old('ph_level') }}" required>
                    @error('ph_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="temperature">Temperature (°C) *</label>
                    <input type="number" step="0.1" class="form-control @error('temperature') is-invalid @enderror" 
                           id="temperature" name="temperature" placeholder="e.g., 25.5" value="{{ old('temperature') }}" required>
                    @error('temperature')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="ammonia">Ammonia (ppm) *</label>
                    <input type="number" step="0.001" class="form-control @error('ammonia') is-invalid @enderror" 
                           id="ammonia" name="ammonia" placeholder="e.g., 0.25" value="{{ old('ammonia') }}" required>
                    @error('ammonia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nitrite">Nitrite (ppm) *</label>
                    <input type="number" step="0.001" class="form-control @error('nitrite') is-invalid @enderror" 
                           id="nitrite" name="nitrite" placeholder="e.g., 0.10" value="{{ old('nitrite') }}" required>
                    @error('nitrite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nitrate">Nitrate (ppm) *</label>
                    <input type="number" step="0.001" class="form-control @error('nitrate') is-invalid @enderror" 
                           id="nitrate" name="nitrate" placeholder="e.g., 20.50" value="{{ old('nitrate') }}" required>
                    @error('nitrate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="salinity">Salinity (ppt) - Optional</label>
                    <input type="number" step="0.001" class="form-control @error('salinity') is-invalid @enderror" 
                           id="salinity" name="salinity" placeholder="e.g., 1.025" value="{{ old('salinity') }}">
                    @error('salinity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tested_at">Tested At *</label>
                    <input type="datetime-local" class="form-control @error('tested_at') is-invalid @enderror" 
                           id="tested_at" name="tested_at" value="{{ old('tested_at', now()->format('Y-m-d\TH:i')) }}" required>
                    @error('tested_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save Water Quality Record</button>
                    <a href="{{ route('admin.water_quality.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection