<?php
session_start();
include 'db_connection.php';

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
$username = $loggedIn ? $_SESSION['username'] : '';

if ($loggedIn) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, profile_image FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['profile_image'] = $user['profile_image'];
    }
}
?>


<!-- HTML here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobalGrocers - Fresh Groceries Delivered</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Cart badge styling */
        .cart-toggle {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .cart-toggle i {
            font-size: 1.5rem;
            color: #333;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #4CAF50;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Header actions styling */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart {
            position: relative;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
            <div class="logo">
                <a href="index.php">
                    <h1>GlobalGrocers</h1>
                </a>
            </div>
            <div class="search-bar" style="flex: 1; margin: 0 20px;">
                <form action="pages/products.html" method="get">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for products..." name="q">
                </form>
            </div>
            <div class="header-actions" style="display: flex; align-items: center; gap: 15px;">
                <div class="language-selector">
                    <span><i class="fas fa-globe"></i> English</span>
                    <div class="language-dropdown">
                        <a href="#" data-lang="en">English</a>
                        <a href="#" data-lang="es">Español</a>
                        <a href="#" data-lang="fr">Français</a>
                        <a href="#" data-lang="hi">हिंदी</a>
                    </div>
                </div>
                <button class="cart-toggle" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cart-count">0</span>
                </button>
                <div class="auth-link">
                    <?php
                    if ($loggedIn) {
                        echo '<a href="profile.php" class="btn btn-secondary user-profile-btn">';
                        echo '<i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['username']);
                        echo '</a>';
                    } else {
                        echo '<a href="login.php" class="btn btn-primary">';
                        echo '<i class="fas fa-user"></i> Login / Sign Up →';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <ul class="main-nav">
                <li><a href="index.php" class="active" data-lang="home">Home</a></li>
                <li><a href="pages/products.php" data-lang="shop">Shop</a></li>
                <li><a href="pages/products.php" data-lang="categories">Categories</a></li>
                <li><a href="pages/about.php" data-lang="about_us">About Us</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h2 data-lang="hero_title">Fresh Groceries Delivered to Your Door</h2>
                <p data-lang="hero_subtitle">Shop from our wide selection of fresh produce, pantry essentials, and more.</p>
                <div class="hero-buttons">
                    <a href="pages/products.php" class="btn btn-primary" data-lang="shop_now">Shop Now <i class="fas fa-arrow-right"></i></a>
                    <a href="pages/category.php" class="btn btn-secondary" data-lang="popular_categories">Popular Categories</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="images/groceries.jpg" alt="Fresh produce display">
                <div class="delivery-badge">
                    <div class="badge-icon">24h</div>
                    <div class="badge-text">
                        <span>Fast Delivery</span>
                        <small>Order before 5PM</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <div class="section-header">
                <h2 data-lang="browse_categories">Browse Categories</h2>
                <a href="pages/category.php" class="view-all" data-lang="view_all_categories">View All Categories <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="category-grid">
                <a href="pages/products.php?category=fruits-vegetables" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-apple-alt"></i>
                    </div>
                    <h3 data-lang="fruits_vegetables">Fruits & Vegetables</h3>
                    <p>Fresh and organic produce</p>
                </a>
                <a href="pages/products.php?category=dairy-eggs" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-egg"></i>
                    </div>
                    <h3 data-lang="dairy_eggs">Dairy & Eggs</h3>
                    <p>Fresh dairy and quality eggs</p>
                </a>
                <a href="pages/products.php?category=bakery" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-bread-slice"></i>
                    </div>
                    <h3 data-lang="bakery">Bakery</h3>
                    <p>Fresh baked goods daily</p>
                </a>
                <a href="pages/products.php?category=meat-seafood" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-fish"></i>
                    </div>
                    <h3 data-lang="meat_seafood">Meat & Seafood</h3>
                    <p>Quality meats and fresh seafood</p>
                </a>
                <a href="pages/products.php?category=frozen" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-snowflake"></i>
                    </div>
                    <h3 data-lang="frozen_foods">Frozen Foods</h3>
                    <p>Frozen meals and treats</p>
                </a>
                <a href="pages/products.php?category=pantry" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3 data-lang="pantry">Pantry</h3>
                    <p>Essential kitchen staples</p>
                </a>
                <a href="pages/products.php?category=beverages" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-glass-cheers"></i>
                    </div>
                    <h3 data-lang="beverages">Beverages</h3>
                    <p>Drinks and refreshments</p>
                </a>
                <a href="pages/products.php?category=snacks" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-cookie"></i>
                    </div>
                    <h3 data-lang="snacks">Snacks</h3>
                    <p>Chips, nuts, and more</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products">
        <div class="container">
            <div class="section-header">
                <h2 data-lang="featured_products">Featured Products</h2>
                <a href="pages/products.php" class="view-all" data-lang="view_all_products">View All Products <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-grid">
                <div class="product-card" data-id="avocado">
                    <div class="product-badge new" data-lang="new">New</div>
                    <div class="product-image">
                        <img src="images/avocado.jpg" alt="Organic Avocados">
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>4.8</span>
                    </div>
                    <h3 class="product-title" data-lang="product_avocado">Organic Avocados</h3>
                    <div class="product-price">
                        <span class="current-price" data-lang="product_avocado_price">₹414.17</span>
                    </div>
                    <button class="add-to-cart" aria-label="Add to cart" data-lang="add_to_cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
                
                <div class="product-card" data-id="strawberry">
                    <div class="product-badge sale" data-lang="sale">Sale</div>
                    <div class="product-image">
                        <img src="images/strawberry.jpg" alt="Fresh Strawberries">
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>4.6</span>
                    </div>
                    <h3 class="product-title" data-lang="product_strawberry">Fresh Strawberries</h3>
                    <div class="product-price">
                        <span class="current-price" data-lang="product_strawberry_price">₹289.67</span>
                        <span class="original-price" data-lang="product_strawberry_original">₹414.17</span>
                    </div>
                    <button class="add-to-cart" aria-label="Add to cart" data-lang="add_to_cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
                
                <div class="product-card" data-id="bread">
                    <div class="product-image">
                        <img src="images/bread.jpg" alt="Artisan Sourdough Bread">
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>4.9</span>
                    </div>
                    <h3 class="product-title" data-lang="product_bread">Artisan Sourdough Bread</h3>
                    <div class="product-price">
                        <span class="current-price" data-lang="product_bread_price">₹497.17</span>
                    </div>
                    <button class="add-to-cart" aria-label="Add to cart" data-lang="add_to_cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
                
                <div class="product-card" data-id="milk">
                    <div class="product-image">
                        <img src="images/milk.jpg" alt="Organic Milk">
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>4.7</span>
                    </div>
                    <h3 class="product-title" data-lang="product_milk">Organic Milk</h3>
                    <div class="product-price">
                        <span class="current-price" data-lang="product_milk_price">₹273.07</span>
                    </div>
                    <button class="add-to-cart" aria-label="Add to cart" data-lang="add_to_cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>

                <div class="product-card" data-id="mango">
                    <div class="product-badge new" data-lang="new">New</div>
                    <div class="product-image">
                        <img src="images/mango.jpg" alt="Fresh Mangoes">
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>4.9</span>
                    </div>
                    <h3 class="product-title" data-lang="product_mango">Fresh Mangoes</h3>
                    <div class="product-price">
                        <span class="current-price" data-lang="product_mango_price">₹349.99</span>
                    </div>
                    <button class="add-to-cart" aria-label="Add to cart" data-lang="add_to_cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>

                <div class="product-card" data-id="honey">
                    <div class="product-badge organic">Organic</div>
                    <div class="product-image">
                        <img src="images/honey.jpg" alt="Pure Honey">
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>4.8</span>
                    </div>
                    <h3 class="product-title" data-lang="product_honey">Pure Honey</h3>
                    <div class="product-price">
                        <span class="current-price" data-lang="product_honey_price">₹456.50</span>
                    </div>
                    <button class="add-to-cart" aria-label="Add to cart" data-lang="add_to_cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>

                <div class="product-card" data-id="almonds">
                    <div class="product-badge sale" data-lang="sale">Sale</div>
                    <div class="product-image">
                        <img src="images/almonds.jpg" alt="Premium Almonds">
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>4.7</span>
                    </div>
                    <h3 class="product-title" data-lang="product_almonds">Premium Almonds</h3>
                    <div class="product-price">
                        <span class="current-price" data-lang="product_almonds_price">₹599.99</span>
                        <span class="original-price" data-lang="product_almonds_original">₹749.99</span>
                    </div>
                    <button class="add-to-cart" aria-label="Add to cart" data-lang="add_to_cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>

                <div class="product-card" data-id="chocolate">
                    <div class="product-image">
                        <img src="images/dark-chocolate.jpg" alt="Dark Chocolate">
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i>
                        <span>4.9</span>
                    </div>
                    <h3 class="product-title" data-lang="product_chocolate">Dark Chocolate</h3>
                    <div class="product-price">
                        <span class="current-price" data-lang="product_chocolate_price">₹299.99</span>
                    </div>
                    <button class="add-to-cart" aria-label="Add to cart" data-lang="add_to_cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Shop With Us Section -->
    <section class="why-shop">
        <div class="container">
            <h2 data-lang="why_shop_with_us">Why Shop With Us</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 data-lang="always_fresh">Always Fresh</h3>
                    <p data-lang="fresh_source">We source directly from local farms and suppliers</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3 data-lang="fast_delivery">Fast Delivery</h3>
                    <p data-lang="delivery_hours">Get your groceries delivered within hours</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 data-lang="premium_quality">Premium Quality</h3>
                    <p data-lang="best_products">We select only the best products for you</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 data-lang="support_24_7">24/7 Support</h3>
                    <p data-lang="always_available">Our customer support team is always available</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-top">
                <div class="footer-about">
                    <h3>GlobalGrocers</h3>
                    <p>Your one-stop shop for fresh groceries from around the world, delivered right to your doorstep.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3 data-lang="quick_links">Quick Links</h3>
                    <ul>
                        <li><a href="pages/about.html" data-lang="about_us">About Us</a></li>
                        <li><a href="#" data-lang="faq">FAQ</a></li>
                        <li><a href="#" data-lang="terms">Terms & Conditions</a></li>
                        <li><a href="#" data-lang="privacy">Privacy Policy</a></li>
                        <li><a href="pages/contact.html" data-lang="contact">Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h3 data-lang="contact">Contact Us</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Grocery Street</p>
                    <p>City, State 12345</p>
                    <p><i class="fas fa-envelope"></i> info@globalgrocers.com</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7890</p>
                </div>
                
                <div class="footer-newsletter">
                    <h3 data-lang="subscribe">Subscribe to our newsletter</h3>
                    <form id="newsletter-form">
                        <input type="email" placeholder="Your email" data-lang="your_email" required>
                        <button type="submit" class="btn" data-lang="subscribe_button">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 GlobalGrocers. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Cart Drawer -->
    <div class="cart-drawer">
        <div class="cart-header">
            <h3>Your Cart</h3>
            <button class="close-cart" onclick="closeCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items">
            <!-- Cart items will be dynamically inserted here -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>Your cart is empty</p>
                <a href="pages/products.html" class="btn btn-primary">Start Shopping</a>
            </div>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="cart-total-amount">₹0.00</span>
            </div>
            <a href="pages/cart.php" class="btn btn-primary btn-block">View Cart</a>
            <button onclick="window.location.href='pages/checkout.html'" class="btn btn-primary btn-block">Checkout</button>
        </div>
    </div>
    
    <!-- Overlay -->
    <div class="overlay"></div>

    <script src="js/main.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/language.js"></script>
</body>
</html>
