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
    tanggal_diperbarui DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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

-- Data: produk
INSERT INTO produk (kode_produk, nama_produk, deskripsi, harga_jual, stok, satuan, kategori, foto_produk)
VALUES 
('PRD001', 'Air Mineral', 'Air mineral botol 600ml', 3000.00, 100, 'Botol', 'Minuman', 'air.jpg'),
('PRD002', 'Roti Tawar', 'Roti tawar kupas 200gr', 12000.00, 50, 'Pack', 'Makanan', 'roti.jpg'),
('PRD003', 'Teh Botol', 'Minuman teh manis', 5000.00, 70, 'Botol', 'Minuman', 'teh.jpg'),
('PRD004', 'Kopi Instan', 'Kopi sachet 20gr', 1500.00, 200, 'Sachet', 'Minuman', 'kopi.jpg'),
('PRD005', 'Sabun Mandi', 'Sabun batang', 3500.00, 80, 'Batang', 'Kebutuhan', 'sabun.jpg'),
('PRD006', 'Sikat Gigi', 'Sikat gigi dewasa', 6000.00, 40, 'Pcs', 'Kebutuhan', 'sikat.jpg'),
('PRD007', 'Shampoo 100ml', 'Shampoo kemasan kecil', 8000.00, 60, 'Botol', 'Kebutuhan', 'shampoo.jpg'),
('PRD008', 'Minyak Goreng', 'Minyak 1 liter', 14000.00, 90, 'Liter', 'Dapur', 'minyak.jpg'),
('PRD009', 'Gula Pasir', 'Gula 1kg', 13000.00, 75, 'Kg', 'Dapur', 'gula.jpg'),
('PRD010', 'Mie Instan', 'Mie instan goreng', 3000.00, 150, 'Bungkus', 'Makanan', 'mie.jpg');

-- Data: pengguna
INSERT INTO pengguna (username, password, nama_lengkap, role, status)
VALUES 
('admin1', 'pass123', 'Admin Utama', 'Admin', 'Active'),
('kasir1', 'pass456', 'Kasir Satu', 'Kasir', 'Active'),
('kasir2', 'pass789', 'Kasir Dua', 'Kasir', 'Active'),
('admin2', 'adminpass', 'Admin Dua', 'Admin', 'Inactive'),
('kasir3', 'password', 'Kasir Tiga', 'Kasir', 'Active'),
('kasir4', 'pass321', 'Kasir Empat', 'Kasir', 'Inactive'),
('kasir5', 'test123', 'Kasir Lima', 'Kasir', 'Active'),
('admin3', 'securepass', 'Admin Tiga', 'Admin', 'Active'),
('kasir6', 'abc123', 'Kasir Enam', 'Kasir', 'Active'),
('admin4', 'root123', 'Admin Empat', 'Admin', 'Active');

-- Data: pelanggan
INSERT INTO pelanggan (nama_lengkap, telepon, alamat, email)
VALUES 
('Budi Santoso', '0811111111', 'Jl. Merdeka No.1', 'budi@email.com'),
('Siti Aminah', '0822222222', 'Jl. Pahlawan No.2', 'siti@email.com'),
('Andi Wijaya', '0833333333', 'Jl. Soekarno No.3', 'andi@email.com'),
('Dewi Lestari', '0844444444', 'Jl. Sudirman No.4', 'dewi@email.com'),
('Rudi Hartono', '0855555555', 'Jl. Diponegoro No.5', 'rudi@email.com'),
('Nina Kartika', '0866666666', 'Jl. Gajah Mada No.6', 'nina@email.com'),
('Agus Salim', '0877777777', 'Jl. Asia Afrika No.7', 'agus@email.com'),
('Tina Syahrini', '0888888888', 'Jl. Thamrin No.8', 'tina@email.com'),
('Doni Saputra', '0899999999', 'Jl. Ahmad Yani No.9', 'doni@email.com'),
('Linda Herlina', '0800000000', 'Jl. Gatot Subroto No.10', 'linda@email.com');

-- Data: member
INSERT INTO member (id_pelanggan, level_member, poin)
VALUES 
(1, 'Gold', 200),
(2, 'Silver', 120),
(3, 'Bronze', 50),
(4, 'Gold', 300),
(5, 'Silver', 90),
(6, 'Bronze', 30),
(7, 'Gold', 180),
(8, 'Silver', 110),
(9, 'Bronze', 60),
(10, 'Gold', 250);

-- Data: penjualan
INSERT INTO penjualan (nomor_invoice, total_bayar, jumlah_bayar, kembalian, tipe_pembayaran, id_kasir, id_pelanggan)
VALUES 
('INV001', 20000.00, 25000.00, 5000.00, 'Cash', 2, 1),
('INV002', 15000.00, 20000.00, 5000.00, 'Debit', 3, 2),
('INV003', 30000.00, 30000.00, 0.00, 'Credit', 2, 3),
('INV004', 5000.00, 10000.00, 5000.00, 'QRIS', 2, 4),
('INV005', 25000.00, 30000.00, 5000.00, 'Cash', 1, 5),
('INV006', 10000.00, 10000.00, 0.00, 'Debit', 2, 6),
('INV007', 22000.00, 25000.00, 3000.00, 'Cash', 3, 7),
('INV008', 8000.00, 10000.00, 2000.00, 'Credit', 2, 8),
('INV009', 12000.00, 15000.00, 3000.00, 'QRIS', 2, 9),
('INV010', 4000.00, 5000.00, 1000.00, 'Cash', 1, 10);

-- Data: detail_penjualan
INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah_beli, harga_saat_ini, subtotal)
VALUES
(1, 1, 2, 3000.00, 6000.00),
(1, 2, 1, 12000.00, 12000.00),
(2, 3, 3, 5000.00, 15000.00),
(3, 4, 2, 1500.00, 3000.00),
(3, 5, 2, 3500.00, 7000.00),
(4, 6, 1, 6000.00, 6000.00),
(5, 7, 2, 8000.00, 16000.00),
(6, 8, 1, 14000.00, 14000.00),
(7, 9, 1, 13000.00, 13000.00),
(10, 10, 1, 3000.00, 3000.00);

-- Data: diskon_member
INSERT INTO diskon_member (level_member, persentase_diskon)
VALUES
('Gold', 10.00),
('Silver', 5.00),
('Bronze', 2.50);