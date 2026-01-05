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

        td:last-child {
            display: table-cell !important;
        }

        td button {
            display: inline-block !important;
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
            <li><a onclick="showPage('addon')"><i class="fas fa-info"></i><span>Kelola Add On</span></a></li>
            <!-- <li><a onclick="showPage('transaksi')"><i class="fas fa-file-invoice"></i><span>Transaksi</span></a></li> -->
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

        <!-- ADD ON PAGE -->
<!-- ADD ON PAGE -->
<div id="page-addon" class="page-section">
    <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-info"></i> Kelola Add On</h4>
            <button class="btn btn-primary" onclick="openAddonModal()">
                <i class="fas fa-plus me-2"></i>Tambah Add On
            </button>
        </div>

        <div class="table-responsive">
           <table class="table table-hover align-middle">
                <thead class="table-info">
                    <tr>
                        <th>No</th>
                        <th>Nama Add On</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Biaya Instalasi</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="addonTable">
                    <!-- DATA DIISI OLEH dashboard.js -->
                </tbody>
            </table>
        </div>
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0"><i class="fas fa-tags"></i> Kelola Promo</h4>
                       <button class="btn btn-primary" onclick="handleOpenPromoModal()">
    <i class="fas fa-plus me-2"></i>Tambah Promo
</button>

<script>
// Fix untuk openPromoModal - Paste setelah button Tambah Promo
function handleOpenPromoModal() {
    console.log('🎯 handleOpenPromoModal called');
    
    // Reset form
    const form = document.getElementById('form-promo');
    if (form) {
        form.reset();
        console.log('✅ Form reset');
    } else {
        console.error('❌ form-promo not found');
    }
    
    // Set default dates
    const today = new Date().toISOString().split('T')[0];
    const nextMonth = new Date();
    nextMonth.setMonth(nextMonth.getMonth() + 1);
    const endDateStr = nextMonth.toISOString().split('T')[0];
    
    const startInput = document.getElementById('promo_start_date');
    const endInput = document.getElementById('promo_end_date');
    
    if (startInput) {
        startInput.value = today;
        console.log('✅ Start date set');
    } else {
        console.error('❌ promo_start_date not found');
    }
    
    if (endInput) {
        endInput.value = endDateStr;
        console.log('✅ End date set');
    } else {
        console.error('❌ promo_end_date not found');
    }
    
    // Buka modal
    const modalElement = document.getElementById('modalTambahPromo');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        console.log('✅ Modal opened');
    } else {
        console.error('❌ Modal modalTambahPromo not found!');
        alert('Error: Modal tidak ditemukan! Periksa ID modal di HTML.');
    }
}

// Alias untuk kompatibilitas
window.openPromoModal = handleOpenPromoModal;
</script>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="min-width: 200px;">Judul Promo</th>
                                    <th style="min-width: 120px;">Region</th>
                                    <th>Diskon</th>
                                    <th style="min-width: 180px;">Periode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="promo-table-body">
                                <tr>
                                    <td colspan="6" class="text-center">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <!-- TRANSAKSI PAGE
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
    </div> -->

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
       id="add-slider-image"
       name="image"
       class="form-control"
       accept="image/png, image/jpeg, image/jpg"
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
                <button type="button" class="btn btn-primary" onclick="addSlider()">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function addSlider() {
    const form = document.getElementById('addSliderForm');
    const formData = new FormData();
    
    // Ambil nilai dari form
    const name = document.getElementById('add-slider-name').value;
    const status = document.getElementById('add-slider-status').value;
    const imageFile = document.getElementById('add-slider-image').files[0];
    
    // Validasi
    if (!name || !imageFile) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Nama dan gambar harus diisi!'
        });
        return;
    }
    
    // Tambahkan data ke FormData
    formData.append('name', name);
    formData.append('status', status);
    formData.append('image', imageFile);
    
    // Kirim via AJAX
    fetch('slider_action.php?action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Slider berhasil ditambahkan',
                timer: 1500
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message || 'Terjadi kesalahan'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat mengirim data'
        });
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
                                               <input type="text"
                            class="form-control"
                            id="edit-slider-name"
                            required>


                             <img id="edit-slider-preview"
                                src=""
                                style="margin-top:10px;max-width:100%;border-radius:8px;">
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti gambar
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="edit-slider-status">
                               <option value="1">✓ Aktif</option>
                                <option value="0">✗ Nonaktif</option>
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
    <div class="modal fade" id="modalTambahPaket" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Paket Internet Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-paket">
                        <!-- Informasi Dasar -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-info-circle me-2"></i>Informasi Dasar</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-tag me-2 text-primary"></i>Nama Paket *</label>
                                    <input type="text" class="form-control" id="nama" placeholder="ICONNET 150" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Kecepatan Internet</label>
                                    <input type="text" class="form-control" id="kecepatan" placeholder="50 MBPS">
                                    <small class="text-muted">Contoh: 50 MBPS, 100 MBPS</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-toggle-on me-2 text-primary"></i>Status</label>
                                    <select class="form-select" id="status">
                                        <option value="1">✓ Aktif</option>
                                        <option value="0">✗ Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tambahkan di Modal Tambah Paket, setelah field "Kecepatan" -->
