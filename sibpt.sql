-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 01:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sibpt`
--

-- --------------------------------------------------------

--
-- Table structure for table `luas_tb`
--

CREATE TABLE `luas_tb` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `luas_area` int(11) DEFAULT NULL,
  `jumlah_batang` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `luas_tb`
--

INSERT INTO `luas_tb` (`id`, `luas_area`, `jumlah_batang`, `status`, `created_at`, `updated_at`) VALUES
(1, 175, 400, 'm2', NULL, NULL),
(2, 180, 420, 'm2', NULL, NULL),
(3, 200, 460, 'm2', NULL, NULL),
(4, 250, 680, 'm2', NULL, NULL),
(5, 300, 700, 'm2', NULL, NULL),
(6, 350, 800, 'm2', NULL, NULL),
(7, 400, 820, 'm2', NULL, NULL),
(8, 450, 1040, 'm2', NULL, NULL),
(9, 500, 1150, 'm2', NULL, NULL),
(10, 550, 1265, 'm2', NULL, NULL),
(11, 600, 1480, 'm2', NULL, NULL),
(12, 650, 1495, 'm2', NULL, NULL),
(13, 700, 1600, 'm2', NULL, NULL),
(14, 750, 1750, 'm2', NULL, NULL),
(15, 800, 1835, 'm2', NULL, NULL),
(16, 850, 1950, 'm2', NULL, NULL),
(17, 900, 2065, 'm2', NULL, NULL),
(18, 950, 2180, 'm2', NULL, NULL),
(19, 1000, 2295, 'm2', NULL, NULL),
(20, 1180, 2410, 'm2', NULL, NULL),
(21, 1200, 2520, 'm2', NULL, NULL),
(22, 1250, 2635, 'm2', NULL, NULL),
(23, 1300, 2750, 'm2', NULL, NULL),
(24, 1350, 2865, 'm2', NULL, NULL),
(25, 1, 3200, 'hektar', NULL, NULL),
(26, 2, 6400, 'hektar', NULL, NULL),
(27, 3, 9600, 'hektar', NULL, NULL),
(28, 4, 12800, 'hektar', NULL, NULL),
(29, 5, 16000, 'hektar', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2024_06_11_125150_create_luas_tb', 1),
(8, '2024_06_12_102724_tb_produkborong', 2),
(9, '2024_06_14_161722_create_tb_transaksi_borong_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_alamat`
--

