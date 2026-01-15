// ===== GLOBAL VARIABLES =====
let editMode = false;
let editId = null;

// ===== LOAD PAKET DARI DATABASE =====
function loadPaket() {
    fetch('api_paket.php')
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            const body = document.getElementById('paket-table-body');
            body.innerHTML = '';

            if (!data || data.length === 0) {
                body.innerHTML = '<tr><td colspan="9" class="text-center text-muted py-4">Tidak ada data paket</td></tr>';
                return;
            }

            data.forEach(p => {
                const formatRupiah = (angka) => {
                    return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
                };

                const namaPaket = p.name || p.nama || 'N/A';

                body.innerHTML += `
                <tr>
                    <td>
                        <strong>${namaPaket}</strong><br>
                        <small class="text-muted">${p.kecepatan || '-'}</small><br>
                        <small class="badge bg-info text-dark">${p.max_perangkat || 0} Device</small>
                        <small class="badge bg-secondary">${p.max_laptop || 0} Laptop</small>
                        <small class="badge bg-secondary">${p.max_smartphone || 0} HP</small>
                    </td>
                    <td>${formatRupiah(p.harga_sumatera)}<br><small class="text-muted">Install: ${formatRupiah(p.instalasi_sumatera || 345000)}</small></td>
                    <td>${formatRupiah(p.harga_jawa)}<br><small class="text-muted">Install: ${formatRupiah(p.instalasi_jawa || 150000)}</small></td>
                    <td>${formatRupiah(p.harga_timur)}<br><small class="text-muted">Install: ${formatRupiah(p.instalasi_timur || 200000)}</small></td>
                    <td>${formatRupiah(p.harga_ntt)}<br><small class="text-muted">Install: ${formatRupiah(p.instalasi_ntt || 0)}</small></td>
                    <td>${formatRupiah(p.harga_batam)}<br><small class="text-muted">Install: ${formatRupiah(p.instalasi_batam || 0)}</small></td>
                    <td>${formatRupiah(p.harga_natuna)}<br><small class="text-muted">Install: ${formatRupiah(p.instalasi_natuna || 0)}</small></td>
                    <td>
                        <span class="badge ${p.is_active == 1 || p.status == 1 ? 'bg-success' : 'bg-secondary'}">
                            ${p.is_active == 1 || p.status == 1 ? 'Aktif' : 'Nonaktif'}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editPaket(${p.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deletePaket(${p.id}, '${namaPaket.replace(/'/g, "\\'")}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
        })
        .catch(err => {
            console.error('Error loading paket:', err);
            const body = document.getElementById('paket-table-body');
            body.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center text-danger py-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Gagal memuat data paket: ${err.message}
                    </td>
                </tr>`;
        });
}

