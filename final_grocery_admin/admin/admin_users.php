<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $success = "User deleted successfully.";
    } catch (PDOException $e) {
        $error = "Error deleting user: " . $e->getMessage();
    }
}

// Fetch all users
try {
    $stmt = $conn->prepare("SELECT id, username, email, created_at, profile_image FROM users ORDER BY created_at DESC");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching users: " . $e->getMessage();
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users | GlobalGrocers</title>
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
                    <li><a href="admin_users.php" class="active"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="admin_products.php"><i class="fas fa-box"></i> Products</a></li>
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
                <h1>Manage Users</h1>
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

            <!-- Users Table -->
            <section class="table-section">
                <div class="table-header">
                    <h2>Users (<?= count($users) ?>)</h2>
                    <a href="admin_add_user.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add User</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Profile Image</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6">No users found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <?php if ($user['profile_image']): ?>
                                            <img src="<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile" class="profile-img">
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('Y-m-d H:i:s', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <a href="admin_edit_user.php?id=<?= $user['id'] ?>" class="btn btn-small btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="?delete=<?= $user['id'] ?>" class="btn btn-small btn-delete" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script src="js/admin.js"></script>
</body>
</html>