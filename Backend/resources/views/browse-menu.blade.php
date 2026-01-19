@extends('layouts.app')

@section('title', 'Cinnamon Bakery - Full Menu')

@section('styles')
    <style>
        /* Updated Premium UI Styles */
        :root {
            --menu-bg: #fdf1e6;
            --card-shadow: 0 10px 30px rgba(123, 63, 0, 0.05);
            --card-radius: 20px;
        }

        body { background: var(--menu-bg) !important; }

        .page-title { text-align: center; margin: 40px 0 30px; }
        .page-title h1 { 
            font-family: 'Playfair Display', serif; 
            font-size: 42px; 
            color: var(--secondary); 
            margin-bottom: 5px;
            font-weight: 700;
        }
        .page-title p { font-size: 18px; color: #8d6e63; max-width: 700px; margin: 0 auto; }

        .categories { display: flex; justify-content: center; flex-wrap: wrap; gap: 12px; margin: 30px 0; }
        .category-btn { 
            background: white; 
            border: none; 
            color: var(--secondary); 
            padding: 10px 25px; 
            border-radius: 25px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            font-size: 15px; 
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .category-btn:hover, .category-btn.active { 
            background: var(--accent); 
            color: white; 
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 159, 28, 0.3);
        }

        .menu-section { margin-bottom: 60px; padding: 0; background: transparent; box-shadow: none; }
        .section-header { 
            margin-bottom: 30px; 
            text-align: center; 
            display: block;
            border: none;
        }
        .section-header h2 { 
            font-family: 'Playfair Display', serif; 
            font-size: 32px; 
            color: var(--secondary); 
            margin-bottom: 10px;
        }
        .section-header p { color: #8d6e63; font-size: 16px; margin: 0; font-weight: 500; }

        .menu-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 30px; 
            justify-content: center;
        }

        .menu-item { 
            background: #fff; 
            border: none; 
            border-radius: var(--card-radius); 
            overflow: hidden; 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            display: flex; 
            flex-direction: column;
            padding: 10px;
            box-shadow: var(--card-shadow);
            position: relative;
        }
        .menu-item:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(123, 63, 0, 0.12); 
        }

        .item-img { 
            width: 100%; 
            height: 200px; 
            object-fit: cover; 
            border-radius: 15px;
            background: #fdf1e6;
        }
        
        .item-content { 
            padding: 20px 10px; 
            flex-grow: 1; 
            display: flex; 
            flex-direction: column;
            text-align: center;
        }
        .item-name { 
            font-family: 'Playfair Display', serif;
            font-size: 22px; 
            font-weight: 700; 
            color: var(--secondary); 
            margin-bottom: 10px;
        }
        .item-desc { 
            font-size: 14px; 
            color: #6d4c41; 
            margin-bottom: 20px; 
            line-height: 1.5;
            min-height: 42px;
        }

        .size-select { 
            width: 100%; 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #eee; 
            border-radius: 10px; 
            font-size: 14px; 
            background-color: #fdf1e6;
            color: var(--secondary);
            font-weight: 500;
        }

        .item-meta { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-top: auto; 
            padding-top: 15px; 
        }
        .item-price { 
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            line-height: 1.2;
        }
        .price-wrapper {
            font-weight: 700; 
            color: var(--accent); 
            font-size: 20px; 
            font-family: 'Poppins', sans-serif;
        }
        .old-price {
            font-size: 14px;
            color: #8d6e63;
            text-decoration: line-through;
            font-weight: 500;
            margin-bottom: 2px;
        }
        
        .add-to-cart { 
            background: var(--accent); 
            color: white; 
            border: none; 
            padding: 12px 25px; 
            border-radius: 25px; 
            font-size: 14px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(255, 159, 28, 0.2);
        }
        .add-to-cart:hover { 
            background: #e68a00; 
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(255, 159, 28, 0.3);
        }

        .wishlist-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            color: #ccc;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 5;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .wishlist-btn:hover { transform: scale(1.1); }
        .wishlist-btn.active { color: #ed4956; }

        .search-bar-container { max-width: 500px; margin: 0 auto 30px; }
    </style>
@endsection

@section('content')
    <div class="container">
        <!-- Page Title -->
        <div class="page-title">
            <h1>Our Menu</h1>
            <p>Delicious offerings perfect for any occasion!</p>
        </div>

        <!-- Menu Categories -->
        <div class="categories">
            <a href="{{ route('browse-menu', 'all') }}" class="category-btn {{ $activeCategory == 'all' ? 'active' : '' }}">All</a>
            @foreach($categories as $category)
                <a href="{{ route('browse-menu', $category->slug) }}" class="category-btn {{ $activeCategory == $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
            @endforeach
        </div>

        <!-- Dynamic Menu Sections -->
        @forelse($displayCategories as $category)
        <div class="menu-section" id="category-{{ $category->slug }}">
            <div class="section-header">
                <h2>{{ $category->name }}</h2>
                <p>{{ count($category->products) }} items</p>
            </div>
            
            <div class="menu-grid">
                @foreach($category->products as $product)
                <div class="menu-item" data-category="{{ $category->slug }}">
                    @if($product->is_popular)
                        <div class="item-tag">Bestseller</div>
                    @endif
                    <button class="wishlist-btn" onclick="toggleWishlist(this, {{ $product->id }})">
                        <i class="fas fa-heart"></i>
                    </button>
                    <img src="{{ (Str::startsWith($product->image_url, 'http') || Str::startsWith($product->image_url, '/storage')) ? $product->image_url : '/storage/' . $product->image_url }}" alt="{{ $product->name }}" class="item-img">
                    <div class="item-content">
                        <div class="item-header">
                            <h3 class="item-name" title="{{ $product->name }}">{{ $product->name }}</h3>
                        </div>
                        <div class="item-desc" title="{{ $product->description }}">{{ $product->description }}</div>
                        
                        <!-- Variant Selection -->
                        @if(!empty($product->variants))
                            <select class="size-select" onchange="updatePrice(this)">
                                @foreach($product->variants as $variant)
                                    <option value="{{ $variant['price'] }}" data-size="{{ $variant['size'] }}">{{ $variant['size'] }}</option>
                                @endforeach
                            </select>
                        @endif

                        <div class="item-meta">
                            @php
                                $hasDiscount = $product->discount_price > 0;
                                $startPrice = !empty($product->variants) ? $product->variants[0]['price'] : ($hasDiscount ? $product->discount_price : $product->price);
                            @endphp
                            <div class="item-price">
                                @if($hasDiscount && empty($product->variants))
                                    <span class="old-price">Rs {{ number_format($product->price, 0) }}</span>
                                @endif
                                <div class="price-wrapper">Rs <span class="price-val">{{ number_format($startPrice, 0) }}</span></div>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 5px;">
                                @if($product->stock <= 0)
                                    <span style="color: #dc3545; font-size: 12px; font-weight: 600;">Out of Stock</span>
                                    <button class="add-to-cart" disabled style="background: #ccc; cursor: not-allowed; box-shadow: none;">
                                        Add to Cart
                                    </button>
                                @else
                                    @if($product->stock < 5)
                                        <span style="color: #e67e22; font-size: 11px; font-weight: 600;"><i class="fas fa-exclamation-triangle"></i> Only {{ $product->stock }} left!</span>
                                    @endif
                                    <button class="add-to-cart" 
                                        data-product-id="{{ $product->id }}"
                                        data-base-name="{{ $product->name }}"
                                        data-has-variants="{{ !empty($product->variants) ? 'true' : 'false' }}">
                                        Add to Cart
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="menu-section">
            <p style="text-align:center;">No menu items found.</p>
        </div>
        @endforelse
    </div>
@endsection

@section('scripts')
    <script>
        async function toggleWishlist(btn, productId) {
            try {
                const response = await fetch('/wishlist/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                if (response.status === 401) {
                    window.location = '/login';
                    return;
                }

                const data = await response.json();
                if (response.ok) {
                    btn.classList.toggle('active');
                    showNotification(data.message);
                }
            } catch (e) { console.error("Wishlist Error", e); }
        }

        function updatePrice(selectEl) {
            const price = selectEl.value;
            const priceValEl = selectEl.closest('.item-content').querySelector('.price-val');
            priceValEl.textContent = price;
        }

        // Add to cart buttons listener
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', async function() {
                const menuItem = this.closest('.menu-item');
                const productId = this.getAttribute('data-product-id');
                const baseName = this.getAttribute('data-base-name');
                const hasVariants = this.getAttribute('data-has-variants') === 'true';

                let finalName = baseName;
                let finalPrice = 0;
                let quantity = 1;

                if (hasVariants) {
                    const select = menuItem.querySelector('.size-select');
                    const selectedOption = select.options[select.selectedIndex];
                    const size = selectedOption.getAttribute('data-size');
                    finalPrice = parseFloat(select.value);
                    finalName = `${baseName} (${size})`;
                } else {
                    const priceText = menuItem.querySelector('.price-val').textContent;
                    finalPrice = parseFloat(priceText.replace(/,/g, ''));
                }

                try {
                    // Call shared addToCart function
                    const originalText = this.textContent;
                    this.textContent = "...";
                    this.disabled = true;

                    await addToCart(productId, finalName, finalPrice, quantity);
                    
                    this.textContent = "Added";
                    this.style.background = "#4CAF50";

                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.background = "";
                        this.disabled = false;
                    }, 1000);
                } catch (error) {
                    console.error('Error adding to cart:', error);
                    this.textContent = "Error";
                    setTimeout(() => { this.textContent = "Add to Cart"; this.disabled = false; }, 2000);
                }
            });
        });
    </script>
@endsection
