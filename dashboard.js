// dashboard.js - Integrasi Frontend dengan API

// Base API URL
const API_URL = 'api.php';
const AUTH_URL = 'auth.php';

// ==================== AUTHENTICATION ====================

// Cek session saat load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard loaded');
    checkSession();
    loadDashboardStats();
});

// Fungsi cek session
function checkSession() {
    fetch(`${AUTH_URL}?action=check_session`)
        .then(response => response.json())
        .then(data => {
            console.log('Session check:', data);
            if (!data.success) {
                window.location.href = 'login.html';
            } else {
                // Update info user di header
                document.querySelector('.user-info strong').textContent = data.data.username;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Komentari redirect untuk testing
            // window.location.href = 'login.html';
        });
}

// Fungsi logout
function logout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        fetch(`${AUTH_URL}?action=logout`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.data.redirect;
                }
            });
    }
}

// ==================== PAGE NAVIGATION (SIDEBAR) ====================
// GANTI fungsi showPage() yang lama dengan yang ini

function showPage(pageName) {
    console.log('Showing page:', pageName);
    
    // Hide all pages
    document.querySelectorAll('.page-section').forEach(page => {
        page.classList.remove('active');
    });

    // Remove active class from all menu items
    document.querySelectorAll('.sidebar-menu a').forEach(menu => {
        menu.classList.remove('active');
    });

    // Show selected page
    const pageElement = document.getElementById('page-' + pageName);
    if (pageElement) {
        pageElement.classList.add('active');
    }
    
    // Update page title
    const titles = {
        'dashboard': 'Dashboard Admin',
        'slider': 'Kelola Slider',
        'paket': 'Kelola Paket Internet',
        'berita': 'Kelola Berita',
        'faq': 'Kelola FAQ',
        'promo': 'Kelola Promo',
        'addon': 'Kelola Add On',
        'transaksi': 'Daftar Transaksi'
    };
    
    const titleElement = document.getElementById('page-title');
    if (titleElement) {
        const icon = document.querySelector('#page-title i');
        if (icon) {
            titleElement.innerHTML = `<i class="${icon.className}"></i> ${titles[pageName] || 'Dashboard Admin'}`;
        } else {
            titleElement.innerHTML = `<i class="fas fa-tachometer-alt"></i> ${titles[pageName] || 'Dashboard Admin'}`;
        }
    }

    // Add active class to clicked menu
    const menuElement = document.querySelector(`.sidebar-menu a[onclick*="${pageName}"]`);
    if (menuElement) {
        menuElement.classList.add('active');
    }

    // Load data based on page
    if (pageName === 'slider') loadSliderTable();
    if (pageName === 'paket') loadPaketTable(); // ✅ PASTIKAN INI ADA
    if (pageName === 'berita') loadBeritaTable();
    if (pageName === 'faq') loadFaqTable();
    if (pageName === 'promo') loadPromoTable();
    if (pageName === 'addon') loadAddon();
}

// ==================== DASHBOARD STATS ====================

function loadDashboardStats() {
    fetch(`${API_URL}?action=get_stats`)
        .then(response => response.json())
        .then(data => {
            console.log('Stats:', data);
            if (data.success) {
                document.getElementById('stat-slider').textContent = data.data.slider;
                document.getElementById('stat-paket').textContent = data.data.paket;
                document.getElementById('stat-berita').textContent = data.data.berita;
                document.getElementById('stat-faq').textContent = data.data.faq;
            }
        })
        .catch(error => console.error('Error loading stats:', error));
}

// ==================== SLIDER MANAGEMENT ====================

