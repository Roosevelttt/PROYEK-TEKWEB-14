<?php
include 'koneksi.php';
session_set_cookie_params(0);

session_start();  // Start the session

// Check if the session variable 'role' exists and if it's one of the allowed roles
if (!isset($_SESSION['jabatan']) || $_SESSION['jabatan'] !== 'pemilik') {
    // Redirect to login page if not logged in as pemilik
    header("Location: loginPage.php");
    exit();
}

// Fungsi untuk menambah produk baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Ambil data dari form
    $kode_barang = $_POST['kode_barang'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $id_ukuran = $_POST['id_ukuran'];

    // Validasi input
    if ($harga < 1000) {
        $error = true;
        $error_message = "Harga harus lebih dari 1000.";
    } elseif ($harga % 100 !== 0) {
        $error = true;
        $error_message = "Harga harus dalam kelipatan 100.";
    } elseif ($jumlah <= 0) {
        $error = true;
        $error_message = "Jumlah harus lebih besar dari 0.";
    } else {
        // Periksa apakah kode barang sudah ada
        $sqlCheckKode = "SELECT * FROM produk WHERE kode_barang = ?";
        $stmt = $conn->prepare($sqlCheckKode);
        $stmt->bind_param("s", $kode_barang);
        $stmt->execute();
        $resultCheckKode = $stmt->get_result();

        if ($resultCheckKode->num_rows > 0) {
            $error = true;
            $error_message = "Kode barang sudah terdaftar. Silakan gunakan kode barang lain.";
        } else {
            // Tambah produk baru
            $sqlInsertProduk = "INSERT INTO produk (kode_barang, harga) VALUES (?, ?)";
            $stmt = $conn->prepare($sqlInsertProduk);
            $stmt->bind_param("si", $kode_barang, $harga);

            if ($stmt->execute()) {
                $id_barang = $stmt->insert_id; // ID produk baru

                // Tambah stok ke detail_produk
                $sqlInsertDetail = "INSERT INTO detail_produk (id_barang, stok_gudang, id_ukuran) VALUES (?, ?, ?)";
                $stmtDetail = $conn->prepare($sqlInsertDetail);
                $stmtDetail->bind_param("iii", $id_barang, $jumlah, $id_ukuran);

                if ($stmtDetail->execute()) {
                    // Tambah data ke detail_laporan
                    $id_detprod = $conn->insert_id; // ID detail produk baru
                    $tanggal = date('Y-m-d');
                    $status_in_out = "In";

                    $sqlInsertLaporan = "INSERT INTO detail_laporan (id_detprod, quantity, tanggal_in_out, status_in_out) VALUES (?, ?, ?, ?)";
                    $stmtLaporan = $conn->prepare($sqlInsertLaporan);
                    $stmtLaporan->bind_param("iiss", $id_detprod, $jumlah, $tanggal, $status_in_out);

                    if ($stmtLaporan->execute()) {
                        $success = true;
                    } else {
                        $error = true;
                        $error_message = "Gagal menambahkan data ke laporan.";
                    }
                } else {
                    $error = true;
                    $error_message = "Gagal menambahkan detail produk.";
                }
            } else {
                $error = true;
                $error_message = "Gagal menambahkan produk.";
            }
        }
    }
}

// Proses Hapus Produk
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id_barang = (int)$_GET['id_barang'];

    // Hapus dari detail_produk
    $sqlDeleteDetail = "DELETE FROM detail_produk WHERE id_barang = $id_barang";
    $conn->query($sqlDeleteDetail);

    // Hapus dari produk
    $sqlDeleteProduk = "DELETE FROM produk WHERE id_barang = $id_barang";
    if ($conn->query($sqlDeleteProduk) === TRUE) {
        $successDelete = true;
    } else {
        $errorDelete = true;
        $error_message = "Gagal menghapus produk.";
    }
}

