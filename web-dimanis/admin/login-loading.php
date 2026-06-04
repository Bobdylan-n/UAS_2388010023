<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="4;url=index.php">
    <title>Menyapa Ruang Studio — The Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,400;1,500&family=Plus+Jakarta+Sans:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root { --bg-workspace: #F8F9FA; --dark-charcoal: #1A1A1A; --accent-gold: #8C7853; }
        body { background-color: var(--bg-workspace); font-family: 'Plus Jakarta Sans', sans-serif; color: var(--dark-charcoal); height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        
        .poetry-wrapper { max-width: 500px; text-align: center; padding: 20px; animation: fadeIn 1.5s ease-in-out; }
        
        .poetry-lines { font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.25rem; line-height: 2; margin-bottom: 2.5rem; }
        .poetry-lines span { display: block; opacity: 0; animation: fadeInUp 0.8s ease-out forwards; }
        
        .poetry-lines span:nth-child(1) { animation-delay: 0.3s; }
        .poetry-lines span:nth-child(2) { animation-delay: 1.2s; }
        .poetry-lines span:nth-child(3) { animation-delay: 2.1s; }

        .minimal-loader { width: 40px; height: 1px; background-color: rgba(0, 0, 0, 0.1); margin: 0 auto 15px auto; position: relative; overflow: hidden; }
        .minimal-loader::after { content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 50%; background-color: var(--accent-gold); animation: linePass 2s infinite linear; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes linePass { 0% { left: -50%; } 100% { left: 100%; } }
    </style>
</head>
<body>

<div class="poetry-wrapper">
    <div class="poetry-lines">
        <span>Kunci telah berputar pada engsel waktu,</span>
        <span>studio sunyi menyambut langkah barumu.</span>
        <span>Selamat datang kembali ke ruang cipta...</span>
    </div>

    <div class="minimal-loader"></div>
    <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; color: #6C757D;">Membuka pintu studio...</div>
</div>

<script>
    setTimeout(function() {
        window.location.href = 'index.php';
    }, 4500);
</script>

</body>
</html>