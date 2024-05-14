CREATE DATABASE  IF NOT EXISTS `zeus_tfg` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `zeus_tfg`;
-- MySQL dump 10.13  Distrib 8.0.25, for macos11 (x86_64)
--
-- Host: 127.0.0.1    Database: zeus_tfg
-- ------------------------------------------------------
-- Server version	5.7.44

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
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador` (
  `id_administrador` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `contrasenia` varchar(60) NOT NULL,
  PRIMARY KEY (`id_administrador`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK de la tabla clientes, de tipo primary autoincremental.',
  `nombre` varchar(45) NOT NULL COMMENT 'nombre del cliente. de tipo varchar.',
  `apellido` varchar(45) NOT NULL COMMENT 'apellido del cliente de tipo varchar.',
  `direccion` varchar(45) NOT NULL COMMENT 'direccion del cliente de tipo varchar.',
  `telefono` varchar(9) NOT NULL COMMENT 'telefono del cliente de tipo varchar.',
  `email` varchar(45) NOT NULL COMMENT 'email del cliente, de tipo varchar , con indice unique.',
  `contrasenia` varchar(60) NOT NULL COMMENT 'contraseña del cliente, de tipo varchar.',
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'tereza','xxxx','xxxx','123456789','tere@gmail','12313');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colores` (
  `id_color` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_color`),
  UNIQUE KEY `id_color_UNIQUE` (`id_color`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
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
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL COMMENT 'fecha donde se realizo el pedido, de tipo date.',
  `id_cliente` int(11) NOT NULL COMMENT 'Fk de la tabla clientes , de tipo INT con indice Index.',
  `id_producto` int(11) NOT NULL COMMENT 'Fk de la tabla productos, de tipo INT con indice Index.',
  `cantidad_producto` int(11) NOT NULL,
  `estado_pedido` varchar(45) NOT NULL,
  `id_color` int(11) NOT NULL,
  `id_talla` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_producto` (`id_producto`),
  KEY `id_pedido` (`id_cliente`,`id_producto`) USING BTREE,
  KEY `idx_pedido` (`id_pedido`),
  KEY `fk_id_color` (`id_color`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
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
-- Table structure for table `producto_color`
--

DROP TABLE IF EXISTS `producto_color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_color` (
  `id_producto` int(11) NOT NULL,
  `id_color` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_producto`,`id_color`),
  KEY `id_color` (`id_color`),
  CONSTRAINT `producto_color_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  CONSTRAINT `producto_color_ibfk_2` FOREIGN KEY (`id_color`) REFERENCES `colores` (`id_color`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_color`
--

LOCK TABLES `producto_color` WRITE;
/*!40000 ALTER TABLE `producto_color` DISABLE KEYS */;
INSERT INTO `producto_color` VALUES (1,1,'img/imagen1'),(1,2,'img/imagen2'),(1,3,'img/imagen3'),(1,4,'img/imagen4'),(2,1,'img/imagen5'),(2,2,'img/imagen6'),(2,3,'img/imagen7'),(2,4,'img/imagen8'),(3,1,'img/imagen9'),(3,2,'img/imagen10'),(3,3,'img/imagen11'),(3,4,'img/imagen12'),(4,1,'img/imagen13'),(4,2,'img/imagen14'),(4,3,'img/imagen15'),(4,4,'img/imagen16'),(5,1,'img/imagen17'),(5,2,'img/imagen18'),(5,3,'img/imagen19'),(5,4,'img/imagen20'),(6,1,'img/imagen21'),(6,2,'img/imagen22'),(6,3,'img/imagen23'),(6,4,'img/imagen24'),(7,1,'img/imagen25'),(7,2,'img/imagen26'),(7,3,'img/imagen27'),(7,4,'img/imagen28'),(8,1,'img/imagen29'),(8,2,'img/imagen30'),(8,3,'img/imagen31'),(8,4,'img/imagen32'),(9,1,'img/imagen33'),(9,2,'img/imagen34'),(9,3,'img/imagen35'),(9,4,'img/imagen36');
/*!40000 ALTER TABLE `producto_color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL COMMENT 'PK de la tabla producto , de indice Primary',
  `nombre` varchar(45) NOT NULL COMMENT 'nombre del producto, de tipo Varchar.',
  `precio` double(10,2) NOT NULL COMMENT 'precio del producto, de tipo double para almacenar los valores reales en doble precisión.',
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `codigo_producto_UNIQUE` (`id_producto`),
  UNIQUE KEY `codigo` (`id_producto`),
  UNIQUE KEY `codigo_2` (`id_producto`),
  KEY `idx_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Camiseta Goku',25.00),(2,'Naruto',25.00),(3,'Vegeta',25.00),(4,'Gatos',25.00),(5,'Super Mario',25.00),(6,'Zelda',25.00),(7,'Pokémon',25.00),(8,'Los Simpson',25.00),(9,'Spider-Man',25.00);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tallas`
--

DROP TABLE IF EXISTS `tallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tallas` (
  `id_talla` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  PRIMARY KEY (`id_talla`),
  UNIQUE KEY `id_talla_UNIQUE` (`id_talla`),
  CONSTRAINT `id_producto` FOREIGN KEY (`id_talla`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
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

-- Dump completed on 2024-05-14 21:08:29
