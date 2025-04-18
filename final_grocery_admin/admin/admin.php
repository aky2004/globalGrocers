<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch dashboard statistics
try {
    // Total Users
    $stmt = $conn->prepare("SELECT COUNT(*) as total_users FROM users");
    $stmt->execute();
    $total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

    // Total Orders
    $stmt = $conn->prepare("SELECT COUNT(*) as total_orders FROM orders");
    $stmt->execute();
    $total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

    // Total Products
    $stmt = $conn->prepare("SELECT COUNT(*) as total_products FROM products");
    $stmt->execute();
    $total_products = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'];

    // Total Categories
    $stmt = $conn->prepare("SELECT COUNT(*) as total_categories FROM categories");
    $stmt->execute();
    $total_categories = $stmt->fetch(PDO::FETCH_ASSOC)['total_categories'];

    // Recent Activities (last 5)
    $stmt = $conn->prepare("
        SELECT al.*, u.username 
        FROM admin_logs al 
        LEFT JOIN users u ON al.user_id = u.id 
        ORDER BY al.created_at DESC 
        LIMIT 5
    ");
    $stmt->execute();
    $recent_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobalGrocers - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>GlobalGrocers Admin</h1>
            </div>
            <div class="header-actions">
                <div class="user-info profile-container">
                    <span class="username"><?= htmlspecialchars($_SESSION['admin_username']) ?></span>
                    <div class="user-dropdown">
                        <a href="admin_logout.php" class="logout-btn">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <div class="sidebar">
            <h3>Admin Menu</h3>
            <ul>
                <li><a href="admin.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin_users.php"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="admin_products.php"><i class="fas fa-box"></i> Products</a></li>
                <li><a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="admin_categories.php"><i class="fas fa-tags"></i> Categories</a></li>
                <li><a href="admin_logs.php" ><i class="fas fa-history"></i> Logs</a></li>
                <li><a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <?php if (isset($error)): ?>
                <div class="error" style="color: red; margin-bottom: 20px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <h2>Dashboard</h2>
            <div class="dashboard-stats">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3><?= number_format($total_users) ?></h3>
                    <p>Total Users</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-shopping-cart"></i>
                    <h3><?= number_format($total_orders) ?></h3>
                    <p>Total Orders</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-box"></i>
                    <h3><?= number_format($total_products) ?></h3>
                    <p>Total Products</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-tags"></i>
                    <h3><?= number_format($total_categories) ?></h3>
                    <p>Total Categories</p>
                </div>
            </div>

            <div class="recent-activities">
                <h3>Recent Activities</h3>
                <?php if (empty($recent_activities)): ?>
                    <p>No recent activities.</p>
                <?php else: ?>
                    <?php foreach ($recent_activities as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-details">
                                <p>
                                    <strong><?= htmlspecialchars($activity['username'] ?? 'System') ?></strong>
                                    <?= htmlspecialchars($activity['action']) ?>
                                </p>
                                <small><?= date('M d, Y H:i', strtotime($activity['created_at'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2025 GlobalGrocers. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>