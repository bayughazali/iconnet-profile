<?php
/**
 * api_paket.php - VERSI LENGKAP FINAL
 */

@ini_set('display_errors', '0');
@error_reporting(0);

function sendJSON($data, $code = 200) {
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    http_response_code($code);
    header("Content-Type: application/json; charset=utf-8");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function toInt($value, $default = 0) {
    if (is_numeric($value)) {
        return (int)$value;
    }
    return $default;
}

function cleanString($value) {
    return trim(strval($value));
}

try {
    if (!file_exists(__DIR__ . "/config.php")) {
        sendJSON(['success' => false, 'message' => 'config.php not found'], 500);
    }
    
    require_once __DIR__ . "/config.php";
    
    if (!isset($conn) || $conn->connect_error) {
        sendJSON(['success' => false, 'message' => 'Database connection failed'], 500);
    }
    
    $method = $_SERVER['REQUEST_METHOD'];
    
    // ==================== GET ====================
    if ($method === 'GET') {
        $sql = "SELECT id, name, image_path, kecepatan, max_perangkat, max_laptop, max_smartphone,
                harga_sumatera, harga_jawa, harga_timur,
                instalasi_sumatera, instalasi_jawa, instalasi_timur,
                tv_4k, streaming, gaming, features, is_active
                FROM paket ORDER BY id ASC";
        
        $result = $conn->query($sql);
        
        if (!$result) {
            sendJSON(['success' => false, 'message' => 'Query failed: ' . $conn->error], 500);
        }
        
        $paket = [];
        while ($row = $result->fetch_assoc()) {
            $paket[] = [
                'id' => toInt($row['id']),
                'name' => cleanString($row['name']) ?: 'Unnamed',
                'image_path' => cleanString($row['image_path']),
                'kecepatan' => cleanString($row['kecepatan']) ?: 'High Speed',
                'max_perangkat' => toInt($row['max_perangkat']),
                'max_laptop' => toInt($row['max_laptop']),
                'max_smartphone' => toInt($row['max_smartphone']),
                'harga_sumatera' => toInt($row['harga_sumatera']),
                'harga_jawa' => toInt($row['harga_jawa']),
                'harga_timur' => toInt($row['harga_timur']),
                'instalasi_sumatera' => toInt($row['instalasi_sumatera']),
                'instalasi_jawa' => toInt($row['instalasi_jawa']),
                'instalasi_timur' => toInt($row['instalasi_timur']),
                'tv_4k' => cleanString($row['tv_4k']),
                'streaming' => cleanString($row['streaming']),
                'gaming' => cleanString($row['gaming']),
                'features' => cleanString($row['features']),
                'status' => toInt($row['is_active'])
            ];
        }
        
        sendJSON($paket, 200);
    }
    
    // ==================== POST (INSERT) ====================
if ($method === 'POST') {
    $imagePath = '';
    
    // Handle upload gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/paket/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            sendJSON(['success' => false, 'message' => 'Format file harus JPG, PNG, atau WEBP'], 400);
        }
        
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            sendJSON(['success' => false, 'message' => 'Ukuran file maksimal 2MB'], 400);
        }
        
        $newFileName = 'paket_' . time() . '_' . uniqid() . '.' . $fileExtension;
        $uploadPath = $uploadDir . $newFileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $imagePath = 'uploads/paket/' . $newFileName;
        } else {
            sendJSON(['success' => false, 'message' => 'Gagal mengupload gambar'], 500);
        }
    }
    
    // Ambil data dari POST
    $nama = cleanString($_POST['nama'] ?? '');
    $kecepatan = cleanString($_POST['kecepatan'] ?? 'High Speed');
    $max_perangkat = toInt($_POST['max_perangkat'] ?? 0);
    $max_laptop = toInt($_POST['max_laptop'] ?? 0);
    $max_smartphone = toInt($_POST['max_smartphone'] ?? 0);
    $sumatera = toInt($_POST['sumatera'] ?? 0);
    $jawa = toInt($_POST['jawa'] ?? 0);
    $timur = toInt($_POST['timur'] ?? 0);
    $instalasi_sumatera = toInt($_POST['instalasi_sumatera'] ?? 0);
    $instalasi_jawa = toInt($_POST['instalasi_jawa'] ?? 0);
    $instalasi_timur = toInt($_POST['instalasi_timur'] ?? 0);
    $tv_4k = cleanString($_POST['tv_4k'] ?? '');
    $streaming = cleanString($_POST['streaming'] ?? '');
    $gaming = cleanString($_POST['gaming'] ?? '');
    $features = cleanString($_POST['features'] ?? '');
    $status = toInt($_POST['status'] ?? 1);
    
    // Validasi
    if (empty($nama)) {
        sendJSON(['success' => false, 'message' => 'Nama paket wajib diisi'], 400);
    }
    
    // ✅ GENERATE ID MANUAL: Ambil ID terbesar + 1
    $result = $conn->query("SELECT MAX(id) as max_id FROM paket");
    $row = $result->fetch_assoc();
    $newId = ($row['max_id'] ?? 0) + 1;
    
    // Query INSERT dengan ID manual
    $sql = "INSERT INTO paket (
                id, name, image_path, kecepatan, 
                max_perangkat, max_laptop, max_smartphone,
                harga_sumatera, harga_jawa, harga_timur,
                instalasi_sumatera, instalasi_jawa, instalasi_timur,
                tv_4k, streaming, gaming, features, is_active
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        sendJSON(['success' => false, 'message' => 'Prepare failed: ' . $conn->error], 500);
    }
    
    // Bind 18 parameter (tambah 1 untuk id)
    $stmt->bind_param(
        "isssiiiiiiiiiisssi",
        $newId,           // 1 - id (int)
        $nama,            // 2 - string
        $imagePath,       // 3 - string
        $kecepatan,       // 4 - string
        $max_perangkat,   // 5 - int
        $max_laptop,      // 6 - int
        $max_smartphone,  // 7 - int
        $sumatera,        // 8 - int
        $jawa,            // 9 - int
        $timur,           // 10 - int
        $instalasi_sumatera, // 11 - int
        $instalasi_jawa,     // 12 - int
        $instalasi_timur,    // 13 - int
        $tv_4k,           // 14 - string
        $streaming,       // 15 - string
        $gaming,          // 16 - string
        $features,        // 17 - string
        $status           // 18 - int
    );
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        sendJSON(['success' => true, 'message' => 'Paket berhasil ditambahkan', 'id' => $newId], 201);
    } else {
        $error = $stmt->error;
        $stmt->close();
        sendJSON(['success' => false, 'message' => 'Insert failed: ' . $error], 500);
    }
}
    
    // ==================== PUT (UPDATE) ====================
    if ($method === 'PUT') {
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);
        
        if (!$data || !isset($data['id'])) {
            sendJSON(['success' => false, 'message' => 'ID tidak valid'], 400);
        }
        
        $id = toInt($data['id']);
        $nama = cleanString($data['nama'] ?? '');
        $kecepatan = cleanString($data['kecepatan'] ?? 'High Speed');
        $max_perangkat = toInt($data['max_perangkat'] ?? 0);
        $max_laptop = toInt($data['max_laptop'] ?? 0);
        $max_smartphone = toInt($data['max_smartphone'] ?? 0);
        $sumatera = toInt($data['sumatera'] ?? 0);
        $jawa = toInt($data['jawa'] ?? 0);
        $timur = toInt($data['timur'] ?? 0);
        $instalasi_sumatera = toInt($data['instalasi_sumatera'] ?? 0);
        $instalasi_jawa = toInt($data['instalasi_jawa'] ?? 0);
        $instalasi_timur = toInt($data['instalasi_timur'] ?? 0);
        $tv_4k = cleanString($data['tv_4k'] ?? '');
        $streaming = cleanString($data['streaming'] ?? '');
        $gaming = cleanString($data['gaming'] ?? '');
        $features = cleanString($data['features'] ?? '');
        $status = toInt($data['status'] ?? 1);
        
        if (empty($nama)) {
            sendJSON(['success' => false, 'message' => 'Nama paket wajib diisi'], 400);
        }
        
        $sql = "UPDATE paket SET 
                name=?, kecepatan=?, 
                max_perangkat=?, max_laptop=?, max_smartphone=?,
                harga_sumatera=?, harga_jawa=?, harga_timur=?,
                instalasi_sumatera=?, instalasi_jawa=?, instalasi_timur=?,
                tv_4k=?, streaming=?, gaming=?, features=?, is_active=?
                WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            sendJSON(['success' => false, 'message' => 'Prepare failed: ' . $conn->error], 500);
        }
        
        $stmt->bind_param(
            "ssiiiiiiiiiisssii",
            $nama, $kecepatan,
            $max_perangkat, $max_laptop, $max_smartphone,
            $sumatera, $jawa, $timur,
            $instalasi_sumatera, $instalasi_jawa, $instalasi_timur,
            $tv_4k, $streaming, $gaming, $features, $status,
            $id
        );
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            sendJSON(['success' => true, 'message' => 'Paket berhasil diupdate'], 200);
        } else {
            $error = $stmt->error;
            $stmt->close();
            sendJSON(['success' => false, 'message' => 'Update failed: ' . $error], 500);
        }
    }
    
    // ==================== DELETE ====================
    if ($method === 'DELETE') {
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);
        
        if (!$data || !isset($data['id'])) {
            sendJSON(['success' => false, 'message' => 'ID tidak valid'], 400);
        }
        
        $id = toInt($data['id']);
        
        $stmt = $conn->prepare("DELETE FROM paket WHERE id=?");
        
        if (!$stmt) {
            sendJSON(['success' => false, 'message' => 'Prepare failed: ' . $conn->error], 500);
        }
        
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            sendJSON(['success' => true, 'message' => 'Paket berhasil dihapus'], 200);
        } else {
            $error = $stmt->error;
            $stmt->close();
            sendJSON(['success' => false, 'message' => 'Delete failed: ' . $error], 500);
        }
    }
    
    sendJSON(['success' => false, 'message' => 'Invalid request method'], 400);
    
} catch (Exception $e) {
    sendJSON(['success' => false, 'message' => $e->getMessage()], 500);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("
        INSERT INTO paket (
            name,
            harga_sumatera, harga_sumatera_before,
            harga_jawa, harga_jawa_before,
            harga_timur, harga_timur_before,
            instalasi_sumatera, instalasi_sumatera_before,
            instalasi_jawa, instalasi_jawa_before,
            instalasi_timur, instalasi_timur_before,
            kecepatan,
            max_perangkat,
            max_laptop,
            max_smartphone,
            tv_4k,
            streaming,
            gaming,
            features,
            status
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $data['nama'],
        $data['sumatera'], $data['sumatera_before'],
        $data['jawa'], $data['jawa_before'],
        $data['timur'], $data['timur_before'],
        $data['instalasi_sumatera'], $data['instalasi_sumatera_before'],
        $data['instalasi_jawa'], $data['instalasi_jawa_before'],
        $data['instalasi_timur'], $data['instalasi_timur_before'],
        $data['kecepatan'],
        $data['max_perangkat'],
        $data['max_laptop'],
        $data['max_smartphone'],
        $data['tv_4k'],
        $data['streaming'],
        $data['gaming'],
        $data['features'],
        $data['status']
    ]);

    echo json_encode(['success' => true]);
    exit;
}

?>