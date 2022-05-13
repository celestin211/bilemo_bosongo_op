-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 13 mai 2022 à 23:10
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bilemo_bo`
--

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20220512184833', '2022-05-12 18:48:45');

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_client_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_34DCD176190BE4C5` (`user_client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `person`
--

INSERT INTO `person` (`id`, `user_client_id`, `email`, `firstname`, `lastname`) VALUES
(1, 1, 'exemple_bosongocelestin@exemple.com', 'Bososngo', 'Celestin'),
(2, 1, 'exemple_stin@exemple.com', 'Bososngo', 'Celestin'),
(3, 1, 'lelo_stin@exemple.com', 'Bososngo', 'Celestin'),
(4, 1, 'leo_stin@exemple.com', 'Bososngo', 'Celestin'),
(5, 1, 'leo_tin@exemple.com', 'Bososngo', 'Celestin'),
(6, 2, 'bosongocelestin@exemple.com', 'Bososngo', 'Celestin'),
(7, 2, 'baple@exemple.com', 'John', 'Smith'),
(8, 2, 'bouloi@exemple.com', 'John', 'Smith');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `release_year` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_gb` int(11) NOT NULL,
  `memory_gb` int(11) NOT NULL,
  `megapixels` int(11) NOT NULL,
  `screen_size` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `brand`, `model`, `price`, `release_year`, `color`, `storage_gb`, `memory_gb`, `megapixels`, `screen_size`) VALUES
(1, 'iPhone 6S', 'Apple', 45.45, 2015, 'Space Gray', 32, 2015, 15, 3.5),
(2, 'Huwai 6S', 'Apple', 456.45, 2015, 'Space Gray', 32, 20, 15, 3.5);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `roles`) VALUES
(1, 'celestin.bosongo@yahoo.fr', 'celestin', '$argon2id$v=19$m=65536,t=4,p=1$anV4bVhDUmxOT3Nxc1ZXQw$hZmr7DioNMnONttp3pCQifcFgmom+fhwt9+P1NSdkCs', '[\"ROLE_ADMIN\"]'),
(2, 'sonia.bosongo@yahoo.fr', 'sonia', '$argon2id$v=19$m=65536,t=4,p=1$ZHBMeGR5VGFWTno1Tm83dg$/+i80WnWAEVF75pVEnLDoE5PiiZqwSMaW34Y5JYzVro', '[\"ROLE_USER\"]');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `FK_34DCD176190BE4C5` FOREIGN KEY (`user_client_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
