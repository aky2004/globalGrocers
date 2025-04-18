<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch logs
try {
    $stmt = $conn->prepare("
        SELECT admin_logs.*, admins.username 
        FROM admin_logs 
        JOIN admins ON admin_logs.user_id = admins.id 
        ORDER BY admin_logs.created_at DESC
    ");
    $stmt->execute();
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching logs: " . $e->getMessage();
    $logs = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Logs | GlobalGrocers</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
        <h2><a href="admin.php">GlobalGrocers Admin</a></h2>
        </div>
        <nav>
            <ul>
                <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin_users.php"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="admin_products.php"><i class="fas fa-box"></i> Products</a></li>
                <li><a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="admin_categories.php"><i class="fas fa-tags"></i> Categories</a></li>
                <li><a href="admin_logs.php" class="active"><i class="fas fa-history"></i> Logs</a></li>
                <li><a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Admin Logs</h1>
            <div class="user-profile">
                <span><?= htmlspecialchars($_SESSION['admin_username']) ?></span>
                <i class="fas fa-user-circle"></i>
            </div>
        </header>

        <?php if (isset($error)): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Logs Table -->
        <section class="table-section">
            <div class="table-header">
                <h2>Log History (<?= count($logs) ?> entries)</h2>
            </div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Admin Username</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($logs)): ?>
                    <tr><td colspan="4">No logs available.</td></tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['id']) ?></td>
                            <td><?= htmlspecialchars($log['username']) ?></td>
                            <td><?= htmlspecialchars($log['action']) ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($log['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>

<script src="js/admin_logs.js"></script>
</body>
</html>
