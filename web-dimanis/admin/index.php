<?php
// Panggil middleware untuk memproteksi halaman ini
require_once 'auth-middleware.php';
require_once '../config/database.php';

// Ambil statistik data singkat untuk dashboard
$total_art     = $pdo->query("SELECT COUNT(*) FROM artworks")->fetchColumn();
$total_writing = $pdo->query("SELECT COUNT(*) FROM writings")->fetchColumn();
$total_comment = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — The Gallery</title>
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
            -webkit-font-smoothing: antialiased;
        }

        /* Top Navigation Bar */
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
            letter-spacing: -0.5px;
        }

        .user-greeting {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .btn-logout-custom {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            border-radius: 0;
            padding: 6px 16px;
            border: 1px solid rgba(0,0,0,0.15);
            color: var(--dark-charcoal);
            transition: all 0.3s ease;
        }

        .btn-logout-custom:hover {
            background-color: #DC3545;
            color: #FFF;
            border-color: #DC3545;
        }

        /* Typography & Header */
        .dashboard-title {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            font-size: 2rem;
            letter-spacing: -0.5px;
        }

        .dashboard-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Stat Cards */
        .card-stat {
            background: var(--panel-white);
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: 0;
            padding: 30px 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.04);
        }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--dark-charcoal);
            line-height: 1;
        }

        .stat-icon {
            font-size: 1.8rem;
            color: var(--accent-gold);
            opacity: 0.8;
        }

        /* Quick Action Area */
        .panel-menu {
            background: var(--panel-white);
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: 0;
            padding: 35px;
        }

        .panel-menu-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: var(--dark-charcoal);
            margin-bottom: 1.5rem;
        }

        .btn-action-minimal {
            background: transparent;
            color: var(--dark-charcoal);
            border: 1px solid var(--dark-charcoal);
            border-radius: 0;
            padding: 12px 24px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-action-minimal:hover {
            background: var(--dark-charcoal);
            color: var(--bg-workspace);
        }

        .btn-live-view {
            background: #F3F3F1;
            color: var(--accent-gold);
            border: none;
            border-radius: 0;
            padding: 12px 24px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-live-view:hover {
            background: var(--accent-gold);
            color: #FFF;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg admin-navbar shadow-sm">
    <div class="container">
        <a class="navbar-brand-custom" href="index.php">
            The Gallery<span style="color: var(--accent-gold);">.</span> <small style="font-size: 0.8rem; font-family: 'Plus Jakarta Sans'; font-weight:400;" class="text-muted">Studio</small>
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="user-greeting d-none d-sm-inline">
                <i class="bi bi-person-circle me-1"></i> Ruang Kerja: <strong><?= htmlspecialchars($_SESSION['admin_username']); ?></strong>
            </span>
            <a href="logout.php" class="btn btn-logout-custom">Keluar Sesi</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="dashboard-title mb-1">Selamat Datang di Panel Konten</h2>
            <p class="dashboard-subtitle">Tempat merawat ingatan rupa, menyunting untaian aksara, dan menata tanggapan jurnal.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card-stat d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Total Visual Art</div>
                    <div class="stat-number"><?= $total_art; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-palette"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card-stat d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Total Arsip Tulisan</div>
                    <div class="stat-number"><?= $total_writing; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card-stat d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Komentar Masuk</div>
                    <div class="stat-number"><?= $total_comment; ?></div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-chat-left-quote"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="panel-menu shadow-sm">
                <h5 class="panel-menu-title"><i class="bi bi-sliders me-2"></i>Kemudi Manajemen Galeri</h5>
                
                <div class="row g-3 align-items-center">
                    <div class="col-xl-9 col-lg-8 d-flex flex-wrap gap-3">
                        <a href="art-list.php" class="btn btn-action-minimal">
                            <i class="bi bi-images"></i> Kelola Artworks
                        </a>
                        <a href="writing-list.php" class="btn btn-action-minimal">
                            <i class="bi bi-pen"></i> Kelola Writings
                        </a>
                        <a href="comment-list.php" class="btn btn-action-minimal">
                            <i class="bi bi-shield-check"></i> Moderasi Komentar
                        </a>
                    </div>
                    
                    <div class="col-xl-3 col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="../index.php" target="_blank" class="btn btn-live-view w-100 text-center">
                            Live Site <i class="bi bi-arrow-up-right ms-1"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

</body>
</html>