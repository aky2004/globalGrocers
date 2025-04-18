document.addEventListener('DOMContentLoaded', () => {
    loadCategories();
    setupCategoryFilter();
});

// Sample category data
const categories = [
    {
        id: 'fruits',
        name: 'Fruits',
        icon: '🍎',
        description: 'Fresh seasonal fruits',
        bgColor: 'var(--green-100)'
    },
    {
        id: 'dairy',
        name: 'Dairy',
        icon: '🥛',
        description: 'Milk, cheese & yogurt',
        bgColor: 'var(--blue-100)'
    },
    {
        id: 'bakery',
        name: 'Bakery',
        icon: '🍞',
        description: 'Fresh baked goods',
        bgColor: 'var(--amber-100)'
    },
    {
        id: 'meat',
        name: 'Meat',
        icon: '🥩',
        description: 'Fresh & quality meats',
        bgColor: 'var(--rose-100)'
    },
    {
        id: 'frozen',
        name: 'Frozen',
        icon: '❄️',
        description: 'Frozen meals & treats',
        bgColor: '#E0F7FA'
    },
    {
        id: 'pantry',
        name: 'Pantry',
        icon: '🥫',
        description: 'Essential kitchen staples',
        bgColor: '#FFF3E0'
    },
    {
        id: 'beverages',
        name: 'Beverages',
        icon: '🍹',
        description: 'Drinks & refreshments',
        bgColor: 'var(--purple-100)'
    },
    {
        id: 'snacks',
        name: 'Snacks',
        icon: '🍿',
        description: 'Chips, nuts & more',
        bgColor: '#FFFDE7'
    }
];

// Sample product data
const products = [
    {
        id: 'avocado',
        name: 'Organic Avocados',
        price: 414.17,
        imageUrl: '../images/avocado.jpg'
    },
    {
        id: 'strawberries',
        name: 'Fresh Strawberries',
        price: 289.67,
        originalPrice: 414.17,
        imageUrl: '../images/strawberry.jpg'
    },
    {
        id: 'bread',
        name: 'Sourdough Bread',
        price: 497.17,
        imageUrl: '../images/bread.jpg'
    },
    {
        id: 'milk',
        name: 'Organic Milk',
        price: 372.67,
        imageUrl: '../images/milk.jpg'
    },
    {
        id: 'yogurt',
        name: 'Greek Yogurt',
        price: 331.17,
        imageUrl: '../images/yogurt.jpg'
    },
    {
        id: 'rolls',
        name: 'Butter Croissants',
        price: 165.17,
        imageUrl: '../images/rolls.jpg'
    },
    {
        id: 'banana',
        name: 'Organic Bananas',
        price: 165.17,
        imageUrl: '../images/banana.jpg'
    },
    {
        id: 'spinach',
        name: 'Fresh Spinach',
        price: 248.17,
        imageUrl: '../images/spinach.jpg'
    },
    {
        id: 'cheese',
        name: 'Artisan Cheese',
        price: 372.67,
        originalPrice: 497.17,
        imageUrl: '../images/cheese.jpg'
    },
    {
        id: 'salmon',
        name: 'Fresh Salmon',
        price: 1327.17,
        imageUrl: '../images/salmon.jpg'
    }
];

// Load categories
function loadCategories() {
    const categoriesGrid = document.querySelector('.all-categories .categories-grid');
    if (!categoriesGrid) return;
    
    categoriesGrid.innerHTML = '';
    
    categories.forEach(category => {
        const categoryCard = document.createElement('div');
        categoryCard.className = 'category-card';
        categoryCard.style.backgroundColor = category.bgColor;
        categoryCard.dataset.category = category.id;
        
        categoryCard.innerHTML = `
            <div class="category-icon">${category.icon}</div>
            <h3>${category.name}</h3>
            <p>${category.description}</p>
            <a href="#category-products" class="category-link" data-category="${category.id}">Shop →</a>
        `;
        
        categoriesGrid.appendChild(categoryCard);
        
        // Add event listener to category link
        const categoryLink = categoryCard.querySelector('.category-link');
        categoryLink.addEventListener('click', (e) => {
            e.preventDefault();
            filterProductsByCategory(category.id);
            scrollToProducts();
        });
    });
}

