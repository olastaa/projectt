-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Czas generowania: 01 Cze 2019, 12:53
-- Wersja serwera: 5.7.25
-- Wersja PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
(1, 'Lukas', 'Lukasz Sucharski', 'lukasuch@yahoo.de', '$2y$10$SThaUcwFq0KqopXS0jmVuOhycW7hcJm/BZhgy3HJ.WS5ZEUSPCzma', 1),
(2, 'Ola', 'Aleksandra Burzych', 'aburzych@gmail.com', '$2y$10$Pl0fWyucpICgwQ84JgvVc.gJIblZkR2psH3erGHXaFDU4sChqlXUi', 2),
(3, 'Asia', 'Joanna Pawlik', 'joanna.pawlik85@gmail.com', '$2y$10$sKyCruyy1sTGXh/dd6qEA./jucTmZMQ2C1jyBdRvQhAZ5EWPobZO.', 3),
(4, 'Zbychu', 'Zbigniew Wielki', 'pifko88@wp.pl', '$2y$10$yVlTYBhca.DmeRY83K7deuI49s441WdsuMh54M4iOW9WOfOf0/5sG', 3),
(5, 'Gienia', 'Genowefa Zielona', 'olaburzych@yahoo.com', '$2y$10$vOv.sWbAxTO0la3uqH.z5.ph52eWZXAsJINsII0UjDp4p2GRW0tNm', 3),
(6, 'Alfredo', 'Alfred Hitchcock', 'olaburzych@wp.pl', '$2y$10$yrj7Raylnq1jBVQlWYj/lu4CrPZka.DQ./rqRXzpo1yxYY6xnloxW', 2);

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
-- Struktura tabeli dla tabeli `roles`
--

CREATE TABLE `roles` (
  `ID_Roles` int(11) NOT NULL,
  `rolename` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `czytaj` tinyint(1) NOT NULL,
  `edytuj` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `roles`
--

INSERT INTO `roles` (`ID_Roles`, `rolename`, `admin`, `czytaj`, `edytuj`) VALUES
(1, 'admin', 1, 0, 0),
(2, 'pm', 0, 0, 1),
(3, 'gosc', 0, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tracker`
--

CREATE TABLE `tracker` (
  `ID_Tracker` int(11) NOT NULL,
  `ID_Projekt` int(11) NOT NULL,
  `ID_Zadanie` int(11) NOT NULL,
  `ID_Pracownik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

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
  ADD PRIMARY KEY (`ID_Pracownik`),
  ADD KEY `ID_Roles` (`ID_Roles`);

--
-- Indeksy dla tabeli `projekty`
--
ALTER TABLE `projekty`
  ADD PRIMARY KEY (`ID_Projektu`),
  ADD KEY `ID_Klienta` (`ID_Klienta`),
  ADD KEY `ID_Pracownik` (`ID_Pracownik`);

--
-- Indeksy dla tabeli `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_Roles`);

--
-- Indeksy dla tabeli `tracker`
--
ALTER TABLE `tracker`
  ADD PRIMARY KEY (`ID_Tracker`),
  ADD KEY `ID_Projekt` (`ID_Projekt`),
  ADD KEY `ID_Zadanie` (`ID_Zadanie`),
  ADD KEY `ID_Pracownik` (`ID_Pracownik`);

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
-- AUTO_INCREMENT dla tabeli `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_Roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `tracker`
--
ALTER TABLE `tracker`
  MODIFY `ID_Tracker` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `zadania`
--
ALTER TABLE `zadania`
  MODIFY `ID_Zadanie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `pracownicy_ibfk_1` FOREIGN KEY (`ID_Roles`) REFERENCES `roles` (`ID_Roles`);

--
-- Ograniczenia dla tabeli `projekty`
--
ALTER TABLE `projekty`
  ADD CONSTRAINT `projekty_ibfk_1` FOREIGN KEY (`ID_Klienta`) REFERENCES `klienci` (`ID_Klienta`),
  ADD CONSTRAINT `projekty_ibfk_2` FOREIGN KEY (`ID_Pracownik`) REFERENCES `pracownicy` (`ID_Pracownik`);

--
-- Ograniczenia dla tabeli `tracker`
--
ALTER TABLE `tracker`
  ADD CONSTRAINT `tracker_ibfk_1` FOREIGN KEY (`ID_Zadanie`) REFERENCES `zadania` (`ID_Zadanie`),
  ADD CONSTRAINT `tracker_ibfk_2` FOREIGN KEY (`ID_Projekt`) REFERENCES `projekty` (`ID_Projektu`),
  ADD CONSTRAINT `tracker_ibfk_3` FOREIGN KEY (`ID_Pracownik`) REFERENCES `pracownicy` (`ID_Pracownik`);
