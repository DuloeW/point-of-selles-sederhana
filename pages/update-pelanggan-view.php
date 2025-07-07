<?php
// Authentication middleware - must be at the top
require_once '../middleware/auth_middleware.php';
requireAuth(['admin', 'kasir']); // Admin and kasir can access update customer

require '../utils/tools_util.php';
require '../utils/pelanggan_util.php';

// Cek apakah id_pelanggan ada di URL
if (!isset($_GET['id_pelanggan'])) {
    echo "<script>alert('ID pelanggan tidak ditemukan!');window.location='pelanggan-view.php';</script>";
    exit;
}

$id_pelanggan = $_GET['id_pelanggan'];
$pelanggan = getPelangganById($id_pelanggan);
if (empty($pelanggan)) {
    echo "<script>alert('Data pelanggan tidak ditemukan!');window.location='pelanggan-view.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
    <link rel="stylesheet" href="../assets/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="flex w-full h-screen bg-gray-100">
    <?php
    $active = 4; // Set active menu item for Pelanggan
    include '../components/sidebar.php'
    ?>
    <div class="flex-1 flex flex-col">
        <?php
        $title = "Edit Pelanggan";
        include '../components/header-page.php'
        ?>

        <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">
            <!-- Header Section -->
            <div class="p-10 flex items-center justify-between bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl text-white shadow-md shadow-gray-300">
                <div class="text-purple-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-user-edit text-2xl"></i>
                        <p class="font-bold text-4xl">Edit Pelanggan</p>
                    </div>
                    <p class="mt-1 text-xl font-semibold text-purple-100">Perbarui informasi pelanggan: <?= htmlspecialchars($pelanggan['nama_lengkap']) ?></p>
                </div>
                <div>
                    <a href="pelanggan-view.php" class="flex items-center gap-5 px-5 py-3 rounded-lg bg-white text-purple-600 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i>
                        <p>Kembali ke Pelanggan</p>
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Form Edit Pelanggan</h2>
                    <p class="text-gray-500 text-sm mt-1">Perbarui informasi pelanggan dengan benar</p>
                </div>

                <div class="p-6">
                    <form method="post" action="../handler/update_pelanggan_handler.php" class="space-y-6">
                        <input type="hidden" name="id_pelanggan" value="<?= $pelanggan['id_pelanggan']; ?>">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div>
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" required
                                    value="<?= htmlspecialchars($pelanggan['nama_lengkap']); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <!-- Telepon -->
                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="telepon" id="telepon" required
                                    value="<?= htmlspecialchars($pelanggan['telepon']); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                    placeholder="Contoh: 081234567890">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email
                                </label>
                                <input type="email" name="email" id="email"
                                    value="<?= htmlspecialchars($pelanggan['email']); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                    placeholder="Masukkan email">
                            </div>

                            <!-- Level Member (Display only if exists) -->
                            <?php if (!empty($pelanggan['level_member'])): ?>
                                <div>
                                    <label for="level_member" class="block text-sm font-medium text-gray-700 mb-2">
                                        Level Member
                                    </label>
                                    <p class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors">
                                        <span class="font-semibold text-purple-700">
                                            <?php
                                            $level_icons = ['Bronze' => '🥉', 'Silver' => '🥈', 'Gold' => '🥇'];
                                            echo $level_icons[$pelanggan['level_member']] . ' ' . $pelanggan['level_member'];
                                            ?>
                                        </span>
                                    </p>
                                </div>

                                <!-- Poin Member -->
                                <div>
                                    <label for="poin" class="block text-sm font-medium text-gray-700 mb-2">
                                        Poin Member
                                    </label>
                                    <input type="number" name="poin" id="poin" min="0"
                                        value="<?= $pelanggan['poin'] ?? 0; ?>"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors"
                                        placeholder="Jumlah poin">
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Alamat (Full Width) -->
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat
                            </label>
                            <textarea name="alamat" id="alamat" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors resize-none"
                                placeholder="Masukkan alamat lengkap..."><?= htmlspecialchars($pelanggan['alamat']); ?></textarea>
                        </div>

                        <!-- Membership Info (if exists) -->
                        <?php if (!empty($pelanggan['level_member'])): ?>
                            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-purple-800 mb-3">
                                    <i class="fa-solid fa-crown text-yellow-500"></i>
                                    Informasi Membership
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600">Level Member:</p>
                                        <p class="font-semibold text-purple-700">
                                            <?php
                                            $level_icons = ['Bronze' => '🥉', 'Silver' => '🥈', 'Gold' => '🥇'];
                                            echo $level_icons[$pelanggan['level_member']] . ' ' . $pelanggan['level_member'];
                                            ?>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Total Poin:</p>
                                        <p class="font-semibold text-purple-700"><?= number_format($pelanggan['poin'] ?? 0); ?> poin</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Tanggal Daftar:</p>
                                        <p class="font-semibold text-purple-700">
                                            <?= !empty($pelanggan['tanggal_daftar']) ? date('d M Y', strtotime($pelanggan['tanggal_daftar'])) : '-'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex-1 bg-purple-600 text-white py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors font-medium flex items-center justify-center gap-2">
                                <i class="fa-solid fa-save"></i>
                                Update Pelanggan
                            </button>
                            <a href="pelanggan-view.php"
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
</body>

</html>