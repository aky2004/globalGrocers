<?php
session_start();
include 'db_connection.php';

// Check if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: admin.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                
                // Log admin login activity
                $log_stmt = $conn->prepare("INSERT INTO admin_logs (user_id, action, created_at) VALUES (?, ?, NOW())");
                $log_stmt->execute([$admin['id'], "Admin logged in"]);
                
                header("Location: admin.php");
                exit();
            } else {
                $error = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobalGrocers - Admin Login</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--background-light);
            padding: 20px;
        }

        .login-card {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 400px;
        }

        .login-card h2 {
            text-align: center;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(var(--primary-color), 0.1);
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .login-button:hover {
            background: var(--primary-dark);
        }

        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo h1 {
            font-size: 2rem;
            color: var(--primary-color);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
            }

            .login-card h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <h1>GlobalGrocers Admin</h1>
            </div>
            <h2>Admin Login</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" 
                        required
                    >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                    >
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </div>
</body>
</html>