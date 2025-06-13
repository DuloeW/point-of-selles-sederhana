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
    <?php include '../components/sidebar.php' ?>
    <div class="flex-1 flex flex-col gap-3">
        <div class="w-full h-16 p-3 pl-5 bg-white flex items-center justify-between shadow-md shadow-gray-200">
            <!-- header -->
            <p class="font-bold text-xl text-purple-700">Dashboard</p>
            <div class="text-neutral-600 text-right mr-3">
                <p class="font-bold">Kasir: <span>Mujianto</span></p>
                <p class="text-xs text-gray-500 font-semibold tracking-wider">12/6/2025</p>
            </div>
        </div>

        <!-- containner main content -->
        <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">

            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 rounded-2xl p-6 text-white shadow-md shadow-gray-300 flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">Selamat Datang, Mujianto!</p>
                    <p class="text-blue-100">Dashboard Kasir - Kamis, 12 Juni 2025</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold">11.23</p>
                    <p class="text-blue-100">Waktu Sekarang</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php
                $dashboardData = [
                    [
                        'title' => 'Transaksi Hari Ini',
                        'value' => 12,
                        'suffix' => 'Transaksi',
                        'color' => 'blue',
                        'icon' => 'fa-regular fa-calendar-check' // Ganti sesuai icon yang kamu pakai
                    ],
                    [
                        'title' => 'Pendapatan Hari Ini',
                        'value' => 'Rp 2500K',
                        'subtext' => 'Rp 2.500.000',
                        'color' => 'green',
                        'icon' => 'fa-solid fa-money-bill-wave'
                    ],
                    [
                        'title' => 'Rata-rata Transaksi',
                        'value' => 'Rp 208K',
                        'suffix' => 'Per transaksi',
                        'color' => 'purple',
                        'icon' => 'fa-solid fa-money-bill-wave'
                    ]
                ];

                // Perulangan untuk menampilkan setiap card
                foreach ($dashboardData as $data) {
                    // Set variabel untuk digunakan di card-informasi.php
                    $title = $data['title'];
                    $value = $data['value'];
                    $suffix = isset($data['suffix']) ? $data['suffix'] : '';
                    $subtext = isset($data['subtext']) ? $data['subtext'] : '';
                    $color = $data['color'];
                    $icon = $data['icon'];

                    // Include card component
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
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-700 rounded-full flex items-center justify-center text-white font-bold">
                                    A
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">INV001</p>
                                    <p class="text-sm text-gray-500">Andi Wijaya</p>
                                    <p class="text-xs text-gray-400">3 items • 10:30</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">Rp 50,000</p>
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Completed</span>
                            </div>
                        </div>

                        <!-- Transaksi 2 -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                    S
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">INV002</p>
                                    <p class="text-sm text-gray-500">Sari Dewi</p>
                                    <p class="text-xs text-gray-400">2 items • 11:15</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">Rp 45,000</p>
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Completed</span>
                            </div>
                        </div>

                        <!-- Transaksi 3 -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                    B
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">INV003</p>
                                    <p class="text-sm text-gray-500">Budi Hartono</p>
                                    <p class="text-xs text-gray-400">5 items • 12:45</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">Rp 75,000</p>
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Completed</span>
                            </div>
                        </div>
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
                        <div class="p-3 bg-orange-50 border border-orange-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">Kopi Robusta</p>
                                    <p class="text-sm text-gray-500">Minuman</p>
                                </div>
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full">35 tersisa</span>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">Susu Full Cream</p>
                                    <p class="text-sm text-gray-500">Minuman</p>
                                </div>
                                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">30 tersisa</span>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="p-3 bg-orange-50 border border-orange-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">Mentega</p>
                                    <p class="text-sm text-gray-500">Bahan Kue</p>
                                </div>
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full">50 tersisa</span>
                            </div>
                        </div>
                    </div>

                    <!-- Restock Button -->
                    <button class="w-full mt-4 bg-gradient-to-br from-red-500 to-orange-600 hover:bg-red-600 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors">
                        <i class="fa-solid fa-box"></i>
                        Restock Sekarang
                    </button>
                </div>
            </div>

        </main>
    </div>
</body>

</html>