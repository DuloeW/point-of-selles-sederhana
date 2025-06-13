<?php 

include '../auth/koneksi.php';

function getTotalPelanggan() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM pelanggan";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

?>