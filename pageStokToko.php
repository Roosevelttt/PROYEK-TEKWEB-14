<?php
include 'koneksi.php';
include 'detailProduk.php';

$detailProduk = new DetailProduk($conn);

// Menangani pencarian kode barang
$search = isset($_POST['search']) ? $_POST['search'] : ''; // Ambil nilai pencarian

// Modifikasi query SQL untuk pencarian kode barang
$query = "SELECT dp.id_detprod, p.kode_barang, p.harga, u.ukuran, dp.stok_toko 
          FROM detail_produk dp
          JOIN produk p ON dp.id_barang = p.id_barang
          JOIN ukuran u ON dp.id_ukuran = u.id_ukuran
          WHERE dp.status_aktif = 1 AND p.status_aktif = 1 AND u.status_aktif = 1";

// Jika ada pencarian, filter berdasarkan kode barang
if (!empty($search)) {
    $query .= " AND p.kode_barang LIKE '%$search%'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
        html, body {
          height: 100%;
          margin: 0;
          display: flex;
          flex-direction: column;
          background-image: url('assets/background.jpeg');
          background-size: cover;
          background-position:center;
          height:full;
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
          padding:3vh;
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
          z-index:1;
          transform: translateY(-25%);
        }
        .sphere-small {
          width: 16px;
          height: 16px;
          border-radius: 50%;
          background: radial-gradient(circle, #ffff00, #E1AD15);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
          z-index:1;
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
            filter: invert(100%); /* Change to white */
        }
        .container-glass {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
            padding: 20px;
            display: flex;
            flex-direction: column;
            margin: 20px auto;
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

        .btn-delete:hover {
            background: radial-gradient(circle, #C30025, #820018);
            color:#f4f4f4;
        }

        .translate-y-10 {
            transform: translateY(-10%);
        }

        table {
            background-color:transparent;
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td{
            padding: 10px;
            text-align: left;
        }

        table td {
            color: #A1A9B7 !important;
        }

        table th {
            cursor: pointer;
            color: #EFF0F3 !important;
        }

        table tr:hover {
            background: #252527;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
            color: #D0D4DB;
            font-weight: bolder;
        }
        th, td, tr {
            border: transparent !important;
        }

        .form-label{
            color: #f8f9fa !important;
            margin-left: 0.5vw;
        }

        h4 {
            font-weight:bold;
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
<div class="container">
<div class="center-content">
        <div class="text-behind">Manajemen</div>
        <div class="text-behind">Stok Toko</div>
        <div class="sphere"></div>
    </div>

    <!-- Form Pencarian -->
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan kode barang" value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <!-- Notifikasi -->
    <?php if (isset($_GET['alert'])) : ?>
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: '<?= $_GET['alert'] ?>'
            });
        </script>
    <?php endif; ?>

    <div class="container-glass">
    <!-- Tabel Stok Barang -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Kode Barang</th>
            <th>Ukuran</th>
            <th>Harga</th>
            <th>Stok Toko</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id_detprod'] ?></td>
                    <td><?= $row['kode_barang'] ?></td>
                    <td><?= $row['ukuran'] ?></td>
                    <td><?= $row['harga'] ?></td>
                    <td><?= $row['stok_toko'] ?></td>
                    <td>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addStockModal"
                                data-id-detprod="<?= $row['id_detprod'] ?>">Tambah Stok</button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#subtractStockModal"
                                data-id-detprod="<?= $row['id_detprod'] ?>">Kurangi Stok</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center">Tidak ada data stok barang.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Stok -->
<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_stokToko.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="id_detprod_add" name="id_detprod">
                    <div class="mb-3">
                        <label style="color: black !important" for="jumlah_add" class="form-label">Jumlah Stok</label>
                        <input type="number" class="form-control" id="jumlah_add" name="jumlah" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="color: black" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button style="color: black" type="submit" name="action" value="add" class="btn btn-primary">Tambah Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Kurangi Stok -->
<div class="modal fade" id="subtractStockModal" tabindex="-1" aria-labelledby="subtractStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kurangi Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_stokToko.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="id_detprod_sub" name="id_detprod">
                    <div class="mb-3">
                    <label for="jumlah_sub" class="form-label" style="color: black !important;">Jumlah Stok</label>
                    <input type="number" class="form-control" id="jumlah_sub" name="jumlah" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="color: black" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button style="color: black" type="submit" name="action" value="subtract" class="btn btn-danger">Kurangi Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('[data-bs-target="#addStockModal"]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('id_detprod_add').value = button.getAttribute('data-id-detprod');
        });
    });
    document.querySelectorAll('[data-bs-target="#subtractStockModal"]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('id_detprod_sub').value = button.getAttribute('data-id-detprod');
        });
    });
</script>
</body>
</html>