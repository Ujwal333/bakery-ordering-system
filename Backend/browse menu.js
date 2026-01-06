// Add this script to your browse-menu page
document.addEventListener('DOMContentLoaded', function() {
    fetchProducts();
});

async function fetchProducts() {
    try {
        const response = await fetch('/api/products');
        const products = await response.json();

        // Display products on the page
        displayProducts(products);
    } catch (error) {
        console.error('Error fetching products:', error);
    }
}

function displayProducts(products) {
    const container = document.getElementById('products-container');

    products.forEach(product => {
        const productCard = `
            <div class="product-card">
                <img src="${product.image_url}" alt="${product.name}">
                <h3>${product.name}</h3>
                <p>${product.description}</p>
                <p>Price: NPR ${product.price}</p>
                <button onclick="addToCart(${product.id})">Add to Cart</button>
            </div>
        `;
        container.innerHTML += productCard;
    });
}
