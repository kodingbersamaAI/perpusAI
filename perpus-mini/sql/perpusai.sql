-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2023 at 11:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpusai`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `cover` varchar(250) NOT NULL,
  `judul` varchar(250) NOT NULL,
  `penerbit` varchar(250) NOT NULL,
  `pengarang` varchar(250) NOT NULL,
  `tahun` varchar(250) NOT NULL,
  `seri` varchar(250) NOT NULL,
  `isbn` varchar(250) NOT NULL,
  `jumlahBuku` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `cover`, `judul`, `penerbit`, `pengarang`, `tahun`, `seri`, `isbn`, `jumlahBuku`) VALUES
(6, 'https://static.buku.kemdikbud.go.id/content/image/coverteks/coverkurikulum21/Bermain%20Berbasis%20Buku-PAUD-COVER.png', 'Buku Panduan Guru Belajar dan Bermain Berbasis Buku untuk Satuan PAUD', 'Pusat Kurikulum dan Perbukuan', 'Arleen Amidjaja, Anna Farida Kurniasari, Ni Ekawati', '2022', '-', '978-602-244-562-3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` enum('admin','user','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `role`) VALUES
(8, 'admin', '$2y$10$UcDOcTy4lBVdlag/dHZjdOnVDNtg6FrByeotFROJtnfpqKGumxbi.', 'admin'),
(13, 'user', '$2y$10$qVJDxo.Hh/kmrYV1sMhixecOUUvKSqSJOzMZPebAZjORxw3wNLMpS', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `judul` varchar(250) NOT NULL,
  `jatuhTempo` varchar(250) NOT NULL,
  `denda` varchar(250) NOT NULL,
  `status` enum('Dipinjam','Dikembalikan','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `username`, `judul`, `jatuhTempo`, `denda`, `status`) VALUES
(22, 'admin', 'Buku Panduan Guru Belajar dan Bermain Berbasis Buku untuk Satuan PAUD', '2023-11-12', '', 'Dipinjam'),
(23, 'admin', 'Buku Panduan Guru Belajar dan Bermain Berbasis Buku untuk Satuan PAUD', '2023-11-12', '0', 'Dikembalikan'),
(24, 'puroguramu', 'Buku Panduan Guru Belajar dan Bermain Berbasis Buku untuk Satuan PAUD', '2023-11-12', '', 'Dipinjam'),
(25, 'admin', 'Buku Panduan Guru Belajar dan Bermain Berbasis Buku untuk Satuan PAUD', '2023-11-12', '', 'Dipinjam'),
(26, 'admin', 'Pendidikan Agama Islam dan Budi Pekerti untuk SD Kelas I', '2023-11-11', '', 'Dipinjam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
