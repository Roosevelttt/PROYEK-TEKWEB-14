<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hartono Collections</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body {
      background-color: #f9f9f9;
      font-family: Arial, sans-serif;
      overflow-x: hidden;
    }

    .hamburger {
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 30px;
        height: 20px;
        z-index: 20;
    }

    .hamburger span {
        display: block;
        height: 4px;
        background-color: black;
        border-radius: 2px;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .tags li {
        padding: 5px 15px;
    }

    .nav-menu {
        display: none;
        position: absolute;
        top: 40px;
        left: 20px;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        list-style: none;
        padding: 10px 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 10;
    }

    .nav-menu li {
        margin: 5px 0;
    }

    .nav-menu li a {
        text-decoration: none;
        color: black;
        display: block;
        padding: 5px 15px;
        transition: background-color 0.3s ease;
    }

    .nav-menu li a:hover {
        background-color: #f0f0f0;
    }

    .nav-left.active .nav-menu {
        display: block;
    }

    .hamburger.active span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }


    .explore-btn {
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .explore-btn .circle {
      display: inline-block;
      background-color: #000;
      color: #fff;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      text-align: center;
      line-height: 20px;
    }

    .center-content {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90vh;
      text-align: center;
    }

    .sphere {
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: radial-gradient(circle, #fff, #ffff00);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .text-behind {
      position: absolute;
      font-size: 10vw;
      color: #000;
      font-weight: bold;
      z-index: -1;
      white-space: nowrap;
    }

    .tags {
      position: absolute;
      bottom: 20px;
      display: flex;
      gap: 10px;
    }

    .tag {
      padding: 5px 10px;
      border-radius: 20px;
      background-color: #f0f0f0;
      font-size: 16px;
    }

    .tag.active {
      background-color: #000;
      color: #fff;
    }

    .profile-container {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .profile-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        top: 50px;
        right: 0;
        background: white;
        border: 1px solid #ccc;
        padding: 10px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .profile-container:hover .profile-dropdown {
        display: block;
    }

    .profile-dropdown p {
        margin: 0;
        font-size: 14px;
    }

    .profile-dropdown a {
        color: blue;
        text-decoration: none;
        font-size: 14px;
    }

  </style>
</head>
<body>  
    <nav>
        <div class="nav-left ms-4 mt-4">
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <ul class="nav-menu">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="menambahProdukBaru.php">Produk</a></li>
                <li><a href="pageHarga.php">Harga</a></li>
                <li><a href="pageStokToko.php">Stok</a></li>
                <li><a href="halamanTransaksi.php">Transaksi</a></li>
                <li><a href="#">Karyawan</a></li>
                <li><a href="#">Laporan</a></li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid d-flex font-weight-bold justify-content-center align-items-start" style="height: 1vh;">
        <div class="text-center mt-1">
            <p class="fw-bold fs-3">- HARTONO COLLECTIONS -</p>
        </div>
    </div>


  <div class="center-content">
    <div class="text-behind">Hartono Collections</div>
    <div class="sphere"></div>
  </div>

  <ul class="tags position-absolute mb-4 me-5 bottom-0 end-0 d-flex gap-2">
    <li href="loginPage.php" class="tag active">Logout</li>
  </ul>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleMenu() {
        const navMenu = document.querySelector('.nav-menu');
        const hamburger = document.querySelector('.hamburger');
        const isHidden = navMenu.style.display === 'none' || navMenu.style.display === '';

        navMenu.style.display = isHidden ? 'block' : 'none'; // Show or hide the menu
        hamburger.classList.toggle('active'); // Animate the hamburger
    }
  </script>
</body>
</html>
