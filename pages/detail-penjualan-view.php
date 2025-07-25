<?php
// Authentication middleware - must be at the top
require_once '../middleware/auth_middleware.php';
requireAuth(['admin']); // Only admin can access sales details

require_once '../utils/detail_penjualan_util.php';

$invoice = $_GET['invoice'] ?? '';

$result = getDetailPenjualanByInvoice($invoice);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Penjualan</title>
  <link rel="icon" type="image/png" href="../assets/d-logo.png">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

  <div class="min-h-screen flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-lg overflow-hidden">
      <div class="bg-gradient-to-r from-purple-700 to-purple-500 p-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Detail Penjualan</h1>
        <div class="text-white font-semibold"><?= $invoice ?></div>
      </div>

      <div class="p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2 font-semibold text-gray-700">Nama Produk</th>
              <th class="px-4 py-2 font-semibold text-gray-700">Harga Satuan</th>
              <th class="px-4 py-2 font-semibold text-gray-700">Jumlah Beli</th>
              <th class="px-4 py-2 font-semibold text-gray-700">Subtotal</th>
              <th class="px-4 py-2 font-semibold text-gray-700">Diskon</th>
              <th class="px-4 py-2 font-semibold text-gray-700">Total Akhir</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
              <tr>
                <td class="px-4 py-2"><?= htmlspecialchars($row['nama_produk']) ?></td>
                <td class="px-4 py-2">Rp <?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                <td class="px-4 py-2"><?= $row['jumlah_beli'] ?></td>
                <td class="px-4 py-2">Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                <td class="px-4 py-2 text-red-600">Rp <?= number_format($row['diskon'], 0, ',', '.') ?></td>
                <td class="px-4 py-2 font-semibold text-green-700">Rp <?= number_format($row['total_setelah_diskon'], 0, ',', '.') ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <div class="px-6 pb-6">
        <a href="laporan-penjualan-view.php" class="inline-block mt-4 bg-red-600 text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-red-700">
          Kembali
        </a>
      </div>
    </div>
  </div>
  <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
</body>

</html>