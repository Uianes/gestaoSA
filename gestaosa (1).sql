-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/11/2024 às 20:43
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestaosa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `patrimonio`
--

CREATE TABLE `patrimonio` (
  `N_Patrimonio` varchar(20) NOT NULL,
  `Descricao` text NOT NULL,
  `Data_Entrada` date NOT NULL,
  `Localizacao` set('EMEI Pequeno Paraíso','EMEI Vaga-Lume','EMEI Vovó Amália','EMEF Sol Nascente','EMEF Rui Barbosa','EMEF Antônio João','EMEF São João','EMEF Antônio Liberato','SME') NOT NULL,
  `Descricao_Localizacao` varchar(500) NOT NULL,
  `Status` set('Tombado','Descarte') NOT NULL,
  `Memorando` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `patrimonio`
--

INSERT INTO `patrimonio` (`N_Patrimonio`, `Descricao`, `Data_Entrada`, `Localizacao`, `Descricao_Localizacao`, `Status`, `Memorando`) VALUES
('13', 'aaaaaaaaaaaa', '2024-11-27', 'EMEI Pequeno Paraíso', 'ffffffffffff', 'Descarte', '34'),
('asd', '43', '2024-11-22', 'EMEI Vaga-Lume', '23', 'Descarte', '12');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `patrimonio`
--
ALTER TABLE `patrimonio`
  ADD PRIMARY KEY (`N_Patrimonio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
