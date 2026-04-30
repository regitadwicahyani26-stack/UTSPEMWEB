<?php
session_start();
include 'koneksi.php';

// 1. Keamanan: Cek apakah yang menghapus adalah admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// 2. Ambil ID menu dari URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. Jalankan query hapus
    $query = "DELETE FROM menu WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        // Jika berhasil, tampilkan notifikasi dan kembali ke dashboard
        echo "<script>
                alert('Menu berhasil dihapus!');
                window.location='admin_dashboard.php';
              </script>";
    } else {
        // Jika gagal karena alasan teknis
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
} else {
    // Jika mencoba akses langsung tanpa ID
    header("Location: admin_dashboard.php");
    exit;
}
?>