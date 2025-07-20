<?php

require_once '../auth/koneksi.php';

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

function getDetailPenjualanByInvoice($invoice)
{
    global $koneksi;
    $query = "
        SELECT 
            p.nama_produk,
            dp.harga_saat_ini AS harga_satuan,
            dp.jumlah_beli,
            dp.subtotal,
            CASE
                WHEN m.level_member IS NOT NULL THEN 
                    dp.subtotal * (dm.persentase_diskon / 100)
                ELSE 0
            END AS diskon,
            CASE
                WHEN m.level_member IS NOT NULL THEN 
                    dp.subtotal - (dp.subtotal * (dm.persentase_diskon / 100))
                ELSE dp.subtotal
            END AS total_setelah_diskon
        FROM detail_penjualan dp
        JOIN produk p ON dp.id_produk = p.id_produk
        JOIN penjualan pj ON dp.id_penjualan = pj.id_penjualan
        LEFT JOIN pelanggan pl ON pj.id_pelanggan = pl.id_pelanggan
        LEFT JOIN member m ON pl.id_pelanggan = m.id_pelanggan
        LEFT JOIN diskon_member dm ON m.level_member = dm.level_member
        WHERE pj.nomor_invoice = '$invoice';";

    return mysqli_query($koneksi, $query);
}
