<?php
// ===============================================================
// FILE: keranjang.php
// Deskripsi: Halaman untuk menampilkan dan mengelola isi keranjang belanja.
// ===============================================================
session_start(); // Mulai sesi PHP
include 'koneksi.php'; // Memuat koneksi database

$pesan_status = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah_sukses') {
        $pesan_status = '<div class="alert alert-success" role="alert">Produk berhasil ditambahkan ke keranjang!</div>';
    } elseif ($_GET['status'] == 'update_sukses') {
        $pesan_status = '<div class="alert alert-success" role="alert">Kuantitas produk berhasil diperbarui!</div>';
    } elseif ($_GET['status'] == 'hapus_sukses') {
        $pesan_status = '<div class="alert alert-success" role="alert">Produk berhasil dihapus dari keranjang!</div>';
    } elseif ($_GET['status'] == 'error_input') {
        $pesan_status = '<div class="alert alert-danger" role="alert">Input tidak valid.</div>';
    }
}

$cart_items = [];
$total_harga_keranjang = 0;
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    // --- Logika untuk Pengguna Login (Database) ---
    $sql = "SELECT ci.id AS cart_item_id, ci.quantity, p.id AS product_id, p.nama_produk, p.harga, p.gambar 
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.user_id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
        $total_harga_keranjang += $row['quantity'] * $row['harga'];
    }
    mysqli_stmt_close($stmt);

} else {
    // --- Logika untuk Pengguna Tamu (Sesi) ---
    if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $product_id => $quantity) {
            $sql = "SELECT id, nama_produk, harga, gambar FROM products WHERE id = ?";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $product = mysqli_fetch_assoc($result);
                $cart_items[] = [
                    'cart_item_id' => null, // Tidak ada ID item keranjang di sesi
                    'product_id' => $product['id'],
                    'nama_produk' => $product['nama_produk'],
                    'harga' => $product['harga'],
                    'gambar' => $product['gambar'],
                    'quantity' => $quantity
                ];
                $total_harga_keranjang += $quantity * $product['harga'];
            }
            mysqli_stmt_close($stmt);
        }
    }
}

// --- Logika Update/Hapus Item Keranjang (POST) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $product_id_action = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
        $quantity_action = filter_var($_POST['quantity'] ?? 1, FILTER_VALIDATE_INT); // Default 1 jika tidak ada

        if ($product_id_action === false) {
            header("Location: keranjang.php?status=error_input");
            exit();
        }

        if ($user_id) {
            // Logika untuk Pengguna Login (Database)
            if ($action == 'update_quantity') {
                if ($quantity_action <= 0) { // Hapus jika kuantitas 0 atau kurang
                    $sql_delete = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
                    $stmt_delete = mysqli_prepare($koneksi, $sql_delete);
                    mysqli_stmt_bind_param($stmt_delete, "ii", $user_id, $product_id_action);
                    mysqli_stmt_execute($stmt_delete);
                    mysqli_stmt_close($stmt_delete);
                    header("Location: keranjang.php?status=hapus_sukses");
                    exit();
                } else {
                    $sql_update = "UPDATE cart_items SET quantity = ?, updated_at = CURRENT_TIMESTAMP() WHERE user_id = ? AND product_id = ?";
                    $stmt_update = mysqli_prepare($koneksi, $sql_update);
                    mysqli_stmt_bind_param($stmt_update, "iii", $quantity_action, $user_id, $product_id_action);
                    mysqli_stmt_execute($stmt_update);
                    mysqli_stmt_close($stmt_update);
                    header("Location: keranjang.php?status=update_sukses");
                    exit();
                }
            } elseif ($action == 'remove_item') {
                $sql_delete = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
                $stmt_delete = mysqli_prepare($koneksi, $sql_delete);
                mysqli_stmt_bind_param($stmt_delete, "ii", $user_id, $product_id_action);
                mysqli_stmt_execute($stmt_delete);
                mysqli_stmt_close($stmt_delete);
                header("Location: keranjang.php?status=hapus_sukses");
                exit();
            }
        } else {
            // Logika untuk Pengguna Tamu (Sesi)
            if ($action == 'update_quantity') {
                if ($quantity_action <= 0) {
                    unset($_SESSION['keranjang'][$product_id_action]);
                    header("Location: keranjang.php?status=hapus_sukses");
                    exit();
                } else {
                    $_SESSION['keranjang'][$product_id_action] = $quantity_action;
                    header("Location: keranjang.php?status=update_sukses");
                    exit();
                }
            } elseif ($action == 'remove_item') {
                unset($_SESSION['keranjang'][$product_id_action]);
                header("Location: keranjang.php?status=hapus_sukses");
                exit();
            }
        }
    }
}
mysqli_close($koneksi); // Tutup koneksi setelah semua operasi database selesai
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            overflow: hidden;
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
        .product-image-cart {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .cart-summary {
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        .btn-action {
            border-radius: 5px;
        }
        .btn-checkout {
            border-radius: 8px;
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
            <a class="navbar-brand" href="index.php">Toko Online Saya</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="keranjang.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Halo, <?php echo htmlspecialchars($_SESSION['user_nama']); ?>
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

    <div class="container">
        <h2 class="mb-4">Keranjang Belanja Anda</h2>
        <?php echo $pesan_status; ?>

        <?php if (empty($cart_items)): ?>
            <div class="alert alert-info text-center" role="alert">
                Keranjang belanja Anda kosong. <a href="index.php">Mulai belanja sekarang!</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td>
                                    <?php 
                                        $gambar_path = "images/" . htmlspecialchars($item['gambar']);
                                        if (empty($item['gambar']) || !file_exists($gambar_path)) {
                                            $gambar_path = "https://placehold.co/80x80/cccccc/333333?text=No+Image";
                                        }
                                    ?>
                                    <img src="<?php echo $gambar_path; ?>" alt="<?php echo htmlspecialchars($item['nama_produk']); ?>" class="product-image-cart" onerror="this.onerror=null;this.src='https://placehold.co/80x80/cccccc/333333?text=No+Image';">
                                </td>
                                <td><?php echo htmlspecialchars($item['nama_produk']); ?></td>
                                <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <form action="keranjang.php" method="POST" class="d-flex align-items-center">
                                        <input type="hidden" name="action" value="update_quantity">
                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                        <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                                        <button type="submit" class="btn btn-info btn-sm btn-action" title="Perbarui Kuantitas"><i class="fas fa-sync-alt"></i></button>
                                    </form>
                                </td>
                                <td>Rp <?php echo number_format($item['quantity'] * $item['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <form action="keranjang.php" method="POST">
                                        <input type="hidden" name="action" value="remove_item">
                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm btn-action" title="Hapus Item"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-md-4">
                    <div class="cart-summary">
                        <h4>Ringkasan Total Belanja</h4>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total Harga:</strong>
                            <span>Rp <?php echo number_format($total_harga_keranjang, 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-checkout">Lanjutkan ke Pembayaran</button>
                            <a href="index.php" class="btn btn-outline-secondary mt-2">Lanjutkan Belanja</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Toko Online Saya. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>