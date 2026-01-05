index.php
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

                    <div class="slide">
                        <div class="hero-card" style="background-image: url('image/s.png');"></div>
                    </div>

                </div>

                <!-- Indicators -->
                <div class="slider-indicators" id="sliderIndicators"></div>

            </div>
        </div>
    </section>


    <!-- Features Section -->
    <!-- ========================================
 PRICING SECTION - FIXED
======================================== -->
<section class="pricing-section" id="product">
  <div class="container">

    <div class="pricing-layout">

<!-- KIRI: PILIH LOKASI -->
<div class="pricing-left">
  <div class="location-selector">
    <h4>
      Silakan pilih lokasi Anda untuk melihat detail paket dan harga yang berlaku.
    </h4>

    <div class="location-dropdown-container">
      <button class="custom-dropdown-toggle" type="button">
        <span>
          <i class="fas fa-map-marker-alt"></i>
          Sumatera & Kalimantan
        </span>
        <i class="fas fa-chevron-down dropdown-icon"></i>
      </button>

      <div class="location-options-list" style="display: none;">
        <div class="location-item">Sumatera & Kalimantan</div>
        <div class="location-item">Jawa & Bali</div>
        <div class="location-item">Indonesia Timur</div>
      </div>
    </div>

    <!-- ✅ TAMBAHAN BARU: Text & Button Bandingkan -->
    <div class="compare-section">
      <p class="compare-text">
        <i class="fas fa-question-circle"></i>
      Masih ragu menentukan pilihan paket? Yuk, bandingkan paket-paket terbaik di sini dan temukan yang paling pas untuk Anda.
      </p>
      <a href="product.php" class="btn-compare">
        <i class="fas fa-balance-scale"></i>
        Bandingkan Paket
      </a>
    </div>
    <!-- ✅ AKHIR TAMBAHAN -->

  </div>
