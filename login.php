<?php
session_set_cookie_params(0);
session_start(); // Start the session

include 'koneksi.php';
header('Content-Type: application/json');

// Mendapatkan data dari frontend
$data = json_decode(file_get_contents('php://input'), true);

// Pastikan data username dan password ada
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username dan password diperlukan.']);
    exit();
}

$inputUsername = trim($data['username']);
$inputPassword = $data['password'];

// Gunakan prepared statement untuk mengambil data karyawan berdasarkan username
$stmt = $conn->prepare("SELECT id_karyawan, kode_karyawan, nama, start_date, jabatan FROM karyawan WHERE REPLACE(nama, ' ', '') = ?");
$stmt->bind_param('s', $inputUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Membentuk password sesuai logika sebelumnya
    $kodeKaryawan = $row['kode_karyawan'];
    $startDate = $row['start_date'];
    $tahunMasuk = substr($startDate, 2, 2); // Dua digit akhir tahun
    $bulanMasuk = substr($startDate, 5, 2); // Dua digit bulan
    $password = $kodeKaryawan . $tahunMasuk . $bulanMasuk;

    // Verifikasi password
    if ($inputPassword === $password) {
        // Simpan informasi pengguna dalam sesi
        $_SESSION['jabatan'] = $row['jabatan'];
        $_SESSION['kode_karyawan'] = $row['kode_karyawan'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['id_karyawan'] = $row['id_karyawan'];

        // Log informasi login
        error_log("User {$row['nama']} (ID: {$row['id_karyawan']}) berhasil login.");

        echo json_encode(['success' => true, 'message' => 'Login berhasil!']);
    } else {
        // Log gagal login
        error_log("Login gagal untuk username: {$inputUsername}");

        echo json_encode(['success' => false, 'message' => 'Username atau password salah.']);
    }
} else {
    // Log gagal login
    error_log("Login gagal untuk username: {$inputUsername}");

    echo json_encode(['success' => false, 'message' => 'Username atau password salah.']);
}

$stmt->close();
$conn->close();
?>
