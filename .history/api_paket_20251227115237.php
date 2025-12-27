<?php
@ini_set('display_errors', '0');
@error_reporting(0);

function sendJSON($data, $code = 200) {
    while (ob_get_level()) ob_end_clean();
    http_response_code($code);
    header("Content-Type: application/json; charset=utf-8");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function toInt($v, $d = 0) {
    return is_numeric($v) ? (int)$v : $d;
}
function clean($v) {
    return trim((string)$v);
}

require_once __DIR__ . "/config.php";
$method = $_SERVER['REQUEST_METHOD'];


// ===================== GET =====================
if ($method === 'GET') {
    $sql = "SELECT * FROM paket ORDER BY id ASC";
    $res = $conn->query($sql);

    $data = [];
    while ($r = $res->fetch_assoc()) {
        $data[] = [
            'id' => toInt($r['id']),
            'name' => clean($r['name']),
            'kecepatan' => clean($r['kecepatan']),
            'harga_sumatera' => toInt($r['harga_sumatera']),
            'harga_sumatera_before' => toInt($r['harga_sumatera_before']),
            'harga_jawa' => toInt($r['harga_jawa']),
            'harga_jawa_before' => toInt($r['harga_jawa_before']),
            'harga_timur' => toInt($r['harga_timur']),
            'harga_timur_before' => toInt($r['harga_timur_before']),
            'instalasi_sumatera' => toInt($r['instalasi_sumatera']),
            'instalasi_sumatera_before' => toInt($r['instalasi_sumatera_before']),
            'instalasi_jawa' => toInt($r['instalasi_jawa']),
            'instalasi_jawa_before' => toInt($r['instalasi_jawa_before']),
            'instalasi_timur' => toInt($r['instalasi_timur']),
            'instalasi_timur_before' => toInt($r['instalasi_timur_before']),
            'max_perangkat' => toInt($r['max_perangkat']),
            'max_laptop' => toInt($r['max_laptop']),
            'max_smartphone' => toInt($r['max_smartphone']),
            'tv_4k' => clean($r['tv_4k']),
            'streaming' => clean($r['streaming']),
            'gaming' => clean($r['gaming']),
            'features' => clean($r['features']),
            'status' => toInt($r['is_active'])
        ];
    }
    sendJSON($data);
}


// ===================== POST =====================
if ($method === 'POST') {
    $sql = "INSERT INTO paket (
        name,
        harga_sumatera, harga_sumatera_before,
        harga_jawa, harga_jawa_before,
        harga_timur, harga_timur_before,
        instalasi_sumatera, instalasi_sumatera_before,
        instalasi_jawa, instalasi_jawa_before,
        instalasi_timur, instalasi_timur_before,
        kecepatan,
        max_perangkat, max_laptop, max_smartphone,
        tv_4k, streaming, gaming, features, is_active
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "iiiiiiiiiiiiisiiissssi",
        $_POST['sumatera'],
        $_POST['sumatera_before'],
        $_POST['jawa'],
        $_POST['jawa_before'],
        $_POST['timur'],
        $_POST['timur_before'],
        $_POST['instalasi_sumatera'],
        $_POST['instalasi_sumatera_before'],
        $_POST['instalasi_jawa'],
        $_POST['instalasi_jawa_before'],
        $_POST['instalasi_timur'],
        $_POST['instalasi_timur_before'],
        $_POST['kecepatan'],
        $_POST['max_perangkat'],
        $_POST['max_laptop'],
        $_POST['max_smartphone'],
        $_POST['tv_4k'],
        $_POST['streaming'],
        $_POST['gaming'],
        $_POST['features'],
        $_POST['status']
    );

    if ($stmt->execute()) {
        sendJSON(['success' => true]);
    }
    sendJSON(['success' => false, 'message' => $stmt->error], 500);
}


// ===================== PUT =====================
if ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    $sql = "UPDATE paket SET
        name=?,
        harga_sumatera=?, harga_sumatera_before=?,
        harga_jawa=?, harga_jawa_before=?,
        harga_timur=?, harga_timur_before=?,
        instalasi_sumatera=?, instalasi_sumatera_before=?,
        instalasi_jawa=?, instalasi_jawa_before=?,
        instalasi_timur=?, instalasi_timur_before=?,
        kecepatan=?,
        max_perangkat=?, max_laptop=?, max_smartphone=?,
        tv_4k=?, streaming=?, gaming=?, features=?, is_active=?
        WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "siiiiiiiiiiiiisiiissssii",
        $data['nama'],
        $data['sumatera'], $data['sumatera_before'],
        $data['jawa'], $data['jawa_before'],
        $data['timur'], $data['timur_before'],
        $data['instalasi_sumatera'], $data['instalasi_sumatera_before'],
        $data['instalasi_jawa'], $data['instalasi_jawa_before'],
        $data['instalasi_timur'], $data['instalasi_timur_before'],
        $data['kecepatan'],
        $data['max_perangkat'], $data['max_laptop'], $data['max_smartphone'],
        $data['tv_4k'], $data['streaming'], $data['gaming'], $data['features'],
        $data['status'],
        $data['id']
    );

    if ($stmt->execute()) {
        sendJSON(['success' => true]);
    }
    sendJSON(['success' => false, 'message' => $stmt->error], 500);
}

sendJSON(['success' => false, 'message' => 'Invalid Method'], 405);
