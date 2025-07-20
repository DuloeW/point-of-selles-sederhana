<?php 

require_once '../auth/koneksi.php';

function getTotalPenggunaAktif() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM pengguna WHERE status = 'Active'";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

?>