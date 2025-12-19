<?php
header("Content-Type: application/json");
require "../config/db.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $result = $conn->query("SELECT * FROM paket WHERE status = 1");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare(
        "INSERT INTO paket (name, kecepatan, max_perangkat, max_laptop, max_smartphone, harga_sumatera, harga_jawa, harga_timur, instalasi_sumatera, instalasi_jawa, instalasi_timur, tv_4k, streaming, gaming, features)
         VALUES (?,?,?,?,?)"
    );
    $stmt->bind_param(
        "siiii",
        $data['nama'],
        $data['sumatera'],
        $data['jawa'],
        $data['timur'],
        $data['status']
    );
    $stmt->execute();
}
