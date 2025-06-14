<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Halaman Kasir</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-gray-100 to-gray-200 font-sans">

  <!-- Header -->
  <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white shadow">
    <h1 class="text-2xl font-bold">Point of Sales</h1>
    <div class="flex items-center gap-4">
      <span class="text-sm">Online</span>
      <div class="w-3 h-3 bg-green-400 rounded-full"></div>
      <button class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white px-4 py-1 rounded">Keluar</button>
    </div>
  </div>

  <div class="grid grid-cols-3 gap-4 px-6 py-4">
    <!-- Katalog Produk -->
    <div class="col-span-2">
      <!-- Info Panel -->
      <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white p-4 rounded-xl shadow">
          <h2 class="text-sm">Total Produk</h2>
          <p class="text-2xl font-bold">8</p>
        </div>
        <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-4 rounded-xl shadow">
          <h2 class="text-sm">Item di Keranjang</h2>
          <p class="text-2xl font-bold">1</p>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-4 rounded-xl shadow">
          <h2 class="text-sm">Total Keranjang</h2>
          <p class="text-2xl font-bold">Rp 30.000</p>
        </div>
      </div>

      <!-- Filter dan Pencarian -->
      <div class="flex gap-2 mb-4">
        <input type="text" placeholder="Cari produk..."
          class="flex-grow px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300" />
        <button class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white px-4 py-2 rounded-xl">Scan Barcode</button>
      </div>

      <!-- Kategori -->
      <div class="flex gap-2 mb-4">
        <button class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-1 rounded-xl">Semua</button>
        <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1 rounded-xl">Makanan</button>
        <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1 rounded-xl">Minuman</button>
      </div>

      <!-- Produk -->
      <div class="grid grid-cols-3 gap-4">
        <!-- Produk 1 -->
        

        <!-- Produk 4: Tambahan dengan SVG -->
        <div class="bg-white rounded-xl shadow flex flex-col items-center p-4 text-center hover:shadow-lg transition">
          <div class="flex justify-center items-center w-full h-24 bg-gray-100 rounded-lg mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 3v6a2 2 0 002 2h0a2 2 0 002-2V3m6 0v6m0 0a2 2 0 002 2h0a2 2 0 002-2V3m-6 0v18m6-9h2a2 2 0 012 2v5a2 2 0 01-2 2h-2v-9z">
              </path>
            </svg>
          </div>
          <h3 class="font-bold text-lg mb-1">Ayam Bakar</h3>
          <p class="text-sm text-gray-600 mb-1">Ayam bakar bumbu kecap dengan nasi</p>
          <div class="flex justify-between items-center w-full text-sm mb-2">
            <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs">Makanan</span>
            <span class="text-gray-500">30 Porsi</span>
          </div>
<div class="flex justify-between items-center w-full mt-2">
  <p class="text-indigo-600 font-bold text-lg">Rp 30.000</p>
  <button class="bg-blue-600 hover:bg-blue-700 text-white text-lg w-10 h-10 rounded-lg flex items-center justify-center">
    +
  </button>
</div>

        </div>
      </div>
    </div>

<!-- TODO BUAT TAMPILAN KERANJANG KOSONG -->
    
    <!-- Keranjang -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white px-4 py-3">
        <h2 class="text-lg font-bold">Keranjang Belanja</h2>
      </div>

      <div class="p-4">
        <!-- Pilih Pelanggan -->
        <div class="mb-4">
          <label class="block mb-1 text-sm text-gray-700">Pilih Pelanggan</label>
          <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300">
            <option>Pelanggan Umum</option>
            <option>Member A</option>
          </select>
          <button class="mt-2 text-sm text-indigo-600 hover:underline">+ Daftar Member Baru</button>
        </div>

        <!-- Item Keranjang -->
        <div class="border rounded-lg p-3 mb-4 bg-white shadow-sm">
          <div class="flex justify-between">
            <div>
              <p class="font-semibold">Ayam Bakar</p>
              <p class="text-sm text-gray-500">Rp 30.000 × 1</p>
            </div>
            <div class="flex items-center gap-2">
              <button class="px-2 bg-gray-200 rounded hover:bg-gray-300">−</button>
              <span>1</span>
              <button class="px-2 bg-gray-200 rounded hover:bg-gray-300">+</button>
              <button class="flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-red-500 to-red-700 text-white rounded hover:from-red-600 hover:to-red-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                  viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zM4 7h16">
                  </path>
                </svg>
                <span class="text-xs font-semibold">Hapus</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Total -->
        <div class="mb-4">
          <p class="text-sm text-gray-600">Subtotal: Rp 30.000</p>
          <p class="text-lg font-bold text-indigo-700">Total: Rp 30.000</p>
        </div>

        <!-- Pembayaran -->
        <input type="text" placeholder="Masukkan jumlah pembayaran"
          class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"/>

        <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-bold">
          ✓ Proses Pembayaran
        </button>
      </div>
    </div>
  </div>
</body>
</html>
