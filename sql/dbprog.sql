-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 27. Apr 2019 um 16:51
-- Server-Version: 10.1.21-MariaDB
-- PHP-Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `dbprog`
--

--
-- Alte Tabellenstruktur löschen
--

DROP TABLE `bewertung`;
DROP TABLE `cocktail`;
DROP TABLE `cocktailkarte`;
DROP TABLE `etablissement`;
DROP TABLE `inhaltsstoffe`;
DROP TABLE `rezept`;
DROP TABLE `users`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bewertung`
--

CREATE TABLE `bewertung` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eta_id` int(11) NOT NULL,
  `cocktail_id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `wert` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cocktail`
--

CREATE TABLE `cocktail` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `beschreibung` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `etablissement`
--

CREATE TABLE `etablissement` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ort` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `anschrift` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `verifiziert` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inhaltsstoffe`
--

CREATE TABLE `inhaltsstoffe` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `beschreibung` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `alkoholhaltig` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezept`
--

CREATE TABLE `rezept` (
  `id` int(11) NOT NULL,
  `cocktail_id` int(11) NOT NULL,
  `inhalts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `passwort`, `username`, `created_at`, `updated_at`) VALUES
(1, 'test@test.de', '$2y$10$qCgb4MKzbMKAqUU2LOFBQ.wGoAD6yBElFA7V7EPwK.QGCViJjx4mu', 'test', '2019-04-19 10:05:39', NULL),
(7, 'flx@ez.de', '$2y$10$9pjjjlrzkrEpEP4zM/wCLuLDwPKlpIGZram8X1oLwTTY/dCIWQhpC', 'FLX', '2019-04-20 11:20:32', NULL),
(8, 'dude@test.de', '$2y$10$wMPXp/feXw5UcqzuDcK7qOm18xYQq.diCzJ1jtgZA.nCf075ScgvK', 'dude', '2019-04-21 14:44:15', NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bewertung`
--
ALTER TABLE `bewertung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bewertung_eta` (`eta_id`),
  ADD KEY `fk_bewertung_user` (`user_id`),
  ADD KEY `fk_bewertung_cocktail` (`cocktail_id`);

--
-- Indizes für die Tabelle `cocktail`
--
ALTER TABLE `cocktail`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cocktailkarte`
--
ALTER TABLE `cocktailkarte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_karte_cocktail` (`cocktail_id`),
  ADD KEY `fk_karte_eta` (`eta_id`);

--
-- Indizes für die Tabelle `etablissement`
--
ALTER TABLE `etablissement`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `inhaltsstoffe`
--
ALTER TABLE `inhaltsstoffe`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `rezept`
--
ALTER TABLE `rezept`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rezept_cocktail` (`cocktail_id`),
  ADD KEY `fk_rezept_inhalt` (`inhalts_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bewertung`
--
ALTER TABLE `bewertung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cocktail`
--
ALTER TABLE `cocktail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cocktailkarte`
--
ALTER TABLE `cocktailkarte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `etablissement`
--
ALTER TABLE `etablissement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `inhaltsstoffe`
--
ALTER TABLE `inhaltsstoffe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `rezept`
--
ALTER TABLE `rezept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bewertung`
--
ALTER TABLE `bewertung`
  ADD CONSTRAINT `fk_bewertung_cocktail` FOREIGN KEY (`cocktail_id`) REFERENCES `cocktail` (`id`),
  ADD CONSTRAINT `fk_bewertung_eta` FOREIGN KEY (`eta_id`) REFERENCES `etablissement` (`id`),
  ADD CONSTRAINT `fk_bewertung_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
  ADD CONSTRAINT `fk_rezept_inhalt` FOREIGN KEY (`inhalts_id`) REFERENCES `inhaltsstoffe` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
