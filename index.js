// index.js - FIXED VERSION - Button "Pesan Sekarang" Bisa Diklik

// ==================== LOAD DATA SAAT HALAMAN DIMUAT ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Index.php loaded, fetching data from database...');
    loadPaketFromDatabase();
    setupLocationDropdown();
    setupModalPesanSekarang(); // ✅ TAMBAH INI
});

// ==================== GLOBAL VARIABLES ====================
let paketData = [];
let currentLocation = 'sumatera';

// ==================== FORMAT RUPIAH ====================
function formatRupiah(angka) {
    if (!angka) return 'Rp. 0';
    return 'Rp. ' + parseInt(angka).toLocaleString('id-ID');
}

// ==================== SETUP LOCATION DROPDOWN ====================
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

// ==================== RENDER PAKET CARDS ====================
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

// ==================== CREATE PACKAGE CARD ELEMENT ====================
// ==================== CREATE PACKAGE CARD ELEMENT ====================
function createPackageCardElement(paket) {
    const card = document.createElement('div');
    card.className = 'package-card';

    // Simpan data harga di dataset
    card.dataset.sumatera = paket.harga_sumatera || 0;
    card.dataset.jawa = paket.harga_jawa || 0;
    card.dataset.timur = paket.harga_timur || 0;
    
    card.dataset.sumateraBefore = paket.harga_sumatera_before || 0;
    card.dataset.jawaBefore = paket.harga_jawa_before || 0;
    card.dataset.timurBefore = paket.harga_timur_before || 0;

    // ✅ TAMBAHAN: Simpan data instalasi
    card.dataset.instalasiSumatera = paket.instalasi_sumatera || 0;
    card.dataset.instalasiJawa = paket.instalasi_jawa || 0;
    card.dataset.instalasiTimur = paket.instalasi_timur || 0;
    
    card.dataset.instalasiSumateraBefore = paket.instalasi_sumatera_before || 0;
    card.dataset.instalasiJawaBefore = paket.instalasi_jawa_before || 0;
    card.dataset.instalasiTimurBefore = paket.instalasi_timur_before || 0;

    card.dataset.packageName = paket.name || '';
    card.dataset.packageSpeed = paket.kecepatan || '';

    card.innerHTML = `
        <h4>${paket.name}</h4>

        <div class="package-specs">
            <p><i class="fas fa-wifi"></i> ${paket.kecepatan}</p>
            <p><i class="fas fa-laptop"></i> ${paket.max_laptop} Laptop</p>
            <p><i class="fas fa-mobile-alt"></i> ${paket.max_smartphone} Smartphone</p>
            <p><i class="fas fa-network-wired"></i> ${paket.max_perangkat} Total Devices</p>
        </div>

        <small>Biaya Bulanan</small>
        <div class="package-price"></div>
      
        <small>Biaya Instalasi</small>
        <div class="package-installation-price mt-3"></div>
        
        <button type="button" class="btn-pilih">
            Pesan Sekarang →
        </button>

        <small class="d-block mt-1">*Harga sudah termasuk PPN</small>
    `;

    return card;
}

