<?php
/**
 * api_paket.php - API untuk mengelola data paket ICONNET
 * Path: ROOT/api_paket.php (di folder yang sama dengan index.php)
 */

// Set headers
header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Include config
require_once __DIR__ . "/config.php";

$method = $_SERVER['REQUEST_METHOD'];

// ========================================
// GET - Ambil semua paket aktif
// ========================================
if ($method === 'GET') {
    try {
        // PERBAIKAN: Gunakan is_active bukan status
        $sql = "SELECT 
            id,
            name,
            kecepatan,
            max_perangkat,
            max_laptop,
            max_smartphone,
            harga_sumatera,
            harga_jawa,
            harga_timur,
            instalasi_sumatera,
            instalasi_jawa,
            instalasi_timur,
            tv_4k,
            streaming,
            gaming,
            features,
            is_active
        FROM paket 
        WHERE is_active = 1 
        ORDER BY id ASC";
        
        $result = $conn->query($sql);
        
        if (!$result) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Query failed: ' . $conn->error,
                'sql' => $sql
            ]);
            exit;
        }
        
        // Ambil semua data
        $paket = [];
        while ($row = $result->fetch_assoc()) {
            // Konversi tipe data yang diperlukan
            $paket[] = [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'kecepatan' => $row['kecepatan'] ?: 'High Speed',
                'max_perangkat' => (int)($row['max_perangkat'] ?: 4),
                'max_laptop' => (int)($row['max_laptop'] ?: 2),
                'max_smartphone' => (int)($row['max_smartphone'] ?: 2),
                'harga_sumatera' => (int)$row['harga_sumatera'],
                'harga_jawa' => (int)$row['harga_jawa'],
                'harga_timur' => (int)$row['harga_timur'],
                'instalasi_sumatera' => (int)($row['instalasi_sumatera'] ?: 345000),
                'instalasi_jawa' => (int)($row['instalasi_jawa'] ?: 150000),
                'instalasi_timur' => (int)($row['instalasi_timur'] ?: 200000),
                'tv_4k' => $row['tv_4k'] ?: '',
                'streaming' => $row['streaming'] ?: '',
                'gaming' => $row['gaming'] ?: '',
                'features' => $row['features'] ?: '',
                'status' => (int)$row['is_active'] // Map is_active ke status
            ];
        }
        
        // Return data sebagai JSON array
        http_response_code(200);
        echo json_encode($paket, JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

// ========================================
// POST - Tambah paket baru
// ========================================
if ($method === 'POST') {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid JSON data'
            ]);
            exit;
        }
        
        $stmt = $conn->prepare(
            "INSERT INTO paket (name, kecepatan, max_perangkat, max_laptop, max_smartphone, 
            harga_sumatera, harga_jawa, harga_timur, 
            instalasi_sumatera, instalasi_jawa, instalasi_timur, 
            tv_4k, streaming, gaming, features, is_active)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        
        if (!$stmt) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Prepare failed: ' . $conn->error
            ]);
            exit;
        }
        
        $stmt->bind_param(
            "ssiiiiiiiiiisssi",
            $data['nama'],
            $data['kecepatan'],
            $data['max_perangkat'],
            $data['max_laptop'],
            $data['max_smartphone'],
            $data['sumatera'],
            $data['jawa'],
            $data['timur'],
            $data['instalasi_sumatera'],
            $data['instalasi_jawa'],
            $data['instalasi_timur'],
            $data['tv_4k'],
            $data['streaming'],
            $data['gaming'],
            $data['features'],
            $data['status']
        );
        
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode([
                'success' => true, 
                'message' => 'Paket berhasil ditambahkan',
                'id' => $conn->insert_id
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'message' => 'Execute failed: ' . $stmt->error
            ]);
        }
        $stmt->close();
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

// ========================================
// PUT - Update paket
// ========================================
if ($method === 'PUT') {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $stmt = $conn->prepare(
            "UPDATE paket SET name=?, kecepatan=?, 
            harga_sumatera=?, harga_jawa=?, harga_timur=?, is_active=?
            WHERE id=?"
        );
        
        $stmt->bind_param(
            "ssiiii",
            $data['nama'],
            $data['kecepatan'],
            $data['sumatera'],
            $data['jawa'],
            $data['timur'],
            $data['status'],
            $data['id']
        );
        
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Paket berhasil diupdate']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate paket: ' . $stmt->error]);
        }
        $stmt->close();
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

// ========================================
// DELETE - Hapus paket
// ========================================
if ($method === 'DELETE') {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $stmt = $conn->prepare("DELETE FROM paket WHERE id=?");
        $stmt->bind_param("i", $data['id']);
        
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Paket berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus paket: ' . $stmt->error]);
        }
        $stmt->close();
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

$conn->close();
?>