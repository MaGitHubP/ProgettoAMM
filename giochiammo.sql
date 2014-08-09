-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Lug 29, 2014 alle 00:04
-- Versione del server: 5.5.35
-- Versione PHP: 5.4.6-1ubuntu1.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `giochiammo`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `buyer`
--

CREATE TABLE IF NOT EXISTS `buyer` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_buyer` bigint(20) unsigned NOT NULL,
  `credit_card` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `id_buyer` (`id`),
  KEY `buyer_fk` (`id_buyer`),
  KEY `credit_card_fk` (`credit_card`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `buyer`
--

INSERT INTO `buyer` (`id`, `id_buyer`, `credit_card`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `credit_card`
--

CREATE TABLE IF NOT EXISTS `credit_card` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `money` float unsigned NOT NULL,
  `code` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `credit_card`
--

INSERT INTO `credit_card` (`id`, `money`, `code`) VALUES
(1, 100, 1111111111111111);

-- --------------------------------------------------------

--
-- Struttura della tabella `seller`
--

CREATE TABLE IF NOT EXISTS `seller` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_seller` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `seller_fk` (`id_seller`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `seller`
--

INSERT INTO `seller` (`id`, `id_seller`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL,
  `city` varchar(20) NOT NULL,
  `address` varchar(20) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `username`, `password`, `role`, `city`, `address`) VALUES
(1, 'Mauro', 'Pisano1', 'MauSeller', 'Pass1', 'Seller', 'Quartu', 'Via Random 1'),
(2, 'Mauro', 'Pisano2', 'MauBuyer', 'Pass2', 'Buyer', 'Domus', 'Via Random 2');

-- --------------------------------------------------------

--
-- Struttura della tabella `videogame`
--

CREATE TABLE IF NOT EXISTS `videogame` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `genre` varchar(20) NOT NULL,
  `console` varchar(20) NOT NULL,
  `relase_date` date NOT NULL,
  `price` float unsigned NOT NULL,
  `cover` blob NOT NULL,
  `owner` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `owner_fk` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dump dei dati per la tabella `videogame`
--

INSERT INTO `videogame` (`id`, `title`, `genre`, `console`, `relase_date`, `price`, `cover`, `owner`) VALUES
(1, 'Pok&eacutemon X', 'RPG', 'Nintendo 3DS', '2013-10-12', 49.99, 0x2f496d616765732f426f786172742f706f6bc3a96d6f6e782e6a7067, 1),
(2, 'Pok&eacutemon Y', 'RPG', 'Nintendo 3DS', '2013-10-12', 49.99, 0x2f496d616765732f426f786172742f706f6bc3a96d6f6e792e6a7067, 1),
(3, 'Pok&eacutemon Y', 'RPG', 'Nintendo 3DS', '2013-10-12', 49.99, 0x2f496d616765732f426f786172742f706f6bc3a96d6f6e792e6a7067, 2),
(4, 'Final Fantasy XV', 'RPG', 'PlayStation 4', '2147-00-00', 69.99, 0x2f496d616765732f426f786172742f66696e616c66616e7461737978767073342e6a7067, 1),
(5, 'Final Fantasy XV', 'RPG', 'PlayStation 4', '2147-00-00', 69.99, 0x2f496d616765732f426f786172742f66696e616c66616e7461737978767073342e6a7067, 1),
(6, 'Final Fantasy XV', 'RPG', 'XBox One', '2147-00-00', 69.99, 0x2f496d616765732f426f786172742f66696e616c66616e746173797876786f6e652e6a7067, 1),
(7, 'The Legend of Zelda:Ocarina of', 'Avventura', 'Nintendo 64', '1998-12-18', 29.99, 0x2f496d616765732f426f786172742f7a656c64616f636172696e612e6a7067, 1),
(8, 'Silent Hill 2', 'Survival Horror', 'PlayStation 2', '2001-11-23', 19.99, 0x2f496d616765732f426f786172742f73696c656e7468696c6c322e6a7067, 1),
(9, 'Super Mario Galaxy', 'Platform', 'Wii', '2007-11-16', 59.99, 0x2f496d616765732f426f786172742f73757065726d6172696f67616c6178792e6a7067, 1),
(10, 'Portal 2', 'Puzzle Game', 'PC', '2011-04-21', 69.99, 0x2f496d616765732f426f786172742f706f7274616c322e6a7067, 1),
(11, 'Half Life 2', 'Sparatutto', 'PC', '2004-11-16', 19.99, 0x2f496d616765732f426f786172742f68616c666c696665322e6a7067, 1),
(12, 'Pok&eacutemon versione Gialla', 'RPG', 'Game Boy', '2000-07-07', 19.99, 0x2f496d616765732f426f786172742f706f6bc3a96d6f6e6769616c6c6f2e6a7067, 1),
(13, 'Pok&eacutemon vers. Smeraldo', 'RPG', 'Game Boy Advance', '2005-10-21', 19.99, 0x2f496d616765732f426f786172742f706f6bc3a96d6f6e736d6572616c646f2e6a7067, 1),
(14, 'Pok&eacutemon versione Platino', 'RPG', 'Nintendo DS', '2009-05-22', 29.99, 0x2f496d616765732f426f786172742f706f6bc3a96d6f6e706c6174696e6f2e6a7067, 1),
(15, 'Tekken 3', 'Picchiaduro', 'PlayStation 1', '1998-09-12', 19.99, 0x2f496d616765732f426f786172742f74656b6b656e332e6a7067, 1),
(16, 'Halo 4', 'Sparatutto', 'XBox 360', '2012-11-06', 69.99, 0x2f496d616765732f426f786172742f68616c6f342e6a7067, 1),
(17, 'Devil May Cry 4', 'Azione', 'PlayStation 3', '2008-02-08', 29.99, 0x2f496d616765732f426f786172742f646576696c6d6179637279342e6a7067, 1),
(18, 'Animal Crossing', 'Simulazione', 'Game Cube', '2004-09-24', 29.99, 0x2f496d616765732f426f786172742f616e696d616c63726f7373696e672e6a7067, 1),
(19, 'Final Fantasy Type-0', 'RPG', 'PSP', '2011-10-27', 29.99, 0x2f496d616765732f426f786172742f666674797065302e6a7067, 1),
(20, 'Final Fantasy Type-0 HD', 'RPG', 'PlayStation 4', '2015-00-00', 69.99, 0x2f496d616765732f426f786172742f6666747970653068642e6a7067, 1);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `buyer`
--
ALTER TABLE `buyer`
  ADD CONSTRAINT `buyer_ibfk_1` FOREIGN KEY (`id_buyer`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `buyer_ibfk_2` FOREIGN KEY (`id_buyer`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `buyer_ibfk_3` FOREIGN KEY (`credit_card`) REFERENCES `credit_card` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `buyer_ibfk_4` FOREIGN KEY (`credit_card`) REFERENCES `credit_card` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `buyer_ibfk_5` FOREIGN KEY (`credit_card`) REFERENCES `credit_card` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `buyer_ibfk_6` FOREIGN KEY (`credit_card`) REFERENCES `credit_card` (`id`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `seller_ibfk_1` FOREIGN KEY (`id_seller`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `videogame`
--
ALTER TABLE `videogame`
  ADD CONSTRAINT `videogame_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
