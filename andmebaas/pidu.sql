-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 27 2024 г., 21:25
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
-- Структура таблицы `pidu`
--

CREATE TABLE `pidu` (
  `Id` int(11) NOT NULL,
  `Tuup` varchar(100) DEFAULT NULL,
  `PiduNimi` varchar(100) DEFAULT NULL,
  `Aeg` date DEFAULT NULL,
  `registered_users` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pidu`
--

INSERT INTO `pidu` (`Id`, `Tuup`, `PiduNimi`, `Aeg`, `registered_users`) VALUES
(8, 'Rokk-kontsert', 'Nervy', '2024-09-08', NULL),
(9, 'Rokk-kontsert', 'Rammstein', '2024-07-07', NULL),
(10, 'Diskoteek', '90-ndate disko', '2024-06-09', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `pidu`
--
ALTER TABLE `pidu`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pidu`
--
ALTER TABLE `pidu`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
