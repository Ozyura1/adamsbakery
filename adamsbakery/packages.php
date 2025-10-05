<?php 
include 'includes/header.php';
include 'backend/db.php';

session_start();

// Get all packages
$packages = $conn->query("SELECT * FROM packages ORDER BY nama");

// Get reviews count and average rating for each package
function getPackageReviews($conn, $package_id) {
    $result = $conn->query("SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews WHERE package_id = $package_id");
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return ['avg_rating' => 0, 'total' => 0];
}
?>

<main>
    <?php if (isset($_GET['added'])): ?>
        <div class="alert alert-success">Paket berhasil ditambahkan ke keranjang!</div>
    <?php endif; ?>
    
    <h2>Paket Spesial Adam Bakery</h2>
    <p style="text-align: center; margin-bottom: 3rem;">
        Nikmati paket hemat dengan kombinasi produk terbaik kami!
    </p>
    
    <!-- Packages Grid -->
    <div class="product-grid">
        <?php while ($package = $packages->fetch_assoc()): ?>
            <?php $reviews = getPackageReviews($conn, $package['id']); ?>
            <div class="package-card">
                <?php if (!empty($package['image'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($package['image']); ?>" 
                    alt="<?php echo htmlspecialchars($package['nama']); ?>" 
                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 1rem;">
            <?php else: ?>
                <img src="images/noimage.png" 
                    alt="Tidak ada gambar" 
                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 1rem;">
            <?php endif; ?>

                
                <h4><?php echo $package['nama']; ?></h4>
                
                <p style="color: #6b5b47; font-size: 0.9rem; margin-bottom: 1rem;">
                    <?php echo $package['deskripsi']; ?>
                </p>
                
                <div class="price">Rp <?php echo number_format($package['harga'], 0, ',', '.'); ?></div>
                
                <!-- Reviews Summary -->
                <?php if ($reviews['total'] > 0): ?>
                    <div style="margin: 0.5rem 0;">
                        <div class="rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="<?php echo $i <= round($reviews['avg_rating']) ? '' : 'empty'; ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <small style="color: #8b5a3c;">
                            <?php echo round($reviews['avg_rating'], 1); ?>/5 (<?php echo $reviews['total']; ?> ulasan)
                        </small>
                    </div>
                <?php else: ?>
                    <div style="margin: 0.5rem 0;">
                        <small style="color: #8b5a3c;">Belum ada ulasan</small>
                    </div>
                <?php endif; ?>
                
                <!-- Add to Cart Form -->
                <form method="post" action="add_to_cart.php" style="margin-top: 1rem;">
                    <input type="hidden" name="item_type" value="package">
                    <input type="hidden" name="item_id" value="<?php echo $package['id']; ?>">
                    <input type="hidden" name="redirect" value="packages.php?added=1">
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <label style="margin: 0;">Jumlah:</label>
                        <input type="number" name="quantity" value="1" min="1" max="5" 
                               style="width: 60px; padding: 0.3rem; margin: 0;">
                    </div>
                    
                    <button type="submit" style="width: 100%;">Tambah ke Keranjang</button>
                </form>
                
                <!-- View Reviews Link -->
                <?php if ($reviews['total'] > 0): ?>
                    <a href="view_reviews.php?type=package&id=<?php echo $package['id']; ?>" 
                       class="btn-secondary" style="width: 100%; margin-top: 0.5rem; text-align: center;">
                        Lihat Ulasan
                    </a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    
    <?php if ($packages->num_rows == 0): ?>
        <div style="text-align: center; padding: 3rem;">
            <p>Belum ada paket tersedia.</p>
            <a href="products.php" class="btn">Lihat Produk Individual</a>
        </div>
    <?php endif; ?>
    
    <!-- Cart Summary -->
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div style="position: fixed; bottom: 20px; right: 20px; background: #d4af8c; color: white; padding: 1rem; border-radius: 50px; box-shadow: 0 4px 12px rgba(139, 90, 60, 0.3);">
            <a href="checkout.php" style="color: white; text-decoration: none; font-weight: bold;">
                🛒 Keranjang (<?php echo count($_SESSION['cart']); ?> item)
            </a>
        </div>
    <?php endif; ?>
    
    <div class="text-center mt-2">
        <a href="index.php" class="btn">Kembali ke Beranda</a>
        <a href="checkout.php" class="btn">Lihat Keranjang</a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
