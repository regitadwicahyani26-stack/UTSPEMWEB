<?php
include 'koneksi.php';

$error = false;

if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $durasi = time() + (86400 * 7);

            setcookie('user_login', '1',               $durasi, '/');
            setcookie('user_id',    $row['id'],         $durasi, '/');
            setcookie('user_nama',  $row['nama_lengkap'], $durasi, '/');
            setcookie('user_role',  $row['role'],       $durasi, '/');

            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit;
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Rasa Nusantara</title>
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
                    <h4 class="text-center mb-4">Login ke Akun Anda</h4>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">Email atau Password salah!</div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="email@contoh.com" required
                                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Password" required>
                        </div>
                        <button name="login" class="btn btn-warning w-100 fw-bold">Masuk</button>
                        <p class="mt-3 text-center mb-0">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>