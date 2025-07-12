<?php
require '../auth/koneksi.php';
require '../utils/produk_util.php';
require '../utils/penjualan_util.php';

// Start session
session_start();

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/kasir-view.php");
    exit();
}

// Validate required fields
$required_fields = ['metode', 'bayar'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo "<script>alert('Field $field harus diisi!');history.back();</script>";
        exit();
    }
}

// Check if cart is not empty
if (empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang kosong! Silakan tambahkan produk terlebih dahulu.');history.back();</script>";
    exit();
}

// Sanitize input data
$metode_pembayaran = trim($_POST['metode']);
$jumlah_bayar = str_replace(['.', ','], '', $_POST['bayar']); // Remove formatting
$jumlah_bayar = floatval($jumlah_bayar);
$id_pelanggan = isset($_SESSION['id_pelanggan']) && $_SESSION['id_pelanggan'] !== 'umum' ? intval($_SESSION['id_pelanggan']) : null;
$id_kasir = $_SESSION['user_id']; // Default kasir ID - you should get this from session

// Calculate totals from cart
$subtotal = 0;
$cart_items = [];

foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
    $produk = getProdukById($id_produk);
    
    if (!$produk) {
        echo "<script>alert('Produk dengan ID $id_produk tidak ditemukan!');history.back();</script>";
        exit();
    }
    
    // Check stock availability
    if ($produk['stok'] < $jumlah) {
        echo "<script>alert('Stok produk {$produk['nama_produk']} tidak mencukupi! Stok tersedia: {$produk['stok']}');history.back();</script>";
        exit();
    }
    
    $harga_saat_ini = $produk['harga_jual'];
    $subtotal_item = $harga_saat_ini * $jumlah;
    $subtotal += $subtotal_item;
    
    $cart_items[] = [
        'id_produk' => $id_produk,
        'nama_produk' => $produk['nama_produk'],
        'jumlah' => $jumlah,
        'harga_saat_ini' => $harga_saat_ini,
        'subtotal' => $subtotal_item,
        'stok_tersedia' => $produk['stok']
    ];
}

// Calculate member discount
$diskon_persen = 0;
$diskon_nominal = 0;
$total_akhir = $subtotal;

