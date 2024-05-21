-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: zeus_tfg
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador` (
  `id_administrador` int NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `contrasenia` varchar(60) NOT NULL,
  `id_cliente` int NOT NULL,
  PRIMARY KEY (`id_administrador`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  KEY `id_cliente_idx` (`id_cliente`),
  CONSTRAINT `id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT COMMENT 'PK de la tabla clientes, de tipo primary autoincremental.',
  `nombre` varchar(45) NOT NULL COMMENT 'nombre del cliente. de tipo varchar.',
  `apellido` varchar(45) NOT NULL COMMENT 'apellido del cliente de tipo varchar.',
  `direccion` varchar(45) NOT NULL COMMENT 'direccion del cliente de tipo varchar.',
  `telefono` varchar(9) NOT NULL COMMENT 'telefono del cliente de tipo varchar.',
  `email` varchar(45) NOT NULL COMMENT 'email del cliente, de tipo varchar , con indice unique.',
  `contrasenia` varchar(60) NOT NULL COMMENT 'contraseña del cliente, de tipo varchar.',
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'tereza','xxxx','xxxx','123456789','tere@gmail','12345'),(2,'xxx','xxxx','xxxx','123456789','x@gmail.com','12345'),(3,'prueba','prueba','prueba','123456789','prueba@gmail.com','$2y$10$x9B5s5f3sjBf7o04BTbzqeaoco2JcEwzs506q2az5E3r1Vk6BF7i.');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colores` (
  `id_color` int NOT NULL AUTO_INCREMENT,
  `nombre_color` varchar(50) NOT NULL,
  PRIMARY KEY (`id_color`),
  UNIQUE KEY `id_color_UNIQUE` (`id_color`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colores`
--

