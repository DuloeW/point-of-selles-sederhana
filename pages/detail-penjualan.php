<?php
include '../koneksi.php'; // ganti path sesuai struktur proyek kamu

$invoice = 'INV001'; // bisa dari $_GET['invoice']

$query = "
SELECT 
    p.nama_produk,
    dp.harga_saat_ini AS harga_satuan,
    dp.jumlah_beli,
    dp.subtotal,
    CASE
        WHEN m.level_member IS NOT NULL THEN 
            dp.subtotal * (dm.persentase_diskon / 100)
        ELSE 0
    END AS diskon,
    CASE
        WHEN m.level_member IS NOT NULL THEN 
            dp.subtotal - (dp.subtotal * (dm.persentase_diskon / 100))
        ELSE dp.subtotal
    END AS total_setelah_diskon
FROM detail_penjualan dp
JOIN produk p ON dp.id_produk = p.id_produk
JOIN penjualan pj ON dp.id_penjualan = pj.id_penjualan
LEFT JOIN pelanggan pl ON pj.id_pelanggan = pl.id_pelanggan
LEFT JOIN member m ON pl.id_pelanggan = m.id_pelanggan
LEFT JOIN diskon_member dm ON m.level_member = dm.level_member
WHERE pj.nomor_invoice = '$invoice';
";

$result = mysqli_query($koneksi, $query);
?>

<!-- Tabel Tampilan -->
<div class="p-4 bg-white rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">Detail Penjualan - <?= $invoice ?></h2>
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-sm font-semibold">
                <tr>
                    <th class="py-2 px-4">Nama Produk</th>
                    <th class="py-2 px-4">Harga Satuan</th>
                    <th class="py-2 px-4">Jumlah Beli</th>
                    <th class="py-2 px-4">Subtotal</th>
                    <th class="py-2 px-4">Diskon</th>
                    <th class="py-2 px-4">Total Akhir</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr class="border-t">
                        <td class="py-2 px-4"><?= htmlspecialchars($row['nama_produk']) ?></td>
                        <td class="py-2 px-4">Rp <?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                        <td class="py-2 px-4"><?= $row['jumlah_beli'] ?></td>
                        <td class="py-2 px-4">Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                        <td class="py-2 px-4 text-red-600">Rp <?= number_format($row['diskon'], 0, ',', '.') ?></td>
                        <td class="py-2 px-4 font-semibold">Rp <?= number_format($row['total_setelah_diskon'], 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <a href="halaman-sebelumnya.php" class="mt-6 inline-block bg-red-600 text-white px-6 py-2 rounded-full shadow hover:bg-red-700">
        kembali
    </a>
</div>
