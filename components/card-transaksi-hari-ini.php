<div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-700 rounded-full flex items-center justify-center text-white font-bold">
            <?= substr($username, 0, 1) ?>
        </div>
        <div>
            <p class="font-medium text-gray-800"><?= $nomor_invoice ?></p>
            <p class="text-sm text-gray-500"><?= $username ?></p>
        </div>
    </div>
    <div class="text-right">
        <p class="font-semibold text-green-600">Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
        <?php if ($status_penjualan == "Pending") { ?>
            <span class="px-2 py-1 bg-yellow-100 text-green-700 text-xs rounded-full"><?= $status_penjualan ?></span>
        <?php } else if ($status_penjualan == "Cancelled") { ?>
            <span class="px-2 py-1 bg-red-100 text-green-700 text-xs rounded-full"><?= $status_penjualan ?></span>
        <?php } else { ?>
            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full"><?= $status_penjualan ?></span>
        <?php } ?>
    </div>
</div>