@extends('layouts.app')

@section('title', 'Cinnamon Bakery - Custom Cake Designer')

@section('styles')
    <style>
        .custom-cake-section { padding: 60px 0; }
        .section-title { text-align: center; margin-bottom: 30px; }
        .section-title h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: var(--secondary); margin-bottom: 10px; letter-spacing: 1px; }
        .section-title p { font-size: 1.2rem; color: var(--dark); max-width: 600px; margin: 0 auto; }
        .cake-builder { display: flex; gap: 40px; margin-top: 30px; }
        .cake-preview { flex: 1; background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); text-align: center; }
        .cake-image { width: 100%; max-width: 400px; height: 300px; margin: 0 auto 25px; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); position: relative; background: #f9f5f0; display: flex; align-items: center; justify-content: center; }
        .cake-image img { width: 100%; height: 100%; object-fit: cover; display: block; transition: all 0.3s ease; }
        .preview-details { position: absolute; bottom: 15px; left: 0; right: 0; padding: 10px; background: rgba(255, 255, 255, 0.85); border-radius: 0 0 10px 10px; text-align: left; }
        .preview-details h3 { font-size: 1.1rem; color: var(--secondary); margin-bottom: 5px; }
        .preview-details p { font-size: 0.9rem; color: var(--text); margin-bottom: 3px; }
        .option-group { margin-bottom: 25px; }
        .option-group h3 { font-size: 1.2rem; color: var(--secondary); margin-bottom: 10px; text-align: left; }
        .custom-select { width: 100%; padding: 12px 15px; border: 2px solid #eee; border-radius: 10px; background: white; font-family: 'Poppins', sans-serif; font-size: 1rem; color: var(--text); cursor: pointer; transition: all 0.3s; }
        .custom-select:hover { border-color: var(--primary); }
        .custom-select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 2px rgba(212, 167, 106, 0.3); }
        .customization { flex: 1; }
        .order-summary { background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); }
        .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .order-header h3 { font-size: 1.4rem; color: var(--secondary); }
        .quantity-selector { display: flex; align-items: center; gap: 15px; }
        .quantity-btn { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: white; border: none; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .quantity-display { font-size: 1.2rem; font-weight: 600; min-width: 40px; text-align: center; }
        .price-total { text-align: right; margin-top: 15px; font-size: 1.4rem; font-weight: 700; }
        .price-total .price { color: var(--accent); margin-left: 10px; }
        .add-to-cart-btn { display: block; width: 100%; padding: 15px; background: var(--accent); color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-top: 20px; box-shadow: 0 5px 15px rgba(255, 159, 28, 0.3); }
        .message-input { width: 100%; height: 100px; padding: 15px; border: 1px solid #ddd; border-radius: 10px; resize: none; font-family: 'Poppins', sans-serif; font-size: 1rem; }
        .customization-options { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); margin-bottom: 30px; }
        .decorations { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .decoration-option { padding: 15px; border: 2px solid #eee; border-radius: 10px; cursor: pointer; transition: all 0.3s ease; text-align: left; display: flex; justify-content: space-between; align-items: center; }
        .decoration-option.selected { border-color: var(--primary); background: rgba(212, 167, 106, 0.1); }
        .decoration-price { font-weight: 600; color: var(--accent); }
        @media (max-width: 992px) { .cake-builder { flex-direction: column; } }
    </style>
@endsection

@section('content')
    <section class="custom-cake-section">
        <div class="container">
            <div class="section-title">
                <h1>CINNAMON BAKERY</h1>
                <p>CUSTOM CAKE DESIGNER</p>
                <p style="font-size: 1.1rem; margin-top: 15px;">Design your perfect cake with our interactive tool.</p>
            </div>

            <div class="cake-builder">
                <div class="cake-preview">
                    <div class="cake-image">
                        <img id="cake-preview-img" src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=1080&q=80" alt="Cake Preview">
                        <div class="preview-details">
                            <h3 id="preview-size">8 inch (Serves 8-10)</h3>
                            <p id="preview-flavor">Classic Vanilla</p>
                        </div>
                    </div>

                    <div class="size-options">
                        <div class="option-group">
                            <h3>Choose size</h3>
                            <select class="custom-select" id="size-select">
                                <option value="900" selected>8 inch (Serves 8-10) - Rs 900</option>
                                <option value="1500">12 inch (Serves 20-25) - Rs 1500</option>
                            </select>
                        </div>
                        <div class="option-group">
                            <h3>Choose flavor</h3>
                            <select class="custom-select" id="flavor-select">
                                <option value="Vanilla">Classic Vanilla - Rs 300</option>
                                <option value="Chocolate">Chocolate Fudge - Rs 500</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="customization">
                    <div class="customization-options">
                        <h3>Add decorations</h3>
                        <div class="decorations">
                            <div class="decoration-option" data-price="800">
                                <span>Fresh Berries</span>
                                <span class="decoration-price">+Rs 800</span>
                            </div>
                            <div class="decoration-option" data-price="1200">
                                <span>Chocolate Drip</span>
                                <span class="decoration-price">+Rs 1200</span>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="order-header">
                            <h3>Order Preview</h3>
                            <div class="quantity-selector">
                                <button class="quantity-btn" onclick="updateQty(-1)">-</button>
                                <div class="quantity-display" id="quantity">1</div>
                                <button class="quantity-btn" onclick="updateQty(1)">+</button>
                            </div>
                        </div>
                        <div class="price-total">
                            Estimated total: <span class="price">Rs 900</span>
                        </div>
                        <button class="add-to-cart-btn" onclick="submitCustomCake()">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        let qty = 1;
        function updateQty(val) {
            qty = Math.max(1, qty + val);
            document.getElementById('quantity').textContent = qty;
        }

        async function submitCustomCake() {
            const size = document.getElementById('size-select').value;
            const flavor = document.getElementById('flavor-select').value;
            
            try {
                // Simplified for now - can be expanded with more metadata
                await addToCart(0, `Custom Cake (${flavor}, ${size})`, parseInt(size) + 500, qty);
                showNotification('Custom cake added to cart!');
            } catch (err) {
                console.error(err);
            }
        }
    </script>
@endsection
