<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle category deletion
if (isset($_GET['delete'])) {
    $category_id = intval($_GET['delete']);
    try {
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$category_id]);
        $success = "Category deleted successfully.";
    } catch (PDOException $e) {
        $error = "Error deleting category: " . $e->getMessage();
    }
}

// Fetch all categories
try {
    $stmt = $conn->prepare("SELECT * FROM categories ORDER BY created_at DESC");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching categories: " . $e->getMessage();
    $categories = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Categories | GlobalGrocers</title>
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
                    <li><a href="admin_categories.php" class="active"><i class="fas fa-tags"></i> Categories</a></li>
                    <li><a href="admin_logs.php"><i class="fas fa-history"></i> Logs</a></li>
                    <li><a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <h1>Manage Categories</h1>
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

            <!-- Categories Table -->
            <section class="table-section">
                <div class="table-header">
                    <h2>Categories (<?= count($categories) ?>)</h2>
                    <a href="admin_add_category.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category ID</th>
                            <th>Name</th>
                            <th>Icon</th>
                            <th>Description</th>
                            <th>Background</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr><td colspan="8">No categories found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cat['id']) ?></td>
                                    <td><?= htmlspecialchars($cat['category_id']) ?></td>
                                    <td><?= htmlspecialchars($cat['name']) ?></td>
                                    <td><i class="<?= htmlspecialchars($cat['icon']) ?>"></i></td>
                                    <td><?= htmlspecialchars($cat['description']) ?></td>
                                    <td><span style="background:<?= htmlspecialchars($cat['bg_color']) ?>;padding:5px 10px;border-radius:5px;color:white;"><?= htmlspecialchars($cat['bg_color']) ?></span></td>
                                    <td><?= date('Y-m-d', strtotime($cat['created_at'])) ?></td>
                                    <td>
                                        <a href="admin_edit_category.php?id=<?= $cat['id'] ?>" class="btn btn-small btn-edit"><i class="fas fa-edit"></i></a>
                                        <a href="?delete=<?= $cat['id'] ?>" class="btn btn-small btn-delete" onclick="return confirm('Are you sure to delete this category?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script src="js/admin_categories.js"></script>
</body>
</html>
