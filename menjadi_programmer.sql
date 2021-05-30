-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2021 at 09:30 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `menjadi_programmer`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `ID` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`ID`, `nama`, `deskripsi`, `foto`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'HTML 5', 'Belajar HTML 5', '60b3331bf2a2b.png', '2021-05-30 05:49:58', '2021-05-30 01:58:20', NULL, 12),
(2, 'PHP', 'belajar PHP', NULL, '2021-05-30 05:49:58', NULL, NULL, NULL),
(4, 'Java', 'Belajar Java', '60b331d2486c9.jpeg', '2021-05-30 06:33:54', NULL, 11, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `ID` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe_konten` int(11) NOT NULL DEFAULT 1 COMMENT '1=Embed HTML, 2=Link Youtube, 3=Link Artikel',
  `link` text DEFAULT NULL,
  `isi_konten` text DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konten`
--

INSERT INTO `konten` (`ID`, `nama`, `deskripsi`, `tipe_konten`, `link`, `isi_konten`, `foto`, `kategori`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Belajar HTML Dasar 1', 'Pendahuluan mengenai HTML.\r\n\r\n---\r\nIkuti Kelas Online \"Menjadi Seorang FullStack Designer dalam 15 Hari\"\r\nhttp://fullstackdesigner.id\r\n\r\n---\r\nBeli Hosting & Domain di NIAGAHOSTER\r\nKODE KUPON DISKON 10% : WPUNPAS (gunakan saat checkout)\r\nNiagaHoster : http://bit.ly/2Jx5jDV\r\n\r\n---\r\n\r\nDOWNLOAD SLIDE :\r\nhttp://www.slideshare.net/sandhikagalih\r\n\r\n\r\n---\r\n\r\nhttp://facebook.com/webprogrammingunpas\r\nhttp://codepen.io/webprogrammingunpas/\r\nhttp://twitter.com/sandhikagalih\r\nhttp://instagram.com/sandhikagalih', 2, 'https://www.youtube.com/watch?v=NBZ9Ro6UKV8&list=PLFIM0718LjIVuONHysfOK0ZtiqUWvrx4F&index=1', NULL, NULL, 1, '2021-05-30 05:59:18', NULL, NULL, NULL),
(2, 'Tutorial Pemrograman PHP untuk Pemula dari Petani Koding', 'PHP adalah bahasa pemrograman yang dirancang khusus untuk membuat web', 3, 'https://www.petanikode.com/tutorial/php/', NULL, NULL, 2, '2021-05-30 05:59:18', NULL, NULL, NULL),
(3, 'Belajar Java 1', 'Belajar Java', 1, 'www.googl.com', 'tets', '60b33721cc491.jpeg', NULL, '2021-05-30 06:56:33', 12, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `konten`
--
ALTER TABLE `konten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
