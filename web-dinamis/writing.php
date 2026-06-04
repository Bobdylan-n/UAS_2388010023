<?php
require_once 'config/database.php';

// 1. Ambil Parameter Search dari URL
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// 2. Bangun Query SQL Dinamis dengan Filter Pencarian
if (!empty($search)) {
    $sql = "SELECT * FROM writings 
            WHERE title LIKE :search 
               OR content LIKE :search 
               OR mood LIKE :search 
            ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => '%' . $search . '%']);
} else {
    $sql = "SELECT * FROM writings ORDER BY id DESC";
    $stmt = $pdo->query($sql);
}

$writings = $stmt->fetchAll();

include 'components/header.php';
?>

<style>
    /* Mengatasi Gap Atas & Mengatur Padding Halaman */
    .writing-page {
        margin-top: 30px;
        padding-bottom: 80px;
        min-height: 100vh;
    }

    .writing-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.6rem;
        font-weight: 500;
        color: #1A1A1A;
        margin-bottom: 10px;
        letter-spacing: -1px;
    }

    .writing-subtitle {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    /* Desain Premium Search Bar Sastra - Konsisten dengan art.php */
    .search-wrapper-premium {
        position: relative;
        display: flex;
        align-items: center;
        background-color: #F7F6F3;
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 6px 36px 6px 14px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        width: 100%;
    }
    .search-wrapper-premium:focus-within {
        background-color: #FFF;
        border-color: #8C7853;
        box-shadow: 0 4px 20px rgba(140, 120, 83, 0.08);
    }
    .search-icon-svg {
        color: #8C8A85;
        margin-right: 10px;
        flex-shrink: 0;
        transition: color 0.3s ease;
    }
    .search-wrapper-premium:focus-within .search-icon-svg {
        color: #8C7853;
    }
    .search-box-gallery {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        color: #1A1A1A;
        padding: 6px 0;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
        width: 100%;
    }
    .search-box-gallery::placeholder {
        color: #A3A19C;
        font-weight: 300;
    }
    
    /* Tombol Bersihkan Pencarian (Silang) */
    .search-clear-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #A3A19C;
        font-size: 1.3rem;
        line-height: 1;
        padding: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s, transform 0.2s;
        text-decoration: none !important;
    }
    .search-clear-btn:hover {
        color: #1A1A1A;
        transform: translateY(-50%) scale(1.1);
    }

    /* Card Tulisan (Writings) */
    .prose-card {
        background-color: #FFF;
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 0;
        padding: 2.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.01);
        transition: all 0.3s ease;
    }
    .prose-card:hover {
        border-color: rgba(0, 0, 0, 0.1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
    .prose-meta {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #8E8D8A;
        text-transform: uppercase;
    }
    .prose-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        color: #1A1A1A;
        font-weight: 500;
    }
    
    /* Teks cuplikan gaya mesin tik */
    .prose-snippet {
        font-family: 'Courier New', Courier, monospace;
        color: #333333;
        font-size: 0.92rem;
        line-height: 1.7;
        font-weight: 500;
    }

    /* Teks Penulis */
    .prose-author {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        color: #8C7853;
        font-size: 0.9rem;
    }
    
    .read-more-link {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #1A1A1A;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        position: relative;
        transition: color 0.3s ease;
    }
    .read-more-link::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 1px;
        bottom: -2px;
        left: 0;
        background-color: #8C7853;
        transform: scaleX(0);
        transform-origin: bottom right;
        transition: transform 0.3s ease;
    }
    .read-more-link:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
</style>

<div class="container py-4" style="margin-bottom: 80px;">

    <div class="row align-items-center mb-4 g-4">
        <div class="col-md-6">
            <h1 class="writing-title">Writings & Stories</h1>
            <p class="writing-subtitle">Kumpulan puisi, catatan rasa, dan arsip pikiran yang tertinggal dalam sunyi.</p>
        </div>
        
        <div class="col-md-6">
            <form action="" method="GET" class="d-flex justify-content-md-end align-items-center">
                <div style="width: 100%; max-width: 340px;">
                    <div class="search-wrapper-premium">
                        <svg class="search-icon-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        
                        <input type="text" name="search" class="form-control search-box-gallery m-0" placeholder="Cari puisi, prosa, atau mood..." value="<?= htmlspecialchars($search); ?>" autocomplete="off">
                        
                        <?php if (!empty($search)): ?>
                            <a href="writing.php" class="search-clear-btn" title="Bersihkan Pencarian">&times;</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr class="mb-5 mt-2" style="border-color: rgba(0,0,0,0.06); opacity: 1;">

    <?php if(empty($writings)): ?>
        <div class="text-center py-5">
            <p class="text-muted small italic">
                <?= !empty($search) ? 'Tidak ada hasil sastra yang cocok dengan pencarian Anda.' : 'Belum ada baris puisi atau prosa yang ditulis.'; ?>
            </p>
        </div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach($writings as $write): ?>
                <div class="col-lg-6">
                    <div class="prose-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="prose-meta mb-2 d-flex justify-content-between">
                                <span>Mood: #<?= htmlspecialchars($write['mood']); ?></span>
                                <span><?= date('F Y', strtotime($write['created_at'])); ?></span>
                            </div>

                            <h5 class="prose-title mb-3">
                                <?= htmlspecialchars($write['title']); ?>
                            </h5>

                            <p class="prose-snippet mb-2">
                                <?= nl2br(htmlspecialchars(substr($write['content'], 0, 220))); ?>...
                            </p>
                            
                            <div class="text-end mb-4">
                                <span class="prose-author">&mdash; <?= htmlspecialchars($write['author'] ?? 'Derma'); ?></span>
                            </div>
                        </div>

                        <div>
                            <a href="writing-detail.php?id=<?= $write['id']; ?>" class="read-more-link">Baca Bait Utuh &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<?php include 'components/footer.php'; ?>