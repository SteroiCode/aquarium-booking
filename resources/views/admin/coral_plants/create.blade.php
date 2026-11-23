@extends('admin.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Add Coral & Plant</h1>

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

            <form action="{{ route('admin.coral_plants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" placeholder="e.g., Brain Coral, Java Fern" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="type">Type *</label>
                    <select class="form-control @error('type') is-invalid @enderror" 
                            id="type" name="type" required>
                        <option value="">-- Select Type --</option>
                        <option value="coral" {{ old('type') === 'coral' ? 'selected' : '' }}>Coral</option>
                        <option value="plant" {{ old('type') === 'plant' ? 'selected' : '' }}>Plant</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="light_requirement">Light Requirement *</label>
                    <input type="text" class="form-control @error('light_requirement') is-invalid @enderror" 
                           id="light_requirement" name="light_requirement" placeholder="e.g., High, Medium, Low" value="{{ old('light_requirement') }}" required>
                    @error('light_requirement')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="water_flow">Water Flow Requirement *</label>
                    <input type="text" class="form-control @error('water_flow') is-invalid @enderror" 
                           id="water_flow" name="water_flow" placeholder="e.g., Strong, Moderate, Weak" value="{{ old('water_flow') }}" required>
                    @error('water_flow')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="compatibility">Compatibility Notes</label>
                    <textarea class="form-control @error('compatibility') is-invalid @enderror" 
                              id="compatibility" name="compatibility" rows="2" placeholder="Enter compatibility notes">{{ old('compatibility') }}</textarea>
                    @error('compatibility')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="image">Image (optional)</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save Coral & Plant</button>
                    <a href="{{ route('admin.coral_plants.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection