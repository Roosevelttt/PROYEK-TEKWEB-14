<?php
include 'koneksi.php';

// Fungsi untuk mendapatkan bulan dan tahun unik dari detail_laporan
function getUniqueMonthsAndYears($conn)
{
    $sql = "SELECT DISTINCT 
                YEAR(tanggal_in_out) AS tahun, 
                MONTH(tanggal_in_out) AS bulan
            FROM detail_laporan
            ORDER BY tahun DESC, bulan DESC";
    $result = $conn->query($sql);

    $months = [];
    while ($row = $result->fetch_assoc()) {
        $months[] = [
            'tahun' => $row['tahun'],
            'bulan' => $row['bulan'],
        ];
    }

    return $months;
}

// Mendapatkan daftar bulan dan tahun unik
$uniqueMonths = getUniqueMonthsAndYears($conn);

// Menyusun daftar tahun yang unik untuk dropdown
$years = array_unique(array_column($uniqueMonths, 'tahun'));
sort($years); // Urutkan tahun dari yang terbaru

// Mengatur bulan dan tahun default atau dari input
$currentMonth = date('m');
$currentYear = date('Y');

// Menangani jika ada input dari form
if (isset($_POST['pilih_bulan']) && isset($_POST['pilih_tahun'])) {
    $bulanLaporan = $_POST['pilih_bulan'];
    $tahunLaporan = $_POST['pilih_tahun'];
} else {
    $bulanLaporan = $currentMonth;
    $tahunLaporan = $currentYear;
}

// Format bulan menjadi dua digit jika bukan "Semua"
if ($bulanLaporan !== 'Semua') {
    $bulanLaporan = str_pad($bulanLaporan, 2, '0', STR_PAD_LEFT);
}

// Daftar nama bulan dalam bahasa Indonesia
$namaBulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
    'Semua' => 'Semua Periode',
];

// Mendapatkan input search
$searchQuery = isset($_POST['search']) ? trim($_POST['search']) : '';

// Menentukan apakah input adalah angka (jumlah) atau kode barang
$searchCondition = '';
if ($searchQuery !== '') {
    if (is_numeric($searchQuery)) {
        // Search berdasarkan jumlah
        $searchCondition = ' AND d.quantity = ' . intval($searchQuery);
    } else {
        // Search berdasarkan kode barang
        $searchCondition = " AND p.kode_barang LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
    }
}

// Menentukan kondisi untuk periode
$periodCondition = '';
if ($bulanLaporan !== 'Semua' && $tahunLaporan !== 'Semua') {
    $periodCondition = "WHERE MONTH(d.tanggal_in_out) = $bulanLaporan AND YEAR(d.tanggal_in_out) = $tahunLaporan";
} elseif ($bulanLaporan !== 'Semua' && $tahunLaporan === 'Semua') {
    $periodCondition = "WHERE MONTH(d.tanggal_in_out) = $bulanLaporan";
} elseif ($bulanLaporan === 'Semua' && $tahunLaporan !== 'Semua') {
    $periodCondition = "WHERE YEAR(d.tanggal_in_out) = $tahunLaporan";
}

// Query untuk menarik data laporan
$sqlLaporan = "SELECT 
                    d.id_detail_laporan,
                    d.tanggal_in_out,
                    dp.id_barang,
                    d.quantity,
                    d.status_in_out,
                    p.kode_barang
               FROM 
                    detail_laporan d
               JOIN 
                    detail_produk dp ON d.id_detprod = dp.id_detprod
               JOIN 
                    produk p ON dp.id_barang = p.id_barang
               $periodCondition
               $searchCondition
               ORDER BY d.tanggal_in_out ASC";

$resultLaporan = $conn->query($sqlLaporan);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Barang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* CSS untuk Navbar dan halaman */
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

        .btn {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .btn:hover {
            background: radial-gradient(circle, #ffff00, #E1AD15);
            color: #000;
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

        select,
        input {
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
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
                <li class="nav-item1"><a class="nav-link" href="loginPage.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container-transparent">
        <div class="center-content">
            <div class="text-behind">Laporan</div>
            <div class="text-behind">Stok</div>
            <div class="sphere"></div>
        </div>

        <div class="filter-section">
            <form method="POST" action="">
                <div class="input-group justify-content-center mb-5">
                    <!-- Dropdown Bulan -->
                    <select name="pilih_bulan" required>
                        <option value="Semua" <?= $bulanLaporan == 'Semua' ? 'selected' : '' ?>>Semua Bulan</option>
                        <?php
                        // Menampilkan semua bulan, meskipun tidak ada data transaksi
                        for ($i = 1; $i <= 12; $i++) {
                            $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                            $selected = $bulan == $bulanLaporan ? 'selected' : '';
                            $bulanLabel = $namaBulan[$bulan];
                            echo "<option value='$bulan' $selected>$bulanLabel</option>";
                        }
                        ?>
                    </select>

                    <!-- Dropdown Tahun -->
                    <select name="pilih_tahun" required>
                        <?php foreach ($years as $year): ?>
                        <option value="<?= $year ?>" <?= $year == $tahunLaporan ? 'selected' : '' ?>>
                            <?= $year ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3 text-center">
                    <input type="text" name="search" placeholder="Cari kode barang atau jumlah"
                        value="<?= htmlspecialchars($searchQuery) ?>">
                </div>


                <div class="text-center">
                    <button type="submit" class="submit-btn btn btn-primary">Tampilkan Laporan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <?php if ($resultLaporan->num_rows > 0): ?>
        <h3 class="text-white">Laporan Stok <?= $namaBulan[$bulanLaporan] . ' ' . $tahunLaporan ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultLaporan->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['kode_barang'] ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal_in_out'])) ?></td>
                    <td><?= abs($row['quantity']) ?></td>
                    <td><?= $row['status_in_out'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Tidak ada barang masuk/keluar untuk bulan <?= $namaBulan[$bulanLaporan] ?> <?= $tahunLaporan ?>.</p>
        <?php endif; ?>
    </div>
</body>

</html>
