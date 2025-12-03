<?php
/**
 * Helper Functions
 * Fungsi-fungsi bantuan yang digunakan di seluruh aplikasi
 */

/**
 * Sanitasi input untuk mencegah XSS
 */
function clean($data) {
    if (is_array($data)) {
        return array_map('clean', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect ke halaman lain
 */
function redirect($url, $message = null, $type = 'info') {
    if ($message) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type; // success, error, warning, info
    }
    header("Location: $url");
    exit();
}

/**
 * Alert JavaScript dan redirect
 */
function alertRedirect($message, $url) {
    echo "<script>
        alert('$message');
        window.location='$url';
    </script>";
    exit();
}

/**
 * Get flash message dan hapus dari session
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}

/**
 * Check if user is admin
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Check if user is regular user
 */
function isUser() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user';
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user role
 */
function getCurrentUserRole() {
    return $_SESSION['user_role'] ?? null;
}

/**
 * Format tanggal Indonesia
 */
function formatTanggal($date, $format = 'd M Y') {
    if (empty($date)) return '-';
    return date($format, strtotime($date));
}

/**
 * Hitung selisih hari
 */
function hitungHari($date1, $date2) {
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    return $interval->days;
}

/**
 * Upload file dengan validasi
 */
function uploadFile($file, $targetDir = '../uploads/', $allowedTypes = ['jpg', 'jpeg', 'png']) {
    if (!isset($file['name']) || empty($file['name'])) {
        return ['success' => false, 'message' => 'Tidak ada file yang diupload'];
    }
    
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    $fileError = $file['error'];
    
    if ($fileError !== 0) {
        return ['success' => false, 'message' => 'Error saat upload file'];
    }
    
    if ($fileSize > 2000000) { // 2MB
        return ['success' => false, 'message' => 'Ukuran file terlalu besar (max 2MB)'];
    }
    
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if (!in_array($fileExt, $allowedTypes)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
    }
    
    // Generate unique filename
    $newFileName = uniqid('AVA-', true) . '.' . $fileExt;
    $targetPath = $targetDir . $newFileName;
    
    // Create directory if not exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    if (move_uploaded_file($fileTmp, $targetPath)) {
        return ['success' => true, 'filename' => $newFileName];
    }
    
    return ['success' => false, 'message' => 'Gagal memindahkan file'];
}

/**
 * Delete file
 */
function deleteFile($filename, $directory = '../uploads/') {
    $filepath = $directory . $filename;
    if (file_exists($filepath) && $filename !== 'default-avatar.jpg') {
        return unlink($filepath);
    }
    return false;
}

/**
 * Generate pagination
 */
function generatePagination($currentPage, $totalPages, $url) {
    $html = '<div class="inline-flex mt-2 xs:mt-0">';
    
    // Previous button
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        $html .= "<a href='$url&page=$prevPage' class='py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100'>Previous</a>";
    }
    
    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'bg-blue-400 !text-white border-blue-400' : '';
        $html .= "<a href='$url&page=$i' class='py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 $activeClass'>$i</a>";
    }
    
    // Next button
    if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        $html .= "<a href='$url&page=$nextPage' class='py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100'>Next</a>";
    }
    
    $html .= '</div>';
    return $html;
}

/**
 * Debug helper
 */
function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

/**
 * Validate required fields
 */
function validateRequired($fields, $data) {
    $errors = [];
    foreach ($fields as $field => $label) {
        if (empty($data[$field])) {
            $errors[] = "$label wajib diisi";
        }
    }
    return $errors;
}