<?php
// ===============================================================
// FILE: tambah_produk.php
// Deskripsi: Form untuk menambahkan produk baru.
// ===============================================================

// Memuat file koneksi database
include 'koneksi.php';

$pesan_status = '';

// Memproses data form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form dan membersihkannya
    $nama_produk = htmlspecialchars(trim($_POST['nama_produk']));
    $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));
    $harga = filter_var($_POST['harga'], FILTER_VALIDATE_INT); // Validasi integer
    $stok = filter_var($_POST['stok'], FILTER_VALIDATE_INT);   // Validasi integer
    $kategori = htmlspecialchars(trim($_POST['kategori']));

    // --- Bagian Upload Gambar ---
    $gambar_nama_file = ''; // Inisialisasi nama file gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_name = $_FILES['gambar']['name'];
        $file_size = $_FILES['gambar']['size'];
        $file_type = $_FILES['gambar']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        $upload_dir = "images/"; // Folder tempat menyimpan gambar

        // Validasi ekstensi file
        if (in_array($file_ext, $allowed_extensions)) {
            // Validasi ukuran file (contoh: maks 2MB)
            if ($file_size < 2000000) { // 2MB
                // Buat nama file unik untuk menghindari tumpang tindih
                $gambar_nama_file = uniqid('prod_', true) . '.' . $file_ext;
                $upload_path = $upload_dir . $gambar_nama_file;

                // Pindahkan file yang diupload ke folder tujuan
                if (!move_uploaded_file($file_tmp, $upload_path)) {
                    $pesan_status = '<div class="alert alert-danger" role="alert">Gagal memindahkan file gambar.</div>';
                    $gambar_nama_file = ''; // Reset jika gagal
                }
            } else {
                $pesan_status = '<div class="alert alert-danger" role="alert">Ukuran file gambar terlalu besar (maks 2MB).</div>';
            }
        } else {
            $pesan_status = '<div class="alert alert-danger" role="alert">Format file gambar tidak didukung (hanya JPG, JPEG, PNG, GIF).</div>';
        }
    } else {
        // Jika tidak ada file diupload atau ada error upload
        $pesan_status = '<div class="alert alert-danger" role="alert">Silakan upload file gambar.</div>';
    }

    // Validasi sederhana: pastikan semua field tidak kosong dan gambar berhasil diupload
    if (empty($nama_produk) || empty($deskripsi) || $harga === false || $stok === false || empty($kategori) || empty($gambar_nama_file)) {
        if (empty($pesan_status)) { // Jika belum ada pesan error dari upload gambar
            $pesan_status = '<div class="alert alert-danger" role="alert">Semua kolom harus diisi dengan benar!</div>';
        }
    } else {
        // Query SQL untuk INSERT data menggunakan Prepared Statement
        $sql = "INSERT INTO products (nama_produk, deskripsi, harga, stok, kategori, gambar) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Mempersiapkan statement
        $stmt = mysqli_prepare($koneksi, $sql);

        // Mengikat parameter ke statement (s=string, i=integer)
        mysqli_stmt_bind_param($stmt, "ssiiss", $nama_produk, $deskripsi, $harga, $stok, $kategori, $gambar_nama_file);

        // Mengeksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect ke dashboard dengan pesan sukses
            header("Location: dashboard.php?status=tambah_sukses");
            exit(); // Hentikan eksekusi script setelah redirect
        } else {
            // Jika ada error database, hapus gambar yang sudah diupload
            if (!empty($gambar_nama_file) && file_exists($upload_dir . $gambar_nama_file)) {
                unlink($upload_dir . $gambar_nama_file);
            }
            $pesan_status = '<div class="alert alert-danger" role="alert">Gagal menambahkan produk: ' . mysqli_error($koneksi) . '</div>';
        }

        // Menutup statement
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
    <!-- Memuat Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
            max-width: 700px; /* Batasi lebar form */
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary, .btn-secondary {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Tambah Produk Baru</h2>
        <?php echo $pesan_status; // Menampilkan pesan status ?>

        <form action="tambah_produk.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk:</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga:</label>
                <input type="number" class="form-control" id="harga" name="harga" required min="0">
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok:</label>
                <input type="number" class="form-control" id="stok" name="stok" required min="0">
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori:</label>
                <input type="text" class="form-control" id="kategori" name="kategori" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar Produk:</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/jpeg,image/png,image/gif" required>
                <div class="form-text">Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary me-md-2">Simpan Produk</button>
                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <!-- Memuat Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>