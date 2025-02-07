-- phpMyAdmin SQL Dump
-- version 5.2.1-5.fc41
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 31, 2025 at 01:38 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestaosa`
--

-- --------------------------------------------------------

--
-- Table structure for table `patrimonio`
--

CREATE TABLE `patrimonio` (
  `N_Patrimonio` varchar(20) NOT NULL,
  `Descricao` text NOT NULL,
  `Data_Entrada` date NOT NULL,
  `Localizacao` set('EMEI Pequeno Paraíso','EMEI Vaga-Lume','EMEI Vovó Amália','EMEF Sol Nascente','EMEF Rui Barbosa','EMEF Antônio João','EMEF São João','EMEF Antônio Liberato','SME') NOT NULL,
  `Descricao_Localizacao` varchar(500) NOT NULL,
  `Status` set('Tombado','Descarte') NOT NULL,
  `Memorando` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `patrimonio`
--
ALTER TABLE `patrimonio`
  ADD PRIMARY KEY (`N_Patrimonio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
