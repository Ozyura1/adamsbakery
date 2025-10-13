<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_type = $_POST['item_type'];
    $item_id = $_POST['item_id'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    
    // Initialize cart if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $cart_key = $item_type . '_' . $item_id;
    
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'type' => $item_type,
            'id' => $item_id,
            'quantity' => $quantity
        ];
    }
    
// Redirect back to previous page
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'products.php';

// Tambahkan parameter added=1 dengan benar
if (strpos($redirect, '?') !== false) {
    $redirect .= '&added=1';
} else {
    $redirect .= '?added=1';
}

header("Location: $redirect");
exit(); 
}
?>
