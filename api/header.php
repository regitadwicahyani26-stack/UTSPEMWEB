<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, nama_lengkap) VALUES ('$username', '$password', '$nama')";
    
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, langsung pindah ke login.php
        header("Location: login.php");
        exit; // Sangat penting untuk menghentikan skrip setelah header
    } else {
        echo "Pendaftaran gagal: " . mysqli_error($conn);
    }
}
?>