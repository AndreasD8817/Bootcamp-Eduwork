<?php
// ===============================================================
// FILE: hapus_produk.php
// Deskripsi: Skrip untuk menghapus produk dari database.
// ===============================================================

// Memuat file koneksi database
include 'koneksi.php';

// Memeriksa apakah ID produk diberikan melalui URL
if (isset($_GET['id'])) {
    $id_produk = filter_var($_GET['id'], FILTER_VALIDATE_INT); // Validasi integer

    if ($id_produk === false) {
        // Redirect ke dashboard dengan pesan gagal jika ID tidak valid
        header("Location: dashboard.php?status=hapus_gagal");
        exit();
    }

    // Ambil nama file gambar sebelum menghapus record dari database
    $sql_get_image = "SELECT gambar FROM products WHERE id = ?";
    $stmt_get_image = mysqli_prepare($koneksi, $sql_get_image);
    mysqli_stmt_bind_param($stmt_get_image, "i", $id_produk);
    mysqli_stmt_execute($stmt_get_image);
    $result_get_image = mysqli_stmt_get_result($stmt_get_image);
    $row_image = mysqli_fetch_assoc($result_get_image);
    $gambar_to_delete = $row_image['gambar'] ?? ''; // Ambil nama file gambar
    mysqli_stmt_close($stmt_get_image);

    // Query SQL untuk DELETE data menggunakan Prepared Statement
    $sql = "DELETE FROM products WHERE id = ?";
    
    // Mempersiapkan statement
    $stmt = mysqli_prepare($koneksi, $sql);

    // Mengikat parameter ke statement
    mysqli_stmt_bind_param($stmt, "i", $id_produk); // "i" untuk integer

    // Mengeksekusi statement
    if (mysqli_stmt_execute($stmt)) {
        // Jika penghapusan dari database sukses, hapus juga file gambar dari server
        $upload_dir = "images/";
        if (!empty($gambar_to_delete) && file_exists($upload_dir . $gambar_to_delete) && $gambar_to_delete != 'no_image.png') {
            unlink($upload_dir . $gambar_to_delete);
        }
        // Redirect ke dashboard dengan pesan sukses
        header("Location: dashboard.php?status=hapus_sukses");
        exit();
    } else {
        // Redirect ke dashboard dengan pesan gagal
        header("Location: dashboard.php?status=hapus_gagal");
        exit();
    }

    // Menutup statement
    mysqli_stmt_close($stmt);
} else {
    // Redirect ke dashboard jika ID tidak diberikan
    header("Location: dashboard.php?status=hapus_gagal");
    exit();
}

// Menutup koneksi database
mysqli_close($koneksi);

?>