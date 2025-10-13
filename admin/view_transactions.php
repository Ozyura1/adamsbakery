<?php
session_start();
include '../backend/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle status updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $transaction_id = $conn->real_escape_string($_POST['transaction_id']);
    $new_status = $conn->real_escape_string($_POST['status']);
    
    $sql = "UPDATE transactions SET status = '$new_status' WHERE id = '$transaction_id'";
    if ($conn->query($sql)) {
        $success = "Status transaksi berhasil diupdate!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Get all transactions
$transactions = $conn->query("SELECT * FROM transactions ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Transaksi - Admin Adam Bakery</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="admin-header">
    <h1>Daftar Transaksi - Adam Bakery</h1>
    <nav class="admin-nav">
        <a href="dashboard.php">Dashboard</a> |
        <a href="manage_products.php">Kelola Produk</a> |
        <a href="manage_packages.php">Kelola Paket</a> |
        <a href="view_transactions.php">Transaksi</a> |
        <a href="admin_promos.php">Promo</a> |
        <a href="view_reviews.php">Ulasan</a> |
        <a href="view_custom_orders.php">Pesanan Kustom</a> |
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <h2>Daftar Transaksi</h2>
    <table>
        
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pembeli</th>
                <th>Email</th>
                <th>Total</th>
                <th>Bank</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($transaction = $transactions->fetch_assoc()): ?>
            <tr>
                <td><?php echo $transaction['id']; ?></td>
                <td><?php echo $transaction['nama_pembeli']; ?></td>
                <td><?php echo $transaction['email']; ?></td>
                <td>Rp <?php echo number_format($transaction['total_amount'], 0, ',', '.'); ?></td>
                <td><?php echo $transaction['bank_name']; ?></td>
                <td><?php echo ucfirst($transaction['status']); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($transaction['created_at'])); ?></td>
                <td>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="transaction_id" value="<?php echo $transaction['id']; ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" <?php echo $transaction['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="confirmed" <?php echo $transaction['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="cancelled" <?php echo $transaction['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                        <input type="hidden" name="update_status" value="1">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <form action="export_excel.php" method="post" style="text-align:center; margin-top:20px;">
    <button type="submit" class="btn-export">Ekspor Laporan Penjualan</button>
</form>

</main>

<?php include '../includes/footer.php'; ?>
