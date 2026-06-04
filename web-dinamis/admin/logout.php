<?php
session_start();

// Hancurkan semua session login terlebih dahulu di sisi server
$_SESSION = [];
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="4;url=login.php">
    <title>Meninggalkan Studio — The Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,400;1,500&family=Plus+Jakarta+Sans:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-workspace: #F8F9FA;
            --dark-charcoal: #1A1A1A;
            --accent-gold: #8C7853;
            --text-muted: #6C757D;
        }

        body {
            background-color: var(--bg-workspace);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark-charcoal);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
        }

        .poetry-wrapper {
            max-width: 500px;
            text-align: center;
            padding: 20px;
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Gaya Baris Puisi */
        .poetry-lines {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.25rem;
            line-height: 2;
            color: var(--dark-charcoal);
            margin-bottom: 2.5rem;
            letter-spacing: -0.2px;
        }

        .poetry-lines span {
            display: block;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        /* Efek jeda kemunculan baris puisi agar terasa dramatis */
        .poetry-lines span:nth-child(1) { animation-delay: 0.3s; }
        .poetry-lines span:nth-child(2) { animation-delay: 1.2s; }
        .poetry-lines span:nth-child(3) { animation-delay: 2.1s; }

        /* Loader Loading Garis Minimalis */
        .minimal-loader {
            width: 40px;
            height: 1px;
            background-color: rgba(0, 0, 0, 0.1);
            margin: 0 auto 15px auto;
            position: relative;
            overflow: hidden;
        }

        .minimal-loader::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 50%;
            background-color: var(--accent-gold);
            animation: linePass 2s infinite linear;
        }

        .redirect-text {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
        }

        /* Animasi Efek */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes linePass {
            0% { left: -50%; }
            100% { left: 100%; }
        }
    </style>
</head>
<body>

<div class="poetry-wrapper">
    <div class="poetry-lines">
        <span>Lampu-lampu galeri mulai meremang,</span>
        <span>untaian kata dan kanvas kini tersimpan tenang.</span>
        <span>Mari pulang, ruang sunyi ini akan menantangmu datang...</span>
    </div>

    <div class="minimal-loader"></div>
    <div class="redirect-text">Mengunci pintu studio digital...</div>
</div>

<script>
    setTimeout(function() {
        window.location.href = 'login.php';
    }, 4500); // Dialihkan setelah 4,5 detik agar user sempat membaca puisi
</script>

</body>
</html>