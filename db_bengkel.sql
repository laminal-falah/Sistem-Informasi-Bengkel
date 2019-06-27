-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 30 Bulan Mei 2019 pada 01.22
-- Versi server: 10.1.32-MariaDB
-- Versi PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bengkel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_buying`
--

CREATE TABLE `tb_buying` (
  `code_buying` varchar(50) COLLATE utf8_bin NOT NULL,
  `total` int(9) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_buying`
--

INSERT INTO `tb_buying` (`code_buying`, `total`, `created_at`) VALUES
('TRK/PEMBELIAN/23052019/001', 2625000, '2019-05-23 03:11:55'),
('TRK/PEMBELIAN/23052019/003', 15000000, '2019-05-23 03:43:27'),
('TRK/PEMBELIAN/23052019/004', 60000, '2019-05-23 03:52:57'),
('TRK/PEMBELIAN/24052019/001', 30000, '2019-05-24 12:47:03'),
('TRK/PEMBELIAN/24052019/002', 17500, '2019-05-24 12:48:50'),
('TRK/PEMBELIAN/24052019/003', 477000, '2019-05-24 16:37:59'),
('TRK/PEMBELIAN/24052019/004', 50000, '2019-05-24 16:42:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_buying_details`
--

CREATE TABLE `tb_buying_details` (
  `id_buying_detail` int(10) UNSIGNED NOT NULL,
  `code_buying` varchar(50) COLLATE utf8_bin NOT NULL,
  `code_item` varchar(50) COLLATE utf8_bin NOT NULL,
  `amount` int(3) UNSIGNED NOT NULL,
  `price` int(9) UNSIGNED NOT NULL,
  `subtotal` int(9) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_buying_details`
--

INSERT INTO `tb_buying_details` (`id_buying_detail`, `code_buying`, `code_item`, `amount`, `price`, `subtotal`) VALUES
(2, 'TRK/PEMBELIAN/23052019/001', 'ALT/TR/2019/00001', 5, 25000, 125000),
(3, 'TRK/PEMBELIAN/23052019/001', 'SMT/SD/2019/00002', 5, 500000, 2500000),
(7, 'TRK/PEMBELIAN/23052019/003', 'ALT/IA/2019/00001', 100, 50000, 5000000),
(8, 'TRK/PEMBELIAN/23052019/003', 'ALT/IA/2019/00002', 100, 50000, 5000000),
(9, 'TRK/PEMBELIAN/23052019/003', 'ALT/IA/2019/00003', 100, 50000, 5000000),
(10, 'TRK/PEMBELIAN/23052019/004', 'ALT/IB/2019/00001', 10, 1000, 10000),
(11, 'TRK/PEMBELIAN/23052019/004', 'SMB/IM/2019/00001', 10, 2000, 20000),
(12, 'TRK/PEMBELIAN/23052019/004', 'SMT/IM/2019/00001', 10, 3000, 30000),
(13, 'TRK/PEMBELIAN/24052019/001', 'ALT/IB/2019/00001', 10, 1000, 10000),
(14, 'TRK/PEMBELIAN/24052019/001', 'SMB/IM/2019/00001', 10, 2000, 20000),
(15, 'TRK/PEMBELIAN/24052019/002', 'ALT/IB/2019/00001', 5, 1000, 5000),
(16, 'TRK/PEMBELIAN/24052019/002', 'SMB/IM/2019/00001', 5, 2500, 12500),
(17, 'TRK/PEMBELIAN/24052019/003', 'ALT/O/2019/00002', 17, 5000, 85000),
(19, 'TRK/PEMBELIAN/24052019/004', 'ALT/O/2019/00002', 10, 5000, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_cart`
--

CREATE TABLE `tb_cart` (
  `id_cart` varchar(50) COLLATE utf8_bin NOT NULL,
  `id_user` varchar(50) COLLATE utf8_bin NOT NULL,
  `code_item` varchar(50) COLLATE utf8_bin NOT NULL,
  `amount` int(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_categories`
--

CREATE TABLE `tb_categories` (
  `code_category` varchar(5) COLLATE utf8_bin NOT NULL,
  `name_category` varchar(15) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_categories`
--

INSERT INTO `tb_categories` (`code_category`, `name_category`) VALUES
('alt', 'Alat'),
('smb', 'Sparepart Mobil'),
('smt', 'Sparepart Motor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_items`
--

CREATE TABLE `tb_items` (
  `code_item` varchar(50) COLLATE utf8_bin NOT NULL,
  `code_category` varchar(5) COLLATE utf8_bin NOT NULL,
  `id_unit` int(2) UNSIGNED NOT NULL,
  `name_item` varchar(50) COLLATE utf8_bin NOT NULL,
  `good_item` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `broken_item` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `lost_item` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `total_stock` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `price_sale` int(9) UNSIGNED NOT NULL DEFAULT '0',
  `price_buy` int(9) UNSIGNED NOT NULL DEFAULT '0',
  `cover` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'default.png',
  `status` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '1',
  `location` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_items`
--

INSERT INTO `tb_items` (`code_item`, `code_category`, `id_unit`, `name_item`, `good_item`, `broken_item`, `lost_item`, `total_stock`, `price_sale`, `price_buy`, `cover`, `status`, `location`, `description`, `created_at`, `updated_at`) VALUES
('ALT/IA/2019/00001', 'alt', 1, 'Item alat beli', 100, 5, 0, 105, 0, 50000, 'default.png', '1', '-', '-', '2019-05-23 03:43:27', '2019-05-23 03:43:27'),
('ALT/IA/2019/00002', 'alt', 1, 'Item alat beli', 95, 0, 5, 100, 0, 50000, 'default.png', '1', '-', '-', '2019-05-23 03:43:27', '2019-05-23 03:43:27'),
('ALT/IA/2019/00003', 'alt', 1, 'Item alat beli', 100, 0, 0, 100, 0, 50000, 'default.png', '1', '-', '-', '2019-05-23 03:43:27', '2019-05-23 03:43:27'),
('ALT/IB/2019/00001', 'alt', 1, 'Item beli alat', 23, 1, 1, 25, 0, 1000, 'default.png', '1', '-', '-', '2019-05-23 03:52:57', '2019-05-24 12:48:50'),
('ALT/M/2019/00001', 'alt', 2, 'Multitester', 100, 0, 0, 100, 0, 15000, '5ce5114c96d7a.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:07:24', '2019-05-22 09:07:24'),
('ALT/O/2019/00002', 'alt', 1, 'Obeng', 25, 1, 1, 27, 0, 5000, 'default.png', '1', '-', '-', '2019-05-24 16:37:59', '2019-05-24 16:42:39'),
('ALT/OM/2019/00001', 'alt', 2, 'Obeng Minus', 100, 0, 0, 100, 0, 5000, '5ce51183efd08.jpg', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:08:19', '2019-05-22 09:08:19'),
('ALT/OP/2019/00001', 'alt', 1, 'Obeng Plus', 100, 0, 0, 100, 0, 5000, '5ce5119cd6a4f.jpeg', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:08:44', '2019-05-22 09:08:44'),
('ALT/TR/2019/00001', 'alt', 1, 'Tang Ragum', 105, 0, 0, 105, 0, 25000, '5ce511bb6812a.jpg', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:09:15', '2019-05-23 03:11:55'),
('SMB/BM/2019/00001', 'smb', 2, 'Ban Mobil', 100, 0, 0, 100, 600000, 500000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:29:49', '2019-05-22 09:29:49'),
('SMB/BM/2019/00002', 'smb', 1, 'Busi Mobil', 100, 0, 0, 100, 30000, 20000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:30:20', '2019-05-22 09:30:20'),
('SMB/GB/2019/00001', 'smb', 2, 'Gardan Belakang', 100, 0, 0, 100, 2500000, 1000000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:33:47', '2019-05-22 09:33:47'),
('SMB/GD/2019/00001', 'smb', 2, 'Gardan Depan ', 100, 0, 0, 100, 1000000, 500000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:34:49', '2019-05-22 09:34:49'),
('SMB/IM/2019/00001', 'smb', 2, 'Item mobil', 0, 1, 1, 2, 5000, 2500, 'default.png', '1', '-', '-', '2019-05-23 03:52:57', '2019-05-24 12:48:50'),
('SMB/K/2019/00001', 'smb', 2, 'Kopling', 75, 0, 0, 75, 30000, 20000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:35:45', '2019-05-22 09:35:45'),
('SMB/LD/2019/00001', 'smb', 2, 'Lampu Depan Mobil', 100, 0, 0, 100, 150000, 120000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:31:56', '2019-05-22 09:31:56'),
('SMB/SD/2019/00001', 'smb', 1, 'Shock Depan', 100, 0, 0, 100, 1000000, 500000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:32:50', '2019-05-22 09:32:50'),
('SMT/BM/2019/00002', 'smt', 2, 'Busi Motor xadwr', 100, 0, 0, 100, 30000, 20000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:21:42', '2019-05-22 09:21:42'),
('SMT/BM/2019/00003', 'smt', 2, 'Ban Motor asdfasdf', 100, 0, 0, 100, 150000, 120000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:23:18', '2019-05-22 09:23:18'),
('SMT/IM/2019/00001', 'smt', 2, 'Item motor', 10, 0, 0, 10, 0, 3000, 'default.png', '1', '-', '-', '2019-05-23 03:52:57', '2019-05-23 03:52:57'),
('SMT/LD/2019/00001', 'smt', 1, 'Lampu Depan Yamaha', 100, 0, 0, 100, 30000, 20000, '5ce512b5198e7.jpg', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:13:25', '2019-05-22 09:13:25'),
('SMT/RM/2019/00002', 'smt', 2, 'Rantai Motor czc', 100, 0, 0, 100, 45000, 30000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:22:51', '2019-05-22 09:22:51'),
('SMT/SA/2019/00001', 'smt', 1, 'Spion Adasd', 100, 0, 0, 100, 7500, 4000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:22:18', '2019-05-22 09:22:18'),
('SMT/SB/2019/00001', 'smt', 2, 'Shock Belakang', 100, 0, 0, 100, 1000000, 750000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:28:19', '2019-05-22 09:28:19'),
('SMT/SD/2019/00002', 'smt', 2, 'Shock Depan affew', 105, 0, 0, 105, 750000, 500000, 'default.png', '1', 'Loker 1', '<p>-</p>', '2019-05-22 09:24:00', '2019-05-23 03:11:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_loan`
--

CREATE TABLE `tb_loan` (
  `code_loan` varchar(50) COLLATE utf8_bin NOT NULL,
  `name_loan` varchar(35) COLLATE utf8_bin NOT NULL,
  `status` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `due_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_loan`
--

INSERT INTO `tb_loan` (`code_loan`, `name_loan`, `status`, `due_date`, `created_at`) VALUES
('TRK/PEMINJAMAN/23052019/001', 'Peminjam 1', '1', '2019-05-23 06:50:00', '2019-05-23 06:41:17'),
('TRK/PEMINJAMAN/23052019/002', 'Pinjam', '1', '2019-05-23 07:28:00', '2019-05-23 07:28:35'),
('TRK/PEMINJAMAN/23052019/003', 'Peminjam 2', '1', '2019-05-23 07:35:00', '2019-05-23 07:36:51'),
('TRK/PEMINJAMAN/24052019/001', 'Test', '1', '2019-05-24 11:30:00', '2019-05-24 10:32:16'),
('TRK/PEMINJAMAN/24052019/002', 'Test', '1', '2019-05-24 11:40:00', '2019-05-24 10:49:41'),
('TRK/PEMINJAMAN/24052019/003', 'Test', '1', '2019-05-24 11:30:00', '2019-05-24 10:54:46'),
('TRK/PEMINJAMAN/30052019/001', 'Test', '1', '2019-05-29 22:45:00', '2019-05-29 22:42:42'),
('TRK/PEMINJAMAN/30052019/002', 'Test', '1', '2019-05-29 22:45:00', '2019-05-29 22:43:33'),
('TRK/PEMINJAMAN/30052019/003', 'Test', '1', '2019-05-29 22:50:00', '2019-05-29 22:47:10'),
('TRK/PEMINJAMAN/30052019/004', 'Test', '1', '2019-05-29 23:15:00', '2019-05-29 23:10:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_loan_details`
--

CREATE TABLE `tb_loan_details` (
  `id_loan_detail` int(10) UNSIGNED NOT NULL,
  `code_loan` varchar(50) COLLATE utf8_bin NOT NULL,
  `code_item` varchar(50) COLLATE utf8_bin NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_loan_details`
--

INSERT INTO `tb_loan_details` (`id_loan_detail`, `code_loan`, `code_item`, `amount`) VALUES
(110, 'TRK/PEMINJAMAN/23052019/001', 'ALT/IA/2019/00001', 10),
(111, 'TRK/PEMINJAMAN/23052019/001', 'ALT/IA/2019/00002', 10),
(112, 'TRK/PEMINJAMAN/23052019/001', 'ALT/IA/2019/00003', 10),
(113, 'TRK/PEMINJAMAN/23052019/002', 'ALT/IA/2019/00001', 10),
(114, 'TRK/PEMINJAMAN/23052019/002', 'ALT/IA/2019/00002', 10),
(115, 'TRK/PEMINJAMAN/23052019/002', 'ALT/IA/2019/00003', 10),
(116, 'TRK/PEMINJAMAN/23052019/003', 'SMT/IM/2019/00001', 10),
(117, 'TRK/PEMINJAMAN/23052019/003', 'ALT/IA/2019/00002', 10),
(119, 'TRK/PEMINJAMAN/24052019/001', 'ALT/IB/2019/00001', 2),
(120, 'TRK/PEMINJAMAN/24052019/001', 'ALT/IA/2019/00001', 3),
(121, 'TRK/PEMINJAMAN/24052019/002', 'ALT/IA/2019/00001', 10),
(122, 'TRK/PEMINJAMAN/24052019/002', 'ALT/IA/2019/00002', 10),
(123, 'TRK/PEMINJAMAN/24052019/002', 'ALT/IA/2019/00003', 10),
(124, 'TRK/PEMINJAMAN/24052019/003', 'SMB/IM/2019/00001', 2),
(125, 'TRK/PEMINJAMAN/24052019/003', 'ALT/IB/2019/00001', 3),
(127, 'TRK/PEMINJAMAN/30052019/001', 'ALT/O/2019/00002', 2),
(128, 'TRK/PEMINJAMAN/30052019/002', 'ALT/O/2019/00002', 7),
(129, 'TRK/PEMINJAMAN/30052019/003', 'ALT/O/2019/00002', 5),
(130, 'TRK/PEMINJAMAN/30052019/003', 'ALT/IB/2019/00001', 3),
(131, 'TRK/PEMINJAMAN/30052019/003', 'SMB/IM/2019/00001', 3),
(136, 'TRK/PEMINJAMAN/30052019/004', 'ALT/O/2019/00002', 5),
(137, 'TRK/PEMINJAMAN/30052019/004', 'ALT/IB/2019/00001', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengadaan`
--

CREATE TABLE `tb_pengadaan` (
  `code_pengadaan` varchar(50) COLLATE utf8_bin NOT NULL,
  `status` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `total` int(9) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_pengadaan`
--

INSERT INTO `tb_pengadaan` (`code_pengadaan`, `status`, `total`, `created_at`) VALUES
('TRK/PENGADAAN/24052019/001', '1', 257000, '2019-05-24 16:34:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengadaan_details`
--

CREATE TABLE `tb_pengadaan_details` (
  `id_pengadaan_detail` int(10) UNSIGNED NOT NULL,
  `code_pengadaan` varchar(50) COLLATE utf8_bin NOT NULL,
  `code_item` varchar(50) COLLATE utf8_bin NOT NULL,
  `amount` int(3) UNSIGNED NOT NULL,
  `subtotal` int(9) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_pengadaan_details`
--

INSERT INTO `tb_pengadaan_details` (`id_pengadaan_detail`, `code_pengadaan`, `code_item`, `amount`, `subtotal`) VALUES
(5, 'TRK/PENGADAAN/24052019/001', 'ALT/IB/2019/00001', 2, 2000),
(6, 'TRK/PENGADAAN/24052019/001', 'SMB/IM/2019/00001', 2, 5000),
(7, 'TRK/PENGADAAN/24052019/001', 'ALT/IA/2019/00001', 5, 250000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_permissions`
--

CREATE TABLE `tb_permissions` (
  `id_permission` int(3) UNSIGNED NOT NULL,
  `name_permission` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_permissions`
--

INSERT INTO `tb_permissions` (`id_permission`, `name_permission`) VALUES
(1, 'create_user'),
(2, 'read_user'),
(3, 'update_user'),
(4, 'delete_user'),
(5, 'create_tool'),
(6, 'read_tool'),
(7, 'update_tool'),
(8, 'delete_tool'),
(9, 'create_sparepart'),
(10, 'read_sparepart'),
(11, 'update_sparepart'),
(12, 'delete_sparepart'),
(13, 'create_loaning'),
(14, 'read_loaning'),
(15, 'update_loaning'),
(16, 'delete_loaning'),
(17, 'create_returning'),
(18, 'read_returning'),
(19, 'update_returning'),
(20, 'delete_returning'),
(21, 'create_selling'),
(22, 'read_selling'),
(23, 'update_selling'),
(24, 'delete_selling'),
(25, 'create_buying'),
(26, 'read_buying'),
(27, 'update_buying'),
(28, 'delete_buying'),
(29, 'menu_data'),
(30, 'menu_transaksi'),
(31, 'menu_penggantian'),
(32, 'menu_laporan'),
(33, 'submenu_data_user'),
(34, 'submenu_data_alat'),
(35, 'submenu_data_sparepart'),
(36, 'submenu_transaksi_peminjaman'),
(37, 'submenu_transaksi_pengembalian'),
(38, 'submenu_transaksi_penjualan'),
(39, 'submenu_transaksi_pembelian'),
(40, 'submenu_laporan_peminjaman'),
(41, 'submenu_laporan_pengembalian'),
(42, 'submenu_laporan_penjualan'),
(43, 'submenu_laporan_pembelian'),
(44, 'submenu_laporan_pengadaan'),
(45, 'submenu_penggantian_alat'),
(46, 'submenu_penggantian_sparepart'),
(47, 'menu_shopping'),
(48, 'sub_menu_shopping'),
(49, 'sub_menu_cart'),
(50, 'create_pengadaan'),
(51, 'read_pengadaan'),
(52, 'update_pengadaan'),
(53, 'delete_pengadaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_return`
--

CREATE TABLE `tb_return` (
  `code_return` varchar(50) COLLATE utf8_bin NOT NULL,
  `code_loan` varchar(50) COLLATE utf8_bin NOT NULL,
  `name_return` varchar(35) COLLATE utf8_bin NOT NULL,
  `pin` enum('0','1') COLLATE utf8_bin NOT NULL,
  `long_period` varchar(50) COLLATE utf8_bin NOT NULL,
  `penalty` int(9) UNSIGNED NOT NULL DEFAULT '0',
  `rechange` enum('0','1','2') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `info` text COLLATE utf8_bin,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_return`
--

INSERT INTO `tb_return` (`code_return`, `code_loan`, `name_return`, `pin`, `long_period`, `penalty`, `rechange`, `info`, `created_at`) VALUES
('TRK/PENGEMBALIAN/23052019/001', 'TRK/PEMINJAMAN/23052019/001', 'Peminjam 1', '1', '0 Hari, 00 Jam, 00 Menit', 0, '0', '<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>', '2019-05-23 06:41:45'),
('TRK/PENGEMBALIAN/23052019/002', 'TRK/PEMINJAMAN/23052019/002', 'Pinjam', '0', '0 Hari, 00 Jam, 01 Menit', 5000, '2', '<em class=\"text-center text-red\">Dikenakan biaya penalti keterlambatan <i>Rp. 5.000</i> per hari ! Total yang harus dibayarkan Rp <b>5,000</b></em>', '2019-05-23 07:29:28'),
('TRK/PENGEMBALIAN/23052019/003', 'TRK/PEMINJAMAN/23052019/003', 'Peminjam 2', '0', '0 Hari, 00 Jam, 02 Menit', 5000, '2', '<em class=\"text-center text-red\">Dikenakan biaya penalti keterlambatan <i>Rp. 5.000</i> per hari ! Total yang harus dibayarkan Rp <b>5,000</b></em>', '2019-05-23 07:37:34'),
('TRK/PENGEMBALIAN/24052019/001', 'TRK/PEMINJAMAN/24052019/001', 'Test', '1', '0 Hari, 00 Jam, 04 Menit', 0, '0', '<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>', '2019-05-24 10:36:18'),
('TRK/PENGEMBALIAN/24052019/002', 'TRK/PEMINJAMAN/24052019/002', 'Test', '1', '0 Hari, 00 Jam, 01 Menit', 0, '1', '<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>', '2019-05-24 10:50:44'),
('TRK/PENGEMBALIAN/24052019/003', 'TRK/PEMINJAMAN/24052019/003', 'Test', '1', '0 Hari, 00 Jam, 01 Menit', 0, '1', '<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>', '2019-05-24 10:55:26'),
('TRK/PENGEMBALIAN/30052019/001', 'TRK/PEMINJAMAN/30052019/001', 'Test', '1', '0 Hari, 00 Jam, 01 Menit', 0, '0', '<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>', '2019-05-29 22:43:08'),
('TRK/PENGEMBALIAN/30052019/002', 'TRK/PEMINJAMAN/30052019/002', 'Test', '1', '0 Hari, 00 Jam, 01 Menit', 0, '1', '<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>', '2019-05-29 22:44:11'),
('TRK/PENGEMBALIAN/30052019/003', 'TRK/PEMINJAMAN/30052019/003', 'Test', '1', '0 Hari, 00 Jam, 01 Menit', 0, '2', '<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>', '2019-05-29 22:48:09'),
('TRK/PENGEMBALIAN/30052019/004', 'TRK/PEMINJAMAN/30052019/004', 'Test', '1', '0 Hari, 00 Jam, 01 Menit', 0, '0', '<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>', '2019-05-29 23:11:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_return_details`
--

CREATE TABLE `tb_return_details` (
  `id_return_details` int(10) UNSIGNED NOT NULL,
  `code_return` varchar(50) COLLATE utf8_bin NOT NULL,
  `code_item` varchar(50) COLLATE utf8_bin NOT NULL,
  `amount_loan` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `broken_amount` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `broken_status` enum('0','1','2') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `lost_amount` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `lost_status` enum('0','1','2') COLLATE utf8_bin NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_return_details`
--

INSERT INTO `tb_return_details` (`id_return_details`, `code_return`, `code_item`, `amount_loan`, `broken_amount`, `broken_status`, `lost_amount`, `lost_status`) VALUES
(79, 'TRK/PENGEMBALIAN/23052019/001', 'ALT/IA/2019/00001', 10, 0, '0', 0, '0'),
(80, 'TRK/PENGEMBALIAN/23052019/001', 'ALT/IA/2019/00002', 10, 0, '0', 0, '0'),
(81, 'TRK/PENGEMBALIAN/23052019/001', 'ALT/IA/2019/00003', 10, 0, '0', 0, '0'),
(82, 'TRK/PENGEMBALIAN/23052019/002', 'ALT/IA/2019/00001', 10, 0, '0', 0, '0'),
(83, 'TRK/PENGEMBALIAN/23052019/002', 'ALT/IA/2019/00002', 10, 0, '0', 0, '0'),
(84, 'TRK/PENGEMBALIAN/23052019/002', 'ALT/IA/2019/00003', 10, 0, '0', 0, '0'),
(85, 'TRK/PENGEMBALIAN/23052019/003', 'SMT/IM/2019/00001', 10, 0, '0', 0, '0'),
(86, 'TRK/PENGEMBALIAN/23052019/003', 'ALT/IA/2019/00002', 10, 0, '0', 0, '0'),
(88, 'TRK/PENGEMBALIAN/24052019/001', 'ALT/IB/2019/00001', 2, 0, '0', 0, '0'),
(89, 'TRK/PENGEMBALIAN/24052019/001', 'ALT/IA/2019/00001', 3, 0, '0', 0, '0'),
(90, 'TRK/PENGEMBALIAN/24052019/002', 'ALT/IA/2019/00001', 10, 5, '1', 0, '0'),
(91, 'TRK/PENGEMBALIAN/24052019/002', 'ALT/IA/2019/00002', 10, 0, '0', 5, '2'),
(92, 'TRK/PENGEMBALIAN/24052019/002', 'ALT/IA/2019/00003', 10, 0, '0', 0, '0'),
(93, 'TRK/PENGEMBALIAN/24052019/003', 'SMB/IM/2019/00001', 2, 1, '1', 1, '2'),
(94, 'TRK/PENGEMBALIAN/24052019/003', 'ALT/IB/2019/00001', 3, 1, '2', 1, '1'),
(95, 'TRK/PENGEMBALIAN/30052019/001', 'ALT/O/2019/00002', 2, 0, '0', 0, '0'),
(96, 'TRK/PENGEMBALIAN/30052019/002', 'ALT/O/2019/00002', 7, 1, '1', 1, '2'),
(97, 'TRK/PENGEMBALIAN/30052019/003', 'ALT/O/2019/00002', 5, 0, '0', 0, '0'),
(98, 'TRK/PENGEMBALIAN/30052019/003', 'ALT/IB/2019/00001', 3, 0, '0', 0, '0'),
(99, 'TRK/PENGEMBALIAN/30052019/003', 'SMB/IM/2019/00001', 3, 0, '0', 0, '0'),
(100, 'TRK/PENGEMBALIAN/30052019/004', 'ALT/O/2019/00002', 5, 0, '0', 0, '0'),
(101, 'TRK/PENGEMBALIAN/30052019/004', 'ALT/IB/2019/00001', 3, 0, '0', 0, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rules`
--

CREATE TABLE `tb_rules` (
  `id_rule` int(3) UNSIGNED NOT NULL,
  `name_rule` varchar(15) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_rules`
--

INSERT INTO `tb_rules` (`id_rule`, `name_rule`) VALUES
(1, 'superadmin'),
(2, 'admin_1'),
(3, 'admin_2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rule_permission`
--

CREATE TABLE `tb_rule_permission` (
  `id_rule` int(3) UNSIGNED NOT NULL,
  `id_permission` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_rule_permission`
--

INSERT INTO `tb_rule_permission` (`id_rule`, `id_permission`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(2, 6),
(2, 10),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 29),
(2, 30),
(2, 34),
(2, 35),
(2, 36),
(2, 37),
(3, 2),
(3, 6),
(3, 10),
(3, 14),
(3, 18),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 26),
(3, 27),
(3, 28),
(3, 29),
(3, 30),
(3, 32),
(3, 33),
(3, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(3, 41),
(3, 42),
(3, 43),
(3, 44),
(3, 47),
(3, 48),
(3, 49);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_selling`
--

CREATE TABLE `tb_selling` (
  `code_selling` varchar(50) COLLATE utf8_bin NOT NULL,
  `name_buyer` varchar(35) COLLATE utf8_bin NOT NULL,
  `total` int(7) UNSIGNED NOT NULL,
  `status` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_selling`
--

INSERT INTO `tb_selling` (`code_selling`, `name_buyer`, `total`, `status`, `created_at`) VALUES
('TRK/PENJUALAN/23052019/001', 'aaa', 35000, '1', '2019-05-23 06:05:38'),
('TRK/PENJUALAN/24052019/001', 'Test Admin 2 Penjualan', 300000, '1', '2019-05-24 16:46:58'),
('TRK/PENJUALAN/24052019/002', 'Test Admin 2 Penjualan 2', 150000, '1', '2019-05-24 16:50:46'),
('TRK/PENJUALAN/24052019/003', 'Test Admin 2 Penjualan 3', 150000, '1', '2019-05-24 16:52:19'),
('TRK/PENJUALAN/24052019/004', 'Test Admin 2 Penjualan 4', 90000, '1', '2019-05-24 16:53:24'),
('TRK/PENJUALAN/30052019/001', 'Test', 75000, '1', '2019-05-29 22:50:20'),
('TRK/PENJUALAN/30052019/002', 'Test', 75000, '1', '2019-05-29 23:13:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_selling_details`
--

CREATE TABLE `tb_selling_details` (
  `id_selling_detail` int(10) UNSIGNED NOT NULL,
  `code_selling` varchar(50) COLLATE utf8_bin NOT NULL,
  `code_item` varchar(50) COLLATE utf8_bin NOT NULL,
  `amount` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `sub_total` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `profit` int(7) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_selling_details`
--

INSERT INTO `tb_selling_details` (`id_selling_detail`, `code_selling`, `code_item`, `amount`, `sub_total`, `profit`) VALUES
(21, 'TRK/PENJUALAN/23052019/001', 'ALT/IB/2019/00001', 5, 15000, 10000),
(22, 'TRK/PENJUALAN/23052019/001', 'SMB/IM/2019/00001', 5, 20000, 10000),
(23, 'TRK/PENJUALAN/24052019/001', 'SMB/K/2019/00001', 10, 300000, 100000),
(24, 'TRK/PENJUALAN/24052019/002', 'SMB/K/2019/00001', 5, 150000, 50000),
(25, 'TRK/PENJUALAN/24052019/003', 'SMB/K/2019/00001', 5, 150000, 50000),
(26, 'TRK/PENJUALAN/24052019/004', 'SMB/K/2019/00001', 3, 90000, 30000),
(27, 'TRK/PENJUALAN/30052019/001', 'SMB/K/2019/00001', 2, 60000, 20000),
(28, 'TRK/PENJUALAN/30052019/001', 'SMB/IM/2019/00001', 3, 15000, 7500),
(29, 'TRK/PENJUALAN/30052019/002', 'SMB/IM/2019/00001', 15, 75000, 37500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_unit`
--

CREATE TABLE `tb_unit` (
  `id_unit` int(10) UNSIGNED NOT NULL,
  `name_unit` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_unit`
--

INSERT INTO `tb_unit` (`id_unit`, `name_unit`) VALUES
(1, 'Set'),
(2, 'Unit'),
(4, 'Box'),
(5, 'Liter');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` varchar(50) COLLATE utf8_bin NOT NULL,
  `id_rule` int(3) UNSIGNED NOT NULL,
  `name` varchar(35) COLLATE utf8_bin NOT NULL,
  `nip` varchar(18) COLLATE utf8_bin NOT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `status` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `id_rule`, `name`, `nip`, `username`, `password`, `status`, `created_at`, `updated_at`) VALUES
('e3e07bae-4720-11e9-a698-1cb72c3aadd9', 1, 'Kakek Admin', '123456789012345679', 'superadmin', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', '1', '2019-03-12 17:00:00', '2019-05-24 08:55:15'),
('e3e0c546-4720-11e9-a8ff-1cb72c3aadd9', 2, 'Bapak Admin', '123456789012345678', 'admin1234', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', '1', '2019-03-12 17:00:01', '2019-03-18 10:55:49'),
('e3e0ccd0-4720-11e9-93e0-1cb72c3aadd9', 3, 'Anak Admin', '123456789012345677', 'admin2345', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', '1', '2019-03-12 17:00:02', '2019-03-17 18:31:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_buying`
--
ALTER TABLE `tb_buying`
  ADD PRIMARY KEY (`code_buying`);

--
-- Indeks untuk tabel `tb_buying_details`
--
ALTER TABLE `tb_buying_details`
  ADD PRIMARY KEY (`id_buying_detail`),
  ADD KEY `code_buying` (`code_buying`),
  ADD KEY `code_item` (`code_item`);

--
-- Indeks untuk tabel `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `code_item` (`code_item`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tb_categories`
--
ALTER TABLE `tb_categories`
  ADD PRIMARY KEY (`code_category`);

--
-- Indeks untuk tabel `tb_items`
--
ALTER TABLE `tb_items`
  ADD PRIMARY KEY (`code_item`),
  ADD KEY `code_category` (`code_category`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indeks untuk tabel `tb_loan`
--
ALTER TABLE `tb_loan`
  ADD PRIMARY KEY (`code_loan`);

--
-- Indeks untuk tabel `tb_loan_details`
--
ALTER TABLE `tb_loan_details`
  ADD PRIMARY KEY (`id_loan_detail`),
  ADD KEY `code_loan` (`code_loan`),
  ADD KEY `code_item` (`code_item`);

--
-- Indeks untuk tabel `tb_pengadaan`
--
ALTER TABLE `tb_pengadaan`
  ADD PRIMARY KEY (`code_pengadaan`);

--
-- Indeks untuk tabel `tb_pengadaan_details`
--
ALTER TABLE `tb_pengadaan_details`
  ADD PRIMARY KEY (`id_pengadaan_detail`),
  ADD KEY `code_pengadaan` (`code_pengadaan`),
  ADD KEY `code_item` (`code_item`);

--
-- Indeks untuk tabel `tb_permissions`
--
ALTER TABLE `tb_permissions`
  ADD PRIMARY KEY (`id_permission`);

--
-- Indeks untuk tabel `tb_return`
--
ALTER TABLE `tb_return`
  ADD PRIMARY KEY (`code_return`),
  ADD KEY `code_loan` (`code_loan`);

--
-- Indeks untuk tabel `tb_return_details`
--
ALTER TABLE `tb_return_details`
  ADD PRIMARY KEY (`id_return_details`),
  ADD KEY `code_return` (`code_return`),
  ADD KEY `code_item` (`code_item`);

--
-- Indeks untuk tabel `tb_rules`
--
ALTER TABLE `tb_rules`
  ADD PRIMARY KEY (`id_rule`);

--
-- Indeks untuk tabel `tb_rule_permission`
--
ALTER TABLE `tb_rule_permission`
  ADD PRIMARY KEY (`id_rule`,`id_permission`),
  ADD KEY `id_permission` (`id_permission`);

--
-- Indeks untuk tabel `tb_selling`
--
ALTER TABLE `tb_selling`
  ADD PRIMARY KEY (`code_selling`);

--
-- Indeks untuk tabel `tb_selling_details`
--
ALTER TABLE `tb_selling_details`
  ADD PRIMARY KEY (`id_selling_detail`),
  ADD KEY `code_item` (`code_item`),
  ADD KEY `code_selling` (`code_selling`);

--
-- Indeks untuk tabel `tb_unit`
--
ALTER TABLE `tb_unit`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_level` (`id_rule`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_buying_details`
--
ALTER TABLE `tb_buying_details`
  MODIFY `id_buying_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tb_loan_details`
--
ALTER TABLE `tb_loan_details`
  MODIFY `id_loan_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT untuk tabel `tb_pengadaan_details`
--
ALTER TABLE `tb_pengadaan_details`
  MODIFY `id_pengadaan_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_permissions`
--
ALTER TABLE `tb_permissions`
  MODIFY `id_permission` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `tb_return_details`
--
ALTER TABLE `tb_return_details`
  MODIFY `id_return_details` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `tb_rules`
--
ALTER TABLE `tb_rules`
  MODIFY `id_rule` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_selling_details`
--
ALTER TABLE `tb_selling_details`
  MODIFY `id_selling_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `id_unit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_buying_details`
--
ALTER TABLE `tb_buying_details`
  ADD CONSTRAINT `tb_buying_details_ibfk_1` FOREIGN KEY (`code_buying`) REFERENCES `tb_buying` (`code_buying`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_buying_details_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `tb_items` (`code_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD CONSTRAINT `tb_cart_ibfk_1` FOREIGN KEY (`code_item`) REFERENCES `tb_items` (`code_item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_cart_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_items`
--
ALTER TABLE `tb_items`
  ADD CONSTRAINT `tb_items_ibfk_1` FOREIGN KEY (`code_category`) REFERENCES `tb_categories` (`code_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_items_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `tb_unit` (`id_unit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_loan_details`
--
ALTER TABLE `tb_loan_details`
  ADD CONSTRAINT `tb_loan_details_ibfk_1` FOREIGN KEY (`code_loan`) REFERENCES `tb_loan` (`code_loan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_loan_details_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `tb_items` (`code_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pengadaan_details`
--
ALTER TABLE `tb_pengadaan_details`
  ADD CONSTRAINT `tb_pengadaan_details_ibfk_1` FOREIGN KEY (`code_pengadaan`) REFERENCES `tb_pengadaan` (`code_pengadaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pengadaan_details_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `tb_items` (`code_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_return`
--
ALTER TABLE `tb_return`
  ADD CONSTRAINT `tb_return_ibfk_1` FOREIGN KEY (`code_loan`) REFERENCES `tb_loan` (`code_loan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_return_details`
--
ALTER TABLE `tb_return_details`
  ADD CONSTRAINT `tb_return_details_ibfk_1` FOREIGN KEY (`code_return`) REFERENCES `tb_return` (`code_return`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_return_details_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `tb_items` (`code_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_rule_permission`
--
ALTER TABLE `tb_rule_permission`
  ADD CONSTRAINT `tb_rule_permission_ibfk_1` FOREIGN KEY (`id_rule`) REFERENCES `tb_rules` (`id_rule`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_rule_permission_ibfk_2` FOREIGN KEY (`id_permission`) REFERENCES `tb_permissions` (`id_permission`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_selling_details`
--
ALTER TABLE `tb_selling_details`
  ADD CONSTRAINT `tb_selling_details_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `tb_items` (`code_item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_selling_details_ibfk_3` FOREIGN KEY (`code_selling`) REFERENCES `tb_selling` (`code_selling`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD CONSTRAINT `tb_users_ibfk_1` FOREIGN KEY (`id_rule`) REFERENCES `tb_rules` (`id_rule`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
