<?php
$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "adamsbakery";
$pass = getenv('DB_PASS') ?: "Adamsbakery123!";  
$db   = getenv('DB_NAME') ?: "adamsbakery";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Database connection error. Please try again later.");
}
?>
