<?php
session_start();

include '../auth/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$data = mysqli_query($koneksi, "select * from pengguna where username='$username' AND password='$password'");

$cek = mysqli_num_rows($data);


if ($cek > 0) {
    $row = mysqli_fetch_assoc($data);
    $_SESSION['username'] = $username;
    $role = $row['role'];

    if ($role == "Admin") {
        header("location: ../pages/dasboard-view.php");
    } else {
        header("location: ../pages/kasir-view.php");
    }
} else {
    header("location: ../pages/login-view.php?pesan=gagal-user");
}

// if( $cek > 0){
//     $row = mysqli_fetch_assoc($data);
//     if(password_verify($password, $row['passowrd'])) {
//         $_SESSION['username'] = $username;

//         $role = $row['role'];
//         if($role == "Admin") {
//             header("location: ../pages/dasboard-view.php");
//         } else {
//             header("location: ../index.php");
//         }   
//     } else {
//         header("location: ../pages/login-view.php?pesan=gagal-pass");
//     }
// } else{
//     header("location: ../pages/login-view.php?pesan=gagal-user");
// }
