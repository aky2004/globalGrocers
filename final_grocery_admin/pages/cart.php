<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - GlobalGrocers</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="../index.php">
                    <h1>GlobalGrocers</h1>
                </a>
            </div>
            <div class="search-bar">
                <form action="products.php" method="get">
                    <input type="text" placeholder="Search for products..." name="q">
                    <i class="fas fa-search"></i>
                </form>
            </div>
            <div class="header-actions">
                <div class="language-selector">
                    <span><i class="fas fa-globe"></i> English</span>
                </div>
                <button class="cart-toggle" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cart-count">0</span>
                </button>
                <div class="auth-link">
    <?php
        session_start();
        if (isset($_SESSION['username'])) {
            echo '<a href="profile.php" class="btn btn-secondary"><i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['username']) . '</a>';
        } else {
            echo '<a href="../login.php" class="btn btn-primary"><i class="fas fa-user"></i> Login / Sign Up →</a>';
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
                <li><a href="../index.php">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </div>
    </nav>

    <!-- Cart Page Content -->
    <section class="cart-page">
        <div class="container">
            <h1>Your Shopping Cart</h1>
            
            <div class="cart-content">
                <div class="cart-items">
                    <!-- Cart items will be dynamically inserted here -->
                </div>
                
                <div class="cart-summary">
                    <div class="cart-summary-row">
                        <span>Subtotal:</span>
                        <span class="cart-subtotal">₹0.00</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Total:</span>
                        <span class="cart-final-total">₹0.00</span>
                    </div>
                    
                    <button class="btn btn-primary btn-block checkout-btn" onclick="window.location.href='checkout.html'">
                        Proceed to Checkout
                    </button>
                    <button class="btn btn-secondary btn-block clear-cart-btn">
                        Clear Cart
                    </button>
                    <a href="products.php" class="btn btn-secondary btn-block">
                        Continue Shopping
                    </a>
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
                    <p>Your one-stop shop for fresh groceries delivered to your doorstep.</p>
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
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="cart-total-amount">₹0.00</span>
            </div>
            <a href="cart.html" class="btn btn-primary btn-block">View Cart</a>
            <button onclick="window.location.href='checkout.html'" class="btn btn-primary btn-block">Checkout</button>
        </div>
    </div>
    
    <!-- Overlay -->
    <div class="overlay"></div>

    <script src="../js/main.js"></script>
    <script src="../js/cart.js"></script>
    <script src="../js/language.js"></script>
</body>
</html> 