function loadSliderTable() {
    fetch(`${API_URL}?action=get_all&table=slider`)
        .then(response => response.json())
        .then(data => {
            console.log('Sliders:', data);
            if (data.success) {
                const tbody = document.getElementById('slider-table-body');
                tbody.innerHTML = '';
                
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
                    return;
                }
                
                data.data.forEach((slider, index) => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td><img src="${slider.image_path}" style="width:100px;height:50px;object-fit:cover;" onerror="this.src='https://via.placeholder.com/100x50'"></td>
                            <td>${slider.name}</td>
                            <td><span class="badge-status ${slider.is_active ? 'badge-active' : 'badge-inactive'}">${slider.is_active ? 'Aktif' : 'Nonaktif'}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-action" onclick='editSlider(${JSON.stringify(slider)})' title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-action" onclick="deleteSlider(${slider.id})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error loading sliders:', error));
}

function deleteSlider(id) {
    if (confirm('⚠️ Apakah Anda yakin ingin menghapus slider ini?\n\nTindakan ini tidak dapat dibatalkan!')) {
        console.log('🗑️ Deleting slider ID:', id);
        
        fetch(`${API_URL}?action=delete&table=slider&id=${id}`)
            .then(response => response.json())
            .then(data => {
                console.log('📦 Response:', data);
                
                if (data.success) {
                    alert('✅ Slider berhasil dihapus!');
                    loadSliderTable();
                    loadDashboardStats();
                } else {
                    alert('❌ Gagal menghapus slider: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                alert('❌ Terjadi kesalahan saat menghapus data');
            });
    }
}

function editSlider(slider) {
    console.log('✏️ Edit slider:', slider);

    // Safety check
    if (!slider) {
        alert('Data slider tidak ditemukan');
        return;
    }

    // Isi field
    document.getElementById('edit-slider-id').value = slider.id || '';
    document.getElementById('edit-slider-name').value = slider.name || '';
    
    // ✅ PERBAIKAN: Set status sesuai data asli
    const statusSelect = document.getElementById('edit-slider-status');
    if (statusSelect) {
        // Konversi boolean ke string "1" atau "0"
        statusSelect.value = slider.is_active ? '1' : '0';
        console.log('✅ Status set to:', statusSelect.value, '(', slider.is_active ? 'Aktif' : 'Nonaktif', ')');
    }

    // Preview gambar lama
    const preview = document.getElementById('edit-slider-preview');
    if (slider.image_path) {
        preview.src = slider.image_path;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }

    // Reset input file
    const imageInput = document.getElementById('edit-slider-image');
    imageInput.value = '';
    
    // Simpan path gambar lama untuk referensi
    imageInput.dataset.oldImagePath = slider.image_path || '';

    // Buka modal
    new bootstrap.Modal(
        document.getElementById('editSliderModal')
    ).show();
}

// Event listener untuk preview gambar baru saat dipilih
document.addEventListener('DOMContentLoaded', function() {
    const editImageInput = document.getElementById('edit-slider-image');
    
    if (editImageInput) {
        editImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('edit-slider-preview');
            
            if (file) {
                // Validasi tipe file
                if (!file.type.match('image.*')) {
                    alert('❌ File harus berupa gambar!');
                    e.target.value = '';
                    // Kembalikan ke gambar lama
                    if (e.target.dataset.oldImagePath) {
                        preview.src = e.target.dataset.oldImagePath;
                        preview.style.display = 'block';
                    }
                    return;
                }
                
                // Validasi ukuran file (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('❌ Ukuran file terlalu besar! Maksimal 2MB');
                    e.target.value = '';
                    // Kembalikan ke gambar lama
                    if (e.target.dataset.oldImagePath) {
                        preview.src = e.target.dataset.oldImagePath;
                        preview.style.display = 'block';
                    }
                    return;
                }
                
                // Preview gambar baru
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    console.log('🖼️ New image previewed:', file.name);
                };
                reader.readAsDataURL(file);
            } else {
                // Jika dibatalkan, kembalikan ke gambar lama
                if (e.target.dataset.oldImagePath) {
                    preview.src = e.target.dataset.oldImagePath;
                    preview.style.display = 'block';
                }
            }
        });
    }
})

function saveSlider() {
    console.log('💾 Saving slider changes...');
    
    // Ambil data dari form secara manual
    const id = document.getElementById('edit-slider-id').value;
    const name = document.getElementById('edit-slider-name').value;
    const status = document.getElementById('edit-slider-status').value;
    const imageInput = document.getElementById('edit-slider-image');
    
    console.log('📝 Data:', { id, name, status, hasNewImage: imageInput.files.length > 0 });
    
    // Validasi
    if (!id || !name) {
        alert('❌ ID dan Nama slider wajib diisi!');
        return;
    }
    
    // Buat FormData
    const formData = new FormData();
    formData.append('id', id);
    formData.append('name', name);
    formData.append('is_active', status);
    
    // Jika ada gambar baru yang diupload
    if (imageInput.files.length > 0) {
        const imageFile = imageInput.files[0];
        console.log('🖼️ New image:', imageFile.name, imageFile.size, 'bytes');
        
        // Validasi ukuran file (max 2MB)
        if (imageFile.size > 2 * 1024 * 1024) {
            alert('❌ Ukuran file terlalu besar! Maksimal 2MB');
            return;
        }
        
        // Validasi tipe file
        if (!imageFile.type.match('image.*')) {
            alert('❌ File harus berupa gambar!');
            return;
        }
        
        formData.append('image', imageFile);
    } else {
        console.log('ℹ️ No new image uploaded, keeping existing image');
    }
    
    // Kirim request
    fetch('api.php?action=update&table=slider', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        console.log('📡 Response status:', res.status);
        return res.text();
    })
    .then(text => {
        console.log('📦 Raw response:', text.substring(0, 500));
        
        // Coba parse JSON
        let data;
        try {
            data = JSON.parse(text);
            console.log('✅ Parsed data:', data);
        } catch (e) {
            console.error('❌ JSON Parse Error:', e);
            console.error('Full response:', text);
            alert('❌ Server Error!\n\nResponse bukan JSON.\n\nKemungkinan:\n1. PHP Error\n2. Folder uploads/ tidak ada\n3. Permission denied\n\nCek console untuk detail!\n\n' + text.substring(0, 300));
            throw new Error('Invalid JSON response');
        }
        
        // Proses hasil
        if (data.success) {
            alert('✅ Slider berhasil diupdate!');
            
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editSliderModal'));
            if (modal) modal.hide();
            
            // Reload tabel
            loadSliderTable();
            loadDashboardStats();
        } else {
            alert('❌ Gagal update slider:\n\n' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('❌ Fetch Error:', err);
        alert('❌ Terjadi kesalahan saat mengirim data.\n\nLihat console untuk detail.');
    });
}

function openSliderModal() {
    // Reset form
    document.getElementById('addSliderForm').reset();
    
    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('addSliderModal'));
    modal.show();
}

function addSlider() {
    console.log('🚀 addSlider() called');
    
    const name = document.getElementById('add-slider-name').value.trim();
    const status = document.getElementById('add-slider-status').value;
    const imageInput = document.getElementById('add-slider-image');
    const imageFile = imageInput.files[0];

    // Validasi
    if (!name) {
        alert('❌ Nama slider wajib diisi!');
        return;
    }

    if (!imageFile) {
        alert('❌ Gambar slider wajib dipilih!');
        return;
    }

    // Validasi ukuran file (max 2MB)
    if (imageFile.size > 2 * 1024 * 1024) {
        alert('❌ Ukuran file terlalu besar! Maksimal 2MB');
        return;
    }

    // Validasi tipe file
    if (!imageFile.type.match('image.*')) {
        alert('❌ File harus berupa gambar!');
        return;
    }

    const formData = new FormData();
    formData.append('name', name);
    formData.append('image', imageFile);
    formData.append('is_active', status);
    
    console.log('📤 Sending data...');

    // Kirim ke API
    fetch(`${API_URL}?action=insert&table=slider`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('📡 Response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('📦 Raw response:', text.substring(0, 500));
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('❌ JSON Parse Error:', e);
            console.error('Response:', text.substring(0, 500));
            alert('❌ Server Error: Response bukan JSON.\n\nLihat console untuk detail.');
            return;
        }
        
        console.log('✅ Parsed data:', data);
        
        if (data.success) {
            alert('✅ Slider berhasil ditambahkan!');
            
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addSliderModal'));
            if (modal) modal.hide();
            
            // Reset form
            document.getElementById('addSliderForm').reset();
            clearSliderPreview();
            
            // Reload data
            loadSliderTable();
            loadDashboardStats();
        } else {
            alert('❌ Gagal menambahkan slider:\n\n' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('❌ Fetch Error:', error);
        alert('❌ Terjadi kesalahan saat mengirim data.\n\nLihat console untuk detail.');
    });
}

// Helper function untuk clear preview slider
function clearSliderPreview() {
    const previewContainer = document.getElementById('preview-slider-container');
    const previewImage = document.getElementById('preview-slider-image');
    const imageInput = document.getElementById('add-slider-image');
    
    if (previewContainer) previewContainer.style.display = 'none';
    if (previewImage) previewImage.src = '';
    if (imageInput) imageInput.value = '';
}

// Event listener untuk preview image saat dipilih
document.addEventListener('DOMContentLoaded', function() {
    const addSliderImage = document.getElementById('add-slider-image');
    
    if (addSliderImage) {
        addSliderImage.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            // Validasi tipe file
            if (!file.type.match('image.*')) {
                alert('❌ File harus berupa gambar!');
                e.target.value = '';
                return;
            }
            
            // Validasi ukuran file (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('❌ Ukuran file terlalu besar! Maksimal 2MB');
                e.target.value = '';
                return;
            }
            
            // Preview image
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewContainer = document.getElementById('preview-slider-container');
                const previewImage = document.getElementById('preview-slider-image');
                
                if (previewImage) previewImage.src = event.target.result;
                if (previewContainer) previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }
});

function initSlider() {
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');
    let index = 0;

    function showSlide(i) {
        slides.forEach((s, idx) => {
            s.style.display = idx === i ? 'block' : 'none';
            indicators[idx]?.classList.toggle('active', idx === i);
        });
    }

    showSlide(index);

    setInterval(() => {
        index = (index + 1) % slides.length;
        showSlide(index);
    }, 5000);
}

// ==================== PAKET MANAGEMENT - DELEGATED ====================
// Fungsi paket dihandle oleh kelola_paket.js
// Hanya perlu fungsi showPage untuk navigasi

function loadPaketTable() {
    console.log('📊 Loading paket table from dashboard.js...');
    
    // Panggil fungsi dari kelola_paket.js
    if (typeof loadPaket === 'function') {
        loadPaket();
    } else {
        console.error('❌ loadPaket() tidak ditemukan! Pastikan kelola_paket.js sudah dimuat');
    }
}

// ==================== BERITA MANAGEMENT ====================

function loadBeritaTable() {
    fetch(`${API_URL}?action=get_all&table=berita`)
        .then(response => response.json())
        .then(data => {
            console.log('Berita:', data);
            if (data.success) {
                const tbody = document.getElementById('berita-table-body');
                tbody.innerHTML = '';
                
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
                    return;
                }
                
                // ✅ URUTKAN BERDASARKAN TANGGAL TERBARU
                const sortedBerita = data.data.sort((a, b) => {
                    // Konversi tanggal ke timestamp untuk perbandingan
                    const dateA = parseIndonesianDate(a.date);
                    const dateB = parseIndonesianDate(b.date);
                    return dateB - dateA; // Descending (terbaru dulu)
                });
                
                sortedBerita.forEach(berita => {
                    // Format gambar dengan fallback
                    const imageUrl = berita.image_url || 'https://via.placeholder.com/80x60?text=No+Image';
                    
                    tbody.innerHTML += `
                        <tr>
                            <td>${berita.title}</td>
                            <td>
                                <img src="${imageUrl}" 
                                     style="width:80px;height:60px;object-fit:cover;border-radius:8px;" 
                                     onerror="this.src='https://via.placeholder.com/80x60?text=No+Image'"
                                     alt="${berita.title}">
                            </td>
                            <td>${berita.date}</td>
                            <td><span class="badge-status ${berita.is_active ? 'badge-active' : 'badge-inactive'}">${berita.is_active ? 'Aktif' : 'Nonaktif'}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-action" onclick="editBerita(${berita.id})"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-action" onclick="deleteBerita(${berita.id})"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error loading berita:', error));
}

// ✅ FUNGSI HELPER UNTUK PARSING TANGGAL INDONESIA
function parseIndonesianDate(dateStr) {
    // Jika format YYYY-MM-DD, langsung parse
    if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
        return new Date(dateStr);
    }
    
    // Konversi dari format Indonesia "27 November 2024"
    const monthMap = {
        'Januari': 0, 'Februari': 1, 'Maret': 2, 'April': 3,
        'Mei': 4, 'Juni': 5, 'Juli': 6, 'Agustus': 7,
        'September': 8, 'Oktober': 9, 'November': 10, 'Desember': 11
    };
    
    const parts = dateStr.split(' ');
    if (parts.length === 3) {
        const day = parseInt(parts[0]);
        const month = monthMap[parts[1]] || 0;
        const year = parseInt(parts[2]);
        return new Date(year, month, day);
    }
    
    // Fallback
    return new Date(dateStr);
}

function editBerita(id) {
    console.log('✏️ Edit berita ID:', id);
    
    fetch(`${API_URL}?action=get_by_id&table=berita&id=${id}`)
        .then(response => response.json())
        .then(data => {
            console.log('📦 Berita data received:', data);
            
            if (data.success) {
                const berita = data.data;
                
                // ===== ISI FORM DENGAN DATA =====
                document.getElementById('edit-berita-id').value = berita.id;
                document.getElementById('edit-berita-title').value = berita.title;
                document.getElementById('edit-berita-content').value = berita.content || '';
                document.getElementById('edit-berita-status').value = berita.is_active ? 'true' : 'false';
                
                // ===== SET TANGGAL =====
                // Konversi format tanggal dari "27 November 2024" ke "2024-11-27"
                const dateStr = berita.date;
                let dateISO = '';
                
                // Cek apakah format sudah YYYY-MM-DD
                if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
                    dateISO = dateStr;
                } else {
                    // Konversi dari format Indonesia ke ISO
                    const monthMap = {
                        'Januari': '01', 'Februari': '02', 'Maret': '03', 'April': '04',
                        'Mei': '05', 'Juni': '06', 'Juli': '07', 'Agustus': '08',
                        'September': '09', 'Oktober': '10', 'November': '11', 'Desember': '12'
                    };
                    
                    const parts = dateStr.split(' ');
                    if (parts.length === 3) {
                        const day = parts[0].padStart(2, '0');
                        const month = monthMap[parts[1]] || '01';
                        const year = parts[2];
                        dateISO = `${year}-${month}-${day}`;
                    }
                }
                
                // Set date picker
                const datePicker = document.getElementById('edit-berita-date-picker');
                if (datePicker && dateISO) {
                    datePicker.value = dateISO;
                    console.log('✅ Date picker set to:', dateISO);
                }
                
                // Set hidden date field
                document.getElementById('edit-berita-date').value = berita.date;
                console.log('✅ Hidden date field set to:', berita.date);
                
                // ===== TAMPILKAN GAMBAR SAAT INI =====
                const currentImage = document.getElementById('edit-current-image');
                const currentImagePreview = document.getElementById('edit-current-image-preview');
                const uploadArea = document.getElementById('edit-upload-area');
                
                if (berita.image_url && berita.image_url.trim() !== '') {
                    // Ada gambar, tampilkan
                    if (currentImagePreview) {
                        currentImagePreview.src = berita.image_url;
                        currentImagePreview.onerror = function() {
                            this.src = 'https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan';
                        };
                    }
                    if (currentImage) currentImage.style.display = 'block';
                    if (uploadArea) uploadArea.style.display = 'none';
                    console.log('✅ Current image displayed:', berita.image_url);
                } else {
                    // Tidak ada gambar
                    if (currentImage) currentImage.style.display = 'none';
                    if (uploadArea) uploadArea.style.display = 'block';
                    console.log('⚠️ No image found');
                }
                
                // Reset preview gambar baru
                const editImagePreview = document.getElementById('edit-image-preview');
                const editFileInput = document.getElementById('edit-berita-image-file');
                
                if (editImagePreview) editImagePreview.style.display = 'none';
                if (editFileInput) editFileInput.value = '';
                
                console.log('✅ All form fields filled with existing data');
                
                // Buka modal
                const modal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
                modal.show();
            } else {
                alert('❌ Gagal memuat data berita: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('❌ Error loading berita:', error);
            alert('❌ Terjadi kesalahan saat memuat data berita');
        });
}

function saveBerita() {
    console.log('💾 Saving berita changes...');
    
    const id = document.getElementById('edit-berita-id').value;
    const title = document.getElementById('edit-berita-title').value;
    const dateHidden = document.getElementById('edit-berita-date').value;
    const content = document.getElementById('edit-berita-content').value;
    const status = document.getElementById('edit-berita-status').value === 'true' ? 1 : 0;
    const imageInput = document.getElementById('edit-berita-image-file');
    
    console.log('📝 Data:', { id, title, dateHidden, hasNewImage: imageInput.files.length > 0 });
    
    if (!id || !title || !dateHidden) {
        alert('❌ ID, Judul, dan Tanggal wajib diisi!');
        return;
    }
    
    const formData = new FormData();
    formData.append('id', id);
    formData.append('title', title);
    formData.append('date', dateHidden);
    formData.append('content', content);
    formData.append('is_active', status);
    
    // ✅ KUNCI: Jika ada gambar baru yang diupload
    if (imageInput.files.length > 0) {
        const imageFile = imageInput.files[0];
        console.log('🖼️ New image:', imageFile.name, imageFile.size, 'bytes');
        
        // Validasi ukuran file (max 5MB)
        if (imageFile.size > 5 * 1024 * 1024) {
            alert('❌ Ukuran file terlalu besar! Maksimal 5MB');
            return;
        }
        
        // Validasi tipe file
        if (!imageFile.type.match('image.*')) {
            alert('❌ File harus berupa gambar!');
            return;
        }
        
        formData.append('image', imageFile);
    } else {
        console.log('ℹ️ No new image uploaded, keeping existing image');
    }
    
    // Kirim request
    fetch(`${API_URL}?action=update&table=berita`, {
        method: 'POST',
        body: formData
    })
    .then(res => {
        console.log('📡 Response status:', res.status);
        return res.text();
    })
    .then(text => {
        console.log('📦 Raw response:', text.substring(0, 500));
        
        let data;
        try {
            data = JSON.parse(text);
            console.log('✅ Parsed data:', data);
        } catch (e) {
            console.error('❌ JSON Parse Error:', e);
            console.error('Full response:', text);
            alert('❌ Server Error!\n\nResponse bukan JSON.\n\nKemungkinan:\n1. PHP Error\n2. Folder uploads/ tidak ada\n3. Permission denied\n\nCek console untuk detail!\n\n' + text.substring(0, 300));
            throw new Error('Invalid JSON response');
        }
        
        if (data.success) {
            alert('✅ Berita berhasil diupdate!');
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('editBeritaModal'));
            if (modal) modal.hide();
            
            loadBeritaTable();
            loadDashboardStats();
        } else {
            alert('❌ Gagal update berita:\n\n' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('❌ Fetch Error:', err);
        alert('❌ Terjadi kesalahan saat mengirim data.\n\nLihat console untuk detail.');
    });
}

function deleteBerita(id) {
    if (confirm('Hapus berita ini?')) {
        fetch(`${API_URL}?action=delete&table=berita&id=${id}`)
            .then(response => response.json())
            .then(data => {
                showToast(data.message);
                if (data.success) {
                    loadBeritaTable();
                    loadDashboardStats();
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

function openBeritaModal() {
    // Reset form
    document.getElementById('addBeritaForm').reset();
    
    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('addBeritaModal'));
    modal.show();
}

function addBerita() {
    // Validasi form
    const title = document.getElementById('add-berita-title').value.trim();
    const date = document.getElementById('add-berita-date').value.trim();
    const content = document.getElementById('add-berita-content').value.trim();
    const imageFile = document.getElementById('add-berita-image-file').files[0];
    
    if (!title) {
        alert('Judul berita wajib diisi!');
        return;
    }
    
    if (!date) {
        alert('Tanggal publikasi wajib diisi!');
        return;
    }
    
    // Siapkan FormData
    const formData = new FormData();
    formData.append('title', title);
    formData.append('date', date);
    formData.append('content', content);
    formData.append('is_active', document.getElementById('add-berita-status').value === 'true' ? 1 : 0);
    
    // Jika ada file gambar yang diupload
    if (imageFile) {
        formData.append('image', imageFile);
    }
    
    // Kirim data ke API
    fetch(`${API_URL}?action=insert&table=berita`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message);
            bootstrap.Modal.getInstance(document.getElementById('addBeritaModal')).hide();
            loadBeritaTable();
            loadDashboardStats();
            
            // Reset form dan preview
            document.getElementById('addBeritaForm').reset();
            removeImage();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Gagal menambahkan berita. Silakan coba lagi.', 'error');
    });
}

// ==================== FAQ MANAGEMENT ====================

function loadFaqTable() {
    fetch(`${API_URL}?action=get_all&table=faq`)
        .then(response => response.json())
        .then(data => {
            console.log('FAQ:', data);
            if (data.success) {
                const tbody = document.getElementById('faq-table-body');
                tbody.innerHTML = '';
                
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="3" class="text-center">Tidak ada data</td></tr>';
                    return;
                }
                
                data.data.forEach(faq => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${faq.question}</td>
                            <td><span class="badge-status ${faq.is_active ? 'badge-active' : 'badge-inactive'}">${faq.is_active ? 'Aktif' : 'Nonaktif'}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-action" onclick="editFaq(${faq.id})"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-action" onclick="deleteFaq(${faq.id})"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error loading FAQ:', error));
}

function editFaq(id) {
    fetch(`${API_URL}?action=get_by_id&table=faq&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const faq = data.data;
                document.getElementById('edit-faq-id').value = faq.id;
                document.getElementById('edit-faq-question').value = faq.question;
                document.getElementById('edit-faq-answer').value = faq.answer;
                document.getElementById('edit-faq-status').value = faq.is_active ? 'true' : 'false';
                
                const modal = new bootstrap.Modal(document.getElementById('editFaqModal'));
                modal.show();
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveFaq() {
    const formData = new FormData();
    formData.append('id', document.getElementById('edit-faq-id').value);
    formData.append('question', document.getElementById('edit-faq-question').value);
    formData.append('answer', document.getElementById('edit-faq-answer').value);
    formData.append('is_active', document.getElementById('edit-faq-status').value === 'true' ? 1 : 0);
    
    fetch(`${API_URL}?action=update&table=faq`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message);
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editFaqModal')).hide();
            loadFaqTable();
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteFaq(id) {
    if (confirm('Hapus FAQ ini?')) {
        fetch(`${API_URL}?action=delete&table=faq&id=${id}`)
            .then(response => response.json())
            .then(data => {
                showToast(data.message);
                if (data.success) {
                    loadFaqTable();
                    loadDashboardStats();
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

function openFaqModal() {
    // Reset form
    document.getElementById('addFaqForm').reset();
    
    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('addFaqModal'));
    modal.show();
}

function addFaq() {
    const formData = new FormData();
    formData.append('question', document.getElementById('add-faq-question').value);
    formData.append('answer', document.getElementById('add-faq-answer').value);
    formData.append('is_active', document.getElementById('add-faq-status').value === 'true' ? 1 : 0);
    
    fetch(`${API_URL}?action=insert&table=faq`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message);
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('addFaqModal')).hide();
            loadFaqTable();
            loadDashboardStats();
            
            // ✅ TAMBAHAN: Clear cache untuk FAQ public
            if ('caches' in window) {
                caches.keys().then(names => {
                    names.forEach(name => caches.delete(name));
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Gagal menambahkan data', 'error');
    });
}

// ==================== UTILITY FUNCTIONS ====================

function showToast(message) {
    const toastHtml = `
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast show" role="alert">
                <div class="toast-header bg-success text-white">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong class="me-auto">Notifikasi</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        </div>
    `;
    
    const toastContainer = document.createElement('div');
    toastContainer.innerHTML = toastHtml;
    document.body.appendChild(toastContainer);
    
    setTimeout(() => {
        toastContainer.remove();
    }, 3000);
}
// ==================== PROMO MANAGEMENT ====================
// Tambahkan kode ini di akhir file dashboard.js

// ==================== PROMO MANAGEMENT - COMPLETE FIX ====================
// COPY PASTE KODE INI KE dashboard.js (GANTI yang lama)

// ==================== PROMO MANAGEMENT - FINAL VERSION ====================
// COPY PASTE ke dashboard.js (GANTI bagian promo yang lama)

function loadPromoTable() {
    fetch(`${API_URL}?action=get_all&table=promo`)
        .then(response => response.json())
        .then(data => {
            console.log('Promo data:', data);
            if (data.success) {
                const tbody = document.getElementById('promo-table-body');
                if (!tbody) return;
                
                tbody.innerHTML = '';
                
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data promo</td></tr>';
                    return;
                }
                
                data.data.forEach(promo => {
const regionMap = {
    'all': 'Semua Wilayah',
    'jawa': 'Jawa & Bali',
    'sumatera': 'Sumatera & Kalimantan',
    'timur': 'Indonesia Timur',
    'ntt': 'NTT',
    'batam': 'Batam',
    'natuna': 'Natuna'
};
                    
                    tbody.innerHTML += `
                        <tr>
                            <td>${promo.title}</td>
                            <td><span class="badge bg-info">${regionMap[promo.region] || promo.region}</span></td>
                            <td>${promo.discount_percentage ? promo.discount_percentage + '%' : '-'}</td>
                            <td><small class="text-muted">${formatDate(promo.start_date)} - ${formatDate(promo.end_date)}</small></td>
                            <td><span class="badge-status ${promo.is_active ? 'badge-active' : 'badge-inactive'}">${promo.is_active ? 'Aktif' : 'Nonaktif'}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-action" onclick="editPromo(${promo.id})"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-action" onclick="deletePromo(${promo.id})"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error loading promo:', error));
}

function openPromoModal() {
    console.log('🎯 Opening promo modal...');
    
    const form = document.getElementById('form-promo');
    if (form) form.reset();
    
    const today = new Date().toISOString().split('T')[0];
    const nextMonth = new Date();
    nextMonth.setMonth(nextMonth.getMonth() + 1);
    const endDate = nextMonth.toISOString().split('T')[0];
    
    const startInput = document.getElementById('promo_start_date');
    const endInput = document.getElementById('promo_end_date');
    
    if (startInput) startInput.value = today;
    if (endInput) endInput.value = endDate;
    
    const modalEl = document.getElementById('modalTambahPromo');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

function addPromo() {
    console.log('🚀 addPromo() called');
    
    const getVal = (id) => {
        const el = document.getElementById(id);
        return el ? el.value.trim() : '';
    };
    
    const title = getVal('promo_title');
    const desc = getVal('promo_description');
    const region = getVal('promo_region');
    const discount = getVal('promo_discount');
    const startDate = getVal('promo_start_date');
    const endDate = getVal('promo_end_date');
    const status = getVal('promo_status') || '1';
    
    console.log('Form values:', {title, desc, region, discount, startDate, endDate, status});
    
    if (!title || !desc || !region || !startDate || !endDate) {
        alert('❌ Mohon lengkapi semua field wajib!');
        return;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        alert('❌ Tanggal mulai tidak boleh lebih besar dari tanggal berakhir!');
        return;
    }
    
    const imgFile = document.getElementById('promo_image')?.files[0];
    
    const fd = new FormData();
    fd.append('title', title);
    fd.append('description', desc);
    fd.append('region', region);
    fd.append('discount_percentage', parseInt(discount) || 0);
    fd.append('start_date', startDate);
    fd.append('end_date', endDate);
    fd.append('is_active', parseInt(status));
    
    if (imgFile) {
        fd.append('image', imgFile);
        console.log('📷 Image:', imgFile.name);
    }
    
    console.log('📤 Sending...');
    
    fetch(`${API_URL}?action=insert&table=promo`, {
        method: 'POST',
        body: fd
    })
    .then(res => {
        console.log('Status:', res.status);
        return res.text();
    })
    .then(text => {
        console.log('Raw response:', text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('JSON parse error:', e);
            console.error('Response:', text.substring(0, 500));
            alert('Server Error!\n\n' + 
                  'Response bukan JSON.\n\n' +
                  'Kemungkinan:\n' +
                  '1. PHP Error\n' +
                  '2. Folder uploads/promo/ tidak ada\n' +
                  '3. Permission denied\n\n' +
                  'Cek console untuk detail!\n\n' +
                  text.substring(0, 300));
            throw new Error('Invalid JSON');
        }
        
        console.log('Parsed:', data);
        
        if (data.success) {
            alert('✅ Promo berhasil ditambahkan!');
            
            const modal = document.getElementById('modalTambahPromo');
            if (modal) {
                const inst = bootstrap.Modal.getInstance(modal);
                if (inst) inst.hide();
            }
            
            const form = document.getElementById('form-promo');
            if (form) form.reset();
            
            const preview = document.getElementById('image-preview-promo');
            if (preview) preview.style.display = 'none';
            
            loadPromoTable();
            loadDashboardStats();
        } else {
            alert('❌ Gagal: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('Error:', err);
    });
}

function editPromo(id) {
    fetch(`${API_URL}?action=get_by_id&table=promo&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const p = data.data;
                
                const setVal = (id, val) => {
                    const el = document.getElementById(id);
                    if (el) el.value = val || '';
                };
                
                setVal('edit_promo_id', p.id);
                setVal('edit_promo_title', p.title);
                setVal('edit_promo_description', p.description);
                setVal('edit_promo_region', p.region);
                setVal('edit_promo_discount', p.discount_percentage);
                setVal('edit_promo_start_date', p.start_date);
                setVal('edit_promo_end_date', p.end_date);
                
                const statusEl = document.getElementById('edit_promo_status');
                if (statusEl) statusEl.value = p.is_active ? '1' : '0';
                
                if (p.image_path) {
                    const img = document.getElementById('edit-current-img-promo');
                    const cont = document.getElementById('edit-current-image-promo');
                    if (img) img.src = p.image_path;
                    if (cont) cont.style.display = 'block';
                }
                
                const modal = document.getElementById('modalEditPromo');
                if (modal) {
                    new bootstrap.Modal(modal).show();
                }
            }
        })
        .catch(err => console.error(err));
}

function updatePromo() {
    const getVal = (id) => {
        const el = document.getElementById(id);
        return el ? el.value.trim() : '';
    };
    
    const id = getVal('edit_promo_id');
    const title = getVal('edit_promo_title');
    const desc = getVal('edit_promo_description');
    const region = getVal('edit_promo_region');
    const discount = getVal('edit_promo_discount');
    const startDate = getVal('edit_promo_start_date');
    const endDate = getVal('edit_promo_end_date');
    const status = getVal('edit_promo_status') || '1';
    
    if (!id || !title || !desc || !region || !startDate || !endDate) {
        alert('Mohon lengkapi semua field!');
        return;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        alert('Tanggal mulai tidak boleh lebih besar!');
        return;
    }
    
    const imgFile = document.getElementById('edit_promo_image')?.files[0];
    
    const fd = new FormData();
    fd.append('id', id);
    fd.append('title', title);
    fd.append('description', desc);
    fd.append('region', region);
    fd.append('discount_percentage', parseInt(discount) || 0);
    fd.append('start_date', startDate);
    fd.append('end_date', endDate);
    fd.append('is_active', parseInt(status));
    
    if (imgFile) fd.append('image', imgFile);
    
    fetch(`${API_URL}?action=update&table=promo`, {
        method: 'POST',
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Promo berhasil diupdate!');
            
            const modal = document.getElementById('modalEditPromo');
            if (modal) {
                const inst = bootstrap.Modal.getInstance(modal);
                if (inst) inst.hide();
            }
            
            loadPromoTable();
        } else {
            alert('❌ Gagal: ' + data.message);
        }
    })
    .catch(err => console.error(err));
}

function deletePromo(id) {
    if (!confirm('Hapus promo ini?')) return;
    
    fetch(`${API_URL}?action=delete&table=promo&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('✅ Promo berhasil dihapus!');
                loadPromoTable();
                loadDashboardStats();
            } else {
                alert('❌ Gagal: ' + data.message);
            }
        })
        .catch(err => console.error(err));
}

function formatDate(dateStr) {
    if (!dateStr) return '-';
    const d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
}

// Image preview handlers
document.addEventListener('DOMContentLoaded', function() {
    // Add promo image
    const addImg = document.getElementById('promo_image');
    if (addImg) {
        addImg.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            if (file.size > 2*1024*1024) {
                alert('File terlalu besar! Max 2MB');
                e.target.value = '';
                return;
            }
            
            if (!file.type.match('image.*')) {
                alert('File harus gambar!');
                e.target.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = (ev) => {
                const img = document.getElementById('preview-img-promo');
                const cont = document.getElementById('image-preview-promo');
                if (img) img.src = ev.target.result;
                if (cont) cont.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }
    
    // Edit promo image
    const editImg = document.getElementById('edit_promo_image');
    if (editImg) {
        editImg.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            if (file.size > 2*1024*1024) {
                alert('File terlalu besar! Max 2MB');
                e.target.value = '';
                return;
            }
            
            if (!file.type.match('image.*')) {
                alert('File harus gambar!');
                e.target.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = (ev) => {
                const img = document.getElementById('edit-preview-img-promo');
                const cont = document.getElementById('edit-image-preview-promo');
                const curr = document.getElementById('edit-current-image-promo');
                if (img) img.src = ev.target.result;
                if (cont) cont.style.display = 'block';
                if (curr) curr.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    }
});

function removeImagePromo() {
    const inp = document.getElementById('promo_image');
    const cont = document.getElementById('image-preview-promo');
    if (inp) inp.value = '';
    if (cont) cont.style.display = 'none';
}

function removeEditImagePromo() {
    const inp = document.getElementById('edit_promo_image');
    const cont = document.getElementById('edit-image-preview-promo');
    const curr = document.getElementById('edit-current-image-promo');
    if (inp) inp.value = '';
    if (cont) cont.style.display = 'none';
    if (curr) curr.style.display = 'block';
}

// =============================================
// ADDON FUNCTIONS
// =============================================

// Load Add On Data
function loadAddon() {
    fetch('addon_action.php?action=list')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('addon-table-body');
            if (!tbody) return;

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center">Belum ada data add on</td></tr>';
                return;
            }

            tbody.innerHTML = data.map(addon => `
                <tr>
                    <td><strong>${addon.name}</strong></td>
                    <td><strong class="text-success">Rp ${parseInt(addon.price).toLocaleString('id-ID')}</strong></td>
                    <td>${addon.description || '-'}</td>
                    <td>
                        <span class="badge-status ${addon.status == 1 ? 'badge-active' : 'badge-inactive'}">
                            ${addon.status == 1 ? '✓ Aktif' : '✗ Nonaktif'}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editAddon(${addon.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteAddon(${addon.id}, '${addon.name}')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            `).join('');
        })
        .catch(error => {
            console.error('Error loading addon:', error);
            const tbody = document.getElementById('addon-table-body');
            if (tbody) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error loading data</td></tr>';
            }
        });
}

// Open Add On Modal
function openAddonModal() {
    const form = document.getElementById('form-addon');
    if (form) form.reset();
    
    const modal = new bootstrap.Modal(document.getElementById('modalTambahAddon'));
    modal.show();
}

// Add Add On
function addAddon() {
    const name = document.getElementById('addon_name').value;
    const price = document.getElementById('addon_price').value;
    const description = document.getElementById('addon_description').value;
    const status = document.getElementById('addon_status').value;

    if (!name || !price) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Nama dan harga wajib diisi!'
        });
        return;
    }

    const formData = new FormData();
    formData.append('name', name);
    formData.append('price', price);
    formData.append('description', description);
    formData.append('status', status);

    fetch('addon_action.php?action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Add On berhasil ditambahkan',
                timer: 1500
            }).then(() => {
                bootstrap.Modal.getInstance(document.getElementById('modalTambahAddon')).hide();
                loadAddon();
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

// Edit Add On
function editAddon(id) {
    fetch(`addon_action.php?action=get&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const addon = data.data;
                document.getElementById('edit_addon_id').value = addon.id;
                document.getElementById('edit_addon_name').value = addon.name;
                document.getElementById('edit_addon_price').value = addon.price;
                document.getElementById('edit_addon_description').value = addon.description || '';
                document.getElementById('edit_addon_status').value = addon.status;

                const modal = new bootstrap.Modal(document.getElementById('modalEditAddon'));
                modal.show();
            }
        })
        .catch(error => console.error('Error:', error));
}

// =============================================
// ADDON FUNCTIONS
// =============================================

// ========================================
// FUNGSI ADD ON - LENGKAP
// ========================================

// Load data Add On
function loadAddon() {
    fetch("api_addon.php")
        .then(res => res.json())
        .then(data => {
            let html = "";

            data.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>  <!-- Nomor urut 1,2,3,4,5... -->
                        <td>${item.name}</td>
                        <td>${item.category}</td>
                        <td>${item.description ?? '-'}</td>
                        <td>Rp ${Number(item.price).toLocaleString('id-ID')}</td>
                        <td>Rp ${Number(item.installation_fee || 0).toLocaleString('id-ID')}</td>
                        <td>
                            ${item.image_path ? 
                                `<img src="${item.image_path}" width="50" class="img-thumbnail" style="object-fit: cover; height: 50px;">` 
                                : '<span class="text-muted">-</span>'}
                        </td>
                        <td>
                            <span class="badge ${item.is_active == 1 ? 'bg-success' : 'bg-secondary'}">
                                ${item.is_active == 1 ? 'Aktif' : 'Nonaktif'}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <button class="btn btn-warning btn-sm" onclick="editAddon(${item.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteAddon(${item.id})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById("addonTable").innerHTML = html || '<tr><td colspan="9" class="text-center text-muted">Belum ada data</td></tr>';
        })
        .catch(err => {
            console.error('Error loading addon:', err);
            document.getElementById("addonTable").innerHTML = '<tr><td colspan="9" class="text-center text-danger">Gagal memuat data</td></tr>';
        });
}

// Open Modal Tambah Add On
function openAddonModal() {
    // Reset form
    document.getElementById('formAddon').reset();
    
    // Reset preview
    document.getElementById('image-preview-addon').style.display = 'none';
    document.getElementById('addon_image').value = '';
    
    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('modalTambahAddon'));
    modal.show();
}

// Preview gambar saat upload (Tambah Add On)
document.addEventListener('DOMContentLoaded', function() {
    const addonImageInput = document.getElementById('addon_image');
    if (addonImageInput) {
        addonImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img-addon').src = e.target.result;
                    document.getElementById('image-preview-addon').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Preview gambar saat upload (Edit Add On)
    const editAddonImageInput = document.getElementById('edit_addon_image');
    if (editAddonImageInput) {
        editAddonImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('edit-preview-img-addon').src = e.target.result;
                    document.getElementById('edit-image-preview-addon').style.display = 'block';
                    // Sembunyikan gambar lama
                    document.getElementById('edit-current-image-addon').style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Hapus preview gambar (Tambah)
function removeImageAddon() {
    document.getElementById('addon_image').value = '';
    document.getElementById('image-preview-addon').style.display = 'none';
}

// Hapus preview gambar (Edit)
function removeEditImageAddon() {
    document.getElementById('edit_addon_image').value = '';
    document.getElementById('edit-image-preview-addon').style.display = 'none';
    document.getElementById('edit-current-image-addon').style.display = 'block';
}

// Tambah Add On Baru
function addAddon() {
    console.log('➕ Adding new addon...');
    
    const formData = new FormData();
    
    // Ambil nilai dari form
    const name = document.getElementById('addon_name').value;
    const category = document.getElementById('addon_category').value;
    const description = document.getElementById('addon_description').value;
    const price = document.getElementById('addon_price').value;
    const installation_fee = document.getElementById('addon_installation_fee').value;
    const status = document.getElementById('addon_status').value;
    const fitur = document.getElementById('addon_fitur').value;
    const imageFile = document.getElementById('addon_image').files[0];
    
    // Debug: Log semua data
    console.log('📝 Form data:', {
        name, category, description, price, installation_fee, status, fitur,
        hasImage: !!imageFile
    });
    
    // Validasi
    if (!name || !category || !price) {
        alert('❌ Nama, Kategori, dan Harga harus diisi!');
        return;
    }
    
    // Tambahkan ke FormData
    formData.append('action', 'add');
    formData.append('name', name);
    formData.append('category', category);
    formData.append('description', description);
    formData.append('price', price);
    formData.append('installation_fee', installation_fee || 0);
    formData.append('is_active', status);
    formData.append('fitur', fitur);
    
    // Tambahkan gambar jika ada
    if (imageFile) {
        formData.append('image', imageFile);
        console.log('🖼️ Image:', imageFile.name, imageFile.size, 'bytes');
    }
    
    // Kirim via AJAX
    fetch('api_addon.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        console.log('📡 Response status:', res.status);
        console.log('📡 Response headers:', res.headers.get('content-type'));
        return res.text(); // Ubah ke text dulu untuk debug
    })
    .then(text => {
        console.log('📦 Raw response:', text);
        
        // Parse JSON
        try {
            const data = JSON.parse(text);
            console.log('✅ Parsed JSON:', data);
            
            if (data.success) {
                alert('✅ Add On berhasil ditambahkan!');
                bootstrap.Modal.getInstance(document.getElementById('modalTambahAddon')).hide();
                loadAddon();
            } else {
                alert('❌ Gagal menambahkan Add On: ' + (data.message || 'Unknown error'));
            }
        } catch (e) {
            console.error('❌ JSON Parse Error:', e);
            console.error('Response text:', text);
            alert('❌ Server response error. Lihat console untuk detail.');
        }
    })
    .catch(err => {
        console.error('❌ Fetch Error:', err);
        alert('❌ Terjadi kesalahan saat mengirim data. Lihat console untuk detail.');
    });
}

// Edit Add On - Fetch data dan isi form
function editAddon(id) {
    console.log('🔍 Fetching addon ID:', id);
    
    fetch(`api_addon.php?id=${id}`)
        .then(res => {
            console.log('📡 Response status:', res.status);
            return res.json();
        })
        .then(data => {
            console.log('📦 Data received:', data);
            
            // Cek apakah data valid
            if (!data || data.error) {
                alert('❌ Data tidak ditemukan: ' + (data.error || 'Unknown error'));
                return;
            }
            
            // Isi form dengan data yang ada
            document.getElementById('edit_addon_id').value = data.id || '';
            document.getElementById('edit_addon_name').value = data.name || '';
            document.getElementById('edit_addon_category').value = data.category || '';
            document.getElementById('edit_addon_status').value = data.is_active || '1';
            document.getElementById('edit_addon_description').value = data.description || '';
            document.getElementById('edit_addon_price').value = data.price || '';
            document.getElementById('edit_addon_installation_fee').value = data.installation_fee || '';
            document.getElementById('edit_addon_fitur').value = data.fitur || '';
            
            console.log('✅ Form filled successfully');
            
            // Tampilkan gambar saat ini jika ada
            if (data.image_path) {
                document.getElementById('edit-current-image-addon').style.display = 'block';
                document.getElementById('edit-current-img-addon').src = data.image_path;
                console.log('🖼️ Image loaded:', data.image_path);
            } else {
                document.getElementById('edit-current-image-addon').style.display = 'none';
                console.log('⚠️ No image found');
            }
            
            // Reset preview gambar baru
            document.getElementById('edit-image-preview-addon').style.display = 'none';
            document.getElementById('edit_addon_image').value = '';
            
            // Buka modal
            const modal = new bootstrap.Modal(document.getElementById('modalEditAddon'));
            modal.show();
            console.log('✅ Modal opened');
        })
        .catch(err => {
            console.error('❌ Error:', err);
            alert('❌ Gagal memuat data addon. Lihat console untuk detail.');
        });
}

// Update Add On
function updateAddon() {
    const formData = new FormData();
    const id = document.getElementById('edit_addon_id').value;
    
    formData.append('id', id);
    formData.append('name', document.getElementById('edit_addon_name').value);
    formData.append('category', document.getElementById('edit_addon_category').value);
    formData.append('is_active', document.getElementById('edit_addon_status').value);
    formData.append('description', document.getElementById('edit_addon_description').value);
    formData.append('price', document.getElementById('edit_addon_price').value);
    formData.append('installation_fee', document.getElementById('edit_addon_installation_fee').value || 0);
    formData.append('fitur', document.getElementById('edit_addon_fitur').value);
    formData.append('action', 'update');
    
    // Tambahkan gambar jika ada yang dipilih
    const imageFile = document.getElementById('edit_addon_image').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }
    
    fetch('api_addon.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Data berhasil diupdate!');
            bootstrap.Modal.getInstance(document.getElementById('modalEditAddon')).hide();
            loadAddon();
        } else {
            alert('❌ Gagal update data: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('❌ Terjadi kesalahan saat update data');
    });
}

// Delete Add On
function deleteAddon(id) {
    if (!confirm('⚠️ Yakin ingin menghapus add on ini?')) return;
    
    console.log('🗑️ Deleting addon ID:', id);
    
    // Gunakan GET method dengan parameter action dan id
    fetch(`api_addon.php?action=delete&id=${id}`)
    .then(res => {
        console.log('📡 Response status:', res.status);
        return res.json();
    })
    .then(data => {
        console.log('📦 Response data:', data);
        
        if (data.success) {
            alert('✅ Add on berhasil dihapus!');
            loadAddon(); // Reload tabel
        } else {
            alert('❌ Gagal menghapus add on: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('❌ Error:', err);
        alert('❌ Terjadi kesalahan saat menghapus data. Lihat console untuk detail.');
    });
}
// Load data saat halaman dibuka
document.addEventListener('DOMContentLoaded', function() {
    loadAddon();
});
// ==================== PREVIEW IMAGE EDIT BERITA ====================
// ✅ KODE BARU - TAMBAHKAN DI AKHIR FILE dashboard.js
document.addEventListener('DOMContentLoaded', function() {
    const editBeritaImageInput = document.getElementById('edit-berita-image-file');
    
    if (editBeritaImageInput) {
        console.log('✅ Edit berita image input found, adding event listener');
        
        editBeritaImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) {
                console.log('⚠️ No file selected');
                return;
            }
            
            console.log('📷 File selected:', file.name, file.size, 'bytes');
            
            // Validasi tipe file
            if (!file.type.match('image.*')) {
                alert('❌ File harus berupa gambar!');
                e.target.value = '';
                return;
            }
            
            // Validasi ukuran file (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('❌ Ukuran file terlalu besar! Maksimal 5MB');
                e.target.value = '';
                return;
            }
            
            // Preview gambar baru
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewImg = document.getElementById('edit-preview-img');
                const imagePreview = document.getElementById('edit-image-preview');
                const currentImage = document.getElementById('edit-current-image');
                const uploadArea = document.getElementById('edit-upload-area');
                
                if (previewImg) previewImg.src = event.target.result;
                if (imagePreview) imagePreview.style.display = 'block';
                if (currentImage) currentImage.style.display = 'none';
                if (uploadArea) uploadArea.style.display = 'none';
                
                console.log('✅ Preview gambar baru ditampilkan');
            };
            reader.readAsDataURL(file);
        });
    } else {
        console.error('❌ Edit berita image input NOT found!');
    }
});

