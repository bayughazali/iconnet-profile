<?php
header("Content-Type: application/json; charset=utf-8");
include 'config.php';

// Tentukan action dari GET atau POST
$action = $_GET['action'] ?? ($_POST['action'] ?? 'list');

/*
|--------------------------------------------------------------------------
| GET SINGLE ADDON BY ID (untuk Edit Modal)
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && !isset($_GET['action'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT * FROM addon WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Addon not found', 'id' => $id]);
    }
    exit;
}

/*
|--------------------------------------------------------------------------
| LIST ADDON (GET ALL)
|--------------------------------------------------------------------------
*/
if ($action === 'list' || ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id']))) {
    $sql = "SELECT 
                id,
                name,
                category,
                description,
                price,
                installation_fee,
                image_path,
                is_active,
                fitur
            FROM addon
            ORDER BY id DESC";

    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

/*
|--------------------------------------------------------------------------
| DETAIL ADDON (dengan parameter action=detail)
|--------------------------------------------------------------------------
*/
if ($action === 'detail') {
    $id = intval($_GET['id'] ?? 0);

    $stmt = $conn->prepare("SELECT * FROM addon WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
        exit;
    }

    echo json_encode($result->fetch_assoc());
    exit;
}

/*
|--------------------------------------------------------------------------
| ADD ADDON
|--------------------------------------------------------------------------
*/
if ($action === 'add') {
    // Log untuk debugging (hapus setelah selesai debug)
    error_log("=== ADD ADDON REQUEST ===");
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));
    
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = intval($_POST['price'] ?? 0);
    $installation_fee = intval($_POST['installation_fee'] ?? 0);
    $is_active = intval($_POST['is_active'] ?? 1);
    $fitur = trim($_POST['fitur'] ?? '');

    // Validasi
    if (empty($name)) {
        echo json_encode([
            'success' => false,
            'message' => 'Nama Add On wajib diisi'
        ]);
        exit;
    }
    
    if (empty($category)) {
        echo json_encode([
            'success' => false,
            'message' => 'Kategori wajib dipilih'
        ]);
        exit;
    }
    
    if ($price <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Harga harus lebih dari 0'
        ]);
        exit;
    }

    // Handle upload gambar
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/addons/';
        
        // Buat folder jika belum ada
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal membuat folder upload'
                ]);
                exit;
            }
        }
        
        // Validasi file
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        
        // Cek ukuran file (max 5MB)
        if ($file_size > 5 * 1024 * 1024) {
            echo json_encode([
                'success' => false,
                'message' => 'Ukuran file terlalu besar (max 5MB)'
            ]);
            exit;
        }
        
        // Cek ekstensi
        if (!in_array($file_ext, $allowed_ext)) {
            echo json_encode([
                'success' => false,
                'message' => 'Format file tidak valid. Gunakan: ' . implode(', ', $allowed_ext)
            ]);
            exit;
        }
        
        // Generate nama file unik
        $new_file_name = 'addon_' . time() . '_' . uniqid() . '.' . $file_ext;
        $target_file = $upload_dir . $new_file_name;
        
        // Upload file
        if (move_uploaded_file($file_tmp, $target_file)) {
            $image_path = $target_file;
            error_log("Image uploaded: " . $image_path);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal upload gambar. Periksa permission folder.'
            ]);
            exit;
        }
    } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Ada error saat upload
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE => 'File terlalu besar (php.ini)',
            UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (form)',
            UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ada',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
            UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh extension'
        ];
        
        $error_code = $_FILES['image']['error'];
        $error_msg = $upload_errors[$error_code] ?? 'Unknown upload error';
        
        echo json_encode([
            'success' => false,
            'message' => 'Upload error: ' . $error_msg
        ]);
        exit;
    }

    // Insert ke database
    $stmt = $conn->prepare(
        "INSERT INTO addon 
        (name, category, description, price, installation_fee, is_active, fitur, image_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'message' => 'Database prepare error: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param(
        "sssiisss",
        $name,
        $category,
        $description,
        $price,
        $installation_fee,
        $is_active,
        $fitur,
        $image_path
    );

    if ($stmt->execute()) {
        $new_id = $stmt->insert_id;
        error_log("New addon inserted with ID: " . $new_id);
        
        echo json_encode([
            'success' => true,
            'message' => 'Add On berhasil disimpan',
            'id' => $new_id
        ]);
    } else {
        error_log("Database execute error: " . $stmt->error);
        
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $stmt->error
        ]);
    }
    exit;
}

