<?php
session_start(); // Memulai session

// Menghancurkan semua session yang ada
session_unset();  // Menghapus semua variabel session
session_destroy(); // Menghancurkan session secara keseluruhan

// Mengarahkan pengguna ke halaman login
header("Location: loginPage.php");
exit();
?>
