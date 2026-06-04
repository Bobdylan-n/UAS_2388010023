<?php
require_once 'config/database.php';

// 1. Pengaturan Pagination
$limit = 6; 
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = $page < 1 ? 1 : $page;
$start = ($page - 1) * $limit;

// 2. Ambil Parameter Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// 3. Bangun Query SQL Dinamis (Tanpa Filter Kategori)
$query_where = " WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query_where .= " AND (artworks.title LIKE :search OR artworks.description LIKE :search)";
    $params['search'] = '%' . $search . '%';
}

// 4. Hitung Total Data untuk Pagination
$sql_count = "SELECT COUNT(*) FROM artworks" . $query_where;
$stmt_count = $pdo->prepare($sql_count);
$stmt_count->execute($params);
$total_rows = $stmt_count->fetchColumn();
$total_pages = ceil($total_rows / $limit);

// 5. Ambil Data Artworks
$sql_data = "SELECT artworks.*, categories.name AS category_name 
             FROM artworks 
             LEFT JOIN categories ON artworks.category_id = categories.id" 
             . $query_where . 
             " ORDER BY artworks.id DESC LIMIT $start, $limit";

$stmt_data = $pdo->prepare($sql_data);
$stmt_data->execute($params);
$artworks = $stmt_data->fetchAll();

// Memanggil Header Komponen Global
include 'components/header.php';
?>

