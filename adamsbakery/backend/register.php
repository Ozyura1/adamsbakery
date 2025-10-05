<?php
require 'db.php';
require 'mailer.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi</title>
  <link rel="stylesheet" href="../style.css"> <!-- pastikan ini mengarah ke file css kamu -->
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        echo '<div class="alert alert-error">❌ Password dan konfirmasi password tidak sama.</div>';
        exit;
    }

    // cek email sudah ada belum
    $check = $conn->prepare("SELECT id FROM customer_users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo '<div class="alert alert-error">❌ Email sudah terdaftar.</div>';
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(16));

    $stmt = $conn->prepare("INSERT INTO customer_users (nama_lengkap, email, password, is_verified, token) VALUES (?, ?, ?, 0, ?)");
    $stmt->bind_param("ssss", $nama, $email, $hashed_password, $token);

    if ($stmt->execute()) {
        if (sendVerificationEmail($email, $token)) {
            echo '<div class="alert alert-success">✅ Registrasi berhasil. Silakan cek email untuk verifikasi akun.</div>';
        } else {
            echo '<div class="alert alert-warning">⚠️ Gagal mengirim email verifikasi.</div>';
        }
    } else {
        echo '<div class="alert alert-error">❌ Error: ' . htmlspecialchars($stmt->error) . '</div>';
    }
}

$conn->close();
?>

</body>
</html>