LOCK TABLES `colores` WRITE;
/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (1,'Rojo'),(2,'Azul'),(3,'Negro'),(4,'Blanco');
/*!40000 ALTER TABLE `colores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL COMMENT 'fecha donde se realizo el pedido, de tipo date.',
  `id_cliente` int NOT NULL COMMENT 'Fk de la tabla clientes , de tipo INT con indice Index.',
  `id_producto` int NOT NULL COMMENT 'Fk de la tabla productos, de tipo INT con indice Index.',
  `cantidad_producto` int NOT NULL,
  `estado_pedido` varchar(50) DEFAULT 'en preparación',
  `id_color` int NOT NULL,
  `id_talla` int NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_producto` (`id_producto`),
  KEY `id_pedido` (`id_cliente`,`id_producto`) USING BTREE,
  KEY `idx_pedido` (`id_pedido`),
  KEY `fk_id_color` (`id_color`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,'2023-11-08',1,2,1,'enviado',1,1);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_color_talla`
--

DROP TABLE IF EXISTS `producto_color_talla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_color_talla` (
  `id_producto_color_talla` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_talla` int NOT NULL,
  `id_color` int NOT NULL,
  PRIMARY KEY (`id_producto_color_talla`),
  KEY `id_talla_idx` (`id_talla`),
  KEY `id_color_idx` (`id_color`),
  KEY `id_producto_idx` (`id_producto`),
  CONSTRAINT `id_color` FOREIGN KEY (`id_color`) REFERENCES `colores` (`id_color`),
  CONSTRAINT `id_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  CONSTRAINT `id_talla` FOREIGN KEY (`id_talla`) REFERENCES `tallas` (`id_talla`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_color_talla`
--

LOCK TABLES `producto_color_talla` WRITE;
/*!40000 ALTER TABLE `producto_color_talla` DISABLE KEYS */;
INSERT INTO `producto_color_talla` VALUES (2,1,1,1),(3,1,1,2),(4,1,1,3),(5,1,1,4),(6,1,2,1),(7,1,2,2),(8,1,2,3),(9,1,2,4),(10,1,3,1),(11,1,3,2),(12,1,3,3),(13,1,3,4),(14,1,4,1),(15,1,4,2),(16,1,4,3),(17,1,4,4),(18,1,5,1),(19,1,5,2),(20,1,5,3),(21,1,5,4),(22,2,1,1),(23,2,1,2),(24,2,1,3),(25,2,1,4),(26,2,2,1),(27,2,2,2),(28,2,2,3),(29,2,2,4),(30,2,3,1),(31,2,3,2),(32,2,3,3),(33,2,3,4),(34,2,4,1),(35,2,4,2),(36,2,4,3),(37,2,4,4),(38,2,5,1),(39,2,5,2),(40,2,5,3),(41,2,5,4),(42,3,1,1),(43,3,1,2),(44,3,1,3),(45,3,1,4),(46,3,2,1),(47,3,2,2),(48,3,2,3),(49,3,2,4),(50,3,3,1),(51,3,3,2),(52,3,3,3),(53,3,3,4),(54,3,4,1),(55,3,4,2),(56,3,4,3),(57,3,4,4),(58,3,5,1),(59,3,5,2),(60,3,5,3),(61,3,5,4),(62,4,1,1),(63,4,1,2),(64,4,1,3),(65,4,1,4),(66,4,2,1),(67,4,2,2),(68,4,2,3),(69,4,2,4),(70,4,3,1),(71,4,3,2),(72,4,3,3),(73,4,3,4),(74,4,4,1),(75,4,4,2),(76,4,4,3),(77,4,4,4),(78,4,5,1),(79,4,5,2),(80,4,5,3),(81,4,5,4),(82,5,1,1),(83,5,1,2),(84,5,1,3),(85,5,1,4),(86,5,2,1),(87,5,2,2),(88,5,2,3),(89,5,2,4),(90,5,3,1),(91,5,3,2),(92,5,3,3),(93,5,3,4),(94,5,4,1),(95,5,4,2),(96,5,4,3),(97,5,4,4),(98,5,5,1),(99,5,5,2),(100,5,5,3),(101,5,5,4),(102,6,1,1),(103,6,1,2),(104,6,1,3),(105,6,1,4),(106,6,2,1),(107,6,2,2),(108,6,2,3),(109,6,2,4),(110,6,3,1),(111,6,3,2),(112,6,3,3),(113,6,3,4),(114,6,4,1),(115,6,4,2),(116,6,4,3),(117,6,4,4),(118,6,5,1),(119,6,5,2),(120,6,5,3),(121,6,5,4),(122,7,1,1),(123,7,1,2),(124,7,1,3),(125,7,1,4),(126,7,2,1),(127,7,2,2),(128,7,2,3),(129,7,2,4),(130,7,3,1),(131,7,3,2),(132,7,3,3),(133,7,3,4),(134,7,4,1),(135,7,4,2),(136,7,4,3),(137,7,4,4),(138,7,5,1),(139,7,5,2),(140,7,5,3),(141,7,5,4),(142,8,1,1),(143,8,1,2),(144,8,1,3),(145,8,1,4),(146,8,2,1),(147,8,2,2),(148,8,2,3),(149,8,2,4),(150,8,3,1),(151,8,3,2),(152,8,3,3),(153,8,3,4),(154,8,4,1),(155,8,4,2),(156,8,4,3),(157,8,4,4),(158,8,5,1),(159,8,5,2),(160,8,5,3),(161,8,5,4),(162,9,1,1),(163,9,1,2),(164,9,1,3),(165,9,1,4),(166,9,2,1),(167,9,2,2),(168,9,2,3),(169,9,2,4),(170,9,3,1),(171,9,3,2),(172,9,3,3),(173,9,3,4),(174,9,4,1),(175,9,4,2),(176,9,4,3),(177,9,4,4),(178,9,5,1),(179,9,5,2),(180,9,5,3),(181,9,5,4);
/*!40000 ALTER TABLE `producto_color_talla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id_producto` int NOT NULL COMMENT 'PK de la tabla producto , de indice Primary',
  `nombre` varchar(45) NOT NULL COMMENT 'nombre del producto, de tipo Varchar.',
  `precio` double(10,2) NOT NULL COMMENT 'precio del producto, de tipo double para almacenar los valores reales en doble precisión.',
  `imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `codigo_producto_UNIQUE` (`id_producto`),
  UNIQUE KEY `codigo` (`id_producto`),
  UNIQUE KEY `codigo_2` (`id_producto`),
  KEY `idx_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Camiseta Goku',25.00,'img/goku.png'),(2,'Naruto',25.00,'img/naruto.png'),(3,'Vegeta',25.00,'img/vegeta.png'),(4,'Gatos',25.00,'img/gatos.png'),(5,'Super Mario',25.00,'img/supermario.png'),(6,'Zelda',25.00,'img/zelda.png'),(7,'Pokémon',25.00,'img/pokemon.png'),(8,'Los Simpson',25.00,'img/lossimpson.png'),(9,'Spider-Man',25.00,'img/spiderman.png');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tallas`
--

DROP TABLE IF EXISTS `tallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tallas` (
  `id_talla` int NOT NULL AUTO_INCREMENT,
  `numero_talla` varchar(50) NOT NULL,
  UNIQUE KEY `id_talla_UNIQUE` (`id_talla`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tallas`
--

LOCK TABLES `tallas` WRITE;
/*!40000 ALTER TABLE `tallas` DISABLE KEYS */;
INSERT INTO `tallas` VALUES (1,'XS'),(2,'S'),(3,'M'),(4,'L'),(5,'XL');
/*!40000 ALTER TABLE `tallas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-21 18:28:53
