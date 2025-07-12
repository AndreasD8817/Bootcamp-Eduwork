<?php
// ===============================================================
// FILE: dashboard.php
// Deskripsi: Halaman utama dashboard untuk menampilkan dan mengelola produk.
// ===============================================================

// Memuat file koneksi database
include 'koneksi.php';

// Mengambil pesan status dari URL (setelah operasi CRUD)
$status_pesan = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah_sukses') {
        $status_pesan = '<div class="alert alert-success" role="alert">Produk berhasil ditambahkan!</div>';
    } elseif ($_GET['status'] == 'edit_sukses') {
        $status_pesan = '<div class="alert alert-success" role="alert">Produk berhasil diperbarui!</div>';
    } elseif ($_GET['status'] == 'hapus_sukses') {
        $status_pesan = '<div class="alert alert-success" role="alert">Produk berhasil dihapus!</div>';
    } elseif ($_GET['status'] == 'hapus_gagal') {
        $status_pesan = '<div class="alert alert-danger" role="alert">Gagal menghapus produk.</div>';
    }elseif ($_GET['status'] == 'upload_gagal') {
        $status_pesan = '<div class="alert alert-danger" role="alert">Gagal menambahkan produk.</div>';
    } 
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Produk</title>
    <!-- Memuat Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .container {
            margin-top: 30px;
        }
        .table-responsive {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden; /* Memastikan sudut membulat diterapkan pada tabel */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        .btn-action {
            margin-right: 5px;
            border-radius: 5px;
        }
        .btn-add-product {
            border-radius: 8px;
        }
        .product-image {
            width: 80px; /* Lebar gambar di tabel */
            height: 80px; /* Tinggi gambar di tabel */
            object-fit: cover; /* Pastikan gambar mengisi area tanpa terdistorsi */
            border-radius: 5px;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
            border-radius: 10px 10px 0 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pengguna</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Manajemen Produk</h2>
        <?php echo $status_pesan; // Menampilkan pesan status ?>

        <a href="tambah_produk.php" class="btn btn-primary mb-3 btn-add-product">Tambah Produk Baru</a>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil semua produk
                    $sql = "SELECT id, nama_produk, kategori, harga, stok, gambar FROM products ORDER BY id DESC";
                    $result = mysqli_query($koneksi, $sql);

                    $nomor_urut =1;

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id_produk = htmlspecialchars($row['id']);
                            $nama_produk = htmlspecialchars($row['nama_produk']);
                            $kategori_produk = htmlspecialchars($row['kategori']);
                            $harga_produk = number_format($row['harga'], 0, ',', '.');
                            $stok_produk = htmlspecialchars($row['stok']);
                            $gambar_produk_nama_file = htmlspecialchars($row['gambar']);

                            // Menentukan path gambar lokal atau placeholder
                            $gambar_path = "images/" . $gambar_produk_nama_file;
                            if (!file_exists($gambar_path) || empty($gambar_produk_nama_file)) {
                                $gambar_path = "https://placehold.co/80x80/cccccc/333333?text=No+Image"; // Placeholder jika gambar tidak ditemukan
                            }
                    ?>
                            <tr>
                                <td><?php echo $nomor_urut++; ?></td>
                                <td><?php echo $id_produk; ?></td>
                                <td><img src="<?php echo $gambar_path; ?>" alt="<?php echo $nama_produk; ?>" 
                                class="product-image" onerror="this.onerror=null;this.src='https://placehold.co/80x80/cccccc/333333?text=No+Image';"></td>
                                <td><?php echo $nama_produk; ?></td>
                                <td><?php echo $kategori_produk; ?></td>
                                <td>Rp <?php echo $harga_produk; ?></td>
                                <td><?php echo $stok_produk; ?></td>
                                <td>
                                    <a href="edit_produk.php?id=<?php echo $id_produk; ?>" class="btn btn-warning btn-sm btn-action">Edit</a>
                                    <!-- Tombol hapus dengan konfirmasi JavaScript sederhana -->
                                    <a href="hapus_produk.php?id=<?php echo $id_produk; ?>" class="btn btn-danger btn-sm btn-action" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>Tidak ada produk yang tersedia.</td></tr>";
                    }

                    // Menutup koneksi database
                    mysqli_close($koneksi);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Dashboard Admin. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <!-- Memuat Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>