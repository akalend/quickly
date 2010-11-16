-- MySQL dump 10.11
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	5.0.67

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city` (
  `city_id` int(11) NOT NULL auto_increment,
  `city_name` varchar(32) default NULL,
  PRIMARY KEY  (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (1,'Россия'),(2,'Беларусь'),(3,'Украина'),(4,'Северо-Запад'),(5,'Центр'),(6,'Санкт-Петербург'),(7,'Москва'),(8,'Мурманск'),(9,'Калининград'),(10,'Киев'),(11,'Тула'),(12,'Омск'),(13,'Республика Карелия'),(14,'Республика Коми'),(15,'Архангельская область'),(16,'Вологодская область'),(17,'Ленинградская область'),(18,'Новгородская область'),(19,'Псковская область'),(20,'Ненецкий автономный округ'),(21,'Анино'),(22,'Бокситогорск'),(23,'Большая Ижора'),(24,'Волосово'),(25,'Волхов'),(26,'Всеволожск'),(27,'Выборг'),(28,'Гатчина'),(29,'Горбунки'),(30,'Гостилицы'),(31,'Владимирская область'),(32,'Владимир'),(33,'Кингисепп'),(34,'Кипень'),(35,'Кириши'),(36,'Кировск'),(37,'Лебяжье'),(38,'Лодейное Поле'),(39,'Ломоносов'),(40,'Ломоносовский'),(41,'Луга'),(42,'Низино'),(43,'Пикалево'),(44,'Подпорожье'),(45,'Приозерск'),(46,'Сланцы'),(47,'Сосновый Бор'),(48,'Набережные Челны'),(49,'Воронежская область'),(50,'Борисоглебск'),(51,'Московская область'),(52,'Реутов'),(53,'Воронеж'),(54,'Югорск'),(55,'Екатеринбург'),(56,'Калужкая обл.'),(57,'Калуга'),(58,'Казахстан'),(59,'Алматы'),(60,'Новосибирск'),(61,'Краснодарский край'),(62,'Сочи'),(63,'Пермь'),(64,'Майкоп');
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `login` varchar(16) default NULL,
  `password` char(32) default NULL,
  `email` varchar(64) default NULL,
  `code` char(8) default NULL,
  `is_active` tinyint(1) default '0',
  `created` int(11) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `loginpsw_idx` (`login`,`password`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(2,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(3,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(4,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(5,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(6,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(7,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(8,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(9,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(10,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(11,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(12,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(13,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(14,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(15,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(16,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(17,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(18,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(19,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(20,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(21,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(22,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(23,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(24,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(25,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(26,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(27,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(28,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(29,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(30,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(31,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(32,'xxx','f45731e3d39a1b2330bbf93e9b3de59e','assa@mail.ru','',1,2009),(33,'sasa','94be83d8226403a621d39e4315da7570','asd@mai.ru','',1,1260742238),(34,'dara','a1d3488c777fb17d2e934529292d8c9a','dara@dara.ru','',1,1260742866),(35,'sasha','48e95c5ac3f304eff145497b18d78707','12@mail.ru','',1,1260910096),(36,'sveta','fb6ed3ae3f9945290c3e0b2894e5c35b','sveta@mail.ru','',1,1261877345);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userProfile`
--

