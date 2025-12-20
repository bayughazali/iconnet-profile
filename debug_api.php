<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug API ICONNET</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            max-height: 500px;
            overflow-y: auto;
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">🔍 Debug API ICONNET</h2>

        <!-- Test 1: Database Connection -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5>Test 1: Database Connection</h5>
            </div>
            <div class="card-body">
                <?php
                require_once 'config/db.php';
                
                if ($conn->connect_error) {
                    echo '<p class="error">❌ GAGAL: ' . $conn->connect_error . '</p>';
                } else {
                    echo '<p class="success">✅ Koneksi berhasil ke database: ' . $conn->server_info . '</p>';
                }
                ?>
            </div>
        </div>

        <!-- Test 2: Cek Tabel Paket -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h5>Test 2: Struktur Tabel Paket</h5>
            </div>
            <div class="card-body">
                <?php
                $result = $conn->query("DESCRIBE paket");
                if ($result) {
                    echo '<table class="table table-sm">';
                    echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['Field'] . '</td>';
                        echo '<td>' . $row['Type'] . '</td>';
                        echo '<td>' . $row['Null'] . '</td>';
                        echo '<td>' . $row['Key'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<p class="error">❌ Tabel paket tidak ditemukan!</p>';
                }
                ?>
            </div>
        </div>

        <!-- Test 3: Ambil Data Paket -->
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5>Test 3: Data Paket dari Database (SQL Direct)</h5>
            </div>
            <div class="card-body">
                <?php
                $sql = "SELECT * FROM paket ORDER BY id DESC";
                $result = $conn->query($sql);
                
                if ($result) {
                    echo '<p class="success">✅ Total paket: ' . $result->num_rows . '</p>';
                    
                    if ($result->num_rows > 0) {
                        echo '<pre>';
                        $data = [];
                        while ($row = $result->fetch_assoc()) {
                            $data[] = $row;
                        }
                        echo json_encode($data, JSON_PRETTY_PRINT);
                        echo '</pre>';
                    } else {
                        echo '<p class="error">⚠️ Tidak ada data paket</p>';
                    }
                } else {
                    echo '<p class="error">❌ Query error: ' . $conn->error . '</p>';
                }
                ?>
            </div>
        </div>

        <!-- Test 4: API Endpoint -->
        <div class="card mb-3">
            <div class="card-header bg-warning">
                <h5>Test 4: API Endpoint (api/paket.php)</h5>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" onclick="testAPI()">Test API GET</button>
                <pre id="api-result" class="mt-3">Klik tombol untuk test...</pre>
            </div>
        </div>

        <!-- Test 5: Paket dengan Status Aktif -->
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">
                <h5>Test 5: Paket dengan Status = 1 (Aktif)</h5>
            </div>
            <div class="card-body">
                <?php
                $sql = "SELECT * FROM paket WHERE status = 1 ORDER BY name ASC";
                $result = $conn->query($sql);
                
                if ($result) {
                    echo '<p class="success">✅ Total paket aktif: ' . $result->num_rows . '</p>';
                    
                    if ($result->num_rows > 0) {
                        echo '<pre>';
                        $data = [];
                        while ($row = $result->fetch_assoc()) {
                            $data[] = $row;
                        }
                        echo json_encode($data, JSON_PRETTY_PRINT);
                        echo '</pre>';
                    } else {
                        echo '<p class="error">⚠️ Tidak ada paket dengan status aktif!</p>';
                        echo '<p>Pastikan field <code>status = 1</code> di tabel paket</p>';
                    }
                } else {
                    echo '<p class="error">❌ Query error: ' . $conn->error . '</p>';
                }
                
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <script>
        function testAPI() {
            const resultDiv = document.getElementById('api-result');
            resultDiv.textContent = 'Loading...';
            
            fetch('api/paket.php')
                .then(res => {
                    if (!res.ok) {
                        throw new Error('HTTP ' + res.status + ': ' + res.statusText);
                    }
                    return res.json();
                })
                .then(data => {
                    resultDiv.textContent = JSON.stringify(data, null, 2);
                    
                    if (Array.isArray(data) && data.length > 0) {
                        resultDiv.style.color = 'green';
                    } else {
                        resultDiv.style.color = 'orange';
                    }
                })
                .catch(err => {
                    resultDiv.textContent = '❌ Error: ' + err.message;
                    resultDiv.style.color = 'red';
                });
        }
    </script>
</body>
</html>