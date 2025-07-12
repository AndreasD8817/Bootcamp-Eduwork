<?php
// ===============================================================
// FILE: edit_produk.php
// Deskripsi: Form untuk mengedit produk yang sudah ada.
// ===============================================================

// Memuat file koneksi database
include 'koneksi.php';

$pesan_status = '';
$id_produk_edit = null;
$data_produk = [
    'nama_produk' => '',
    'deskripsi' => '',
    'harga' => '',
    'stok' => '',
    'kategori' => '',
    'gambar' => '' // Akan menyimpan nama file gambar saat ini
];

// Mengambil ID produk dari URL
if (isset($_GET['id'])) {
    $id_produk_edit = filter_var($_GET['id'], FILTER_VALIDATE_INT); // Validasi integer
    if ($id_produk_edit === false) {
        die("ID produk tidak valid.");
    }

    // Mengambil data produk yang akan diedit dari database
    $sql_fetch = "SELECT nama_produk, deskripsi, harga, stok, kategori, gambar FROM products WHERE id = ?";
    $stmt_fetch = mysqli_prepare($koneksi, $sql_fetch);
    mysqli_stmt_bind_param($stmt_fetch, "i", $id_produk_edit); // "i" untuk integer
    mysqli_stmt_execute($stmt_fetch);
    $result_fetch = mysqli_stmt_get_result($stmt_fetch);

    if (mysqli_num_rows($result_fetch) == 1) {
        $data_produk = mysqli_fetch_assoc($result_fetch);
    } else {
        die("Produk tidak ditemukan.");
    }
    mysqli_stmt_close($stmt_fetch);
} else {
    die("ID produk tidak diberikan.");
}

// Memproses data form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form dan membersihkannya
    $nama_produk = htmlspecialchars(trim($_POST['nama_produk']));
    $deskripsi = htmlspecialchars(trim($_POST['deskripsi']));
    $harga = filter_var($_POST['harga'], FILTER_VALIDATE_INT);
    $stok = filter_var($_POST['stok'], FILTER_VALIDATE_INT);
    $kategori = htmlspecialchars(trim($_POST['kategori']));
    
    // Ambil nama gambar yang sudah ada dari database (sebelum ada upload baru)
    $gambar_lama = $data_produk['gambar']; 
    $gambar_nama_file_baru = $gambar_lama; // Default: gunakan gambar lama

    // --- Bagian Upload Gambar Baru ---
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
                $gambar_nama_file_baru = uniqid('prod_', true) . '.' . $file_ext;
                $upload_path = $upload_dir . $gambar_nama_file_baru;

                // Pindahkan file yang diupload ke folder tujuan
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Jika upload sukses, hapus gambar lama jika ada dan bukan placeholder
                    if (!empty($gambar_lama) && file_exists($upload_dir . $gambar_lama) && $gambar_lama != 'no_image.png') { // Hindari hapus placeholder
                        unlink($upload_dir . $gambar_lama);
                    }
                } else {
                    $pesan_status = '<div class="alert alert-danger" role="alert">Gagal memindahkan file gambar baru.</div>';
                    $gambar_nama_file_baru = $gambar_lama; // Kembali ke gambar lama jika gagal upload
                }
            } else {
                $pesan_status = '<div class="alert alert-danger" role="alert">Ukuran file gambar terlalu besar (maks 2MB).</div>';
                $gambar_nama_file_baru = $gambar_lama; // Kembali ke gambar lama jika gagal upload
            }
        } else {
            $pesan_status = '<div class="alert alert-danger" role="alert">Format file gambar tidak didukung (hanya JPG, JPEG, PNG, GIF).</div>';
            $gambar_nama_file_baru = $gambar_lama; // Kembali ke gambar lama jika gagal upload
        }
    }
    // Jika tidak ada file baru diupload, $gambar_nama_file_baru akan tetap berisi $gambar_lama

    // Validasi sederhana
    if (empty($nama_produk) || empty($deskripsi) || $harga === false || $stok === false || empty($kategori)) {
        if (empty($pesan_status)) { // Jika belum ada pesan error dari upload gambar
            $pesan_status = '<div class="alert alert-danger" role="alert">Semua kolom harus diisi dengan benar!</div>';
        }
    } else {
        // Query SQL untuk UPDATE data menggunakan Prepared Statement
        $sql_update = "UPDATE products SET nama_produk = ?, deskripsi = ?, harga = ?, stok = ?, kategori = ?, gambar = ? WHERE id = ?";
        
        // Mempersiapkan statement
        $stmt_update = mysqli_prepare($koneksi, $sql_update);

        // Mengikat parameter ke statement
        mysqli_stmt_bind_param($stmt_update, "ssiissi", $nama_produk, $deskripsi, $harga, $stok, $kategori, $gambar_nama_file_baru, $id_produk_edit);

        // Mengeksekusi statement
        if (mysqli_stmt_execute($stmt_update)) {
            // Redirect ke dashboard dengan pesan sukses
            header("Location: dashboard.php?status=edit_sukses");
            exit();
        } else {
            $pesan_status = '<div class="alert alert-danger" role="alert">Gagal memperbarui produk: ' . mysqli_error($koneksi) . '</div>';
        }

        // Menutup statement
        mysqli_stmt_close($stmt_update);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
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
        .current-image-preview {
            max-width: 150px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Edit Produk</h2>
        <?php echo $pesan_status; // Menampilkan pesan status ?>

        <form action="edit_produk.php?id=<?php echo $id_produk_edit; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk:</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($data_produk['nama_produk']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($data_produk['deskripsi']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga:</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($data_produk['harga']); ?>" required min="0">
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok:</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo htmlspecialchars($data_produk['stok']); ?>" required min="0">
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori:</label>
                <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo htmlspecialchars($data_produk['kategori']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini:</label><br>
                <?php 
                    $current_image_path = "images/" . htmlspecialchars($data_produk['gambar']);
                    if (empty($data_produk['gambar']) || !file_exists($current_image_path)) {
                        $current_image_path = "https://placehold.co/150x150/cccccc/333333?text=No+Image";
                    }
                ?>
                <img src="<?php echo $current_image_path; ?>" alt="Gambar Produk Saat Ini" class="current-image-preview">
                <p class="form-text">Nama file: <?php echo empty($data_produk['gambar']) ? 'Tidak ada' : htmlspecialchars($data_produk['gambar']); ?></p>
                
                <label for="gambar" class="form-label">Upload Gambar Baru (Opsional):</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/jpeg,image/png,image/gif">
                <div class="form-text">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary me-md-2">Perbarui Produk</button>
                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <!-- Memuat Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>