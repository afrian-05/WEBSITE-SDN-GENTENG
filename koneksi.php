<?php
// Ganti dengan detail koneksi XAMPP Anda
$host = "localhost"; // Biasanya localhost
$user = "root";      // Default user XAMPP
$password = "";      // Default password XAMPP (kosong)
$database = "db_ppdb_sekolah"; // Nama database yang Anda buat

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>