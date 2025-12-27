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
    const packageName = paket.name || paket.nama || 'ICONNET Package';
    const packageId = packageName.toLowerCase().replace(/\s+/g, '');
    const kecepatan = paket.kecepatan || 'High Speed Internet';
    const maxPerangkat = paket.max_perangkat || 4;
    const maxLaptop = paket.max_laptop || 2;
    const maxSmartphone = paket.max_smartphone || 2;
    
    const hargaSumatera = paket.harga_sumatera || 0;
    const hargaJawa = paket.harga_jawa || 0;
    const hargaTimur = paket.harga_timur || 0;
    const instalasiSumatera = paket.instalasi_sumatera || 345000;
    const instalasiJawa = paket.instalasi_jawa || 150000;
    const instalasiTimur = paket.instalasi_timur || 200000;
    
    // ✅ CREATE DOM ELEMENT instead of HTML string
    const card = document.createElement('div');
    card.className = 'package-card';
    card.setAttribute('data-package-id', packageId);
    card.setAttribute('data-harga-sumatera', hargaSumatera);
    card.setAttribute('data-harga-jawa', hargaJawa);
    card.setAttribute('data-harga-timur', hargaTimur);
    card.setAttribute('data-instalasi-sumatera', instalasiSumatera);
    card.setAttribute('data-instalasi-jawa', instalasiJawa);
    card.setAttribute('data-instalasi-timur', instalasiTimur);
    
    card.innerHTML = `
        <h4>${packageName}</h4>

        <div class="package-rating">
            <span class="rating-badge">★★ 4.5</span>
            <small>(1,500+ reviews)</small>
        </div>

        <div class="package-specs">
            <p><i class="fas fa-wifi"></i> ${kecepatan}</p>
            <p><i class="fas fa-laptop"></i> ${maxLaptop} Laptop</p>
            <p><i class="fas fa-mobile-alt"></i> ${maxSmartphone} Smartphone</p>
            <p><i class="fas fa-network-wired"></i> ${maxPerangkat} Total Devices</p>
        </div>

        <div class="package-price price-abonemen"></div>

        <div class="package-price price-abonemen">
            ${hargaView(
                paket.harga_sumatera_before,
                paket.harga_sumatera
            )}
        </div>

        <small>Biaya Bulanan</small>

        <button class="btn-pilih">Pesan Sekarang →</button>
        <small>*Harga sudah termasuk PPN</small>
    `; 
    return card;
}

// ==================== UPDATE PRICES BY LOCATION ====================
function updatePricesByLocation() {
    console.log('📍 Updating prices for location:', currentLocation);
    
    const packageCards = document.querySelectorAll('.package-card');
    
    if (packageCards.length === 0) {
        console.warn('⚠️ No package cards found to update');
        return;
    }
    
    console.log(`📍 Found ${packageCards.length} cards to update`);
    
    packageCards.forEach((card, index) => {
        let hargaBulanan = 0;
        
        switch(currentLocation) {
            case 'sumatera-kalimantan':
                hargaBulanan = card.dataset.hargaSumatera;
                break;
            case 'jawa-bali':
                hargaBulanan = card.dataset.hargaJawa;
                break;
            case 'indonesia-timur':
                hargaBulanan = card.dataset.hargaTimur;
                break;
        }
        
        console.log(`  Card ${index + 1}: Bulanan=${hargaBulanan}`);
        
        const abonemenEl = card.querySelector('.price-abonemen');
        if (abonemenEl) {
            abonemenEl.textContent = formatRupiah(hargaBulanan);
        }
    });
    
    console.log('✅ Prices updated successfully');
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
  if (before && before > after) {
    return `
      <div class="text-muted text-decoration-line-through small">
        Rp ${Number(before).toLocaleString('id-ID')}
      </div>
      <div class="fw-bold text-primary fs-5">
        Rp ${Number(after).toLocaleString('id-ID')}
      </div>
    `;
  }

  return `
    <div class="fw-bold text-primary fs-5">
      Rp ${Number(after).toLocaleString('id-ID')}
    </div>
  `;
};

data.forEach(paket => {

    const card = document.createElement('div');
    card.className = 'package-card';

    const priceEl = document.createElement('div');
    priceEl.className = 'package-price';

    let before = 0;
    let after  = 0;

    if (lokasi === 'sumatera-kalimantan') {
        before = paket.harga_sumatera_before;
        after  = paket.harga_sumatera;
    } 
    else if (lokasi === 'jawa-bali') {
        before = paket.harga_jawa_before;
        after  = paket.harga_jawa;
    } 
    else if (lokasi === 'indonesia-timur') {
        before = paket.harga_timur_before;
        after  = paket.harga_timur;
    }

    priceEl.innerHTML = hargaView(before, after);

    card.innerHTML = `
        <h4>${paket.name}</h4>
        <div class="package-specs">
            <p>${paket.kecepatan}</p>
            <p>${paket.max_laptop} Laptop</p>
            <p>${paket.max_smartphone} Smartphone</p>
        </div>
    `;

    card.appendChild(priceEl);
    container.appendChild(card);
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

