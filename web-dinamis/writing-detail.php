<?php
require_once 'config/database.php';

// 1. Validasi ID tulisan yang masuk
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: writing.php");
    exit;
}

$id = (int)$_GET['id'];

// 2. Ambil data tulisan berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM writings WHERE id = :id");
$stmt->execute(['id' => $id]);
$write = $stmt->fetch();

// Jika data tidak ditemukan di database, kembalikan ke arsip tulisan
if (!$write) {
    header("Location: writing.php");
    exit;
}

include 'components/header.php';
?>

<style>
    /* Mengatasi Gap Atas di bawah Navbar Fixed-top */
    .detail-writing-page {
        margin-top: 30px;
        padding-bottom: 90px;
        min-height: 85vh;
    }

    /* Tombol Kembali Minimalis */
    .btn-back-archive {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #8C7853;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s ease;
        font-weight: 500;
        background: transparent;
        border: none;
        padding: 0;
    }
    .btn-back-archive:hover {
        color: #1A1A1A;
    }

    /* Konten Artikel Bergaya Buku Vintage */
    .editorial-container {
        max-width: 740px;
        margin: 0 auto;
        
        /* Warna kertas tua & tekstur serat halus */
        background-color: #F9F7F2; 
        background-image: url('https://www.transparenttextures.com/patterns/paper-fibers.png');
        
        border: 1px solid #E0D8C3;
        padding: 4rem;
        
        /* Bayangan untuk kesan lembaran buku yang tebal */
        box-shadow: 0 10px 30px rgba(0,0,0,0.06), 
                    inset 0 0 100px rgba(255,255,255,0.3); 
        
        position: relative;
    }

    /* Efek sudut kertas terlipat yang elegan */
    .editorial-container::before {
        content: "";
        position: absolute;
        top: 0; right: 0;
        border-width: 0 30px 30px 0;
        border-style: solid;
        border-color: #E0D8C3 #F9F7F2;
        box-shadow: -3px 3px 5px rgba(0,0,0,0.05);
    }

    .editorial-meta {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #8E8D8A;
        text-transform: uppercase;
    }

    .editorial-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: #1A1A1A;
        font-weight: 500;
        line-height: 1.25;
        letter-spacing: -0.5px;
    }

    /* Pembatas Dekoratif Tengah */
    .editorial-divider {
        width: 40px;
        height: 1px;
        background-color: #8C7853;
        margin: 2rem 0;
    }

    /* Ruang Baca Utama - Tipografi yang lebih "Sastra" */
    .editorial-body {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        color: #2D2926; 
        font-size: 1.1rem;
        line-height: 1.8;
        font-weight: 400;
        white-space: pre-line;
        word-break: break-word;
        letter-spacing: 0.2px;
    }

    /* Style untuk Nama Penulis di Bagian Bawah Puisi */
    .editorial-author {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        color: #8C7853;
        font-size: 1rem;
    }

    /* Responsif untuk Smartphone */
    @media (max-width: 768px) {
        .editorial-container {
            padding: 2rem;
        }
        .editorial-title {
            font-size: 2rem;
        }
    }
</style>

<div class="container py-4" style="margin-bottom: 80px;">
    
    <div class="max-width-740 mx-auto mb-4" style="max-width: 740px;">
        <a href="writing.php" class="btn-back-archive">
            &larr; Kembali ke Arsip Sastra
        </a>
    </div>

    <article class="editorial-container">
        
        <div class="editorial-meta mb-3 d-flex justify-content-between align-items-center">
            <span>Mood: #<?= htmlspecialchars($write['mood']); ?></span>
            <span>Dipublikasikan pada <?= date('d F Y', strtotime($write['created_at'])); ?></span>
        </div>

        <h1 class="editorial-title mb-0">
            <?= htmlspecialchars($write['title']); ?>
        </h1>

        <div class="editorial-divider"></div>

        <div class="editorial-body">
            <?= htmlspecialchars($write['content']); ?>
        </div>

        <div class="text-end mt-4">
            <span class="editorial-author">&mdash; <?= htmlspecialchars($write['author'] ?? 'Derma'); ?></span>
        </div>

    </article>

</div>

<?php include 'components/footer.php'; ?>