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
    if (pageName === 'promo') loadPromoTable(); // TAMBAHKAN BARIS INI
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

// ==================== PAKET MANAGEMENT - FULLY FIXED ====================

// ==================== PAKET MANAGEMENT - FULLY FIXED ====================

function openPaketModal() {
    console.log('Opening paket modal...');
    
    // Reset form - TANPA DEFAULT VALUE untuk instalasi & perangkat
    const form = document.getElementById('form-paket');
    if (form) {
        form.reset();
    }
    
    // Set default HANYA untuk status
    const statusElement = document.getElementById('status');
    if (statusElement) {
        statusElement.value = '1';
    }
    
    // Buka modal
    // KODE BARU YANG BENAR
const modalElement = document.getElementById('modalTambahPaket'); // ✅ BENAR
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        console.log('✅ Modal opened');
    } else {
        console.error('❌ Modal modalTambahPaket not found!');
        alert('Error: Modal tidak ditemukan!');
    }
}

function addPaket() {
    console.log('🚀 addPaket() dipanggil');
    
    const getValue = (id) => {
        const el = document.getElementById(id);
        return el ? el.value.trim() : '';
    };
    
    const nama = getValue('nama');
    const kecepatan = getValue('kecepatan');
    const max_perangkat = getValue('max_perangkat');
    const max_laptop = getValue('max_laptop');
    const max_smartphone = getValue('max_smartphone');
    const sumatera = getValue('sumatera');
    const jawa = getValue('jawa');
    const timur = getValue('timur');
    const instalasi_sumatera = getValue('instalasi_sumatera');
    const instalasi_jawa = getValue('instalasi_jawa');
    const instalasi_timur = getValue('instalasi_timur');
    const tv_4k = getValue('tv_4k');
    const streaming = getValue('streaming');
    const gaming = getValue('gaming');
    const features = getValue('features');
    const status = getValue('status') || '1';
    
    // Ambil file gambar
    const imageFile = document.getElementById('paket_image')?.files[0];

    // Validasi - PERBAIKAN: Cek string kosong
    if (!nama || sumatera === '' || jawa === '' || timur === '') {
        alert('❌ Mohon lengkapi field wajib:\n- Nama Paket\n- Harga Sumatera\n- Harga Jawa\n- Harga Timur');
        return;
    }

    if (instalasi_sumatera === '' || instalasi_jawa === '' || instalasi_timur === '') {
        alert('❌ Biaya instalasi wajib diisi untuk semua wilayah!\n(Boleh diisi 0 jika gratis)');
        return;
    }

    if (max_perangkat === '' || max_laptop === '' || max_smartphone === '') {
        alert('❌ Data perangkat ideal wajib diisi semua!\n(Boleh diisi 0 jika tidak ada)');
        return;
    }

    // GUNAKAN FormData untuk upload file
    const formData = new FormData();
    formData.append('nama', nama);
    formData.append('kecepatan', kecepatan);
    formData.append('max_perangkat', parseInt(max_perangkat) || 0);
    formData.append('max_laptop', parseInt(max_laptop) || 0);
    formData.append('max_smartphone', parseInt(max_smartphone) || 0);
    formData.append('sumatera', parseInt(sumatera) || 0);
    formData.append('jawa', parseInt(jawa) || 0);
    formData.append('timur', parseInt(timur) || 0);
    formData.append('instalasi_sumatera', parseInt(instalasi_sumatera) || 0);
    formData.append('instalasi_jawa', parseInt(instalasi_jawa) || 0);
    formData.append('instalasi_timur', parseInt(instalasi_timur) || 0);
    formData.append('tv_4k', tv_4k);
    formData.append('streaming', streaming);
    formData.append('gaming', gaming);
    formData.append('features', features);
    formData.append('status', parseInt(status) || 1);
    
    // Tambahkan file jika ada
    if (imageFile) {
        formData.append('image', imageFile);
    }

    console.log('📤 Mengirim data dengan gambar ke api_paket.php');

    // KIRIM DENGAN FormData (BUKAN JSON)
    fetch('api_paket.php', {
        method: 'POST',
        body: formData  // JANGAN gunakan headers Content-Type untuk FormData
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                console.error('❌ Response bukan JSON:', text);
                throw new Error('Server error');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('✅ Paket berhasil ditambahkan!');
            
            const modalElement = document.getElementById('modalTambahPaket');
            if (modalElement) {
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            }
            
            const form = document.getElementById('form-paket');
            if (form) form.reset();
            
            removeImagePaket();
            
            if (typeof loadPaket === 'function') {
                loadPaket();
            }
            
            if (typeof loadDashboardStats === 'function') {
                loadDashboardStats();
            }
        } else {
            alert('❌ Gagal menambahkan paket:\n\n' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        alert('❌ Terjadi kesalahan:\n\n' + error.message);
    });
}

function editPaket(id) {
    console.log('✏️ Edit paket ID:', id);
    
    // Fetch data paket dari API (GET method)
    fetch(`api_paket.php`, {
        method: 'GET'
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                console.error('❌ Response bukan JSON:', text);
                throw new Error('Server error. Periksa api_paket.php');
            });
        }
        return response.json();
    })
    .then(paketList => {
        console.log('📥 Data semua paket:', paketList);
        
        // Cari paket berdasarkan ID
        const paket = paketList.find(p => p.id == id);
        
        if (!paket) {
            alert('❌ Paket dengan ID ' + id + ' tidak ditemukan!');
            return;
        }
        
        console.log('📋 Data paket yang dipilih:', paket);
        
        // Isi form edit - SESUAI dengan ID di HTML
        const setValue = (fieldId, value) => {
            const el = document.getElementById(fieldId);
            if (el) {
                el.value = value || '';
            } else {
                console.warn(`⚠️ Element ${fieldId} tidak ditemukan`);
            }
        };
        
        setValue('edit_id', paket.id);
        setValue('edit_nama', paket.name);
        setValue('edit_kecepatan', paket.kecepatan);
        setValue('edit_sumatera', paket.harga_sumatera);
        setValue('edit_jawa', paket.harga_jawa);
        setValue('edit_timur', paket.harga_timur);
        setValue('edit_instalasi_sumatera', paket.instalasi_sumatera);
        setValue('edit_instalasi_jawa', paket.instalasi_jawa);
        setValue('edit_instalasi_timur', paket.instalasi_timur);
        setValue('edit_max_perangkat', paket.max_perangkat);
        setValue('edit_max_laptop', paket.max_laptop);
        setValue('edit_max_smartphone', paket.max_smartphone);
        setValue('edit_tv_4k', paket.tv_4k);
        setValue('edit_streaming', paket.streaming);
        setValue('edit_gaming', paket.gaming);
        setValue('edit_features', paket.features);
        setValue('edit_status', paket.status); // dari api_paket.php status = is_active
        
        // Buka modal
        const modalElement = document.getElementById('modalEditPaket');
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            console.log('✅ Modal edit dibuka');
        } else {
            console.error('❌ Modal modalEditPaket tidak ditemukan!');
            alert('Error: Modal edit tidak ditemukan!');
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        alert('❌ Gagal memuat data:\n\n' + error.message);
    });
}

