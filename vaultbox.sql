-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2022 at 10:38 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaultbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `filename`, `folder`, `size`, `path`) VALUES
(24, '1.png', 'W0qmPQID957C', '-', ''),
(25, 'pngegg.png', 'x7QTwaXYLAhU', '-', ''),
(26, '2.png', 'W0qmPQID957C', '-', ''),
(27, 'pngegg.png', 'W0qmPQID957C', '-', ''),
(28, '1.jpg', 'W0qmPQID957C', '-', ''),
(29, 'abstract-background-with-squares.zip', 'W0qmPQID957C', '-', ''),
(35, 'Microblog coba.png', 'W0qmPQID957C', '1.05 MB', 'W0qmPQID957C/Microblog coba.png'),
(36, 'Screenshot 2022-06-27 102849.png', 'W0qmPQID957C', '0.22 MB', 'W0qmPQID957C/Screenshot 2022-06-27 102849.png'),
(37, 'SERTTIFIKAT ASESOR BANSM.pdf', 'W0qmPQID957C', '1.67 MB', 'W0qmPQID957C/SERTTIFIKAT ASESOR BANSM.pdf'),
(38, 'favicon.png', 'XHvmdOtaTfZs', '0.25 MB', 'XHvmdOtaTfZs/favicon.png'),
(39, 'Sertifikat Pelatihan Desain 2022-20220722T084856Z-001.zip', 'XHvmdOtaTfZs', '24.10 MB', 'XHvmdOtaTfZs/Sertifikat Pelatihan Desain 2022-20220722T084856Z-001.zip'),
(40, 'SERTTIFIKAT ASESOR BANSM_rotated.pdf', 'QFmVq8PER1hn', '1.67 MB', 'QFmVq8PER1hn/SERTTIFIKAT ASESOR BANSM_rotated.pdf'),
(41, 'SERTTIFIKAT ASESOR BANSM.pdf', 'QFmVq8PER1hn', '1.67 MB', 'QFmVq8PER1hn/SERTTIFIKAT ASESOR BANSM.pdf'),
(45, 'Surat Undangan SD GM 2022.docx', '9gStHR8WVE31', '0.35 MB', '9gStHR8WVE31/Surat Undangan SD GM 2022.docx'),
(47, 'SERTTIFIKAT ASESOR BANSM_rotated.pdf', 'dr2ySOVx7ls9', '1.67 MB', 'dr2ySOVx7ls9/SERTTIFIKAT ASESOR BANSM_rotated.pdf'),
(48, 'Surat Undangan SD GM 2022.docx', 'dr2ySOVx7ls9', '0.35 MB', 'dr2ySOVx7ls9/Surat Undangan SD GM 2022.docx'),
(49, 'Firebase_Logo.png', 'W0qmPQID957C', '0.02 MB', 'W0qmPQID957C/Firebase_Logo.png'),
(50, 'SERTTIFIKAT ASESOR BANSM.pdf', 'XVOupAU9gWwl', '1.67 MB', 'XVOupAU9gWwl/SERTTIFIKAT ASESOR BANSM.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `token`) VALUES
(1, 'MTY1ODU2ODA5Ni4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI='),
(2, 'MTY1ODU2ODQwOS4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI='),
(3, 'MTY1ODU2ODU0Ni4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI='),
(4, 'MTY1ODU2ODYxNS4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI='),
(5, 'MTY1ODU2OTI1OC4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI='),
(6, 'MTY1ODU2OTM0Mi4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI='),
(7, 'MTY1ODU2OTU1Ni4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI='),
(8, 'MTY1ODU3MDM4MC4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI='),
(9, 'MTY1OTE3NTIyMC4xLjEtYmlzbWlsbGFoYWxsYWh1YWtiYXI=');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`) VALUES
(1, 'fikriafa289@gmail.com', 'siren', '$2y$10$iSCINBP5av2seKU3qKxLjObSYUdITlB0ccZzSThBcoXrtR4j6Klrq'),
(5, '2010118210009@mhs.ulm.ac.id', 'ahmad', '$2y$10$oKiosxm4UcWXSptuOaepK.PWLXX36vxoPwM8VndrVmGgrcCqzI/Ju');

-- --------------------------------------------------------

--
-- Table structure for table `vault`
--

CREATE TABLE `vault` (
  `id` int(255) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `withkeyword` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vault`
--

INSERT INTO `vault` (`id`, `uid`, `name`, `owner`, `withkeyword`, `keyword`, `access`) VALUES
(15, 'W0qmPQID957C', 'My First Vault', '1', '1', '123', 'owner'),
(20, 'dr2ySOVx7ls9', 'coba', '1', '1', 'coba', 'anyone'),
(21, 'XVOupAU9gWwl', 'recourse', '5', '1', '123', 'owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vault`
--
ALTER TABLE `vault`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vault`
--
ALTER TABLE `vault`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
