<?php
include 'koneksi.php';
$error_msg   = '';
$success_msg = '';

if (isset($_POST['register'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        $error_msg = 'Email sudah terdaftar, gunakan email lain.';
    } else {
        $query = "INSERT INTO users (nama_lengkap, email, password, role) VALUES ('$nama', '$email', '$password', 'user')";
        if (mysqli_query($conn, $query)) {
            $success_msg = 'Pendaftaran berhasil! Silakan login.';
        } else {
            $error_msg = 'Pendaftaran gagal: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Rasa Nusantara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a1a1a; }
        .brand { color: #ffc107; font-weight: bold; font-size: 1.4rem; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <span class="brand">Rasa Nusantara</span>
                </div>
                <div class="card shadow p-4 bg-white">
                    <h4 class="text-center mb-4">Buat Akun Baru</h4>

                    <?php if ($error_msg): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
                    <?php endif; ?>

                    <?php if ($success_msg): ?>
                        <div class="alert alert-success">
                            <?= $success_msg ?>
                            <a href="login.php" class="alert-link">Klik di sini untuk login</a>.
                        </div>
                    <?php else: ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control"
                                   placeholder="Nama Lengkap" required
                                   value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="email@contoh.com" required
                                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Minimal 6 karakter" required minlength="6">
                        </div>
                        <button name="register" class="btn btn-warning w-100 fw-bold">Daftar Sekarang</button>
                        <p class="mt-3 text-center mb-0">Sudah punya akun? <a href="login.php">Login di sini</a></p>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>