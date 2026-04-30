<?php
$host = "gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com";
$port = 4000
$user = "3ymotaaKzzAD8W5.root";
$pass = "9M4ha2k6HvOhlgQY";
$db   = "restoran"; // <-- Ini yang diubah (menyesuaikan nama di phpMyAdmin)

$conn = mysqli_connect($host, $port, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>