// Proses Update Produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_barang = (int)$_POST['id_barang'];
    $harga = (int)$_POST['harga'];
    $stok_gudang = (int)$_POST['stok_gudang'];
    $id_ukuran = (int)$_POST['id_ukuran'];

    if ($harga < 1000) {
        $errorEdit = true;
        $error_message = "Harga harus lebih dari 1000.";
    } elseif ($harga % 100 !== 0) {
        $errorEdit = true;
        $error_message = "Harga harus dalam kelipatan 100 (contoh: 1200, 1500).";
    } elseif ($stok_gudang <= 0) {
        $errorEdit = true;
        $error_message = "Jumlah harus lebih besar dari 0.";
    } else {
        // Update produk
        $sqlUpdateProduk = "UPDATE produk SET harga = '$harga' WHERE id_barang = $id_barang";
        if ($conn->query($sqlUpdateProduk) === TRUE) {
            // Update detail_produk
            $sqlUpdateDetail = "UPDATE detail_produk SET stok_gudang = '$stok_gudang', id_ukuran = '$id_ukuran' WHERE id_barang = $id_barang";
            if ($conn->query($sqlUpdateDetail) === TRUE) {
                // Update detail_laporan
                $tanggal = date('Y-m-d'); // Tanggal saat ini
                $status_in_out = "In"; // Status untuk pembaruan
                $sqlUpdateLaporan = "UPDATE detail_laporan 
                                     SET quantity = '$stok_gudang', tanggal_in_out = '$tanggal', status_in_out = '$status_in_out' 
                                     WHERE id_detprod = $id_barang";
                if ($conn->query($sqlUpdateLaporan) === TRUE) {
                    $successEdit = true;
                } else {
                    $errorEdit = true;
                    $error_message = "Gagal mengupdate detail laporan.";
                }
            } else {
                $errorEdit = true;
                $error_message = "Gagal mengupdate detail produk.";
            }
        } else {
            $errorEdit = true;
            $error_message = "Gagal mengupdate produk.";
        }
    }
}

// Ambil ukuran untuk pilihan edit
$sqlUkuran = "SELECT * FROM ukuran";
$resultUkuran = $conn->query($sqlUkuran);

// Search
$searchTerm = '';
$whereClause = '';
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $searchTerm = $conn->real_escape_string($_GET['search']);
    // Pencarian pada kode_barang, ukuran, stok_gudang, dan harga
    $whereClause = "WHERE p.kode_barang LIKE '%$searchTerm%'
                    OR u.ukuran LIKE '%$searchTerm%'
                    OR dp.stok_gudang LIKE '%$searchTerm%'
                    OR p.harga LIKE '%$searchTerm%'";
}

// Query untuk menampilkan daftar produk
$sqlProduk = "SELECT
                p.id_barang,
                p.kode_barang,
                p.harga,
                dp.stok_gudang,
                u.id_ukuran,
                u.ukuran
            FROM 
                produk p
            JOIN 
                detail_produk dp ON p.id_barang = dp.id_barang
            JOIN 
                ukuran u ON dp.id_ukuran = u.id_ukuran
            $whereClause
            ORDER BY 
                p.kode_barang ASC";

$resultProduk = $conn->query($sqlProduk);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.9/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.9/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0 ;
            padding: 0 ;
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
            align-items: center; /* Memusatkan secara horizontal */
            justify-content: center; /* Memusatkan secara vertikal */
            text-align: center; /* Menyelaraskan teks ke tengah */
            margin: 20px auto;
        }

        .container-transparent {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Memusatkan secara horizontal */
            justify-content: center; /* Memusatkan secara vertikal */
            text-align: center; /* Menyelaraskan teks ke tengah */
            margin: 20px auto;
        }

        h1 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color:#f4f4f4;
        }
        table th, table td{
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            cursor: pointer;
        }
        table th:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: radial-gradient(circle, #ffff00, #E1AD15);;
        }
        .modal {
        display: none; /* Sembunyikan modal secara default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); /* Latar belakang semi-transparan */
        justify-content: center;
        align-items: center;
        transition: opacity 0.3s ease; /* Transisi halus */
        z-index: 1000; /* Pastikan modal di atas elemen lain */
    }
    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px; /* Maksimal lebar modal */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Bayangan untuk efek kedalaman */
    }
    .modal-content h3 {
        margin-bottom: 15px; /* Jarak antara judul dan konten */
    }
    .modal-content input, .modal-content select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px; /* Jarak antara input */
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box; /* Pastikan padding tidak menambah lebar */
    }
    .modal-buttons {
        display: flex;
        justify-content: space-between; /* Jarak antara tombol */
    }
    .modal-buttons .btn {
        flex: 1; /* Tombol mengambil ruang yang sama */
        margin: 0 5px; /* Jarak antar tombol */
        transform: translateY(0);
    }
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
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand"href="index.php">  <div class="sphere-small ms-3 me-2"></div> <div class="title">Hartono Collections</div></a>
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
        <div class="text-behind">Daftar</div>
        <div class="text-behind">Produk</div>
        <div class="sphere"></div>
    </div>

    
