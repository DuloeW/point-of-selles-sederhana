DROP DATABASE IF EXISTS point_of_sales;
CREATE DATABASE point_of_sales;
USE point_of_sales;

CREATE TABLE produk (
    id_produk int PRIMARY KEY AUTO_INCREMENT,
    kode_produk varchar(50) UNIQUE NOT null,
    nama_produk varchar(255) NOT null,
    deskripsi text,
    harga_jual decimal(10, 2) NOT null DEFAULT 0.00,
    stok int NOT null DEFAULT 0,
    satuan varchar(50) NOT null,
    kategori varchar(100),
    foto_produk varchar(255),
    tanggal_dibuat datetime NOT null DEFAULT CURRENT_TIMESTAMP,
    tanggal_diperbarui datetime NOT null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE pengguna (
	id_pengguna int PRIMARY KEY AUTO_INCREMENT,
    username varchar(50) UNIQUE NOT null,
    password varchar(255) NOT null,
    nama_lengkap varchar(100) NOT null,
    role ENUM('Admin','Kasir') NOT null DEFAULT 'Kasir',
    status ENUM('Active', 'Inactive') NOT null DEFAULT 'Active'
);

CREATE TABLE pelanggan (
	id_pelanggan int PRIMARY KEY AUTO_INCREMENT,
    nama_lengkap varchar(255) NOT null,
    telepon varchar(50) UNIQUE,
    alamat text,
    email varchar(100)
);

CREATE TABLE penjualan (
	id_penjualan int PRIMARY KEY AUTO_INCREMENT,
    nomor_invoice varchar(100) UNIQUE NOT null,
    tanggal_penjualan datetime NOT null DEFAULT CURRENT_TIMESTAMP,
    total_bayar decimal(10,2) NOT null DEFAULT 0.00,
    jumlah_bayar decimal(10,2) NOT null DEFAULT 0.00,
    kembalian decimal(10,2) NOT null DEFAULT 0.00,
    tipe_pembayaran ENUM('Cash','Debit', 'Credit', 'QRIS') NOT null DEFAULT 'Cash',
    id_kasir int,
    id_pelanggan int,
    status_penjualan ENUM('Completed', 'Pending', 'Cancelled') NOT null DEFAULT 'Completed',
    FOREIGN KEY (id_kasir) REFERENCES pengguna(id_pengguna),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
);

CREATE TABLE detail_penjualan(
	id_detail_penjualan int PRIMARY KEY AUTO_INCREMENT,
    id_penjualan int NOT null,
    id_produk int NOT null,
    jumlah_beli int NOT null DEFAULT 1,
    harga_saat_ini decimal(10,2) NOT null DEFAULT 0.00,
    subtotal decimal(10,2) NOT null DEFAULT 0.00,
    FOREIGN KEY (id_penjualan) REFERENCES penjualan(id_penjualan),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);

-- Menggunakan database yang relevan

-- --------------------------------------------------------
-- INSERT DATA UNTUK TABEL PENGGUNA
-- --------------------------------------------------------
INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `nama_lengkap`, `role`, `status`) VALUES
(1, 'admin', 'hashed_password_admin', 'Administrator Utama', 'Admin', 'Active'),
(2, 'kasir_budi', 'hashed_password_budi', 'Budi Santoso', 'Kasir', 'Active'),
(3, 'kasir_citra', 'hashed_password_citra', 'Citra Ayu', 'Kasir', 'Active'),
(4, 'kasir_dian', 'hashed_password_dian', 'Dian Permata', 'Kasir', 'Inactive');

-- --------------------------------------------------------
-- INSERT DATA UNTUK TABEL PELANGGAN
-- --------------------------------------------------------
INSERT INTO `pelanggan` (`id_pelanggan`, `nama_lengkap`, `telepon`, `alamat`, `email`) VALUES
(1, 'Andi Wijaya', '081234567890', 'Jl. Merdeka No. 1, Jakarta', 'andi.wijaya@example.com'),
(2, 'Siti Aminah', '081234567891', 'Jl. Pahlawan No. 2, Surabaya', 'siti.aminah@example.com'),
(3, 'Rina Hartono', '081234567892', 'Jl. Sudirman No. 3, Bandung', 'rina.hartono@example.com'),
(4, 'Joko Susilo', '081234567893', 'Jl. Gajah Mada No. 4, Yogyakarta', 'joko.s@example.com'),
(5, 'Dewi Lestari', '081234567894', 'Jl. Diponegoro No. 5, Semarang', 'dewi.lestari@example.com'),
(6, 'Bambang Irawan', '081234567895', 'Jl. Imam Bonjol No. 6, Medan', 'bambang.irawan@example.com'),
(7, 'Lia Kurnia', '081234567896', 'Jl. Teuku Umar No. 7, Makassar', 'lia.kurnia@example.com'),
(8, 'Agus Salim', '081234567897', 'Jl. Gatot Subroto No. 8, Denpasar', 'agus.salim@example.com'),
(9, 'Fitriani', '081234567898', 'Jl. Hasanuddin No. 9, Palembang', 'fitriani@example.com'),
(10, 'Eko Prasetyo', '081234567899', 'Jl. Ahmad Yani No. 10, Balikpapan', 'eko.prasetyo@example.com');

