<?php
$host = "192.168.122.115";      
$user = "adamsbakery";           
$pass = "Adamsbakery123!";               
$db   = "adamsbakery";    

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Optional: set charset UTF-8 biar aman untuk teks multibahasa
$conn->set_charset("utf8mb4");
?>
