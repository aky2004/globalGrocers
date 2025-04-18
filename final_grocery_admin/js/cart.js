// Cart state
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// DOM elements
const cartDrawer = document.querySelector('.cart-drawer');
const cartOverlay = document.querySelector('.overlay');
const cartItemsContainer = document.querySelector('.cart-items');
const cartBadge = document.querySelector('#cart-count');
const cartTotal = document.querySelector('.cart-total-amount');

// Cart functions
function toggleCart() {
    console.log('Toggling cart');
    cartDrawer.classList.toggle('open');
    cartOverlay.classList.toggle('show');
    document.body.classList.toggle('no-scroll');
    updateCartUI();
}

function closeCart() {
    console.log('Closing cart');
    cartDrawer.classList.remove('open');
    cartOverlay.classList.remove('show');
    document.body.classList.remove('no-scroll');
}

function clearCart() {
    console.log('Clearing cart');
    cart = [];
    saveCart();
    updateCartUI();
}

function updateCartUI() {
    console.log('Updating cart UI');
    updateCartBadge();
    updateCartItems();
    updateCartTotal();
}

function updateCartBadge() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    if (cartBadge) {
        cartBadge.textContent = totalItems;
        cartBadge.style.display = totalItems > 0 ? 'flex' : 'none';
    }
}

function formatPrice(price) {
    return `₹${parseFloat(price).toFixed(2)}`;
}

function updateCartItems() {
    if (!cartItemsContainer) return;

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>Your cart is empty</p>
                <a href="products.php" class="btn btn-primary">Start Shopping</a>
            </div>
        `;
        return;
    }

    cartItemsContainer.innerHTML = cart.map(item => `
        <div class="cart-item" data-id="${item.id}">
            <img src="${item.imageUrl || item.image}" alt="${item.name}" class="cart-item-image">
            <div class="cart-item-details">
                <h4>${item.name}</h4>
                <div class="cart-item-price">${formatPrice(item.price)}</div>
                <div class="cart-item-quantity">
                    <button class="quantity-btn minus" onclick="updateQuantity('${item.id}', -1)">-</button>
                    <span>${item.quantity}</span>
                    <button class="quantity-btn plus" onclick="updateQuantity('${item.id}', 1)">+</button>
                </div>
                <div class="cart-item-total">Total: ${formatPrice(item.price * item.quantity)}</div>
            </div>
            <button class="remove-item" onclick="removeFromCart('${item.id}')">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');
}

function updateCartTotal() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    // Update cart drawer total
    if (cartTotal) {
        cartTotal.textContent = formatPrice(subtotal);
    }

    // Update cart page totals if they exist
    const subtotalElement = document.querySelector('.cart-subtotal');
    const totalElement = document.querySelector('.cart-final-total');
    if (subtotalElement) {
        subtotalElement.textContent = formatPrice(subtotal);
    }
    if (totalElement) {
        totalElement.textContent = formatPrice(subtotal); // Since shipping is free, total equals subtotal
    }
}

function addToCart(product) {
    console.log('Adding to cart:', product);
    let productData;

    // Check if product is an HTML element or a data object
    if (product instanceof Element || product.closest) {
        const productCard = product.closest('.product-card');
        if (!productCard) return;

        // Extract data from product card
        const priceElement = productCard.querySelector('.current-price, .product-price');
        let price;
        if (priceElement) {
            const priceText = priceElement.textContent.trim();
            price = parseFloat(priceText.replace('₹', '').replace(',', ''));
        }
        
        productData = {
            id: productCard.dataset.id || productCard.querySelector('.add-to-cart').dataset.id || 
                productCard.querySelector('.product-title').textContent.toLowerCase().replace(/\s+/g, '-'),
            name: productCard.querySelector('.product-title').textContent,
            price: price,
            imageUrl: productCard.querySelector('img').src,
            quantity: 1
        };
    } else {
        // Product is already a data object
        productData = {
            id: product.id || product.name.toLowerCase().replace(/\s+/g, '-'),
            name: product.name,
            price: parseFloat(product.price),
            imageUrl: product.imageUrl || product.image,
            quantity: 1
        };
    }

    if (!productData.id || !productData.name || !productData.price || !productData.imageUrl) {
        console.error('Invalid product data:', productData);
        return;
    }

    const existingItem = cart.find(item => item.id === productData.id);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push(productData);
    }
    
    saveCart();
    updateCartUI();
    toggleCart();
}

function removeFromCart(productId) {
    console.log('Removing from cart:', productId);
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    updateCartUI();
}

function updateQuantity(productId, change) {
    console.log('Updating quantity:', productId, change);
    const item = cart.find(item => item.id === productId);
    if (!item) return;
    
    item.quantity += change;
    
    if (item.quantity <= 0) {
        removeFromCart(productId);
    } else {
        saveCart();
        updateCartUI();
    }
}

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', () => {
    updateCartUI();
    
    // Close cart when clicking overlay
    if (cartOverlay) {
        cartOverlay.addEventListener('click', closeCart);
    }
    
    // Close cart when pressing Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeCart();
    });

    // Add event listeners for cart page buttons if they exist
    const clearCartBtn = document.querySelector('.clear-cart-btn');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', clearCart);
    }

    // Add event listeners for all add to cart buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            addToCart(this);
        });
    });
});

// Export functions for use in other files
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
window.toggleCart = toggleCart;
window.clearCart = clearCart;
