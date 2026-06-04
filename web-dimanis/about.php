<?php
require_once 'config/database.php';

$status_message = '';

// Proses jika form kontak mengirimkan pesan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $sql = "INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'name'    => $name,
                'email'   => $email,
                'message' => $message
            ]);
            $status_message = 'success';
        } catch (PDOException $e) {
            $status_message = 'error';
        }
    } else {
        $status_message = 'empty';
    }
}

include 'components/header.php';
?>

<style>
    .about-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 500;
        color: #1A1A1A;
        letter-spacing: -1px;
    }
    
    .about-subtitle {
        font-family: 'Courier New', Courier, monospace;
        color: #8C7853;
        font-size: 0.95rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .about-statement {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #333;
        font-weight: 400;
    }

    /* Form Surat Minimalis */
    .form-minimal {
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 0;
        padding-left: 0;
        padding-right: 0;
        font-size: 0.95rem;
        color: #1A1A1A;
        transition: all 0.3s ease;
    }
    .form-minimal:focus {
        background: transparent;
        box-shadow: none;
        border-color: #8C7853;
    }

    /* Social Links */
    .social-link-item {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        color: #1A1A1A;
        text-decoration: none;
        font-size: 1.1rem;
        transition: color 0.3s ease, padding-left 0.3s ease;
        display: inline-block;
    }
    .social-link-item:hover {
        color: #8C7853;
        padding-left: 5px;
    }

    .btn-send-letter {
        background-color: #1A1A1A;
        color: #FBFBFA;
        border-radius: 0;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 12px 30px;
        transition: all 0.3s ease;
        border: none;
    }
    .btn-send-letter:hover {
        background-color: #8C7853;
        color: #FBFBFA;
    }
</style>

<div class="container py-4" style="margin-bottom: 80px;">

    <div class="row g-5">
        
        <div class="col-lg-6 pe-lg-5">
            <span class="about-subtitle d-block mb-2">Curator & Storyteller</span>
            <h1 class="about-title mb-4">Derma</h1>
            
            <div class="about-statement text-muted mb-4">
                <p>
                    Selamat datang di ruang sunyi ini. Sastra dan rupa bagi saya bukanlah sekadar hobi, melainkan lembar-lembar catatan tempat ingatan yang rapuh dirawat agar tidak lebur oleh waktu.
                </p>
                <p>
                    Melalui media visual dan susunan bait puisi, platform ini dibangun sebagai sebuah arsip emosi—sebuah tempat berteduh bagi siapa saja yang merindukan kedamaian di tengah riuhnya dunia luar.
                </p>
            </div>

            <hr class="my-4" style="border-color: rgba(0,0,0,0.06); opacity: 1;">

            <h5 class="text-dark small fw-bold tracking-wider text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Temukan Saya</h5>
            <div class="d-flex flex-column gap-2">
                <a href="https://instagram.com/dickydmwn__" target="_blank" class="social-link-item">Instagram &rarr;</a>
                <a href="https://pinterest.com/USERNAME_KAMU" target="_blank" class="social-link-item">Pinterest &rarr;</a>
                <a href="mailto:derma0512@gmail.com" class="social-link-item">Email &rarr;</a>
            </div>
        </div>

        <div class="col-lg-6 ps-lg-5 border-start border-light-subtle">
            <span class="about-subtitle d-block mb-2">Leave a Note</span>
            <h2 class="fw-medium text-dark mb-4" style="font-family: 'Playfair Display', serif; font-size: 2rem;">Kirim Pesan Sunyi</h2>

            <?php if ($status_message === 'success'): ?>
                <div class="alert alert-light text-success border-0 p-0 mb-4 small italic">
                    ✓ Pesan Anda telah terkirim dan disimpan ke dalam arsip rahasia. Terima kasih.
                </div>
            <?php elseif ($status_message === 'error'): ?>
                <div class="alert alert-light text-danger border-0 p-0 mb-4 small italic">
                    ✕ Maaf, sistem gagal mengirimkan pesan Anda. Silakan coba kembali.
                </div>
            <?php elseif ($status_message === 'empty'): ?>
                <div class="alert alert-light text-warning border-0 p-0 mb-4 small italic">
                    ⚠ Mohon isi seluruh baris pesan sebelum mengirimkannya.
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="mt-2">
                <div class="mb-4">
                    <label class="text-muted small text-uppercase tracking-wider d-block mb-1" style="font-size: 0.7rem;">Nama Pengunjung</label>
                    <input type="text" name="name" class="form-control form-minimal" placeholder="Siapa nama Anda?" required autocomplete="off">
                </div>

                <div class="mb-4">
                    <label class="text-muted small text-uppercase tracking-wider d-block mb-1" style="font-size: 0.7rem;">Alamat Surat Digital (Email)</label>
                    <input type="email" name="email" class="form-control form-minimal" placeholder="nama@email.com" required autocomplete="off">
                </div>

                <div class="mb-5">
                    <label class="text-muted small text-uppercase tracking-wider d-block mb-1" style="font-size: 0.7rem;">Isi Catatan / Pesan</label>
                    <textarea name="message" rows="4" class="form-control form-minimal" placeholder="Tuliskan baris pikiran atau kesan Anda di sini..." required></textarea>
                </div>

                <button type="submit" class="btn btn-send-letter w-100">Kirimkan Surat</button>
            </form>
        </div>

    </div>
</div>

<?php 
include 'components/footer.php'; 
?>