// ===== BUKA MODAL TAMBAH =====
function openPaketModal() {
    console.log('📝 Opening modal tambah paket...');
    
    const form = document.getElementById('form-paket');
    if (form) {
        form.reset();
    }
    
    // Set default status
    const statusElement = document.getElementById('status');
    if (statusElement) {
        statusElement.value = '1';
    }
    
    // ✅ Set default: semua region AKTIF
    const regions = ['sumatera', 'jawa', 'timur', 'ntt', 'batam', 'natuna'];
    regions.forEach(region => {
        const checkbox = document.getElementById(`status_${region}`);
        if (checkbox) {
            checkbox.checked = true;
            checkbox.value = '1';
        }
        // Enable all inputs
        toggleRegionInputs(region, true, 'add');
    });
    
    const imagePreview = document.getElementById('image-preview-paket');
    if (imagePreview) {
        imagePreview.style.display = 'none';
    }
    
    const imageInput = document.getElementById('paket_image');
    if (imageInput) {
        imageInput.value = '';
    }
    
    const modalEl = document.getElementById('modalTambahPaket');
    
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
        console.log('✅ Modal opened with all regions enabled');
    } else {
        console.error('❌ Modal element not found!');
        alert('Error: Modal tidak ditemukan. Periksa ID modal di HTML.');
    }
}
// ===== TAMBAH PAKET BARU =====
// ===== TAMBAH PAKET BARU - FIXED VERSION =====
function addPaket() {
    console.log('🚀 addPaket() dipanggil');

    const nama = document.getElementById('nama')?.value.trim();
    const sumatera = document.getElementById('sumatera')?.value;
    const jawa = document.getElementById('jawa')?.value;
    const timur = document.getElementById('timur')?.value;
    const ntt = document.getElementById('ntt')?.value;
    const batam = document.getElementById('batam')?.value;
    const natuna = document.getElementById('natuna')?.value;

    console.log('📝 Form values:', {nama, sumatera, jawa, timur, ntt, batam, natuna});

    if (!nama) {
        alert('❌ Nama Paket wajib diisi!');
        return;
    }

    // ✅ FIXED: Validasi minimal 1 harga terisi (tidak wajib semua)
    const hasAnyPrice = sumatera || jawa || timur || ntt || batam || natuna;
    if (!hasAnyPrice) {
        alert('❌ Minimal 1 harga region harus diisi!');
        return;
    }

    const formData = new FormData();
    
    formData.append('nama', nama);
    formData.append('kecepatan', document.getElementById('kecepatan')?.value || '');
    formData.append('status', document.getElementById('status')?.value || '1');

    // Harga Bulanan - gunakan 0 jika kosong
    formData.append('harga_sumatera', parseInt(sumatera) || 0);
    formData.append('harga_jawa', parseInt(jawa) || 0);
    formData.append('harga_timur', parseInt(timur) || 0);
    formData.append('harga_ntt', parseInt(ntt) || 0);
    formData.append('harga_batam', parseInt(batam) || 0);
    formData.append('harga_natuna', parseInt(natuna) || 0);

    // Harga Sebelum Diskon
    formData.append('harga_sumatera_before', parseInt(document.getElementById('sumatera_before')?.value) || 0);
    formData.append('harga_jawa_before', parseInt(document.getElementById('jawa_before')?.value) || 0);
    formData.append('harga_timur_before', parseInt(document.getElementById('timur_before')?.value) || 0);
    formData.append('harga_ntt_before', parseInt(document.getElementById('ntt_before')?.value) || 0);
    formData.append('harga_batam_before', parseInt(document.getElementById('batam_before')?.value) || 0);
    formData.append('harga_natuna_before', parseInt(document.getElementById('natuna_before')?.value) || 0);

    // Instalasi
    formData.append('instalasi_sumatera', parseInt(document.getElementById('instalasi_sumatera')?.value) || 0);
    formData.append('instalasi_jawa', parseInt(document.getElementById('instalasi_jawa')?.value) || 0);
    formData.append('instalasi_timur', parseInt(document.getElementById('instalasi_timur')?.value) || 0);
    formData.append('instalasi_ntt', parseInt(document.getElementById('instalasi_ntt')?.value) || 0);
    formData.append('instalasi_batam', parseInt(document.getElementById('instalasi_batam')?.value) || 0);
    formData.append('instalasi_natuna', parseInt(document.getElementById('instalasi_natuna')?.value) || 0);

    // Instalasi Sebelum Diskon
    formData.append('instalasi_sumatera_before', parseInt(document.getElementById('instalasi_sumatera_before')?.value) || 0);
    formData.append('instalasi_jawa_before', parseInt(document.getElementById('instalasi_jawa_before')?.value) || 0);
    formData.append('instalasi_timur_before', parseInt(document.getElementById('instalasi_timur_before')?.value) || 0);
    formData.append('instalasi_ntt_before', parseInt(document.getElementById('instalasi_ntt_before')?.value) || 0);
    formData.append('instalasi_batam_before', parseInt(document.getElementById('instalasi_batam_before')?.value) || 0);
    formData.append('instalasi_natuna_before', parseInt(document.getElementById('instalasi_natuna_before')?.value) || 0);

    // Perangkat
    formData.append('max_perangkat', parseInt(document.getElementById('max_perangkat')?.value) || 0);
    formData.append('max_laptop', parseInt(document.getElementById('max_laptop')?.value) || 0);
    formData.append('max_smartphone', parseInt(document.getElementById('max_smartphone')?.value) || 0);

    // Fitur
    formData.append('tv_4k', document.getElementById('tv_4k')?.value || '');
    formData.append('streaming', document.getElementById('streaming')?.value || '');
    formData.append('gaming', document.getElementById('gaming')?.value || '');
    formData.append('features', document.getElementById('features')?.value || '');

    // ✅ PENTING: Status Publikasi per Region
const regions = ['sumatera', 'jawa', 'timur', 'ntt', 'batam', 'natuna'];
regions.forEach(region => {
    const checkbox = document.getElementById(`status_${region}`);
    const statusValue = checkbox && checkbox.checked ? 1 : 0;
    formData.append(`status_${region}`, statusValue);
    console.log(`Status ${region}: ${statusValue}`);
});

    // Image
    const imageFile = document.getElementById('paket_image')?.files[0];
    if (imageFile) {
        formData.append('image', imageFile);
        console.log('📷 Image akan diupload:', imageFile.name);
    }

    console.log('📤 Mengirim data ke api_paket.php...');

    fetch('api_paket.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        console.log('📡 Response status:', res.status);
        return res.text();
    })
    .then(text => {
        console.log('📦 Raw response:', text);
        
        let data;
        try {
            data = JSON.parse(text);
            console.log('✅ Parsed JSON:', data);
        } catch (e) {
            console.error('❌ JSON Parse Error:', e);
            console.error('Response text:', text.substring(0, 500));
            alert('❌ Server Error!\n\nResponse bukan JSON.\n\nLihat console untuk detail.');
            return;
        }
        
        if (data.success) {
            alert('✅ Paket berhasil ditambahkan!');
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalTambahPaket'));
            if (modal) modal.hide();
            
            const form = document.getElementById('form-paket');
            if (form) form.reset();
            
            loadPaket();
        } else {
            alert('❌ Gagal menambahkan paket:\n\n' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('❌ Fetch Error:', err);
        alert('❌ Terjadi kesalahan saat mengirim data.\n\nLihat console untuk detail.');
    });
}

// ===== EDIT PAKET =====
function editPaket(id) {
    console.log('✏️ Edit paket ID:', id);
    
    fetch('api_paket.php')
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            const paket = data.find(p => p.id == id);
            if (!paket) {
                alert('❌ Paket tidak ditemukan!');
                return;
            }

            console.log('📦 Data paket:', paket);

            const namaPaket = paket.name || paket.nama || '';

            // === ISI FORM EDIT ===
            document.getElementById('edit_id').value = paket.id;
            document.getElementById('edit_nama').value = namaPaket;
            document.getElementById('edit_kecepatan').value = paket.kecepatan || '';

            // === HARGA BULANAN ===
            document.getElementById('edit_sumatera').value = paket.harga_sumatera || 0;
            document.getElementById('edit_jawa').value = paket.harga_jawa || 0;
            document.getElementById('edit_timur').value = paket.harga_timur || 0;
            document.getElementById('edit_ntt').value = paket.harga_ntt || 0;
            document.getElementById('edit_batam').value = paket.harga_batam || 0;
            document.getElementById('edit_natuna').value = paket.harga_natuna || 0;

            // === HARGA SEBELUM DISKON ===
            document.getElementById('edit_sumatera_before').value = paket.harga_sumatera_before || '';
            document.getElementById('edit_jawa_before').value = paket.harga_jawa_before || '';
            document.getElementById('edit_timur_before').value = paket.harga_timur_before || '';
            document.getElementById('edit_ntt_before').value = paket.harga_ntt_before || '';
            document.getElementById('edit_batam_before').value = paket.harga_batam_before || '';
            document.getElementById('edit_natuna_before').value = paket.harga_natuna_before || '';

            // === INSTALASI ===
            document.getElementById('edit_instalasi_sumatera').value = paket.instalasi_sumatera || 0;
            document.getElementById('edit_instalasi_jawa').value = paket.instalasi_jawa || 0;
            document.getElementById('edit_instalasi_timur').value = paket.instalasi_timur || 0;
            document.getElementById('edit_instalasi_ntt').value = paket.instalasi_ntt || 0;
            document.getElementById('edit_instalasi_batam').value = paket.instalasi_batam || 0;
            document.getElementById('edit_instalasi_natuna').value = paket.instalasi_natuna || 0;

            // === INSTALASI SEBELUM DISKON ===
            document.getElementById('edit_instalasi_sumatera_before').value = paket.instalasi_sumatera_before || '';
            document.getElementById('edit_instalasi_jawa_before').value = paket.instalasi_jawa_before || '';
            document.getElementById('edit_instalasi_timur_before').value = paket.instalasi_timur_before || '';
            document.getElementById('edit_instalasi_ntt_before').value = paket.instalasi_ntt_before || '';
            document.getElementById('edit_instalasi_batam_before').value = paket.instalasi_batam_before || '';
            document.getElementById('edit_instalasi_natuna_before').value = paket.instalasi_natuna_before || '';

            // === PERANGKAT & FITUR ===
            document.getElementById('edit_max_perangkat').value = paket.max_perangkat || 0;
            document.getElementById('edit_max_laptop').value = paket.max_laptop || 0;
            document.getElementById('edit_max_smartphone').value = paket.max_smartphone || 0;
            document.getElementById('edit_tv_4k').value = paket.tv_4k || '';
            document.getElementById('edit_streaming').value = paket.streaming || '';
            document.getElementById('edit_gaming').value = paket.gaming || '';
            document.getElementById('edit_features').value = paket.features || '';
            document.getElementById('edit_status').value = paket.is_active || paket.status || 1;

// ✅ PENTING: STATUS PUBLIKASI PER REGION dengan toggle
const regions = ['sumatera', 'jawa', 'timur', 'ntt', 'batam', 'natuna'];
regions.forEach(region => {
    const statusValue = paket[`status_${region}`] != null ? parseInt(paket[`status_${region}`]) : 1;
    const checkbox = document.getElementById(`edit_status_${region}`);
    
    if (checkbox) {
        checkbox.checked = statusValue === 1;
        checkbox.value = statusValue;
        
        // Toggle inputs based on status
        toggleRegionInputs(region, statusValue === 1, 'edit');
    }
});

console.log('✅ Status region loaded and inputs toggled:', {
    sumatera: paket.status_sumatera,
    jawa: paket.status_jawa,
    timur: paket.status_timur,
    ntt: paket.status_ntt,
    batam: paket.status_batam,
    natuna: paket.status_natuna
});

            // === TAMPILKAN GAMBAR JIKA ADA ===
            const currentImage = document.getElementById('current-image-paket');
            const currentImg = document.getElementById('current-img-paket');
            if (paket.image_path) {
                if (currentImg) currentImg.src = paket.image_path;
                if (currentImage) currentImage.style.display = 'block';
            } else {
                if (currentImage) currentImage.style.display = 'none';
            }

            // === TAMPILKAN MODAL ===
            const modalEl = document.getElementById('modalEditPaket');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            } else {
                alert('❌ Modal edit tidak ditemukan!');
            }
        })
        .catch(err => {
            console.error('❌ Error loading paket for edit:', err);
            alert('❌ Gagal memuat data paket: ' + err.message);
        });
}

