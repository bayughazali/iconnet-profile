// Script untuk memuat promo dari database
document.addEventListener('DOMContentLoaded', function() {
    loadPromos();
});

// Fungsi untuk memuat semua promo
async function loadPromos() {
    try {
        const response = await fetch('api.php?action=get_promo_public');
        const result = await response.json();
        
        if (!result.success) {
            console.error('Error loading promos:', result.message);
            return;
        }
        
        const promos = result.data;
        const promoContainer = document.getElementById('promoList');
        
        if (!promoContainer) return;
        
        // Kosongkan container
        promoContainer.innerHTML = '';
        
        // Jika tidak ada promo
        if (promos.length === 0) {
            promoContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada promo tersedia saat ini</p>
                </div>
            `;
            return;
        }
        
        // Tampilkan semua promo
        promos.forEach(promo => {
            const promoCard = createPromoCard(promo);
            promoContainer.innerHTML += promoCard;
        });
        
    } catch (error) {
        console.error('Error loading promos:', error);
    }
}

// Fungsi untuk membuat card promo
function createPromoCard(promo) {
    const discount = promo.discount_percentage ? `${promo.discount_percentage}% OFF` : '';
    const validPeriod = formatPeriod(promo.start_date, promo.end_date);
    
    return `
        <div class="col-md-4 mb-4 promo-item" data-region="${promo.region}">
            <div class="card promo-card">
                <div class="promo-img" style="background: linear-gradient(135deg, #6ed2de 0%, #29a4b8 100%); position: relative;">
                    ${discount ? `
                        <div style="position: absolute; top: 10px; right: 10px; background: #ff4757; color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 14px;">
                            ${discount}
                        </div>
                    ` : ''}
                    <div style="padding: 20px; color: white;">
                        <h5 style="font-weight: bold; margin-bottom: 10px;">${promo.title}</h5>
                        <p style="font-size: 12px; margin: 0;">${validPeriod}</p>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">${truncateText(promo.description, 80)}</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-outline-secondary btn-sm" onclick="showPromoDetail(${promo.id})">
                            Lihat Detail →
                        </button>
                        <button class="btn btn-order btn-sm" onclick="orderPromo(${promo.id})">
                            Pesan Sekarang →
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Fungsi untuk format periode promo
function formatPeriod(startDate, endDate) {
    const start = formatDate(startDate);
    const end = formatDate(endDate);
    return `Berlaku: ${start} - ${end}`;
}

// Fungsi untuk format tanggal
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { day: 'numeric', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('id-ID', options);
}

// Fungsi untuk memotong teks
function truncateText(text, maxLength) {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength) + '...';
}

// Fungsi filter promo berdasarkan region
function filterPromo(region) {
    const items = document.querySelectorAll('.promo-item');
    const filterBtns = document.querySelectorAll('.filter-btns button');
    
    // Update active button
    filterBtns.forEach(btn => {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-primary');
    });
    
    event.target.classList.remove('btn-outline-primary');
    event.target.classList.add('btn-primary');
    
    // Filter items
    items.forEach(item => {
        if (region === 'all' || item.dataset.region === region) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Fungsi untuk menampilkan detail promo (bisa dikembangkan dengan modal)
async function showPromoDetail(promoId) {
    try {
        const response = await fetch(`api.php?action=get_promo_by_id&id=${promoId}`);
        const result = await response.json();
        
        if (result.success) {
            const promo = result.data;
            
            // Buat modal atau alert untuk menampilkan detail
            alert(`
Promo: ${promo.title}

Deskripsi: ${promo.description}

Region: ${promo.region.toUpperCase()}
Diskon: ${promo.discount_percentage}%
Periode: ${formatDate(promo.start_date)} - ${formatDate(promo.end_date)}

Hubungi kami untuk info lebih lanjut!
            `.trim());
        }
    } catch (error) {
        console.error('Error loading promo detail:', error);
    }
}

// Fungsi untuk order promo (redirect atau buka form)
function orderPromo(promoId) {
    // Bisa redirect ke halaman pemesanan atau buka modal form
    alert(`Terima kasih! Anda akan dihubungi oleh tim kami untuk proses pemesanan promo ini.`);
    
    // Atau redirect ke WhatsApp
    // const waNumber = '6281234567890';
    // const message = `Halo, saya tertarik dengan promo ID: ${promoId}`;
    // window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`, '_blank');
}