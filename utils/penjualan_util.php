<?php 

include '../auth/koneksi.php';

function getTotalDataTransaksiHariIni() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM penjualan WHERE DATE(tanggal_penjualan) = CURDATE()";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

// function getTransaksiHariIni() {
//     global $koneksi;
//     $query = "SELECT * FROM penjualan WHERE DATE(tanggal_penjualan) = CURDATE() ORDER BY tanggal_penjualan DESC LIMIT 5";
//     $result = mysqli_query($koneksi, $query);
//     return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
// }

function getPendapatanHariIni() {
    global $koneksi;
    $query = "SELECT SUM(total_bayar) as total FROM penjualan WHERE DATE(tanggal_penjualan) = CURDATE()";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

function getRataRataTransaksi() {
    global $koneksi;
    $query = "SELECT AVG(total_bayar) as rata_rata FROM penjualan";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['rata_rata'] : 0;
}

?>