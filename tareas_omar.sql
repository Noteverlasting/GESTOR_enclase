CREATE DATABASE  IF NOT EXISTS `tareas_omar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tareas_omar`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: tareas_omar
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `tareas`
--

DROP TABLE IF EXISTS `tareas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tareas` (
  `idTarea` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('urgente','pendiente','ejecucion','finalizada') NOT NULL,
  `fechaFinal` date DEFAULT NULL,
  `idUsuario` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idTarea`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareas`
--

LOCK TABLES `tareas` WRITE;
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
INSERT INTO `tareas` VALUES (1,'Estudiar PHP','Me encanta PHP y le voy a dedicar un montón de horas','2025-05-06 10:48:58','finalizada',NULL,1),(2,'Estudiar CSS','Me encanta CSS y le voy a dedicar un montón de horas para mejorar','2025-05-06 10:48:58','urgente','2025-05-08',1),(3,'Estudiar HTML','Me encanta HTML y le voy a dedicar un montón de horas más para mejorar mucho','2025-05-06 10:48:58','pendiente',NULL,1),(4,'Estudiar javascript','Me encanta javascript pero tengo que dedicarle un montón de horas más para mejorar','2025-05-06 10:48:58','urgente','2025-05-20',1),(6,'Crear un organizador de tareas','Cada tarea aparecerá separada de las demás, con un fondo de color diferente para cada tipo. Sin embargo en todas ellas debe constar : título, descripción, fecha de inserción o actualización (que la pondrá el sistema, no el usuario)','2025-05-07 07:00:59','ejecucion','2025-05-13',2),(7,'Cambiar el diseño para que sea responsive','Modificar las mediaquery para poder realizar un diseño que se adapte a todas las pantallas','2025-05-07 07:01:54','urgente',NULL,2),(17,'Terminar el gestor','Hay que definir mejor los estilos y aplicar seguridad para que el diseño esté mas completo','2025-05-13 11:46:58','pendiente','2025-05-16',2),(18,'Estudiar javascript','Me encanta javascript pero tengo que dedicarle un montón de horas más para mejorar','2025-05-14 09:45:29','urgente','2025-05-22',1),(19,'Estudiar javascript','Me encanta javascript pero tengo que dedicarle un montón de horas más para mejorar','2025-05-14 09:47:58','pendiente','2025-05-22',1),(20,'Estudiar javascript','Me encanta javascript pero tengo que dedicarle un montón de horas más para mejorar','2025-05-14 09:50:54','pendiente','2025-05-26',1),(21,'Estudiar javascript','Me encanta javascript pero tengo que dedicarle un montón de horas más para mejorar','2025-05-15 07:04:52','ejecucion','2025-05-16',1),(22,'Estudiar javascript','Me encanta javascript pero tengo que dedicarle un montón de horas más para mejorar','2025-05-15 09:06:46','ejecucion','2025-05-23',1);
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(13) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Peppa Pig','peppapig@peppa.pig','666696969','$2y$10$nO01uaNXBCxwt3JcxJdMeukBkhUF/ftcqR/MUgg5CzPulYrzm8mMG'),(2,'Papa pig','papa@peppa.pig','666898989','$2y$10$jHSoeLEU7NzQjE1UMhVFp.zeAnr43jUmJpbx5hanTCFYdnz251cTa');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-19  8:31:11
