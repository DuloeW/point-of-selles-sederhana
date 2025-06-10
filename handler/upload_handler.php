<?php
session_start(); // Mulai session untuk menyimpan pesan

// --- FUNGSI PEMBANTU ---

/**
 * Fungsi untuk menampilkan pesan status ke pengguna melalui session.
 * @param string $message Pesan yang akan ditampilkan.
 * @param string $type Tipe pesan (success, error, info).
 */
function display_message($message, $type = 'info') {
    $_SESSION['upload_message'] = $message;
    $_SESSION['upload_type'] = $type;
    header("Location: upload_form.php"); // Redirect kembali ke form
    exit;
}

/**
 * Fungsi untuk memvalidasi file yang diupload.
 * @param array $file_data Data file dari $_FILES.
 * @param string $target_file Path tujuan lengkap.
 * @param array $allowed_types Array ekstensi yang diizinkan.
 * @param int $max_size Ukuran maksimum file dalam bytes.
 * @return bool True jika valid, false jika tidak.
 */
function validate_upload($file_data, $target_file, $allowed_types, $max_size) {
    // Cek apakah file benar-benar diupload
    if (!isset($file_data) || $file_data['error'] !== UPLOAD_ERR_OK) {
        display_message("Terjadi kesalahan saat mengunggah file. Kode error: " . $file_data['error'], 'error');
        return false;
    }

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar asli atau palsu
    $check = getimagesize($file_data["tmp_name"]);
    if($check === false) {
        display_message("File yang diupload bukan gambar yang valid.", 'error');
        return false;
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        display_message("Maaf, file dengan nama yang sama sudah ada. Ganti nama file Anda atau hapus yang lama.", 'error');
        return false;
    }

    // Cek ukuran file
    if ($file_data["size"] > $max_size) {
        display_message("Maaf, ukuran file terlalu besar. Maksimal " . ($max_size / (1024 * 1024)) . "MB.", 'error');
        return false;
    }

    // Izinkan format file tertentu
    if (!in_array($imageFileType, $allowed_types)) {
        display_message("Maaf, hanya file " . implode(", ", array_map('strtoupper', $allowed_types)) . " yang diizinkan.", 'error');
        return false;
    }

    return true; // Semua validasi lolos
}

// --- LOGIKA UTAMA UPLOAD ---

// Pastikan form di-submit
if (!isset($_POST["submit"])) {
    display_message("Akses tidak sah.", 'error');
}

// Tentukan direktori tujuan upload
// SESUAIKAN PATH INI DENGAN LOKASI DIREKTORI htdocs ANDA atau sub-direktori di dalamnya
$target_dir = __DIR__ . "/uploads/"; // Membuat folder 'uploads' di dalam folder skrip ini

// Buat direktori 'uploads' jika belum ada
if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0755, true)) { // Gunakan 0755 untuk izin yang lebih aman
        display_message("Gagal membuat direktori upload. Periksa izin folder server.", 'error');
    }
}

// Data file yang diupload
$file_data = $_FILES["foto_produk"];
$target_file = $target_dir . basename($file_data["name"]);

// Konfigurasi validasi
$allowed_types = ["jpg", "jpeg", "png"];
$max_file_size = 2 * 1024 * 1024; // 2 MB

// Lakukan validasi menggunakan fungsi pembantu
if (!validate_upload($file_data, $target_file, $allowed_types, $max_file_size)) {
    // Fungsi validate_upload sudah mengarahkan kembali (redirect) dan menampilkan pesan jika validasi gagal
    exit;
}

// Jika validasi sukses, coba pindahkan file
if (move_uploaded_file($file_data["tmp_name"], $target_file)) {
    display_message("File " . htmlspecialchars(basename($file_data["name"])) . " berhasil diupload!", 'success');
} else {
    // Tangkap error jika move_uploaded_file gagal (misal: izin tulis)
    display_message("Maaf, terjadi kesalahan saat memindahkan file Anda. Periksa izin folder server.", 'error');
}


?>
