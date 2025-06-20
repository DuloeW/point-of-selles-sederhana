<?php

date_default_timezone_set('Asia/Makassar');

function getFormattedDateAndDay()
{
    $hari = date('l');
    $tanggal = date('d');
    $bulan = date('F');
    $tahun = date('Y');
    $formattedDate = "$hari, $tanggal $bulan $tahun";

    return $formattedDate;
}

function getFormattedDate()
{
    $hari = date('d');
    $bulan = date('m');
    $tahun = date('Y');
    $formattedDate = "$hari/$bulan/$tahun";

    return $formattedDate;
}

function getFormattedTime()
{
    return date('H.i');
}

function cariProdukByKode($kode_produk)
{
    global $koneksi;
    $kode_produk = mysqli_real_escape_string($koneksi, $kode_produk);
    $query = "SELECT * FROM produk WHERE kode_produk = '$kode_produk'";
    $result = mysqli_query($koneksi, $query);
    return $result ? mysqli_fetch_assoc($result) : null;
}

// Fungsi untuk membangun URL dengan parameter yang sudah ada
function buildUrlWithParams($newKategori)
{
    $params = $_GET; // Ambil semua parameter yang ada
    $params['kategori'] = $newKategori; // Update kategori
    return '?' . http_build_query($params);
}

// Function to read .env file
function loadEnv($filePath) {
    $env = [];
    if (file_exists($filePath)) {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments and empty lines
            if (strpos(trim($line), '#') === 0 || empty(trim($line))) {
                continue;
            }
            
            // Parse key=value pairs
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes if present
                $value = trim($value, '"\'');                
                $env[$key] = $value;
            }
        }
    }
    return $env;
}
