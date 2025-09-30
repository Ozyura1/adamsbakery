-- Seed initial data for Adam Bakery (versi revisi)
USE adam_bakery;

-- Insert categories
INSERT INTO categories (nama) VALUES
('Roti Manis'),
('Roti Tawar'),
('Kue Kering'),
('Kue Ulang Tahun');

-- Insert sample products dengan category_id
INSERT INTO products (category_id, nama, harga, deskripsi) VALUES
((SELECT id FROM categories WHERE nama = 'Roti Tawar'), 'Roti Tawar Gandum', 25000, 'Roti tawar gandum segar dengan tekstur lembut dan rasa yang kaya'),
((SELECT id FROM categories WHERE nama = 'Roti Tawar'), 'Roti Tawar Putih', 20000, 'Roti tawar putih klasik yang lembut dan cocok untuk sarapan'),
((SELECT id FROM categories WHERE nama = 'Roti Manis'), 'Croissant Butter', 18000, 'Croissant berlapis dengan butter premium, renyah di luar lembut di dalam'),
((SELECT id FROM categories WHERE nama = 'Roti Manis'), 'Donat Coklat', 12000, 'Donat lembut dengan glazur coklat manis yang menggoda'),
((SELECT id FROM categories WHERE nama = 'Roti Manis'), 'Donat Strawberry', 12000, 'Donat dengan topping strawberry segar dan manis'),
((SELECT id FROM categories WHERE nama = 'Kue Kering'), 'Kue Nastar', 45000, 'Kue kering tradisional dengan isian nanas manis (per toples)'),
((SELECT id FROM categories WHERE nama = 'Kue Kering'), 'Kastengel', 50000, 'Kue kering keju yang gurih dan renyah (per toples)'),
((SELECT id FROM categories WHERE nama = 'Kue Ulang Tahun'), 'Kue Tart Coklat', 150000, 'Kue tart coklat dengan dekorasi cantik untuk ulang tahun'),
((SELECT id FROM categories WHERE nama = 'Kue Ulang Tahun'), 'Kue Tart Vanilla', 140000, 'Kue tart vanilla dengan cream lembut dan dekorasi elegan'),
((SELECT id FROM categories WHERE nama = 'Kue Ulang Tahun'), 'Black Forest Cake', 180000, 'Kue black forest dengan cherry dan whipped cream');

-- Insert sample packages
INSERT INTO packages (nama, deskripsi, harga) VALUES
('Paket Pagi Sehat', 'Roti tawar gandum + croissant + susu segar untuk memulai hari', 35000),
('Paket Ulang Tahun Kecil', 'Kue tart vanilla + 6 donat mix + lilin ulang tahun', 200000),
('Paket Ulang Tahun Besar', 'Kue tart coklat + 12 donat mix + black forest mini + dekorasi', 350000),
('Paket Kue Kering Lebaran', 'Nastar + kastengel + putri salju dalam kemasan cantik', 120000),
('Paket Sarapan Keluarga', '2 roti tawar + 4 croissant + selai strawberry', 65000);

-- Insert default admin user
-- Password = "admin123" (sudah dalam bentuk bcrypt hash)
INSERT INTO admin_users (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
