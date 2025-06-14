  <?php
  require '../utils/produk_util.php';
  require '../utils/keranjang_util.php';

  $kategoriDipilih = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';

  $queryKategori = "SELECT DISTINCT kategori FROM produk WHERE kategori IS NOT NULL AND kategori != ''";
  $resultKategori = $koneksi->query($queryKategori);

  $produkList = filterProdukByKategori($kategoriDipilih);

  $queryPelanggan = "SELECT pelanggan.id_pelanggan, pelanggan.nama_lengkap, member.level_member 
                   FROM pelanggan 
                   LEFT JOIN member ON pelanggan.id_pelanggan = member.id_pelanggan";
  $resultPelanggan = $koneksi->query($queryPelanggan);

  session_start();
  if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
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

  ?>



  <!DOCTYPE html>
  <html lang="id">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  </head>

  <body class="bg-gradient-to-b from-gray-100 to-gray-200 font-sans">

    <!-- Header -->
    <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white shadow">
      <img src="../assets/logo.png" alt=""
        class="w-24 ">
      <div class="flex items-center gap-4">
        <span class="text-sm">Online</span>
        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
        <a href="../pages/logout.php"
          class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white px-4 py-1 rounded inline-block">
          Keluar
        </a>

      </div>
    </div>

    <div class="grid grid-cols-3 gap-4 px-6 py-4">
      <!-- Katalog Produk -->
      <div class="col-span-2">
        <!-- Info Panel -->
        <div class="grid grid-cols-1 gap-4 mb-4">
          <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white p-4 rounded-xl shadow">
            <h2 class="text-sm">Total Produk</h2>
            <p class="text-4xl font-bold"><?= getTotalPruduk() ?></p>
          </div>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="flex gap-2 mb-4">
          <form action="" class="flex w-full gap-2">
            <input
              type="text"
              placeholder="Cari produk..."
              class="flex-grow px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300" />
            <button
              class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white px-4 py-2 rounded-xl whitespace-nowrap">
              Scan Barcode
            </button>
          </form>
        </div>

        <!-- Kategori -->
        <div class="grid grid-cols-4 gap-2 mb-4">
          <?php
          $isSemua = $kategoriDipilih === 'Semua';
          $semuaClass = $isSemua
            ? 'bg-indigo-600 text-white'
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
              ? 'bg-indigo-600 text-white'
              : 'bg-gray-200 hover:bg-gray-300 text-gray-800';
            ?>
            <a href="?kategori=<?= urlencode($kategoriSekarang) ?>"
              class="<?= $btnClass ?> text-center px-4 py-2 rounded-xl text-sm font-semibold w-full">
              <?= htmlspecialchars($kategoriSekarang) ?>
            </a>


          <?php endwhile; ?>
        </div>

        <!-- listproduk -->
        <div class="grid grid-cols-3 gap-4">
          <?php if (!empty($produkList)): ?>
            <?php foreach ($produkList as $produk): ?>
              <div class="bg-white rounded-xl shadow flex flex-col items-center p-4 text-center hover:shadow-lg transition">
                <div class="flex justify-center items-center w-full h-24 bg-gray-100 rounded-lg mb-4">
                  <img src="../assets/<?= $produk['foto_produk']; ?>" alt="<?= $produk['nama_produk']; ?>" class="h-20 object-cover">
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
            <select id="select-member" name="id_pelanggan" class="select-member w-full">
              <option value="umum" data-level="umum">Pelanggan Umum</option>
              <?php while ($row = $resultPelanggan->fetch_assoc()): ?>
                <?php
                $nama = htmlspecialchars($row['nama_lengkap']);
                $level = $row['level_member'] ?? 'none';
                $label = $level !== 'none' ? "$nama ($level)" : $nama;
                ?>
                <option value="<?= $row['id_pelanggan'] ?>" data-level="<?= strtolower($level) ?>"><?= $label ?></option>
              <?php endwhile; ?>
            </select>


            <button
              id="openModalBtn"
              class="w-full mt-2 inline-flex justify-center items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:from-purple-600 hover:to-indigo-700 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Tambah Member Baru
            </button>


          </div>

          <!-- Item Keranjang -->
          <?php
          $subtotal = 0;

          if (!empty($_SESSION['keranjang'])):
            foreach ($_SESSION['keranjang'] as $idProduk => $jumlah):
              $produk = getProdukById($idProduk); // Buat function ini di utils/produk_util.php
              $totalHargaItem = $produk['harga_jual'] * $jumlah;
              $subtotal += $totalHargaItem;
          ?>
              <div class="border rounded-lg p-3 mb-4 bg-white shadow-sm">
                <div class="flex justify-between">
                  <div>
                    <p class="font-semibold"><?= $produk['nama_produk']; ?></p>
                    <p class="text-sm text-gray-500">Rp <?= number_format($produk['harga_jual'], 0, ',', '.'); ?> × <?= $jumlah ?></p>
                  </div>
                  <div class="flex items-center gap-2">
                    <a href="?kurang=<?= $idProduk ?>&kategori=<?= urlencode($kategoriDipilih) ?>" class="px-2 bg-gray-200 rounded hover:bg-gray-300">−</a>
                    <span><?= $jumlah ?></span>
                    <a href="?tambah=<?= $idProduk ?>&kategori=<?= urlencode($kategoriDipilih) ?>" class="px-2 bg-gray-200 rounded hover:bg-gray-300">+</a>
                    <a href="?hapus=<?= $idProduk ?>&kategori=<?= urlencode($kategoriDipilih) ?>" class="flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-red-500 to-red-700 text-white rounded hover:from-red-600 hover:to-red-800 transition">
                      🗑 <span class="text-xs font-semibold">Hapus</span>
                    </a>
                  </div>
                </div>
              </div>
            <?php
            endforeach;
          else:
            ?>
            <div class="flex flex-col items-center justify-center text-gray-500 py-12">
              <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart" class="w-24 h-24 mb-4 opacity-70">
              <p class="text-lg font-semibold">Keranjang masih kosong</p>
              <p class="text-sm text-gray-400">Silakan pilih produk dari katalog.</p>
            </div>

          <?php endif; ?>


          <!-- Total -->
          <div class="mb-4">
            <p class="text-sm text-gray-600">Subtotal: Rp <?= number_format($subtotal, 0, ',', '.'); ?></p>
            <p class="text-lg font-bold text-indigo-700">Total: Rp <?= number_format($subtotal, 0, ',', '.'); ?></p>
          </div>


          <!-- Pembayaran -->
          <!-- Metode Pembayaran -->
          <div class="mb-4">
            <label for="metode" class="block text-sm font-semibold text-gray-700 mb-1">
              🧾 Metode Pembayaran
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
            <label for="bayar" class="block text-sm font-semibold text-gray-700 mb-1">
              💰 Jumlah Bayar
            </label>
            <input
              type="text"
              id="bayar"
              placeholder="Masukkan jumlah pembayaran"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300" />
          </div>

          <!-- Kembalian -->
          <div id="kembalianDisplay" class="hidden mt-2 mb-4 p-3 rounded-lg bg-gradient-to-r from-green-100 to-green-200 border border-green-300">
            <p class="text-green-800 text-sm font-semibold">Kembalian:</p>
            <p id="jumlahKembalian" class="text-xl font-bold text-green-700">Rp 0</p>
          </div>


          <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-bold">
            ✓ Proses Pembayaran
          </button>
        </div>
      </div>
    </div>
    <script>
      const inputBayar = document.getElementById("bayar");
      const totalHarga = <?= $subtotal ?>;
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
        $('#select-member').select2({
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


  </body>

  </html>