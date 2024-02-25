-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 10 2024 г., 19:59
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `catalogdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `категория`
--

CREATE TABLE `категория` (
  `ид` int(11) NOT NULL,
  `категория` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `поставщик`
--

CREATE TABLE `поставщик` (
  `ид` int(11) NOT NULL,
  `название` varchar(128) NOT NULL,
  `фио` varchar(64) NOT NULL,
  `телефон` varchar(18) NOT NULL,
  `адрес` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ед_изм`
--

CREATE TABLE `ед_изм` (
  `ид` int(11) NOT NULL,
  `ед_изм` varchar(8) NOT NULL DEFAULT 'кг'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `склад`
--

CREATE TABLE `склад` (
  `ид` int(11) NOT NULL,
  `название` int(11) NOT NULL,
  `незанятое_пространство` int(11) NOT NULL,
  `вместимость` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `товар`
--

CREATE TABLE `товар` (
  `ид` int(10) UNSIGNED NOT NULL,
  `наименование` varchar(32) NOT NULL,
  `ид_категория` int(11) NOT NULL,
  `количество` int(11) NOT NULL,
  `цена` decimal(10,0) NOT NULL,
  `стоимость` decimal(2,0) UNSIGNED NOT NULL,
  `суммарный_вес` int(11) NOT NULL,
  `ид_ед_изм` int(11) NOT NULL,
  `ид_поставщик` int(11) NOT NULL,
  `ид_склад` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `категория`
--
ALTER TABLE `категория`
  ADD PRIMARY KEY (`ид`);

--
-- Индексы таблицы `поставщик`
--
ALTER TABLE `поставщик`
  ADD PRIMARY KEY (`ид`);

--
-- Индексы таблицы `ед_изм`
--
ALTER TABLE `ед_изм`
  ADD PRIMARY KEY (`ид`);

--
-- Индексы таблицы `склад`
--
ALTER TABLE `склад`
  ADD PRIMARY KEY (`ид`);

--
-- Индексы таблицы `товар`
--
ALTER TABLE `товар`
  ADD PRIMARY KEY (`ид`),
  ADD UNIQUE KEY `ид_категория` (`ид_категория`),
  ADD KEY `ид_категория_2` (`ид_категория`),
  ADD KEY `ид_ед_изм` (`ид_ед_изм`,`ид_поставщик`,`ид_склад`),
  ADD KEY `ид_поставщик` (`ид_поставщик`),
  ADD KEY `ид_склад` (`ид_склад`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `категория`
--
ALTER TABLE `категория`
  MODIFY `ид` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `поставщик`
--
ALTER TABLE `поставщик`
  MODIFY `ид` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ед_изм`
--
ALTER TABLE `ед_изм`
  MODIFY `ид` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `склад`
--
ALTER TABLE `склад`
  MODIFY `ид` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `товар`
--
ALTER TABLE `товар`
  MODIFY `ид` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `товар`
--
ALTER TABLE `товар`
  ADD CONSTRAINT `товар_ibfk_1` FOREIGN KEY (`ид_ед_изм`) REFERENCES `ед_изм` (`ид`),
  ADD CONSTRAINT `товар_ibfk_2` FOREIGN KEY (`ид_поставщик`) REFERENCES `поставщик` (`ид`),
  ADD CONSTRAINT `товар_ibfk_3` FOREIGN KEY (`ид_категория`) REFERENCES `категория` (`ид`),
  ADD CONSTRAINT `товар_ibfk_4` FOREIGN KEY (`ид_склад`) REFERENCES `склад` (`ид`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
