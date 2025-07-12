<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Data Produk</title>
</head>
<body>
    <h1>Hasil Proses Data Produk</h1>
    <?php
    // Mendeklarasikan variabel dan mengambil data dari form
    // Menggunakan $_POST karena method form adalah POST
    $namaProduk = htmlspecialchars(trim( $_POST['nama_produk']));
    $hargaProduk = htmlspecialchars(trim( $_POST['harga_produk']));
    $deskripsiProduk = htmlspecialchars(trim( $_POST['deskripsi_produk']));

    // --- Bagian Validasi Sederhana (Tugas 3) ---
    // Menggunakan operator logika dan if-else untuk validasi
    if (empty($namaProduk) || empty($hargaProduk) || empty($deskripsiProduk)) {
        echo "<p style='color: red;'><strong>Error:</strong> Semua kolom harus diisi!</p>";
        echo "<p><a href='form_html.html'>Kembali ke Form</a></p>";
    } else {
        // --- Bagian Operator Sederhana (Contoh) ---
        // Misalnya, kita ingin menghitung harga diskon (hanya contoh operator)
        // Kita bisa asumsikan diskon 10% jika harga di atas 100000
        $diskon = 0;
        if ($hargaProduk > 100000) {
            $diskon = 0.10; // Diskon 10%
        }
        $hargaSetelahDiskon = $hargaProduk - ($hargaProduk * $diskon);

        // Menampilkan data yang berhasil diproses
        echo "<p><strong>Nama Produk:</strong> " . $namaProduk . "</p>";
        echo "<p><strong>Harga Asli:</strong> Rp " . number_format($hargaProduk, 0, ',', '.') . "</p>";
        
        // Menampilkan diskon jika ada
        if ($diskon > 0) {
            echo "<p><strong>Diskon:</strong> " . ($diskon * 100) . "%</p>";
            echo "<p><strong>Harga Setelah Diskon:</strong> Rp " . number_format($hargaSetelahDiskon, 0, ',', '.') . "</p>";
        } else {
            echo "<p>Tidak ada diskon untuk produk ini.</p>";
        }
        
        echo "<p><strong>Deskripsi:</strong> " . $deskripsiProduk . "</p>";
        echo "<p style='color: green;'>Data produk berhasil disimpan (simulasi).</p>";
        echo "<p><a href='form_html.html'>Tambah Produk Lain</a></p>";

        // Catatan: Pada aplikasi nyata, data ini akan disimpan ke database di sini.
    }
    ?>
</body>
</html>