<!-- Upload Gambar Paket -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <strong><i class="fas fa-image me-2"></i>Gambar Paket</strong>
    </div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Upload Gambar Paket</label>
            <input type="file"
                   class="form-control"
                   id="paket_image"
                   accept="image/png, image/jpeg, image/jpg, image/webp">

            <small class="text-muted">
                Kosongkan jika tidak ingin menambah gambar
            </small>

            <!-- Preview -->
            <div id="image-preview-paket" class="mt-3" style="display:none;">
                <img id="preview-img-paket"
                     class="img-thumbnail"
                     style="max-width:200px;">
                <button type="button"
                        class="btn btn-sm btn-danger mt-2"
                        onclick="removeImagePaket()">
                    <i class="fas fa-times"></i> Hapus
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Harga Regional -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <strong>
            <i class="fas fa-money-bill-wave me-2"></i>
            Harga Berlangganan per Bulan
        </strong>
    </div>

    <div class="card-body">

        <!-- SUMATERA -->
        <div class="row mb-3">
            <div class="col-12">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-map-marker-alt me-2"></i>Sumatera & Kalimantan
                </h6>
            </div>

            <div class="col-md-6 mb-3">
                <label>Harga Sebelum Diskon</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="sumatera_before">
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Harga Sesudah Diskon *</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="sumatera" required>
                </div>
            </div>
        </div>

        <hr>

        <!-- JAWA -->
        <div class="row mb-3">
            <div class="col-12">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-map-marker-alt me-2"></i>Jawa & Bali
                </h6>
            </div>

            <div class="col-md-6 mb-3">
                <label>Harga Sebelum Diskon</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="jawa_before">
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Harga Sesudah Diskon *</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="jawa" required>
                </div>
            </div>
        </div>

        <hr>

        <!-- TIMUR -->
        <div class="row mb-3">
            <div class="col-12">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-map-marker-alt me-2"></i>Indonesia Timur
                </h6>
            </div>

            <div class="col-md-6 mb-3">
                <label>Harga Sebelum Diskon</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="timur_before">
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Harga Sesudah Diskon *</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="timur" required>
                </div>
            </div>
        </div>

    </div> <!-- ✅ TUTUP card-body -->
