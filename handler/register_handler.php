<?php

include '../auth/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];
$nama_lengkap = $_POST['nama_lengkap'];
$role = $_POST['role'];
$status = $_POST['status'];

function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function isUserNameExists($koneksi, $username)
{
    $data = mysqli_query($koneksi, "SELECT username from pengguna where username = '$username'");
    return mysqli_num_rows($data) > 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isUserNameExists($koneksi, $username)) {
        echo "<script>alert('Username sudah ada!');</script>";
    } else {
        $hashedPassword = hashPassword($password);
        $query = "INSERT INTO pengguna (id_pengguna, username, password, nama_lengkap, role, status) VALUES (null, '$username', '$hashedPassword', '$nama_lengkap', '$role', '$status')";

        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Registrasi berhasil!');</script>";
        } else {
            echo "<script>alert('Registrasi gagal!');</script>";
        }
    }
    header("location:/point-of-sales-sederhana/pages/register-view.php");
    exit();
}
