<?php
// Authentication middleware - must be at the top
require_once '../middleware/auth_middleware.php';
requireAuth(['admin']); // Only admin can access edit product

require '../utils/tools_util.php';
require '../utils/produk_util.php';

// Cek apakah id_produk ada di URL
if (!isset($_GET['id_produk'])) {
    echo "<script>alert('ID produk tidak ditemukan!');window.location='kelola-produk-view.php';</script>";
    exit;
}

include '../auth/koneksi.php';

$id_produk = $_GET['id_produk'];
$produk = getProdukById($id_produk);
if(count($produk) == 0){
    echo "<script>alert('Data produk tidak ditemukan!');window.location='kelola-produk-view.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../assets/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="flex w-full h-screen bg-gray-100">
    <?php
    $active = 2; // Set active menu item for Produk
    include '../components/sidebar.php'
    ?>
    <div class="flex-1 flex flex-col">
        <div class="w-full h-16 p-3 pl-5 bg-white flex items-center justify-between shadow-md shadow-gray-200">
            <!-- header -->
            <p class="font-bold text-xl text-purple-700">Edit Produk</p>            <div class="text-neutral-600 text-right mr-3">
                <p class="font-bold">Admin: <span><?= getUserDisplayName() ?></span></p>
                <p class="text-xs text-gray-500 font-semibold tracking-wider"><?= getFormattedDate() ?></p>
            </div>
        </div>

        <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">
            <!-- Header Section -->
            <div class="p-10 flex items-center justify-between bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl text-white shadow-md shadow-gray-300">
                <div class="text-purple-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-edit text-2xl"></i>
                        <p class="font-bold text-4xl">Edit Produk</p>
                    </div>
                    <p class="mt-1 text-xl font-semibold text-purple-100">Perbarui informasi produk: <?= htmlspecialchars($produk['nama_produk']) ?></p>
                </div>
                <div>
                    <a href="kelola-produk-view.php" class="flex items-center gap-5 px-5 py-3 rounded-lg bg-white text-purple-600 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Kembali ke Kelola Produk</p>
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Form Edit Produk</h2>
                    <p class="text-gray-500 text-sm mt-1">Perbarui informasi produk dengan benar</p>
                </div>

                <div class="p-6">
                    <form method="post" action="../handler/update_pruduk_handler.php" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Kode Produk -->
                            <div>
                                <label for="kode_produk" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kode Produk <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kode_produk" id="kode_produk" required
                                    value="<?= htmlspecialchars($produk['kode_produk']); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                    placeholder="Contoh: PRD001">
                            </div>

                            <!-- Nama Produk -->
                            <div>
                                <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_produk" id="nama_produk" required
                                    value="<?= htmlspecialchars($produk['nama_produk']); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                    placeholder="Masukkan nama produk">
                            </div>

                            <!-- Harga Jual -->
                            <div>
                                <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Jual <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                    <input type="number" name="harga_jual" id="harga_jual" required
                                        value="<?= $produk['harga_jual']; ?>"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                        placeholder="0">
                                </div>
                            </div>

                            <!-- Stok -->
                            <div>
                                <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stok <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stok" id="stok" required
                                    value="<?= $produk['stok']; ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                    placeholder="Jumlah stok">
                            </div>

                            <!-- Satuan -->
                            <div>
                                <label for="satuan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Satuan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="satuan" id="satuan" required
                                    value="<?= htmlspecialchars($produk['satuan']); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                    placeholder="pcs, kg, liter, dll">
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kategori" id="kategori" required
                                    value="<?= htmlspecialchars($produk['kategori']); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                    placeholder="Minuman, Makanan, dll">
                            </div>

                            <div>
                                <label for="status_produk" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status Produk <span class="text-red-500">*</span>
                                </label>
                                <select name="status_produk" id="status_produk" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors">
                                    <option value="Aktif" <?= $produk['status_produk'] === 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="Tidak Aktif" <?= $produk['status_produk'] === 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                                </select>
                            </div>

                            <!-- Tanggal Dibuat -->
                            <div>
                                <label for="tanggal_dibuat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Dibuat <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tanggal_dibuat" id="tanggal_dibuat" readonly
                                    value="<?= $produk['tanggal_dibuat'];?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors">
                            </div>

                            <!-- Tanggal Diperbarui -->
                            <div>
                                <label for="tanggal_diperbarui" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Diperbarui <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_diperbarui" id="tanggal_diperbarui" required
                                    value="<?= date('Y-m-d'); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors">
                            </div>
                        </div>

                        <!-- Deskripsi (Full Width) -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors resize-none"
                                placeholder="Masukkan deskripsi produk..."><?= htmlspecialchars($produk['deskripsi']); ?></textarea>
                        </div>

                        <!-- Foto Produk -->
                        <div>
                            <label for="foto_produk" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Produk
                            </label>
                            
                            <!-- Current Photo Display -->
                            <?php if (!empty($produk['foto_produk'])): ?>
                                <div class="mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                    <img src="../uploads/<?= $produk['foto_produk']; ?>" 
                                         alt="Foto Produk" 
                                         class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                    <p class="text-xs text-gray-500 mt-1"><?= $produk['foto_produk']; ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- File Upload -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-400 transition-colors">
                                <i class="fa-solid fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <input type="file" name="foto_produk" id="foto_produk" accept="image/*"
                                    class="hidden" onchange="displayFileName(this)">
                                <input type="hidden" name="foto_produk_lama" value="<?= $produk['foto_produk']; ?>">
                                <label for="foto_produk" class="cursor-pointer">
                                    <p class="text-gray-600 mb-2">Klik untuk upload foto baru atau drag & drop</p>
                                    <p class="text-sm text-gray-400">Format: JPG, JPEG, PNG. Max size: 2MB</p>
                                    <p class="text-xs text-orange-600 mt-2">*Kosongkan jika tidak ingin mengubah foto</p>
                                </label>
                                <p id="file-name" class="mt-2 text-sm text-purple-600 hidden"></p>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-6 border-t border-gray-200">
                            <button type="submit" 
                                class="flex-1 bg-purple-600 text-white py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors font-medium flex items-center justify-center gap-2">
                                <i class="fa-solid fa-save"></i>
                                Update Produk
                            </button>
                            <a href="kelola-produk-view.php"
                                class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition-colors font-medium flex items-center justify-center gap-2 text-decoration-none">
                                <i class="fa-solid fa-times"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function displayFileName(input) {
            const fileNameElement = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameElement.textContent = 'File dipilih: ' + input.files[0].name;
                fileNameElement.classList.remove('hidden');
            } else {
                fileNameElement.classList.add('hidden');
            }
        }

        // Set tanggal diperbarui ke hari ini secara otomatis
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_diperbarui').value = today;
        });
    </script>
</body>

</html>