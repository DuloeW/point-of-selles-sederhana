<?php
require_once '../auth/koneksi.php';

$id_produk=$_GET['id_produk'];

mysqli_query($koneksi, "delete from produk where id_produk='$id_produk'");

header("location:../pages/list-produk-view.php");
?>