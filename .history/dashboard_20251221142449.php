<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ICONNET</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* ========== PREVIEW IMAGE ========== */
        .preview-slider-container {
            margin-top: 15px;
            text-align: center;
        }

        .preview-slider-container img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 12px;
            border: 3px solid var(--primary-color);
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.2);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
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
                <p class="text-muted">Gunakan menu di sidebar untuk mengelola konten website ICONNET.</p>
            </div>
        </div>

        <!-- SLIDER PAGE -->
        <div id="page-slider" class="page-section">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="fas fa-images"></i>Kelola Slider</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSliderModal">
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
                <h4><i class="fas fa-box"></i>Kelola Paket Internet</h4>
                <p class="text-muted">Fitur ini akan segera tersedia.</p>
            </div>
        </div>

        <!-- BERITA PAGE -->
        <div id="page-berita" class="page-section">
            <div class="content-card">
                <h4><i class="fas fa-newspaper"></i>Kelola Berita</h4>
                <p class="text-muted">Fitur ini akan segera tersedia.</p>
            </div>
        </div>

        <!-- FAQ PAGE -->
        <div id="page-faq" class="page-section">
            <div class="content-card">
                <h4><i class="fas fa-question-circle"></i>Kelola FAQ</h4>
                <p class="text-muted">Fitur ini akan segera tersedia.</p>
            </div>
        </div>
    </div>

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
                            <label class="form-label">
                                <i class="fas fa-tag me-2 text-primary"></i>Nama Slider
                            </label>
                            <input type="text" class="form-control" id="add-slider-name" placeholder="Contoh: Slider Promo" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-image me-2 text-primary"></i>Gambar Slider
                            </label>
                            <input type="file"
                                   class="form-control"
                                   id="add-slider-image"
                                   accept="image/*"
                                   onchange="previewSliderImage(this)"
                                   required>
                            <small class="text-muted">Format: JPG, PNG, WEBP (Max. 5MB)</small>

                            <div class="preview-slider-container">
                                <img id="preview-slider-image" style="display:none;" alt="Preview">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-toggle-on me-2 text-primary"></i>Status
                            </label>
                            <select class="form-select" id="add-slider-status">
                                <option value="1">✓ Aktif</option>
                                <option value="0">✗ Nonaktif</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="addSlider()">
                        <i class="fas fa-save me-2"></i>Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // ==================== GLOBAL VARIABLES ====================
        let currentPage = 'dashboard';
        let sliderModal, editSliderModal;

        // ==================== PAGE NAVIGATION ====================
        function showPage(page) {
            // Hide all pages
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show selected page
            document.getElementById('page-' + page).classList.add('active');
            
            // Update sidebar active state
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.classList.remove('active');
            });
            event.target.closest('a').classList.add('active');
            
            // Update page title
            const titles = {
                'dashboard': '<i class="fas fa-tachometer-alt"></i> Dashboard Admin',
                'slider': '<i class="fas fa-images"></i> Kelola Slider',
                'paket': '<i class="fas fa-box"></i> Kelola Paket',
                'berita': '<i class="fas fa-newspaper"></i> Kelola Berita',
                'faq': '<i class="fas fa-question-circle"></i> Kelola FAQ'
            };
            document.getElementById('page-title').innerHTML = titles[page];
            
            currentPage = page;
            
            // Load data if needed
            if (page === 'slider') {
                loadSliders();
            }
        }

        // ==================== SLIDER FUNCTIONS ====================
        function previewSliderImage(input) {
            const preview = document.getElementById('preview-slider-image');
            
            if (input.files && input.files[0]) {
                // Validasi ukuran file (max 5MB)
                if (input.files[0].size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 5MB'
                    });
                    input.value = '';
                    preview.style.display = 'none';
                    return;
                }

                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                if (!allowedTypes.includes(input.files[0].type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Valid',
                        text: 'Format file harus JPG, PNG, atau WEBP'
                    });
                    input.value = '';
                    preview.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        function addSlider() {
            const name = document.getElementById('add-slider-name').value.trim();
            const status = document.getElementById('add-slider-status').value;
            const imageFile = document.getElementById('add-slider-image').files[0];
            
            // Validasi
            if (!name) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nama slider harus diisi!'
                });
                return;
            }

            if (!imageFile) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gambar harus dipilih!'
                });
                return;
            }
            
            // Buat FormData untuk kirim file
            const formData = new FormData();
            formData.append('name', name);
            formData.append('status', status);
            formData.append('image', imageFile);
            formData.append('action', 'add');
            
            // Show loading
            Swal.fire({
                title: 'Uploading...',
                text: 'Mohon tunggu, sedang mengupload gambar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Kirim via AJAX
            fetch('slider_action.php', {
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
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Reset form
                        document.getElementById('addSliderForm').reset();
                        document.getElementById('preview-slider-image').style.display = 'none';
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addSliderModal'));
                        modal.hide();
                        
                        // Reload data
                        loadSliders();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: