<?php
/**
 * Authentication Middleware
 * Checks if user is logged in and has proper access rights
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../auth/koneksi.php';

/**
 * Check if user is authenticated via session or cookies
 */
function isUserAuthenticated() {
    // Check session first
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        return true;
    }
    
    // Check cookies if session is empty
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username']) && isset($_COOKIE['login_token'])) {
        return validateUserFromCookies();
    }
    
    return false;
}

/**
 * Validate user from cookies and restore session
 */
function validateUserFromCookies() {
    global $koneksi;
    
    $userId = $_COOKIE['user_id'];
    $username = mysqli_real_escape_string($koneksi, $_COOKIE['username']);
    
    // Verify user still exists and is active
    $query = "SELECT id_pengguna, username, nama_lengkap, role, status FROM pengguna WHERE id_pengguna = '$userId' AND username = '$username'";
    $result = mysqli_query($koneksi, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Check if account is still active
        if (isset($user['status']) && $user['status'] === 'Inactive') {
            clearAuthCookies();
            return false;
        }
        
        // Restore session from cookies
        $_SESSION['user_id'] = $user['id_pengguna'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_time'] = time();
        
        return true;
    }
    
    // Invalid cookies, clear them
    clearAuthCookies();
    return false;
}

/**
 * Clear authentication cookies
 */
function clearAuthCookies() {
    $cookiesToClear = ['user_id', 'username', 'nama_lengkap', 'role', 'login_time', 'login_token'];
    $cookiePath = '/';
    
    foreach ($cookiesToClear as $cookie) {
        if (isset($_COOKIE[$cookie])) {
            setcookie($cookie, '', time() - 3600, $cookiePath);
        }
    }
}

/**
 * Check if user has required role
 */
function hasRole($requiredRoles = []) {
    if (empty($requiredRoles)) {
        return true; // No specific role required
    }
    
    $userRole = $_SESSION['role'] ?? '';
    
    // Convert single role to array
    if (is_string($requiredRoles)) {
        $requiredRoles = [$requiredRoles];
    }
    
    // Check if user role matches any of the required roles
    return in_array(strtolower($userRole), array_map('strtolower', $requiredRoles));
}

/**
 * Get current user data
 */
function getCurrentUser() {
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'nama_lengkap' => $_SESSION['nama_lengkap'] ?? null,
        'role' => $_SESSION['role'] ?? null,
        'login_time' => $_SESSION['login_time'] ?? null
    ];
}

/**
 * Redirect to login if not authenticated
 */
function requireAuth($requiredRoles = []) {
    if (!isUserAuthenticated()) {
        // Clear any invalid sessions/cookies
        session_destroy();
        clearAuthCookies();
        
        // Redirect to login
        header("Location: " . getLoginUrl());
        exit();
    }
    
    // Check role if specified
    if (!hasRole($requiredRoles)) {
        // Redirect to appropriate page based on user role
        redirectByRole();
        exit();
    }
}

/**
 * Get login URL based on current location
 */
function getLoginUrl() {
    $currentPath = $_SERVER['REQUEST_URI'];
    
    // Determine relative path to login
    if (strpos($currentPath, '/pages/') !== false) {
        return 'login-view.php';
    } else {
        return '../pages/login-view.php';
    }
}

/**
 * Redirect user based on their role
 */
function redirectByRole() {
    $userRole = $_SESSION['role'] ?? '';
    
    switch (strtolower($userRole)) {
        case 'admin':
            header("Location: dasboard-view.php");
            break;
        case 'kasir':
            header("Location: kasir-view.php");
            break;
        default:
            header("Location: " . getLoginUrl());
            break;
    }
}

/**
 * Get user display name for headers
 */
function getUserDisplayName() {
    return $_SESSION['nama_lengkap'] ?? $_SESSION['username'] ?? 'User';
}

/**
 * Check if current user is admin
 */
function isAdmin() {
    return hasRole(['admin']);
}

/**
 * Check if current user is kasir
 */
function isKasir() {
    return hasRole(['kasir']);
}
?>
