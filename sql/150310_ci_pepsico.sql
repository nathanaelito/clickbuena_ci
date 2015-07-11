-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2015 a las 01:28:40
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ci_pepsico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `user_id` int(10) unsigned NOT NULL,
  `account_key` varchar(45) NOT NULL,
  `account_type_id` int(10) unsigned DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_confirm`
--

CREATE TABLE IF NOT EXISTS `account_confirm` (
  `id` varchar(32) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `record_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_recover`
--

CREATE TABLE IF NOT EXISTS `account_recover` (
  `id` varchar(32) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `record_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_type`
--

CREATE TABLE IF NOT EXISTS `account_type` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `account_type`
--

INSERT INTO `account_type` (`id`, `name`, `status`) VALUES
(1, 'Facebook', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ban`
--

CREATE TABLE IF NOT EXISTS `ban` (
`id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT 'login,redimir,concursar,ganar, Ej: 0001 = 1, 1000=8',
  `start` datetime NOT NULL,
  `minutes` int(11) NOT NULL DEFAULT '999999'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codes_redemption`
--

CREATE TABLE IF NOT EXISTS `codes_redemption` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `redemption_date` datetime NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `flag` int(1) NOT NULL,
  `tag` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `points_history`
--

CREATE TABLE IF NOT EXISTS `points_history` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `points_source_id` int(10) unsigned NOT NULL,
  `points` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `points_source`
--

CREATE TABLE IF NOT EXISTS `points_source` (
  `id` int(10) unsigned NOT NULL,
  `key_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `points_source`
--

INSERT INTO `points_source` (`id`, `key_name`) VALUES
(1, 'Código');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redemption_attempt_log`
--

CREATE TABLE IF NOT EXISTS `redemption_attempt_log` (
  `id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requests_log`
--

CREATE TABLE IF NOT EXISTS `requests_log` (
  `id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `url` varchar(254) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE IF NOT EXISTS `role` (
`id` tinyint(1) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Editor'),
(3, 'Visitor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(10) unsigned NOT NULL,
  `status` int(1) unsigned NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `salt` varchar(45) DEFAULT NULL,
  `role` tinyint(1) DEFAULT NULL,
  `register_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `status`, `email`, `password`, `salt`, `role`, `register_date`) VALUES
(2, 1, 'alejandro.olp@gmail.com', 'ba0eb592b4efcbd22acdec0be41cf6ed0ee9b541c76b4bccbfe3071ab808eefe', 'Qqs1R9oGdQSCg9boG6MieLjG', 1, '2014-08-29 05:04:51'),
(4, 0, '192.168.zero.1@gmail.com', 'c70e5a01d019ce65e0e533b17d0fc671c96589e04e506c8866c72037f9baaf6c', 'xGzQTcBmRakCYi34g26qPt9B', 3, '2015-03-10 23:03:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `address_1` varchar(126) NOT NULL,
  `address_2` varchar(126) NOT NULL,
  `number_ext` varchar(10) NOT NULL,
  `number_int` varchar(10) NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `state` varchar(62) NOT NULL,
  `city` varchar(62) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `cellphone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`user_id`), ADD KEY `fk_account_account_type1_idx` (`account_type_id`), ADD KEY `fk_account_user1_idx` (`user_id`);

--
-- Indices de la tabla `account_recover`
--
ALTER TABLE `account_recover`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `fk_account_forget_user1_idx` (`user_id`);

--
-- Indices de la tabla `account_type`
--
ALTER TABLE `account_type`
 ADD PRIMARY KEY (`id`), ADD KEY `status` (`status`);

--
-- Indices de la tabla `ban`
--
ALTER TABLE `ban`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indices de la tabla `codes_redemption`
--
ALTER TABLE `codes_redemption`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `fk_user_role` (`role`);

--
-- Indices de la tabla `user_profile`
--
ALTER TABLE `user_profile`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ban`
--
ALTER TABLE `ban`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `account`
--
ALTER TABLE `account`
ADD CONSTRAINT `fk_account_account_type1` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `fk_account_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `account_recover`
--
ALTER TABLE `account_recover`
ADD CONSTRAINT `fk_account_forget_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ban`
--
ALTER TABLE `ban`
ADD CONSTRAINT `fk_bantable_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_profile`
--
ALTER TABLE `user_profile`
ADD CONSTRAINT `fk_user_profile_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
