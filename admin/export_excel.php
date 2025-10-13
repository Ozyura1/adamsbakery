<?php
include '../backend/db.php';

// Ambil semua transaksi
$result = $conn->query("SELECT * FROM transactions ORDER BY created_at DESC");

// Header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
<th>ID</th>
<th>Nama Pembeli</th>
<th>Email</th>
<th>Total</th>
<th>Bank</th>
<th>Status</th>
<th>Tanggal</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['nama_pembeli']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>Rp " . number_format($row['total_amount'], 0, ',', '.') . "</td>";
    echo "<td>{$row['bank_name']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