</div> <!-- ✅ TUTUP card -->

                        <!-- Biaya Instalasi - TANPA DEFAULT VALUE -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <strong><i class="fas fa-tools me-2"></i>Biaya Instalasi</strong>
    </div>

    <div class="card-body">

        <!-- SUMATERA -->
        <div class="row mb-3">
            <div class="col-12">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-map-marker-alt me-2"></i>Sumatera & Kalimantan
                </h6>
            </div>

            <div class="col-md-6 mb-3">
                <label>Instalasi Sebelum Diskon</label>
                <input type="number" class="form-control" id="instalasi_sumatera_before">
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Instalasi Sesudah Diskon</label>
                <input type="number" class="form-control" id="instalasi_sumatera">
            </div>
        </div>

        <hr>

        <!-- JAWA -->
        <div class="row mb-3">
            <div class="col-12">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-map-marker-alt me-2"></i>Jawa & Bali
                </h6>
            </div>

            <div class="col-md-6 mb-3">
                <label>Instalasi Sebelum Diskon</label>
                <input type="number" class="form-control" id="instalasi_jawa_before">
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Instalasi Sesudah Diskon</label>
                <input type="number" class="form-control" id="instalasi_jawa">
            </div>
        </div>

        <hr>

        <!-- TIMUR -->
        <div class="row mb-3">
            <div class="col-12">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-map-marker-alt me-2"></i>Indonesia Timur
                </h6>
            </div>

            <div class="col-md-6 mb-3">
                <label>Instalasi Sebelum Diskon</label>
                <input type="number" class="form-control" id="instalasi_timur_before">
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Instalasi Sesudah Diskon</label>
                <input type="number" class="form-control" id="instalasi_timur">
            </div>
        </div>

    </div>
</div>

                        <!-- Perangkat Ideal - TANPA DEFAULT VALUE -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <strong><i class="fas fa-laptop me-2"></i>Perangkat Ideal</strong>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Total Perangkat</label>
                <input type="number" class="form-control" id="max_perangkat" min="0">
            </div>

            <div class="col-md-4 mb-3">
                <label>Jumlah Laptop</label>
                <input type="number" class="form-control" id="max_laptop" min="0">
            </div>

            <div class="col-md-4 mb-3">
                <label>Jumlah Handphone</label>
                <input type="number" class="form-control" id="max_smartphone" min="0">
            </div>
        </div>
    </div>
</div>

                        <!-- Fitur Tambahan -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-star me-2"></i>Fitur & Keunggulan</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">TV 4K</label>
                                    <input type="text" class="form-control" id="tv_4k" placeholder="Contoh: Streaming 4K Lancar">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Streaming</label>
                                    <input type="text" class="form-control" id="streaming" placeholder="Contoh: Netflix, Disney+, YouTube">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gaming</label>
                                    <input type="text" class="form-control" id="gaming" placeholder="Contoh: Mobile Legends, PUBG">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Fitur Lainnya</label>
                                    <textarea class="form-control" id="features" rows="3" placeholder="Fitur tambahan lainnya (pisahkan dengan enter)"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="addPaket()">
                        <i class="fas fa-save me-2"></i>Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Edit Paket -->
