<?php 
include 'includes/header.php';
include 'backend/db.php';

session_start();

$selected_category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Get all categories
$categories = ['all' => 'Semua Produk', 'Roti Manis' => 'Roti Manis', 'Roti Tawar' => 'Roti Tawar', 'Kue Kering' => 'Kue Kering', 'Kue Ulang Tahun' => 'Kue Ulang Tahun'];

// Build query based on category
$where_clause = "";
if ($selected_category != 'all') {
    $where_clause = "WHERE kategori = '" . $conn->real_escape_string($selected_category) . "'";
}

$products_query = "SELECT * FROM products $where_clause ORDER BY id DESC";
$products = $conn->query($products_query);


// Get reviews count and average rating for each product
function getProductReviews($conn, $product_id) {
    $result = $conn->query("SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews WHERE product_id = $product_id");
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return ['avg_rating' => 0, 'total' => 0];
}
?>

<main>
    <?php if (isset($_GET['added'])): ?>
        <div class="alert alert-success">Produk berhasil ditambahkan ke keranjang!</div>
    <?php endif; ?>
    
    <h2>Produk Adam Bakery</h2>
    
    <!-- Category Filter -->
    <div style="text-align: center; margin: 2rem 0;">
        <?php foreach ($categories as $key => $name): ?>
            <a href="?category=<?php echo $key; ?>" 
               class="btn <?php echo $selected_category == $key ? '' : 'btn-secondary'; ?>" 
               style="margin: 0.5rem;">
                <?php echo $name; ?>
            </a>
        <?php endforeach; ?>
    </div>
    
    <!-- Products Grid -->
    <div class="product-grid">
        <?php while ($product = $products->fetch_assoc()): ?>
            <?php $reviews = getProductReviews($conn, $product['id']); ?>
            <div class="product-card">
                <div class="category"><?php echo $product['kategori']; ?></div>
                
                <?php 
                $imageFile = 'uploads/' . $product['image'];
                if (empty($product['image']) || !file_exists($imageFile)) {
                    $imageFile = 'uploads/placeholder.jpg';
                }
                ?>

                <img src="<?php echo $imageFile; ?>" 
                    alt="<?php echo htmlspecialchars($product['nama']); ?>" 
                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 1rem;">

                
                <?php if ($product['deskripsi']): ?>
                    <p style="color: #6b5b47; font-size: 0.9rem; margin-bottom: 1rem;">
                        <?php echo $product['deskripsi']; ?>
                    </p>
                <?php endif; ?>
                
                <div class="price">Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></div>
                
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
                    <input type="hidden" name="item_type" value="product">
                    <input type="hidden" name="item_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="redirect" value="products.php?category=<?php echo $selected_category; ?>">
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <label style="margin: 0;">Jumlah:</label>
                        <input type="number" name="quantity" value="1" min="1" max="10" 
                               style="width: 60px; padding: 0.3rem; margin: 0;">
                    </div>
                    
                    <button type="submit" style="width: 100%;">Tambah ke Keranjang</button>
                </form>
                
                <!-- View Reviews Link -->
                <?php if ($reviews['total'] > 0): ?>
                    <a href="view_reviews.php?type=product&id=<?php echo $product['id']; ?>" 
                       class="btn-secondary" style="width: 100%; margin-top: 0.5rem; text-align: center;">
                        Lihat Ulasan
                    </a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    
    <?php if ($products->num_rows == 0): ?>
        <div style="text-align: center; padding: 3rem;">
            <p>Tidak ada produk dalam kategori ini.</p>
            <a href="products.php" class="btn">Lihat Semua Produk</a>
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
