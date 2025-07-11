-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2025 at 11:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `kategori` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_produk`, `deskripsi`, `harga`, `stok`, `kategori`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Laptop ASUS ROG Zephyrus', 'Laptop gaming dengan processor Intel i7-11800H dan GPU RTX 3060', 18999000, 15, 'Elektronik', 'laptop_asus_rog.jpg', '2025-07-11 08:43:17', '2025-07-11 08:43:17'),
(2, 'Smartphone Samsung Galaxy S23', 'Smartphone flagship dengan kamera 50MP dan baterai 3900mAh', 14999000, 25, 'Elektronik', 'samsung_s23.jpg', '2025-07-11 08:43:17', '2025-07-11 08:43:17'),
(3, 'Kamera Canon EOS R6', 'Kamera mirrorless full-frame dengan sensor 20.1MP', 32999000, 8, 'Elektronik', 'canon_eos_r6.jpg', '2025-07-11 08:43:17', '2025-07-11 08:43:17'),
(4, 'Headphone Sony WH-1000XM5', 'Headphone wireless dengan noise cancellation premium', 4999000, 30, 'Aksesoris', 'sony_wh1000xm5.jpg', '2025-07-11 08:43:17', '2025-07-11 08:43:17'),
(5, 'Smartwatch Apple Watch Series 8', 'Smartwatch dengan ECG, monitor suhu tubuh, dan GPS', 8999000, 12, 'Aksesoris', 'apple_watch_8.jpg', '2025-07-11 08:43:17', '2025-07-11 08:43:17'),
(6, 'Power Bank Anker 20.000mAh', 'Power bank cepat dengan kapasitas besar dan dual port', 899000, 50, 'Aksesoris', 'anker_powerbank.jpg', '2025-07-11 08:43:17', '2025-07-11 08:43:17'),
(7, 'Meja Gaming Eureka Ergonomic', 'Meja gaming ergonomis dengan tinggi adjustable', 2499000, 10, 'Perabotan', 'meja_gaming_eureka.jpg', '2025-07-11 08:43:17', '2025-07-11 08:43:17'),
(8, 'Kursi Secretlab Titan EVO', 'Kursi gaming premium dengan material kulit sintetis', 6999000, 80, 'Perabotan', 'secretlab_titan.jpg', '2025-07-11 08:43:17', '2025-07-11 09:12:26'),
(9, 'Rak Buku Minimalis Oak', 'Rak buku kayu oak dengan desain minimalis', 1299000, 20, 'Perabotan', 'rak_buku_oak.jpg', '2025-07-11 08:43:17', '2025-07-11 08:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
