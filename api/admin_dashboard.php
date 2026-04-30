<?php
session_start();
include 'koneksi.php';

// 1. Cek apakah yang masuk benar-benar admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// 2. Ambil Statistik Ringkas untuk Card Dashboard
$totalPesananQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan");
$totalPesanan = mysqli_fetch_assoc($totalPesananQuery)['total'];

$totalMenuQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM menu");
$totalMenu = mysqli_fetch_assoc($totalMenuQuery)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Rasa Nusantara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .sidebar {
            height: 100vh;
            background: #1a1a1a;
            color: white;
            padding: 20px;
            position: fixed;
            width: 16.666667%;
        }
        .sidebar h3 { color: #ffc107; font-weight: bold; margin-bottom: 30px; }
        .sidebar a {
            color: #ccc;
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
        }
        .sidebar a:hover { background: #333; color: #ffc107; }
        .main-content { margin-left: 16.666667%; padding: 40px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .img-table { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
        .badge-status { font-size: 0.85rem; padding: 6px 12px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <hr>
            <a href="#section-stats">Dashboard Utama</a>
            <a href="#section-menu">Kelola Menu</a>
            <a href="#section-pesanan">Daftar Pesanan</a>
            <a href="#section-bps">Data API BPS</a>
            <a href="logout.php" class="text-danger mt-5">Keluar (Logout)</a>
        </div>

        <div class="main-content col-md-10">

            <!-- SECTION: Statistik -->
            <div id="section-stats">
                <h2 class="mb-4">Selamat Datang, Admin <?php echo $_SESSION['nama']; ?>!</h2>

                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white p-4">
                            <h6>Total Pesanan</h6>
                            <h2><?php echo $totalPesanan; ?> Pesanan</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white p-4">
                            <h6>Menu Aktif</h6>
                            <h2><?php echo $totalMenu; ?> Menu</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION: Kelola Menu -->
            <div id="section-menu" class="card p-4 bg-white mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="m-0">Kelola Menu Restoran</h4>
                    <a href="tambah_menu.php" class="btn btn-success btn-sm fw-bold">+ Tambah Menu</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Nama Menu</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $menus = mysqli_query($conn, "SELECT * FROM menu ORDER BY id DESC");
                            while($m = mysqli_fetch_assoc($menus)):
                            ?>
                            <tr>
                                <td>#<?php echo $m['id']; ?></td>
                                <td><img src="<?php echo $m['gambar']; ?>" class="img-table" alt="menu"></td>
                                <td class="fw-bold"><?php echo $m['nama']; ?></td>
                                <td>Rp <?php echo number_format($m['harga'], 0, ',', '.'); ?></td>
                                <td style="max-width: 250px;">
                                    <small class="text-muted">
                                        <?php
                                            echo (strlen($m['dheskripsi']) > 60)
                                                ? substr($m['dheskripsi'], 0, 60) . "..."
                                                : $m['dheskripsi'];
                                        ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <a href="hapus_menu.php?id=<?php echo $m['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION: Daftar Pesanan -->
            <div id="section-pesanan" class="card p-4 bg-white mb-5">
                <h4 class="mb-4">Daftar Pesanan Masuk</h4>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Menu</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_pesanan = "SELECT pesanan.*, users.nama_lengkap, menu.nama as nama_menu
                                              FROM pesanan
                                              LEFT JOIN users ON pesanan.user_id = users.id
                                              LEFT JOIN menu ON pesanan.menu_id = menu.id
                                              ORDER BY pesanan.id DESC";
                            $result_pesanan = mysqli_query($conn, $query_pesanan);

                            if(mysqli_num_rows($result_pesanan) > 0){
                                while($p = mysqli_fetch_assoc($result_pesanan)){
                                    $nama_user = !empty($p['nama_lengkap']) ? $p['nama_lengkap'] : "<i class='text-danger'>User Terhapus (ID: {$p['user_id']})</i>";
                                    $nama_menu = !empty($p['nama_menu']) ? $p['nama_menu'] : "<i class='text-danger'>Menu Dihapus (ID: {$p['menu_id']})</i>";

                                    echo "<tr>
                                            <td>#{$p['id']}</td>
                                            <td><span class='fw-bold'>{$nama_user}</span></td>
                                            <td>{$nama_menu}</td>
                                            <td>{$p['jumlah']}</td>
                                            <td class='fw-bold text-success'>Rp ".number_format($p['total'],0,',','.')."</td>
                                            <td><span class='badge bg-info text-dark'>{$p['metode']}</span></td>
                                            <td><span class='badge bg-warning text-dark badge-status'>Diproses</span></td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center py-4'>Belum ada pesanan masuk.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION: Data API BPS -->
            <div id="section-bps" class="row mb-5">

                <!-- Card: Data Wilayah -->
                <div class="col-md-6">
                    <div class="card p-4 bg-white h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Data Wilayah (API BPS)</h4>
                            <button onclick="loadBPS()" class="btn btn-outline-primary btn-sm">Refresh Data</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40%">Atribut / Kunci</th>
                                        <th>Detail Informasi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-wilayah">
                                    <tr><td colspan="2" class="text-center text-muted py-4">Klik tombol refresh untuk memuat data.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Card: Data Informasi -->
                <div class="col-md-6">
                    <div class="card p-4 bg-white h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="m-0">Data Informasi (API BPS)</h4>
                            <button onclick="loadBPS()" class="btn btn-outline-primary btn-sm">Refresh Data</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="25%">Atribut / Kunci</th>
                                        <th>Detail Informasi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-informasi">
                                    <tr><td colspan="2" class="text-center text-muted py-4">Klik tombol refresh untuk memuat data.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- END SECTION BPS -->

        </div>
    </div>
</div>

<script>
function loadBPS() {
    const tblWilayah   = document.getElementById('data-wilayah');
    const tblInformasi = document.getElementById('data-informasi');

    // Tampilkan loading
    const loading = '<tr><td colspan="2" class="text-center py-4">Memuat data dari API BPS...</td></tr>';
    tblWilayah.innerHTML   = loading;
    tblInformasi.innerHTML = loading;

    fetch('alamat.php')
        .then(res => res.json())
        .then(data => {

            if (!data || data.status !== "OK") {
                const err = '<tr><td colspan="2" class="text-center text-danger">Data tidak ditemukan dari API.</td></tr>';
                tblWilayah.innerHTML   = err;
                tblInformasi.innerHTML = err;
                return;
            }

            // ── Tabel Kiri: Data Wilayah (info umum & subject) ──
            let rowsWilayah = '';

            rowsWilayah += `
                <tr>
                    <td class="fw-bold bg-light">Status</td>
                    <td>${data.status}</td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Ketersediaan</td>
                    <td>${data['data-availability'] ?? '-'}</td>
                </tr>
                <tr>
                    <td class="fw-bold bg-light">Last Update</td>
                    <td>${data['last_update'] ?? '-'}</td>
                </tr>
            `;

            if (data.subject && data.subject.length > 0) {
                data.subject.forEach(s => {
                    rowsWilayah += `
                        <tr>
                            <td class="fw-bold bg-light">Subject</td>
                            <td>${s.label}</td>
                        </tr>
                    `;
                });
            }

            tblWilayah.innerHTML = rowsWilayah;

            // ── Tabel Kanan: Data Informasi (var dari BPS) ──
            let rowsInfo = '';

            if (data.var && data.var.length > 0) {
                data.var.forEach(v => {
                    rowsInfo += `
                        <tr>
                            <td class="fw-bold bg-light">${v.val}</td>
                            <td>${v.label}</td>
                        </tr>
                    `;
                });
            } else {
                rowsInfo = '<tr><td colspan="2" class="text-center text-danger">Data var tidak tersedia.</td></tr>';
            }

            tblInformasi.innerHTML = rowsInfo;
        })
        .catch(err => {
            console.error(err);
            const errMsg = '<tr><td colspan="2" class="text-center text-danger py-4">Gagal memuat data.</td></tr>';
            tblWilayah.innerHTML   = errMsg;
            tblInformasi.innerHTML = errMsg;
        });
}
</script>

</body>
</html>