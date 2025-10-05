<?php 
include 'includes/header.php'; 
include 'backend/db.php'; 

session_start();
?>
<main>
    <h2>Hubungi Kami</h2>
    
    <!-- Added tabs for different contact types -->
     <style>
.tab-btn {
    background: #8b5a3c;    
    color: #8a774eff;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;

}

.tab-btn.active {
    background: #d4af8c;
    color: #8a774eff;
}
</style>

    <div class="contact-tabs">
        <button class="tab-btn active" onclick="showTab('ulasan')">Beri Ulasan</button>
        <button class="tab-btn" onclick="showTab('custom_order')">Pesanan Kustom</button>
        <button class="tab-btn" onclick="showTab('pertanyaan')">Pertanyaan Umum</button>
    </div>

    <!-- Added review form tab -->
    <div id="ulasan-tab" class="tab-content active">
        <h3>Beri Ulasanmu</h3>
        <form method="post" action="backend/process_contact.php">
            <input type="hidden" name="jenis_kontak" value="ulasan">
            
            <label>Nama:</label><br>
            <input type="text" name="nama" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>
            
            <label>Ulasan:</label><br>
            <textarea name="pesan" placeholder="Bagikan pengalaman Anda dengan produk kami..." required></textarea><br><br>
            
            <button type="submit">Kirim Ulasan</button>
        </form>
    </div>

    <!-- Added custom order form tab -->
    <div id="custom_order-tab" class="tab-content">
        <h3>Pesanan Kustom</h3>
        <p>Ingin memesan kue atau roti khusus untuk acara spesial Anda? Isi form di bawah ini!</p>
        
        <form method="post" action="backend/process_contact.php">
            <input type="hidden" name="jenis_kontak" value="custom_order">
            
            <label>Nama:</label><br>
            <input type="text" name="nama" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>No. Telepon:</label><br>
            <input type="tel" name="phone"><br><br>
            
            <label>Jenis Acara:</label><br>
            <select name="jenis_acara">
                <option value="">Pilih jenis acara</option>
                <option value="ulang_tahun">Ulang Tahun</option>
                <option value="pernikahan">Pernikahan</option>
                <option value="graduation">Wisuda</option>
                <option value="corporate">Corporate Event</option>
                <option value="lainnya">Lainnya</option>
            </select><br><br>

            <label>Tanggal Acara:</label><br>
            <input type="date" name="event_date" min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>"><br><br>

            <label>Jumlah Porsi (perkiraan):</label><br>
            <input type="number" name="jumlah_porsi" min="1" placeholder="contoh: 50"><br><br>

            <label>Budget Range:</label><br>
            <select name="budget_range">
                <option value="">Pilih budget range</option>
                <option value="< 500rb">< Rp 500.000</option>
                <option value="500rb - 1jt">Rp 500.000 - 1.000.000</option>
                <option value="1jt - 2jt">Rp 1.000.000 - 2.000.000</option>
                <option value="2jt - 5jt">Rp 2.000.000 - 5.000.000</option>
                <option value="> 5jt">> Rp 5.000.000</option>
            </select><br><br>
            
            <label>Detail Pesanan Kustom:</label><br>
            <textarea name="custom_order_details" placeholder="Jelaskan detail pesanan Anda: jenis kue/roti, tema, warna, ukuran, rasa, dekorasi khusus, dll." required></textarea><br><br>

            <label>Pesan Tambahan:</label><br>
            <textarea name="pesan" placeholder="Ada permintaan khusus atau pertanyaan lainnya?"></textarea><br><br>
            
            <button type="submit">Kirim Permintaan Pesanan</button>
        </form>
    </div>

    <!-- Added general inquiry form tab -->
    <div id="pertanyaan-tab" class="tab-content">
        <h3>Pertanyaan Umum</h3>
        <form method="post" action="backend/process_contact.php">
            <input type="hidden" name="jenis_kontak" value="pertanyaan">
            
            <label>Nama:</label><br>
            <input type="text" name="nama" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>
            
            <label>Pertanyaan:</label><br>
            <textarea name="pesan" placeholder="Apa yang ingin Anda tanyakan?" required></textarea><br><br>
            
            <button type="submit">Kirim Pertanyaan</button>
        </form>
    </div>
</main>

<!-- Added CSS and JavaScript for tabs -->
<style>
.contact-tabs {
    display: flex;
    margin-bottom: 2rem;
    border-bottom: 2px solid #ddd;
}

.tab-btn {
    background: none;
    border: none;
    padding: 1rem 2rem;
    cursor: pointer;
    font-size: 1rem;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.tab-btn:hover {
    background-color: #f5f5f5;
}

.tab-btn.active {
    border-bottom-color: #8B4513;
    color: #8B4513;
    font-weight: bold;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.tab-content h3 {
    color: #8B4513;
    margin-bottom: 1rem;
}

form {
    max-width: 600px;
}

label {
    font-weight: bold;
    color: #333;
}

input, select, textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

textarea {
    min-height: 100px;
    resize: vertical;
}

button[type="submit"] {
    background-color: #8B4513;
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #A0522D;
}
</style>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => content.classList.remove('active'));
    
    // Remove active class from all buttons
    const tabBtns = document.querySelectorAll('.tab-btn');
    tabBtns.forEach(btn => btn.classList.remove('active'));
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}
</script>

<?php include 'includes/footer.php'; ?>
