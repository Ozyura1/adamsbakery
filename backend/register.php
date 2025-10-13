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

    // hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // generate OTP 6 digit
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $otp_expires = date("Y-m-d H:i:s", strtotime("+5 minutes"));

    // simpan data user ke database
    $stmt = $conn->prepare("INSERT INTO customer_users (nama_lengkap, email, password, is_verified, otp_code, otp_expires_at) VALUES (?, ?, ?, 0, ?, ?)");
    $stmt->bind_param("sssss", $nama, $email, $hashed_password, $otp, $otp_expires);

    if ($stmt->execute()) {
        // kirim email OTP
        if (sendVerificationEmail($email, $otp)) {
            echo '<div class="alert alert-success">✅ Registrasi berhasil. Kode OTP telah dikirim ke email Anda.</div>';
            echo '<a href="verify.php">Klik di sini untuk verifikasi akun</a>';
        } else {
            echo '<div class="alert alert-warning">⚠️ Registrasi berhasil, tapi gagal mengirim email OTP.</div>';
        }
    } else {
        echo '<div class="alert alert-error">❌ Error: ' . htmlspecialchars($stmt->error) . '</div>';
    }
}

$conn->close();
?>

</body>
</html>
