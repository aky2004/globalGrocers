document.addEventListener('DOMContentLoaded', () => {
    // Get the category from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category');
    const searchQuery = urlParams.get('q');

    // Product data
    const products = {
        'fruits-vegetables': [
            {
                name: 'Organic Avocados',
                price: 414.17,
                image: '../images/avocado.jpg',
                rating: 4.8,
                description: 'Fresh and ripe organic avocados',
                isNew: true
            },
            {
                name: 'Fresh Strawberries',
                price: 289.67,
                originalPrice: 414.17,
                image: '../images/strawberry.jpg',
                rating: 4.6,
                description: 'Sweet and juicy strawberries',
                isSale: true
            },
            {
                name: 'Fresh Spinach',
                price: 248.17,
                image: '../images/spinach.jpg',
                rating: 4.7,
                description: 'Organic baby spinach leaves'
            },
            {
                name: 'Organic Bell Peppers',
                price: 331.17,
                image: '../images/bellpepper.jpg',
                rating: 4.5,
                description: 'Colorful organic bell peppers',
                isNew: true
            }
        ],
        'dairy-eggs': [
            {
                name: 'Organic Milk',
                price: 372.67,
                image: '../images/milk.jpg',
                rating: 4.9,
                description: 'Fresh organic whole milk'
            },
            {
                name: 'Greek Yogurt',
                price: 331.17,
                image: '../images/yogurt.jpg',
                rating: 4.7,
                description: 'Creamy Greek-style yogurt',
                isNew: true
            },
            {
                name: 'Free-Range Eggs',
                price: 497.17,
                image: '../images/rangeEggs.jpg',
                rating: 4.8,
                description: 'Farm-fresh free-range eggs'
            },
            {
                name: 'Artisan Cheese Selection',
                price: 746.17,
                originalPrice: 912.17,
                image: '../images/artCheese.jpg',
                rating: 4.9,
                description: 'Premium cheese assortment',
                isSale: true
            }
        ],
        'bakery': [
            {
                name: 'Sourdough Bread',
                price: 580.17,
                image: '../images/bread.jpg',
                rating: 4.9,
                description: 'Artisanal sourdough bread'
            },
            {
                name: 'Butter Croissants',
                price: 206.67,
                originalPrice: 331.17,
                image: '../images/butCroissants.jpg',
                rating: 4.7,
                description: 'Fresh-baked butter croissants',
                isSale: true
            },
            {
                name: 'French Baguette',
                price: 289.67,
                image: '../images/baguTTe.avif',
                rating: 4.6,
                description: 'Traditional French baguette'
            },
            {
                name: 'Cinnamon Rolls',
                price: 414.17,
                image: '../images/cinnamonRolls.jpg',
                rating: 4.8,
                description: 'Fresh-baked cinnamon rolls',
                isNew: true
            }
        ],
        'meat-seafood': [
            {
                name: 'Fresh Salmon Fillet',
                price: 1078.17,
                image: '../images/salmonMill.jpg',
                rating: 4.8,
                description: 'Premium Atlantic salmon fillet',
                isNew: true
            },
            {
                name: 'Organic Chicken Breast',
                price: 746.17,
                image: 'https://images.unsplash.com/photo-1604503468506-a8da13d82791',
                rating: 4.7,
                description: 'Free-range organic chicken breast'
            },
            {
                name: 'Premium Ground Beef',
                price: 663.17,
                originalPrice: 829.17,
                image: '../images/GroundBeef.jpg',
                rating: 4.6,
                description: 'Fresh ground beef, 90% lean',
                isSale: true
            },
            {
                name: 'Fresh Shrimp',
                price: 1327.17,
                image: '../images/shrimp.jpg',
                rating: 4.8,
                description: 'Wild-caught jumbo shrimp',
                isNew: true
            }
        ],
        'frozen': [
            {
                name: 'Mixed Vegetables',
                price: 331.17,
                image: '../images/mixedVeg.jpg',
                rating: 4.5,
                description: 'Premium frozen vegetable mix'
            },
            {
                name: 'Ice Cream Collection',
                price: 497.17,
                originalPrice: 663.17,
                image: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb',
                rating: 4.8,
                description: 'Assorted ice cream flavors',
                isSale: true
            },
            {
                name: 'Pizza Pack',
                price: 829.17,
                image: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38',
                rating: 4.6,
                description: 'Ready-to-bake frozen pizzas',
                isNew: true
            },
            {
                name: 'Frozen Berry Mix',
                price: 580.17,
                image: 'https://images.unsplash.com/photo-1563746098251-d35aef196e83',
                rating: 4.7,
                description: 'Premium mixed berries',
                isNew: true
            }
        ],
        'pantry': [
            {
                name: 'Organic Pasta',
                price: 248.17,
                image: 'https://images.unsplash.com/photo-1551462147-37885acc36f1',
                rating: 4.7,
                description: 'Premium Italian pasta'
            },
            {
                name: 'Extra Virgin Olive Oil',
                price: 995.17,
                originalPrice: 1244.17,
                image: 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5',
                rating: 4.9,
                description: 'Cold-pressed olive oil',
                isSale: true
            },
            {
                name: 'Quinoa Pack',
                price: 580.17,
                image: '../images/quionna.jpg',
                rating: 4.6,
                description: 'Organic white quinoa',
                isNew: true
            },
            {
                name: 'Organic Honey',
                price: 746.17,
                image: '../images/honey.jpg',
                rating: 4.8,
                description: 'Raw organic honey',
                isNew: true
            }
        ],
        'beverages': [
            {
                name: 'Cold Brew Coffee',
                price: 414.17,
                image: 'https://images.unsplash.com/photo-1517701604599-bb29b565090c',
                rating: 4.8,
                description: 'Smooth cold brew coffee',
                isNew: true
            },
            {
                name: 'Green Tea Collection',
                price: 663.17,
                originalPrice: 829.17,
                image: 'https://images.unsplash.com/photo-1627435601361-ec25f5b1d0e5',
                rating: 4.7,
                description: 'Organic green tea varieties',
                isSale: true
            },
            {
                name: 'Fresh Orange Juice',
                price: 497.17,
                image: 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b',
                rating: 4.9,
                description: 'Freshly squeezed orange juice'
            },
            {
                name: 'Sparkling Water Pack',
                price: 1078.17,
                image: '../images/sparklingWater.jpg',
                rating: 4.6,
                description: 'Assorted flavored sparkling water',
                isSale: true
            }
        ],
        'snacks': [
            {
                name: 'Mixed Nuts',
                price: 746.17,
                image: '../images/mNuts.jpg',
                rating: 4.8,
                description: 'Premium roasted nut mix',
                isNew: true
            },
            {
                name: 'Potato Chips',
                price: 206.67,
                originalPrice: 289.67,
                image: '../images/pChips.jpg',
                rating: 4.6,
                description: 'Crispy kettle-cooked chips',
                isSale: true
            },
            {
                name: 'Dark Chocolate',
                price: 414.17,
                image: '../images/dChocolate.jpg',
                rating: 4.9,
                description: '72% cocoa dark chocolate'
            },
            {
                name: 'Trail Mix',
                price: 580.17,
                image: '../images/trailMix.jpg',
                rating: 4.7,
                description: 'Premium dried fruits and nuts mix',
                isNew: true
            }
        ]
    };

    // Filtering and sorting functions
    function filterProducts(productsToFilter, filterType) {
        switch (filterType) {
            case 'sale':
                return productsToFilter.filter(product => product.isSale);
            case 'new':
                return productsToFilter.filter(product => product.isNew);
            default:
                return productsToFilter;
        }
    }

    function sortProducts(productsToSort, sortType) {
        switch (sortType) {
            case 'price-low':
                return [...productsToSort].sort((a, b) => a.price - b.price);
            case 'price-high':
                return [...productsToSort].sort((a, b) => b.price - a.price);
            case 'rating':
                return [...productsToSort].sort((a, b) => b.rating - a.rating);
            case 'newest':
                return [...productsToSort].sort((a, b) => (b.isNew ? 1 : 0) - (a.isNew ? 1 : 0));
            default: // 'featured'
                return productsToSort;
        }
    }

    function searchProducts(productsToSearch, query) {
        if (!query) return productsToSearch;
        
        const searchTerm = query.toLowerCase();
        return productsToSearch.filter(product => 
            product.name.toLowerCase().includes(searchTerm) ||
            product.description.toLowerCase().includes(searchTerm)
        );
    }

    function displayProducts(categoryName, filterType = 'all', sortType = 'featured', searchTerm = '') {
        const productGrid = document.querySelector('.product-grid');
        const categoryTitle = document.querySelector('.page-banner h1');
        let productsToShow = [];

        // Get products for the category
        if (categoryName && products[categoryName]) {
            productsToShow = products[categoryName];
            categoryTitle.textContent = categoryName
                .split('-')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        } else {
            // Show all products if no category is selected
            productsToShow = Object.values(products).flat();
            categoryTitle.textContent = searchTerm ? 'Search Results' : 'All Products';
        }

        // Apply search filter if there's a search term
        productsToShow = searchProducts(productsToShow, searchTerm);

        // Apply selected filter
        productsToShow = filterProducts(productsToShow, filterType);

        // Apply selected sort
        productsToShow = sortProducts(productsToShow, sortType);

        if (productsToShow.length === 0) {
            productGrid.innerHTML = '<div class="no-products">No products found.</div>';
            return;
        }

        productGrid.innerHTML = productsToShow.map(product => `
            <div class="product-card">
                ${product.isNew ? '<div class="product-badge new">New</div>' : ''}
                ${product.isSale ? '<div class="product-badge sale">Sale</div>' : ''}
                <div class="product-image">
                    <img src="${product.image}" alt="${product.name}">
                </div>
                <div class="product-rating">
                    <i class="fas fa-star"></i>
                    <span>${product.rating}</span>
                </div>
                <h3 class="product-title">${product.name}</h3>
                <p class="product-description">${product.description}</p>
                <div class="product-price">
                    ${product.isSale ? 
                        `<span class="current-price">₹${product.price}</span>
                         <span class="original-price">₹${product.originalPrice}</span>` :
                        `₹${product.price}`
                    }
                </div>
                <button class="add-to-cart" onclick="window.cartFunctions.addToCart({
                    id: '${product.name.toLowerCase().replace(/\s+/g, '-')}',
                    name: '${product.name}',
                    price: ${product.price},
                    image: '${product.image}'
                })">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </div>
        `).join('');
    }

    // Set up event listeners for filters and sorting
    const sortSelect = document.getElementById('sort-products');
    const filterSelect = document.getElementById('show-products');

    sortSelect.addEventListener('change', () => {
        displayProducts(category, filterSelect.value, sortSelect.value, searchQuery);
    });

    filterSelect.addEventListener('change', () => {
        displayProducts(category, filterSelect.value, sortSelect.value, searchQuery);
    });

    // Initial display
    displayProducts(category, 'all', 'featured', searchQuery);
}); 