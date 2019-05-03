-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 03. Mai 2019 um 14:22
-- Server-Version: 10.1.21-MariaDB
-- PHP-Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `dbprog` clearen
--

DROP DATABASE `dbprog`;
CREATE DATABASE `dbprog`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bewertung_cocktail`
--

CREATE TABLE `bewertung_cocktail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eta_id` int(11) NOT NULL,
  `cocktail_id` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `wert` enum('1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `bewertung_cocktail`
--

INSERT INTO `bewertung_cocktail` (`id`, `user_id`, `timestamp`, `eta_id`, `cocktail_id`, `text`, `wert`) VALUES
(1, 1, '2019-05-03 08:22:26', 1, 3, 'Schmeckt wohl.', '5'),
(2, 1, '2019-05-03 08:22:53', 2, 4, 'Was das denn', '1'),
(3, 1, '2019-05-03 12:21:38', 2, 2, 'Test', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bewertung_etablissement`
--

CREATE TABLE `bewertung_etablissement` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `eta_id` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `wert` enum('1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Daten für Tabelle `bewertung_etablissement`
--

INSERT INTO `bewertung_etablissement` (`id`, `user_id`, `timestamp`, `eta_id`, `text`, `wert`) VALUES
(1, 1, '2019-05-03 12:10:27', 1, 'Ganz nett', '2'),
(2, 7, '2019-05-03 12:10:43', 2, 'Geiler Scheiß', '5');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cocktail`
--

CREATE TABLE `cocktail` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `beschreibung` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `cocktail`
--

INSERT INTO `cocktail` (`id`, `name`, `beschreibung`) VALUES
(1, 'So ein Cocktail', 'Hier könnte Ihre Werbung stehen.'),
(2, 'Anderer Cocktail', 'Blahblah'),
(3, 'Cocktail ABC', 'Was ist das für ein Müll'),
(4, 'Der name sollte maybe unique sein?', 'not sure tho\r\n');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cocktailkarte`
--

CREATE TABLE `cocktailkarte` (
  `id` int(11) NOT NULL,
  `eta_id` int(11) NOT NULL,
  `cocktail_id` int(11) NOT NULL,
  `preis` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `cocktailkarte`
--

INSERT INTO `cocktailkarte` (`id`, `eta_id`, `cocktail_id`, `preis`) VALUES
(1, 1, 2, '5.00'),
(2, 1, 4, '123.00'),
(3, 1, 1, '16.00'),
(5, 2, 3, '12.00'),
(7, 2, 4, '44.55');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `etablissement`
--

CREATE TABLE `etablissement` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ort` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `anschrift` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `verifiziert` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `etablissement`
--

INSERT INTO `etablissement` (`id`, `name`, `ort`, `anschrift`, `verifiziert`) VALUES
(1, 'Isoein Laden', 'Hameln', 'blabla straße 192', 0),
(2, 'Baka', 'Dortmund', 'Die eine Straße 10', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inhaltsstoff`
--

CREATE TABLE `inhaltsstoff` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `beschreibung` text COLLATE utf8_unicode_ci NOT NULL,
  `alkoholhaltig` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `inhaltsstoff`
--

INSERT INTO `inhaltsstoff` (`id`, `name`, `beschreibung`, `alkoholhaltig`) VALUES
(1, 'Cola', 'Cola eben', 0),
(2, 'Rum', 'ALKOHOL', 1),
(3, 'Ouzo', 'Welcher Wahnsinnige kippt Ouzo in Cocktails??', 1),
(4, 'Hat Alkohol', 'True', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezept`
--

CREATE TABLE `rezept` (
  `id` int(11) NOT NULL,
  `cocktail_id` int(11) NOT NULL,
  `inhalts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `rezept`
--

INSERT INTO `rezept` (`id`, `cocktail_id`, `inhalts_id`) VALUES
(9, 1, 4),
(1, 2, 1),
(2, 2, 3),
(7, 3, 1),
(8, 3, 2),
(11, 4, 2),
(10, 4, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vorname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nachname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` tinyint(3) DEFAULT NULL,
  `beruf` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `email`, `passwort`, `username`, `vorname`, `nachname`, `age`, `beruf`, `created_at`, `updated_at`) VALUES
(1, 'test@test.de', '$2y$10$qCgb4MKzbMKAqUU2LOFBQ.wGoAD6yBElFA7V7EPwK.QGCViJjx4mu', 'test', 'Test-Account', 'Sampled', 127, 'Tester', '2019-04-19 10:05:39', '2019-04-28 13:00:17'),
(7, 'flx@ez.de', '$2y$10$9pjjjlrzkrEpEP4zM/wCLuLDwPKlpIGZram8X1oLwTTY/dCIWQhpC', 'FLX', 'Felix', 'Pause', 21, 'Developer of this shit.', '2019-04-20 11:20:32', '2019-04-30 07:46:35'),
(8, 'dude@dude.dude', '$2y$10$m53ZQ.6xRPIcwKqFVDKZhu5wlWB5jZNI80NY18sDqB2wDu8NieUjG', 'dude', NULL, NULL, NULL, NULL, '2019-04-21 14:44:15', '2019-04-28 14:16:25');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bewertung_cocktail`
--
ALTER TABLE `bewertung_cocktail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`eta_id`,`cocktail_id`),
  ADD KEY `fk_bewertung_eta` (`eta_id`),
  ADD KEY `fk_bewertung_user` (`user_id`),
  ADD KEY `fk_bewertung_cocktail` (`cocktail_id`);

--
-- Indizes für die Tabelle `bewertung_etablissement`
--
ALTER TABLE `bewertung_etablissement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`eta_id`),
  ADD KEY `fk_bew_eta_eta` (`eta_id`);

--
-- Indizes für die Tabelle `cocktail`
--
ALTER TABLE `cocktail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `cocktailkarte`
--
ALTER TABLE `cocktailkarte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eta_id` (`eta_id`,`cocktail_id`),
  ADD KEY `fk_karte_cocktail` (`cocktail_id`),
  ADD KEY `fk_karte_eta` (`eta_id`);

--
-- Indizes für die Tabelle `etablissement`
--
ALTER TABLE `etablissement`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `inhaltsstoff`
--
ALTER TABLE `inhaltsstoff`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `rezept`
--
ALTER TABLE `rezept`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cocktail_id` (`cocktail_id`,`inhalts_id`),
  ADD KEY `fk_rezept_cocktail` (`cocktail_id`),
  ADD KEY `fk_rezept_inhalt` (`inhalts_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bewertung_cocktail`
--
ALTER TABLE `bewertung_cocktail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `bewertung_etablissement`
--
ALTER TABLE `bewertung_etablissement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `cocktail`
--
ALTER TABLE `cocktail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `cocktailkarte`
--
ALTER TABLE `cocktailkarte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `etablissement`
--
ALTER TABLE `etablissement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `inhaltsstoff`
--
ALTER TABLE `inhaltsstoff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `rezept`
--
ALTER TABLE `rezept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bewertung_cocktail`
--
ALTER TABLE `bewertung_cocktail`
  ADD CONSTRAINT `fk_bew_cock_cocktail` FOREIGN KEY (`cocktail_id`) REFERENCES `cocktail` (`id`),
  ADD CONSTRAINT `fk_bew_cock_eta` FOREIGN KEY (`eta_id`) REFERENCES `etablissement` (`id`),
  ADD CONSTRAINT `fk_bew_cock_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `bewertung_etablissement`
--
ALTER TABLE `bewertung_etablissement`
  ADD CONSTRAINT `fk_bew_eta_eta` FOREIGN KEY (`eta_id`) REFERENCES `etablissement` (`id`),
  ADD CONSTRAINT `fk_bew_eta_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `cocktailkarte`
--
ALTER TABLE `cocktailkarte`
  ADD CONSTRAINT `fk_karte_cocktail` FOREIGN KEY (`cocktail_id`) REFERENCES `cocktail` (`id`),
  ADD CONSTRAINT `fk_karte_eta` FOREIGN KEY (`eta_id`) REFERENCES `etablissement` (`id`);

--
-- Constraints der Tabelle `rezept`
--
ALTER TABLE `rezept`
  ADD CONSTRAINT `fk_rezept_cocktail` FOREIGN KEY (`cocktail_id`) REFERENCES `cocktail` (`id`),
  ADD CONSTRAINT `fk_rezept_inhalt` FOREIGN KEY (`inhalts_id`) REFERENCES `inhaltsstoff` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
