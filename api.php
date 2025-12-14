<?php
// api.php - REST API untuk CRUD Operations
require_once 'config.php';

// Hanya izinkan request dari admin yang sudah login (kecuali get public data)
$public_actions = ['get_paket_public', 'get_berita_public', 'get_faq_public', 'get_slider_public'];
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
    
    json_response(true, 'Stats loaded', $stats);
}

// ==================== GET ALL DATA ====================
if ($action === 'get_all') {
    $table = clean_input($_GET['table']);
    $allowed_tables = ['slider', 'paket', 'berita', 'faq'];
    
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
    $allowed_tables = ['slider', 'paket', 'berita', 'faq'];
    
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

// ==================== INSERT DATA (TAMBAH DATA BARU) ====================
if ($action === 'insert' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = clean_input($_GET['table']);
    $allowed_tables = ['slider', 'paket', 'berita', 'faq'];
    
    if (!in_array($table, $allowed_tables)) {
        json_response(false, 'Tabel tidak valid');
    }
    
    // Insert berdasarkan tabel
    switch ($table) {
        case 'slider':
            $name = clean_input($_POST['name']);
            $image_path = clean_input($_POST['image_path']);
            $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
            
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
    $allowed_tables = ['slider', 'paket', 'berita', 'faq'];
    
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
    $allowed_tables = ['slider', 'paket', 'berita', 'faq'];
    
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
if ($action === 'get_berita_public') {
    $sql = "SELECT * FROM berita WHERE is_active = 1 ORDER BY id DESC LIMIT 3";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    json_response(true, 'Berita loaded', $data);
}

// Get Active FAQ untuk Homepage
if ($action === 'get_faq_public') {
    $sql = "SELECT * FROM faq WHERE is_active = 1 ORDER BY id ASC LIMIT 5";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    json_response(true, 'FAQ loaded', $data);
}

$conn->close();
?>