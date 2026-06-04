<?php
require_once 'auth-middleware.php';
require_once '../config/database.php';

$error = '';

if (isset($_POST['submit'])) {
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);
    $mood    = trim($_POST['mood']); 

    if (empty($title) || empty($content)) {
        $error = "Judul dan isi gubahan sastra tidak boleh dikosongkan.";
    } else {
        // Simpan data dengan Prepared Statement agar aman dari SQL Injection
        $stmt = $pdo->prepare("INSERT INTO writings (title, content, mood) VALUES (:title, :content, :mood)");
        $stmt->execute([
            'title'   => $title,
            'content' => $content,
            'mood'    => !empty($mood) ? $mood : 'Sastra'
        ]);

        header("Location: writing-list.php?pesan=tambah-sukses");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Karya Baru — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
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

        /* Workspace Panel Card */
        .workspace-panel {
            background: var(--panel-white);
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: 0;
            padding: 40px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            font-size: 1.8rem;
            letter-spacing: -0.5px;
        }

        /* Form Minimalis */
        .form-label-custom {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .form-control-minimal {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.12);
            border-radius: 0;
            padding: 0.6rem 0;
            font-size: 0.95rem;
            color: var(--dark-charcoal);
            transition: all 0.3s ease;
        }

        .form-control-minimal:focus {
            background: transparent;
            box-shadow: none;
            border-color: var(--accent-gold);
        }

        /* Ruang Ketik Monospace Estetik */
        .monospace-textarea {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-size: 0.95rem;
            line-height: 1.7;
            background-color: #FAFAFA;
            border: 1px dashed rgba(0, 0, 0, 0.15);
            border-radius: 0;
            padding: 24px;
            color: #2D3748;
            transition: all 0.3s ease;
            resize: vertical;
        }

        .monospace-textarea:focus {
            background-color: #FFFFFF;
            border-color: var(--accent-gold);
            box-shadow: none;
        }

        /* Tombol Aksi */
        .btn-save-minimal {
            background-color: var(--dark-charcoal);
            color: #FFF;
            border-radius: 0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 12px 28px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-save-minimal:hover {
            background-color: var(--accent-gold);
            color: #FFF;
        }

        .btn-cancel-minimal {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid rgba(0,0,0,0.15);
            border-radius: 0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 12px 24px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cancel-minimal:hover {
            background: #F3F3F1;
            color: var(--dark-charcoal);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg admin-navbar shadow-sm">
    <div class="container">
        <a class="navbar-brand-custom" href="index.php">
            The Gallery<span style="color: var(--accent-gold);">.</span> <small style="font-size: 0.8rem; font-family: 'Plus Jakarta Sans'; font-weight:400;" class="text-muted">Studio</small>
        </a>
    </div>
</nav>

<div class="container my-5" style="max-width: 760px;">
    
    <div class="workspace-panel shadow-sm">
        <h3 class="page-title mb-1">Gubahan Sastra Baru</h3>
        <p class="text-muted small mb-4">Tuangkan untaian rima puisi, prosa, atau fragmen cerita ke dalam jurnal digital.</p>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-light text-danger border-0 p-0 mb-4 small italic">
                ✕ <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            
            <div class="mb-4">
                <label for="title" class="form-label-custom">Judul Karya Sastra <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control form-control-minimal" required placeholder="Tuliskan tajuk gubahan..." autocomplete="off">
            </div>

            <div class="mb-4">
                <label for="mood" class="form-label-custom">Atmosfer / Penanda Rasa</label>
                <input type="text" name="mood" id="mood" class="form-control form-control-minimal" placeholder="Contoh: melankolia, sunyi, distopia, saujana" autocomplete="off">
                <small class="text-muted d-block mt-2" style="font-size: 0.75rem;"><i class="bi bi-tag me-1"></i>Gunakan satu atau dua kata kunci sebagai identitas emosi tulisan.</small>
            </div>

            <div class="mb-5">
                <label for="content" class="form-label-custom">Bait-Bait Tulisan <span class="text-danger">*</span></label>
                <textarea name="content" id="content" rows="15" class="form-control monospace-textarea" placeholder="Mulai ketikkan bait rahasia atau baris narasimu di sini..." required></textarea>
            </div>

            <div class="d-flex align-items-center gap-2 pt-2">
                <button type="submit" name="submit" class="btn btn-save-minimal px-4">Terbitkan Sastra</button>
                <a href="writing-list.php" class="btn btn-cancel-minimal">Batalkan</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>