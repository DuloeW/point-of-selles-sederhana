<?php

include '../auth/koneksi.php';
include '../utils/tools_util.php';

// Load environment variables
$envPath = __DIR__ . '/../.env';
$env = loadEnv($envPath);

// Debug: Check if env loaded correctly
if (empty($env)) {
    die("Error: Unable to load environment variables from .env file");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $role = $_POST['role'];
    $kunci_unik = $_POST['kunci_unik'];

    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    function isUserNameExists($koneksi, $username)
    {
        $data = mysqli_query($koneksi, "SELECT username from pengguna where username = '$username'");
        return mysqli_num_rows($data) > 0;
    }

    if (isUserNameExists($koneksi, $username)) {
        echo "<script>alert('Username sudah ada!'); window.location.href='../pages/register-view.php';</script>";
    } else {
        if ($kunci_unik == $env['SECREET_KEY_ADMIN'] || $kunci_unik == $env['SECREET_KEY_KASIR']) {
            $hashedPassword = hashPassword($password);
            $query = "INSERT INTO pengguna (id_pengguna, username, password, nama_lengkap, role) VALUES (null, '$username', '$hashedPassword', '$nama_lengkap', '$role')";

            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Registrasi berhasil!'); window.location.href='../pages/register-view.php';</script>";
            } else {
                echo "<script>alert('Registrasi gagal: " . mysqli_error($koneksi) . "'); window.location.href='../pages/register-view.php';</script>";
            }
        } else {
            echo "<script>alert('Kunci unik tidak valid!'); window.location.href='../pages/register-view.php';</script>";
        }
    }
} else {
    header("location: ../pages/register-view.php");
    exit();
}
