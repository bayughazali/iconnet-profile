<?php
// test_connection.php - File untuk test koneksi database

header('Content-Type: application/json; charset=utf-8');

// Konfigurasi
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db';

// Test koneksi
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Koneksi Gagal',
        'error' => $conn->connect_error,
        'details' => [
            'host' => $host,
            'user' => $user,
            'database' => $db
        ]
    ], JSON_PRETTY_PRINT);
    exit;
}

// Jika berhasil, ambil data sample
$result = [];

// Test query admin
$sql = "SELECT COUNT(*) as total FROM admin";
$query = $conn->query($sql);
if ($query) {
    $result['admin_count'] = $query->fetch_assoc()['total'];
}

// Test query slider
$sql = "SELECT COUNT(*) as total FROM slider";
$query = $conn->query($sql);
if ($query) {
    $result['slider_count'] = $query->fetch_assoc()['total'];
}

// Test query paket
$sql = "SELECT COUNT(*) as total FROM paket";
$query = $conn->query($sql);
if ($query) {
    $result['paket_count'] = $query->fetch_assoc()['total'];
}

// Test query berita
$sql = "SELECT COUNT(*) as total FROM berita";
$query = $conn->query($sql);
if ($query) {
    $result['berita_count'] = $query->fetch_assoc()['total'];
}

// Test query faq
$sql = "SELECT COUNT(*) as total FROM faq";
$query = $conn->query($sql);
if ($query) {
    $result['faq_count'] = $query->fetch_assoc()['total'];
}

echo json_encode([
    'success' => true,
    'message' => 'Koneksi Database Berhasil! ✓',
    'database' => $db,
    'charset' => $conn->character_set_name(),
    'tables' => $result,
    'php_version' => phpversion(),
    'mysqli_version' => $conn->server_info
], JSON_PRETTY_PRINT);

$conn->close();
?>