// ===== UPDATE PAKET =====
// ===== UPDATE PAKET =====
function updatePaket() {
    console.log('🔄 updatePaket() dipanggil');

    // ✅ PENTING: Deklarasi getValue PERTAMA KALI sebelum digunakan
    const getValue = (id) => {
        const el = document.getElementById(id);
        const value = el ? el.value.trim() : '';
        console.log(`Field ${id}: "${value}"`);
        return value;
    };

    // ✅ PENTING: Ambil status dengan default value
    const status_sumatera = parseInt(getValue('edit_status_sumatera') || 0);
    const status_jawa = parseInt(getValue('edit_status_jawa') || 0);
    const status_timur = parseInt(getValue('edit_status_timur') || 0);
    const status_ntt = parseInt(getValue('edit_status_ntt') || 0);
    const status_batam = parseInt(getValue('edit_status_batam') || 0);
    const status_natuna = parseInt(getValue('edit_status_natuna') || 0);

    console.log('📤 Status yang dikirim:', {
        sumatera: status_sumatera,
        jawa: status_jawa,
        timur: status_timur,
        ntt: status_ntt,
        batam: status_batam,
        natuna: status_natuna
    });

    const id = getValue('edit_id');
    const nama = getValue('edit_nama');
    const kecepatan = getValue('edit_kecepatan');

    if (!id || !nama) {
        alert('❌ ID dan Nama wajib diisi');
        return;
    }

    const formData = new FormData();
    
    formData.append('action', 'update');
    formData.append('id', parseInt(id));
    formData.append('nama', nama);
    formData.append('kecepatan', kecepatan);

    // Harga Bulanan
    formData.append('harga_sumatera', parseInt(getValue('edit_sumatera')) || 0);
    formData.append('harga_jawa', parseInt(getValue('edit_jawa')) || 0);
    formData.append('harga_timur', parseInt(getValue('edit_timur')) || 0);
    formData.append('harga_ntt', parseInt(getValue('edit_ntt')) || 0);
    formData.append('harga_batam', parseInt(getValue('edit_batam')) || 0);
    formData.append('harga_natuna', parseInt(getValue('edit_natuna')) || 0);

    // Harga Before
    formData.append('harga_sumatera_before', parseInt(getValue('edit_sumatera_before')) || 0);
    formData.append('harga_jawa_before', parseInt(getValue('edit_jawa_before')) || 0);
    formData.append('harga_timur_before', parseInt(getValue('edit_timur_before')) || 0);
    formData.append('harga_ntt_before', parseInt(getValue('edit_ntt_before')) || 0);
    formData.append('harga_batam_before', parseInt(getValue('edit_batam_before')) || 0);
    formData.append('harga_natuna_before', parseInt(getValue('edit_natuna_before')) || 0);

    // Instalasi
    formData.append('instalasi_sumatera', parseInt(getValue('edit_instalasi_sumatera')) || 0);
    formData.append('instalasi_jawa', parseInt(getValue('edit_instalasi_jawa')) || 0);
    formData.append('instalasi_timur', parseInt(getValue('edit_instalasi_timur')) || 0);
    formData.append('instalasi_ntt', parseInt(getValue('edit_instalasi_ntt')) || 0);
    formData.append('instalasi_batam', parseInt(getValue('edit_instalasi_batam')) || 0);
    formData.append('instalasi_natuna', parseInt(getValue('edit_instalasi_natuna')) || 0);

    // Instalasi Before
    formData.append('instalasi_sumatera_before', parseInt(getValue('edit_instalasi_sumatera_before')) || 0);
    formData.append('instalasi_jawa_before', parseInt(getValue('edit_instalasi_jawa_before')) || 0);
    formData.append('instalasi_timur_before', parseInt(getValue('edit_instalasi_timur_before')) || 0);
    formData.append('instalasi_ntt_before', parseInt(getValue('edit_instalasi_ntt_before')) || 0);
    formData.append('instalasi_batam_before', parseInt(getValue('edit_instalasi_batam_before')) || 0);
    formData.append('instalasi_natuna_before', parseInt(getValue('edit_instalasi_natuna_before')) || 0);

    // Perangkat
    formData.append('max_perangkat', parseInt(getValue('edit_max_perangkat')) || 0);
    formData.append('max_laptop', parseInt(getValue('edit_max_laptop')) || 0);
    formData.append('max_smartphone', parseInt(getValue('edit_max_smartphone')) || 0);

// Fitur
formData.append('tv_4k', getValue('edit_tv_4k'));
formData.append('streaming', getValue('edit_streaming'));
formData.append('gaming', getValue('edit_gaming'));
formData.append('features', getValue('edit_features'));
formData.append('is_active', parseInt(getValue('edit_status')) || 1);

// ✅ PENTING: Status Publikasi per Region
const regions = ['sumatera', 'jawa', 'timur', 'ntt', 'batam', 'natuna'];
regions.forEach(region => {
    const checkbox = document.getElementById(`edit_status_${region}`);
    const statusValue = checkbox && checkbox.checked ? 1 : 0;
    formData.append(`status_${region}`, statusValue);
    console.log(`Edit Status ${region}: ${statusValue}`);
});

    // Gambar
    const imageFile = document.getElementById('edit_paket_image')?.files[0];
    if (imageFile) {
        formData.append('image', imageFile);
        console.log('📷 Image akan diupload:', imageFile.name);
    }

    console.log('📤 Mengirim data update...');

    fetch('api_paket.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        console.log('📡 Response status:', res.status);
        return res.text();
    })
    .then(text => {
        console.log('📦 Raw response:', text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('❌ JSON Parse Error:', e);
            console.error('Response:', text.substring(0, 500));
            alert('❌ Server Error!\n\nResponse bukan JSON.\n\nLihat console untuk detail.');
            throw new Error('Invalid JSON response');
        }
        
        console.log('✅ Parsed data:', data);
        
        if (data.success) {
            alert('✅ Paket berhasil diupdate!');

            const modal = bootstrap.Modal.getInstance(
                document.getElementById('modalEditPaket')
            );
            if (modal) modal.hide();

            loadPaket();
        } else {
            alert('❌ Gagal update:\n' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('❌ Fetch Error:', err);
        alert('❌ Terjadi kesalahan saat mengirim data.\n\nLihat console untuk detail.');
    });
}

// ===== DELETE PAKET =====
function deletePaket(id, nama) {
    if (!confirm(`⚠️ Apakah Anda yakin ingin menghapus paket "${nama}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        return;
    }

    fetch('api_paket.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id: parseInt(id)})
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(result => {
        if (result.success) {
            alert('✅ Paket berhasil dihapus!');
            loadPaket();
        } else {
            alert('❌ Gagal menghapus paket: ' + (result.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('Error deleting paket:', err);
        alert('❌ Terjadi kesalahan: ' + err.message);
    });
}

// ===== PREVIEW IMAGE =====
document.addEventListener('DOMContentLoaded', function() {
    const addImageInput = document.getElementById('paket_image');
    if (addImageInput) {
        addImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview-paket');
                    const img = document.getElementById('preview-img-paket');
                    if (img) img.src = e.target.result;
                    if (preview) preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    const editImageInput = document.getElementById('edit_paket_image');
    if (editImageInput) {
        editImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('edit-image-preview-paket');
                    const img = document.getElementById('edit-preview-img-paket');
                    const current = document.getElementById('current-image-paket');
                    if (img) img.src = e.target.result;
                    if (preview) preview.style.display = 'block';
                    if (current) current.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

function removeImagePaket() {
    document.getElementById('paket_image').value = '';
    document.getElementById('image-preview-paket').style.display = 'none';
}

function removeEditImagePaket() {
    document.getElementById('edit_paket_image').value = '';
    document.getElementById('edit-image-preview-paket').style.display = 'none';
    document.getElementById('current-image-paket').style.display = 'block';
}
// ===== TOGGLE REGION INPUTS BASED ON STATUS =====
function toggleRegionInputs(region, isActive, mode = 'add') {
    console.log(`🔄 Toggling ${region} - Active: ${isActive} - Mode: ${mode}`);
    
    const prefix = mode === 'edit' ? 'edit_' : '';
    const classPrefix = mode === 'edit' ? 'edit-region-input-' : 'region-input-';
    
    // Get all inputs for this region
    const inputs = document.querySelectorAll(`.${classPrefix}${region}`);
    
    inputs.forEach(input => {
        if (isActive) {
            // Enable input
            input.removeAttribute('disabled');
            input.style.backgroundColor = '';
            input.style.cursor = '';
        } else {
            // Disable input
            input.setAttribute('disabled', 'disabled');
            input.style.backgroundColor = '#e9ecef';
            input.style.cursor = 'not-allowed';
            // Clear value when disabled
            input.value = '';
        }
    });
    
    // Update checkbox value
    const checkbox = document.getElementById(`${prefix}status_${region}`);
    if (checkbox) {
        checkbox.value = isActive ? '1' : '0';
    }
    
    console.log(`✅ Region ${region} inputs ${isActive ? 'enabled' : 'disabled'}`);
}

// ===== INIT TOGGLE ON PAGE LOAD =====
document.addEventListener('DOMContentLoaded', function() {
    // Set initial state for all regions (default: active)
    const regions = ['sumatera', 'jawa', 'timur', 'ntt', 'batam', 'natuna'];
    
    regions.forEach(region => {
        // Add mode
        const checkbox = document.getElementById(`status_${region}`);
        if (checkbox) {
            checkbox.checked = true; // Default checked
            toggleRegionInputs(region, true, 'add');
        }
        
        // Edit mode
        const editCheckbox = document.getElementById(`edit_status_${region}`);
        if (editCheckbox) {
            // Will be set dynamically when editing
        }
    });
});