-- --------------------------------------------------------
-- INSERT DATA UNTUK TABEL PRODUK
-- --------------------------------------------------------
INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`, `deskripsi`, `harga_jual`, `stok`, `satuan`, `kategori`) VALUES
(1, 'P001', 'Laptop Pro 14', 'Laptop canggih untuk profesional', 15000000.00, 15, 'Unit', 'Elektronik'),
(2, 'P002', 'Mouse Wireless Silent', 'Mouse tanpa kabel dengan klik senyap', 150000.00, 120, 'Unit', 'Aksesoris Komputer'),
(3, 'P003', 'Keyboard Mechanical RGB', 'Keyboard gaming dengan lampu RGB', 750000.00, 50, 'Unit', 'Aksesoris Komputer'),
(4, 'P004', 'Kopi Arabika 250g', 'Biji kopi arabika pilihan', 85000.00, 200, 'Pack', 'Minuman'),
(5, 'P005', 'Teh Hijau Celup', 'Isi 25 kantong teh hijau', 25000.00, 300, 'Box', 'Minuman'),
(6, 'P006', 'Air Mineral 600ml', 'Air mineral murni', 3500.00, 1000, 'Botol', 'Minuman'),
(7, 'P007', 'Roti Tawar Gandum', 'Roti tawar sehat dari gandum utuh', 18000.00, 75, 'Bungkus', 'Makanan'),
(8, 'P008', 'Susu UHT Coklat 1L', 'Susu UHT rasa coklat', 22000.00, 150, 'Karton', 'Minuman'),
(9, 'P009', 'Buku Tulis Sinar Dunia', 'Buku tulis isi 58 lembar', 5000.00, 500, 'Pcs', 'ATK'),
(10, 'P010', 'Pulpen Pilot G2', 'Pulpen tinta gel warna hitam', 12000.00, 400, 'Pcs', 'ATK'),
(11, 'P011', 'Sabun Mandi Cair 450ml', 'Sabun mandi aroma lavender', 35000.00, 90, 'Botol', 'Perawatan Tubuh'),
(12, 'P012', 'Shampoo Anti Ketombe 170ml', 'Shampoo untuk mengatasi ketombe', 28000.00, 80, 'Botol', 'Perawatan Tubuh'),
(13, 'P013', 'Deterjen Bubuk 800g', 'Deterjen untuk pakaian bersih wangi', 19000.00, 110, 'Pack', 'Kebutuhan Rumah Tangga'),
(14, 'P014', 'Minyak Goreng 2L', 'Minyak goreng kelapa sawit', 42000.00, 130, 'Pouch', 'Sembako'),
(15, 'P015', 'Beras Premium 5kg', 'Beras putih pulen dan wangi', 68000.00, 60, 'Karung', 'Sembako'),
(16, 'P016', 'Mie Instan Goreng', 'Mie instan rasa original', 3000.00, 800, 'Bungkus', 'Makanan'),
(17, 'P017', 'Kecap Manis 600ml', 'Kecap manis dari kedelai pilihan', 21000.00, 140, 'Botol', 'Sembako'),
(18, 'P018', 'Sambal Terasi Sachet', 'Sambal terasi siap saji', 1500.00, 600, 'Sachet', 'Bumbu'),
(19, 'P019', 'Lampu LED 10W', 'Lampu hemat energi', 25000.00, 250, 'Unit', 'Elektronik'),
(20, 'P020', 'Baterai AA', 'Baterai alkaline isi 4', 15000.00, 300, 'Pack', 'Elektronik');

-- --------------------------------------------------------
-- INSERT DATA PENJUALAN & DETAIL PENJUALAN
-- Transaksi akan dibuat satu per satu untuk kejelasan
-- --------------------------------------------------------

-- Transaksi 1
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(1, 'INV20250610001', 33000.00, 35000.00, 2000.00, 'Cash', 2, 1);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(1, 9, 2, 5000.00, 10000.00),
(1, 10, 1, 12000.00, 12000.00),
(1, 6, 3, 3500.00, 10500.00);

-- Transaksi 2
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(2, 'INV20250610002', 15000000.00, 15000000.00, 0.00, 'Debit', 3, 5);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(2, 1, 1, 15000000.00, 15000000.00);

-- Transaksi 3
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(3, 'INV20250610003', 15000.00, 20000.00, 5000.00, 'Cash', 2, NULL);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(3, 16, 5, 3000.00, 15000.00);

-- Transaksi 4
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(4, 'INV20250611004', 110000.00, 110000.00, 0.00, 'QRIS', 2, 7);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(4, 14, 1, 42000.00, 42000.00),
(4, 15, 1, 68000.00, 68000.00);

-- Transaksi 5
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(5, 'INV20250611005', 165000.00, 165000.00, 0.00, 'Credit', 3, 2);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(5, 2, 1, 150000.00, 150000.00),
(5, 20, 1, 15000.00, 15000.00);

-- Transaksi 6
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(6, 'INV20250611006', 53000.00, 60000.00, 7000.00, 'Cash', 2, NULL);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(6, 11, 1, 35000.00, 35000.00),
(6, 18, 12, 1500.00, 18000.00);

-- Transaksi 7
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(7, 'INV20250612007', 85000.00, 85000.00, 0.00, 'Debit', 3, 8);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(7, 4, 1, 85000.00, 85000.00);

-- Transaksi 8
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(8, 'INV20250612008', 44000.00, 44000.00, 0.00, 'QRIS', 2, 4);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(8, 8, 2, 22000.00, 44000.00);

-- Transaksi 9
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(9, 'INV20250612009', 50000.00, 50000.00, 0.00, 'Cash', 3, NULL);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(9, 19, 2, 25000.00, 50000.00);

-- Transaksi 10
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(10, 'INV20250613010', 52000.00, 52000.00, 0.00, 'Debit', 2, 10);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(10, 7, 1, 18000.00, 18000.00),
(10, 5, 1, 25000.00, 25000.00),
(10, 9, 1, 5000.00, 5000.00);

-- Transaksi 11
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(11, 'INV20250613011', 750000.00, 750000.00, 0.00, 'Credit', 3, 3);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(11, 3, 1, 750000.00, 750000.00);

-- Transaksi 12
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(12, 'INV20250613012', 40000.00, 50000.00, 10000.00, 'Cash', 2, 6);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(12, 13, 1, 19000.00, 19000.00),
(12, 17, 1, 21000.00, 21000.00);

-- Transaksi 13
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(13, 'INV20250614013', 28000.00, 30000.00, 2000.00, 'Cash', 3, NULL);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(13, 12, 1, 28000.00, 28000.00);

-- Transaksi 14
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(14, 'INV20250614014', 10500.00, 10500.00, 0.00, 'QRIS', 2, 9);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(14, 6, 3, 3500.00, 10500.00);

-- Transaksi 15
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(15, 'INV20250614015', 30000.00, 30000.00, 0.00, 'Debit', 3, 1);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(15, 20, 2, 15000.00, 30000.00);

-- Transaksi 16
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(16, 'INV20250615016', 36000.00, 40000.00, 4000.00, 'Cash', 2, NULL);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(16, 16, 12, 3000.00, 36000.00);

-- Transaksi 17
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(17, 'INV20250615017', 24000.00, 24000.00, 0.00, 'QRIS', 3, 5);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(17, 10, 2, 12000.00, 24000.00);

-- Transaksi 18
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(18, 'INV20250615018', 136000.00, 136000.00, 0.00, 'Credit', 2, 8);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(18, 15, 2, 68000.00, 136000.00);

-- Transaksi 19
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(19, 'INV20250615019', 42000.00, 50000.00, 8000.00, 'Cash', 3, NULL);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(19, 14, 1, 42000.00, 42000.00);

-- Transaksi 20
INSERT INTO `penjualan` (`id_penjualan`, `nomor_invoice`, `total_bayar`, `jumlah_bayar`, `kembalian`, `tipe_pembayaran`, `id_kasir`, `id_pelanggan`) VALUES
(20, 'INV20250615020', 104000.00, 104000.00, 0.00, 'Debit', 2, 2);
INSERT INTO `detail_penjualan` (`id_penjualan`, `id_produk`, `jumlah_beli`, `harga_saat_ini`, `subtotal`) VALUES
(20, 8, 2, 22000.00, 44000.00),
(20, 7, 1, 18000.00, 18000.00),
(20, 14, 1, 42000.00, 42000.00);

