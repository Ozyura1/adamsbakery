<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// load composer autoload
require __DIR__ . '/../vendor/autoload.php';  

function sendVerificationEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi server Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '2311102118@ittelkom-pwt.ac.id'; // ganti dengan email kamu
        $mail->Password   = 'icvutmgvxivfwnbn';       // ganti dengan sandi aplikasi Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Pengirim
        $mail->setFrom('2311102118@ittelkom-pwt.ac.id', 'Adam Bakery');
        // Penerima
        $mail->addAddress($email);

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Akun Anda';
        
        // link ke verify.php
        $verifyLink = "http://localhost/adambakrybaru1/backend/verify.php?token=" . $token;

        $mail->Body = "
            <h2>Verifikasi Akun Anda</h2>
            <p>Terima kasih sudah mendaftar. Klik link berikut untuk mengaktifkan akun Anda:</p>
            <a href='$verifyLink'>$verifyLink</a>
        ";

        $mail->send();
        // sukses
        return true;
    } catch (Exception $e) {
        echo "Email tidak dapat dikirim. Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>
