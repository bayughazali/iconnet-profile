<?php
// test_api.php - Simpan file ini di root folder yang sama dengan index.php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Konfigurasi database - SESUAIKAN DENGAN SETTING ANDA
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_iconnet';

// Test koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'error' => 'Connection failed: ' . $conn->connect_error,
        'config' => [
            'host' => $host,
            'user' => $user,
            'database' => $db
        ]
    ], JSON_PRETTY_PRINT);
    exit;
}

// Set charset
$conn->set_charset("utf8mb4");

// Query paket
$sql = "SELECT * FROM paket WHERE status = 1 ORDER BY name ASC";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        'success' => false,
        'error' => 'Query failed: ' . $conn->error,
        'sql' => $sql
    ], JSON_PRETTY_PRINT);
    exit;
}

// Ambil data
$paket = [];
while ($row = $result->fetch_assoc()) {
    $paket[] = $row;
}

// Return hasil
echo json_encode([
    'success' => true,
    'message' => 'Data loaded successfully',
    'count' => count($paket),
    'data' => $paket,
    'database_info' => [
        'host' => $host,
        'database' => $db,
        'charset' => $conn->character_set_name()
    ]
], JSON_PRETTY_PRINT);

$conn->close();
?>