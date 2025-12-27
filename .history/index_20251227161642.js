// index.js - Load Data dari Database untuk Homepage - FIXED

// ==================== LOAD DATA SAAT HALAMAN DIMUAT ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Index.php loaded, fetching data from database...');
    loadPaketFromDatabase();
});

// ==================== GLOBAL VARIABLES ====================
let paketData = [];
let currentLocation = 'sumatera-kalimantan';

// ==================== FORMAT RUPIAH ====================
function formatRupiah(angka) {
    if (!angka) return 'Rp. 0';
    return 'Rp. ' + parseInt(angka).toLocaleString('id-ID');
}

// ==================== LOAD PAKET FROM DATABASE ====================
function loadPaketFromDatabase() {
    console.log('📦 Loading paket from database...');
    
    const API_URL = 'api_paket.php';
    console.log('🔗 Fetching from:', API_URL);
    
    fetch(API_URL)
        .then(response => {
            console.log('📥 Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Raw data received:', data);
            
            if (!data) {
                console.error('❌ Data is null or undefined');
                showNoDataMessage();
                return;
            }
            
            if (data.success === false) {
                console.error('❌ API returned error:', data.error || data.message);
                showErrorMessage(data.error || data.message || 'Unknown error');
                return;
            }
            
            if (Array.isArray(data) && data.length === 0) {
                console.warn('⚠️ No paket data found (empty array)');
                showNoDataMessage();
                return;
            }
            
            paketData = data;
            console.log('✅ Paket data stored:', paketData.length, 'items');
            
            renderPaketCards();
            setupLocationSelector();
        })
        .catch(error => {
            console.error('❌ Error loading paket:', error);
            showErrorMessage(error.message);
        });
}

// ==================== RENDER PAKET CARDS - FIXED ====================
function renderPaketCards() {
    console.log('🎨 Starting to render paket cards...');
    console.log('🎨 Number of packages:', paketData.length);
    
    const carouselInner = document.querySelector('#packageCarousel .carousel-inner');
    
    if (!carouselInner) {
        console.error('❌ Carousel container not found!');
        return;
    }
    
    console.log('✅ Carousel container found');
    carouselInner.innerHTML = '';
    
    // Group packages: 3 per slide
    const packagesPerSlide = 3;
    let slideCount = 0;
    
    for (let i = 0; i < paketData.length; i += packagesPerSlide) {
        const slidePackages = paketData.slice(i, i + packagesPerSlide);
        const isActive = slideCount === 0 ? 'active' : '';
        
        console.log(`📄 Creating slide ${slideCount + 1} with ${slidePackages.length} packages`);
        
        // Create carousel item
        const carouselItem = document.createElement('div');
        carouselItem.className = `carousel-item ${isActive}`;
        
        // ✅ FIX: Create card-group-row WITHOUT "row" class
        const cardGroupRow = document.createElement('div');
        cardGroupRow.className = 'card-group-row';
        
        // ✅ FIX: Add package cards DIRECTLY (no col wrapper)
        slidePackages.forEach((paket, idx) => {
            console.log(`  📦 Adding package ${idx + 1}:`, paket.name || paket.nama);
            const packageCard = createPackageCardElement(paket);
            cardGroupRow.appendChild(packageCard);
        });
        
        carouselItem.appendChild(cardGroupRow);
        carouselInner.appendChild(carouselItem);
        slideCount++;
    }
    
    console.log(`✅ Successfully rendered ${paketData.length} packages in ${slideCount} slides`);
    
    setTimeout(() => {
        updatePricesByLocation();
    }, 100);
}

// ==================== CREATE PACKAGE CARD ELEMENT - FIXED ====================
function createPackageCardElement(paket) {

    const card = document.createElement('div');
    card.className = 'package-card';

    // ===== DATASET HARGA =====
    card.dataset.hargaSumatera = paket.harga_sumatera;
    card.dataset.hargaJawa     = paket.harga_jawa;
    card.dataset.hargaTimur    = paket.harga_timur;

    card.dataset.hargaSumateraBefore = paket.harga_sumatera_before;
    card.dataset.hargaJawaBefore     = paket.harga_jawa_before;
    card.dataset.hargaTimurBefore    = paket.harga_timur_before;

    card.innerHTML = `
        <h4>${paket.name}</h4>

        <div class="package-specs">
            <p><i class="fas fa-wifi"></i> ${paket.kecepatan}</p>
            <p><i class="fas fa-laptop"></i> ${paket.max_laptop} Laptop</p>
            <p><i class="fas fa-mobile-alt"></i> ${paket.max_smartphone} Smartphone</p>
            <p><i class="fas fa-network-wired"></i> ${paket.max_perangkat} Total Devices</p>
        </div>

        <!-- 🔥 HARGA PROMO -->
        <div class="package-price price-abonemen"></div>

        <small>Biaya Bulanan</small>

        <!-- 🔴 BUTTON TARUH DI SINI -->
        <button type="button" class="btn-pilih">
        Pesan Sekarang →
        </button>


        </div>

        <small>*Harga sudah termasuk PPN</small>
    `;

    return card;
}



