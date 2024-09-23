-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Nov 19. 11:43
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `palyazat`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `dokumentum`
--

CREATE TABLE `dokumentum` (
  `sorszam` int(3) NOT NULL,
  `beszamolo` varchar(255) DEFAULT NULL,
  `hatarido` date NOT NULL,
  `ellhatarido` date NOT NULL,
  `teljesult` tinyint(1) NOT NULL DEFAULT 0,
  `kifizetett` int(10) NOT NULL,
  `merfoldko` varchar(8) NOT NULL,
  `rneve` varchar(20) NOT NULL,
  `dokumentum` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `dokumentum`
--

INSERT INTO `dokumentum` (`sorszam`, `beszamolo`, `hatarido`, `ellhatarido`, `teljesult`, `kifizetett`, `merfoldko`, `rneve`, `dokumentum`) VALUES
(1, NULL, '2023-11-18', '2023-11-18', 0, 100, 'M001', 'Kovács Béla', NULL),
(1, 'sfdh', '2023-11-18', '2023-11-18', 0, 4, 'M001', 'péter', 'fg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `email` varchar(20) NOT NULL,
  `nev` varchar(30) NOT NULL,
  `jelszo` char(255) NOT NULL,
  `bevanejelentkezve` tinyint(1) NOT NULL DEFAULT 0,
  `szerepkor` varchar(14) NOT NULL DEFAULT 'témafelelös',
  `utolsobelepesidopontja` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalo`
--

INSERT INTO `felhasznalo` (`email`, `nev`, `jelszo`, `bevanejelentkezve`, `szerepkor`, `utolsobelepesidopontja`) VALUES
('gg', 'gg', '$2y$10$BNldJx0Dyhfk3BN8DkCfjOPIZFiII/h79KLESpNH36EuIPJEH9FPe', 0, 'témafelelös', '2023-11-19 11:22:33'),
('ii', 'oo', '$2y$10$s5YqPAmzH2lMAG8YdWZZdeJJGgKIF3AbgugnZFQtL.Grl2anYfbVm', 0, 'admin', '2023-11-19 11:33:26'),
('pp', 'pp', '$2y$10$ro5hj6eDg8DtilMGQnnZg.qswcozJx43hiGC.1oxcKqFOxfnH1AO2', 0, 'témafelelös', '2023-11-19 11:27:09'),
('oo', 'uu', '$2y$10$WyVWuGTeiCbbGNY9pFbUnuDfmodW7.esK7tIebUsUhOkCGwbZHxBG', 0, 'témafelelös', '2023-11-19 11:27:25');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `merfoldko`
--

CREATE TABLE `merfoldko` (
  `teljesul` int(3) NOT NULL DEFAULT 0,
  `leiras` varchar(200) DEFAULT NULL,
  `idopont` date NOT NULL,
  `megnevezes` varchar(10) DEFAULT NULL,
  `merfoldko` varchar(8) NOT NULL,
  `palyazat` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `merfoldko`
--

INSERT INTO `merfoldko` (`teljesul`, `leiras`, `idopont`, `megnevezes`, `merfoldko`, `palyazat`) VALUES
(4, 'mj', '2023-11-25', 'vvvv', 'M001', 'P002'),
(0, 'megnézük hogy müködik-e', '2023-11-18', 'ww', 'M002', 'P002');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `palyazatok`
--

CREATE TABLE `palyazatok` (
  `nev` varchar(30) DEFAULT NULL,
  `cel` varchar(200) DEFAULT NULL,
  `elnyert` int(10) NOT NULL,
  `palyazott` int(10) NOT NULL,
  `vege` date NOT NULL,
  `kezdete` date NOT NULL,
  `cime` varchar(20) NOT NULL,
  `temaszam` int(2) NOT NULL,
  `kodja` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `palyazatok`
--

INSERT INTO `palyazatok` (`nev`, `cel`, `elnyert`, `palyazott`, `vege`, `kezdete`, `cime`, `temaszam`, `kodja`) VALUES
('uu', 'valami', 2, 2, '2023-11-11', '2023-11-10', 'proba', 1, 'P001'),
('uu', 'valami', 1, 1, '2023-11-26', '2023-11-09', 'dgfd', 1, 'P002');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `dokumentum`
--
ALTER TABLE `dokumentum`
  ADD PRIMARY KEY (`sorszam`,`merfoldko`,`rneve`) USING BTREE,
  ADD KEY `merfoldko` (`merfoldko`);

--
-- A tábla indexei `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`nev`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nev` (`nev`);

--
-- A tábla indexei `merfoldko`
--
ALTER TABLE `merfoldko`
  ADD PRIMARY KEY (`merfoldko`),
  ADD UNIQUE KEY `merfoldko` (`merfoldko`),
  ADD KEY `palyazat` (`palyazat`);

--
-- A tábla indexei `palyazatok`
--
ALTER TABLE `palyazatok`
  ADD PRIMARY KEY (`kodja`),
  ADD UNIQUE KEY `palyazat kodja` (`kodja`),
  ADD UNIQUE KEY `kodja` (`kodja`),
  ADD KEY `nem tudom` (`nev`);

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `dokumentum`
--
ALTER TABLE `dokumentum`
  ADD CONSTRAINT `dokumentum_ibfk_1` FOREIGN KEY (`merfoldko`) REFERENCES `merfoldko` (`merfoldko`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `merfoldko`
--
ALTER TABLE `merfoldko`
  ADD CONSTRAINT `merfoldko_ibfk_1` FOREIGN KEY (`palyazat`) REFERENCES `palyazatok` (`kodja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `palyazatok`
--
ALTER TABLE `palyazatok`
  ADD CONSTRAINT `palyazatok_ibfk_1` FOREIGN KEY (`nev`) REFERENCES `felhasznalo` (`nev`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
