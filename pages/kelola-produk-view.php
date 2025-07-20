<?php
// Authentication middleware - must be at the top
require_once '../middleware/auth_middleware.php';
requireAuth(['admin']); // Only admin can access product management

require_once '../utils/tools_util.php';
require_once '../utils/produk_util.php';

$kategori_aktif = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';
$kode_produk = isset($_GET['kode_produk']) ? $_GET['kode_produk'] : '';

$produkList = filterProdukByKategoriAndKodeProduk($kategori_aktif, $kode_produk);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="../assets/output.css">
    <link rel="icon" type="image/png" href="../assets/d-logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="flex w-full h-screen bg-gray-100">
    <?php
    $active = 2; // Set active menu item for Kelola Produk
    include_once '../components/sidebar.php'
    ?>
    <div class="flex-1 flex flex-col">
        <?php
        $title = "Kelola Produk";
        include_once '../components/header-page.php'
        ?>

        <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">
            <div class="p-10 flex items-center justify-between bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl text-white shadow-md shadow-gray-300">
                <div class="text-purple-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-box-open text-2xl"></i>
                        <p class="font-bold text-4xl">Manajemen Produk</p>
                    </div>
                    <p class="mt-1 text-xl font-semibold text-purple-100">Kelola inventori dan produk toko</p>
                </div>
                <div>
                    <a href="tambah-produk-view.php">
                        <div class="flex items-center gap-5 px-5 py-3 rounded-lg bg-white text-purple-600">
                            <i class="fa-solid fa-plus"></i>
                            <p>Tambah Produk</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Product Statistics Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                <?php
                $dashboardData = [
                    [
                        'title' => 'Total Produk',
                        'value' => getTotalPruduk(),
                        'suffix' => 'Item berbeda',
                        'color' => 'blue',
                        'icon' => 'fa-solid fa-box' // Ganti sesuai icon yang kamu pakai
                    ],
                    [
                        'title' => 'Stok Habis',
                        'value' => getTotalProdukHabis(),
                        'suffix' => 'Perlu restock',
                        'color' => 'red',
                        'icon' => 'fa-solid fa-triangle-exclamation'
                    ],
                    [
                        'title' => 'Stok Sedikit',
                        'value' => getTotalProdukHampirHabis(),
                        'suffix' => '≤ 10 unit',
                        'color' => 'yellow',
                        'icon' => 'fa-solid fa-exclamation-triangle'
                    ],
                    [
                        'title' => 'Produk Aktif',
                        'value' => getTotalProdukAktif(),
                        'suffix' => 'Produk Aktif',
                        'color' => 'green',
                        'icon' => 'fa-solid fa-check'
                    ]
                ];

                foreach ($dashboardData as $data) {
                    $title = $data['title'];
                    $value = $data['value'];
                    $suffix = isset($data['suffix']) ? $data['suffix'] : '';
                    $color = $data['color'];
                    $icon = $data['icon'];

                    include '../components/card-informasi-kelola-produk.php';
                }

                ?>

            </div> <!-- Search and Filter Section -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-6">
                <form action="" method="GET">
                    <!-- Hidden input untuk mempertahankan kategori yang aktif -->
                    <?php if (isset($_GET['kategori']) && $_GET['kategori'] !== 'Semua'): ?>
                        <input type="hidden" name="kategori" value="<?= htmlspecialchars($_GET['kategori']) ?>">
                    <?php endif; ?>

                    <div class="flex flex-col lg:flex-row gap-4 items-center">
                        <!-- Search Bar -->
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-search text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                name="kode_produk"
                                value="<?= isset($_GET['kode_produk']) ? htmlspecialchars($_GET['kode_produk']) : '' ?>"
                                placeholder="Cari produk berdasarkan kode produk"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors">
                        </div>

                        <!-- Filter Button -->
                        <button type="submit" class="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-search text-gray-500"></i>
                            <span class="text-gray-600">Cari</span>
                        </button>
                    </div>
                </form> <!-- Category Filter Pills -->
                <?php
                // Ambil kategori aktif dari URL (misalnya ?kategori=Minuman)
                $kategori_aktif = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';

                $data = getAllKategoriProduk(); // Ambil daftar kategori dari fungsi util
                ?>

                <div class="flex flex-wrap gap-3 mt-4 pt-4 border-t border-gray-100">
                    <a href="<?= buildUrlWithParams('Semua') ?>"
                        class="category-filter px-4 py-2 <?= $kategori_aktif === 'Semua' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?> rounded-full text-sm font-medium transition-colors">
                        Semua
                    </a>
                    <?php foreach ($data as $d) :
                        $isActive = $d['kategori'] === $kategori_aktif;
                        $bgClass = $isActive ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200';
                    ?>
                        <a href="<?= buildUrlWithParams($d['kategori']) ?>"
                            class="category-filter px-4 py-2 <?= $bgClass ?> rounded-full text-sm font-medium transition-colors">
                            <?= $d['kategori'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Product Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <!-- Table Header -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Produk</h2>
                    <p class="text-gray-500 text-sm mt-1">Menampilkan <?= count($produkList) ?> dari <?= getTotalPruduk() ?> produk</p>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($produkList)): ?>
                                <?php foreach ($produkList as $produk): ?>
                                    <!-- Row 1 -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $produk['kode_produk'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $produk['nama_produk'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full"><?= $produk['kategori'] ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp <?= number_format($produk['harga_jual'], 0, '.', ',') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <p class="px-3 py-1 rounded-full <?= $produk['stok'] > 20  ? 'text-grey-900' : 'text-center text-orange-800 bg-orange-300' ?> ">
                                                <?= $produk['stok'] ?>
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 text-xs font-medium <?= $produk['status_produk'] == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-300 text-red-800' ?>  rounded-full"><?= $produk['status_produk'] ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex gap-2">
                                                <a href="edit-produk-view.php?id_produk=<?= $produk['id_produk'] ?>">
                                                    <div class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg border border-blue-200 transition-colors">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada produk ditemukan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </main>
    </div>

</body>

</html>