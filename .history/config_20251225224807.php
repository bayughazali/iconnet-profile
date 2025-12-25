<?php
// config.php - Konfigurasi Database ICONNET

// Tampilkan error untuk debugging (nonaktifkan di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'iconnet');

// Membuat koneksi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Koneksi database gagal: ' . $conn->connect_error
    ]));
}

// Set charset
$conn->set_charset("utf8mb4");

// Fungsi untuk mencegah SQL Injection
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Fungsi untuk response JSON
function json_response($success, $message, $data = null) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Fungsi untuk cek login admin
function check_login() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        json_response(false, 'Silakan login terlebih dahulu');
    }
}

// Fungsi untuk upload gambar
function upload_image($file, $target_dir = 'uploads/') {
    // Buat folder jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    // Validasi ekstensi file
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'message' => 'Format file tidak didukung. Gunakan: JPG, PNG, GIF, WEBP'];
    }
    
    // Validasi ukuran file (max 5MB)
    if ($file['size'] > 5000000) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar (maksimal 5MB)'];
    }
    
    // Generate nama file unik
    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return ['success' => true, 'path' => $target_file];
    } else {
        return ['success' => false, 'message' => 'Gagal upload file'];
    }
}

// Fungsi untuk delete file
function delete_file($file_path) {
    if (file_exists($file_path) && is_file($file_path)) {
        return unlink($file_path);
    }
    return false;
}

// Test koneksi (opsional - hapus di production)
// echo json_encode(['success' => true, 'message' => 'Database connected successfully']);
?>