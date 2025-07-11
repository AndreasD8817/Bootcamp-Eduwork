<?php
// ===============================================================
// FILE: index.php (Halaman Tampilan Produk)
// Deskripsi: Menampilkan daftar produk dan fitur keranjang.
// ===============================================================
session_start(); // Mulai sesi PHP

// Memuat file koneksi database
include 'koneksi.php';

// Mendapatkan status login
$is_logged_in = isset($_SESSION['user_id']);
$user_nama = $is_logged_in ? htmlspecialchars($_SESSION['user_nama']) : '';

// Mendapatkan jumlah item di keranjang
$cart_item_count = 0;
if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    $sql_count = "SELECT SUM(quantity) AS total_items FROM cart_items WHERE user_id = ?";
    $stmt_count = mysqli_prepare($koneksi, $sql_count);
    mysqli_stmt_bind_param($stmt_count, "i", $user_id);
    mysqli_stmt_execute($stmt_count);
    $result_count = mysqli_stmt_get_result($stmt_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $cart_item_count = $row_count['total_items'] ?? 0;
    mysqli_stmt_close($stmt_count);
} else {
    if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $qty) {
            $cart_item_count += $qty;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online Saya</title>
    <!-- Memuat Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome untuk ikon keranjang -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS kustom untuk sedikit penyesuaian */
        body {
            font-family: 'Inter', sans-serif; /* Menggunakan font Inter */
            background-color: #f8f9fa; /* Warna latar belakang ringan */
        }
        .navbar {
            border-radius: 0 0 10px 10px; /* Sudut membulat di bagian bawah navbar */
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Bayangan lembut */
        }
        .product-card {
            border: none; /* Hilangkan border default card */
            border-radius: 15px; /* Sudut membulat pada kartu produk */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Bayangan untuk efek kedalaman */
            transition: transform 0.2s ease-in-out; /* Animasi saat hover */
            overflow: hidden; /* Pastikan gambar tidak keluar dari sudut membulat */
            height: 100%; /* Pastikan semua kartu memiliki tinggi yang sama */
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-5px); /* Sedikit naik saat di-hover */
        }
        .product-card img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 280px; /* Tinggi gambar produk yang seragam, diubah menjadi potret */
            object-fit: contain; /* Pastikan gambar tertampil sempurna tanpa terpotong */
            width: 100%; /* Pastikan gambar mengisi lebar kartu */
            background-color: #f0f0f0; /* Warna latar belakang untuk mengisi ruang kosong */
        }
        .card-body {
            flex-grow: 1; /* Memastikan body kartu mengisi sisa ruang */
            display: flex;
            flex-direction: column;
        }
        .card-title {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 0.5rem;
        }
        .card-text {
            font-size: 0.9em;
            color: #6c757d;
            flex-grow: 1; /* Memastikan deskripsi mengisi ruang */
        }
        .product-price {
            font-size: 1.2em;
            color: #007bff; /* Warna biru untuk harga */
            font-weight: bold;
            margin-top: auto; /* Dorong harga ke bawah kartu */
        }
        .btn-primary {
            border-radius: 8px; /* Sudut membulat pada tombol */
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
            border-radius: 10px 10px 0 0;
        }
        .cart-icon {
            position: relative;
            margin-left: 15px;
        }
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7em;
        }
    </style>
