-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.62-log - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп структуры для таблица diplom_1.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id категории товара',
  `name` varchar(20) NOT NULL DEFAULT '0' COMMENT 'Название категории товара',
  `russian_name` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Название категории товара на русском языке',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Категории товаров';

-- Дамп данных таблицы diplom_1.categories: ~4 rows (приблизительно)
DELETE FROM `categories`;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `russian_name`) VALUES
	(1, 'women', 'Женщины'),
	(2, 'men', 'Мужчины'),
	(3, 'children', 'Дети'),
	(4, 'accessories', 'Аксессуары');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Дамп структуры для таблица diplom_1.category_product
CREATE TABLE IF NOT EXISTS `category_product` (
  `category_id` int(5) NOT NULL,
  `product_id` int(20) NOT NULL,
  PRIMARY KEY (`category_id`,`product_id`),
  KEY `FK1_product_id` (`product_id`),
  CONSTRAINT `FK1_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица принадлежности товаров к разным категориям.';

-- Дамп данных таблицы diplom_1.category_product: ~112 rows (приблизительно)
DELETE FROM `category_product`;
/*!40000 ALTER TABLE `category_product` DISABLE KEYS */;
INSERT INTO `category_product` (`category_id`, `product_id`) VALUES
	(1, 2),
	(1, 4),
	(1, 5),
	(3, 5),
	(2, 6),
	(4, 6),
	(1, 7),
	(2, 7),
	(3, 7),
	(4, 7),
	(1, 8),
	(4, 8),
	(3, 9),
	(1, 10),
	(3, 10),
	(1, 11),
	(1, 12),
	(2, 13),
	(3, 13),
	(1, 14),
	(4, 15),
	(2, 16),
	(1, 17),
	(3, 17),
	(1, 18),
	(2, 18),
	(1, 19),
	(2, 19),
	(3, 19),
	(2, 20),
	(2, 21),
	(2, 22),
	(1, 23),
	(2, 23),
	(1, 24),
	(3, 24),
	(1, 25),
	(2, 25),
	(3, 25),
	(2, 26),
	(3, 26),
	(2, 27),
	(4, 27),
	(2, 28),
	(3, 28),
	(4, 28),
	(1, 40),
	(3, 41),
	(3, 42),
	(4, 42),
	(1, 43),
	(3, 44),
	(1, 45),
	(2, 45),
	(3, 45),
	(3, 46),
	(2, 47),
	(4, 47),
	(1, 48),
	(3, 48),
	(2, 49),
	(4, 49),
	(2, 50),
	(4, 50),
	(1, 51),
	(2, 51),
	(3, 51),
	(4, 51),
	(2, 52),
	(4, 52),
	(1, 72),
	(2, 72),
	(3, 72),
	(1, 73),
	(2, 73),
	(3, 73),
	(1, 74),
	(2, 74),
	(4, 74),
	(3, 75),
	(4, 76),
	(4, 77),
	(3, 78),
	(1, 79),
	(2, 79),
	(2, 80),
	(4, 80),
	(2, 84),
	(1, 85),
	(3, 85),
	(3, 86),
	(1, 87),
	(2, 87),
	(3, 87),
	(1, 91),
	(2, 91),
	(3, 91),
	(1, 93),
	(1, 94),
	(1, 95),
	(2, 95),
	(3, 95),
	(4, 95),
	(4, 97),
	(1, 98),
	(2, 98),
	(3, 98),
	(1, 99),
	(3, 99),
	(2, 100),
	(3, 100),
	(4, 100);
/*!40000 ALTER TABLE `category_product` ENABLE KEYS */;

-- Дамп структуры для таблица diplom_1.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `surname` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Фамилия',
  `firstName` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Имя',
  `thirdName` varchar(50) DEFAULT '0' COMMENT 'Отчество',
  `phone` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Телефон',
  `email` varchar(50) NOT NULL DEFAULT '0' COMMENT 'E-mail',
  `delivery` varchar(10) NOT NULL DEFAULT '0' COMMENT 'Способ доставки: самовывоз - 0, Курьерная доставка - 1.',
  `city` varchar(30) DEFAULT '0' COMMENT 'Город доставки',
  `street` varchar(50) DEFAULT '0' COMMENT 'Улица',
  `home` varchar(30) DEFAULT '0' COMMENT 'Дом',
  `aprt` varchar(10) DEFAULT '0' COMMENT 'Квартира',
  `pay` varchar(10) NOT NULL DEFAULT '0' COMMENT 'Способ оплаты: cash/card',
  `comment` varchar(300) DEFAULT '0' COMMENT 'Комментарии к заказу',
  `productId` int(20) NOT NULL DEFAULT '0' COMMENT 'id-товара',
  `productPrice` float NOT NULL COMMENT 'стоимость товара',
  `deliveryPrice` float NOT NULL COMMENT 'стоимость доставки',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Статус заказа: 0 - не обработан, 1 - обработан',
  PRIMARY KEY (`id`),
  KEY `FK1_productId` (`productId`),
  CONSTRAINT `FK1_productId` FOREIGN KEY (`productId`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы diplom_1.orders: ~10 rows (приблизительно)
DELETE FROM `orders`;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `created`, `surname`, `firstName`, `thirdName`, `phone`, `email`, `delivery`, `city`, `street`, `home`, `aprt`, `pay`, `comment`, `productId`, `productPrice`, `deliveryPrice`, `status`) VALUES
	(18, '2021-04-20 18:53:16', 'Иванов', 'Юрий', 'Владимирович', '+7 987 654 32 10', 'ee@dd.ru', 'dev-no', ' Москва', ' Пушкина', '5', '233', 'card', 'Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Вдали от всех живут они в буквенных домах на берегу.', 2, 2999, 0, 1),
	(19, '2021-04-21 19:17:44', 'Сидоров', 'Петр', 'Петрович', '89990002228', 'ps@mail.ru', 'dev-yes', 'Урюпинск', 'Ленина', '11', '22', 'cash', 'И побыстрее...', 7, 1850, 280, 1),
	(20, '2021-04-23 14:29:38', 'Семенов', 'Семен', 'Семеныч', '890364859548', 'sem@yu.gu', 'dev-no', '', '', '', '', 'card', 'цукфвтпьрацкуеарпцкувеыапцуквап', 6, 5888, 0, 0),
	(21, '2021-04-23 14:31:20', 'Зайчикова', 'Марья', 'Петровна', '+72223334440', 'ma@zu.qq', 'dev-yes', 'Челябинск', 'Ленина', '4а', '5', 'cash', 'киварнеолкнгорай4ефкпваф\r\nпроыкрукпквып\r\n85737', 8, 7435, 0, 0),
	(22, '2021-04-26 12:03:25', 'Иванова', 'Тамара', 'Юрьевна', '87654321908', 'там@ив.рф', 'dev-no', '', '', '', '', 'card', '', 10, 1755, 0, 1),
	(23, '2021-05-05 10:56:37', 'Алексеева', 'Алена', 'Игоревна', '+79902345678', 'ал@я.рф', 'dev-yes', 'Клин', 'Чайковского', '7б', '44', 'cash', 'Очень надо!!!!!!!!!!!!!', 10, 1755, 280, 0),
	(24, '2021-06-07 18:22:33', 'Иванов', 'Федя', '', '47473474377', 'ввп@fhft.huk', 'dev-no', '', '', '', '', 'card', '', 84, 450, 0, 1),
	(25, '2021-06-07 18:23:46', 'ролоит', 'птасм', '', '4356', 'фф@sd.jj', 'dev-no', '', '', '', '', 'card', '', 100, 15888, 0, 0),
	(26, '2021-06-15 20:20:07', 'Сидоров', 'Сидор', '', '8907654321', 'sid@gg.tt', 'dev-no', '', '', '', '', 'cash', 'zdfhnfxhbzsd', 13, 3422, 0, 0),
	(27, '2021-06-15 20:48:28', 'Zimmerman', 'Otto', '', '810345678098', 'zmm@ott.ge', 'dev-no', '', '', '', '', 'card', 'dfxhgcj,vb,mn', 27, 1999, 0, 0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Дамп структуры для таблица diplom_1.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT 'id товара',
  `name` varchar(255) NOT NULL DEFAULT '0' COMMENT 'Название товара',
  `price` decimal(12,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'Цена товара',
  `image` varchar(255) NOT NULL DEFAULT '0' COMMENT 'Имя файла с изображением товара',
  `new` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Признак новизны товара: 1 - новинка, 0 -нет',
  `sale` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Признак, что товар на распродаже: 1 - да, 0 -нет',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Признак, что товар был удален: 1 - да, 0 -нет',
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Признак активности товар: 1 - да, 0 -нет',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='Таблица товаров';

-- Дамп данных таблицы diplom_1.products: ~68 rows (приблизительно)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `price`, `image`, `new`, `sale`, `deleted`, `active`) VALUES
	(2, 'Платье красное', 2999.00, 'product-6.jpg', 0, 0, 1, 0),
	(4, 'Платье белое', 3599.00, 'product-4.jpg', 1, 1, 0, 0),
	(5, 'Рубашка в клеточку', 1250.00, 'product-2.jpg', 0, 1, 0, 0),
	(6, 'Часы командирские', 5888.00, 'product-3.jpg', 1, 0, 0, 0),
	(7, 'Штаны в полоску', 1850.00, 'product-7.jpg', 0, 1, 0, 0),
	(8, 'Сумка нат.кожа ', 7435.00, 'product-5.jpg', 0, 0, 0, 0),
	(9, 'Плащ розовый ', 2895.00, 'product-7.jpg', 1, 1, 0, 0),
	(10, 'Кофточка', 1755.00, 'product-8.jpg', 1, 0, 0, 0),
	(11, 'Сапоги нат.кожа', 5890.00, 'product-9.jpg', 0, 1, 0, 0),
	(12, 'Пижама женская', 2444.00, 'product-12.jpg', 1, 0, 0, 0),
	(13, 'Пижама мужская', 3422.00, 'product-13.jpg', 1, 0, 0, 0),
	(14, 'Шуба', 25777.00, 'product-14.jpg', 1, 0, 0, 0),
	(15, 'Шуба красная', 32000.00, 'product-15.jpg', 1, 1, 0, 0),
	(16, 'Носки 5 пальцев', 1350.00, 'product-16.jpg', 1, 0, 0, 0),
	(17, 'Туфли красные', 5437.00, 'product-17.jpg', 1, 0, 0, 0),
	(18, 'Сапоги жокейские', 14532.00, 'product-18.jpg', 1, 0, 0, 0),
	(19, 'Сапоги болтные', 5467.00, 'product-19.jpg', 1, 0, 0, 0),
	(20, 'Джинсы', 2500.00, 'no-photo.jpg', 1, 0, 0, 0),
	(21, 'Рубашка', 3400.00, 'no-photo.jpg', 0, 1, 0, 0),
	(22, 'Кроссы', 4999.00, 'no-photo.jpg', 0, 1, 0, 0),
	(23, 'Вечернее платье', 19999.00, 'product-23.jpg', 1, 0, 0, 0),
	(24, 'Юбка', 2555.00, 'product-24.jpg', 1, 0, 0, 0),
	(25, 'Сапоги резиновые', 3555.00, 'product-25.jpg', 0, 1, 0, 0),
	(26, 'Трусы', 555.00, 'product-26.jpg', 0, 1, 0, 0),
	(27, 'Зонт', 1999.00, 'product-27.jpg', 0, 1, 0, 0),
	(28, 'Кошелек нат.кож., кор.', 5588.00, 'product-28.jpg', 1, 1, 0, 1),
	(40, 'Юбка трапеция', 3777.00, 'product-40.jpg', 1, 0, 0, 0),
	(41, 'Шорты', 1555.00, 'product-41.jpg', 0, 1, 0, 0),
	(42, 'Шорты-2', 1789.00, 'product-42.jpg', 1, 1, 0, 0),
	(43, 'Черное платье', 8555.00, 'product-43.jpg', 1, 0, 0, 0),
	(44, 'Футболка детская', 350.00, 'product-44.jpg', 0, 1, 0, 0),
	(45, 'Футболка Москва', 755.00, 'product-45.jpg', 1, 0, 0, 0),
	(46, 'Москва-Абибас', 478.00, 'product-46.jpg', 1, 1, 0, 0),
	(47, 'Шляпа Австралия', 4500.00, 'product-47.jpg', 1, 0, 0, 0),
	(48, 'Шляпка соломенная', 3899.00, 'product-48.jpg', 1, 1, 0, 0),
	(49, 'Шляпа ковбойская', 7777.00, 'product-49.jpg', 1, 0, 0, 0),
	(50, 'Ремень ковбойский', 6543.00, 'product-50.jpg', 1, 0, 0, 0),
	(51, 'Сомбреро', 5432.00, 'product-51.jpg', 1, 0, 0, 0),
	(52, 'Котелок', 13333.00, 'product-52.jpg', 1, 0, 0, 0),
	(72, 'Кроссы белые', 7555.00, 'product-72.jpg', 1, 0, 0, 0),
	(73, 'Сапоги ковбойские', 12333.00, 'product-73.jpg', 1, 0, 0, 0),
	(74, 'Ремешок', 5444.00, 'product-74.jpg', 1, 0, 0, 0),
	(75, 'большое фото', 21223.00, 'product-0.jpg', 0, 1, 0, 0),
	(76, 'lkjhg', 9988.00, 'product-0.jpg', 0, 1, 0, 0),
	(77, 'gggghhhh', 4444.00, 'product-0.jpg', 0, 1, 0, 0),
	(78, 'ffffggg', 5555.00, 'product-0.jpg', 0, 1, 0, 0),
	(79, 'zxcvb', 7778.00, 'product-0.jpg', 1, 1, 0, 0),
	(80, 'Кошель', 7999.00, 'product-0.jpg', 1, 1, 0, 0),
	(81, 'wertyui', 2345.00, 'product-0.jpg', 0, 0, 0, 0),
	(82, 'new prod 1', 1234.00, 'product-0.jpg', 0, 0, 0, 0),
	(83, 'new prod 2', 2345.00, 'product-0.jpg', 0, 0, 0, 0),
	(84, 'Носки полушерсть 100%', 450.00, 'product-84.jpg', 0, 1, 0, 0),
	(85, 'Кроссовки детские', 2333.00, 'product-85.jpg', 0, 1, 0, 0),
	(86, 'паролд', 670.00, 'product-0.jpg', 0, 0, 0, 0),
	(87, 'чвсампр', 3456.00, 'product-87.jpg', 0, 1, 0, 0),
	(88, 'ццццц', 22222.00, 'product-0.jpg', 0, 0, 0, 0),
	(89, 'цццц', 2222.00, 'product-89.jpg', 0, 0, 0, 0),
	(90, 'цувка', 2345.00, 'product-90.jpg', 0, 0, 0, 0),
	(91, 'Носки желтые', 455.00, 'product-91.jpg', 1, 0, 0, 0),
	(92, 'asdfgh', 23456.00, 'product-0.jpg', 0, 0, 0, 0),
	(93, 'Красные туфельки', 4777.00, 'product-93.jpg', 1, 0, 0, 0),
	(94, 'Туфли бежевые', 2345.00, 'product-94.jpg', 0, 1, 0, 0),
	(95, 'Соломенная шляпка', 3456.00, 'product-95.jpg', 1, 1, 0, 0),
	(96, 'ertггг', 456.00, 'product-0.jpg', 0, 0, 0, 0),
	(97, 'fgh', 3456.00, 'product-0.jpg', 1, 1, 0, 0),
	(98, 'Носки фастфуд', 854.00, 'product-98.jpg', 1, 0, 0, 0),
	(99, 'Кроссы с перламутром', 4455.00, 'product-99.jpg', 1, 0, 0, 0),
	(100, 'Шляпа шерифа', 15888.00, 'product-100.jpg', 1, 0, 0, 0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица diplom_1.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL COMMENT 'E-mail пользователя',
  `password` varchar(255) NOT NULL COMMENT 'Пароль',
  `status` varchar(50) DEFAULT NULL COMMENT 'admin, operator, user',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Данные пользователей.';

-- Дамп данных таблицы diplom_1.users: ~3 rows (приблизительно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `login`, `password`, `status`, `comment`) VALUES
	(2, 'yuri@ya.ru', '$2y$10$8gV.1HJ.C0Zo3MHuPCMaa.rsjmKmBYkG4bpgUnsexfxLMl3dCSpJ.', 'adm', '123'),
	(3, 'nat@ya.ru', '$2y$10$tVtFZiGyXFQBedHzCSITTexHv8WWWZFNmrnb1OI3jVlJ7cYY/7oeK', 'oper', '123'),
	(4, 'leo@ya.ru', '$2y$10$MLYqVxkFeeaZBb/NPvRT3uZHOBXFkY4DOAe9P7aE96Opk8X6bBwny', 'user', '123');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
