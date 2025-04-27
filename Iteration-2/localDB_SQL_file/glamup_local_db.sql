-- MySQL dump 10.13  Distrib 8.0.41, for macos15 (x86_64)
--
-- Host: 127.0.0.1    Database: Beauty_Saloon
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS users;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE users (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  email varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  phone varchar(50) DEFAULT NULL,
  full_address varchar(255) NOT NULL,
  zip varchar(20) NOT NULL,
  card_number varchar(25) NOT NULL,
  expiry_date varchar(7) NOT NULL,
  cvv varchar(10) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  apply_as_artist tinyint(1) DEFAULT 0,
  artist_bio text DEFAULT NULL,
  resume_path varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY email (email)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES users WRITE;
/*!40000 ALTER TABLE users DISABLE KEYS */;
INSERT INTO users VALUES (1,'pop@gmail.com','$2y$10$ajUUpPBM5MH1Y8m9XIo.Nu3YejbsoS4grRGrMOaiu8KKRibkkXL5K','09876551','LOL','101','12345','01/20','111','2025-04-09 05:32:43',0,NULL,NULL),(3,'asd@gmail.com','$2y$10$h/CgqLOl2yd90kkNZ4LLLe9gO3Ukrvhw4V6vjutUimb2go8LJw2ou','09876','my, address','101','12345','01/25','010','2025-04-09 05:34:05',0,NULL,NULL),(4,'OOOPPPP@gmail.com','$2y$10$ifbzQHejqM7ZNDkf5vU1suLT/7.M/BjOEdKcNedlo6lqbYbhQZFQC','0987','my, op','101','1234','01/02','111','2025-04-09 06:25:32',0,NULL,NULL),(5,'wasd@gmail.com','$2y$10$A7AC0QiOPs/b4Xg57fuUl.quMjP5xls5ZROxFhR/qqBBybGFm32Qm','09876','wasdqe','101','12345','09/81','010','2025-04-13 12:53:43',0,NULL,NULL),(7,'artist@gmail.com','$2y$10$4aQgfh03VWfinh5sRD4eNegO0vE6u62OrzNO1V6bmL0o1qq2F4KFu','092345678','art st., auzie','23456','234567','23/4','2345','2025-04-16 23:06:14',1,'I am artist.',NULL);
/*!40000 ALTER TABLE users ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS bookings;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE bookings (
  booking_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user_id int(10) unsigned NOT NULL,
  email varchar(255) NOT NULL,
  service varchar(50) NOT NULL,
  appointment_datetime datetime NOT NULL,
  phone varchar(50) NOT NULL,
  full_address varchar(255) NOT NULL,
  zip varchar(20) NOT NULL,
  card_number varchar(25) NOT NULL,
  expiry_date varchar(7) NOT NULL,
  cvv varchar(10) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('accepted','finished','cancelled') DEFAULT NULL,
  PRIMARY KEY (booking_id),
  KEY user_id (user_id),
  CONSTRAINT bookings_ibfk_1 FOREIGN KEY (user_id) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES bookings WRITE;
/*!40000 ALTER TABLE bookings DISABLE KEYS */;
INSERT INTO bookings VALUES (2,1,'pop@gmail.com','makeup','2025-04-17 11:25:00','09876551','LOL','101','12345','01/20','111','2025-04-17 01:26:03','accepted');
/*!40000 ALTER TABLE bookings ENABLE KEYS */;
UNLOCK TABLES;

-- Dump completed on 2025-04-27 11:29:33