// ==================== UPDATE PRICES BY LOCATION ====================
function updatePricesByLocation() {

    


    document.querySelectorAll('.package-card').forEach(card => {
        

        let before = 0;
        let after  = 0;

        if (currentLocation === 'sumatera-kalimantan') {
            before = card.dataset.hargaSumateraBefore;
            after  = card.dataset.hargaSumatera;
        } 
        else if (currentLocation === 'jawa-bali') {
            before = card.dataset.hargaJawaBefore;
            after  = card.dataset.hargaJawa;
        } 
        else if (currentLocation === 'indonesia-timur') {
            before = card.dataset.hargaTimurBefore;
            after  = card.dataset.hargaTimur;
        }

        // 🔍 DEBUG (INI YANG KITA CEK)
        console.log({
            before,
            after,
            location: currentLocation
        });

        const el = card.querySelector('.price-abonemen');
        if (el) {
            el.innerHTML = hargaView(before, after);
        }
    });
}



// ==================== SETUP LOCATION SELECTOR ====================
function setupLocationSelector() {
    const locationItems = document.querySelectorAll('.location-item');
    const selectedLocationText = document.getElementById('selected-location-text');
    
    if (locationItems.length === 0) {
        console.warn('⚠️ Location selector items not found');
        return;
    }
    
    console.log(`✅ Found ${locationItems.length} location items`);
    
    locationItems.forEach(item => {
        const newItem = item.cloneNode(true);
        item.parentNode.replaceChild(newItem, item);
    });
    
    const newLocationItems = document.querySelectorAll('.location-item');
    
    newLocationItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const newLocation = this.getAttribute('data-location');
            const locationName = this.textContent.trim();
            
            console.log('📍 Location clicked:', newLocation);
            
            currentLocation = newLocation;
            
            if (selectedLocationText) {
                selectedLocationText.textContent = locationName;
            }
            
            updatePricesByLocation();
            
            const collapseElement = document.getElementById('locationOptions');
            if (collapseElement && typeof bootstrap !== 'undefined') {
                const bsCollapse = bootstrap.Collapse.getInstance(collapseElement);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    });
    
    console.log('✅ Location selector initialized');
}

