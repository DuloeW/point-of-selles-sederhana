<?php 

include '../auth/koneksi.php';

function getTotalPruduk() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM produk";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

function getProdukAktifHampirHabis() {
    global $koneksi;
    $query = "SELECT * FROM produk WHERE stok <= 5 AND status_produk = 'Aktif' ORDER BY nama_produk ASC";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}

function getTotalProdukHampirHabis() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM produk WHERE stok <= 20 AND stok <> 0 AND status_produk = 'Aktif'";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

function filterProdukByKategori($kategori) {
    global $koneksi;
    $kategori = mysqli_real_escape_string($koneksi, $kategori);

    if ($kategori === 'Semua') {
        $query = "SELECT * FROM produk ORDER BY nama_produk ASC";
    } else {
        $query = "SELECT * FROM produk WHERE kategori = '$kategori' ORDER BY nama_produk ASC";
    }

    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}

function filterProdukByKategoriAndKodeProduk($kategori, $kode_produk) {
    global $koneksi;
    $kategori = mysqli_real_escape_string($koneksi, $kategori);
    $kode_produk = mysqli_real_escape_string($koneksi, $kode_produk);

    if ($kategori === 'Semua') {
        $query = "SELECT * FROM produk WHERE kode_produk LIKE '%$kode_produk%' ORDER BY nama_produk ASC";
    } else {
        $query = "SELECT * FROM produk WHERE kategori = '$kategori' AND kode_produk LIKE '%$kode_produk%' ORDER BY nama_produk ASC";
    }

    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}

function getProdukById($id) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getAllKategoriProduk() {
    global $koneksi;
    $query = "SELECT DISTINCT kategori FROM produk ORDER BY kategori ASC";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}

function getTotalProdukHabis() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM produk WHERE stok = 0";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

function getTotalProdukAktif() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM produk WHERE status_produk = 'Aktif'";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}


?>