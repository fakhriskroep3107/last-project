<?php
/**
 * Database Configuration
 * File koneksi database menggunakan PDO
 */

// Konfigurasi database
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'perpustakaan');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Error reporting (ubah ke 0 di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set 1 jika menggunakan HTTPS

/**
 * Fungsi untuk mendapatkan koneksi database
 * @return PDO
 */
function getConnection() {
    static $connection = null;
    
    if ($connection === null) {
        try {
            $dsn = sprintf(
                "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                DB_HOST,
                DB_PORT,
                DB_NAME,
                DB_CHARSET
            );
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
            ];
            
            $connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            // Log error (dalam production, jangan tampilkan error ke user)
            error_log("Database Connection Error: " . $e->getMessage());
            die("Koneksi database gagal. Silakan hubungi administrator.");
        }
    }
    
    return $connection;
}

/**
 * Fungsi helper untuk eksekusi query
 */
function executeQuery($sql, $params = []) {
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

/**
 * Fungsi helper untuk fetch single row
 */
function fetchOne($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetch();
}

/**
 * Fungsi helper untuk fetch multiple rows
 */
function fetchAll($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetchAll();
}

/**
 * Fungsi helper untuk insert dan return last ID
 */
function insert($sql, $params = []) {
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $conn->lastInsertId();
}

/**
 * Fungsi untuk begin transaction
 */
function beginTransaction() {
    return getConnection()->beginTransaction();
}

/**
 * Fungsi untuk commit transaction
 */
function commit() {
    return getConnection()->commit();
}

/**
 * Fungsi untuk rollback transaction
 */
function rollback() {
    return getConnection()->rollBack();
}

// Inisialisasi koneksi (untuk memastikan database tersedia)
try {
    getConnection();
} catch (Exception $e) {
    error_log("Failed to initialize database connection: " . $e->getMessage());
}