-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/07/2024 às 03:39
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `compra`
--

CREATE TABLE IF NOT EXISTS `compra` (
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `preco_compra` decimal(10,0) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesas`
--

CREATE TABLE IF NOT EXISTS `despesas` (
  `id_despesa` int(11) NOT NULL AUTO_INCREMENT,
  `renda` decimal(10,2) NOT NULL,
  `energia` decimal(10,2) NOT NULL,
  `salarios` decimal(10,2) NOT NULL,
  `impostos` decimal(10,2) NOT NULL,
  `data_despesa` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_despesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE IF NOT EXISTS `funcionarios` (
  `funcionario_id` int(11) NOT NULL AUTO_INCREMENT,
  `salario` decimal(10,0) NOT NULL,
  `numero_de_faltas` int(11) NOT NULL,
  `vendedor_id` int(11) DEFAULT NULL,
  `limpeza_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`funcionario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `limpeza`
--

CREATE TABLE IF NOT EXISTS `limpeza` (
  `id_limpeza` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `Telefone` varchar(14) DEFAULT NULL,
  `Email` int(200) DEFAULT NULL,
  `Morada` text NOT NULL,
  PRIMARY KEY (`id_limpeza`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id_msg` int(11) NOT NULL AUTO_INCREMENT,
  `msg` varchar(200) NOT NULL,
  `tipo` set('erro','success') NOT NULL,
  `data_msg` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_msg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id_pagamento` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `metodo` varchar(50) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `data_pagamento` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pagamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `data_pedido` date NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_vendedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `id_compra` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_pedido`
--

CREATE TABLE IF NOT EXISTS `produto_pedido` (
  `id_produto_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_produto_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_vendido`
--

CREATE TABLE IF NOT EXISTS `produto_vendido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto_pedido` int(11) NOT NULL,
  `preco_vendido` decimal(10,2) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produto_pedido` (`id_produto_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE IF NOT EXISTS `venda` (
  `id_venda` int(11) NOT NULL AUTO_INCREMENT,
  `preco_venda` decimal(10,0) NOT NULL,
  `id_produto` int(11) NOT NULL,
  PRIMARY KEY (`id_venda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendedores`
--

CREATE TABLE IF NOT EXISTS `vendedores` (
  `id_vendedor` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `salario` decimal(10,0) NOT NULL,
  `usuario` varchar(10) DEFAULT NULL,
  `senha` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_vendedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
