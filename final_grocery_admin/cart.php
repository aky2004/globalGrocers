<?php
session_start();
include 'db_connection.php';

// Function to add item to cart
function addToCart($userId, $productId, $quantity = 1) {
    global $conn;
    
    try {
        // Verify product exists and get price
        $stmt = $conn->prepare("SELECT id, price FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }
        
        // Check if item already exists in cart
        $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem['quantity'] + $quantity;
            $stmt = $conn->prepare("UPDATE cart SET quantity = ?, price = ?, added_at = NOW() WHERE id = ?");
            $stmt->execute([$newQuantity, $product['price'] * $newQuantity, $cartItem['id']]);
        } else {
            // Add new item to cart
            $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, price, added_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$userId, $productId, $quantity, $product['price'] * $quantity]);
        }
        
        return ['success' => true, 'message' => 'Product added to cart'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error adding to cart: ' . $e->getMessage()];
    }
}

// Function to get cart items
function getCartItems($userId) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("
            SELECT c.id, c.product_id, c.quantity, c.price, p.name, p.imageUrl
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $row;
        }
        return $items;
    } catch (PDOException $e) {
        return [];
    }
}

// Function to update cart item quantity
function updateCartQuantity($cartId, $quantity) {
    global $conn;
    
    try {
        if ($quantity < 1) {
            return ['success' => false, 'message' => 'Invalid quantity'];
        }
        
        $stmt = $conn->prepare("
            SELECT p.price
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.id = ?
        ");
        $stmt->execute([$cartId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            return ['success' => false, 'message' => 'Cart item not found'];
        }
        
        $stmt = $conn->prepare("UPDATE cart SET quantity = ?, price = ? WHERE id = ?");
        $stmt->execute([$quantity, $product['price'] * $quantity, $cartId]);
        
        return ['success' => true, 'message' => 'Cart updated'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error updating cart: ' . $e->getMessage()];
    }
}

// Function to remove item from cart
function removeFromCart($cartId) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->execute([$cartId]);
        return ['success' => true, 'message' => 'Item removed from cart'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error removing item: ' . $e->getMessage()];
    }
}

// Function to clear cart
function clearCart($userId) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
        return ['success' => true, 'message' => 'Cart cleared'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error clearing cart: ' . $e->getMessage()];
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }
    
    $userId = $_SESSION['user_id'];
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add':
            $productId = $_POST['product_id'] ?? '';
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            echo json_encode(addToCart($userId, $productId, $quantity));
            break;
            
        case 'update':
            $cartId = $_POST['cart_id'] ?? '';
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            echo json_encode(updateCartQuantity($cartId, $quantity));
            break;
            
        case 'remove':
            $cartId = $_POST['cart_id'] ?? '';
            echo json_encode(removeFromCart($cartId));
            break;
            
        case 'clear':
            echo json_encode(clearCart($userId));
            break;
            
        case 'get':
            echo json_encode(['success' => true, 'items' => getCartItems($userId)]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    exit;
}
?>