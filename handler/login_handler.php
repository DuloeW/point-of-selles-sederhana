<?php
session_start();

require_once '../auth/koneksi.php';
require_once '../middleware/auth_middleware.php';

/**
 * Validates user credentials and returns user data if valid
 */
function authenticateUser($koneksi, $username, $password)
{
    // Sanitize input
    $username = mysqli_real_escape_string($koneksi, $username);

    // Query user by username
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

// Check if user is already logged in
if (isUserAuthenticated()) {
    $user = getCurrentUser();
    redirectUserByRole($user['role']);
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

        // Set session (hanya nama dan role)
        setUserSession($user['nama_lengkap'], $user['role'], $user['id_pengguna']);

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