// Setup category filtering
function setupCategoryFilter() {
    // Check URL parameters for category
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('cat');
    
    if (categoryParam) {
        filterProductsByCategory(categoryParam);
        scrollToProducts();
    } else {
        // Load all products by default
        loadProductsByCategory();
    }
    
    // Setup sort dropdown
    const sortSelect = document.getElementById('sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', () => {
            const currentCategory = document.querySelector('#category-title').dataset.category;
            loadProductsByCategory(currentCategory, sortSelect.value);
        });
    }
}

// Filter products by category
function filterProductsByCategory(categoryId) {
    const category = categories.find(cat => cat.id === categoryId);
    
    if (category) {
        // Update category title and description
        const categoryTitle = document.getElementById('category-title');
        const categoryDescription = document.getElementById('category-description');
        
        if (categoryTitle) {
            categoryTitle.textContent = category.name;
            categoryTitle.dataset.category = categoryId;
        }
        
        if (categoryDescription) {
            categoryDescription.textContent = `Browse our selection of ${category.name.toLowerCase()}`;
        }
        
        // Load products for this category
        const sortSelect = document.getElementById('sort-select');
        const sortValue = sortSelect ? sortSelect.value : 'popular';
        
        loadProductsByCategory(categoryId, sortValue);
    }
}

// Load products by category
function loadProductsByCategory(categoryId = null, sortBy = 'popular') {
    const productsGrid = document.getElementById('category-products-grid');
    if (!productsGrid) return;
    
    // Filter products by category
    let filteredProducts = categoryId 
        ? products.filter(product => product.category === categoryId)
        : products;
    
    // Sort products
    switch(sortBy) {
        case 'price-low':
            filteredProducts.sort((a, b) => a.price - b.price);
            break;
        case 'price-high':
            filteredProducts.sort((a, b) => b.price - a.price);
            break;
        case 'newest':
            // For demonstration, we're just shuffling the products
            filteredProducts.sort(() => Math.random() - 0.5);
            break;
        default: // popular
            // For demonstration, sort by rating
            filteredProducts.sort((a, b) => b.rating - a.rating);
    }
    
    // Clear grid and add products
    productsGrid.innerHTML = '';
    
    if (filteredProducts.length === 0) {
        productsGrid.innerHTML = '<div class="no-products">No products found in this category.</div>';
        return;
    }
    
    filteredProducts.forEach(product => {
        const productCard = document.createElement('div');
        productCard.className = 'product-card';
        productCard.innerHTML = `
            <div class="product-image">
                <img src="${product.imageUrl}" alt="${product.name}">
                ${product.isNew ? '<span class="product-badge badge-new">New</span>' : ''}
                ${product.isSale ? '<span class="product-badge badge-sale">Sale</span>' : ''}
                <button class="add-to-cart-btn" data-id="${product.id}">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="product-content">
                <div class="product-meta">
                    <span class="product-category">${categories.find(cat => cat.id === product.category)?.name || product.category}</span>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>${product.rating.toFixed(1)}</span>
                    </div>
                </div>
                <h3 class="product-title">${product.name}</h3>
                <p class="product-description">${window.appUtils.truncateText(product.description, 60)}</p>
                <div class="product-footer">
                    <div class="product-price">
                        <span class="current-price">${window.appUtils.formatCurrency(product.price)}</span>
                        ${product.originalPrice ? `<span class="original-price">${window.appUtils.formatCurrency(product.originalPrice)}</span>` : ''}
                    </div>
                    <button class="quick-add" data-id="${product.id}">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
            </div>
        `;
        productsGrid.appendChild(productCard);
        
        // Add event listeners
        const addToCartBtn = productCard.querySelector('.add-to-cart-btn');
        const quickAddBtn = productCard.querySelector('.quick-add');
        
        [addToCartBtn, quickAddBtn].forEach(btn => {
            btn.addEventListener('click', () => {
                window.cartFunctions.addToCart({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    imageUrl: product.imageUrl
                });
            });
        });
    });
}

// Scroll to products section
function scrollToProducts() {
    const productsSection = document.getElementById('category-products');
    if (productsSection) {
        productsSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Update the formatPrice function to use ₹ symbol
function formatPrice(price) {
    return `₹${price.toFixed(2)}`;
}
