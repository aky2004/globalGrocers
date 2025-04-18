document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-times');
        });
    }
    
    // Add to Cart Functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get product info
            const productCard = this.closest('.product-card');
            const productName = productCard.querySelector('.product-title').textContent;
            const productImageSrc = productCard.querySelector('.product-image img').src;
            const productPrice = productCard.querySelector('.product-price').innerText.split('\n')[0];
            
            // Get cart from localStorage or initialize empty array
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Check if product is already in cart
            const existingProductIndex = cart.findIndex(item => item.name === productName);
            
            if (existingProductIndex > -1) {
                // Product exists, increase quantity
                cart[existingProductIndex].quantity += 1;
            } else {
                // Add new product to cart
                cart.push({
                    name: productName,
                    price: productPrice,
                    image: productImageSrc,
                    quantity: 1
                });
            }
            
            // Save cart to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Update cart count
            updateCartCount();
            
            // Show notification
            showNotification(`${productName} added to cart!`);
        });
    });
    
    // Update cart count on page load
    updateCartCount();
    
    // Newsletter form submission
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('input[type="email"]');
            
            if (emailInput.value) {
                showNotification('Thanks for subscribing to our newsletter!');
                emailInput.value = '';
            }
        });
    }
});

// Update Cart Count
function updateCartCount() {
    const cartCountElements = document.querySelectorAll('.cart-count');
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Calculate total items
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    
    // Update all cart count elements
    cartCountElements.forEach(element => {
        element.textContent = totalItems;
    });
}

// Show Notification
function showNotification(message) {
    // Check if there's an existing notification
    let notification = document.querySelector('.notification');
    
    if (notification) {
        // Update existing notification
        notification.textContent = message;
        notification.classList.add('active');
    } else {
        // Create new notification
        notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('active');
        }, 10);
    }
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('active');
        
        // Remove from DOM after transition
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add notification styles to head
const notificationStyles = `
.notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    transform: translateY(100px);
    opacity: 0;
    transition: transform 0.3s, opacity 0.3s;
}

.notification.active {
    transform: translateY(0);
    opacity: 1;
}
`;

const styleElement = document.createElement('style');
styleElement.textContent = notificationStyles;
document.head.appendChild(styleElement);