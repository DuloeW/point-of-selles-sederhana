<?php

date_default_timezone_set('Asia/Makassar');

function getFormattedDateAndDay() {
    $hari = date('l');
    $tanggal = date('d');
    $bulan = date('F');
    $tahun = date('Y');
    $formattedDate = "$hari, $tanggal $bulan $tahun";

    return $formattedDate;
}

function getFormattedDate() {
    $hari = date('d');
    $bulan = date('m');
    $tahun = date('Y');
    $formattedDate = "$hari/$bulan/$tahun";

    return $formattedDate;
}

function getFormattedTime() {
    return date('H.i');
}

function cariProdukByKode($kode_produk) {
    global $koneksi;
    $kode_produk = mysqli_real_escape_string($koneksi, $kode_produk);
    $query = "SELECT * FROM produk WHERE kode_produk = '$kode_produk'";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result) : null;
}


?>