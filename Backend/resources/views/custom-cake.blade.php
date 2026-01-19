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
                            <h3 id="preview-type">Not Selected</h3>
                            <p id="preview-size">Please select a size</p>
                            <p id="preview-flavor">Please select a flavor</p>
                        </div>
                    </div>

                    <div class="size-options">
                        <div class="option-group">
                            <h3>Cake Type</h3>
                            <select class="custom-select" id="type-select">
                                    <option value="" disabled selected>Select Cake Type</option>
                                @forelse($options['cake_type'] ?? [] as $opt)
                                    <option value="{{ $opt->name }}" data-image="{{ $opt->image_path ? '/storage/' . $opt->image_path : '' }}">{{ $opt->name }} @if($opt->price > 0) (+Rs {{ $opt->price }}) @endif</option>
                                @empty
                                    <option value="Sponge Cake">Sponge Cake</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="option-group">
                            <h3>Choose size</h3>
                            <select class="custom-select" id="size-select">
                                    <option value="" disabled selected>Select Size</option>
                                @forelse($options['size'] ?? [] as $opt)
                                    <option value="{{ $opt->price }}" data-label="{{ $opt->name }}">{{ $opt->name }} - Rs {{ $opt->price }}</option>
                                @empty
                                    <option value="900">8 inch (Serves 8-10) - Rs 900</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="option-group">
                            <h3>Choose flavor</h3>
                            <select class="custom-select" id="flavor-select">
                                    <option value="" disabled selected>Select Flavor</option>
                                @forelse($options['flavor'] ?? [] as $opt)
                                    <option value="{{ $opt->name }}" data-price="{{ $opt->price }}" data-image="{{ $opt->image_path ? '/storage/' . $opt->image_path : '' }}">{{ $opt->name }} @if($opt->price > 0) - Rs {{ $opt->price }} @endif</option>
                                @empty
                                    <option value="Classic Vanilla">Classic Vanilla - Rs 300</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="option-group">
                            <h3>Choose frosting</h3>
                            <select class="custom-select" id="frosting-select">
                                    <option value="" disabled selected>Select Frosting</option>
                                @forelse($options['frosting'] ?? [] as $opt)
                                    <option value="{{ $opt->name }}" data-price="{{ $opt->price }}">{{ $opt->name }} - Rs {{ $opt->price }}</option>
                                @empty
                                    <option value="Buttercream" data-price="200">Vanilla Buttercream - Rs 200</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="option-group">
                            <h3>Custom Message</h3>
                            <textarea id="custom-message" class="message-input" placeholder="Happy Birthday, Name!"></textarea>
                        </div>
                        <div class="option-group">
                            <h3>Reference Image (Optional)</h3>
                            <input type="file" id="reference-image" accept="image/*" class="custom-select">
                        </div>
                    </div>
                </div>

                <div class="customization">
                    <div class="customization-options">
                        <h3>Add decorations</h3>
                        <div class="decorations">
                            @forelse($options['decoration'] ?? [] as $opt)
                                <div class="decoration-option" data-name="{{ $opt->name }}" data-price="{{ $opt->price }}">
                                    <span>{{ $opt->name }}</span>
                                    <span class="decoration-price">+Rs {{ $opt->price }}</span>
                                </div>
                            @empty
                                <p style="grid-column: 1/-1; color: #888;">No decoration options available.</p>
                            @endforelse
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
                            Estimated total: <span class="price" id="total-price">Rs 0</span>
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

        document.addEventListener('DOMContentLoaded', () => {
             updateTotal();
             document.querySelectorAll('.decoration-option').forEach(opt => {
                opt.addEventListener('click', () => {
                    opt.classList.toggle('selected');
                    updateTotal();
                });
             });
             ['size-select', 'flavor-select', 'frosting-select', 'type-select'].forEach(id => {
                const el = document.getElementById(id);
                if(el) el.addEventListener('change', updateTotal);
             });

             // Image Preview Logic
             document.getElementById('reference-image')?.addEventListener('change', function(e) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cake-preview-img').src = e.target.result;
                }
                if (this.files[0]) {
                    reader.readAsDataURL(this.files[0]);
                }
             });
        });

        function updateQty(val) {
            qty = Math.max(1, qty + val);
            document.getElementById('quantity').textContent = qty;
            updateTotal();
        }

        function calculateTotal() {
            try {
                const sizeSelect = document.getElementById('size-select');
                if (!sizeSelect.value) return 0;
                const sizePrice = parseInt(sizeSelect.value || 0);

                const flavorSelect = document.getElementById('flavor-select');
                const flavorOption = flavorSelect.options[flavorSelect.selectedIndex];
                const flavorPrice = flavorOption && flavorOption.value ? parseInt(flavorOption.getAttribute('data-price') || 0) : 0;

                const frostingSelect = document.getElementById('frosting-select');
                const frostingOption = frostingSelect.options[frostingSelect.selectedIndex];
                const frostingPrice = frostingOption && frostingOption.value ? parseInt(frostingOption.getAttribute('data-price') || 0) : 0;
                
                let decoPrice = 0;
                document.querySelectorAll('.decoration-option.selected').forEach(opt => {
                    decoPrice += parseInt(opt.getAttribute('data-price') || 0);
                });

                const baseTotal = sizePrice + flavorPrice + frostingPrice + decoPrice;
                if (baseTotal === 0) return 0;
                
                return baseTotal * qty;
            } catch (e) {
                console.error("Calculation Error:", e);
                return 0;
            }
        }

        function updateTotal() {
            const total = calculateTotal();
            document.getElementById('total-price').textContent = 'Rs ' + total;

            try {
                // Get Elements
                const typeSelect = document.getElementById('type-select');
                const sizeSelect = document.getElementById('size-select');
                const flavorSelect = document.getElementById('flavor-select');
                const frostingSelect = document.getElementById('frosting-select');

                // Update Preview Texts
                if (typeSelect && document.getElementById('preview-type')) {
                    document.getElementById('preview-type').textContent = typeSelect.value || 'Not Selected';
                }

                if (sizeSelect && document.getElementById('preview-size')) {
                    const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
                    const sizeText = selectedOption && selectedOption.value ? (selectedOption.getAttribute('data-label') || selectedOption.text.split(' - ')[0]) : 'Please select a size';
                    document.getElementById('preview-size').textContent = sizeText;
                }

                if (flavorSelect && document.getElementById('preview-flavor')) {
                     document.getElementById('preview-flavor').textContent = flavorSelect.value || 'Please select a flavor';
                }

                // Image Logic: Flavor > Type
                let newImage = null;
                
                // Check Flavor
                if (flavorSelect && flavorSelect.selectedIndex > -1) {
                    const selectedFlavor = flavorSelect.options[flavorSelect.selectedIndex];
                    const flavorImg = selectedFlavor && selectedFlavor.value ? selectedFlavor.getAttribute('data-image') : null;
                    if (flavorImg) newImage = flavorImg;
                }

                // Check Type (if no flavor image)
                if (!newImage && typeSelect && typeSelect.selectedIndex > -1) {
                    const selectedType = typeSelect.options[typeSelect.selectedIndex];
                    const typeImg = selectedType && selectedType.value ? selectedType.getAttribute('data-image') : null;
                    if (typeImg) newImage = typeImg;
                }

                // Update Preview Image
                const previewImg = document.getElementById('cake-preview-img');
                const userFile = document.getElementById('reference-image');
                const defaultImage = "https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=1080&q=80";
                
                if (previewImg && (!userFile || !userFile.files.length)) {
                    if (newImage) {
                        previewImg.src = newImage;
                    } else {
                        previewImg.src = defaultImage;
                    }
                }
            } catch (e) { console.error("Update UI Error:", e); }
        }

        async function submitCustomCake() {
            const formData = new FormData();
            
            const sizeSelect = document.getElementById('size-select');
            const flavorSelect = document.getElementById('flavor-select');
            const frostingSelect = document.getElementById('frosting-select');
            const typeSelect = document.getElementById('type-select');
            
            const decorations = [];
            document.querySelectorAll('.decoration-option.selected').forEach(opt => {
                decorations.push({
                    name: opt.getAttribute('data-name'),
                    price: parseInt(opt.getAttribute('data-price'))
                });
            });

            if (!typeSelect.value || !sizeSelect.value || !flavorSelect.value || !frostingSelect.value) {
                showNotification('Please select all required options (Type, Size, Flavor, Frosting)', 'error');
                return;
            }

            formData.append('cake_type', typeSelect.value);
            formData.append('size', sizeSelect.options[sizeSelect.selectedIndex].getAttribute('data-label') || sizeSelect.options[sizeSelect.selectedIndex].text.split(' - ')[0]);
            formData.append('size_price', parseInt(sizeSelect.value));
            formData.append('flavor', flavorSelect.value);
            formData.append('flavor_price', parseInt(flavorSelect.options[flavorSelect.selectedIndex].getAttribute('data-price') || 0));
            formData.append('frosting', frostingSelect.value);
            formData.append('frosting_price', parseInt(frostingSelect.options[frostingSelect.selectedIndex].getAttribute('data-price')));
            formData.append('decorations', JSON.stringify(decorations));
            formData.append('custom_message', document.getElementById('custom-message').value);
            formData.append('quantity', qty);

            const imageFile = document.getElementById('reference-image').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            try {
                const submitBtn = document.querySelector('.add-to-cart-btn');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Uploading...';
                submitBtn.disabled = true;

                const response = await fetch(`${CART_API}/custom-cake`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json().catch(() => ({ success: false, message: 'Server error encountered.' }));
                
                if (response.ok) {
                    showNotification('Custom cake added to cart!', 'success');
                    updateCartCount();
                } else {
                    showNotification(result.message || 'Failed to add custom cake', 'error');
                }
                
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            } catch (err) {
                showNotification('Error: ' + err.message, 'error');
                console.error(err);
                document.querySelector('.add-to-cart-btn').textContent = 'Add to Cart';
                document.querySelector('.add-to-cart-btn').disabled = false;
            }
        }
    </script>
@endsection
