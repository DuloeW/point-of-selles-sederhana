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

function getProdukById($id) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

?>