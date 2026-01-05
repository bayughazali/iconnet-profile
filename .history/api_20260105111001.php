<?php
// api.php - REST API untuk CRUD Operations
require_once 'config.php';

// ✅ TAMBAHAN BARU: Anti-cache headers untuk data real-time
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: 0');

// Hanya izinkan request dari admin yang sudah login (kecuali get public data)
$public_actions = ['get_paket_public', 'get_berita_public', 'get_faq_public', 'get_slider_public', 'get_promo_public', 'get_promo_by_id', 'get_promo_by_region'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if (!in_array($action, $public_actions)) {
    session_start();
    check_login();
}

// ==================== GET DASHBOARD STATS ====================
if ($action === 'get_stats') {
    $stats = [];
    
    $stats['slider'] = $conn->query("SELECT COUNT(*) as total FROM slider")->fetch_assoc()['total'];
    $stats['paket'] = $conn->query("SELECT COUNT(*) as total FROM paket")->fetch_assoc()['total'];
    $stats['berita'] = $conn->query("SELECT COUNT(*) as total FROM berita")->fetch_assoc()['total'];
    $stats['faq'] = $conn->query("SELECT COUNT(*) as total FROM faq")->fetch_assoc()['total'];
    $stats['promo'] = $conn->query("SELECT COUNT(*) as total FROM promo")->fetch_assoc()['total'];
    
    json_response(true, 'Stats loaded', $stats);
}

// ==================== GET ALL DATA ====================
if ($action === 'get_all') {
    $table = clean_input($_GET['table']);
    $allowed_tables = ['slider', 'paket', 'berita', 'faq', 'promo'];
    
    if (!in_array($table, $allowed_tables)) {
        json_response(false, 'Tabel tidak valid');
    }
    
    $sql = "SELECT * FROM $table ORDER BY id DESC";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        // Convert is_active ke boolean
        if (isset($row['is_active'])) {
            $row['is_active'] = (bool)$row['is_active'];
        }
        $data[] = $row;
    }
    
    json_response(true, 'Data loaded', $data);
}

// ==================== GET BY ID ====================
if ($action === 'get_by_id') {
    $table = clean_input($_GET['table']);
    $id = clean_input($_GET['id']);
    $allowed_tables = ['slider', 'paket', 'berita', 'faq', 'promo'];
    
    if (!in_array($table, $allowed_tables)) {
        json_response(false, 'Tabel tidak valid');
    }
    
    $sql = "SELECT * FROM $table WHERE id = '$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Convert is_active ke boolean
        if (isset($data['is_active'])) {
            $data['is_active'] = (bool)$data['is_active'];
        }
        
        json_response(true, 'Data found', $data);
    } else {
        json_response(false, 'Data tidak ditemukan');
    }
}

    // ================= GET SLIDER (LANDING PAGE) =================
    if ($_GET['action'] === 'get' && $_GET['table'] === 'slider') {

        $result = $conn->query(
            "SELECT * FROM slider 
            WHERE is_active = 1 
            ORDER BY display_order ASC, created_at DESC"
        );

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
        exit;
    }


