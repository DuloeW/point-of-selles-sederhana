<?php
require_once '../middleware/auth_middleware.php';

session_start();

// Clear authentication cookies
clearAuthCookies();

// Clear session
session_unset(); // Menghapus semua variabel session
session_destroy(); // Menghapus session

header("Location:../pages/login-view.php"); // Redirect ke halaman login
exit;
?>
