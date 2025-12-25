<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ICONNET - Promo</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    body {
      background: #edf6fa;
      font-family: 'Segoe UI', sans-serif;
    }
    header {
      background: white;
      border-bottom: 1px solid #ddd;
    }
    .navbar-brand {
      font-weight: bold;
      color: #0a91a8 !important;
    }

    .promo-title {
      text-align: center;
      font-weight: bold;
      font-size: 28px;
      margin-top: 15px;
      color: #0a91a8;
    }

    /* Slider */
    .slider-container {
      position: relative;
      overflow: hidden;
      margin-top: 15px;
    }
    .slider {
      display: flex;
      transition: transform .5s ease;
    }
    .slide {
      min-width: 100%;
      height: 220px;
      background: #29a4b8;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 24px;
      font-weight: bold;
    }
    .slider-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: #1b3b45;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: none;
      cursor: pointer;
      z-index: 10;
    }
    .slider-btn:hover {
      background: #0a5665;
    }
    .prev { left: 10px; }
    .next { right: 10px; }

    /* Filter */
    .filter-btns button {
      margin: 5px;
      border-radius: 8px;
    }

    /* Card promo */
    .promo-card {
      border-radius: 15px;
      border: none;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,.1);
      transition: transform 0.3s ease;
      height: 100%;
    }
    .promo-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 12px rgba(0,0,0,.15);
    }
    .promo-img {
      height: 140px;
      background: linear-gradient(135deg, #6ed2de 0%, #29a4b8 100%);
      position: relative;
    }
    .btn-order {
      background: #0a5665;
      color: white;
    }
    .btn-order:hover {
      background: #094854;
      color: white;
    }
    
    /* Loading state */
    .loading-spinner {
      text-align: center;
      padding: 40px;
    }
    
    /* Empty state */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #6c757d;
    }
    .empty-state i {
      font-size: 64px;
      margin-bottom: 20px;
      opacity: 0.5;
    }
  </style>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg container">
    <a class="navbar-brand" href="#">ICONNET</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navMenu" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Product & Add on</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
      </ul>
    </div>
  </nav>
</header>

<div class="container mt-3">

  <a href="index.php" class="text-decoration-none text-secondary mb-2 d-inline-block">
    <i class="bi bi-arrow-left"></i> Kembali ke halaman sebelumnya
  </a>

  <div class="promo-title">PROMO</div>

  <!-- SLIDER -->
  <div class="slider-container">
    <div class="slider" id="slider">
      <div class="slide">Promo Spesial Bulan Ini</div>
      <div class="slide">Dapatkan Diskon Hingga 50%</div>
      <div class="slide">Gratis Instalasi & Modem</div>
    </div>
    <button class="slider-btn prev" onclick="prevSlide()">‹</button>
    <button class="slider-btn next" onclick="nextSlide()">›</button>
  </div>

  <!-- FILTER -->
  <div class="filter-btns text-center mt-4">
    <button class="btn btn-primary" onclick="filterPromo('all')">Semua</button>
    <button class="btn btn-outline-primary" onclick="filterPromo('sumatera')">Sumatera & Kalimantan</button>
    <button class="btn btn-outline-primary" onclick="filterPromo('jawa')">Jawa & Bali</button>
    <button class="btn btn-outline-primary" onclick="filterPromo('timur')">Indonesia Timur</button>
  </div>

  <!-- PROMO LIST -->
  <div class="row mt-4" id="promoList">
    <!-- Loading State -->
    <div class="col-12 loading-spinner">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-3 text-muted">Memuat promo...</p>
    </div>
  </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Load Promo Script -->
<script>
/* SLIDER SCRIPT */
let index = 0;
const total = document.querySelectorAll('.slide').length;
const slider = document.getElementById('slider');

function updateSlide() {
  slider.style.transform = `translateX(-${index * 100}%)`;
}

function nextSlide() {
  index = (index + 1) % total;
  updateSlide();
}

function prevSlide() {
  index = (index - 1 + total) % total;
  updateSlide();
}

/* AUTO SLIDE */
setInterval(nextSlide, 4000);

/* FILTER SCRIPT */
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

/* ================== LOAD PROMO FROM DATABASE ================== */
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
            showEmptyState();
            return;
        }
        
        const promos = result.data;
        const promoContainer = document.getElementById('promoList');
        
        if (!promoContainer) return;
        
        // Kosongkan container
        promoContainer.innerHTML = '';
        
        // Jika tidak ada promo
        if (promos.length === 0) {
            showEmptyState();
            return;
        }
        
        // Tampilkan semua promo
        promos.forEach(promo => {
            const promoCard = createPromoCard(promo);
            promoContainer.innerHTML += promoCard;
        });
        
    } catch (error) {
        console.error('Error loading promos:', error);
        showErrorState();
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
                      <button class="btn btn-order btn-sm pesan-sekarang"
                          data-nama="hebat 6"
                          data-deskripsi="ini hebat 6"
                          data-region="ALL"
                          data-diskon="0.00%"
                          data-periode="9 Des 2025 - 31 Jan 2026">
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

// Fungsi untuk menampilkan detail promo
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
        alert('Gagal memuat detail promo. Silakan coba lagi.');
    }
}

function pesanSekarang(promo) {
    alert(
        `Promo: ${promo.nama}\n\n` +
        `Deskripsi: ${promo.deskripsi}\n\n` +
        `Region: ${promo.region}\n` +
        `Diskon: ${promo.diskon}\n` +
        `Periode: ${promo.periode}\n\n` +
        `Hubungi kami untuk info lebih lanjut!`
    );
}

// Fungsi untuk order promo
// function orderPromo(promoId) {
//     // Bisa redirect ke halaman pemesanan atau buka modal form
//     const confirmation = confirm('Anda akan dihubungi oleh tim kami untuk proses pemesanan promo ini. Lanjutkan?');
    
//     if (confirmation) {
//         alert('Terima kasih! Anda akan dihubungi oleh tim kami segera.');
        
//         // Optional: redirect ke WhatsApp
//         // const waNumber = '6281234567890';
//         // const message = `Halo, saya tertarik dengan promo ID: ${promoId}`;
//         // window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`, '_blank');
//     }
// }

// Fungsi untuk menampilkan empty state
function showEmptyState() {
    const promoContainer = document.getElementById('promoList');
    promoContainer.innerHTML = `
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5>Belum Ada Promo</h5>
                <p class="text-muted">Belum ada promo tersedia saat ini. Silakan cek kembali nanti.</p>
            </div>
        </div>
    `;
}

// Fungsi untuk menampilkan error state
function showErrorState() {
    const promoContainer = document.getElementById('promoList');
    promoContainer.innerHTML = `
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-exclamation-triangle"></i>
                <h5>Gagal Memuat Promo</h5>
                <p class="text-muted">Terjadi kesalahan saat memuat data. Silakan refresh halaman.</p>
                <button class="btn btn-primary mt-3" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
            </div>
        </div>
    `;
}
</script>
</body>
<script>
document.querySelectorAll('.pesan-sekarang').forEach(button => {
    button.addEventListener('click', function () {
        alert(
            `Promo: ${this.dataset.nama}\n\n` +
            `Deskripsi: ${this.dataset.deskripsi}\n\n` +
            `Region: ${this.dataset.region}\n` +
            `Diskon: ${this.dataset.diskon}\n` +
            `Periode: ${this.dataset.periode}\n\n` +
            `Hubungi kami untuk info lebih lanjut!`
        );
    });
});
</script>
</html>