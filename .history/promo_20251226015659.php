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
    .main-header {
  background: #ffffff;
  border-bottom: 1px solid #e5e5e5;
  position: sticky;
  top: 0;
  z-index: 1000;
}

.logo-iconnet {
  height: 64px;
  object-fit: contain;
}

@media (max-width: 768px) {
  .logo-iconnet {
    height: 50px;
  }
}

.navbar-nav .nav-link {
  font-weight: 600; /* TEBAL */
  color: #333 !important;
  padding: 8px 14px;
  position: relative;
  transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
  color: #0a91a8 !important;
}

/* Garis bawah saat hover */
.navbar-nav .nav-link::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  background: #0a91a8;
  left: 0;
  bottom: 0;
  transition: width 0.3s ease;
}

.navbar-nav .nav-link:hover::after,
.navbar-nav .nav-link.active::after {
  width: 100%;
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
  border-radius: 12px;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  position: relative;
}

/* Overlay gelap */
.slide::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.35);
  border-radius: 12px;
}

/* Text di tengah */
.slide-content {
  position: relative;
  z-index: 2;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 26px;
  font-weight: 700;
  text-align: center;
  padding: 20px;
}

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

    .promo-detail-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.promo-detail-card {
    background: #fff;
    max-width: 600px;
    width: 90%;
    border-radius: 12px;
    padding: 20px;
    position: relative;
    animation: zoomIn 0.3s ease;
}

@keyframes zoomIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
  </style>
</head>
<body>

<header class="main-header">
  <nav class="navbar navbar-expand-lg container">
    
    <!-- LOGO -->
    <a class="navbar-brand" href="index.php">
      <img src="image/iconnet.png" alt="ICONNET Logo" class="logo-iconnet">
    </a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navMenu" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="product.php">Product & Add On</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
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
  <!-- SLIDER -->
<div class="slider-container">
  <div class="slider" id="slider">

    <div class="slide" style="background-image: url('image/slide1.png');">
      <div class="slide-content">
        Promo Spesial Bulan Ini
      </div>
    </div>

    <div class="slide" style="background-image: url('imgae/slide2.png');">
      <div class="slide-content">
        Dapatkan Diskon Hingga 50%
      </div>
    </div>

    <div class="slide" style="background-image: url('image/slide3.jpg');">
      <div class="slide-content">
        Gratis Instalasi & Modem
      </div>
    </div>

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

// Fungsi untuk menampilkan detail promo
async function showPromoDetail(promoId) {
    try {
        const response = await fetch(`api.php?action=get_promo_by_id&id=${promoId}`);
        const result = await response.json();

        if (result.success) {
            const promo = result.data;

            // 🔹 ISI KONTEN DETAIL
            document.getElementById("promo-detail-content").innerHTML = `
                <h4 class="fw-bold mb-2">${promo.title}</h4>
                <p class="text-muted mb-3">${formatDate(promo.start_date)} - ${formatDate(promo.end_date)}</p>

                <p>${promo.description}</p>

                <div class="mt-3">
                    <span class="badge bg-primary me-2">${promo.region.toUpperCase()}</span>
                    <span class="badge bg-danger">${promo.discount_percentage}% OFF</span>
                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-order" onclick="orderPromo(${promo.id})">
                        Pesan Sekarang →
                    </button>
                </div>
            `;

            // 🔹 TAMPILKAN MODAL
            document.getElementById("promo-detail-wrapper").classList.remove("d-none");
        }
    } catch (error) {
        console.error("Error loading promo detail:", error);
        alert("Gagal memuat detail promo.");
    }
}

function closePromoDetail() {
    document.getElementById("promo-detail-wrapper").classList.add("d-none");
}

// Fungsi untuk order promo
async function orderPromo(promoId) {
    try {
        // 🔹 Ambil data promo
        const response = await fetch(`api.php?action=get_promo_by_id&id=${promoId}`);
        const result = await response.json();

        if (!result.success) {
            alert('Promo tidak ditemukan.');
            return;
        }

        const promo = result.data;

        // 🔹 Format pesan WhatsApp
        const message = `
Halo Admin,
Saya tertarik dengan promo berikut:

Nama Promo: ${promo.title}
Diskon: ${promo.discount_percentage ? promo.discount_percentage + '%' : '-'}
Periode: ${formatDate(promo.start_date)} - ${formatDate(promo.end_date)}
Region: ${promo.region.toUpperCase()}

Mohon info lebih lanjut. Terima kasih.
        `.trim();

        // 🔹 Nomor WhatsApp tujuan (GANTI INI)
        const phoneNumber = '6281252519535';

        // 🔹 Redirect ke WhatsApp
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');

    } catch (error) {
        console.error('Order promo error:', error);
        alert('Terjadi kesalahan saat memproses pesanan.');
    }
}


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
<div id="promo-detail-wrapper" class="promo-detail-overlay d-none">
    <div class="promo-detail-card">
        <button class="btn-close" onclick="closePromoDetail()"></button>
        <div id="promo-detail-content"></div>
    </div>
</div>
</body>
</html>