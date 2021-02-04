-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour m152-facebook
CREATE DATABASE IF NOT EXISTS `m152-facebook` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `m152-facebook`;

-- Listage de la structure de la table m152-facebook. media
CREATE TABLE IF NOT EXISTS `media` (
  `idMedia` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idPost` int(11) NOT NULL,
  PRIMARY KEY (`idMedia`),
  KEY `FK_idPost` (`idPost`),
  CONSTRAINT `FK_idPost` FOREIGN KEY (`idPost`) REFERENCES `post` (`idPost`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- Listage des données de la table m152-facebook.media : ~0 rows (environ)
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` (`idMedia`, `nom`, `type`, `creationDate`, `modificationDate`, `idPost`) VALUES
	(38, '637112270486526354N-g1003e.jpeg', 'image/jpeg', '2021-02-04 10:28:59', '2021-02-04 10:28:59', 20);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;

-- Listage de la structure de la table m152-facebook. post
CREATE TABLE IF NOT EXISTS `post` (
  `idPost` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPost`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Listage des données de la table m152-facebook.post : ~3 rows (environ)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`idPost`, `commentaire`, `creationDate`, `modificationDate`) VALUES
	(20, 'Template Post', '2021-02-04 10:28:59', '2021-02-04 10:28:59');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
