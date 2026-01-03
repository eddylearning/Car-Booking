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
                <form>
                    <label>Name</label>
                    <input type="text" placeholder="Your Name" required>

                    <label>Email</label>
                    <input type="email" placeholder="Your Email" required>

                    <label>Message</label>
                    <textarea rows="5" placeholder="How can we help?" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection