<?php
header("Content-Type: application/json; charset=utf-8");

$host = "localhost";
$user = "root";
$pass = "";
$db   = "iconnet_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Koneksi database gagal"]);
    exit;
}

/*
|--------------------------------------------------------------------------
| DETAIL ADDON
|--------------------------------------------------------------------------
*/
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "SELECT 
                id,
                name,
                category,
                description,
                price,
                installation_fee,
                fitur,
                layanan_tersedia,
                image_path
            FROM addon
            WHERE id = $id AND is_active = 1
            LIMIT 1";

    $result = $conn->query($sql);

    if (!$result || $result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Addon tidak ditemukan"]);
        exit;
    }

    echo json_encode($result->fetch_assoc(), JSON_PRETTY_PRINT);
    exit;
}

/*
|--------------------------------------------------------------------------
| LIST ADDON
|--------------------------------------------------------------------------
*/
$sql = "SELECT 
            id,
            name,
            category,
            description,
            price,
            installation_fee,
            fitur,
            layanan_tersedia,
            image_path
        FROM addon
        WHERE is_active = 1
        ORDER BY category, id ASC";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Query gagal"]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data, JSON_PRETTY_PRINT);
$conn->close();
// 