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
    }
    .promo-img {
      height: 140px;
      background: #6ed2de;
    }
    .btn-order {
      background: #0a5665;
      color: white;
    }
    .btn-order:hover {
      background: #094854;
      color: white;
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
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
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
      <div class="slide"></div>
      <div class="slide"></div>
      <div class="slide"></div>
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

    <!-- CARD -->
    <div class="col-md-4 mb-4 promo-item" data-region="jawa">
      <div class="card promo-card">
        <div class="promo-img"></div>
        <div class="card-body text-center">
          <button class="btn btn-outline-secondary btn-sm mb-2">Lihat Detail →</button><br>
          <button class="btn btn-order btn-sm">Pesan Sekarang →</button>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4 promo-item" data-region="sumatera">
      <div class="card promo-card">
        <div class="promo-img"></div>
        <div class="card-body text-center">
          <button class="btn btn-outline-secondary btn-sm mb-2">Lihat Detail →</button><br>
          <button class="btn btn-order btn-sm">Pesan Sekarang →</button>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4 promo-item" data-region="timur">
      <div class="card promo-card">
        <div class="promo-img"></div>
        <div class="card-body text-center">
          <button class="btn btn-outline-secondary btn-sm mb-2">Lihat Detail →</button><br>
          <button class="btn btn-order btn-sm">Pesan Sekarang →</button>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4 promo-item" data-region="jawa">
      <div class="card promo-card">
        <div class="promo-img"></div>
        <div class="card-body text-center">
          <button class="btn btn-outline-secondary btn-sm mb-2">Lihat Detail →</button><br>
          <button class="btn btn-order btn-sm">Pesan Sekarang →</button>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4 promo-item" data-region="sumatera">
      <div class="card promo-card">
        <div class="promo-img"></div>
        <div class="card-body text-center">
          <button class="btn btn-outline-secondary btn-sm mb-2">Lihat Detail →</button><br>
          <button class="btn btn-order btn-sm">Pesan Sekarang →</button>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4 promo-item" data-region="timur">
      <div class="card promo-card">
        <div class="promo-img"></div>
        <div class="card-body text-center">
          <button class="btn btn-outline-secondary btn-sm mb-2">Lihat Detail →</button><br>
          <button class="btn btn-order btn-sm">Pesan Sekarang →</button>
        </div>
      </div>
    </div>

  </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
  items.forEach(item => {
    if (region === 'all' || item.dataset.region === region) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });
}
</script>

</body>
</html>
