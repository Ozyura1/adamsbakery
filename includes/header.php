<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Adam Bakery - Roti Segar & Kue Berkualitas</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        header {
            text-align: center;
            padding: 1rem;
        }
        .logo-container {
            display: flex;
            align-items: center;    
            justify-content: center;
            gap: 10px; /* jarak antara logo dan teks */
        }
        .logo-container img {
            width: 50px; /* ukuran logo */
            height: auto;
        }
        nav {
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
<header>
    <div class="logo-container">
        <img src="assets/logoadambakery.png" alt="Logo Adam Bakery" style="width:100px; height:auto;">
        <h1>Adam Bakery</h1>
    </div>
    <p style="text-align: center; color: #8b5a3c; font-style: italic; margin: 0.5rem 0;">
        "Kelezatan Tradisional dengan Sentuhan Modern"
    </p>
    <nav>
        <a href="index.php">Beranda</a> |
        <a href="products.php">Produk</a> |
        <a href="packages.php">Paket Spesial</a> |
        <a href="view_reviews.php">Ulasan</a> |
        <a href="contact.php">Kontak</a> |
        <a href="checkout.php">Keranjang</a> |
        <a href="check_review_status.php">Cek Ulasan</a>
    </nav>
</header>
<hr>
