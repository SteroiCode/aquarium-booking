@extends('layout')

@section('content')
<style>
    /* About page — all text sits on the dark navy layout background */
    .about-muted   { color: #cbd5e1; }          /* body/paragraph text — clearly readable */
    .about-label   { color: #94a3b8; }           /* secondary/small labels */
    .about-heading { color: #f1f5f9; }           /* h2–h5 headings */

    /* Achievements & CTA sections have a tinted dark box */
    .about-dark-box          { background: rgba(14,165,233,0.08); border: 1px solid rgba(14,165,233,0.2); border-radius: 16px; }
    .about-dark-box h2,
    .about-dark-box h5       { color: #f1f5f9; }
    .about-dark-box .about-muted { color: #cbd5e1; }
</style>

<div class="container py-5">

    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-3 fw-bold mb-3" style="color:#f1f5f9;">About {{ $siteName }}</h1>
        <p class="lead about-muted">Discover the wonders of marine life in Cambodia's premier aquarium destination</p>
    </div>

    <!-- Our Story -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&h=600&fit=crop"
                 alt="Aquarium" class="img-fluid rounded shadow">
        </div>
        <div class="col-lg-6">
            <h2 class="mb-4 about-heading">Our Story</h2>
            <p class="about-muted">
                Founded in 2020, {{ $siteName }} has become Cambodia's leading marine education and conservation center.
                Our mission is to inspire wonder and respect for the ocean's incredible biodiversity while promoting
                sustainable practices and marine conservation.
            </p>
            <p class="about-muted">
                With over 10,000 marine animals representing 500+ species from around the world, we offer an
                immersive experience that educates and entertains visitors of all ages. From colorful tropical fish
                to majestic sharks and graceful rays, our exhibits showcase the beauty and diversity of aquatic life.
            </p>
            <p class="about-muted">
                We are committed to conservation, research, and education, working closely with international
                organizations to protect endangered species and their habitats.
            </p>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                        <i class="bi bi-bullseye text-primary fs-1"></i>
                    </div>
                    <h3 class="mb-3 about-heading">Our Mission</h3>
                    <p class="about-muted">
                        To inspire conservation of the aquatic world through education, research, and unforgettable
                        experiences. We strive to connect people with marine life and foster a deeper understanding
                        of ocean ecosystems.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                        <i class="bi bi-eye text-success fs-1"></i>
                    </div>
                    <h3 class="mb-3 about-heading">Our Vision</h3>
                    <p class="about-muted">
                        To be Southeast Asia's most innovative and sustainable aquarium, setting the standard for
                        marine conservation and education. We envision a future where every visitor becomes an
                        advocate for ocean protection.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="about-dark-box p-5 mb-5">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="display-4 fw-bold text-primary">10K+</div>
                <p class="about-muted mb-0">Marine Animals</p>
            </div>
            <div class="col-md-3 col-6">
                <div class="display-4 fw-bold text-primary">500+</div>
                <p class="about-muted mb-0">Species</p>
            </div>
            <div class="col-md-3 col-6">
                <div class="display-4 fw-bold text-primary">12</div>
                <p class="about-muted mb-0">Aquarium Zones</p>
            </div>
            <div class="col-md-3 col-6">
                <div class="display-4 fw-bold text-primary">100K+</div>
                <p class="about-muted mb-0">Annual Visitors</p>
            </div>
        </div>
    </div>

    <!-- Our Values -->
    <div class="mb-5">
        <h2 class="text-center mb-5 about-heading">Our Core Values</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-info bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-heart-fill text-info fs-1"></i>
                    </div>
                    <h4 class="about-heading">Conservation</h4>
                    <p class="about-muted">
                        Protecting marine ecosystems and endangered species through active conservation programs
                        and partnerships with global organizations.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-book-fill text-warning fs-1"></i>
                    </div>
                    <h4 class="about-heading">Education</h4>
                    <p class="about-muted">
                        Providing engaging educational programs for schools, families, and researchers to learn
                        about marine biology and ocean conservation.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-recycle text-success fs-1"></i>
                    </div>
                    <h4 class="about-heading">Sustainability</h4>
                    <p class="about-muted">
                        Operating with minimal environmental impact through renewable energy, water conservation,
                        and sustainable practices in all our operations.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="mb-5">
        <h2 class="text-center mb-5 about-heading">Meet Our Team</h2>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle mx-auto mb-3"
                             style="width:100px;height:100px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill text-primary" style="font-size:3rem;"></i>
                        </div>
                        <h5 class="mb-1 about-heading">Dr. Sophea Chan</h5>
                        <p class="about-label small mb-2">Director &amp; Marine Biologist</p>
                        <p class="about-muted small">20+ years of marine research experience</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 text-center">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle mx-auto mb-3"
                             style="width:100px;height:100px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill text-success" style="font-size:3rem;"></i>
                        </div>
                        <h5 class="mb-1 about-heading">Virak Phan</h5>
                        <p class="about-label small mb-2">Head of Conservation</p>
                        <p class="about-muted small">Expert in coral reef restoration</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 text-center">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle mx-auto mb-3"
                             style="width:100px;height:100px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill text-info" style="font-size:3rem;"></i>
                        </div>
                        <h5 class="mb-1 about-heading">Sreymom Lim</h5>
                        <p class="about-label small mb-2">Education Coordinator</p>
                        <p class="about-muted small">Passionate about marine education</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 text-center">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle mx-auto mb-3"
                             style="width:100px;height:100px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill text-warning" style="font-size:3rem;"></i>
                        </div>
                        <h5 class="mb-1 about-heading">Dara Sok</h5>
                        <p class="about-label small mb-2">Operations Manager</p>
                        <p class="about-muted small">Ensuring excellent visitor experiences</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements -->
    <div class="about-dark-box p-5 mb-5">
        <h2 class="text-center mb-5 about-heading">Our Achievements</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-award-fill text-primary fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="about-heading">Best Aquarium in Southeast Asia 2024</h5>
                        <p class="about-muted mb-0">Awarded by International Aquarium Association</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-trophy-fill text-success fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="about-heading">Conservation Excellence Award 2023</h5>
                        <p class="about-muted mb-0">For outstanding coral reef restoration program</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-star-fill text-warning fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="about-heading">TripAdvisor Certificate of Excellence</h5>
                        <p class="about-muted mb-0">5 consecutive years of outstanding reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-patch-check-fill text-info fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="about-heading">Green Tourism Certification</h5>
                        <p class="about-muted mb-0">Recognized for sustainable tourism practices</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center about-dark-box p-5">
        <h2 class="mb-3 about-heading">Ready to Explore?</h2>
        <p class="lead about-muted mb-4">Book your visit today and discover the wonders of the ocean!</p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-2">
            <i class="bi bi-ticket-perforated"></i> Book Tickets
        </a>
        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg" style="color:#38bdf8;border-color:#38bdf8;">
            <i class="bi bi-envelope"></i> Contact Us
        </a>
    </div>

</div>
@endsection
