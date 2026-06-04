<?php
require_once 'auth-middleware.php';
require_once '../config/database.php';

// Ambil semua data tulisan terbaru
$query = "SELECT * FROM writings ORDER BY id DESC";
$stmt = $pdo->query($query);
$writings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Writings — Admin</title>
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
            letter-spacing: -0.5px;
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
            background: transparent;
        }

        .btn-back-custom:hover {
            background-color: var(--dark-charcoal);
            color: #FFF;
        }

        /* Headings */
        .page-title {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            font-size: 1.8rem;
            letter-spacing: -0.5px;
        }

        /* Tombol Tulis Sastra Baru */
        .btn-add-minimal {
            background-color: var(--dark-charcoal);
            color: #FFF;
            border-radius: 0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-add-minimal:hover {
            background-color: var(--accent-gold);
            color: #FFF;
        }

        /* Panel & Tabel Modern */
        .workspace-panel {
            background: var(--panel-white);
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: 0;
            padding: 30px;
        }

        .custom-table inequities {
            border-bottom: 2px solid var(--dark-charcoal);
        }

        .custom-table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: var(--text-muted);
            padding: 15px 10px;
            background: transparent;
        }

        .custom-table td {
            padding: 16px 10px;
            font-size: 0.9rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        }

        .custom-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .custom-table tbody tr:hover {
            background-color: rgba(140, 120, 83, 0.03);
        }

        /* Badge Mood / Tag */
        .badge-mood {
            background-color: #F3F3F1;
            color: var(--accent-gold);
            font-weight: 500;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 0;
            letter-spacing: 0.5px;
            border-left: 2px solid var(--accent-gold);
        }

        /* Tombol Aksi Bulat */
        .btn-action-round {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid rgba(0,0,0,0.1);
            background: transparent;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            color: var(--dark-charcoal);
            text-decoration: none;
        }

        .btn-action-round.edit:hover {
            background-color: var(--accent-gold);
            color: #FFF;
            border-color: var(--accent-gold);
        }

        .btn-action-round.delete:hover {
            background-color: #DC3545;
            color: #FFF;
            border-color: #DC3545;
        }

        /* Notifikasi Sukses Custom */
        .custom-alert-toast {
            background-color: var(--dark-charcoal);
            color: #FFF;
            border-radius: 0;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 14px 20px;
        }
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
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="page-title mb-1">Manajemen Puisi & Sastra</h2>
            <p class="text-muted small mb-0">Daftar baris puisi, narasi, dan cerita pendek yang telah diarsipkan ke dalam sistem.</p>
        </div>
        <a href="writing-add.php" class="btn btn-add-minimal">
            <i class="bi bi-feather me-1"></i> Tulis Sastra Baru
        </a>
    </div>

    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success alert-dismissible fade show custom-alert-toast d-flex align-items-center justify-content-between mb-4" role="alert">
            <div>
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                <?php
                if ($_GET['pesan'] == 'tambah-sukses') echo "Gubahan sastra baru berhasil diterbitkan menuju jurnal publik.";
                if ($_GET['pesan'] == 'edit-sukses') echo "Perubahan bait-bait tulisan telah berhasil disimpan kembali.";
                if ($_GET['pesan'] == 'hapus-sukses') echo "Karya tulis berhasil dihapus dan dilenyapkan dari arsip.";
                ?>
            </div>
            <button type="button" class="btn-close btn-close-white p-0 m-0 align-self-center" data-bs-dismiss="alert" style="box-shadow:none;"></button>
        </div>
    <?php endif; ?>

    <div class="workspace-panel shadow-sm">
        <div class="table-responsive">
            <table class="table custom-table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 7px;">No</th>
                        <th>Judul Karya Tulis</th>
                        <th style="width: 25%;">Kutipan / Suasana (Mood)</th>
                        <th style="width: 20%;">Tanggal Rilis</th>
                        <th style="width: 120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($writings)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5 italic">
                                <i class="bi bi-journal-x d-block mb-2 fs-3 text-black-50"></i>
                                Belum ada karya tulis atau untaian puisi yang tersimpan.
                            </td>
                        </tr>
                    <?php else: $no = 1; foreach ($writings as $write): ?>
                        <tr>
                            <td class="text-muted fw-medium"><?= sprintf("%02d", $no++); ?></td>
                            <td>
                                <span class="d-block fw-semibold text-dark mb-0"><?= htmlspecialchars($write['title']); ?></span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">ID Registrasi: #W-<?= $write['id']; ?></small>
                            </td>
                            <td>
                                <span class="badge badge-mood">
                                    #<?= htmlspecialchars($write['mood'] ? $write['mood'] : 'General'); ?>
                                </span>
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-clock me-1"></i> <?= date('d M Y', strtotime($write['created_at'])); ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="writing-edit.php?id=<?= $write['id']; ?>" class="btn-action-round edit" title="Sunting Tulisan">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="writing-delete.php?id=<?= $write['id']; ?>" class="btn-action-round delete" title="Hapus Tulisan" onclick="return confirm('Apakah Anda yakin ingin melenyapkan untaian sastra ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
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