/*
|--------------------------------------------------------------------------
| UPDATE ADDON (POST dengan action=update atau dengan id)
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'update' || isset($_POST['id']))) {
    $id = intval($_POST['id']);
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = intval($_POST['price'] ?? 0);
    $installation_fee = intval($_POST['installation_fee'] ?? 0);
    $is_active = intval($_POST['is_active'] ?? 1);
    $fitur = $_POST['fitur'] ?? '';

    // Validasi
    if ($name === '' || $price <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Nama dan harga wajib diisi'
        ]);
        exit;
    }

    // Handle upload gambar baru
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/addons/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($file_ext, $allowed_ext)) {
            echo json_encode(['success' => false, 'message' => 'Format file tidak valid']);
            exit;
        }
        
        $file_name = 'addon_' . time() . '_' . uniqid() . '.' . $file_ext;
        $target_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
            
            // Hapus gambar lama jika ada
            $stmt_old = $conn->prepare("SELECT image_path FROM addon WHERE id = ?");
            $stmt_old->bind_param("i", $id);
            $stmt_old->execute();
            $result_old = $stmt_old->get_result();
            if ($row_old = $result_old->fetch_assoc()) {
                if ($row_old['image_path'] && file_exists($row_old['image_path'])) {
                    unlink($row_old['image_path']);
                }
            }
        }
    }

    // Update database
    if ($image_path) {
        // Update dengan gambar baru
        $stmt = $conn->prepare(
            "UPDATE addon SET 
                name = ?, 
                category = ?, 
                description = ?, 
                price = ?, 
                installation_fee = ?, 
                is_active = ?, 
                fitur = ?, 
                image_path = ? 
            WHERE id = ?"
        );
        $stmt->bind_param(
            "sssiiissi",
            $name,
            $category,
            $description,
            $price,
            $installation_fee,
            $is_active,
            $fitur,
            $image_path,
            $id
        );
    } else {
        // Update tanpa mengubah gambar
        $stmt = $conn->prepare(
            "UPDATE addon SET 
                name = ?, 
                category = ?, 
                description = ?, 
                price = ?, 
                installation_fee = ?, 
                is_active = ?, 
                fitur = ? 
            WHERE id = ?"
        );
        $stmt->bind_param(
            "sssiissi",
            $name,
            $category,
            $description,
            $price,
            $installation_fee,
            $is_active,
            $fitur,
            $id
        );
    }

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Data berhasil diperbarui'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $stmt->error
        ]);
    }
    exit;
}

/*
|--------------------------------------------------------------------------
| DELETE ADDON
|--------------------------------------------------------------------------
*/
if ($action === 'delete') {
    // Support POST method dengan action=delete
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['id'] ?? 0);
    } 
    // Support DELETE method (JSON body)
    else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = intval($data['id'] ?? 0);
    } 
    // Support GET method dengan action=delete
    else {
        $id = intval($_GET['id'] ?? 0);
    }

    // Validasi ID
    if ($id <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'ID tidak valid atau tidak ditemukan'
        ]);
        exit;
    }

    // Cek apakah data ada
    $check_stmt = $conn->prepare("SELECT id, image_path FROM addon WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Data dengan ID ' . $id . ' tidak ditemukan'
        ]);
        exit;
    }

    // Hapus gambar jika ada
    $row_img = $check_result->fetch_assoc();
    if ($row_img['image_path'] && file_exists($row_img['image_path'])) {
        if (!unlink($row_img['image_path'])) {
            // Gambar gagal dihapus, tapi lanjutkan hapus data
            error_log("Warning: Gagal menghapus file gambar: " . $row_img['image_path']);
        }
    }

    // Hapus dari database
    $stmt = $conn->prepare("DELETE FROM addon WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil dihapus',
                'deleted_id' => $id
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak dihapus (mungkin sudah tidak ada)'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $stmt->error
        ]);
    }
    exit;
}

/*
|--------------------------------------------------------------------------
| ACTION TIDAK VALID
|--------------------------------------------------------------------------
*/
echo json_encode([
    'success' => false,
    'message' => 'Action tidak valid: ' . $action
]);
exit;
?>