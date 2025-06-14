-- Hapus dan buat ulang database
DROP DATABASE IF EXISTS point_of_sales;
CREATE DATABASE point_of_sales;
USE point_of_sales;

-- Tabel produk
CREATE TABLE produk (
    id_produk INT PRIMARY KEY AUTO_INCREMENT,
    kode_produk VARCHAR(50) UNIQUE NOT NULL,
    nama_produk VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    harga_jual DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    stok INT NOT NULL DEFAULT 0,
    satuan VARCHAR(50) NOT NULL,
    kategori VARCHAR(100),
    foto_produk VARCHAR(255),
    tanggal_dibuat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    tanggal_diperbarui DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status_produk ENUM('Aktif', 'Tidak Aktif') NOT NULL DEFAULT 'Aktif'
);
    

-- Tabel pengguna
CREATE TABLE pengguna (
    id_pengguna INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role ENUM('Admin', 'Kasir') NOT NULL DEFAULT 'Kasir',
    status ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active'
);

-- Tabel pelanggan
CREATE TABLE pelanggan (
    id_pelanggan INT PRIMARY KEY AUTO_INCREMENT,
    nama_lengkap VARCHAR(255) NOT NULL,
    telepon VARCHAR(50) UNIQUE,
    alamat TEXT,
    email VARCHAR(100)
);

-- Tabel member
CREATE TABLE member (
    id_member INT PRIMARY KEY AUTO_INCREMENT,
    id_pelanggan INT NOT NULL,
    level_member ENUM('Gold', 'Silver', 'Bronze') NOT NULL DEFAULT 'Bronze',
    tanggal_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    poin INT NOT NULL DEFAULT 0,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
);

CREATE TABLE keranjang (
    id_keranjang INT PRIMARY KEY AUTO_INCREMENT,
    id_pengguna INT NOT NULL,
    id_pelanggan INT,
    id_produk INT NOT NULL,
    jumlah INT NOT NULL DEFAULT 1,
    harga_saat_ini DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    subtotal DECIMAL(10,2) AS (jumlah * harga_saat_ini) STORED,
    tanggal_ditambahkan DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);  

-- Tabel penjualan
CREATE TABLE penjualan (
    id_penjualan INT PRIMARY KEY AUTO_INCREMENT,
    nomor_invoice VARCHAR(100) UNIQUE NOT NULL,
    tanggal_penjualan DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_bayar DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    jumlah_bayar DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    kembalian DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    tipe_pembayaran ENUM('Cash','Debit', 'Credit', 'QRIS') NOT NULL DEFAULT 'Cash',
    id_kasir INT,
    id_pelanggan INT,
    status_penjualan ENUM('Completed', 'Pending', 'Cancelled') NOT NULL DEFAULT 'Completed',
    FOREIGN KEY (id_kasir) REFERENCES pengguna(id_pengguna),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
);

-- Tabel detail_penjualan
CREATE TABLE detail_penjualan (
    id_detail_penjualan INT PRIMARY KEY AUTO_INCREMENT,
    id_penjualan INT NOT NULL,
    id_produk INT NOT NULL,
    jumlah_beli INT NOT NULL DEFAULT 1,
    harga_saat_ini DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (id_penjualan) REFERENCES penjualan(id_penjualan),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);

-- Tabel diskon_member
CREATE TABLE diskon_member (
    level_member ENUM('Gold', 'Silver', 'Bronze') PRIMARY KEY,
    persentase_diskon DECIMAL(5,2) NOT NULL DEFAULT 0.00
);