<div class="modal fade" id="modalEditPaket" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-gradient-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Paket Internet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-paket">
                    <input type="hidden" id="edit_id">
                    
                    <!-- Informasi Dasar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-info-circle me-2"></i>Informasi Dasar</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Paket *</label>
                                <input type="text" class="form-control" id="edit_nama" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Kecepatan Internet</label>
                                <input type="text" class="form-control" id="edit_kecepatan" placeholder="50 MBPS">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="edit_status">
                                    <option value="1">✓ Aktif</option>
                                    <option value="0">✗ Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-image me-2"></i>Gambar Paket</strong>
                        </div>
                        <div class="card-body">
                            <!-- Current Image -->
                            <div id="current-image-paket" style="display: none;" class="mb-2">
                                <p class="text-muted small">Gambar saat ini:</p>
                                <img id="current-img-paket" src="" alt="Current" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            
                            <!-- Upload New -->
                            <div class="mb-3">
                                <label class="form-label">Upload Gambar Baru (Opsional)</label>
                                <input type="file" 
                                    class="form-control" 
                                    id="edit_paket_image" 
                                    accept="image/png, image/jpeg, image/jpg, image/webp">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                
                                <!-- Preview New Image -->
                                <div id="edit-image-preview-paket" class="mt-3" style="display: none;">
                                    <img id="edit-preview-img-paket" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeEditImagePaket()">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== HARGA BULANAN - LAYOUT DIPERBAIKI ===== -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-money-bill-wave me-2"></i>Harga Berlangganan per Bulan</strong>
                        </div>
                        <div class="card-body">
                            
                            <!-- SUMATERA -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Sumatera & Kalimantan
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga Sebelum Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_sumatera_before" placeholder="0">
                                    </div>
                                    <small class="text-muted">Kosongkan jika tidak ada diskon</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Harga Sesudah Diskon *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_sumatera" required>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>

                            <!-- JAWA -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Jawa & Bali
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga Sebelum Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_jawa_before" placeholder="0">
                                    </div>
                                    <small class="text-muted">Kosongkan jika tidak ada diskon</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Harga Sesudah Diskon *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_jawa" required>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- TIMUR -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Indonesia Timur
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga Sebelum Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_timur_before" placeholder="0">
                                    </div>
                                    <small class="text-muted">Kosongkan jika tidak ada diskon</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Harga Sesudah Diskon *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_timur" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== BIAYA INSTALASI - LAYOUT DIPERBAIKI ===== -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-tools me-2"></i>Biaya Instalasi</strong>
                        </div>
                        <div class="card-body">
                            
                            <!-- SUMATERA -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Sumatera & Kalimantan
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Instalasi Sebelum Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_instalasi_sumatera_before" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Instalasi Sesudah Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_instalasi_sumatera" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- JAWA -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Jawa & Bali
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Instalasi Sebelum Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_instalasi_jawa_before" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Instalasi Sesudah Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_instalasi_jawa" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- TIMUR -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Indonesia Timur
                                    </h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Instalasi Sebelum Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_instalasi_timur_before" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Instalasi Sesudah Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_instalasi_timur" placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Perangkat Ideal -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-laptop me-2"></i>Perangkat Ideal</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Total Perangkat</label>
                                    <input type="number" class="form-control" id="edit_max_perangkat" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Jumlah Laptop</label>
                                    <input type="number" class="form-control" id="edit_max_laptop" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Jumlah Handphone</label>
                                    <input type="number" class="form-control" id="edit_max_smartphone" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fitur Tambahan -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-star me-2"></i>Fitur & Keunggulan</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">TV 4K</label>
                                <input type="text" class="form-control" id="edit_tv_4k">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Streaming</label>
                                <input type="text" class="form-control" id="edit_streaming">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gaming</label>
                                <input type="text" class="form-control" id="edit_gaming">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fitur Lainnya</label>
                                <textarea class="form-control" id="edit_features" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="updatePaket()">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Add On -->
<div class="modal fade" id="modalTambahAddon" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Add On Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formAddon">
                    <!-- Informasi Dasar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-info-circle me-2"></i>Informasi Dasar</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-tag me-2 text-primary"></i>Nama Add On *
                                </label>
                                <input type="text" class="form-control" id="addon_name" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-list me-2 text-primary"></i>Kategori *
                                    </label>
                                    <select class="form-select" id="addon_category" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="wifi_extender">WiFi Extender</option>
                                        <option value="iconplay">ICONPLAY</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-toggle-on me-2 text-primary"></i>Status
                                    </label>
                                    <select class="form-select" id="addon_status">
                                        <option value="1">✓ Aktif (Tampil di Website)</option>
                                        <option value="0">✗ Nonaktif (Tersembunyi)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi
                                </label>
                                <textarea class="form-control" id="addon_description" rows="3" 
                                          placeholder="Jelaskan detail add on..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-money-bill-wave me-2"></i>Informasi Harga</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga Add On *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="addon_price" 
                                               placeholder="145000" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Biaya Instalasi</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="addon_installation_fee" 
                                               placeholder="0" value="0">
                                    </div>
                                    <small class="text-muted">Kosongkan atau isi 0 jika gratis instalasi</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-image me-2"></i>Gambar Add On</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Upload Gambar</label>
                                <input type="file" class="form-control" id="addon_image" 
                                       accept="image/png, image/jpeg, image/jpg, image/webp">
                                <small class="text-muted">Format: PNG, JPG, WEBP (Max. 2MB)</small>
                                
                                <!-- Preview Image -->
                                <div id="image-preview-addon" class="mt-3" style="display: none;">
                                    <img id="preview-img-addon" src="" alt="Preview" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" 
                                            onclick="removeImageAddon()">
                                        <i class="fas fa-times"></i> Hapus Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fitur/Layanan Tersedia -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-list-check me-2"></i>Layanan Tersedia (Opsional)</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Fitur/Layanan</label>
                                <textarea class="form-control" id="addon_fitur" rows="3" 
                                          placeholder="Contoh: cepat dan luas, stabil, dll (pisahkan dengan enter)"></textarea>
                                <small class="text-muted">Pisahkan setiap fitur dengan enter/baris baru</small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="addAddon()">
                    Simpan
                </button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Add On -->