// ==================== INSERT DATA (TAMBAH DATA BARU) ====================
if ($action === 'insert' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = clean_input($_GET['table']);
    $allowed_tables = ['slider', 'paket', 'berita', 'faq', 'promo'];
    
    if (!in_array($table, $allowed_tables)) {
        json_response(false, 'Tabel tidak valid');
    }
    
    // Insert berdasarkan tabel
    switch ($table) {
       case 'slider':
    $name = isset($_POST['name']) ? clean_input($_POST['name']) : '';
    $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

    if (empty($name)) {
        json_response(false, 'Nama slider wajib diisi');
    }

    // ===== UPLOAD GAMBAR =====
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        json_response(false, 'Gambar slider wajib diupload');
    }

    $uploadDir = 'uploads/slider/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = 'slider_' . time() . '.' . $ext;
    $image_path = $uploadDir . $filename;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        json_response(false, 'Gagal upload gambar slider');
    }

    // ===== INSERT DATABASE =====
    $sql = "INSERT INTO slider (name, image_path, is_active, created_at, updated_at) 
            VALUES ('$name', '$image_path', $is_active, NOW(), NOW())";
    break;

            
        case 'paket':
            $id = clean_input($_POST['id']);
            $name = clean_input($_POST['name']);
            $harga_sumatera = clean_input($_POST['harga_sumatera']);
            $harga_jawa = clean_input($_POST['harga_jawa']);
            $harga_timur = clean_input($_POST['harga_timur']);
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
            
            // Cek apakah ID sudah ada
            $check = $conn->query("SELECT id FROM paket WHERE id = '$id'");
            if ($check->num_rows > 0) {
                json_response(false, 'ID Paket sudah digunakan, gunakan ID yang berbeda');
            }
            
            $sql = "INSERT INTO paket (id, name, harga_sumatera, harga_jawa, harga_timur, is_active, created_at, updated_at) 
                    VALUES ('$id', '$name', '$harga_sumatera', '$harga_jawa', '$harga_timur', $is_active, NOW(), NOW())";
            break;
            
        case 'berita':
            $title = clean_input($_POST['title']);
            $date = clean_input($_POST['date']);
            $content = isset($_POST['content']) ? clean_input($_POST['content']) : '';
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
            
            // Handle file upload
            $image_url = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_result = upload_image($_FILES['image'], 'uploads/berita/');
                if ($upload_result['success']) {
                    $image_url = $upload_result['path'];
                } else {
                    json_response(false, $upload_result['message']);
                }
            }
            
            $sql = "INSERT INTO berita (title, date, image_url, content, is_active, created_at, updated_at) 
                    VALUES ('$title', '$date', '$image_url', '$content', $is_active, NOW(), NOW())";
            break;
            
        case 'faq':
            $question = clean_input($_POST['question']);
            $answer = clean_input($_POST['answer']);
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
            
            $sql = "INSERT INTO faq (question, answer, is_active, created_at, updated_at) 
                    VALUES ('$question', '$answer', $is_active, NOW(), NOW())";
            break;
            
        case 'promo':
            // FIXED: Jangan cek $_POST['id'] untuk INSERT!
            $title = isset($_POST['title']) ? clean_input($_POST['title']) : '';
            $description = isset($_POST['description']) ? clean_input($_POST['description']) : '';
            $region = isset($_POST['region']) ? clean_input($_POST['region']) : '';
            $discount_percentage = isset($_POST['discount_percentage']) ? (int)clean_input($_POST['discount_percentage']) : 0;
            $start_date = isset($_POST['start_date']) ? clean_input($_POST['start_date']) : '';
            $end_date = isset($_POST['end_date']) ? clean_input($_POST['end_date']) : '';
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
            
            // Validasi field wajib
            if (empty($title) || empty($description) || empty($region) || empty($start_date) || empty($end_date)) {
                json_response(false, 'Field wajib tidak boleh kosong!');
            }
            
            // Handle upload gambar
            $image_path = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_result = upload_image($_FILES['image'], 'uploads/promo/');
                if ($upload_result['success']) {
                    $image_path = $upload_result['path'];
                } else {
                    json_response(false, $upload_result['message']);
                }
            }
            
            // Query INSERT
            $sql = "INSERT INTO promo (title, description, image_path, region, discount_percentage, start_date, end_date, is_active, created_at, updated_at) 
                    VALUES ('$title', '$description', '$image_path', '$region', $discount_percentage, '$start_date', '$end_date', $is_active, NOW(), NOW())";
            break;
    }
    
    if ($conn->query($sql)) {
        json_response(true, 'Data berhasil ditambahkan');
    } else {
        json_response(false, 'Gagal menambahkan data: ' . $conn->error);
    }
}

// ==================== UPDATE DATA ====================
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = clean_input($_GET['table']);
    $allowed_tables = ['slider', 'paket', 'berita', 'faq', 'promo'];
    
    if (!in_array($table, $allowed_tables)) {
        json_response(false, 'Tabel tidak valid');
    }
    
    $id = clean_input($_POST['id']);
    
    // Update berdasarkan tabel
    switch ($table) {
        case 'slider':
            $name = clean_input($_POST['name']);
            $image_path = clean_input($_POST['image_path']);
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 0;
            
            $sql = "UPDATE slider SET 
                    name = '$name',
                    image_path = '$image_path',
                    is_active = $is_active,
                    updated_at = NOW()
                    WHERE id = '$id'";
            break;
            
        case 'paket':
            $name = clean_input($_POST['name']);
            $harga_sumatera = clean_input($_POST['harga_sumatera']);
            $harga_jawa = clean_input($_POST['harga_jawa']);
            $harga_timur = clean_input($_POST['harga_timur']);
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 0;
            
            $sql = "UPDATE paket SET 
                    name = '$name',
                    harga_sumatera = '$harga_sumatera',
                    harga_jawa = '$harga_jawa',
                    harga_timur = '$harga_timur',
                    is_active = $is_active,
                    updated_at = NOW()
                    WHERE id = '$id'";
            break;
            
        case 'berita':
            $title = clean_input($_POST['title']);
            $date = clean_input($_POST['date']);
            $content = isset($_POST['content']) ? clean_input($_POST['content']) : '';
            $image_url = isset($_POST['image_url']) ? clean_input($_POST['image_url']) : '';
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 0;
            
            $sql = "UPDATE berita SET 
                    title = '$title',
                    date = '$date',
                    image_url = '$image_url',
                    content = '$content',
                    is_active = $is_active,
                    updated_at = NOW()
                    WHERE id = '$id'";
            break;
            
        case 'faq':
            $question = clean_input($_POST['question']);
            $answer = clean_input($_POST['answer']);
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 0;
            
            $sql = "UPDATE faq SET 
                    question = '$question',
                    answer = '$answer',
                    is_active = $is_active,
                    updated_at = NOW()
                    WHERE id = '$id'";
            break;
            
        case 'promo':
            $title = clean_input($_POST['title']);
            $description = clean_input($_POST['description']);
            $region = clean_input($_POST['region']);
            $discount_percentage = isset($_POST['discount_percentage']) ? (int)clean_input($_POST['discount_percentage']) : 0;
            $start_date = clean_input($_POST['start_date']);
            $end_date = clean_input($_POST['end_date']);
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 0;
            
            // Cek apakah ada upload gambar baru
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_result = upload_image($_FILES['image'], 'uploads/promo/');
                if ($upload_result['success']) {
                    $image_path = $upload_result['path'];
                    
                    // Update dengan gambar baru
                    $sql = "UPDATE promo SET 
                            title = '$title',
                            description = '$description',
                            image_path = '$image_path',
                            region = '$region',
                            discount_percentage = $discount_percentage,
                            start_date = '$start_date',
                            end_date = '$end_date',
                            is_active = $is_active,
                            updated_at = NOW()
                            WHERE id = '$id'";
                } else {
                    json_response(false, $upload_result['message']);
                }
            } else {
                // Update tanpa gambar baru
                $sql = "UPDATE promo SET 
                        title = '$title',
                        description = '$description',
                        region = '$region',
                        discount_percentage = $discount_percentage,
                        start_date = '$start_date',
                        end_date = '$end_date',
                        is_active = $is_active,
                        updated_at = NOW()
                        WHERE id = '$id'";
            }
            break;
    }
    
    if ($conn->query($sql)) {
        json_response(true, 'Data berhasil diupdate');
    } else {
        json_response(false, 'Gagal update data: ' . $conn->error);
    }
}

