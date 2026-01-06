@extends('layouts.frontend')

@section('content')

<div class="contact-page-wrapper">
    <div class="container">
        <div class="contact-layout">
            
            <!-- Left Side: Contact Details -->
            <div class="contact-info">
                <h1>Contact Us</h1>
                <p>Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                
                <div class="info-item">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <h4>Phone</h4>
                        <p>+254 700 000 000</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h4>Email</h4>
                        <p>support@carbooking.test</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h4>Location</h4>
                        <p>Nairobi, Kenya</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Contact Form -->
           <div class="contact-form">
    <h1>Contact Us</h1>

    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST">
        @csrf

        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Your Message:</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Send Message</button>
    </form>
</div>


@endsection