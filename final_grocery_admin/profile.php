<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error_message = '';
$success_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get username from POST data with validation
        $username = isset($_POST['username']) ? trim($_POST['username']) : null;
        if (empty($username)) {
            throw new Exception("Username cannot be empty");
        }

        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
        $address = isset($_POST['address']) ? trim($_POST['address']) : null;
        $preferences = isset($_POST['preferences']) ? json_encode($_POST['preferences']) : null;

        // Handle profile image upload
        $profile_image = null;
        if (!empty($_FILES['profile_image']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            
            if (!in_array($file_extension, $allowed_types)) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed.");
            }

            $target_file = $target_dir . time() . '_' . basename($_FILES['profile_image']['name']);
            
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $profile_image = $target_file;
            } else {
                throw new Exception("Sorry, there was an error uploading your file.");
            }
        }

        // Build the update query
        $updateFields = ["username = ?"];
        $params = [$username];

        if ($phone !== null) {
            $updateFields[] = "phone = ?";
            $params[] = $phone;
        }

        if ($address !== null) {
            $updateFields[] = "address = ?";
            $params[] = $address;
        }

        if ($profile_image) {
            $updateFields[] = "profile_image = ?";
            $params[] = $profile_image;
        }

        if ($preferences !== null) {
            $updateFields[] = "preferences = ?";
            $params[] = $preferences;
        }

        $query = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
        $params[] = $user_id;

        $stmt = $conn->prepare($query);
        if ($stmt->execute($params)) {
            $_SESSION['username'] = $username;
            if ($profile_image) {
                $_SESSION['profile_image'] = $profile_image;
            }
            $success_message = "Profile updated successfully!";
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Fetch current user info with error handling
try {
    $stmt = $conn->prepare("SELECT username, email, profile_image, phone, address, preferences, created_at FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found");
    }

    // Fetch user's order history with error handling
    try {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$user_id]);
        $recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // If there's an error fetching orders, set to empty array
        $recent_orders = [];
    }
} catch (PDOException $e) {
    die("Error fetching user data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - GlobalGrocers</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }

        .profile-sidebar {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            position: relative;
            overflow: hidden;
            border: 3px solid #4CAF50;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-picture .edit-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            padding: 8px;
            color: white;
            text-align: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .profile-picture:hover .edit-overlay {
            opacity: 1;
        }

        .profile-sidebar h2 {
            text-align: center;
            margin: 0 0 10px;
            color: #333;
        }

        .text-muted {
            color: #666;
            text-align: center;
            display: block;
            margin-bottom: 20px;
        }

        .profile-menu {
            margin-top: 30px;
        }

        .profile-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            color: #333;
            text-decoration: none;
        }

        .profile-menu-item:hover,
        .profile-menu-item.active {
            background: #E8F5E9;
            color: #4CAF50;
        }

        .profile-menu-item i {
            margin-right: 10px;
            width: 20px;
        }

        .profile-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-section {
            display: none;
        }

        .profile-section.active {
            display: block;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group:last-child {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            outline: none;
        }

        .form-group input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        .btn-update, .btn-home, .btn-logout {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 16px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-update {
            background: #4CAF50;
            color: white;
        }

        .btn-home {
            background: #2196F3;
            color: white;
        }

        .btn-logout {
            background: #f44336;
            color: white;
        }

        .btn-update:hover, .btn-home:hover, .btn-logout:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .btn-update:hover {
            background: #388E3C;
        }

        .btn-home:hover {
            background: #1976D2;
        }

        .btn-logout:hover {
            background: #D32F2F;
        }

        .btn-update i, .btn-home i, .btn-logout i {
            margin-right: 8px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: #E8F5E9;
            border-color: #4CAF50;
            color: #388E3C;
        }

        .alert-danger {
            background-color: #FFEBEE;
            border-color: #EF5350;
            color: #D32F2F;
        }

        .alert-info {
            background-color: #E3F2FD;
            border-color: #2196F3;
            color: #1976D2;
        }

        .preferences-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .preference-item {
            background: var(--bg-light);
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .preference-item:hover {
            background: var(--primary-light);
        }

        .preference-item.selected {
            background: var(--primary-color);
            color: white;
        }

        .order-card {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .order-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-item img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--bg-light);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .notification-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-sidebar {
                margin-bottom: 20px;
            }

            .profile-picture {
                width: 120px;
                height: 120px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .profile-actions {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .profile-actions .btn {
            flex: 1;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .btn-secondary {
            background-color: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-danger {
            background-color: #fff;
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn i {
            font-size: 1.1rem;
        }

        /* Make form elements consistent */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }
    </style>
</head>
<body>
    <!-- Include your header here -->
    
    <div class="profile-container">
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <div class="profile-grid">
            <div class="profile-sidebar">
                <div class="profile-picture">
                    <?php if (!empty($user['profile_image'])): ?>
                        <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Picture">
                    <?php else: ?>
                        <img src="images/default-avatar.png" alt="Default Profile Picture">
                    <?php endif; ?>
                    <div class="edit-overlay">
                        <i class="fas fa-camera"></i> Change Photo
                    </div>
                </div>
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <p class="text-muted">Member since <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                
                <div class="profile-menu">
                    <div class="profile-menu-item active" data-section="personal">
                        <i class="fas fa-user"></i> Personal Information
                    </div>
                    <div class="profile-menu-item" data-section="orders">
                        <i class="fas fa-shopping-bag"></i> Order History
                    </div>
                    <div class="profile-menu-item" data-section="preferences">
                        <i class="fas fa-heart"></i> Shopping Preferences
                    </div>
                    <div class="profile-menu-item" data-section="notifications">
                        <i class="fas fa-bell"></i> Notifications
                    </div>
                    <div class="profile-menu-item" data-section="security">
                        <i class="fas fa-shield-alt"></i> Security
                    </div>
                </div>
            </div>

            <div class="profile-content">
                <!-- Personal Information Section -->
                <div class="profile-section active" id="personal">
                    <h3 class="section-title">Personal Information</h3>
                    <form action="profile.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email (readonly)</label>
                            <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Delivery Address</label>
                            <textarea name="address" rows="1"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_image" accept="image/*" style="display: none;">
                        </div>
                        <div class="profile-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Profile
                            </button>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                            <a href="logout.php" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Order History Section -->
                <div class="profile-section" id="orders">
                    <h3 class="section-title">Order History</h3>
                    <div class="stats-grid">
                        <?php
                        // Calculate stats from recent orders
                        $total_orders = count($recent_orders);
                        $total_spent = array_sum(array_column($recent_orders, 'total_amount'));
                        ?>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $total_orders; ?></div>
                            <div class="stat-label">Total Orders</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">₹<?php echo number_format($total_spent, 2); ?></div>
                            <div class="stat-label">Total Spent</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">-</div>
                            <div class="stat-label">Avg. Rating</div>
                        </div>
                    </div>

                    <?php if (empty($recent_orders)): ?>
                        <div class="alert alert-info">
                            <p>You haven't placed any orders yet. Start shopping to see your order history here!</p>
                            <a href="pages/products.php" class="btn btn-primary" style="margin-top: 10px;">Browse Products</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($recent_orders as $order): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <div>
                                    <h4>Order #<?php echo htmlspecialchars($order['order_id']); ?></h4>
                                    <span class="text-muted"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></span>
                                </div>
                                <div class="order-status">
                                    <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                                </div>
                            </div>
                            <div class="order-total">
                                Total: ₹<?php echo number_format($order['total_amount'], 2); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Shopping Preferences Section -->
                <div class="profile-section" id="preferences">
                    <h3 class="section-title">Shopping Preferences</h3>
                    <p>Select your preferred categories and dietary requirements:</p>
                    
                    <form action="profile.php" method="POST">
                        <div class="preferences-grid">
                            <?php
                            $current_preferences = json_decode($user['preferences'] ?? '[]', true) ?: [];
                            $available_preferences = [
                                'organic' => ['icon' => 'leaf', 'label' => 'Organic'],
                                'vegetarian' => ['icon' => 'carrot', 'label' => 'Vegetarian'],
                                'gluten-free' => ['icon' => 'bread-slice', 'label' => 'Gluten-Free'],
                                'dairy-free' => ['icon' => 'cheese', 'label' => 'Dairy-Free'],
                                'local' => ['icon' => 'map-marker-alt', 'label' => 'Local Products'],
                                'international' => ['icon' => 'globe', 'label' => 'International']
                            ];
                            
                            foreach ($available_preferences as $value => $pref):
                                $is_selected = in_array($value, $current_preferences) ? 'selected' : '';
                            ?>
                                <div class="preference-item <?php echo $is_selected; ?>" data-value="<?php echo htmlspecialchars($value); ?>">
                                    <i class="fas fa-<?php echo htmlspecialchars($pref['icon']); ?>"></i>
                                    <?php echo htmlspecialchars($pref['label']); ?>
                                    <input type="checkbox" name="preferences[]" value="<?php echo htmlspecialchars($value); ?>" 
                                           <?php echo $is_selected ? 'checked' : ''; ?> style="display: none;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <button type="submit" class="btn-update">Save Preferences</button>
                        </div>
                    </form>
                </div>

                <!-- Notifications Section -->
                <div class="profile-section" id="notifications">
                    <h3 class="section-title">Notifications</h3>
                    <div class="notification-list">
                        <div class="notification-item">
                            <div class="notification-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="notification-content">
                                <h4>Special Offer!</h4>
                                <p>Get 20% off on your next order</p>
                                <small>2 hours ago</small>
                            </div>
                        </div>
                        <div class="notification-item">
                            <div class="notification-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="notification-content">
                                <h4>Order Delivered</h4>
                                <p>Your order #1234 has been delivered</p>
                                <small>Yesterday</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="profile-section" id="security">
                    <h3 class="section-title">Security Settings</h3>
                    <form action="profile.php" method="POST" class="form-grid">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" placeholder="Enter new password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" placeholder="Confirm new password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-update">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include your footer here -->

    <script>
        // Tab switching functionality
        document.querySelectorAll('.profile-menu-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all menu items and sections
                document.querySelectorAll('.profile-menu-item').forEach(i => i.classList.remove('active'));
                document.querySelectorAll('.profile-section').forEach(s => s.classList.remove('active'));
                
                // Add active class to clicked menu item
                this.classList.add('active');
                
                // Show corresponding section
                const sectionId = this.getAttribute('data-section');
                document.getElementById(sectionId).classList.add('active');
            });
        });

        // Preferences selection
        document.querySelectorAll('.preference-item').forEach(item => {
            item.addEventListener('click', function() {
                this.classList.toggle('selected');
                const checkbox = this.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
            });
        });

        // Profile picture upload preview
        const profileImageInput = document.querySelector('input[name="profile_image"]');
        const profileImage = document.querySelector('.profile-picture img');
        
        if (profileImageInput && profileImage) {
            profileImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileImage.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Profile picture upload trigger
        document.querySelector('.edit-overlay').addEventListener('click', function() {
            document.querySelector('input[name="profile_image"]').click();
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>
