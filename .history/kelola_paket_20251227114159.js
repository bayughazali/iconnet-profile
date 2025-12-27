// ===== GLOBAL VARIABLES =====
let editMode = false;
let editId = null;

// ===== LOAD PAKET DARI DATABASE =====
function loadPaket() {
    fetch('../api/paket.php')
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
                body.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data paket</td></tr>';
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
                    <td>
                        <span class="badge ${p.status == 1 ? 'bg-success' : 'bg-secondary'}">
                            ${p.status == 1 ? 'Aktif' : 'Nonaktif'}
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
                    <td colspan="6" class="text-center text-danger py-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Gagal memuat data paket: ${err.message}
                    </td>
                </tr>`;
        });
}

// ===== BUKA MODAL TAMBAH =====
function openPaketModal() {
    console.log('Opening modal...');
    
    // Reset form
    const form = document.getElementById('form-paket');
    if (form) {
        form.reset();
    }
    
    // Set default values
    const defaults = {
        'instalasi_sumatera': '345000',
        'instalasi_jawa': '150000',
        'instalasi_timur': '200000',
        'max_perangkat': '4',
        'max_laptop': '2',
        'max_smartphone': '2',
        'status': '1'
    };
    
    for (const [id, value] of Object.entries(defaults)) {
        const element = document.getElementById(id);
        if (element) {
            element.value = value;
        }
    }
    
    // Show modal
    const modalEl = document.getElementById('modalTambahPaket');
    
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
        console.log('Modal opened successfully');
    } else {
        console.error('Modal element not found!');
        alert('Error: Modal tidak ditemukan. Periksa ID modal di HTML.');
    }
}

// ===== TAMBAH PAKET BARU =====
function addPaket() {
    console.log('addPaket() called');

    // ===== AMBIL NILAI FORM =====
    const nama = document.getElementById('nama')?.value || '';
    const kecepatan = document.getElementById('kecepatan')?.value || '';

    const sumatera = document.getElementById('sumatera')?.value || '0';
    const jawa = document.getElementById('jawa')?.value || '0';
    const timur = document.getElementById('timur')?.value || '0';

    // ===== HARGA SEBELUM DISKON =====
    const sumatera_before = document.getElementById('sumatera_before')?.value || null;
    const jawa_before = document.getElementById('jawa_before')?.value || null;
    const timur_before = document.getElementById('timur_before')?.value || null;

    // ===== INSTALASI =====
    const instalasi_sumatera = document.getElementById('instalasi_sumatera')?.value || '345000';
    const instalasi_jawa = document.getElementById('instalasi_jawa')?.value || '150000';
    const instalasi_timur = document.getElementById('instalasi_timur')?.value || '200000';

    // ===== INSTALASI SEBELUM DISKON =====
    const instalasi_sumatera_before = document.getElementById('instalasi_sumatera_before')?.value || null;
    const instalasi_jawa_before = document.getElementById('instalasi_jawa_before')?.value || null;
    const instalasi_timur_before = document.getElementById('instalasi_timur_before')?.value || null;

    const max_perangkat = document.getElementById('max_perangkat')?.value || '0';
    const max_laptop = document.getElementById('max_laptop')?.value || '0';
    const max_smartphone = document.getElementById('max_smartphone')?.value || '0';

    const tv_4k = document.getElementById('tv_4k')?.value || '';
    const streaming = document.getElementById('streaming')?.value || '';
    const gaming = document.getElementById('gaming')?.value || '';
    const features = document.getElementById('features')?.value || '';
    const status = document.getElementById('status')?.value || '1';

    // ===== VALIDASI =====
    if (!nama.trim() || !sumatera || !jawa || !timur) {
        alert('❌ Mohon lengkapi Nama Paket & Harga!');
        return;
    }

    // ===== DATA KE API =====
    const data = {
        nama: nama.trim(),
        kecepatan: kecepatan.trim(),

        sumatera: parseInt(sumatera),
        jawa: parseInt(jawa),
        timur: parseInt(timur),

        sumatera_before: sumatera_before ? parseInt(sumatera_before) : null,
        jawa_before: jawa_before ? parseInt(jawa_before) : null,
        timur_before: timur_before ? parseInt(timur_before) : null,

        instalasi_sumatera: parseInt(instalasi_sumatera),
        instalasi_jawa: parseInt(instalasi_jawa),
        instalasi_timur: parseInt(instalasi_timur),

        instalasi_sumatera_before: instalasi_sumatera_before ? parseInt(instalasi_sumatera_before) : null,
        instalasi_jawa_before: instalasi_jawa_before ? parseInt(instalasi_jawa_before) : null,
        instalasi_timur_before: instalasi_timur_before ? parseInt(instalasi_timur_before) : null,

        max_perangkat: parseInt(max_perangkat),
        max_laptop: parseInt(max_laptop),
        max_smartphone: parseInt(max_smartphone),

        tv_4k: tv_4k.trim(),
        streaming: streaming.trim(),
        gaming: gaming.trim(),
        features: features.trim(),
        status: parseInt(status)
    };

    console.log('Sending data:', data);

    fetch('../api/paket.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            alert('✅ Paket berhasil ditambahkan!');
            loadPaket();
            document.getElementById('form-paket')?.reset();
            bootstrap.Modal.getInstance(document.getElementById('modalTambahPaket'))?.hide();
        } else {
            alert('❌ ' + (result.message || 'Gagal menambah paket'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Terjadi kesalahan');
    });
}


// ===== EDIT PAKET =====
function editPaket(id) {
    console.log('Edit paket ID:', id);
    
    fetch('../api/paket.php')
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

            const namaPaket = paket.name || paket.nama || '';

            // Isi form edit dengan semua field
            document.getElementById('edit_id').value = paket.id;
            document.getElementById('edit_nama').value = namaPaket;
            document.getElementById('edit_kecepatan').value = paket.kecepatan || '';
            document.getElementById('edit_sumatera').value = paket.harga_sumatera || 0;
            document.getElementById('edit_jawa').value = paket.harga_jawa || 0;
            document.getElementById('edit_timur').value = paket.harga_timur || 0;
            document.getElementById('edit_instalasi_sumatera').value = paket.instalasi_sumatera || 345000;
            document.getElementById('edit_instalasi_jawa').value = paket.instalasi_jawa || 150000;
            document.getElementById('edit_instalasi_timur').value = paket.instalasi_timur || 200000;
            document.getElementById('edit_max_perangkat').value = paket.max_perangkat || 4;
            document.getElementById('edit_max_laptop').value = paket.max_laptop || 2;
            document.getElementById('edit_max_smartphone').value = paket.max_smartphone || 2;
            document.getElementById('edit_tv_4k').value = paket.tv_4k || '';
            document.getElementById('edit_streaming').value = paket.streaming || '';
            document.getElementById('edit_gaming').value = paket.gaming || '';
            document.getElementById('edit_features').value = paket.features || '';
            document.getElementById('edit_status').value = paket.status || 1;
            
            // Show modal
            const modalEl = document.getElementById('modalEditPaket');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            } else {
                alert('❌ Modal edit tidak ditemukan!');
            }
        })
        .catch(err => {
            console.error('Error loading paket for edit:', err);
            alert('❌ Gagal memuat data paket: ' + err.message);
        });
}

// ===== UPDATE PAKET =====
function updatePaket() {
    console.log('updatePaket() called');
    
    const id = document.getElementById('edit_id')?.value;
    const nama = document.getElementById('edit_nama')?.value || '';
    const kecepatan = document.getElementById('edit_kecepatan')?.value || '';
    const sumatera = document.getElementById('edit_sumatera')?.value || '0';
    const jawa = document.getElementById('edit_jawa')?.value || '0';
    const timur = document.getElementById('edit_timur')?.value || '0';
    const instalasi_sumatera = document.getElementById('edit_instalasi_sumatera')?.value || '345000';
    const instalasi_jawa = document.getElementById('edit_instalasi_jawa')?.value || '150000';
    const instalasi_timur = document.getElementById('edit_instalasi_timur')?.value || '200000';
    const max_perangkat = document.getElementById('edit_max_perangkat')?.value || '4';
    const max_laptop = document.getElementById('edit_max_laptop')?.value || '2';
    const max_smartphone = document.getElementById('edit_max_smartphone')?.value || '2';
    const tv_4k = document.getElementById('edit_tv_4k')?.value || '';
    const streaming = document.getElementById('edit_streaming')?.value || '';
    const gaming = document.getElementById('edit_gaming')?.value || '';
    const features = document.getElementById('edit_features')?.value || '';
    const status = document.getElementById('edit_status')?.value || '1';

    if (!id || !nama.trim() || !sumatera || !jawa || !timur) {
        alert('❌ Mohon lengkapi semua field wajib!');
        return;
    }

    const data = {
        id: parseInt(id),
        nama: nama.trim(),
        kecepatan: kecepatan.trim(),
        sumatera: parseInt(sumatera) || 0,
        jawa: parseInt(jawa) || 0,
        timur: parseInt(timur) || 0,
        instalasi_sumatera: parseInt(instalasi_sumatera) || 345000,
        instalasi_jawa: parseInt(instalasi_jawa) || 150000,
        instalasi_timur: parseInt(instalasi_timur) || 200000,
        max_perangkat: parseInt(max_perangkat) || 4,
        max_laptop: parseInt(max_laptop) || 2,
        max_smartphone: parseInt(max_smartphone) || 2,
        tv_4k: tv_4k.trim(),
        streaming: streaming.trim(),
        gaming: gaming.trim(),
        features: features.trim(),
        status: parseInt(status) || 1
    };

    console.log('Updating paket:', data);

    fetch('../api/paket.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(result => {
        console.log('Update response:', result);
        if (result.success) {
            alert('✅ Paket berhasil diupdate!');
            loadPaket();
            
            const modalEl = document.getElementById('modalEditPaket');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
        } else {
            alert('❌ Gagal mengupdate paket: ' + (result.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('Error updating paket:', err);
        alert('❌ Terjadi kesalahan: ' + err.message);
    });
}

// ===== DELETE PAKET =====
function deletePaket(id, nama) {
    if (!confirm(`⚠️ Apakah Anda yakin ingin menghapus paket "${nama}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        return;
    }

    fetch('../api/paket.php', {
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

// ===== INITIALIZE =====
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Kelola Paket Script Loaded');
    
    // Load data awal
    loadPaket();
    
    // Auto refresh setiap 30 detik
    setInterval(loadPaket, 30000);
    
    console.log('✅ Ready!');
});