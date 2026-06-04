<?php
require_once 'auth-middleware.php';
require_once '../config/database.php';

$error = '';

if (isset($_POST['submit'])) {
    $title       = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category_id = null; // Kategori dihapus, diset otomatis kosong/null di database
    
    // Konfigurasi Upload File Gambar
    $file        = $_FILES['image'];
    $fileName    = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize    = $file['size'];
    $fileError   = $file['error'];
    
    $fileExt       = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowedExt    = ['jpg', 'jpeg', 'png', 'webp'];

    // Validasi Formulir & Gambar
    if (empty($title)) {
        $error = "Judul karya tidak boleh dikosongkan.";
    } elseif ($fileError === 4) {
        $error = "Harap sematkan berkas gambar rupa terlebih dahulu.";
    } elseif (!in_array($fileActualExt, $allowedExt)) {
        $error = "Format berkas ditolak. Gunakan ekstensi standard: JPG, JPEG, PNG, atau WEBP.";
    } elseif ($fileSize > 3 * 1024 * 1024) { // Batas maksimal 3MB
        $error = "Ukuran berkas terlalu besar. Batas ambang maksimal adalah 3MB.";
    } else {
        // Jika lolos validasi, acak nama file gambar baru agar tidak bentrok di server
        $fileNewName = uniqid('ART-', true) . "." . $fileActualExt;
        $fileDestination = '../assets/uploads/' . $fileNewName;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            // Masukkan data informasi ke database menggunakan Prepared Statement
            $stmt = $pdo->prepare("INSERT INTO artworks (category_id, title, image_path, description) VALUES (:category_id, :title, :image_path, :description)");
            $stmt->execute([
                'category_id' => $category_id,
                'title'       => $title,
                'image_path'  => $fileNewName,
                'description' => $description
            ]);

            header("Location: art-list.php?pesan=tambah-sukses");
            exit;
        } else {
            $error = "Terjadi kegagalan sistem saat memindahkan berkas ke penyimpanan server.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artwork Baru — Admin</title>
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

        /* File Upload Area */
        .form-file-custom {
            border: 1px dashed rgba(0, 0, 0, 0.15);
            padding: 20px;
            background: #FAFAFA;
            transition: all 0.3s ease;
        }
        
        .form-file-custom:focus-within {
            border-color: var(--accent-gold);
            background: #FFF;
        }

        /* Live Preview Frame */
        #preview-container {
            display: none;
            margin-top: 15px;
            text-align: center;
            background: #F3F3F1;
            padding: 15px;
            border: 1px solid rgba(0,0,0,0.05);
        }

        #image-preview {
            max-height: 250px;
            width: auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
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

<div class="container my-5" style="max-width: 680px;">
    
    <div class="workspace-panel shadow-sm">
        <h3 class="page-title mb-1">Guratan Rupa Baru</h3>
        <p class="text-muted small mb-4">Unggah data karya seni visual orisinal kamu ke dalam sistem basis data ruang pamer.</p>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-light text-danger border-0 p-0 mb-4 small italic">
                ✕ <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="mb-4">
                <label for="title" class="form-label-custom">Judul Karya Seni <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control form-control-minimal" required placeholder="Tulis nama mahakarya rupa..." autocomplete="off">
            </div>

            <div class="mb-4">
                <label for="image" class="form-label-custom">Unggah Berkas Seni (JPG, PNG, WEBP) <span class="text-danger">*</span></label>
                <div class="form-file-custom">
                    <input type="file" name="image" id="image" class="form-control form-control-sm" accept="image/*" required onchange="previewImage(this)">
                    <small class="text-muted d-block mt-2" style="font-size:0.75rem;"><i class="bi bi-info-circle me-1"></i>Kompresi berkas di bawah resolusi 3MB sangat dianjurkan.</small>
                </div>
                
                <div id="preview-container">
                    <span class="d-block small text-muted mb-2 text-uppercase tracking-wider" style="font-size:0.65rem;">Pratinjau Visual:</span>
                    <img id="image-preview" src="#" alt="Pratinjau Ungguhan">
                </div>
            </div>

            <div class="mb-5">
                <label for="description" class="form-label-custom">Narasi / Catatan di Balik Karya</label>
                <textarea name="description" id="description" rows="5" class="form-control form-control-minimal" placeholder="Tuangkan kisah, alat media rupa, atau bait puitis yang melatarbelakangi lahirnya karya ini..."></textarea>
            </div>

            <div class="d-flex align-items-center gap-2 pt-2">
                <button type="submit" name="submit" class="btn btn-save-minimal px-4">Arsipkan Karya</button>
                <a href="art-list.php" class="btn btn-cancel-minimal">Batalkan</a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const container = document.getElementById('preview-container');
        const preview = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            container.style.display = 'none';
        }
    }
</script>

</body>
</html>