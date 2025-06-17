<?php 
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="flex bg-gray-100">
  <?php $active = 3; include '../components/sidebar.php'; ?>

  <div class="flex-1 flex flex-col">
    <!-- Header -->
   <div class="w-full h-16 p-3 pl-5 bg-white flex items-center justify-between shadow-md shadow-gray-200">
            <!-- header -->
            <p class="font-bold text-xl text-purple-700">Laporan Penjualan</p>
            <div class="text-neutral-600 text-right mr-3">
                <p class="font-bold">Admin: <span>Mujianto</span></p>
                <p class="text-xs text-gray-500 font-semibold tracking-wider"><?= getFormattedDate() ?></p>
            </div>
        </div>

    <!-- Konten Utama -->
    <main class="flex-1 p-6 space-y-6 overflow-y-auto">
      
      <!-- Kartu Informasi -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php
          $dashboardData = [
            [
              'title' => 'Total Transaksi',
              'value' => getTotalTransaksi(),
              'suffix' => 'Transaksi',
              'color' => 'blue',
              'icon' => 'fa-solid fa-file-invoice'
            ],
            [
              'title' => 'Total Penjualan',
              'value' => 'Rp ' . number_format(getTotalPenjualan(), 0, ',', '.'),
              'color' => 'green',
              'icon' => 'fa-solid fa-coins'
            ],
            [
              'title' => 'Rata-rata Transaksi',
              'value' => 'Rp ' . number_format(getRataRataTransaksi(), 0, ',', '.'),
              'color' => 'purple',
              'icon' => 'fa-solid fa-chart-line'
            ],
            [
              'title' => 'Penjualan Hari Ini',
              'value' => getTotalPenjualanHariIni() . ' Transaksi',
              'color' => 'orange',
              'icon' => 'fa-solid fa-calendar-day'
            ],
          ];

          foreach ($dashboardData as $data) {
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
                <td class="px-4 py-3"><?= $transaksi['nama_pelanggan'] ?></td>
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
                  <a href="detail-penjualan-view.php?invoice=<?= $transaksi['nomor_invoice'] ?>" class="hover:underline text-sm">
                    <i class="fa-solid fa-eye text-grey-300"></i>
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
</body>
</html>