// ==================== SHOW ERROR MESSAGE ====================
function showErrorMessage(errorMsg) {
    const carouselInner = document.querySelector('#packageCarousel .carousel-inner');
    if (carouselInner) {
        carouselInner.innerHTML = `
            <div class="carousel-item active">
                <div class="card-group-row" style="justify-content: center;">
                    <div style="background: white; padding: 40px; border-radius: 12px; text-align: center; max-width: 600px;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #dc3545; margin-bottom: 20px;"></i>
                        <h4 style="color: #dc3545; margin-bottom: 15px;">Tidak dapat memuat data paket</h4>
                        <p style="color: #6c757d; margin-bottom: 20px;">${errorMsg || 'Terjadi kesalahan saat memuat data'}</p>
                        <button class="btn-pilih" onclick="location.reload()" style="background: #dc3545;">
                            <i class="fas fa-refresh"></i> Refresh Halaman
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
}

// ==================== SHOW NO DATA MESSAGE ====================
function showNoDataMessage() {
    const carouselInner = document.querySelector('#packageCarousel .carousel-inner');
    if (carouselInner) {
        carouselInner.innerHTML = `
            <div class="carousel-item active">
                <div class="card-group-row" style="justify-content: center;">
                    <div style="background: white; padding: 40px; border-radius: 12px; text-align: center; max-width: 600px;">
                        <i class="fas fa-info-circle" style="font-size: 3rem; color: #17a2b8; margin-bottom: 20px;"></i>
                        <h4 style="color: #17a2b8; margin-bottom: 15px;">Belum ada paket tersedia</h4>
                        <p style="color: #6c757d; margin-bottom: 20px;">Silakan tambahkan paket melalui halaman admin</p>
                        <a href="admin/kelola_paket.php" class="btn-pilih" style="text-decoration: none;">
                            <i class="fas fa-plus"></i> Tambah Paket
                        </a>
                    </div>
                </div>
            </div>
        `;
    }
}

// ===== HELPER VIEW HARGA =====
const hargaView = (before, after) => {
    if (Number(before) >= Number(after)) {
        return `
            <div style="text-decoration:line-through;color:#9ca3af">
                Rp ${Number(before).toLocaleString('id-ID')}
            </div>
            <div style="font-size:28px;font-weight:700;color:#14b8a6">
                Rp ${Number(after).toLocaleString('id-ID')}
            </div>
        `;
    }

    return `
        <div style="font-size:28px;font-weight:700;color:#14b8a6">
            Rp ${Number(after).toLocaleString('id-ID')}
        </div>
    `;
};



// data.forEach(paket => {

//     const card = document.createElement('div');
//     card.className = 'package-card';

//     const priceEl = document.createElement('div');
//     priceEl.className = 'package-price';

//     let before = 0;
//     let after  = 0;

//     if (lokasi === 'sumatera-kalimantan') {
//         before = paket.harga_sumatera_before;
//         after  = paket.harga_sumatera;
//     } 
//     else if (lokasi === 'jawa-bali') {
//         before = paket.harga_jawa_before;
//         after  = paket.harga_jawa;
//     } 
//     else if (lokasi === 'indonesia-timur') {
//         before = paket.harga_timur_before;
//         after  = paket.harga_timur;
//     }

//     priceEl.innerHTML = hargaView(before, after);

//     card.innerHTML = `
//         <h4>${paket.name}</h4>
//         <div class="package-specs">
//             <p>${paket.kecepatan}</p>
//             <p>${paket.max_laptop} Laptop</p>
//             <p>${paket.max_smartphone} Smartphone</p>
//         </div>
//     `;

//     card.appendChild(priceEl);
//     container.appendChild(card);
// });

// ==================== MODAL PESAN SEKARANG ====================
document.addEventListener('DOMContentLoaded', () => {

  const modal = document.getElementById('modalPesan');
  const modalNama = document.getElementById('modalNama');
  const modalKecepatan = document.getElementById('modalKecepatan');
  const modalHarga = document.getElementById('modalHarga');
  const btnWhatsapp = document.getElementById('btnWhatsapp');

  document.addEventListener('click', e => {
    if (!e.target.classList.contains('btn-pilih')) return;

    const card = e.target.closest('.package-card');
    if (!card) return;

    modalNama.textContent = card.querySelector('h4')?.textContent || '';
    modalKecepatan.textContent = card.querySelector('.package-specs p')?.textContent || '';
    modalHarga.textContent = card.querySelector('.price-abonemen')?.innerText || '';

    btnWhatsapp.dataset.text =
      `Halo, saya ingin pesan paket ${modalNama.textContent}
${modalKecepatan.textContent}
Harga : ${modalHarga.textContent}`;

    modal.classList.add('show');
  });

  document.querySelector('.modal-close')?.addEventListener('click', () => {
    modal.classList.remove('show');
  });

  btnWhatsapp?.addEventListener('click', () => {
    const nomorWA = '6289502434324'; // GANTI JIKA PERLU
    const text = encodeURIComponent(btnWhatsapp.dataset.text || '');
    window.open(`https://wa.me/${nomorWA}?text=${text}`, '_blank');
  });

});


document.addEventListener('DOMContentLoaded', () => {
  renderHarga('sumatera-kalimantan');

  document.querySelectorAll('.location-item').forEach(item => {
    item.addEventListener('click', () => {
      const lokasi = item.dataset.location;
      document.getElementById('selected-location-text').innerText = item.innerText;
      renderHarga(lokasi);
    });
  });
});

document.querySelectorAll('.btn-pilih').forEach(btn => {
  btn.addEventListener('click', () => {
    const card = btn.closest('.package-card');

    const nama = card.dataset.nama;
    const kecepatan = card.dataset.kecepatan;
    const harga = card.dataset.harga;

    // isi modal
  });
});

document.addEventListener('DOMContentLoaded', () => {

  const modal = document.getElementById('modalPesan');
  const modalNama = document.getElementById('modalNama');
  const modalKecepatan = document.getElementById('modalKecepatan');
  const modalHarga = document.getElementById('modalHarga');
  const btnWhatsapp = document.getElementById('btnWhatsapp');

  document.querySelectorAll('.btn-pilih').forEach(btn => {
    btn.addEventListener('click', () => {
      const card = btn.closest('.package-card');

      if (!card) {
        console.error('package-card tidak ditemukan');
        return;
      }

      modalNama.textContent = card.dataset.nama;
      modalKecepatan.textContent = card.dataset.kecepatan;
      modalHarga.textContent = 'Rp ' + Number(card.dataset.harga).toLocaleString('id-ID');

      btnWhatsapp.dataset.text =
        `Halo, saya ingin pesan paket ${card.dataset.nama}
Kecepatan: ${card.dataset.kecepatan}
Harga: Rp ${Number(card.dataset.harga).toLocaleString('id-ID')}`;

      modal.classList.add('show');
    });
  });

  document.querySelector('.modal-close').onclick = () => {
    modal.classList.remove('show');
  };

  btnWhatsapp.onclick = () => {
    const nomorWA = '6281252519535'; // GANTI
    const text = encodeURIComponent(btnWhatsapp.dataset.text);
    window.open(`https://wa.me/${nomorWA}?text=${text}`, '_blank');
  };

});

document.addEventListener('click', e => {
  if (e.target.classList.contains('btn-pilih')) {
    alert('BUTTON TERKLIK');
  }
});
