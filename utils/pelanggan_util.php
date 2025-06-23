<?php

include '../auth/koneksi.php';

function getTotalPelanggan()
{
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM pelanggan";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

function tambahMemberBaru($nama, $telepon, $email, $alamat, $level)
{
    global $koneksi;

    $insert = mysqli_query($koneksi, "INSERT INTO pelanggan (nama_lengkap, telepon, alamat, email)
                                      VALUES ('$nama', '$telepon', '$alamat', '$email')");
    if (!$insert) return ['success' => false, 'message' => mysqli_error($koneksi)];

    $id_pelanggan = mysqli_insert_id($koneksi);

    $poin_awal = 0;
    if ($level === 'Silver') $poin_awal = 500;
    elseif ($level === 'Gold') $poin_awal = 1000;

    $insertMember = mysqli_query($koneksi, "INSERT INTO member (id_pelanggan, level_member, poin)
                                            VALUES ($id_pelanggan, '$level', $poin_awal)");
    if (!$insertMember) return ['success' => false, 'message' => mysqli_error($koneksi)];

    return ['success' => true];
}



function tentukanLevelMember($poin)
{
    if ($poin >= 1000) return 'Gold';
    if ($poin >= 500) return 'Silver';
    return 'Bronze';
}

function totalAkhir()
{
    global $koneksi;
    session_start(); // Wajib ada jika belum dipanggil sebelumnya

    $subtotal = 0;
    $id_pelanggan = $_SESSION['id_pelanggan'] ?? 'umum';

    // Hitung subtotal dari keranjang
    $queryKeranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_pelanggan = '$id_pelanggan'");
    while ($row = mysqli_fetch_assoc($queryKeranjang)) {
        $subtotal += $row['jumlah'] * $row['harga'];
    }

    // Hitung diskon jika pelanggan adalah member
    $diskonPersen = 0;
    if ($id_pelanggan !== 'umum') {
        $query = mysqli_query($koneksi, "SELECT m.level_member, d.persentase_diskon
                                         FROM member m
                                         JOIN diskon_member d ON m.level_member = d.level_member
                                         WHERE m.id_pelanggan = $id_pelanggan");

        if ($row = mysqli_fetch_assoc($query)) {
            $diskonPersen = (float)$row['persentase_diskon'];
        }
    }

    $diskon = $subtotal * ($diskonPersen / 100);
    $totalAkhir = $subtotal - $diskon;

    return $totalAkhir;
}

function getPelangganByNomorHp($keyword)
{
    global $koneksi;

    if ($keyword !== '') {
        $keyword = mysqli_real_escape_string($koneksi, $keyword);
        $query = "SELECT p.nama_lengkap, p.telepon, p.alamat, p.email, m.poin 
              FROM pelanggan p
              LEFT JOIN member m ON p.id_pelanggan = m.id_pelanggan
              WHERE p.telepon LIKE '%$keyword%'";
    } else {
        $query = "SELECT p.nama_lengkap, p.telepon, p.alamat, p.email, m.poin 
              FROM pelanggan p
              LEFT JOIN member m ON p.id_pelanggan = m.id_pelanggan";
    }

    return mysqli_query($koneksi, $query);
}
