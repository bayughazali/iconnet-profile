// index.js - FIXED VERSION - Load Data dari Database untuk Homepage

// ==================== LOAD DATA SAAT HALAMAN DIMUAT ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Index.php loaded, fetching data from database...');
    loadPaketFromDatabase();
    setupLocationDropdown(); // ✅ TAMBAH INI
});

// ==================== GLOBAL VARIABLES ====================
let paketData = [];
let currentLocation = 'sumatera'; // ✅ GANTI dari 'sumatera-kalimantan' ke 'sumatera'

// ==================== FORMAT RUPIAH ====================
function formatRupiah(angka) {
    if (!angka) return 'Rp. 0';
    return 'Rp. ' + parseInt(angka).toLocaleString('id-ID');
}

// ==================== SETUP LOCATION DROPDOWN - FIXED ====================
function setupLocationDropdown() {
    console.log('🎯 Setting up location dropdown...');
    
    const dropdownBtn = document.querySelector('.custom-dropdown-toggle');
    const dropdownList = document.querySelector('.location-options-list');
    const locationItems = document.querySelectorAll('.location-item');
    
    if (!dropdownBtn || !dropdownList) {
        console.error('❌ Dropdown elements not found!');
        return;
    }
    
    // Toggle dropdown saat button diklik
    dropdownBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const isOpen = dropdownList.style.display === 'block';
        dropdownList.style.display = isOpen ? 'none' : 'block';
        
        console.log('🔽 Dropdown toggled:', !isOpen ? 'OPEN' : 'CLOSED');
    });
    
    // Handle klik pada setiap lokasi
    locationItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const locationText = this.textContent.trim();
            console.log('📍 Location clicked:', locationText);
            
            // Tentukan region berdasarkan teks
            if (locationText.includes('Sumatera')) {
                currentLocation = 'sumatera';
            } else if (locationText.includes('Jawa')) {
                currentLocation = 'jawa';
            } else if (locationText.includes('Timur')) {
                currentLocation = 'timur';
            }
            
            console.log('🌍 Current location set to:', currentLocation);
            
            // Update button text
            const buttonText = dropdownBtn.querySelector('span');
            if (buttonText) {
                buttonText.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${locationText}`;
            }
            
            // Tutup dropdown
            dropdownList.style.display = 'none';
            
            // Update harga
            updatePricesByLocation();
        });
    });
    
    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(e) {
        if (!dropdownBtn.contains(e.target) && !dropdownList.contains(e.target)) {
            dropdownList.style.display = 'none';
        }
    });
    
    console.log('✅ Location dropdown setup complete');
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
            console.log('📊 First package data:', paketData[0]);
            
            renderPaketCards();
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
        
        // Create card-group-row
        const cardGroupRow = document.createElement('div');
        cardGroupRow.className = 'card-group-row';
        
        // Add package cards
        slidePackages.forEach((paket, idx) => {
            console.log(`  📦 Adding package ${idx + 1}:`, paket.name || paket.nama);
            console.log(`  💰 Prices - Sumatera: ${paket.harga_sumatera}, Jawa: ${paket.harga_jawa}, Timur: ${paket.harga_timur}`);
            
            const packageCard = createPackageCardElement(paket);
            cardGroupRow.appendChild(packageCard);
        });
        
        carouselItem.appendChild(cardGroupRow);
        carouselInner.appendChild(carouselItem);
        slideCount++;
    }
    
    console.log(`✅ Successfully rendered ${paketData.length} packages in ${slideCount} slides`);
    
    // Update prices setelah render
    setTimeout(() => {
        updatePricesByLocation();
    }, 100);
}

// ==================== CREATE PACKAGE CARD ELEMENT - FIXED ====================
function createPackageCardElement(paket) {
    const card = document.createElement('div');
    card.className = 'package-card';

    // ✅ PENTING: Simpan data harga di dataset dengan nama yang benar
    card.dataset.sumatera = paket.harga_sumatera || 0;
    card.dataset.jawa = paket.harga_jawa || 0;
    card.dataset.timur = paket.harga_timur || 0;
    
    card.dataset.sumateraBefore = paket.harga_sumatera_before || 0;
    card.dataset.jawaBefore = paket.harga_jawa_before || 0;
    card.dataset.timurBefore = paket.harga_timur_before || 0;

    console.log('🏷️ Card dataset created:', {
        sumatera: card.dataset.sumatera,
        jawa: card.dataset.jawa,
        timur: card.dataset.timur
    });

    card.innerHTML = `
        <h4>${paket.name}</h4>

        <div class="package-specs">
            <p><i class="fas fa-wifi"></i> ${paket.kecepatan}</p>
            <p><i class="fas fa-laptop"></i> ${paket.max_laptop} Laptop</p>
            <p><i class="fas fa-mobile-alt"></i> ${paket.max_smartphone} Smartphone</p>
            <p><i class="fas fa-network-wired"></i> ${paket.max_perangkat} Total Devices</p>
        </div>

        <div class="package-price"></div>

        <small>Biaya Bulanan</small>

        <button type="button" class="btn-pilih">
            Pesan Sekarang →
        </button>

        <small class="d-block mt-1">*Harga sudah termasuk PPN</small>
    `;

    return card;
}

// ==================== UPDATE PRICES BY LOCATION - FIXED ====================
function updatePricesByLocation() {
    console.log('💰 Updating prices for location:', currentLocation);
    
    const cards = document.querySelectorAll('.package-card');
    console.log('📋 Found', cards.length, 'package cards');
    
    cards.forEach((card, index) => {
        let before = 0;
        let after = 0;

        // ✅ AMBIL DATA BERDASARKAN LOKASI YANG BENAR
        if (currentLocation === 'sumatera') {
            before = card.dataset.sumateraBefore || 0;
            after = card.dataset.sumatera || 0;
        } 
        else if (currentLocation === 'jawa') {
            before = card.dataset.jawaBefore || 0;
            after = card.dataset.jawa || 0;
        } 
        else if (currentLocation === 'timur') {
            before = card.dataset.timurBefore || 0;
            after = card.dataset.timur || 0;
        }

        console.log(`📦 Card ${index + 1} - Location: ${currentLocation}, Before: ${before}, After: ${after}`);

        const priceEl = card.querySelector('.package-price');
        if (priceEl) {
            priceEl.innerHTML = hargaView(before, after);
            console.log(`✅ Price updated for card ${index + 1}`);
        } else {
            console.error(`❌ Price element not found for card ${index + 1}`);
        }
    });
    
    console.log('✅ All prices updated');
}

// ==================== HARGA VIEW (CORET + AFTER) ====================
const hargaView = (before, after) => {
    before = parseInt(before) || 0;
    after = parseInt(after) || 0;
    
    console.log('🎨 Rendering price view - Before:', before, 'After:', after);
    
    if (before > 0 && before > after) {
        return `
            <div style="text-decoration:line-through;color:#9ca3af;font-size:16px;">
                Rp ${before.toLocaleString('id-ID')}
            </div>
            <div style="font-size:28px;font-weight:700;color:#14b8a6;">
                Rp ${after.toLocaleString('id-ID')}
            </div>
        `;
    }
    
    return `
        <div style="font-size:28px;font-weight:700;color:#14b8a6;">
            Rp ${after.toLocaleString('id-ID')}
        </div>
    `;
};

// ==================== MODAL PESAN SEKARANG ====================
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalPesan');
    const modalNama = document.getElementById('modalNama');
    const modalKecepatan = document.getElementById('modalKecepatan');
    const modalHarga = document.getElementById('modalHarga');
    const btnWhatsapp = document.getElementById('btnWhatsapp');

    document.addEventListener('click', e => {
        const btn = e.target.closest('.btn-pilih');
        if (!btn) return;

        const card = btn.closest('.package-card');
        if (!card) return;

        const nama = card.querySelector('h4')?.textContent || '';
        const kecepatan = card.querySelector('.package-specs p')?.textContent || '';

        let before = 0;
        let after = 0;

        if (currentLocation === 'sumatera') {
            before = card.dataset.sumateraBefore;
            after = card.dataset.sumatera;
        } else if (currentLocation === 'jawa') {
            before = card.dataset.jawaBefore;
            after = card.dataset.jawa;
        } else if (currentLocation === 'timur') {
            before = card.dataset.timurBefore;
            after = card.dataset.timur;
        }

        modalNama.textContent = nama;
        modalKecepatan.textContent = kecepatan;
        modalHarga.textContent = formatRupiah(after);

        btnWhatsapp.dataset.text =
`Halo, saya ingin pesan paket ${nama}
${kecepatan}
Harga: ~${formatRupiah(before)}~
Menjadi ${formatRupiah(after)}`;

        modal.classList.add('show');
    });

    document.querySelector('.modal-close')?.addEventListener('click', () => {
        modal.classList.remove('show');
    });

    btnWhatsapp?.addEventListener('click', () => {
        const nomorWA = '6289502434324';
        const text = encodeURIComponent(btnWhatsapp.dataset.text);
        window.open(`https://wa.me/${nomorWA}?text=${text}`, '_blank');
    });
});

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