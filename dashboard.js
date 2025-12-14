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
        'transaksi': 'Daftar Transaksi'
    };
    
    const titleElement = document.getElementById('page-title');
    if (titleElement) {
        titleElement.textContent = titles[pageName] || 'Dashboard Admin';
    }

    // Add active class to clicked menu
    const menuElement = document.querySelector(`.sidebar-menu a[onclick*="${pageName}"]`);
    if (menuElement) {
        menuElement.classList.add('active');
    }

    // Load data based on page
    if (pageName === 'slider') loadSliderTable();
    if (pageName === 'paket') loadPaketTable();
    if (pageName === 'berita') loadBeritaTable();
    if (pageName === 'faq') loadFaqTable();
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
                                <button class="btn btn-sm btn-warning btn-action" onclick="editSlider(${slider.id})"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-action" onclick="deleteSlider(${slider.id})"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error loading sliders:', error));
}

function deleteSlider(id) {
    if (confirm('Hapus slider ini?')) {
        fetch(`${API_URL}?action=delete&table=slider&id=${id}`)
            .then(response => response.json())
            .then(data => {
                showToast(data.message);
                if (data.success) {
                    loadSliderTable();
                    loadDashboardStats();
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

function editSlider(id) {
    fetch(`${API_URL}?action=get_by_id&table=slider&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const slider = data.data;
                document.getElementById('edit-slider-id').value = slider.id;
                document.getElementById('edit-slider-name').value = slider.name;
                document.getElementById('edit-slider-image').value = slider.image_path;
                document.getElementById('edit-slider-status').value = slider.is_active ? 'true' : 'false';
                
                const modal = new bootstrap.Modal(document.getElementById('editSliderModal'));
                modal.show();
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveSlider() {
    const formData = new FormData();
    formData.append('id', document.getElementById('edit-slider-id').value);
    formData.append('name', document.getElementById('edit-slider-name').value);
    formData.append('image_path', document.getElementById('edit-slider-image').value);
    formData.append('is_active', document.getElementById('edit-slider-status').value === 'true' ? 1 : 0);
    
    fetch(`${API_URL}?action=update&table=slider`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message);
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editSliderModal')).hide();
            loadSliderTable();
        }
    })
    .catch(error => console.error('Error:', error));
}

function openSliderModal() {
    // Reset form
    document.getElementById('addSliderForm').reset();
    
    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('addSliderModal'));
    modal.show();
}

function addSlider() {
    const formData = new FormData();
    formData.append('name', document.getElementById('add-slider-name').value);
    formData.append('image_path', document.getElementById('add-slider-image').value);
    formData.append('is_active', document.getElementById('add-slider-status').value === 'true' ? 1 : 0);
    
    fetch(`${API_URL}?action=insert&table=slider`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message);
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('addSliderModal')).hide();
            loadSliderTable();
            loadDashboardStats();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Gagal menambahkan data', 'error');
    });
}

// ==================== PAKET MANAGEMENT ====================

function loadPaketTable() {
    fetch(`${API_URL}?action=get_all&table=paket`)
        .then(response => response.json())
        .then(data => {
            console.log('Pakets:', data);
            if (data.success) {
                const tbody = document.getElementById('paket-table-body');
                tbody.innerHTML = '';
                
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>';
                    return;
                }
                
                data.data.forEach(paket => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${paket.name}</td>
                            <td>Rp ${parseInt(paket.harga_sumatera).toLocaleString('id-ID')}</td>
                            <td>Rp ${parseInt(paket.harga_jawa).toLocaleString('id-ID')}</td>
                            <td>Rp ${parseInt(paket.harga_timur).toLocaleString('id-ID')}</td>
                            <td><span class="badge-status ${paket.is_active ? 'badge-active' : 'badge-inactive'}">${paket.is_active ? 'Aktif' : 'Nonaktif'}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-action" onclick="editPaket('${paket.id}')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-action" onclick="deletePaket('${paket.id}')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error loading pakets:', error));
}

function editPaket(id) {
    fetch(`${API_URL}?action=get_by_id&table=paket&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const paket = data.data;
                document.getElementById('edit-paket-id').value = paket.id;
                document.getElementById('edit-paket-name').value = paket.name;
                document.getElementById('edit-paket-sumatera').value = paket.harga_sumatera;
                document.getElementById('edit-paket-jawa').value = paket.harga_jawa;
                document.getElementById('edit-paket-timur').value = paket.harga_timur;
                document.getElementById('edit-paket-status').value = paket.is_active ? 'true' : 'false';
                
                const modal = new bootstrap.Modal(document.getElementById('editPaketModal'));
                modal.show();
            }
        })
        .catch(error => console.error('Error:', error));
}

function savePaket() {
    const formData = new FormData();
    formData.append('id', document.getElementById('edit-paket-id').value);
    formData.append('name', document.getElementById('edit-paket-name').value);
    formData.append('harga_sumatera', document.getElementById('edit-paket-sumatera').value);
    formData.append('harga_jawa', document.getElementById('edit-paket-jawa').value);
    formData.append('harga_timur', document.getElementById('edit-paket-timur').value);
    formData.append('is_active', document.getElementById('edit-paket-status').value === 'true' ? 1 : 0);
    
    fetch(`${API_URL}?action=update&table=paket`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message);
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editPaketModal')).hide();
            loadPaketTable();
        }
    })
    .catch(error => console.error('Error:', error));
}

