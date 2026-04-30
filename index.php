<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuliner Lokal Indonesia</title>

    <link rel="stylesheet" href="style.css">
    
    <style>
        .hero-btn {
            margin-top: 30px;
            display: flex;
            gap: 20px; /* Jarak antara tombol Login dan Register */
            flex-wrap: wrap; /* Agar responsif di layar HP */
        }

        .btn-primary, .btn-outline {
            padding: 12px 40px;
            border-radius: 50px; /* Membuat bentuk tombol membulat (pill-shape) */
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            text-align: center;
        }

        /* Gaya untuk Tombol Login (Solid/Penuh) */
        .btn-primary {
            background-color: #ffc107; /* Warna kuning/oranye khas tema kuliner */
            color: #1a1a1a; /* Warna teks gelap */
            border: 2px solid #ffc107;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }

        .btn-primary:hover {
            background-color: #e0a800;
            border-color: #e0a800;
            transform: translateY(-3px); /* Efek tombol terangkat saat disentuh */
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.6);
        }

        /* Gaya untuk Tombol Register (Outline/Garis Luar) */
        .btn-outline {
            background-color: transparent;
            color: #ffffff; /* Teks putih agar kontras dengan background gelap */
            border: 2px solid #ffffff;
        }

        .btn-outline:hover {
            background-color: #ffffff;
            color: #1a1a1a; /* Teks berubah gelap saat background jadi putih */
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">Rasa Nusantara</div>
        <nav>
            <a href="#home">Home</a>
            <a href="#menu">Menu</a>
            <a href="#about">Tentang Kami</a>
            <a href="#contact">Kontak</a>
        </nav>
    </header>

    <section class="hero" id="home">
        <div class="overlay"></div>

        <div class="hero-content">
            <h1>Kelezatan Kuliner Lokal</h1>
            <p>Cita rasa asli nusantara yang menggugah selera langsung ke meja Anda.</p>

            <div class="hero-btn">
                <a href="login.php" class="btn-primary">Login</a>
                <a href="register.php" class="btn-outline">Register</a>
            </div>
        </div>
    </section>
 
    <script src="script.js"></script>
</body>
</html>