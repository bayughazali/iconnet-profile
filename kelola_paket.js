// ===== GLOBAL VARIABLES =====
let editMode = false;
let editId = null;

// ===== LOAD PAKET DARI DATABASE =====
function loadPaket() {
    fetch('../api/paket.php')
        .then(res => res.json())
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

                // Support field 'name' atau 'nama'
                const namaPaket = p.name || p.nama;

                body.innerHTML += `
                <tr>
                    <td><strong>${namaPaket}</strong><br><small class="text-muted">${p.kecepatan || '-'}</small></td>
                    <td>${formatRupiah(p.harga_sumatera)}</td>
                    <td>${formatRupiah(p.harga_jawa)}</td>
                    <td>${formatRupiah(p.harga_timur)}</td>
                    <td>
                        <span class="badge ${p.status == 1 ? 'bg-success' : 'bg-secondary'}">
                            ${p.status == 1 ? 'Aktif' : 'Nonaktif'}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editPaket(${p.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deletePaket(${p.id}, '${namaPaket}')">
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
                        Gagal memuat data paket. Silakan refresh halaman.
                    </td>
                </tr>`;
        });
}

// ===== TAMBAH PAKET BARU =====
function addPaket() {
    // Ambil nilai dari form
    const nama = document.getElementById('nama').value;
    const kecepatan = document.getElementById('kecepatan')?.value || '';
    const max_perangkat = document.getElementById('max_perangkat')?.value || 0;
    const max_laptop = document.getElementById('max_laptop')?.value || 0;
    const max_smartphone = document.getElementById('max_smartphone')?.value || 0;
    const sumatera = document.getElementById('sumatera').value;
    const jawa = document.getElementById('jawa').value;
    const timur = document.getElementById('timur').value;
    const instalasi_sumatera = document.getElementById('instalasi_sumatera')?.value || '345000';
    const instalasi_jawa = document.getElementById('instalasi_jawa')?.value || '150000';
    const instalasi_timur = document.getElementById('instalasi_timur')?.value || '200000';
    const tv_4k = document.getElementById('tv_4k')?.value || '';
    const streaming = document.getElementById('streaming')?.value || '';
    const gaming = document.getElementById('gaming')?.value || '';
    const features = document.getElementById('features')?.value || '';
    const status = document.getElementById('status').value;

    // Validasi
    if (!nama || !sumatera || !jawa || !timur) {
        alert('❌ Mohon lengkapi field wajib: Nama Paket, Harga Sumatera, Harga Jawa, Harga Timur!');
        return;
    }

    // Prepare data
    const data = {
        nama: nama,
        kecepatan: kecepatan,
        max_perangkat: max_perangkat,
        max_laptop: max_laptop,
        max_smartphone: max_smartphone,
        sumatera: sumatera,
        jawa: jawa,
        timur: timur,
        instalasi_sumatera: instalasi_sumatera,
        instalasi_jawa: instalasi_jawa,
        instalasi_timur: instalasi_timur,
        tv_4k: tv_4k,
        streaming: streaming,
        gaming: gaming,
        features: features,
        status: status
    };

    console.log('Sending data:', data);

    // Send to API
    fetch('../api/paket.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        console.log('Response:', result);
        if (result.success) {
            alert('✅ Paket berhasil ditambahkan!');
            loadPaket();
            
            // Reset form
            document.getElementById('form-paket').reset();
            
            // Tutup modal
            const modalEl = document.getElementById('modalTambahPaket');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
        } else {
            alert('❌ Gagal menambahkan paket: ' + (result.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('Error adding paket:', err);
        alert('❌ Terjadi kesalahan saat menambahkan paket: ' + err.message);
    });
}

// ===== EDIT PAKET =====
function editPaket(id) {
    fetch('../api/paket.php')
        .then(res => res.json())
        .then(data => {
            const paket = data.find(p => p.id == id);
            if (!paket) {
                alert('❌ Paket tidak ditemukan!');
                return;
            }

            // Support field 'name' atau 'nama'
            const namaPaket = paket.name || paket.nama;

            // Isi form edit
            document.getElementById('edit_id').value = paket.id;
            document.getElementById('edit_nama').value = namaPaket;
            document.getElementById('edit_kecepatan').value = paket.kecepatan || '';
            document.getElementById('edit_sumatera').value = paket.harga_sumatera;
            document.getElementById('edit_jawa').value = paket.harga_jawa;
            document.getElementById('edit_timur').value = paket.harga_timur;
            document.getElementById('edit_status').value = paket.status;
            
            // Show modal
            const modalEl = document.getElementById('modalEditPaket');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        })
        .catch(err => {
            console.error('Error loading paket for edit:', err);
            alert('❌ Gagal memuat data paket');
        });
}

// ===== UPDATE PAKET =====
function updatePaket() {
    const id = document.getElementById('edit_id').value;
    const nama = document.getElementById('edit_nama').value;
    const kecepatan = document.getElementById('edit_kecepatan')?.value || '';
    const sumatera = document.getElementById('edit_sumatera').value;
    const jawa = document.getElementById('edit_jawa').value;
    const timur = document.getElementById('edit_timur').value;
    const status = document.getElementById('edit_status').value;

    if (!nama || !sumatera || !jawa || !timur) {
        alert('❌ Mohon lengkapi semua field!');
        return;
    }

    const data = {
        id: id,
        nama: nama,
        kecepatan: kecepatan,
        sumatera: sumatera,
        jawa: jawa,
        timur: timur,
        status: status
    };

    fetch('../api/paket.php', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
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
        alert('❌ Terjadi kesalahan saat mengupdate paket');
    });
}

// ===== DELETE PAKET =====
function deletePaket(id, nama) {
    if (!confirm(`⚠️ Apakah Anda yakin ingin menghapus paket "${nama}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
        return;
    }

    fetch('../api/paket.php', {
        method: 'DELETE',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({id: id})
    })
    .then(res => res.json())
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
        alert('❌ Terjadi kesalahan saat menghapus paket');
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