<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $pesan = $conn->real_escape_string($_POST['pesan']);
    
    $jenis_kontak = isset($_POST['jenis_kontak']) ? $conn->real_escape_string($_POST['jenis_kontak']) : 'ulasan';
    
    $custom_order_details = null;
    $budget_range = null;
    $event_date = null;
    $jumlah_porsi = null;
    
    if ($jenis_kontak == 'custom_order') {
        $custom_order_details = isset($_POST['custom_order_details']) ? $conn->real_escape_string($_POST['custom_order_details']) : null;
        $budget_range = isset($_POST['budget_range']) ? $conn->real_escape_string($_POST['budget_range']) : null;
        $event_date = isset($_POST['event_date']) && !empty($_POST['event_date']) ? $conn->real_escape_string($_POST['event_date']) : null;
        $jumlah_porsi = isset($_POST['jumlah_porsi']) && !empty($_POST['jumlah_porsi']) ? intval($_POST['jumlah_porsi']) : null;
    }

    $sql = "INSERT INTO kontak (nama, email, pesan, jenis_kontak, custom_order_details, budget_range, event_date, jumlah_porsi) 
            VALUES ('$nama', '$email', '$pesan', '$jenis_kontak', " . 
            ($custom_order_details ? "'$custom_order_details'" : "NULL") . ", " .
            ($budget_range ? "'$budget_range'" : "NULL") . ", " .
            ($event_date ? "'$event_date'" : "NULL") . ", " .
            ($jumlah_porsi ? "$jumlah_porsi" : "NULL") . ")";

    if ($conn->query($sql) === TRUE) {
        switch ($jenis_kontak) {
            case 'custom_order':
                echo "<div style='max-width: 600px; margin: 2rem auto; padding: 2rem; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px;'>";
                echo "<h3 style='color: #155724; margin-top: 0;'>Permintaan Pesanan Kustom Diterima!</h3>";
                echo "<p style='color: #155724;'>Terima kasih <strong>$nama</strong>, permintaan pesanan kustom Anda sudah kami terima!</p>";
                echo "<p style='color: #155724;'>Tim kami akan menghubungi Anda dalam 1-2 hari kerja untuk membahas detail dan memberikan penawaran harga.</p>";
                if ($event_date) {
                    echo "<p style='color: #155724;'><strong>Tanggal acara:</strong> " . date('d M Y', strtotime($event_date)) . "</p>";
                }
                echo "<a href='../contact.php' style='display: inline-block; margin-top: 1rem; padding: 0.5rem 1rem; background: #8B4513; color: white; text-decoration: none; border-radius: 4px;'>Kembali</a>";
                echo "</div>";
                break;
            case 'pertanyaan':
                echo "<div style='max-width: 600px; margin: 2rem auto; padding: 2rem; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 8px;'>";
                echo "<h3 style='color: #0c5460; margin-top: 0;'>Pertanyaan Diterima!</h3>";
                echo "<p style='color: #0c5460;'>Terima kasih <strong>$nama</strong>, pertanyaan Anda sudah kami terima dan akan dijawab segera!</p>";
                echo "<a href='../contact.php' style='display: inline-block; margin-top: 1rem; padding: 0.5rem 1rem; background: #8B4513; color: white; text-decoration: none; border-radius: 4px;'>Kembali</a>";
                echo "</div>";
                break;
            default: // ulasan
                echo "<div style='max-width: 600px; margin: 2rem auto; padding: 2rem; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px;'>";
                echo "<h3 style='color: #856404; margin-top: 0;'>Ulasan Diterima!</h3>";
                echo "<p style='color: #856404;'>Terima kasih <strong>$nama</strong>, ulasan Anda sangat berharga bagi kami!</p>";
                echo "<a href='../contact.php' style='display: inline-block; margin-top: 1rem; padding: 0.5rem 1rem; background: #8B4513; color: white; text-decoration: none; border-radius: 4px;'>Kembali</a>";
                echo "</div>";
                break;
        }
    } else {
        echo "<div style='max-width: 600px; margin: 2rem auto; padding: 2rem; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px;'>";
        echo "<h3 style='color: #721c24; margin-top: 0;'>Terjadi Kesalahan</h3>";
        echo "<p style='color: #721c24;'>Maaf, terjadi kesalahan: " . $conn->error . "</p>";
        echo "<a href='../contact.php' style='display: inline-block; margin-top: 1rem; padding: 0.5rem 1rem; background: #8B4513; color: white; text-decoration: none; border-radius: 4px;'>Coba Lagi</a>";
        echo "</div>";
    }
}
?>