</div>

      <!-- KANAN: PROMO / PACKAGE -->
      <div class="pricing-right">

        <div id="packageCarousel" class="carousel slide" data-bs-ride="false">

          <div class="carousel-inner">
            <!-- Data akan diisi oleh JavaScript -->
          </div>

          <!-- CONTROLS -->
          <button class="carousel-control-prev" type="button" data-bs-target="#packageCarousel" data-bs-slide="prev">
            <i class="fas fa-chevron-left carousel-control-icon"></i>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#packageCarousel" data-bs-slide="next">
            <i class="fas fa-chevron-right carousel-control-icon"></i>
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
                                    <svg width="80" height="80" viewBox="0 0 100 100" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="20" y="20" width="60" height="60" rx="10" fill="#20b2aa" />
                                        <path
                                            d="M40 70L70 40M45 40L40 45M65 65L70 60M40 60C40 63.3137 42.6863 66 46 66C49.3137 66 52 63.3137 52 60C52 56.6863 49.3137 54 46 54C42.6863 54 40 56.6863 40 60Z"
                                            stroke="white" stroke-width="5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <circle cx="66" cy="40" r="6" fill="white" />
                                    </svg>
                                </div>
                                <div class="service-text">
                                    <h6>Bayar Cepat</h6>
                                </div>
                            </div>

                            <div class="vertical-divider"></div>

                            <div class="service-item">
                                <div class="service-icon-svg">
                                    <svg width="80" height="80" viewBox="0 0 100 100" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M50 85C50 85 80 55 80 40C80 25.6667 66.5 15 50 15C33.5 15 20 25.6667 20 40C20 55 50 85 50 85Z"
                                            fill="#20b2aa" stroke="#20b2aa" stroke-width="3" />
                                        <circle cx="50" cy="40" r="10" fill="white" />
                                        <path d="M50 78.5L50 85L57 78.5H43L50 78.5Z" fill="#008080" />
                                    </svg>
                                </div>
                                <div class="service-text">
                                    <h6>Cek Tagihan</h6>
                                </div>
                            </div>

                            <div class="vertical-divider"></div>

                            <div class="service-item">
                                <div class="service-icon-svg">
                                    <svg width="80" height="80" viewBox="0 0 100 100" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="50" cy="50" r="35" stroke="#20b2aa" stroke-width="5"
                                            fill="#E0F7FA" />
                                        <path d="M50 30V50H70" stroke="#20b2aa" stroke-width="5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <circle cx="50" cy="50" r="3" fill="#20b2aa" />
                                        <path d="M50 15V20M50 80V85M15 50H20M80 50H85" stroke="#20b2aa" stroke-width="3"
                                            stroke-linecap="round" />
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

                <div class="col-lg-6 mb-4 text-center text-lg-start">
                    <img src="image/hpIconnet2.png" alt="PLN Mobile App" class="img-fluid app-phone">
                </div>


                <div class="col-lg-6">
                    <h2>Unduh PLN Mobile, semua layanan listrik jadi lebih mudah!</h2>
                    <div class="app-badge mt-4 d-flex align-items-center flex-wrap gap-3">

                        <a href="https://play.google.com/store/apps/details?id=com.icon.pln123" target="_blank"
                            rel="noopener noreferrer" class="store-link">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/200px-Google_Play_Store_badge_EN.svg.png"
                                alt="Get it on Google Play" class="img-fluid store-icon">
                        </a>


                        <a href="https://apps.apple.com/id/app/pln-mobile/id1299581030?l=id" target="_blank"
                            rel="noopener noreferrer" class="store-link">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/200px-Download_on_the_App_Store_Badge.svg.png"
                                alt="Download on the App Store" class="img-fluid store-icon">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="news-section" id="berita">
    <div class="container-fluid px-5">
        <!-- Header -->
        <div class="section-header text-center">
            <span class="news-badge">BERITA TERKINI</span>
            <h2>Update Info ICONNET</h2>
            <p>Informasi terbaru seputar layanan, promo, dan aktivitas ICONNET</p>
        </div>

        <!-- News Carousel -->
        <div class="row g-4" id="newsContainer">
            <!-- Carousel akan diisi oleh load_news_faq.js -->
            <div class="col-12 text-center">
                <p class="text-muted">
                    <i class="fas fa-spinner fa-spin me-2"></i>
                    Memuat berita...
                </p>
            </div>
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
                <!-- FAQ Container - akan diisi oleh JavaScript -->
                <div id="faqContainer">
                    <div class="faq-item">
                        <h5><i class="fas fa-spinner fa-spin me-2"></i>Memuat FAQ...</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="house-illustration text-center">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cellipse cx='200' cy='350' rx='150' ry='30' fill='%23C8E6F5' opacity='0.5'/%3E%3Cpath d='M 200 100 L 280 180 L 280 320 L 120 320 L 120 180 Z' fill='%23E8F4F8'/%3E%3Cpath d='M 150 100 L 200 100 L 200 50 L 150 50 Z' fill='%23A5D8E8'/%3E%3Crect x='160' y='220' width='40' height='100' fill='%238B7355'/%3E%3C/svg%3E"
                        class="img-fluid">
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
</script>

