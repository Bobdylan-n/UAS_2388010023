<?php
require_once 'auth-middleware.php';
require_once '../config/database.php';

// Validasi parameter ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: art-list.php");
    exit;
}

$id = $_GET['id'];

// Ambil data detail artwork lama
$stmt = $pdo->prepare("SELECT * FROM artworks WHERE id = :id");
$stmt->execute(['id' => $id]);
$art = $stmt->fetch();

if (!$art) {
    die("Karya Seni Visual tidak ditemukan di database!");
}

$error = '';

if (isset($_POST['submit'])) {
    $title       = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category_id = null; // Kategori dihapus, diset otomatis kosong/null di database
    
    $file     = $_FILES['image'];
    $fileName = $file['name'];
    
    if (empty($title)) {
        $error = "Judul karya tidak boleh dikosongkan.";
    } else {
        $fileNewName = $art['image_path']; // Default menggunakan file gambar lama

        // Cek jika admin mengunggah file gambar baru
        if (!empty($fileName)) {
            $fileTmpName   = $file['tmp_name'];
            $fileSize      = $file['size'];
            $fileExt       = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowedExt    = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($fileActualExt, $allowedExt)) {
                $error = "Format berkas ditolak. Gunakan ekstensi standard: JPG, JPEG, PNG, atau WEBP.";
            } elseif ($fileSize > 3 * 1024 * 1024) {
                $error = "Ukuran berkas terlalu besar. Batas ambang maksimal adalah 3MB.";
            } else {
                // Hapus file fisik gambar lama dari server agar tidak membebani memori
                if (file_exists('../assets/uploads/' . $art['image_path'])) {
                    unlink('../assets/uploads/' . $art['image_path']);
                }
                
                // Set nama baru dan pindahkan file baru
                $fileNewName = uniqid('ART-', true) . "." . $fileActualExt;
                move_uploaded_file($fileTmpName, '../assets/uploads/' . $fileNewName);
            }
        }

        // Jika tidak terjadi error validasi gambar, eksekusi pembaruan SQL
        if (empty($error)) {
            $stmt_update = $pdo->prepare("UPDATE artworks SET category_id = :category_id, title = :title, image_path = :image_path, description = :description WHERE id = :id");
            $stmt_update->execute([
                'category_id' => $category_id,
                'title'       => $title,
                'image_path'  => $fileNewName,
                'description' => $description,
                'id'          => $id
            ]);

            header("Location: art-list.php?pesan=edit-sukses");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunting Artwork — Admin</title>
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

        /* File Upload Area & Preview */
        .preview-wrapper {
            background: #FAFAFA;
            border: 1px dashed rgba(0, 0, 0, 0.12);
            padding: 20px;
            text-align: center;
        }

        #image-preview {
            max-height: 200px;
            width: auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.05);
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
        <h3 class="page-title mb-1">Sunting Riwayat Rupa</h3>
        <p class="text-muted small mb-4">Modifikasi judul, visual, atau narasi lampau yang tersimpan di dalam sistem pameran.</p>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-light text-danger border-0 p-0 mb-4 small italic">
                ✕ <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="mb-4">
                <label for="title" class="form-label-custom">Judul Karya Seni <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control form-control-minimal" value="<?= htmlspecialchars($art['title']); ?>" required autocomplete="off">
            </div>

            <div class="mb-4">
                <label class="form-label-custom d-block">Media Visual Karya</label>
                <div class="preview-wrapper mb-3">
                    <img id="image-preview" src="../assets/uploads/<?= htmlspecialchars($art['image_path']); ?>" alt="Current Art">
                    <span class="d-block small text-muted mt-2" id="preview-text" style="font-size:0.75rem;">Gambar yang saat ini aktif di galeri</span>
                </div>
                
                <input type="file" name="image" id="image" class="form-control form-control-sm form-control-minimal border-bottom-0" accept="image/*" onchange="previewImage(this)">
                <small class="text-muted d-block mt-2" style="font-size:0.75rem;"><i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin memperbarui berkas gambar visual.</small>
            </div>

            <div class="mb-5">
                <label for="description" class="form-label-custom">Narasi / Catatan di Balik Karya</label>
                <textarea name="description" id="description" rows="5" class="form-control form-control-minimal" placeholder="Tuliskan catatan barunya..."><?= htmlspecialchars($art['description'] ?? ''); ?></textarea>
            </div>

            <div class="d-flex align-items-center gap-2 pt-2">
                <button type="submit" name="submit" class="btn btn-save-minimal px-4">Simpan Perubahan</button>
                <a href="art-list.php" class="btn btn-cancel-minimal">Batalkan</a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const labelText = document.getElementById('preview-text');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                labelText.innerHTML = "<span class='text-success fw-medium'>✓ Menampilkan pratinjau gambar baru (belum disimpan)</span>";
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>