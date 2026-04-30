<?php
$host = "gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com";
$port = 4000;
$user = "3ymotaaKzzAD8W5.root";
$pass = "9M4ha2k6HvOhlgQY";
$db   = "restoran";

$koneksi = mysqli_init(); // ← bukan mysql_init()

$ca_path = '/etc/ssl/certs/ca-certificates.crt';
mysqli_ssl_set($koneksi, NULL, NULL, $ca_path, NULL, NULL);

$real_connect = mysqli_real_connect(
    $koneksi,
    $host,
    $user,
    $pass,
    $db,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$real_connect) { // ← bukan $conn, tapi $real_connect
    die("Koneksi gagal: " . mysqli_connect_error());
}

$conn = $koneksi; // ← tambahkan ini agar $conn bisa dipakai di file lain
?>