</head>
<body>
    <!-- Navbar (Header) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Toko Online Saya</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang 
                            <span class="cart-badge"><?php echo $cart_item_count; ?></span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if ($is_logged_in): ?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Halo, <?php echo $user_nama; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        <?php else: ?>
                            <a class="nav-link" href="login.php">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama (Daftar Produk) -->
    <div class="container">
        <h2 class="mb-4 text-center">Produk Terbaru</h2>

        <!-- Filter Kategori -->
        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <form action="" method="GET" class="d-flex align-items-center flex-nowrap">
                    <!-- Menambahkan style 'white-space: nowrap;' untuk mencegah teks label melipat -->
                    <label for="kategoriFilter" class="form-label me-2 mb-0" style="white-space: nowrap;">Filter Kategori:</label>
                    <select class="form-select" id="kategoriFilter" name="kategori" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <?php
                        // Query untuk mendapatkan semua kategori unik
                        $sql_kategori = "SELECT DISTINCT kategori FROM products ORDER BY kategori ASC";
                        $result_kategori = mysqli_query($koneksi, $sql_kategori);

                        $selected_kategori = isset($_GET['kategori']) ? htmlspecialchars($_GET['kategori']) : '';

                        if (mysqli_num_rows($result_kategori) > 0) {
                            while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
                                $kategori_option = htmlspecialchars($row_kategori['kategori']);
                                $selected = ($kategori_option == $selected_kategori) ? 'selected' : '';
                                echo "<option value='{$kategori_option}' {$selected}>{$kategori_option}</option>";
                            }
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            // Query SQL dasar untuk mengambil semua data produk
            $sql = "SELECT id, nama_produk, deskripsi, harga, stok, kategori, gambar FROM products";
            
            // Menambahkan kondisi WHERE jika ada filter kategori yang dipilih
            if (!empty($selected_kategori)) {
                // Gunakan prepared statement untuk keamanan
                $sql .= " WHERE kategori = ?";
            }
            $sql .= " ORDER BY id DESC"; // Selalu urutkan berdasarkan ID terbaru

            // Menggunakan prepared statement untuk keamanan query
            $stmt = mysqli_prepare($koneksi, $sql);

            if (!empty($selected_kategori)) {
                mysqli_stmt_bind_param($stmt, "s", $selected_kategori); // "s" untuk string
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Memeriksa apakah ada produk yang ditemukan
            if (mysqli_num_rows($result) > 0) {
                // Loop melalui setiap baris data produk yang ditemukan
                while ($row = mysqli_fetch_assoc($result)) {
                    // Mendeklarasikan variabel dari setiap kolom data
                    $id_produk = $row['id'];
                    $nama_produk = htmlspecialchars($row['nama_produk']); // Membersihkan input untuk keamanan
                    $deskripsi_produk = htmlspecialchars(substr($row['deskripsi'], 0, 100)) . '...'; // Ambil 100 karakter pertama
                    $harga_produk = $row['harga'];
                    $stok_produk = $row['stok'];
                    $kategori_produk = htmlspecialchars($row['kategori']);
                    $gambar_produk_nama_file = htmlspecialchars($row['gambar']); // Mengambil nama file gambar dari database

                    // Menentukan path gambar lokal atau placeholder
                    $gambar_path = "images/" . $gambar_produk_nama_file;
                    
                    // Cek apakah file gambar ada di server lokal, jika tidak gunakan placeholder
                    if (!file_exists($gambar_path) || empty($gambar_produk_nama_file)) {
                        $gambar_path = "https://placehold.co/600x400/cccccc/333333?text=No+Image"; // Placeholder jika gambar tidak ditemukan
                    }
            ?>
                    <!-- Kartu Produk Bootstrap -->
                    <div class="col">
                        <div class="card product-card">
                            <!-- Menggunakan $gambar_path yang sekarang berisi path lokal atau placeholder -->
                            <img src="<?php echo $gambar_path; ?>" class="card-img-top" alt="<?php echo $nama_produk; ?>" onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/333333?text=No+Image';">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $nama_produk; ?></h5>
                                <p class="card-text"><?php echo $deskripsi_produk; ?></p>
                                <p class="product-price">Rp <?php echo number_format($harga_produk, 0, ',', '.'); ?></p>
                                <p class="card-text"><small class="text-muted">Stok: <?php echo $stok_produk; ?></small></p>
                                <!-- Form Tambah ke Keranjang -->
                                <form action="tambah_ke_keranjang.php" method="POST" class="mt-2">
                                    <input type="hidden" name="product_id" value="<?php echo $id_produk; ?>">
                                    <input type="hidden" name="quantity" value="1"> <!-- Default 1 saat ditambahkan -->
                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                // Pesan jika tidak ada produk ditemukan di database
                echo "<div class='col-12'><p class='text-center'>Tidak ada produk yang tersedia saat ini.</p></div>";
            }

            // Menutup prepared statement
            mysqli_stmt_close($stmt);
            // Menutup koneksi database
            mysqli_close($koneksi);
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Toko Online Saya. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <!-- Memuat Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>