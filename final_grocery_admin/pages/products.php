<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - GlobalGrocers</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
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
                <a href="../index.php">
                    <h1>GlobalGrocers</h1>
                </a>
            </div>
            <div class="search-bar" style="flex: 1; margin: 0 20px;">
                <form action="products.html" method="get">
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
                <div class="cart">
                    <button class="cart-toggle" onclick="toggleCart()">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge" id="cart-count">0</span>
                    </button>
                </div>
                <div class="auth-link">
                    <?php
                        session_start();
                        if (isset($_SESSION['username'])) {
                            echo '<a href="../profile.php" class="btn btn-secondary"><i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['username']) . '</a>';
                        } else {
                            echo '<a href="../login.php" class="btn btn-primary"><i class="fas fa-user"></i> Login / Sign Up →</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Cart Drawer -->
    <div class="cart-drawer">
        <div class="cart-header">
            <h3>Your Cart</h3>
            <button class="close-cart" onclick="closeCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="cart-total-amount">₹0.00</span>
            </div>
            <a href="cart.php" class="btn btn-primary checkout-btn">Checkout</a>
            <button class="btn btn-secondary clear-cart-btn" onclick="clearCart()">Clear Cart</button>
        </div>
    </div>
    <div class="overlay"></div>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <ul class="main-nav">
                <li><a href="../index.php">Home</a></li>
                <li><a href="products.php" class="active">Shop</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <main>
        <!-- Page Banner -->
        <section class="page-banner">
            <div class="container">
                <h1>Products</h1>
                <div class="breadcrumbs">
                    <a href="../index.php">Home</a> / <span>Products</span>
                </div>
            </div>
        </section>

        <!-- Filter and Sort Section -->
        <section class="filter-section">
            <div class="container">
                <div class="filter-wrapper">
                    <div class="filter-group">
                        <label>Sort by:</label>
                        <select id="sort-products">
                            <option value="featured">Featured</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="rating">Top Rated</option>
                            <option value="newest">Newest</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Show:</label>
                        <select id="show-products">
                            <option value="all">All Products</option>
                            <option value="sale">On Sale</option>
                            <option value="new">New Arrivals</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section class="product-section">
            <div class="container">
                <div class="product-grid">
                    <!-- Products will be loaded dynamically -->
                </div>
            </div>
        </section>
    </main>

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
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Grocery Street</p>
                    <p>City, State 12345</p>
                    <p><i class="fas fa-envelope"></i> info@globalgrocers.com</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7890</p>
                </div>
                
                <div class="footer-newsletter">
                    <h3>Subscribe to our newsletter</h3>
                    <form id="newsletter-form">
                        <input type="email" placeholder="Your email" required>
                        <button type="submit" class="btn">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 GlobalGrocers. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../js/main.js"></script>
    <script src="../js/cart.js"></script>
    <script src="../js/products.js"></script>
    <script src="js/language.js"></script>

</body>
</html> 