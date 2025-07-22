<?php
/**
 * Simple Authentication Middleware
 * Menggunakan session sederhana yang hanya menyimpan role dan nama
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is authenticated via session
 */
function isUserAuthenticated() {
    return isset($_SESSION['role']) && isset($_SESSION['nama']);
}

/**
 * Check if user has required role
 */
function hasRole($requiredRoles = []) {
    if (!isUserAuthenticated()) {
        return false;
    }
    
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
        'nama' => $_SESSION['nama'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}

/**
 * Redirect to login if not authenticated
 */
function requireAuth($requiredRoles = []) {
    if (!isUserAuthenticated()) {
        // Clear session
        session_destroy();
        
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
    return $_SESSION['nama'] ?? 'User';
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

/**
 * Set user session after successful login
 */
function setUserSession($nama, $role, $user_id) {
    $_SESSION['nama'] = $nama;
    $_SESSION['role'] = $role;
    $_SESSION['user_id'] = $user_id;
}

/**
 * Clear user session
 */
function clearUserSession() {
    session_unset();
    session_destroy();
}
?>
