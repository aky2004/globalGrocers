<?php
session_start();
include '../db_connection.php';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - GlobalGrocers</title>
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
            gap: 15px;
        }

        .cart {
            position: relative;
            margin-right: 10px;
        }

        /* Enhanced Category Grid Styling */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            padding: 40px 0;
        }

        .category-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-color: #4CAF50;
        }

        .category-icon {
            width: 80px;
            height: 80px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            background: #4CAF50;
        }

        .category-icon i {
            font-size: 32px;
            color: #4CAF50;
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon i {
            color: #fff;
        }

        .category-card h3 {
            color: #333;
            font-size: 1.25rem;
            margin: 0 0 10px;
            font-weight: 600;
        }

        .category-card p {
            color: #666;
            font-size: 0.9rem;
            margin: 0 0 15px;
            line-height: 1.5;
        }

        .category-stats {
            display: flex;
            justify-content: center;
            gap: 15px;
            font-size: 0.85rem;
            color: #666;
            margin-top: auto;
        }

        .category-stats span {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #f5f5f5;
            padding: 6px 12px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .category-stats span i {
            color: #4CAF50;
            font-size: 0.9rem;
        }

        .category-card:hover .category-stats span {
            background: #e8f5e9;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .category-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .category-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Updated profile button styling to match index.php */
        .btn-secondary.user-profile-btn {
            background-color: #6c757d;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-secondary.user-profile-btn:hover {
            background-color: #5a6268;
        }

        .btn-secondary.user-profile-btn i {
            font-size: 1rem;
        }

        /* Login button styling */
        .btn-primary {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        /* Header actions alignment */
        .auth-link {
            margin-left: 5px;
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
                <form action="products.php" method="get">
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
                        echo '<a href="../profile.php" class="btn btn-secondary user-profile-btn">';
                        echo '<i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['username']);
                        echo '</a>';
                    } else {
                        echo '<a href="../login.php" class="btn btn-primary">';
                        echo '<i class="fas fa-user"></i> Login / Sign Up →';
                        echo '</a>';
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
                <li><a href="products.php">Shop</a></li>
                <li><a href="category.php" class="active">Categories</a></li>
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
                <h1>Browse Categories</h1>
                <div class="breadcrumbs">
                    <a href="../index.php">Home</a> / <span>Categories</span>
                </div>
            </div>
        </section>

        <!-- Main Categories Section -->
        <section class="categories">
            <div class="container">
                <div class="category-grid">
                    <!-- Fruits & Vegetables -->
                    <a href="products.php?category=fruits-vegetables" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <h3>Fruits & Vegetables</h3>
                        <p>Fresh and organic produce</p>
                        <div class="category-stats">
                            <span><i class="fas fa-box"></i> 150+ Items</span>
                            <span><i class="fas fa-tag"></i> Up to 30% Off</span>
                        </div>
                    </a>

                    <!-- Dairy & Eggs -->
                    <a href="products.php?category=dairy-eggs" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-egg"></i>
                        </div>
                        <h3>Dairy & Eggs</h3>
                        <p>Fresh dairy and quality eggs</p>
                        <div class="category-stats">
                            <span><i class="fas fa-box"></i> 80+ Items</span>
                            <span><i class="fas fa-tag"></i> Up to 20% Off</span>
                        </div>
                    </a>

                    <!-- Bakery -->
                    <a href="products.php?category=bakery" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-bread-slice"></i>
                        </div>
                        <h3>Bakery</h3>
                        <p>Fresh baked goods daily</p>
                        <div class="category-stats">
                            <span><i class="fas fa-box"></i> 100+ Items</span>
                            <span><i class="fas fa-tag"></i> Up to 25% Off</span>
                        </div>
                    </a>

                    <!-- Meat & Seafood -->
                    <a href="products.php?category=meat-seafood" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-fish"></i>
                        </div>
                        <h3>Meat & Seafood</h3>
                        <p>Quality meats and fresh seafood</p>
                        <div class="category-stats">
                            <span><i class="fas fa-box"></i> 120+ Items</span>
                            <span><i class="fas fa-tag"></i> Up to 15% Off</span>
                        </div>
                    </a>

                    <!-- Frozen Foods -->
                    <a href="products.php?category=frozen" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <h3>Frozen Foods</h3>
                        <p>Frozen meals and treats</p>
                        <div class="category-stats">
                            <span><i class="fas fa-box"></i> 90+ Items</span>
                            <span><i class="fas fa-tag"></i> Up to 25% Off</span>
                        </div>
                    </a>

                    <!-- Pantry -->
                    <a href="products.php?category=pantry" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <h3>Pantry</h3>
                        <p>Essential kitchen staples</p>
                        <div class="category-stats">
                            <span><i class="fas fa-box"></i> 200+ Items</span>
                            <span><i class="fas fa-tag"></i> Up to 35% Off</span>
                        </div>
                    </a>

                    <!-- Beverages -->
                    <a href="products.php?category=beverages" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-glass-cheers"></i>
                        </div>
                        <h3>Beverages</h3>
                        <p>Drinks and refreshments</p>
                        <div class="category-stats">
                            <span><i class="fas fa-box"></i> 70+ Items</span>
                            <span><i class="fas fa-tag"></i> Up to 20% Off</span>
                        </div>
                    </a>

                    <!-- Snacks -->
                    <a href="products.php?category=snacks" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-cookie"></i>
                        </div>
                        <h3>Snacks</h3>
                        <p>Chips, nuts, and more</p>
                        <div class="category-stats">
                            <span><i class="fas fa-box"></i> 130+ Items</span>
                            <span><i class="fas fa-tag"></i> Up to 30% Off</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="featured-categories">
            <div class="container">
                <div class="section-header">
                    <h2>Featured Categories</h2>
                </div>
                <div class="featured-grid">
                    <div class="featured-category" style="background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e')">
                        <div class="featured-content">
                            <h3>Organic Produce</h3>
                            <p>Fresh from local farms</p>
                            <a href="products.html?category=fruits-vegetables&filter=organic" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                    <div class="featured-category" style="background-image: url('https://images.unsplash.com/photo-1509440159596-0249088772ff')">
                        <div class="featured-content">
                            <h3>Fresh Bakery</h3>
                            <p>Baked daily</p>
                            <a href="products.html?category=bakery" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                    <div class="featured-category" style="background-image: url('https://images.unsplash.com/photo-1547592180-85f173990554')">
                        <div class="featured-content">
                            <h3>Healthy Snacks</h3>
                            <p>Nutritious & delicious</p>
                            <a href="products.html?category=snacks&filter=healthy" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
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
    <script src="js/language.js"></script>

</body>
</html>

