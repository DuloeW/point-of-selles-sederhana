<?php
// Authentication middleware - must be at the top
require_once '../middleware/auth_middleware.php';
requireAuth(['admin']); // Only admin can access customer management

require '../utils/tools_util.php';
require '../auth/koneksi.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($keyword !== '') {
  $keyword = mysqli_real_escape_string($koneksi, $keyword);
  $query = "SELECT p.nama_lengkap, p.telepon, p.alamat, p.email, m.poin 
              FROM pelanggan p
              LEFT JOIN member m ON p.id_pelanggan = m.id_pelanggan
              WHERE p.telepon LIKE '%$keyword%'";
} else {
  $query = "SELECT p.nama_lengkap, p.telepon, p.alamat, p.email, m.poin 
              FROM pelanggan p
              LEFT JOIN member m ON p.id_pelanggan = m.id_pelanggan";
}


$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manajemen Pelanggan</title>
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
      <p class="font-bold text-xl text-purple-700">Manajemen Pelanggan</p>
      <div class="text-neutral-600 text-right mr-3">        <p class="font-bold">Admin: <span><?= getUserDisplayName() ?></span></p>
        <p class="text-xs text-gray-500 font-semibold tracking-wider"><?= getFormattedDate() ?></p>
      </div>
    </div>

    <!--Main-->
    <main class="flex-1 flex flex-col space-y-6 w-full h-screen p-5 overflow-y-auto">
      <div class="p-10 flex items-center justify-between bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl text-white shadow-md shadow-gray-300">
        <div class="text-purple-100">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-box-open text-2xl"></i>
            <p class="font-bold text-4xl">Manajemen Pelanggan</p>
          </div>
          <p class="mt-1 text-xl font-semibold text-purple-100">Kelola data pelanggan</p>
        </div>
      </div>

      <div class="flex-1 flex flex-col gap-6 p-5 bg-white rounded-lg shadow-md shadow-gray-200">
        <!-- Search -->
        <div class="flex gap-2 mb-4">
          <form action="" class="flex w-full gap-2">
            <input
              type="text"
              name="keyword"
              placeholder="Cari nomor telepon pelanggan.."
              value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"
              class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-1 focus:ring-purple-500 focus:border-purple-500 outline-none transition-colors" />
            <button
              type="submit"
              class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-800 text-white px-4 py-2 rounded-xl whitespace-nowrap">
              Cari
            </button>
          </form>
        </div>
  
        <!-- Tabel Pelanggan -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
          <table class="w-full text-sm text-left table-auto">
            <thead class="bg-purple-700 text-white">
              <tr>
                <th class="px-4 py-3 w-1/4">Nama Pelanggan</th>
                <th class="px-4 py-3 w-1/3 text-center">Kontak</th>
                <th class="px-4 py-3 text-center">Poin</th>
                <th class="px-4 py-3 w-2/5 text-right">Alamat</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr class="hover:bg-gray-50 align-top">
                  <td class="px-4 py-3 font-medium"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                  <td class="px-4 py-3 text-center">
                    📞 <?= htmlspecialchars($row['telepon']) ?> |
                    ✉️ <?= htmlspecialchars($row['email']) ?>
                  </td>
                  <td class="px-4 py-3 text-center"><?= htmlspecialchars($row['poin']) ?></td>
                  <td class="px-4 py-3 text-right"><?= htmlspecialchars($row['alamat']) ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
  
        </div>
      </div>

    </main>
</body>
</body>

</html>