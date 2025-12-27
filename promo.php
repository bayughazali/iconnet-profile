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
    :root {
    --primary-color: #20b2aa;
    --primary-dark: #008080;
    --text-dark: #2c3e50;
}
body {
  padding-top: 90px;
  background: linear-gradient(180deg, #f4fbfd, #edf6fa);
  font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
  color: #2c2c2c;
}

@media (max-width: 768px) {
  .logo-iconnet {
    height: 50px;
  }
}

/* ========== NAVBAR (SAMA DENGAN INDEX) ========== */
.navbar {
    padding: 0.5rem 0;
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    left: 0;
}

.navbar-brand img {
    height: 70px;
    object-fit: contain;
}

.nav-link {
    color: #2c2c2c !important;
    margin: 0 15px;
    font-weight: 600;
    transition: color 0.3s;
    font-size: 1rem;
}

.nav-link:hover,
.nav-link.active {
    color: #0d6efd !important;
}

/* Tombol PROMO */
.btn-promo {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 10px 30px;
    border-radius: 25px;
    text-decoration: none;
    border: none;
    transition: all 0.3s;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
}

.btn-promo:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(32, 178, 170, 0.4);
    color: white;
}

.navbar-nav .nav-link:hover {
  color: #0a91a8 !important;
}

.navbar-nav .nav-link:hover::after,
.navbar-nav .nav-link.active::after {
  width: 100%;
}


    /* Slider */
/* ===== SLIDER (VERSI AWAL / ORIGINAL) ===== */

.slider-container {
  position: relative;
  overflow: hidden;
  margin-top: 15px;
}

.slider {
  display: flex;
  transition: transform .5s ease;
}
/*  */
.slide {
  min-width: 100%;
  height: 400px; /* tinggi awal */
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
  margin: 6px;
  border-radius: 999px;
  padding: 8px 20px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.filter-btns button.btn-primary {
  box-shadow: 0 6px 16px rgba(13,110,253,0.35);
}

    /* Card promo */
.promo-card {
  border-radius: 20px;
  border: none;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  transition: all 0.35s ease;
  height: 300px;
}

.promo-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 18px 45px rgba(0,0,0,0.15);
}

.promo-img {
  height: 180px;
  background-size: cover;
  background-position: center;
  position: relative;
}
.promo-discount-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  background: linear-gradient(135deg, #ff4757, #ff6b81);
  color: #fff;
  padding: 6px 14px;
  border-radius: 999px;
  font-size: 13px;
  font-weight: 700;
  box-shadow: 0 6px 15px rgba(255,71,87,0.4);
}

.btn-order:hover {
  opacity: 0.9;
}

/*  */
    
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
  max-width: 900px;
  width: 95%;
  border-radius: 20px;
  box-shadow: 0 30px 70px rgba(0,0,0,0.25);
}
.promo-container {
  max-width: 1400px;
  margin: 0 auto;
  padding-left: 20px;
  padding-right: 20px;
}

@keyframes zoomIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.main-header {
    background: #eef7fb;
}

.navbar {
    padding: 12px 0;
}

.logo-iconnet {
    height: 60px;
    object-fit: contain;
}

.navbar-nav .nav-link {
    font-weight: 500;
    color: #333;
}

.navbar-nav .nav-link.active {
    font-weight: 600;
    color: #0d6efd;
}

.navbar-nav .nav-link:hover {
    color: #0d6efd;
}
body {
    padding-top: 90px; 
}/* SESUAI tinggi navbar */

/* ================= BUTTON PROMO ================= */
/* Lihat Detail */
.btn-detail {
  background: #ffffff;
  border: 2px solid #252179ff;
  color: #252179ff;
  font-weight: 600;
  border-radius: 999px;
  padding: 6px 16px;
  transition: all 0.25s ease;
}

.btn-detail:hover {
  background: #252179ff;
  color: #ffffff;
  box-shadow: 0 6px 18px rgba(255, 255, 255, 1);
  transform: translateY(-1px);
}

