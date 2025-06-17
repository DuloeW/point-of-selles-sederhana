<?php

include '../auth/koneksi.php';

function getKeranjang() {
    global $koneksi;
    $query = "SELECT SUM(jumlah) AS total_item_keranjang FROM keranjang";
    $result = mysqli_query($koneksi, $query);
    $data = $result ? mysqli_fetch_assoc($result) : ['total_item_keranjang' => 0];
    return $data['total_item_keranjang'] ?? 0;
}
