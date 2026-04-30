<?php
include 'koneksi.php';

// ============================================================
// CEK LOGIN MENGGUNAKAN COOKIE (bukan session)
// ============================================================
if (!isset($_COOKIE['user_login'])) {
    header("Location: login.php");
    exit;
}

$role       = $_COOKIE['user_role'] ?? 'user';
$nama_user  = $_COOKIE['user_nama'] ?? 'Pengguna';

// Jika admin nyasar ke sini, lempar ke dashboard admin
if ($role == 'admin') {
    header("Location: admin_dashboard.php");
    exit;
}

// Ambil data menu dari database
$query_menu = mysqli_query($conn, "SELECT * FROM menu");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rasa Nusantara - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="navbar">
        <div class="logo">Rasa Nusantara</div>
        <nav>
            <span class="user-greeting">Halo, <?php echo htmlspecialchars($nama_user); ?>!</span>
            <a href="#home">Home</a>
            <a href="#menu">Menu</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </nav>
    </header>

    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Kelezatan Lokal</h1>
            <p>Cita rasa asli nusantara dari resep warisan leluhur.</p>
            <a href="#menu" class="btn-hero">Eksplorasi Menu</a>
        </div>
    </section>

    <section class="menu" id="menu">
        <h2>Menu Andalan Kami</h2>
        <div class="container">

            <?php while ($row = mysqli_fetch_assoc($query_menu)) : ?>
            <div class="card">
                <img src="<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama']; ?>">
                <div class="card-info">
                    <h3><?php echo $row['nama']; ?></h3>
                    <p><?php echo $row['dheskripsi']; ?></p>
                    <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn-order">Pesan & Bayar</a>
                </div>
            </div>
            <?php endwhile; ?>

        </div>
    </section>

    <footer>
        <p>&copy; 2026 Rasa Nusantara - Nikmatnya Tradisi di Setiap Suapan.</p>
    </footer>

</body>
</html>