// ==================== UPDATE PRICES BY LOCATION ====================
function updatePricesByLocation() {
    console.log('💰 Updating prices for location:', currentLocation);
    
    const cards = document.querySelectorAll('.package-card');
    console.log('📋 Found', cards.length, 'package cards');
    
    cards.forEach((card, index) => {
        let before = 0;
        let after = 0;
        let instalasiBefore = 0;
        let instalasiAfter = 0;

        if (currentLocation === 'sumatera') {
            before = card.dataset.sumateraBefore || 0;
            after = card.dataset.sumatera || 0;
            instalasiBefore = card.dataset.instalasiSumateraBefore || 0;
            instalasiAfter = card.dataset.instalasiSumatera || 0;
        } 
        else if (currentLocation === 'jawa') {
            before = card.dataset.jawaBefore || 0;
            after = card.dataset.jawa || 0;
            instalasiBefore = card.dataset.instalasiJawaBefore || 0;
            instalasiAfter = card.dataset.instalasiJawa || 0;
        } 
        else if (currentLocation === 'timur') {
            before = card.dataset.timurBefore || 0;
            after = card.dataset.timur || 0;
            instalasiBefore = card.dataset.instalasiTimurBefore || 0;
            instalasiAfter = card.dataset.instalasiTimur || 0;
        }

        console.log(`📦 Card ${index + 1} - Location: ${currentLocation}, Before: ${before}, After: ${after}, Instalasi Before: ${instalasiBefore}, Instalasi After: ${instalasiAfter}`);

        const priceEl = card.querySelector('.package-price');
        const installationPriceEl = card.querySelector('.package-installation-price');
        
        if (priceEl) {
            priceEl.innerHTML = hargaView(before, after);
            console.log(`✅ Price updated for card ${index + 1}`);
        } else {
            console.error(`❌ Price element not found for card ${index + 1}`);
        }

        if (installationPriceEl) {
            installationPriceEl.innerHTML = hargaView(instalasiBefore, instalasiAfter);
            console.log(`✅ Installation price updated for card ${index + 1}`);
        }
    });
    
    console.log('✅ All prices updated');
}

// ==================== HARGA VIEW (CORET + AFTER) - FIXED ====================
const hargaView = (before, after) => {
    before = parseInt(before) || 0;
    after = parseInt(after) || 0;
    
    console.log('🎨 Rendering price view - Before:', before, 'After:', after);
    
    // ✅ LOGIKA BARU: Tampilkan coret HANYA jika before > 0 DAN before > after
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
    
    // ✅ Jika before kosong/0 atau before <= after, tampilkan after saja TANPA coret
    return `
        <div style="font-size:28px;font-weight:700;color:#14b8a6;">
            Rp ${after.toLocaleString('id-ID')}
        </div>
    `;
};

