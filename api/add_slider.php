<?php
include '../config/koneksi.php';

$name = $_POST['name'];
$is_active = $_POST['is_active'];

if (!isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'message' => 'Gambar tidak ada']);
    exit;
}

$folder = '../uploads/slider/';
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$filename = time() . '.' . $ext;
$path = 'uploads/slider/' . $filename;

move_uploaded_file($_FILES['image']['tmp_name'], '../' . $path);

$query = mysqli_query($conn, "
    INSERT INTO sliders (name, image_path, is_active)
    VALUES ('$name', '$path', '$is_active')
");

echo json_encode(['success' => true]);