-- Insert ke tabel produk
INSERT INTO produk (kode_produk, nama_produk, deskripsi, harga_jual, stok, satuan, kategori, foto_produk, status_produk)
VALUES
('PRD001', 'Kopi Arabika', 'Kopi murni dari dataran tinggi', 25000, 50, 'bungkus', 'Minuman', 'kopi.jpg', 'Aktif'),
('PRD002', 'Teh Hijau', 'Teh hijau alami', 15000, 40, 'bungkus', 'Minuman', 'teh.jpg', 'Aktif'),
('PRD003', 'Susu Full Cream', 'Susu sapi segar', 18000, 30, 'liter', 'Minuman', 'susu.jpg', 'Aktif'),
('PRD004', 'Gula Pasir', 'Gula putih kristal', 12000, 100, 'kg', 'Bahan Pokok', 'gula.jpg', 'Aktif'),
('PRD005', 'Minyak Goreng', 'Minyak kelapa sawit', 28000, 60, 'liter', 'Bahan Pokok', 'minyak.jpg', 'Aktif'),
('PRD006', 'Beras Medium', 'Beras kualitas sedang', 9500, 150, 'kg', 'Bahan Pokok', 'beras.jpg', 'Aktif'),
('PRD007', 'Sabun Mandi', 'Sabun batang wangi', 3500, 200, 'pcs', 'Kebutuhan Harian', 'sabun.jpg', 'Aktif'),
('PRD008', 'Pasta Gigi', 'Pasta gigi mint', 8000, 120, 'pcs', 'Kebutuhan Harian', 'pasta.jpg', 'Aktif'),
('PRD009', 'Shampo Herbal', 'Shampo anti rontok', 15000, 70, 'pcs', 'Kebutuhan Harian', 'shampo.jpg', 'Aktif'),
('PRD010', 'Mie Instan', 'Mie rasa ayam bawang', 3000, 500, 'pcs', 'Makanan Instan', 'mie.jpg', 'Aktif'),
('PRD011', 'Tepung Terigu', 'Tepung serba guna', 10000, 80, 'kg', 'Bahan Pokok', 'tepung.jpg', 'Aktif'),
('PRD012', 'Kecap Manis', 'Kecap manis khas Indo', 9000, 60, 'pcs', 'Bumbu Dapur', 'kecap.jpg', 'Aktif'),
('PRD013', 'Sambal Botol', 'Sambal pedas mantap', 8500, 70, 'pcs', 'Bumbu Dapur', 'sambal.jpg', 'Aktif'),
('PRD014', 'Air Mineral', 'Air mineral 600ml', 3000, 300, 'botol', 'Minuman', 'air.jpg', 'Aktif'),
('PRD015', 'Kerupuk Udang', 'Kerupuk gurih udang', 7000, 100, 'bungkus', 'Snack', 'kerupuk.jpg', 'Aktif'),
('PRD016', 'Coklat Batang', 'Coklat premium', 12000, 90, 'pcs', 'Snack', 'coklat.jpg', 'Aktif'),
('PRD017', 'Roti Tawar', 'Roti tawar segar', 11000, 60, 'bungkus', 'Makanan', 'roti.jpg', 'Aktif'),
('PRD018', 'Telur Ayam', 'Telur ayam kampung', 22000, 180, 'lusin', 'Bahan Pokok', 'telur.jpg', 'Aktif'),
('PRD019', 'Mentega', 'Mentega masak', 15000, 50, 'pcs', 'Bahan Kue', 'mentega.jpg', 'Aktif'),
('PRD020', 'Kopi Robusta', 'Kopi kuat & pekat', 23000, 35, 'bungkus', 'Minuman', 'robusta.jpg', 'Tidak Aktif');

-- Insert pengguna
INSERT INTO pengguna (username, password, nama_lengkap, role, status)
VALUES
('admin', 'admin123', 'Admin Utama', 'Admin', 'Active'),
('kasir1', 'kasir123', 'Kasir A', 'Kasir', 'Active'),
('kasir2', 'kasir456', 'Kasir B', 'Kasir', 'Active');

-- Insert pelanggan
INSERT INTO pelanggan (nama_lengkap, telepon, alamat, email)
VALUES
('Andi Wijaya', '081234567891', 'Jl. Merdeka 1', 'andi@mail.com'),
('Sari Dewi', '081234567892', 'Jl. Sudirman 2', 'sari@mail.com'),
('Budi Hartono', '081234567893', 'Jl. Gajah Mada 3', 'budi@mail.com'),
('Rina Kurnia', '081234567894', 'Jl. Pemuda 4', 'rina@mail.com'),
('Fajar Pratama', '081234567895', 'Jl. Soekarno Hatta 5', 'fajar@mail.com');

-- Insert member
INSERT INTO member (id_pelanggan, level_member, poin)
VALUES
(1, 'Gold', 500),
(2, 'Silver', 300),
(3, 'Bronze', 150);

-- Insert diskon_member
INSERT INTO diskon_member (level_member, persentase_diskon)
VALUES
('Gold', 15.00),
('Silver', 10.00),
('Bronze', 5.00);

-- Insert penjualan
INSERT INTO penjualan (nomor_invoice, total_bayar, jumlah_bayar, kembalian, tipe_pembayaran, id_kasir, id_pelanggan, status_penjualan)
VALUES
('INV001', 50000, 60000, 10000, 'Cash', 2, 1, 'Completed'),
('INV002', 45000, 50000, 5000, 'Debit', 2, 2, 'Completed'),
('INV003', 75000, 80000, 5000, 'QRIS', 3, 3, 'Completed');

-- Insert detail_penjualan
INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah_beli, harga_saat_ini, subtotal)
VALUES
(1, 1, 2, 25000, 50000),
(2, 2, 3, 15000, 45000),
(3, 10, 5, 3000, 15000),
(3, 4, 5, 12000, 60000);