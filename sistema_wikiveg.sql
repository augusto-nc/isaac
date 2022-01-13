-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 21-Dez-2021 às 23:09
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_wikiveg`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_categories`
--

DROP TABLE IF EXISTS `cl_categories`;
CREATE TABLE IF NOT EXISTS `cl_categories` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `id_ref` text NOT NULL,
  `nome` varchar(455) NOT NULL,
  `page_title` text NOT NULL,
  `tags` longtext NOT NULL,
  `small_title` varchar(455) NOT NULL,
  `imagem` text NOT NULL,
  `data_adicionado` varchar(455) NOT NULL,
  `data_update` varchar(455) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_products`
--

DROP TABLE IF EXISTS `cl_products`;
CREATE TABLE IF NOT EXISTS `cl_products` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `id_category` text NOT NULL,
  `nome` text NOT NULL,
  `id_product` text NOT NULL,
  `tipo` text NOT NULL,
  `imagem` text NOT NULL,
  `vegetal` text NOT NULL,
  `created_at` text NOT NULL,
  `qtd_like` int(99) NOT NULL,
  `qtd_review` int(99) NOT NULL,
  `qtd_comment` int(99) NOT NULL,
  `no_vegan` int(11) NOT NULL,
  `vegano` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_reviews`
--

DROP TABLE IF EXISTS `cl_reviews`;
CREATE TABLE IF NOT EXISTS `cl_reviews` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `id_produto` text NOT NULL,
  `verdict` text NOT NULL,
  `text` text NOT NULL,
  `is_review` int(11) NOT NULL,
  `created_at` text NOT NULL,
  `id_prod` text NOT NULL,
  `qtd_like` int(11) NOT NULL,
  `qtd_comment` int(11) NOT NULL,
  `name_user` text NOT NULL,
  `url_user` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_reviews_replay`
--

DROP TABLE IF EXISTS `cl_reviews_replay`;
CREATE TABLE IF NOT EXISTS `cl_reviews_replay` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `id_produto` text NOT NULL,
  `verdict` text NOT NULL,
  `text` text NOT NULL,
  `is_review` int(11) NOT NULL,
  `created_at` text NOT NULL,
  `id_prod` text NOT NULL,
  `qtd_like` int(11) NOT NULL,
  `qtd_comment` int(11) NOT NULL,
  `name_user` text NOT NULL,
  `url_user` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