/* Pesan Sekarang */
.btn-order {
  background: linear-gradient(135deg, #252179ff, #252179ff);
  color: #ffffff;
  border: none;
  font-weight: 600;
  border-radius: 999px;
  padding: 6px 18px;
  transition: all 0.25s ease;
}

.btn-order:hover {
  opacity: 0.95;
  box-shadow: 0 6px 20px rgba(13,110,253,0.45);
  transform: translateY(-1px);
  color: #ffffff;
}
/* ========================= */
/* PROMO DETAIL DESCRIPTION */
/* ========================= */

.promo-description-box {
    max-height: 260px;        /* batas tinggi */
    overflow-y: auto;         /* ✅ scroll ke bawah */
    overflow-x: hidden;       /* ❌ MATIKAN scroll samping */
    padding: 15px 18px;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

/* Scrollbar halus */
.promo-description-box::-webkit-scrollbar {
    width: 6px;
}
.promo-description-box::-webkit-scrollbar-thumb {
    background: #cfd8dc;
    border-radius: 10px;
}
.modal-body {
    max-height: 75vh;   /* 🔥 modal tidak kepanjangan */
    overflow-y: auto;
}
#promoDetailDescription {
    white-space: pre-line;     /* jaga enter */
    word-break: break-word;    /* 🔥 potong kata panjang */
    overflow-wrap: break-word; /* 🔥 anti overflow */
    line-height: 1.7;
    font-size: 15px;
    color: #374151;
}
.modal-body {
    max-height: 75vh;
    overflow-y: auto;
    overflow-x: hidden;
}
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid px-5">

        <a class="navbar-brand" href="index.php">
            <img src="image/iconnet.png" class="logo-iconnet" alt="ICONNET">
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-4">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product.php">Product & Add on</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#cara">Cara Berlangganan</a>
                </li>
            </ul>

            <!-- Tombol PROMO -->
            <a href="promo.php" class="btn-promo ms-3">PROMO</a>
        </div>

    </div>
  </nav>
</header>




<div class="container mt-3">

  <a href="index.php" class="text-decoration-none text-secondary mb-2 d-inline-block">
    <i class="bi bi-arrow-left"></i> Kembali ke halaman sebelumnya
  </a>

  <!-- SLIDER -->
<div class="slider-container">
  <div class="slider" id="slider">

    <div class="slide" style="background-image: url('image/slide1.png');">
      <div class="slide-content">
      </div>
    </div>

    <div class="slide" style="background-image: url('image/slide2.png');">
      <div class="slide-content">
      </div>
    </div>

    <div class="slide" style="background-image: url('image/slide3.png');">
      <div class="slide-content">
      </div>
    </div>

  </div>
</div>

  <!-- FILTER -->
<div class="filter-btns text-center mt-4">
    <button class="btn btn-primary filter-btn" data-filter="all"
            onclick="filterPromo('all')">Semua</button>

    <button class="btn btn-outline-primary filter-btn" data-filter="sumatera"
            onclick="filterPromo('sumatera')">Sumatera & Kalimantan</button>

    <button class="btn btn-outline-primary filter-btn" data-filter="jawa"
            onclick="filterPromo('jawa')">Jawa & Bali</button>

    <button class="btn btn-outline-primary filter-btn" data-filter="timur"
            onclick="filterPromo('timur')">Indonesia Timur</button>
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

    // 🔵 1. UPDATE WARNA BUTTON
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-primary');

        if (btn.dataset.filter === region) {
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-primary');
        }
    });

    // 🔵 2. LOGIKA FILTER PROMO (yang sudah kita buat sebelumnya)
    document.querySelectorAll('.promo-item').forEach(item => {
        const itemRegion = item.dataset.region.toLowerCase();

        if (itemRegion === 'semua' || itemRegion === 'all') {
            item.style.display = 'block';
            return;
        }

        if (region === 'all' || itemRegion === region) {
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
const discount = promo.discount_percentage > 0
    ? `${promo.discount_percentage}% OFF`
    : '';

    const validPeriod = formatPeriod(promo.start_date, promo.end_date);

    // ✅ LANGSUNG DARI DATABASE
    const imageUrl = promo.image_path && promo.image_path.trim() !== ''
        ? promo.image_path
        : 'image/default-promo.jpg';

    console.log('IMAGE:', imageUrl);

    return `
        <div class="col-md-4 mb-4 promo-item" data-region="${promo.region}">
            <div class="card promo-card">

                <div class="promo-img"
                     style="
                        background-image: url('${imageUrl}');
                        background-size: cover;
                        background-position: center;
                        height: 200px;
                        position: relative;
                     ">

                    ${discount ? `
    <div style="
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff4757;
        color: white;
        padding: 5px 14px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 13px;">
        ${discount}
    </div>
` : ''}

                    <div style="
                        position: absolute;
                        bottom: 0;
                        width: 100%;
                        padding: 12px;
                        background: linear-gradient(to top, rgba(0,0,0,0.65), transparent);
                        color: white;">
                        <h6 class="mb-0 fw-bold">${promo.title}</h6>
                        <small>${validPeriod}</small>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-muted small mb-3">
                        ${truncateText(promo.description, 80)}
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
<button class="btn btn-detail btn-sm"
        onclick="showPromoDetail(${promo.id})">
    <i class="bi bi-eye"></i> Lihat Detail
</button>
                        <button class="btn btn-order btn-sm"
                                onclick="orderPromo(${promo.id})">
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
            // 🔹 Simpan promo ID ke button "Pesan Sekarang" di modal
document.getElementById('btnOrderFromDetail')
        .setAttribute('data-promo-id', promo.id);

            // 📌 Tentukan gambar
            const imageUrl = promo.image_path && promo.image_path.trim() !== ''
                ? promo.image_path
                : 'image/default-promo.jpg';

            // 📌 Isi modal
            document.getElementById('promoDetailTitle').innerText = promo.title;
            document.getElementById('promoDetailImage').src = imageUrl;

            document.getElementById('promoDetailPeriod').innerText =
                `Periode: ${formatDate(promo.start_date)} - ${formatDate(promo.end_date)}`;

            document.getElementById('promoDetailRegion').innerText =
                promo.region.toUpperCase();

            document.getElementById('promoDetailDescription').innerText =
                promo.description;

            // 📌 Diskon (hanya jika > 0)
            const discountEl = document.getElementById('promoDetailDiscount');
            if (promo.discount_percentage > 0) {
                discountEl.innerText = `Diskon ${promo.discount_percentage}%`;
                discountEl.style.display = 'block';
            } else {
                discountEl.style.display = 'none';
            }

            // 📌 Tampilkan modal
            const modal = new bootstrap.Modal(
                document.getElementById('promoDetailModal')
            );
            modal.show();
        }
    } catch (error) {
        console.error('Error loading promo detail:', error);
        alert('Gagal memuat detail promo.');
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
// 🔥 EVENT BUTTON MODAL (DIPASANG SEKALI)
document.addEventListener('DOMContentLoaded', function () {
    const orderBtn = document.getElementById('btnOrderFromDetail');

    if (!orderBtn) return;

    orderBtn.addEventListener('click', function () {
        const promoId = this.getAttribute('data-promo-id');

        if (!promoId) {
            alert('Promo belum dipilih.');
            return;
        }

        orderPromo(promoId);
    });
});

</script>
<div id="promo-detail-wrapper" class="promo-detail-overlay d-none">
    <div class="promo-detail-card">
        <button class="btn-close" onclick="closePromoDetail()"></button>
        <div id="promo-detail-content"></div>
    </div>
</div>
<!-- MODAL DETAIL PROMO -->
<div class="modal fade" id="promoDetailModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="promoDetailTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

<div class="modal-body p-4">
<img id="promoDetailImage"
     src=""
     class="img-fluid rounded mb-3"
     alt="Promo Image"
     style="
        width: 100%;
        max-height: 450px;
        object-fit: contain;
        background-color: #f8f9fa;
     ">

        <p class="text-muted mb-1" id="promoDetailPeriod"></p>
        <p class="mb-1"><strong>Wilayah:</strong> <span id="promoDetailRegion"></span></p>
        <p class="mb-2 text-danger fw-bold" id="promoDetailDiscount"></p>

        <hr>
<div class="promo-description-box">
    <p id="promoDetailDescription"></p>
</div>
      </div>

      <div class="modal-footer">
<button class="btn btn-outline-secondary rounded-pill px-4"
        data-bs-dismiss="modal">
    Tutup
</button>

<button class="btn btn-order px-4"
        id="btnOrderFromDetail">
    <i class="bi bi-whatsapp"></i> Pesan Sekarang
</button>

      </div>
<!--  -->
    </div>
  </div>
</div>

</body>
</html>