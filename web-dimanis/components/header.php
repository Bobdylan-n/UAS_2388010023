<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Art & Writing Gallery</title>
    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap" rel="stylesheet">
    
    <style>
        /* Base Styling */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #FBFBFA; /* Warna off-white galeri */
            color: #1A1A1A;
            overflow-x: hidden;
        }
        
        .font-serif { font-family: 'Playfair Display', serif; }

        /* Custom Aesthetic Navbar */
        .custom-navbar {
            background-color: rgba(251, 251, 250, 0.85) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            padding: 20px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand { 
            font-family: 'Playfair Display', serif; 
            font-weight: 600; 
            font-size: 1.4rem;
            color: #1A1A1A !important;
            letter-spacing: -0.5px;
        }

        .custom-navbar .nav-link {
            color: #555555 !important;
            font-size: 0.9rem;
            font-weight: 400;
            padding: 8px 16px !important;
            position: relative;
            transition: color 0.3s ease;
            letter-spacing: 0.3px;
        }

        /* Nav Link Hover Animation */
        .custom-navbar .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: 4px;
            left: 16px;
            background-color: #1A1A1A;
            transition: width 0.3s ease;
        }

        .custom-navbar .nav-link:hover::after {
            width: calc(100% - 32px);
        }

        .custom-navbar .nav-link:hover {
            color: #1A1A1A !important;
        }

        /* Mobile Toggler Styling */
        .navbar-toggler { border: none !important; padding: 0; }
        .navbar-toggler:focus { box-shadow: none !important; }

        /* --- STYLE TAMBAHAN UNTUK FOOTER (Ditaruh di sini agar global) --- */
        .custom-footer {
            background-color: #FBFBFA;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            color: #555555;
            font-size: 0.85rem;
        }
        .footer-brand { font-size: 1.1rem; font-weight: 600; color: #1A1A1A; }
        .copyright { color: #8E8D8A; font-weight: 300; }
        .tech-stack { color: #8E8D8A; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; }
        .footer-socials .social-link { color: #555555; text-decoration: none; transition: color 0.3s ease; }
        .footer-socials .social-link:hover { color: #8C7853; }
        .footer-socials .divider { margin: 0 6px; color: #D1D1D1; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top custom-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">Derma Gallery<span style="color: #8C7853;">.</span></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon" style="filter: invert(10%); width: 1.2rem;"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-center text-lg-start pt-3 pt-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="art.php">Visual Art</a></li>
                <li class="nav-item"><a class="nav-link" href="writing.php">Writings</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            </ul>
        </div>
    </div>
</nav>