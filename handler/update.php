<?php
include 'koneksi.php';

$id_produk = $_POST["id_produk"];
$kode_produk = $_POST["kode_produk"];
$nama_produk = $_POST["nama_produk"];
$deskripsi = $_POST["deskripsi"];
$harga_jual = $_POST["harga_jual"];
$stok = $_POST["stok"];
$satuan = $_POST["satuan"];
$kategori = $_POST["kategori"];
$foto_produk = $_POST["foto_produk"];
$tanggal_dibuat = $_POST["tanggal_dibuat"];
$tanggal_diperbarui = $_POST["tanggal_diperbarui"];

mysqli_query($koneksi, "UPDATE produk SET 
    kode_produk='$kode_produk', 
    nama_produk='$nama_produk', 
    deskripsi='$deskripsi', 
    harga_jual='$harga_jual', 
    stok='$stok', 
    satuan='$satuan', 
    kategori='$kategori', 
    foto_produk='$foto_produk', 
    tanggal_dibuat='$tanggal_dibuat', 
    tanggal_diperbarui='$tanggal_diperbarui' 
    WHERE id_produk='$id_produk'");

header("location:listproduk.php");
?>