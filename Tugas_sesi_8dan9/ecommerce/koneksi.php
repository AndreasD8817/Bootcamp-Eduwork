<?php
// koneksi.php - File untuk mengatur koneksi ke database

// --- Deklarasi Variabel untuk Konfigurasi Database ---
// Nama host database. Jika menggunakan Laragon/XAMPP, biasanya 'localhost'.
$host = "localhost"; 

// Username untuk mengakses database. Default Laragon/XAMPP biasanya 'root'.
$user = "root";

// Password untuk user database. Default Laragon/XAMPP biasanya kosong (tidak ada password).
$pass = ""; 

// Nama database yang akan kita gunakan. Anda bisa menggantinya nanti sesuai nama database Anda.
// Contoh: Buat database baru di phpMyAdmin/HeidiSQL dengan nama 'db_produk'.
$database = "toko"; 

// --- Membuat Koneksi ke Database ---
// Menggunakan fungsi mysqli_connect() untuk membuka koneksi.
// Fungsi ini membutuhkan 4 parameter: host, username, password, dan nama database.
$koneksi = mysqli_connect($host, $user, $pass, $database);

// --- Cek Koneksi ---
// Menggunakan if-else untuk memeriksa apakah koneksi berhasil atau gagal.
if (!$koneksi) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan eksekusi script.
    // mysqli_connect_error() akan memberikan detail error koneksi.
    die("Koneksi database gagal: " . mysqli_connect_error());
} 
// else {
//     // Baris ini bisa diaktifkan (hapus //) untuk menguji apakah koneksi berhasil.
//     // Namun, di aplikasi nyata, kita tidak menampilkan pesan ini agar tidak bocor ke publik.
//     echo "Koneksi database berhasil!"; 
//}

?>