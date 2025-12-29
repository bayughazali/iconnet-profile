// load_news_faq.js - Script untuk memuat berita dan FAQ dari database
// Versi dengan link ke halaman detail berita

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Loading News & FAQ...');
    loadNews();
    loadFAQ();
});

// ==================== LOAD BERITA ====================
async function loadNews() {
    try {
        console.log('📰 Fetching news from API...');
        const response = await fetch('api.php?action=get_berita_public');
        const result = await response.json();
        
        console.log('📦 News API Response:', result);
        
        if (!result.success) {
            console.error('❌ Error loading news:', result.message);
            showNewsError('Gagal memuat berita');
            return;
        }
        
        const news = result.data;
        
        // Cari container berita
        const newsContainer = document.querySelector('.news-section .row.g-4') || 
                            document.getElementById('newsContainer');
        
        if (!newsContainer) {
            console.error('❌ News container not found');
            return;
        }
        
        // Cek apakah ada berita
        if (!news || news.length === 0) {
            newsContainer.innerHTML = `
                <div class="col-12">
                    <div class="news-empty-state">
                        <i class="fas fa-newspaper"></i>
                        <h4>Belum ada berita tersedia</h4>
                        <p>Nantikan informasi terbaru dari kami</p>
                    </div>
                </div>
            `;
            return;
        }
        
        // Render berita dengan carousel
        console.log(`✅ Rendering ${news.length} news items with carousel`);
        
        const carouselHTML = `
            <div class="col-12">
                <div class="news-carousel-wrapper">
                    <!-- Carousel Container -->
                    <div class="news-carousel-container">
                        <div class="news-carousel-track" id="newsCarouselTrack">
                            ${news.map(item => createNewsCard(item)).join('')}
                        </div>
                    </div>
                    
                    <!-- Navigation Controls -->
                    <button class="news-carousel-control prev" id="newsPrevBtn" onclick="moveNewsCarousel(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="news-carousel-control next" id="newsNextBtn" onclick="moveNewsCarousel(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <!-- Indicators -->
                <div class="news-carousel-indicators" id="newsIndicators"></div>
            </div>
        `;
        
        newsContainer.innerHTML = carouselHTML;
        
        // Initialize carousel
        initNewsCarousel(news.length);
        
        console.log('✅ News carousel loaded successfully');
        
    } catch (error) {
        console.error('❌ Error loading news:', error);
        showNewsError('Terjadi kesalahan saat memuat berita');
    }
}

// Fungsi untuk membuat HTML card berita
// Fungsi untuk membuat HTML card berita (untuk carousel)
function createNewsCard(item) {
    // Format konten untuk preview (strip HTML, ambil 120 karakter)
    const contentPreview = truncateText(stripHtml(item.content || ''), 120);
    
    // Format tanggal
    const formattedDate = formatDate(item.date);
    
    // Gambar dengan fallback
    const imageUrl = item.image_url || 'https://via.placeholder.com/600x400?text=ICONNET+News';
    
    return `
        <div class="news-carousel-item">
            <article class="news-card h-100">
                <div class="news-image">
                    <img src="${escapeHtml(imageUrl)}" 
                         alt="${escapeHtml(item.title)}"
                         onerror="this.src='https://via.placeholder.com/600x400?text=ICONNET+News'">
                </div>
                <div class="news-content">
                    <span class="news-date">
                        <i class="far fa-calendar-alt me-1"></i>
                        ${formattedDate}
                    </span>
                    <h5 class="news-title">${escapeHtml(item.title)}</h5>
                    <p class="news-desc">${escapeHtml(contentPreview)}</p>
                    <a href="berita.php?id=${item.id}" class="news-link">
                        Baca Selengkapnya →
                    </a>
                </div>
            </article>
        </div>
    `;
}

