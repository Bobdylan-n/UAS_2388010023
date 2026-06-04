<?php
require_once 'config/database.php';

$art_stmt = $pdo->query("SELECT artworks.*, categories.name AS category_name FROM artworks LEFT JOIN categories ON artworks.category_id = categories.id ORDER BY artworks.id DESC LIMIT 3");
$latest_arts = $art_stmt->fetchAll();

$writing_stmt = $pdo->query("SELECT * FROM writings ORDER BY id DESC LIMIT 3");
$latest_writings = $writing_stmt->fetchAll();

include 'components/header.php';
?>

<style>
    /* Overlay Transisi */
    #loader-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #FBFBFA; z-index: 9999; transition: opacity 1.5s ease; }

    /* Animasi fade-in-up */
    .fade-in-up { opacity: 0; transform: translateY(20px); transition: opacity 1s ease-out, transform 1s ease-out; }
    .fade-in-up.active { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.2s; }
    .delay-2 { transition-delay: 0.4s; }

    /* Hero & Layout */
    .hero-section { padding: 110px 0 80px 0; background-color: #FBFBFA; }
    .hero-title { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 500; color: #1A1A1A; line-height: 1.2; letter-spacing: -1px; }
    .hero-subtitle { font-family: 'Playfair Display', serif; font-style: italic; color: #666666; max-width: 650px; margin: 1.5rem auto; font-size: 1.15rem; }
    
    .btn-gallery-primary { background-color: #1A1A1A; color: #FBFBFA; padding: 12px 30px; border-radius: 0; border: none; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
    .btn-gallery-primary:hover { background-color: #8C7853; color: #FFF; }
    .btn-gallery-secondary { background-color: transparent; color: #1A1A1A; border: 1px solid rgba(0,0,0,0.15); padding: 12px 30px; border-radius: 0; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
    .btn-gallery-secondary:hover { border-color: #1A1A1A; background-color: rgba(0,0,0,0.02); }

    .section-title { font-family: 'Playfair Display', serif; font-size: 1.75rem; font-weight: 500; color: #1A1A1A; padding-bottom: 16px; position: relative; }
    .section-title::after { content: ''; position: absolute; left: 0; bottom: 0; width: 30px; height: 1px; background-color: #8C7853; }

    .art-card, .prose-card { background: transparent; border: none; }
    .art-img { width: 100%; height: 320px; object-fit: cover; transition: 0.8s; }
    .art-card:hover .art-img { transform: scale(1.03); }
    .prose-card { background-color: #FFF; border: 1px solid rgba(0,0,0,0.04); padding: 2.5rem; transition: 0.3s; }
    .prose-card:hover { border-color: rgba(0,0,0,0.1); }
</style>

<div id="loader-overlay"></div>

<header class="hero-section text-center fade-in-up">
    <div class="container">
        <h1 class="hero-title">Ruang Sunyi Visual & Rasa</h1>
        <p class="hero-subtitle">Arsip mandiri peretas pengamatan, baris-baris rupa, dan untaian bait sastra yang tertinggal, yang ditulis dan digores oleh Derma .</p>
        <div class="d-flex gap-3 justify-content-center mt-4 pt-2">
            <a href="art.php" class="btn btn-gallery-primary">Jelajahi Rupa</a>
            <a href="writing.php" class="btn btn-gallery-secondary">Membaca Bait</a>
        </div>
    </div>
</header>

<div class="container my-5 py-4">
    <div class="row g-5">
        <div class="col-lg-6 fade-in-up delay-1">
            <h3 class="section-title mb-5">Guratan Seni Terbaru</h3>
            <?php foreach ($latest_arts as $art): ?>
                <div class="card art-card mb-4">
                    <div class="overflow-hidden"><img src="assets/uploads/<?= htmlspecialchars($art['image_path']); ?>" class="art-img" alt="..."></div>
                    <div class="mt-3"><small class="text-uppercase text-secondary"><?= $art['category_name']; ?></small>
                    <h5 class="mt-1"><?= htmlspecialchars($art['title']); ?></h5></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-lg-6 fade-in-up delay-2">
            <h3 class="section-title mb-5">Bait Prosa Terakhir</h3>
            <?php foreach ($latest_writings as $write): ?>
                <div class="prose-card mb-4">
                    <div class="text-uppercase small text-muted mb-2"><?= date('F Y', strtotime($write['created_at'])); ?></div>
                    <h5><?= htmlspecialchars($write['title']); ?></h5>
                    <p class="text-secondary small"><?= substr(htmlspecialchars($write['content']), 0, 100); ?>...</p>
                    <a href="writing-detail.php?id=<?= $write['id']; ?>" class="text-dark fw-bold small text-decoration-none border-bottom border-dark">BACA BAIT &rarr;</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    // Animasi Overlay
    window.addEventListener('load', () => {
        const loader = document.getElementById('loader-overlay');
        loader.style.opacity = '0';
        setTimeout(() => { loader.style.display = 'none'; }, 1500);
    });

    // Animasi Muncul Konten
    document.addEventListener("DOMContentLoaded", () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('active'); });
        });
        document.querySelectorAll('.fade-in-up').forEach((el) => observer.observe(el));
    });
</script>

<?php include 'components/footer.php'; ?>