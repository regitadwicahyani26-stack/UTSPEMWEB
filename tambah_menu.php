<?php
session_start();
include 'koneksi.php';

// Cek apakah yang masuk adalah admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Logika Tambah Menu
if (isset($_POST['tambah'])) {
    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga     = mysqli_real_escape_string($conn, $_POST['harga']);
    $gambar    = mysqli_real_escape_string($conn, $_POST['gambar']);
    $dheskripsi = mysqli_real_escape_string($conn, $_POST['dheskripsi']);

    $query = "INSERT INTO menu (nama, harga, gambar, dheskripsi) 
              VALUES ('$nama', '$harga', '$gambar', '$dheskripsi')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Menu Berhasil Ditambahkan!');
                window.location='admin_dashboard.php';
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
    <title>Tambah Menu Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; }
        .card { border-radius: 15px; border: none; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center mb-4">Tambah Menu Kuliner</h3>
                <hr>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Sate Kambing" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 25000" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Gambar</label>
                        <input type="text" name="gambar" class="form-control" placeholder="https://link-gambar.jpg" required>
                        <small class="text-muted">Gunakan link gambar dari internet atau path folder.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dheskripsi</label>
                        <textarea name="dheskripsi" class="form-control" rows="4" placeholder="Jelaskan kelezatan menu ini..." required></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="tambah" class="btn btn-success">Simpan Menu</button>
                        <a href="admin_dashboard.php" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>