// Fungsi untuk menampilkan error berita
function showNewsError(message) {
    const newsContainer = document.querySelector('.news-section .row.g-4') || 
                        document.getElementById('newsContainer');
    
    if (newsContainer) {
        newsContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    ${message}. Silakan refresh halaman.
                </div>
            </div>
        `;
    }
}

// ==================== LOAD FAQ ====================
async function loadFAQ() {
    try {
        console.log('❓ Fetching FAQ from API...');
        // ✅ TAMBAHAN: timestamp untuk prevent cache
        const timestamp = new Date().getTime();
        const response = await fetch(`api.php?action=get_faq_public&_t=${timestamp}`);
        const result = await response.json();
        
        console.log('📦 FAQ API Response:', result);
        
        if (!result.success) {
            console.error('❌ Error loading FAQ:', result.message);
            showFAQError('Gagal memuat FAQ');
            return;
        }
        
        const faqs = result.data;
        
        // Cari container FAQ (support 2 format)
        const faqContainer = document.querySelector('.faq-section .col-lg-6') ||
                           document.getElementById('faqContainer');
        
        if (!faqContainer) {
            console.error('❌ FAQ container not found');
            return;
        }
        
        // Cek apakah ada FAQ
        if (!faqs || faqs.length === 0) {
            faqContainer.innerHTML = `
                <div class="faq-item">
                    <h5>
                        <i class="fas fa-info-circle me-2"></i>
                        Belum ada FAQ tersedia
                    </h5>
                </div>
            `;
            return;
        }
        
        // Clear container
        faqContainer.innerHTML = '';
        
// Render FAQ (SEMUA data aktif)
const faqsToShow = faqs; // ✅ UBAH: tidak pakai slice, tampilkan semua
console.log(`✅ Rendering ${faqsToShow.length} FAQ items`);

faqsToShow.forEach((item, index) => {
            console.log(`❓ FAQ ${index + 1}:`, item.question);
            
            const isFirst = index === 0; // FAQ pertama otomatis terbuka
            const faqItem = createFAQItem(item, isFirst);
            faqContainer.appendChild(faqItem);
        });
        
        // Tambahkan event listener untuk toggle
        addFAQToggleEvents();
        
        console.log('✅ FAQ loaded successfully');
        
    } catch (error) {
        console.error('❌ Error loading FAQ:', error);
        showFAQError('Terjadi kesalahan saat memuat FAQ');
    }
}

// Fungsi untuk membuat element FAQ
function createFAQItem(item, isOpen = false) {
    const faqItem = document.createElement('div');
    faqItem.className = 'faq-item';
    faqItem.setAttribute('data-faq-id', item.id);
    faqItem.setAttribute('data-answer', item.answer); // Simpan answer untuk akses mudah
    
    const iconClass = isOpen ? 'fa-times' : 'fa-plus';
    
    faqItem.innerHTML = `
        <h5 style="cursor: pointer;">
            ${escapeHtml(item.question)}
            <i class="fas ${iconClass} float-end faq-toggle"></i>
        </h5>
        ${isOpen ? `<p class="mt-3 faq-answer">${escapeHtml(item.answer)}</p>` : ''}
    `;
    
    return faqItem;
}

// Fungsi untuk menampilkan error FAQ
function showFAQError(message) {
    const faqContainer = document.querySelector('.faq-section .col-lg-6') ||
                       document.getElementById('faqContainer');
    
    if (faqContainer) {
        faqContainer.innerHTML = `
            <div class="faq-item">
                <h5>
                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                    ${message}
                </h5>
                <p class="mt-3 text-muted">
                    Silakan refresh halaman atau coba beberapa saat lagi.
                </p>
            </div>
        `;
    }
}

// ==================== FAQ TOGGLE EVENTS ====================
function addFAQToggleEvents() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    console.log(`🎯 Adding toggle events to ${faqItems.length} FAQ items`);
    
    faqItems.forEach(item => {
        const heading = item.querySelector('h5');
        
        if (!heading) return;
        
        heading.addEventListener('click', function() {
            toggleFAQItem(item, faqItems);
        });
    });
}

// Fungsi untuk toggle FAQ item
function toggleFAQItem(currentItem, allItems) {
    const toggle = currentItem.querySelector('.faq-toggle');
    const isOpen = toggle.classList.contains('fa-times');
    
    // Tutup semua FAQ lainnya
    allItems.forEach(otherItem => {
        if (otherItem !== currentItem) {
            const otherToggle = otherItem.querySelector('.faq-toggle');
            const existingAnswer = otherItem.querySelector('.faq-answer');
            
            if (otherToggle) {
                otherToggle.classList.remove('fa-times');
                otherToggle.classList.add('fa-plus');
            }
            
            if (existingAnswer) {
                existingAnswer.remove();
            }
        }
    });
    
    if (isOpen) {
        // Tutup item saat ini
        toggle.classList.remove('fa-times');
        toggle.classList.add('fa-plus');
        
        const answer = currentItem.querySelector('.faq-answer');
        if (answer) {
            answer.remove();
        }
        
        console.log('❌ FAQ closed');
    } else {
        // Buka item saat ini
        toggle.classList.remove('fa-plus');
        toggle.classList.add('fa-times');
        
        // Ambil answer dari data attribute
        const answerText = currentItem.getAttribute('data-answer');
        
        if (answerText && !currentItem.querySelector('.faq-answer')) {
            const answerElement = document.createElement('p');
            answerElement.className = 'mt-3 faq-answer';
            answerElement.textContent = answerText;
            currentItem.appendChild(answerElement);
            
            console.log('✅ FAQ opened');
        }
    }
}

// ==================== UTILITY FUNCTIONS ====================

/**
 * Format tanggal ke format Indonesia
 * @param {string} dateString - Tanggal dalam format YYYY-MM-DD atau string lain
 * @returns {string} Tanggal terformat (contoh: "27 November 2024")
 */
function formatDate(dateString) {
    if (!dateString) return '';
    
    try {
        // Cek apakah sudah dalam format yang benar (contoh: "27 November 2025")
        if (dateString.includes(' ')) {
            return dateString;
        }
        
        // Konversi jika format YYYY-MM-DD atau format lainnya
        const date = new Date(dateString);
        
        // Validasi apakah tanggal valid
        if (isNaN(date.getTime())) {
            return dateString; // Return original jika tidak valid
        }
        
        const options = { 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric',
            timeZone: 'Asia/Jakarta' // Tambahan timezone
        };
        
        return date.toLocaleDateString('id-ID', options);
    } catch (error) {
        console.error('Error formatting date:', error);
        return dateString; // Return original jika error
    }
}

/**
 * Potong teks dengan batas karakter
 * @param {string} text - Teks yang akan dipotong
 * @param {number} maxLength - Panjang maksimal karakter
 * @returns {string} Teks yang sudah dipotong dengan "..."
 */
function truncateText(text, maxLength) {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength).trim() + '...';
}

/**
 * Escape HTML untuk keamanan (mencegah XSS)
 * @param {string} text - Teks yang akan di-escape
 * @returns {string} Teks yang sudah aman dari XSS
 */
function escapeHtml(text) {
    if (!text) return '';
    
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    
    return text.toString().replace(/[&<>"']/g, m => map[m]);
}

/**
 * Strip HTML tags dari string
 * @param {string} html - String HTML
 * @returns {string} Plain text tanpa tag HTML
 */
function stripHtml(html) {
    if (!html) return '';
    
    try {
        const tmp = document.createElement('DIV');
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || '';
    } catch (error) {
        console.error('Error stripping HTML:', error);
        return html.replace(/<[^>]*>/g, '');
    }
}

// ==================== EXPORTS (untuk testing/reuse) ====================
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        loadNews,
        loadFAQ,
        formatDate,
        truncateText,
        escapeHtml,
        stripHtml,
        toggleFAQItem
    };
}
// ==================== NEWS CAROUSEL FUNCTIONALITY ====================
let newsCurrentIndex = 0;
let newsTotalItems = 0;
let newsItemsPerView = 3;

function initNewsCarousel(totalItems) {
    newsTotalItems = totalItems;
    newsCurrentIndex = 0;
    
    // Hitung items per view berdasarkan ukuran layar
    updateNewsItemsPerView();
    
    // Buat indicators
    createNewsIndicators();
    
    // Update tampilan awal
    updateNewsCarousel();
    
    // Add resize listener
    window.addEventListener('resize', function() {
        updateNewsItemsPerView();
        updateNewsCarousel();
    });
}

function updateNewsItemsPerView() {
    const width = window.innerWidth;
    if (width <= 768) {
        newsItemsPerView = 1;
    } else if (width <= 992) {
        newsItemsPerView = 2;
    } else {
        newsItemsPerView = 3;
    }
}

function createNewsIndicators() {
    const indicatorsContainer = document.getElementById('newsIndicators');
    if (!indicatorsContainer) return;
    
    const totalPages = Math.ceil(newsTotalItems / newsItemsPerView);
    indicatorsContainer.innerHTML = '';
    
    for (let i = 0; i < totalPages; i++) {
        const indicator = document.createElement('button');
        indicator.className = 'news-indicator';
        if (i === 0) indicator.classList.add('active');
        indicator.onclick = () => goToNewsPage(i);
        indicatorsContainer.appendChild(indicator);
    }
}

function moveNewsCarousel(direction) {
    const totalPages = Math.ceil(newsTotalItems / newsItemsPerView);
    const currentPage = Math.floor(newsCurrentIndex / newsItemsPerView);
    let newPage = currentPage + direction;
    
    // Loop carousel
    if (newPage < 0) {
        newPage = totalPages - 1;
    } else if (newPage >= totalPages) {
        newPage = 0;
    }
    
    newsCurrentIndex = newPage * newsItemsPerView;
    updateNewsCarousel();
}

function goToNewsPage(pageIndex) {
    newsCurrentIndex = pageIndex * newsItemsPerView;
    updateNewsCarousel();
}

function updateNewsCarousel() {
    const track = document.getElementById('newsCarouselTrack');
    const prevBtn = document.getElementById('newsPrevBtn');
    const nextBtn = document.getElementById('newsNextBtn');
    const indicators = document.querySelectorAll('.news-indicator');
    
    if (!track) return;
    
    // Hitung pergeseran
    const itemWidth = 100 / newsItemsPerView;
    const offset = -(newsCurrentIndex * itemWidth);
    
    track.style.transform = `translateX(${offset}%)`;
    
    // Update indicators
    const currentPage = Math.floor(newsCurrentIndex / newsItemsPerView);
    indicators.forEach((indicator, index) => {
        if (index === currentPage) {
            indicator.classList.add('active');
        } else {
            indicator.classList.remove('active');
        }
    });
    
    // Update button states (optional: disable on edges)
    const totalPages = Math.ceil(newsTotalItems / newsItemsPerView);
    // Karena kita pakai loop, button tidak perlu di-disable
    // Tapi jika ingin tanpa loop, uncomment kode di bawah:
    /*
    if (prevBtn) {
        prevBtn.disabled = currentPage === 0;
    }
    if (nextBtn) {
        nextBtn.disabled = currentPage === totalPages - 1;
    }
    */
    
    console.log(`📰 Carousel updated - Page ${currentPage + 1}/${totalPages}`);
}

// Export untuk testing
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ...module.exports,
        initNewsCarousel,
        moveNewsCarousel,
        goToNewsPage
    };
}
console.log('✅ load_news_faq.js loaded successfully');