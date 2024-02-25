-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 22 2024 г., 09:18
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
-- База данных: `bd_autotools`
--

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_email`, `customer_phone`) VALUES
(1, 'Иван Иванов', 'ivan@example.com', '123-456-7890'),
(2, 'Петр Петров', 'petr@example.com', '456-789-1230'),
(3, 'Мария Сидорова', 'maria@example.com', '789-123-4560'),
(4, 'Анна Новикова', 'anna@example.com', '321-654-9870'),
(5, 'Сергей Кузнецов', 'sergey@example.com', '654-987-3210'),
(6, 'Елена Иванова', 'elena@example.com', '111-222-3333'),
(7, 'Алексей Смирнов', 'alex@example.com', '444-555-6666'),
(8, 'Ольга Козлова', 'olga@example.com', '777-888-9999'),
(9, 'Дмитрий Федоров', 'dmitry@example.com', '000-111-2222'),
(10, 'Наталья Морозова', 'natalia@example.com', '333-444-5555'),
(11, 'Иван Иванов', 'ivan@example.com', '123-456-7890'),
(12, 'Петр Петров', 'petr@example.com', '456-789-1230'),
(13, 'Мария Сидорова', 'maria@example.com', '789-123-4560'),
(14, 'Анна Новикова', 'anna@example.com', '321-654-9870'),
(15, 'Сергей Кузнецов', 'sergey@example.com', '654-987-3210'),
(16, 'Елена Иванова', 'elena@example.com', '111-222-3333'),
(17, 'Алексей Смирнов', 'alex@example.com', '444-555-6666'),
(18, 'Ольга Козлова', 'olga@example.com', '777-888-9999'),
(19, 'Дмитрий Федоров', 'dmitry@example.com', '000-111-2222'),
(20, 'Наталья Морозова', 'natalia@example.com', '333-444-5555');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`) VALUES
(1, 1, '2024-02-20 07:52:59'),
(2, 2, '2024-02-20 07:52:59'),
(3, 3, '2024-02-20 07:52:59'),
(4, 4, '2024-02-20 07:52:59'),
(5, 5, '2024-02-20 07:52:59'),
(6, 6, '2024-02-20 07:52:59'),
(7, 7, '2024-02-20 07:52:59'),
(8, 8, '2024-02-20 07:52:59'),
(9, 9, '2024-02-20 07:52:59');

-- --------------------------------------------------------

--
-- Структура таблицы `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(11, 1, 1, 2, 25.99),
(12, 1, 2, 1, 12.50),
(13, 2, 3, 1, 35.75),
(14, 3, 4, 4, 8.99),
(15, 4, 5, 1, 18.25),
(16, 5, 6, 3, 15.99),
(17, 6, 7, 1, 75.50),
(18, 7, 8, 2, 28.75),
(19, 8, 9, 1, 22.99),
(20, 9, 10, 2, 55.25);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_price`) VALUES
(1, 'Масло моторное', 'Масло для двигателя автомобиля', 25.99),
(2, 'Фильтр масляный', 'Фильтр для очистки масла', 12.50),
(3, 'Тормозные колодки', 'Колодки для тормозной системы', 35.75),
(4, 'Свечи зажигания', 'Свечи для зажигания', 8.99),
(5, 'Ремень ГРМ', 'Ремень газораспределительного механизма', 18.25),
(6, 'Фильтр воздушный', 'Фильтр для очистки воздуха', 15.99),
(7, 'Аккумулятор', 'Аккумуляторная батарея', 75.50),
(8, 'Шаровая опора', 'Шаровая опора подвески', 28.75),
(9, 'Фонарь задний', 'Фонарь заднего хода', 22.99),
(10, 'Масляный радиатор', 'Масляный радиатор охлаждения', 55.25),
(11, 'Масло моторное', 'Масло для двигателя автомобиля', 25.99),
(12, 'Фильтр масляный', 'Фильтр для очистки масла', 12.50),
(13, 'Тормозные колодки', 'Колодки для тормозной системы', 35.75),
(14, 'Свечи зажигания', 'Свечи для зажигания', 8.99),
(15, 'Ремень ГРМ', 'Ремень газораспределительного механизма', 18.25),
(16, 'Фильтр воздушный', 'Фильтр для очистки воздуха', 15.99),
(17, 'Аккумулятор', 'Аккумуляторная батарея', 75.50),
(18, 'Шаровая опора', 'Шаровая опора подвески', 28.75),
(19, 'Фонарь задний', 'Фонарь заднего хода', 22.99),
(20, 'Масляный радиатор', 'Масляный радиатор охлаждения', 55.25);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Индексы таблицы `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Ограничения внешнего ключа таблицы `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
