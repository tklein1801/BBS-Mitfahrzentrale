-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 05. Mai 2021 um 21:58
-- Server-Version: 10.1.48-MariaDB-0+deb9u2
-- PHP-Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bbs-mitfahrzentrale-v2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cshare_apiLogs`
--

CREATE TABLE `cshare_apiLogs` (
  `logId` int(11) NOT NULL,
  `response_code` int(3) NOT NULL,
  `requestedPath` varchar(40) NOT NULL,
  `requestedIp` varchar(15) NOT NULL,
  `requestKey` varchar(16) DEFAULT NULL,
  `requestedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cshare_favorites`
--

CREATE TABLE `cshare_favorites` (
  `favoriteId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `rideId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cshare_plz`
--

CREATE TABLE `cshare_plz` (
  `plzId` int(11) NOT NULL,
  `plz` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cshare_rides`
--

CREATE TABLE `cshare_rides` (
  `rideId` int(11) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `driver` int(1) NOT NULL,
  `title` varchar(50) NOT NULL,
  `information` varchar(250) NOT NULL,
  `price` int(4) NOT NULL,
  `seats` int(2) NOT NULL,
  `startAt` int(11) NOT NULL,
  `startPlz` int(5) NOT NULL,
  `startCity` varchar(40) NOT NULL,
  `startAdress` varchar(40) NOT NULL,
  `destinationPlz` int(5) NOT NULL,
  `destinationCity` varchar(40) NOT NULL,
  `destinationAdress` varchar(40) NOT NULL,
  `createdAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cshare_user`
--

CREATE TABLE `cshare_user` (
  `userId` int(11) NOT NULL,
  `verified` int(1) NOT NULL DEFAULT '0',
  `isAdmin` int(1) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(50) NOT NULL,
  `telNumber` varchar(18) NOT NULL,
  `apiKey` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cshare_apiLogs`
--
ALTER TABLE `cshare_apiLogs`
  ADD PRIMARY KEY (`logId`);

--
-- Indizes für die Tabelle `cshare_favorites`
--
ALTER TABLE `cshare_favorites`
  ADD PRIMARY KEY (`favoriteId`),
  ADD KEY `cshare_rides-cshare_favorites` (`rideId`),
  ADD KEY `cshare_user-cshare_favorites` (`userId`);

--
-- Indizes für die Tabelle `cshare_plz`
--
ALTER TABLE `cshare_plz`
  ADD PRIMARY KEY (`plzId`);

--
-- Indizes für die Tabelle `cshare_rides`
--
ALTER TABLE `cshare_rides`
  ADD PRIMARY KEY (`rideId`),
  ADD KEY `cshare_user-cshare_rides` (`creatorId`);

--
-- Indizes für die Tabelle `cshare_user`
--
ALTER TABLE `cshare_user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cshare_apiLogs`
--
ALTER TABLE `cshare_apiLogs`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `cshare_favorites`
--
ALTER TABLE `cshare_favorites`
  MODIFY `favoriteId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `cshare_plz`
--
ALTER TABLE `cshare_plz`
  MODIFY `plzId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `cshare_rides`
--
ALTER TABLE `cshare_rides`
  MODIFY `rideId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `cshare_user`
--
ALTER TABLE `cshare_user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cshare_favorites`
--
ALTER TABLE `cshare_favorites`
  ADD CONSTRAINT `cshare_rides-cshare_favorites` FOREIGN KEY (`rideId`) REFERENCES `cshare_rides` (`rideId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cshare_user-cshare_favorites` FOREIGN KEY (`userId`) REFERENCES `cshare_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `cshare_rides`
--
ALTER TABLE `cshare_rides`
  ADD CONSTRAINT `cshare_user-cshare_rides` FOREIGN KEY (`creatorId`) REFERENCES `cshare_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
