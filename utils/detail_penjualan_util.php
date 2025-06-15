<?php

include '../auth/koneksi.php';

function getTransaksiHariIni()
{
    global $koneksi;
    $query = "
    SELECT
        p.id_penjualan,
        p.nomor_invoice,
        p.tanggal_penjualan,
        p.status_penjualan,
        p.total_bayar,
        COALESCE(pl.nama_lengkap, 'Pelanggan Umum') as nama_lengkap
    FROM 
        penjualan p
    LEFT JOIN 
        pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
    LEFT JOIN 
        detail_penjualan dp ON p.id_penjualan = dp.id_penjualan
    WHERE
        DATE(p.tanggal_penjualan) = CURDATE()
    GROUP BY
        p.id_penjualan, p.nomor_invoice, p.tanggal_penjualan, 
        p.status_penjualan, p.total_bayar, pl.nama_lengkap
    ORDER BY
        p.tanggal_penjualan DESC
    LIMIT 5
    ";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}
