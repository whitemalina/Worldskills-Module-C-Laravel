-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 09 2023 г., 20:45
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `airport`
--

CREATE TABLE `airport` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `iata` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `airport`
--

INSERT INTO `airport` (`id`, `name`, `iata`) VALUES
(1, 'Сургут', 'SGC'),
(2, 'Moscow', 'MSK');

-- --------------------------------------------------------

--
-- Структура таблицы `airports`
--

CREATE TABLE `airports` (
  `id` int(11) NOT NULL,
  `city` text NOT NULL,
  `name` text NOT NULL,
  `iata` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `airports`
--

INSERT INTO `airports` (`id`, `city`, `name`, `iata`) VALUES
(1, 'Kazan', 'Kazan', 'kaz'),
(2, 'Surgut', 'Surgut', 'SGC');

-- --------------------------------------------------------

--
-- Структура таблицы `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `flights`
--

INSERT INTO `flights` (`id`, `from_id`, `to_id`, `date`) VALUES
(1, 1, 2, '2023-02-09');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `phone` text NOT NULL,
  `document_number` text NOT NULL,
  `password` text NOT NULL,
  `api_token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `document_number`, `password`, `api_token`) VALUES
(1, 'Ivan', 'Ivanov', '+79324207445', '6717123456', 'Ivan123', ''),
(2, 'Ivan', 'Ivanov', '89324207445', '6717123456', 'Ivan123', ''),
(3, 'Ivan', 'Ivanov', '89001234527', '6717123456', 'paSSword', 'QtjWY6loIjfmZSmE5H2f5pGRBIc91ZMd');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `airport`
--
ALTER TABLE `airport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `airports`
--
ALTER TABLE `airports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
