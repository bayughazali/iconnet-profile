<!DOCTYPE html>
<html>
<head>
    <title>Quick Test - ICONNET API</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success { color: green; }
        .error { color: red; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 4px; overflow-x: auto; }
        h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
    </style>
</head>
<body>
    <h1>🔍 ICONNET API Quick Test</h1>

    <!-- Test 1: Database Connection -->
    <div class="box">
        <h2>1. Test Koneksi Database</h2>
        <?php
        $db_path = __DIR__ . '/config/db.php';
        
        if (file_exists($db_path)) {
            echo "<p class='success'>✅ File config/db.php ditemukan</p>";
            require_once $db_path;
            
            if (isset($conn) && $conn->ping()) {
                echo "<p class='success'>✅ Koneksi database BERHASIL</p>";
                echo "<p>Database: " . $conn->server_info . "</p>";
            } else {
                echo "<p class='error'>❌ Koneksi database GAGAL</p>";
            }
        } else {
            echo "<p class='error'>❌ File config/db.php tidak ditemukan</p>";
            echo "<p>Expected path: " . $db_path . "</p>";
        }
        ?>
    </div>

    <!-- Test 2: Check Table Paket -->
    <div class="box">
        <h2>2. Test Tabel Paket</h2>
        <?php
        if (isset($conn)) {
            $result = $conn->query("SELECT COUNT(*) as total FROM paket");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "<p class='success'>✅ Tabel paket ditemukan</p>";
                echo "<p>Total records: <strong>" . $row['total'] . "</strong></p>";
            } else {
                echo "<p class='error'>❌ Tabel paket tidak ditemukan: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>

    <!-- Test 3: Check Active Packages -->
    <div class="box">
        <h2>3. Test Paket Aktif (status = 1)</h2>
        <?php
        if (isset($conn)) {
            $result = $conn->query("SELECT * FROM paket WHERE status = 1");
            if ($result) {
                $count = $result->num_rows;
                echo "<p class='success'>✅ Query berhasil</p>";
                echo "<p>Paket aktif: <strong>" . $count . "</strong></p>";
                
                if ($count > 0) {
                    echo "<h3>Data Paket:</h3>";
                    echo "<pre>";
                    $data = [];
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    echo "</pre>";
                } else {
                    echo "<p class='error'>⚠️ TIDAK ADA PAKET DENGAN STATUS = 1</p>";
                    echo "<p>Solusi: Jalankan query berikut di phpMyAdmin:</p>";
                    echo "<pre>UPDATE paket SET status = 1;</pre>";
                }
            } else {
                echo "<p class='error'>❌ Query gagal: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>

    <!-- Test 4: API Endpoint -->
    <div class="box">
        <h2>4. Test API Endpoint</h2>
        <?php
        $api_paths = [
            'api/paket.php',
            'api_paket.php',
            'get_paket.php'
        ];
        
        $found = false;
        foreach ($api_paths as $path) {
            $full_path = __DIR__ . '/' . $path;
            if (file_exists($full_path)) {
                echo "<p class='success'>✅ File API ditemukan: <code>$path</code></p>";
                echo "<p>URL: <a href='$path' target='_blank'>$path</a></p>";
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo "<p class='error'>❌ File API tidak ditemukan</p>";
            echo "<p>Coba cek di folder:</p>";
            echo "<ul>";
            echo "<li>api/paket.php</li>";
            echo "<li>api_paket.php</li>";
            echo "</ul>";
        }
        ?>
    </div>

    <!-- Test 5: JavaScript Fetch Test -->
    <div class="box">
        <h2>5. Test Fetch dari JavaScript</h2>
        <button onclick="testFetch()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
            🧪 Test Fetch API
        </button>
        <pre id="fetch-result" style="margin-top: 10px;">Klik tombol untuk test...</pre>
    </div>

    <script>
        async function testFetch() {
            const result = document.getElementById('fetch-result');
            result.textContent = '⏳ Loading...';
            
            const paths = ['api/paket.php', '../api/paket.php', 'api_paket.php'];
            
            for (const path of paths) {
                try {
                    result.textContent += `\n📡 Trying: ${path}`;
                    const response = await fetch(path);
                    
                    if (response.ok) {
                        const data = await response.json();
                        result.textContent = `✅ SUCCESS with path: ${path}\n\n`;
                        result.textContent += JSON.stringify(data, null, 2);
                        return;
                    } else {
                        result.textContent += ` - HTTP ${response.status}`;
                    }
                } catch (err) {
                    result.textContent += ` - Error: ${err.message}`;
                }
            }
            
            result.textContent += '\n\n❌ All paths failed!';
        }
    </script>

    <?php
    if (isset($conn)) {
        $conn->close();
    }
    ?>
</body>
</html>