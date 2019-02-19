-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2019 at 03:10 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transaksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `harga_beli` int(10) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `stok` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode`, `nama`, `harga_beli`, `harga_jual`, `stok`) VALUES
('moklet', 'SUSU', 1000, 4000, 4),
('moklet1', 'ROTI', 2000, 4000, 5),
('moklet3', 'TELUR', 1500, 3000, 14);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `no_nota` varchar(10) NOT NULL,
  `kode` varchar(8) NOT NULL,
  `harga` int(8) NOT NULL,
  `jumlah` int(8) NOT NULL,
  `subtotal` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`no_nota`, `kode`, `harga`, `jumlah`, `subtotal`) VALUES
('1', 'moklet1', 2000, 12, 24000),
('1', 'moklet', 1000, 1, 1000),
('2', 'moklet', 1000, 1, 1000),
('2', 'moklet', 1000, 1, 1000),
('3', 'moklet', 1000, 1, 1000),
('3', 'moklet1', 2000, 3, 6000),
('4', 'moklet3', 1500, 1, 1500),
('4', 'moklet', 1000, 1, 1000),
('4', 'moklet', 1000, 1, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_nota` varchar(8) NOT NULL,
  `tanggal` date NOT NULL,
  `total` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`no_nota`, `tanggal`, `total`) VALUES
('1', '2019-02-19', 25000),
('2', '2019-02-19', 2000),
('3', '2019-02-19', 7000),
('4', '2019-02-19', 3500);

-- --------------------------------------------------------

--
-- Table structure for table `sementara`
--

CREATE TABLE `sementara` (
  `kode` varchar(30) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `harga` int(8) NOT NULL,
  `jumlah` int(8) NOT NULL,
  `subtotal` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_nota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