<!-- Search Form -->
<div class="search-container text-center">
    <form id="form-search" method="GET" action="">
        <input type="text" name="search" placeholder="Cari kode, ukuran, stok, harga" value="<?= isset($searchTerm) ? htmlspecialchars($searchTerm) : '' ?>">
        <button type="submit" class="btn submit-btn">Search</button>
    </form>
</div>
    
    <!-- Tombol untuk menambah produk -->
    <button class="btn" id="addProductBtn">Tambah Produk</button>
</div>

    <div class="container">
    <!-- Daftar Produk -->
    <?php if ($resultProduk->num_rows > 0): ?>
        <table id="productTable">
    <thead>
        <tr>
            <th id="sortKodeBarang">Kode Barang</th>
            <th id="sortUkuran">Ukuran</th>
            <th id="sortStok">Stok Gudang</th>
            <th id="sortHarga">Harga</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultProduk->fetch_assoc()): ?>
            <tr>
                <td><?= $row['kode_barang'] ?></td>
                <td><?= $row['ukuran'] ?></td>
                <td><?= $row['stok_gudang'] ?></td>
                <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>
                    <button class="btn btn-warning btn-sm btn-edit" onclick="openEditModal(<?= $row['id_barang'] ?>, <?= $row['harga'] ?>, <?= $row['stok_gudang'] ?>, <?= $row['id_ukuran'] ?>)">Edit</button>
                    <a href="?action=delete&id_barang=<?= $row['id_barang'] ?>" class="btn btn-danger btn-sm btn-delete" id="delete-btn-<?= $row['id_barang'] ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    <?php else: ?>
        <p class="no-item">Tidak ada produk yang tersedia.</p>
    <?php endif; ?>
</div>

