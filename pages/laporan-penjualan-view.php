<?php
// Authentication middleware - must be at the top
require_once '../middleware/auth_middleware.php';
requireAuth(['admin']); // Only admin can access sales reports

require '../handler/penjualan_handler.php'; // handler logika
require '../utils/penjualan_util.php'; // fungsi data penjualan
require '../utils/tools_util.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Laporan Penjualan</title>
  <link rel="stylesheet" href="../assets/output.css">
  <link rel="icon" type="image/png" href="../assets/d-logo.png">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body class="flex bg-gray-100">
  <?php $active = 3;
  include '../components/sidebar.php'; ?>
  <div class="flex-1 flex flex-col h-screen">
    <!-- Header -->
    <?php
    $title = "Laporan Penjualan";
    include '../components/header-page.php'
    ?>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col space-y-6 w-full p-5 overflow-y-scroll">

      <!-- Kartu Informasi -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php
        $laporanData = getDataForInformationLaporanPenjualan();

        foreach ($laporanData as $data) {
          $title = $data['title'];
          $value = $data['value'];
          $suffix = $data['suffix'] ?? '';
          $subtext = $data['subtext'] ?? '';
          $color = $data['color'];
          $icon = $data['icon'];

          include '../components/card-informasi.php';
        }
        ?>
      </div>

      <!-- Tabel Riwayat Transaksi -->
      <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold mb-4">Riwayat Transaksi Penjualan</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
              <tr>
                <th class="px-4 py-3">Invoice</th>
                <th class="px-4 py-3">Tanggal & Waktu</th>
                <th class="px-4 py-3">Kasir</th>
                <th class="px-4 py-3">Pelanggan</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Pembayaran</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php foreach (getRiwayatTransaksi() as $transaksi): ?>
                <tr>
                  <td class="px-4 py-3 text-blue-600 font-semibold"><?= $transaksi['nomor_invoice'] ?></td>
                  <td class="px-4 py-3"><?= date('d M Y, H.i', strtotime($transaksi['created_at'])) ?></td>
                  <td class="px-4 py-3"><?= $transaksi['nama_kasir'] ?></td>
                  <td class="px-4 py-3">
                    <?= !empty($transaksi['nama_pelanggan']) ? $transaksi['nama_pelanggan'] : 'Umum' ?>
                  </td>
                  <td class="px-4 py-3 text-green-600 font-semibold">Rp <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?></td>
                  <td class="px-4 py-3">
                    <?php if ($transaksi['tipe_pembayaran'] === 'Cash'): ?>
                      <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Cash</span>
                    <?php elseif ($transaksi['tipe_pembayaran'] === 'QRIS'): ?>
                      <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-semibold">QRIS</span>
                    <?php else: ?>
                      <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold"><?= $transaksi['tipe_pembayaran'] ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-3">
                    <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs font-semibold"><?= $transaksi['status_penjualan'] === 'Completed' ? 'Selesai' : 'Pending' ?></span>
                  </td>
                  <td class="px-4 py-3">
                    <a href="detail-penjualan-view.php?invoice=<?= $transaksi['nomor_invoice'] ?>" class="text-grey-300 hover:underline text-sm">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
  <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
</body>

</html>