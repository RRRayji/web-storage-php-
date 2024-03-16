-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 15 2024 г., 19:47
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `склады`
--

INSERT INTO `склады` (`№_склада`, `наименование`, `фио_кладовщика`) VALUES
(1, 'Склад №1', 'Иванов Иван Иванович'),
(2, 'Склад №2', 'Петрова Мария Сергеевна'),
(3, 'Склад №3', 'Сидоров Николай Петрович'),
(4, 'Склад №4', 'Федорова Ольга Владимировна'),
(5, 'Склад №5', 'Кузнецов Алексей Михайлович'),
(6, 'Склад №6', 'Смирнова Ирина Александровна'),
(7, 'Склад №7', 'Попов Андрей Дмитриевич'),
(8, 'Склад №8', 'Васильева Елена Николаевна'),
(9, 'Склад №9', 'Соколов Сергей Юрьевич'),
(10, 'Склад №10', 'Захарова Татьяна Викторовна');

-- --------------------------------------------------------

--
-- Структура таблицы `состав_накладной`
--

CREATE TABLE IF NOT EXISTS `состав_накладной` (
  `№_накладной` int(11) NOT NULL,
  `артикул` int(11) NOT NULL,
  `количество` int(11) NOT NULL,
  KEY `№_накладной` (`№_накладной`,`артикул`),
  KEY `артикул` (`артикул`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `цена` int(11) NOT NULL,
  PRIMARY KEY (`артикул`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

--
-- Дамп данных таблицы `товары`
--

INSERT INTO `товары` (`артикул`, `наименование`, `ед_изм`, `цена`) VALUES
(4, 'Хлеб "Дарница", 400г', 'шт', 3),
(5, 'Молоко "РОГАЧЕВ", 900мл', 'шт', 90),
(6, 'Хлеб "Дарница", 400г', 'шт', 70),
(7, 'Яйца "Своя ферма", 10шт', 'шт', 120),
(8, 'Сыр "Российский", 500г', 'кг', 450),
(9, 'Колбаса "Докторская", 400г', 'кг', 480),
(10, 'Яблоки "Гренни Смит", 1кг', 'кг', 180),
(11, 'Бананы, 1кг', 'кг', 140),
(12, 'Помидоры, 1кг', 'кг', 120),
(13, 'Огурцы, 1кг', 'кг', 100),
(14, 'Картофель, 3кг', 'кг', 60),
(15, 'Сметана "Простоквашино", 200г', 'шт', 4),
(16, 'Йогурт "Активиа", 125г', 'шт', 4),
(17, 'Творог "Домик в деревне", 500г', 'шт', 80),
(18, 'Масло сливочное "Вологодское", 180г', 'шт', 120),
(19, 'Кефир "Домик в деревне", 900мл', 'шт', 60),
(20, 'Пельмени "Сибирские", 800г', 'шт', 300),
(21, 'Вареники с вишней, 400г', 'шт', 180),
(22, 'Мясо куриное, 1кг', 'кг', 450),
(23, 'Рыба минтай, 1кг', 'кг', 250),
(24, 'Сахар, 1кг', 'кг', 80),
(25, 'Сок "Добрый", 1л', 'шт', 100),
(26, 'Вода "Святой источник", 0.5л', 'шт', 50),
(27, 'Чай "Липтон", 25 пакетиков', 'шт', 150),
(28, 'Кофе "Nescafe", 200г', 'шт', 300),
(29, 'Конфеты "Алёнка", 200г', 'шт', 120),
(30, 'Печенье "Юбилейное", 200г', 'шт', 80),
(31, 'Хлеб "Дарницкий", 700г', 'шт', 35),
(32, 'Батон "Нарезной", 400г', 'шт', 25),
(33, 'Макароны "Макфа", 400г', 'шт', 50),
(34, 'Рис "Басмати", 1кг', 'кг', 150),
(35, 'Соль "Экстра", 1кг', 'кг', 50),
(36, 'Сахар "Песок", 1кг', 'кг', 80),
(37, 'Мука "Пшеничная", 2кг', 'кг', 60),
(38, 'Гречка, 800г', 'кг', 120),
(39, 'Манная крупа, 500г', 'кг', 50),
(40, 'Овсяные хлопья "Геркулес", 400г', 'шт', 80),
(41, 'Сода пищевая, 500г', 'шт', 30),
(42, 'Уксус столовый 9%, 900мл', 'шт', 40),
(43, 'Лавровый лист, 10г', 'шт', 15),
(44, 'Перец черный горошком, 50г', 'шт', 30),
(45, 'Кетчуп "Heinz", 500г', 'шт', 120),
(46, 'Майонез "Слобода", 400г', 'шт', 100),
(47, 'Горчица "Махеев", 250г', 'шт', 80),
(48, 'Подсолнечное масло "Рафинированное", 1л', 'шт', 150),
(49, 'Оливковое масло "Extra Virgin", 500мл', 'шт', 400),
(50, 'Сливочное масло "Хозяюшка", 180г', 'шт', 130),
(51, 'Сметана "Простоквашино", 150г', 'шт', 45),
(52, 'Йогурт "Активиа", 170г', 'шт', 40),
(53, 'Творог "Домик в деревне", 200г', 'шт', 50),
(54, 'Масло сливочное "Вологодское", 100г', 'шт', 80),
(55, 'Соус "Томатный", 500г', 'шт', 80),
(56, 'Майонез "Провансаль", 250г', 'шт', 60),
(57, 'Уксус бальзамический, 250мл', 'шт', 250),
(58, 'Соевый соус "Kikkoman", 250мл', 'шт', 150),
(59, 'Мёд "Алтайский", 350г', 'шт', 200),
(60, 'Варенье "Клубничное", 300г', 'шт', 150),
(61, 'Джем "Абрикосовый", 250г', 'шт', 120),
(62, 'Сгущенка "Рогачев", 380г', 'шт', 80),
(63, 'Конфитюр "Малиновый", 250г', 'шт', 100),
(64, 'Варенье из черной смородины, 300г', 'шт', 130),
(65, 'Чай черный "Липтон", 20 пакетиков', 'шт', 80),
(66, 'Кофе молотый "Жокей", 250г', 'шт', 180),
(67, 'Какао "Золотой ярлык", 100г', 'шт', 50),
(68, 'Сахарная пудра, 250г', 'шт', 40),
(69, 'Ванилин, 1г', 'шт', 15),
(70, 'Сода пищевая, 500г', 'шт', 30),
(71, 'Уксус столовый 9%, 900мл', 'шт', 40),
(72, 'Лавровый лист, 10г', 'шт', 15),
(73, 'Перец черный горошком, 50г', 'шт', 30),
(74, 'Гвоздика, 10г', 'шт', 20),
(75, 'Корица молотая, 10г', 'шт', 25),
(76, 'Мускатный орех, 50г', 'шт', 80),
(77, 'Кардамон, 10г', 'шт', 30),
(78, 'Желатин, 10г', 'шт', 20),
(79, 'Разрыхлитель теста, 10г', 'шт', 15),
(80, 'Соль морская, 250г', 'шт', 60),
(81, 'Перец черный молотый, 50г', 'шт', 35),
(82, 'Паприка молотая, 10г', 'шт', 20),
(83, 'Хмели-сунели, 10г', 'шт', 25),
(84, 'Смесь перцев, 50г', 'шт', 40),
(85, 'Чай зеленый "Сенча", 25 пакетиков', 'шт', 90),
(86, 'Чай фруктовый "Шиповник", 20 пакетиков', 'шт', 70),
(87, 'Чай травяной "Мята", 25 пакетиков', 'шт', 80),
(88, 'Чай черный "Эрл Грей", 20 пакетиков', 'шт', 95),
(89, 'Чай зеленый "Молочный улун", 25 пакетиков', 'шт', 120),
(90, 'Чай фруктовый "Клубника со сливками", 20 пакетиков', 'шт', 75),
(91, 'Чай травяной "Ромашка", 25 пакетиков', 'шт', 85),
(92, 'Чай черный "Русский караван", 20 пакетиков', 'шт', 100),
(93, 'Чай зеленый " gunpowder", 25 пакетиков', 'шт', 110);

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
  ADD CONSTRAINT `@x0@u0@x0@y0@g0@i0_@t0@g0@q0@r0@g0@k0@t0@u0@p0_ibfk_2` FOREIGN KEY (`№_накладной`) REFERENCES `приход` (`№_накладной`),
  ADD CONSTRAINT `@x0@u0@x0@y0@g0@i0_@t0@g0@q0@r0@g0@k0@t0@u0@p0_ibfk_1` FOREIGN KEY (`артикул`) REFERENCES `товары` (`артикул`);

--
-- Ограничения внешнего ключа таблицы `состав_расхода`
--
ALTER TABLE `состав_расхода`
  ADD CONSTRAINT `@x0@u0@x0@y0@g0@i0_@w0@g0@x0@h1@u0@k0@g0_ibfk_1` FOREIGN KEY (`№_лимитной_карты`) REFERENCES `расход` (`№_лимитной_карты`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
