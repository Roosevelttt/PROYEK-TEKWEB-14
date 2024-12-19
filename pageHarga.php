<?php
session_set_cookie_params(0);

session_start();  // Start the session

// Check if the session variable 'role' exists and if it's one of the allowed roles
if (!isset($_SESSION['jabatan']) || $_SESSION['jabatan'] !== 'pemilik') {
    // Redirect to login page if not logged in as pemilik
    header("Location: loginPage.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Harga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <style>
      /* Pastikan navbar dan container-fluid mengambil lebar penuh */
/* Pastikan navbar dan container-fluid mengambil lebar penuh */
/* Navbar */
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

        label{
            color: #f4f4f4 !important;
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

        footer {
          background-color: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
          color: white;
          z-index: 2;
          height:15vh;
          padding: 2vh;
          font-weight: 200;
          font-size: smaller;
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
          margin-top: 10vh;
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
    <a class="navbar-brand"href="dashboard.php">  <div class="sphere-small ms-3 me-2"></div> <div class="title">Hartono Collections</div></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="menambahProdukBaru.php"><i class="fas fa-box"></i> Produk</a></li>
                <li class="nav-item"><a class="nav-link" href="pageHarga.php"><i class="fas fa-tags"></i> Harga </a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-store-alt"></i> Stok</a>
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
                <li class="nav-item"><a class="nav-link" href="halamanTransaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-users"></i> Karyawan</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="absensi.php">Absensi</a></li>
                        <li><a class="dropdown-item" href="perhitunganGaji.php">Perhitungan Gaji</a></li>
                        <li><a class="dropdown-item" href="MelihatAbsensiPage.php">List Absensi</a></li>
                        <li><a class="dropdown-item" href="pageKaryawan.php">Manajemen Karyawan</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-file-alt"></i> Laporan</a>
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
  <!-- Search Bar -->
    <div class="center-content">
        <div class="text-behind">Edit</div>
        <div class="text-behind">Harga</div>
        <div class="sphere"></div>
    </div>
    <div class="container text-center mt-5">
    <div class="input-group">
        <input type="search" id="findKode" class="form-control w-" placeholder="Search">
        <button type="button" id="btnSearch" class="btn btn-primary" data-mdb-ripple-init>
          <i class="fas fa-search"></i>
        </button>
        </div>
    </div>


<!-- Price Form -->
<div class="container mt-3">
    <div class="col-12 col-md-6 mx-auto">
        <form id="price-form">
            <div class="row mb-3 align-items-center">
                <label for="inputKode" class="col-sm-3 col-form-label">Kode</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputKode" disabled>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <label for="inputStok" class="col-sm-3 col-form-label">Stok</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputStok" disabled>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <label for="inputHarga" class="col-sm-3 col-form-label">Harga</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputHarga" disabled>
                </div>
            </div>
            
            <!-- Menambahkan Flexbox untuk tombol agar berada di tengah -->
            <div class="d-flex justify-content-center">
                <button type="submit" id="btnEditHarga" class="btn btn-primary">Edit Harga</button>
            </div>
        </form>
    </div>
</div>

  
  <script>
    $(document).ready(function () {

      // SEARCH KODE
      $("#btnSearch").on("click", function () {
          const inputKode = $("#findKode").val();

          if (inputKode !== '') {
              $.ajax({
                  url: "searchKode.php", // File pencarian
                  method: "GET",
                  data: { inputKode: inputKode },
                  success: function (response) {
                      const data = JSON.parse(response);

                      // Jika data tidak ditemukan, tampilkan pesan error
                      if (data.error) {
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Kode barang tidak ditemukan',
                        }).then((result) => {
                            // Setelah tombol "OK" diklik, kosongkan field
                            if (result.isConfirmed) {
                                $("#findKode").val("");
                            }
                          });
                      } 
                      // Jika data ditemukan, isi dengan data dari database
                      else {
                          $("#inputKode").val(data.kode_barang).prop("disabled", true); // Disable input kode
                          $("#inputStok").val(data.stok_toko).prop("disabled", true); // Disable input stok
                          $("#inputHarga").val(data.harga); // Isi harga

                          // Jika stok toko tidak ada, harga tidak bisa diedit
                          if (data.stok_toko == 0) {
                            $("#inputHarga").prop("disabled", true);
                            $("#btnEditHarga").prop("disabled", true);
                            // Tampilkan alert
                            setTimeout(function () {
                              Swal.fire({
                                icon: 'error',
                                title: 'Stok Barang Tidak Tersedia',
                                text: 'Harga tidak dapat diedit',
                              }).then((result) => {
                                  // Setelah tombol "OK" diklik, kosongkan field
                                  if (result.isConfirmed) {
                                      $("#findKode").val("");
                                      $("#inputKode").val("").prop("disabled", true);
                                      $("#inputStok").val("").prop("disabled", true);
                                      $("#inputHarga").val("").prop("disabled", true);
                                  }
                              });
                            }, 100); // Tunggu 100ms untuk memastikan data terlihat
                          } 
                          // Jika stok toko ada, maka harga bisa diedit
                          else {
                            $("#inputHarga").prop("disabled", false);
                            $("#btnEditHarga").prop("disabled", false);
                          }
                        }
                  },
                  error: function () {
                      console.log("Gagal mengambil data");
                  }
              });
        }
    });

    // EDIT HARGA
    $("#btnEditHarga").on("click", function() {
      event.preventDefault();
      const kodeBarang = $("#inputKode").val();
      const hargaBaru = $("#inputHarga").val();

      // Cek apakah textfield ada isinya
      if (kodeBarang !== "" && hargaBaru !== "") {
        // Validasi BR2: Harga harus bilangan positif dalam ribuan
        if (isNaN(hargaBaru) || parseInt(hargaBaru) <= 0 || parseInt(hargaBaru) % 100 !== 0) {
            Swal.fire({
              icon: 'error',
              title: 'Harga Tidak Valid',
              html: 'Harga harus dalam bentuk bilangan positif <br> dalam ribu rupiah',
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#inputHarga").val("");
                }
            });
            return;
        }

        // Harga harus lebih dari 1000
        if (parseInt(hargaBaru) < 1000) {
            Swal.fire({
                icon: 'error',
                title: 'Harga Tidak Valid',
                text: 'Harga harus lebih dari 1000 rupiah',
            });
            return;
        }

      // Log data yang dikirim ke server untuk debugging
      console.log("Kode Barang:", kodeBarang);
      console.log("Harga Baru:", hargaBaru);

      $.ajax({
        url: 'editHarga.php', // Endpoint untuk menyimpan data harga yang diedit
        method: 'POST',
        data: {
          kode_barang: kodeBarang,
          harga_baru: hargaBaru
        },
        success: function (response) {
            try {
                if (response.success) {
                    Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Perubahan harga berhasil disimpan!',
                    }).then((result) => {
                          if (result.isConfirmed) {
                              $("#findKode").val("");
                              $("#inputKode").val("").prop("disabled", true);
                              $("#inputStok").val("").prop("disabled", true);
                              $("#inputHarga").val("").prop("disabled", true);
                          }
                      });
                } 
                else {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'Gagal memperbarui harga',
                  }).then((result) => {
                          if (result.isConfirmed) {
                              $("#inputHarga").val("");
                          }
                      });
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.log('Response from server:', response); // Untuk debugging
            }
        },
        error: function () {
            console.log('Error saving data');
        }
    });
  } else {
      Swal.fire({
        icon: 'warning',
        title: 'Data Tidak Lengkap',
        text: 'Mohon isi semua data',
    });
  }
});


});
  </script>
<footer class="text-center py-3">
    <p class="mb-0">&copy; <?php echo date("Y"); ?> HARTONO COLLECTION. All rights reserved.</p>
    <p class="mb-0">Email: info@hartonocollection.com | Phone: (123) 456-7890</p>
</footer>
</body>
</html>