-- Add customer users table for Adam Bakery
USE adam_bakery;

-- Customer users table
CREATE TABLE IF NOT EXISTS customer_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- bcrypt hash
    phone VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Add customer_id to transactions table to link orders to customers
ALTER TABLE transactions 
ADD COLUMN customer_id INT,
ADD FOREIGN KEY (customer_id) REFERENCES customer_users(id) ON DELETE SET NULL;

-- Add index for better performance
CREATE INDEX idx_customer_email ON customer_users(email);
CREATE INDEX idx_transaction_customer ON transactions(customer_id);
