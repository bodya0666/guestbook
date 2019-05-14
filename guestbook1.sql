-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Трв 14 2019 р., 21:40
-- Версія сервера: 5.7.23
-- Версія PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `guestbook1`
--

-- --------------------------------------------------------

--
-- Структура таблиці `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190512121808', '2019-05-12 12:18:29'),
('20190512134714', '2019-05-12 13:47:19'),
('20190512150336', '2019-05-12 15:04:12'),
('20190512152811', '2019-05-12 15:28:41'),
('20190512153242', '2019-05-12 15:32:49'),
('20190512213900', '2019-05-12 21:39:17'),
('20190513070641', '2019-05-13 07:07:08'),
('20190513224727', '2019-05-13 22:48:25');

-- --------------------------------------------------------

--
-- Структура таблиці `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `homepage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `posts`
--

INSERT INTO `posts` (`id`, `username`, `email`, `homepage`, `text`, `alt_text`, `image`, `date`, `status`) VALUES
(1, 'username1', 'email@email.com', 'page22', 'Русский текст', 'English Text', 'ba23fedec1a3f8bd30fd857fd28d49fc.png', '2019-05-14 16:57:25', 1),
(2, 'Text', 'Text', 'Text', 'Русский текст', 'English Text', 'img2', '2019-05-13 20:23:03', 1),
(3, 'test', 'test', 'test', 'Русский текст', 'English Text', 'test', '2019-05-13 20:23:03', 1),
(4, 'maximchuk', 'maximchuk.bodya@gmail.com', 'test', 'Русский текст', 'English Text', 'test', '2019-05-13 20:23:03', 0),
(6, 'maximchuk', 'maximchuk.bodya@gmail.com', 'test', 'Русский текст', 'English Text', '/tmp/phpqxr7rO', '2019-05-13 20:23:03', 0),
(8, 'maximchuk', 'maximchuk.bodya@gmail.com', 'testы', 'Русский текст', 'English Text', '/tmp/phpHlN0cF', '2019-05-13 20:23:03', 0),
(9, 'maximchuk', 'maximchuk.bodya@gmail.com', 'testtest', 'Русский текст', 'English Text', '/tmp/phpiOUfnH', '2019-05-13 20:23:03', 1),
(10, 'maximchuk', 'maximchuk.bodya@gmail.com', 'testtest', 'Русский текст', 'English Text', '/tmp/phpRh2ljb', '2019-05-13 20:23:03', 1),
(11, 'test', 'test', 'test', 'Русский текст', 'English Text', 'test', '2019-05-13 20:23:03', 1),
(12, 'maximchuk', 'maximchuk.bodya@gmail.com', 'testtest', 'Русский текст', 'English Text', NULL, '2019-05-13 20:23:03', 1),
(13, 'maximchuk', 'maximchuk.bodya@gmail.com', 'https://example.com', 'Русский текст', 'English Text', '815fc6e5029c256caeda985d8689f185.png', '2019-05-13 20:23:03', 1),
(14, 'maximchuk', 'maximchuk.bodya@gmail.com', 'https://example.com', 'Русский текст', 'English Text', '157ebf6c17c1f480caa0ffb5890998ab.png', '2019-05-13 20:23:03', 0),
(15, 'maximchuk', 'maximchuk.bodya@gmail.com', 'https://example.com', 'Русский текст', '', NULL, '2019-05-13 23:28:03', 1),
(16, 'maximchuk', 'maximchuk.bodya@gmail.com', 'https://example.com', 'https://example.com', 'https://example.com', '/tmp/phpXRotfj', '2019-05-14 14:17:34', 0),
(17, 'maximchuk', 'maximchuk.bodya@gmail.com', 'https://example.com', 'https://example.com', 'https://example.com', '/tmp/php3ey4al', '2019-05-14 14:18:40', 0),
(18, 'maximchuk', 'maximchuk.bodya@gmail.com', 'https://example.com', '//example.com', '//example.com', '/tmp/phpYzX1Hi', '2019-05-14 14:22:26', 0),
(19, 'maximchuk', 'maximchuk.bodya@gmail.com', 'https://example.com', 'https://example.com', 'https://example.com', '/tmp/phpDXAOAQ', '2019-05-14 14:25:33', 0),
(20, 'maximchuk', 'maximchuk.bodya@gmail.com', 'https://example.com', 'https://example.com', 'https://example.com', '814475e7e0b15c40d920eb00feed93bd.png', '2019-05-14 14:48:43', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `baned` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `ip`, `user_agent`, `username`, `baned`) VALUES
(1, 'maximchuk.bodya@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=1024,t=2,p=2$UWVDNFlpWWRJclVRbFAwVg$JLBfRcMg+oEesdv5b3ySsjqYkUTHD9OIEGJ7z8HAcN8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'maximchuk', 0),
(2, 'maximchuk2.bodya@gmail.com', '[]', '$argon2i$v=19$m=1024,t=2,p=2$Vk5pSFMzNm9lakZoLmRTRg$IHQ1eeL5+vj1Zmkj7GcpHedVw1SX0xg9lgXJYy/6TtU', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36', 'maximchuk', 0);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Індекси таблиці `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
