@php
    $settings = \App\Models\Setting::getCached();
@endphp
<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>{{ $settings->get('bakery_name', 'Cinnamon Bakery') }}</h3>
                <p>{{ $settings->get('footer_description', 'Artisan bakery crafting delicious treats since 2022. Quality ingredients, traditional methods, modern flavors.') }}</p>
                <div class="social-links">
                    <a href="{{ $settings->get('social_facebook', '#') }}"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $settings->get('social_instagram', '#') }}"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $settings->get('social_twitter', '#') }}"><i class="fab fa-twitter"></i></a>
                    <a href="{{ $settings->get('social_pinterest', '#') }}"><i class="fab fa-pinterest-p"></i></a>
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
                    <li><a href="{{ route('careers') }}">Careers</a></li>
                    <li><a href="{{ route('about') }}#help-section">Help Center</a></li>
                    <li><a href="{{ route('about') }}#features">Features</a></li>
                    <li><a href="{{ route('about') }}#gallery">Gallery</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Contact Us</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> {{ $settings->get('contact_address', 'Sano Bharayang, Kathmandu, Nepal') }}</li>
                    <li><i class="fas fa-phone"></i> {{ $settings->get('contact_phone', '+977 9769349551') }}</li>
                    <li><i class="fas fa-envelope"></i> {{ $settings->get('contact_email', 'cinnamonbakery79@gmail.com') }}</li>
                    <li><i class="fas fa-clock"></i> {{ $settings->get('contact_hours', 'Open Daily: 8AM - 8PM') }}</li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Newsletter</h3>
                <p style="font-size: 14px; margin-bottom: 20px; color: #ccc;">{{ $settings->get('newsletter_text', 'Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.') }}</p>
                <form id="newsletter-form" style="display: flex; flex-direction: column; gap: 10px;">
                    <input type="email" id="news-email" placeholder="Your email address" style="padding: 12px; border: none; border-radius: 6px; background: #2a2a2a; color: white;" required>
                    <button type="submit" class="btn" style="width: 100%; border-radius: 6px;">Subscribe</button>
                </form>
                <div id="newsletter-msg" style="margin-top: 10px; font-size: 13px;"></div>
            </div>
        </div>

        <script>
            document.getElementById('newsletter-form')?.addEventListener('submit', async function(e) {
                e.preventDefault();
                const email = document.getElementById('news-email').value;
                const msg = document.getElementById('newsletter-msg');
                const btn = this.querySelector('button');

                btn.disabled = true;
                btn.textContent = 'Subscribing...';

                try {
                    const response = await fetch('/api/subscribe', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ email })
                    });
                    const data = await response.json();
                    if(response.ok) {
                        msg.style.color = '#2ecc71';
                        msg.textContent = 'Success! You are subscribed.';
                        this.reset();
                    } else {
                        msg.style.color = '#ed4956';
                        msg.textContent = data.message || 'Subscription failed.';
                    }
                } catch(e) {
                    msg.style.color = '#ed4956';
                    msg.textContent = 'An error occurred.';
                } finally {
                    btn.disabled = false;
                    btn.textContent = 'Subscribe';
                }
            });
        </script>

        <div class="copyright">
            <p>&copy; {{ date('Y') }} Cinnamon Bakery. All Rights Reserved.</p>
            <div style="margin-top: 10px; opacity: 0.5; font-size: 0.8rem;">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" style="color: inherit; text-decoration: none;">Dashboard</a>
                @else
                    <a href="{{ route('admin.login') }}" style="color: inherit; text-decoration: none;">Admin</a>
                @endif
            </div>
        </div>
    </div>
</footer>
