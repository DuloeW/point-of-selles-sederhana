<?php
require '../utils/tools_util.php';
require '../auth/koneksi.php';

$query= "SELECT nama_lengkap, telepon, alamat, email FROM pelanggan";
$result= mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="flex w-full h-screen bg-gray-100">
    <?php
    $active = 4; // Set active menu item for Dasboard
    include '../components/sidebar.php'
    ?>
    <div class="flex-1 flex flex-col gap-3">
        <div class="w-full h-16 p-3 pl-5 bg-white flex items-center justify-between shadow-md shadow-gray-200">
            <!-- header -->
            <p class="font-bold text-xl text-purple-700">Manajemen Pelangan</p>
            <div class="text-neutral-600 text-right mr-3">
                <p class="font-bold">Admin: <span>Mujianto</span></p>
                <p class="text-xs text-gray-500 font-semibold tracking-wider"><?= getFormattedDate() ?></p>
            </div>
        </div>

        <!--Main-->
        <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">
            <div class="p-10 flex items-center justify-between bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl text-white shadow-md shadow-gray-300">
                <div class="text-purple-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-box-open text-2xl"></i>
                        <p class="font-bold text-4xl">Manajemen Produk</p>
                    </div>
                    <p class="mt-1 text-xl font-semibold text-purple-100">Kelola inventori dan produk toko Anda</p>
                </div>
            </div>

            <!-- Search -->
            <div class="mb-4">
                <input
                    type="text"
                    placeholder="Cari pelanggan berdasarkan nama, telepon, atau email..."
                    class="w-full p-3 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>

            <!-- Tabel Pelanggan -->
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-purple-700 text-white">
                        <tr>
                            <th class="px-4 py-3">Nama Pelanggan</th>
                            <th class="px-4 py-3">Kontak</th>
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Contoh Data (nanti ini diisi dari PHP atau JS yang ambil dari database) -->
                      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
            <td class="px-4 py-3">
                📞 <?= htmlspecialchars($row['telepon']) ?> <br />
                ✉️ <?= htmlspecialchars($row['email']) ?>
            </td>
            <td class="px-4 py-3"><?= htmlspecialchars($row['alamat']) ?></td>
            <td class="px-4 py-3 space-x-2">
                <button class="px-3 py-1 bg-purple-500 hover:bg-purple-600 text-white rounded">Edit</button>
                <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded">Hapus</button>
            </td>
        </tr>
    <?php endwhile; ?>
                        <!-- Tambahkan data lainnya... -->
                    </tbody>
                </table>
            </div>

        </main>
</body>
</body>

</html>