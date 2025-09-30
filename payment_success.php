<?php 
include 'includes/header.php';
include 'backend/db.php';

$transaction_id = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : null;

if ($transaction_id) {
    $result = $conn->query("SELECT * FROM transactions WHERE id = $transaction_id");
    $transaction = $result->fetch_assoc();
    
    // Get transaction items
    $items_query = "
        SELECT ti.*, 
               CASE 
                   WHEN ti.item_type = 'product' THEN p.nama
                   WHEN ti.item_type = 'package' THEN pkg.nama
               END as item_name
        FROM transaction_items ti
        LEFT JOIN products p ON ti.product_id = p.id
        LEFT JOIN packages pkg ON ti.package_id = pkg.id
        WHERE ti.transaction_id = $transaction_id
    ";
    $items = $conn->query($items_query);
}
?>

<main>
    <?php if ($transaction): ?>
        <div class="alert alert-success">
            <h2>Pembayaran Berhasil!</h2>
            <p>Terima kasih atas pesanan Anda. Transaksi ID: <strong><?php echo $transaction['id']; ?></strong></p>
        </div>
        
        <div style="background: #fff; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(139, 90, 60, 0.1); margin: 2rem 0;">
            <h3>Detail Pesanan</h3>
            <p><strong>Nama:</strong> <?php echo $transaction['nama_pembeli']; ?></p>
            <p><strong>Email:</strong> <?php echo $transaction['email']; ?></p>
            <p><strong>Total:</strong> Rp <?php echo number_format($transaction['total_amount'], 0, ',', '.'); ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst($transaction['status']); ?></p>
            
            <h4>Item yang Dipesan:</h4>
            <ul>
                <?php while ($item = $items->fetch_assoc()): ?>
                <li><?php echo $item['item_name']; ?> - <?php echo $item['quantity']; ?>x - Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        
        <div style="background: #f4e4c1; padding: 1.5rem; border-radius: 10px; margin: 2rem 0;">
            <h3>Langkah Selanjutnya:</h3>
            <ol>
                <li>Transfer sesuai jumlah yang tertera ke rekening yang dipilih</li>
                <li>Tunggu konfirmasi dari admin (1-2 jam kerja)</li>
                <li>Setelah dikonfirmasi, Anda dapat memberikan ulasan produk</li>
                <li>Pesanan akan diproses dan siap diambil/dikirim</li>
            </ol>
        </div>
        
        <div class="text-center">
            <a href="index.php" class="btn">Kembali ke Beranda</a>
            <a href="products.php" class="btn-secondary">Belanja Lagi</a>
        </div>
        
    <?php else: ?>
        <div class="alert alert-error">
            <p>Transaksi tidak ditemukan.</p>
        </div>
        <a href="index.php" class="btn">Kembali ke Beranda</a>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
