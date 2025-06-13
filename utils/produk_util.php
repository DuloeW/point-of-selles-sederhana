<?php 

include '../auth/koneksi.php';

function getTotalPruduk() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM produk";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

function getProdukHampirHabis() {
    global $koneksi;
    $query = "SELECT nama_produk, kategori, stok FROM produk WHERE stok <= 20 ORDER BY stok ASC LIMIT 5";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}




?>