// ==================== DELETE DATA ====================
if ($action === 'delete') {
    $table = clean_input($_GET['table']);
    $id = clean_input($_GET['id']);
    $allowed_tables = ['slider', 'paket', 'berita', 'faq', 'promo'];
    
    if (!in_array($table, $allowed_tables)) {
        json_response(false, 'Tabel tidak valid');
    }
    
    $sql = "DELETE FROM $table WHERE id = '$id'";
    
    if ($conn->query($sql)) {
        json_response(true, 'Data berhasil dihapus');
    } else {
        json_response(false, 'Gagal menghapus data: ' . $conn->error);
    }
}

// ==================== PUBLIC ENDPOINTS (Tanpa Login) ====================

// Get Active Sliders untuk Homepage
if ($action === 'get_slider_public') {
    $sql = "SELECT * FROM slider WHERE is_active = 1 ORDER BY id ASC";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    json_response(true, 'Sliders loaded', $data);
}

// Get Active Paket untuk Homepage
if ($action === 'get_paket_public') {
    $sql = "SELECT * FROM paket WHERE is_active = 1 ORDER BY id ASC";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    json_response(true, 'Paket loaded', $data);
}

// Get Active Berita untuk Homepage
// Get Active Berita untuk Homepage
if ($action === 'get_berita_public') {
    $sql = "SELECT * FROM berita WHERE is_active = 1 ORDER BY date DESC, id DESC";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    json_response(true, 'Berita loaded', $data);
}

// Get Active FAQ untuk Homepage
if ($action === 'get_faq_public') {
    $sql = "SELECT * FROM faq WHERE is_active = 1 ORDER BY id DESC";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    // ✅ DEBUG: Log query dan hasil
    error_log("FAQ Query: " . $sql);
    error_log("FAQ Count: " . count($data));
    error_log("FAQ Data: " . json_encode($data));
    
    json_response(true, 'FAQ loaded', $data);
}

// Get Active Promo untuk Homepage
if ($action === 'get_promo_public') {
    $sql = "SELECT * FROM promo WHERE is_active = 1 ORDER BY start_date DESC";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    json_response(true, 'Promo loaded', $data);
}

// Get Promo By ID untuk detail
if ($action === 'get_promo_by_id') {
    $id = clean_input($_GET['id']);
    
    $sql = "SELECT * FROM promo WHERE id = '$id' AND is_active = 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        json_response(true, 'Promo found', $data);
    } else {
        json_response(false, 'Promo tidak ditemukan');
    }
}

// Get Promo by Region
if ($action === 'get_promo_by_region') {
    $region = clean_input($_GET['region']);
    
    $sql = "SELECT * FROM promo WHERE region = '$region' AND is_active = 1 ORDER BY start_date DESC";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    json_response(true, 'Promo loaded', $data);
}

$conn->close();
if ($_GET['action'] === 'update' && $_GET['table'] === 'slider') {

    $id = (int)$_POST['id'];
    $name = clean_input($_POST['name']);
    $is_active = (int)$_POST['is_active'];

    $image_sql = "";

    // jika upload gambar baru
    if (!empty($_FILES['image']['name'])) {

        $uploadDir = 'uploads/slider/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'slider_' . time() . '.' . $ext;
        $path = $uploadDir . $filename;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
            json_response(false, 'Gagal upload gambar');
        }

        $image_sql = ", image_path='$path'";
    }

    $sql = "UPDATE slider 
            SET name='$name', is_active=$is_active $image_sql, updated_at=NOW()
            WHERE id=$id";

    if ($conn->query($sql)) {
        json_response(true, 'Slider diperbarui');
    } else {
        json_response(false, $conn->error);
    }
}

?>