<!-- Modal untuk Menambahkan Produk -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <h3>Tambah Produk Baru</h3>
        <form method="POST" action="">
            <label for="kode_barang">Kode Barang:</label>
            <input type="text" id="kode_barang" name="kode_barang" required>
            
            <label for="harga">Harga (min 1000):</label>
            <input type="number" id="harga" name="harga" required>
            
            <label for="jumlah">Stok Gudang:</label>
            <input type="number" id="jumlah" name="jumlah" required>
            
            <label for="id_ukuran">Ukuran:</label>
            <select name="id_ukuran" id="id_ukuran" required>
                <?php while ($row = $resultUkuran->fetch_assoc()): ?>
                    <option value="<?= $row['id_ukuran'] ?>"><?= $row['ukuran'] ?></option>
                <?php endwhile; ?>
            </select>
            
            <div class="modal-buttons">
                <button type="submit" name="submit" class="btn">Simpan Produk</button>
                <button type="button" class="btn" id="closeModalBtn">Tutup</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <h3>Edit Produk</h3>
        <form method="POST" action="">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id_barang" id="edit_id_barang">
            <label>Harga:</label>
            <input type="number" name="harga" id="edit_harga" required>
            <label>Stok Gudang:</label>
            <input type="number" name="stok_gudang" id="edit_stok_gudang" required min="0">
            <label>Ukuran:</label>
            <select name="id_ukuran" id="edit_id_ukuran" required>
                <?php 
                $resultUkuran->data_seek(0); // Reset pointer ukuran
                while ($u = $resultUkuran->fetch_assoc()): ?>
                    <option value="<?= $u['id_ukuran'] ?>"><?= $u['ukuran'] ?></option>
                <?php endwhile; ?>
            </select>
            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Menangani tombol "Tambah Produk"
    document.getElementById('addProductBtn').addEventListener('click', function() {
        document.getElementById('productModal').style.display = 'flex';
    });

    // Menangani tombol "Tutup" untuk modal
    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('productModal').style.display = 'none';
    });

    // Mengatur flag untuk arah sorting
    let sortAsc = {
        id_barang: true,
        kode_barang: true,
        harga: true,
        stok: true,
        ukuran: true
    };

    // Definisikan urutan untuk ukuran (Small, Medium, Large)
    const ukuranOrder = ['S', 'M', 'L'];

    // Mengambil elemen header yang bisa disortir
    const headers = document.querySelectorAll('table th');

    headers.forEach(header => {
        header.addEventListener('click', function() {
            const columnIndex = Array.from(header.parentNode.children).indexOf(header);
            const columnName = header.id.replace('sort', '').toLowerCase();
            sortTable(columnIndex, columnName);
        });
    });

    // Fungsi untuk sorting tabel
    function sortTable(columnIndex, columnName) {
        const table = document.getElementById('productTable');
        const rows = Array.from(table.rows).slice(1); // Mengambil semua baris kecuali header

        // Menentukan apakah urutan akan menaik atau menurun
        const isAscending = sortAsc[columnName];

        // Sorting berdasarkan kolom yang diklik
        rows.sort((rowA, rowB) => {
            const cellA = rowA.cells[columnIndex].textContent.trim();
            const cellB = rowB.cells[columnIndex].textContent.trim();

            // Parsing harga, ukuran, dan ID Barang untuk sorting yang benar
            let valueA, valueB;
            if (columnName === 'harga') {
                valueA = parseFloat(cellA.replace(/[^0-9.-]+/g, "")); // Hapus simbol mata uang dan parse float
                valueB = parseFloat(cellB.replace(/[^0-9.-]+/g, ""));
            } else if (columnName === 'ukuran') {
                valueA = ukuranOrder.indexOf(cellA); // Menyusun berdasarkan urutan ukuran
                valueB = ukuranOrder.indexOf(cellB);
            } else if (columnName === 'id_barang') {
                valueA = parseInt(cellA); // ID Barang disortir secara numerik
                valueB = parseInt(cellB);
            } else {
                valueA = cellA;
                valueB = cellB;
            }

            if (isAscending) {
                return valueA > valueB ? 1 : valueA < valueB ? -1 : 0;
            } else {
                return valueA < valueB ? 1 : valueA > valueB ? -1 : 0;
            }
        });

        // Menyusun ulang baris tabel
        rows.forEach(row => table.appendChild(row));

        // Toggle arah sorting
        sortAsc[columnName] = !isAscending;
    }

    // SweetAlert untuk success atau error setelah simpan produk
    <?php if (isset($success) && $success === true): ?>
        Swal.fire({
            icon: 'success',
            title: 'Produk Berhasil Ditambahkan',
            text: 'Produk baru berhasil disimpan ke dalam database.',
        });
    <?php elseif (isset($error) && $error === true): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= isset($error_message) ? $error_message : "Terjadi kesalahan." ?>',
        });
    <?php endif; ?>

    <?php if (isset($successDelete) && $successDelete === true): ?>
        Swal.fire({
            icon: 'success',
            title: 'Produk Berhasil Dihapus',
        });
    <?php elseif (isset($errorDelete) && $errorDelete === true): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= isset($error_message) ? $error_message : "Terjadi kesalahan." ?>',
        });
    <?php endif; ?>

    <?php if (isset($successEdit) && $successEdit === true): ?>
        Swal.fire({
            icon: 'success',
            title: 'Produk Berhasil Diupdate',
        });
    <?php elseif (isset($errorEdit) && $errorEdit === true): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= isset($error_message) ? $error_message : "Terjadi kesalahan." ?>',
        });
    <?php endif; ?>

    document.querySelector('form').onsubmit = function(e) {
        let harga = document.getElementById('harga').value;
        if (harga < 1000) {
            e.preventDefault(); // Mencegah form dikirim
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harga harus lebih dari 1000!',
            });
        }
        if (harga % 100 !== 0) {
            e.preventDefault(); // Mencegah form dikirim
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harga harus dalam ribu rupiah! (misal: 1250 (x), 1200 (v))',
            });
        }
    };

    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah default action (navigasi)

            const deleteUrl = this.href; // Ambil URL dari atribut href
            const id_barang = this.id.split('-')[2]; // Ambil ID barang dari tombol yang diklik

            // Gunakan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Yakin ingin menghapus produk ini?',
                text: 'Data yang sudah dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user mengonfirmasi, lanjutkan ke URL untuk menghapus
                    window.location.href = deleteUrl;
            }
            });
        });
    });

function openEditModal(id_barang, harga, stok_gudang, id_ukuran) {
    document.getElementById('edit_id_barang').value = id_barang;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_stok_gudang').value = stok_gudang;
    document.getElementById('edit_id_ukuran').value = id_ukuran;

    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
document.getElementById('form-search').onsubmit = function(e) {
};
</script>
</body>
</html>