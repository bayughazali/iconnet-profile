<?php
$paket = [];

// WAJIB URL HTTP, BUKAN PATH FILE
$apiUrl = "http://localhost/iconnet-profile/api_paket.php";

// Ambil data dari API
$response = @file_get_contents($apiUrl);

if ($response !== false) {
    $json = json_decode($response, true);
    if (is_array($json)) {
        $paket = $json;
    }
}

// Anti error mutlak
if (!is_array($paket)) {
    $paket = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONNET - Internet Cepat & Terpercaya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid px-5">
        
        <a class="navbar-brand" href="#">
            <img src="image/iconnet.png" alt="ICONNET" style="height:90px; object-fit:contain;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-4">
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="Product.php">Product & Add on</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="#cara">Cara Berlangganan</a>
                </li>
            </ul>
            <a href="promo.php" class="btn-promo">PROMO</a>
        </div>

    </div>
</nav>


   <!-- Hero Section dengan Slider -->
<section class="hero-section" style="margin-top: 80px;">
    <div class="container">
        <div class="slider-container">

            <div class="slider-wrapper" id="heroSlider">
                
                <div class="slide">
                    <div class="hero-card" style="background-image: url('image/slide1.png');"></div>
                </div>

                <div class="slide">
                    <div class="hero-card" style="background-image: url('image/slide2.png');"></div>
                </div>

                <div class="slide">
                    <div class="hero-card" style="background-image: url('image/slide3.png');"></div>
                </div>

            </div>

            <!-- Indicators -->
            <div class="slider-indicators" id="sliderIndicators"></div>

        </div>
    </div>
</section>


    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon"><i class="fas fa-truck-fast"></i></div>
                        <h5>RELIABILITY</h5>
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon"><i class="fas fa-tags"></i></div>
                        <h5>AFFORDABLE</h5>
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                        <h5>UNLIMITED</h5>
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================
     PRICING SECTION - FINAL
     ======================================== -->
<section class="pricing-section" id="product">
    <div class="container">
        <div class="row">

            <!-- Location Selector -->
            <div class="col-lg-4 mb-4">
                <div class="location-selector">
                    <h4>Silakan pilih lokasi Anda untuk melihat detail paket dan harga yang berlaku.</h4>
                    
                    <div class="location-dropdown-container">
                        <button class="location-toggle custom-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#locationOptions" aria-expanded="false">
                            <span>
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <span class="fw-bold" id="selected-location-text">Sumatera & Kalimantan</span>
                            </span>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </button>

                        <div class="collapse location-options-list show" id="locationOptions">
                            <div class="location-item" data-location="sumatera-kalimantan">Sumatera & Kalimantan</div>
                            <div class="location-item" data-location="jawa-bali">Jawa & Bali</div>
                            <div class="location-item" data-location="indonesia-timur">Indonesia Timur</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Carousel -->
            <div class="col-lg-8 mb-4">
                <div id="packageCarousel" class="carousel slide" data-bs-ride="false">
                    
                    <div class="carousel-inner">

<?php
$chunks = array_chunk($paket, 3); // 3 card per slide
$active = 'active';
?>

<?php foreach ($chunks as $group): ?>
<div class="carousel-item <?= $active ?>">
    <div class="card-group-row">

        <?php foreach ($group as $p): ?>
        <div class="package-card">

            <h4><?= htmlspecialchars($p['name']) ?></h4>

            <div class="package-rating">
                <span class="rating-badge">★★ 4.5</span>
                <small>(1,500+ reviews)</small>
            </div>

            <div class="package-specs">
                <p><i class="fas fa-wifi"></i> <?= htmlspecialchars($p['kecepatan']) ?></p>
                <p><i class="fas fa-laptop"></i> <?= $p['max_laptop'] ?> Laptop</p>
                <p><i class="fas fa-mobile-alt"></i> <?= $p['max_smartphone'] ?> Smartphone</p>
                <p><i class="fas fa-network-wired"></i> <?= $p['max_perangkat'] ?> Total Devices</p>
            </div>

            <!-- HARGA SUMATERA -->
            <div class="package-card"
                data-sumatera-before="<?= $p['harga_sumatera_before'] ?>"
                data-sumatera="<?= $p['harga_sumatera'] ?>"
                data-jawa-before="<?= $p['harga_jawa_before'] ?>"
                data-jawa="<?= $p['harga_jawa'] ?>"
                data-timur-before="<?= $p['harga_timur_before'] ?>"
                data-timur="<?= $p['harga_timur'] ?>"
            >

    <h4><?= htmlspecialchars($p['name']) ?></h4>

    <div class="package-rating">
        <span class="rating-badge">★★ 4.5</span>
        <small>(1,500+ reviews)</small>
    </div>

    <div class="package-specs">
        <p><i class="fas fa-wifi"></i> <?= htmlspecialchars($p['kecepatan']) ?></p>
        <p><i class="fas fa-laptop"></i> <?= $p['max_laptop'] ?> Laptop</p>
        <p><i class="fas fa-mobile-alt"></i> <?= $p['max_smartphone'] ?> Smartphone</p>
        <p><i class="fas fa-network-wired"></i> <?= $p['max_perangkat'] ?> Total Devices</p>
    </div>

    <!-- 🔥 HARGA DINAMIS (JS ISI) -->
   <div 
  class="package-price"
  data-sumatera-before="<?= $p['harga_sumatera_before'] ?>"
  data-sumatera="<?= $p['harga_sumatera'] ?>"
  data-jawa-before="<?= $p['harga_jawa_before'] ?>"
  data-jawa="<?= $p['harga_jawa'] ?>"
  data-timur-before="<?= $p['harga_timur_before'] ?>"
  data-timur="<?= $p['harga_timur'] ?>"
>
</div>

<small>Biaya Bulanan</small>


    <button class="btn-pilih">
        Pesan Sekarang →
    </button>

    <small class="d-block mt-1">*Harga sudah termasuk PPN</small>

</div>


        </div>
        <?php endforeach; ?>

    </div>
</div>
<?php $active = ''; endforeach; ?>

</div>


                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#packageCarousel" data-bs-slide="prev">
                        <i class="fas fa-chevron-left carousel-control-icon"></i>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#packageCarousel" data-bs-slide="next">
                        <i class="fas fa-chevron-right carousel-control-icon"></i>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                </div>
            </div>

        </div>
    </div>
</section>

    <!-- Subscription Section -->
    <section class="subscription-section" id="cara">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 mb-4">
                    <div class="subscription-card">
                        <h2 class="mb-4">Cara Berlangganan</h2>
                        <p>Enjoy the large 200+ of unrealistic templates perfect slice of sensibilities.</p>
                        <button class="btn-detail mt-3">LIHAT DETAIL →</button>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <img src="image/langganan.png" class="img-fluid rounded">
                </div>

            </div>
        </div>
    </section>

    <!-- Mascot Section -->
    <section class="mascot-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 mb-4">
                    <img src="image/koni.png" class="img-fluid">
                </div>
                <div class="col-lg-6">
                    <h2 class="mb-4">Syarat & Ketentuan</h2>
                    <p>Get the best fixed chicken smeared with a lip smacking lemon chili flavor.</p>

                   <button class="btn-detail mt-3" data-bs-toggle="modal" data-bs-target="#modalSyarat">
                    Lihat Detail →
                    </button>
                </div>

            </div>
        </div>
        
        <!-- Service Icons Section -->
        <div class="row mt-5">
            <section class="service-icons-section py-5">
                <div class="container">
                    <div class="icon-group-container"> 
                        <div class="icon-group-wrapper">

                            <div class="service-item">
                                <div class="service-icon-svg">
                                    <svg width="80" height="80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="20" y="20" width="60" height="60" rx="10" fill="#20b2aa"/>
                                        <path d="M40 70L70 40M45 40L40 45M65 65L70 60M40 60C40 63.3137 42.6863 66 46 66C49.3137 66 52 63.3137 52 60C52 56.6863 49.3137 54 46 54C42.6863 54 40 56.6863 40 60Z" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="66" cy="40" r="6" fill="white"/>
                                    </svg>
                                </div>
                                <div class="service-text">
                                    <h6>Bayar Cepat</h6>
                                </div>
                            </div>

                            <div class="vertical-divider"></div>

                            <div class="service-item">
                                <div class="service-icon-svg">
                                    <svg width="80" height="80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M50 85C50 85 80 55 80 40C80 25.6667 66.5 15 50 15C33.5 15 20 25.6667 20 40C20 55 50 85 50 85Z" fill="#20b2aa" stroke="#20b2aa" stroke-width="3"/>
                                        <circle cx="50" cy="40" r="10" fill="white"/>
                                        <path d="M50 78.5L50 85L57 78.5H43L50 78.5Z" fill="#008080"/>
                                    </svg>
                                </div>
                                <div class="service-text">
                                    <h6>Cek Tagihan</h6>
                                </div>
                            </div>

                            <div class="vertical-divider"></div>

                            <div class="service-item">
                                <div class="service-icon-svg">
                                    <svg width="80" height="80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="50" cy="50" r="35" stroke="#20b2aa" stroke-width="5" fill="#E0F7FA"/>
                                        <path d="M50 30V50H70" stroke="#20b2aa" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="50" cy="50" r="3" fill="#20b2aa"/>
                                        <path d="M50 15V20M50 80V85M15 50H20M80 50H85" stroke="#20b2aa" stroke-width="3" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div class="service-text">
                                    <h6>Layanan Lengkap</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <!-- App Section -->
    <section class="app-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 mb-4">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='500'%3E%3Crect x='50' y='50' width='150' height='300' rx='20' fill='white' opacity='0.3'/%3E%3Crect x='200' y='100' width='150' height='300' rx='20' fill='white' opacity='0.5'/%3E%3C/svg%3E" class="img-fluid">
                </div>

                <div class="col-lg-6">
                    <h2>Unduh PLN Mobile, semua layanan listrik jadi lebih mudah!</h2>
                    <div class="app-badge mt-4 d-flex align-items-center flex-wrap gap-3">
                        
                        <a href="LINK_ANDA_KE_PLAYSTORE" target="_blank" class="store-link">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/200px-Google_Play_Store_badge_EN.svg.png" 
                                alt="Get it on Google Play" 
                                class="img-fluid store-icon">
                        </a>
                        
                        <a href="LINK_ANDA_KE_APPSTORE" target="_blank" class="store-link">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/200px-Download_on_the_App_Store_Badge.svg.png" 
                                alt="Download on the App Store" 
                                class="img-fluid store-icon">
                        </a>   
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="news-section py-5" style="background:#ffffff;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary mb-2">BERITA TERKINI</span>
                <h2 class="fw-bold">Update Info ICONNET</h2>
                <p class="text-muted">Informasi terbaru seputar layanan, promo, dan aktivitas ICONNET</p>
            </div>

            <div class="row g-4">

                <!-- News Item 1 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm news-card h-100">
                        <img src="image/pakkomang.png" class="card-img-top rounded-top" alt="News Image">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">ICONNET Capai 100+ Pelanggan Baru</h5>
                            <p class="text-muted small mb-2"><i class="far fa-calendar me-1"></i> 27 November 2025</p>
                            <p class="card-text">ICONNET terus memperluas jangkauan layanan dan berhasil mencapai lebih dari 100 pelanggan baru di wilayah jabodetabek.</p>
                            <a href="#" class="text-primary fw-semibold">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>

                <!-- News Item 2 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm news-card h-100">
                        <img src="https://via.placeholder.com/500x300" class="card-img-top rounded-top" alt="News Image">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Promo Akhir Tahun ICONNET</h5>
                            <p class="text-muted small mb-2"><i class="far fa-calendar me-1"></i> 25 November 2025</p>
                            <p class="card-text">Nikmati berbagai promo menarik ICONNET khusus akhir tahun. Kuota unlimited, harga hemat!</p>
                            <a href="#" class="text-primary fw-semibold">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>

                <!-- News Item 3 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm news-card h-100">
                        <img src="https://via.placeholder.com/500x300" class="card-img-top rounded-top" alt="News Image">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Perluasan Jaringan ICONNET 2025</h5>
                            <p class="text-muted small mb-2"><i class="far fa-calendar me-1"></i> 20 November 2025</p>
                            <p class="card-text">ICONNET resmi memperluas jaringan fiber optik ke beberapa kota besar untuk peningkatan kualitas internet.</p>
                            <a href="#" class="text-primary fw-semibold">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-4">
                <button class="btn btn-promo px-4 py-2">Lihat Semua Berita</button>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">

            <div class="text-center mb-5">
                <h2>Paling sering ditanyakan</h2>
            </div>

            <div class="row">

                <div class="col-lg-6">

                    <div class="faq-item">
                        <h5>What is Midana? <i class="fas fa-times float-end"></i></h5>
                        <p class="mt-3">Midana is the world's largest software library...</p>
                    </div>

                    <div class="faq-item">
                        <h5>How often do you update the library? <i class="fas fa-plus float-end"></i></h5>
                    </div>

                    <div class="faq-item">
                        <h5>Can I get a free trial? <i class="fas fa-plus float-end"></i></h5>
                    </div>

                    <div class="faq-item">
                        <h5>Do you have a monthly plan? <i class="fas fa-plus float-end"></i></h5>
                    </div>

                    <div class="faq-item">
                        <h5>Any discount for students? <i class="fas fa-plus float-end"></i></h5>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="house-illustration text-center">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cellipse cx='200' cy='350' rx='150' ry='30' fill='%23C8E6F5' opacity='0.5'/%3E%3Cpath d='M 200 100 L 280 180 L 280 320 L 120 320 L 120 180 Z' fill='%23E8F4F8'/%3E%3Cpath d='M 150 100 L 200 100 L 200 50 L 150 50 Z' fill='%23A5D8E8'/%3E%3Crect x='160' y='220' width='40' height='100' fill='%238B7355'/%3E%3C/svg%3E" class="img-fluid">
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2024 ICONNET. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="login.php" class="btn btn-outline-light btn-sm px-4">
                        <i class="fas fa-user-shield me-2"></i>Admin Login
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <!-- Load News and FAQ Script -->
    <script src="load_news_faq.js"></script>

    <!-- Main Dynamic Package Script -->
    <script src="index.js"></script>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("heroSlider");
    const slides = slider.children;
    const indicators = document.getElementById("sliderIndicators");

    let index = 0;
    const total = slides.length;
    let interval;

    // indikator (PASTI 3)
    for (let i = 0; i < total; i++) {
        const dot = document.createElement("span");
        dot.classList.add("indicator");
        if (i === 0) dot.classList.add("active");

        dot.addEventListener("click", () => {
            index = i;
            update();
            reset();
        });

        indicators.appendChild(dot);
    }

    const dots = indicators.children;

    function update() {
        slider.style.transform = `translateX(-${index * 100}%)`;
        [...dots].forEach(d => d.classList.remove("active"));
        dots[index].classList.add("active");
    }

    function next() {
        index = (index + 1) % total;
        update();
    }

    function reset() {
        clearInterval(interval);
        interval = setInterval(next, 5000);
    }

    reset();
}); 
</script>

</body>
</html>