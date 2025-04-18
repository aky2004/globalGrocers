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
    <title data-translate="about.pageTitle">About Us - GlobalGrocers</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom styles for About page */
        .about-section {
            padding: 80px 0;
            background-color: #fff;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-content h2 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 30px;
        }

        .about-content p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        .stat-item {
            text-align: left;
        }

        .stat-number {
            display: block;
            font-size: 2.5em;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 1.1em;
        }

        .about-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* Core Values Section */
        .values-section {
            padding: 80px 0;
            background-color: #f9f9f9;
        }

        .values-section h2 {
            text-align: center;
            font-size: 2.5em;
            color: #333;
            margin-bottom: 50px;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .value-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .value-icon i {
            font-size: 32px;
            color: #4CAF50;
        }

        .value-card h3 {
            color: #333;
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        .value-card p {
            color: #666;
            line-height: 1.6;
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
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .auth-link {
            margin-left: 5px;
        }

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

        /* Language selector styling */
        .language-selector {
            position: relative;
            cursor: pointer;
        }

        .language-selector span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .language-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 8px 0;
            min-width: 150px;
            z-index: 100;
        }

        .language-selector:hover .language-dropdown {
            display: block;
        }

        .language-dropdown a {
            display: block;
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
        }

        .language-dropdown a:hover {
            background: #f5f5f5;
        }

        /* Breadcrumb styling */
        .breadcrumbs {
            margin-top: 10px;
            color: #666;
        }

        .breadcrumbs a {
            color: #4CAF50;
            text-decoration: none;
        }

        .breadcrumbs span {
            color: #999;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .about-grid {
                grid-template-columns: 1fr;
            }

            .values-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .about-stats {
                grid-template-columns: 1fr;
            }

            .values-grid {
                grid-template-columns: 1fr;
            }
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

    <!-- Navigation -->
    <nav>
        <div class="container">
            <ul class="main-nav">
                <li><a href="../index.php" data-translate="about.home">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php" class="active" data-translate="about.aboutUs">About Us</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Page Banner -->
    <section class="page-banner">
        <div class="container">
            <h1>About Us</h1>
            <div class="breadcrumbs">
                <a href="../index.html">Home</a> / <span>About Us</span>
            </div>
        </div>
    </section>

    <main>
        <!-- Our Story Section -->
        <section class="about-section">
            <div class="container">
                <div class="about-grid">
                    <div class="about-content">
                        <h2 data-translate="about.trustedPartner">Your Trusted Grocery Partner</h2>
                        <p data-translate="about.aboutStory1">GlobalGrocers started with a simple mission: to make quality groceries accessible to everyone. Founded in 2020, we've grown from a small local store to a trusted online grocery platform serving thousands of customers.</p>
                        <p data-translate="about.aboutStory2">We work directly with farmers, artisans, and producers to bring you the freshest products at the best prices. Our commitment to quality, sustainability, and customer satisfaction drives everything we do.</p>
                        <div class="about-stats">
                            <div class="stat-item">
                                <span class="stat-number">50K+</span>
                                <span class="stat-label" data-translate="about.happyCustomers">Happy Customers</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">5000+</span>
                                <span class="stat-label" data-translate="about.products">Products</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">98%</span>
                                <span class="stat-label" data-translate="about.satisfactionRate">Satisfaction Rate</span>
                            </div>
                        </div>
                    </div>
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80" alt="Fresh produce display">
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Values Section -->
        <section class="values-section">
            <div class="container">
                <h2>Our Core Values</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3>Quality First</h3>
                        <p>We ensure only the freshest and highest quality products reach our customers.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h3>Fast Delivery</h3>
                        <p>Same-day delivery to ensure your groceries arrive fresh and on time.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3>Customer Care</h3>
                        <p>24/7 support to assist you with any questions or concerns.</p>
                    </div>
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h3>Sustainability</h3>
                        <p>Committed to eco-friendly practices and sustainable packaging.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team-section">
            <div class="container">
                <h2 data-translate="about.meetTeam">Meet Our Team</h2>
                <div class="team-grid">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="../images/team/other.jpg" alt="CEO" onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80'">
                        </div>
                        <div class="member-content">
                            <h3>Prince Yadav</h3>
                            <span class="member-role">Registration Number: 12307406</span>
                            <p>One codebase, one master — Prince handles both frontend magic and backend muscle with unmatched skill and style.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="mailto:rahul@grocerymart.com"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <img src="../images/team/other.jpg" alt="Operations Director" onerror="this.src='https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80'">
                        </div>
                        <div class="member-content">
                            <h3>Aman Kumar Yadav</h3>
                            <span class="member-role">Registration Number: 12309982</span>
                            <p>Aman weaves code like art, blending HTML, CSS, and JavaScript into flawless, high-performance designs that speak louder than words.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="mailto:priya@grocerymart.com"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <img src="../images/team/other.jpg" alt="Head of Technology" onerror="this.src='https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80'">
                        </div>
                        <div class="member-content">
                            <h3>Preet Rana</h3>
                            <span class="member-role">Registration Number: 12308619</span>
                            <p>Preet keeps the core tight and the sessions tighter, orchestrating backend brilliance through clean, efficient PHP.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="mailto:amit@grocerymart.com"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <img src="../images/team/other.jpg" alt="Customer Relations Manager" onerror="this.src='https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80'">
                        </div>
                        <div class="member-content">
                            <h3>Shivam Anand</h3>
                            <span class="member-role">Registration Number: 12308901</span>
                            <p>Sneha works tirelessly to ensure our customers receive the best possible service and support.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="mailto:sneha@grocerymart.com"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
    <script src="../js/translate.js"></script>
    <script src="../js/language.js"></script>

</body>
</html> 