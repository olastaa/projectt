-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Maj 2019, 21:32
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projectt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `ID_Klienta` int(11) NOT NULL,
  `Klient` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`ID_Klienta`, `Klient`) VALUES
(1, 'H&M Polska'),
(2, 'Telekomunikacja'),
(3, 'Opony.pl'),
(4, 'Lidl'),
(5, 'Wyższa Szkoła Bankowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `ID_Pracownik` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `imie_nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `ID_Roles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`ID_Pracownik`, `user`, `imie_nazwisko`, `email`, `pass`, `ID_Roles`) VALUES
(1, 'Lukas', 'Lukasz Sucharski', 'lukasuch@yahoo.de', 'admin', 1),
(2, 'Ola', 'Aleksandra Burzych', 'aburzych@gmail.com', 'drugiadmin', 2),
(3, 'Asia', 'Joanna Pawlik', 'joanna.pawlik85@gmail.com', 'gosc', 3),
(4, 'Zbychu', 'Zbigniew Wielki', 'pifko88@wp.pl', 'zbysio', 3),
(5, 'Gienia', 'Genowefa Zielona', 'olaburzych@yahoo.com', 'GeZiel', 3),
(6, 'Alfredo', 'Alfred Hitchcock', 'olaburzych@wp.pl', 'Batman', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projekty`
--

CREATE TABLE `projekty` (
  `ID_Projektu` int(11) NOT NULL,
  `Projekt` text COLLATE utf8_polish_ci NOT NULL,
  `ID_Klienta` int(11) NOT NULL,
  `ID_Pracownik` int(11) NOT NULL,
  `Data_start` date NOT NULL,
  `Data_stop` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `projekty`
--

INSERT INTO `projekty` (`ID_Projektu`, `Projekt`, `ID_Klienta`, `ID_Pracownik`, `Data_start`, `Data_stop`) VALUES
(1, 'Sklep internetowy Buty24.pl', 1, 2, '2019-05-18', '2019-05-22'),
(2, 'Baza dla Opony.pl', 3, 6, '2019-05-18', '2019-05-29');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadania`
--

CREATE TABLE `zadania` (
  `ID_Zadanie` int(11) NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zadania`
--

INSERT INTO `zadania` (`ID_Zadanie`, `opis`) VALUES
(1, 'Projekt graficzny'),
(2, 'Import danych'),
(3, 'Strategia'),
(4, 'Frontend development'),
(5, 'Backend development'),
(6, 'Makieta');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`ID_Klienta`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`ID_Pracownik`);

--
-- Indeksy dla tabeli `projekty`
--
ALTER TABLE `projekty`
  ADD PRIMARY KEY (`ID_Projektu`);

--
-- Indeksy dla tabeli `zadania`
--
ALTER TABLE `zadania`
  ADD PRIMARY KEY (`ID_Zadanie`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `ID_Klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `ID_Pracownik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `projekty`
--
ALTER TABLE `projekty`
  MODIFY `ID_Projektu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `zadania`
--
ALTER TABLE `zadania`
  MODIFY `ID_Zadanie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
