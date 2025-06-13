<?php

include '../auth/koneksi.php';

function getTransaksiHariIni()
{
    global $koneksi;
    $query = "
    SELECT 
        dp.*, 
        p.tanggal_penjualan,
        p.status_penjualan
    FROM 
        detail_penjualan dp
    JOIN 
        penjualan p ON dp.id_penjualan = p.id_penjualan
    WHERE
        DATE(p.tanggal_penjualan) = CURDATE()
    ORDER BY
        p.tanggal_penjualan DESC
    LIMIT 5
    ";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}
