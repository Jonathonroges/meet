-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 05, 2023 at 06:59 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meet`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` longtext,
  `user_password` longtext,
  `user_phone` mediumtext,
  `user_email` longtext,
  `user_bio` longtext,
  `user_photo_perfil` longtext,
  `user_birthday` date DEFAULT NULL,
  `user_sexo` longtext,
  `user_latitude` longtext,
  `user_longitude` longtext,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_phone`, `user_email`, `user_bio`, `user_photo_perfil`, `user_birthday`, `user_sexo`, `user_latitude`, `user_longitude`) VALUES
(5, 'Henrrique Dias', '123', '(75) 99119-5121', 'henrrique@gmail.com', 'Aguem bem divertido que gosta de aproveitar bem a vida.\r\nProcuro pessoas com o mesmo intuito e sempre aberto a novas experiencias.\r\n:)\r\n            				 				 				 ', 'man-with-glasses-smiling-looking-into-distance.jpg', '2023-08-03', 'male', NULL, NULL),
(7, 'Lucas Silva', '123', '(75) 99119-5121', 'lucassilva@gmail.com', 'Sapeca, divertido e extrovertido.\r\nvenha e acessse meu perfil para conhecer mais sobre mim\r\ngosto de nadas na praia, cultivar boas amizades e aberto a novas experiências.\r\n:) enjoy!\r\n            ', 'images.jpeg', '1989-02-01', 'male', NULL, NULL),
(8, 'Ana Fenix', '123', '(75) 99119-5121', 'ana@gmail.com', '   Aguem bem divertido que gosta de aproveitar bem a vida.\r\nProcuro pessoas com o mesmo intuito e sempre aberto a novas experiencias.\r\n:)				 				 				 				 				 				 				 ', 'Beautiful-Girls-Images-Pics-new-Download-1.jpg', '1989-02-01', 'female', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_new_post`
--

DROP TABLE IF EXISTS `user_new_post`;
CREATE TABLE IF NOT EXISTS `user_new_post` (
  `user_new_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_new_post_user_id` int(11) DEFAULT NULL,
  `user_new_post_image` longtext,
  `user_new_post_date` datetime DEFAULT NULL,
  `user_new_post_description` longtext,
  `user_new_post_arquivar` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`user_new_post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_new_post`
--

INSERT INTO `user_new_post` (`user_new_post_id`, `user_new_post_user_id`, `user_new_post_image`, `user_new_post_date`, `user_new_post_description`, `user_new_post_arquivar`) VALUES
(1, 8, 'Travelshoot-photoshoot-Paris-7.jpg', '2023-08-04 10:57:32', 'Uma viagem inesquecivel\r\n								', 'no'),
(2, 8, 'Surprise-Proposal-in-Paris-4.jpg', '2023-08-04 10:59:15', 'Quer casar comigo\r\n:)', 'no'),
(3, 8, '2f268866-city-36014-16dee346533.jpg', '2023-08-04 11:07:26', 'Pelas belas ruas nostalgicas de paris', 'no'),
(4, 8, '10ca3cb67e65c9c538aecbe4312354e4.jpg', '2023-08-04 11:12:00', 'uma volta divertida!', 'no'),
(5, 8, 'Small-Dog-Names-678x381.jpg', '2023-08-04 11:57:59', 'My Doginho :)', 'no'),
(6, 8, 'images.jpeg', '2023-08-04 12:03:41', 'litle boy', 'no'),
(7, 5, 'Katapul-2-1600x800.png', '2023-08-05 10:26:10', 'Montanha-russa é uma atração popular dos parques de diversões modernos. Consiste basicamente em uma estrutura de aço que forme uma pista composta por.', 'no'),
(8, 5, 'Rollercoaster_expedition_geforce_holiday_park_germany.jpg', '2023-08-05 10:26:41', 'Os carros comuns de montanha-russa não são puxados todo o tempo. Normalmente são erguidos através de cabos mecânicos sendo soltos ao topo da primeira ', 'no'),
(9, 5, 'photo-1575425186775-b8de9a427e67.jpeg', '2023-08-05 10:31:44', 'O pug é classificado como “cão de companhia“, fazendo parte do grupo dos cães “Toys” ou “de Companhia”, o grupo 9. Os pugs deveriam pesar entre 6,3 e 8,1 kg, sendo cães pesados para a sua estatura. Sua aparência geral deve ser quadrada e maciça, deve mostrar “multum in parvo ” (muita substância em um pequeno volume), o que transparece em sua forma compacta, com proporcionalidade entre as partes e musculatura firme.\r\n\r\nA cabeça do pug é a característica mais original e típica da raça. Deve ser redo', 'no'),
(10, 5, 'app-fotos-antigas-retro-vintage_o1e5shor751k5f14p31n7dqer1570e.jpg', '2023-08-05 10:34:22', 'Uma bela lembrança dos anos 80.', 'no'),
(11, 7, 'rock-in-rio-2017-no-rio-de-janeiro20170917_00031.jpg', '2023-08-05 10:59:42', 'Rock in rio gays :) lets go...', 'no'),
(12, 7, 'Rock-in-Rio-4.jpg', '2023-08-05 11:00:30', 'jump in aftermoon hard core!!!', 'no'),
(13, 7, 'maxresdefault.jpg', '2023-08-05 11:02:43', 'beatiful girls.', 'no'),
(14, 8, 'estilo-vintage-3.jpg', '2023-08-05 11:50:45', 'Moda Vintage\r\nEnjoy :)', 'no');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
