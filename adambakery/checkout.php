<?php 
include 'includes/header.php';
include 'backend/db.php';

session_start();

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['redirect_after_login'] = 'checkout.php';
    header("Location: customer_auth.php");
    exit();
}

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $item_type = $_POST['item_type'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    
    $cart_key = $item_type . '_' . $item_id;
    
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'type' => $item_type,
            'id' => $item_id,
            'quantity' => $quantity
        ];
    }
    
    $success = "Item berhasil ditambahkan ke keranjang!";
}

// Handle remove from cart
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    $success = "Item berhasil dihapus dari keranjang!";
}

// Handle update cart (ubah jumlah)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $key => $qty) {
        $qty = (int)$qty;
        if ($qty > 0) {
            $_SESSION['cart'][$key]['quantity'] = $qty;
        } else {
            unset($_SESSION['cart'][$key]); // kalau qty jadi 0, item dihapus
        }
    }
    $success = "Keranjang berhasil diperbarui!";
}

// Calculate cart total
$cart_total = 0;
$cart_items = [];

foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['type'] == 'product') {
        $result = $conn->query("SELECT * FROM products WHERE id = " . $item['id']);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $cart_items[$key] = [
                'name' => $product['nama'],
                'price' => $product['harga'],
                'quantity' => $item['quantity'],
                'type' => 'product',
                'subtotal' => $product['harga'] * $item['quantity']
            ];
            $cart_total += $cart_items[$key]['subtotal'];
        }
    } elseif ($item['type'] == 'package') {
        $result = $conn->query("SELECT * FROM packages WHERE id = " . $item['id']);
        if ($result->num_rows > 0) {
            $package = $result->fetch_assoc();
            $cart_items[$key] = [
                'name' => $package['nama'],
                'price' => $package['harga'],
                'quantity' => $item['quantity'],
                'type' => 'package',
                'subtotal' => $package['harga'] * $item['quantity']
            ];
            $cart_total += $cart_items[$key]['subtotal'];
        }
    }
}

$customer_sql = "SELECT * FROM customer_users WHERE id = " . $_SESSION['customer_id'];
$customer_result = $conn->query($customer_sql);
$customer_data = $customer_result->fetch_assoc();
?>

<main>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Keranjang Belanja</h2>
        <div>
            <span>Selamat datang, <?php echo $_SESSION['customer_name']; ?>!</span>
            <a href="customer_logout.php" class="btn-secondary" style="margin-left: 1rem;">Logout</a>
        </div>
    </div>
    
    <?php if (empty($cart_items)): ?>
        <p>Keranjang belanja Anda kosong.</p>
        <a href="products.php" class="btn">Mulai Belanja</a>
    <?php else: ?>
        <form method="post" action="">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $key => $item): ?>
                    <tr>
                        <td><?php echo $item['name']; ?> (<?php echo ucfirst($item['type']); ?>)</td>
                        <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                        <td>
                            <input type="number" 
                                   name="quantities[<?php echo $key; ?>]" 
                                   value="<?php echo $item['quantity']; ?>" 
                                   min="1" style="width:60px;">
                        </td>
                        <td>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="?remove=<?php echo $key; ?>" class="btn-secondary" onclick="return confirm('Hapus item ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="font-weight: bold; background-color: #f4e4c1;">
                        <td colspan="3">Total</td>
                        <td>Rp <?php echo number_format($cart_total, 0, ',', '.'); ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" name="update_cart" class="btn">Update Keranjang</button>
        </form>
        
        <h3>Informasi Pembeli</h3>
        <form method="post" action="backend/process_payment.php" enctype="multipart/form-data">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_pembeli" value="<?php echo $customer_data['nama_lengkap']; ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $customer_data['email']; ?>" required>
            
            <label>No. Telepon:</label>
            <input type="tel" name="phone" value="<?php echo $customer_data['phone']; ?>" required>
            
            <label>Alamat Lengkap:</label>
            <textarea name="alamat" rows="3" required><?php echo $customer_data['alamat']; ?></textarea>
            
            <h3>Informasi Transfer Bank</h3>
            <p style="background: #f4e4c1; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <strong>Rekening Tujuan:</strong><br>
                Bank BCA: 1234567890 a.n. Adam Bakery<br>
                Bank Mandiri: 0987654321 a.n. Adam Bakery<br>
                Bank BNI: 1122334455 a.n. Adam Bakery
            </p>
            
            <label>Nama Pemilik Rekening (Pengirim):</label>
            <input type="text" name="account_name" required>
            
            <label>Nomor Rekening (Pengirim):</label>
            <input type="text" name="account_number" required>
            
            <label>Bank Tujuan:</label>
            <select name="bank_name" required>
                <option value="">Pilih Bank</option>
                <option value="BCA">BCA</option>
                <option value="Mandiri">Mandiri</option>
                <option value="BNI">BNI</option>
                <option value="BRI">BRI</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            
            <label>Jumlah Transfer:</label>
            <input type="number" name="transfer_amount" value="<?php echo $cart_total; ?>" required>
            
            <label>Bukti Transfer (Wajib):</label>
            <input type="file" name="transfer_proof" accept="image/*">
            <small>Format: JPG, PNG, maksimal 2MB</small>
            
            <input type="hidden" name="total_amount" value="<?php echo $cart_total; ?>">
            <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
            
            <button type="submit">Proses Pembayaran</button>
        </form>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
