  <?php
  // Authentication middleware - must be at the top
  require_once '../middleware/auth_middleware.php';
  requireAuth(['kasir']); // Both admin and kasir can access

  require '../utils/produk_util.php';
  require '../utils/tools_util.php';
  require '../utils/keranjang_util.php';
  require_once '../utils/pelanggan_util.php';

  $username = $_SESSION['nama_lengkap'];

  $kategoriDipilih = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';

  $queryKategori = "SELECT DISTINCT kategori FROM produk WHERE kategori IS NOT NULL AND kategori != ''";
  $resultKategori = $koneksi->query($queryKategori);
  if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {
    $keyword = $koneksi->real_escape_string($_GET['keyword']);
    $produkList = [];

    $query = "SELECT * FROM produk 
            WHERE (kode_produk LIKE '%$keyword%' 
               OR nama_produk LIKE '%$keyword%'
               OR kategori LIKE '%$keyword%') 
               AND status_produk = 'Aktif'";

    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_assoc($result)) {
      $produkList[] = $row;
    }
  } else {
    $produkList = filterProdukByKategori($kategoriDipilih);
  }

  $queryPelanggan = "SELECT pelanggan.id_pelanggan, pelanggan.nama_lengkap, member.level_member 
                   FROM pelanggan 
                   LEFT JOIN member ON pelanggan.id_pelanggan = member.id_pelanggan";
  $resultPelanggan = $koneksi->query($queryPelanggan);

  // session_start();
  if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pelanggan'])) {
    $_SESSION['id_pelanggan'] = $_POST['id_pelanggan'];
  }


  // Menambahkan produk ke keranjang
  if (isset($_GET['tambah'])) {
    $id = $_GET['tambah'];
    if (isset($_SESSION['keranjang'][$id])) {
      $_SESSION['keranjang'][$id] += 1;
    } else {
      $_SESSION['keranjang'][$id] = 1;
    }
    header("Location: ../pages/kasir-view.php?kategori=$kategoriDipilih");
    exit;
  }
  // Kurangi jumlah
  if (isset($_GET['kurang'])) {
    $id = $_GET['kurang'];
    if (isset($_SESSION['keranjang'][$id])) {
      $_SESSION['keranjang'][$id]--;
      if ($_SESSION['keranjang'][$id] <= 0) {
        unset($_SESSION['keranjang'][$id]);
      }
    }
    header("Location: ../pages/kasir-view.php?kategori=$kategoriDipilih");
    exit;
  }

  // Hapus item
  if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    unset($_SESSION['keranjang'][$id]);
    header("Location: ../pages/kasir-view.php?kategori=$kategoriDipilih");
    exit;
  }

  // hubungkan pelanggan ke database
  if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['nama_lengkap'], $_POST['telepon'], $_POST['email'], $_POST['alamat'], $_POST['level_member'])
  ) {
    $nama = $_POST['nama_lengkap'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $level = $_POST['level_member'];

    $result = tambahMemberBaru($nama, $telepon, $email, $alamat, $level);

    if ($result['success']) {
      header('Location: ../pages/kasir-view.php?success=member_added');
      exit;
    } else {
      echo "<script>alert('{$result['message']}');</script>";
    }
  }

  ?>



  <!DOCTYPE html>
  <html lang="id">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Kasir</title>
    <link rel="stylesheet" href="../assets/output.css">
    <link rel="icon" type="image/png" href="../assets/d-logo.png">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  </head>

  <body class="bg-gradient-to-b from-gray-100 to-gray-200 font-sans">

    <!-- Header -->
    <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-br from-purple-500 to-purple-700 text-white shadow">
      <img src="../assets/logo.png" alt=""
        class="w-24 ">
      <div class="flex items-center gap-4">
        <span class="text-sm"><?= $username ?></span>
        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
        <button
          onclick="confirmLogout()"
          class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white px-4 py-1 rounded">
          Keluar
        </button>

      </div>
    </div>

    <div class="grid grid-cols-3 gap-4 px-6 py-4">
      <!-- Katalog Produk -->
      <div class="col-span-2">
        <!-- Info Panel -->
        <div class="grid grid-cols-1 gap-4 mb-4">
          <div class="bg-gradient-to-r from-purple-500 to-purple-700 text-white p-4 rounded-xl shadow">
            <h2 class="text-sm">Total Produk</h2>
            <p class="text-4xl font-bold"><?= getTotalProdukAktif() ?></p>
          </div>
        </div>

        <div class="sticky top-0 bg-transparent backdrop-blur-lg z-10 p-4 rounded-xl shadow mb-4">
          <div class="flex gap-2 mb-4">
            <form action="" class="flex w-full gap-2">
              <input
                type="text"
                name="keyword"
                placeholder="Cari kode produk..."
                value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"
                class="flex-grow px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300" />
              <button
                type="submit"
                class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-800 text-white px-4 py-2 rounded-xl whitespace-nowrap">
                Cari
              </button>
            </form>
          </div>

          <!-- Kategori -->
          <div class="grid grid-cols-4 gap-2 mb-4">
            <?php
            $isSemua = $kategoriDipilih === 'Semua';
            $semuaClass = $isSemua
              ? 'bg-purple-600 text-white'
              : 'bg-gray-200 hover:bg-gray-300 text-gray-800';
            ?>
            <a href="?kategori=Semua"
              class="<?= $semuaClass ?> text-center px-4 py-2 rounded-xl text-sm font-semibold w-full">
              Semua
            </a>


            <?php while ($row = $resultKategori->fetch_assoc()): ?>
              <?php
              $kategoriSekarang = $row['kategori'];
              $isActive = $kategoriSekarang === $kategoriDipilih;
              $btnClass = $isActive
                ? 'bg-purple-600 text-white'
                : 'bg-gray-200 hover:bg-gray-300 text-gray-800';
              ?>
              <a href="?kategori=<?= urlencode($kategoriSekarang) ?>"
                class="<?= $btnClass ?> text-center px-4 py-2 rounded-xl text-sm font-semibold w-full">
                <?= htmlspecialchars($kategoriSekarang) ?>
              </a>


            <?php endwhile; ?>
          </div>
        </div>

        <!-- Filter dan Pencarian -->

        <!-- listproduk -->
        <div class="grid grid-cols-3 gap-4 overflow-y-auto h-[calc(100vh-200px)]">
          <?php if (!empty($produkList)): ?>
            <?php foreach ($produkList as $produk): ?>
              <div class="bg-white h-fit rounded-xl shadow flex flex-col items-center p-4 text-center hover:shadow-lg transition">
                <div class="w-full h-32 rounded-lg mb-4 overflow-hidden">
                  <?php if (getFileNameInUplouds($produk['foto_produk']) == null) : ?>
                    <div class="w-full h-full flex items-center justify-center">
                      <p class="font-semibold opacity-25">Gambar tidak ditemukan</p>
                    </div>
                  <?php else: ?>
                    <img src="../uploads/<?= $produk['foto_produk']; ?>" class="h-full mx-auto">
                  <?php endif; ?>
                </div>
                <h3 class="font-bold text-lg mb-1"><?= $produk['nama_produk']; ?></h3>
                <p class="text-sm text-gray-600 mb-1"><?= $produk['deskripsi']; ?></p>
                <div class="flex justify-between items-center w-full text-sm mb-2">
                  <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs"><?= $produk['kategori']; ?></span>
                  <span class="text-gray-500"><?= $produk['stok']; ?> Pcs</span>
                </div>
                <div class="flex justify-between items-center w-full mt-2">
                  <p class="text-indigo-600 font-bold text-lg">Rp <?= number_format($produk['harga_jual'], 0, ',', '.'); ?></p>
                  <a href="?tambah=<?= $produk['id_produk']; ?>&kategori=<?= urlencode($kategoriDipilih); ?>"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-lg w-10 h-10 rounded-lg flex items-center justify-center">
                    +
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="col-span-3 text-center text-gray-500">Tidak ada produk dalam kategori ini.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Keranjang -->
      <div class="bg-white h-fit rounded-xl shadow-md flex flex-col pb-5">
        <!-- Header -->
        <div class="bg-white text-gray-800/55 px-4 py-3 rounded-tr-xl rounded-tl-xl">
          <h2 class="text-xl font-bold">Keranjang Belanja</h2>
        </div> <!-- Pilih Pelanggan -->
        <form method="POST" action="" class="p-4">
          <div class="mb-4">
            <label class="block mb-1 text-sm text-gray-700">Pilih Pelanggan</label>
            <?php $resultPelanggan = mysqli_query($koneksi, "SELECT p.id_pelanggan, p.nama_lengkap, m.level_member FROM pelanggan p LEFT JOIN member m ON p.id_pelanggan = m.id_pelanggan"); ?>
            <select name="id_pelanggan" class="select-member w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" onchange="this.form.submit()">
              <option value="umum" data-level="umum"
                <?= (!isset($_SESSION['id_pelanggan']) || $_SESSION['id_pelanggan'] === 'umum') ? 'selected' : '' ?>>
                Pelanggan Umum
              </option>
              <?php while ($row = $resultPelanggan->fetch_assoc()): ?>
                <?php
                $nama = htmlspecialchars($row['nama_lengkap']);
                $level = $row['level_member'] ?? 'none';
                $label = $level !== 'none' ? "$nama ($level)" : $nama;
                ?>
                <option value="<?= $row['id_pelanggan'] ?>" data-level="<?= strtolower($level) ?>"
                  <?= (isset($_SESSION['id_pelanggan']) && $_SESSION['id_pelanggan'] == $row['id_pelanggan']) ? 'selected' : '' ?>>
                  <?= $label ?>
                </option>
              <?php endwhile; ?>
            </select>

            <button type="button" id="openModalBtn" class="w-full mt-2 inline-flex justify-center items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:from-purple-600 hover:to-indigo-700 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Tambah Member Baru
            </button>
          </div>
        </form>

        <div class="px-4">
          <!-- Item Keranjang -->
          <div class="grid <?= sizeof($_SESSION['keranjang']) > 1 ? 'grid-cols-2' : 'grid-cols-1' ?> gap-4">
            <?php
            $subtotal = 0;
            $diskonPersen = 0;

            // Hitung subtotal dari keranjang
            if (!empty($_SESSION['keranjang'])):
              foreach ($_SESSION['keranjang'] as $idProduk => $jumlah):
                $produk = getProdukById($idProduk); // Fungsi ambil produk by ID
                $totalItem = $produk['harga_jual'] * $jumlah;
                $subtotal += $totalItem;
            ?>
                <!-- Tampilkan masing-masing item -->
                <div class="border rounded-lg p-3 mb-4 bg-white shadow-sm">
                  <div class="flex flex-col justify-between gap-3">
                    <div>
                      <p class="font-semibold"><?= $produk['nama_produk']; ?></p>
                      <p class="text-sm text-gray-500">Rp <?= number_format($produk['harga_jual'], 0, ',', '.'); ?> × <?= $jumlah ?></p>
                    </div>
                    <div class="flex items-center gap-2">
                      <a href="?kurang=<?= $idProduk ?>&kategori=<?= urlencode($kategoriDipilih) ?>" class="px-2 bg-gray-200 rounded hover:bg-gray-300">−</a>
                      <span><?= $jumlah ?></span>
                      <a href="?tambah=<?= $idProduk ?>&kategori=<?= urlencode($kategoriDipilih) ?>" class="px-2 bg-gray-200 rounded hover:bg-gray-300">+</a>
                      <a href="?hapus=<?= $idProduk ?>&kategori=<?= urlencode($kategoriDipilih) ?>" class="flex items-center gap-1 px-2 py-1 bg-white shadow-xl rounded-md">
                        <!-- <span class="text-xs font-semibold py-1">Hapus</span> -->
                        <i class="fa-solid fa-trash text-red-500"></i>
                      </a>
                    </div>
                  </div>
                </div>
              <?php
              endforeach;
            else:
              ?>
              <!-- Keranjang kosong -->
              <div class="flex flex-col items-center justify-center text-gray-500 py-12 col-span-2">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart" class="w-24 h-24 mb-4 opacity-70">
                <p class="text-lg font-semibold">Keranjang masih kosong</p>
                <p class="text-sm text-gray-400">Silakan pilih produk dari katalog.</p>
              </div>
            <?php endif; ?>
          </div>

          <?php if (!empty($_SESSION['keranjang'])): ?>
            <?php
            $diskonPersen = 0;
            $diskon = 0;
            $totalAkhir = $subtotal;

            $id_pelanggan = $_SESSION['id_pelanggan'] ?? 'umum';
            if ($id_pelanggan !== 'umum') {
              $query = mysqli_query($koneksi, "SELECT m.level_member, d.persentase_diskon
                                   FROM member m
                                   JOIN diskon_member d ON m.level_member = d.level_member
                                   WHERE m.id_pelanggan = $id_pelanggan");

              if ($row = mysqli_fetch_assoc($query)) {
                $diskonPersen = (float)$row['persentase_diskon'];
                $diskon = $subtotal * ($diskonPersen / 100);
                $totalAkhir = $subtotal - $diskon;
              }
            }

            ?>

            <?php if ($diskonPersen > 0): ?>
              <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-2">
                <p><strong>Diskon Member (<?= $diskonPersen ?>%)</strong></p>
                <p>Rp <?= number_format($diskon, 0, ',', '.') ?></p>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-100 p-3 rounded">
                  <p class="text-sm text-gray-600">Subtotal:</p>
                  <p class="text-xl font-bold text-black">Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
                </div>
              <?php endif; ?>

              <div class="bg-gray-100 p-3 rounded">
                <p class="text-sm text-gray-600">Subtotal (akhir):</p>
                <p class="text-xl font-bold text-green-700">Rp <?= number_format($totalAkhir, 0, ',', '.') ?></p>
              </div>
            <?php else: ?> <?php endif; ?>
              </div>


              <!-- Payment Form (only show if cart has items) -->
              <?php if (!empty($_SESSION['keranjang'])): ?>
                <form method="POST" action="../handler/kasir_handler.php">
                  <!-- Metode Pembayaran -->
                  <div class="grid grid-cols-2 gap-2 px-4">
                    <div class="mb-4">
                      <label for="metode" class="block text-sm font-semibold text-gray-700 mt-3 mb-1">
                        Metode Pembayaran
                      </label>
                      <select id="metode" name="metode" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        <option value="cash">💵 Cash</option>
                        <option value="qris">📱 QRIS</option>
                        <option value="debit">🏧 Kartu Debit</option>
                        <option value="transfer">💳 Transfer Bank</option>
                      </select>
                    </div>

                    <!-- Jumlah Bayar -->
                    <div class="mb-4">
                      <label for="bayar" class="block text-sm font-semibold text-gray-700 mt-3 mb-1">
                        Jumlah Bayar
                      </label>
                      <input
                        type="text"
                        id="bayar"
                        name="bayar"
                        placeholder="Jumlah pembayaran"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300" />
                    </div>

                    <!-- Kembalian -->
                    <div id="kembalianDisplay" class="hidden p-3 col-span-2 rounded-lg bg-gradient-to-r from-green-100 to-green-200 border border-green-300">
                      <p class="text-green-800 text-sm font-semibold">Kembalian:</p>
                      <p id="jumlahKembalian" class="text-xl font-bold text-green-700">Rp 0</p>
                    </div>
                  </div>

                  <div class="px-4 mt-4">
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-bold">
                      Proses Pembayaran
                    </button>
                  </div>
                </form>
              <?php endif; ?>
        </div>
      </div>
    </div>
    <script>
      const inputBayar = document.getElementById("bayar");
      const totalHarga = <?= $totalAkhir ?>;
      const kembalianDisplay = document.getElementById("kembalianDisplay");
      const jumlahKembalian = document.getElementById("jumlahKembalian");

      inputBayar.addEventListener("input", () => {
        const bayar = parseInt(inputBayar.value.replace(/\D/g, ""));
        if (!isNaN(bayar) && bayar >= totalHarga) {
          const kembali = bayar - totalHarga;
          jumlahKembalian.textContent = `Rp ${kembali.toLocaleString("id-ID")}`;
          kembalianDisplay.classList.remove("hidden");
        } else {
          kembalianDisplay.classList.add("hidden");
        }
      });
    </script>
    <script>
      $(document).ready(function() {
        $('.select-member').select2({
          templateResult: function(data) {
            if (!data.id) return data.text;

            const level = $(data.element).data('level') || 'none';
            const text = data.text;
            const name = text.split(' (')[0];
            const badgeText = level !== 'none' && level !== 'umum' ?
              level.charAt(0).toUpperCase() + level.slice(1) :
              '';

            // Warna badge berdasarkan level
            let bgColor = '',
              iconColor = '';
            switch (level) {
              case 'gold':
                bgColor = '#FFD700';
                iconColor = '#b8860b';
                break;
              case 'silver':
                bgColor = '#C0C0C0';
                iconColor = '#708090';
                break;
              case 'bronze':
                bgColor = '#cd7f32';
                iconColor = '#8b4513';
                break;
              case 'platinum':
                bgColor = '#e5e4e2';
                iconColor = '#6a5acd';
                break;
              default:
                bgColor = '#eee';
                iconColor = '#555';
            }

            const container = $(`
    <div style="
      display: flex;
      align-items: center;
      padding: 6px;
    ">
      <div style="
        width: 28px;
        height: 28px;
        background-color: ${iconColor};
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        font-weight: bold;
        margin-right: 10px;
      ">
        <i class="fa fa-user"></i>
      </div>
      <div style="flex-grow: 1;">
        <div style="font-weight: 500; color: #000;">${name}</div>
      </div>
      ${badgeText ? `
        <div style="
          background-color: ${bgColor};
          color: white;
          padding: 2px 8px;
          border-radius: 12px;
          font-size: 11px;
          font-weight: bold;
          margin-left: 8px;
          text-transform: uppercase;
        ">${badgeText}</div>` : ''}
    </div>
  `);

            return container;
          },

          templateSelection: function(data) {
            return data.text;
          }

        });
      });
    </script>

    <!-- Modal Tambah Member Baru -->
    <div id="modalMember" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
      <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white w-[800px] rounded-lg shadow-lg p-6 relative">
          <h2 class="text-xl font-bold text-center mb-1">Pendaftaran Member Baru</h2>
          <p class="text-center text-sm text-gray-500 mb-4">Daftarkan pelanggan sebagai member untuk mendapatkan berbagai keuntungan</p>

          <!-- Tabs -->
          <div class="flex justify-center space-x-4 mb-6">
            <button id="tabBronze" class="px-4 py-2 rounded-md bg-gradient-to-r from-yellow-200 to-yellow-400 text-sm font-semibold">🥉 Bronze</button>
            <button id="tabSilver" class="px-4 py-2 rounded-md bg-gradient-to-r from-gray-300 to-gray-500 text-sm font-semibold">🥈 Silver</button>
            <button id="tabGold" class="px-4 py-2 rounded-md bg-gradient-to-r from-yellow-400 to-yellow-600 text-sm font-semibold">🥇 Gold</button>
          </div>

          <!-- Card Member Info -->
          <div id="memberCard" class="flex gap-6 mb-6">
            <div id="cardLevel" class="w-1/3 rounded-lg p-4 text-white bg-gradient-to-br from-yellow-400 to-yellow-600">
              <div class="text-center">
                <div class="text-3xl mb-2">🥇</div>
                <div class="text-lg font-bold">Gold</div>
                <div class="text-sm">Membership</div>
                <div class="text-2xl font-semibold mt-4">Rp 300.000</div>
                <div class="bg-white text-yellow-600 rounded-full text-xs mt-2 px-2 py-1 inline-block">Diskon 15%</div>
              </div>
            </div>

            <div class="w-2/3 text-sm">
              <h3 class="font-semibold mb-2">Keuntungan Member <span id="levelText">Gold</span></h3>
              <ul id="benefitList" class="space-y-2 text-gray-700">
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✓</span> Diskon 15% setiap transaksi</li>
              </ul>
            </div>
          </div>

          <!-- Form Input -->
          <form method="POST" action="" class="space-y-4">
            <input type="hidden" name="level_member" id="inputLevelMember" value="Gold">
            <div class="grid grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-medium">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="w-full mt-1 px-3 py-2 border rounded-md" placeholder="Masukkan nama lengkap">
              </div>
              <div>
                <label class="block text-sm font-medium">Nomor Telepon</label>
                <input type="text" name="telepon" class="w-full mt-1 px-3 py-2 border rounded-md" placeholder="Masukkan nomor telepon">
              </div>
              <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full mt-1 px-3 py-2 border rounded-md" placeholder="Masukkan email">
              </div>
              <div>
                <label class="block text-sm font-medium">Alamat</label>
                <input type="text" name="alamat" class="w-full mt-1 px-3 py-2 border rounded-md" placeholder="Masukkan alamat">
              </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-6">
              <button type="button" id="closeModalBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
              <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg">Daftar Member</button>
            </div>
          </form>
        </div>
      </div>


      <!-- Script -->
      <script>
        document.addEventListener("DOMContentLoaded", function() {
          const openBtn = document.getElementById("openModalBtn");
          const modal = document.getElementById("modalMember");
          const closeBtn = document.getElementById("closeModalBtn");

          openBtn.addEventListener("click", () => modal.classList.remove("hidden"));
          closeBtn.addEventListener("click", () => modal.classList.add("hidden"));
        });

        const tabs = {
          Bronze: {
            color: "from-yellow-200 to-yellow-400",
            text: "🥉 Bronze",
            benefit: ["Diskon 5% setiap transaksi"],
            harga: 150000,
            poin_awal: 0,
          },
          Silver: {
            color: "from-gray-300 to-gray-500",
            text: "🥈 Silver",
            benefit: ["Diskon 10% setiap transaksi"],
            harga: 250000,
            poin_awal: 500,
          },
          Gold: {
            color: "from-yellow-400 to-yellow-600",
            text: "🥇 Gold",
            benefit: ["Diskon 15% setiap transaksi"],
            harga: 350000,
            poin_awal: 1000,
          }
        };


        const tabButtons = {
          Bronze: document.getElementById("tabBronze"),
          Silver: document.getElementById("tabSilver"),
          Gold: document.getElementById("tabGold"),
        };

        function updateCard(level) {
          const card = document.getElementById("cardLevel");
          card.className = `w-1/3 rounded-lg p-4 text-white bg-gradient-to-br ${tabs[level].color}`;

          card.innerHTML = `
    <div class="text-center">
      <div class="text-3xl mb-2">${tabs[level].text.split(' ')[0]}</div>
      <div class="text-lg font-bold">${level}</div>
      <div class="text-sm">Membership</div>
      <div class="text-2xl font-semibold mt-4">Rp ${tabs[level].harga.toLocaleString('id-ID')}<span class="text-sm font-normal"> /tahun</span></div>
      <div class="bg-white text-yellow-600 rounded-full text-xs mt-2 px-2 py-1 inline-block">Diskon ${tabs[level].benefit[0].split(' ')[1]}</div>
    </div>
  `;

          // Perbarui label dan input tersembunyi
          document.getElementById("levelText").textContent = level;
          document.getElementById("inputLevelMember").value = level;

          const list = document.getElementById("benefitList");
          list.innerHTML = tabs[level].benefit
            .map(b => `<li class="flex items-center gap-2"><span class="text-green-500 font-bold">✓</span> ${b}</li>`)
            .join('');
        }


        Object.keys(tabButtons).forEach(level => {
          tabButtons[level].addEventListener("click", () => updateCard(level));
        });

        openBtn.addEventListener("click", () => modal.classList.remove("hidden"));
        closeBtn.addEventListener("click", () => modal.classList.add("hidden"));

        // Init with Gold by default
        updateCard("Gold");
      </script>

      <!-- logout -->
      <script>
        function confirmLogout() {
          if (confirm("Apakah Anda yakin ingin keluar?")) {
            window.location.href = "../handler/logout_handler.php";
          }
        }
      </script>


  </body>

  </html>