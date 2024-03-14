-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 14 2024 г., 18:50
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `копеечка`
--

-- --------------------------------------------------------

--
-- Структура таблицы `организации`
--

CREATE TABLE IF NOT EXISTS `организации` (
  `№_организации` int(11) NOT NULL,
  `наименование` varchar(255) NOT NULL,
  PRIMARY KEY (`№_организации`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `остаток_на_складе`
--

CREATE TABLE IF NOT EXISTS `остаток_на_складе` (
  `№_склада` int(11) NOT NULL,
  `артикул` int(11) NOT NULL,
  `количество` int(11) NOT NULL,
  `дата` date NOT NULL,
  PRIMARY KEY (`№_склада`),
  KEY `артикул` (`артикул`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `приход`
--

CREATE TABLE IF NOT EXISTS `приход` (
  `№_накладной` int(11) NOT NULL,
  `дата` date NOT NULL,
  `тип_накладной` varchar(255) NOT NULL,
  `№_склада` int(11) NOT NULL,
  `поставщик` int(11) NOT NULL,
  PRIMARY KEY (`№_накладной`),
  KEY `№_склада` (`№_склада`,`поставщик`),
  KEY `поставщик` (`поставщик`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `расход`
--

CREATE TABLE IF NOT EXISTS `расход` (
  `№_лимитной_карты` int(11) NOT NULL AUTO_INCREMENT,
  `№_склада` int(11) NOT NULL,
  `подразделение` varchar(255) NOT NULL,
  `товар` int(11) NOT NULL,
  `месяц` int(11) NOT NULL,
  `год` int(11) NOT NULL,
  `лимит` int(11) NOT NULL,
  PRIMARY KEY (`№_лимитной_карты`),
  KEY `№_склада` (`№_склада`,`товар`),
  KEY `товар` (`товар`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `склады`
--

CREATE TABLE IF NOT EXISTS `склады` (
  `№_склада` int(11) NOT NULL AUTO_INCREMENT,
  `наименование` varchar(255) NOT NULL,
  `фио_кладовщика` varchar(255) NOT NULL,
  PRIMARY KEY (`№_склада`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `состав_накладной`
--

CREATE TABLE IF NOT EXISTS `состав_накладной` (
  `№_накладной` int(11) NOT NULL AUTO_INCREMENT,
  `артикул` int(11) NOT NULL,
  `количество` int(11) NOT NULL,
  PRIMARY KEY (`№_накладной`),
  KEY `артикул` (`артикул`),
  KEY `артикул_2` (`артикул`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `состав_расхода`
--

CREATE TABLE IF NOT EXISTS `состав_расхода` (
  `№_пп` int(11) NOT NULL,
  `№_лимитной_карты` int(11) NOT NULL,
  `дата` date NOT NULL,
  `количество` int(11) NOT NULL,
  `вид_расхода` varchar(255) NOT NULL,
  PRIMARY KEY (`№_пп`),
  KEY `№_лимитной_карты` (`№_лимитной_карты`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `товары`
--

CREATE TABLE IF NOT EXISTS `товары` (
  `артикул` int(11) NOT NULL AUTO_INCREMENT,
  `наименование` varchar(255) NOT NULL,
  `ед_изм` varchar(255) NOT NULL,
  `цена` decimal(12,2) NOT NULL,
  PRIMARY KEY (`артикул`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `остаток_на_складе`
--
ALTER TABLE `остаток_на_складе`
  ADD CONSTRAINT `@u0@x0@y0@g0@y0@u0@q0_@t0@g0_@x0@q0@r0@g0@k0@l0_ibfk_1` FOREIGN KEY (`№_склада`) REFERENCES `склады` (`№_склада`),
  ADD CONSTRAINT `@u0@x0@y0@g0@y0@u0@q0_@t0@g0_@x0@q0@r0@g0@k0@l0_ibfk_2` FOREIGN KEY (`артикул`) REFERENCES `товары` (`артикул`);

--
-- Ограничения внешнего ключа таблицы `приход`
--
ALTER TABLE `приход`
  ADD CONSTRAINT `@v0@w0@o0@h1@u0@k0_ibfk_1` FOREIGN KEY (`№_накладной`) REFERENCES `состав_накладной` (`№_накладной`),
  ADD CONSTRAINT `@v0@w0@o0@h1@u0@k0_ibfk_2` FOREIGN KEY (`№_склада`) REFERENCES `склады` (`№_склада`),
  ADD CONSTRAINT `@v0@w0@o0@h1@u0@k0_ibfk_3` FOREIGN KEY (`поставщик`) REFERENCES `организации` (`№_организации`);

--
-- Ограничения внешнего ключа таблицы `расход`
--
ALTER TABLE `расход`
  ADD CONSTRAINT `@w0@g0@x0@h1@u0@k0_ibfk_1` FOREIGN KEY (`№_склада`) REFERENCES `склады` (`№_склада`),
  ADD CONSTRAINT `@w0@g0@x0@h1@u0@k0_ibfk_2` FOREIGN KEY (`товар`) REFERENCES `товары` (`артикул`);

--
-- Ограничения внешнего ключа таблицы `состав_накладной`
--
ALTER TABLE `состав_накладной`
  ADD CONSTRAINT `@x0@u0@x0@y0@g0@i0_@t0@g0@q0@r0@g0@k0@t0@u0@p0_ibfk_1` FOREIGN KEY (`артикул`) REFERENCES `товары` (`артикул`);

--
-- Ограничения внешнего ключа таблицы `состав_расхода`
--
ALTER TABLE `состав_расхода`
  ADD CONSTRAINT `@x0@u0@x0@y0@g0@i0_@w0@g0@x0@h1@u0@k0@g0_ibfk_1` FOREIGN KEY (`№_лимитной_карты`) REFERENCES `расход` (`№_лимитной_карты`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