<div class="modal fade" id="modalEditAddon" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-gradient-warning text-dark">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Add On
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-addon">
                    <input type="hidden" id="edit_addon_id">
                    
                    <!-- Informasi Dasar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-info-circle me-2"></i>Informasi Dasar</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Add On *</label>
                                <input type="text" class="form-control" id="edit_addon_name" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori *</label>
                                    <select class="form-select" id="edit_addon_category" required>
                                        <option value="wifi_extender">WiFi Extender</option>
                                        <option value="iconplay">ICONPLAY</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" id="edit_addon_status">
                                        <option value="1">✓ Aktif</option>
                                        <option value="0">✗ Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="edit_addon_description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-money-bill-wave me-2"></i>Informasi Harga</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga Add On *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_addon_price" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Biaya Instalasi</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="edit_addon_installation_fee">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gambar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-image me-2"></i>Gambar Add On</strong>
                        </div>
                        <div class="card-body">
                            <!-- Current Image -->
                            <div id="edit-current-image-addon" style="display: none;" class="mb-2">
                                <p class="text-muted small">Gambar saat ini:</p>
                                <img id="edit-current-img-addon" src="" alt="Current" 
                                     class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            
                            <!-- Upload New -->
                            <div class="mb-3">
                                <label class="form-label">Upload Gambar Baru (Opsional)</label>
                                <input type="file" class="form-control" id="edit_addon_image" 
                                       accept="image/png, image/jpeg, image/jpg, image/webp">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                
                                <!-- Preview New Image -->
                                <div id="edit-image-preview-addon" class="mt-3" style="display: none;">
                                    <img id="edit-preview-img-addon" src="" alt="Preview" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" 
                                            onclick="removeEditImageAddon()">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fitur -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-list-check me-2"></i>Layanan Tersedia</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Fitur/Layanan</label>
                                <textarea class="form-control" id="edit_addon_fitur" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="updateAddon()">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
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

    <!-- Modal Tambah Promo -->
