<?php
session_start();
include 'koneksi.php';

// 1. Cek Login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// 2. Ambil ID Menu dari URL (misal: detail.php?id=1)
$id_menu = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// 3. Ambil data menu dari database berdasarkan ID
$query = "SELECT * FROM menu WHERE id = '$id_menu'";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

// Jika menu tidak ditemukan, kembalikan ke home atau beri pesan
if (!$item) {
    echo "<script>alert('Menu tidak ditemukan!'); window.location='home.php';</script>";
    exit;
}

// 4. Logika Simpan Pesanan (Jika form disubmit)
if (isset($_POST['konfirmasi_bayar'])) {
    
    // =========================================================================
    // PERBAIKAN: Mencegah user_id bernilai 0
    // =========================================================================
    $user_id = 0;
    
    // Cek apakah user_id sudah ada di session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } 
    // Jika tidak ada, kita cari otomatis di database berdasarkan nama di session
    else if (isset($_SESSION['nama'])) {
        $nama_session = mysqli_real_escape_string($conn, $_SESSION['nama']);
        $cari_user = mysqli_query($conn, "SELECT id FROM users WHERE nama_lengkap = '$nama_session' LIMIT 1");
        
        if ($row_user = mysqli_fetch_assoc($cari_user)) {
            $user_id = $row_user['id'];
            $_SESSION['user_id'] = $user_id; // Simpan ke session untuk pesanan berikutnya
        }
    }

    // Jika setelah dicari user_id tetap 0 (Data akun aneh/hilang)
    if ($user_id == 0) {
        echo "<script>alert('Sesi tidak valid! Silakan logout dan login kembali.'); window.location='login.php';</script>";
        exit;
    }
    // =========================================================================

    $menu_id = $item['id'];
    $jumlah  = $_POST['jumlah'];
    $metode  = $_POST['metode'];
    $total   = $jumlah * $item['harga'];

    $insert = "INSERT INTO pesanan (user_id, menu_id, jumlah, metode, total) 
               VALUES ('$user_id', '$menu_id', '$jumlah', '$metode', '$total')";

    if (mysqli_query($conn, $insert)) {
        echo "<script>
                alert('Pesanan Berhasil Disimpan!');
                window.location='home.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail & Pembayaran - <?= $item['nama']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #fdfdfd; }
        .product-image { border-radius: 20px; width: 100%; height: 400px; object-fit: cover; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .product-title { font-size: 2.5rem; color: #ffc107; font-weight: bold; }
        .payment-box { background: #fff; padding: 25px; border-radius: 15px; border: 1px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .btn-pay { background: #ffc107; border: none; width: 100%; padding: 12px; border-radius: 10px; font-weight: 600; transition: 0.3s; }
        .btn-pay:hover { background: #e5ac00; color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-5">
    <div class="container">
        <a class="navbar-brand text-warning fw-bold" href="home.php">Rasa Nusantara</a>
    </div>
</nav>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= $item['gambar']; ?>" class="product-image" alt="<?= $item['nama']; ?>">
            <h2 class="mt-4 product-title"><?= $item['nama']; ?></h2>
            <p class="text-muted" style="font-size: 1.1rem; line-height: 1.8;">
                <?= $item['dheskripsi']; ?>
            </p>
        </div>

        <div class="col-md-6">
            <div class="payment-box">
                <h4 class="mb-4">Konfirmasi Pesanan</h4>
                
                <form method="POST">
                    <div class="mb-3 d-flex justify-content-between">
                        <span>Harga Satuan:</span>
                        <span class="fw-bold">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Pesanan</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" oninput="updateTotal()">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode" id="metode" class="form-select" required>
                            <option value="">-- Pilih Pembayaran --</option>
                            <option value="DANA">DANA</option>
                            <option value="OVO">OVO</option>
                            <option value="ShopeePay">ShopeePay</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="COD">Tunai (COD)</option>
                        </select>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>Total Bayar:</h5>
                        <h4 class="text-success fw-bold" id="totalHarga">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></h4>
                    </div>

                    <button type="submit" name="konfirmasi_bayar" class="btn-pay">Konfirmasi & Pesan Sekarang</button>
                    <a href="home.php" class="btn btn-outline-secondary w-100 mt-2">Kembali ke Menu</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const hargaSatuan = <?= $item['harga']; ?>;

    function updateTotal() {
        let jumlah = document.getElementById('jumlah').value;
        if (jumlah < 1) jumlah = 1;
        
        let total = jumlah * hargaSatuan;
        document.getElementById('totalHarga').innerText = "Rp " + total.toLocaleString('id-ID');
    }
</script>

</body>
</html>