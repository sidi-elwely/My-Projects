SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


DROP TABLE IF EXISTS `Professeur`;
CREATE TABLE IF NOT EXISTS `Professeur` (
  `idProf` int(11) NOT NULL AUTO_INCREMENT,
  `nomProf` varchar(50) NOT NULL,
  `prenomProf` varchar(50) NOT NULL,
  `mailProf` varchar(100) NOT NULL,
  `motPass` varchar(50) NOT NULL,
  `nomCours` varchar(50) NOT NULL,
  PRIMARY KEY (`idProf`),
  KEY `fk_nomCours` (`nomCours`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Cours`;
CREATE TABLE IF NOT EXISTS `Cours` (
  `nomCours` varchar(50) NOT NULL,
  `dateCours` date NOT NULL,
  PRIMARY KEY (`nomCours`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Etudiant`;
CREATE TABLE IF NOT EXISTS `Etudiant` (
  `idEtu` int(11) NOT NULL AUTO_INCREMENT,
  `nomEtu` varchar(50) NOT NULL,
  `prenomEtu` varchar(50) NOT NULL,
  `mailEtu` varchar(100) NOT NULL,
  `motPass` varchar(50) NOT NULL,
  PRIMARY KEY (`idEtu`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS `Suivi`;
CREATE TABLE IF NOT EXISTS `Suivi` (
  `idEtu` int(11) NOT NULL,
  `nomCours` varchar(50) NOT NULL,
  PRIMARY KEY (`idEtu`, `nomCours`),
  KEY `fk_coursSuivi` (`nomCours`),
  KEY `fk_idEtu` (`idEtu`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS `Absence`;
CREATE TABLE IF NOT EXISTS `Absence` (
  `idEtu` int(11) NOT NULL,
  `nomCours` varchar(50) NOT NULL,
  `heurs` varchar(50) NOT NULL,
  PRIMARY KEY (`idEtu`, `nomCours`),
  KEY `fk_coursRate` (`nomCours`),
  KEY `fk_idEtud` (`idEtu`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS `Notes`;
CREATE TABLE IF NOT EXISTS `Notes` (
  `idEtu` int(11) NOT NULL,
  `nomCours` varchar(50) NOT NULL,
  `note` int(11) NOT NULL,
  `remarque` varchar(50),
  PRIMARY KEY (`idEtu`, `nomCours`),
  KEY `fk_coursRate` (`nomCours`),
  KEY `fk_idEtud` (`idEtu`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8; 



ALTER TABLE `Professeur`
  ADD CONSTRAINT `fk_nomCours` FOREIGN KEY (`nomCours`) REFERENCES `Cours` (`nomCours`);

ALTER TABLE `Suivi`
  ADD CONSTRAINT `fk_coursSuivi` FOREIGN KEY (`nomCours`) REFERENCES `Cours` (`nomCours`),
  ADD CONSTRAINT `fk_idEtu` FOREIGN KEY (`idEtu`) REFERENCES `Etudiant` (`idEtu`);

ALTER TABLE `Absence`
  ADD CONSTRAINT `fk_coursRate` FOREIGN KEY (`nomCours`) REFERENCES `Cours` (`nomCours`),
  ADD CONSTRAINT `fk_idEtud` FOREIGN KEY (`idEtu`) REFERENCES `Etudiant` (`idEtu`);

ALTER TABLE `Notes`
  ADD CONSTRAINT `fk_coursNote` FOREIGN KEY (`nomCours`) REFERENCES `Cours` (`nomCours`),
  ADD CONSTRAINT `fk_idEtudNote` FOREIGN KEY (`idEtu`) REFERENCES `Etudiant` (`idEtu`);

