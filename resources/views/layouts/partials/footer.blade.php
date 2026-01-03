{{-- <footer class="footer">
    <div class="container footer-grid">

        <div>
            <h4>CarBooking</h4>
            <p>Reliable car rentals for business & leisure.</p>
        </div>

        <div>
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('cars.index') }}">Cars</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>

        <div>
            <h4>Contact</h4>
            <p>📞 +254 700 000 000</p>
            <p>✉ support@carbooking.test</p>
        </div>

    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} Car Booking System. All rights reserved.
    </div>
</footer> --}}

<footer class="footer">
    <div class="container footer-grid">

        <div class="footer-about">
            <h4>CarBooking</h4>
            <p>Reliable car rentals for business & leisure.</p>
            
            <!-- Fix: Added Social Icons -->
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>

        <div>
            <h4>Quick Links</h4>
            <!-- Fix: Added class 'footer-list' to hide dots -->
            <ul class="footer-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('cars.index') }}">Cars</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>

        <div>
            <h4>Contact</h4>
            <p>📞 +254 700 000 000</p>
            <p>✉ support@carbooking.test</p>
        </div>

    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} Car Booking System. All rights reserved.
    </div>
</footer>