function updatePaket() {
    console.log('🔄 updatePaket() dipanggil');
    
    // Ambil nilai dari form dengan helper function
    const getValue = (id) => {
        const el = document.getElementById(id);
        const value = el ? el.value.trim() : '';
        console.log(`Field ${id}: "${value}"`); // Debug log
        return value;
    };
    
    const id = getValue('edit_id');
    const nama = getValue('edit_nama');
    const kecepatan = getValue('edit_kecepatan'); // PASTIKAN INI BENAR, BUKAN "Recepatan"
    const sumatera = getValue('edit_sumatera');
    const jawa = getValue('edit_jawa');
    const timur = getValue('edit_timur');
    const instalasi_sumatera = getValue('edit_instalasi_sumatera');
    const instalasi_jawa = getValue('edit_instalasi_jawa');
    const instalasi_timur = getValue('edit_instalasi_timur');
    const max_perangkat = getValue('edit_max_perangkat');
    const max_laptop = getValue('edit_max_laptop');
    const max_smartphone = getValue('edit_max_smartphone');
    const tv_4k = getValue('edit_tv_4k');
    const streaming = getValue('edit_streaming');
    const gaming = getValue('edit_gaming');
    const features = getValue('edit_features');
    const status = getValue('edit_status') || '1';

    console.log('📝 Raw form values:', {
        id, nama, kecepatan, sumatera, jawa, timur,
        instalasi_sumatera, instalasi_jawa, instalasi_timur,
        max_perangkat, max_laptop, max_smartphone,
        tv_4k, streaming, gaming, features, status
    });

    // Validasi field wajib
    if (!id || !nama || !sumatera || !jawa || !timur) {
        alert('❌ Mohon lengkapi field wajib:\n- ID\n- Nama Paket\n- Harga Sumatera/Jawa/Timur');
        return;
    }

    if (!instalasi_sumatera || !instalasi_jawa || !instalasi_timur) {
        alert('❌ Biaya instalasi wajib diisi untuk semua wilayah!');
        return;
    }

    if (!max_perangkat || !max_laptop || !max_smartphone) {
        alert('❌ Data perangkat ideal wajib diisi semua!');
        return;
    }

    // Prepare data dengan NAMA FIELD YANG BENAR
    const data = {
        id: parseInt(id),
        nama: nama,
        kecepatan: kecepatan, // BUKAN "Recepatan"
        sumatera: parseInt(sumatera) || 0,
        jawa: parseInt(jawa) || 0,
        timur: parseInt(timur) || 0,
        instalasi_sumatera: parseInt(instalasi_sumatera) || 0,
        instalasi_jawa: parseInt(instalasi_jawa) || 0,
        instalasi_timur: parseInt(instalasi_timur) || 0,
        max_perangkat: parseInt(max_perangkat) || 0,
        max_laptop: parseInt(max_laptop) || 0,
        max_smartphone: parseInt(max_smartphone) || 0,
        tv_4k: tv_4k,
        streaming: streaming,
        gaming: gaming,
        features: features,
        status: parseInt(status) || 1
    };

    console.log('📤 Data yang akan dikirim ke api_paket.php:', data);
    console.log('📤 JSON String:', JSON.stringify(data));

    // Kirim ke API
    fetch('api_paket.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('📥 Response status:', response.status);
        
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                console.error('❌ Response bukan JSON:', text);
                throw new Error('Server error: Response bukan JSON');
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ Response data:', data);
        
        if (data.success) {
            alert('✅ Paket berhasil diupdate!');
            
            // Tutup modal
            const modalElement = document.getElementById('modalEditPaket');
            if (modalElement) {
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
            
            // Reload table
            if (typeof loadPaket === 'function') {
                loadPaket();
            }
            
            // Reload stats
            if (typeof loadDashboardStats === 'function') {
                loadDashboardStats();
            }
        } else {
            alert('❌ Gagal mengupdate paket:\n\n' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        alert('❌ Terjadi kesalahan:\n\n' + error.message);
    });
}

function deletePaket(id) {
    if (!confirm('⚠️ Apakah Anda yakin ingin menghapus paket ini?\n\nTindakan ini tidak dapat dibatalkan!')) {
        return;
    }

    console.log('🗑️ Delete paket ID:', id);

    fetch('api_paket.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id: parseInt(id)})
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                console.error('❌ Response bukan JSON:', text);
                throw new Error('Server error');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('✅ Paket berhasil dihapus!');
            
            // Reload table (jika ada fungsi loadPaket)
            if (typeof loadPaket === 'function') {
                loadPaket();
            }
            
            // Reload stats dashboard
            if (typeof loadDashboardStats === 'function') {
                loadDashboardStats();
            }
        } else {
            alert('❌ Gagal menghapus paket:\n\n' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        alert('❌ Terjadi kesalahan:\n\n' + error.message);
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
                        'timur': 'Indonesia Timur'
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