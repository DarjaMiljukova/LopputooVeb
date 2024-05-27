-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 27 2024 г., 21:24
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `projekt`
--

-- --------------------------------------------------------

--
-- Структура таблицы `kasutajad`
--

CREATE TABLE `kasutajad` (
  `Id` int(11) NOT NULL,
  `Eesnimi` varchar(40) DEFAULT NULL,
  `Perenimi` varchar(40) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Parool` varchar(100) DEFAULT NULL,
  `onAdmin` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `kasutajad`
--

INSERT INTO `kasutajad` (`Id`, `Eesnimi`, `Perenimi`, `Email`, `Parool`, `onAdmin`) VALUES
(10, 'admin', 'admin', 'admin@gmail.com', 'admin', 1),
(13, 'Darja', 'Miljukova', 'miljukovadarja@gmail.com', 'darja@2203', NULL),
(15, 'Maksim', 'Tsepelevits', 'chip@gmail.com', 'chip', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `kasutajad`
--
ALTER TABLE `kasutajad`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `kasutajad`
--
ALTER TABLE `kasutajad`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