DROP TABLE IF EXISTS `userProfile`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `userProfile` (
  `user_id` int(11) NOT NULL auto_increment,
  `name` varchar(32) default NULL,
  `first_name` varchar(32) default NULL,
  `last_name` varchar(32) default NULL,
  `nick` varchar(32) default NULL,
  `birthdate` datetime default NULL,
  `data` tinytext,
  `reiting` int(11) default NULL,
  `is_avatar` tinyint(4) default '0',
  PRIMARY KEY  (`user_id`),
  KEY `idx_reiting` USING BTREE (`reiting`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `userProfile`
--

LOCK TABLES `userProfile` WRITE;
/*!40000 ALTER TABLE `userProfile` DISABLE KEYS */;
INSERT INTO `userProfile` VALUES (1,'Машка',NULL,NULL,'olga','2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\",\"interes\":\"\\u043b\\u0430\\u0441\\u043a\\u0430\\u0442\\u044c \\u043f\\u0435\\u043d\\u0438\\u0441\"}',662,1),(2,'Виктория',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041a\\u0443\\u0440\\u0441\\u043a\"}',587,1),(3,'Ника',NULL,NULL,NULL,'1971-07-19 00:00:00','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\",\"interes\":\"\\u0443\\u043b\\u044c\\u0442\\u0440\\u0430\\u0444\\u0438\\u043e\\u043b\\u0435\\u0442\"}',949,1),(4,'Вероника',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\"}',983,1),(5,'Василиса',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\"}',67,1),(6,'Марина',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u043d\\u043a\\u0442-\\u041f\\u0435\\u0442\\u0435\\u0440\\u0431\\u0435\\u0440\\u0433\"}',387,1),(7,'Люся',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\",\"interes\":\"\"}',734,1),(8,'Света',NULL,NULL,NULL,'0000-00-00 00:00:00','{\"city\":\"\\u0421\\u0430\\u0440\\u0430\\u0442\\u043e\\u0432\",\"interes\":\"\"}',509,1),(9,'Оксана',NULL,NULL,NULL,'0000-00-00 00:00:00','{\"city\":\"\\u0411\\u043e\\u043b\\u0448\\u0435\\u0432\\u043e\",\"interes\":\"sex \\u043d\\u0430 \\u0431\\u0430\\u043b\\u043a\\u043e\\u043d\\u0435\"}',342,1),(10,'Лапушка',NULL,NULL,NULL,'1985-08-21 00:00:00','{\"city\":\"\\u0421\\u0430\\u0440\\u0430\\u0442\\u043e\\u0432\",\"interes\":\"\\u043e\\u0447 \\u0445\\u043e\\u0447\\u0443\"}',185,1),(11,'Алена',NULL,NULL,NULL,'1992-08-08 00:00:00','{\"city\":\"\\u041a\\u0443\\u0440\\u0441\\u043a\",\"interes\":\"\\u0433\\u0430\\u0434\\u0430\\u043d\\u0438\\u0435 \\u043d\\u0430 \\u0441\\u0443\\u0436\\u0435\\u043d\\u043d\\u043e\\u0433\\u043e\"}',899,1),(12,'Елена',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041d\\u043e\\u0432\\u043e\\u0440\\u043e\\u0441\\u0441\\u0438\\u0439\\u0441\\u043a\"}',940,1),(13,'Иришка',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041d\\u043e\\u0432\\u043e\\u0440\\u043e\\u0441\\u0441\\u0438\\u0439\\u0441\\u043a\"}',4,1),(14,'Женевья',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u043d\\u043a\\u0442-\\u041f\\u0435\\u0442\\u0435\\u0440\\u0431\\u0435\\u0440\\u0433\"}',201,1),(15,'Жасмин',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\"}',992,1),(16,'Сюзанна',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u043d\\u043a\\u0442-\\u041f\\u0435\\u0442\\u0435\\u0440\\u0431\\u0435\\u0440\\u0433\"}',356,1),(17,'Наташа',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\"}',805,1),(18,'Маруся',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041d\\u043e\\u0432\\u043e\\u0440\\u043e\\u0441\\u0441\\u0438\\u0439\\u0441\\u043a\",\"interes\":\"\\u043c\\u043e\\u0440\\u0435 \\u0441\\u0442\\u0438\\u0445\\u0438 \\u0438 \\u0447\\u0430\\u0439\\u043a\\u0438\"}',959,1),(19,'Мария',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u043d\\u043a\\u0442-\\u041f\\u0435\\u0442\\u0435\\u0440\\u0431\\u0435\\u0440\\u0433\"}',377,1),(20,'Маша',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u043d\\u043a\\u0442-\\u041f\\u0435\\u0442\\u0435\\u0440\\u0431\\u0435\\u0440\\u0433\"}',8,1),(21,'Валерия',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u043d\\u043a\\u0442-\\u041f\\u0435\\u0442\\u0435\\u0440\\u0431\\u0435\\u0440\\u0433\"}',911,1),(22,'Сара',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041d\\u043e\\u0432\\u0433\\u043e\\u0440\\u043e\\u0434\"}',530,1),(23,'Сергей',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u043d\\u043a\\u0442-\\u041f\\u0435\\u0442\\u0435\\u0440\\u0431\\u0435\\u0440\\u0433\"}',916,1),(24,'Колян',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\"}',989,1),(25,'Александр',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041d\\u043e\\u0432\\u0433\\u043e\\u0440\\u043e\\u0434\",\"interes\":\"\\u043c\\u0430\\u0448\\u0438\\u043d\\u043a\\u0438 \\u0438 \\u0430\\u043b\\u044c\\u043f\\u0438\\u043d\\u0438\\u0437\\u043c\"}',197,1),(26,'Димка',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u043d\\u043a\\u0442-\\u041f\\u0435\\u0442\\u0435\\u0440\\u0431\\u0435\\u0440\\u0433\"}',21,1),(27,'Захар',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041d\\u043e\\u0432\\u043e\\u0440\\u043e\\u0441\\u0441\\u0438\\u0439\\u0441\\u043a\",\"interes\":\"\"}',511,1),(28,'Кузя',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u0421\\u0430\\u0440\\u0430\\u0442\\u043e\\u0432\",\"interes\":\"\"}',495,1),(29,'Шурик',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\",\"interes\":\"\\u043f\\u0438\\u0432\\u043e\"}',940,1),(30,'Павел',NULL,NULL,NULL,'0000-00-00 00:00:00','{\"city\":\"\\u041d\\u043e\\u0432\\u043e\\u0440\\u043e\\u0441\\u0441\\u0438\\u0439\\u0441\\u043a\",\"interes\":\"\"}',214,1),(31,'Петя',NULL,NULL,NULL,'1976-09-06 00:00:00','{\"city\":\"\\u041d\\u043e\\u0432\\u0433\\u043e\\u0440\\u043e\\u0434\",\"interes\":\"\"}',250,1),(32,'Борис',NULL,NULL,NULL,'2009-12-22 02:13:20','{\"city\":\"\\u041c\\u043e\\u0441\\u043a\\u0432\\u0430\"}',611,1),(33,'Солнце',NULL,NULL,'sasa','1986-07-11 00:00:00','{\"city\":\"\\u041d\\u043e\\u0432\\u043e\\u0441\\u0438\\u0431\",\"interes\":\"\\u043c\\u0430\\u0440\\u043a\\u0438 \\u0438 \\u0437\\u043d\\u0430\\u0447\\u043a\\u0438\"}',NULL,1),(34,NULL,NULL,NULL,'dara','2009-12-22 02:13:54',NULL,NULL,0),(35,'Никочка',NULL,NULL,'sasha','1998-01-27 00:00:00','{\"city\":\"\\u043c\\u043e\\u0441\\u043a\\u0432\\u0430\",\"interes\":\"\\u043a\\u0443\\u043a\\u043b\\u044b\"}',342,1),(36,'Светик',NULL,NULL,'sveta','1973-10-21 00:00:00','{\"city\":\"\\u041b\\u0435\\u043d\\u0438\\u043d\\u0433\\u0440\\u0430\\u0434\",\"interes\":\"\\u0441\\u0435\\u043c\\u044c\\u044f \\u0432\\u044b\\u0448\\u0438\\u0432\\u0430\\u043d\\u0438\\u044f\"}',NULL,1);
/*!40000 ALTER TABLE `userProfile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-12-28  5:35:00
