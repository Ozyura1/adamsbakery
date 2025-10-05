<?php
require 'db.php';

$message = '';
$redirect = false;
$styleColor = '#4CAF50'; // default hijau (sukses)

if (isset($_GET['token'])) {
    $token = $conn->real_escape_string($_GET['token']);

    $sql = "SELECT * FROM customer_users WHERE token='$token' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $update = "UPDATE customer_users 
                   SET is_verified=1, token=NULL 
                   WHERE id=" . $user['id'];

        if ($conn->query($update) === TRUE) {
            $message = "
                <h2 style='color:$styleColor;'>✅ Verifikasi Berhasil!</h2>
                <p>Akun Anda telah aktif. Anda akan diarahkan ke halaman login dalam <b>3 detik</b>.</p>
                <a href='../login.php?verified=1' style='
                    display:inline-block;
                    margin-top:10px;
                    padding:10px 20px;
                    background:$styleColor;
                    color:white;
                    text-decoration:none;
                    border-radius:8px;
                    font-weight:bold;
                '>Login Sekarang</a>
            ";
            $redirect = true;
        } else {
            $styleColor = '#f44336'; // merah
            $message = "<h2 style='color:$styleColor;'>❌ Terjadi Kesalahan!</h2>
                        <p>Terjadi error pada server: <b>" . htmlspecialchars($conn->error) . "</b></p>";
        }
    } else {
        $styleColor = '#FF9800'; // oranye
        $message = "<h2 style='color:$styleColor;'>⚠️ Token Tidak Valid</h2>
                    <p>Link verifikasi sudah dipakai atau tidak ditemukan.</p>
                    <a href='../register.php' style='
                        display:inline-block;
                        margin-top:10px;
                        padding:10px 20px;
                        background:$styleColor;
                        color:white;
                        text-decoration:none;
                        border-radius:8px;
                        font-weight:bold;
                    '>Daftar Lagi</a>";
    }
} else {
    $styleColor = '#FF9800';
    $message = "<h2 style='color:$styleColor;'>⚠️ Token Tidak Ditemukan</h2>
                <p>Pastikan Anda membuka link verifikasi dari email.</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Akun</title>
    <?php if ($redirect): ?>
        <meta http-equiv="refresh" content="3;url=../login.php?verified=1">
    <?php endif; ?>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f5f5;">
    <div style="
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        border: 2px solid <?= $styleColor ?>;
        background: #fff;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    ">
        <?= $message ?>
    </div>
</body>
</html>
