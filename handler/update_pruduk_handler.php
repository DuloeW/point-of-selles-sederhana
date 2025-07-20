<?php
require_once '../auth/koneksi.php';
require_once '../utils/tools_util.php';

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/kelola-produk-view.php");
    exit();
}

// Validate required fields
$required_fields = ['id_produk', 'kode_produk', 'nama_produk', 'deskripsi', 'harga_jual', 'stok', 'satuan', 'kategori', 'tanggal_dibuat', 'tanggal_diperbarui'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo "<script>alert('Field $field harus diisi!');history.back();</script>";
        exit();
    }
}

// Sanitize input data
$id_produk = intval($_POST['id_produk']);
$kode_produk = trim($_POST['kode_produk']);
$nama_produk = trim($_POST['nama_produk']);
$deskripsi = trim($_POST['deskripsi']);
$harga_jual = floatval($_POST['harga_jual']);
$stok = intval($_POST['stok']);
$satuan = trim($_POST['satuan']);
$kategori = trim($_POST['kategori']);
$status_produk = isset($_POST['status_produk']) ? trim($_POST['status_produk']) : 'Aktif';
$tanggal_dibuat = $_POST['tanggal_dibuat'];
$tanggal_diperbarui = $_POST['tanggal_diperbarui'];
$foto_produk_lama = $_POST['foto_produk_lama'];

// Validate numeric values
if ($harga_jual <= 0) {
    echo "<script>alert('Harga jual harus lebih dari 0!');history.back();</script>";
    exit();
}

if ($stok < 0) {
    echo "<script>alert('Stok tidak boleh negatif!');history.back();</script>";
    exit();
}

// Handle file upload
$foto_produk = $foto_produk_lama; // Default to old photo

if (isset($_FILES['foto_produk']) && $_FILES['foto_produk']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/';
    
    // Create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_tmp = $_FILES['foto_produk']['tmp_name'];
    $file_name = $_FILES['foto_produk']['name'];
    $file_size = $_FILES['foto_produk']['size'];
    $file_type = $_FILES['foto_produk']['type'];
    
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($file_type, $allowed_types)) {
        echo "<script>alert('Format file tidak didukung! Gunakan JPG, JPEG, PNG, atau GIF.');history.back();</script>";
        exit();
    }
    
    // Validate file size (max 2MB)
    if ($file_size > 2 * 1024 * 1024) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.');history.back();</script>";
        exit();
    }
    
    // Generate unique filename
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_filename = time() . '_' . uniqid() . '.' . $file_extension;
    $upload_path = $upload_dir . $new_filename;
    
    // Move uploaded file
    if (move_uploaded_file($file_tmp, $upload_path)) {
        // Delete old photo if it exists and is different from new one
        if (!empty($foto_produk_lama) && file_exists($upload_dir . $foto_produk_lama)) {
            unlink($upload_dir . $foto_produk_lama);
        }
        $foto_produk = $new_filename;
    } else {
        echo "<script>alert('Gagal mengupload file!');history.back();</script>";
        exit();
    }
}

// Check if product code already exists (excluding current product)
$check_kode = $koneksi->prepare("SELECT id_produk FROM produk WHERE kode_produk = ? AND id_produk != ?");
$check_kode->bind_param("si", $kode_produk, $id_produk);
$check_kode->execute();
$result = $check_kode->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Kode produk sudah digunakan!');history.back();</script>";
    exit();
}

// Update product data using prepared statement
$stmt = $koneksi->prepare("UPDATE produk SET 
    kode_produk = ?, 
    nama_produk = ?, 
    deskripsi = ?, 
    harga_jual = ?, 
    stok = ?, 
    satuan = ?, 
    kategori = ?, 
    status_produk = ?,
    foto_produk = ?, 
    tanggal_dibuat = ?, 
    tanggal_diperbarui = ? 
    WHERE id_produk = ?");

$stmt->bind_param("sssdissssssi", 
    $kode_produk, 
    $nama_produk, 
    $deskripsi, 
    $harga_jual, 
    $stok, 
    $satuan, 
    $kategori, 
    $status_produk,
    $foto_produk, 
    $tanggal_dibuat, 
    $tanggal_diperbarui, 
    $id_produk
);

if ($stmt->execute()) {
    echo "<script>alert('Produk berhasil diperbarui!');window.location='../pages/kelola-produk-view.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui produk: " . $stmt->error . "');history.back();</script>";
}

$stmt->close();
$koneksi->close();
?>