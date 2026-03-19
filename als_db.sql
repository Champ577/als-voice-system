-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: voicesystem
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

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
-- Table structure for table `PRODUCTS`
--

DROP TABLE IF EXISTS `PRODUCTS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PRODUCTS` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NAME` varchar(100) DEFAULT NULL,
  `PRICE` int DEFAULT NULL,
  `CREATED_AT` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PRODUCTS`
--

LOCK TABLES `PRODUCTS` WRITE;
/*!40000 ALTER TABLE `PRODUCTS` DISABLE KEYS */;
/*!40000 ALTER TABLE `PRODUCTS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Sachin Kumar','sachin@gmail.com','Delhi','2024-08-15'),(2,'Amit Sharma','amit@gmail.com','Mumbai','2024-10-10'),(3,'Neha Singh','neha@gmail.com','Pune','2025-01-05'),(4,'Rohit Verma','rohit@gmail.com','Bangalore','2025-02-12'),(5,'Priya Mehta','priya@gmail.com','Ahmedabad','2025-03-01');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1200.00,'2025-02-10','Completed'),(2,1,450.00,'2025-03-05','Pending'),(3,2,800.00,'2025-01-15','Completed'),(4,3,1500.00,'2025-03-20','Completed'),(5,4,300.00,'2025-04-01','Cancelled'),(6,5,2000.00,'2025-04-10','Completed');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `salary` bigint DEFAULT NULL,
  `age` tinyint DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'Amit Sharma','amit@test.com','IT','Developer',70000,28,'Delhi','2021-03-01','active'),(2,'Rohit Verma','rohit@test.com','HR','Manager',75000,35,'Noida','2020-06-15','active'),(3,'Neha Singh','neha@test.com','IT','Tester',50000,26,'Pune','2022-01-10','active'),(4,'Pooja Mehta','pooja@test.com','Finance','Accountant',55000,30,'Mumbai','2019-08-20','active'),(5,'Ankit Jain','ankit@test.com','IT','Developer',65000,29,'Delhi','2021-09-05','active'),(6,'Karan Malhotra','karan@test.com','Sales','Executive',45000,27,'Gurgaon','2023-02-01','active'),(7,'Simran Kaur','simran@test.com','HR','Recruiter',48000,25,'Noida','2022-05-12','active'),(8,'Rahul Khanna','rahul@test.com','Finance','Analyst',70000,34,'Mumbai','2018-11-25','inactive');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_voice`
--

DROP TABLE IF EXISTS `tbl_user_voice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_user_voice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `a_filename` varchar(255) DEFAULT NULL,
  `e_filename` varchar(255) DEFAULT NULL,
  `i_filename` varchar(255) DEFAULT NULL,
  `o_filename` varchar(255) DEFAULT NULL,
  `u_filename` varchar(255) DEFAULT NULL,
  `pa_filename` varchar(255) DEFAULT NULL,
  `ta_filename` varchar(255) DEFAULT NULL,
  `ka_filename` varchar(255) DEFAULT NULL,
  `api_response` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_voice`
--

LOCK TABLES `tbl_user_voice` WRITE;
/*!40000 ALTER TABLE `tbl_user_voice` DISABLE KEYS */;
INSERT INTO `tbl_user_voice` VALUES (12,5,'a_filename_5_1767017682.wav','e_filename_5_1767017682.wav','i_filename_5_1767017531.wav','o_filename_5_1767017531.wav','u_filename_5_1767017531.wav','pa_filename_5_1767017531.wav','ta_filename_5_1767017531.wav','ka_filename_5_1767017531.wav','{\"prediction\":\"ALS\",\"confidence\":0.8638861179351807,\"probabilities\":{\"HC\":0.13611388206481934,\"ALS\":0.8638861179351807}}','2025-12-29 13:45:28'),(13,6,'a_filename_6_1767017802.wav','e_filename_6_1767017802.wav',NULL,NULL,NULL,NULL,NULL,NULL,'{\"prediction\":\"ALS\",\"confidence\":0.833458662033081,\"probabilities\":{\"HC\":0.16654133796691895,\"ALS\":0.833458662033081}}','2025-12-29 14:16:42'),(15,37,NULL,'e_filename_37_1767093171.wav',NULL,NULL,NULL,NULL,NULL,NULL,'{\"prediction\":\"ALS\",\"confidence\":0.833458662033081,\"probabilities\":{\"HC\":0.16654133796691895,\"ALS\":0.833458662033081}}','2025-12-30 11:12:51'),(16,2,'a_filename_2_1767179070.wav','e_filename_2_1767179070.wav','i_filename_2_1767179070.wav','o_filename_2_1767179070.wav','u_filename_2_1767179070.wav','pa_filename_2_1767179070.wav','ta_filename_2_1767179070.wav','ka_filename_2_1767179070.wav','{\"prediction\":\"ALS\",\"confidence\":0.833458662033081,\"probabilities\":{\"HC\":0.16654133796691895,\"ALS\":0.833458662033081},\"voice_features\":{\"a\":{\"meanF0\":null,\"stdevF0\":null,\"HNR\":null,\"jitter\":null,\"shimmer\":null},\"e\":{\"meanF0\":null,\"stdevF0\":null,\"HNR\":null,\"jitter\":null,\"shimmer\":null},\"i\":{\"meanF0\":null,\"stdevF0\":null,\"HNR\":null,\"jitter\":null,\"shimmer\":null},\"o\":{\"meanF0\":null,\"stdevF0\":null,\"HNR\":null,\"jitter\":null,\"shimmer\":null},\"u\":{\"meanF0\":null,\"stdevF0\":null,\"HNR\":null,\"jitter\":null,\"shimmer\":null},\"pa\":{\"meanF0\":null,\"stdevF0\":null,\"HNR\":null,\"jitter\":null,\"shimmer\":null},\"ta\":{\"meanF0\":null,\"stdevF0\":null,\"HNR\":null,\"jitter\":null,\"shimmer\":null},\"ka\":{\"meanF0\":null,\"stdevF0\":null,\"HNR\":null,\"jitter\":null,\"shimmer\":null},\"demographics\":{\"age\":2,\"sex_M\":1}}}','2025-12-31 09:29:42');
/*!40000 ALTER TABLE `tbl_user_voice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbluser`
--

DROP TABLE IF EXISTS `tbluser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbluser` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `age` int DEFAULT NULL COMMENT 'User age (1–120)',
  `gender` tinyint(1) DEFAULT NULL COMMENT '1=Male, 0=Female',
  `password` varchar(255) NOT NULL,
  `diseases` varchar(20) NOT NULL,
  `diseases_desc` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=candidate, 1=admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbluser`
--

LOCK TABLES `tbluser` WRITE;
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
INSERT INTO `tbluser` VALUES (1,'Admin','9999999999','admin@gmail.com',NULL,NULL,'$2y$12$GrTwOOqiIaGsqb4y.L/oVu/XLZqbqIscNrsGPq32LvibrulaMw2ny','NA',NULL,'2025-12-29 07:33:22',1),(2,'sachin kumar','8400151175','sk@gmail.com',2,1,'$2y$12$GrTwOOqiIaGsqb4y.L/oVu/XLZqbqIscNrsGPq32LvibrulaMw2ny','no','','2025-12-29 07:36:06',0),(3,'aaa','8187878686','a@gmail.com',NULL,NULL,'$2y$12$1YPSf/qpLhEyKzFOJubvQuZ/u6S2rN9XhWS39uCVI3v0Tip87bbvu','no','','2025-12-29 12:54:27',0),(4,'sachin','0987654321','s@gmail.com',111,1,'$2y$12$SwZoID7cFkAhMZsXHSn1hewSg4BWmtenH8QHNY/qhifsbgWlITeaK','no','','2025-12-29 13:19:56',0),(5,'k','9876543210','k@gmail.com',99,0,'$2y$12$M7WDGNKISVNSYkXcJRsvuOcOm715o1GRps4dC84crX35QEJKhzi/S','yes','testing','2025-12-29 13:20:44',0),(6,'Ankit','9123456789','ankit1@yopmail.com',35,1,'$2y$12$dOr3k2mffx/0xz1vewMnjelg3iHzL1lcTkAQ2bNzWu7F3N/BKldgO','no','','2025-12-29 14:15:57',0),(9,'saass','0987654321','ak@gmail.com',11,1,'$2y$12$nxUkQd7OIt4lZlaHNGTaEu/xRpbkLk8ltUC/6flfGaxwblxFhG4Zi','no','','2025-12-29 14:30:35',0),(10,'saass','0987654321','ak1@gmail.com',11,1,'$2y$12$xLusk9emd.ZSxDvljnd80.2QfLXivdoMwX09XebArSg7rfupjWQbO','no','','2025-12-29 14:31:13',0),(11,'ss','0987654321','jk@gmail.com',12,0,'$2y$12$Ne9Vnv41NcB9JYvWxeDf/uB0xd.XsB0MU12Zev22C3HIktuEaQKsK','no','','2025-12-29 14:31:48',0),(13,'ss','0987654321','jk11@gmail.com',12,0,'$2y$12$1YC7oCM8WWn8NMaLOSn8.u23bQFVRwouT9fPtkKQSuWnbnrXUKfIK','no','','2025-12-29 14:34:42',0),(14,'qqq','0987654321','kk@gmail.com',11,1,'$2y$12$6rQ4eRBTtSDoeyvR5O1/U.SobIinegbLEBfb55aY42zYk/R4G7soe','no','','2025-12-29 14:35:15',0),(15,'qqq','0987654321','kk11@gmail.com',11,1,'$2y$12$IZYmzTYIm1IEWy.RAjqVFeqD6M62c/SCKTYgfnf7rbRrzv2af9EIW','no','','2025-12-29 14:35:25',0),(17,'asdasd','0987654321','gg@gmail.com',22,1,'$2y$12$6FLEl9GO4cviV7cc1b7UmOYdOwAoJ68oQHsTIXEbUt6L2UFx54fB.','no','','2025-12-29 14:36:12',0),(19,'asda','0987654345','hg@gmail.com',12,1,'$2y$12$MSkHHkFcY5pjKiZR3fiarO2Kqqc4hP8o79pEFADTR4LI4cBrJ52Vm','no','','2025-12-29 14:37:54',0),(21,'asdasd','0987654567','ty@gmail.com',22,1,'$2y$12$omYguhlm/Hp1sbIOxkZS1eys1O4bFQwv743GmmD7uQEbVNrN7sL0.','no','','2025-12-29 14:38:59',0),(22,'sss','0987654321','kkkk@gmail.com',11,1,'$2y$12$Fcwjl0.yahlr95/UqgeR.u3QI7DRSrhfV7cHqwHYbgUnuwWwVUVT6','no','','2025-12-30 05:43:08',0),(23,'kkkk','0987654321','k2@gmail.com',23,1,'$2y$12$85myE0f07G2vgK5kaUyFfO//VEVTrOjWbduYYIuqyCWcb/oy.jglG','no','','2025-12-30 05:49:01',0),(24,'jjjj','1234567890','hh@gmail.com',54,1,'$2y$12$mIe5XfFOZT1vXHG1TuiHbuw9V6An/ZHfb3Kw83m13j7h0IQjuJd0.','no','','2025-12-30 05:49:52',0),(25,'pankaj0987654321','0987654321','pankaj@gmail.com',27,1,'$2y$12$kJJ7Sfue3DfmAMnUzn7vNe/.cooXwHnK82GyHhZHWj0VusdUpkTZ.','no','','2025-12-30 05:55:25',0),(26,'testing','9876543212','test@gmail.com',11,1,'$2y$12$8wk9vKlrc0X4izR1UK2MvO5iooGNu8II8vGiInjh8hMlQ4vdEh8qG','no','','2025-12-30 05:56:07',0),(27,'aaa','0987654321','ggg@gmail.com',120,1,'$2y$12$0HUGQcSK3XpmY30k7i.3qOf8XMAE0W931AnLqz2oEK4KDlH95yzAm','no','','2025-12-30 05:58:47',0),(28,'jaksd','0987654321','jhads@gmail.com',55,1,'$2y$12$Qhgv2b/ey02/u.KTVGpdF.geFx.AO62KXSGjuQ09Vqsu2INz.aIXa','no','','2025-12-30 06:05:12',0),(29,'as','0987654321','kkki@gmail.com',33,1,'$2y$12$Bv6lEZHFhyJpRpwkP05vjObMXd/tpRfTsxDFgKdRMUXqOE6/0cpdi','no','','2025-12-30 06:06:02',0),(30,'qwe','0987654321','ff@gmail.com',55,1,'$2y$12$veQ2pHzt2rteYFxw3GYvee8KIsXw8/E3B9X3QPIFiCSfjx0t7cKF6','no','','2025-12-30 06:06:49',0),(31,'kjkasd','0987654321','er@gmail.com',55,1,'$2y$12$ZcuQheXYOdhMDKB977cA8.c8LR5Owv3GeqQYvlVcx5t5R.cGYuFNe','no','','2025-12-30 06:08:41',0),(32,'uuu','0987654321','jj@gmail.com',12,1,'$2y$12$91IV6GkqVwW/trDv1cJolukVlo03P1qdwz7HIe8eskNSK6GrEtut2','no','','2025-12-30 06:40:42',0),(33,'iii','0987654321','ii@gmail.com',23,0,'$2y$12$vvvrKs0bFHm76/XDm8gFoudmwPTGQKsiaGV2lrvxjeLmQ3imVkZQu','yes','testing ii','2025-12-30 06:42:15',0),(34,'dfa','0987654321','rr@gmail.com',22,0,'$2y$12$XY8Vxu3msiD3xdLWTkLNYesFxNfcOr0ZGKtyl7Fl//P7nqtsMTRNu','yes','yyy','2025-12-30 06:42:58',0),(35,'testing','0987654321','test11@gmail.com',22,1,'$2y$12$zDx5ILBcynZSQ7ncgpiRWOoSSPbATE9INsuLXZvYztC.SJQK1GCR6','no','','2025-12-30 09:05:25',0),(36,'asd','1234567890','a2@gmail.com',44,1,'$2y$12$YrAWp57MxGyxDjFMM7mu9eoI9ujjWJFrRy2d5z/Vf5LVOT6dQa4Ya','no','','2025-12-30 11:11:06',0),(37,'a3','1234567890','a3@gmail.com',22,1,'$2y$12$b0PwhoJPE5g/DeQX06XoiuTDkCJuJNDyXQ5.fbAwGgBpoZ2e/vuGG','no','','2025-12-30 11:12:44',0);
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-19 23:32:25
