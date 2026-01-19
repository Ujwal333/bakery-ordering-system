// API Configuration
const API_BASE = '/api';
let authToken = null;
let csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCartCount();
    checkAuthStatus();

    // Load token from localStorage
    authToken = localStorage.getItem('auth_token');
    if (authToken) {
        setAuthToken(authToken);
    }
});

// Set authentication token
function setAuthToken(token) {
    authToken = token;
    localStorage.setItem('auth_token', token);
}

// Remove authentication token
function removeAuthToken() {
    authToken = null;
    localStorage.removeItem('auth_token');
}

// API request helper
async function apiRequest(endpoint, options = {}) {
    const url = `${API_BASE}${endpoint}`;

    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        ...options.headers,
    };

    if (authToken) {
        headers['Authorization'] = `Bearer ${authToken}`;
    }

    if (csrfToken && (options.method === 'POST' || options.method === 'PUT' || options.method === 'DELETE')) {
        headers['X-CSRF-TOKEN'] = csrfToken;
    }

    try {
        const response = await fetch(url, {
            ...options,
            headers,
            credentials: 'include',
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'API request failed');
        }

        return data;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}

// Authentication functions
async function login(email, password) {
    try {
        const data = await apiRequest('/login', {
            method: 'POST',
            body: JSON.stringify({ email, password }),
        });

        if (data.success && data.token) {
            setAuthToken(data.token);
            showNotification('Login successful!', 'success');
            return data;
        }
    } catch (error) {
        showNotification(error.message, 'error');
        throw error;
    }
}

async function register(userData) {
    try {
        const data = await apiRequest('/register', {
            method: 'POST',
            body: JSON.stringify(userData),
        });

        if (data.success && data.token) {
            setAuthToken(data.token);
            showNotification('Registration successful!', 'success');
            return data;
        }
    } catch (error) {
        showNotification(error.message, 'error');
        throw error;
    }
}

async function logout() {
    try {
        await apiRequest('/logout', { method: 'POST' });
        removeAuthToken();
        showNotification('Logged out successfully', 'success');
        setTimeout(() => window.location.href = '/', 1000);
    } catch (error) {
        console.error('Logout error:', error);
    }
}

// Cart functions
async function loadCartCount() {
    try {
        const data = await apiRequest('/cart/count');
        const cartCountEl = document.getElementById('cart-count');
        if (cartCountEl && data.success) {
            cartCountEl.textContent = data.data.count;
        }
    } catch (error) {
        console.error('Failed to load cart count:', error);
    }
}

async function addToCart(productId, quantity = 1, customizations = null) {
    try {
        const data = await apiRequest('/cart/add', {
            method: 'POST',
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity,
                customizations: customizations,
            }),
        });

        if (data.success) {
            loadCartCount();
            showNotification('Added to cart!', 'success');
            return data;
        }
    } catch (error) {
        showNotification(error.message, 'error');
        throw error;
    }
}

async function addCustomCakeToCart(cakeData) {
    try {
        const data = await apiRequest('/cart/custom-cake', {
            method: 'POST',
            body: JSON.stringify(cakeData),
        });

        if (data.success) {
            loadCartCount();
            showNotification('Custom cake added to cart!', 'success');
            return data;
        }
    } catch (error) {
        showNotification(error.message, 'error');
        throw error;
    }
}

// Order functions
async function trackOrder(orderNumber) {
    try {
        const data = await apiRequest('/orders/track', {
            method: 'POST',
            body: JSON.stringify({ order_number: orderNumber }),
        });

        return data;
    } catch (error) {
        showNotification(error.message, 'error');
        throw error;
    }
}

async function placeOrder(orderData) {
    try {
        const data = await apiRequest('/orders', {
            method: 'POST',
            body: JSON.stringify(orderData),
        });

        if (data.success) {
            showNotification('Order placed successfully!', 'success');
            return data;
        }
    } catch (error) {
        showNotification(error.message, 'error');
        throw error;
    }
}

// User functions
async function checkAuthStatus() {
    try {
        const data = await apiRequest('/user');
        if (data.success) {
            updateUIForLoggedInUser(data.data.user);
            return data.data.user;
        }
    } catch (error) {
        // User is not logged in
        updateUIForLoggedOutUser();
        return null;
    }
}

function updateUIForLoggedInUser(user) {
    const profileElements = document.querySelectorAll('.user-profile');
    profileElements.forEach(el => {
        el.innerHTML = `
            <img src="${user.profile_image}" alt="Profile" class="profile-img">
            <span>${user.name}</span>
        `;
    });

    const authButtons = document.querySelectorAll('.auth-buttons');
    authButtons.forEach(el => {
        el.innerHTML = `
            <button class="btn btn-outline" onclick="logout()">Logout</button>
        `;
    });
}

function updateUIForLoggedOutUser() {
    const authButtons = document.querySelectorAll('.auth-buttons');
    authButtons.forEach(el => {
        el.innerHTML = `
            <a href="/login" class="btn btn-outline">Login</a>
            <a href="/register" class="btn">Register</a>
        `;
    });
}

// Product functions
async function loadProducts(category = null) {
    try {
        let url = '/products';
        if (category) {
            url += `?category=${category}`;
        }

        const data = await apiRequest(url);
        return data.success ? data.data : [];
    } catch (error) {
        console.error('Failed to load products:', error);
        return [];
    }
}

async function getProduct(slug) {
    try {
        const data = await apiRequest(`/products/${slug}`);
        return data.success ? data.data.product : null;
    } catch (error) {
        console.error('Failed to load product:', error);
        return null;
    }
}

// Custom cake functions
async function getCakeOptions() {
    try {
        const data = await apiRequest('/products/cake-options');
        return data.success ? data.data : null;
    } catch (error) {
        console.error('Failed to load cake options:', error);
        return null;
    }
}

// Utility functions
function showNotification(message, type = 'success') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(n => n.remove());

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="close-btn">&times;</button>
    `;

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'success' ? '#4CAF50' : '#f44336'};
        color: white;
        border-radius: 5px;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-width: 300px;
        max-width: 400px;
        animation: slideIn 0.3s ease;
    `;

    const closeBtn = notification.querySelector('.close-btn');
    closeBtn.style.cssText = `
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        margin-left: 15px;
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