CREATE TABLE `tb_alamat` (
  `id_alamat` int(11) NOT NULL,
  `id_provinsi` int(11) DEFAULT NULL,
  `id_kota` int(11) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_alamatpengiriman`
--

CREATE TABLE `tb_alamatpengiriman` (
  `alamatpengiriman_id` int(11) NOT NULL,
  `alamatpengiriman_user_id` varchar(255) DEFAULT NULL,
  `alamatpengiriman_kecamatan_id` varchar(255) DEFAULT NULL,
  `alamatpengiriman_alamat` varchar(255) DEFAULT NULL,
  `alamatpengiriman_deskripsi` varchar(255) DEFAULT NULL,
  `alamatpengiriman_created` varchar(255) DEFAULT NULL,
  `alamatpengiriman_updated` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_alamatpengiriman`
--

INSERT INTO `tb_alamatpengiriman` (`alamatpengiriman_id`, `alamatpengiriman_user_id`, `alamatpengiriman_kecamatan_id`, `alamatpengiriman_alamat`, `alamatpengiriman_deskripsi`, `alamatpengiriman_created`, `alamatpengiriman_updated`) VALUES
(6, '12', '22', 'Dsn.Gondang', 'Jl.welirang Ds.Tanjung', '2024-06-06 08:23:19', NULL),
(7, '15', '1', 'Dsn.Gondang', 'Jl.welirang Ds.Tanjung', '2024-06-07 11:04:08', NULL),
(8, '16', '6', 'Dsn.Gondang', 'Jl.welirang Ds.Tanjung', '2024-06-07 11:52:45', NULL),
(9, '17', '1', 'Dsn.Gondang', 'Jl.welirang Ds.Gondang', '2024-06-07 12:10:38', NULL),
(10, '11', '4', '1wwe', '1wwd', '2024-06-09 20:36:44', NULL),
(11, '18', '2', '1wwe', NULL, '2024-06-09 20:43:22', NULL),
(12, '19', '6', '1wwe', '12121', '2024-06-10 11:50:04', '2024-06-14 13:33:33'),
(16, '20', '1', '2', '12121', '2024-06-10 22:09:12', NULL),
(17, '21', '2', '2', 'esgtrfhtj', '2024-06-19 21:52:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kecamatan`
--

CREATE TABLE `tb_kecamatan` (
  `kecamatan_id` int(11) NOT NULL,
  `kecamatan_name` varchar(255) DEFAULT NULL,
  `kecamatan_created` varchar(255) DEFAULT NULL,
  `kecamatan_updated` varchar(255) DEFAULT NULL,
  `ongkir` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_kecamatan`
--

INSERT INTO `tb_kecamatan` (`kecamatan_id`, `kecamatan_name`, `kecamatan_created`, `kecamatan_updated`, `ongkir`) VALUES
(1, 'Bagor', NULL, NULL, 150000),
(2, 'Baron', NULL, NULL, 150000),
(3, 'Berbek', NULL, NULL, 150000),
(4, 'Gondang', NULL, NULL, 150000),
(5, 'Jatikalen', NULL, NULL, 150000),
(6, 'Kertosono', NULL, NULL, 100000),
(7, 'Lengkong', NULL, NULL, 150000),
(8, 'Loceret', NULL, NULL, 150000),
(9, 'Nganjuk', NULL, NULL, 150000),
(10, 'Ngetos', NULL, NULL, 150000),
(11, 'Ngluyu', NULL, NULL, 150000),
(12, 'Ngronggot', NULL, NULL, 150000),
(24, 'semampir', '2024-06-15 21:22:41', '2024-06-15 21:22:41', 121),
(26, 'balowerti', '2024-06-18 18:36:40', '2024-06-18 18:36:40', 121);

-- --------------------------------------------------------

--
-- Table structure for table `tb_keranjang`
--

CREATE TABLE `tb_keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `keranjang_id_produk` varchar(255) DEFAULT NULL,
  `keranjang_id_user` varchar(255) DEFAULT NULL,
  `qty_keranjang` varchar(255) DEFAULT NULL,
  `pengiriman_keranjang` varchar(255) DEFAULT NULL,
  `price_keranjang` varchar(255) DEFAULT NULL,
  `created_keranjang` varchar(255) DEFAULT NULL,
  `detail_rumah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_keranjang`
--

INSERT INTO `tb_keranjang` (`id_keranjang`, `keranjang_id_produk`, `keranjang_id_user`, `qty_keranjang`, `pengiriman_keranjang`, `price_keranjang`, `created_keranjang`, `detail_rumah`) VALUES
(16, '58', '12', '200', '21', '80000', '2024-06-06 09:16:31', ''),
(17, '58', '12', '150', '21', '60000', '2024-06-06 09:19:43', ''),
(20, '61', '12', '110', '21', '38500', '2024-06-06 15:22:35', ''),
(25, '61', '12', '120', '22', '42000', '2024-06-06 19:09:03', ''),
(26, '62', '12', '100', '21', '35000', '2024-06-07 02:23:46', ''),
(27, '62', '12', '100', '21', '35000', '2024-06-07 02:24:04', ''),
(28, '60', '12', '100', '21', '60000', '2024-06-07 02:24:45', ''),
(30, '60', '12', '110', NULL, '66000', '2024-06-07 02:45:19', ''),
(32, '60', '15', '110', NULL, '66000', '2024-06-07 11:11:27', ''),
(33, '61', '15', '123', '1', '43050', '2024-06-07 11:15:24', ''),
(34, '60', '12', '230', NULL, '138000', '2024-06-07 11:30:46', ''),
(36, '66', '16', '123', '21', '43050', '2024-06-07 11:56:05', ''),
(38, '65', '16', '123', '6', '49200', '2024-06-07 12:05:11', ''),
(40, '65', '17', '123', '1', '49200', '2024-06-07 12:12:25', ''),
(47, '65', '20', '350', '21', '140000', '2024-06-10 22:33:38', ''),
(48, '65', '20', '350', NULL, '140000', '2024-06-10 22:36:42', ''),
(49, '65', '20', '350', NULL, '140000', '2024-06-10 22:36:46', ''),
(50, '65', '20', '350', NULL, '140000', '2024-06-10 22:38:03', ''),
(51, '65', '20', NULL, NULL, '0', '2024-06-10 23:22:06', ''),
(52, '65', '20', '222', NULL, '88800', '2024-06-10 23:24:10', ''),
(53, '65', '20', '2', NULL, '800', '2024-06-10 23:26:26', ''),
(57, '74', '20', '2', NULL, '424242', '2024-06-11 00:04:59', ''),
(58, '74', '20', '2', NULL, '424242', '2024-06-11 00:09:01', ''),
(60, '74', '20', '1', NULL, '212121', '2024-06-11 00:14:03', ''),
(65, '73', '20', '12', NULL, '144', '2024-06-11 00:35:23', ''),
(68, '73', '20', '1', '0', '12', '2024-06-11 22:19:18', ''),
(148, '63', '19', '12', '10', '154200', '2024-06-26 11:34:51', '45678'),
(149, '63', '19', '1', '12', '150350', '2024-06-26 11:36:10', '123');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kuantitas`
--

CREATE TABLE `tb_kuantitas` (
  `kuantitas_id` int(11) NOT NULL,
  `kuantitas_id_produk` varchar(255) DEFAULT NULL,
  `kuantitas_luaslahan` varchar(255) DEFAULT NULL,
  `kuantitas_jumlahbatang` varchar(255) DEFAULT NULL,
  `kuantitas_created` varchar(255) DEFAULT NULL,
  `kuantitas_updated` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_metodepembayaran`
--

CREATE TABLE `tb_metodepembayaran` (
  `metodepembayaran_id` int(11) NOT NULL,
  `metodepembayaran_name` varchar(255) DEFAULT NULL,
  `metodepembayaran_bank` varchar(255) DEFAULT NULL,
  `metodepembayaran_numberbank` varchar(255) DEFAULT NULL,
  `metodepembayaran_created` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_metodepembayaran`
--

INSERT INTO `tb_metodepembayaran` (`metodepembayaran_id`, `metodepembayaran_name`, `metodepembayaran_bank`, `metodepembayaran_numberbank`, `metodepembayaran_created`) VALUES
(4, 'Alvia Sikha', 'BRI', '351098827', '2024-06-06 08:07:40'),
(5, 'Sena', 'BCA', '149187489', '2024-06-06 18:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ongkir`
--

CREATE TABLE `tb_ongkir` (
  `ongkir_id` int(11) NOT NULL,
  `ongkir_fromlocation` varchar(255) DEFAULT NULL,
  `ongkir_tolocation` varchar(255) DEFAULT NULL,
  `ongkir_price` varchar(255) DEFAULT NULL,
  `ongkir_created` varchar(255) DEFAULT NULL,
  `ongkir_updated` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_ongkir`
--

INSERT INTO `tb_ongkir` (`ongkir_id`, `ongkir_fromlocation`, `ongkir_tolocation`, `ongkir_price`, `ongkir_created`, `ongkir_updated`) VALUES
(4, 'Kertosono', 'Lengkong', '100.000', '2024-06-06 08:09:12', '2024-06-06 08:09:12'),
(5, 'Kertosono', 'Ngronggot', '150.000', '2024-06-06 12:52:27', '2024-06-06 12:52:27'),
(6, 'Kertosono', 'Bagor', '150.000', '2024-06-07 02:14:54', '2024-06-07 02:14:54'),
(10, 'Kertosono', 'Nganjuk', '1101001', '2024-06-12 17:43:06', '2024-06-12 17:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengiriman`
--

CREATE TABLE `tb_pengiriman` (
  `id_pengiriman` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_alamat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_perkembangan`
--

CREATE TABLE `tb_perkembangan` (
  `id_pbk` int(11) NOT NULL,
  `perkembangan_kode_transaksi` varchar(255) DEFAULT NULL,
  `perkembangan_gambar` varchar(255) DEFAULT NULL,
  `perkembangan_umur` varchar(255) DEFAULT NULL,
  `perkembangan_tinggi` varchar(255) DEFAULT NULL,
  `perkembangan_deskripsi` mediumtext DEFAULT NULL,
  `perkembangan_created` varchar(255) DEFAULT NULL,
  `perkembangan_updated` varchar(255) DEFAULT NULL,
  `perkembangan_tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_perkembangan`
--

INSERT INTO `tb_perkembangan` (`id_pbk`, `perkembangan_kode_transaksi`, `perkembangan_gambar`, `perkembangan_umur`, `perkembangan_tinggi`, `perkembangan_deskripsi`, `perkembangan_created`, `perkembangan_updated`, `perkembangan_tanggal`) VALUES
(3, 'TRX_666c78f52b22c', '1718560186.jpeg', '12', '1.2', 'eweedkjewk', '2024-06-17 00:49:46', '2024-06-17 00:49:46', '2024-06-14'),
(4, 'TRX_666dbedc5e17f', '1718560209.jpeg', '12', '1.2', 'drctfvgbnijmko', '2024-06-17 00:50:09', '2024-06-17 00:50:09', '2024-06-07'),
(5, 'TRX_666c78ad34d47', '1718560313.jpeg', '2121', '21.2', '2weweqweqw', '2024-06-17 00:51:53', '2024-06-17 00:51:53', '2024-06-21'),
(6, 'TRX_666dbedc5e17f', '1718562013.jpeg', '13', '21.24', 'sasds', '2024-06-17 01:20:13', '2024-06-17 01:20:13', '2024-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pesan`
--

CREATE TABLE `tb_pesan` (
  `id_pesanan` int(11) NOT NULL,
  `nama_pesanan` varchar(255) DEFAULT NULL,
  `tgl_pesanan` varchar(255) DEFAULT NULL,
  `kuantitas` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` int(11) NOT NULL,
  `produk_id_user` varchar(255) DEFAULT NULL,
  `kode_bibit` varchar(255) DEFAULT NULL,
  `nama_bibit` varchar(255) DEFAULT NULL,
  `detail_bibit` mediumtext DEFAULT NULL,
  `harga_bibit` varchar(255) DEFAULT NULL,
  `stok_bibit` varchar(255) DEFAULT NULL,
  `gambar_bibit` varchar(255) DEFAULT NULL,
  `terjual_bibit` varchar(255) DEFAULT NULL,
  `status_bibit` varchar(255) DEFAULT NULL,
  `created_produk` varchar(255) DEFAULT NULL,
  `updated_produk` varchar(255) DEFAULT NULL,
  `harga_borong` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `produk_id_user`, `kode_bibit`, `nama_bibit`, `detail_bibit`, `harga_bibit`, `stok_bibit`, `gambar_bibit`, `terjual_bibit`, `status_bibit`, `created_produk`, `updated_produk`, `harga_borong`) VALUES
(63, '15', 'A001', 'Bibit Semangka', 'Semangka tanpa biji', '350', '188', '1719122193_8316.jpg', '166', '1', '2024-06-07 04:40:03', NULL, '350'),
(65, '15', 'A002', 'Bibit Cabai', 'Cabai Rawit Pedas', '400', '0', '1719122193_8316.jpg', '352', '1', '2024-06-07 04:43:49', NULL, '350'),
(66, '15', 'A003', 'Bibit Sawi', 'Sawi hijau daun lebar', '350', '300', '51981717735753.jpg', '3', '1', '2024-06-07 04:49:13', NULL, '350'),
(74, NULL, 'A005', 'Coba', 'anjir', '212121', '0', '48491717982700.png', '24', '1', '2024-06-10 01:25:00', NULL, '0'),
(75, NULL, 'A006', '111', '111', '1101001', '121', NULL, NULL, '1', '2024-06-15 15:20:57', NULL, '0'),
(76, NULL, 'A005', 'Coba', 'wwq', '212121', '20897', '48051718464882.jpg', '224', '1', '2024-06-15 15:21:22', NULL, '0'),
(77, NULL, 'A005', 'Coba', 'wwq', '212121', '21001', '89561718465323.jpg', '120', '1', '2024-06-15 15:28:43', NULL, '0'),
(79, NULL, 'A007', 'pelanggan', 'swdefrgtbhnj', '200', '12', '52801718713469.png', NULL, '1', '2024-06-18 12:24:29', NULL, '0'),
(85, '18', 'A008', 'ertyuio', 'gyfcygtfugfvhjghjgjhghghjjghjj', '121', '80', '70941718735109.jpg', '320', '1', '2024-06-26 04:08:57', NULL, '88'),
(86, '18', 'A001', 'bibit semangka', 'Tanaman kokoh serta bercabangan seragam serta sama besar, di rekomendasikan untuk berkebun di dataran rendah, tahan terhadap penyakit layu, bakteri dan fusarium, serta tahan kekurangan kalsium.', '300', '187', '1719122193_8316.jpg', '213', '1', '2024-06-24 17:15:24', NULL, '5000'),
(87, '18', 'A002', 'asdafds', 'dsfdsf', '300', '133', '1719122193_8316.jpg', '267', '1', '2024-06-18 18:32:57', NULL, '0'),
(88, '11', 'A003', 'cobadsddsdasdadadfsas', 'wdefghj', '12', '21122', '1719122193_8316.jpg', NULL, '1', '2024-06-23 05:56:33', NULL, '2121');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produkborong`
--

CREATE TABLE `tb_produkborong` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_produkborong`
--

INSERT INTO `tb_produkborong` (`id`, `name`, `harga`, `created_at`, `updated_at`, `gambar`) VALUES
(1, 'Brokoli', 250, NULL, NULL, 'clown-7286951_960_720.jpg'),
(2, 'Cabai Rawit', 350, NULL, NULL, NULL),
(3, 'Cabai Merah Besar', 350, NULL, NULL, NULL),
(4, 'Cabai Kriting', 350, NULL, NULL, NULL),
(5, 'Gambas', 250, NULL, NULL, NULL),
(6, 'Labu Air', 250, NULL, NULL, NULL),
(7, 'Labu Kuning', 250, NULL, NULL, NULL),
(8, 'Labu Waluh', 250, NULL, NULL, NULL),
(9, 'Labu Madu', 0, NULL, NULL, NULL),
(10, 'Tomat', 350, NULL, NULL, NULL),
(11, 'Terong Kecil', 250, NULL, NULL, NULL),
(12, 'Terong Ungu', 250, NULL, NULL, NULL),
(13, 'Terong Hijau', 250, NULL, NULL, NULL),
(14, 'Timun Suri', 250, NULL, NULL, NULL),
(15, 'Timun Lalap', 250, NULL, NULL, NULL),
(16, 'Melon Golden (Daging Putih)', 600, NULL, NULL, NULL),
(17, 'Melon Daging Putih', 600, NULL, NULL, NULL),
(18, 'Melon Jumbo Daging Oranye', 600, NULL, NULL, NULL),
(19, 'Sawi Putih', 250, NULL, NULL, NULL),
(20, 'Sawi Hijau', 250, NULL, NULL, NULL),
(21, 'Sawi Packcoy', 250, NULL, NULL, NULL),
(22, 'Sawi Manis/Caisim', 250, NULL, NULL, NULL),
(23, 'Semangka Tanpa Biji', 250, NULL, NULL, NULL),
(24, 'Semangka Merah', 250, NULL, NULL, NULL),
(25, 'Semangka Kuning', 250, NULL, NULL, NULL),
(26, 'Kacang Panjang', 250, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE `tb_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_status`
--

INSERT INTO `tb_status` (`status_id`, `status_name`) VALUES
(1, 'sudah dibayar'),
(2, 'sedang diproses'),
(3, 'sudah dikirim'),
(4, 'sudah diterima');

-- --------------------------------------------------------

--
-- Table structure for table `tb_statuspengiriman`
--

CREATE TABLE `tb_statuspengiriman` (
  `statuspengiriman_id` int(11) NOT NULL,
  `statuspengiriman_id_status` varchar(255) DEFAULT NULL,
  `statuspengiriman_kodetransaksi` varchar(255) DEFAULT NULL,
  `statuspengiriman_created` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_statuspengiriman`
--

INSERT INTO `tb_statuspengiriman` (`statuspengiriman_id`, `statuspengiriman_id_status`, `statuspengiriman_kodetransaksi`, `statuspengiriman_created`) VALUES
(24, '1', 'T2024060615', '2024-06-06 19:09:24'),
(25, '1', 'T2024060616', '2024-06-06 19:19:24'),
(26, '1', 'T2024060717', '2024-06-07 02:38:22'),
(27, '1', 'T2024060718', '2024-06-07 11:59:22'),
(28, '1', 'T2024060719', '2024-06-07 12:05:34'),
(29, '1', 'T2024061020', '2024-06-10 23:30:10'),
(30, '1', 'T2024061021', '2024-06-10 23:38:33'),
(31, '1', 'T2024061022', '2024-06-10 23:43:36'),
(32, '1', 'T2024061023', '2024-06-10 23:45:22'),
(33, '1', 'T2024061024', '2024-06-10 23:51:20'),
(34, '1', 'T2024061125', '2024-06-11 00:01:35'),
(35, '1', 'T2024061126', '2024-06-11 00:04:00'),
(36, '1', 'T2024061127', '2024-06-11 00:09:05'),
(37, '1', 'T2024061128', '2024-06-11 00:12:25'),
(38, '1', 'T2024061129', '2024-06-11 00:14:22'),
(39, '1', 'T2024061130', '2024-06-11 00:17:24'),
(40, '1', 'T2024061131', '2024-06-11 00:23:12'),
(41, '1', 'T2024061132', '2024-06-11 00:41:12'),
(42, '1', 'T2024061233', '2024-06-12 20:35:17'),
(43, '1', 'T2024061434', '2024-06-14 14:21:58'),
(44, '1', 'T2024061435', '2024-06-14 14:25:31'),
(45, '1', 'T2024061436', '2024-06-14 22:55:12'),
(46, '2', 'T2024061129', '2024-06-17 21:15:04'),
(47, '2', 'T2024061022', '2024-06-17 21:17:11'),
(48, '2', 'T2024061023', '2024-06-17 21:17:12'),
(49, '2', 'T2024061125', '2024-06-17 21:17:13'),
(50, '3', 'T2024061022', '2024-06-17 21:17:25'),
(51, '4', 'T2024061022', '2024-06-17 21:17:27'),
(52, '2', 'T2024061024', '2024-06-17 21:17:30'),
(53, '3', 'T2024061024', '2024-06-17 21:17:38'),
(54, '4', 'T2024061024', '2024-06-17 21:17:43'),
(55, '3', 'T2024061125', '2024-06-18 19:26:27'),
(56, '4', 'T2024061125', '2024-06-18 19:26:53'),
(57, '1', 'T2024061837', '2024-06-18 20:10:42'),
(58, '1', 'T2024061838', '2024-06-18 20:15:55'),
(59, '1', 'T2024061839', '2024-06-18 23:13:50'),
(60, '1', 'T2024061840', '2024-06-18 23:40:16'),
(61, '1', 'T2024061841', '2024-06-18 23:40:57'),
(62, '1', 'T2024061842', '2024-06-18 23:41:08'),
(63, '1', 'T2024061843', '2024-06-18 23:41:42'),
(64, '1', 'T2024061844', '2024-06-18 23:43:16'),
(65, '1', 'T2024061845', '2024-06-18 23:43:25'),
(66, '1', 'T2024061847', '2024-06-18 23:54:06'),
(67, '1', 'T2024061848', '2024-06-18 23:56:10'),
(68, '1', 'T2024061849', '2024-06-18 23:58:31'),
(69, '1', 'T2024061950', '2024-06-19 00:06:08'),
(70, '3', 'T2024061023', '2024-06-19 00:07:57'),
(71, '4', 'T2024061023', '2024-06-19 00:08:23'),
(72, '2', 'T2024061020', '2024-06-19 00:12:14'),
(73, '2', 'T2024061021', '2024-06-19 00:12:20'),
(74, '1', 'T2024061951', '2024-06-19 23:20:52'),
(75, '1', 'T2024061952', '2024-06-19 23:21:28'),
(76, '1', 'T2024061953', '2024-06-19 23:21:44'),
(77, '1', 'T2024061954', '2024-06-19 23:21:52'),
(78, '1', 'T202406191', '2024-06-19 23:23:24'),
(79, '1', 'T2024061956', '2024-06-19 23:25:13'),
(80, '1', 'T2024061957', '2024-06-19 23:25:33'),
(81, '1', 'T2024061958', '2024-06-19 23:26:32'),
(82, '1', 'T2024061959', '2024-06-19 23:37:23'),
(83, '1', 'T2024061960', '2024-06-19 23:37:28'),
(84, '1', 'T2024061961', '2024-06-19 23:50:37'),
(85, '1', 'T2024061962', '2024-06-19 23:57:17'),
(86, '1', 'T2024062063', '2024-06-20 00:00:07'),
(87, '1', 'T2024062064', '2024-06-20 00:19:17'),
(88, '1', 'T2024062065', '2024-06-20 00:21:24'),
(89, '1', 'T2024062066', '2024-06-20 00:22:23'),
(90, '1', 'T2024062067', '2024-06-20 00:23:15'),
(91, '2', 'T2024062067', '2024-06-20 00:50:17'),
(92, '2', 'T202406191', '2024-06-20 01:08:01'),
(93, '3', 'T2024062067', '2024-06-20 01:08:12'),
(94, '4', 'T2024062067', '2024-06-20 01:08:32'),
(95, '2', 'T2024062066', '2024-06-20 01:22:51'),
(96, '3', 'T2024062066', '2024-06-20 01:23:17'),
(97, '1', 'T2024062368', '2024-06-23 01:41:54'),
(98, '4', 'T202406191', '2024-06-25 21:25:13'),
(99, '4', 'T2024062368', '2024-06-25 21:25:49'),
(100, '4', 'T2024062066', '2024-06-25 22:40:07'),
(101, '2', 'T2024062065', '2024-06-26 11:29:26'),
(102, '3', 'T2024062065', '2024-06-26 11:29:31'),
(103, '4', 'T2024062065', '2024-06-26 11:35:46'),
(104, '2', '667b9ae4b835f', '2024-06-26 11:39:21'),
(105, '3', '667b9ae4b835f', '2024-06-26 11:39:24'),
(106, '4', '667b9ae4b835f', '2024-06-26 11:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `tb_stok`
--

CREATE TABLE `tb_stok` (
  `id_bibit` int(11) NOT NULL,
  `stok_kode_barang` varchar(255) DEFAULT NULL,
  `stok_jumlah` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `nama_bibit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_stok`
--

INSERT INTO `tb_stok` (`id_bibit`, `stok_kode_barang`, `stok_jumlah`, `created_at`, `updated_at`, `nama_bibit`) VALUES
(30, 'A001', '520', '2024-06-06 01:08:13', '2024-06-18 18:26:11', 'bibit semangkabibit semangka'),
(35, 'A001', '520', '2024-06-07 04:40:03', '2024-06-18 18:26:11', 'bibit semangkabibit semangka'),
(37, 'A002', '400', '2024-06-18 18:32:57', '2024-06-18 18:32:57', 'asdafds'),
(38, 'A003', '21122', '2024-06-23 05:56:33', '2024-06-23 05:56:33', 'cobadsddsdasdadadfsas'),
(41, 'A005', '142333', '2024-06-10 01:25:00', '2024-06-15 15:28:43', 'CobaCoba'),
(42, 'A006', '-21000', '2024-06-15 15:20:57', '2024-06-18 18:19:12', '111'),
(43, 'A006', '-21000', '2024-06-15 18:20:58', '2024-06-18 18:19:12', '111'),
(44, 'A007', '-109', '2024-06-18 12:24:29', '2024-06-18 18:19:13', 'tahu lonntong'),
(45, 'A007', '-109', '2024-06-18 15:46:17', '2024-06-18 18:19:13', 'tahu lonntong'),
(46, 'A002', '349', '2024-06-18 18:21:37', '2024-06-18 18:21:43', 'naila'),
(47, 'A008', '400', '2024-06-18 18:25:09', NULL, 'ertyuio');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user_transaksi` varchar(255) DEFAULT NULL,
  `kode_transaksi` varchar(255) DEFAULT NULL,
  `total_transaksi` varchar(255) DEFAULT NULL,
  `status_transaksi` varchar(255) DEFAULT NULL,
  `created_transaksi` varchar(255) DEFAULT NULL,
  `bukti_transfer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_transaksi`, `id_user_transaksi`, `kode_transaksi`, `total_transaksi`, `status_transaksi`, `created_transaksi`, `bukti_transfer`) VALUES
(55, '19', 'T202406191', '0', '4', '2024-06-25 21:25:13', NULL),
(56, '19', 'T2024061956', '0', '1', '2024-06-19 23:25:13', NULL),
(57, '19', 'T2024061957', '0', '1', '2024-06-19 23:25:33', NULL),
(58, '19', 'T2024061958', '0', '1', '2024-06-19 23:26:32', NULL),
(59, '19', 'T2024061959', '0', '1', '2024-06-19 23:37:23', NULL),
(60, '19', 'T2024061960', '0', '1', '2024-06-19 23:37:28', NULL),
(61, '19', 'T2024061961', '0', '1', '2024-06-19 23:50:37', NULL),
(62, '19', 'T2024061962', '0', '1', '2024-06-19 23:57:17', NULL),
(63, '19', 'T2024062063', '0', '1', '2024-06-20 00:00:07', NULL),
(64, '19', 'T2024062064', '0', '1', '2024-06-20 00:19:17', 'bukti_transfer/HMVgFSfKO4IFoDMK6mpv5mtjFvNpxd8w1GfRmj4v.png'),
(65, '19', 'T2024062065', '0', '4', '2024-06-26 11:35:46', 'bukti_transfer/9QJJ9H7TssVxSgZDhnFLhz9wPDfNAV6Amfco9HI8.jpg'),
(66, '19', 'T2024062066', '1452', '4', '2024-06-25 22:40:07', 'bukti_transfer/l9nc5GycwauXieRKcc6UOPIhCn578wdUi9192xpJ.jpg'),
(67, '19', 'T2024062067', '4454541', '4', '2024-06-20 01:08:32', 'bukti_transfer/C6E3cU58OV20VdOUL5GvlYImjC084PQ7zaS35ZLM.jpg'),
(68, '19', 'T2024062368', '4966662', '4', '2024-06-25 21:25:49', 'bukti_transfer/8Dds3GQEJd0FqR6BkiH1XEC8gwzpdahvS6Uo3REi.jpg'),
(69, '19', '667838911ed8e', NULL, '1', '2024-06-23 15:00:33', '/path/to/bukti_transfer'),
(70, '19', '66783912be78a', NULL, '1', '2024-06-23 15:02:42', '/path/to/bukti_transfer2'),
(71, '19', '667b99f22b6db', '303600', '1', '2024-06-26 04:32:50', '/path/to/bukti_transfer2'),
(72, '19', '667b9a94c10e4', '304200', '1', '2024-06-26 04:35:32', '/path/to/bukti_transfer2'),
(73, '19', '667b9ae4b835f', '604550', '4', '2024-06-26 11:39:59', '/path/to/bukti_transfer2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_borong`
--

CREATE TABLE `tb_transaksi_borong` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user_transaksi` bigint(20) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `nama_bibit` varchar(255) NOT NULL,
  `tanggal_tanam` date NOT NULL,
  `luas_lahan` varchar(255) NOT NULL,
  `kuantitas_bibit` varchar(255) NOT NULL,
  `total_transaksi` decimal(10,2) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `pengiriman` bigint(20) UNSIGNED NOT NULL,
  `metodepembayaran` bigint(20) UNSIGNED NOT NULL,
  `status_transaksi` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `detail_rumah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_transaksi_borong`
--

INSERT INTO `tb_transaksi_borong` (`id`, `id_user_transaksi`, `kode_transaksi`, `nama_bibit`, `tanggal_tanam`, `luas_lahan`, `kuantitas_bibit`, `total_transaksi`, `bukti_pembayaran`, `pengiriman`, `metodepembayaran`, `status_transaksi`, `created_at`, `updated_at`, `detail_rumah`) VALUES
(1, 19, 'TRX_666c78ad34d47', '3', '2024-06-12', '18', '2180', 763008.00, 'public/bukti_pembayaran/upoFVWczVsPPOWWlkR1mX1pEeRtpzyh6Lcpo0EPi.png', 8, 4, 2, '2024-06-14 10:06:53', '2024-06-26 04:04:48', ''),
(2, 19, 'TRX_666c78f52b22c', '5', '2024-06-12', '18', '2180', 545008.00, 'public/bukti_pembayaran/DtFN5RE4hhOgtpsFf3vBIFVYGKtBtZs6tOF8dSDC.png', 8, 4, 1, '2024-06-14 10:08:05', NULL, ''),
(3, 19, 'TRX_666dbedc5e17f', '4', '2024-06-29', '3', '460', 161002.00, 'public/bukti_pembayaran/RYUDMeGIdgqsdwegxHivKQaH2SeRyaKidAAPnmP6.png', 2, 5, 3, '2024-06-26 04:01:39', '2024-06-26 04:05:04', ''),
(4, 19, 'TRX_666f349191296', '3', '2024-06-30', '17', '2065', 722751.00, 'public/bukti_pembayaran/wVQAfkNiKC9ryPt7QR7QLrDZklYerUpYJxZucLsr.jpg', 1, 4, 4, '2024-06-30 11:53:05', '2024-06-26 04:05:21', ''),
(5, 19, 'TRX_666f35666fda6', '1', '2024-06-30', '19', '2295', 573752.00, 'public/bukti_pembayaran/4FhEWytHsEAmUEYLPFbzfU8ho7B4O0WWPrbT1yR4.png', 2, 4, 1, '2024-06-30 11:56:38', NULL, ''),
(6, 19, 'TRX_66718aee88535', '1', '2024-07-03', '2', '420', 105010.00, 'public/bukti_pembayaran/ESG9BrvsIEzL4gfyikaRUYqWPubgxqiJCfqMAKDe.jpg', 10, 4, 1, '2024-07-03 06:26:06', NULL, ''),
(7, 19, 'TRX_6677163b34540', '65', '2024-07-07', '266', '532', 186212.00, 'public/bukti_pembayaran/Q9zkT4qwRA5ncPV7eNte2ZFwgfbLNAEkZBrJXzzB.jpg', 12, 4, 1, '2024-07-08 01:21:47', NULL, 'Alamat: 1wwe\r\nDeskripsi: 12121\r\nKecamatan: Kertosono'),
(8, 19, '6677a52ccfdf3', '63', '2024-07-08', '266', '532', 186207.00, '/images/about.jpeg', 7, 2, 1, '2024-07-08 11:31:40', NULL, 'werty'),
(9, 19, '6677a57fddb44', '66', '2024-07-08', '1', '2', 704.00, '/images/about.jpeg', 4, 2, 1, '2024-07-08 11:33:03', NULL, '1234567'),
(10, 19, '6677a593ae06f', '66', '2024-07-08', '1', '2', 704.00, '/images/about.jpeg', 4, 2, 1, '2024-07-08 11:33:23', NULL, '1234567'),
(11, 19, '6677a5bdc6fa1', '65', '2024-07-08', '266', '532', 186209.00, '/images/about.jpeg', 9, 2, 1, '2024-07-08 11:34:05', NULL, 'qwertyuio'),
(12, 19, '6677a5f7c702f', '63', '2024-07-08', '266', '532', 186211.00, '/images/about.jpeg', 11, 2, 1, '2024-07-08 11:35:03', NULL, '21121'),
(13, 19, '6677a60761d6b', '63', '2024-07-08', '266', '532', 186211.00, '/images/about.jpeg', 11, 2, 1, '2024-07-08 11:35:19', NULL, '21121'),
(14, 19, '6677a695ef920', '63', '2024-07-08', '266', '532', 186208.00, '/images/about.jpeg', 8, 2, 1, '2024-07-08 11:37:41', NULL, '12345678'),
(15, 19, '6677a72dac1db', '86', '2024-07-08', '266', '532', 24.00, '/images/about.jpeg', 24, 2, 1, '2024-07-08 11:40:13', NULL, 'qwertyuio'),
(16, 19, '6677a72f47d6c', '86', '2024-07-08', '266', '532', 24.00, '/images/about.jpeg', 24, 2, 1, '2024-07-08 11:40:15', NULL, 'qwertyuio'),
(17, 19, '6677a7750525a', '65', '2024-07-08', '1', '2', 712.00, '/images/about.jpeg', 12, 2, 1, '2024-07-08 11:41:25', NULL, 'Alamat: 1wwe\r\nDeskripsi: 12121\r\nKecamatan: Kertosono'),
(18, 19, '6677a8b042049', '65', '2024-07-08', '2', '4', 1401.00, '/images/about.jpeg', 1, 2, 1, '2024-07-08 11:46:40', NULL, '123456'),
(19, 19, '6677b180932a0', '63', '2024-07-08', '266', '532', 186212.00, '/images/about.jpeg', 12, 2, 1, '2024-07-08 12:24:16', NULL, 'Alamat: 1wwe\r\nDeskripsi: 12121\r\nKecamatan: Kertosono'),
(20, 19, '6677b1d8bffe3', '63', '2024-07-08', '266', '532', 186212.00, '/images/about.jpeg', 12, 2, 1, '2024-07-08 12:25:44', NULL, 'Alamat: 1wwe\r\nDeskripsi: 12121\r\nKecamatan: Kertosono'),
(21, 19, '6677b1eeeb0ef', '65', '2024-07-08', '2', '4', 1411.00, '/images/about.jpeg', 11, 2, 1, '2024-07-08 12:26:06', NULL, '122121'),
(22, 19, '6677b278f043e', '63', '2024-07-08', '266', '532', 186209.00, '/images/about.jpeg', 9, 2, 1, '2024-07-08 12:28:24', NULL, '`123456789'),
(23, 19, '6677b36ced0b7', '63', '2024-07-08', '266', '532', 186212.00, '/images/about.jpeg', 12, 2, 1, '2024-07-08 12:32:28', NULL, 'Alamat: 1wwe\r\nDeskripsi: 12121\r\nKecamatan: Kertosono'),
(24, 19, '6677b387ad383', '63', '2024-07-08', '266', '532', 186212.00, '/images/about.jpeg', 12, 2, 1, '2024-07-08 12:32:55', NULL, 'Alamat: 1wwe\r\nDeskripsi: 12121\r\nKecamatan: Kertosono'),
(25, 19, '6677b39836025', '63', '2024-07-08', '266', '532', 186212.00, '/images/about.jpeg', 12, 2, 1, '2024-07-08 12:33:12', NULL, 'Alamat: 1wwe\r\nDeskripsi: 12121\r\nKecamatan: Kertosono'),
(26, 19, '6677b3bcdbfdd', '63', '2024-07-08', '266', '532', 186212.00, '/images/about.jpeg', 12, 2, 1, '2024-07-08 12:33:48', NULL, 'Alamat: 1wwe\r\nDeskripsi: 12121\r\nKecamatan: Kertosono'),
(27, 11, '6677d40b1fac3', '66', '2024-07-08', '266', '532', 186210.00, '/images/about.jpeg', 10, 2, 1, '2024-07-08 14:51:39', NULL, 'Alamat: 1wwe\r\nDeskripsi: 1wwd\r\nKecamatan: Gondang'),
(28, 19, '667824379e90f', '65', '2024-07-08', '266', '532', 186205.00, '/images/about.jpeg', 5, 2, 1, '2024-07-08 20:33:43', NULL, '3243243241343143141341341'),
(29, 19, '667826833ac80', '65', '2024-07-08', '266', '532', 186200.00, '/images/about.jpeg', 0, 2, 1, '2024-07-08 20:43:31', NULL, 'dffdfdffd'),
(30, 19, '667826c77fee7', '65', '2024-07-08', '266', '532', 186200.00, '/images/about.jpeg', 0, 2, 1, '2024-07-08 20:44:39', NULL, 'dffdfdffd'),
(31, 19, '667a96fbbcb3d', '65', '2024-07-10', '266', '532', 186211.00, '/images/about.jpeg', 11, 2, 1, '2024-07-10 03:07:55', NULL, '23456789'),
(32, 19, '667acc3d59e82', '63', '2024-07-10', '266', '532', 186224.00, '/images/about.jpeg', 24, 2, 1, '2024-07-10 06:55:09', NULL, '23'),
(33, 19, '667acd0a97ece', '65', '2024-07-10', '21', '42', 14712.00, '/images/about.jpeg', 12, 2, 1, '2024-07-10 06:58:34', NULL, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_keranjang`
--

CREATE TABLE `tb_transaksi_keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `kode_transaksi_keranjang` varchar(255) DEFAULT NULL,
  `keranjang_id_produk` varchar(255) DEFAULT NULL,
  `keranjang_id_user` varchar(255) DEFAULT NULL,
  `qty_keranjang` varchar(255) DEFAULT NULL,
  `pengiriman_keranjang` varchar(255) DEFAULT NULL,
  `price_keranjang` varchar(255) DEFAULT NULL,
  `created_keranjang` varchar(255) DEFAULT NULL,
  `detail_rumah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_transaksi_keranjang`
--

INSERT INTO `tb_transaksi_keranjang` (`id_keranjang`, `kode_transaksi_keranjang`, `keranjang_id_produk`, `keranjang_id_user`, `qty_keranjang`, `pengiriman_keranjang`, `price_keranjang`, `created_keranjang`, `detail_rumah`) VALUES
(39, 'T202406061', '58', '12', '200', '21', '80000', '2024-06-06 15:23:24', ''),
(40, 'T202406061', '58', '12', '150', '21', '60000', '2024-06-06 15:23:24', ''),
(41, 'T202406061', '58', '12', NULL, NULL, '0', '2024-06-06 15:23:24', ''),
(42, 'T202406061', '61', '12', '110', '21', '38500', '2024-06-06 15:23:24', ''),
(43, 'T202406061', '61', '12', '110', '22', '38500', '2024-06-06 15:23:24', ''),
(44, 'T2024060612', '58', '12', '200', '21', '80000', '2024-06-06 15:34:11', ''),
(45, 'T2024060612', '58', '12', '150', '21', '60000', '2024-06-06 15:34:11', ''),
(46, 'T2024060612', '58', '12', NULL, NULL, '0', '2024-06-06 15:34:11', ''),
(47, 'T2024060612', '61', '12', '110', '21', '38500', '2024-06-06 15:34:11', ''),
(48, 'T2024060612', '61', '12', '110', '22', '38500', '2024-06-06 15:34:11', ''),
(49, 'T2024060612', '61', '12', '111', '22', '38850', '2024-06-06 15:34:11', ''),
(50, 'T2024060613', '58', '12', '200', '21', '80000', '2024-06-06 19:03:07', ''),
(51, 'T2024060613', '58', '12', '150', '21', '60000', '2024-06-06 19:03:07', ''),
(52, 'T2024060613', '58', '12', NULL, NULL, '0', '2024-06-06 19:03:07', ''),
(53, 'T2024060613', '61', '12', '110', '21', '38500', '2024-06-06 19:03:07', ''),
(54, 'T2024060613', '61', '12', '110', '22', '38500', '2024-06-06 19:03:07', ''),
(55, 'T2024060614', '58', '12', '200', '21', '80000', '2024-06-06 19:07:37', ''),
(56, 'T2024060614', '58', '12', '150', '21', '60000', '2024-06-06 19:07:37', ''),
(57, 'T2024060614', '58', '12', NULL, NULL, '0', '2024-06-06 19:07:37', ''),
(58, 'T2024060614', '61', '12', '110', '21', '38500', '2024-06-06 19:07:37', ''),
(59, 'T2024060614', '61', '12', '110', '22', '38500', '2024-06-06 19:07:37', ''),
(60, 'T2024060615', '58', '12', '200', '21', '80000', '2024-06-06 19:09:24', ''),
(61, 'T2024060615', '58', '12', '150', '21', '60000', '2024-06-06 19:09:24', ''),
(62, 'T2024060615', '58', '12', NULL, NULL, '0', '2024-06-06 19:09:24', ''),
(63, 'T2024060615', '61', '12', '110', '21', '38500', '2024-06-06 19:09:24', ''),
(64, 'T2024060615', '61', '12', '120', '22', '42000', '2024-06-06 19:09:24', ''),
(65, 'T2024060616', '58', '12', '200', '21', '80000', '2024-06-06 19:19:24', ''),
(66, 'T2024060616', '58', '12', '150', '21', '60000', '2024-06-06 19:19:24', ''),
(67, 'T2024060616', '58', '12', NULL, NULL, '0', '2024-06-06 19:19:24', ''),
(68, 'T2024060616', '61', '12', '110', '21', '38500', '2024-06-06 19:19:24', ''),
(69, 'T2024060616', '61', '12', '120', '22', '42000', '2024-06-06 19:19:24', ''),
(70, 'T2024060717', '58', '12', '200', '21', '80000', '2024-06-07 02:38:22', ''),
(71, 'T2024060717', '58', '12', '150', '21', '60000', '2024-06-07 02:38:22', ''),
(72, 'T2024060717', '61', '12', '110', '21', '38500', '2024-06-07 02:38:22', ''),
(73, 'T2024060717', '61', '12', '120', '22', '42000', '2024-06-07 02:38:22', ''),
(74, 'T2024060717', '62', '12', '100', '21', '35000', '2024-06-07 02:38:22', ''),
(75, 'T2024060717', '62', '12', '100', '21', '35000', '2024-06-07 02:38:22', ''),
(76, 'T2024060717', '60', '12', '100', '21', '60000', '2024-06-07 02:38:22', ''),
(77, 'T2024060718', '66', '16', '123', '21', '43050', '2024-06-07 11:59:22', ''),
(78, 'T2024060718', '66', '16', '123', '6', '43050', '2024-06-07 11:59:22', ''),
(79, 'T2024060719', '66', '16', '123', '21', '43050', '2024-06-07 12:05:34', ''),
(80, 'T2024060719', '65', '16', '123', '6', '49200', '2024-06-07 12:05:34', ''),
(81, 'T2024061020', '65', '20', '350', '21', '140000', '2024-06-10 23:30:10', ''),
(82, 'T2024061020', '65', '20', '350', NULL, '140000', '2024-06-10 23:30:10', ''),
(83, 'T2024061020', '65', '20', '350', NULL, '140000', '2024-06-10 23:30:10', ''),
(84, 'T2024061020', '65', '20', '350', NULL, '140000', '2024-06-10 23:30:10', ''),
(85, 'T2024061020', '65', '20', NULL, NULL, '0', '2024-06-10 23:30:10', ''),
(86, 'T2024061020', '65', '20', '222', NULL, '88800', '2024-06-10 23:30:10', ''),
(87, 'T2024061020', '65', '20', '2', NULL, '800', '2024-06-10 23:30:10', ''),
(88, 'T2024061020', '65', '20', '22', '1', '8800', '2024-06-10 23:30:10', ''),
(89, 'T2024061021', '65', '20', '350', '21', '140000', '2024-06-10 23:38:33', ''),
(90, 'T2024061021', '65', '20', '350', NULL, '140000', '2024-06-10 23:38:33', ''),
(91, 'T2024061021', '65', '20', '350', NULL, '140000', '2024-06-10 23:38:33', ''),
(92, 'T2024061021', '65', '20', '350', NULL, '140000', '2024-06-10 23:38:33', ''),
(93, 'T2024061021', '65', '20', NULL, NULL, '0', '2024-06-10 23:38:33', ''),
(94, 'T2024061021', '65', '20', '222', NULL, '88800', '2024-06-10 23:38:33', ''),
(95, 'T2024061021', '65', '20', '2', NULL, '800', '2024-06-10 23:38:33', ''),
(96, 'T2024061021', '74', '20', '99', '1', '20999979', '2024-06-10 23:38:33', ''),
(97, 'T2024061022', '65', '20', '350', '21', '140000', '2024-06-10 23:43:36', ''),
(98, 'T2024061022', '65', '20', '350', NULL, '140000', '2024-06-10 23:43:36', ''),
(99, 'T2024061022', '65', '20', '350', NULL, '140000', '2024-06-10 23:43:36', ''),
(100, 'T2024061022', '65', '20', '350', NULL, '140000', '2024-06-10 23:43:36', ''),
(101, 'T2024061022', '65', '20', NULL, NULL, '0', '2024-06-10 23:43:36', ''),
(102, 'T2024061022', '65', '20', '222', NULL, '88800', '2024-06-10 23:43:36', ''),
(103, 'T2024061022', '65', '20', '2', NULL, '800', '2024-06-10 23:43:36', ''),
(104, 'T2024061022', '73', '20', '12', '1', '144', '2024-06-10 23:43:36', ''),
(105, 'T2024061023', '65', '20', '350', '21', '140000', '2024-06-10 23:45:22', ''),
(106, 'T2024061023', '65', '20', '350', NULL, '140000', '2024-06-10 23:45:22', ''),
(107, 'T2024061023', '65', '20', '350', NULL, '140000', '2024-06-10 23:45:22', ''),
(108, 'T2024061023', '65', '20', '350', NULL, '140000', '2024-06-10 23:45:22', ''),
(109, 'T2024061023', '65', '20', NULL, NULL, '0', '2024-06-10 23:45:22', ''),
(110, 'T2024061023', '65', '20', '222', NULL, '88800', '2024-06-10 23:45:22', ''),
(111, 'T2024061023', '65', '20', '2', NULL, '800', '2024-06-10 23:45:22', ''),
(112, 'T2024061023', '73', '20', '12', '1', '144', '2024-06-10 23:45:22', ''),
(113, 'T2024061024', '65', '20', '350', '21', '140000', '2024-06-10 23:51:20', ''),
(114, 'T2024061024', '65', '20', '350', NULL, '140000', '2024-06-10 23:51:20', ''),
(115, 'T2024061024', '65', '20', '350', NULL, '140000', '2024-06-10 23:51:20', ''),
(116, 'T2024061024', '65', '20', '350', NULL, '140000', '2024-06-10 23:51:20', ''),
(117, 'T2024061024', '65', '20', NULL, NULL, '0', '2024-06-10 23:51:20', ''),
(118, 'T2024061024', '65', '20', '222', NULL, '88800', '2024-06-10 23:51:20', ''),
(119, 'T2024061024', '65', '20', '2', NULL, '800', '2024-06-10 23:51:20', ''),
(120, 'T2024061024', '73', '20', '12', '1', '144', '2024-06-10 23:51:20', ''),
(121, 'T2024061125', '65', '20', '350', '21', '140000', '2024-06-11 00:01:35', ''),
(122, 'T2024061125', '65', '20', '350', NULL, '140000', '2024-06-11 00:01:35', ''),
(123, 'T2024061125', '65', '20', '350', NULL, '140000', '2024-06-11 00:01:35', ''),
(124, 'T2024061125', '65', '20', '350', NULL, '140000', '2024-06-11 00:01:35', ''),
(125, 'T2024061125', '65', '20', NULL, NULL, '0', '2024-06-11 00:01:35', ''),
(126, 'T2024061125', '65', '20', '222', NULL, '88800', '2024-06-11 00:01:35', ''),
(127, 'T2024061125', '65', '20', '2', NULL, '800', '2024-06-11 00:01:35', ''),
(128, 'T2024061125', '73', '20', '12', '1', '144', '2024-06-11 00:01:35', ''),
(129, 'T2024061126', '65', '20', '350', '21', '140000', '2024-06-11 00:04:00', ''),
(130, 'T2024061126', '65', '20', '350', NULL, '140000', '2024-06-11 00:04:00', ''),
(131, 'T2024061126', '65', '20', '350', NULL, '140000', '2024-06-11 00:04:00', ''),
(132, 'T2024061126', '65', '20', '350', NULL, '140000', '2024-06-11 00:04:00', ''),
(133, 'T2024061126', '65', '20', NULL, NULL, '0', '2024-06-11 00:04:00', ''),
(134, 'T2024061126', '65', '20', '222', NULL, '88800', '2024-06-11 00:04:00', ''),
(135, 'T2024061126', '65', '20', '2', NULL, '800', '2024-06-11 00:04:00', ''),
(136, 'T2024061126', '73', '20', '12', '1', '144', '2024-06-11 00:04:00', ''),
(137, 'T2024061127', '65', '20', '350', '21', '140000', '2024-06-11 00:09:05', ''),
(138, 'T2024061127', '65', '20', '350', NULL, '140000', '2024-06-11 00:09:05', ''),
(139, 'T2024061127', '65', '20', '350', NULL, '140000', '2024-06-11 00:09:05', ''),
(140, 'T2024061127', '65', '20', '350', NULL, '140000', '2024-06-11 00:09:05', ''),
(141, 'T2024061127', '65', '20', NULL, NULL, '0', '2024-06-11 00:09:05', ''),
(142, 'T2024061127', '65', '20', '222', NULL, '88800', '2024-06-11 00:09:05', ''),
(143, 'T2024061127', '65', '20', '2', NULL, '800', '2024-06-11 00:09:05', ''),
(144, 'T2024061127', '73', '20', '12', '1', '144', '2024-06-11 00:09:05', ''),
(145, 'T2024061127', '74', '20', '2', NULL, '424242', '2024-06-11 00:09:05', ''),
(146, 'T2024061127', '74', '20', '2', NULL, '424242', '2024-06-11 00:09:05', ''),
(147, 'T2024061128', '65', '20', '350', '21', '140000', '2024-06-11 00:12:25', ''),
(148, 'T2024061128', '65', '20', '350', NULL, '140000', '2024-06-11 00:12:25', ''),
(149, 'T2024061128', '65', '20', '350', NULL, '140000', '2024-06-11 00:12:25', ''),
(150, 'T2024061128', '65', '20', '350', NULL, '140000', '2024-06-11 00:12:25', ''),
(151, 'T2024061128', '65', '20', NULL, NULL, '0', '2024-06-11 00:12:25', ''),
(152, 'T2024061128', '65', '20', '222', NULL, '88800', '2024-06-11 00:12:25', ''),
(153, 'T2024061128', '65', '20', '2', NULL, '800', '2024-06-11 00:12:25', ''),
(154, 'T2024061128', '74', '20', '2', NULL, '424242', '2024-06-11 00:12:25', ''),
(155, 'T2024061128', '74', '20', '2', NULL, '424242', '2024-06-11 00:12:25', ''),
(156, 'T2024061128', '74', '20', '2', '1', '424242', '2024-06-11 00:12:25', ''),
(157, 'T2024061129', '65', '20', '350', '21', '140000', '2024-06-11 00:14:22', ''),
(158, 'T2024061129', '65', '20', '350', NULL, '140000', '2024-06-11 00:14:22', ''),
(159, 'T2024061129', '65', '20', '350', NULL, '140000', '2024-06-11 00:14:22', ''),
(160, 'T2024061129', '65', '20', '350', NULL, '140000', '2024-06-11 00:14:22', ''),
(161, 'T2024061129', '65', '20', NULL, NULL, '0', '2024-06-11 00:14:22', ''),
(162, 'T2024061129', '65', '20', '222', NULL, '88800', '2024-06-11 00:14:22', ''),
(163, 'T2024061129', '65', '20', '2', NULL, '800', '2024-06-11 00:14:22', ''),
(164, 'T2024061129', '74', '20', '2', NULL, '424242', '2024-06-11 00:14:22', ''),
(165, 'T2024061129', '74', '20', '2', NULL, '424242', '2024-06-11 00:14:22', ''),
(166, 'T2024061129', '74', '20', '1', NULL, '212121', '2024-06-11 00:14:22', ''),
(167, 'T2024061129', '74', '20', '3', '1', '636363', '2024-06-11 00:14:22', ''),
(168, 'T2024061130', '65', '20', '350', '21', '140000', '2024-06-11 00:17:24', ''),
(169, 'T2024061130', '65', '20', '350', NULL, '140000', '2024-06-11 00:17:24', ''),
(170, 'T2024061130', '65', '20', '350', NULL, '140000', '2024-06-11 00:17:24', ''),
(171, 'T2024061130', '65', '20', '350', NULL, '140000', '2024-06-11 00:17:24', ''),
(172, 'T2024061130', '65', '20', NULL, NULL, '0', '2024-06-11 00:17:24', ''),
(173, 'T2024061130', '65', '20', '222', NULL, '88800', '2024-06-11 00:17:24', ''),
(174, 'T2024061130', '65', '20', '2', NULL, '800', '2024-06-11 00:17:24', ''),
(175, 'T2024061130', '74', '20', '2', NULL, '424242', '2024-06-11 00:17:24', ''),
(176, 'T2024061130', '74', '20', '2', NULL, '424242', '2024-06-11 00:17:24', ''),
(177, 'T2024061130', '74', '20', '1', NULL, '212121', '2024-06-11 00:17:24', ''),
(178, 'T2024061130', '74', '20', '2', '1', '424242', '2024-06-11 00:17:24', ''),
(179, 'T2024061131', '65', '20', '350', '21', '140000', '2024-06-11 00:23:12', ''),
(180, 'T2024061131', '65', '20', '350', NULL, '140000', '2024-06-11 00:23:12', ''),
(181, 'T2024061131', '65', '20', '350', NULL, '140000', '2024-06-11 00:23:12', ''),
(182, 'T2024061131', '65', '20', '350', NULL, '140000', '2024-06-11 00:23:12', ''),
(183, 'T2024061131', '65', '20', NULL, NULL, '0', '2024-06-11 00:23:12', ''),
(184, 'T2024061131', '65', '20', '222', NULL, '88800', '2024-06-11 00:23:12', ''),
(185, 'T2024061131', '65', '20', '2', NULL, '800', '2024-06-11 00:23:12', ''),
(186, 'T2024061131', '74', '20', '2', NULL, '424242', '2024-06-11 00:23:12', ''),
(187, 'T2024061131', '74', '20', '2', NULL, '424242', '2024-06-11 00:23:12', ''),
(188, 'T2024061131', '74', '20', '1', NULL, '212121', '2024-06-11 00:23:12', ''),
(189, 'T2024061131', '73', '20', '12', '1', '144', '2024-06-11 00:23:12', ''),
(190, 'T2024061132', '65', '20', '350', '21', '140000', '2024-06-11 00:41:12', ''),
(191, 'T2024061132', '65', '20', '350', NULL, '140000', '2024-06-11 00:41:12', ''),
(192, 'T2024061132', '65', '20', '350', NULL, '140000', '2024-06-11 00:41:12', ''),
(193, 'T2024061132', '65', '20', '350', NULL, '140000', '2024-06-11 00:41:12', ''),
(194, 'T2024061132', '65', '20', NULL, NULL, '0', '2024-06-11 00:41:12', ''),
(195, 'T2024061132', '65', '20', '222', NULL, '88800', '2024-06-11 00:41:12', ''),
(196, 'T2024061132', '65', '20', '2', NULL, '800', '2024-06-11 00:41:12', ''),
(197, 'T2024061132', '74', '20', '2', NULL, '424242', '2024-06-11 00:41:12', ''),
(198, 'T2024061132', '74', '20', '2', NULL, '424242', '2024-06-11 00:41:12', ''),
(199, 'T2024061132', '74', '20', '1', NULL, '212121', '2024-06-11 00:41:12', ''),
(200, 'T2024061132', '73', '20', '12', NULL, '144', '2024-06-11 00:41:12', ''),
(201, 'T2024061132', '73', '20', '1', '1', '12', '2024-06-11 00:41:12', ''),
(202, 'T2024061233', '74', '19', '1', '2', '212121', '2024-06-12 20:35:17', ''),
(203, 'T2024061434', '73', '19', '1', NULL, '12', '2024-06-14 14:21:58', ''),
(204, 'T2024061435', '73', '19', '111', '0', '1332', '2024-06-14 14:25:31', ''),
(205, 'T2024061436', '73', '19', '111', '0', '1332', '2024-06-14 22:55:12', ''),
(206, 'T2024061436', '73', '19', '22', '0', '264', '2024-06-14 22:55:12', ''),
(207, 'T2024061837', '73', '19', '123', '6', '101476', '2024-06-18 20:10:42', ''),
(208, 'T2024061838', '73', '19', '123', '6', '101476', '2024-06-18 20:15:55', ''),
(209, 'T2024061839', '73', '19', '1', NULL, '12', '2024-06-18 23:13:50', ''),
(210, 'T2024061840', '73', '19', '1', '0', '12', '2024-06-18 23:40:16', ''),
(211, 'T2024061841', '73', '19', '15', '0', '180', '2024-06-18 23:40:57', ''),
(212, 'T2024061843', '73', '19', '15', '6', '100180', '2024-06-18 23:41:42', ''),
(213, 'T2024061847', '73', '19', '3', '6', '100036', '2024-06-18 23:54:06', ''),
(214, 'T2024061848', '73', '19', '6', '6', '100072', '2024-06-18 23:56:10', ''),
(215, 'T2024061849', '73', '19', '14', '6', '100168', '2024-06-18 23:58:31', ''),
(216, 'T2024061951', '73', '19', '14', '6', '100168', '2024-06-19 23:20:52', ''),
(217, 'T2024062066', '85', '19', '12', NULL, '1452', '2024-06-20 00:22:23', ''),
(218, 'T2024062067', '77', '19', '21', NULL, '4454541', '2024-06-20 00:23:15', ''),
(219, 'T2024062368', '77', '19', '22', '10', '4816662', '2024-06-23 01:41:54', ''),
(220, NULL, '63', '19', '22', '3', '157700', '2024-06-25 21:40:48', 'ertyu'),
(221, NULL, '63', '19', '45', '24', '15871', '2024-06-25 21:41:37', 'rtyhjukl'),
(222, NULL, '63', '19', '45', '24', '15871', '2024-06-25 21:41:45', 'rtyhjukl'),
(223, NULL, '63', '19', '1', '8', '150350', '2024-06-25 21:42:25', '21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `nomortelepon_user` varchar(255) DEFAULT NULL,
  `alamat_user` varchar(255) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL,
  `username_user` varchar(255) DEFAULT NULL,
  `password_user` varchar(255) DEFAULT NULL,
  `role_user` varchar(255) DEFAULT NULL,
  `status_user` varchar(255) DEFAULT NULL,
  `created_user` varchar(255) DEFAULT NULL,
  `updated_user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_user`, `nomortelepon_user`, `alamat_user`, `email_user`, `username_user`, `password_user`, `role_user`, `status_user`, `created_user`, `updated_user`) VALUES
(11, 'yudha', '111212121', 'asassa', 'wyudha104@gmail.com', 'yudha', '123', '2', '1', '2024-06-09 20:07:17', NULL),
(18, 'pemilik', '7638290', '1wwe', 'wyudha104@gmail.com', 'pemilik', '123', '3', '1', '2024-06-09 20:42:58', NULL),
(19, 'pelanggan', '7638290', '1wwe', 'wyudha104@gmail.com', 'pelanggan', '123', '4', '1', '2024-06-10 11:49:31', NULL),
(20, 'naila', '7638290', '1wwe', 'wyudha104@gmail.com', 'naila', '123', '1', '1', '2024-06-10 21:46:37', NULL),
(21, 'naila', '7638290', '2', 'wyudha104@gmail.com', 'pegawai', '123', '4', '1', '2024-06-18 18:37:37', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `luas_tb`
--
ALTER TABLE `luas_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tb_alamat`
--
ALTER TABLE `tb_alamat`
  ADD PRIMARY KEY (`id_alamat`);

--
-- Indexes for table `tb_alamatpengiriman`
--
ALTER TABLE `tb_alamatpengiriman`
  ADD PRIMARY KEY (`alamatpengiriman_id`);

--
-- Indexes for table `tb_kecamatan`
--
ALTER TABLE `tb_kecamatan`
  ADD PRIMARY KEY (`kecamatan_id`);

--
-- Indexes for table `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `tb_kuantitas`
--
ALTER TABLE `tb_kuantitas`
  ADD PRIMARY KEY (`kuantitas_id`);

--
-- Indexes for table `tb_metodepembayaran`
--
ALTER TABLE `tb_metodepembayaran`
  ADD PRIMARY KEY (`metodepembayaran_id`);

--
-- Indexes for table `tb_ongkir`
--
ALTER TABLE `tb_ongkir`
  ADD PRIMARY KEY (`ongkir_id`);

--
-- Indexes for table `tb_pengiriman`
--
ALTER TABLE `tb_pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`);

--
-- Indexes for table `tb_perkembangan`
--
ALTER TABLE `tb_perkembangan`
  ADD PRIMARY KEY (`id_pbk`);

--
-- Indexes for table `tb_pesan`
--
ALTER TABLE `tb_pesan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tb_produkborong`
--
ALTER TABLE `tb_produkborong`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tb_statuspengiriman`
--
ALTER TABLE `tb_statuspengiriman`
  ADD PRIMARY KEY (`statuspengiriman_id`);

--
-- Indexes for table `tb_stok`
--
ALTER TABLE `tb_stok`
  ADD PRIMARY KEY (`id_bibit`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tb_transaksi_borong`
--
ALTER TABLE `tb_transaksi_borong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_transaksi_borong_id_user_transaksi_foreign` (`id_user_transaksi`);

--
-- Indexes for table `tb_transaksi_keranjang`
--
ALTER TABLE `tb_transaksi_keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `luas_tb`
--
ALTER TABLE `luas_tb`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_alamat`
--
ALTER TABLE `tb_alamat`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_alamatpengiriman`
--
ALTER TABLE `tb_alamatpengiriman`
  MODIFY `alamatpengiriman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_kecamatan`
--
ALTER TABLE `tb_kecamatan`
  MODIFY `kecamatan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `tb_kuantitas`
--
ALTER TABLE `tb_kuantitas`
  MODIFY `kuantitas_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_metodepembayaran`
--
ALTER TABLE `tb_metodepembayaran`
  MODIFY `metodepembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_ongkir`
--
ALTER TABLE `tb_ongkir`
  MODIFY `ongkir_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_pengiriman`
--
ALTER TABLE `tb_pengiriman`
  MODIFY `id_pengiriman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_perkembangan`
--
ALTER TABLE `tb_perkembangan`
  MODIFY `id_pbk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_pesan`
--
ALTER TABLE `tb_pesan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `tb_produkborong`
--
ALTER TABLE `tb_produkborong`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_status`
--
ALTER TABLE `tb_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_statuspengiriman`
--
ALTER TABLE `tb_statuspengiriman`
  MODIFY `statuspengiriman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `tb_stok`
--
ALTER TABLE `tb_stok`
  MODIFY `id_bibit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tb_transaksi_borong`
--
ALTER TABLE `tb_transaksi_borong`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tb_transaksi_keranjang`
--
ALTER TABLE `tb_transaksi_keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_transaksi_borong`
--
ALTER TABLE `tb_transaksi_borong`
  ADD CONSTRAINT `tb_transaksi_borong_id_user_transaksi_foreign` FOREIGN KEY (`id_user_transaksi`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
