<?php 

include '../auth/koneksi.php';

function getTotalPelanggan() {
    global $koneksi;
    $query = "SELECT COUNT(*) as total FROM pelanggan";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result)['total'] : 0;
}

function tambahMemberBaru($nama, $telepon, $email, $alamat, $level) {
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



function tentukanLevelMember($poin) {
    if ($poin >= 1000) return 'Gold';
    if ($poin >= 500) return 'Silver';
    return 'Bronze';
}
?>