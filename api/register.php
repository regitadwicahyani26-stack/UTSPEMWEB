<?php
include 'koneksi.php';
if (isset($_POST['register'])) {
    // 1. Sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $nama  = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    
    // 2. Fix password_hash (The second parameter should be a constant like PASSWORD_DEFAULT)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    /* 3. Update Query:
       - We skip 'id' because it is usually AUTO_INCREMENT.
       - We match the order: (nama_lengkap, email, password)
    */
    $query = "INSERT INTO users (nama_lengkap, email, password) VALUES ('$nama', '$email', '$password')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil Daftar!'); window.location='login.php';</script>";
    } else {
        // Helpful for debugging if it fails
        echo "Error: " . mysqli_error($conn);
    }
}
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