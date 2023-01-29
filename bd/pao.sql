-- MariaDB dump 10.19  Distrib 10.5.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pao
-- ------------------------------------------------------
-- Server version	10.5.18-MariaDB-0+deb11u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `academias`
--

DROP TABLE IF EXISTS `academias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `academias` (
  `id_aca` int(11) NOT NULL AUTO_INCREMENT,
  `nom_aca` text DEFAULT NULL,
  `id_est` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_aca`),
  KEY `id_est` (`id_est`),
  CONSTRAINT `academias_ibfk_1` FOREIGN KEY (`id_est`) REFERENCES `estatus` (`id_est`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academias`
--

LOCK TABLES `academias` WRITE;
/*!40000 ALTER TABLE `academias` DISABLE KEYS */;
INSERT INTO `academias` VALUES (1,'AMEJB',1),(2,'AMGNB',1),(3,'AMAB',1),(4,'AMARB',1),(5,'AMMED',1),(6,'ATMEJB',1),(7,'ATMGNB',1),(8,'ATMAB',1),(9,'ATMARB',1),(10,'ATMCOM',1),(11,'ATMSAL',1),(12,'AMHC',1);
/*!40000 ALTER TABLE `academias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accesos`
--

DROP TABLE IF EXISTS `accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accesos` (
  `id_acc` int(11) NOT NULL AUTO_INCREMENT,
  `id_est` int(11) DEFAULT NULL,
  `id_per` int(11) DEFAULT NULL,
  `usu_acc` text DEFAULT NULL,
  `cla_acc` text DEFAULT NULL,
  PRIMARY KEY (`id_acc`),
  KEY `id_est` (`id_est`),
  KEY `id_per` (`id_per`),
  CONSTRAINT `accesos_ibfk_1` FOREIGN KEY (`id_est`) REFERENCES `estatus` (`id_est`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `accesos_ibfk_2` FOREIGN KEY (`id_per`) REFERENCES `personas` (`id_per`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4649 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesos`
--

LOCK TABLES `accesos` WRITE;
/*!40000 ALTER TABLE `accesos` DISABLE KEYS */;
INSERT INTO `accesos` VALUES (1,1,1,'admin','7110eda4d09e062aa5e4a390b0a572ac0d2c0220');
/*!40000 ALTER TABLE `accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acciones`
--

DROP TABLE IF EXISTS `acciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acciones` (
  `id_aci` int(11) NOT NULL AUTO_INCREMENT,
  `nom_aci` text DEFAULT NULL,
  PRIMARY KEY (`id_aci`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acciones`
--

LOCK TABLES `acciones` WRITE;
/*!40000 ALTER TABLE `acciones` DISABLE KEYS */;
INSERT INTO `acciones` VALUES (1,'entrada'),(2,'salida'),(3,'procesar');
/*!40000 ALTER TABLE `acciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auditorias`
--

DROP TABLE IF EXISTS `auditorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auditorias` (
  `id_aud` int(11) NOT NULL AUTO_INCREMENT,
  `id_pro` int(11) DEFAULT NULL,
  `id_mot` int(11) DEFAULT NULL,
  `lug_aud` text DEFAULT NULL,
  `edi_aud` text DEFAULT NULL,
  `hab_aud` text DEFAULT NULL,
  `obs_aud` text DEFAULT NULL,
  PRIMARY KEY (`id_aud`),
  KEY `id_pro` (`id_pro`),
  KEY `id_mot` (`id_mot`),
  CONSTRAINT `auditorias_ibfk_1` FOREIGN KEY (`id_pro`) REFERENCES `procesos` (`id_pro`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auditorias_ibfk_2` FOREIGN KEY (`id_mot`) REFERENCES `motivos` (`id_mot`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4754 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditorias`
--

LOCK TABLES `auditorias` WRITE;
/*!40000 ALTER TABLE `auditorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `auditorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `canchas`
--

DROP TABLE IF EXISTS `canchas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `canchas` (
  `id_can` int(11) NOT NULL AUTO_INCREMENT,
  `nom_can` text DEFAULT NULL,
  `id_est` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_can`),
  KEY `id_est` (`id_est`),
  CONSTRAINT `canchas_ibfk_1` FOREIGN KEY (`id_est`) REFERENCES `estatus` (`id_est`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canchas`
--

LOCK TABLES `canchas` WRITE;
/*!40000 ALTER TABLE `canchas` DISABLE KEYS */;
INSERT INTO `canchas` VALUES (3,'DEFENSA PERSONAL MILITAR',1),(4,'LOGISTICA TERRITORIAL',1),(5,'NAVEGACION NOCTURNA',1),(6,'SUPERVIVENCIA Y PRIMEROS AUXILIOS',1),(12,'POLIGONO DE COMBATE EN ESCUADRA',1),(13,'POLIGONO DE COMBATE EN ESCUADRA NOCTURNO',1),(15,'NUDOS, APAREJOS E INFILTRACION',1);
/*!40000 ALTER TABLE `canchas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companias`
--

DROP TABLE IF EXISTS `companias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companias` (
  `id_com` int(11) NOT NULL AUTO_INCREMENT,
  `nom_com` text DEFAULT NULL,
  `id_est` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_com`),
  KEY `id_est` (`id_est`),
  CONSTRAINT `companias_ibfk_1` FOREIGN KEY (`id_est`) REFERENCES `estatus` (`id_est`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companias`
--

LOCK TABLES `companias` WRITE;
/*!40000 ALTER TABLE `companias` DISABLE KEYS */;
INSERT INTO `companias` VALUES (1,'C1',1),(2,'C2',1),(3,'C3',1),(4,'C4',1),(5,'C5',1),(6,'C6',1),(7,'C7',1),(8,'C8',1),(9,'C9',1),(10,'C10',1),(11,'C11',1),(12,'C12',1),(13,'C13',1),(14,'C14',1),(15,'C15',1),(16,'C16',1),(17,'C17',1),(18,'C18',1),(19,'c1000',1);
/*!40000 ALTER TABLE `companias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estatus`
--

DROP TABLE IF EXISTS `estatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estatus` (
  `id_est` int(11) NOT NULL AUTO_INCREMENT,
  `nom_est` text DEFAULT NULL,
  PRIMARY KEY (`id_est`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatus`
--

LOCK TABLES `estatus` WRITE;
/*!40000 ALTER TABLE `estatus` DISABLE KEYS */;
INSERT INTO `estatus` VALUES (1,'activo'),(2,'inactivo');
/*!40000 ALTER TABLE `estatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluaciones`
--

DROP TABLE IF EXISTS `evaluaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evaluaciones` (
  `id_eva` int(11) NOT NULL AUTO_INCREMENT,
  `id_per` int(11) DEFAULT NULL,
  `id_can` int(11) DEFAULT NULL,
  `not_eva` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_eva`),
  KEY `id_per` (`id_per`),
  KEY `id_can` (`id_can`),
  CONSTRAINT `evaluaciones_ibfk_1` FOREIGN KEY (`id_per`) REFERENCES `personas` (`id_per`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `evaluaciones_ibfk_2` FOREIGN KEY (`id_can`) REFERENCES `canchas` (`id_can`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluaciones`
--

LOCK TABLES `evaluaciones` WRITE;
/*!40000 ALTER TABLE `evaluaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jefe`
--

DROP TABLE IF EXISTS `jefe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jefe` (
  `id_jef` int(11) NOT NULL AUTO_INCREMENT,
  `id_per` int(11) DEFAULT NULL,
  `car_jef` text DEFAULT NULL,
  PRIMARY KEY (`id_jef`),
  KEY `id_per` (`id_per`),
  CONSTRAINT `jefe_ibfk_1` FOREIGN KEY (`id_per`) REFERENCES `personas` (`id_per`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jefe`
--

LOCK TABLES `jefe` WRITE;
/*!40000 ALTER TABLE `jefe` DISABLE KEYS */;
/*!40000 ALTER TABLE `jefe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jerarquias`
--

DROP TABLE IF EXISTS `jerarquias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jerarquias` (
  `id_jer` int(11) NOT NULL AUTO_INCREMENT,
  `nom_jer` text DEFAULT NULL,
  `id_est` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jer`),
  KEY `id_est` (`id_est`),
  CONSTRAINT `jerarquias_ibfk_1` FOREIGN KEY (`id_est`) REFERENCES `estatus` (`id_est`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jerarquias`
--

LOCK TABLES `jerarquias` WRITE;
/*!40000 ALTER TABLE `jerarquias` DISABLE KEYS */;
INSERT INTO `jerarquias` VALUES (1,'GJ',1),(2,'MG',1),(3,'GD',1),(4,'GB',1),(5,'CNEL',1),(6,'TCNEL',1),(7,'MAY',1),(8,'CAP',1),(9,'1TTE',1),(10,'TTE',1),(11,'SS',1),(12,'SA',1),(13,'SM1',1),(14,'SM2',1),(15,'SM3',1),(16,'S1',1),(17,'S2',1),(18,'C1',1),(19,'C2',1),(20,'S/D',1),(21,'S/R',1),(22,'S/A',1),(23,'C/I',1),(24,'CD/I',1),(25,'C/II',1),(26,'CD/II',1),(27,'C/III',1),(28,'BRIG',1),(29,'1ER BRIG',1),(30,'2DO BRIG',1),(31,'BRIG MAY',1),(32,'C/IV',1),(33,'ALF',1),(34,'ALF AUX',1),(35,'ALF MAY',1),(36,'ING',1),(37,'LIC',1),(38,'CDDNO(A)',1);
/*!40000 ALTER TABLE `jerarquias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivos`
--

DROP TABLE IF EXISTS `motivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motivos` (
  `id_mot` int(11) NOT NULL AUTO_INCREMENT,
  `nom_mot` text DEFAULT NULL,
  PRIMARY KEY (`id_mot`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivos`
--

LOCK TABLES `motivos` WRITE;
/*!40000 ALTER TABLE `motivos` DISABLE KEYS */;
INSERT INTO `motivos` VALUES (1,'registrar'),(2,'insertar'),(3,'editar'),(4,'eliminar'),(5,'reporte');
/*!40000 ALTER TABLE `motivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personas`
--

DROP TABLE IF EXISTS `personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personas` (
  `id_per` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) DEFAULT NULL,
  `id_com` int(11) DEFAULT NULL,
  `id_aca` int(11) DEFAULT NULL,
  `id_jer` int(11) DEFAULT NULL,
  `id_sex` int(11) DEFAULT NULL,
  `ced_per` text DEFAULT NULL,
  `mat_per` varchar(4) DEFAULT NULL,
  `nom_per` text DEFAULT NULL,
  `ape_per` text DEFAULT NULL,
  PRIMARY KEY (`id_per`),
  KEY `id_rol` (`id_rol`),
  KEY `id_com` (`id_com`),
  KEY `id_aca` (`id_aca`),
  KEY `id_jer` (`id_jer`),
  KEY `id_sex` (`id_sex`),
  CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`id_com`) REFERENCES `companias` (`id_com`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `personas_ibfk_3` FOREIGN KEY (`id_aca`) REFERENCES `academias` (`id_aca`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `personas_ibfk_4` FOREIGN KEY (`id_jer`) REFERENCES `jerarquias` (`id_jer`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `personas_ibfk_5` FOREIGN KEY (`id_sex`) REFERENCES `sexos` (`id_sex`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4650 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personas`
--

LOCK TABLES `personas` WRITE;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` VALUES (1,1,NULL,1,NULL,NULL,'admin','','admin','admin');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posicion`
--

DROP TABLE IF EXISTS `posicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posicion` (
  `id_pos` int(11) NOT NULL AUTO_INCREMENT,
  `id_per` int(11) DEFAULT NULL,
  `pro_pos` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_pos`),
  KEY `id_per` (`id_per`),
  CONSTRAINT `posicion_ibfk_1` FOREIGN KEY (`id_per`) REFERENCES `personas` (`id_per`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posicion`
--

LOCK TABLES `posicion` WRITE;
/*!40000 ALTER TABLE `posicion` DISABLE KEYS */;
/*!40000 ALTER TABLE `posicion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procesos`
--

DROP TABLE IF EXISTS `procesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procesos` (
  `id_pro` int(11) NOT NULL AUTO_INCREMENT,
  `id_aci` int(11) DEFAULT NULL,
  `id_acc` int(11) DEFAULT NULL,
  `id_per` int(11) DEFAULT NULL,
  `fec_pro` date DEFAULT NULL,
  `hor_pro` time DEFAULT NULL,
  PRIMARY KEY (`id_pro`),
  KEY `id_aci` (`id_aci`),
  KEY `id_acc` (`id_acc`),
  KEY `id_per` (`id_per`),
  CONSTRAINT `procesos_ibfk_1` FOREIGN KEY (`id_aci`) REFERENCES `acciones` (`id_aci`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `procesos_ibfk_2` FOREIGN KEY (`id_acc`) REFERENCES `accesos` (`id_acc`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `procesos_ibfk_3` FOREIGN KEY (`id_per`) REFERENCES `personas` (`id_per`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4754 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procesos`
--

LOCK TABLES `procesos` WRITE;
/*!40000 ALTER TABLE `procesos` DISABLE KEYS */;
/*!40000 ALTER TABLE `procesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nom_rol` text DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrador'),(2,'operador'),(3,'cadete'),(4,'transcriptor');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexos`
--

DROP TABLE IF EXISTS `sexos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sexos` (
  `id_sex` int(11) NOT NULL AUTO_INCREMENT,
  `nom_sex` text DEFAULT NULL,
  PRIMARY KEY (`id_sex`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexos`
--

LOCK TABLES `sexos` WRITE;
/*!40000 ALTER TABLE `sexos` DISABLE KEYS */;
INSERT INTO `sexos` VALUES (1,'masculino'),(2,'femenino');
/*!40000 ALTER TABLE `sexos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-29 19:22:47
