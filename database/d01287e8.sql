-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: dd1628.kasserver.com
-- Erstellungszeit: 27. Nov 2011 um 23:25
-- Server Version: 5.1.43
-- PHP-Version: 5.2.12-nmm2



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `d01287e8`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Debt`
--

CREATE TABLE IF NOT EXISTS `Debt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creditor_id` int(11) NOT NULL,
  `debitor_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `toDelete` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creditor_id` (`creditor_id`),
  KEY `debitor_id` (`debitor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(40) NOT NULL,
  `forename` varchar(64) DEFAULT NULL,
  `surname` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `Debt`
--
ALTER TABLE `Debt`
  ADD CONSTRAINT `Debt_ibfk_1` FOREIGN KEY (`creditor_id`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `Debt_ibfk_2` FOREIGN KEY (`debitor_id`) REFERENCES `User` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
