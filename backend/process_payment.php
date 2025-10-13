<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pembeli = $conn->real_escape_string($_POST['nama_pembeli']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $total_amount = $conn->real_escape_string($_POST['total_amount']);
    $account_name = $conn->real_escape_string($_POST['account_name']);
    $account_number = $conn->real_escape_string($_POST['account_number']);
    $bank_name = $conn->real_escape_string($_POST['bank_name']);
    $transfer_amount = $conn->real_escape_string($_POST['transfer_amount']);
    $customer_id = isset($_POST['customer_id']) ? $conn->real_escape_string($_POST['customer_id']) : null;
    
    // Handle file upload (simplified for demo)
    $transfer_proof = null;
    if (isset($_FILES['transfer_proof']) && $_FILES['transfer_proof']['error'] == 0) {
        $transfer_proof = 'bukti_' . time() . '_' . $_FILES['transfer_proof']['name'];
        // In production, move uploaded file to proper directory
        // move_uploaded_file($_FILES['transfer_proof']['tmp_name'], '../uploads/' . $transfer_proof);
    }
    
    $sql = "INSERT INTO transactions (customer_id, nama_pembeli, email, phone, alamat, total_amount, bank_name, account_name, account_number, transfer_amount, transfer_proof, status) 
            VALUES ('$customer_id', '$nama_pembeli', '$email', '$phone', '$alamat', '$total_amount', '$bank_name', '$account_name', '$account_number', '$transfer_amount', '$transfer_proof', 'pending')";
    
    if ($conn->query($sql)) {
        $transaction_id = $conn->insert_id;
        
        // Insert transaction items
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                $item_type = $item['type'];
                $item_id = $item['id'];
                $quantity = $item['quantity'];
                
                // Get item price
                if ($item_type == 'product') {
                    $result = $conn->query("SELECT harga FROM products WHERE id = $item_id");
                    $price = $result->fetch_assoc()['harga'];
                    $sql_item = "INSERT INTO transaction_items (transaction_id, product_id, item_type, quantity, price) 
                                VALUES ('$transaction_id', '$item_id', 'product', '$quantity', '$price')";
                } else {
                    $result = $conn->query("SELECT harga FROM packages WHERE id = $item_id");
                    $price = $result->fetch_assoc()['harga'];
                    $sql_item = "INSERT INTO transaction_items (transaction_id, package_id, item_type, quantity, price) 
                                VALUES ('$transaction_id', '$item_id', 'package', '$quantity', '$price')";
                }
                
                $conn->query($sql_item);
            }
        }
        
        // Clear cart
        $_SESSION['cart'] = [];
        
        // Redirect to success page
        header("Location: ../payment_success.php?transaction_id=" . $transaction_id);
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: ../checkout.php");
    exit();
}
?>
