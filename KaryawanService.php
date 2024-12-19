<?php
class KaryawanService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Fungsi untuk mengambil data karyawan berdasarkan ID
    public function getKaryawanById($id_karyawan) {
        $result = $this->conn->query("SELECT * FROM karyawan WHERE id_karyawan = $id_karyawan");
        return $result->fetch_assoc();
    }

    // Fungsi untuk memperbarui gaji karyawan
    public function updateGaji($id_karyawan, $new_gaji, $new_periode) {
        $this->conn->query("UPDATE karyawan SET gaji = $new_gaji, periode_terakhir = '{$new_periode->format('Y-m-d')}' WHERE id_karyawan = $id_karyawan");
    }
    
    // Fungsi untuk mendapatkan tanggal absensi pertama karyawan
    private function getFirstAttendanceDate($id_karyawan) {
        $result = $this->conn->query("SELECT MIN(jam) AS tanggal_absensi_pertama FROM absensi WHERE id_karyawan = $id_karyawan");
        $data = $result->fetch_assoc();
        return $data['tanggal_absensi_pertama'];    
    }

    // Fungsi untuk menghitung jumlah absensi dalam rentang tanggal tertentu
    private function getAttendanceCount($id_karyawan, $startDate, $endDate) {
        $query = "SELECT COUNT(*) AS hadir FROM absensi 
                  WHERE id_karyawan = $id_karyawan 
                  AND DATE(jam) BETWEEN '{$startDate->format('Y-m-d')}' AND '{$endDate->format('Y-m-d')}'";
        $result = $this->conn->query($query);
        $data = $result->fetch_assoc();
        return $data['hadir'];
    }

    // Fungsi untuk menghitung detail gaji karyawan berdasarkan tahun kerja
    // Fungsi untuk menghitung detail gaji karyawan berdasarkan tahun kerja
public function detailGaji($id_karyawan) {
    // Ambil data karyawan berdasarkan ID
    $row = $this->getKaryawanById($id_karyawan);
    if (!$row || empty($row['start_date'])) return null; // Pastikan start_date ada

    // Ambil start_date dari tabel karyawan
    $start_date = new DateTime($row['start_date']);
    $current_date = new DateTime();

    // Hitung tahun kerja berdasarkan start_date
    $interval = $start_date->diff($current_date);
    $years_of_work = $interval->y; // Selisih dalam tahun penuh

    // Jika tahun kerja kurang dari 1 tahun (misalnya bekerja hanya beberapa bulan),
    // maka set tahun kerja menjadi 1 untuk menghindari 0 tahun kerja.
    if ($years_of_work < 1) {
        $years_of_work = 1;
    }

    // Perhitungan gaji pokok dan kenaikan tahunan
    $base_salary = 3000000; // Gaji pokok tetap Rp 3 juta pada tahun pertama
    $increment = 0;

    // Jika sudah memasuki tahun kedua atau lebih, hitung tambahan gaji
    if ($years_of_work >= 2) {
        $increment = ($years_of_work - 1) * 2000000; // Tahun kedua dan seterusnya mendapatkan tambahan Rp 2 juta per tahun
    }

    $calculated_salary = $base_salary + $increment;

    // Bonus berdasarkan kehadiran
    $attendance_count = $this->getAttendanceCount($id_karyawan, $start_date, $current_date);
    $work_days = 312; // Jumlah hari kerja dalam setahun
    $bonus = ($attendance_count >= $work_days) ? 500000 : 0;
    $calculated_salary += $bonus;

    // Kembalikan detail gaji
    return [
        'nama' => $row['nama'],
        'base_salary' => $base_salary,
        'increment' => $increment,
        'bonus' => $bonus,
        'total' => $calculated_salary,
        'years_of_work' => $years_of_work,
        'start_date' => $start_date->format('Y-m-d'),
        'current_date' => $current_date->format('Y-m-d')
    ];
}


    // Fungsi untuk menghitung dan memperbarui gaji karyawan
    public function hitungGaji($id_karyawan) {
        $detail = $this->detailGaji($id_karyawan);
        if ($detail) {
            $current_date = new DateTime();
            $this->updateGaji($id_karyawan, $detail['total'], $current_date);
        }
        return $detail;
    }
}
?>
