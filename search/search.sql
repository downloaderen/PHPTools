-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 23. 09 2016 kl. 08:31:57
-- Serverversion: 5.7.11
-- PHP-version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `search`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Bundkort'),
(2, 'Grafikkort'),
(3, 'Strømforsyninger');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `models`
--

INSERT INTO `models` (`id`, `name`) VALUES
(1, 'Asus'),
(2, 'MSI'),
(3, 'Gigabyte'),
(4, 'Evga'),
(5, 'Cooler Master');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `fkCategoryId` int(11) NOT NULL,
  `fkModelId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `fkCategoryId`, `fkModelId`) VALUES
(1, 'Cooler Master G750M, 750W PSU', 699, 3, 5),
(2, 'EVGA SuperNOVA 750 G2, 750W PSU', 899, 3, 4),
(3, 'MSI A88XM-E35 V2, Socket FM2+', 495, 1, 2),
(4, 'MSI X99A GODLIKE GAMING CARBON', 4599, 1, 2),
(5, 'ASUS X99-E-10G WS, Socket-2011-3', 5149, 1, 1),
(6, 'ASUS ROG Maximus VIII Formula, S-1151', 2799, 1, 1),
(7, 'EVGA GeForce GTX 1080 SC Gaming', 5490, 2, 4),
(8, 'Gigabyte GeForce GTX 1070 G1 Gaming', 3699, 2, 3);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Tilføj AUTO_INCREMENT i tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
