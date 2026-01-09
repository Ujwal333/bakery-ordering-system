<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>Cinnamon Bakery</h3>
                <p>Artisan bakery crafting delicious treats since 2010. Quality ingredients, traditional methods, modern flavors.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('browse-menu') }}">Browse Menu</a></li>
                    <li><a href="{{ route('custom-cake') }}">Custom Cakes</a></li>
                    <li><a href="{{ route('order-tracking') }}">Order Tracking</a></li>
                    <li><a href="{{ route('about') }}">About / Events</a></li>
                    <li><a href="{{ route('features') }}">Features</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Contact Us</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> Sano Bharayang, Kathmandu, Nepal</li>
                    <li><i class="fas fa-phone"></i> +977 9769349551</li>
                    <li><i class="fas fa-envelope"></i> cinnamonbakery79@gmail.com</li>
                    <li><i class="fas fa-clock"></i> Open Daily: 8AM - 8PM</li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; {{ date('Y') }} Cinnamon Bakery. All Rights Reserved.</p>
            @if(!auth()->user() || !auth()->user()->isAdmin())
            <div style="margin-top: 10px; opacity: 0.5; font-size: 0.8rem;">
                <a href="{{ route('admin.login') }}" style="color: inherit; text-decoration: none;">Admin</a>
            </div>
            @endif
        </div>
    </div>
</footer>
