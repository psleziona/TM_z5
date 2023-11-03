-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql01.slezionp.beep.pl:3306
-- Generation Time: Lis 03, 2023 at 08:09 AM
-- Wersja serwera: 5.7.31-34-log
-- Wersja PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `z5_slezionp`
--
CREATE DATABASE IF NOT EXISTS `z5_slezionp` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `z5_slezionp`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `break_ins`
--

CREATE TABLE `break_ins` (
  `id` int(11) NOT NULL,
  `ip` text COLLATE utf8_polish_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `break_ins`
--

INSERT INTO `break_ins` (`id`, `ip`, `date`, `user`) VALUES
(1, '83.21.236.211', '2023-10-25 11:18:21', 'admin'),
(2, '83.21.236.211', '2023-10-25 11:58:53', 'admin'),
(3, '83.21.236.211', '2023-10-25 13:22:22', 'admin'),
(4, '83.21.236.211', '2023-10-25 13:37:39', 'admin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `goscieportalu`
--

CREATE TABLE `goscieportalu` (
  `id` int(11) NOT NULL,
  `ipaddress` text COLLATE utf8_polish_ci NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `browser` text COLLATE utf8_polish_ci NOT NULL,
  `resolution` text COLLATE utf8_polish_ci NOT NULL,
  `browserResolution` text COLLATE utf8_polish_ci NOT NULL,
  `colors` text COLLATE utf8_polish_ci NOT NULL,
  `cookies` tinyint(1) NOT NULL,
  `aplets` tinyint(1) NOT NULL,
  `language` text COLLATE utf8_polish_ci NOT NULL,
  `counter` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `goscieportalu`
--

INSERT INTO `goscieportalu` (`id`, `ipaddress`, `datetime`, `browser`, `resolution`, `browserResolution`, `colors`, `cookies`, `aplets`, `language`, `counter`) VALUES
(0, '83.21.236.211', '2023-10-26 15:40:33', 'Chrome 118.0.0.0', '1920x1080', '1920x1032', '24', 1, 0, 'pl-PL', 15),
(0, '89.64.5.27', '2023-11-02 17:51:24', 'Chrome 118.0.0.0', '1680x1050', '1680x1002', '24', 1, 0, 'pl-PL', 18),
(0, '89.64.7.75', '2023-10-29 09:56:33', 'Opera 102.0.0.0', '1920x1080', '1920x1080', '24', 1, 0, 'pl-PL', 1),
(0, '83.21.238.71', '2023-10-30 08:18:26', 'Chrome 118.0.0.0', '1920x1080', '1920x1032', '24', 1, 0, 'pl-PL', 1),
(0, '83.21.210.198', '2023-10-30 09:37:53', 'Chrome 118.0.0.0', '1920x1080', '1920x1032', '24', 1, 0, 'pl-PL', 2),
(0, '83.21.212.112', '2023-10-30 13:53:42', 'Chrome 118.0.0.0', '1920x1080', '1920x1032', '24', 1, 0, 'pl-PL', 3),
(0, '86.111.115.165', '2023-11-01 12:16:45', 'Chrome 118.0.0.0', '1536x864', '1536x816', '24', 1, 0, 'pl-PL', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `idk` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text COLLATE utf8_polish_ci NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `recipient` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` smallint(6) NOT NULL,
  `username` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `avatar` text COLLATE utf8_polish_ci NOT NULL,
  `failed_login_attempts` int(11) NOT NULL,
  `account_locked_until` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `avatar`, `failed_login_attempts`, `account_locked_until`) VALUES
(0, 'admin', 'admin', 'admin.jpg', 0, '0000-00-00 00:00:00'),
(0, 'test1', '1', '', 1, '0000-00-00 00:00:00'),
(0, 'test2', '1', '', 1, '0000-00-00 00:00:00'),
(0, 'test', 'test', '', 0, '0000-00-00 00:00:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `break_ins`
--
ALTER TABLE `break_ins`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `break_ins`
--
ALTER TABLE `break_ins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
