<?php
// ===============================================================
// FILE: tambah_ke_keranjang.php
// Deskripsi: Memproses penambahan produk ke keranjang (sesi atau database).
// ===============================================================
session_start(); // Mulai sesi PHP
include 'koneksi.php'; // Memuat koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);

    if ($product_id === false || $quantity === false || $quantity <= 0) {
        // Redirect dengan pesan error jika input tidak valid
        header("Location: index.php?status=error_input");
        exit();
    }

    $user_id = $_SESSION['user_id'] ?? null; // Ambil user_id jika sudah login

    if ($user_id) {
        // --- Logika untuk Pengguna Login (Database) ---
        // Cek apakah produk sudah ada di keranjang user
        $sql_check = "SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?";
        $stmt_check = mysqli_prepare($koneksi, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $product_id);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            // Jika produk sudah ada, update kuantitas
            $row = mysqli_fetch_assoc($result_check);
            $cart_item_id = $row['id'];
            $new_quantity = $row['quantity'] + $quantity;

            $sql_update = "UPDATE cart_items SET quantity = ?, updated_at = CURRENT_TIMESTAMP() WHERE id = ?";
            $stmt_update = mysqli_prepare($koneksi, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "ii", $new_quantity, $cart_item_id);
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);
        } else {
            // Jika produk belum ada, tambahkan baru
            $sql_insert = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($koneksi, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "iii", $user_id, $product_id, $quantity);
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);
        }
        mysqli_stmt_close($stmt_check);

    } else {
        // --- Logika untuk Pengguna Tamu (Sesi) ---
        // Inisialisasi keranjang jika belum ada
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }

        // Cek apakah produk sudah ada di keranjang sesi
        if (array_key_exists($product_id, $_SESSION['keranjang'])) {
            // Jika sudah ada, tambahkan kuantitas
            $_SESSION['keranjang'][$product_id] += $quantity;
        } else {
            // Jika belum ada, tambahkan produk baru
            $_SESSION['keranjang'][$product_id] = $quantity;
        }
    }

    // Redirect kembali ke halaman produk atau keranjang
    header("Location: keranjang.php?status=tambah_sukses");
    exit();

} else {
    // Jika bukan metode POST, redirect ke halaman utama
    header("Location: index.php");
    exit();
}

mysqli_close($koneksi);
?>