<?php
/**
 * Authentication Middleware
 * Pengecekan otentikasi dan otorisasi user
 */

// Start session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Require Login
 * Memastikan user sudah login
 */
function requireLogin() {
    if (!isLoggedIn()) {
        alertRedirect('Silakan login terlebih dahulu!', 'auth/login.php');
    }
}

/**
 * Require Admin
 * Memastikan user adalah admin
 */
function requireAdmin() {
    requireLogin();
    
    if (!isAdmin()) {
        alertRedirect('Akses ditolak! Halaman ini hanya untuk Admin.', 'user/dashboard.php');
    }
}

/**
 * Require User
 * Memastikan user adalah anggota biasa
 */
function requireUser() {
    requireLogin();
    
    if (!isUser()) {
        alertRedirect('Akses ditolak! Halaman ini hanya untuk Anggota.', 'admin/dashboard.php');
    }
}

/**
 * Require Guest
 * Memastikan user belum login (untuk halaman login/register)
 */
function requireGuest() {
    if (isLoggedIn()) {
        if (isAdmin()) {
            redirect('admin/dashboard.php');
        } else {
            redirect('user/dashboard.php');
        }
    }
}

/**
 * Check Permission
 * Cek apakah user punya akses ke resource tertentu
 */
function checkPermission($resource, $action = 'view') {
    // Admin bisa akses semua
    if (isAdmin()) {
        return true;
    }
    
    // Define permissions untuk user biasa
    $userPermissions = [
        'books' => ['view'],
        'peminjaman' => ['view'],
    ];
    
    if (isset($userPermissions[$resource])) {
        return in_array($action, $userPermissions[$resource]);
    }
    
    return false;
}

/**
 * Login User
 * Set session data setelah login berhasil
 */
function loginUser($userData) {
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['user_name'] = $userData['name'];
    $_SESSION['user_email'] = $userData['email'];
    $_SESSION['user_role'] = $userData['role'];
    $_SESSION['login_time'] = time();
    
    // Regenerate session ID untuk keamanan
    session_regenerate_id(true);
}

/**
 * Logout User
 * Hapus semua session data
 */
function logoutUser() {
    $_SESSION = [];
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    
    session_destroy();
}

/**
 * Check Session Timeout
 * Logout otomatis jika inactive terlalu lama
 */
function checkSessionTimeout($timeout = 3600) { // 1 jam default
    if (isset($_SESSION['login_time'])) {
        $elapsed = time() - $_SESSION['login_time'];
        
        if ($elapsed > $timeout) {
            logoutUser();
            alertRedirect('Session timeout. Silakan login kembali.', 'auth/login.php');
        }
        
        // Update last activity time
        $_SESSION['login_time'] = time();
    }
}

/**
 * Verify CSRF Token
 * Validasi token untuk form submission
 */
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Generate CSRF Token
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Get CSRF Hidden Input
 */
function csrfField() {
    $token = generateCsrfToken();
    return "<input type='hidden' name='csrf_token' value='$token'>";
}