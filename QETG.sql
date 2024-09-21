-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 21 sep. 2024 à 10:06
-- Version du serveur : 8.3.0
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id_quiz` int NOT NULL AUTO_INCREMENT,
  `id_image_quiz` int DEFAULT NULL,
  `nom_quiz` varchar(50) NOT NULL,
  `bienvenue` text NOT NULL,
  `xp` int NOT NULL DEFAULT '5',
  `id_user` int NOT NULL DEFAULT '1',
  `id_quiz_user` int NOT NULL DEFAULT '0',
  `src` text,
  `quizComplet` int NOT NULL DEFAULT '0',
  `nbrQuestion` int NOT NULL,
  `portee` tinyint(1) NOT NULL DEFAULT '1',
  `vue` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_quiz`),
  KEY `fk_image_quiz` (`id_image_quiz`),
  KEY `fk_quiz_membre` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_cle`
--

DROP TABLE IF EXISTS `quiz_cle`;
CREATE TABLE IF NOT EXISTS `quiz_cle` (
  `id_cle` int NOT NULL AUTO_INCREMENT,
  `cle` text NOT NULL,
  `cle_login` text NOT NULL,
  `cle_pass_md5` text NOT NULL,
  `cle_email` varchar(100) NOT NULL,
  `cle_nom` varchar(20) NOT NULL,
  `cle_prenom` varchar(20) NOT NULL,
  `cle_newletter` int NOT NULL DEFAULT '0',
  `cle_date` date NOT NULL,
  PRIMARY KEY (`id_cle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_commentaire`
--

DROP TABLE IF EXISTS `quiz_commentaire`;
CREATE TABLE IF NOT EXISTS `quiz_commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `commentaire` varchar(1000) NOT NULL,
  `date_creation` varchar(50) NOT NULL,
  `ip_utilisateur` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_difficulte`
--

DROP TABLE IF EXISTS `quiz_difficulte`;
CREATE TABLE IF NOT EXISTS `quiz_difficulte` (
  `id_difficulte` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`id_difficulte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_image`
--

DROP TABLE IF EXISTS `quiz_image`;
CREATE TABLE IF NOT EXISTS `quiz_image` (
  `id_image` int NOT NULL AUTO_INCREMENT,
  `src` varchar(200) NOT NULL,
  `alt` varchar(300) NOT NULL,
  PRIMARY KEY (`id_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_like_quiz`
--

DROP TABLE IF EXISTS `quiz_like_quiz`;
CREATE TABLE IF NOT EXISTS `quiz_like_quiz` (
  `id_like` int NOT NULL AUTO_INCREMENT,
  `id_quiz` int NOT NULL,
  `ip` text NOT NULL,
  `likeOrDislike` int NOT NULL DEFAULT '1',
  `esQuizUser` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_like`),
  KEY `fk_like_quiz_quiz` (`id_quiz`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_membre`
--

DROP TABLE IF EXISTS `quiz_membre`;
CREATE TABLE IF NOT EXISTS `quiz_membre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `pass_md5` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `admin` int NOT NULL DEFAULT '0',
  `image_profil` varchar(200) NOT NULL DEFAULT 'default',
  `newletter` int NOT NULL DEFAULT '0',
  `ip` text NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_membre_succes`
--

DROP TABLE IF EXISTS `quiz_membre_succes`;
CREATE TABLE IF NOT EXISTS `quiz_membre_succes` (
  `id_membre_succes` int NOT NULL AUTO_INCREMENT,
  `id_succes` int NOT NULL,
  `id_membre` int NOT NULL,
  `date_succes` varchar(100) NOT NULL,
  PRIMARY KEY (`id_membre_succes`),
  KEY `fk_membre_succes_membre` (`id_membre`),
  KEY `fk_membre_succes_succes` (`id_succes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_progression`
--

DROP TABLE IF EXISTS `quiz_progression`;
CREATE TABLE IF NOT EXISTS `quiz_progression` (
  `id_prog` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_question` int NOT NULL,
  PRIMARY KEY (`id_prog`),
  KEY `fk_progression_question` (`id_question`),
  KEY `fk_progression_membre` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_question`
--

DROP TABLE IF EXISTS `quiz_question`;
CREATE TABLE IF NOT EXISTS `quiz_question` (
  `id_question` int NOT NULL AUTO_INCREMENT,
  `id_quiz` int NOT NULL,
  `id_image_question` int DEFAULT NULL,
  `texte_bienvenue` text,
  `id_difficulte` int NOT NULL,
  `question_texte` text NOT NULL,
  `numero_question` int NOT NULL,
  `nbrReponse` int NOT NULL DEFAULT '2',
  PRIMARY KEY (`id_question`),
  KEY `fk_question_image` (`id_image_question`),
  KEY `fk_question_difficulte` (`id_difficulte`),
  KEY `fk_question_quiz` (`id_quiz`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_reponse`
--

DROP TABLE IF EXISTS `quiz_reponse`;
CREATE TABLE IF NOT EXISTS `quiz_reponse` (
  `id_reponse` int NOT NULL AUTO_INCREMENT,
  `id_question` int NOT NULL,
  `id_image_reponse` int DEFAULT NULL,
  `choix_possible_quiz` varchar(200) NOT NULL,
  `reponseOK` varchar(10) NOT NULL,
  `texte_reponse_explicatif` text,
  `num_reponse` int DEFAULT NULL,
  PRIMARY KEY (`id_reponse`),
  KEY `fk_reponse_image` (`id_image_reponse`),
  KEY `fk_reponse_question` (`id_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_reponse_commentaire`
--

DROP TABLE IF EXISTS `quiz_reponse_commentaire`;
CREATE TABLE IF NOT EXISTS `quiz_reponse_commentaire` (
  `id_reponse_commentaire` int NOT NULL AUTO_INCREMENT,
  `id_commentaire` int NOT NULL,
  `id_user` int NOT NULL,
  `reponse_val` text NOT NULL,
  `ip_rep` text NOT NULL,
  PRIMARY KEY (`id_reponse_commentaire`),
  KEY `fk_reponse_commentaire_commentaire` (`id_commentaire`),
  KEY `fk_reponse_commentaire_membre` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_signalement`
--

DROP TABLE IF EXISTS `quiz_signalement`;
CREATE TABLE IF NOT EXISTS `quiz_signalement` (
  `id_signalement` int NOT NULL AUTO_INCREMENT,
  `id_user_origine` int NOT NULL,
  `id_user_cible` int NOT NULL,
  PRIMARY KEY (`id_signalement`),
  KEY `fk_signalement_membre` (`id_user_cible`),
  KEY `fk_signalement_membre_2` (`id_user_origine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_statistique`
--

DROP TABLE IF EXISTS `quiz_statistique`;
CREATE TABLE IF NOT EXISTS `quiz_statistique` (
  `id_user` int NOT NULL,
  `id_quiz` int NOT NULL,
  `date` text NOT NULL,
  `note` int NOT NULL DEFAULT '0',
  `favoris` int NOT NULL DEFAULT '0',
  `quiz_utilisateur` int NOT NULL DEFAULT '1',
  UNIQUE KEY `index_stat` (`id_user`,`id_quiz`),
  KEY `fk_statistique_quiz` (`id_quiz`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_subscription_membre`
--

DROP TABLE IF EXISTS `quiz_subscription_membre`;
CREATE TABLE IF NOT EXISTS `quiz_subscription_membre` (
  `idAbonnement` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `idUserAbonnement` int NOT NULL,
  `dateAjout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAbonnement`),
  KEY `fk_subscriptionMembre_membre` (`idUser`),
  KEY `fk_subscriberMembre_membre` (`idUserAbonnement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_succes`
--

DROP TABLE IF EXISTS `quiz_succes`;
CREATE TABLE IF NOT EXISTS `quiz_succes` (
  `id_succes` int NOT NULL AUTO_INCREMENT,
  `nom_succes` varchar(100) NOT NULL,
  `xp_succes` int NOT NULL,
  `descri_succes` text NOT NULL,
  PRIMARY KEY (`id_succes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `fk_image_quiz` FOREIGN KEY (`id_image_quiz`) REFERENCES `quiz_image` (`id_image`),
  ADD CONSTRAINT `fk_quiz_membre` FOREIGN KEY (`id_user`) REFERENCES `quiz_membre` (`id`);

--
-- Contraintes pour la table `quiz_like_quiz`
--
ALTER TABLE `quiz_like_quiz`
  ADD CONSTRAINT `fk_like_quiz_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_membre_succes`
--
ALTER TABLE `quiz_membre_succes`
  ADD CONSTRAINT `fk_membre_succes_membre` FOREIGN KEY (`id_membre`) REFERENCES `quiz_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_membre_succes_succes` FOREIGN KEY (`id_succes`) REFERENCES `quiz_succes` (`id_succes`);

--
-- Contraintes pour la table `quiz_progression`
--
ALTER TABLE `quiz_progression`
  ADD CONSTRAINT `fk_progression_membre` FOREIGN KEY (`id_user`) REFERENCES `quiz_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_progression_question` FOREIGN KEY (`id_question`) REFERENCES `quiz_question` (`id_question`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `fk_question_difficulte` FOREIGN KEY (`id_difficulte`) REFERENCES `quiz_difficulte` (`id_difficulte`),
  ADD CONSTRAINT `fk_question_image` FOREIGN KEY (`id_image_question`) REFERENCES `quiz_image` (`id_image`),
  ADD CONSTRAINT `fk_question_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_reponse`
--
ALTER TABLE `quiz_reponse`
  ADD CONSTRAINT `fk_reponse_image` FOREIGN KEY (`id_image_reponse`) REFERENCES `quiz_image` (`id_image`),
  ADD CONSTRAINT `fk_reponse_question` FOREIGN KEY (`id_question`) REFERENCES `quiz_question` (`id_question`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_reponse_commentaire`
--
ALTER TABLE `quiz_reponse_commentaire`
  ADD CONSTRAINT `fk_reponse_commentaire_commentaire` FOREIGN KEY (`id_commentaire`) REFERENCES `quiz_commentaire` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reponse_commentaire_membre` FOREIGN KEY (`id_user`) REFERENCES `quiz_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_signalement`
--
ALTER TABLE `quiz_signalement`
  ADD CONSTRAINT `fk_signalement_membre` FOREIGN KEY (`id_user_cible`) REFERENCES `quiz_membre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_signalement_membre_2` FOREIGN KEY (`id_user_origine`) REFERENCES `quiz_membre` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_statistique`
--
ALTER TABLE `quiz_statistique`
  ADD CONSTRAINT `fk_statistique_membre` FOREIGN KEY (`id_user`) REFERENCES `quiz_membre` (`id`),
  ADD CONSTRAINT `fk_statistique_quiz` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_subscription_membre`
--
ALTER TABLE `quiz_subscription_membre`
  ADD CONSTRAINT `fk_subscriberMembre_membre` FOREIGN KEY (`idUserAbonnement`) REFERENCES `quiz_membre` (`id`),
  ADD CONSTRAINT `fk_subscriptionMembre_membre` FOREIGN KEY (`idUser`) REFERENCES `quiz_membre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
