<?php 
include 'includes/header.php';
include 'backend/db.php';

$item_type = isset($_GET['type']) ? $_GET['type'] : 'all';
$item_id = isset($_GET['id']) ? $_GET['id'] : null;

// Build query based on filters
$where_clause = "WHERE 1=1";
if ($item_type != 'all' && $item_id) {
    if ($item_type == 'product') {
        $where_clause .= " AND r.item_type = 'product' AND r.product_id = $item_id";
    } elseif ($item_type == 'package') {
        $where_clause .= " AND r.item_type = 'package' AND r.package_id = $item_id";
    }
}

$reviews_query = "
    SELECT r.*, 
           CASE 
               WHEN r.item_type = 'product' THEN p.nama
               WHEN r.item_type = 'package' THEN pkg.nama
           END as item_name
    FROM reviews r
    LEFT JOIN products p ON r.product_id = p.id
    LEFT JOIN packages pkg ON r.package_id = pkg.id
    $where_clause
    ORDER BY r.created_at DESC
";

$reviews = $conn->query($reviews_query);

// Get average rating if viewing specific item
$avg_rating = 0;
$total_reviews = 0;
if ($item_type != 'all' && $item_id) {
    $avg_query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews $where_clause";
    $avg_result = $conn->query($avg_query);
    if ($avg_result->num_rows > 0) {
        $avg_data = $avg_result->fetch_assoc();
        $avg_rating = round($avg_data['avg_rating'], 1);
        $total_reviews = $avg_data['total'];
    }
}
?>

<main>
    <h2>Ulasan Pelanggan</h2>
    
    <?php if ($item_type != 'all' && $item_id && $total_reviews > 0): ?>
        <div style="background: #f4e4c1; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; text-align: center;">
            <h3>Rating Rata-rata</h3>
            <div style="font-size: 2rem; color: #ffc107; margin: 0.5rem 0;">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="<?php echo $i <= $avg_rating ? '' : 'empty'; ?>">★</span>
                <?php endfor; ?>
            </div>
            <p><strong><?php echo $avg_rating; ?>/5</strong> dari <?php echo $total_reviews; ?> ulasan</p>
        </div>
    <?php endif; ?>
    
    <?php if ($reviews->num_rows == 0): ?>
        <p>Belum ada ulasan untuk item ini.</p>
    <?php else: ?>
        <div class="product-grid">
            <?php while ($review = $reviews->fetch_assoc()): ?>
                <div class="product-card">
                    <h4><?php echo $review['item_name']; ?></h4>
                    <p><strong><?php echo $review['nama_reviewer']; ?></strong></p>
                    
                    <div class="rating" style="margin: 0.5rem 0;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="<?php echo $i <= $review['rating'] ? '' : 'empty'; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    
                    <?php if ($review['review_text']): ?>
                        <p style="font-style: italic; color: #6b5b47;">"<?php echo $review['review_text']; ?>"</p>
                    <?php endif; ?>
                    
                    <small style="color: #8b5a3c;">
                        <?php echo date('d F Y', strtotime($review['created_at'])); ?>
                    </small>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    
    <div class="text-center mt-2">
        <a href="products.php" class="btn">Lihat Produk</a>
        <a href="index.php" class="btn">Kembali ke Beranda</a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
