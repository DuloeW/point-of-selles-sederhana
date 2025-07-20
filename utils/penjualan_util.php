<?php 

require_once '../auth/koneksi.php';

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
    $row = $result ? mysqli_fetch_assoc($result) : null;

    return $row && $row['rata_rata'] !== null ? (float)$row['rata_rata'] : 0;
}

function getRiwayatTransaksi() {
  global $koneksi;
  $sql = "SELECT p.id_penjualan, p.nomor_invoice, p.total_bayar, p.tipe_pembayaran, p.status_penjualan, 
          pg.nama_lengkap AS nama_kasir, pl.nama_lengkap AS nama_pelanggan, p.created_at
          FROM penjualan p
          LEFT JOIN pengguna pg ON pg.id_pengguna = p.id_kasir
          LEFT JOIN pelanggan pl ON pl.id_pelanggan = p.id_pelanggan
          ORDER BY p.created_at DESC";
  $result = mysqli_query($koneksi, $sql);
  $data = [];
  while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
  }
  return $data;
}


function getTotalPenjualan() {
  global $koneksi;
  $q = mysqli_query($koneksi, "SELECT SUM(total_bayar) as total FROM penjualan");
  return mysqli_fetch_assoc($q)['total'] ?? 0;
}

function getTotalPenjualanHariIni() {
  global $koneksi;
  $today = date('Y-m-d');
  $q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM penjualan WHERE DATE(created_at) = '$today'");
  return mysqli_fetch_assoc($q)['total'];
}

function getTotalTransaksi() {
  global $koneksi;
  $q = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM penjualan");
  return mysqli_fetch_assoc($q)['total'];
}
  ?>