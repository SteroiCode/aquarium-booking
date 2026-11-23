@extends('layout')

@section('hero')
<div class="hero">
    <div class="hero-content container">
        <h1 data-aos="fade-up">{{ __('app.welcome') }}</h1>
        <p data-aos="fade-up" data-aos-delay="100">{{ __('app.welcome_sub') }}</p>
        <a href="#aquariums" class="btn btn-primary btn-lg" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-ticket-perforated"></i> {{ __('app.book_now') }}
        </a>
    </div>
</div>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success" data-aos="fade-down">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- AVAILABLE AQUARIUMS SECTION -->
<div id="aquariums" class="mb-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="display-5 fw-bold mb-3">
            <i class="bi bi-water"></i> Available Aquariums
        </h2>
        <p class="text-muted">Discover amazing underwater experiences</p>
    </div>

    <div class="row g-4 mb-5">
    @foreach($aquariums as $index => $aqua)
    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
        <div class="card shadow h-100">
            @if($aqua->image)
            <img src="{{ asset('storage/'.$aqua->image) }}" 
                 alt="{{ $aqua->name }}" 
                 class="card-img-top">
            @else
            <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800" 
                 alt="{{ $aqua->name }}" 
                 class="card-img-top">
            @endif

            <div class="card-body d-flex flex-column">
                <h5 class="card-title">
                    <i class="bi bi-building"></i> {{ $aqua->name }}
                </h5>
                <p class="card-text text-muted mb-3">
                    <i class="bi bi-geo-alt"></i> {{ $aqua->location }}
                </p>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-success fs-6">
                        <i class="bi bi-tag"></i> ${{ number_format($aqua->price, 2) }}
                    </span>
                    <span class="text-muted small">per ticket</span>
                </div>

                <a href="{{ route('booking.form', $aqua->id) }}" 
                   class="btn btn-primary mt-auto w-100">
                    <i class="bi bi-calendar-check"></i> {{ __('app.book_now') }}
                </a>
            </div>
        </div>
    </div>
    @endforeach
    </div>
</div>

<!-- FISH SPECIES SECTION -->
@if(count($fishSpecies ?? []) > 0)
<hr class="my-5" style="border-color: rgba(255, 255, 255, 0.1);">
<div class="mb-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="display-5 fw-bold mb-3">
            <i class="bi bi-fish"></i> {{ __('app.featured_fish') }}
        </h2>
        <p class="text-muted">{{ __('app.featured_fish_sub') }}</p>
    </div>

    <div class="row g-4 mb-5">
    @foreach($fishSpecies as $index => $fish)
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
            <div class="card shadow h-100">
                @if($fish->image)
                    <img src="{{ asset('storage/' . $fish->image) }}" alt="{{ $fish->name }}"
                         style="width:100%;height:200px;object-fit:cover;border-radius:12px 12px 0 0;">
                @else
                    <div style="width:100%;height:200px;background:linear-gradient(135deg,#0ea5e9,#06b6d4);border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-fish" style="font-size:60px;color:rgba(255,255,255,0.5);"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $fish->name }}</h5>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-journal-text"></i> <em>{{ $fish->scientific_name }}</em>
                    </p>
                    
                    <p class="card-text small mb-3">{{ Str::limit($fish->description, 100) }}</p>
                    
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 rounded" style="background: rgba(14, 165, 233, 0.1);">
                                <small class="d-block text-muted">Tank Size</small>
                                <strong>{{ $fish->tank_size }} gal</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded" style="background: rgba(14, 165, 233, 0.1);">
                                <small class="d-block text-muted">Temperature</small>
                                <strong>{{ $fish->temperature }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-2 rounded" style="background: rgba(14, 165, 233, 0.1);">
                                <small class="d-block text-muted">pH Level</small>
                                <strong>{{ $fish->ph_level }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endif

<!-- CORAL & PLANTS SECTION -->
@if(count($coralPlants ?? []) > 0)
<hr class="my-5" style="border-color: rgba(255, 255, 255, 0.1);">
<div class="mb-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="display-5 fw-bold mb-3">
            <i class="bi bi-flower1"></i> {{ __('app.coral_collection') }}
        </h2>
        <p class="text-muted">{{ __('app.coral_sub') }}</p>
    </div>

    <div class="row g-4 mb-5">
    @foreach($coralPlants as $index => $item)
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
            <div class="card shadow h-100">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                         style="width:100%;height:200px;object-fit:cover;border-radius:12px 12px 0 0;">
                @else
                    <div style="width:100%;height:200px;background:linear-gradient(135deg,#06b6d4,#10b981);border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-flower1" style="font-size:60px;color:rgba(255,255,255,0.5);"></i>
                    </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0">{{ $item->name }}</h5>
                        @if($item->type === 'coral')
                            <span class="badge bg-warning">
                                <i class="bi bi-gem"></i> Coral
                            </span>
                        @else
                            <span class="badge bg-success">
                                <i class="bi bi-flower2"></i> Plant
                            </span>
                        @endif
                    </div>
                    
                    <p class="card-text small mb-3">{{ Str::limit($item->description, 100) }}</p>
                    
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 rounded" style="background: rgba(6, 182, 212, 0.1);">
                                <small class="d-block text-muted">
                                    <i class="bi bi-sun"></i> Light
                                </small>
                                <strong class="small">{{ $item->light_requirement }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded" style="background: rgba(6, 182, 212, 0.1);">
                                <small class="d-block text-muted">
                                    <i class="bi bi-water"></i> Flow
                                </small>
                                <strong class="small">{{ $item->water_flow }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>


</div>
@endif

<!-- WATER QUALITY SECTION -->
@if(count($waterQualities ?? []) > 0)
<hr class="my-5" style="border-color: rgba(255, 255, 255, 0.1);">
<div class="mb-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="display-5 fw-bold mb-3">
            <i class="bi bi-droplet"></i> {{ __('app.water_quality_heading') }}
        </h2>
        <p class="text-muted">{{ __('app.water_quality_sub') }}</p>
    </div>

    <div class="table-responsive" data-aos="fade-up">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><i class="bi bi-building"></i> Aquarium</th>
                    <th><i class="bi bi-thermometer-half"></i> pH</th>
                    <th><i class="bi bi-thermometer"></i> Temp</th>
                    <th>Ammonia</th>
                    <th>Nitrite</th>
                    <th>Nitrate</th>
                    <th><i class="bi bi-clock"></i> Last Tested</th>
                </tr>
            </thead>
            <tbody>
                @foreach($waterQualities as $quality)
                    <tr>
                        <td><strong>{{ $quality->aquarium->name ?? 'N/A' }}</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $quality->ph_level }}</span>
                        </td>
                        <td>{{ $quality->temperature }}°C</td>
                        <td>
                            @if($quality->ammonia > 0.5)
                                <span class="badge bg-danger">{{ $quality->ammonia }}</span>
                            @else
                                <span class="badge bg-success">{{ $quality->ammonia }}</span>
                            @endif
                        </td>
                        <td>
                            @if($quality->nitrite > 0.5)
                                <span class="badge bg-danger">{{ $quality->nitrite }}</span>
                            @else
                                <span class="badge bg-success">{{ $quality->nitrite }}</span>
                            @endif
                        </td>
                        <td>
                            @if($quality->nitrate > 40)
                                <span class="badge bg-warning">{{ $quality->nitrate }}</span>
                            @else
                                <span class="badge bg-success">{{ $quality->nitrate }}</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ \Carbon\Carbon::parse($quality->tested_at)->diffForHumans() }}</small></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>
@endif

@endsection