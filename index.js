// index.js - Load Data dari Database untuk Homepage

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
    
    // GUNAKAN api_paket.php yang sudah ada di root folder
    const API_URL = 'api_paket.php';
    
    console.log('🔗 Fetching from:', API_URL);
    
    fetch(API_URL)
        .then(response => {
            console.log('📥 Response status:', response.status);
            console.log('📥 Response OK:', response.ok);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Raw data received:', data);
            console.log('✅ Data type:', typeof data);
            console.log('✅ Is Array:', Array.isArray(data));
            
            // Check if data is valid
            if (!data) {
                console.error('❌ Data is null or undefined');
                showNoDataMessage();
                return;
            }
            
            // If data has 'success' property, it might be an error response
            if (data.success === false) {
                console.error('❌ API returned error:', data.error || data.message);
                showErrorMessage(data.error || data.message || 'Unknown error');
                return;
            }
            
            // Check if data is empty array
            if (Array.isArray(data) && data.length === 0) {
                console.warn('⚠️ No paket data found (empty array)');
                showNoDataMessage();
                return;
            }
            
            // Store data
            paketData = data;
            console.log('✅ Paket data stored:', paketData.length, 'items');
            
            // Render cards
            renderPaketCards();
            setupLocationSelector();
        })
        .catch(error => {
            console.error('❌ Error loading paket:', error);
            console.error('❌ Error details:', error.message);
            showErrorMessage(error.message);
        });
}

// ==================== RENDER PAKET CARDS ====================
function renderPaketCards() {
    console.log('🎨 Starting to render paket cards...');
    console.log('🎨 Number of packages:', paketData.length);
    
    const carouselInner = document.querySelector('#packageCarousel .carousel-inner');
    
    if (!carouselInner) {
        console.error('❌ Carousel container (#packageCarousel .carousel-inner) not found!');
        return;
    }
    
    console.log('✅ Carousel container found');
    
    // Clear existing content
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
        
        // Create row
        const row = document.createElement('div');
        row.className = 'row card-group-row';
        
        // Add package cards to row
        slidePackages.forEach((paket, idx) => {
            console.log(`  📦 Adding package ${idx + 1}:`, paket.name || paket.nama);
            const col = document.createElement('div');
            col.className = 'col-md-4 mb-4';
            col.innerHTML = createPackageCard(paket);
            row.appendChild(col);
        });
        
        carouselItem.appendChild(row);
        carouselInner.appendChild(carouselItem);
        slideCount++;
    }
    
    console.log(`✅ Successfully rendered ${paketData.length} packages in ${slideCount} slides`);
    
    // Update prices for current location
    setTimeout(() => {
        updatePricesByLocation();
    }, 100);
}

// ==================== CREATE PACKAGE CARD HTML ====================
function createPackageCard(paket) {
    const packageName = paket.name || paket.nama || 'ICONNET Package';
    const packageId = packageName.toLowerCase().replace(/\s+/g, '');
    const kecepatan = paket.kecepatan || 'High Speed Internet';
    const maxPerangkat = paket.max_perangkat || 4;
    const maxLaptop = paket.max_laptop || 2;
    const maxSmartphone = paket.max_smartphone || 2;
    
    // Pastikan harga ada dan valid
    const hargaSumatera = paket.harga_sumatera || 0;
    const hargaJawa = paket.harga_jawa || 0;
    const hargaTimur = paket.harga_timur || 0;
    const instalasiSumatera = paket.instalasi_sumatera || 345000;
    const instalasiJawa = paket.instalasi_jawa || 150000;
    const instalasiTimur = paket.instalasi_timur || 200000;
    
    return `
        <div class="package-card" 
             data-package-id="${packageId}"
             data-harga-sumatera="${hargaSumatera}"
             data-harga-jawa="${hargaJawa}"
             data-harga-timur="${hargaTimur}"
             data-instalasi-sumatera="${instalasiSumatera}"
             data-instalasi-jawa="${instalasiJawa}"
             data-instalasi-timur="${instalasiTimur}">
            
            <div class="text-center package-rating">
                <span class="rating-badge">★★ 4.5</span>
                <small>(1,500+ reviews)</small>
            </div>
            
            <h4 class="text-center mb-3">${packageName}</h4>
            
            <div class="package-specs">
                <p><i class="fas fa-tachometer-alt me-2"></i>${kecepatan}</p>
                <p><i class="fas fa-laptop me-2"></i>${maxLaptop} Laptop</p>
                <p><i class="fas fa-mobile-alt me-2"></i>${maxSmartphone} Smartphone</p>
                <p><i class="fas fa-wifi me-2"></i>${maxPerangkat} Total Devices</p>
            </div>
            
            <small class="d-block mt-3">Biaya Bulanan</small>
            <div class="package-price price-abonemen">${formatRupiah(hargaSumatera)}</div>

            <small class="d-block mt-3">Biaya Instalasi</small>
            <div class="package-price price-instalasi">${formatRupiah(instalasiSumatera)}</div>

            <button class="btn btn-primary btn-pilih mt-3">Pesan Sekarang →</button>
        </div>
    `;
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
        let hargaInstalasi = 0;
        
        // Get prices based on location
        switch(currentLocation) {
            case 'sumatera-kalimantan':
                hargaBulanan = card.dataset.hargaSumatera;
                hargaInstalasi = card.dataset.instalasiSumatera;
                break;
            case 'jawa-bali':
                hargaBulanan = card.dataset.hargaJawa;
                hargaInstalasi = card.dataset.instalasiJawa;
                break;
            case 'indonesia-timur':
                hargaBulanan = card.dataset.hargaTimur;
                hargaInstalasi = card.dataset.instalasiTimur;
                break;
        }
        
        console.log(`  Card ${index + 1}: Bulanan=${hargaBulanan}, Instalasi=${hargaInstalasi}`);
        
        // Update display
        const abonemenEl = card.querySelector('.price-abonemen');
        const instalasiEl = card.querySelector('.price-instalasi');
        
        if (abonemenEl) {
            abonemenEl.textContent = formatRupiah(hargaBulanan);
        }
        
        if (instalasiEl) {
            instalasiEl.textContent = formatRupiah(hargaInstalasi);
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
    
    // Remove existing listeners (prevent duplicates)
    locationItems.forEach(item => {
        const newItem = item.cloneNode(true);
        item.parentNode.replaceChild(newItem, item);
    });
    
    // Re-query after cloning
    const newLocationItems = document.querySelectorAll('.location-item');
    
    newLocationItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const newLocation = this.getAttribute('data-location');
            const locationName = this.textContent.trim();
            
            console.log('📍 Location clicked:', newLocation);
            
            // Update current location
            currentLocation = newLocation;
            
            // Update display text
            if (selectedLocationText) {
                selectedLocationText.textContent = locationName;
            }
            
            // Update all prices
            updatePricesByLocation();
            
            // Close dropdown
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
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <h4>Tidak dapat memuat data paket</h4>
                            <p class="mb-3">${errorMsg || 'Terjadi kesalahan saat memuat data'}</p>
                            <button class="btn btn-primary" onclick="location.reload()">
                                <i class="fas fa-refresh me-2"></i>Refresh Halaman
                            </button>
                        </div>
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
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h4>Belum ada paket tersedia</h4>
                            <p>Silakan tambahkan paket melalui halaman admin</p>
                            <a href="admin/kelola_paket.php" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>Tambah Paket
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}