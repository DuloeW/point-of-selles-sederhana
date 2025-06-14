<?php
require '../utils/tools_util.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="../assets/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="flex w-full h-screen bg-gray-100">
    <?php
    $active = 2; // Set active menu item for Kelola Produk
    include '../components/sidebar.php'
    ?>
    <div class="flex-1 flex flex-col">
        <div class="w-full h-16 p-3 pl-5 bg-white flex items-center justify-between shadow-md shadow-gray-200">
            <!-- header -->
            <p class="font-bold text-xl text-purple-700">Produk</p>
            <div class="text-neutral-600 text-right mr-3">
                <p class="font-bold">Admin: <span>Mujianto</span></p>
                <p class="text-xs text-gray-500 font-semibold tracking-wider"><?= getFormattedDate() ?></p>
            </div>
        </div>

        <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">
            <div class="p-10 flex items-center justify-between bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl text-white shadow-md shadow-gray-300">
                <div class="text-purple-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-box-open text-2xl"></i>
                        <p class="font-bold text-4xl">Manajemen Produk</p>
                    </div>
                    <p class="mt-1 text-xl font-semibold text-purple-100">Kelola inventori dan produk toko Anda</p>
                </div>
                <div>
                    <div class="flex items-center gap-5 px-5 py-3 rounded-lg bg-white text-emerald-600">
                        <i class="fa-solid fa-plus"></i>
                        <p>Tambah Produk</p>
                    </div>
                </div>
            </div>

            <!-- Product Statistics Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Produk -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl p-6 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Produk</p>
                            <p class="text-3xl font-bold text-blue-100 mt-1">10</p>
                            <p class="text-blue-100 text-sm mt-1">Item berbeda</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-box text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Stok Habis -->
                <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm font-medium">Stok Habis</p>
                            <p class="text-3xl font-bold text-red-100 mt-1">0</p>
                            <p class="text-red-100 text-sm mt-1">Perlu restock</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-triangle-exclamation text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Stok Sedikit -->
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Stok Sedikit</p>
                            <p class="text-3xl font-bold text-yellow-100 mt-1">0</p>
                            <p class="text-yellow-100 text-sm mt-1">≤ 10 unit</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Produk Aktif</p>
                            <p class="text-3xl font-bold text-green-100 mt-1">0</p>
                            <p class="text-green-100 text-sm mt-1">Produk Aktif</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-check text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-6">
                <div class="flex flex-col lg:flex-row gap-4 items-center">
                    <!-- Search Bar -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input
                            type="text"
                            placeholder="Cari produk berdasarkan nama, kode, atau kategori..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-colors">
                    </div>

                    <!-- Filter Button -->
                    <button class="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-filter text-gray-500"></i>
                        <span class="text-gray-600">Filter</span>
                    </button>
                </div>

                <!-- Category Filter Pills -->
                <?php
                // Ambil kategori aktif dari URL (misalnya ?kategori=Minuman)
                $kategori_aktif = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';

                $kategori_list = ['Semua', 'Minuman', 'Bahan Pokok', 'Kebutuhan Harian', 'Makanan Instan', 'Snack'];
                ?>

                <div class="flex flex-wrap gap-3 mt-4 pt-4 border-t border-gray-100">
                    <?php foreach ($kategori_list as $kategori) :
                        $isActive = $kategori === $kategori_aktif;
                        $bgClass = $isActive ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200';
                    ?>
                        <a href="?kategori=<?= urlencode($kategori) ?>"
                            class="category-filter px-4 py-2 <?= $bgClass ?> rounded-full text-sm font-medium transition-colors">
                            <?= $kategori ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Product Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <!-- Table Header -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Produk</h2>
                    <p class="text-gray-500 text-sm mt-1">Menampilkan 6 dari 6 produk</p>
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
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PRD001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Kopi Arabika</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Minuman</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp 25,000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">50</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg border border-blue-200 transition-colors">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg border border-red-200 transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PRD002</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Teh Hijau</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Minuman</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp 15,000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">40</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg border border-blue-200 transition-colors">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg border border-red-200 transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PRD003</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Susu Full Cream</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Minuman</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp 18,000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">30</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg border border-blue-200 transition-colors">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg border border-red-200 transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 4 -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PRD004</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Gula Pasir</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Bahan Pokok</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp 12,000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">100</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg border border-blue-200 transition-colors">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg border border-red-200 transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            

        </main>
    </div>

</body>

</html>