<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product & Add-on - ICONNET</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #20b2aa;
            --primary-dark: #008080;
            --primary-light: #4dd0e1;
            --accent-color: #17a2b8;
            --bg-light: #f0f8ff;
            --text-dark: #2c3e50;
            --border-color: #e0e0e0;
            --shadow-sm: 0 2px 10px rgba(32, 178, 170, 0.1);
            --shadow-md: 0 4px 20px rgba(32, 178, 170, 0.15);
            --shadow-lg: 0 8px 30px rgba(32, 178, 170, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #e0f7fa 0%, #f0f8ff 100%);
            padding-top: 80px;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            padding: 0.5rem 0;
            background: white !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            height: 70px;
            object-fit: contain;
            transition: transform 0.3s;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--text-dark) !important;
            margin: 0 15px;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 1rem;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--primary-color);
            transition: all 0.3s;
            transform: translateX(-50%);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
        }

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

        /* ========== HEADER SECTION ========== */
        .product-header-section {
            padding: 60px 0 40px 0;
            background: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .product-header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 200%;
            height: 100%;
            background: radial-gradient(circle, rgba(32, 178, 170, 0.05) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: translateX(0) scale(1); }
            50% { transform: translateX(10%) scale(1.1); }
        }

        .product-header-section h1 {
            color: var(--text-dark);
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }

        .product-header-section p {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        /* ========== TAB NAVIGATION ========== */
        .tab-navigation {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }

        .tab-btn {
            padding: 12px 35px;
            background: white;
            border: 3px solid var(--primary-color);
            border-radius: 50px;
            color: var(--primary-color);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.1);
        }

        .tab-btn:hover {
            background: var(--primary-light);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(32, 178, 170, 0.3);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(32, 178, 170, 0.3);
        }

        /* ========== CONTENT SECTION ========== */
        .product-content-section {
            padding: 40px 0 30px 0;
        }

        /* ========== FILTER SIDEBAR ========== */
        .filter-sidebar {
            background: white;
            padding: 30px 25px;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            position: sticky;
            top: 100px;
            border-left: 5px solid var(--primary-color);
        }

        .filter-title {
            color: var(--text-dark);
            font-weight: 800;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary-light);
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-title i {
            color: var(--primary-color);
        }

        .filter-group {
            margin-bottom: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #f0f8ff 0%, #e0f7fa 100%);
            border-radius: 15px;
        }

        .filter-label {
            display: block;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-label i {
            color: var(--primary-color);
        }

        .input-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-counter {
            background: white;
            color: var(--primary-color);
            border: 3px solid var(--primary-color);
            width: 45px;
            height: 45px;
            border-radius: 12px;
            font-size: 1.4rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(32, 178, 170, 0.1);
        }

        .btn-counter:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
        }

        .input-group .form-control {
            border: 3px solid var(--primary-light);
            border-radius: 12px;
            height: 45px;
            width: 80px;
            text-align: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--text-dark);
        }

        .btn-compare {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 700;
            margin-top: 25px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
        }

        .btn-compare:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(32, 178, 170, 0.4);
        }

        /* ========== PRODUCT GRID ========== */
        .product-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .product-card-modern {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow-sm);
            border: 2px solid transparent;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .product-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(32, 178, 170, 0.1), transparent);
            transition: left 0.5s;
        }

        .product-card-modern:hover::before {
            left: 100%;
        }

        .product-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .product-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.85rem;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .product-card-header {
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .product-title {
            color: var(--text-dark);
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-title i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .product-subtitle {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .product-specs {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .spec-badge {
            background: linear-gradient(135deg, #f0f8ff 0%, #e0f7fa 100%);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .spec-badge i {
            color: var(--primary-color);
        }

        .product-card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            position: relative;
            z-index: 1;
        }

        .product-price-section {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .price-label {
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .product-price-tag {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-product-detail {
            padding: 12px 30px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
        }

        .btn-product-detail:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(32, 178, 170, 0.4);
            color: white;
        }

        /* ========== INFO BANNER ========== */
        .info-banner {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe8a1 100%);
            padding: 20px 25px;
            border-radius: 15px;
            text-align: center;
            font-weight: 700;
            color: #856404;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 30px 0;
            border: 2px solid #ffc107;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
        }

        .info-banner i {
            font-size: 1.5rem;
            color: #ffc107;
        }

        /* ========== ADDON SECTION ========== */
.addon-section {
    padding: 10px 0;
    background: linear-gradient(135deg, #ffffffff, #f8ffff);
    position: relative;
    overflow: hidden;
}

        .addon-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(32, 178, 170, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .addon-section h2 {
            color: var(--text-dark);
            margin-bottom: 20px;
            font-weight: 800;
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
        }

        .addon-section .section-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 50px;
            position: relative;
            z-index: 1;
        }

        .addon-category {
            margin-bottom: 60px;
            position: relative;
            z-index: 1;
        }

        .addon-category-title {
            color: var(--text-dark);
            font-weight: 800;
            margin-bottom: 30px;
            font-size: 1.8rem;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary-light);
            display: inline-block;
        }

        .addon-card {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            padding: 35px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s;
            height: 100%;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .addon-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transition: transform 0.5s;
        }

        .addon-card:hover::before {
            transform: translate(-25%, -25%);
        }

        .addon-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .addon-icon {
            font-size: 3rem;
            color: white;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .addon-title {
            color: white;
            font-weight: 800;
            margin-bottom: 12px;
            font-size: 1.4rem;
            position: relative;
            z-index: 1;
        }

        .addon-subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1rem;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .addon-price {
            color: white;
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .btn-addon-detail {
            width: 100%;
            padding: 15px;
            background: white;
            color: var(--primary-color);
            border: none;
            border-radius: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-addon-detail:hover {
            background: var(--text-dark);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* ========== FOOTER ========== */
        footer {
            background: linear-gradient(135deg, var(--text-dark) 0%, #1a2332 100%) !important;
            margin-top: 0;
            padding: 30px 0;
        }

        footer p {
            margin: 0;
            color: white;
            font-weight: 600;
        }

        /* ========== MODAL ========== */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 30px;
        }

        .modal-title {
            font-weight: 800;
            font-size: 1.5rem;
        }

        .modal-body {
            padding: 30px;
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .table th {
            font-weight: 700;
            padding: 15px;
        }

        .table td {
            padding: 15px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .filter-sidebar {
                margin-bottom: 30px;
                position: relative;
                top: 0;
            }

            .product-header-section h1 {
                font-size: 2rem;
            }

            .addon-section h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }

            .navbar-brand img {
                height: 60px;
            }

            .product-header-section h1 {
                font-size: 1.6rem;
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

            .product-title {
                font-size: 1.4rem;
            }

            .product-price-tag {
                font-size: 1.5rem;
            }
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card-modern,
        .addon-card {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .product-card-modern:nth-child(1) { animation-delay: 0.1s; }
        .product-card-modern:nth-child(2) { animation-delay: 0.2s; }
        .product-card-modern:nth-child(3) { animation-delay: 0.3s; }
        .product-card-modern:nth-child(4) { animation-delay: 0.4s; }
        .product-card-modern:nth-child(5) { animation-delay: 0.5s; }

/* OPTIONAL */
#paket-internet,
#wifi-extender,
#iconplay {
    scroll-margin-top: 100px;
}
/* ============================= */
/* GLOBAL SCALE ADJUSTMENT */
/* ============================= */
html {
    font-size: 80%; /* 🔥 Ubah ke 88% / 85% jika masih besar */
}
.product-header-section h1 {
    font-size: 32px;
}

.product-header-section p {
    font-size: 14px;
}
.tab-navigation .tab-btn {
    padding: 10px 20px;
    font-size: 14px;
}
.product-card-modern {
    padding: 16px;
}

.product-title {
    font-size: 16px;
}

.product-subtitle {
    font-size: 13px;
}
.product-price-tag {
    font-size: 20px;
}

.product-badge {
    font-size: 11px;
    padding: 4px 8px;
}
.btn-success {
    position: relative;
    z-index: 999;
}
.btn-wa-highlight {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    background: linear-gradient(135deg, #008080, #2fb9b9);
    color: #ffffff;

    font-weight: 600;
    font-size: 14px;
    line-height: 1;

    border-radius: 28px;
    padding: 10px 18px;
    border: none;

    box-shadow: 0 6px 16px rgba(0, 128, 128, 0.35);
    transition: all 0.25s ease-in-out;

    text-align: center;
    white-space: nowrap;
}

.btn-wa-highlight i {
    font-size: 16px;
    line-height: 1;
    display: flex;
    align-items: center;
}

/* Hover elegan */
.btn-wa-highlight:hover {
    background: linear-gradient(135deg, #006f6f, #26a8a8);
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(0, 128, 128, 0.5);
    color: #ffffff;
}

/* Disable */
.btn-wa-highlight:disabled {
    background: #9fbcbc;
    box-shadow: none;
    cursor: not-allowed;
    opacity: 0.75;
}

.addon-price-box {
    background: #008080;
    color: #fff;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 12px;
    text-align: left; /* 🔹 RATA KIRI */
}

.addon-price-box .label {
    font-size: 13px;
    opacity: 0.9;
}

.addon-price-box .price {
    font-size: 26px;
    font-weight: 700;
    margin-top: 2px;
}
.addon-installation-box {
    border: 1px solid #008080;
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    background: #ffffff;
}

.addon-installation-box span {
    font-size: 14px;
    font-weight: 600;
    color: #008080;
}
.btn-whatsapp-modern {
    background: linear-gradient(135deg, #008080, #00a6a6);
    color: #ffffff;
    border: none;
    border-radius: 999px;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 6px 14px rgba(0, 128, 128, 0.35);
    transition: all 0.25s ease;
}

.btn-whatsapp-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 128, 128, 0.45);
    color: #fff;
}

.price-box {
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 15px;
    background: #f8f9fa;
}

.price-box .label {
    font-size: 14px;
    color: #6c757d;
}

.price-box .price {
    font-size: 22px;
    font-weight: bold;
    margin-top: 5px;
}

.installation-box {
    background: #fff3cd;
    border: 1px solid #ffe69c;
}
.feature-list {
    list-style: none;
    padding-left: 0;
}

.feature-list li {
    padding: 6px 0;
    font-size: 15px;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 15px;
}

.info-card {
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 14px;
    border-radius: 12px;
    background: #f8f9fa;
}

.info-card i {
    font-size: 26px;
    color: #0d6efd;
}

.info-card .label {
    font-size: 13px;
    color: #6c757d;
}

.info-card .value {
    font-weight: 600;
    font-size: 16px;
}
.feature-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.feature-badge {
    background: #e7f1ff;
    color: #0d6efd;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}
.addon-desc-box {
    background: #f5fffe;
    border-left: 4px solid #008080;
    padding: 10px 14px;
    margin-bottom: 12px;
    font-size: 14px;
    color: #333;
    line-height: 1.5;
    border-radius: 6px;
}
/* ============================= */
/* ADDON CARD PUTIH (MODERN) */
/* ============================= */

.addon-card-white {
    background: #ffffff;
    border-radius: 20px;
    padding: 26px 22px;
    text-align: center;
    height: 100%;
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e9f2f2;
}

.addon-card-white:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 36px rgba(0, 128, 128, 0.18);
}

/* Icon */
.addon-card-white .addon-icon {
    font-size: 40px;
    color: #008080;
    margin-bottom: 14px;
}

/* Judul */
.addon-card-white .addon-title {
    font-size: 16px;
    font-weight: 700;
    color: #1f2d3d;
    margin-bottom: 6px;
}

/* Deskripsi */
.addon-card-white .addon-subtitle {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 16px;
}

/* Harga */
.addon-card-white .addon-price {
    font-size: 20px;
    font-weight: 800;
    color: #008080;
    margin-bottom: 14px;
}

/* Button */
.addon-card-white .btn-addon-detail {
    background: linear-gradient(135deg, #008080, #2fb9b9);
    color: #fff;
    border-radius: 999px;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 600;
}
.addon-section .section-divider {
    width: 120px;
    height: 4px;
    background: linear-gradient(90deg, #00b3b3, #008080);
    border-radius: 99px;
    margin: 0 auto 30px;
}
.addon-section {
    margin-top: 80px;
    padding-top: 80px;
    background: linear-gradient(135deg, #f3ffff, #ffffff);
    border-top: 6px solid #008080;
}
.channel-group {
    margin-bottom: 24px;
}

.channel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
}

.channel-header h6 {
    font-weight: 600;
    font-size: 16px;
    margin: 0;
}

.lihat-semua {
    color: #0d6efd;
    font-size: 14px;
    cursor: pointer;
}

.channel-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 16px;
    margin-top: 12px;
}

.channel-logo {
    width: 100%;
    height: 100px; /* 🔥 BESARIN DARI SEBELUMNYA */
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 8px;
    overflow: hidden;
}

/* GAMBAR LOGO */
.channel-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* 🔥 PENTING: agar logo proporsional */
}

.channel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.channel-header h6 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
}

.lihat-semua {
    font-size: 14px;
    color: #00a8cc;
    cursor: pointer;
}

   </style>
</head>
<body>

    <!-- NAVBAR -->
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="product.php">Product & Add on</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#cara">Cara Berlangganan</a>
                    </li>
                </ul>
                <a href="promo.php" class="btn-promo">PROMO</a>
            </div>
        </div>
    </nav>

    <!-- HEADER SECTION -->
    <section class="product-header-section">
        <div class="container">
            <h1>Pilih Paket Internet Terbaik</h1>
            <p>Solusi internet cepat dan stabil untuk kebutuhan digital Anda</p>

            <!-- 🔽 PERUBAHAN DI SINI (HEADER SECTION) -->
<div class="tab-navigation">
    <button class="tab-btn active" data-target="#paket-internet">
        <i class="fas fa-home me-2"></i>Paket Internet
    </button>
    <button class="tab-btn" data-target="#wifi-extender">
        <i class="fas fa-signal me-2"></i>Wifi Extender
    </button>
    <button class="tab-btn" data-target="#iconplay">
        <i class="fas fa-play-circle me-2"></i>ICONPLAY
    </button>
</div>
        </div>
    </section>

    <!-- CONTENT SECTION -->
    <section class="product-content-section">
        <div class="container">
            <div class="row">
                
                <!-- FILTER SIDEBAR -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="filter-sidebar">
                        <h5 class="filter-title">
                            <i class="fas fa-sliders-h"></i>
                            Filter Paket
                        </h5>
                        
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fas fa-devices"></i>
                                Handphone
                            </label>
                            <div class="input-group">
                                <button class="btn-counter" onclick="decreaseValue('device-count')">−</button>
                                <input type="number" id="device-count" value="0" min="1" class="form-control">
                                <button class="btn-counter" onclick="increaseValue('device-count')">+</button>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="fas fa-laptop"></i>
                                Laptop
                            </label>
                            <div class="input-group">
                                <button class="btn-counter" onclick="decreaseValue('laptop-count')">−</button>
                                <input type="number" id="laptop-count" value="0" min="0" class="form-control">
                                <button class="btn-counter" onclick="increaseValue('laptop-count')">+</button>
                            </div>
                        </div>

                        <div class="mb-3">
    <label class="form-label fw-bold">Wilayah Pemasangan</label>
    <select id="regionSelect" class="form-select" onchange="updateRegion()">
        <option value="jawa">Jawa & Bali</option>
        <option value="sumatera">Sumatera & Kalimantan</option>
        <option value="timur">Indonesia Timur</option>
    </select>
</div>

                        <button class="btn-compare" onclick="openCompareModal()">
                            <i class="fas fa-balance-scale"></i>
                            Bandingkan Paket
                        </button>
                    </div>
                </div>

                <!-- PRODUCT GRID -->
                <div class="col-lg-9 col-md-8">
                    <!-- <div class="product-grid" id="residential-content"> -->
                        
                    <!-- 🔽 TAMBAHAN ID DI SINI -->

                    <!-- PAKET REGULER -->
<div class="product-grid" id="paket-regular"></div>

                            <!-- INFO BANNER HEBAT -->
                            <div class="info-banner d-none" id="infoBannerHebat">
                                <i class="fas fa-info-circle"></i>
                                <span>Lebih hemat dengan paket bundling ICONNET HEBAT!</span>
                            </div>

                            <!-- PAKET HEBAT (DINAMIS DARI DB) -->
                            <div class="product-grid mt-3" id="paket-hebat"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>
<!--  -->
    <section class="addon-section">
        <div class="container">
            <div class="section-divider"></div>
            <h2 class="text-center">LENGKAPI DENGAN ADD-ON</h2>
            <p class="section-subtitle text-center">Tingkatkan pengalaman internet Anda dengan produk tambahan berkualitas</p>

            <!-- WIFI EXTENDER -->
            <!-- <div class="addon-category">
                <h4 class="addon-category-title">WiFi Extender</h4> -->
                <!-- 🔽 TAMBAHAN ID DI SINI -->
                <div class="addon-category" id="wifi-extender">
                    <h4 class="addon-category-title">WiFi Extender</h4>
                    <div class="row g-4" id="wifiExtenderContainer">
                        <!-- DATA DARI DATABASE -->
                    </div>
                </div>

                <div class="addon-category" id="iconplay">
                    <h4 class="addon-category-title">ICONPLAY</h4>
                    <div class="row g-4" id="iconplayContainer">
                        <!-- DATA DARI DATABASE -->
                    </div>
                </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 ICONNET. All rights reserved. | Made with ❤️ in Indonesia</p>
        </div>
    </footer>

    <!-- COMPARE MODAL -->
    <div class="modal fade" id="compareModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-balance-scale me-2"></i>
                        Bandingkan Paket ICONNET
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="compareModalBody">
                    <p class="text-center text-muted mb-4">Rekomendasi paket terbaik untuk kebutuhan Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- PRODUCT DETAIL MODAL -->
    <div class="modal fade" id="productDetailModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>
                        <span id="detailModalTitle">Detail Paket</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="productDetailBody">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
let selectedRegion = "jawa";
function updateRegion() {
    selectedRegion = document.getElementById("regionSelect").value;

    const modal = document.getElementById("compareModal");
    if (modal.classList.contains("show")) {
        openCompareModal();
    }
}

function getHargaByRegion(paket) {
    if (selectedRegion === "sumatera") return paket.harga_sumatera;
    if (selectedRegion === "timur") return paket.harga_timur;
    return paket.harga_jawa;
}

function getInstalasiByRegion(paket) {
    if (selectedRegion === "sumatera") return paket.instalasi_sumatera;
    if (selectedRegion === "timur") return paket.instalasi_timur;
    return paket.instalasi_jawa;
}

function getRegionLabel() {
    if (selectedRegion === "sumatera") return "Sumatera & Kalimantan";
    if (selectedRegion === "timur") return "Indonesia Timur";
    return "Jawa & Bali";
}

function selectPackageFromDetail(paketId) {
            const paket = paketData[paketId];
            alert(`✅ Anda memilih paket: ${paket.nama}\n💰 Harga: ${paket.harga}${paket.durasi ? ' (' + paket.durasi + ')' : '/bulan'}\n\n🎉 Terima kasih! Tim kami akan segera menghubungi Anda untuk proses selanjutnya.`);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('productDetailModal'));
            if (modal) modal.hide();
        }

function increaseValue(id) {
            const input = document.getElementById(id);
            input.value = parseInt(input.value) + 1;
            renderFilteredPaket(); // 🔥 FILTER LANGSUNG
        }

function decreaseValue(id) {
            const input = document.getElementById(id);
            if (parseInt(input.value) > (id === 'device-count' ? 1 : 0)) {
                input.value = parseInt(input.value) - 1;
            }
            renderFilteredPaket(); // 🔥 FILTER LANGSUNG
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
                    message.style.borderRadius = '15px';
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

  function openCompareModal() {
    const paketList = getFilteredPackagesFromDB();
    const modalBody = document.getElementById("compareModalBody");

    const hp = parseInt(document.getElementById("device-count").value) || 0;
    const laptop = parseInt(document.getElementById("laptop-count").value) || 0;
    const totalDevice = hp + laptop;

    if (paketList.length === 0) {
        modalBody.innerHTML = `
            <div class="alert alert-warning text-center">
                Tidak ada paket yang sesuai dengan kebutuhan Anda
            </div>`;
        new bootstrap.Modal(document.getElementById("compareModal")).show();
        return;
    }

    let html = `
        <div class="alert alert-info mb-3">
            <strong>Kebutuhan Anda:</strong>
            ${totalDevice} Perangkat (${laptop} Laptop, ${hp} Smartphone)
        </div>

        <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
        <thead class="table-success">
            <tr>
                <th>Fitur</th>
    `;

    paketList.forEach(p => {
        html += `<th>${p.name}</th>`;
    });

    html += `</tr></thead><tbody>`;

    // Harga
    html += `<tr><td><b>Harga / Bulan (${getRegionLabel()})</b></td>`;
    paketList.forEach(p => {
        html += `<td>Rp ${formatRupiah(getHargaByRegion(p))}</td>`;
    });
    html += `</tr>`;

    // Kecepatan
    html += `<tr><td>Kecepatan</td>`;
    paketList.forEach(p => html += `<td>${p.kecepatan}</td>`);
    html += `</tr>`;

    // Maks Perangkat
    html += `<tr><td>Maks. Perangkat</td>`;
    paketList.forEach(p => html += `<td>${p.max_perangkat}</td>`);
    html += `</tr>`;

    // Laptop
    html += `<tr><td>Support Laptop</td>`;
    paketList.forEach(p => html += `<td>${p.max_laptop} Unit</td>`);
    html += `</tr>`;

    // Smartphone
    html += `<tr><td>Support Smartphone</td>`;
    paketList.forEach(p => html += `<td>${p.max_smartphone} Unit</td>`);
    html += `</tr>`;

    // TV 4K
    html += `<tr><td>4K TV / UHD Video</td>`;
    paketList.forEach(p => html += `<td>${p.tv_4k}</td>`);
    html += `</tr>`;

    // Streaming
    html += `<tr><td>Streaming Quality</td>`;
    paketList.forEach(p => html += `<td>${p.streaming}</td>`);
    html += `</tr>`;

    // Gaming
    html += `<tr><td>Gaming</td>`;
    paketList.forEach(p => html += `<td>${p.gaming}</td>`);
    html += `</tr>`;

    // Instalasi
    html += `<tr><td>Biaya Instalasi (${getRegionLabel()})</td>`;
    paketList.forEach(p => {
        html += `<td>Rp ${formatRupiah(getInstalasiByRegion(p))}</td>`;
    });
    html += `</tr>`;

    // Fitur Tambahan
    html += `<tr><td>Fitur Tambahan</td>`;
    paketList.forEach(p => {
        const fitur = p.features
            ? p.features.split(",").map(f => `✓ ${f.trim()}`).join("<br>")
            : "-";
        html += `<td class="text-start">${fitur}</td>`;
    });
    html += `</tr>`;

    // Rekomendasi
    html += `<tr><td>Rekomendasi</td>`;
    paketList.forEach(p => {
        html += `<td>${getRecommendationBadge(p, laptop, hp)}</td>`;
    });
    html += `</tr>`;

    // Usage bar
    html += `<tr><td>Penggunaan Perangkat</td>`;
    paketList.forEach(p => {
        html += `<td>${renderUsageBar(totalDevice, p.max_perangkat)}</td>`;
    });
    html += `</tr>`;

    // Action (INI YANG FIX TOTAL)
    html += `<tr><td></td>`;
    paketList.forEach(p => {
        html += `
            <td>
                <button type="button"
    class="btn btn-wa-highlight btn-sm w-100"
    onclick='redirectToWhatsApp(${JSON.stringify(p)})'>
    <i class="fab fa-whatsapp"></i>
    <span>Pesan Sekarang</span>
</button>
            </td>`;
    });
    html += `</tr>`;

    html += `</tbody></table></div>`;

    html += `
        <div class="mt-3 p-3 border rounded bg-light">
            <strong>Keterangan Rekomendasi:</strong>
            <ul class="mb-0 mt-2">
                <li>★ <b>Optimal</b> → Paket ini masih sangat efisien dan mampu menampung perangkat tambahan di masa depan.</li>
                <li>✓ <b>Sesuai Kebutuhan</b> → aket ini pas untuk jumlah perangkat yang Anda gunakan saat ini.</li>
                <li>⚠ <b>Mendekati Limit</b> → Paket ini hampir mencapai batas maksimal. Jika perangkat bertambah, koneksi bisa melambat.</li>
                <li>✗ <b>Tidak Sesuai</b> → Jumlah perangkat melebihi kemampuan paket, sehingga tidak disarankan digunakan.</li>
            </ul>
        </div>
    `;

    modalBody.innerHTML = html;
    new bootstrap.Modal(document.getElementById("compareModal")).show();
// Aktifkan tooltip Bootstrap
setTimeout(() => {
    document
        .querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(el => new bootstrap.Tooltip(el));
}, 100);

}
        function selectPackage(paketId) {
            const paket = paketData[paketId];
            alert(`✅ Anda memilih paket: ${paket.nama}\n💰 Harga: ${paket.harga}/bulan\n\n🎉 Terima kasih! Tim kami akan segera menghubungi Anda.`);
        }

        function showProductDetail(productId) {
            alert(`Detail untuk ${productId} akan segera hadir!`);
        }

        function selectAddon(addonId) {
            alert(`✅ Terima kasih! Anda telah memilih add-on ini.\n\n📞 Tim kami akan segera menghubungi Anda untuk proses selanjutnya.`);
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('productDetailModal'));
            if (modal) modal.hide();
        }

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const tab = this.getAttribute('data-tab');
                console.log('Tab aktif:', tab);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            filterProducts();
        });
    </script>
<!-- 🔽 TAMBAHAN SCRIPT -->
<script>
document.querySelectorAll('.tab-btn').forEach(button => {
    button.addEventListener('click', function () {
        const target = document.querySelector(this.dataset.target);
        const headerOffset = 130; // UBAH ANGKA INI JIKA MASIH KURANG
        if (target) {
            const elementPosition = target.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }

        // Active state
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
<script>
    let allPaket = []; // simpan semua data paket

document.addEventListener("DOMContentLoaded", () => {
    loadPaket();
});

function loadPaket() {
    fetch("api_paket.php")
        .then(res => res.json())
        .then(data => {
            console.log("✅ DATA API BERHASIL DIMUAT:", data);
            console.log("📊 Jumlah Paket:", data.length);
            
            allPaket = data;
            
            // Debug: Lihat paket mana yang HEBAT
            const hebatPaket = data.filter(p => 
                String(p.name).toLowerCase().includes("hebat")
            );
            console.log("🎯 Paket HEBAT:", hebatPaket);
            
            renderFilteredPaket();
        })
        .catch(err => console.error("❌ API ERROR:", err));
}

// ================================
// TOOLTIP REKOMENDASI (HELPER)
// ================================
function getRecommendationBadge(paket, laptops, smartphones) {
    const total = laptops + smartphones;

    let badgeClass, badgeText, tooltip;

    if (
        total > paket.max_perangkat ||
        laptops > paket.max_laptop ||
        smartphones > paket.max_smartphone
    ) {
        badgeClass = 'bg-danger';
        badgeText = '✗ Tidak Sesuai';
        tooltip = 'Jumlah perangkat melebihi kemampuan paket, sehingga tidak disarankan digunakan.';
    }
    else if (
        total > paket.max_perangkat * 0.8 ||
        laptops > paket.max_laptop * 0.8 ||
        smartphones > paket.max_smartphone * 0.8
    ) {
        badgeClass = 'bg-warning text-dark';
        badgeText = '⚠ Mendekati Limit';
        tooltip = 'Paket ini hampir mencapai batas maksimal. Jika perangkat bertambah, koneksi bisa melambat.';
    }
    else if (
        total <= paket.max_perangkat * 0.5 &&
        laptops <= paket.max_laptop * 0.5 &&
        smartphones <= paket.max_smartphone * 0.5
    ) {
        badgeClass = 'bg-info';
        badgeText = '★ Optimal';
        tooltip = 'Paket ini masih sangat efisien dan mampu menampung perangkat tambahan di masa depan.';
    }
    else {
        badgeClass = 'bg-success';
        badgeText = '✓ Sesuai Kebutuhan';
        tooltip = 'Paket ini pas untuk jumlah perangkat yang Anda gunakan saat ini.';
    }

    return `
        <span class="badge ${badgeClass}"
              data-bs-toggle="tooltip"
              title="${tooltip}">
            ${badgeText}
        </span>
    `;
}


function renderUsageBar(used, max) {
    const percent = Math.min(100, Math.round((used / max) * 100));

    let color = 'bg-success';
    if (percent > 80) color = 'bg-warning';
    if (percent > 100) color = 'bg-danger';

    return `
        <div class="progress" style="height: 18px;">
            <div class="progress-bar ${color}"
                 style="width:${percent}%">
                ${percent}%
            </div>
        </div>
        <small>${used} / ${max} perangkat</small>
    `;
}

function renderFilteredPaket() {
    const hp = parseInt(document.getElementById("device-count").value) || 0;
    const laptop = parseInt(document.getElementById("laptop-count").value) || 0;
    const totalDevice = hp + laptop;

    const regularContainer = document.getElementById("paket-regular");
    const hebatContainer = document.getElementById("paket-hebat");
    const banner = document.getElementById("infoBannerHebat");

    regularContainer.innerHTML = "";
    hebatContainer.innerHTML = "";

    let hasHebat = false;
    let hasRegular = false;

allPaket.forEach(p => {
        console.log("🔄 Processing paket:", p.name); // DEBUG

        // === DETEKSI HEBAT ===
        const isHebat = String(p.name).toLowerCase().includes("hebat");
        console.log(`   ${isHebat ? '🎁' : '📦'} ${p.name} - isHebat: ${isHebat}`);

        // === FILTER PERANGKAT (dengan fallback) ===
        const maxPerangkat = p.max_perangkat || 99;
        const maxLaptop = p.max_laptop || 99;
        const maxSmartphone = p.max_smartphone || 99;
        
        const sesuaiFilter =
            totalDevice <= maxPerangkat &&
            laptop <= maxLaptop &&
            hp <= maxSmartphone;

        console.log(`   Filter: ${sesuaiFilter ? '✅' : '❌'} (Device: ${totalDevice}/${maxPerangkat}, Laptop: ${laptop}/${maxLaptop}, HP: ${hp}/${maxSmartphone})`);

        if (!sesuaiFilter) return;

        // ✅ BARU RENDER JIKA SESUAI
        const cardHTML = renderPaketCard(p);

        if (isHebat) {
            hasHebat = true;
            hebatContainer.innerHTML += cardHTML;
        } else {
            hasRegular = true;
            regularContainer.innerHTML += cardHTML;
        }
    });

    // Banner HEBAT
    if (hasHebat) {
        banner.classList.remove("d-none");
    } else {
        banner.classList.add("d-none");
    }

    // Jika benar-benar tidak ada paket
    if (!hasHebat && !hasRegular) {
        regularContainer.innerHTML = `
            <div class="alert alert-warning text-center">
                Tidak ada paket yang sesuai dengan jumlah perangkat Anda
            </div>
        `;
    }
}

function getFilteredPackagesFromDB() {
    const hp = parseInt(document.getElementById("device-count").value) || 0;
    const laptop = parseInt(document.getElementById("laptop-count").value) || 0;
    const totalDevice = hp + laptop;

    return allPaket.filter(p => {
        // Pastikan field ada dan valid
        const maxPerangkat = p.max_perangkat || 0;
        const maxLaptop = p.max_laptop || 0;
        const maxSmartphone = p.max_smartphone || 0;
        
        return (
            maxPerangkat >= totalDevice &&
            maxLaptop >= laptop &&
            maxSmartphone >= hp
        );
    });
}

function renderPaketCard(p) {
    const isHebat = String(p.name).toLowerCase().includes("hebat");

    return `
        <div class="product-card-modern" data-package="${p.id}">
            <span class="product-badge">
                ${isHebat ? "BUNDLING" : "ICONNET"}
            </span>

            <div class="product-card-header">
                <h4 class="product-title">
                    <i class="fas fa-wifi"></i>
                    ${p.name}
                </h4>

                <p class="product-subtitle">
                    Kecepatan hingga ${p.kecepatan}
                </p>
            </div>

            <div class="product-card-body">
                <div class="product-price-section">
                    <span class="price-label">Mulai dari</span>
                    <div class="product-price-tag">
                        Rp ${formatRupiah(p.harga_jawa)}
                    </div>
                </div>

                <button class="btn-product-detail"
                    onclick="showProductDetailFromDB('${p.id}')">
                    Lihat Detail
                </button>
            </div>
        </div>
    `;
}

function showProductDetailFromDB(paketId) {
    const paket = allPaket.find(p => p.id == paketId);

    if (!paket) {
        alert("Data paket tidak ditemukan");
        return;
    }

    document.getElementById("detailModalTitle").innerText = paket.name;
document.getElementById("productDetailBody").innerHTML = `

<!-- INFORMASI PAKET -->
<div class="info-grid">

    <div class="info-card">
        <i class="bi bi-speedometer2"></i>
        <div>
            <div class="label">Kecepatan</div>
            <div class="value">${paket.kecepatan}</div>
        </div>
    </div>

    <div class="info-card">
        <i class="bi bi-router"></i>
        <div>
            <div class="label">Total Perangkat</div>
            <div class="value">${paket.max_perangkat}</div>
        </div>
    </div>

    <div class="info-card">
        <i class="bi bi-laptop"></i>
        <div>
            <div class="label">Laptop</div>
            <div class="value">${paket.max_laptop}</div>
        </div>
    </div>

    <div class="info-card">
        <i class="bi bi-phone"></i>
        <div>
            <div class="label">Smartphone</div>
            <div class="value">${paket.max_smartphone}</div>
        </div>
    </div>

</div>

<hr class="my-4">

<!-- HARGA & INSTALASI (TETAP PUNYAMU) -->
<div class="price-box" style="background:#d1e7dd;border:1px solid #badbcc;">
    <div class="label">Harga / Bulan</div>
    <div class="price">Rp ${formatRupiah(getHargaByRegion(paket))}</div>
</div>

<div class="price-box installation-box">
    <div class="label">Biaya Instalasi</div>
    <div class="price">Rp ${formatRupiah(getInstalasiByRegion(paket))}</div>
</div>

<hr class="my-4">

<!-- FITUR TAMBAHAN -->
<h6 class="mb-3">Fitur Tambahan</h6>
<div class="feature-badges">
    ${
        paket.features
        ? paket.features.split(",").map(f => `
            <span class="feature-badge">✓ ${f.trim()}</span>
        `).join("")
        : `<span class="text-muted">Tidak ada fitur tambahan</span>`
    }
</div>

<div class="text-end mt-4">
    <button class="btn btn-success"
        onclick='redirectToWhatsApp(${JSON.stringify(paket)})'>
        <i class="fab fa-whatsapp"></i> Pesan Sekarang
    </button>
</div>
`;

    new bootstrap.Modal(
        document.getElementById("productDetailModal")
    ).show();
}

function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}
</script>
<script>
function redirectToWhatsApp(paket) {
    if (!paket || !paket.name) {
        alert("Data paket tidak valid");
        return;
    }

    const laptops = parseInt(document.getElementById("laptop-count").value) || 0;
    const smartphones = parseInt(document.getElementById("device-count").value) || 0;

    const harga = getHargaByRegion(paket);
    const wilayah = getRegionLabel();

    const phoneNumber = "6289502434324"; // GANTI

    const message = `
Halo Admin ICONNET 👋

Saya tertarik berlangganan paket internet ICONNET dengan detail berikut:

📦 Paket : ${paket.name}
⚡ Kecepatan : ${paket.kecepatan}
📍 Wilayah Pemasangan : ${wilayah}
💰 Harga / Bulan : Rp ${formatRupiah(harga)}
📶 Kebutuhan Perangkat :
- Laptop : ${laptops} unit
- Smartphone : ${smartphones} unit

Mohon informasi lebih lanjut terkait proses pemasangan.
Terima kasih 🙏
    `;

    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message.trim())}`;
    window.open(url, "_blank");
}

</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    fetch("api_paket.php")
        .then(res => res.json())
        .then(data => {
            // Cek apakah ada paket dengan id mengandung 'hebat'
            const hasHebat = data.some(paket =>
                String(paket.id).toLowerCase().includes("hebat")
            );

            if (hasHebat) {
                document.getElementById("infoBannerHebat")
                    .classList.remove("d-none");
            }
        })
        .catch(err => console.error("Gagal load paket:", err));
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    loadAddon();
});

function loadAddon() {
    fetch("api_addon.php")
        .then(res => res.json())
        .then(data => {
            renderAddon(data);
        })
        .catch(err => {
            console.error("Gagal load addon:", err);
        });
}

function renderAddon(addons) {
    const wifiContainer = document.getElementById("wifiExtenderContainer");
    const iconplayContainer = document.getElementById("iconplayContainer");

    wifiContainer.innerHTML = "";
    iconplayContainer.innerHTML = "";

    addons.forEach(addon => {
        const card = `
            <div class="col-lg-4 col-md-6">
                <div class="addon-card-white">
                    <div class="addon-icon">
                        <i class="fas ${addon.category === 'wifi_extender' ? 'fa-wifi' : 'fa-tv'}"></i>
                    </div>

                    <h5 class="addon-title">${addon.name}</h5>
                    <p class="addon-subtitle">${addon.description ?? ''}</p>

                    <div class="addon-price">
                        Rp ${formatRupiah(addon.price)}
                    </div>

<button class="btn-addon-detail"
    onclick="showAddonDetailFromDB(${addon.id})">

                        Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        `;

        if (addon.category === "wifi_extender") {
            wifiContainer.innerHTML += card;
        } else if (addon.category === "iconplay") {
            iconplayContainer.innerHTML += card;
        }
    });
}

function formatRupiah(angka) {
    return new Intl.NumberFormat("id-ID").format(angka);
}
</script>
<!-- ADDON DETAIL MODAL -->
<div class="modal fade" id="addonDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="addonDetailTitle">
                    Detail Add-on
                </h5>
                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="addonDetailBody">
                <!-- ISI DARI JAVASCRIPT -->
            </div>

            <div class="modal-footer justify-content-end">
    <button class="btn-whatsapp-modern"
        onclick="redirectAddonToWhatsApp()">
        <i class="fab fa-whatsapp"></i>
        Pesan via WhatsApp
    </button>
</div>

<script>
let selectedAddon = null;

function showAddonDetailFromDB(addonId) {
    fetch(`api_addon.php?id=${addonId}`)
        .then(res => res.json())
        .then(addon => {

            if (!addon || !addon.id) {
                alert("Data add-on tidak valid");
                return;
            }

            selectedAddon = addon;

            let featureHTML = "";

            // =============================
            // WIFI EXTENDER → FITUR
            // =============================
            if (addon.category === "wifi_extender") {
                const fiturList = addon.fitur
                    ? addon.fitur.split(",")
                        .map(f => `<li>${f.trim()}</li>`)
                        .join("")
                    : "<li>-</li>";

                featureHTML = `
                    <div class="addon-feature-box">
                        <h6>Fitur WiFi Extender</h6>
                        <ul>${fiturList}</ul>
                    </div>
                `;
            }

            // =============================
            // ICONPLAY → LAYANAN
            // =============================
if (addon.category === "iconplay" && addon.layanan_tersedia) {

    const layananData = JSON.parse(addon.layanan_tersedia);
    let layananHTML = "";

    Object.keys(layananData).forEach(kategori => {

        const logoHTML = layananData[kategori]
            .map(img => `
                <div class="channel-logo">
                    <img src="assets/img/channels/${img}" alt="${kategori}">
                </div>
            `)
            .join("");

        layananHTML += `
            <div class="channel-group">
                <div class="channel-header">
                    <h6>${kategori}</h6>
                    <span class="lihat-semua">Lihat Semua</span>
                </div>
                <div class="channel-list">
                    ${logoHTML}
                </div>
            </div>
        `;
    });

    featureHTML = `
        <div class="addon-feature-box">
            <h5 class="mb-3">Layanan yang Tersedia</h5>
            ${layananHTML}
        </div>
    `;

}console.log("LAYANAN:", addon.layanan_tersedia);

            document.getElementById("addonDetailTitle").innerText =
                addon.name;

            document.getElementById("addonDetailBody").innerHTML = `
            ${addon.description ? `
            <div class="addon-desc-box">
                <p>${addon.description}</p>
            </div>
            ` : ''}

                <div class="addon-price-box">
                    <div class="label">Harga Add-on</div>
                    <div class="price">
                        Rp ${formatRupiah(addon.price)}
                    </div>
                </div>

<div class="price-box installation-box">
    <div class="label">Biaya Instalasi</div>
    <div class="price">
        Rp ${formatRupiah(addon.installation_fee ?? 0)}
    </div>
</div>

                ${featureHTML}
            `;

            new bootstrap.Modal(
                document.getElementById("addonDetailModal")
            ).show();
        })
        .catch(() => {
            alert("Gagal memuat detail add-on");
        });
}

function redirectAddonToWhatsApp() {
    if (!selectedAddon) return;

    const phone = "6289502434324";

    const message = `
Halo Admin ICONNET 👋

Saya tertarik dengan Add-on berikut:

📦 Add-on : ${selectedAddon.name}
💰 Harga : Rp ${formatRupiah(selectedAddon.price)}
🛠 Biaya Instalasi : Rp ${formatRupiah(selectedAddon.installation_fee)}

Mohon info pemasangan lebih lanjut.
Terima kasih 🙏
    `;

    window.open(
        `https://wa.me/${phone}?text=${encodeURIComponent(message)}`,
        "_blank"
    );
}
</script>
<!--  -->
</body>
</html>