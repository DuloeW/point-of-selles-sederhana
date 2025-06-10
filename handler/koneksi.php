<?php 

$koneksi = mysqli_connect("localhost", "root", "", "point_of_sales");

if(mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error(); 
}

?>