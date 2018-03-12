-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 23. Jan 2018 um 16:09
-- Server-Version: 10.1.28-MariaDB
-- PHP-Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `pizza-service`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orderedPizza`
--

CREATE TABLE `orderedPizza` (
  `pizzaID` int(10) UNSIGNED NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `fOrderID` int(10) UNSIGNED NOT NULL,
  `fID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orderPizza`
--

CREATE TABLE `orderPizza` (
  `orderID` int(10) UNSIGNED NOT NULL,
  `addressCustomer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `orderTimestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `supply`
--

CREATE TABLE `supply` (
  `id` int(10) UNSIGNED NOT NULL,
  `pizzaName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `supply`
--

INSERT INTO `supply` (`id`, `pizzaName`, `image`, `price`) VALUES
(1, 'Margherita ', 'pizza-margherita.png ', 400),
(2, 'Salami', 'pizza-salami.png', 450),
(3, 'Hawaii', 'pizza-hawaii.png', 550),
(4, 'Diavolo', 'pizza-diavolo.png', 1050);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `orderedPizza`
--
ALTER TABLE `orderedPizza`
  ADD PRIMARY KEY (`pizzaID`),
  ADD KEY `orderedPizza_fk_1` (`fOrderID`),
  ADD KEY `orderedPizza_fk_2` (`fID`);

--
-- Indizes für die Tabelle `orderPizza`
--
ALTER TABLE `orderPizza`
  ADD PRIMARY KEY (`orderID`);

--
-- Indizes für die Tabelle `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `orderedPizza`
--
ALTER TABLE `orderedPizza`
  MODIFY `pizzaID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `orderPizza`
--
ALTER TABLE `orderPizza`
  MODIFY `orderID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `supply`
--
ALTER TABLE `supply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `orderedPizza`
--
ALTER TABLE `orderedPizza`
  ADD CONSTRAINT `orderedPizza_fk_1` FOREIGN KEY (`fOrderID`) REFERENCES `orderPizza` (`orderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderedPizza_fk_2` FOREIGN KEY (`fID`) REFERENCES `supply` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