<!-- Modal Pesan Sekarang - Detail Lengkap -->
<div id="modalPesan" class="modal">
  <div class="modal-content-custom">
    <span class="modal-close">&times;</span>
    
    <!-- Header Modal -->
    <div class="modal-header-custom">
      <i class="fas fa-shopping-cart"></i>
      <h2>Detail Pemesanan Paket</h2>
    </div>
    
    <!-- Body Modal -->
    <div class="modal-body-custom">
      
      <!-- Package Info Card -->
      <div class="detail-card">
        <div class="detail-card-header">
          <i class="fas fa-box"></i>
          <h4>Informasi Paket</h4>
        </div>
        <div class="detail-item">
          <span class="detail-label">
            <i class="fas fa-tag"></i> Nama Paket
          </span>
          <span class="detail-value" id="modalNama">-</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">
            <i class="fas fa-wifi"></i> Kecepatan
          </span>
          <span class="detail-value" id="modalKecepatan">-</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">
            <i class="fas fa-map-marker-alt"></i> Wilayah Pemasangan
          </span>
          <span class="detail-value" id="modalWilayah">-</span>
        </div>
      </div>

      <!-- Pricing Card -->
      <div class="detail-card pricing-card">
        <div class="detail-card-header">
          <i class="fas fa-money-bill-wave"></i>
          <h4>Rincian Harga</h4>
        </div>
        
        <!-- Biaya Bulanan -->
        <div class="price-section">
          <div class="price-label">
            <i class="fas fa-calendar-alt"></i>
            <span>Biaya Bulanan</span>
          </div>
          <div class="price-display">
            <span class="price-before" id="modalHargaBefore">Rp. 0</span>
            <span class="price-arrow">→</span>
            <span class="price-after" id="modalHargaAfter">Rp. 0</span>
          </div>
          <div class="price-badge">
            <i class="fas fa-percent"></i>
            <span id="modalDiskon">Hemat Rp. 0</span>
          </div>
        </div>

        <div class="divider-line"></div>

        <!-- Biaya Instalasi -->
        <div class="price-section">
          <div class="price-label">
            <i class="fas fa-tools"></i>
            <span>Biaya Instalasi</span>
          </div>
          <div class="price-display">
            <span class="price-before-install" id="modalInstallBefore">Rp. 0</span>
            <span class="price-arrow">→</span>
            <span class="price-after-install" id="modalInstallAfter">Rp. 0</span>
          </div>
          <div class="price-badge install-badge">
            <i class="fas fa-percent"></i>
            <span id="modalDiskonInstall">Hemat Rp. 0</span>
          </div>
        </div>

        <div class="divider-line"></div>

        <!-- Total -->
        <div class="total-section">
          <span class="total-label">Total Biaya</span>
          <span class="total-value" id="modalTotal">Rp. 0</span>
        </div>

        <p class="price-note">
          <i class="fas fa-info-circle"></i>
          *Harga sudah termasuk PPN 11%
        </p>
      </div>

      <!-- Additional Info -->
      <div class="info-box">
        <i class="fas fa-check-circle"></i>
        <div>
          <strong>Masa Kontrak: 12 Bulan</strong>
          <p>Dapatkan layanan internet stabil dengan garansi kualitas terbaik</p>
        </div>
      </div>

    </div>

    <!-- Footer Modal -->
    <div class="modal-footer-custom">
      <button id="btnWhatsapp" class="btn-wa">
        <i class="fab fa-whatsapp"></i>
        Pesan via WhatsApp
      </button>
      <button class="btn-cancel">
        <i class="fas fa-times"></i>
        Batal
      </button>
    </div>
    
  </div>
</div>

