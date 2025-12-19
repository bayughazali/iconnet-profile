<?php
// auth.php - Sistem Autentikasi Admin FIXED
require_once 'config.php';

// Enable CORS if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$action = isset($_GET['action']) ? $_GET['action'] : '';

// ==================== LOGIN ====================
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    
    // Cek dulu password asli di database
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $db_password = $admin['password'];
        
        // Cek apakah password di database sudah di-hash atau belum
        // Jika panjang password = 32 karakter, berarti MD5
        // Jika tidak, berarti plain text
        
        $password_match = false;
        
        if (strlen($db_password) == 32) {
            // Password di database sudah MD5, bandingkan dengan MD5
            $password_match = ($db_password === md5($password));
        } else {
            // Password di database masih plain text
            $password_match = ($db_password === $password);
        }
        
        if ($password_match) {
            // Set session
            session_start();
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_email'] = $admin['email'];
            
            // Update last login
            $admin_id = $admin['id'];
            $conn->query("UPDATE admin SET last_login = NOW() WHERE id = '$admin_id'");
            
            json_response(true, 'Login berhasil', [
                'username' => $admin['username'],
                'email' => $admin['email'],
                'redirect' => 'dashboard.php'
            ]);
        } else {
            json_response(false, 'Password salah');
        }
    } else {
        json_response(false, 'Username tidak ditemukan');
    }
}

// ==================== LOGOUT ====================
if ($action === 'logout') {
    session_start();
    session_destroy();
    json_response(true, 'Logout berhasil', ['redirect' => 'login.php']);
}

// ==================== CHECK SESSION ====================
if ($action === 'check_session') {
    session_start();
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        json_response(true, 'Session aktif', [
            'username' => $_SESSION['admin_username'],
            'email' => $_SESSION['admin_email']
        ]);
    } else {
        json_response(false, 'Session tidak aktif');
    }
}

// ==================== CHANGE PASSWORD ====================
if ($action === 'change_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    check_login();
    
    $old_password = md5(clean_input($_POST['old_password']));
    $new_password = md5(clean_input($_POST['new_password']));
    $admin_id = $_SESSION['admin_id'];
    
    // Cek password lama
    $sql = "SELECT * FROM admin WHERE id = '$admin_id' AND password = '$old_password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Update password baru
        $sql = "UPDATE admin SET password = '$new_password' WHERE id = '$admin_id'";
        if ($conn->query($sql)) {
            json_response(true, 'Password berhasil diubah');
        } else {
            json_response(false, 'Gagal mengubah password');
        }
    } else {
        json_response(false, 'Password lama tidak sesuai');
    }
}

// ==================== FORGOT PASSWORD ====================
if ($action === 'forgot_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean_input($_POST['email']);
    
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Generate token reset password (simplified)
        $token = bin2hex(random_bytes(32));
        
        // Di sini seharusnya kirim email dengan link reset password
        // Untuk demo, kita hanya return success
        
        json_response(true, 'Link reset password telah dikirim ke email Anda', [
            'email' => $email
        ]);
    } else {
        json_response(false, 'Email tidak ditemukan');
    }
}

// ==================== DEBUG - CEK PASSWORD DI DATABASE ====================
if ($action === 'debug_check_password' && isset($_GET['username'])) {
    $username = clean_input($_GET['username']);
    
    $sql = "SELECT id, username, password FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        json_response(true, 'Debug Info', [
            'username' => $admin['username'],
            'password_in_db' => $admin['password'],
            'password_length' => strlen($admin['password']),
            'is_md5' => (strlen($admin['password']) == 32) ? 'Yes' : 'No',
            'admin123_md5' => md5('admin123'),
            'admin_md5' => md5('admin')
        ]);
    } else {
        json_response(false, 'Username tidak ditemukan');
    }
}

$conn->close();
?>