<?php
session_set_cookie_params(0);
session_start();  // Mulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_karyawan'])) {
    header('Location: loginPage.php');
    exit();
}

include 'koneksi.php';

$alert = ''; // Variabel untuk menyimpan notifikasi

// Ambil informasi pengguna dari sesi
$id_karyawan_session = $_SESSION['id_karyawan'];
$jabatan = $_SESSION['jabatan'];
$nama_session = $_SESSION['nama'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($jabatan === 'pemilik') {
        // Jika pemilik, ambil id_karyawan dari form
        if (isset($_POST['id_karyawan']) && !empty($_POST['id_karyawan'])) {
            $id_karyawan = intval($_POST['id_karyawan']);
        } else {
            // Handle error: id_karyawan tidak diberikan
            $alert = "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const notyf = new Notyf();
                        notyf.error('ID Karyawan diperlukan.');
                    });
                </script>
            ";
            exit();
        }
    } else {
        // Jika bukan pemilik, gunakan id_karyawan dari sesi
        $id_karyawan = $id_karyawan_session;
    }

    $current_time = date('H:i'); // Waktu sekarang (jam:menit)

    if ($current_time > '07:30') {
        // Tidak mencatat absensi, hanya memberikan notifikasi keterlambatan
        $alert = "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const notyf = new Notyf();
                    notyf.error('Terlambat! Hubungi pemilik untuk klarifikasi.');
                });
            </script>
        ";
    } else {
        // Cek duplikasi absensi
        $stmt_check = $conn->prepare("SELECT COUNT(*) FROM absensi WHERE id_karyawan = ? AND DATE(jam) = CURDATE()");
        $stmt_check->bind_param("i", $id_karyawan);
        $stmt_check->execute();
        $stmt_check->bind_result($count_absensi);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count_absensi > 0) {
            // Sudah melakukan absensi hari ini
            $alert = "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const notyf = new Notyf();
                        notyf.error('Anda sudah mencatat absensi hari ini.');
                    });
                </script>
            ";
        } else {
            // Insert absensi
            $status = 1; // Status hadir
            $stmt_insert = $conn->prepare("INSERT INTO absensi (id_karyawan, jam, status) VALUES (?, NOW(), ?)");
            $stmt_insert->bind_param("ii", $id_karyawan, $status);

            if ($stmt_insert->execute()) {
                $alert = "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const notyf = new Notyf();
                            notyf.success('Absensi berhasil dicatat!');
                        });
                    </script>
                ";
            } else {
                // Log error ke file log
                error_log("Error mencatat absensi: " . $stmt_insert->error);
                $alert = "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const notyf = new Notyf();
                            notyf.error('Gagal mencatat absensi. Silakan coba lagi.');
                        });
                    </script>
                ";
            }
            $stmt_insert->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content tetap sama -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet"> <!-- Notyf CSS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script> <!-- Notyf JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


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

        table {
            background-color:transparent;
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color:rgb(249, 249, 249);
        }
        table th, table td{
            padding: 10px;
            text-align: left;
            color: whitesmoke !important;
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
            align-items: center; /* Memusatkan secara horizontal */
            justify-content: center; /* Memusatkan secara vertikal */
            text-align: center; /* Menyelaraskan teks ke tengah */
            max-width: 1200px;
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
        .translate-y-10 {
            transform: translateY(-10%);
        }

        .container h2 {
            font-weight:bold;
            color:#f8f9fa;
        }

        th {
            color:#f8f9fa !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <div class="sphere-small ms-3 me-2"></div>
            <div class="title">Hartono Collections</div>
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

    <div class="container">
        <div class="container-glass">
            <div class="center-content">
                <div class="text-behind">Absensi</div>
                <div class="text-behind">Karyawan</div>
                <div class="sphere"></div>
            </div>
            <form method="POST" action="" class="translate-y-10">
                <div class="mb-5">
                    <label for="id_karyawan" class="form-label text-white my-1">Nama Karyawan</label>
                    <?php if ($jabatan === 'pemilik'): ?>
                        <select class="form-select my-1" id="id_karyawan" name="id_karyawan" required>
                            <option value="" disabled selected>Pilih Nama Karyawan</option>
                            <?php
                            // Query untuk mendapatkan daftar karyawan
                            $stmt = $conn->prepare("SELECT id_karyawan, nama FROM karyawan ORDER BY nama ASC");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['id_karyawan']) . "'>" . htmlspecialchars($row['nama']) . "</option>";
                            }
                            $stmt->close();
                            ?>
                        </select>
                    <?php else: ?>
                        <!-- Jika bukan pemilik, tampilkan nama karyawan dan set id_karyawan secara tersembunyi -->
                        <input type="hidden" name="id_karyawan" value="<?php echo htmlspecialchars($id_karyawan_session); ?>">
                        <input type="text" class="form-control my-1" value="<?php echo htmlspecialchars($nama_session); ?>" readonly>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn my-1">Catat Absensi</button>
            </form>
        </div>
    </div>


    <div class="container-glass">
        <div class="container mt-5">
            <h2>Daftar Absensi Hari Ini</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jam Absensi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk menampilkan absensi hari ini
                    $today = date('Y-m-d');
                    if ($jabatan === 'pemilik') {
                        $stmt = $conn->prepare("SELECT k.nama, a.jam, a.status 
                                                FROM absensi a 
                                                JOIN karyawan k ON a.id_karyawan = k.id_karyawan 
                                                WHERE DATE(a.jam) = ?");
                        $stmt->bind_param("s", $today);
                    } else {
                        $stmt = $conn->prepare("SELECT k.nama, a.jam, a.status 
                                                FROM absensi a 
                                                JOIN karyawan k ON a.id_karyawan = k.id_karyawan 
                                                WHERE DATE(a.jam) = ? AND a.id_karyawan = ?");
                        $stmt->bind_param("si", $today, $id_karyawan_session);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $nama = htmlspecialchars($row['nama']);
                        $jam = htmlspecialchars($row['jam']);
                        $status_text = ($row['status'] == 1) ? 'Hadir' : 'Terlambat';
                        echo "<tr>
                            <td>{$nama}</td>
                            <td>{$jam}</td>
                            <td>{$status_text}</td>
                        </tr>";
                    }

                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tampilkan Notifikasi -->
    <?php echo $alert; ?>
</body>
</html>
