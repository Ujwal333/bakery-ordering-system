@extends('layouts.app')

@section('title', 'Cinnamon Bakery - Full Menu')

@section('styles')
    <style>
        /* Page Title */
        .page-title {
            text-align: center;
            margin: 40px 0 30px;
        }

        .page-title h1 {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .page-title p {
            font-size: 18px;
            color: var(--text);
            max-width: 700px;
            margin: 0 auto;
        }

        /* Menu Categories */
        .categories {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin: 40px 0;
        }

        .category-btn {
            background: white;
            border: 2px solid var(--primary);
            color: var(--text);
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }

        .category-btn:hover,
        .category-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Menu Sections */
        .menu-section {
            margin-bottom: 60px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--accent2);
        }

        .section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: var(--secondary);
        }

        .section-header p {
            color: var(--text);
            margin-top: 10px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .menu-item {
            background: var(--light);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .menu-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .item-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            z-index: 2;
        }

        .item-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-bottom: 3px solid var(--accent2);
        }

        .item-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .item-name {
            font-size: 20px;
            font-weight: 600;
            color: var(--secondary);
        }

        .item-price {
            font-weight: 700;
            color: var(--accent);
            font-size: 20px;
        }

        .item-desc {
            color: #666;
            margin-bottom: 20px;
            font-size: 15px;
            flex-grow: 1;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .add-to-cart {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-to-cart:hover {
            background: #F57C00;
            transform: scale(1.05);
        }

        .item-rating {
            color: var(--accent);
            font-weight: 600;
        }

        /* Search Bar Enhancement */
        .search-bar-container {
            max-width: 600px;
            margin: 0 auto 40px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <!-- Page Title -->
        <div class="page-title">
            <h1>Our Complete Bakery Menu</h1>
            <p>Discover all our delicious offerings - from cakes and cupcakes to pastries and hot drinks. Perfect for any occasion!</p>
        </div>

        <!-- Menu Categories -->
        <div class="categories">
            <a href="{{ route('browse-menu', 'all') }}" class="category-btn {{ $activeCategory == 'all' ? 'active' : '' }}">All Items</a>
            @foreach($categories as $category)
                <a href="{{ route('browse-menu', $category->slug) }}" class="category-btn {{ $activeCategory == $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
            @endforeach
        </div>

        <!-- Dynamic Menu Sections -->
        @forelse($displayCategories as $category)
        <div class="menu-section" id="category-{{ $category->slug }}">
            <div class="section-header">
                <h2>{{ $category->name }}</h2>
                <p>Delicious {{ strtolower($category->name) }} selection</p>
            </div>
            
            <div class="menu-grid">
                @foreach($category->products as $product)
                <div class="menu-item" data-category="{{ $category->slug }}">
                    @if($product->is_featured)
                        <div class="item-tag">Popular</div>
                    @endif
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="item-img">
                    <div class="item-content">
                        <div class="item-header">
                            <h3 class="item-name">{{ $product->name }}</h3>
                            <div class="item-price">Rs {{ $product->price }}</div>
                        </div>
                        <div class="item-desc">
                            <p>{{ Str::limit($product->description, 60) }}</p>
                        </div>
                        <div class="item-footer">
                            <button class="add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
                            <div class="item-rating">★★★★★</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="menu-section">
            <p style="text-align:center;">No menu items found. Please check back later.</p>
        </div>
        @endforelse

        <!-- Pickup Information -->
        <div class="menu-section" style="background: var(--accent2);">
            <div class="section-header">
                <h2>Pickup Information</h2>
            </div>
            <div style="text-align: center; padding: 20px; font-size: 18px;">
                <p><i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i> Pickup is located in Kathmandu area unless other plans have been arranged</p>
                <p style="margin-top: 15px;">Please allow 48 hours notice for custom orders</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Search functionality
        const searchInput = document.querySelector('.search-bar input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                const menuItems = document.querySelectorAll('.menu-item');

                menuItems.forEach(item => {
                    const name = item.querySelector('.item-name')?.textContent.toLowerCase() || '';
                    const desc = item.querySelector('.item-desc')?.textContent.toLowerCase() || '';
                    if (!query || name.includes(query) || desc.includes(query)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Hide sections with no visible items
                document.querySelectorAll('.menu-section').forEach(section => {
                    const h2 = section.querySelector('h2');
                    if(h2 && h2.textContent === 'Pickup Information') return;

                    const visibleItems = Array.from(section.querySelectorAll('.menu-item')).filter(item => item.style.display !== 'none').length;
                    section.style.display = visibleItems > 0 ? 'block' : 'none';
                });
            });
        }

        // Add to cart buttons listener
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', async function() {
                const menuItem = this.closest('.menu-item');
                const productName = menuItem.querySelector('.item-name').textContent.trim();
                const priceText = menuItem.querySelector('.item-price').textContent.trim();
                const productId = this.getAttribute('data-product-id');
                
                let price = priceText.replace('Rs', '').replace(',', '').trim();
                price = parseFloat(price);

                try {
                    // Call the addToCart function from layout
                    await addToCart(productId, productName, price, 1);
                    
                    const originalText = this.textContent;
                    this.textContent = "✓ Added";
                    this.style.background = "#4CAF50";

                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.background = "";
                    }, 1500);
                } catch (error) {
                    console.error('Error adding to cart:', error);
                }
            });
        });
    </script>
@endsection
