@extends('admin.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Edit Water Quality Record</h1>

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

            <form action="{{ route('admin.water_quality.update', $waterQuality->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="aquarium_id">Aquarium *</label>
                    <select class="form-control @error('aquarium_id') is-invalid @enderror" 
                            id="aquarium_id" name="aquarium_id" required>
                        @forelse($aquariums ?? [] as $aquarium)
                            <option value="{{ $aquarium->id }}" {{ old('aquarium_id', $waterQuality->aquarium_id) == $aquarium->id ? 'selected' : '' }}>
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
                           id="ph_level" name="ph_level" value="{{ old('ph_level', $waterQuality->ph_level) }}" required>
                    @error('ph_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="temperature">Temperature (°C) *</label>
                    <input type="number" step="0.1" class="form-control @error('temperature') is-invalid @enderror" 
                           id="temperature" name="temperature" value="{{ old('temperature', $waterQuality->temperature) }}" required>
                    @error('temperature')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="ammonia">Ammonia (ppm) *</label>
                    <input type="number" step="0.001" class="form-control @error('ammonia') is-invalid @enderror" 
                           id="ammonia" name="ammonia" value="{{ old('ammonia', $waterQuality->ammonia) }}" required>
                    @error('ammonia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nitrite">Nitrite (ppm) *</label>
                    <input type="number" step="0.001" class="form-control @error('nitrite') is-invalid @enderror" 
                           id="nitrite" name="nitrite" value="{{ old('nitrite', $waterQuality->nitrite) }}" required>
                    @error('nitrite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nitrate">Nitrate (ppm) *</label>
                    <input type="number" step="0.001" class="form-control @error('nitrate') is-invalid @enderror" 
                           id="nitrate" name="nitrate" value="{{ old('nitrate', $waterQuality->nitrate) }}" required>
                    @error('nitrate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="salinity">Salinity (ppt) - Optional</label>
                    <input type="number" step="0.001" class="form-control @error('salinity') is-invalid @enderror" 
                           id="salinity" name="salinity" value="{{ old('salinity', $waterQuality->salinity) }}">
                    @error('salinity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tested_at">Tested At *</label>
                    <input type="datetime-local" class="form-control @error('tested_at') is-invalid @enderror" 
                           id="tested_at" name="tested_at" value="{{ old('tested_at', $waterQuality->tested_at->format('Y-m-d\TH:i')) }}" required>
                    @error('tested_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update Water Quality Record</button>
                    <a href="{{ route('admin.water_quality.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection