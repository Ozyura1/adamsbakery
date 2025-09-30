-- Add custom order functionality to contact system
USE adam_bakery;

-- Add custom order fields to kontak table
ALTER TABLE kontak 
ADD COLUMN jenis_kontak ENUM('ulasan', 'custom_order', 'pertanyaan') DEFAULT 'ulasan' AFTER pesan,
ADD COLUMN custom_order_details TEXT AFTER jenis_kontak,
ADD COLUMN budget_range VARCHAR(100) AFTER custom_order_details,
ADD COLUMN event_date DATE AFTER budget_range,
ADD COLUMN jumlah_porsi INT AFTER event_date,
ADD COLUMN status ENUM('pending', 'reviewed', 'quoted', 'confirmed', 'completed') DEFAULT 'pending' AFTER jumlah_porsi;

-- Create custom order quotes table
CREATE TABLE IF NOT EXISTS custom_order_quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kontak_id INT NOT NULL,
    quoted_price DECIMAL(10,2) NOT NULL,
    quote_details TEXT,
    valid_until DATE,
    status ENUM('pending', 'accepted', 'rejected', 'expired') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kontak_id) REFERENCES kontak(id) ON DELETE CASCADE
);

-- Add index for better performance
CREATE INDEX idx_kontak_jenis ON kontak(jenis_kontak);
CREATE INDEX idx_kontak_status ON kontak(status);
