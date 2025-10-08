<?php
session_start();
include '../backend/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle status updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $kontak_id = intval($_POST['kontak_id']);
    $new_status = $conn->real_escape_string($_POST['status']);
    $update_sql = "UPDATE kontak SET status = '$new_status' WHERE id = $kontak_id";
    $conn->query($update_sql);
}

// Get custom orders
$sql = "SELECT * FROM kontak WHERE jenis_kontak = 'custom_order' ORDER BY created_at DESC";
$result = $conn->query($sql);

// Mapping status -> warna (background + text)
function getStatusStyle($status) {
    switch ($status) {
        case 'pending':
            return ['#fff3cd', '#856404']; // kuning
        case 'reviewed':
            return ['#d0ebff', '#004085']; // biru muda
        case 'quoted':
            return ['#fef9e7', '#7d6608']; // kuning pucat
        case 'confirmed':
            return ['#e2f0d9', '#155724']; // hijau
        case 'completed':
            return ['#e2e3e5', '#383d41']; // abu
        case 'cancelled':
            return ['#f8d7da', '#721c24']; // merah
        default:
            return ['#f8f9fa', '#6c757d']; // fallback abu
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Adam Bakery</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="admin-header">
    <h1>Dashboard Admin - Adam Bakery</h1>
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

<style>
        main {
            padding: 20px 40px;
        }

        .order-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
            gap: 12px 20px;
            margin-bottom: 12px;
        }

        .detail-item {
            font-size: 14px;
            line-height: 1.5;
        }

        .detail-label {
            font-weight: 600;
            color: #222;
            margin-right: 6px;
        }

        .detail-value {
            color: #555;
        }

        .detail-box {
            background: #f9f9f9;
            border: 1px solid #eee;
            padding: 10px 14px;
            border-radius: 8px;
            margin-top: 4px;
            font-size: 14px;
            line-height: 1.5;
            color: #444;
        }

        .status-form {
            margin-top: 14px;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .status-form select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .status-form button {
            padding: 6px 12px;
            border: none;
            background: #8B4513;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
        }

        .status-form button:hover {
            background: #A0522D;
        }

        .no-orders {
            padding: 16px;
            background: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 8px;
            color: #856404;
        }
    </style>
</head>
<main>
    <h2>Daftar Pesanan Kustom</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): 
            [$bgColor, $textColor] = getStatusStyle($order['status']);
        ?>
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <h3>Pesanan #<?php echo $order['id']; ?></h3>
                        <p style="color: #666; margin: 0;"><?php echo date('d M Y H:i', strtotime($order['created_at'])); ?></p>
                    </div>
                    <span class="status-badge" style="background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>;">
                        <?php echo ucfirst($order['status']); ?>
                    </span>
                </div>

                <div class="order-details">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Nama:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($order['nama']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($order['email']); ?></span>
                        </div>
                        <?php if ($order['event_date']): ?>
                            <div class="detail-item">
                                <span class="detail-label">Tanggal Acara:</span>
                                <span class="detail-value"><?php echo date('d M Y', strtotime($order['event_date'])); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($order['jumlah_porsi']): ?>
                            <div class="detail-item">
                                <span class="detail-label">Jumlah Porsi:</span>
                                <span class="detail-value"><?php echo $order['jumlah_porsi']; ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($order['budget_range']): ?>
                            <div class="detail-item">
                                <span class="detail-label">Budget:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($order['budget_range']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($order['custom_order_details']): ?>
                    <div class="detail-box-wrapper">
                        <span class="detail-label">Detail Pesanan:</span>
                        <div class="detail-box"><?php echo nl2br(htmlspecialchars($order['custom_order_details'])); ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($order['pesan']): ?>
                    <div class="detail-box-wrapper">
                        <span class="detail-label">Pesan Tambahan:</span>
                        <div class="detail-box"><?php echo nl2br(htmlspecialchars($order['pesan'])); ?></div>
                    </div>
                <?php endif; ?>

                <form method="post" class="status-form">
                    <input type="hidden" name="kontak_id" value="<?php echo $order['id']; ?>">
                    <label>Update Status:</label>
                    <select name="status">
                        <option value="pending" <?php echo $order['status']=='pending'?'selected':''; ?>>Pending</option>
                        <option value="reviewed" <?php echo $order['status']=='reviewed'?'selected':''; ?>>Reviewed</option>
                        <option value="quoted" <?php echo $order['status']=='quoted'?'selected':''; ?>>Quoted</option>
                        <option value="confirmed" <?php echo $order['status']=='confirmed'?'selected':''; ?>>Confirmed</option>
                        <option value="completed" <?php echo $order['status']=='completed'?'selected':''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $order['status']=='cancelled'?'selected':''; ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update_status">Update</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-orders">Belum ada pesanan kustom.</div>
    <?php endif; ?>
</main>
</body>
</html>
