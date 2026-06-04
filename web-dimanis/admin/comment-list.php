<?php
require_once 'auth-middleware.php';
require_once '../config/database.php';

// Ambil semua komentar dan gabungkan dengan judul artwork
$query = "SELECT comments.*, artworks.title AS art_title
          FROM comments
          LEFT JOIN artworks ON comments.item_id = artworks.id
          WHERE comments.item_type = 'art'
          ORDER BY comments.id DESC";

$stmt = $pdo->query($query);
$comments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Komentar — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --bg-workspace: #F8F9FA;
            --panel-white: #FFFFFF;
            --dark-charcoal: #1A1A1A;
            --accent-gold: #8C7853;
            --text-muted: #6C757D;
        }

        body {
            background-color: var(--bg-workspace);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark-charcoal);
        }

        /* Navigasi */
        .admin-navbar {
            background-color: var(--panel-white);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 15px 0;
        }

        .navbar-brand-custom {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 1.35rem;
            color: var(--dark-charcoal) !important;
            text-decoration: none;
        }

        .btn-back-custom {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            border-radius: 0;
            padding: 8px 16px;
            border: 1px solid rgba(0,0,0,0.15);
            color: var(--dark-charcoal);
            transition: all 0.3s ease;
        }

        .btn-back-custom:hover { background-color: var(--dark-charcoal); color: #FFF; }

        .page-title { font-family: 'Playfair Display', serif; font-weight: 500; font-size: 1.8rem; }

        /* Panel & Tabel */
        .workspace-panel { background: var(--panel-white); border: 1px solid rgba(0, 0, 0, 0.04); padding: 30px; }
        
        .custom-table th {
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px;
            color: var(--text-muted); padding: 15px 10px; border-bottom: 2px solid #EEE;
        }

        .custom-table td { padding: 20px 10px; font-size: 0.9rem; border-bottom: 1px solid rgba(0,0,0,0.04); }

        .comment-text { font-style: italic; color: #4A4A4A; line-height: 1.6; }

        /* Tombol Aksi */
        .btn-action-round {
            width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); background: transparent;
            color: var(--dark-charcoal); transition: all 0.2s ease; text-decoration: none;
        }
        .btn-action-round.delete:hover { background-color: #DC3545; color: #FFF; border-color: #DC3545; }

        .custom-alert-toast { background-color: var(--dark-charcoal); color: #FFF; border-radius: 0; font-size: 0.85rem; border: none; padding: 14px 20px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg admin-navbar shadow-sm">
    <div class="container">
        <a class="navbar-brand-custom" href="index.php">
            The Gallery<span style="color: var(--accent-gold);">.</span> <small style="font-size: 0.8rem; font-family: 'Plus Jakarta Sans'; font-weight:400;" class="text-muted">Studio</small>
        </a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-back-custom"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="mb-4">
        <h2 class="page-title">Moderasi Komentar</h2>
        <p class="text-muted small">Mengelola interaksi pengunjung dan meninjau setiap suara yang masuk ke dalam galeri.</p>
    </div>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus-sukses'): ?>
        <div class="alert alert-success custom-alert-toast mb-4">
            <i class="bi bi-check-circle-fill text-success me-2"></i> Komentar telah berhasil dihapus dari sistem.
        </div>
    <?php endif; ?>

    <div class="workspace-panel shadow-sm">
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 200px;">Pengunjung</th>
                        <th>Isi Komentar</th>
                        <th style="width: 250px;">Terkait Karya</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($comments)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5 italic">
                                <i class="bi bi-chat-dots d-block mb-2 fs-3 text-black-50"></i>
                                Belum ada suara atau komentar pengunjung yang masuk.
                            </td>
                        </tr>
                    <?php else: $no = 1; foreach ($comments as $com): ?>
                        <tr>
                            <td class="text-muted fw-medium"><?= sprintf("%02d", $no++); ?></td>
                            <td>
                                <span class="fw-semibold d-block"><?= htmlspecialchars($com['visitor_name']); ?></span>
                                <small class="text-muted" style="font-size: 0.7rem;">ID: #<?= $com['id']; ?></small>
                            </td>
                            <td class="comment-text"><?= nl2br(htmlspecialchars($com['comment_text'])); ?></td>
                            <td class="text-muted small"><?= htmlspecialchars($com['art_title'] ?? 'Artwork Terhapus'); ?></td>
                            <td class="text-center">
                                <a href="comment-delete.php?id=<?= $com['id']; ?>" class="btn-action-round delete" title="Hapus Komentar" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>