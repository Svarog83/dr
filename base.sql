-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Май 26 2008 г., 01:25
-- Версия сервера: 5.0.41
-- Версия PHP: 5.1.6
-- 
-- БД: `dr`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `ent`
-- 

DROP TABLE IF EXISTS `ent`;
CREATE TABLE `ent` (
  `ent_id` int(10) unsigned NOT NULL auto_increment,
  `ent_title` varchar(255) NOT NULL,
  `ent_descr` text NOT NULL,
  `ent_time_begin` varchar(255) NOT NULL,
  PRIMARY KEY  (`ent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `ent`
-- 

INSERT INTO `ent` VALUES (1, 'Пейнтбол', 'Играем в пейнтбол в городе Домодедово с 12 часов дня.', 'Суббота, 31 мая 12:00');
INSERT INTO `ent` VALUES (2, 'Пьянка после Пейнтбола', 'После завершения игры в Пейнтбол шашлык и легкая выпивка в виде фуршета.', 'Суббота, 31 мая 16:00');
INSERT INTO `ent` VALUES (3, 'Дача Миши Седова', 'Для самых стойких. ', 'Суббота 31-е мая - Воскресенье, 1-е июня');

-- --------------------------------------------------------

-- 
-- Структура таблицы `user`
-- 

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_car_exist` tinyint(1) NOT NULL,
  `user_car_use` tinyint(1) NOT NULL,
  `user_ent` varchar(100) default NULL,
  `user_ent_real` varchar(100) NOT NULL,
  `user_confirm` tinyint(1) NOT NULL,
  `user_remarks` text NOT NULL,
  `user_hash` varchar(255) NOT NULL,
  `user_email_sent` tinyint(1) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- 
-- Дамп данных таблицы `user`
-- 

INSERT INTO `user` VALUES (1, 'Сергей Ветко', 'sergey@vetko.net', 1, 1, '2,3', '3', 1, '"test''', '210e0d81309f3325322599048b949362', 1);
INSERT INTO `user` VALUES (10, 'test2test', 'test', 1, 2, '2,3', '2,3', 1, '', '5f4a730552569edce21ff8cd5bec89d0', 1);
        