<?php
require '../handler/dashboard_handler.php';
require '../utils/produk_util.php';
require '../utils/penjualan_util.php';
require '../utils/detail_penjualan_util.php';
require '../utils/pengguna_util.php';
require '../utils/pelanggan_util.php';
require '../utils/tools_util.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasboard</title>
    <link rel="stylesheet" href="../assets/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="flex w-full h-screen bg-gray-100">
    <?php
        $active = 1; // Set active menu item for Dasboard
        include '../components/sidebar.php'
    ?>
    <div class="flex-1 flex flex-col gap-3">
        <div class="w-full h-16 p-3 pl-5 bg-white flex items-center justify-between shadow-md shadow-gray-200">
            <!-- header -->
            <p class="font-bold text-xl text-purple-700">Dashboard</p>
            <div class="text-neutral-600 text-right mr-3">
                <p class="font-bold">Admin: <span>Mujianto</span></p>
                <p class="text-xs text-gray-500 font-semibold tracking-wider"><?= getFormattedDate() ?></p>
            </div>
        </div>

        <!-- containner main content -->
        <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">

            <!-- TODO get admin belum dinamis -->
            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 rounded-2xl p-6 text-white shadow-md shadow-gray-300 flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">Selamat Datang, Mujianto!</p>
                    <p class="text-blue-100">Dashboard Admin - <?= getFormattedDateAndDay() ?></p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold"><?= getFormattedTime() ?></p>
                    <p class="text-blue-100">Waktu Sekarang</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <?php
                $dashboardData = [
                    [
                        'title' => 'Transaksi Hari Ini',
                        'value' => getTotalDataTransaksiHariIni(),
                        'suffix' => 'Transaksi',
                        'color' => 'blue',
                        'icon' => 'fa-regular fa-calendar-check' // Ganti sesuai icon yang kamu pakai
                    ],
                    [
                        'title' => 'Pendapatan Hari Ini',
                        'value' => 'Rp ' . getPendapatanHariIni(),
                        'subtext' => 'Rp ' . getPendapatanHariIni(),
                        'color' => 'green',
                        'icon' => 'fa-solid fa-money-bill-wave'
                    ],
                    [
                        'title' => 'Rata-rata Transaksi',
                        'value' => 'Rp ' . number_format(getRataRataTransaksi(), 0, ',', '.'),
                        'suffix' => 'Per transaksi',
                        'color' => 'purple',
                        'icon' => 'fa-solid fa-money-bill-wave'
                    ]
                ];

                foreach ($dashboardData as $data) {
                    $title = $data['title'];
                    $value = $data['value'];
                    $suffix = isset($data['suffix']) ? $data['suffix'] : '';
                    $subtext = isset($data['subtext']) ? $data['subtext'] : '';
                    $color = $data['color'];
                    $icon = $data['icon'];

                    include '../components/card-informasi.php';
                }
                ?>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Transaksi Terbaru -->
                <div class="bg-white rounded-xl p-6 shadow-md lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-green-600  rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-arrow-trend-up text-white text-sm"></i>
                            </div>
                            <h3 class="text-2xl font-semibold leading-none tracking-tight text-gray-800">Transaksi Terbaru</h3>
                        </div>
                        <button class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-lg border flex items-center gap-3 text-sm">
                            Lihat Semua <i class="fa-solid fa-arrow-right -rotate-45"></i>
                        </button>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">Penjualan hari ini</p>

                    <!-- Transaksi List -->
                    <div class="space-y-3">
                        <!-- Transaksi 1 -->
                        <?php
                        $transaksiHariIni = getTransaksiHariIni();
                        if (empty($transaksiHariIni)) {
                            echo '<p class="text-gray-500 text-center text-sm">Tidak ada transaksi hari ini.</p>';
                        } else {
                            foreach ($transaksiHariIni as $transaksi) {
                                $username = $transaksi['nama_lengkap'];
                                $nomor_invoice = $transaksi['nomor_invoice'];
                                $jumlah_beli = $transaksi['jumlah_beli'];
                                $subtotal = $transaksi['subtotal'];
                                $status_penjualan = $transaksi['status_penjualan'];
                                include '../components/card-transaksi-hari-ini.php';
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Peringatan Stok -->
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-triangle-exclamation text-white text-sm"></i>
                        </div>
                        <h3 class="text-2xl font-semibold leading-none tracking-tight text-gray-800">Peringatan Stok</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">Produk yang perlu direstok</p>

                    <!-- Stok Warning List -->
                    <div class="space-y-3">
                        <!-- Item 1 -->
                        <?php
                        $produkHampirHabis = getProdukHampirHabis();
                        if (empty($produkHampirHabis)) {
                            echo '<p class="text-gray-500 text-center text-sm">Tidak ada produk yang hampir habis.</p>';
                        } else {
                            foreach ($produkHampirHabis as $produk) {
                                $nama_produk = $produk['nama_produk'];
                                $kategori = $produk['kategori'];
                                $stok = $produk['stok'];
                                include '../components/card-produk-hampir-habis.php';
                            }
                        }
                        ?>

                    </div>

                    <!-- Restock Button -->
                    <button class="w-full mt-4 bg-gradient-to-br from-red-500 to-orange-600 hover:bg-red-600 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors">
                        <i class="fa-solid fa-box"></i>
                        Restock Sekarang
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-md flex flex-col">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-cubes-stacked text-2xl bg-gradient-to-br p-2 rounded-lg from-red-500 to-orange-700 text-white"></i>
                    <p class="text-3xl font-semibold">Ringkasan Sistem</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
                    <div class="flex flex-col justify-center items-center p-5">
                        <p class="text-4xl font-bold text-blue-700">
                            <?= getTotalPruduk() ?>
                        </p>
                        <p class="text-lg font-semibold text-gray-500">Total Produk</p>
                    </div>
                    <div class="flex flex-col justify-center items-center p-5">
                        <p class="text-4xl font-bold text-purple-700"><?= getTotalPelanggan() ?></p>
                        <p class="text-lg font-semibold text-gray-500">Total Pelanggan</p>
                    </div>
                    <div class="flex flex-col justify-center items-center p-5">
                        <p class="text-4xl font-bold text-green-600"><?= getTotalPenggunaAktif() ?></p>
                        <p class="text-lg font-semibold text-gray-500">Pengguna Aktif</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>