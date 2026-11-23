@extends('admin.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Edit Fish Species</h1>

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

            <form action="{{ route('admin.fish_species.update', $fishSpecies->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name">Species Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $fishSpecies->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="scientific_name">Scientific Name *</label>
                    <input type="text" class="form-control @error('scientific_name') is-invalid @enderror" 
                           id="scientific_name" name="scientific_name" value="{{ old('scientific_name', $fishSpecies->scientific_name) }}" required>
                    @error('scientific_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $fishSpecies->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tank_size">Minimum Tank Size (Liters) *</label>
                    <input type="number" class="form-control @error('tank_size') is-invalid @enderror" 
                           id="tank_size" name="tank_size" value="{{ old('tank_size', $fishSpecies->tank_size) }}" required>
                    @error('tank_size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="temperature">Temperature Range *</label>
                    <input type="text" class="form-control @error('temperature') is-invalid @enderror" 
                           id="temperature" name="temperature" value="{{ old('temperature', $fishSpecies->temperature) }}" required>
                    @error('temperature')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="ph_level">pH Level Range *</label>
                    <input type="text" class="form-control @error('ph_level') is-invalid @enderror" 
                           id="ph_level" name="ph_level" value="{{ old('ph_level', $fishSpecies->ph_level) }}" required>
                    @error('ph_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="image">Image</label>
                    @if($fishSpecies->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $fishSpecies->image) }}" alt="Current image"
                                 style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*">
                    <small class="text-muted">Leave empty to keep current image.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update Fish Species</button>
                    <a href="{{ route('admin.fish_species.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection