<?php 
include '../auth/koneksi.php';


$kode_produk = $_POST["kode_produk"];
$nama_produk = $_POST["nama_produk"];
$deskripsi = $_POST["deskripsi"];
$harga_jual = $_POST["harga_jual"];
$stok = $_POST["stok"];
$satuan = $_POST["satuan"];
$kategori = $_POST["kategori"];
$tanggal_dibuat = $_POST["tanggal_dibuat"];
$tanggal_diperbarui = $_POST["tanggal_diperbarui"];

// Proses upload file
$target_dir = "../uploads/";
$foto_produk = "";

// Cek apakah direktori uploads ada, jika tidak, buat direktori
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Periksa apakah file foto diupload
if(isset($_FILES["foto_produk"]) && $_FILES["foto_produk"]["error"] == 0) {
    $allowed_types = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
    $file_name = $_FILES["foto_produk"]["name"];
    $file_size = $_FILES["foto_produk"]["size"];
    $file_tmp = $_FILES["foto_produk"]["tmp_name"];
    $file_type = $_FILES["foto_produk"]["type"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validasi tipe file
    if(in_array($file_type, $allowed_types)) {
        // Validasi ukuran file (max 2MB)
        if($file_size <= 2097152) {
            // Buat nama file baru untuk menghindari duplikasi
            $new_file_name = time() . "_" . $kode_produk . "." . $file_ext;
            $target_file = $target_dir . $new_file_name;
            
            // Upload file
            if(move_uploaded_file($file_tmp, $target_file)) {
                $foto_produk = $new_file_name;
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file.";
                exit;
            }
        } else {
            echo "Ukuran file terlalu besar. Maksimal 2MB.";
            exit;
        }
    } else {
        echo "Hanya file JPG, JPEG, dan PNG yang diperbolehkan.";
        exit;
    }
}

// Simpan data ke database
mysqli_query($koneksi, "INSERT INTO produk (kode_produk, nama_produk, deskripsi, harga_jual, stok, satuan, kategori, foto_produk, tanggal_dibuat, tanggal_diperbarui) VALUES ('$kode_produk', '$nama_produk', '$deskripsi', '$harga_jual', '$stok', '$satuan', '$kategori', '$foto_produk', '$tanggal_dibuat', '$tanggal_diperbarui')");

header("location:../pages/list-produk-view.php");


?>