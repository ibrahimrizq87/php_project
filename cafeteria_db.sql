-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: cafeteria
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.24.04.1

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
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `FK_Items_product_idx` (`product_id`),
  CONSTRAINT `FK_Items_Order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (3,1,1,50),(4,2,1,40),(5,1,1,50),(9,1,1,50),(13,2,1,40),(13,4,4,30),(14,3,5,55),(15,1,1,50),(15,3,1,55),(16,1,5,50),(16,3,3,55),(16,5,2,25),(16,6,3,60),(16,7,2,45),(17,1,2,50),(17,2,2,40),(18,1,1,50),(19,4,1,30),(19,5,1,25),(20,8,1,35),(21,9,5,40),(22,2,1,40),(22,3,1,55),(22,4,1,30),(23,1,2,50),(23,3,2,55),(24,1,1,50),(25,2,1,40),(25,4,1,30),(26,2,1,40),(27,3,1,55),(28,8,1,35),(28,10,3,50),(29,10,1,50),(30,8,1,35),(30,9,1,40),(31,1,1,50),(31,2,1,40),(31,3,1,55),(32,1,1,50);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(45) NOT NULL DEFAULT 'Pending',
  `total_price` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_orders_idx` (`user_id`),
  CONSTRAINT `FK_user_orders` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (3,'2024-08-20 16:40:21','Pending',50,6,''),(4,'2024-08-20 16:40:40','Pending',40,7,''),(5,'2024-08-20 18:39:13','Pending',50,6,''),(9,'2024-08-20 18:56:24','Pending',50,7,''),(13,'2024-08-20 19:02:46','Pending',160,6,''),(14,'2024-08-20 19:02:53','Pending',275,7,''),(15,'2024-08-20 19:06:26','Pending',105,6,''),(16,'2024-08-20 20:17:21','Pending',735,6,''),(17,'2024-08-20 20:51:11','Pending',180,8,''),(18,'2024-08-20 22:13:53','canceled',50,8,''),(19,'2024-08-20 22:14:45','canceled',55,8,''),(20,'2024-08-20 22:15:13','canceled',35,8,''),(21,'2024-08-20 22:15:34','canceled',200,8,''),(22,'2024-08-20 22:21:09','Pending',125,7,''),(23,'2024-08-21 21:26:48','Pending',210,8,''),(24,'2024-08-21 21:30:44','Pending',50,8,''),(25,'2024-08-21 21:31:01','Pending',70,8,''),(26,'2024-08-21 21:32:56','Pending',40,8,''),(27,'2024-08-21 21:32:59','Pending',55,8,''),(28,'2024-08-21 21:33:25','Pending',185,8,''),(29,'2024-08-21 21:34:01','Pending',50,8,''),(30,'2024-08-21 21:34:17','Pending',75,8,''),(31,'2024-08-21 21:40:37','Pending',145,8,''),(32,'2024-08-21 21:41:49','delivered',50,8,'');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `price` int NOT NULL,
  `category` varchar(45) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `availability` enum('available','unavailable') DEFAULT 'available',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Latte',50,'Coffee','../uploads/products/linkedin.png','available'),(2,'Espresso',40,'Coffee','../uploads/products/linkedin.png','unavailable'),(3,'Cappuccino',55,'Coffee','../uploads/products/linkedin.png','available'),(4,'Green Tea',30,'Tea','../uploads/products/linkedin.png','available'),(5,'Black Tea',25,'Tea','../uploads/products/linkedin.png','available'),(6,'Mocha',60,'Coffee','../uploads/products/linkedin.png','available'),(7,'Americano',45,'Coffee','../uploads/products/linkedin.png','available'),(8,'Lemonade',35,'Juice','../uploads/products/linkedin.png','available'),(9,'Orange Juice',40,'Juice','../uploads/products/linkedin.png','available'),(10,'Iced Coffee',50,'Coffee','../uploads/products/linkedin.png','available');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `room_no` int DEFAULT NULL,
  `ext` int DEFAULT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  `is_admin` varchar(5) NOT NULL DEFAULT 'FALSE',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Ibrahim Rizq Abd-Elhaleem','ibrahimxxrizqabd@gmail.com','$2y$10$oA4drUV4cp.CgEKxx5Uo6Oltu4nmYgo7hSKiHslftGbvWUedm2HaK',11,22,'../uploads/users/manual.png','TRUE'),(5,'Ahmed Ali Mohamed','ahmedali@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$YlVtLzM5Q2xiakhIbjQuQw$R/P9o7RLuS44bcXTAiOSCZopcVBw84hjUvC9HGuxxRo',54,1010,'../uploads/users/linkedin.png','TRUE'),(6,'mohamed Ehab ali','mohamedehab@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$WXNBZGlPMGpERWt0SUV5QQ$2GoczfJNwqLv9t0yVnGYFa+TOns848deWj285mJeN/w',44,4040,'../uploads/users/facebook.png','FALSE'),(7,'Ibrahim Rizq Abd-Elhaleem','ibrahimrizqabd@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$RFltZzQ3UDZGWWpxTXliag$EqcwwRCErHqBZYafJbfEmvonP16fWpQfBgDHcctLUV0',11,33,'../uploads/users/66c3a5640b0a1_checks.png','FALSE'),(8,'name name as custumer','customer@testing.com','$2y$10$HNOAsuTQbPfgF5DowiqEfe/2W9iKQOiO3acnstFCDrgHO/FOW8ELq',21,1233,'../uploads/users/order.png','FALSE'),(9,'user as customer','customerrrr2@gmail.com','$2y$10$BghmBvQsFXuIibcD/RG8bud0Q4cV2ZcHl7.PhZyBausoTlpoZo3zG',101,1122,'../uploads/users/order1.png','FALSE');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-22  0:32:33
