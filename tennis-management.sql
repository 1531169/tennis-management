-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Feb 2018 um 15:21
-- Server-Version: 10.1.28-MariaDB
-- PHP-Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `tennis-management`
--
CREATE DATABASE IF NOT EXISTS `tennis-management` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tennis-management`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spielplan`
--

DROP TABLE IF EXISTS `spielplan`;
CREATE TABLE `spielplan` (
  `spielplan_id` int(11) NOT NULL,
  `saison` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `spielplan`
--

INSERT INTO `spielplan` (`spielplan_id`, `saison`) VALUES
(26, '2018/2019'),
(27, '2019/2020'),
(28, '2018/2020');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spieltag`
--

DROP TABLE IF EXISTS `spieltag`;
CREATE TABLE `spieltag` (
  `spieltag_id` int(11) NOT NULL,
  `spielplan_id` int(11) NOT NULL,
  `spieldatum` date NOT NULL,
  `team1` varchar(50) DEFAULT NULL,
  `team2` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `spieltag`
--

INSERT INTO `spieltag` (`spieltag_id`, `spielplan_id`, `spieldatum`, `team1`, `team2`) VALUES
(7, 26, '2017-10-10', '', ''),
(8, 26, '2018-01-17', 'FIT', ''),
(9, 26, '2018-01-24', '', 'F&CO'),
(10, 26, '2018-01-31', 'FIT', 'FIT'),
(11, 27, '2017-10-17', 'FIT', 'F&CO'),
(12, 27, '2017-10-24', '', ''),
(13, 27, '2017-10-31', 'XYZ', 'FST'),
(14, 28, '2017-10-24', '', ''),
(15, 28, '2017-10-31', '', ''),
(16, 26, '2018-02-07', 'FIT', 'F&CO'),
(17, 26, '2018-02-14', '', ''),
(18, 26, '2018-02-21', '', ''),
(19, 28, '2018-01-24', 'FIT', 'F&CO');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `state` enum('active','inactive','disabled','deleted') NOT NULL,
  `role` enum('admin','coach','player','') NOT NULL,
  `surname` varchar(100) NOT NULL,
  `givenname` varchar(100) NOT NULL,
  `gender` char(1) NOT NULL,
  `username` varchar(767) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `email` varchar(767) NOT NULL,
  `email2` varchar(1000) DEFAULT NULL,
  `organization` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `state`, `role`, `surname`, `givenname`, `gender`, `username`, `password`, `email`, `email2`, `organization`) VALUES
(1, 'active', 'admin', 'Reinhard', 'Cedric', 'm', 'c.reinhard', '2a054709a624b49fdc26f4df94a770cce05451d5', 'cedric.reinhard@web.de', 'cedric-reinhard@web.de', 'FIT'),
(2, 'deleted', 'coach', 'Reinhard', 'Karl', 'm', 'k.reinhard', '7c73e9a40b6a85c2e7764f711ce1c87954a6f4f0', 'karl.reinhard@web.de', '', 'FIT'),
(6, 'inactive', 'player', 'Reinhard', 'Kevin', 'm', 'ke.reinhard', '6788e8009e94ae1afba1a0d7dd5c1257225af3a5', 'kevin@web.de', '', 'F&CO'),
(7, 'disabled', 'coach', 'Reinhard', 'Jessica', 'm', 'j.reinhard', '6788e8009e94ae1afba1a0d7dd5c1257225af3a5', 'jessica@web.de', '', 'FST'),
(8, 'inactive', 'coach', 'Mustermann', 'Max', 'm', 'Max', '7c73e9a40b6a85c2e7764f711ce1c87954a6f4f0', 'max@web.de', '', 'XYZ');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `spielplan`
--
ALTER TABLE `spielplan`
  ADD PRIMARY KEY (`spielplan_id`);

--
-- Indizes für die Tabelle `spieltag`
--
ALTER TABLE `spieltag`
  ADD PRIMARY KEY (`spieltag_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `spielplan`
--
ALTER TABLE `spielplan`
  MODIFY `spielplan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT für Tabelle `spieltag`
--
ALTER TABLE `spieltag`
  MODIFY `spieltag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
