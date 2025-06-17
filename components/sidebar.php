<!-- TODO responsive belum -->
<div class="w-64 h-screen bg-gray-50 shadow-lg flex flex-col">
    <!-- Header -->
    <div class="h-16 flex items-center justify-center text-purple-900 border-b border-purple-300/30">
        <div class="flex items-center justify-center gap-3">
            <div class="w-8 h-8 bg-gradient-to-br from-purple-800 to-blue-700 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-store text-white"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg">Shopping Mart</h1>
                <p class="text-sm opacity-90">d'Carts Basket</p>
            </div>
        </div>
    </div>

    <!-- Menu Items -->
    <div class="flex-1 p-4 mt-4 space-y-2">

        <a href="dasboard-view.php" class="block">
            <div class="flex items-center rounded-lg justify-between p-3 <?= $active == 1 ? 'bg-purple-700 text-white' : 'text-gray-600 transition-all scale-95 hover:scale-100 hover:shadow-md'; ?>">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-house <?= $active == 1 ? '' : 'text-blue-500' ?>"></i>
                    <span class="font-medium">Dashboard</span>
                </div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </a>

        <a href="kelola-produk-view.php" class="block">
            <div class="flex items-center rounded-lg justify-between p-3 <?= $active == 2 ? 'bg-purple-700 text-white' : 'text-gray-600 transition-all scale-95 hover:scale-100 hover:shadow-md'; ?>">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-box <?= $active == 2 ? '' : 'text-green-500' ?>"></i>
                    <span class="font-medium">Produk</span>
                </div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </a>

        <a href="laporan-penjualan-view.php" class="block">
            <div class="flex items-center rounded-lg justify-between p-3 <?= $active == 3 ? 'bg-purple-700 text-white' : 'text-gray-600 transition-all scale-95 hover:scale-100 hover:shadow-md'; ?>">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-chart-line <?= $active == 3 ? '' : 'text-purple-500' ?>"></i>
                    <span class="font-medium">Penjualan</span>
                </div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </a>

        <a href="" class="block">
            <div class="flex items-center rounded-lg justify-between p-3 <?= $active == 4 ? 'bg-purple-700 text-white' : 'text-gray-600 transition-all scale-95 hover:scale-100 hover:shadow-md'; ?>">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users <?= $active == 4 ? '' : 'text-orange-500' ?>"></i>
                    <span class="font-medium">Pelanggan</span>
                </div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </a>

        <!-- Pengaturan
        <a href="" class="block">
            <div class="flex items-center gap-3 p-3 text-gray-600 rounded-lg transition-all scale-95 hover:scale-100 hover:shadow-md">
                <i class="fa-solid fa-cog text-gray-500"></i>
                <span>Pengaturan</span>
            </div>
        </a> -->
    </div>

    <!-- User Card -->
    <div class="p-4">
        <div class="bg-red-100 rounded-lg p-3 flex items-center gap-3">
            <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center text-white font-bold">
                K
            </div>
            <div class="flex-1">
                <p class="font-medium text-gray-800">Kasir Satu</p>
                <p class="text-sm text-gray-500">Kasir</p>
            </div>
            <i class="fa-solid fa-sign-out-alt text-gray-400"></i>
        </div>
    </div>
</div>