if ($id_pelanggan) {
    $query_diskon = $koneksi->prepare("SELECT m.level_member, d.persentase_diskon
                                       FROM member m
                                       JOIN diskon_member d ON m.level_member = d.level_member
                                       WHERE m.id_pelanggan = ?");
    $query_diskon->bind_param("i", $id_pelanggan);
    $query_diskon->execute();
    $result_diskon = $query_diskon->get_result();
    
    if ($row_diskon = $result_diskon->fetch_assoc()) {
        $diskon_persen = (float)$row_diskon['persentase_diskon'];
        $diskon_nominal = $subtotal * ($diskon_persen / 100);
        $total_akhir = $subtotal - $diskon_nominal;
    }
}

// Validate payment amount
if ($jumlah_bayar < $total_akhir) {
    $format_total = number_format($total_akhir, 0, ',', '.');
    $format_bayar = number_format($jumlah_bayar, 0, ',', '.');
    echo "<script>alert('Jumlah pembayaran tidak mencukupi!\\nTotal: Rp $format_total\\nBayar: Rp $format_bayar');history.back();</script>";
    exit();
}

// Calculate change
$kembalian = $jumlah_bayar - $total_akhir;

// Convert payment method
$tipe_pembayaran_map = [
    'cash' => 'Cash',
    'qris' => 'QRIS',
    'debit' => 'Debit',
    'transfer' => 'Credit'
];
$tipe_pembayaran = $tipe_pembayaran_map[$metode_pembayaran] ?? 'Cash';

// Begin transaction
$koneksi->begin_transaction();

try {
    // Generate invoice number
    $invoice_number = generateInvoiceNumber();
    
    // Insert into penjualan table
    $stmt_penjualan = $koneksi->prepare("INSERT INTO penjualan 
        (nomor_invoice, total_bayar, jumlah_bayar, kembalian, tipe_pembayaran, id_kasir, id_pelanggan, status_penjualan) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Completed')");
    
    $stmt_penjualan->bind_param("sdddsii", 
        $invoice_number, 
        $total_akhir, 
        $jumlah_bayar, 
        $kembalian, 
        $tipe_pembayaran, 
        $id_kasir, 
        $id_pelanggan
    );
    
    if (!$stmt_penjualan->execute()) {
        throw new Exception("Gagal menyimpan data penjualan: " . $stmt_penjualan->error);
    }
    
    $id_penjualan = $koneksi->insert_id;
    
    // Insert detail penjualan and update stock
    $stmt_detail = $koneksi->prepare("INSERT INTO detail_penjualan 
        (id_penjualan, id_produk, jumlah_beli, harga_saat_ini, subtotal) 
        VALUES (?, ?, ?, ?, ?)");
    
    $stmt_update_stock = $koneksi->prepare("UPDATE produk SET stok = stok - ? WHERE id_produk = ?");
    
    foreach ($cart_items as $item) {
        // Insert detail penjualan
        $stmt_detail->bind_param("iiidd", 
            $id_penjualan, 
            $item['id_produk'], 
            $item['jumlah'], 
            $item['harga_saat_ini'], 
            $item['subtotal']
        );
        
        if (!$stmt_detail->execute()) {
            throw new Exception("Gagal menyimpan detail penjualan untuk produk " . $item['nama_produk'] . ": " . $stmt_detail->error);
        }
        
        // Update stock
        $stmt_update_stock->bind_param("ii", $item['jumlah'], $item['id_produk']);
        
        if (!$stmt_update_stock->execute()) {
            throw new Exception("Gagal mengupdate stok untuk produk " . $item['nama_produk'] . ": " . $stmt_update_stock->error);
        }
    }
    
    // Update member points if applicable
    if ($id_pelanggan) {
        $poin_tambahan = floor($total_akhir / 10000); // 1 point per 10,000 spent
        if ($poin_tambahan > 0) {
            $stmt_poin = $koneksi->prepare("UPDATE member SET poin = poin + ? WHERE id_pelanggan = ?");
            $stmt_poin->bind_param("ii", $poin_tambahan, $id_pelanggan);
            $stmt_poin->execute();
        }
    }
    
    // Commit transaction
    $koneksi->commit();
    
    // Clear cart
    $_SESSION['keranjang'] = [];
    unset($_SESSION['id_pelanggan']);
    
    // Prepare success message with transaction details
    $format_subtotal = number_format($subtotal, 0, ',', '.');
    $format_diskon = number_format($diskon_nominal, 0, ',', '.');
    $format_total = number_format($total_akhir, 0, ',', '.');
    $format_bayar = number_format($jumlah_bayar, 0, ',', '.');
    $format_kembalian = number_format($kembalian, 0, ',', '.');
    
    $success_message = "Transaksi berhasil!";
    
    echo "<script>alert('$success_message');window.location='../pages/kasir-view.php';</script>";
    
} catch (Exception $e) {
    // Rollback transaction
    $koneksi->rollback();
    
    echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "');history.back();</script>";
    exit();
}

// Function to generate invoice number
function generateInvoiceNumber() {
    global $koneksi;
    
    $today = date('Ymd');
    $prefix = 'INV' . $today;
    
    // Get last invoice number for today
    $query = $koneksi->prepare("SELECT nomor_invoice FROM penjualan 
                               WHERE nomor_invoice LIKE ? 
                               ORDER BY nomor_invoice DESC LIMIT 1");
    $search_pattern = $prefix . '%';
    $query->bind_param("s", $search_pattern);
    $query->execute();
    $result = $query->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $last_number = substr($row['nomor_invoice'], -3);
        $next_number = str_pad(intval($last_number) + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $next_number = '001';
    }
    
    return $prefix . $next_number;
}
?>
