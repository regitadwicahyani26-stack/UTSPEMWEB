<?php
include 'koneksi.php';
if (isset($_POST['register'])) {
    // Ganti variable $username jadi $email
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Update Query-nya (username jadi email)
    $query = "INSERT INTO users (email, password, nama_lengkap) VALUES ('$email', '$password', '$nama')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil Daftar!'); window.location='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container border bg-white p-4 shadow rounded" style="max-width: 400px;">
        <h3 class="text-center mb-4">Buat Akun</h3>
        <form method="POST">
            <input type="text" name="nama_lengkap" class="form-control mb-3" placeholder="Nama Lengkap" required>
            <input type="email" name="email" class="form-control mb-3" placeholder="Alamat Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button name="register" class="btn btn-warning w-100 fw-bold">Daftar Sekarang</button>
            <p class="mt-3 text-center">Sudah punya akun? <a href="login.php">Login</a></p>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>