<!-- Modal Syarat & Ketentuan -->
<!-- Modal Syarat & Ketentuan - Modern Light Theme -->
<div class="modal fade" id="modalSyarat" tabindex="-1" aria-labelledby="modalSyaratLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      
      <!-- Header -->
      <div class="modal-header border-0">
        <h3 class="modal-title" id="modalSyaratLabel">
          <i class="fas fa-file-contract"></i>
          Syarat & Ketentuan ICONNET
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Body -->
      <div class="modal-body">
        <div class="terms-content">
          
          <!-- Term 1 -->
          <div class="term-section">
            <h5>
              <span class="term-number">1</span>
              Definisi
            </h5>
            <p>Pasal ini menjelaskan istilah-istilah penting yang digunakan dalam layanan ICONNET, seperti pelanggan, layanan ICONNET, perangkat (modem/STB), gangguan, dan data pribadi, agar tidak terjadi perbedaan pemahaman antara pelanggan dan PLN Icon Plus.</p>
          </div>

          <!-- Term 2 -->
          <div class="term-section">
            <h5>
              <span class="term-number">2</span>
              Ruang Lingkup Layanan
            </h5>
            <p>ICONNET adalah layanan internet rumah untuk penggunaan pribadi (residential) dengan kecepatan "up to", hanya boleh digunakan oleh pelanggan sendiri dan tidak boleh diperjualbelikan atau disambungkan ke jaringan lain secara ilegal.</p>
          </div>

          <!-- Term 3 -->
          <div class="term-section">
            <h5>
              <span class="term-number">3</span>
              Jangka Waktu Berlangganan
            </h5>
            <p>Pelanggan wajib berlangganan minimal 12 bulan, dan layanan akan diperpanjang otomatis kecuali pelanggan mengajukan pemutusan paling lambat 30 hari sebelum berhenti.</p>
          </div>

          <!-- Term 4 -->
          <div class="term-section">
            <h5>
              <span class="term-number">4</span>
              Pembayaran
            </h5>
            <p>Pelanggan wajib membayar biaya instalasi dan biaya bulanan tepat waktu, dan jika berhenti sebelum masa 12 bulan berakhir, akan dikenakan denda pembatalan sebesar Rp1.000.000.</p>
          </div>

          <!-- Term 5 -->
          <div class="term-section">
            <h5>
              <span class="term-number">5</span>
              Hak dan Kewajiban PLN Icon Plus
            </h5>
            <p>PLN Icon Plus berhak melakukan instalasi, perawatan, dan pengambilan perangkat, serta tidak bertanggung jawab atas penyalahgunaan layanan oleh pelanggan, namun tetap menyediakan dukungan teknis 24 jam.</p>
          </div>

          <!-- Term 6 -->
          <div class="term-section">
            <h5>
              <span class="term-number">6</span>
              Hak dan Kewajiban Pelanggan
            </h5>
            <p>Pelanggan wajib membayar layanan, memberikan data yang valid, menjaga perangkat milik PLN Icon Plus, dan bertanggung jawab atas kerusakan atau kehilangan perangkat tersebut.</p>
          </div>

          <!-- Term 7 -->
          <div class="term-section">
            <h5>
              <span class="term-number">7</span>
              Pemutusan Layanan
            </h5>
            <p>Jika pelanggan menunggak pembayaran, layanan dapat diputus sementara, dan bila tidak dibayar hingga 90 hari, layanan akan diputus secara permanen tanpa perlu keputusan pengadilan.</p>
          </div>

          <!-- Term 8 -->
          <div class="term-section">
            <h5>
              <span class="term-number">8</span>
              Penyambungan Kembali & Perubahan Layanan
            </h5>
            <p>Layanan dapat disambungkan kembali setelah tunggakan dilunasi, sementara perubahan paket hanya bisa dilakukan jika memenuhi syarat dan secara teknis memungkinkan.</p>
          </div>

          <!-- Term 9 -->
          <div class="term-section">
            <h5>
              <span class="term-number">9</span>
              Keadaan Kahar (Force Majeure)
            </h5>
            <p>PLN Icon Plus dan pelanggan tidak bertanggung jawab atas gangguan layanan yang disebabkan oleh kejadian di luar kendali seperti bencana alam, kerusuhan, atau kebijakan pemerintah.</p>
          </div>

          <!-- Term 10 -->
          <div class="term-section">
            <h5>
              <span class="term-number">10</span>
              Kerahasiaan
            </h5>
            <p>Kedua belah pihak wajib menjaga kerahasiaan data dan informasi pelanggan, kecuali untuk kepentingan hukum atau instansi yang berwenang.</p>
          </div>

          <!-- Term 11 -->
          <div class="term-section">
            <h5>
              <span class="term-number">11</span>
              Hukum dan Penyelesaian Sengketa
            </h5>
            <p>Jika terjadi sengketa, akan diselesaikan terlebih dahulu secara musyawarah, dan jika gagal, melalui BPSK atau Pengadilan Negeri sesuai hukum Indonesia.</p>
          </div>

          <!-- Term 12 -->
          <div class="term-section">
            <h5>
              <span class="term-number">12</span>
              Larangan
            </h5>
            <p>Pelanggan dilarang menjual kembali layanan ICONNET, memindahkan perangkat, atau menggunakan layanan di luar alamat yang terdaftar.</p>
          </div>

          <!-- Term 13 -->
          <div class="term-section">
            <h5>
              <span class="term-number">13</span>
              Ketentuan yang Dipisahkan
            </h5>
            <p>Jika ada satu ketentuan yang dinyatakan tidak berlaku oleh hukum, ketentuan lainnya tetap sah dan mengikat.</p>
          </div>

          <!-- Term 14 -->
          <div class="term-section">
            <h5>
              <span class="term-number">14</span>
              Ketentuan Lain-lain
            </h5>
            <p>Pelanggan menyetujui seluruh syarat, termasuk pemrosesan data pribadi sesuai Undang-Undang Perlindungan Data Pribadi, serta bersedia dihubungi oleh PLN Icon Plus selama masa berlangganan.</p>
          </div>

        </div>
      </div>
      
      <!-- Footer -->
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i>
          Tutup
        </button>
        <button type="button" class="btn btn-primary" id="btnMengerti">
          <i class="fas fa-check"></i>
          Lanjutkan
        </button>
      </div>
      
    </div>
  </div>
</div>

<!-- JavaScript untuk Button Lanjutkan -->
<script>
document.getElementById('btnMengerti').addEventListener('click', function() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalSyarat'));
    if (modal) modal.hide();
    
    setTimeout(() => {
        window.location.href = 'product.php';
    }, 300);
});
</script>
</body>
<!-- batas -->
</html>