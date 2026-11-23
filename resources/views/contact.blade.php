@extends('layout')

@section('content')
<style>
    /* ── Contact page — dark theme overrides ── */
    .contact-card {
        background: rgba(30,41,59,0.9);
        border: 1px solid rgba(14,165,233,0.3);
        border-radius: 20px;
    }
    .contact-heading { color: #f1f5f9; }
    .contact-label   { color: #e2e8f0; font-weight: 600; font-size: 14px; }
    .contact-muted   { color: #cbd5e1; }
    .contact-subtext { color: #94a3b8; font-size: 13px; }

    /* Form inputs — dark style */
    .contact-input {
        width: 100%;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(14,165,233,0.35);
        color: #fff;
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }
    .contact-input:focus { border-color: #0ea5e9; background: rgba(255,255,255,0.1); }
    .contact-input::placeholder { color: #64748b; }
    .contact-input.is-invalid { border-color: #ef4444; }

    /* Accordion — dark style */
    .contact-accordion .accordion-item {
        background: rgba(30,41,59,0.9);
        border: 1px solid rgba(14,165,233,0.2);
        border-radius: 12px !important;
        margin-bottom: 8px;
        overflow: hidden;
    }
    .contact-accordion .accordion-button {
        background: rgba(30,41,59,0.9);
        color: #f1f5f9;
        font-weight: 600;
        font-size: 15px;
        border-radius: 12px !important;
        box-shadow: none;
    }
    .contact-accordion .accordion-button:not(.collapsed) {
        background: rgba(14,165,233,0.15);
        color: #38bdf8;
    }
    .contact-accordion .accordion-button::after {
        filter: brightness(10);
    }
    .contact-accordion .accordion-body {
        background: rgba(15,23,42,0.6);
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.7;
        border-top: 1px solid rgba(14,165,233,0.15);
    }

    /* Map instruction bar */
    .map-info {
        background: rgba(30,41,59,0.9);
        border-top: 1px solid rgba(14,165,233,0.2);
        padding: 12px 16px;
    }
    .map-info small { color: #94a3b8; font-size: 12px; }
    .map-info a { color: #38bdf8; }
    .map-info code { color: #a78bfa; background: rgba(167,139,250,0.1); padding: 1px 5px; border-radius: 4px; }

    /* Social buttons */
    .social-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 16px;
        border: 1px solid rgba(255,255,255,0.15);
        color: #cbd5e1;
        text-decoration: none;
        transition: all 0.2s;
    }
    .social-btn:hover { color: #fff; border-color: #0ea5e9; background: rgba(14,165,233,0.2); }

    /* Divider inside info card */
    .contact-divider { border-top: 1px solid rgba(255,255,255,0.08); margin: 20px 0; }

    /* Section title */
    .faq-title { color: #f1f5f9; font-weight: 700; text-align: center; margin-bottom: 24px; }
    .map-title { color: #f1f5f9; font-weight: 700; padding: 20px 24px 16px; border-bottom: 1px solid rgba(14,165,233,0.2); margin: 0; }
</style>

<div class="container py-5">

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3" style="color:#f1f5f9;">Contact Us</h1>
        <p class="lead contact-muted">We'd love to hear from you! Get in touch with us.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
             style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.4);color:#6ee7b7;border-radius:12px;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        <!-- ── Contact Information ── -->
        <div class="col-lg-4">
            <div class="contact-card p-4 h-100">
                <h4 class="contact-heading mb-4">Get In Touch</h4>

                <!-- Address -->
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div style="width:46px;height:46px;background:rgba(14,165,233,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-geo-alt-fill text-primary fs-5"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="contact-heading fw-bold mb-1">Address</h6>
                        <p class="contact-muted mb-0" style="font-size:13px;">
                            123 Ocean Boulevard<br>
                            Phnom Penh, Cambodia<br>
                            12000
                        </p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div style="width:46px;height:46px;background:rgba(16,185,129,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-telephone-fill text-success fs-5"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="contact-heading fw-bold mb-1">Phone</h6>
                        <p class="contact-muted mb-0" style="font-size:13px;">{{ $contactPhone }}</p>
                        <p class="contact-subtext mb-0">+855 12 345 678 (Mobile)</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div style="width:46px;height:46px;background:rgba(6,182,212,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-envelope-fill text-info fs-5"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="contact-heading fw-bold mb-1">Email</h6>
                        <p class="contact-muted mb-0" style="font-size:13px;">{{ $contactEmail }}</p>
                        <p class="contact-subtext mb-0">support@oceanblue.com</p>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div style="width:46px;height:46px;background:rgba(245,158,11,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-clock-fill text-warning fs-5"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="contact-heading fw-bold mb-1">Business Hours</h6>
                        <p class="contact-muted mb-0" style="font-size:13px;">Mon–Fri: {{ $businessHoursStart }} – {{ $businessHoursEnd }}</p>
                        <p class="contact-subtext mb-0">Saturday: 10:00 AM – 8:00 PM</p>
                        <p class="contact-subtext mb-0">Sunday: 10:00 AM – 6:00 PM</p>
                    </div>
                </div>

                <!-- Social -->
                <div class="contact-divider"></div>
                <h6 class="contact-heading fw-bold mb-3">Follow Us</h6>
                <div class="d-flex gap-2">
                    <a href="#" class="social-btn"><i class="bi bi-facebook" style="color:#3b82f6;"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-twitter" style="color:#38bdf8;"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-instagram" style="color:#ec4899;"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-whatsapp" style="color:#22c55e;"></i></a>
                </div>
            </div>
        </div>

        <!-- ── Contact Form ── -->
        <div class="col-lg-8">
            <div class="contact-card p-4">
                <h4 class="contact-heading mb-4">Send Us a Message</h4>

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="contact-label d-block mb-2">Your Name <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="name" placeholder="Enter your full name"
                                   class="contact-input @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="contact-label d-block mb-2">Your Email <span style="color:#ef4444;">*</span></label>
                            <input type="email" name="email" placeholder="your@email.com"
                                   class="contact-input @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="contact-label d-block mb-2">Subject <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="subject" placeholder="How can we help?"
                                   class="contact-input @error('subject') is-invalid @enderror"
                                   value="{{ old('subject') }}" required>
                            @error('subject')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="contact-label d-block mb-2">Message <span style="color:#ef4444;">*</span></label>
                            <textarea name="message" rows="6" placeholder="Tell us more..."
                                      class="contact-input @error('message') is-invalid @enderror"
                                      required style="resize:vertical;">{{ old('message') }}</textarea>
                            @error('message')<div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <button type="submit"
                                    style="background:linear-gradient(135deg,#0ea5e9,#06b6d4);border:none;color:#fff;font-weight:700;font-size:15px;padding:13px 32px;border-radius:50px;cursor:pointer;">
                                <i class="bi bi-send"></i> Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ── Map ── -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="contact-card overflow-hidden">
                <h4 class="map-title">Find Us Here</h4>
                <div class="ratio ratio-21x9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125422.39093043!2d104.82490779726562!3d11.556374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513dc76a6be3%3A0x9c010ee85ab525bb!2sPhnom%20Penh%2C%20Cambodia!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="map-info">
                    <small>
                        <i class="bi bi-info-circle"></i>
                        <strong style="color:#cbd5e1;">To update this map:</strong>
                        Go to <a href="https://www.google.com/maps" target="_blank">Google Maps</a>,
                        find your location, click "Share" → "Embed a map" → Copy the iframe code and replace it in
                        <code>resources/views/contact.blade.php</code>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- ── FAQ ── -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="faq-title">Frequently Asked Questions</h3>
            <div class="accordion contact-accordion" id="faqAccordion">

                @foreach([
                    ['faq1', true,  'What are your visiting hours?',
                     'We are open Monday to Friday from '.$businessHoursStart.' to '.$businessHoursEnd.', Saturday from 10:00 AM to 8:00 PM, and Sunday from 10:00 AM to 6:00 PM.'],
                    ['faq2', false, 'How do I book tickets?',
                     'You can book tickets online through our website by selecting your preferred aquarium and date. After registration, choose from our available aquariums and complete the booking process.'],
                    ['faq3', false, 'What payment methods do you accept?',
                     'We accept KHQR payments through Bakong. After booking, you\'ll receive a QR code to scan and complete your payment.'],
                    ['faq4', false, 'Can I cancel or reschedule my booking?',
                     'Yes, you can cancel or reschedule your booking up to 24 hours before your visit date. Please contact us via email or phone to make changes.'],
                    ['faq5', false, 'Do you offer group discounts?',
                     'Yes! We offer special rates for groups of 10 or more people. Please contact us at '.$contactEmail.' for group booking inquiries.'],
                ] as [$id, $open, $question, $answer])
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ $open ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#{{ $id }}">
                            {{ $question }}
                        </button>
                    </h2>
                    <div id="{{ $id }}" class="accordion-collapse collapse {{ $open ? 'show' : '' }}"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body">{{ $answer }}</div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

</div>
@endsection
