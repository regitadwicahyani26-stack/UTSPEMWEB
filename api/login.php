<?php
include 'koneksi.php';

if(isset($_POST['login'])){

    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(!$result){
        die("Query Error: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password'])){

            // ============================================================
            // SET COOKIE (bukan session)
            // Cookie berlaku 7 hari (86400 detik x 7)
            // ============================================================
            $durasi = time() + (86400 * 7);

            setcookie('user_login',   '1',                  $durasi, '/');
            setcookie('user_id',      $row['id'],            $durasi, '/');
            setcookie('user_nama',    $row['nama_lengkap'],  $durasi, '/');
            setcookie('user_role',    $row['role'],          $durasi, '/');

            if($row['role'] == "admin"){
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
<html>
<head>
    <title>Login - Rasa Nusantara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center" style="height: 100vh;">
    <div class="container border bg-white p-4 shadow rounded" style="max-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
        <?php if(isset($error)) echo "<p class='text-danger text-center'>Username/Password Salah!</p>"; ?>
        <form method="POST">
            <input type="email"    name="email"    class="form-control mb-3" placeholder="Masukkan Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button name="login" class="btn btn-warning w-100 fw-bold">Masuk</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>