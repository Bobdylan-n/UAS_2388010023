<?php
session_start();
// Jika sudah login, langsung lempar ke dashboard admin
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — The Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Plus+Jakarta+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #FBFBFA;
            --primary-dark: #1A1A1A;
            --accent-gold: #8C7853;
            --text-muted: #7A7A7A;
        }

        body { 
            background-color: var(--bg-color); 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--primary-dark);
            -webkit-font-smoothing: antialiased;
        }

        .login-wrapper {
            width: 100%;
            max-width: 380px;
            padding: 20px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 500;
            letter-spacing: -0.5px;
            margin-bottom: 0.2rem;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent-gold);
            font-weight: 500;
        }

        /* Form Garis Minimalis */
        .form-label-custom {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0.3rem;
        }

        .form-control-minimal {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.12);
            border-radius: 0;
            padding: 0.6rem 0;
            font-size: 0.95rem;
            color: var(--primary-dark);
            transition: all 0.3s ease;
        }

        .form-control-minimal:focus {
            background: transparent;
            box-shadow: none;
            border-color: var(--accent-gold);
        }

        /* Tombol Premium */
        .btn-login-minimal {
            background-color: var(--primary-dark);
            color: var(--bg-color);
            border-radius: 0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 12px;
            transition: all 0.3s ease;
            border: none;
            font-weight: 500;
        }

        .btn-login-minimal:hover {
            background-color: var(--accent-gold);
            color: var(--bg-color);
        }

        /* Notifikasi Alert Estetik */
        .custom-alert {
            font-size: 0.8rem;
            border-radius: 0;
            border: none;
            background-color: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: var(--accent-gold);
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    
    <div class="brand-header">
        <h3 class="brand-title">The Gallery<span style="color: var(--accent-gold);">.</span></h3>
        <span class="brand-subtitle">Masuk Sejenak.</span>
    </div>
    
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
        <div class="custom-alert text-danger text-center">
            ✕ Identitas gagal diverifikasi. Periksa kembali username/password.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'tamu'): ?>
        <div class="custom-alert text-warning text-center">
            ⚠ Akses ditolak. Harap mendaftarkan sesi login terlebih dahulu.
        </div>
    <?php endif; ?>

    <form action="proses-login.php" method="POST">
        <div class="mb-4">
            <label Solusi untuk="username" class="form-label-custom">Kunci Pengenal (Username)</label>
            <input type="text" name="username" id="username" class="form-control form-minimal form-control-minimal" required autocomplete="off">
        </div>
        
        <div class="mb-5">
            <label for="password" class="form-label-custom">Kata Sandi (Password)</label>
            <input type="password" name="password" id="password" class="form-control form-minimal form-control-minimal" required>
        </div>
        
        <button type="submit" name="login" class="btn btn-login-minimal w-100">Buka Panel</button>
    </form>

    <a href="index.php" class="back-link">&larr; Kembali menuju galeri utama</a>

</div>

</body>
</html>