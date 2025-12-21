<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONNET - Internet Cepat & Terpercaya</title>

    <!-- Bootstrap & Icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="image/iconnet.png" alt="ICONNET">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-4">
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="#product">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="#cara">Cara Berlangganan</a>
                </li>
            </ul>
            <a href="#" class="btn-promo">PROMO</a>
        </div>
    </div>
</nav>

<!-- ================= HERO ================= -->
<section class="hero-section">
    <div class="container">
        <div class="hero-card" style="background-image:url('image/slide1.png')"></div>
    </div>
</section>

<!-- ================= PRICING ================= -->
<section class="pricing-section" id="product">
    <div class="container">
        <div class="row">

            <!-- LOCATION -->
            <div class="col-lg-4 mb-4">
                <div class="location-selector">
                    <h4>Silakan pilih lokasi Anda untuk melihat detail paket dan harga yang berlaku.</h4>

                    <div class="location-dropdown-container">
                        <button class="custom-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#locationOptions">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span id="selected-location-text">Sumatera & Kalimantan</span>
                            <i class="fas fa-chevron-down dropdown-icon ms-auto"></i>
                        </button>

                        <div class="collapse show location-options-list" id="locationOptions">
                            <div class="location-item">Sumatera & Kalimantan</div>
                            <div class="location-item">Jawa & Bali</div>
                            <div class="location-item">Indonesia Timur</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CAROUSEL -->
            <div class="col-lg-8">
                <div id="packageCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">

                        <!-- ITEM 1 -->
                        <div class="carousel-item active">
                            <div class="row card-group-row">
                                <div class="package-card">
                                    <div class="package-rating">
                                        <span class="rating-badge">⭐ 4.5</span>
                                        <small>(1.500+ reviews)</small>
                                    </div>
                                    <h4>ICONNET 35</h4>
                                    <div class="package-specs">
                                        <p><i class="fas fa-wifi"></i> 35 Mbps</p>
                                        <p><i class="fas fa-laptop"></i> 15 Laptop</p>
                                        <p><i class="fas fa-mobile"></i> 25 Smartphone</p>
                                    </div>
                                    <small>Biaya Bulanan</small>
                                    <div class="price-abonemen">Rp 335.000</div>
                                    <small>Biaya Instalasi</small>
                                    <div class="price-instalasi">Rp 345.000</div>
                                    <button class="btn-pilih">Pilih Paket</button>
                                </div>
                            </div>
                        </div>

                        <!-- ITEM 2 -->
                        <div class="carousel-item">
                            <div class="row card-group-row">
                                <div class="package-card">
                                    <div class="package-rating">
                                        <span class="rating-badge">⭐ 4.5</span>
                                        <small>(1.500+ reviews)</small>
                                    </div>
                                    <h4>ICONNET 50</h4>
                                    <div class="package-specs">
                                        <p><i class="fas fa-wifi"></i> 50 Mbps</p>
                                        <p><i class="fas fa-laptop"></i> 20 Laptop</p>
                                        <p><i class="fas fa-mobile"></i> 30 Smartphone</p>
                                    </div>
                                    <small>Biaya Bulanan</small>
                                    <div class="price-abonemen">Rp 535.000</div>
                                    <small>Biaya Instalasi</small>
                                    <div class="price-instalasi">Rp 345.000</div>
                                    <button class="btn-pilih">Pilih Paket</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- CONTROLS (SATU KALI SAJA) -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#packageCarousel" data-bs-slide="prev">
                        <span class="fas fa-chevron-left carousel-control-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#packageCarousel" data-bs-slide="next">
                        <span class="fas fa-chevron-right carousel-control-icon"></span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
