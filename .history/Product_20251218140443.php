<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product & Add-on - ICONNET</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2B9EB3;
            --primary-teal: #20b2aa;
            --dark-blue: #1A5F7A;
            --dark-teal: #008080;
            --light-bg: #F0F8FF;
            --light-teal: #4dd0e1;
            --text-dark: #2c3e50;
            --border-color: #e0e0e0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background-color: #ffffff;
            padding-top: 80px;
        }

        .navbar {
            padding: 0.5rem 0;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand img {
            height: 70px;
            object-fit: contain;
        }

        .nav-link {
            color: #2c3e50 !important;
            margin: 0 15px;
            font-weight: 600;
            transition: color 0.3s;
            font-size: 1rem;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #2B9EB3 !important;
        }

        .btn-promo {
            background: #23a3b0;
            color: white;
            padding: 10px 30px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            transition: all 0.3s;
            font-weight: 600;
        }

        .btn-promo:hover {
            background: #1A5F7A;
            color: white;
            transform: translateY(-2px);
        }

        .product-header-section {
            padding: 40px 0 30px 0;
            background: #ffffff;
            text-align: left;
        }

        .product-header-section h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .tab-navigation {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .tab-btn {
            padding: 10px 25px;
            background: white;
            border: 2px solid #2c3e50;
            border-radius: 5px;
            color: #2c3e50;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .tab-btn:hover {
            border-color: #2B9EB3;
            color: #2B9EB3;
        }

        .tab-btn.active {
            background: #2c3e50;
            color: white;
            border-color: #2c3e50;
        }

        .product-content-section {
            padding: 20px 0 60px 0;
            background-color: #ffffff;
        }

        .filter-sidebar {
            background: white;
            padding: 25px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
            position: sticky;
            top: 100px;
        }

        .filter-title {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e0e0e0;
            font-size: 1.1rem;
        }

        .filter-group {
            margin-bottom: 20px;
        }

        .filter-label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .input-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .btn-counter {
            background: white;
            color: #2c3e50;
            border: 2px solid #2c3e50;
            width: 35px;
            height: 35px;
            border-radius: 5px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-counter:hover {
            background: #2c3e50;
            color: white;
        }

        .input-group .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            height: 35px;
            width: 60px;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
        }

        .btn-compare {
            width: 100%;
            padding: 12px;
            background: white;
            color: #2c3e50;
            border: 2px solid #2c3e50;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 20px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .btn-compare:hover {
            background: #2c3e50;
            color: white;
        }

        .product-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .product-card-modern {
            background: white;
            border-radius: 0px;
            padding: 0;
            box-shadow: none;
            border: none;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 25px;
            transition: all 0.3s;
        }

        .product-card-modern:hover {
            border-bottom-color: #4dd0e1;
        }

        .product-card-header {
            margin-bottom: 12px;
        }

        .product-title {
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .product-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .product-card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .product-price-tag {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .btn-product-detail {
            padding: 8px 20px;
            background: white;
            color: #2c3e50;
            border: 2px solid #2c3e50;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-product-detail:hover {
            background: #2c3e50;
            color: white;
        }

        .info-banner {
            background: white;
            padding: 15px 20px;
            border-radius: 5px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 15px 0;
            border: 1px solid #e9ecef;
            font-size: 0.9rem;
        }

        .info-banner i {
            font-size: 1.2rem;
            color: #2c3e50;
            background: #2c3e50;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .addon-section {
            padding: 60px 0;
            background: white;
            border-top: 1px solid #e9ecef;
        }

        .addon-section h2 {
            color: #2c3e50;
            margin-bottom: 40px;
            font-weight: bold;
        }

        .addon-category {
            margin-bottom: 40px;
        }

        .addon-category-title {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 25px;
            font-size: 1.3rem;
        }

        .addon-card {
            background: #4dd0e1;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s;
            height: 100%;
        }

        .addon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(77, 208, 225, 0.3);
        }

        .addon-title {
            color: white;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .addon-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .addon-price {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-addon-detail {
            width: 100%;
            padding: 12px;
            background: white;
            color: #20b2aa;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-addon-detail:hover {
            background: #2c3e50;
            color: white;
        }

        footer {
            background: #2c3e50 !important;
            margin-top: 0;
            padding: 20px 0;
        }

        footer p {
            margin: 0;
            color: white;
        }

        @media (max-width: 992px) {
            .filter-sidebar {
                margin-bottom: 30px;
                position: relative;
                top: 0;
            }

            .product-header-section h1 {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }

            .navbar-brand img {
                height: 60px;
            }

            .product-card-body {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-product-detail {
                width: 100%;
                justify-content: center;
            }

            .tab-navigation {
                flex-direction: column;
            }

            .tab-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="image/iconnet.png" alt="ICONNET">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="product.html">Product & Add on</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#cara">Cara Berlangganan</a>
                    </li>
                </ul>
                <a href="promo.php" class="btn-promo">PROMO</a>
            </div>
        </div>
    </nav>

    <section class="product-header-section">
        <div class="container">
            <h1>Pilih Product & Add on Sesuai Kebutuhanmu</h1>
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="residential">RESIDENTIAL</button>
                <button class="tab-btn" data-tab="broadband">BROADBAND</button>
                <button class="tab-btn" data-tab="iconplay">ICONPLAY</button>
            </div>
        </div>
    </section>

    <section class="product-content-section">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="filter-sidebar">
                        <h5 class="filter-title">Filter Paket</h5>
                        
                        <div class="filter-group">
                            <label class="filter-label">Jumlah Perangkat</label>
                            <div class="input-group">
                                <button class="btn-counter" onclick="decreaseValue('device-count')">-</button>
                                <input type="number" id="device-count" value="3" min="1" class="form-control">
                                <button class="btn-counter" onclick="increaseValue('device-count')">+</button>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">Laptop</label>
                            <div class="input-group">
                                <button class="btn-counter" onclick="decreaseValue('laptop-count')">-</button>
                                <input type="number" id="laptop-count" value="3" min="0" class="form-control">
                                <button class="btn-counter" onclick="increaseValue('laptop-count')">+</button>
                            </div>
                        </div>

                        <button class="btn-compare" onclick="openCompareModal()">
                            <i class="fas fa-balance-scale"></i>
                            Bandingkan Paket Anda
                        </button>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8">
                    <div class="product-grid" id="residential-content">
                        
                        <div class="product-card-modern" data-package="iconnet35">
                            <div class="product-card-header">
                                <h4 class="product-title">ICONNET 35</h4>
                                <p class="product-subtitle">Enjoy HD Hingga 40 Perangkat. Cumplete 20-25 Hz 4K TV/UHD Video</p>
                            </div>
                            <div class="product-card-body">
                                <div class="product-price-tag">Rp 259.000</div>
                                <button class="btn-product-detail" onclick="showProductDetail('iconnet35')">
                                    Lihat Detail <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="product-card-modern" data-package="iconnet50">
                            <div class="product-card-header">
                                <h4 class="product-title">ICONNET 50</h4>
                                <p class="product-subtitle">Enjoy HD Hingga 50 Perangkat. Cumplete 25-30 Hz 4K TV/UHD Video</p>
                            </div>
                            <div class="product-card-body">
                                <div class="product-price-tag">Rp 339.000</div>
                                <button class="btn-product-detail" onclick="showProductDetail('iconnet50')">
                                    Lihat Detail <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="product-card-modern" data-package="iconnet100">
                            <div class="product-card-header">
                                <h4 class="product-title">ICONNET 100</h4>
                                <p class="product-subtitle">Enjoy HD Hingga 100 Perangkat. Cumplete 40-50 Hz 4K TV/UHD Video</p>
                            </div>
                            <div class="product-card-body">
                                <div class="product-price-tag">Rp 459.000</div>
                                <button class="btn-product-detail" onclick="showProductDetail('iconnet100')">
                                    Lihat Detail <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="info-banner">
                            <i class="fas fa-info-circle"></i>
                            Lebih hemat dengan paket hebat ICONNET
                        </div>

                        <div class="product-card-modern" data-package="iconnet35">
                            <div class="product-card-header">
                                <h4 class="product-title">ICONNET HEBAT 3</h4>
                                <p class="product-subtitle">Enjoy HD Hingga 40 Perangkat. Cumplete 20-25 Hz 4K TV/UHD Video</p>
                            </div>
                            <div class="product-card-body">
                                <div class="product-price-tag">Rp 259.000</div>
                                <button class="btn-product-detail" onclick="showProductDetail('hebat3')">
                                    Lihat Detail <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="product-card-modern" data-package="iconnet50">
                            <div class="product-card-header">
                                <h4 class="product-title">ICONNET HEBAT 6</h4>
                                <p class="product-subtitle">Enjoy HD Hingga 40 Perangkat. Cumplete 20-25 Hz 4K TV/UHD Video</p>
                            </div>
                            <div class="product-card-body">
                                <div class="product-price-tag">Rp 259.000</div>
                                <button class="btn-product-detail" onclick="showProductDetail('hebat6')">
                                    Lihat Detail <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="addon-section">
        <div class="container">
            <h2 class="text-center mb-5">LENGKAPI DENGAN PRODUK ADD-ON</h2>

            <div class="addon-category">
                <h4 class="addon-category-title">Wifi Extender</h4>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="addon-card">
                            <h5 class="addon-title">Wifi Extender A</h5>
                            <p class="addon-subtitle">Lihat Detail Wifi</p>
                            <div class="addon-price">$145</div>
                            <button class="btn-addon-detail">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="addon-card">
                            <h5 class="addon-title">Wifi Extender B</h5>
                            <p class="addon-subtitle">Lihat Detail Wifi</p>
                            <div class="addon-price">$145</div>
                            <button class="btn-addon-detail">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="addon-card">
                            <h5 class="addon-title">Wifi Extender C</h5>
                            <p class="addon-subtitle">Lihat Detail Wifi</p>
                            <div class="addon-price">$145</div>
                            <button class="btn-addon-detail">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="addon-category">
                <h4 class="addon-category-title">ICONPLAY</h4>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="addon-card">
                            <h5 class="addon-title">ICONPLAY Basic</h5>
                            <p class="addon-subtitle">Lihat Detail IPTV</p>
                            <div class="addon-price">$145</div>
                            <button class="btn-addon-detail">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="addon-card">
                            <h5 class="addon-title">ICONPLAY Premium</h5>
                            <p class="addon-subtitle">Lihat Detail IPTV</p>
                            <div class="addon-price">$145</div>
                            <button class="btn-addon-detail">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="addon-card">
                            <h5 class="addon-title">ICONPLAY Premium Sport</h5>
                            <p class="addon-subtitle">Lihat Detail IPTV</p>
                            <div class="addon-price">$145</div>
                            <button class="btn-addon-detail">
                                Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 ICONNET. All rights reserved.</p>
        </div>
    </footer>

    <div class="modal fade" id="compareModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Bandingkan Paket ICONNET</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="compareModalBody">
                    <p class="text-center text-muted mb-4">Rekomendasi paket terbaik untuk kebutuhan Anda</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        const paketData = {
            'iconnet35': {
                nama: 'ICONNET 35',
                kecepatan: '35 Mbps',
                perangkat: 40,
                harga: 'Rp 259.000',
                tv4k: '20-25 Hz',
                laptop: 15,
                smartphone: 25,
                streaming: '4K UHD',
                gaming: 'HD Gaming',
                features: ['Free Instalasi', 'Router Gratis', 'Support 24/7']
            },
            'iconnet50': {
                nama: 'ICONNET 50',
                kecepatan: '50 Mbps',
                perangkat: 50,
                harga: 'Rp 339.000',
                tv4k: '25-30 Hz',
                laptop: 20,
                smartphone: 30,
                streaming: '4K UHD Premium',
                gaming: 'HD Gaming Plus',
                features: ['Free Instalasi', 'Router Premium', 'Support 24/7', 'Prioritas Bandwidth']
            },
            'iconnet100': {
                nama: 'ICONNET 100',
                kecepatan: '100 Mbps',
                perangkat: 100,
                harga: 'Rp 459.000',
                tv4k: '40-50 Hz',
                laptop: 40,
                smartphone: 60,
                streaming: '8K UHD',
                gaming: '4K Gaming',
                features: ['Free Instalasi', 'Router High-End', 'Support Premium 24/7', 'Prioritas Bandwidth', 'Static IP']
            }
        };

        function increaseValue(id) {
            const input = document.getElementById(id);
            input.value = parseInt(input.value) + 1;
            filterProducts();
        }

        function decreaseValue(id) {
            const input = document.getElementById(id);
            if (parseInt(input.value) > (id === 'device-count' ? 1 : 0)) {
                input.value = parseInt(input.value) - 1;
            }
            filterProducts();
        }

        function filterProducts() {
            const totalDevices = parseInt(document.getElementById('device-count').value);
            const laptops = parseInt(document.getElementById('laptop-count').value);
            const smartphones = totalDevices - laptops;
            
            const productCards = document.querySelectorAll('.product-card-modern[data-package]');
            
            productCards.forEach(card => {
                const paketId = card.getAttribute('data-package');
                
                if (paketId && paketData[paketId]) {
                    const paket = paketData[paketId];
                    
                    if (totalDevices <= paket.perangkat && 
                        laptops <= paket.laptop && 
                        smartphones <= paket.smartphone) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
            
            checkVisibleProducts();
        }
        
        function checkVisibleProducts() {
            const visibleCards = document.querySelectorAll('.product-card-modern[data-package][style*="display: block"], .product-card-modern[data-package]:not([style*="display: none"])');
            
            const existingMessage = document.getElementById('no-products-message');
            
            if (visibleCards.length === 0) {
                if (!existingMessage) {
                    const message = document.createElement('div');
                    message.id = 'no-products-message';
                    message.className = 'alert alert-warning text-center';
                    message.innerHTML = `
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Tidak ada paket yang sesuai dengan kebutuhan Anda.</strong><br>
                        <small>Silakan kurangi jumlah perangkat atau hubungi kami untuk solusi custom.</small>
                    `;
                    document.querySelector('.product-grid').prepend(message);
                }
            } else {
                if (existingMessage) {
                    existingMessage.remove();
                }
            }
        }

        function getRecommendedPackages() {
            const totalDevices = parseInt(document.getElementById('device-count').value);
            const laptops = parseInt(document.getElementById('laptop-count').value);
            const smartphones = totalDevices - laptops;
            
            const recommendations = [];
            
            Object.keys(paketData).forEach(paketId => {
                const paket = paketData[paketId];
                if (totalDevices <= paket.perangkat && 
                    laptops <= paket.laptop && 
                    smartphones <= paket.smartphone) {
                    recommendations.push(paketId);
                }
            });
            
            if (recommendations.length === 0) {
                return ['iconnet35', 'iconnet50', 'iconnet100'];
            }
            
            return recommendations;
        }

        function openCompareModal() {
            const recommended = getRecommendedPackages();
            const modalBody = document.getElementById('compareModalBody');
            
            const totalDevices = parseInt(document.getElementById('device-count').value);
            const laptops = parseInt(document.getElementById('laptop-count').value);
            const smartphones = totalDevices - laptops;
            
            let html = `
                <div class="alert alert-info mb-4">
                    <strong><i class="fas fa-info-circle me-2"></i>Kebutuhan Anda:</strong> ${totalDevices} Perangkat Total (${laptops} Laptop, ${smartphones} Smartphone/Tablet)
                </div>
                <p class="text-center text-muted mb-4">Perbandingan paket yang sesuai dengan kebutuhan Anda</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 180px; position: sticky; left: 0; background: #f8f9fa; z-index: 1;">Fitur</th>
            `;
            
            recommended.forEach(paketId => {
                const paket = paketData[paketId];
                html += `<th class="text-center" style="min-width: 200px;"><strong>${paket.nama}</strong></th>`;
            });
            
            html += `</tr></thead><tbody>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">💰 Harga/Bulan</td>`;
            recommended.forEach(paketId => {
                html += `<td class="text-center"><span class="badge bg-primary fs-6">${paketData[paketId].harga}</span></td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">⚡ Kecepatan</td>`;
            recommended.forEach(paketId => {
                html += `<td class="text-center fw-bold">${paketData[paketId].kecepatan}</td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">📱 Maks. Perangkat</td>`;
            recommended.forEach(paketId => {
                html += `<td class="text-center">${paketData[paketId].perangkat} Perangkat</td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">💻 Support Laptop</td>`;
            recommended.forEach(paketId => {
                const paket = paketData[paketId];
                const isOverLimit = laptops > paket.laptop;
                html += `<td class="text-center ${isOverLimit ? 'table-warning' : ''}">Hingga ${paket.laptop} Unit ${isOverLimit ? '<br><small class="text-danger">⚠️ Melebihi kapasitas</small>' : ''}</td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">📱 Support Smartphone</td>`;
            recommended.forEach(paketId => {
                const paket = paketData[paketId];
                const isOverLimit = smartphones > paket.smartphone;
                html += `<td class="text-center ${isOverLimit ? 'table-warning' : ''}">Hingga ${paket.smartphone} Unit ${isOverLimit ? '<br><small class="text-danger">⚠️ Melebihi kapasitas</small>' : ''}</td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">📺 4K TV/UHD Video</td>`;
            recommended.forEach(paketId => {
                html += `<td class="text-center">${paketData[paketId].tv4k}</td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">🎬 Streaming Quality</td>`;
            recommended.forEach(paketId => {
                html += `<td class="text-center">${paketData[paketId].streaming}</td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">🎮 Gaming</td>`;
            recommended.forEach(paketId => {
                html += `<td class="text-center">${paketData[paketId].gaming}</td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;">✨ Fitur Tambahan</td>`;
            recommended.forEach(paketId => {
                const features = paketData[paketId].features.map(f => `<small>✓ ${f}</small>`).join('<br>');
                html += `<td class="text-start" style="font-size: 0.9rem;">${features}</td>`;
            });
            html += `</tr>`;
            
            html += `<tr class="table-light"><td class="fw-bold" style="position: sticky; left: 0; background: #f8f9fa; z-index: 1;">🎯 Rekomendasi</td>`;
            recommended.forEach(paketId => {
                const paket = paketData[paketId];
                let badgeClass = 'bg-success';
                let badgeText = '✓ Sesuai Kebutuhan';
                
                if (totalDevices > paket.perangkat || laptops > paket.laptop || smartphones > paket.smartphone) {
                    badgeClass = 'bg-danger';
                    badgeText = '✗ Tidak Cukup';
                } else if (totalDevices > paket.perangkat * 0.8 || laptops > paket.laptop * 0.8) {
                    badgeClass = 'bg-warning text-dark';
                    badgeText = '⚠ Mendekati Limit';
                } else if (totalDevices <= paket.perangkat * 0.5 && laptops <= paket.laptop * 0.5) {
                    badgeClass = 'bg-info';
                    badgeText = '★ Optimal';
                }
                
                html += `<td class="text-center"><span class="badge ${badgeClass} fs-6 py-2 px-3">${badgeText}</span></td>`;
            });
            html += `</tr>`;
            
            html += `<tr><td class="fw-bold" style="position: sticky; left: 0; background: white; z-index: 1;"></td>`;
            recommended.forEach(paketId => {
                html += `<td class="text-center py-3">
                    <button class="btn btn-primary btn-sm w-75" onclick="selectPackage('${paketId}')">
                        <i class="fas fa-check-circle me-2"></i>Pilih Paket
                    </button>
                </td>`;
            });
            html += `</tr>`;
            
            html += `</tbody></table></div>`;
            
            html += `
                <div class="alert alert-light border mt-4">
                    <h6 class="fw-bold mb-2"><i class="fas fa-lightbulb text-warning me-2"></i>Tips Memilih Paket:</h6>
                    <ul class="mb-0 small">
                        <li><strong>Optimal (★):</strong> Paket ini ideal untuk Anda dengan ruang untuk pertumbuhan</li>
                        <li><strong>Sesuai Kebutuhan (✓):</strong> Paket ini memenuhi kebutuhan Anda saat ini</li>
                        <li><strong>Mendekati Limit (⚠):</strong> Paket ini bisa memadai tapi pertimbangkan upgrade untuk performa terbaik</li>
                        <li><strong>Tidak Cukup (✗):</strong> Paket ini tidak dapat menampung semua perangkat Anda</li>
                    </ul>
                </div>
            `;
            
            modalBody.innerHTML = html;
            
            const modal = new bootstrap.Modal(document.getElementById('compareModal'));
            modal.show();
        }

        function selectPackage(paketId) {
            const paket = paketData[paketId];
            alert(`Anda memilih paket: ${paket.nama}\nHarga: ${paket.harga}/bulan\n\nTerima kasih! Tim kami akan segera menghubungi Anda.`);
        }

        function showProductDetail(productId) {
            console.log('Detail untuk ' + productId);
        }

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const tab = this.getAttribute('data-tab');
                console.log('Tab aktif:', tab);
            });
        });

        // Filter produk saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            filterProducts();
        });
    </script>

</body>
</html>