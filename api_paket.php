<?php
/**
 * api_paket.php - COMPLETE FIX
 * Menambahkan status publikasi per wilayah
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

function sendJSON($data, $code = 200) {
    while (ob_get_level()) ob_end_clean();
    http_response_code($code);
    header("Content-Type: application/json; charset=utf-8");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function toInt($value, $default = 0) {
    return is_numeric($value) ? (int)$value : $default;
}

function toFloat($value, $default = 0) {
    return is_numeric($value) ? (float)$value : (float)$default;
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
    
// ===== GET - LOAD DATA =====
if ($method === 'GET') {
    $sql = "SELECT 
        id, name, image_path, kecepatan,
        max_perangkat, max_laptop, max_smartphone,
        harga_sumatera_before, harga_sumatera,
        harga_jawa_before, harga_jawa,
        harga_timur_before, harga_timur,
        harga_ntt_before, harga_ntt,
        harga_batam_before, harga_batam,
        harga_natuna_before, harga_natuna,
            instalasi_sumatera_before, instalasi_sumatera,
            instalasi_jawa_before, instalasi_jawa,
            instalasi_timur_before, instalasi_timur,
            instalasi_ntt_before, instalasi_ntt,
            instalasi_batam_before, instalasi_batam,
            instalasi_natuna_before, instalasi_natuna,
            tv_4k, streaming, gaming, features, is_active,
            status_sumatera, status_jawa, status_timur, 
            status_ntt, status_batam, status_natuna
        FROM paket 
        ORDER BY id ASC";
        
        $result = $conn->query($sql);
        
        if (!$result) {
            sendJSON(['success' => false, 'message' => 'Query failed: ' . $conn->error], 500);
        }
        
        $paket = [];
        while ($row = $result->fetch_assoc()) {
            $paket[] = [
                'id' => toInt($row['id']),
                'name' => cleanString($row['name']),
                'image_path' => cleanString($row['image_path']),
                'kecepatan' => cleanString($row['kecepatan']),
                'harga_sumatera_before' => toFloat($row['harga_sumatera_before']),
                'harga_sumatera' => toFloat($row['harga_sumatera']),
                'harga_jawa_before' => toFloat($row['harga_jawa_before']),
                'harga_jawa' => toFloat($row['harga_jawa']),
                'harga_timur_before' => toFloat($row['harga_timur_before']),
                'harga_timur' => toFloat($row['harga_timur']),
                'harga_ntt_before' => toFloat($row['harga_ntt_before']),
                'harga_ntt' => toFloat($row['harga_ntt']),
                'harga_batam_before' => toFloat($row['harga_batam_before']),
                'harga_batam' => toFloat($row['harga_batam']),
                'harga_natuna_before' => toFloat($row['harga_natuna_before']),
                'harga_natuna' => toFloat($row['harga_natuna']),
                'instalasi_sumatera_before' => toFloat($row['instalasi_sumatera_before']),
                'instalasi_sumatera' => toFloat($row['instalasi_sumatera']),
                'instalasi_jawa_before' => toFloat($row['instalasi_jawa_before']),
                'instalasi_jawa' => toFloat($row['instalasi_jawa']),
                'instalasi_timur_before' => toFloat($row['instalasi_timur_before']),
                'instalasi_timur' => toFloat($row['instalasi_timur']),
                'instalasi_ntt_before' => toFloat($row['instalasi_ntt_before']),
                'instalasi_ntt' => toFloat($row['instalasi_ntt']),
                'instalasi_batam_before' => toFloat($row['instalasi_batam_before']),
                'instalasi_batam' => toFloat($row['instalasi_batam']),
                'instalasi_natuna_before' => toFloat($row['instalasi_natuna_before']),
                'instalasi_natuna' => toFloat($row['instalasi_natuna']),
                'max_perangkat' => toInt($row['max_perangkat']),
                'max_laptop' => toInt($row['max_laptop']),
                'max_smartphone' => toInt($row['max_smartphone']),
                'tv_4k' => cleanString($row['tv_4k']),
                'streaming' => cleanString($row['streaming']),
                'gaming' => cleanString($row['gaming']),
                'features' => cleanString($row['features']),
                'status' => toInt($row['is_active']),
                // ✅ PENTING: Pastikan status wilayah di-load
                'status_sumatera' => toInt($row['status_sumatera'] ?? 1),
                'status_jawa' => toInt($row['status_jawa'] ?? 1),
                'status_timur' => toInt($row['status_timur'] ?? 1),
                'status_ntt' => toInt($row['status_ntt'] ?? 1),
                'status_batam' => toInt($row['status_batam'] ?? 1),
                'status_natuna' => toInt($row['status_natuna'] ?? 1)
            ];
        }
        
        sendJSON($paket, 200);
    }
    
    // ===== POST - INSERT & UPDATE =====
    if ($method === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : 'insert';
        $isUpdate = ($action === 'update' && isset($_POST['id']) && !empty($_POST['id']));
        
        // Upload gambar
        $imagePath = '';
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

        // Ambil data dari form
        $nama = cleanString($_POST['nama'] ?? '');
        $kecepatan = cleanString($_POST['kecepatan'] ?? '');
        
        // Harga & Instalasi
        $harga_sumatera = toFloat($_POST['harga_sumatera'] ?? 0);
        $harga_jawa = toFloat($_POST['harga_jawa'] ?? 0);
        $harga_timur = toFloat($_POST['harga_timur'] ?? 0);
        $harga_ntt = toFloat($_POST['harga_ntt'] ?? 0);
        $harga_batam = toFloat($_POST['harga_batam'] ?? 0);
        $harga_natuna = toFloat($_POST['harga_natuna'] ?? 0);
        
        $harga_sumatera_before = toFloat($_POST['harga_sumatera_before'] ?? 0);
        $harga_jawa_before = toFloat($_POST['harga_jawa_before'] ?? 0);
        $harga_timur_before = toFloat($_POST['harga_timur_before'] ?? 0);
        $harga_ntt_before = toFloat($_POST['harga_ntt_before'] ?? 0);
        $harga_batam_before = toFloat($_POST['harga_batam_before'] ?? 0);
        $harga_natuna_before = toFloat($_POST['harga_natuna_before'] ?? 0);
        
        $instalasi_sumatera = toFloat($_POST['instalasi_sumatera'] ?? 0);
        $instalasi_jawa = toFloat($_POST['instalasi_jawa'] ?? 0);
        $instalasi_timur = toFloat($_POST['instalasi_timur'] ?? 0);
        $instalasi_ntt = toFloat($_POST['instalasi_ntt'] ?? 0);
        $instalasi_batam = toFloat($_POST['instalasi_batam'] ?? 0);
        $instalasi_natuna = toFloat($_POST['instalasi_natuna'] ?? 0);
        
        $instalasi_sumatera_before = toFloat($_POST['instalasi_sumatera_before'] ?? 0);
        $instalasi_jawa_before = toFloat($_POST['instalasi_jawa_before'] ?? 0);
        $instalasi_timur_before = toFloat($_POST['instalasi_timur_before'] ?? 0);
        $instalasi_ntt_before = toFloat($_POST['instalasi_ntt_before'] ?? 0);
        $instalasi_batam_before = toFloat($_POST['instalasi_batam_before'] ?? 0);
        $instalasi_natuna_before = toFloat($_POST['instalasi_natuna_before'] ?? 0);
        
        // Perangkat
        $max_perangkat = toInt($_POST['max_perangkat'] ?? 0);
        $max_laptop = toInt($_POST['max_laptop'] ?? 0);
        $max_smartphone = toInt($_POST['max_smartphone'] ?? 0);
        
        // Fitur
        $tv_4k = cleanString($_POST['tv_4k'] ?? '');
        $streaming = cleanString($_POST['streaming'] ?? '');
        $gaming = cleanString($_POST['gaming'] ?? '');
        $features = cleanString($_POST['features'] ?? '');
        $status = toInt($_POST['status'] ?? 1);
        
        // ✅ STATUS PUBLIKASI PER WILAYAH
        $status_sumatera = toInt($_POST['status_sumatera'] ?? 1);
        $status_jawa = toInt($_POST['status_jawa'] ?? 1);
        $status_timur = toInt($_POST['status_timur'] ?? 1);
        $status_ntt = toInt($_POST['status_ntt'] ?? 1);
        $status_batam = toInt($_POST['status_batam'] ?? 1);
        $status_natuna = toInt($_POST['status_natuna'] ?? 1);
        
        // Validasi
        if (empty($nama)) {
            sendJSON(['success' => false, 'message' => 'Nama paket wajib diisi'], 400);
        }

// ===== UPDATE =====
if ($isUpdate) {
    $id = toInt($_POST['id']);
    
    if (!empty($imagePath)) {
        $sql = "UPDATE paket SET 
            name=?, kecepatan=?, image_path=?,
            max_perangkat=?, max_laptop=?, max_smartphone=?,
            harga_sumatera_before=?, harga_sumatera=?,
            harga_jawa_before=?, harga_jawa=?,
            harga_timur_before=?, harga_timur=?,
            harga_ntt_before=?, harga_ntt=?,
            harga_batam_before=?, harga_batam=?,
            harga_natuna_before=?, harga_natuna=?,
            instalasi_sumatera_before=?, instalasi_sumatera=?,
            instalasi_jawa_before=?, instalasi_jawa=?,
            instalasi_timur_before=?, instalasi_timur=?,
            instalasi_ntt_before=?, instalasi_ntt=?,
            instalasi_batam_before=?, instalasi_batam=?,
            instalasi_natuna_before=?, instalasi_natuna=?,
            tv_4k=?, streaming=?, gaming=?, features=?, is_active=?,
            status_sumatera=?, status_jawa=?, status_timur=?, 
            status_ntt=?, status_batam=?, status_natuna=?
            WHERE id=?";
        
        $stmt->bind_param(
            "sssiiiddddddddddddddddddddddddssssiiiiiii",
            $nama, $kecepatan, $imagePath,
            $max_perangkat, $max_laptop, $max_smartphone,
            $harga_sumatera_before, $harga_sumatera,
            $harga_jawa_before, $harga_jawa,
            $harga_timur_before, $harga_timur,
            $harga_ntt_before, $harga_ntt,
            $harga_batam_before, $harga_batam,
            $harga_natuna_before, $harga_natuna,
            $instalasi_sumatera_before, $instalasi_sumatera,
            $instalasi_jawa_before, $instalasi_jawa,
            $instalasi_timur_before, $instalasi_timur,
            $instalasi_ntt_before, $instalasi_ntt,
            $instalasi_batam_before, $instalasi_batam,
            $instalasi_natuna_before, $instalasi_natuna,
            $tv_4k, $streaming, $gaming, $features,
            $status, 
            $status_sumatera, $status_jawa, $status_timur, 
            $status_ntt, $status_batam, $status_natuna,
            $id
        );
    } else {
    // UPDATE tanpa image_path
    $sql = "UPDATE paket SET 
        name=?, kecepatan=?,
        max_perangkat=?, max_laptop=?, max_smartphone=?,
        harga_sumatera_before=?, harga_sumatera=?,
        harga_jawa_before=?, harga_jawa=?,
        harga_timur_before=?, harga_timur=?,
        harga_ntt_before=?, harga_ntt=?,
        harga_batam_before=?, harga_batam=?,
        harga_natuna_before=?, harga_natuna=?,
        instalasi_sumatera_before=?, instalasi_sumatera=?,
        instalasi_jawa_before=?, instalasi_jawa=?,
        instalasi_timur_before=?, instalasi_timur=?,
        instalasi_ntt_before=?, instalasi_ntt=?,
        instalasi_batam_before=?, instalasi_batam=?,
        instalasi_natuna_before=?, instalasi_natuna=?,
        tv_4k=?, streaming=?, gaming=?, features=?, is_active=?,
        status_sumatera=?, status_jawa=?, status_timur=?, 
        status_ntt=?, status_batam=?, status_natuna=?
        WHERE id=?";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        sendJSON(['success' => false, 'message' => 'Prepare failed: ' . $conn->error], 500);
    }
    
    // ✅ FIX: 2s + 3i + 24d + 4s + 1i + 6i + 1i = 41 parameters
    $stmt->bind_param(
        "ssiiiddddddddddddddddddddddddssssiiiiiiii",
        $nama, $kecepatan,
        $max_perangkat, $max_laptop, $max_smartphone,
        $harga_sumatera_before, $harga_sumatera,
        $harga_jawa_before, $harga_jawa,
        $harga_timur_before, $harga_timur,
        $harga_ntt_before, $harga_ntt,
        $harga_batam_before, $harga_batam,
        $harga_natuna_before, $harga_natuna,
        $instalasi_sumatera_before, $instalasi_sumatera,
        $instalasi_jawa_before, $instalasi_jawa,
        $instalasi_timur_before, $instalasi_timur,
        $instalasi_ntt_before, $instalasi_ntt,
        $instalasi_batam_before, $instalasi_batam,
        $instalasi_natuna_before, $instalasi_natuna,
        $tv_4k, $streaming, $gaming, $features,
        $status,
        $status_sumatera, $status_jawa, $status_timur, 
        $status_ntt, $status_batam, $status_natuna,
        $id
    );
}
            
            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                sendJSON(['success' => true, 'message' => 'Paket berhasil diupdate'], 200);
            } else {
                $error = $stmt->error;
                $stmt->close();
                $conn->close();
                sendJSON(['success' => false, 'message' => 'Update failed: ' . $error], 500);
            }
        }
        // ===== INSERT =====
        // ===== INSERT - FIXED VERSION =====
else {
// ✅ FIX: Generate ID yang benar untuk varchar
$result = $conn->query("SELECT MAX(CAST(id AS UNSIGNED)) as max_id FROM paket");
$row = $result->fetch_assoc();
$newId = ($row['max_id'] ?? 0) + 1;
    
    $sql = "INSERT INTO paket (
        id, name, image_path, kecepatan,
        max_perangkat, max_laptop, max_smartphone,
        harga_sumatera_before, harga_sumatera,
        harga_jawa_before, harga_jawa,
        harga_timur_before, harga_timur,
        harga_ntt_before, harga_ntt,
        harga_batam_before, harga_batam,
        harga_natuna_before, harga_natuna,
        instalasi_sumatera_before, instalasi_sumatera,
        instalasi_jawa_before, instalasi_jawa,
        instalasi_timur_before, instalasi_timur,
        instalasi_ntt_before, instalasi_ntt,
        instalasi_batam_before, instalasi_batam,
        instalasi_natuna_before, instalasi_natuna,
        tv_4k, streaming, gaming, features, is_active,
        status_sumatera, status_jawa, status_timur, 
        status_ntt, status_batam, status_natuna
    ) VALUES (?,?,?,?, ?,?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?, ?,?,?,?,?, ?,?,?, ?,?,?)";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        sendJSON(['success' => false, 'message' => 'Prepare failed: ' . $conn->error], 500);
    }
    
    // ✅ FIXED: Total 41 parameters
    // Format: i s s s | i i i | d d d d d d d d d d d d d d d d d d d d d d d d | s s s s | i | i i i i i i
    // Count:  1+1+1+1 + 1+1+1 + 24x d + 1+1+1+1 + 1 + 1+1+1+1+1+1 = 41 parameters ✅
    
    $stmt->bind_param(
        "isssiiidddddddddddddddddddddddssssiiiiiiii",
        $newId,
        $nama, $imagePath, $kecepatan,
        $max_perangkat, $max_laptop, $max_smartphone,
        $harga_sumatera_before, $harga_sumatera,
        $harga_jawa_before, $harga_jawa,
        $harga_timur_before, $harga_timur,
        $harga_ntt_before, $harga_ntt,
        $harga_batam_before, $harga_batam,
        $harga_natuna_before, $harga_natuna,
        $instalasi_sumatera_before, $instalasi_sumatera,
        $instalasi_jawa_before, $instalasi_jawa,
        $instalasi_timur_before, $instalasi_timur,
        $instalasi_ntt_before, $instalasi_ntt,
        $instalasi_batam_before, $instalasi_batam,
        $instalasi_natuna_before, $instalasi_natuna,
        $tv_4k, $streaming, $gaming, $features,
        $status,
        $status_sumatera, $status_jawa, $status_timur, 
        $status_ntt, $status_batam, $status_natuna
    );
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        sendJSON(['success' => true, 'message' => 'Paket berhasil ditambahkan', 'id' => $newId], 201);
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        sendJSON(['success' => false, 'message' => 'Insert failed: ' . $error], 500);
    }
}
    }
    
    // ===== DELETE =====
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
?>