// ==================== SETUP MODAL PESAN SEKARANG - FIXED ====================
// ==================== SETUP MODAL PESAN SEKARANG - COMPLETE DETAIL ====================
function setupModalPesanSekarang() {
    console.log('🎯 Setting up detailed modal...');
    
    const modal = document.getElementById('modalPesan');
    
    // Modal elements
    const modalNama = document.getElementById('modalNama');
    const modalKecepatan = document.getElementById('modalKecepatan');
    const modalWilayah = document.getElementById('modalWilayah');
    const modalHargaBefore = document.getElementById('modalHargaBefore');
    const modalHargaAfter = document.getElementById('modalHargaAfter');
    const modalDiskon = document.getElementById('modalDiskon');
    const modalInstallBefore = document.getElementById('modalInstallBefore');
    const modalInstallAfter = document.getElementById('modalInstallAfter');
    const modalDiskonInstall = document.getElementById('modalDiskonInstall');
    const modalTotal = document.getElementById('modalTotal');
    
    const btnWhatsapp = document.getElementById('btnWhatsapp');
    const modalClose = document.querySelector('.modal-close');
    const btnCancel = document.querySelector('.btn-cancel');

    if (!modal) {
        console.error('❌ Modal not found!');
        return;
    }

    // ✅ EVENT DELEGATION - Click handler for "Pesan Sekarang" buttons
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-pilih');
        
        if (!btn) return;
        
        console.log('🖱️ "Pesan Sekarang" clicked!');
        e.preventDefault();
        e.stopPropagation();

        const card = btn.closest('.package-card');
        if (!card) {
            console.error('❌ Package card not found!');
            return;
        }

        // Get package data
        const nama = card.dataset.packageName || card.querySelector('h4')?.textContent || '';
        const kecepatan = card.dataset.packageSpeed || '';

        // Get prices based on location
        let hargaBefore = 0;
        let hargaAfter = 0;
        let installBefore = 0;
        let installAfter = 0;
        let wilayahText = '';

        if (currentLocation === 'sumatera') {
            hargaBefore = parseInt(card.dataset.sumateraBefore) || 0;
            hargaAfter = parseInt(card.dataset.sumatera) || 0;
            installBefore = parseInt(card.dataset.instalasiSumateraBefore) || 0;
            installAfter = parseInt(card.dataset.instalasiSumatera) || 0;
            wilayahText = 'Sumatera & Kalimantan';
        } else if (currentLocation === 'jawa') {
            hargaBefore = parseInt(card.dataset.jawaBefore) || 0;
            hargaAfter = parseInt(card.dataset.jawa) || 0;
            installBefore = parseInt(card.dataset.instalasiJawaBefore) || 0;
            installAfter = parseInt(card.dataset.instalasiJawa) || 0;
            wilayahText = 'Jawa & Bali';
        } else if (currentLocation === 'timur') {
            hargaBefore = parseInt(card.dataset.timurBefore) || 0;
            hargaAfter = parseInt(card.dataset.timur) || 0;
            installBefore = parseInt(card.dataset.instalasiTimurBefore) || 0;
            installAfter = parseInt(card.dataset.instalasiTimur) || 0;
            wilayahText = 'Indonesia Timur';
        }

        // Calculate discounts
        const diskonBulanan = hargaBefore - hargaAfter;
        const diskonInstalasi = installBefore - installAfter;
        const totalBiaya = hargaAfter + installAfter;

        console.log('📝 Modal data:', {
            nama,
            kecepatan,
            wilayahText,
            hargaBefore,
            hargaAfter,
            diskonBulanan,
            installBefore,
            installAfter,
            diskonInstalasi,
            totalBiaya
        });

        // Update modal content
        if (modalNama) modalNama.textContent = nama;
        if (modalKecepatan) modalKecepatan.textContent = kecepatan;
        if (modalWilayah) modalWilayah.textContent = wilayahText;
        
        if (modalHargaBefore) {
            modalHargaBefore.textContent = formatRupiah(hargaBefore);
            modalHargaBefore.style.display = hargaBefore > hargaAfter ? 'inline' : 'none';
        }
        
        if (modalHargaAfter) modalHargaAfter.textContent = formatRupiah(hargaAfter);
        
        if (modalDiskon) {
            modalDiskon.textContent = diskonBulanan > 0 ? `Hemat ${formatRupiah(diskonBulanan)}` : 'Harga Terbaik';
        }
        
        if (modalInstallBefore) {
            modalInstallBefore.textContent = formatRupiah(installBefore);
            modalInstallBefore.style.display = installBefore > installAfter ? 'inline' : 'none';
        }
        
        if (modalInstallAfter) modalInstallAfter.textContent = formatRupiah(installAfter);
        
        if (modalDiskonInstall) {
            modalDiskonInstall.textContent = diskonInstalasi > 0 ? `Hemat ${formatRupiah(diskonInstalasi)}` : 'Harga Terbaik';
        }
        
        if (modalTotal) modalTotal.textContent = formatRupiah(totalBiaya);

        // Hide arrows if no discount
        const arrows = modal.querySelectorAll('.price-arrow');
        arrows[0].style.display = hargaBefore > hargaAfter ? 'inline' : 'none';
        arrows[1].style.display = installBefore > installAfter ? 'inline' : 'none';

        // Prepare WhatsApp message - DETAILED FORMAT
        if (btnWhatsapp) {
            let waMessage = `🌐 *PEMESANAN PAKET ICONNET*\n\n`;
            waMessage += `📦 *Detail Paket:*\n`;
            waMessage += `• Paket: ${nama}\n`;
            waMessage += `• Kecepatan: ${kecepatan}\n`;
            waMessage += `• Wilayah: ${wilayahText}\n\n`;
            
            waMessage += `💰 *Rincian Biaya:*\n`;
            
            // Biaya Bulanan
            if (hargaBefore > hargaAfter) {
                waMessage += `• Biaya Bulanan: ~${formatRupiah(hargaBefore)}~ → *${formatRupiah(hargaAfter)}*\n`;
                waMessage += `  ✅ Hemat ${formatRupiah(diskonBulanan)}\n\n`;
            } else {
                waMessage += `• Biaya Bulanan: *${formatRupiah(hargaAfter)}*\n\n`;
            }
            
            // Biaya Instalasi
            if (installBefore > installAfter) {
                waMessage += `• Biaya Instalasi: ~${formatRupiah(installBefore)}~ → *${formatRupiah(installAfter)}*\n`;
                waMessage += `  ✅ Hemat ${formatRupiah(diskonInstalasi)}\n\n`;
            } else {
                waMessage += `• Biaya Instalasi: *${formatRupiah(installAfter)}*\n\n`;
            }
            
            waMessage += `💵 *TOTAL BIAYA: ${formatRupiah(totalBiaya)}*\n\n`;
            waMessage += `📋 Masa kontrak: 12 bulan\n`;
            waMessage += `✨ Harga sudah termasuk PPN 11%\n\n`;
            waMessage += `Saya ingin melakukan pemesanan. Mohon informasi lebih lanjut. Terima kasih! 🙏`;
            
            btnWhatsapp.dataset.text = waMessage;
        }

        // Show modal
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent background scroll
        console.log('✅ Modal shown with complete details');
    });

    // Close modal function
    function closeModal() {
        modal.classList.remove('show');
        document.body.style.overflow = ''; // Restore scroll
        console.log('❌ Modal closed');
    }

    // Close button
    if (modalClose) {
        modalClose.addEventListener('click', closeModal);
    }

    // Cancel button
    if (btnCancel) {
        btnCancel.addEventListener('click', closeModal);
    }

    // WhatsApp button
    if (btnWhatsapp) {
        btnWhatsapp.addEventListener('click', function() {
            const nomorWA = '6289502434324';
            const text = encodeURIComponent(this.dataset.text || 'Halo, saya tertarik dengan ICONNET');
            const url = `https://wa.me/${nomorWA}?text=${text}`;
            console.log('📱 Opening WhatsApp with detailed message');
            window.open(url, '_blank');
        });
    }

    // Close when clicking outside modal
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('show')) {
            closeModal();
        }
    });

    console.log('✅ Detailed modal setup complete');
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
// ==================== SMOOTH CAROUSEL ANIMATION ====================
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('#packageCarousel');
    
    if (carousel) {
        // ✅ Tambahkan smooth transition untuk Bootstrap carousel
        carousel.addEventListener('slide.bs.carousel', function (e) {
            const activeItem = e.relatedTarget;
            const direction = e.direction;
            
            // Tambahkan class untuk animasi
            if (direction === 'left') {
                activeItem.style.transform = 'translateX(50px)';
                activeItem.style.opacity = '0';
            } else {
                activeItem.style.transform = 'translateX(-50px)';
                activeItem.style.opacity = '0';
            }
            
            // Trigger reflow untuk smooth animation
            setTimeout(() => {
                activeItem.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                activeItem.style.transform = 'translateX(0)';
                activeItem.style.opacity = '1';
            }, 50);
        });
        
        // ✅ Tambahkan keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                const prevBtn = carousel.querySelector('.carousel-control-prev');
                if (prevBtn && !prevBtn.classList.contains('disabled')) {
                    prevBtn.click();
                }
            } else if (e.key === 'ArrowRight') {
                const nextBtn = carousel.querySelector('.carousel-control-next');
                if (nextBtn && !nextBtn.classList.contains('disabled')) {
                    nextBtn.click();
                }
            }
        });
        
        console.log('✅ Smooth carousel animation initialized');
    }
});

// ==================== SWIPE GESTURE SUPPORT (Mobile) ====================
let touchStartX = 0;
let touchEndX = 0;

const carouselElement = document.querySelector('#packageCarousel');

if (carouselElement) {
    carouselElement.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    
    carouselElement.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });
}

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe left - next
            const nextBtn = document.querySelector('#packageCarousel .carousel-control-next');
            if (nextBtn && !nextBtn.classList.contains('disabled')) {
                nextBtn.click();
            }
        } else {
            // Swipe right - prev
            const prevBtn = document.querySelector('#packageCarousel .carousel-control-prev');
            if (prevBtn && !prevBtn.classList.contains('disabled')) {
                prevBtn.click();
            }
        }
    }
}