<!-- Modal Tambah Promo -->
<div class="modal fade" id="modalTambahPromo" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Promo Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-promo">
                    <!-- Informasi Dasar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-info-circle me-2"></i>Informasi Promo</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-heading me-2 text-primary"></i>Judul Promo *
                                </label>
                                <!-- PASTIKAN ID INI: promo_title -->
                                <input type="text" class="form-control" id="promo_title" 
                                       placeholder="Contoh: Diskon 50% Paket Internet Fiber" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi *
                                </label>
                                <!-- PASTIKAN ID INI: promo_description -->
                                <textarea class="form-control" id="promo_description" rows="3" 
                                          placeholder="Jelaskan detail promo..." required></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Region *
                                    </label>
                                    <!-- PASTIKAN ID INI: promo_region -->
                                    <select class="form-select" id="promo_region" required>
                                        <option value="">-- Pilih Region --</option>
                                        <option value="all">Semua Wilayah</option>
                                        <option value="jawa">Jawa & Bali</option>
                                        <option value="sumatera">Sumatera & Kalimantan</option>
                                        <option value="timur">Indonesia Timur</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-percent me-2 text-primary"></i>Diskon (%)
                                    </label>
                                    <!-- PASTIKAN ID INI: promo_discount -->
                                    <input type="number" class="form-control" id="promo_discount" 
                                           placeholder="0" min="0" max="100">
                                    <small class="text-muted">Kosongkan jika tidak ada diskon persentase</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-image me-2"></i>Gambar Promo</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Upload Gambar Promo</label>
                                <!-- PASTIKAN ID INI: promo_image -->
                                <input type="file" class="form-control" id="promo_image" 
                                       accept="image/png, image/jpeg, image/jpg, image/webp">
                                <small class="text-muted">Format: PNG, JPG, WEBP (Max. 2MB)</small>
                                
                                <!-- Preview Image -->
                                <div id="image-preview-promo" class="mt-3" style="display: none;">
                                    <img id="preview-img-promo" src="" alt="Preview" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" 
                                            onclick="removeImagePromo()">
                                        <i class="fas fa-times"></i> Hapus Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Periode Promo -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-calendar-alt me-2"></i>Periode Promo</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mulai *</label>
                                    <!-- PASTIKAN ID INI: promo_start_date -->
                                    <input type="date" class="form-control" id="promo_start_date" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Berakhir *</label>
                                    <!-- PASTIKAN ID INI: promo_end_date -->
                                    <input type="date" class="form-control" id="promo_end_date" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-toggle-on me-2"></i>Status Publikasi</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <!-- PASTIKAN ID INI: promo_status -->
                                <select class="form-select" id="promo_status">
                                    <option value="1">✓ Aktif (Tampil di Website)</option>
                                    <option value="0">✗ Nonaktif (Tersembunyi)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="addPromo()">
                    <i class="fas fa-save me-2"></i>Simpan Promo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Promo -->
<div class="modal fade" id="modalEditPromo" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-gradient-warning text-dark">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Promo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-promo">
                    <input type="hidden" id="edit_promo_id">
                    
                    <!-- Informasi Dasar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-info-circle me-2"></i>Informasi Promo</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Judul Promo *</label>
                                <input type="text" class="form-control" id="edit_promo_title" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Deskripsi *</label>
                                <textarea class="form-control" id="edit_promo_description" 
                                          rows="3" required></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Region *</label>
                                    <select class="form-select" id="edit_promo_region" required>
                                        <option value="all">Semua Wilayah</option>
                                        <option value="jawa">Jawa & Bali</option>
                                        <option value="sumatera">Sumatera & Kalimantan</option>
                                        <option value="timur">Indonesia Timur</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Diskon (%)</label>
                                    <input type="number" class="form-control" id="edit_promo_discount" 
                                           min="0" max="100">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gambar -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-image me-2"></i>Gambar Promo</strong>
                        </div>
                        <div class="card-body">
                            <!-- Current Image -->
                            <div id="edit-current-image-promo" style="display: none;" class="mb-2">
                                <p class="text-muted small">Gambar saat ini:</p>
                                <img id="edit-current-img-promo" src="" alt="Current" 
                                     class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            
                            <!-- Upload New -->
                            <div class="mb-3">
                                <label class="form-label">Upload Gambar Baru (Opsional)</label>
                                <input type="file" class="form-control" id="edit_promo_image" 
                                       accept="image/png, image/jpeg, image/jpg, image/webp">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                            </div>
                        </div>
                    </div>

                    <!-- Periode Promo -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-calendar-alt me-2"></i>Periode Promo</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mulai *</label>
                                    <input type="date" class="form-control" id="edit_promo_start_date" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Berakhir *</label>
                                    <input type="date" class="form-control" id="edit_promo_end_date" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong><i class="fas fa-toggle-on me-2"></i>Status Publikasi</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="edit_promo_status">
                                    <option value="1">✓ Aktif</option>
                                    <option value="0">✗ Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="updatePromo()">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>