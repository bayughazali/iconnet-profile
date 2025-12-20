// Script untuk memuat berita dan FAQ dari database menggunakan api.php yang sudah ada
document.addEventListener('DOMContentLoaded', function() {
    loadNews();
    loadFAQ();
});

// Fungsi untuk memuat berita dari database
async function loadNews() {
    try {
        const response = await fetch('api.php?action=get_berita_public');
        const result = await response.json();
        
        if (!result.success) {
            console.error('Error loading news:', result.message);
            return;
        }
        
        const news = result.data;
        const newsContainer = document.querySelector('.news-section .row.g-4');
        
        if (!newsContainer) return;
        
        newsContainer.innerHTML = '';
        
        // Tampilkan maksimal 3 berita terbaru (API sudah LIMIT 3)
        news.forEach(item => {
            const newsCard = `
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm news-card h-100">
                        <img src="${item.image_url || 'https://via.placeholder.com/500x300'}" 
                             class="card-img-top rounded-top" 
                             alt="${item.title}"
                             onerror="this.src='https://via.placeholder.com/500x300'">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">${item.title}</h5>
                            <p class="text-muted small mb-2">
                                <i class="far fa-calendar me-1"></i> ${formatDate(item.date)}
                            </p>
                            <p class="card-text">${truncateText(item.content, 100)}</p>
                            <a href="#" class="text-primary fw-semibold">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>
            `;
            newsContainer.innerHTML += newsCard;
        });
    } catch (error) {
        console.error('Error loading news:', error);
    }
}

// Fungsi untuk memuat FAQ dari database
async function loadFAQ() {
    try {
        const response = await fetch('api.php?action=get_faq_public');
        const result = await response.json();
        
        if (!result.success) {
            console.error('Error loading FAQ:', result.message);
            return;
        }
        
        const faqs = result.data;
        const faqContainer = document.querySelector('.faq-section .col-lg-6');
        
        if (!faqContainer) return;
        
        faqContainer.innerHTML = '';
        
        // Tampilkan maksimal 5 FAQ (API sudah LIMIT 5)
        faqs.forEach((item, index) => {
            const isFirst = index === 0;
            const faqItem = document.createElement('div');
            faqItem.className = 'faq-item';
            faqItem.setAttribute('data-faq-id', item.id);
            
            faqItem.innerHTML = `
                <h5 style="cursor: pointer;">
                    ${item.question} 
                    <i class="fas ${isFirst ? 'fa-times' : 'fa-plus'} float-end faq-toggle"></i>
                </h5>
                ${isFirst ? `<p class="mt-3 faq-answer">${item.answer}</p>` : ''}
            `;
            
            // Simpan answer sebagai data attribute untuk akses mudah
            faqItem.setAttribute('data-answer', item.answer);
            
            faqContainer.appendChild(faqItem);
        });
        
        // Add click event untuk FAQ toggle
        addFAQToggleEvents();
    } catch (error) {
        console.error('Error loading FAQ:', error);
    }
}

// Event handler untuk toggle FAQ
function addFAQToggleEvents() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const heading = item.querySelector('h5');
        
        heading.addEventListener('click', function() {
            const toggle = item.querySelector('.faq-toggle');
            const isOpen = toggle.classList.contains('fa-times');
            
            // Close all other FAQ items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    const otherToggle = otherItem.querySelector('.faq-toggle');
                    const existingAnswer = otherItem.querySelector('.faq-answer');
                    
                    otherToggle.classList.remove('fa-times');
                    otherToggle.classList.add('fa-plus');
                    if (existingAnswer) {
                        existingAnswer.remove();
                    }
                }
            });
            
            if (isOpen) {
                // Close current item
                toggle.classList.remove('fa-times');
                toggle.classList.add('fa-plus');
                const answer = item.querySelector('.faq-answer');
                if (answer) answer.remove();
            } else {
                // Open current item
                toggle.classList.remove('fa-plus');
                toggle.classList.add('fa-times');
                
                // Get answer from data attribute
                const answerText = item.getAttribute('data-answer');
                
                if (answerText && !item.querySelector('.faq-answer')) {
                    const answerElement = document.createElement('p');
                    answerElement.className = 'mt-3 faq-answer';
                    answerElement.textContent = answerText;
                    item.appendChild(answerElement);
                }
            }
        });
    });
}

// Helper function untuk format tanggal
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    return date.toLocaleDateString('id-ID', options);
}

// Helper function untuk memotong teks
function truncateText(text, maxLength) {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength) + '...';
}