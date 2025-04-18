<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle status update
if (isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = $_POST['status'];

    try {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$newStatus, $orderId]);
        $success = "Order status updated successfully.";
    } catch (PDOException $e) {
        $error = "Error updating order: " . $e->getMessage();
    }
}

// Fetch all orders with user info
try {
    $stmt = $conn->prepare("
        SELECT o.*, u.username, u.email 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        ORDER BY o.created_at DESC
    ");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching orders: " . $e->getMessage();
    $orders = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Orders | GlobalGrocers</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="admin-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2><a href="admin.php">GlobalGrocers Admin</a></h2>
        </div>
        <nav>
            <ul>
                <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin_users.php"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="admin_products.php"><i class="fas fa-box"></i> Products</a></li>
                <li><a href="admin_order.php" class="active"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="admin_categories.php"><i class="fas fa-tags"></i> Categories</a></li>
                <li><a href="admin_logs.php"><i class="fas fa-history"></i> Logs</a></li>
                <li><a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Manage Orders</h1>
            <div class="user-profile">
                <span><?= htmlspecialchars($_SESSION['admin_username']) ?></span>
                <i class="fas fa-user-circle"></i>
            </div>
        </header>

        <?php if (isset($success)): ?>
            <div class="alert success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <section class="table-section">
            <div class="table-header">
                <h2>Orders (<?= count($orders) ?>)</h2>
            </div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Shipping Address</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="10">No orders found.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($order['username']) ?></td>
                            <td><?= htmlspecialchars($order['email']) ?></td>
                            <td>$<?= $order['total_amount'] ?></td>
                            <td><span class="status-label <?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span></td>
                            <td><?= str_replace('_', ' ', ucfirst($order['payment_method'])) ?></td>
                            <td><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></td>
                            <td><?= $order['created_at'] ?></td>
                            <td><?= $order['updated_at'] ?></td>
                            <td>
                                <form method="post" class="status-form">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <select name="status" class="status-dropdown">
                                        <?php foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status): ?>
                                            <option value="<?= $status ?>" <?= $order['status'] === $status ? 'selected' : '' ?>>
                                                <?= ucfirst($status) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-small btn-edit">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>

<script src="js/admin_orders.js"></script>
</body>
</html>