function deletePaket(id) {
    if (confirm('Hapus paket ini?')) {
        fetch(`${API_URL}?action=delete&table=paket&id=${id}`)
            .then(response => response.json())
            .then(data => {
                showToast(data.message);
                if (data.success) {
                    loadPaketTable();
                    loadDashboardStats();
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

function openPaketModal() {
    // Reset form
    document.getElementById('addPaketForm').reset();
    
    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('addPaketModal'));
    modal.show();
}

function addPaket() {
    const formData = new FormData();
    formData.append('id', document.getElementById('add-paket-id').value);
    formData.append('name', document.getElementById('add-paket-name').value);
    formData.append('harga_sumatera', document.getElementById('add-paket-sumatera').value);
    formData.append('harga_jawa', document.getElementById('add-paket-jawa').value);
    formData.append('harga_timur', document.getElementById('add-paket-timur').value);
    formData.append('is_active', document.getElementById('add-paket-status').value === 'true' ? 1 : 0);
    
    fetch(`${API_URL}?action=insert&table=paket`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message);
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('addPaketModal')).hide();
            loadPaketTable();
            loadDashboardStats();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Gagal menambahkan data', 'error');
    });
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
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>';
                    return;
                }
                
                data.data.forEach(berita => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${berita.title}</td>
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

function editBerita(id) {
    fetch(`${API_URL}?action=get_by_id&table=berita&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const berita = data.data;
                document.getElementById('edit-berita-id').value = berita.id;
                document.getElementById('edit-berita-title').value = berita.title;
                document.getElementById('edit-berita-date').value = berita.date;
                document.getElementById('edit-berita-content').value = berita.content || '';
                document.getElementById('edit-berita-status').value = berita.is_active ? 'true' : 'false';
                
                const modal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
                modal.show();
            }
        })
        .catch(error => console.error('Error:', error));
}

function saveBerita() {
    const formData = new FormData();
    formData.append('id', document.getElementById('edit-berita-id').value);
    formData.append('title', document.getElementById('edit-berita-title').value);
    formData.append('date', document.getElementById('edit-berita-date').value);
    formData.append('content', document.getElementById('edit-berita-content').value);
    formData.append('is_active', document.getElementById('edit-berita-status').value === 'true' ? 1 : 0);
    
    fetch(`${API_URL}?action=update&table=berita`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message);
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editBeritaModal')).hide();
            loadBeritaTable();
        }
    })
    .catch(error => console.error('Error:', error));
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