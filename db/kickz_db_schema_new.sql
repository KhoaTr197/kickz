-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 04:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kickz`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietgiohang`
--

CREATE TABLE `chitietgiohang` (
  `MAGH` int(11) NOT NULL,
  `MASP` int(11) NOT NULL,
  `MAKC` int(11) NOT NULL,
  `SOLUONG` int(11) DEFAULT NULL,
  `GIA` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `MASP` int(11) NOT NULL,
  `MAHD` int(11) NOT NULL,
  `MAKC` int(11) NOT NULL,
  `SOLUONG` int(11) DEFAULT NULL,
  `GIA` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MADM` int(11) NOT NULL,
  `TENDM` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `MAGH` int(11) NOT NULL,
  `MATK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hangsanxuat`
--

CREATE TABLE `hangsanxuat` (
  `MAHSX` int(11) NOT NULL,
  `TENHSX` varchar(30) DEFAULT NULL,
  `LOGO` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hinhanh`
--

CREATE TABLE `hinhanh` (
  `MASP` int(11) NOT NULL,
  `MAHA` int(11) NOT NULL,
  `FILE` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `MAHD` int(11) NOT NULL,
  `MATK` int(11) DEFAULT NULL,
  `TONGTIEN` float DEFAULT NULL,
  `HOTENKH` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `DCHI` varchar(200) DEFAULT NULL,
  `GHICHU` text DEFAULT NULL,
  `NGLAPHD` date DEFAULT NULL,
  `MATT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kichco`
--

CREATE TABLE `kichco` (
  `MASP` int(11) NOT NULL,
  `MAKC` int(11) NOT NULL,
  `COGIAY` float DEFAULT NULL,
  `SOLUONG` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MATK` int(11) NOT NULL,
  `TENTK` varchar(30) DEFAULT NULL,
  `HOTEN` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `SDT` varchar(10) DEFAULT NULL,
  `MATKHAU` varchar(32) DEFAULT NULL,
  `NGLAPTK` date DEFAULT NULL,
  `DCHI` varchar(200) DEFAULT NULL,
  `TRANGTHAI` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phanloai`
--

CREATE TABLE `phanloai` (
  `MADM` int(11) NOT NULL,
  `MASP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quantrivien`
--

CREATE TABLE `quantrivien` (
  `MAQTV` int(11) NOT NULL,
  `TENTK` varchar(50) DEFAULT NULL,
  `MATKHAU` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `MASP` int(11) NOT NULL,
  `TENSP` varchar(150) DEFAULT NULL,
  `GIA` float DEFAULT NULL,
  `KHUYENMAI` int(11) DEFAULT NULL,
  `MOTA` text DEFAULT NULL,
  `SOSAO` int(11) DEFAULT NULL,
  `NGSX` date DEFAULT NULL,
  `MAHSX` int(11) DEFAULT NULL,
  `TRANGTHAI` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `MASS` varchar(50) NOT NULL,
  `MATK` int(11) NOT NULL,
  `LAN_CUOI_DANG_NHAP` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trangthai`
--

CREATE TABLE `trangthai` (
  `MATT` int(11) NOT NULL,
  `TENTT` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD PRIMARY KEY (`MAGH`,`MASP`,`MAKC`),
  ADD KEY `MASP` (`MASP`),
  ADD KEY `MAKC` (`MAKC`);

--
-- Indexes for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`MAHD`,`MASP`,`MAKC`),
  ADD KEY `MASP` (`MASP`),
  ADD KEY `MAKC` (`MAKC`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MADM`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MAGH`),
  ADD KEY `MATK` (`MATK`);

--
-- Indexes for table `hangsanxuat`
--
ALTER TABLE `hangsanxuat`
  ADD PRIMARY KEY (`MAHSX`);

--
-- Indexes for table `hinhanh`
--
ALTER TABLE `hinhanh`
  ADD PRIMARY KEY (`MAHA`,`MASP`),
  ADD KEY `MASP` (`MASP`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MAHD`),
  ADD KEY `MATK` (`MATK`),
  ADD KEY `MATT` (`MATT`);

--
-- Indexes for table `kichco`
--
ALTER TABLE `kichco`
  ADD PRIMARY KEY (`MAKC`,`MASP`),
  ADD KEY `MASP` (`MASP`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MATK`),
  ADD UNIQUE KEY `TENTK` (`TENTK`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `SDT` (`SDT`);

--
-- Indexes for table `phanloai`
--
ALTER TABLE `phanloai`
  ADD PRIMARY KEY (`MADM`,`MASP`),
  ADD KEY `MASP` (`MASP`);

--
-- Indexes for table `quantrivien`
--
ALTER TABLE `quantrivien`
  ADD PRIMARY KEY (`MAQTV`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MASP`),
  ADD KEY `MAHSX` (`MAHSX`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`MASS`),
  ADD KEY `MATK` (`MATK`);

--
-- Indexes for table `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`MATT`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MADM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MAGH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hangsanxuat`
--
ALTER TABLE `hangsanxuat`
  MODIFY `MAHSX` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MAHD` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kichco`
--
ALTER TABLE `kichco`
  MODIFY `MAKC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `MATK` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quantrivien`
--
ALTER TABLE `quantrivien`
  MODIFY `MAQTV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MASP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trangthai`
--
ALTER TABLE `trangthai`
  MODIFY `MATT` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD CONSTRAINT `chitietgiohang_ibfk_1` FOREIGN KEY (`MAGH`) REFERENCES `giohang` (`MAGH`),
  ADD CONSTRAINT `chitietgiohang_ibfk_2` FOREIGN KEY (`MASP`) REFERENCES `sanpham` (`MASP`),
  ADD CONSTRAINT `chitietgiohang_ibfk_3` FOREIGN KEY (`MAKC`) REFERENCES `kichco` (`MAKC`);

--
-- Constraints for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`MAHD`) REFERENCES `hoadon` (`MAHD`),
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`MASP`) REFERENCES `sanpham` (`MASP`),
  ADD CONSTRAINT `chitiethoadon_ibfk_3` FOREIGN KEY (`MAKC`) REFERENCES `kichco` (`MAKC`);

--
-- Constraints for table `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MATK`) REFERENCES `nguoidung` (`MATK`);

--
-- Constraints for table `hinhanh`
--
ALTER TABLE `hinhanh`
  ADD CONSTRAINT `hinhanh_ibfk_1` FOREIGN KEY (`MASP`) REFERENCES `sanpham` (`MASP`);

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`MATK`) REFERENCES `nguoidung` (`MATK`),
  ADD CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`MATT`) REFERENCES `trangthai` (`MATT`);

--
-- Constraints for table `phanloai`
--
ALTER TABLE `phanloai`
  ADD CONSTRAINT `phanloai_ibfk_1` FOREIGN KEY (`MADM`) REFERENCES `danhmuc` (`MADM`),
  ADD CONSTRAINT `phanloai_ibfk_2` FOREIGN KEY (`MASP`) REFERENCES `sanpham` (`MASP`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MAHSX`) REFERENCES `hangsanxuat` (`MAHSX`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