<style>
    /* Desain Modern Search Bar Premium & Responsif */
    .search-wrapper-premium {
        position: relative;
        display: flex;
        align-items: center;
        background-color: #F7F6F3;
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 6px 36px 6px 14px; /* Space kanan diperlebar untuk tombol silang */
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
    
    /* Tombol Silang Terikat Sempurna secara Absolut */
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

    /* Galeri Card Grid Modis */
    .art-archive-card {
        background-color: transparent;
        border: none;
        border-radius: 0;
        overflow: hidden;
        transition: all 0.4s ease;
    }
    .art-img-container {
        position: relative;
        width: 100%;
        padding-top: 100%; /* Rasio 1:1 Kotak Presisi */
        overflow: hidden;
        background-color: #F0EDE9;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }
    .art-img {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .art-archive-card:hover .art-img {
        transform: scale(1.03);
    }
    .art-archive-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        color: #1A1A1A;
        font-weight: 500;
    }

    /* Modal / Popup Detail Premium */
    .modal-content-custom {
        position: relative;
        background-color: #FBFBFA;
        border: 1px solid rgba(0, 0, 0, 0.08);
        color: #1A1A1A;
        border-radius: 0;
    }
    .modal-body-img {
        width: 100%;
        max-height: 550px;
        object-fit: contain;
        background-color: #F0EDE9;
        border: 1px solid rgba(0, 0, 0, 0.02);
    }
    
    /* Tombol Silang Modal Responsif Kunci di Kanan Atas */
    .modal-header-custom {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1050;
        padding: 0;
        border: none;
    }
    .modal-header-custom .btn-close {
        background-size: 0.8rem;
        padding: 10px;
        margin: 0;
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }
    .modal-header-custom .btn-close:hover {
        opacity: 1;
    }

    .comment-scroll {
        overflow-y: auto;
        max-height: 240px;
        padding-right: 6px;
    }
    .comment-scroll::-webkit-scrollbar { width: 3px; }
    .comment-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); }

    .comment-box {
        background-color: rgba(0, 0, 0, 0.02);
        padding: 12px;
        border: 1px solid rgba(0,0,0,0.04);
        margin-bottom: 10px;
    }

    /* Tombol Kirim Jurnal */
    .btn-submit-comment {
        background-color: #1A1A1A;
        color: #FBFBFA;
        border-radius: 0;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    .btn-submit-comment:hover {
        background-color: #8C7853;
        color: #FBFBFA;
    }

    /* Pagination Minimalis */
    .page-link-custom {
        background-color: #FFF;
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
        color: #555555;
        padding: 8px 16px;
        font-size: 0.85rem;
        border-radius: 0 !important;
        transition: all 0.3s ease;
    }
    .page-link-custom:hover {
        background-color: rgba(0, 0, 0, 0.02);
        color: #1A1A1A;
    }
    .page-item.active .page-link-custom {
        background-color: #1A1A1A !important;
        color: #FFF !important;
        border-color: #1A1A1A !important;
    }
</style>

<div class="container py-4" style="margin-bottom: 80px;">
    
    <div class="row align-items-center mb-4 g-4">
        <div class="col-md-6">
            <h1 class="fw-medium text-dark mb-2" style="font-family: 'Playfair Display', serif; font-size: 2.6rem; letter-spacing: -1px; line-height: 1.1;">Visual Archives</h1>
            <p class="text-muted small mb-0">Rangkaian tangkapan rupa, kolase cerita, dan dokumentasi rasa secara berkala.</p>
        </div>
        
        <div class="col-md-6">
            <form action="" method="GET" class="d-flex justify-content-md-end align-items-center">
                <div style="width: 100%; max-width: 340px;">
                    <div class="search-wrapper-premium">
                        <svg class="search-icon-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        
                        <input type="text" name="search" class="form-control search-box-gallery m-0" placeholder="Cari karya arsip rupa..." value="<?= htmlspecialchars($search); ?>" autocomplete="off">
                        
                        <?php if (!empty($search)): ?>
                            <a href="art.php" class="search-clear-btn" title="Bersihkan Pencarian">&times;</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr class="mb-5 mt-2" style="border-color: rgba(0,0,0,0.06); opacity: 1;">

    <div class="row g-4">
        <?php if (empty($artworks)): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted small italic">Tidak ada dokumentasi visual yang ditemukan.</p>
            </div>
        <?php else: ?>
            <?php foreach ($artworks as $art): ?>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card art-archive-card h-100" data-bs-toggle="modal" data-bs-target="#artModal<?= $art['id']; ?>" style="cursor: pointer;">
                        <div class="art-img-container">
                            <img src="assets/uploads/<?= htmlspecialchars($art['image_path']); ?>" class="art-img" alt="<?= htmlspecialchars($art['title']); ?>">
                        </div>
                        <div class="pt-3">
                            <span class="text-uppercase tracking-wider d-block mb-1" style="font-size: 0.7rem; color: #8C7853; font-weight: 500;">
                                <?= htmlspecialchars($art['category_name'] ?? 'General'); ?>
                            </span>
                            <h5 class="art-archive-title text-truncate mb-0"><?= htmlspecialchars($art['title']); ?></h5>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="artModal<?= $art['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content modal-content-custom">
                            <div class="modal-header modal-header-custom">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4 pt-4">
                                <div class="row g-4">
                                    <div class="col-lg-5">
                                        <img src="assets/uploads/<?= htmlspecialchars($art['image_path']); ?>" class="modal-body-img" alt="Detail Image">
                                    </div>
                                    <div class="col-lg-4 border-end border-light-subtle pe-lg-4">
                                        <span class="text-uppercase tracking-wider" style="font-size: 0.75rem; color: #8C7853; font-weight: 500;"><?= htmlspecialchars($art['category_name'] ?? 'General'); ?></span>
                                        <h3 class="fw-medium text-dark mt-1 mb-3 font-serif" style="font-family: 'Playfair Display', serif;"><?= htmlspecialchars($art['title']); ?></h3>
                                        <div class="overflow-y-auto mb-3" style="max-height: 280px;">
                                            <p class="text-muted lh-base" style="white-space: pre-line; font-size: 0.9rem;"><?= htmlspecialchars($art['description']); ?></p>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.75rem; font-weight: 300;">Arsip rilis: <?= date('d M Y', strtotime($art['created_at'])); ?></div>
                                    </div>
                                    <div class="col-lg-3 d-flex flex-column justify-content-between ps-lg-4">
                                        <div>
                                            <h6 class="text-dark small fw-bold tracking-wider text-uppercase mb-3" style="font-size: 0.75rem;">Tanggapan Lukisan</h6>
                                            <div class="comment-scroll">
                                                <?php
                                                try {
                                                    // UPDATE: Query diubah menjadi polimorfik memakai item_id dan item_type
                                                    $c_stmt = $pdo->prepare("
                                                        SELECT * FROM comments 
                                                        WHERE item_id = :art_id 
                                                        AND item_type = 'art'
                                                        ORDER BY id DESC
                                                    ");
                                                    $c_stmt->execute(['art_id' => $art['id']]);
                                                    $comments = $c_stmt->fetchAll();
                                                } catch (PDOException $e) {
                                                    $comments = [];
                                                }

                                                if (empty($comments)):
                                                ?>
                                                    <p class="text-muted small italic my-2" style="font-size: 0.8rem;">Kolom sunyi, belum ada tanggapan.</p>
                                                <?php else: ?>
                                                    <?php foreach ($comments as $com): ?>
                                                        <div class="comment-box">
                                                            <div class="d-flex justify-content-between mb-1" style="font-size: 0.7rem;">
                                                                <strong class="text-dark"><?= htmlspecialchars($com['visitor_name']); ?></strong>
                                                                <span class="text-muted"><?= date('d/m/y', strtotime($com['created_at'])); ?></span>
                                                            </div>
                                                            <p class="text-muted small mb-0 lh-sm" style="word-break: break-word; font-size: 0.8rem;"><?= nl2br(htmlspecialchars($com['comment_text'])); ?></p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-top border-light-subtle">
                                            <form action="proses-komentar.php" method="POST">
                                                <input type="hidden" name="item_id" value="<?= $art['id']; ?>">
                                                <input type="hidden" name="item_type" value="art">
                                                
                                                <div class="mb-2">
                                                    <input type="text" name="visitor_name" class="form-control form-control-sm search-box-gallery" placeholder="Nama..." required autocomplete="off" style="font-size: 0.8rem; border-bottom: 1px solid rgba(0, 0, 0, 0.15) !important;">
                                                </div>
                                                <div class="mb-2">
                                                    <textarea name="comment_text" rows="2" class="form-control form-control-sm search-box-gallery" placeholder="Tulis catatan pikiran..." required style="font-size: 0.8rem; border-bottom: 1px solid rgba(0, 0, 0, 0.15) !important;"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-submit-comment w-100 mt-1">Kirim Catatan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if ($total_pages > 1): ?>
        <nav class="d-flex justify-content-center mt-5 pt-4">
            <ul class="pagination gap-1">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $page === $i ? 'active' : ''; ?>">
                        <a class="page-link page-link-custom border-0" href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php 
include 'components/footer.php'; 
?>