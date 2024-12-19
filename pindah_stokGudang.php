<?php
// Menghubungkan koneksi database yang sudah ada
include('koneksi.php');

// Fungsi untuk mencari produk berdasarkan kode barang
function cariProduk($kode_barang) {
    global $conn;

    // Query untuk mengambil produk berdasarkan kode_barang
    $query = "SELECT p.id_barang, p.kode_barang, u.ukuran, p.harga, dp.id_detprod 
              FROM produk p
              JOIN detail_produk dp ON p.id_barang = dp.id_barang
              JOIN ukuran u ON dp.id_ukuran = u.id_ukuran
              WHERE p.kode_barang = ? AND dp.status_aktif = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kode_barang);
    $stmt->execute();
    $result = $stmt->get_result();

    $produk = [];
    while ($row = $result->fetch_assoc()) {
        $produk[] = $row; // Menyimpan produk yang ditemukan dalam array
    }
    $stmt->close();
    return $produk;
}

// Fungsi untuk mengecek ketersediaan stok gudang berdasarkan id_detprod
function cekStokGudang($id_detprod) {
    global $conn;
    $query = "SELECT stok_gudang FROM detail_produk WHERE id_detprod = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_detprod);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['stok_gudang'];
    } else {
        return 0; // Tidak ditemukan
    }
}

// Fungsi untuk memindahkan stok dari gudang ke toko
// Fungsi untuk memindahkan stok dari gudang ke toko
function pindah_stokGudang($id_detprod, $jumlah) {
    global $conn;

    // Cek stok gudang sebelum dipindahkan
    $stok_gudang = cekStokGudang($id_detprod);
    if ($stok_gudang >= $jumlah) {
        // Kurangi stok dari gudang
        $query_update_gudang = "UPDATE detail_produk SET stok_gudang = stok_gudang - ? WHERE id_detprod = ?";
        $stmt = $conn->prepare($query_update_gudang);
        $stmt->bind_param("ii", $jumlah, $id_detprod);
        $stmt->execute();
        $stmt->close();

        // Tambahkan stok ke toko
        $query_update_toko = "UPDATE detail_produk SET stok_toko = stok_toko + ? WHERE id_detprod = ?";
        $stmt = $conn->prepare($query_update_toko);
        $stmt->bind_param("ii", $jumlah, $id_detprod);
        $stmt->execute();
        $stmt->close();

        // Simpan transaksi ke laporanTransaksi
        $status_in_out = 'Out';  // Karena stok dipindahkan dari gudang (out)
        $tanggal_in_out = date('Y-m-d H:i:s');  // Waktu saat transaksi dilakukan

        // Query untuk menyimpan transaksi
        $query_laporan = "INSERT INTO detail_laporan (id_detprod, quantity, status_in_out, tanggal_in_out) 
                          VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query_laporan);
        $stmt->bind_param("iiss", $id_detprod, $jumlah, $status_in_out, $tanggal_in_out);
        $stmt->execute();
        $stmt->close();

        return true; // Stok berhasil dipindahkan dan laporan dibuat
    } else {
        return false; // Stok gudang tidak cukup
    }
}


// Proses jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_detprod']) && isset($_POST['jumlah'])) {
        $id_detprod = $_POST['id_detprod']; // Mendapatkan id_detprod yang dipilih
        $jumlah = $_POST['jumlah'];

        // Pindahkan stok
        $berhasil = pindah_stokGudang($id_detprod, $jumlah);

        // Menampilkan notifikasi
        if ($berhasil) {
            echo "<div class='notification success'>Stok telah berhasil dipindahkan ke toko.</div>";
        } else {
            echo "<div class='notification error'>Stok gudang tidak cukup untuk dipindahkan.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memindah Stok Barang ke Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0 ;
            padding: 0 ;
        }
        label {
            color:#f4f4f4 !important;
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

        .btn {
            margin-top: 20px; /* Memberikan jarak antara tombol dan elemen sebelumnya */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color:#f4f4f4;
        }
        table th, table td {
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
            transform: translateY(-5vh);
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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #007bff; /* Warna Biru */
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Warna Biru Tua saat hover */
        }

        .notification {
            padding: 15px;
            margin-top: 20px;
            text-align: center;
            border-radius: 6px;
            font-size: 16px;
        }

        .notification.success {
            background-color: #4CAF50;
            color: #fff;
        }

        .notification.error {
            background-color: #f44336;
            color: #fff;
        }

        select {
            font-size: 16px;
        }

        .form-group input[type="number"] {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand"href="dashboard.php">  <div class="sphere-small ms-3 me-2"></div> <div class="title">Hartono Collections</div></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="fas fa-home"></i></a></li>
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
        <div class="text-behind">Pindah Stok</div>
        <div class="text-behind">Harga</div>
        <div class="sphere"></div>
    </div>
        <!-- Form untuk memasukkan kode barang -->
        <form method="POST" action="pindah_stokGudang.php">
            <div class="form-group">
                <label for="kode_barang">Kode Barang:</label>
                <input type="text" id="kode_barang" name="kode_barang" value="<?php echo isset($_POST['kode_barang']) ? htmlspecialchars($_POST['kode_barang']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Cari Produk">
            </div>
        </form>
    </div>
    <div class="container">

        <?php
        // Cek apakah kode_barang telah di-submit
        if (isset($_POST['kode_barang'])) {
            $kode_barang = $_POST['kode_barang'];

            // Cari produk berdasarkan kode_barang
            $produk_list = cariProduk($kode_barang);

            if (count($produk_list) > 0) {
                echo '<form method="POST" action="pindah_stokGudang.php">';
                echo '<div class="form-group">';
                echo '<label for="id_detprod">Pilih Produk:</label>';
                echo '<select name="id_detprod" required>';
                foreach ($produk_list as $produk) {
                    echo '<option value="' . $produk['id_detprod'] . '">' . $produk['kode_barang'] . ' - ' . $produk['ukuran'] . ' - Rp ' . number_format($produk['harga'], 0, ',', '.') . '</option>';
                }
                echo '</select>';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label for="jumlah">Jumlah Stok yang Dipindahkan:</label>';
                echo '<input type="number" id="jumlah" name="jumlah" value="' . (isset($_POST['jumlah']) ? $_POST['jumlah'] : '') . '" required>';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<input type="submit" value="Confirm">';
                echo '</div>';
                echo '</form>';
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Kode barang tidak ditemukan.'
                    });
                </script>";
            }
        }
        ?>
    </div>
</body>
</html>