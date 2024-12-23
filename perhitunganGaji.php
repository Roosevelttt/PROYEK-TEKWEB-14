<?php
session_set_cookie_params(0);

session_start(); // Start the session

// Check if the session variable 'role' exists and if it's one of the allowed roles
if (!isset($_SESSION['jabatan']) || $_SESSION['jabatan'] !== 'pemilik') {
    // Redirect to login page if not logged in or pemilik
    header('Location: loginPage.php');
    exit();
}
// Include koneksi database dan kelas layanan baru
include 'koneksi.php';
include 'KaryawanService.php';

// Inisialisasi service
$service = new KaryawanService($conn);

$alert = '';
$details = '';

// Cek apakah ada aksi yang dilakukan pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'all') {
        // Hitung gaji untuk semua karyawan non-pemilik
        $result = $conn->query("SELECT id_karyawan FROM karyawan WHERE kode_karyawan NOT RLIKE '^[pP][0-9]+'");
        while ($row = $result->fetch_assoc()) {
            $service->hitungGaji($row['id_karyawan']);
        }

        $alert = "<script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Gaji semua karyawan berhasil diperbarui.'
            });
        </script>";
    } elseif ($action === 'hitung' && !empty($_POST['id_karyawan'])) {
        $id_karyawan = (int) $_POST['id_karyawan'];
        $detail = $service->hitungGaji($id_karyawan);
        if ($detail) {
            $details =
                "
            <div class='container mt-5'>
                <div class='card shadow-sm'>
                    <div class='card-header bg-primary text-white'>
                        <h5 class='mb-0'>Detail Gaji - {$detail['nama']}</h5>
                    </div>
                    <div class='card-body'>
                        <table class='table '>
                            <tr><th width='30%'>Base Salary</th><td>Rp " .
                number_format($detail['base_salary'], 0, ',', '.') .
                "</td></tr>
                            <tr><th>Increment</th><td>Rp " .
                number_format($detail['increment'], 0, ',', '.') .
                "</td></tr>
                            <tr><th>Bonus</th><td>Rp " .
                number_format($detail['bonus'], 0, ',', '.') .
                "</td></tr>
                            <tr class='table-info'><th>Total Salary</th><td><strong>Rp " .
                number_format($detail['total'], 0, ',', '.') .
                "</strong></td></tr>
                            <tr><th>Years of Work</th><td>{$detail['years_of_work']} tahun</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            ";

            $alert = "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Gaji Diperbarui',
                    text: 'Gaji karyawan {$detail['nama']} berhasil diperbarui!'
                });
            </script>";
        }
    } elseif ($action === 'detail' && !empty($_POST['id_karyawan'])) {
        $id_karyawan = (int) $_POST['id_karyawan'];
        $detail = $service->detailGaji($id_karyawan);
        if ($detail) {
            $details =
                "
            <div class='container mt-5'>
                <div class='card shadow-sm'>
                    <div class='card-header bg-secondary text-white'>
                        <h5 class='mb-0'>Detail Gaji - {$detail['nama']}</h5>
                    </div>
                    <div class='card-body'>
                        <table class='table table-bordered table-striped table-hover'>
                            <tr><th width='30%'>Base Salary</th><td>Rp " .
                number_format($detail['base_salary'], 0, ',', '.') .
                "</td></tr>
                            <tr><th>Increment</th><td>Rp " .
                number_format($detail['increment'], 0, ',', '.') .
                "</td></tr>
                            <tr><th>Bonus</th><td>Rp " .
                number_format($detail['bonus'], 0, ',', '.') .
                "</td></tr>
                            <tr class='table-info'><th>Total Salary</th><td><strong>Rp " .
                number_format($detail['total'], 0, ',', '.') .
                "</strong></td></tr>
                            <tr><th>Years of Work</th><td>{$detail['years_of_work']} tahun</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Gaji Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Memusatkan secara horizontal */
            justify-content: center;
            /* Memusatkan secara vertikal */
            text-align: center;
            /* Menyelaraskan teks ke tengah */
            margin: 20px auto;
        }

        .container-transparent {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Memusatkan secara horizontal */
            justify-content: center;
            /* Memusatkan secara vertikal */
            text-align: center;
            /* Menyelaraskan teks ke tengah */
            margin: 20px auto;
        }

        h1 {
            margin-bottom: 10px;
        }

        table {
            background-color: transparent;
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #A1A9B7;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
        }

        table th {
            cursor: pointer;
            color: #EFF0F3;
        }

        table tr:hover {
            background: #252527;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
            color: #D0D4DB;
            font-weight: bolder;
        }

        .btn :not(btn-success) {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: radial-gradient(circle, #ffff00, #E1AD15);
            ;
        }

        .modal {
            display: none;
            /* Sembunyikan modal secara default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            /* Latar belakang semi-transparan */
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease;
            /* Transisi halus */
            z-index: 1000;
            /* Pastikan modal di atas elemen lain */
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            /* Maksimal lebar modal */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            /* Bayangan untuk efek kedalaman */
        }

        .modal-content h3 {
            margin-bottom: 15px;
            /* Jarak antara judul dan konten */
        }

        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            /* Jarak antara input */
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            /* Pastikan padding tidak menambah lebar */
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
            /* Jarak antara tombol */
        }

        .modal-buttons .btn {
            flex: 1;
            /* Tombol mengambil ruang yang sama */
            margin: 0 5px;
            /* Jarak antar tombol */
            transform: translateY(0);
        }

        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background-image: url('assets/background.jpeg');
            background-size: cover;
            background-position: center;
            height: full;
        }

        main {
            flex: 1;
        }

        .navbar {
            width: 100%;
            margin: 0;
            padding: 2vh 1vw;
            background-color: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
        }

        .navbar .container-fluid {
            max-width: 100%;
            padding: 0;
        }

        .navbar-brand {
            color: white;
            font-size: 1.5rem;
        }

        .navbar-nav {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .navbar-nav .nav-item {
            list-style: none;
            padding: 0 0.5vw;
        }

        .navbar-nav .nav-item .nav-link {
            color: white;
            padding: 15px 20px;
            display: block;
            text-align: center;
        }

        .navbar-nav .nav-item1 .nav-link {
            color: white;
            padding: 15px 20px;
            display: block;
            text-align: center;
        }

        .navbar-nav .nav-item1 .nav-link:hover {
            color: #000;
            background: radial-gradient(circle, #ffff00, #E1AD15);
            border-radius: 50px;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #000;
            background: radial-gradient(circle, #ffff00, #E1AD15);
            border-radius: 50px;
        }

        .dropdown-menu {
            left: 0;
            right: auto;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
        }

        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            color: #333;
            padding: 10px 20px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .center-content {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3vh;
            height: 30vh;
            text-align: center;
            transform: translateY(10%);
        }

        .sphere {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: radial-gradient(circle, #ffff00, #E1AD15);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 1;
            transform: translateY(-25%);
        }

        .sphere-small {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: radial-gradient(circle, #ffff00, #E1AD15);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .text-behind {
            position: absolute;
            font-size: 5vw;
            color: #fff;
            margin: 3vh;
            font-weight: bold;
            z-index: 0;
            white-space: nowrap;
        }

        .title {
            text-align: center;
            font-size: 1.5vw;
            font-weight: bold;
            white-space: nowrap;
            padding: 1vw 0;
        }

        .text-behind:first-child {
            transform: translateY(-50%);
        }

        .text-behind:last-child {
            transform: translateY(50%);
        }

        .title {
            text-align: center;
            font-size: 1.5vw;
            font-weight: bold;
            white-space: nowrap;
            padding: 1vw 0;
        }

        .navbar-toggler-icon {
            filter: invert(100%);
            /* Change to white */
        }

        .navbar-logo {
        height: 100%; /* Gambar akan mengikuti tinggi navbar */
        max-height: 50px; /* Batas maksimal tinggi gambar */
        width: auto; /* Lebar otomatis berdasarkan proporsi gambar */
        object-fit: contain; /* Menjaga proporsi gambar */
        padding: 5px; /* Opsional: memberikan jarak di sekitar gambar */
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
    <a href="index.php">
          <img src="assets/logo6trsnprnt_1.png" alt="Deskripsi gambar" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-home"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="menambahProdukBaru.php"><i class="fas fa-box"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="pageHarga.php"><i class="fas fa-tags"></i></a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-store-alt"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="pageStokToko.php">Toko</a></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Gudang</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="lihatStokHargaBarangGudang.php">Lihat Stok</a></li>
                                <li><a class="dropdown-item" href="tambahStokGudang.php">Tambah Stok</a></li>
                                <li><a class="dropdown-item" href="pindah_stokGudang.php">Pindah Stok</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="halamanTransaksi.php"><i class="fas fa-exchange-alt"></i></a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-users"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="absensi.php">Absensi</a></li>
                        <li><a class="dropdown-item" href="perhitunganGaji.php">Perhitungan Gaji</a></li>
                        <li><a class="dropdown-item" href="MelihatAbsensiPage.php">List Absensi</a></li>
                        <li><a class="dropdown-item" href="pageKaryawan.php">Manajemen Karyawan</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-file-alt"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="pageLaporan.php">Transaksi</a></li>
                        <li><a class="dropdown-item" href="membuatLaporanStok.php">Stok Gudang</a></li>
                    </ul>
                </li>
                <li class="nav-item1"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container-transparent mt-5">
        <div class="center-content">
            <div class="text-behind">Daftar</div>
            <div class="text-behind">Karyawan</div>
            <div class="sphere"></div>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="action" value="all">
            <button type="submit" class="btn btn-success mb-3">Hitung Gaji Semua Karyawan</button>
        </form>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Gaji</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query('SELECT k.id_karyawan, k.nama, k.gaji, k.periode_terakhir FROM karyawan k');
                while ($row = $result->fetch_assoc()) {
                    // Gunakan periode_terakhir untuk menentukan status
                    $periode_terakhir = $row['periode_terakhir'] ? new DateTime($row['periode_terakhir']) : null;
                    $current_date = new DateTime();
                
                    $status = $periode_terakhir === null || $periode_terakhir->diff($current_date)->y >= 1 ? '<span class="text-danger">Perlu Diperbarui</span>' : '<span class="text-success">Terkini</span>';
                
                    echo "<tr>
                            <td>{$row['nama']}</td>
                            <td>Rp " .
                        number_format($row['gaji'], 0, ',', '.') .
                        "</td>
                            <td>{$status}</td>
                            <td>
                                <form method='POST' action='' style='display:inline;'>
                                    <input type='hidden' name='id_karyawan' value='{$row['id_karyawan']}'>
                                    <button type='submit' name='action' value='hitung' class='btn btn-primary btn-sm'>Hitung Gaji</button>
                                </form>
                                <form method='POST' action='' style='display:inline;'>
                                    <input type='hidden' name='id_karyawan' value='{$row['id_karyawan']}'>
                                    <button type='submit' name='action' value='detail' class='btn btn-secondary btn-sm'>Detail Gaji</button>
                                </form>
                            </td>
                        </tr>";
                }
                ?>

            </tbody>

        </table>
    </div>

    <!-- Rincian Perhitungan -->
    <?php echo $details; ?>

    <!-- Tampilkan Notifikasi -->
    <?php echo $alert; ?>


</body>

</html>
