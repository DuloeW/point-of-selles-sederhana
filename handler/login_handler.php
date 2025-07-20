<?php
session_start();

require_once '../auth/koneksi.php';
require_once '../utils/tools_util.php';

/**
 * Validates login cookies and returns user data if valid
 */
function validateLoginCookies($koneksi)
{
    $requiredCookies = ['user_id', 'username', 'nama_lengkap', 'role', 'login_token'];

    // Check if all required cookies exist
    foreach ($requiredCookies as $cookie) {
        if (!isset($_COOKIE[$cookie])) {
            return false;
        }
    }

    $userId = $_COOKIE['user_id'];
    $username = mysqli_real_escape_string($koneksi, $_COOKIE['username']);

    // Verify user still exists and is active
    $query = "SELECT id_pengguna, username, nama_lengkap, role, status FROM pengguna WHERE id_pengguna = '$userId' AND username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Check if account is still active
        if (isset($user['status']) && $user['status'] === 'Inactive') {
            return false;
        }

        return $user;
    }

    return false;
}

/**
 * Clears all login cookies
 */
function clearLoginCookies()
{
    $cookiesToClear = ['user_id', 'username', 'nama_lengkap', 'role', 'login_time', 'login_token'];
    $cookiePath = '/';

    foreach ($cookiesToClear as $cookie) {
        if (isset($_COOKIE[$cookie])) {
            setcookie($cookie, '', time() - 3600, $cookiePath);
        }
    }
}

/**
 * Validates user credentials and returns user data if valid
 */
function authenticateUser($koneksi, $username, $password)
{
    // Sanitize input
    $username = mysqli_real_escape_string($koneksi, $username);

    // Query user by username only (don't include password in WHERE clause)
    $query = "SELECT id_pengguna, username, password, nama_lengkap, role, status FROM pengguna WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password hash
        if (password_verify($password, $user['password'])) {
            // Check if user is active
            if (isset($user['status']) && $user['status'] === 'Inactive') {
                return ['error' => 'inactive'];
            }
            return ['success' => true, 'user' => $user];
        } else {
            return ['error' => 'invalid_password'];
        }
    } else {
        return ['error' => 'user_not_found'];
    }
}

/**
 * Sets login cookies for persistent login
 */
function setLoginCookies($user)
{
    $cookieExpire = time() + (30 * 24 * 60 * 60); // 30 days
    $cookiePath = '/';
    $cookieDomain = '';
    $secure = false; // Set to true if using HTTPS
    $httpOnly = true; // Prevent XSS attacks

    // Set individual cookies
    setcookie('user_id', $user['id_pengguna'], $cookieExpire, $cookiePath, $cookieDomain, $secure, $httpOnly);
    setcookie('username', $user['username'], $cookieExpire, $cookiePath, $cookieDomain, $secure, $httpOnly);
    setcookie('nama_lengkap', $user['nama_lengkap'], $cookieExpire, $cookiePath, $cookieDomain, $secure, $httpOnly);
    setcookie('role', $user['role'], $cookieExpire, $cookiePath, $cookieDomain, $secure, $httpOnly);
    setcookie('login_time', time(), $cookieExpire, $cookiePath, $cookieDomain, $secure, $httpOnly);

    // Set a secure token for validation
    $loginToken = hash('sha256', $user['id_pengguna'] . $user['username'] . time() . 'secret_salt');
    setcookie('login_token', $loginToken, $cookieExpire, $cookiePath, $cookieDomain, $secure, $httpOnly);
}

/**
 * Redirects user based on their role
 */
function redirectUserByRole($role)
{
    switch (strtolower($role)) {
        case 'admin':
            header("Location: ../pages/dasboard-view.php");
            break;
        case 'kasir':
            header("Location: ../pages/kasir-view.php");
            break;
        default:
            header("Location: ../index.php");
            break;
    }
    exit();
}

/**
 * Handles login errors with appropriate redirects
 */
function handleLoginError($error)
{
    switch ($error) {
        case 'user_not_found':
            header("Location: ../pages/login-view.php?pesan=gagal-user");
            break;
        case 'invalid_password':
            header("Location: ../pages/login-view.php?pesan=gagal-pass");
            break;
        case 'inactive':
            header("Location: ../pages/login-view.php?pesan=akun-nonaktif");
            break;
        default:
            header("Location: ../pages/login-view.php?pesan=gagal");
            break;
    }
    exit();
}

// Check for existing valid cookies (auto-login)
if (!isset($_SESSION['user_id'])) {
    $cookieUser = validateLoginCookies($koneksi);
    if ($cookieUser) {
        // Auto-login from cookies
        $_SESSION['user_id'] = $cookieUser['id_pengguna'];
        $_SESSION['username'] = $cookieUser['username'];
        $_SESSION['nama_lengkap'] = $cookieUser['nama_lengkap'];
        $_SESSION['role'] = $cookieUser['role'];
        $_SESSION['login_time'] = time();


        // Refresh cookies
        setLoginCookies($cookieUser);

        // Redirect to appropriate page based on role
        redirectUserByRole($cookieUser['role']);
    }
}

// Main login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['username']) || empty($_POST['password'])) {
        header("Location: ../pages/login-view.php?pesan=field-kosong");
        exit();
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Authenticate user
    $authResult = authenticateUser($koneksi, $username, $password);
    if (isset($authResult['success']) && $authResult['success']) {
        // Login successful
        $user = $authResult['user'];

        // Set session variables
        $_SESSION['user_id'] = $user['id_pengguna'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_time'] = time();

        echo "<script>console.log('Login successful for user: {$user['id_pengguna']}');</script>";

        // Set login cookies for persistent login
        setLoginCookies($user);

        // Redirect based on role
        redirectUserByRole($user['role']);
    } else {
        // Login failed
        handleLoginError($authResult['error']);
    }
} else {
    // Not a POST request, redirect to login page
    header("Location: ../pages/login-view.php");
    exit();
}