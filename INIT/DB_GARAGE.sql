CREATE DATABASE  IF NOT EXISTS `garage` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `garage`;
-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: garage
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `client_demande`
--

DROP TABLE IF EXISTS `client_demande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_demande` (
  `nom` text NOT NULL,
  `prenom` text,
  `email` text,
  `phone` text,
  `adresse` text,
  `message` text,
  `idx_vehicule` bigint DEFAULT NULL,
  `idx_contact_client` bigint NOT NULL AUTO_INCREMENT,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx_contact_client`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `marque`
--

DROP TABLE IF EXISTS `marque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marque` (
  `code` char(5) NOT NULL,
  `libelle` text,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marque`
--

LOCK TABLES `marque` WRITE;
/*!40000 ALTER TABLE `marque` DISABLE KEYS */;
INSERT INTO `marque` VALUES ('00','ABARTH'),('01','AUDI'),('02','BMW'),('03','FIAT'),('04','FORD'),('05','MERCEDES'),('06','MINI'),('07','PEUGEOT'),('08','RENAULT');
/*!40000 ALTER TABLE `marque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestation`
--

DROP TABLE IF EXISTS `prestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestation` (
  `code` char(5) NOT NULL,
  `libelle` text,
  `code_type_prestation` char(5) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestation`
--

LOCK TABLES `prestation` WRITE;
/*!40000 ALTER TABLE `prestation` DISABLE KEYS */;
INSERT INTO `prestation` VALUES ('00','Véhicule','VD'),('01','Carrosserie','RP'),('02','Mécanique','RP'),('03','Entretien','RP');
/*!40000 ALTER TABLE `prestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propriete`
--

DROP TABLE IF EXISTS `propriete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propriete` (
  `code` char(4) NOT NULL,
  `libelle` text,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propriete`
--

LOCK TABLES `propriete` WRITE;
/*!40000 ALTER TABLE `propriete` DISABLE KEYS */;
INSERT INTO `propriete` VALUES ('BO','Type de boite'),('GA','Garantie'),('MO','Motorisation'),('NBPO','Nombre de Porte');
/*!40000 ALTER TABLE `propriete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propriete_valeur`
--

DROP TABLE IF EXISTS `propriete_valeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propriete_valeur` (
  `code_propriete` char(4) NOT NULL,
  `code_valeur` char(4) NOT NULL,
  `libelle` text,
  PRIMARY KEY (`code_propriete`,`code_valeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propriete_valeur`
--

LOCK TABLES `propriete_valeur` WRITE;
/*!40000 ALTER TABLE `propriete_valeur` DISABLE KEYS */;
INSERT INTO `propriete_valeur` VALUES ('BO','AU','Automatique'),('BO','MA','Manuelle'),('GA','12','12 mois'),('GA','24','24 mois'),('GA','36','36 mois'),('MO','DI','Diesel'),('MO','EL','Electrique'),('MO','ES','Essence'),('MO','HY','Hybride');
/*!40000 ALTER TABLE `propriete_valeur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temoignage`
--

DROP TABLE IF EXISTS `temoignage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temoignage` (
  `idx_temoignage` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `commentaire` text,
  `note` int DEFAULT NULL,
  `is_publie` tinyint(1) DEFAULT '0' COMMENT '0 FALSE\n1 TRUE',
  `is_interdit` tinyint(1) DEFAULT '0',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_publication` datetime DEFAULT NULL,
  PRIMARY KEY (`idx_temoignage`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temoignage`
--
--
-- Table structure for table `type_prestation`
--

DROP TABLE IF EXISTS `type_prestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `type_prestation` (
  `code` char(5) NOT NULL,
  `libelle` text,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_prestation`
--

LOCK TABLES `type_prestation` WRITE;
/*!40000 ALTER TABLE `type_prestation` DISABLE KEYS */;
INSERT INTO `type_prestation` VALUES ('RP','Réparation'),('VD','Vente Direct');
/*!40000 ALTER TABLE `type_prestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
  `identifiant` varchar(45) NOT NULL,
  `mdp` text,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `type_utilisateur` char(1) DEFAULT NULL COMMENT 'A : admin\nE : employes',
  `adress` text,
  `code_postal` char(5) DEFAULT NULL,
  `ville` text,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES ('\'\"test= €','\"\'toto','','','A',NULL,NULL,NULL),('1','toto','emp1 nom','emp1 prenom','E',NULL,NULL,NULL),('T3','T4','T5','T6','E',NULL,NULL,NULL),('titi','toto','','','A',NULL,NULL,NULL),('tutu','1e80dbe36634ff1056cd3cb9a4321831e5732d2c10d9212e3c','tutu','tutut','A',NULL,NULL,NULL);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicule` (
  `idx_vehicule` bigint NOT NULL AUTO_INCREMENT,
  `code_marque` char(5) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `prix` decimal(7,2) DEFAULT NULL,
  `annee_circulation` int DEFAULT NULL,
  `km` int DEFAULT NULL,
  `url_img` text,
  `status` varchar(45) DEFAULT NULL COMMENT 'null : Vehicule venant d''arriver\nP  : PUBLIER\nR  : RESA\nV  : VENTE\nA : ANNULATION',
  PRIMARY KEY (`idx_vehicule`),
  KEY `fk_marque_idx` (`code_marque`),
  CONSTRAINT `fk_marque` FOREIGN KEY (`code_marque`) REFERENCES `marque` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicule`
--

LOCK TABLES `vehicule` WRITE;
/*!40000 ALTER TABLE `vehicule` DISABLE KEYS */;
INSERT INTO `vehicule` VALUES (1,'00','FIAT',12990.00,2022,25000,'FIAT_500_GREEN_680x430.jpg',NULL),(2,'00','ABARTH',13500.00,2020,32000,'526_380.png',NULL),(3,'01','BMX',40000.00,2020,10000,'bmw blanche slider.jpg',NULL),(4,'02','AUDI',45500.00,2021,11000,'Audi bleu slider.jpg',NULL),(5,'03','AUDI',53000.00,2022,11000,'Audi cabriolet.avif',NULL),(6,'04','Kia',10000.00,2019,32000,'Kia jaune.avif',NULL),(7,'05','Cherokee',48000.00,2021,35000,'Cherokee.png',NULL),(8,'06','Mercedes',80000.00,2019,70000,'Mercedes cabriolet.avif',NULL),(9,'07','Range Rover',60000.00,2019,60000,'Range-Rover marron.avif',NULL),(10,'08','Renault Jaune',18000.00,2020,36000,'Renault jaune.png',NULL);
/*!40000 ALTER TABLE `vehicule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicule_propriete`
--

DROP TABLE IF EXISTS `vehicule_propriete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicule_propriete` (
  `idx_vehicule` bigint NOT NULL,
  `code_propriete` char(4) NOT NULL,
  `code_valeur` char(4) DEFAULT NULL,
  PRIMARY KEY (`idx_vehicule`,`code_propriete`),
  KEY `fk_propriete_idx` (`code_propriete`),
  KEY `fk_propriete_valeur_idx` (`code_propriete`,`code_valeur`),
  CONSTRAINT `fk_propriete` FOREIGN KEY (`code_propriete`) REFERENCES `propriete` (`code`),
  CONSTRAINT `fk_propriete_valeur` FOREIGN KEY (`code_propriete`, `code_valeur`) REFERENCES `propriete_valeur` (`code_propriete`, `code_valeur`),
  CONSTRAINT `fk_vehicule` FOREIGN KEY (`idx_vehicule`) REFERENCES `vehicule` (`idx_vehicule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicule_propriete`
--

LOCK TABLES `vehicule_propriete` WRITE;
/*!40000 ALTER TABLE `vehicule_propriete` DISABLE KEYS */;
INSERT INTO `vehicule_propriete` VALUES (2,'BO','AU'),(1,'BO','MA'),(1,'GA','12'),(1,'MO','ES');
/*!40000 ALTER TABLE `vehicule_propriete` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-18 17:46:19
