<?php
require_once '../middleware/auth_middleware.php';

// Clear user session
clearUserSession();

// Redirect to login page
header("Location: ../pages/login-view.php");
exit;
?>
