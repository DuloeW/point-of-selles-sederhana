<?php
require_once '../middleware/auth_middleware.php';
requireAuth(['admin', 'kasir']);

require '../auth/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    
    // Validate required fields
    if (empty($nama_lengkap) || empty($telepon)) {
        echo "<script>alert('Nama lengkap dan telepon wajib diisi!');window.history.back();</script>";
        exit;
    }
    
    // Check if phone number is unique (excluding current customer)
    $checkPhone = mysqli_query($koneksi, "SELECT id_pelanggan FROM pelanggan WHERE telepon = '$telepon' AND id_pelanggan != '$id_pelanggan'");
    if (mysqli_num_rows($checkPhone) > 0) {
        echo "<script>alert('Nomor telepon sudah digunakan pelanggan lain!');window.history.back();</script>";
        exit;
    }
    
    // Update pelanggan data
    $updatePelanggan = mysqli_query($koneksi, "UPDATE pelanggan SET 
        nama_lengkap = '$nama_lengkap',
        telepon = '$telepon',
        email = '$email',
        alamat = '$alamat'
        WHERE id_pelanggan = '$id_pelanggan'");
    
    if (!$updatePelanggan) {
        echo "<script>alert('Gagal mengupdate data pelanggan: " . mysqli_error($koneksi) . "');window.history.back();</script>";
        exit;
    }
    
    // Check if customer is already a member
    $checkMember = mysqli_query($koneksi, "SELECT id_member FROM member WHERE id_pelanggan = '$id_pelanggan'");
    $isMember = mysqli_num_rows($checkMember) > 0;
    
    if ($isMember) {
        // Update existing member data
        $level_member = $_POST['level_member'];
        $poin = $_POST['poin'];
        
        $updateMember = mysqli_query($koneksi, "UPDATE member SET 
            level_member = '$level_member',
            poin = '$poin'
            WHERE id_pelanggan = '$id_pelanggan'");
        
        if (!$updateMember) {
            echo "<script>alert('Gagal mengupdate data member: " . mysqli_error($koneksi) . "');window.history.back();</script>";
            exit;
        }
    } else {
        // Check if converting to member
        if (isset($_POST['convert_to_member']) && $_POST['convert_to_member'] == 'on') {
            $new_level_member = $_POST['new_level_member'];
            $new_poin = $_POST['new_poin'];
            
            $insertMember = mysqli_query($koneksi, "INSERT INTO member (id_pelanggan, level_member, poin) 
                VALUES ('$id_pelanggan', '$new_level_member', '$new_poin')");
            
            if (!$insertMember) {
                echo "<script>alert('Gagal menambahkan member baru: " . mysqli_error($koneksi) . "');window.history.back();</script>";
                exit;
            }
        }
    }
    
    echo "<script>alert('Data pelanggan berhasil diupdate!');window.location='../pages/pelanggan-view.php';</script>";
} else {
    echo "<script>alert('Metode request tidak valid!');window.location='../pages/pelanggan-view.php';</script>";
}
?>
