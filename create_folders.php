<?php
// create_folders.php - Jalankan sekali untuk buat folder

$folders = [
    'uploads',
    'uploads/slider',
    'uploads/paket',
    'uploads/berita',
    'uploads/promo'
];

echo "<h2>Membuat Folder Upload...</h2>";

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        if (mkdir($folder, 0777, true)) {
            echo "✅ <strong>$folder</strong> berhasil dibuat<br>";
        } else {
            echo "❌ <strong>$folder</strong> GAGAL dibuat<br>";
        }
    } else {
        echo "ℹ️ <strong>$folder</strong> sudah ada<br>";
    }
    
    if (is_dir($folder)) {
        chmod($folder, 0777);
        if (is_writable($folder)) {
            echo "✅ Folder <strong>writable</strong><br>";
        } else {
            echo "❌ Folder <strong>NOT writable</strong><br>";
        }
    }
    echo "<hr>";
}

echo "<h3>Selesai!</h3>";
?>