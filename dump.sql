-- MySQL dump 10.13  Distrib 9.2.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: movies_db
-- ------------------------------------------------------
-- Server version	9.2.0

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
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'USA'),(2,'France'),(3,'Japan'),(4,'India'),(5,'Germany');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` VALUES (1,'Action'),(2,'Comedy'),(3,'Drama'),(4,'Thriller'),(5,'Animation'),(6,'Sci-Fi');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movie_genre`
--

DROP TABLE IF EXISTS `movie_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movie_genre` (
  `movie_id` int NOT NULL,
  `genre_id` int NOT NULL,
  PRIMARY KEY (`movie_id`,`genre_id`),
  KEY `genre_id` (`genre_id`),
  CONSTRAINT `movie_genre_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `movie_genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movie_genre`
--

LOCK TABLES `movie_genre` WRITE;
/*!40000 ALTER TABLE `movie_genre` DISABLE KEYS */;
INSERT INTO `movie_genre` VALUES (1,1),(5,1),(6,1),(8,1),(11,1),(12,1),(2,2),(3,3),(7,3),(9,3),(10,3),(1,4),(4,4),(10,4),(6,5),(7,5),(5,6),(8,6),(9,6),(11,6),(12,6);
/*!40000 ALTER TABLE `movie_genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `film_type` enum('movie','cartoon','anime') COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year DEFAULT NULL,
  `film_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES (1,'The Great Chase','A high-speed action movie.','assets/img/board/chase.jpg','movie',2020,'great_chase.mp4',1,'2025-06-30 16:37:08'),(2,'Laugh Out Loud','A hilarious comedy film.','assets/img/board/comedy.jpg','movie',2018,'lol.mp4',1,'2025-06-30 16:37:08'),(3,'Deep Thoughts','A touching drama.','assets/img/board/drama.jpg','movie',2019,'deep_thoughts.mp4',2,'2025-06-30 16:37:08'),(4,'Night Terror','A suspenseful thriller.','assets/img/board/thriller.jpg','movie',2021,'night_terror.mp4',3,'2025-06-30 16:37:08'),(5,'Robot Galaxy','Sci-fi movie in space.','assets/img/board/sci-fi.jpg','movie',2022,'robot_galaxy.mp4',1,'2025-06-30 16:37:08'),(6,'Ninja Kids','Animated ninja adventure.','assets/img/board/ninja.jpg','cartoon',2020,'ninja_kids.mp4',3,'2025-06-30 16:37:08'),(7,'Fairy World','Fantasy cartoon.','assets/img/board/fairy.jpg','cartoon',2017,'fairy_world.mp4',4,'2025-06-30 16:37:08'),(8,'Tokyo Pulse','A modern anime action.','assets/img/board/tokyo.jpg','anime',2021,'tokyo_pulse.mp4',3,'2025-06-30 16:37:08'),(9,'Cyber Mind','A deep anime sci-fi.','assets/img/board/cyber.jpg','anime',2023,'cyber_mind.mp4',3,'2025-06-30 16:37:08'),(10,'Hidden Truth','Mystery and drama combined.','assets/img/board/truth.jpg','movie',2020,'hidden_truth.mp4',5,'2025-06-30 16:37:08'),(11,'Star Wars','Смотри бесплатно без подписки','assets/img/board/starwars.jpg','movie',1977,'starwars.mp4',1,'2025-07-04 16:31:19'),(12,'Avatar','Новый мир ждёт тебя','assets/img/board/shrek.webp','movie',2009,'avatar.mp4',1,'2025-07-04 16:31:19');
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `movie_id` int DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_chk_1` CHECK ((`rating` between 1 and 10))
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,2,1,'Amazing action scenes!',9,'2025-06-30 16:41:21'),(2,3,1,'Loved the stunts.',8,'2025-06-30 16:41:21'),(3,4,2,'Very funny!',7,'2025-06-30 16:41:21'),(4,5,3,'So emotional.',9,'2025-06-30 16:41:21'),(5,2,4,'Kept me on edge.',8,'2025-06-30 16:41:21'),(6,3,5,'Great visuals!',9,'2025-06-30 16:41:21'),(7,4,6,'My kids loved it.',10,'2025-06-30 16:41:21'),(8,5,7,'Nice fantasy world.',7,'2025-06-30 16:41:21'),(9,2,8,'Cool fights!',8,'2025-06-30 16:41:21'),(10,3,9,'Mind-blowing anime!',10,'2025-06-30 16:41:21'),(11,4,10,'Very mysterious.',9,'2025-06-30 16:41:21'),(12,1,2,'привет',10,'2025-07-02 09:22:33'),(13,1,1,'ну такое себе',4,'2025-07-02 10:59:46'),(14,1,11,'Легендарный космический эпос. Картинка топ!',9,'2025-07-04 16:43:06'),(15,1,12,'Красочный и захватывающий. Очень понравилось!',8,'2025-07-04 16:43:06'),(16,1,11,'ghbdtn',10,'2025-07-10 11:22:30');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'wsanta','2@mail.ru','$2y$12$FVZ1RYGTQaEIHqrya./5jesoMGWDRm6.J99zhBpvf0NWsYb4ldP..','/assets/img/avatar/avatar_686001826345f6.89163238.png','2025-06-24 09:41:32'),(2,'ferdinant','ferdinant@mail.ru','$2y$12$z9cdWJD7Olm5faDaPR4pFeGU4Q5Qv1Af0owt8UWFbGuIlnf8PyhD2',NULL,'2025-06-25 15:13:01'),(3,'root','root@example.com','123456','avatar1.png','2025-06-30 16:36:35'),(4,'John Doe','john@example.com','pass123','avatar2.png','2025-06-30 16:36:35'),(5,'Jane Smith','jane@example.com','pass456','avatar3.png','2025-06-30 16:36:35'),(6,'Alice Johnson','alice@example.com','pass789','avatar4.png','2025-06-30 16:36:35'),(7,'Bob Brown','bob@example.com','pass101','avatar5.png','2025-06-30 16:36:35');
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

-- Dump completed on 2025-07-11 13:20:20
