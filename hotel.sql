-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2019 at 10:06 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nomecliente` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(100) NOT NULL,
  `sexo` varchar(11) NOT NULL,
  `telefone` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `devedor` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `nomecliente`, `email`, `cpf`, `sexo`, `telefone`, `status`, `devedor`) VALUES
(141, 'Vanessa', 'teste@teste.com', '85236497000', 'Masculino', '51998659858', 'ativo', ''),
(142, 'Teste cliente 3', 'teste@teste.com', '85236497001', 'Masculino', '51998659858', 'inativo', ''),
(143, 'Teste cliente 4', 'teste@teste.com', '85236497002', 'Masculino', '51998659858', 'ativo', ''),
(144, 'Teste cliente 5', 'teste@teste.com', '85236497003', 'Masculino', '51998659858', 'inativo', ''),
(145, 'Teste cliente 6', 'teste@teste.com', '85236497004', 'Masculino', '51998659858', 'ativo', ''),
(146, 'Teste cliente 7', 'teste@teste.com', '85236497005', 'Masculino', '51998659858', 'inativo', '');

-- --------------------------------------------------------

--
-- Table structure for table `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `cpf` varchar(100) NOT NULL,
  `telefone` varchar(100) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `tiririca` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `endereco`, `cpf`, `telefone`, `sexo`, `cargo`, `email`, `senha`, `tiririca`) VALUES
(4, 'Vanessa', 'Rua Alvorada, 105', '8523649700', '85223698', 'Feminino', 'Desenvolvedora', 'vanessa@funcionario.com', '123', NULL),
(5, 'Fernando', 'Rua Umbu, 1023', '5879642100', '456', 'Masculino', 'slat', 'teste@gmail.com', '123', NULL),
(6, 'Administrador', 'Av. Baltazar, 168', '123456789', '85369874', 'Feminino', 'suporte', 'admin@gmail.com', '123', 'admin'),
(7, 'Estrangeiro', 'Rua Paulo Renato Ketzer', '03285487562', '93559864', 'Masculino', 'Tester', 'estrangeiro@gmail.com', '123456', NULL),
(8, 'vanny', 'rua tal', '85236497022', '777', 'Feminino', 'testatndo@gmail.com', 'vanny@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `clientechave` int(11) NOT NULL,
  `tipoquartochave` int(11) NOT NULL,
  `dia` date NOT NULL,
  `obs` varchar(100) NOT NULL,
  `diasaida` date NOT NULL,
  `funcionariochave` int(11) NOT NULL,
  `horarioinicial` time NOT NULL,
  `numreserva` varchar(100) NOT NULL,
  `horariofinal` time NOT NULL,
  `status` enum('A','F') DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`id`, `clientechave`, `tipoquartochave`, `dia`, `obs`, `diasaida`, `funcionariochave`, `horarioinicial`, `numreserva`, `horariofinal`) VALUES
(1, 142, 6, '2019-11-23', 'teste', '2019-11-24', 4, '14:00:00', '101', '14:00:00'),
(4, 141, 2, '2019-11-26', 'Sem observações.', '2019-11-29', 4, '13:00:00', '32432', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tipoprodutos`
--

CREATE TABLE `tipoprodutos` (
  `id` int(100) NOT NULL,
  `nomeproduto` varchar(10) NOT NULL,
  `precoproduto` decimal(10,2) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipoprodutos`
--

INSERT INTO `tipoprodutos` (`id`, `nomeproduto`, `precoproduto`, `status`) VALUES
(1, 'Coca-Cola', '5.00', 'Ativo');

-- --------------------------------------------------------

--
-- Table structure for table `tipoquartos`
--

CREATE TABLE `tipoquartos` (
  `id` int(11) NOT NULL,
  `nomequarto` varchar(100) NOT NULL,
  `precoquarto` decimal(10,2) NOT NULL,
  `status` varchar(100) NOT NULL,
  `numeroquarto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipoquartos`
--

INSERT INTO `tipoquartos` (`id`, `nomequarto`, `precoquarto`, `status`, `numeroquarto`) VALUES
(1, 'Quarto 1 ', '20.00', 'Ativo', 100),
(2, 'Quarto 2', '30.00', 'Ativo', 101),
(3, 'Quarto 3', '40.00', 'Ativo', 102),
(4, 'Quarto 4', '50.00', 'Ativo', 200),
(5, 'Quarto 5', '60.00', 'Inativo', 201),
(6, 'Luxo', '100.00', 'Ativo', 300),
(7, 'Quarto 6', '70.00', 'Ativo', 301);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_fk` (`clientechave`),
  ADD KEY `tiposervico_fk` (`tipoquartochave`),
  ADD KEY `funcionario_fk` (`funcionariochave`);

--
-- Indexes for table `tipoprodutos`
--
ALTER TABLE `tipoprodutos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipoquartos`
--
ALTER TABLE `tipoquartos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tipoprodutos`
--
ALTER TABLE `tipoprodutos`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tipoquartos`
--
ALTER TABLE `tipoquartos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `cliente_fk` FOREIGN KEY (`clientechave`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `funcionario_fk` FOREIGN KEY (`funcionariochave`) REFERENCES `funcionarios` (`id`),
  ADD CONSTRAINT `tipoquarto_fk` FOREIGN KEY (`tipoquartochave`) REFERENCES `tipoquartos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
