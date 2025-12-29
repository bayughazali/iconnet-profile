<?php
// berita.php - Halaman Detail Berita
require_once 'config.php';

// Ambil ID berita dari URL
$berita_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($berita_id <= 0) {
    header('Location: index.php');
    exit();
}

// Ambil data berita dari database
$sql = "SELECT * FROM berita WHERE id = $berita_id AND is_active = 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit();
}

$berita = $result->fetch_assoc();

// Ambil berita terkait (3 berita terbaru selain yang sedang dibaca)
// Ambil berita terkait (semua berita aktif selain yang sedang dibaca)
$sql_related = "SELECT * FROM berita WHERE id != $berita_id AND is_active = 1 ORDER BY date DESC, id DESC";
$result_related = $conn->query($sql_related);
$berita_terkait = [];
while ($row = $result_related->fetch_assoc()) {
    $berita_terkait[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($berita['title']); ?> - ICONNET</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/berita.css">
    
    <!-- Meta Tags untuk SEO dan Social Media -->
    <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($berita['content']), 0, 160)); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($berita['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars(substr(strip_tags($berita['content']), 0, 160)); ?>">
    <?php if (!empty($berita['image_url'])): ?>
    <meta property="og:image" content="<?php echo htmlspecialchars($berita['image_url']); ?>">
    <?php endif; ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid px-5">
            <a class="navbar-brand" href="index.php">
                <img src="image/iconnet.png" alt="ICONNET" style="height:90px; object-fit:contain;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="Product.php">Product & Add on</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="index.php#cara">Cara Berlangganan</a>
                    </li>
                </ul>
                <a href="promo.php" class="btn-promo">PROMO</a>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <div class="text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="index.php#berita">Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Article Section -->
    <section class="article-section">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8 mb-4">
                    <article class="article-detail">
                        <!-- Article Header -->
                        <div class="article-header">
                            <div class="article-meta mb-3">
                                <span class="badge bg-primary me-2">
                                    <i class="fas fa-tag me-1"></i>Berita ICONNET
                                </span>
                                <span class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?php echo $berita['date']; ?>
                                </span>
                            </div>
                            
                            <h1 class="article-title"><?php echo htmlspecialchars($berita['title']); ?></h1>
                        </div>

                        <!-- Featured Image -->
                        <?php if (!empty($berita['image_url'])): ?>
                        <div class="article-image">
                            <img src="<?php echo htmlspecialchars($berita['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($berita['title']); ?>"
                                 onerror="this.src='https://via.placeholder.com/800x450?text=ICONNET+News'">
                        </div>
                        <?php endif; ?>

                        <!-- Article Body -->
                        <div class="article-body">
                            <?php 
                            // Format content dengan paragraf
                            $content = $berita['content'];
                            
                            // Jika content masih plain text, tambahkan paragraf
                            if (strpos($content, '<p>') === false) {
                                $paragraphs = explode("\n\n", $content);
                                $content = '';
                                foreach ($paragraphs as $paragraph) {
                                    if (trim($paragraph) !== '') {
                                        $content .= '<p>' . nl2br(htmlspecialchars(trim($paragraph))) . '</p>';
                                    }
                                }
                            }
                            
                            echo $content;
                            ?>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-section">
                            <h5><i class="fas fa-share-alt"></i> Bagikan Artikel Ini</h5>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                                   target="_blank" class="btn btn-facebook">
                                    <i class="fab fa-facebook-f"></i> <span>Facebook</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($berita['title']); ?>" 
                                   target="_blank" class="btn btn-twitter">
                                    <i class="fab fa-twitter"></i> <span>Twitter</span>
                                </a>
                                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($berita['title'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                                   target="_blank" class="btn btn-whatsapp">
                                    <i class="fab fa-whatsapp"></i> <span>WhatsApp</span>
                                </a>
                                <button class="btn btn-copy" onclick="copyLink(this)">
                                    <i class="fas fa-link"></i> <span>Salin Link</span>
                                </button>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <aside class="sidebar">
                        <!-- Berita Terkait -->
                        <?php if (count($berita_terkait) > 0): ?>
                        <div class="sidebar-widget">
                            <h4 class="widget-title">
                                <i class="fas fa-newspaper"></i> Berita Terkait
                            </h4>
                            <div class="related-news-list">
                                <?php foreach ($berita_terkait as $related): ?>
                                <a href="berita.php?id=<?php echo $related['id']; ?>" class="related-news-item">
                                    <?php if (!empty($related['image_url'])): ?>
                                    <div class="related-news-image">
                                        <img src="<?php echo htmlspecialchars($related['image_url']); ?>" 
                                             alt="<?php echo htmlspecialchars($related['title']); ?>"
                                             onerror="this.src='https://via.placeholder.com/100x80?text=News'">
                                    </div>
                                    <?php endif; ?>
                                    <div class="related-news-content">
                                        <h6><?php echo htmlspecialchars($related['title']); ?></h6>
<small>
    <i class="far fa-calendar-alt"></i>
    <?php 
        // Format tanggal Indonesia dengan validasi
        $dateValue = $related['date'];
        
        // Cek apakah sudah dalam format yang benar (contoh: "27 November 2025")
        if (strpos($dateValue, ' ') !== false && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateValue)) {
            // Sudah format Indonesia, langsung tampilkan
            echo $dateValue;
        } else {
            // Konversi dari format YYYY-MM-DD ke format Indonesia
            $timestamp = strtotime($dateValue);
            
            // Validasi timestamp
            if ($timestamp === false || $timestamp < 0) {
                echo $dateValue; // Tampilkan original jika gagal konversi
            } else {
                $bulan = array(
                    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                );
                echo date('d', $timestamp) . ' ' . $bulan[(int)date('n', $timestamp)] . ' ' . date('Y', $timestamp);
            }
        }
    ?>
</small>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- CTA Widget -->
                        <div class="sidebar-widget cta-widget">
                            <div class="cta-content">
                                <div class="cta-icon">
                                    <i class="fas fa-wifi"></i>
                                </div>
                                <h5>Tertarik dengan ICONNET?</h5>
                                <p>Dapatkan internet cepat dan stabil untuk kebutuhan Anda</p>
                                <a href="Product.php" class="btn btn-cta">
                                    Lihat Paket <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Back to News -->
                        <div class="sidebar-widget">
                            <a href="index.php#berita" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Berita
                            </a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <!-- <footer class="bg-dark text-white py-4">
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
    </footer> -->

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Copy Link & Scroll Scripts -->
    <script>

        // Scroll to Top Function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Show/Hide Scroll to Top Button
        window.addEventListener('scroll', function() {
            const scrollButton = document.getElementById('scrollToTop');
            if (window.pageYOffset > 300) {
                scrollButton.classList.add('visible');
            } else {
                scrollButton.classList.remove('visible');
            }

            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            if (window.pageYOffset > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
    <script>
function copyLink(button) {
    const url = window.location.href;

    // Browser modern
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(() => {
            const originalHTML = button.innerHTML;

            button.innerHTML = '<i class="fas fa-check"></i> <span>Tersalin!</span>';
            button.classList.add('btn-success');
            button.classList.remove('btn-copy');

            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('btn-success');
                button.classList.add('btn-copy');
            }, 2000);
        }).catch(() => {
            fallbackCopy(url);
        });
    } else {
        fallbackCopy(url);
    }
}

// Fallback untuk browser lama
function fallbackCopy(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-9999px';

    document.body.appendChild(textArea);
    textArea.select();

    try {
        document.execCommand('copy');
        alert('Link berhasil disalin!');
    } catch (err) {
        alert('Browser tidak mendukung salin otomatis');
    }

    document.body.removeChild(textArea);
}
</script>

</body>
</html>