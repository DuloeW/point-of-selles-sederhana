<!-- TODO responsive belum -->
<div class="w-64 h-screen bg-gray-50 shadow-lg flex flex-col">
    <!-- Header -->
    <div class="h-16 flex items-center justify-center bg-gradient-to-r from-orange-500 to-pink-500 text-white">
        <div class="flex items-center justify-center gap-3">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-store text-orange-500"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg">Shopping Mart</h1>
                <p class="text-sm opacity-90">d'Carts Basket</p>
            </div>
        </div>
    </div>
    
    <!-- Menu Items -->
    <div class="flex-1 p-4 mt-4 space-y-2">
        <!-- POS - Active -->
        <a href="" class="block">
            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-500 to-pink-500 rounded-lg text-white">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="font-medium">Dasboard</span>
                </div>
                <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
        </a>
        
        <!-- Produk -->
        <a href="" class="block">
            <div class="flex items-center gap-3 p-3 text-gray-600 rounded-lg transition-all scale-95 hover:scale-100 hover:shadow-md">
                <i class="fa-solid fa-box text-green-500"></i>
                <span>Produk</span>
            </div>
        </a>
        
        <!-- Penjualan -->
        <a href="" class="block">
            <div class="flex items-center gap-3 p-3 text-gray-600 rounded-lg transition-all scale-95 hover:scale-100 hover:shadow-md">
                <i class="fa-solid fa-chart-line text-purple-500"></i>
                <span>Penjualan</span>
            </div>
        </a>
        
        <!-- Pelanggan -->
        <a href="" class="block">
            <div class="flex items-center gap-3 p-3 text-gray-600 rounded-lg transition-all scale-95 hover:scale-100 hover:shadow-md">
                <i class="fa-solid fa-users text-orange-500"></i>
                <span>Pelanggan</span>
            </div>
        </a>
        
        <!-- Pengaturan -->
        <a href="" class="block">
            <div class="flex items-center gap-3 p-3 text-gray-600 rounded-lg transition-all scale-95 hover:scale-100 hover:shadow-md">
                <i class="fa-solid fa-cog text-gray-500"></i>
                <span>Pengaturan</span>
            </div>
        </a>
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