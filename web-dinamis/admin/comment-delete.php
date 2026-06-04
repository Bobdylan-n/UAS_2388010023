<?php
require_once 'auth-middleware.php';
require_once '../config/database.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Eksekusi penghapusan komentar dari database di awal proses
    $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="4;url=comment-list.php?pesan=hapus-sukses">
    <title>Melarungkan Komentar — Admin</title>
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
            overflow: hidden;
        }

        .poetry-wrapper {
            max-width: 520px;
            text-align: center;
            padding: 20px;
            animation: fadeIn 1.2s ease-in-out;
        }

        .poetry-lines {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.25rem;
            line-height: 2;
            margin-bottom: 2.5rem;
        }

        .poetry-lines span {
            display: block;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .poetry-lines span:nth-child(1) { animation-delay: 0.3s; }
        .poetry-lines span:nth-child(2) { animation-delay: 1.2s; }
        .poetry-lines span:nth-child(3) { animation-delay: 2.1s; }

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

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes linePass { 0% { left: -50%; } 100% { left: 100%; } }
    </style>
</head>
<body>

<div class="poetry-wrapper">
    <div class="poetry-lines">
        <span>Satu suara telah dilarungkan ke cakrawala,</span>
        <span>jejak komentar kini hilang ditelan masa.</span>
        <span>Biarlah ruang ini kembali tenang tanpa sisa...</span>
    </div>

    <div class="minimal-loader"></div>
    <div class="redirect-text">Membersihkan riwayat interaksi...</div>
</div>

<script>
    setTimeout(function() {
        window.location.href = 'comment-list.php?pesan=hapus-sukses';
    }, 4200);
</script>

</body>
</html>