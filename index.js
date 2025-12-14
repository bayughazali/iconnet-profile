// index.js - Load Data dari Database untuk Homepage

const API_URL = 'api.php';

// ==================== LOAD DATA SAAT HALAMAN DIMUAT ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Index.html loaded, fetching data from database...');
    loadSliders();
    loadPaketPrices();
    loadBerita();
    loadFAQ();
});

// ==================== LOAD SLIDERS ====================
function loadSliders() {
    fetch(`${API_URL}?action=get_slider_public`)
        .then(response => response.json())
        .then(data => {
            console.log('Sliders from DB:', data);
            if (data.success && data.data.length > 0) {
                updateSliderHTML(data.data);
            }
        })
        .catch(error => console.error('Error loading sliders:', error));
}

function updateSliderHTML(sliders) {
    const sliderWrapper = document.querySelector('.slider-wrapper');
    if (!sliderWrapper) return;
    
    sliderWrapper.innerHTML = '';
    
    sliders.forEach((slider, index) => {
        const slideDiv = document.createElement('div');
        slideDiv.className = 'row g-4 slide' + (index === 0 ? ' active-slide' : '');
        slideDiv.innerHTML = `
            <div class="col-12">
                <div class="hero-card" style="background-image: url('${slider.image_path}'); background-size: contain; height: 450px;"></div>
            </div>
        `;
        sliderWrapper.appendChild(slideDiv);
    });
    
    // Restart auto slide
    startAutoSlide();
}

// ==================== LOAD PAKET PRICES ====================
function loadPaketPrices() {
    fetch(`${API_URL}?action=get_paket_public`)
        .then(response => response.json())
        .then(data => {
            console.log('Paket from DB:', data);
            if (data.success && data.data.length > 0) {
                updatePaketData(data.data);
            }
        })
        .catch(error => console.error('Error loading paket:', error));
}

function updatePaketData(pakets) {
    // Update packageData object yang sudah ada di index.html
    pakets.forEach(paket => {
        const paketId = paket.id.toLowerCase();
        
        // Update harga untuk setiap region
        if (window.packageData) {
            if (window.packageData['sumatera-kalimantan'] && window.packageData['sumatera-kalimantan'][paketId]) {
                window.packageData['sumatera-kalimantan'][paketId].abonemen = parseInt(paket.harga_sumatera).toLocaleString('id-ID');
            }
            if (window.packageData['jawa-bali'] && window.packageData['jawa-bali'][paketId]) {
                window.packageData['jawa-bali'][paketId].abonemen = parseInt(paket.harga_jawa).toLocaleString('id-ID');
            }
            if (window.packageData['indonesia-timur'] && window.packageData['indonesia-timur'][paketId]) {
                window.packageData['indonesia-timur'][paketId].abonemen = parseInt(paket.harga_timur).toLocaleString('id-ID');
            }
        }
    });
    
    // Refresh tampilan harga dengan lokasi default
    if (typeof updatePackagePrices === 'function') {
        updatePackagePrices('sumatera-kalimantan');
    }
}

// ==================== LOAD BERITA ====================
function loadBerita() {
    fetch(`${API_URL}?action=get_berita_public`)
        .then(response => response.json())
        .then(data => {
            console.log('Berita from DB:', data);
            if (data.success && data.data.length > 0) {
                updateBeritaHTML(data.data);
            }
        })
        .catch(error => console.error('Error loading berita:', error));
}

function updateBeritaHTML(beritaList) {
    const newsSection = document.querySelector('.news-section .row');
    if (!newsSection) return;
    
    newsSection.innerHTML = '';
    
    beritaList.forEach(berita => {
        const newsCard = `
            <div class="col-md-4">
                <div class="card border-0 shadow-sm news-card h-100">
                    <img src="${berita.image_url || 'https://via.placeholder.com/500x300'}" class="card-img-top rounded-top" alt="${berita.title}">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">${berita.title}</h5>
                        <p class="text-muted small mb-2"><i class="far fa-calendar me-1"></i> ${berita.date}</p>
                        <p class="card-text">${berita.content ? berita.content.substring(0, 150) + '...' : 'Baca selengkapnya untuk informasi lebih detail.'}</p>
                        <a href="#" class="text-primary fw-semibold">Baca Selengkapnya →</a>
                    </div>
                </div>
            </div>
        `;
        newsSection.innerHTML += newsCard;
    });
}

// ==================== LOAD FAQ ====================
function loadFAQ() {
    fetch(`${API_URL}?action=get_faq_public`)
        .then(response => response.json())
        .then(data => {
            console.log('FAQ from DB:', data);
            if (data.success && data.data.length > 0) {
                updateFAQHTML(data.data);
            }
        })
        .catch(error => console.error('Error loading FAQ:', error));
}

function updateFAQHTML(faqList) {
    const faqContainer = document.querySelector('.faq-section .col-lg-6');
    if (!faqContainer) return;
    
    faqContainer.innerHTML = '';
    
    faqList.forEach((faq, index) => {
        const faqItem = `
            <div class="faq-item">
                <h5>${faq.question} <i class="fas fa-${index === 0 ? 'times' : 'plus'} float-end"></i></h5>
                ${index === 0 ? `<p class="mt-3">${faq.answer}</p>` : ''}
            </div>
        `;
        faqContainer.innerHTML += faqItem;
    });
}

// ==================== AUTO SLIDER ====================
let slideIndex = 0;
let autoSlideInterval;

function startAutoSlide() {
    // Clear existing interval
    if (autoSlideInterval) {
        clearInterval(autoSlideInterval);
    }
    
    const slides = document.querySelectorAll('.slide');
    if (slides.length === 0) return;
    
    autoSlideInterval = setInterval(() => {
        slides.forEach(slide => slide.classList.remove('active-slide'));
        
        slideIndex++;
        if (slideIndex >= slides.length) slideIndex = 0;
        
        slides[slideIndex].classList.add('active-slide');
        
        const sliderWrapper = document.querySelector('.slider-wrapper');
        if (sliderWrapper) {
            sliderWrapper.style.transform = `translateX(-${slideIndex * 100}%)`;
        }
    }, 3000);
}