-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 16, 2022 at 10:18 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `control_acc`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumnos`
--

CREATE TABLE `alumnos` (
  `id_alumnos` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `dni` int(8) NOT NULL,
  `division` varchar(2) NOT NULL,
  `id_huella` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alumnos`
--

INSERT INTO `alumnos` (`id_alumnos`, `nombre`, `apellido`, `dni`, `division`, `id_huella`) VALUES
(1, 'Emiliano', 'Santandrea', 45780973, '7b', 0),
(2, 'Agustina', 'Jaime', 44654625, '7b', 1),
(3, 'Tobias', 'Duarte', 44687925, '7b', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fechahora`
--

CREATE TABLE `fechahora` (
  `id_fechahora` int(11) NOT NULL,
  `id_huella` int(11) NOT NULL,
  `presente` tinyint(1) NOT NULL,
  `fecha` date NOT NULL,
  `hora_llegada` time NOT NULL,
  `hora_salida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fechahora`
--

INSERT INTO `fechahora` (`id_fechahora`, `id_huella`, `presente`, `fecha`, `hora_llegada`, `hora_salida`) VALUES
(1, 0, 0, '2022-11-05', '12:05:20', '17:53:24'),
(6, 0, 0, '2022-11-08', '17:17:35', '17:53:24'),
(14, 0, 0, '2022-11-14', '09:02:18', '09:06:27'),
(49, 1, 0, '2022-11-14', '09:58:57', '09:59:12'),
(50, 2, 0, '2022-11-14', '09:59:01', '10:01:00'),
(51, 0, 0, '2022-11-14', '09:59:06', '09:59:16'),
(52, 2, 0, '2022-11-14', '09:59:21', '10:01:00'),
(53, 2, 0, '2022-11-14', '09:59:33', '10:01:00'),
(54, 2, 0, '2022-11-14', '10:01:01', '10:01:01'),
(55, 2, 0, '2022-11-14', '10:01:02', '10:01:02'),
(56, 2, 0, '2022-11-14', '10:01:06', '10:01:08'),
(57, 2, 0, '2022-11-14', '10:34:39', '10:34:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id_alumnos`);

--
-- Indexes for table `fechahora`
--
ALTER TABLE `fechahora`
  ADD PRIMARY KEY (`id_fechahora`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id_alumnos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fechahora`
--
ALTER TABLE `fechahora`
  MODIFY `id_fechahora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
