-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 03:48 AM
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
-- Database: `fesifo4_smkdm`
--

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id_sub` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `judul_buku` varchar(255) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `ringkasan` text DEFAULT NULL,
  `tanggal_input` datetime DEFAULT current_timestamp(),
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `catatan_guru` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id_sub`, `id_user`, `judul_buku`, `penulis`, `ringkasan`, `tanggal_input`, `status`, `catatan_guru`) VALUES
(1, 2, 'testes', 'ger', 'redt', '2026-04-28 14:18:49', 'disetujui', NULL),
(2, 2, 'RUMAH', 'Js Kahiren', 'sedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdghsedrfgdfgdfghfdgh', '2026-04-28 14:24:43', 'disetujui', NULL),
(3, 2, 'sdf', 'dfghdf', 'gdfdfb', '2026-04-28 14:33:00', 'disetujui', NULL),
(4, 2, 'gghj', 'aasd', 'tere liye', '2026-04-28 15:14:48', 'disetujui', NULL),
(5, 2, 'gghj', 'tere lite', 'adfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe radfas sd fwsrfewrwrsdrfwse we rwerwerwer we rwerwe r', '2026-04-28 15:17:18', 'ditolak', NULL),
(6, 2, 'gghj', 'tere lite', 'sdfwegevr erterterterter sdfwegevr ertertertertersdfwegevr ertertertertersdfwegevr ertertertertersdfwegevr ertertertertersdfwegevr ertertertertersdfwegevr erterterterter', '2026-04-28 15:27:24', 'ditolak', NULL),
(7, 2, 'sdfsfgd', 'gdgegwe', 'faertwe456ne 45r56 y56 ye5 e 56u56u5ur5u5 u u56 7u 5ur56u6r57 ir67 i56u57ui 7', '2026-04-28 15:31:36', 'ditolak', 'gehuuu'),
(8, 2, 'Laskar Pelangi', 'gehu pedas', 'apa yang menjadi tahapan yang dilakukan oleh sang maha kuasa????', '2026-04-29 06:33:16', 'disetujui', NULL),
(9, 3, 'Laskar Pelangiwww', 'gehu pedasssss', 'ada yang lain dan ada yang merah setiap hari kusiram semuaaa', '2026-04-29 06:35:34', 'ditolak', 'reviewnya tidak berbobot'),
(10, 3, 'Bumi', 'Tere LIYE', 'apa yang menjadi kesusahan orang yang akan emnjalani apa yang akan diharapi orang tersebut sehingga bisa dilakuakn penagkapan oleh yang bersangkuran', '2026-04-29 06:48:34', 'disetujui', NULL),
(11, 2, 'Bumi', 'Tere LIYE', 'sdfe', '2026-04-29 07:37:02', 'disetujui', NULL),
(12, 2, 'asdas', 'sdfsdf', 'sfwsefwerfawe awer faertgersdr rt gysrytgseraerjfha ahr haae f aoe awher auiwerfuawserhuiw awrhtuiwio hwr thawr  auiher', '2026-04-29 08:25:52', 'disetujui', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('guru','siswa','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(2, 'Ranti Tri Aulianti', 'titiw', '$2y$10$7MAboO2M1vTKBSvlgGtn.eAvzF84LbKA0EC/PyxObAb0REEdrlv9K', 'siswa'),
(3, 'Ade Rangga Asyani', 'rangga', '$2y$10$TmOk3hLqxEAMzf5pqZaTH.pUwUeYDoZUGtuBegVgphggNBQpbOeDu', 'siswa'),
(4, 'Admin Cuyyy', 'admin', '$2y$10$d/6j.rzyXyCsdhj4/mYQsueMU4kb1e31hA.3WKjrE8O51jIm3cjkG', 'admin'),
(7, 'Ilfan Muhammad Rizki, S.Pd., Gr.', 'rizkilfan', '$2y$10$JQkI6YqZUzXsvhg0tZ8SYOP9SB3Yaz4JkvvuUDdgKf.vfvPbw2IYq', 'guru'),
(8, 'Guru Tes', 'guru', '$2y$10$zilnaj1x/wriO5Mu4uCsvuHcx2lY0QMR/SeRBTxVL7tn1RAirhaMG', 'guru'),
(9, 'Siswa Tes', 'siswa', '$2y$10$dWhRwwZHYRvYegHUX0jHzOh3B0erPzRSt9Vo3qM4kNU9oQTZrvtQ6', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id_sub`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
