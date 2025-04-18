<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    try {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $success = "Product deleted successfully.";
    } catch (PDOException $e) {
        $error = "Error deleting product: " . $e->getMessage();
    }
}

// Fetch all products
try {
    $stmt = $conn->prepare("SELECT id, name, price, image, category_id, created_at FROM products ORDER BY created_at DESC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching products: " . $e->getMessage();
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products | GlobalGrocers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
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
                    <li><a href="admin_products.php" class="active"><i class="fas fa-box"></i> Products</a></li>
                    <li><a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                    <li><a href="admin_categories.php"><i class="fas fa-tags"></i> Categories</a></li>
                    <li><a href="admin_logs.php"><i class="fas fa-history"></i> Logs</a></li>
                    <li><a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <h1>Manage Products</h1>
                <div class="user-profile">
                    <span><?= htmlspecialchars($_SESSION['admin_username']) ?></span>
                    <i class="fas fa-user-circle"></i>
                </div>
            </header>

            <!-- Messages -->
            <?php if (isset($success)): ?>
                <div class="alert success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Products Table -->
            <section class="table-section">
                <div class="table-header">
                    <h2>Products (<?= count($products) ?>)</h2>
                    <a href="admin_add_product.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7">No products found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['id']) ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td>$<?= number_format($product['price'], 2) ?></td>
                                    <td>
                                        <?php if ($product['image']): ?>
                                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product" class="profile-img">
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($product['category']) ?></td>
                                    <td><?= date('Y-m-d H:i:s', strtotime($product['created_at'])) ?></td>
                                    <td>
                                        <a href="admin_edit_product.php?id=<?= $product['id'] ?>" class="btn btn-small btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="?delete=<?= $product['id'] ?>" class="btn btn-small btn-delete" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script src="js/admin_product.js"></script>
</body>
</html>
