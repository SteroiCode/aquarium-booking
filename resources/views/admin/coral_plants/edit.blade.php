@extends('admin.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Edit Coral & Plant</h1>

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

            <form action="{{ route('admin.coral_plants.update', $coralPlant->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $coralPlant->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="type">Type *</label>
                    <select class="form-control @error('type') is-invalid @enderror" 
                            id="type" name="type" required>
                        <option value="coral" {{ old('type', $coralPlant->type) === 'coral' ? 'selected' : '' }}>Coral</option>
                        <option value="plant" {{ old('type', $coralPlant->type) === 'plant' ? 'selected' : '' }}>Plant</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $coralPlant->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="light_requirement">Light Requirement *</label>
                    <input type="text" class="form-control @error('light_requirement') is-invalid @enderror" 
                           id="light_requirement" name="light_requirement" value="{{ old('light_requirement', $coralPlant->light_requirement) }}" required>
                    @error('light_requirement')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="water_flow">Water Flow Requirement *</label>
                    <input type="text" class="form-control @error('water_flow') is-invalid @enderror" 
                           id="water_flow" name="water_flow" value="{{ old('water_flow', $coralPlant->water_flow) }}" required>
                    @error('water_flow')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="compatibility">Compatibility Notes</label>
                    <textarea class="form-control @error('compatibility') is-invalid @enderror" 
                              id="compatibility" name="compatibility" rows="2">{{ old('compatibility', $coralPlant->compatibility) }}</textarea>
                    @error('compatibility')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="image">Image</label>
                    @if($coralPlant->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $coralPlant->image) }}" alt="Current image"
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
                    <button type="submit" class="btn btn-success">Update Coral & Plant</button>
                    <a href="{{ route('admin.coral_plants.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection