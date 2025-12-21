<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ICONNET</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #20b2aa;
            --primary-dark: #0a91a8;
            --primary-light: #ffffff;
            --accent-color: #17a2b8;
            --bg-light: #f0f8ff;
            --text-dark: #2c3e50;
            --shadow: 0 4px 20px rgba(32, 178, 170, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
            min-height: 100vh;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 0;
            box-shadow: 4px 0 20px rgba(255, 255, 255, 0.15);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-logo {
            text-align: center;
            padding: 30px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logo i {
            font-size: 48px;
            color: white;
            margin-bottom: 10px;
        }

        .sidebar-logo h4 {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 15px;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu a.active {
            background: white;
            color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .sidebar-menu a i {
            width: 30px;
            margin-right: 15px;
            font-size: 18px;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
        }

        /* ========== HEADER ========== */
        .dashboard-header {
            background: white;
            padding: 25px 35px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 5px solid var(--primary-color);
        }

        .dashboard-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .dashboard-header h2 i {
            color: var(--primary-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
        }

        .btn-logout {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        }

        /* ========== STATS CARDS ========== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 25px;
            transition: all 0.3s;
            border-left: 5px solid;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(32, 178, 170, 0.05);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(32, 178, 170, 0.2);
        }

        .stat-card:nth-child(1) { border-left-color: #667eea; }
        .stat-card:nth-child(2) { border-left-color: #11998e; }
        .stat-card:nth-child(3) { border-left-color: #ff6b6b; }
        .stat-card:nth-child(4) { border-left-color: #8e44ad; }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .stat-icon.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon.green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stat-icon.orange { background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); }
        .stat-icon.purple { background: linear-gradient(135deg, #8e44ad 0%, #c0392b 100%); }

        .stat-info h3 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
        }

        .stat-info p {
            color: #7f8c8d;
            font-size: 14px;
            margin: 5px 0 0 0;
            font-weight: 500;
        }

        /* ========== CONTENT CARDS ========== */
        .content-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 25px;
            border-left: 5px solid var(--primary-color);
        }

        .content-card h4 {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e8f5f4;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        /* ========== BUTTONS ========== */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(32, 178, 170, 0.4);
        }

        /* ========== TABLE ========== */
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }

        .table {
            margin: 0;
        }

        .table th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e8f5f4;
        }

        .table tbody tr:hover {
            background: #f0f8ff;
        }

        .badge-status {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-active { background: #d4edda; color: #155724; }
        .badge-inactive { background: #f8d7da; color: #721c24; }

        .btn-action {
            padding: 8px 12px;
            font-size: 13px;
            margin: 0 3px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        /* ========== MODAL STYLING ========== */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-radius: 20px 20px 0 0;
            padding: 25px 30px;
            border: none;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .modal-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(32, 178, 170, 0.15);
        }

        /* ========== UPLOAD AREA ========== */
        .upload-area {
            border: 3px dashed var(--primary-color);
            border-radius: 15px;
            padding: 50px 30px;
            text-align: center;
            background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 30%);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: var(--primary-dark);
            background: linear-gradient(135deg, #b2ebf2 0%, #80deea 30%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(32, 178, 170, 0.2);
        }

        .upload-icon {
            font-size: 60px;
            color: var(--primary-color);
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .upload-text strong {
            color: var(--primary-dark);
            font-size: 18px;
        }

        /* ========== PREVIEW IMAGE ========== */
        .preview-container {
            position: relative;
            display: inline-block;
        }

        .preview-container img {
            max-width: 100%;
            max-height: 350px;
            border-radius: 15px;
            border: 4px solid var(--primary-color);
            box-shadow: 0 8px 25px rgba(32, 178, 170, 0.2);
        }

        .remove-image {
            position: absolute;
            top: 15px;
            right: 15px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
                padding: 10px;
            }

            .sidebar-logo h4,
            .sidebar-menu a span {
                display: none;
            }

            .main-content {
                margin-left: 80px;
                padding: 20px;
            }

            .dashboard-header {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="fas fa-wifi"></i>
            <h4>ICONNET ADMIN</h4>
        </div>
        <ul class="sidebar-menu">
            <li><a onclick="showPage('dashboard')" class="active"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
            <li><a onclick="showPage('slider')"><i class="fas fa-images"></i><span>Kelola Slider</span></a></li>
            <li><a onclick="showPage('paket')"><i class="fas fa-box"></i><span>Kelola Paket</span></a></li>
            <li><a onclick="showPage('berita')"><i class="fas fa-newspaper"></i><span>Kelola Berita</span></a></li>
            <li><a onclick="showPage('faq')"><i class="fas fa-question-circle"></i><span>Kelola FAQ</span></a></li>
            <li><a onclick="showPage('promo')"><i class="fas fa-tags"></i><span>Kelola Promo</span></a></li>
            <li><a onclick="showPage('transaksi')"><i class="fas fa-file-invoice"></i><span>Transaksi</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="dashboard-header">
            <div>
                <h2 id="page-title"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h2>
                <p class="text-muted mb-0">Selamat datang kembali, Admin ICONNET!</p>
            </div>
            <div class="user-info">
                <div class="user-avatar">A</div>
                <div>
                    <strong>Admin</strong>
                    <p class="text-muted mb-0" style="font-size: 12px;">Administrator</p>
                </div>
                <button class="btn-logout" onclick="logout()">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </button>
            </div>
        </div>

        <!-- DASHBOARD PAGE -->
        <div id="page-dashboard" class="page-section active">
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="stat-slider">0</h3>
                        <p>Total Slider</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="stat-paket">0</h3>
                        <p>Paket Internet</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="stat-berita">0</h3>
                        <p>Berita Aktif</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="stat-faq">0</h3>
                        <p>FAQ</p>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <h4><i class="fas fa-chart-line"></i>Ringkasan Aktivitas</h4>
                <p class="text-muted">Gunakan menu di sidebar untuk mengelola konten website ICONNET. Semua perubahan akan langsung tersimpan ke database.</p>
            </div>
        </div>

        <!-- SLIDER PAGE -->
        <div id="page-slider" class="page-section">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="fas fa-images"></i>Kelola Slider</h4>
                    <button class="btn btn-primary" onclick="openSliderModal()">
                        <i class="fas fa-plus me-2"></i>Tambah Slider
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Preview</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="slider-table-body">
                            <tr>
                                <td colspan="5" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PAKET PAGE -->
<div id="page-paket" class="page-section">
    <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-box"></i> Kelola Paket Internet</h4>
            <button class="btn btn-primary" onclick="openPaketModal()">
                <i class="fas fa-plus me-2"></i>Tambah Paket
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Harga Sumatera</th>
                        <th>Harga Jawa</th>
                        <th>Harga Timur</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="paket-table-body">
                    <tr>
                        <td colspan="6" class="text-center">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


        <!-- BERITA PAGE -->
        <div id="page-berita" class="page-section">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="fas fa-newspaper"></i>Kelola Berita</h4>
                    <button class="btn btn-primary" onclick="openBeritaModal()">
                        <i class="fas fa-plus me-2"></i>Tambah Berita
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="berita-table-body">
                            <tr>
                                <td colspan="4" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- FAQ PAGE -->
        <div id="page-faq" class="page-section">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="fas fa-question-circle"></i>Kelola FAQ</h4>
                    <button class="btn btn-primary" onclick="openFaqModal()">
                        <i class="fas fa-plus me-2"></i>Tambah FAQ
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Pertanyaan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="faq-table-body">
                            <tr>
                                <td colspan="3" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PROMO PAGE -->
        <div id="page-promo" class="page-section">
            <div class="content-card">
                <h4><i class="fas fa-tags"></i>Kelola Promo</h4>
                <p class="text-muted">Fitur ini akan segera tersedia.</p>
            </div>
        </div>

        <!-- TRANSAKSI PAGE -->
        <div id="page-transaksi" class="page-section">
            <div class="content-card">
                <h4><i class="fas fa-file-invoice"></i>Daftar Transaksi</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pelanggan</th>
                                <th>Paket</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#001</td>
                                <td>Budi Santoso</td>
                                <td>ICONNET 50</td>
                                <td>12 Des 2024</td>
                                <td>Rp 319.000</td>
                                <td><span class="badge-status badge-active">Aktif</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS TETAP SAMA SEPERTI SEBELUMNYA -->
    <!-- Modal Tambah Slider -->
   <div class="modal fade" id="addSliderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Slider Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
            <form id="addSliderForm" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Nama Slider</label>
        <input type="text" class="form-control" id="add-slider-name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Gambar Slider</label>
        <input type="file"
               class="form-control"
               id="add-slider-image"
               accept="image/*"
               onchange="previewSliderImage(this)"
               required>

        <img id="preview-slider-image"
             style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select class="form-select" id="add-slider-status">
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>
    </div>
</form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" onclick="addSlider()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
function addSlider() {
    const fd = new FormData();

    fd.append('name', document.getElementById('add-slider-name').value);
    fd.append('image', document.getElementById('add-slider-image').files[0]);
    fd.append('is_active', document.getElementById('add-slider-status').value);

    fetch('api/add_slider.php', {
        method: 'POST',
        body: fd
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            alert('Slider berhasil ditambahkan');
            location.reload();
        } else {
            alert(res.message);
        }
    });
}
</script>



    <!-- Modal Edit Slider -->
    <div class="modal fade" id="editSliderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editSliderForm">
                        <input type="hidden" id="edit-slider-id">
                        <div class="mb-3">
                            <label class="form-label">Nama Slider</label>
                            <input type="text" class="form-control" id="edit-slider-name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Path Gambar</label>
                            <input type="text" class="form-control" id="edit-slider-image" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="edit-slider-status">
                                <option value="true">✓ Aktif</option>
                                <option value="false">✗ Nonaktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" onclick="saveSlider()">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Paket -->
    <div class="modal fade" id="addPaketModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Paket Internet Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addPaketForm">
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-wifi me-2 text-primary"></i>ID Paket</label>
                            <input type="text" class="form-control" id="add-paket-id" placeholder="iconnet150" required>
                            <small class="text-muted">Gunakan huruf kecil tanpa spasi, contoh: iconnet150</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-tag me-2 text-primary"></i>Nama Paket</label>
                            <input type="text" class="form-control" id="add-paket-name" placeholder="ICONNET 150" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga Sumatera</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="add-paket-sumatera" placeholder="999000" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga Jawa</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="add-paket-jawa" placeholder="799000" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga Timur</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="add-paket-timur" placeholder="899000" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="add-paket-status">
                                <option value="true">✓ Aktif</option>
                                <option value="false">✗ Nonaktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="addPaket()">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Paket -->
    <div class="modal fade" id="editPaketModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Paket Internet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editPaketForm">
                        <input type="hidden" id="edit-paket-id">
                        <div class="mb-3">
                            <label class="form-label">Nama Paket</label>
                            <input type="text" class="form-control" id="edit-paket-name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga Sumatera</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="edit-paket-sumatera" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga Jawa</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="edit-paket-jawa" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga Timur</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="edit-paket-timur" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="edit-paket-status">
                                <option value="true">✓ Aktif</option>
                                <option value="false">✗ Nonaktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" onclick="savePaket()">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Berita -->
    <div class="modal fade" id="addBeritaModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Berita Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addBeritaForm">
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-newspaper me-2 text-primary"></i>Judul Berita</label>
                            <input type="text" class="form-control" id="add-berita-title" placeholder="Contoh: ICONNET Raih Penghargaan Best ISP 2024" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-calendar me-2 text-primary"></i>Tanggal Publikasi</label>
                            <input type="date" class="form-control" id="add-berita-date-picker" required>
                            <input type="hidden" id="add-berita-date">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-image me-2 text-primary"></i>Upload Gambar Berita</label>
                            <div class="upload-area" id="add-upload-area">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="upload-text">
                                    <p class="mb-1"><strong>Klik untuk upload gambar</strong></p>
                                    <p class="text-muted small mb-0">atau drag & drop file di sini</p>
                                    <p class="text-muted small">PNG, JPG, WEBP (Max. 5MB)</p>
                                </div>
                                <input type="file" id="add-berita-image-file" accept="image/*" style="display: none;">
                            </div>
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <div class="preview-container">
                                    <img id="preview-img" src="" alt="Preview" class="img-thumbnail">
                                    <button type="button" class="btn btn-sm btn-danger remove-image" onclick="removeImage()">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                                <p class="text-muted small mt-2" id="file-name"></p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-align-left me-2 text-primary"></i>Konten Berita</label>
                            <textarea class="form-control" id="add-berita-content" rows="6" placeholder="Tulis konten berita di sini..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-toggle-on me-2 text-primary"></i>Status</label>
                            <select class="form-select" id="add-berita-status">
                                <option value="true">✓ Aktif (Tampil di Homepage)</option>
                                <option value="false">✗ Nonaktif (Tersembunyi)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="addBerita()">Publikasikan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Berita -->
    <div class="modal fade" id="editBeritaModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editBeritaForm">
                        <input type="hidden" id="edit-berita-id">
                        <div class="mb-3">
                            <label class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="edit-berita-title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tanggal Publikasi</label>
                            <input type="date" class="form-control" id="edit-berita-date-picker" required>
                            <input type="hidden" id="edit-berita-date">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Upload Gambar Berita</label>
                            <div class="current-image mb-3" id="edit-current-image" style="display: none;">
                                <p class="text-muted small mb-2"><i class="fas fa-info-circle me-1"></i>Gambar saat ini:</p>
                                <img id="edit-current-image-preview" src="" alt="Current" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                            <div class="upload-area" id="edit-upload-area">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="upload-text">
                                    <p class="mb-1"><strong>Klik untuk upload gambar baru</strong></p>
                                    <p class="text-muted small mb-0">atau drag & drop file di sini</p>
                                    <p class="text-muted small">PNG, JPG, WEBP (Max. 5MB)</p>
                                </div>
                                <input type="file" id="edit-berita-image-file" accept="image/*" style="display: none;">
                            </div>
                            <div id="edit-image-preview" class="mt-3" style="display: none;">
                                <div class="preview-container">
                                    <img id="edit-preview-img" src="" alt="Preview" class="img-thumbnail">
                                    <button type="button" class="btn btn-sm btn-danger remove-image" onclick="removeEditImage()">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                                <p class="text-muted small mt-2" id="edit-file-name"></p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Konten Berita</label>
                            <textarea class="form-control" id="edit-berita-content" rows="6"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="edit-berita-status">
                                <option value="true">✓ Aktif (Tampil di Homepage)</option>
                                <option value="false">✗ Nonaktif (Tersembunyi)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" onclick="saveBerita()">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah FAQ -->
    <div class="modal fade" id="addFaqModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah FAQ Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addFaqForm">
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-question-circle me-2 text-primary"></i>Pertanyaan</label>
                            <input type="text" class="form-control" id="add-faq-question" placeholder="Contoh: Bagaimana cara upgrade paket internet?" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-comment-dots me-2 text-primary"></i>Jawaban</label>
                            <textarea class="form-control" id="add-faq-answer" rows="6" placeholder="Tulis jawaban lengkap di sini..." required></textarea>
                            <small class="text-muted">Berikan jawaban yang jelas dan mudah dipahami</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="add-faq-status">
                                <option value="true">✓ Aktif (Tampil di Homepage)</option>
                                <option value="false">✗ Nonaktif (Tersembunyi)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="addFaq()">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit FAQ -->
    <div class="modal fade" id="editFaqModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editFaqForm">
                        <input type="hidden" id="edit-faq-id">
                        <div class="mb-3">
                            <label class="form-label">Pertanyaan</label>
                            <input type="text" class="form-control" id="edit-faq-question" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jawaban</label>
                            <textarea class="form-control" id="edit-faq-answer" rows="6" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="edit-faq-status">
                                <option value="true">✓ Aktif</option>
                                <option value="false">✗ Nonaktif</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" onclick="saveFaq()">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="dashboard.js"></script>
    <script>
        // Global functions for removing images
        function removeImage() {
            const fileInput = document.getElementById('add-berita-image-file');
            const imagePreview = document.getElementById('image-preview');
            const uploadArea = document.getElementById('add-upload-area');
            
            if (fileInput) fileInput.value = '';
            if (imagePreview) imagePreview.style.display = 'none';
            if (uploadArea) uploadArea.style.display = 'block';
        }
        
        function removeEditImage() {
            const fileInput = document.getElementById('edit-berita-image-file');
            const imagePreview = document.getElementById('edit-image-preview');
            const uploadArea = document.getElementById('edit-upload-area');
            const currentImage = document.getElementById('edit-current-image');
            
            if (fileInput) fileInput.value = '';
            if (imagePreview) imagePreview.style.display = 'none';
            if (uploadArea) uploadArea.style.display = 'block';
            if (currentImage) currentImage.style.display = 'block';
        }
        
        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Date Picker Handler for Add Modal
            const addDatePicker = document.getElementById('add-berita-date-picker');
            if (addDatePicker) {
                const today = new Date();
                addDatePicker.valueAsDate = today;
                
                addDatePicker.addEventListener('change', function() {
                    const selectedDate = new Date(this.value);
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    const formattedDate = selectedDate.getDate() + ' ' + months[selectedDate.getMonth()] + ' ' + selectedDate.getFullYear();
                    document.getElementById('add-berita-date').value = formattedDate;
                });
                
                addDatePicker.dispatchEvent(new Event('change'));
            }
            
            // Date Picker Handler for Edit Modal
            const editDatePicker = document.getElementById('edit-berita-date-picker');
            if (editDatePicker) {
                editDatePicker.addEventListener('change', function() {
                    const selectedDate = new Date(this.value);
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    const formattedDate = selectedDate.getDate() + ' ' + months[selectedDate.getMonth()] + ' ' + selectedDate.getFullYear();
                    document.getElementById('edit-berita-date').value = formattedDate;
                });
            }
            
            // Upload Area Click Handler - Add Modal
            const addUploadArea = document.getElementById('add-upload-area');
            if (addUploadArea) {
                addUploadArea.addEventListener('click', function() {
                    document.getElementById('add-berita-image-file').click();
                });
            }
            
            // Upload Area Click Handler - Edit Modal
            const editUploadArea = document.getElementById('edit-upload-area');
            if (editUploadArea) {
                editUploadArea.addEventListener('click', function() {
                    document.getElementById('edit-berita-image-file').click();
                });
            }
            
            // Image Upload Handler - Add Modal
            const addImageInput = document.getElementById('add-berita-image-file');
            if (addImageInput) {
                addImageInput.addEventListener('change', function(e) {
                    handleImageUpload(e, 'add');
                });
            }
            
            // Image Upload Handler - Edit Modal
            const editImageInput = document.getElementById('edit-berita-image-file');
            if (editImageInput) {
                editImageInput.addEventListener('change', function(e) {
                    handleImageUpload(e, 'edit');
                });
            }
        });
        
        // Handle Image Upload
        function handleImageUpload(e, type) {
            const file = e.target.files[0];
            if (!file) return;
            
            // Validasi ukuran file (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 5MB');
                e.target.value = '';
                return;
            }
            
            // Validasi tipe file
            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar!');
                e.target.value = '';
                return;
            }
            
            // Preview image
            const reader = new FileReader();
            reader.onload = function(event) {
                const prefix = type === 'add' ? '' : 'edit-';
                const previewImg = document.getElementById(prefix + 'preview-img');
                const imagePreview = document.getElementById(prefix.replace('-', '') + 'image-preview');
                const fileName = document.getElementById(prefix + 'file-name');
                const uploadArea = document.getElementById(prefix.replace('-', '') + 'upload-area');
                
                if (previewImg) previewImg.src = event.target.result;
                if (imagePreview) imagePreview.style.display = 'block';
                if (fileName) fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';
                if (uploadArea) uploadArea.style.display = 'none';
                
                // Hide current image in edit mode
                if (type === 'edit') {
                    const currentImage = document.getElementById('edit-current-image');
                    if (currentImage) currentImage.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>