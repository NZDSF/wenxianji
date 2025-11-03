-- MySQL dump 10.13  Distrib 5.6.51, for Win64 (x86_64)
--
-- Host: localhost    Database: cs_yanxii_com
-- ------------------------------------------------------
-- Server version	5.6.51-log

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
-- Table structure for table `s_admin`
--

DROP TABLE IF EXISTS `s_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_admin` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_admin`
--

LOCK TABLES `s_admin` WRITE;
/*!40000 ALTER TABLE `s_admin` DISABLE KEYS */;
INSERT INTO `s_admin` VALUES (1,'admin','a554823e8a7c45f5dee298881db1a311');
/*!40000 ALTER TABLE `s_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_bangpai_all`
--

DROP TABLE IF EXISTS `s_bangpai_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_bangpai_all` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `bp_name` varchar(30) DEFAULT NULL,
  `s_name` varchar(30) DEFAULT NULL,
  `bp_dj` int(2) DEFAULT '1',
  `times` varchar(30) DEFAULT NULL,
  `bp_ss_dj` int(2) DEFAULT '1',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_bangpai_all`
--

LOCK TABLES `s_bangpai_all` WRITE;
/*!40000 ALTER TABLE `s_bangpai_all` DISABLE KEYS */;
INSERT INTO `s_bangpai_all` VALUES (2,'紫禁之巅','admin',1,NULL,1),(3,'萌新萌新',NULL,1,NULL,1),(4,'哈哈哈哈',NULL,1,NULL,1),(5,'测试帮派','admin2',1,'2019-12-26 17:11:24',1);
/*!40000 ALTER TABLE `s_bangpai_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_bangpai_sq`
--

DROP TABLE IF EXISTS `s_bangpai_sq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_bangpai_sq` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `bp_num` int(2) DEFAULT NULL,
  `times` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_bangpai_sq`
--

LOCK TABLES `s_bangpai_sq` WRITE;
/*!40000 ALTER TABLE `s_bangpai_sq` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_bangpai_sq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_baoshi_all`
--

DROP TABLE IF EXISTS `s_baoshi_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_baoshi_all` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `bs_name` varchar(30) DEFAULT NULL,
  `bs_sx` varchar(4) DEFAULT NULL,
  `bs_zhi` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_baoshi_all`
--

LOCK TABLES `s_baoshi_all` WRITE;
/*!40000 ALTER TABLE `s_baoshi_all` DISABLE KEYS */;
INSERT INTO `s_baoshi_all` VALUES (1,'1级攻击宝石','gj',3),(2,'1级防御宝石','fy',1),(3,'1级仙气宝石','xq',2),(4,'1级生命宝石','hp',10),(5,'1级速度宝石','sd',1),(6,'1级暴击宝石','bj',5),(7,'1级韧性宝石','rx',2),(8,'2级攻击宝石','gj',4),(9,'3级攻击宝石','gj',5);
/*!40000 ALTER TABLE `s_baoshi_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_chenghao_all`
--

DROP TABLE IF EXISTS `s_chenghao_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_chenghao_all` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `ch_name` varchar(30) DEFAULT NULL,
  `ch_fl` varchar(4) DEFAULT NULL,
  `ch_gj` int(2) DEFAULT '0',
  `ch_xq` int(2) DEFAULT '0',
  `ch_fy` int(2) DEFAULT '0',
  `ch_hp` int(2) DEFAULT '0',
  `ch_sd` int(2) DEFAULT '0',
  `ch_bj` int(2) DEFAULT '0',
  `ch_rx` int(2) DEFAULT '0',
  `ch_jf` int(2) DEFAULT '1',
  `ch_note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_chenghao_all`
--

LOCK TABLES `s_chenghao_all` WRITE;
/*!40000 ALTER TABLE `s_chenghao_all` DISABLE KEYS */;
INSERT INTO `s_chenghao_all` VALUES (1,'天南修士','pt',10,0,0,0,0,0,0,1,NULL),(2,'壕气冲天','hd',100,100,0,0,0,0,0,10,NULL);
/*!40000 ALTER TABLE `s_chenghao_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_comm_user`
--

DROP TABLE IF EXISTS `s_comm_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_comm_user` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `comm_user` varchar(30) DEFAULT NULL,
  `comm_pass` varchar(80) DEFAULT NULL,
  `comm_sex` varchar(4) DEFAULT NULL,
  `comm_rgtime` varchar(30) DEFAULT NULL,
  `comm_aqm` varchar(60) DEFAULT NULL,
  `comm_rg_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_comm_user`
--

LOCK TABLES `s_comm_user` WRITE;
/*!40000 ALTER TABLE `s_comm_user` DISABLE KEYS */;
INSERT INTO `s_comm_user` VALUES (2,'admin','ba80367d785f9df273dfb4497718dd68','男','2019-12-01 15:13:32','ba80367d785f9df273dfb4497718dd68','127.0.0.1'),(3,'520','269f2bf6d12aeb97c656e7e73c866ef3','男','2022-06-16 09:14:06','afd9f11793c00967ae4187c4311ef19c','117.171.166.109');
/*!40000 ALTER TABLE `s_comm_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_df_wj_cs`
--

DROP TABLE IF EXISTS `s_df_wj_cs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_df_wj_cs` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `df_num` int(2) DEFAULT NULL,
  `df_cs` int(2) DEFAULT '1',
  `df_stop_time` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_df_wj_cs`
--

LOCK TABLES `s_df_wj_cs` WRITE;
/*!40000 ALTER TABLE `s_df_wj_cs` DISABLE KEYS */;
INSERT INTO `s_df_wj_cs` VALUES (1,'admin',900052,1,'2020-01-21 06:00:00'),(2,'admin',900050,1,'2020-01-21 06:00:00'),(3,'admin',900049,2,'2020-01-19 06:00:00'),(4,'admin2',900005,1,'2020-01-22 06:00:00');
/*!40000 ALTER TABLE `s_df_wj_cs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_duihuan_all`
--

DROP TABLE IF EXISTS `s_duihuan_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_duihuan_all` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `dh_wp` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_duihuan_all`
--

LOCK TABLES `s_duihuan_all` WRITE;
/*!40000 ALTER TABLE `s_duihuan_all` DISABLE KEYS */;
INSERT INTO `s_duihuan_all` VALUES (1,1);
/*!40000 ALTER TABLE `s_duihuan_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_duihuan_all_list`
--

DROP TABLE IF EXISTS `s_duihuan_all_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_duihuan_all_list` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `dh_wp` int(2) DEFAULT NULL,
  `nd_fl` varchar(10) DEFAULT NULL,
  `nd_wp` int(2) DEFAULT NULL,
  `nd_sl` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_duihuan_all_list`
--

LOCK TABLES `s_duihuan_all_list` WRITE;
/*!40000 ALTER TABLE `s_duihuan_all_list` DISABLE KEYS */;
INSERT INTO `s_duihuan_all_list` VALUES (1,1,'wp',2,1),(2,1,'wp',3,1),(3,1,'money',NULL,100),(4,1,'coin',NULL,200);
/*!40000 ALTER TABLE `s_duihuan_all_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_fuben_diaoluo`
--

DROP TABLE IF EXISTS `s_fuben_diaoluo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_fuben_diaoluo` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `fb_jindu` int(2) DEFAULT NULL,
  `fb_jieduan` int(2) DEFAULT NULL,
  `wp_num` int(2) DEFAULT NULL,
  `wp_sl` int(2) DEFAULT NULL,
  `wp_jilv` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_fuben_diaoluo`
--

LOCK TABLES `s_fuben_diaoluo` WRITE;
/*!40000 ALTER TABLE `s_fuben_diaoluo` DISABLE KEYS */;
INSERT INTO `s_fuben_diaoluo` VALUES (1,1,1,1,1,5000),(2,1,1,2,1,5000),(3,1,1,3,1,5000),(4,1,2,1,2,5000),(5,1,2,2,2,5000),(6,1,2,3,3,5000),(7,1,3,1,3,5000),(8,1,3,2,3,5000),(9,1,3,4,3,5000),(10,1,4,1,4,5000),(11,1,4,2,4,5000);
/*!40000 ALTER TABLE `s_fuben_diaoluo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_fuben_info1`
--

DROP TABLE IF EXISTS `s_fuben_info1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_fuben_info1` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `fb_name` varchar(30) DEFAULT NULL,
  `fb_min_dj` int(2) DEFAULT NULL,
  `fb_max_dj` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_fuben_info1`
--

LOCK TABLES `s_fuben_info1` WRITE;
/*!40000 ALTER TABLE `s_fuben_info1` DISABLE KEYS */;
INSERT INTO `s_fuben_info1` VALUES (1,'灵台山',1,10),(2,'无极大陆',10,20),(3,'神隐岛',20,40),(4,'沉光之海',40,60),(5,'雷泽虚空',60,80),(6,'大荒遗迹',80,100);
/*!40000 ALTER TABLE `s_fuben_info1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_fuben_info2`
--

DROP TABLE IF EXISTS `s_fuben_info2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_fuben_info2` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `fb_name` varchar(30) DEFAULT NULL,
  `fb_jindu` int(2) DEFAULT NULL,
  `fb_min_dj` int(2) DEFAULT NULL,
  `fb_max_dj` int(2) DEFAULT NULL,
  `fb_info1_num` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_fuben_info2`
--

LOCK TABLES `s_fuben_info2` WRITE;
/*!40000 ALTER TABLE `s_fuben_info2` DISABLE KEYS */;
INSERT INTO `s_fuben_info2` VALUES (1,'黑水寨',1,1,2,1),(2,'迷雾森林',2,3,4,1),(3,'火云石窟',3,5,6,1),(4,'机关地穴',4,7,8,1),(5,'虚灵殿',5,9,10,1),(6,'青牛村',6,11,12,2),(7,'彩霞山',7,13,14,2),(8,'黄枫谷',8,15,16,2),(9,'血禁试炼',9,17,18,2),(10,'逍遥谷',10,19,20,2),(11,'小镜湖',11,21,24,3),(12,'幻雾迷泽',12,25,28,3),(13,'乱云涧',13,29,32,3),(14,'盘龙峡',14,33,36,3),(15,'万兽山庄',15,37,40,3),(16,'东海渔村',16,41,44,4),(17,'太施海岸',17,45,48,4),(18,'通灵船',18,49,52,4),(19,'极寒水殿',19,53,56,4),(20,'冰蚕宫',20,57,60,4),(21,'虚空入口',21,61,64,5),(22,'雷泽小径',22,65,68,5),(23,'雷火镜',23,69,72,5),(24,'六壬浮山',24,73,76,5),(25,'赤雷岭',25,77,80,5),(26,'兽王井',26,81,84,6),(27,'哭魂冢',27,85,88,6),(28,'咆哮平原',28,89,92,6),(29,'狂沙城墙',29,93,96,6),(30,'亡魂堡',30,97,100,6);
/*!40000 ALTER TABLE `s_fuben_info2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_fuben_info3`
--

DROP TABLE IF EXISTS `s_fuben_info3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_fuben_info3` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `fb_info2_num` int(2) DEFAULT NULL,
  `fb_jindu` int(2) DEFAULT NULL,
  `fb_gw_num` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_fuben_info3`
--

LOCK TABLES `s_fuben_info3` WRITE;
/*!40000 ALTER TABLE `s_fuben_info3` DISABLE KEYS */;
INSERT INTO `s_fuben_info3` VALUES (1,1,1,1),(2,1,1,2),(3,1,2,3),(4,1,2,4),(5,1,3,5),(6,1,3,6),(7,1,3,7),(8,1,4,8),(9,2,1,9),(10,2,1,10),(11,2,2,11),(12,2,2,12),(13,2,3,13),(14,2,3,14),(15,2,3,15),(16,2,4,16),(17,3,1,17),(18,3,1,18),(19,3,2,19),(20,3,2,20),(21,3,3,21),(22,3,3,22),(23,3,3,23),(24,3,4,24),(25,4,1,25),(26,4,1,26),(27,4,2,27),(28,4,2,28),(29,4,3,29),(30,4,3,30),(31,4,3,31),(32,4,4,32),(33,5,1,33),(34,5,1,34),(35,5,2,35),(36,5,2,36),(37,5,3,37),(38,5,3,38),(39,5,3,39),(40,5,4,40),(41,6,1,41),(42,6,1,42),(43,6,2,43),(44,6,2,44),(45,6,3,45),(46,6,3,46),(47,6,3,47),(48,6,4,48),(49,7,1,49),(50,7,1,50),(51,7,2,51),(52,7,2,52),(53,7,3,53),(54,7,3,54),(55,7,3,55),(56,7,4,56),(57,8,1,57),(58,8,1,58),(59,8,2,59),(60,8,2,60),(61,8,3,61),(62,8,3,62),(63,8,3,63),(64,8,4,64),(65,9,1,65),(66,9,1,66),(67,9,2,67),(68,9,2,68),(69,9,3,69),(70,9,3,70),(71,9,3,71),(72,9,4,72),(73,10,1,73),(74,10,1,74),(75,10,2,75),(76,10,2,76),(77,10,3,77),(78,10,3,78),(79,10,3,79),(80,10,4,80),(81,11,1,81),(82,11,1,82),(83,11,2,83),(84,11,2,84),(85,11,3,85),(86,11,3,86),(87,11,3,87),(88,11,4,88),(89,12,1,89),(90,12,1,90),(91,12,2,91),(92,12,2,92),(93,12,3,93),(94,12,3,94),(95,12,3,95),(96,12,4,96),(97,13,1,97),(98,13,1,98),(99,13,2,99),(100,13,2,100),(101,13,3,101),(102,13,3,102),(103,13,3,103),(104,13,4,104),(105,14,1,105),(106,14,1,106),(107,14,2,107),(108,14,2,108),(109,14,3,109),(110,14,3,110),(111,14,3,111),(112,14,4,112),(113,15,1,113),(114,15,1,114),(115,15,2,115),(116,15,2,116),(117,15,3,117),(118,15,3,118),(119,15,3,119),(120,15,4,120),(121,16,1,121),(122,16,1,122),(123,16,2,123),(124,16,2,124),(125,16,3,125),(126,16,3,126),(127,16,3,127),(128,16,4,128),(129,17,1,129),(130,17,1,130),(131,17,2,131),(132,17,2,132),(133,17,3,133),(134,17,3,134),(135,17,3,135),(136,17,4,136),(137,18,1,137),(138,18,1,138),(139,18,2,139),(140,18,2,140),(141,18,3,141),(142,18,3,142),(143,18,3,143),(144,18,4,144),(145,19,1,145),(146,19,1,146),(147,19,2,147),(148,19,2,148),(149,19,3,149),(150,19,3,150),(151,19,3,151),(152,19,4,152),(153,20,1,153),(154,20,1,154),(155,20,2,155),(156,20,2,156),(157,20,3,157),(158,20,3,158),(159,20,3,159),(160,20,4,160),(161,21,1,161),(162,21,1,162),(163,21,2,163),(164,21,2,164),(165,21,3,165),(166,21,3,166),(167,21,3,167),(168,21,4,168),(169,22,1,169),(170,22,1,170),(171,22,2,171),(172,22,2,172),(173,22,3,173),(174,22,3,174),(175,22,3,175),(176,22,4,176),(177,23,1,177),(178,23,1,178),(179,23,2,179),(180,23,2,180),(181,23,3,181),(182,23,3,182),(183,23,3,183),(184,23,4,184),(185,24,1,185),(186,24,1,186),(187,24,2,187),(188,24,2,188),(189,24,3,189),(190,24,3,190),(191,24,3,191),(192,24,4,192),(193,25,1,193),(194,25,1,194),(195,25,2,195),(196,25,2,196),(197,25,3,197),(198,25,3,198),(199,25,3,199),(200,25,4,200),(201,26,1,201),(202,26,1,202),(203,26,2,203),(204,26,2,204),(205,26,3,205),(206,26,3,206),(207,26,3,207),(208,26,4,208),(209,27,1,209),(210,27,1,210),(211,27,2,211),(212,27,2,212),(213,27,3,213),(214,27,3,214),(215,27,3,215),(216,27,4,216),(217,28,1,217),(218,28,1,218),(219,28,2,219),(220,28,2,220),(221,28,3,221),(222,28,3,222),(223,28,3,223),(224,28,4,224),(225,29,1,225),(226,29,1,226),(227,29,2,227),(228,29,2,228),(229,29,3,229),(230,29,3,230),(231,29,3,231),(232,29,4,232),(233,30,1,233),(234,30,1,234),(235,30,2,235),(236,30,2,236),(237,30,3,237),(238,30,3,238),(239,30,3,239),(240,30,4,240);
/*!40000 ALTER TABLE `s_fuben_info3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_gm_user`
--

DROP TABLE IF EXISTS `s_gm_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_gm_user` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `gm_name` varchar(20) DEFAULT NULL,
  `gm_pass` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_gm_user`
--

LOCK TABLES `s_gm_user` WRITE;
/*!40000 ALTER TABLE `s_gm_user` DISABLE KEYS */;
INSERT INTO `s_gm_user` VALUES (1,'admin','a7a72c9ba9a99836fdae9a75dda2d2aa');
/*!40000 ALTER TABLE `s_gm_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_gonggao`
--

DROP TABLE IF EXISTS `s_gonggao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_gonggao` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(20) DEFAULT NULL,
  `s_name1` varchar(20) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  `message1` varchar(100) DEFAULT NULL,
  `xx_leixin` varchar(10) DEFAULT NULL,
  `times` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_gonggao`
--

LOCK TABLES `s_gonggao` WRITE;
/*!40000 ALTER TABLE `s_gonggao` DISABLE KEYS */;
INSERT INTO `s_gonggao` VALUES (1,'admin','','恭喜','冲击境界成功，修炼进阶为筑基','xt','2019-12-13 16:26:39'),(3,'admin','','紫禁之巅','','cjbp','2019-12-22 10:47:14'),(4,'admin2','','测试帮派','','cjbp','2019-12-26 17:11:24'),(5,'admin','战神9','打败了','获得了天武榜第9名','pk_top10','2020-01-08 20:51:32'),(6,'admin','战神1','打败了','获得了天武榜第1名','pk_top10','2020-01-08 20:51:57'),(9,'admin2','admin','喜结良缘，共度余生~','','qhcg','2020-01-12 13:09:03'),(10,'admin','admin2','打败了','获得了天武榜第1名','pk_top10','2020-01-21 09:05:26');
/*!40000 ALTER TABLE `s_gonggao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_guaiwu_all`
--

DROP TABLE IF EXISTS `s_guaiwu_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_guaiwu_all` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `gw_name` varchar(30) DEFAULT NULL,
  `gw_dj` int(2) DEFAULT '1',
  `gw_gj` int(2) DEFAULT '0',
  `gw_xq` int(2) DEFAULT '0',
  `gw_fy` int(2) DEFAULT '0',
  `gw_bj` int(2) DEFAULT '0',
  `gw_rx` int(2) DEFAULT '0',
  `gw_hp` int(2) DEFAULT '0',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_guaiwu_all`
--

LOCK TABLES `s_guaiwu_all` WRITE;
/*!40000 ALTER TABLE `s_guaiwu_all` DISABLE KEYS */;
INSERT INTO `s_guaiwu_all` VALUES (1,'毛贼',1,20,10,7,12,2,145),(2,'打更人',1,20,10,7,12,2,145),(3,'窃贼',1,20,10,7,12,2,145),(4,'弓弩手',1,20,10,7,12,2,145),(5,'刀客',1,20,10,7,12,2,145),(6,'铁锤客',1,20,10,7,12,2,145),(7,'剑师',1,20,10,7,12,2,145),(8,'刘三刀',2,24,12,8,17,7,180),(9,'黑蜘蛛 ',3,28,14,10,22,12,200),(10,'赤红蜈蚣',3,28,14,10,22,12,200),(11,'采药人',3,28,14,10,22,12,200),(12,'棘皮狼',3,28,14,10,22,12,200),(13,'制药人',3,28,14,10,22,12,200),(14,'药尸',3,28,14,10,22,12,200),(15,'金斑虎',3,28,14,10,22,12,200),(16,'合成兽人',4,32,16,11,27,17,235),(17,'焰灵',5,36,18,12,32,22,270),(18,'烈火小鬼',5,36,18,12,32,22,270),(19,'石人',5,36,18,12,32,22,270),(20,'炎人',5,36,18,12,32,22,270),(21,'炎火修行者',5,36,18,12,32,22,270),(22,'火鸦',5,36,18,12,32,22,270),(23,'爆裂火球',5,36,18,12,32,22,270),(24,'火麒麟',6,40,20,14,36,26,290),(25,'木桩人',7,44,22,15,41,31,325),(26,'修理技师',7,44,22,15,41,31,325),(27,'铁皮人 ',7,44,22,15,41,31,325),(28,'冶炼师',7,44,22,15,41,31,325),(29,'机巧蛮牛',7,44,22,15,41,31,325),(30,'机巧猎鹰',7,44,22,15,41,31,325),(31,'疯狂的技师',7,44,22,15,41,31,325),(32,'公输治',8,48,24,16,46,36,360),(33,'空铠甲',9,52,26,18,51,41,380),(34,'乐伶之魂',9,52,26,18,51,41,380),(35,'剑士之魂',9,52,26,18,51,41,380),(36,'剑戟甲士',9,52,26,18,51,41,380),(37,'三尾狐',9,52,26,18,51,41,380),(38,'亡灵歌姬',9,52,26,18,51,41,380),(39,'琵琶乐师',9,52,26,18,51,41,380),(40,'杜施施',10,65,28,22,56,46,415),(41,'炼气门徒',11,70,30,24,60,50,440),(42,'噬血虫',11,70,30,24,60,50,440),(43,'飞翅蜈蚣',11,70,30,24,60,50,440),(44,'炼丹门徒',11,70,30,24,60,50,440),(45,'无极浪人',11,70,30,24,60,50,440),(46,'土财主',11,70,30,24,60,50,440),(47,'醉酒刀客',11,70,30,24,60,50,440),(48,'齐天骄',12,75,32,25,65,55,480),(49,'白臀猴',13,80,34,27,70,60,505),(50,'巨尾山鸡',13,80,34,27,70,60,505),(51,'藤蔓妖灵',13,80,34,27,70,60,505),(52,'血红飞蛇',13,80,34,27,70,60,505),(53,'爬壁刺杀者',13,80,34,27,70,60,505),(54,'剧毒伞菇',13,80,34,27,70,60,505),(55,'食人蚁兽',13,80,34,27,70,60,505),(56,'玄蛇',14,85,36,29,75,65,530),(57,'幽魂狼',15,90,38,30,80,70,570),(58,'碧玉雕像',15,90,38,30,80,70,570),(59,'幽冥巨狼',15,90,38,30,80,70,570),(60,'墨玉雕像',15,90,38,30,80,70,570),(61,'傀儡师',15,90,38,30,80,70,570),(62,'幽火邪灵',15,90,38,30,80,70,570),(63,'通灵师',15,90,38,30,80,70,570),(64,'鬼武者',16,95,40,32,84,74,595),(65,'血煞',17,100,42,34,89,79,620),(66,'魔煞',17,100,42,34,89,79,620),(67,'炼血者',17,100,42,34,89,79,620),(68,'吞灵者',17,100,42,34,89,79,620),(69,'疯狂嗜血魔',17,100,42,34,89,79,620),(70,'跳跃的魔焰',17,100,42,34,89,79,620),(71,'血兽',17,100,42,34,89,79,620),(72,'血女娲',18,105,44,35,94,84,660),(73,'散修道人',19,110,46,37,99,89,685),(74,'采灵女妖',19,110,46,37,99,89,685),(75,'游荡的巨剑',19,110,46,37,99,89,685),(76,'葫芦妖',19,110,46,37,99,89,685),(77,'荷花仙子',19,110,46,37,99,89,685),(78,'提灯道童',19,110,46,37,99,89,685),(79,'雪云豹',19,110,46,37,99,89,685),(80,'玄灵上人',20,134,48,45,104,94,715),(81,'绣女',21,140,50,47,108,98,745),(82,'采莲人',21,140,50,47,108,98,745),(83,'水藤精',22,146,52,49,113,103,775),(84,'鲤鱼精',22,146,52,49,113,103,775),(85,'渡鸦',23,152,54,51,118,108,805),(86,'矮人商贩',23,152,54,51,118,108,805),(87,'玉石收集者',23,152,54,51,118,108,805),(88,'卢玉箫',24,158,56,53,123,113,835),(89,'黑烟',25,164,58,55,128,118,865),(90,'巨壳蜥蜴',25,164,58,55,128,118,865),(91,'萤火蚊',26,170,60,57,132,122,895),(92,'陆生水母',26,170,60,57,132,122,895),(93,'食尸水蛭 ',27,176,62,59,137,127,925),(94,'沼泽巨蜥',27,176,62,59,137,127,925),(95,'爆炸腐液',27,176,62,59,137,127,925),(96,'卢玉堂',28,182,64,61,142,132,955),(97,'玄龟',29,188,66,63,147,137,985),(98,'泪斑石',29,188,66,63,147,137,985),(99,'气灵散修',30,223,68,75,152,142,1015),(100,'气灵守护者',30,223,68,75,152,142,1015),(101,'偷丹人',31,230,70,77,156,146,1050),(102,'制药散修',31,230,70,77,156,146,1050),(103,'硝火灵焰',31,230,70,77,156,146,1050),(104,'红莲真人',32,237,72,79,161,151,1080),(105,'黄鸟',33,244,74,82,166,156,1105),(106,'黑翼人',33,244,74,82,166,156,1105),(107,'黑翼弓手',34,251,76,84,171,161,1140),(108,'黑翼投掷者',34,251,76,84,171,161,1140),(109,'地龙龟',35,258,78,86,176,166,1170),(110,'巨大藤蔓',35,258,78,86,176,166,1170),(111,'黑翼金丹者',35,258,78,86,176,166,1170),(112,'陆阳伯',36,265,80,89,180,170,1195),(113,'游荡猎犬',37,272,82,91,185,175,1230),(114,'山鹰',37,272,82,91,185,175,1230),(115,'万兽猎户',38,279,84,93,190,180,1260),(116,'陷阱放置者',38,279,84,93,190,180,1260),(117,'巨獒',39,286,86,96,195,185,1285),(118,'吊额猛虎',39,286,86,96,195,185,1285),(119,'驯兽修者',39,286,86,96,195,185,1285),(120,'黄一彪 ',40,332,88,111,200,190,1320),(121,'狩猎鱼人',41,340,90,114,204,194,1345),(122,'采砂蚌精',41,340,90,114,204,194,1345),(123,'蛤蟆枪兵',42,348,92,116,209,199,1380),(124,'鱼人修士',42,348,92,116,209,199,1380),(125,'蛤蟆头领',43,356,94,119,214,204,1410),(126,'御水散修',43,356,94,119,214,204,1410),(127,'灵媒真人',43,356,94,119,214,204,1410),(128,'白浪巨灵',44,364,96,122,219,209,1435),(129,'破浪者',45,372,98,124,224,214,1470),(130,'巨化螃蟹',45,372,98,124,224,214,1470),(131,'膨胀水灵',46,380,100,127,228,218,1500),(132,'执戟鱼人',46,380,100,127,228,218,1500),(133,'鱼人长老',47,388,102,130,233,223,1525),(134,'暴虐船夫',47,388,102,130,233,223,1525),(135,'失魂掌舵者',47,388,102,130,233,223,1525),(136,'呼延文滨',48,396,104,132,238,228,1560),(137,'失魂水手',49,404,106,135,243,233,1590),(138,'碧蓝石蚌',49,404,106,135,243,233,1590),(139,'疯狂水手',50,461,108,154,248,238,1620),(140,'疯狂舵手',50,461,108,154,248,238,1620),(141,'失忆剑戟士',51,470,110,157,252,242,1650),(142,'碧火邪灵',51,470,110,157,252,242,1650),(143,'水灵召唤师',51,470,110,157,252,242,1650),(144,'扶飞尘',52,479,112,160,257,247,1680),(145,'极寒道人',53,488,114,163,262,252,1710),(146,'极寒女妖',53,488,114,163,262,252,1710),(147,'游荡的冰魄',54,497,116,166,267,257,1740),(148,'极寒妖女',54,497,116,166,267,257,1740),(149,'极寒仙子',55,506,118,169,272,262,1770),(150,'极寒道童',55,506,118,169,272,262,1770),(151,'剧毒龙鳗 ',55,506,118,169,272,262,1770),(152,'清露道人',56,515,120,172,276,266,1800),(153,'紫火灯',57,524,122,175,281,271,1830),(154,'空灵宝箱',57,524,122,175,281,271,1830),(155,'元宝小妖',58,533,124,178,286,276,1860),(156,'盗宝修士',58,533,124,178,286,276,1860),(157,'飞钱隐士',59,542,126,181,291,281,1890),(158,'无极巡捕',59,542,126,181,291,281,1890),(159,'法器摧毁者',59,542,126,181,291,281,1890),(160,'无极盗圣',60,610,128,204,296,286,1915),(161,'火灵修士',61,620,130,207,300,290,1950),(162,'水灵修士',61,620,130,207,300,290,1950),(163,'土灵炼气者',62,630,132,210,305,295,1980),(164,'木灵炼气者',62,630,132,210,305,295,1980),(165,'黑孔雀',63,640,134,214,310,300,2005),(166,'炼气师',63,640,134,214,310,300,2005),(167,'神秘刺客',63,640,134,214,310,300,2005),(168,'陆无极',64,650,136,217,315,305,2040),(169,'盗剑人',65,660,138,220,320,310,2070),(170,'生锈的环刀',65,660,138,220,320,310,2070),(171,'剑谱收藏者',66,670,140,224,324,314,2095),(172,'破损的剑刃',66,670,140,224,324,314,2095),(173,'暴怒的剑灵',67,680,142,227,329,319,2130),(174,'铸剑师',67,680,142,227,329,319,2130),(175,'剑谱绘制者',67,680,142,227,329,319,2130),(176,'诸葛寒烟',68,690,144,230,334,324,2160),(177,'金灵鸟',69,700,146,234,339,329,2185),(178,'黄晶树人',69,700,146,234,339,329,2185),(179,'暗金蟾',70,779,148,260,344,334,2220),(180,'吹笙乐师',70,779,148,260,344,334,2220),(181,'水灵兽',71,790,150,264,348,338,2245),(182,'御水道士',71,790,150,264,348,338,2245),(183,'莲花修士',71,790,150,264,348,338,2245),(184,'端木雪',72,801,152,267,353,343,2280),(185,'挑水小僧',73,812,154,271,358,348,2310),(186,'扫地门僧',73,812,154,271,358,348,2310),(187,'夜巡僧',74,823,156,275,363,353,2335),(188,'鼓头僧',74,823,156,275,363,353,2335),(189,'香灯僧人',75,834,158,278,368,358,2370),(190,'大光知客',75,834,158,278,368,358,2370),(191,'大光藏主',75,834,158,278,368,358,2370),(192,'金光圣佛',76,845,160,282,372,362,2400),(193,'摆渡浪子',77,856,162,286,377,367,2425),(194,'乐师',77,856,162,286,377,367,2425),(195,'笛音刺杀者',78,867,164,289,382,372,2460),(196,'池沼修士',78,867,164,289,382,372,2460),(197,'笛音召唤者',79,878,166,293,387,377,2490),(198,'水生巨兽',79,878,166,293,387,377,2490),(199,'幽径守卫',79,878,166,293,387,377,2490),(200,'孟雪风',80,968,168,323,392,382,2520),(201,'玄光镜',81,980,170,327,396,386,2550),(202,'失心灵者',81,980,170,327,396,386,2550),(203,'躁动的琵琶',82,992,172,331,401,391,2580),(204,'失心乐师',82,992,172,331,401,391,2580),(205,'失心女伶',83,1004,174,335,406,396,2610),(206,'飞纸鹤',83,1004,174,335,406,396,2610),(207,'失心传送者',83,1004,174,335,406,396,2610),(208,'虚无巨神',84,1016,176,339,411,401,2640),(209,'深渊鬼火',85,1028,178,343,416,406,2670),(210,'冤死的亡魂',85,1028,178,343,416,406,2670),(211,'流火飞剑',86,1040,180,347,420,410,2700),(212,'黑焰环蛇',86,1040,180,347,420,410,2700),(213,'赤毒巨蝎',87,1052,182,351,425,415,2730),(214,'虚空怒灵',87,1052,182,351,425,415,2730),(215,'怨灵召唤者',87,1052,182,351,425,415,2730),(216,'异界巨灵',88,1064,184,355,430,420,2760),(217,'暴虐剑士',89,1076,186,359,435,425,2790),(218,'飘荡亡魂',89,1076,186,359,435,425,2790),(219,'暴虐刺杀者',90,1177,188,393,440,430,2820),(220,'失心剑灵',90,1177,188,393,440,430,2820),(221,'暴虐决斗者',91,1190,190,397,444,434,2850),(222,'不屈的冤魂',91,1190,190,397,444,434,2850),(223,'怨灵控制者',91,1190,190,397,444,434,2850),(224,'罗睺杀星',92,1203,192,401,449,439,2880),(225,'巨鲸帮众',93,1216,194,406,454,444,2910),(226,'马贼',93,1216,194,406,454,444,2910),(227,'泰赤乌巨人',94,1229,196,410,459,449,2940),(228,'蔑里岂士兵',94,1229,196,410,459,449,2940),(229,'蓟皮巨熊',95,1242,198,414,464,454,2970),(230,'钢齿巨熊',95,1242,198,414,464,454,2970),(231,'烈焰土熊',95,1242,198,414,464,454,2970),(232,'大地之熊',96,1255,200,419,468,458,3000),(233,'幽灵',97,1268,202,423,473,463,3030),(234,'嚎哭女鬼',97,1268,202,423,473,463,3030),(235,'霍姆幽魂',98,1281,204,427,478,468,3060),(236,'鬼狼',98,1281,204,427,478,468,3060),(237,'失落的树妖',99,1294,206,432,483,473,3090),(238,'忿怨幽灵',99,1294,206,432,483,473,3090),(239,'失落的土灵',99,1294,206,432,483,473,3090),(240,'极地幽灵',100,1406,208,469,488,478,3120);
/*!40000 ALTER TABLE `s_guaiwu_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_huodong_time`
--

DROP TABLE IF EXISTS `s_huodong_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_huodong_time` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `hd_name` varchar(30) DEFAULT NULL,
  `hd_stop_time` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_huodong_time`
--

LOCK TABLES `s_huodong_time` WRITE;
/*!40000 ALTER TABLE `s_huodong_time` DISABLE KEYS */;
INSERT INTO `s_huodong_time` VALUES (2,'songshouhua','2020-01-27 00:00:01');
/*!40000 ALTER TABLE `s_huodong_time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_jingjie_all`
--

DROP TABLE IF EXISTS `s_jingjie_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_jingjie_all` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `jj_name` varchar(10) DEFAULT NULL,
  `jj_dj` int(2) DEFAULT NULL,
  `jj_gj` int(2) DEFAULT '0',
  `jj_xq` int(2) DEFAULT '0',
  `jj_fy` int(2) DEFAULT '0',
  `jj_hp` int(2) DEFAULT '0',
  `jj_bj` int(2) DEFAULT '0',
  `jj_rx` int(2) DEFAULT '0',
  `jj_sd` int(2) DEFAULT '0',
  `jj_tp_dj` int(2) DEFAULT NULL,
  `jj_tp_money` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_jingjie_all`
--

LOCK TABLES `s_jingjie_all` WRITE;
/*!40000 ALTER TABLE `s_jingjie_all` DISABLE KEYS */;
INSERT INTO `s_jingjie_all` VALUES (1,'炼气',1,20,10,7,145,12,2,0,10,100),(2,'筑基',2,65,28,22,415,56,46,0,20,200),(3,'结丹',3,110,46,37,685,99,89,0,30,300),(4,'元婴',4,223,68,75,1015,152,142,0,40,400),(5,'化神',5,332,88,11,1320,200,190,0,50,500),(6,'炼虚',6,461,108,154,1620,248,238,0,60,600),(7,'合体',7,610,128,204,1915,296,286,0,70,700),(8,'大乘',8,779,148,260,2220,344,334,0,80,800),(9,'真仙',9,968,168,323,2520,392,382,0,NULL,900);
/*!40000 ALTER TABLE `s_jingjie_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_jingjie_cailiao`
--

DROP TABLE IF EXISTS `s_jingjie_cailiao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_jingjie_cailiao` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `jj_dj` int(2) DEFAULT NULL,
  `wp_num` int(2) DEFAULT NULL,
  `wp_counts` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_jingjie_cailiao`
--

LOCK TABLES `s_jingjie_cailiao` WRITE;
/*!40000 ALTER TABLE `s_jingjie_cailiao` DISABLE KEYS */;
INSERT INTO `s_jingjie_cailiao` VALUES (1,1,1,10),(2,1,2,20);
/*!40000 ALTER TABLE `s_jingjie_cailiao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_pk_duihuan`
--

DROP TABLE IF EXISTS `s_pk_duihuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_pk_duihuan` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `wp_id` int(2) DEFAULT NULL,
  `xh_jf` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_pk_duihuan`
--

LOCK TABLES `s_pk_duihuan` WRITE;
/*!40000 ALTER TABLE `s_pk_duihuan` DISABLE KEYS */;
INSERT INTO `s_pk_duihuan` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,100);
/*!40000 ALTER TABLE `s_pk_duihuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_renwu`
--

DROP TABLE IF EXISTS `s_renwu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_renwu` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `rw_jindu` int(2) NOT NULL,
  `rw_biaoti` varchar(20) DEFAULT NULL,
  `rw_mubiao` varchar(150) DEFAULT NULL,
  `rw_skill_gw_num1` int(2) DEFAULT NULL,
  `rw_jiangli_money` int(2) DEFAULT NULL,
  `rw_jiangli_exp` int(2) DEFAULT NULL,
  `rw_jiangli_wp1_id` int(2) DEFAULT NULL,
  `rw_jiangli_wp1_sl` int(2) DEFAULT NULL,
  `rw_jiangli_wp2_id` int(2) DEFAULT NULL,
  `rw_jiangli_wp2_sl` int(2) DEFAULT NULL,
  `rw_jiangli_wp3_id` int(2) DEFAULT NULL,
  `rw_jiangli_wp3_sl` int(2) DEFAULT NULL,
  `rw_jiangli_wp4_id` int(2) DEFAULT NULL,
  `rw_jiangli_wp4_sl` int(2) DEFAULT NULL,
  `rw_jiangli_wp5_id` int(2) DEFAULT NULL,
  `rw_jiangli_wp5_sl` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_renwu`
--

LOCK TABLES `s_renwu` WRITE;
/*!40000 ALTER TABLE `s_renwu` DISABLE KEYS */;
INSERT INTO `s_renwu` VALUES (1,1,'黑水寨','通过副本[黑水寨]',8,1000,1000,1,1,2,1,3,1,4,1,5,1),(2,2,'迷雾森林','通过副本[迷雾森林]',16,2000,2000,1,2,2,2,3,2,4,2,5,2),(3,3,'火云石窟','通过副本[火云石窟]',24,3000,3000,1,3,2,3,3,3,4,3,5,3),(4,4,'机关地穴','通过副本[机关地穴]',32,4000,4000,1,4,2,4,3,4,4,4,5,4),(5,5,'虚灵殿','通过副本[虚灵殿]',40,5000,5000,1,5,2,5,3,5,4,5,5,5);
/*!40000 ALTER TABLE `s_renwu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_skill_all`
--

DROP TABLE IF EXISTS `s_skill_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_skill_all` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `skill_name` varchar(20) DEFAULT NULL,
  `skill_fl` varchar(4) DEFAULT NULL,
  `skill_lx` varchar(10) DEFAULT NULL,
  `skill_zhi` int(2) DEFAULT NULL,
  `skill_cx` int(2) DEFAULT NULL,
  `skill_cd` int(2) DEFAULT NULL,
  `skill_money` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_skill_all`
--

LOCK TABLES `s_skill_all` WRITE;
/*!40000 ALTER TABLE `s_skill_all` DISABLE KEYS */;
INSERT INTO `s_skill_all` VALUES (101,'落英剑法','zd','gj',10,2,3,1000),(102,'三清剑法','zd','sd',10,2,3,1000),(103,'护体剑法','zd','fy',10,2,3,1000),(104,'嗜血术','zd','gj',20,2,5,2000),(105,'会心一击','bd','gj',20,NULL,NULL,1000),(106,'金刚罩','bd','fy',20,NULL,NULL,1000),(107,'回血术','bd','hp',20,NULL,NULL,1000);
/*!40000 ALTER TABLE `s_skill_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_ta_guaiwu`
--

DROP TABLE IF EXISTS `s_ta_guaiwu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_ta_guaiwu` (
  `ta_ceng` int(2) DEFAULT NULL,
  `gw_id` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_ta_guaiwu`
--

LOCK TABLES `s_ta_guaiwu` WRITE;
/*!40000 ALTER TABLE `s_ta_guaiwu` DISABLE KEYS */;
INSERT INTO `s_ta_guaiwu` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),(13,13),(14,14),(15,15),(16,16),(17,17),(18,18),(19,19),(20,20);
/*!40000 ALTER TABLE `s_ta_guaiwu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_ta_jiangli`
--

DROP TABLE IF EXISTS `s_ta_jiangli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_ta_jiangli` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `ta_ceng` int(2) DEFAULT NULL,
  `jl_lx` varchar(4) DEFAULT NULL,
  `jl_id` int(2) DEFAULT NULL,
  `jl_sl` int(2) DEFAULT NULL,
  `jl_jl` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_ta_jiangli`
--

LOCK TABLES `s_ta_jiangli` WRITE;
/*!40000 ALTER TABLE `s_ta_jiangli` DISABLE KEYS */;
INSERT INTO `s_ta_jiangli` VALUES (1,1,'exp',NULL,100,NULL),(2,1,'wp',1,1,5000),(3,1,'wp',2,2,5000),(4,1,'wp',3,3,5000);
/*!40000 ALTER TABLE `s_ta_jiangli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_ta_jiangli_box`
--

DROP TABLE IF EXISTS `s_ta_jiangli_box`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_ta_jiangli_box` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `ta_ceng` int(2) DEFAULT NULL,
  `jl_lx` varchar(4) DEFAULT NULL,
  `jl_id` int(2) DEFAULT NULL,
  `jl_sl` int(2) DEFAULT NULL,
  `jl_jl` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_ta_jiangli_box`
--

LOCK TABLES `s_ta_jiangli_box` WRITE;
/*!40000 ALTER TABLE `s_ta_jiangli_box` DISABLE KEYS */;
INSERT INTO `s_ta_jiangli_box` VALUES (1,1,'wp',1,1,5000),(2,1,'wp',2,2,5000),(3,1,'wp',3,3,5000);
/*!40000 ALTER TABLE `s_ta_jiangli_box` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_ta_wj_jilu`
--

DROP TABLE IF EXISTS `s_ta_wj_jilu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_ta_wj_jilu` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `ceng` int(2) DEFAULT NULL,
  `s_name` varchar(30) DEFAULT NULL,
  `wabao` int(2) DEFAULT '0',
  `xiangzi` int(2) DEFAULT '0',
  `skill` int(2) DEFAULT '0',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_ta_wj_jilu`
--

LOCK TABLES `s_ta_wj_jilu` WRITE;
/*!40000 ALTER TABLE `s_ta_wj_jilu` DISABLE KEYS */;
INSERT INTO `s_ta_wj_jilu` VALUES (11,1,'admin',9,1,1),(19,3,'admin',0,0,1),(18,2,'admin',0,0,1),(20,4,'admin',0,0,0),(21,5,'admin',0,0,0),(22,6,'admin',0,0,0),(23,7,'admin',0,0,0),(24,8,'admin',0,0,0),(25,9,'admin',0,0,0),(26,10,'admin',0,0,0),(27,11,'admin',0,0,0),(28,12,'admin',0,0,0),(29,13,'admin',0,0,0),(30,14,'admin',0,0,0),(31,15,'admin',0,0,0),(32,16,'admin',0,0,0),(33,17,'admin',0,0,0),(34,18,'admin',0,0,0),(35,19,'admin',0,0,0),(36,20,'admin',0,0,0),(37,21,'admin',0,0,0);
/*!40000 ALTER TABLE `s_ta_wj_jilu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_user`
--

DROP TABLE IF EXISTS `s_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_user` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `g_name` varchar(30) DEFAULT NULL,
  `sex` varchar(4) DEFAULT '男',
  `dj` int(2) DEFAULT '1',
  `dj_up_time` varchar(30) DEFAULT NULL,
  `exp` int(2) DEFAULT '0',
  `money` int(2) DEFAULT '0',
  `coin` int(2) DEFAULT '0',
  `sy_hp` int(2) DEFAULT NULL,
  `state` int(2) DEFAULT '0',
  `sy_nl` int(2) DEFAULT '120',
  `z_nl` int(2) DEFAULT '120',
  `nl_hf_time` varchar(30) DEFAULT NULL,
  `fb_jindu` int(2) DEFAULT '1',
  `jingjie` varchar(10) DEFAULT '炼气',
  `tianfu` int(2) DEFAULT '0',
  `tf_wx` int(2) DEFAULT '0',
  `tf_lq` int(2) DEFAULT '0',
  `tf_jg` int(2) DEFAULT '0',
  `tf_xm` int(2) DEFAULT '0',
  `tf_sf` int(2) DEFAULT '0',
  `yqs_cs` int(2) DEFAULT '0',
  `yqs_next_time` varchar(30) DEFAULT NULL,
  `pk_pm` int(2) DEFAULT NULL,
  `pk_max_pm` int(2) DEFAULT NULL,
  `pk_cs` int(2) DEFAULT '0',
  `pk_jf` int(2) DEFAULT '0',
  `pk_zjf` int(2) DEFAULT '0',
  `pk_next_time` varchar(30) DEFAULT NULL,
  `pk_jf_next_time` varchar(30) DEFAULT NULL,
  `pk_gm_cs` int(2) DEFAULT '0',
  `robot` int(2) DEFAULT '0',
  `rw_zx_jd` int(2) DEFAULT '1',
  `rw_zx_skill` int(2) DEFAULT '0',
  `bangpai` varchar(30) DEFAULT NULL,
  `bangpai_zw` int(2) DEFAULT NULL,
  `bangpai_qd` varchar(30) DEFAULT NULL,
  `bangpai_gx` int(2) DEFAULT '0',
  `nld_cs` int(2) DEFAULT '0',
  `nld_next_time` varchar(30) DEFAULT NULL,
  `cz_jf` int(2) DEFAULT '0',
  `xl_hour` int(2) DEFAULT NULL,
  `xl_start_time` varchar(30) DEFAULT NULL,
  `xl_stop_time` varchar(30) DEFAULT NULL,
  `xl_sx_dfsname` varchar(30) DEFAULT NULL,
  `zhizun_vip` int(2) DEFAULT '0',
  `zhizun_vip_lq_jiangli` int(2) DEFAULT '0',
  `yueka_next_time` varchar(30) DEFAULT NULL,
  `yueka_stop_time` varchar(30) DEFAULT NULL,
  `gongxun` int(2) DEFAULT '0',
  `df_sl` int(2) DEFAULT '0',
  `df_sb` int(2) DEFAULT '0',
  `ch_jf` int(2) DEFAULT '0',
  `ch_gj` int(2) DEFAULT '0',
  `ch_xq` int(2) DEFAULT '0',
  `ch_fy` int(2) DEFAULT '0',
  `ch_hp` int(2) DEFAULT '0',
  `ch_sd` int(2) DEFAULT '0',
  `ch_bj` int(2) DEFAULT '0',
  `ch_rx` int(2) DEFAULT '0',
  `chenghao` varchar(30) DEFAULT NULL,
  `mood` varchar(255) DEFAULT NULL,
  `zhanli` int(2) DEFAULT '0',
  `meili` int(2) DEFAULT '0',
  `xianlv` varchar(30) DEFAULT NULL,
  `eaz` int(2) DEFAULT '0',
  `love_time` varchar(30) DEFAULT NULL,
  `jiezhi` varchar(30) DEFAULT NULL,
  `jiezhi_dj` int(2) DEFAULT '1',
  `songhb` int(2) DEFAULT '0',
  `songhb_week` int(2) DEFAULT '0',
  `shouhb` int(2) DEFAULT '0',
  `shouhb_week` int(2) DEFAULT '0',
  `ta_ceng` int(2) DEFAULT '1',
  `ta_max_ceng` int(2) DEFAULT '1',
  `ta_next_time` varchar(30) DEFAULT NULL,
  `enter` int(2) DEFAULT '0',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=900056 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_user`
--

LOCK TABLES `s_user` WRITE;
/*!40000 ALTER TABLE `s_user` DISABLE KEYS */;
INSERT INTO `s_user` VALUES (900005,'admin','宿心','男',13,'2020-01-05 22:26:35',854250,86537,8335,2260,0,130,120,NULL,4,'筑基',176,80,20,10,15,5,0,'2020-01-20 06:00:00',1,1,1,21,25,'2020-01-22 06:00:00',NULL,0,0,2,0,'紫禁之巅',1,'2019-12-24 06:00:00',15,9,'2020-01-14 06:00:00',1,NULL,NULL,NULL,NULL,1,1,'2020-01-06 06:00:00','',520,24,0,11,110,100,0,0,0,0,0,'壕气冲天','哈哈哈',1489,1000,'admin2',1162,'2020-01-12 13:09:03','金戒指',2,40,0,1000,1000,20,21,'2020-01-20 06:00:00',1),(900011,'admin1','玩也不懂','男',1,NULL,0,94999,9999,290,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,NULL,21,0,0,0,NULL,NULL,0,0,1,0,'紫禁之巅',10,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,1),(900048,'战神17','战神17','男',20,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,17,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900047,'战神16','战神16','男',25,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,16,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,1,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900046,'战神15','战神15','男',30,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,15,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900045,'战神14','战神14','男',35,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,14,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900044,'战神13','战神13','男',40,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,13,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900043,'战神12','战神12','男',45,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,12,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900042,'战神11','战神11','男',50,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,19,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900041,'战神10','战神10','男',55,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,11,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900040,'战神9','战神9','男',60,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,10,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900039,'战神8','战神8','男',65,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,8,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900038,'战神7','战神7','男',70,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,7,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900037,'战神6','战神6','男',75,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,6,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900036,'战神5','战神5','男',80,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,5,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900035,'战神4','战神4','男',85,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,4,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900034,'战神3','战神3','男',90,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,3,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900033,'战神2','战神2','男',95,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,2,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900032,'战神1','战神1','男',100,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,9,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900049,'战神18','战神18','男',15,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,18,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,3,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900050,'战神19','战神19','男',10,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,21,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,1,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900051,'战神20','战神20','男',5,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,NULL,NULL,0,0,0,NULL,NULL,0,1,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,0),(900052,'admin2','宿心2','女',10,NULL,0,0,7899,590,0,40,120,'2020-01-21 10:51:59',1,'炼气',0,0,0,0,0,0,0,NULL,2,1,0,0,0,'2020-01-08 06:00:00',NULL,0,0,1,0,'测试帮派',1,NULL,0,0,NULL,0,8,'2020-01-21 10:37:11','2020-01-21 18:37:11','admin',0,0,NULL,NULL,1001,0,19,0,0,0,0,0,0,0,0,NULL,NULL,0,594,'admin',1162,'2020-01-12 13:09:03','金戒指',2,1000,1000,40,0,1,1,NULL,1),(900053,'admin3','admin3','女',1,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,0,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,1),(900054,'admin4','admin4','男',1,NULL,800,0,0,264,0,111,120,NULL,2,'炼气',0,0,0,0,0,0,0,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,1,1,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,0,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,1),(900055,'520','家园博客','男',1,NULL,0,0,0,NULL,0,120,120,NULL,1,'炼气',0,0,0,0,0,0,0,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,1,0,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,0,0,NULL,NULL,0,0,0,0,0,0,0,0,0,0,0,NULL,NULL,0,0,NULL,0,NULL,NULL,1,0,0,0,0,1,1,NULL,1);
/*!40000 ALTER TABLE `s_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_bag`
--

DROP TABLE IF EXISTS `s_wj_bag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_bag` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `wp_name` varchar(30) DEFAULT NULL,
  `wp_counts` int(2) DEFAULT NULL,
  `wp_fenlei` varchar(4) DEFAULT NULL,
  `wp_bd` int(2) DEFAULT '1',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_bag`
--

LOCK TABLES `s_wj_bag` WRITE;
/*!40000 ALTER TABLE `s_wj_bag` DISABLE KEYS */;
INSERT INTO `s_wj_bag` VALUES (17,'admin','五行石',9977,'wp',1),(6,'admin','天绝剑图谱',122,'wp',0),(5,'admin','风雷剑图谱',234,'wp',0),(4,'admin','洗练符',1047,'wp',0),(7,'admin','风雷靴图谱',102,'wp',0),(8,'admin','风雷带图谱',99,'wp',0),(9,'admin','风雷衣图谱',93,'wp',0),(10,'admin','天绝靴图谱',22,'wp',0),(13,'admin','耐力丹',10035,'wp',0),(14,'admin','大耐力丹',9983,'wp',0),(16,'admin','天梯挑战卷',9970,'wp',1),(18,'admin','1级攻击宝石',32,'bs',0),(19,'admin','2级攻击宝石',4,'bs',0),(20,'admin','开孔符',7105,'wp',1),(21,'admin','幸运草',9874,'wp',1),(22,'admin','天绝衣图谱',17,'wp',0),(23,'admin','装备石',117,'wp',0),(24,'admin','月卡',98,'wp',0),(27,'admin','至尊卡',96,'wp',0),(28,'admin','壕气冲天',1,'ch',0),(29,'admin','天南修士',93,'ch',0),(30,'admin','春节大礼包',99927,'lb',0),(31,'admin','帮派令',44,'wp',0),(32,'admin','玫瑰',300,'wp',0),(33,'admin','草戒',4,'hl',0),(37,'admin','一纸休书',1,'hl',0),(38,'admin','天绝带图谱',18,'wp',0),(39,'admin','藏宝图',974,'wp',0),(41,'admin4','洗练符',3,'wp',0);
/*!40000 ALTER TABLE `s_wj_bag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_chenghao`
--

DROP TABLE IF EXISTS `s_wj_chenghao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_chenghao` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `ch_name` varchar(30) DEFAULT NULL,
  `ch_time` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_chenghao`
--

LOCK TABLES `s_wj_chenghao` WRITE;
/*!40000 ALTER TABLE `s_wj_chenghao` DISABLE KEYS */;
INSERT INTO `s_wj_chenghao` VALUES (1,'admin','天南修士','2020-01-06 12:22:16'),(2,'admin','壕气冲天','2020-01-06 12:22:44');
/*!40000 ALTER TABLE `s_wj_chenghao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_dongtai`
--

DROP TABLE IF EXISTS `s_wj_dongtai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_dongtai` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `s_name1` varchar(30) DEFAULT NULL,
  `xx_lx` varchar(10) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `times` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_dongtai`
--

LOCK TABLES `s_wj_dongtai` WRITE;
/*!40000 ALTER TABLE `s_wj_dongtai` DISABLE KEYS */;
INSERT INTO `s_wj_dongtai` VALUES (1,'admin2','admin','dfcg','','2020-01-20 14:12:22'),(2,'admin','admin2','dfsb','','2020-01-21 08:46:42'),(3,'admin2','admin','pkup','在天武榜中将你打败，你跌落到了了2名~','2020-01-21 09:05:26'),(4,'admin','admin2','shuangxiu','','2020-01-21 10:37:11'),(5,'admin','admin2','songhua','向你赠送了1朵玫瑰','2020-01-21 10:59:19'),(6,'admin','admin2','songhua','向你赠送了998朵玫瑰','2020-01-21 11:01:09');
/*!40000 ALTER TABLE `s_wj_dongtai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_friends`
--

DROP TABLE IF EXISTS `s_wj_friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_friends` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `df_num` int(2) DEFAULT NULL,
  `qinmidu` int(2) DEFAULT '0',
  `times` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_friends`
--

LOCK TABLES `s_wj_friends` WRITE;
/*!40000 ALTER TABLE `s_wj_friends` DISABLE KEYS */;
INSERT INTO `s_wj_friends` VALUES (9,'admin2',900005,1264,'2020-01-10 21:09:10'),(10,'admin',900052,1264,'2020-01-10 21:09:10');
/*!40000 ALTER TABLE `s_wj_friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_fuben`
--

DROP TABLE IF EXISTS `s_wj_fuben`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_fuben` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `fb_jindu` int(2) DEFAULT NULL,
  `fb_jieduan` int(2) DEFAULT NULL,
  `fb_zhandou_gw` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_fuben`
--

LOCK TABLES `s_wj_fuben` WRITE;
/*!40000 ALTER TABLE `s_wj_fuben` DISABLE KEYS */;
INSERT INTO `s_wj_fuben` VALUES (38,'admin1',1,1,192),(39,'admin2',1,1,194),(65,'admin',4,3,NULL);
/*!40000 ALTER TABLE `s_wj_fuben` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_guaiwu`
--

DROP TABLE IF EXISTS `s_wj_guaiwu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_guaiwu` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `gw_name` varchar(30) DEFAULT NULL,
  `gw_dj` int(2) DEFAULT NULL,
  `gw_gj` int(2) DEFAULT NULL,
  `gw_xq` int(2) DEFAULT NULL,
  `gw_fy` int(2) DEFAULT NULL,
  `gw_bj` int(2) DEFAULT NULL,
  `gw_rx` int(2) DEFAULT NULL,
  `gw_sy_hp` int(2) DEFAULT NULL,
  `gw_hp` int(255) DEFAULT NULL,
  `gw_lx` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=281 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_guaiwu`
--

LOCK TABLES `s_wj_guaiwu` WRITE;
/*!40000 ALTER TABLE `s_wj_guaiwu` DISABLE KEYS */;
INSERT INTO `s_wj_guaiwu` VALUES (193,'admin1','打更人',1,20,10,7,12,2,9999999,145,2),(192,'admin1','毛贼',1,20,10,7,12,2,145,145,2),(194,'admin2','毛贼',1,20,10,7,12,2,145,145,2),(195,'admin2','打更人',1,20,10,7,12,2,9999999,145,2),(257,'admin','机巧猎鹰',7,44,22,15,41,31,0,325,2),(258,'admin','疯狂的技师',7,44,22,15,41,31,0,325,2),(256,'admin','机巧蛮牛',7,44,22,15,41,31,0,325,2);
/*!40000 ALTER TABLE `s_wj_guaiwu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_paimai`
--

DROP TABLE IF EXISTS `s_wj_paimai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_paimai` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `wp_num` int(2) DEFAULT NULL,
  `wp_counts` int(2) DEFAULT NULL,
  `wp_money` int(2) DEFAULT NULL,
  `wp_zfl` varchar(10) DEFAULT NULL,
  `wp_start_time` varchar(30) DEFAULT NULL,
  `wp_expire_time` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_paimai`
--

LOCK TABLES `s_wj_paimai` WRITE;
/*!40000 ALTER TABLE `s_wj_paimai` DISABLE KEYS */;
INSERT INTO `s_wj_paimai` VALUES (27,'admin',31,1,1,'lb','2020-01-07 11:22:25','2020-01-08 11:22:25');
/*!40000 ALTER TABLE `s_wj_paimai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_pk_wj`
--

DROP TABLE IF EXISTS `s_wj_pk_wj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_pk_wj` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `df_num` int(2) DEFAULT NULL,
  `df_sname` varchar(30) DEFAULT NULL,
  `df_sy_hp` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_pk_wj`
--

LOCK TABLES `s_wj_pk_wj` WRITE;
/*!40000 ALTER TABLE `s_wj_pk_wj` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_wj_pk_wj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_qiandao`
--

DROP TABLE IF EXISTS `s_wj_qiandao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_qiandao` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `qd_month` int(2) DEFAULT NULL,
  `qd_cs_dy` int(2) DEFAULT '0',
  `qd_next_time` varchar(30) DEFAULT NULL,
  `qd_bq_cs` int(2) DEFAULT '0',
  `qd_1` int(2) DEFAULT '0',
  `qd_2` int(2) DEFAULT '0',
  `qd_3` int(2) DEFAULT '0',
  `qd_4` int(2) DEFAULT '0',
  `qd_5` int(2) DEFAULT '0',
  `qd_6` int(2) DEFAULT '0',
  `qd_7` int(2) DEFAULT '0',
  `qd_8` int(2) DEFAULT '0',
  `qd_9` int(2) DEFAULT '0',
  `qd_10` int(2) DEFAULT '0',
  `qd_11` int(2) DEFAULT '0',
  `qd_12` int(2) DEFAULT '0',
  `qd_13` int(2) DEFAULT '0',
  `qd_14` int(2) DEFAULT '0',
  `qd_15` int(2) DEFAULT '0',
  `qd_16` int(2) DEFAULT '0',
  `qd_17` int(2) DEFAULT '0',
  `qd_18` int(2) DEFAULT '0',
  `qd_19` int(2) DEFAULT '0',
  `qd_20` int(2) DEFAULT '0',
  `qd_21` int(2) DEFAULT '0',
  `qd_22` int(2) DEFAULT '0',
  `qd_23` int(2) DEFAULT '0',
  `qd_24` int(2) DEFAULT '0',
  `qd_25` int(2) DEFAULT '0',
  `qd_26` int(2) DEFAULT '0',
  `qd_27` int(2) DEFAULT '0',
  `qd_28` int(2) DEFAULT '0',
  `qd_29` int(2) DEFAULT '0',
  `qd_30` int(2) DEFAULT '0',
  `qd_31` int(2) DEFAULT '0',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_qiandao`
--

LOCK TABLES `s_wj_qiandao` WRITE;
/*!40000 ALTER TABLE `s_wj_qiandao` DISABLE KEYS */;
INSERT INTO `s_wj_qiandao` VALUES (1,'admin',1,9,'2020-01-12 06:00:00',4,1,1,1,1,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `s_wj_qiandao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_qiuhun`
--

DROP TABLE IF EXISTS `s_wj_qiuhun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_qiuhun` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `s_name1` varchar(30) DEFAULT NULL,
  `times` varchar(30) DEFAULT NULL,
  `jiezhi` varchar(30) DEFAULT NULL,
  `state` int(2) DEFAULT '0',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_qiuhun`
--

LOCK TABLES `s_wj_qiuhun` WRITE;
/*!40000 ALTER TABLE `s_wj_qiuhun` DISABLE KEYS */;
INSERT INTO `s_wj_qiuhun` VALUES (3,'战神1','admin2','2020-01-11 17:03:33','钻石戒指',2),(4,'战神2','admin2','2020-01-11 17:05:33','钻石戒指',2);
/*!40000 ALTER TABLE `s_wj_qiuhun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_siliao`
--

DROP TABLE IF EXISTS `s_wj_siliao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_siliao` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `xx_leixin` varchar(10) DEFAULT NULL,
  `s_name1` varchar(30) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  `yd_state` int(2) DEFAULT '0',
  `times` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_siliao`
--

LOCK TABLES `s_wj_siliao` WRITE;
/*!40000 ALTER TABLE `s_wj_siliao` DISABLE KEYS */;
INSERT INTO `s_wj_siliao` VALUES (8,'admin2','hysq','admin','想加你为好友,通过一下哦~',1,'2020-01-07 08:19:30'),(9,'admin','hysq','admin2','想加你为好友,通过一下哦~',1,'2020-01-07 10:35:32');
/*!40000 ALTER TABLE `s_wj_siliao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_skill`
--

DROP TABLE IF EXISTS `s_wj_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_skill` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `skill_num` int(2) DEFAULT NULL,
  `skill_fl` varchar(4) DEFAULT NULL,
  `skill_dj` int(2) DEFAULT '1',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_skill`
--

LOCK TABLES `s_wj_skill` WRITE;
/*!40000 ALTER TABLE `s_wj_skill` DISABLE KEYS */;
INSERT INTO `s_wj_skill` VALUES (2,'admin',101,'zd',6),(10,'admin',104,'zd',1),(5,'admin',102,'zd',3),(6,'admin1',101,'zd',1),(7,'admin1',102,'zd',1),(8,'admin1',103,'zd',1),(9,'admin1',104,'zd',1),(11,'admin',105,'bd',1),(13,'admin',103,'zd',1),(12,'admin',106,'bd',1),(14,'admin',107,'bd',1);
/*!40000 ALTER TABLE `s_wj_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_talk`
--

DROP TABLE IF EXISTS `s_wj_talk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_talk` (
  `num` int(6) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(20) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  `times` varchar(30) DEFAULT NULL,
  `zb_num` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_talk`
--

LOCK TABLES `s_wj_talk` WRITE;
/*!40000 ALTER TABLE `s_wj_talk` DISABLE KEYS */;
INSERT INTO `s_wj_talk` VALUES (1,'admin','123','2019-12-13 16:31:14',NULL),(2,'admin1','12','2019-12-19 09:57:48',NULL),(3,'admin','还好','2019-12-19 10:08:20',NULL),(4,'admin','1','2019-12-26 12:27:11',NULL),(5,'admin','2','2019-12-26 12:27:15',NULL),(6,'admin','3','2019-12-26 12:31:16',NULL),(7,'admin','4','2019-12-26 12:31:18',NULL),(8,'admin','5','2019-12-26 12:31:20',NULL),(9,'admin','6','2019-12-26 12:31:21',NULL),(10,'admin','7','2019-12-26 12:31:22',NULL),(11,'admin','8','2019-12-26 12:31:23',NULL),(12,'admin','9','2019-12-26 12:31:55',NULL),(13,'admin','10','2019-12-28 17:24:27',NULL),(14,'admin','11','2019-12-28 22:18:55',NULL),(15,'admin','123','2020-01-08 21:19:09',NULL),(16,'admin2','1','2020-01-08 21:19:24',NULL);
/*!40000 ALTER TABLE `s_wj_talk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_youxiang`
--

DROP TABLE IF EXISTS `s_wj_youxiang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_youxiang` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `yx_biaoti` varchar(50) DEFAULT NULL,
  `yx_message` varchar(255) DEFAULT NULL,
  `wp_num` int(2) DEFAULT NULL,
  `wp_counts` int(2) DEFAULT NULL,
  `money` int(2) DEFAULT NULL,
  `lq_state` int(2) DEFAULT '0',
  `dq_state` int(2) DEFAULT '0',
  `yx_leixin` varchar(10) DEFAULT NULL,
  `times` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_youxiang`
--

LOCK TABLES `s_wj_youxiang` WRITE;
/*!40000 ALTER TABLE `s_wj_youxiang` DISABLE KEYS */;
INSERT INTO `s_wj_youxiang` VALUES (17,'admin',NULL,NULL,2,50,NULL,0,0,'pmgq','2020-01-02 12:08:45'),(18,'admin',NULL,NULL,2,1,NULL,0,0,'pmgq','2020-01-02 12:08:45'),(19,'admin',NULL,NULL,2,93,NULL,0,0,'pmgq','2020-01-02 12:08:45'),(20,'admin',NULL,NULL,2,500,NULL,0,0,'pmgq','2020-01-02 12:08:45'),(21,'admin',NULL,NULL,16,2,NULL,0,0,'pmgq','2020-01-06 10:55:07'),(22,'admin',NULL,NULL,16,1,NULL,0,0,'pmgq','2020-01-06 10:55:07'),(23,'admin',NULL,NULL,29,1,NULL,0,1,'pmgq','2020-01-07 11:18:26'),(25,'admin','充值榜第1名奖励发放','<div>灵石x100</div><div>仙券x200</div><div>洗练符x1</div><div>装备石x2</div><div>风雷剑图谱x3</div><div>风雷衣图谱x4</div><div>风雷带图谱x5</div>',NULL,NULL,NULL,0,1,'htfswp','2020-01-15 21:11:30');
/*!40000 ALTER TABLE `s_wj_youxiang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_zhandou_skill`
--

DROP TABLE IF EXISTS `s_wj_zhandou_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_zhandou_skill` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `skill_num` int(2) DEFAULT NULL,
  `skill_lx` varchar(5) DEFAULT NULL,
  `skill_zhi` int(2) DEFAULT NULL,
  `skill_cx` int(2) DEFAULT NULL,
  `skill_cd` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_zhandou_skill`
--

LOCK TABLES `s_wj_zhandou_skill` WRITE;
/*!40000 ALTER TABLE `s_wj_zhandou_skill` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_wj_zhandou_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_zhandou_skill_pk`
--

DROP TABLE IF EXISTS `s_wj_zhandou_skill_pk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_zhandou_skill_pk` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `df_num` int(2) DEFAULT NULL,
  `df_sname` varchar(30) DEFAULT NULL,
  `skill_num` int(2) DEFAULT NULL,
  `skill_lx` varchar(5) DEFAULT NULL,
  `skill_zhi` int(2) DEFAULT NULL,
  `skill_cx` int(2) DEFAULT NULL,
  `skill_cd` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_zhandou_skill_pk`
--

LOCK TABLES `s_wj_zhandou_skill_pk` WRITE;
/*!40000 ALTER TABLE `s_wj_zhandou_skill_pk` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_wj_zhandou_skill_pk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_zhuangbei`
--

DROP TABLE IF EXISTS `s_wj_zhuangbei`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_zhuangbei` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `zb_name` varchar(30) DEFAULT NULL,
  `zb_dj` int(2) DEFAULT NULL,
  `zb_col` varchar(30) DEFAULT NULL,
  `zb_pinzhi` varchar(10) DEFAULT '真武',
  `zb_fs_gj` int(2) DEFAULT '0',
  `zb_fs_xq` int(2) DEFAULT '0',
  `zb_fs_fy` int(2) DEFAULT '0',
  `zb_fs_hp` int(2) DEFAULT '0',
  `zb_fs_bj` int(2) DEFAULT '0',
  `zb_fs_rx` int(2) DEFAULT '0',
  `zb_fs_sd` int(2) DEFAULT '0',
  `zb_used` int(2) DEFAULT '0',
  `zb_kw1` int(2) DEFAULT '-1',
  `zb_kw2` int(2) DEFAULT '-1',
  `zb_kw3` int(2) DEFAULT '-1',
  `zb_kw4` int(2) DEFAULT '-1',
  `zb_kw5` int(2) DEFAULT '-1',
  `zb_kw6` int(2) DEFAULT '-1',
  `zb_kw7` int(2) DEFAULT '-1',
  `zb_kw8` int(2) DEFAULT '-1',
  `zb_kw9` int(2) DEFAULT '-1',
  `zb_kw10` int(2) DEFAULT '-1',
  `zb_cl_gj_dj` int(2) DEFAULT '0',
  `zb_cl_fy_dj` int(2) DEFAULT '0',
  `zb_cl_hp_dj` int(2) DEFAULT '0',
  `zb_cl_xq_dj` int(2) DEFAULT '0',
  `zb_cl_sd_dj` int(2) DEFAULT '0',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_zhuangbei`
--

LOCK TABLES `s_wj_zhuangbei` WRITE;
/*!40000 ALTER TABLE `s_wj_zhuangbei` DISABLE KEYS */;
INSERT INTO `s_wj_zhuangbei` VALUES (7,'admin','靴',1,'xuezi','真武',0,0,0,0,0,0,0,1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(6,'admin','衣',1,'yifu','真武',0,0,6,129,4,2,1,1,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(5,'admin','剑',2,'wuqi','天绝',0,0,2,207,8,3,0,1,0,1,1,1,8,0,0,0,0,0,3,3,3,3,3),(8,'admin','带',1,'yaodai','真武',0,0,0,0,0,0,0,1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(26,'admin1','带',1,'yaodai','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(25,'admin1','靴',1,'xuezi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(24,'admin1','衣',1,'yifu','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(23,'admin1','剑',1,'wuqi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(27,'admin2','剑',1,'wuqi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(28,'admin2','衣',1,'yifu','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(29,'admin2','靴',1,'xuezi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(30,'admin2','带',1,'yaodai','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(31,'admin3','剑',1,'wuqi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(32,'admin3','衣',1,'yifu','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(33,'admin3','靴',1,'xuezi','真武',0,0,0,0,0,0,0,1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(34,'admin3','带',1,'yaodai','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(35,'admin3','帽',1,'maozi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(36,'admin3','戒',1,'jiezhi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(37,'admin4','剑',1,'wuqi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(38,'admin4','衣',1,'yifu','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(39,'admin4','靴',1,'xuezi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(40,'admin4','带',1,'yaodai','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(41,'admin4','帽',1,'maozi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(42,'admin4','戒',1,'jiezhi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(43,'520','剑',1,'wuqi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(44,'520','衣',1,'yifu','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(45,'520','靴',1,'xuezi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(46,'520','带',1,'yaodai','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(47,'520','帽',1,'maozi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0),(48,'520','戒',1,'jiezhi','真武',0,0,0,0,0,0,0,0,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,0,0,0,0,0);
/*!40000 ALTER TABLE `s_wj_zhuangbei` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wj_zhuangbei_xilian_tmp`
--

DROP TABLE IF EXISTS `s_wj_zhuangbei_xilian_tmp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wj_zhuangbei_xilian_tmp` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(30) DEFAULT NULL,
  `zb_num` int(2) DEFAULT NULL,
  `zb_gj_tmp` int(2) DEFAULT '0',
  `zb_xq_tmp` int(2) DEFAULT '0',
  `zb_fy_tmp` int(2) DEFAULT '0',
  `zb_hp_tmp` int(2) DEFAULT '0',
  `zb_bj_tmp` int(2) DEFAULT '0',
  `zb_rx_tmp` int(2) DEFAULT '0',
  `zb_sd_tmp` int(2) DEFAULT '0',
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wj_zhuangbei_xilian_tmp`
--

LOCK TABLES `s_wj_zhuangbei_xilian_tmp` WRITE;
/*!40000 ALTER TABLE `s_wj_zhuangbei_xilian_tmp` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_wj_zhuangbei_xilian_tmp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_wupin_all`
--

DROP TABLE IF EXISTS `s_wupin_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_wupin_all` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `wp_name` varchar(30) DEFAULT NULL,
  `wp_canuse` int(2) DEFAULT '0',
  `wp_coin` int(2) DEFAULT NULL,
  `wp_bd` int(2) DEFAULT '0',
  `wp_xfl` varchar(20) DEFAULT NULL,
  `wp_shop_fl` varchar(10) DEFAULT NULL,
  `wp_zfl` varchar(4) DEFAULT NULL,
  `wp_shop` int(2) DEFAULT '0',
  `wp_list` varchar(255) DEFAULT NULL,
  `wp_note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_wupin_all`
--

LOCK TABLES `s_wupin_all` WRITE;
/*!40000 ALTER TABLE `s_wupin_all` DISABLE KEYS */;
INSERT INTO `s_wupin_all` VALUES (1,'洗练符',0,100,0,'daoju','daoju','wp',1,NULL,'用于洗炼装备,增加装备属性'),(2,'装备石',0,200,0,'daoju','daoju','wp',1,NULL,'用于升级装备,增加装备属性'),(3,'风雷剑图谱',0,300,0,'daoju','daoju','wp',1,NULL,'可用于飞升装备'),(4,'风雷衣图谱',0,400,0,'daoju','daoju','wp',1,NULL,'可用于飞升装备'),(5,'风雷带图谱',0,500,0,'daoju','daoju','wp',1,NULL,'可用于飞升装备'),(6,'风雷靴图谱',0,600,0,'daoju','daoju','wp',1,NULL,'可用于飞升装备'),(7,'天绝剑图谱',0,700,0,'daoju','daoju','wp',1,NULL,'可用于飞升装备'),(8,'天绝衣图谱',0,800,0,'daoju','daoju','wp',1,NULL,'可用于飞升装备'),(9,'天绝带图谱',0,900,0,'daoju','daoju','wp',1,NULL,'可用于飞升装备'),(10,'天绝靴图谱',0,1000,0,'daoju','daoju','wp',1,NULL,'可用于飞升装备'),(11,'帮派令',0,1100,0,'daoju','daoju','wp',1,NULL,'可用于创建帮派'),(12,'耐力丹',0,1200,0,'daoju','daoju','wp',1,NULL,'使用后可恢复耐力10点'),(13,'大耐力丹',0,1300,0,'daoju','daoju','wp',1,NULL,'使用后可恢复耐力30点'),(14,'天梯挑战卷',0,1400,0,'daoju','daoju','wp',1,NULL,'可用于增加天梯挑战次数'),(15,'五行石',0,1500,0,'daoju','daoju','wp',1,NULL,'可用于装备淬炼'),(16,'1级攻击宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(17,'1级防御宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(18,'1级仙气宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(19,'1级生命宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(20,'1级速度宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(21,'1级暴击宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(22,'1级韧性宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(23,'2级攻击宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(24,'3级攻击宝石',0,1,0,'baoshi','baoshi','bs',1,NULL,NULL),(25,'开孔符',0,1,0,'daoju','daoju','wp',1,NULL,'可用于装备开孔'),(26,'幸运草',0,1,0,'daoju','daoju','wp',1,NULL,'可用于增加装备打开成功率'),(27,'月卡',0,1,0,'daoju','daoju','wp',1,NULL,'可用于获得30天月卡福利'),(28,'至尊卡',0,1,0,'daoju','daoju','wp',1,NULL,'可用于开通永久至尊VIP'),(29,'天南修士',1,1,0,'chenghao','chenghao','ch',1,NULL,'使用后可获得天南修士称号'),(30,'壕气冲天',1,1,0,'chenghao','chenghao','ch',1,NULL,'使用后可获得壕气冲天称号'),(31,'春节大礼包',1,1,0,'xiangzi','libao','lb',1,'wp,1,2~2,10000|wp,2,1~5,5000|wp,11,1~10,5000|wp,12,1~10,5000|wp,13,1~10,5000','使用后可获得物品<br>洗练符1~10 (随机)<br>装备石1~10 (随机)<br>帮派令1~10 (随机)<br>耐力丹1~10 (随机)<br>大耐力丹1~10 (随机)<br>'),(32,'玫瑰',0,1,0,'daoju','daoju','wp',1,NULL,'赠人玫瑰手留余香，送花所需道具'),(33,'草戒',0,0,0,'hunlian',NULL,'hl',0,NULL,'求婚所需道具'),(34,'金戒指',0,0,0,'hunlian',NULL,'hl',0,NULL,'求婚所需道具'),(35,'钻石戒指',0,0,0,'hunlian',NULL,'hl',0,NULL,'求婚所需道具'),(36,'一纸休书',0,0,0,'hunlian',NULL,'hl',0,NULL,'有缘相聚无缘散 聚散之间莫生怨'),(37,'藏宝图',0,1,0,'daoju','daoju','wp',1,NULL,'可用于闯塔挖宝');
/*!40000 ALTER TABLE `s_wupin_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_zhuangbei_all`
--

DROP TABLE IF EXISTS `s_zhuangbei_all`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_zhuangbei_all` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `zb_name` varchar(30) DEFAULT NULL,
  `zb_dj` int(2) DEFAULT NULL,
  `zb_col` varchar(20) DEFAULT NULL,
  `zb_gj` int(2) DEFAULT NULL,
  `zb_xq` int(2) DEFAULT NULL,
  `zb_fy` int(2) DEFAULT NULL,
  `zb_hp` int(2) DEFAULT NULL,
  `zb_bj` int(2) DEFAULT NULL,
  `zb_rx` int(2) DEFAULT NULL,
  `zb_sd` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=601 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_zhuangbei_all`
--

LOCK TABLES `s_zhuangbei_all` WRITE;
/*!40000 ALTER TABLE `s_zhuangbei_all` DISABLE KEYS */;
INSERT INTO `s_zhuangbei_all` VALUES (1,'剑',1,'wuqi',20,0,0,0,0,0,0),(2,'衣',1,'yifu',0,0,0,145,0,2,0),(3,'靴',1,'xuezi',0,0,0,0,0,0,5),(4,'带',1,'yaodai',0,0,0,0,12,0,0),(5,'帽',1,'maozi',0,0,7,0,0,0,0),(6,'戒',1,'jiezhi',0,10,0,0,0,0,0),(7,'剑',2,'wuqi',24,0,0,0,0,0,0),(8,'衣',2,'yifu',0,0,0,180,0,7,0),(9,'靴',2,'xuezi',0,0,0,0,0,0,6),(10,'带',2,'yaodai',0,0,0,0,17,0,0),(11,'帽',2,'maozi',0,0,8,0,0,0,0),(12,'戒',2,'jiezhi',0,12,0,0,0,0,0),(13,'剑',3,'wuqi',28,0,0,0,0,0,0),(14,'衣',3,'yifu',0,0,0,200,0,12,0),(15,'靴',3,'xuezi',0,0,0,0,0,0,7),(16,'带',3,'yaodai',0,0,0,0,22,0,0),(17,'帽',3,'maozi',0,0,10,0,0,0,0),(18,'戒',3,'jiezhi',0,14,0,0,0,0,0),(19,'剑',4,'wuqi',32,0,0,0,0,0,0),(20,'衣',4,'yifu',0,0,0,235,0,17,0),(21,'靴',4,'xuezi',0,0,0,0,0,0,8),(22,'带',4,'yaodai',0,0,0,0,27,0,0),(23,'帽',4,'maozi',0,0,11,0,0,0,0),(24,'戒',4,'jiezhi',0,16,0,0,0,0,0),(25,'剑',5,'wuqi',36,0,0,0,0,0,0),(26,'衣',5,'yifu',0,0,0,270,0,22,0),(27,'靴',5,'xuezi',0,0,0,0,0,0,9),(28,'带',5,'yaodai',0,0,0,0,32,0,0),(29,'帽',5,'maozi',0,0,12,0,0,0,0),(30,'戒',5,'jiezhi',0,18,0,0,0,0,0),(31,'剑',6,'wuqi',40,0,0,0,0,0,0),(32,'衣',6,'yifu',0,0,0,290,0,26,0),(33,'靴',6,'xuezi',0,0,0,0,0,0,10),(34,'带',6,'yaodai',0,0,0,0,36,0,0),(35,'帽',6,'maozi',0,0,14,0,0,0,0),(36,'戒',6,'jiezhi',0,20,0,0,0,0,0),(37,'剑',7,'wuqi',44,0,0,0,0,0,0),(38,'衣',7,'yifu',0,0,0,325,0,31,0),(39,'靴',7,'xuezi',0,0,0,0,0,0,11),(40,'带',7,'yaodai',0,0,0,0,41,0,0),(41,'帽',7,'maozi',0,0,15,0,0,0,0),(42,'戒',7,'jiezhi',0,22,0,0,0,0,0),(43,'剑',8,'wuqi',48,0,0,0,0,0,0),(44,'衣',8,'yifu',0,0,0,360,0,36,0),(45,'靴',8,'xuezi',0,0,0,0,0,0,12),(46,'带',8,'yaodai',0,0,0,0,46,0,0),(47,'帽',8,'maozi',0,0,16,0,0,0,0),(48,'戒',8,'jiezhi',0,24,0,0,0,0,0),(49,'剑',9,'wuqi',52,0,0,0,0,0,0),(50,'衣',9,'yifu',0,0,0,380,0,41,0),(51,'靴',9,'xuezi',0,0,0,0,0,0,13),(52,'带',9,'yaodai',0,0,0,0,51,0,0),(53,'帽',9,'maozi',0,0,18,0,0,0,0),(54,'戒',9,'jiezhi',0,26,0,0,0,0,0),(55,'剑',10,'wuqi',65,0,0,0,0,0,0),(56,'衣',10,'yifu',0,0,0,415,0,46,0),(57,'靴',10,'xuezi',0,0,0,0,0,0,14),(58,'带',10,'yaodai',0,0,0,0,56,0,0),(59,'帽',10,'maozi',0,0,22,0,0,0,0),(60,'戒',10,'jiezhi',0,28,0,0,0,0,0),(61,'剑',11,'wuqi',70,0,0,0,0,0,0),(62,'衣',11,'yifu',0,0,0,440,0,50,0),(63,'靴',11,'xuezi',0,0,0,0,0,0,15),(64,'带',11,'yaodai',0,0,0,0,60,0,0),(65,'帽',11,'maozi',0,0,24,0,0,0,0),(66,'戒',11,'jiezhi',0,30,0,0,0,0,0),(67,'剑',12,'wuqi',75,0,0,0,0,0,0),(68,'衣',12,'yifu',0,0,0,480,0,55,0),(69,'靴',12,'xuezi',0,0,0,0,0,0,16),(70,'带',12,'yaodai',0,0,0,0,65,0,0),(71,'帽',12,'maozi',0,0,25,0,0,0,0),(72,'戒',12,'jiezhi',0,32,0,0,0,0,0),(73,'剑',13,'wuqi',80,0,0,0,0,0,0),(74,'衣',13,'yifu',0,0,0,505,0,60,0),(75,'靴',13,'xuezi',0,0,0,0,0,0,17),(76,'带',13,'yaodai',0,0,0,0,70,0,0),(77,'帽',13,'maozi',0,0,27,0,0,0,0),(78,'戒',13,'jiezhi',0,34,0,0,0,0,0),(79,'剑',14,'wuqi',85,0,0,0,0,0,0),(80,'衣',14,'yifu',0,0,0,530,0,65,0),(81,'靴',14,'xuezi',0,0,0,0,0,0,18),(82,'带',14,'yaodai',0,0,0,0,75,0,0),(83,'帽',14,'maozi',0,0,29,0,0,0,0),(84,'戒',14,'jiezhi',0,36,0,0,0,0,0),(85,'剑',15,'wuqi',90,0,0,0,0,0,0),(86,'衣',15,'yifu',0,0,0,570,0,70,0),(87,'靴',15,'xuezi',0,0,0,0,0,0,19),(88,'带',15,'yaodai',0,0,0,0,80,0,0),(89,'帽',15,'maozi',0,0,30,0,0,0,0),(90,'戒',15,'jiezhi',0,38,0,0,0,0,0),(91,'剑',16,'wuqi',95,0,0,0,0,0,0),(92,'衣',16,'yifu',0,0,0,595,0,74,0),(93,'靴',16,'xuezi',0,0,0,0,0,0,20),(94,'带',16,'yaodai',0,0,0,0,84,0,0),(95,'帽',16,'maozi',0,0,32,0,0,0,0),(96,'戒',16,'jiezhi',0,40,0,0,0,0,0),(97,'剑',17,'wuqi',100,0,0,0,0,0,0),(98,'衣',17,'yifu',0,0,0,620,0,79,0),(99,'靴',17,'xuezi',0,0,0,0,0,0,21),(100,'带',17,'yaodai',0,0,0,0,89,0,0),(101,'帽',17,'maozi',0,0,34,0,0,0,0),(102,'戒',17,'jiezhi',0,42,0,0,0,0,0),(103,'剑',18,'wuqi',105,0,0,0,0,0,0),(104,'衣',18,'yifu',0,0,0,660,0,84,0),(105,'靴',18,'xuezi',0,0,0,0,0,0,22),(106,'带',18,'yaodai',0,0,0,0,94,0,0),(107,'帽',18,'maozi',0,0,35,0,0,0,0),(108,'戒',18,'jiezhi',0,44,0,0,0,0,0),(109,'剑',19,'wuqi',110,0,0,0,0,0,0),(110,'衣',19,'yifu',0,0,0,685,0,89,0),(111,'靴',19,'xuezi',0,0,0,0,0,0,23),(112,'带',19,'yaodai',0,0,0,0,99,0,0),(113,'帽',19,'maozi',0,0,37,0,0,0,0),(114,'戒',19,'jiezhi',0,46,0,0,0,0,0),(115,'剑',20,'wuqi',134,0,0,0,0,0,0),(116,'衣',20,'yifu',0,0,0,715,0,94,0),(117,'靴',20,'xuezi',0,0,0,0,0,0,24),(118,'带',20,'yaodai',0,0,0,0,104,0,0),(119,'帽',20,'maozi',0,0,45,0,0,0,0),(120,'戒',20,'jiezhi',0,48,0,0,0,0,0),(121,'剑',21,'wuqi',140,0,0,0,0,0,0),(122,'衣',21,'yifu',0,0,0,745,0,98,0),(123,'靴',21,'xuezi',0,0,0,0,0,0,25),(124,'带',21,'yaodai',0,0,0,0,108,0,0),(125,'帽',21,'maozi',0,0,47,0,0,0,0),(126,'戒',21,'jiezhi',0,50,0,0,0,0,0),(127,'剑',22,'wuqi',146,0,0,0,0,0,0),(128,'衣',22,'yifu',0,0,0,775,0,103,0),(129,'靴',22,'xuezi',0,0,0,0,0,0,26),(130,'带',22,'yaodai',0,0,0,0,113,0,0),(131,'帽',22,'maozi',0,0,49,0,0,0,0),(132,'戒',22,'jiezhi',0,52,0,0,0,0,0),(133,'剑',23,'wuqi',152,0,0,0,0,0,0),(134,'衣',23,'yifu',0,0,0,805,0,108,0),(135,'靴',23,'xuezi',0,0,0,0,0,0,27),(136,'带',23,'yaodai',0,0,0,0,118,0,0),(137,'帽',23,'maozi',0,0,51,0,0,0,0),(138,'戒',23,'jiezhi',0,54,0,0,0,0,0),(139,'剑',24,'wuqi',158,0,0,0,0,0,0),(140,'衣',24,'yifu',0,0,0,835,0,113,0),(141,'靴',24,'xuezi',0,0,0,0,0,0,28),(142,'带',24,'yaodai',0,0,0,0,123,0,0),(143,'帽',24,'maozi',0,0,53,0,0,0,0),(144,'戒',24,'jiezhi',0,56,0,0,0,0,0),(145,'剑',25,'wuqi',164,0,0,0,0,0,0),(146,'衣',25,'yifu',0,0,0,865,0,118,0),(147,'靴',25,'xuezi',0,0,0,0,0,0,29),(148,'带',25,'yaodai',0,0,0,0,128,0,0),(149,'帽',25,'maozi',0,0,55,0,0,0,0),(150,'戒',25,'jiezhi',0,58,0,0,0,0,0),(151,'剑',26,'wuqi',170,0,0,0,0,0,0),(152,'衣',26,'yifu',0,0,0,895,0,122,0),(153,'靴',26,'xuezi',0,0,0,0,0,0,30),(154,'带',26,'yaodai',0,0,0,0,132,0,0),(155,'帽',26,'maozi',0,0,57,0,0,0,0),(156,'戒',26,'jiezhi',0,60,0,0,0,0,0),(157,'剑',27,'wuqi',176,0,0,0,0,0,0),(158,'衣',27,'yifu',0,0,0,925,0,127,0),(159,'靴',27,'xuezi',0,0,0,0,0,0,31),(160,'带',27,'yaodai',0,0,0,0,137,0,0),(161,'帽',27,'maozi',0,0,59,0,0,0,0),(162,'戒',27,'jiezhi',0,62,0,0,0,0,0),(163,'剑',28,'wuqi',182,0,0,0,0,0,0),(164,'衣',28,'yifu',0,0,0,955,0,132,0),(165,'靴',28,'xuezi',0,0,0,0,0,0,32),(166,'带',28,'yaodai',0,0,0,0,142,0,0),(167,'帽',28,'maozi',0,0,61,0,0,0,0),(168,'戒',28,'jiezhi',0,64,0,0,0,0,0),(169,'剑',29,'wuqi',188,0,0,0,0,0,0),(170,'衣',29,'yifu',0,0,0,985,0,137,0),(171,'靴',29,'xuezi',0,0,0,0,0,0,33),(172,'带',29,'yaodai',0,0,0,0,147,0,0),(173,'帽',29,'maozi',0,0,63,0,0,0,0),(174,'戒',29,'jiezhi',0,66,0,0,0,0,0),(175,'剑',30,'wuqi',223,0,0,0,0,0,0),(176,'衣',30,'yifu',0,0,0,1015,0,142,0),(177,'靴',30,'xuezi',0,0,0,0,0,0,34),(178,'带',30,'yaodai',0,0,0,0,152,0,0),(179,'帽',30,'maozi',0,0,75,0,0,0,0),(180,'戒',30,'jiezhi',0,68,0,0,0,0,0),(181,'剑',31,'wuqi',230,0,0,0,0,0,0),(182,'衣',31,'yifu',0,0,0,1050,0,146,0),(183,'靴',31,'xuezi',0,0,0,0,0,0,35),(184,'带',31,'yaodai',0,0,0,0,156,0,0),(185,'帽',31,'maozi',0,0,77,0,0,0,0),(186,'戒',31,'jiezhi',0,70,0,0,0,0,0),(187,'剑',32,'wuqi',237,0,0,0,0,0,0),(188,'衣',32,'yifu',0,0,0,1080,0,151,0),(189,'靴',32,'xuezi',0,0,0,0,0,0,36),(190,'带',32,'yaodai',0,0,0,0,161,0,0),(191,'帽',32,'maozi',0,0,79,0,0,0,0),(192,'戒',32,'jiezhi',0,72,0,0,0,0,0),(193,'剑',33,'wuqi',244,0,0,0,0,0,0),(194,'衣',33,'yifu',0,0,0,1105,0,156,0),(195,'靴',33,'xuezi',0,0,0,0,0,0,37),(196,'带',33,'yaodai',0,0,0,0,166,0,0),(197,'帽',33,'maozi',0,0,82,0,0,0,0),(198,'戒',33,'jiezhi',0,74,0,0,0,0,0),(199,'剑',34,'wuqi',251,0,0,0,0,0,0),(200,'衣',34,'yifu',0,0,0,1140,0,161,0),(201,'靴',34,'xuezi',0,0,0,0,0,0,38),(202,'带',34,'yaodai',0,0,0,0,171,0,0),(203,'帽',34,'maozi',0,0,84,0,0,0,0),(204,'戒',34,'jiezhi',0,76,0,0,0,0,0),(205,'剑',35,'wuqi',258,0,0,0,0,0,0),(206,'衣',35,'yifu',0,0,0,1170,0,166,0),(207,'靴',35,'xuezi',0,0,0,0,0,0,39),(208,'带',35,'yaodai',0,0,0,0,176,0,0),(209,'帽',35,'maozi',0,0,86,0,0,0,0),(210,'戒',35,'jiezhi',0,78,0,0,0,0,0),(211,'剑',36,'wuqi',265,0,0,0,0,0,0),(212,'衣',36,'yifu',0,0,0,1195,0,170,0),(213,'靴',36,'xuezi',0,0,0,0,0,0,40),(214,'带',36,'yaodai',0,0,0,0,180,0,0),(215,'帽',36,'maozi',0,0,89,0,0,0,0),(216,'戒',36,'jiezhi',0,80,0,0,0,0,0),(217,'剑',37,'wuqi',272,0,0,0,0,0,0),(218,'衣',37,'yifu',0,0,0,1230,0,175,0),(219,'靴',37,'xuezi',0,0,0,0,0,0,41),(220,'带',37,'yaodai',0,0,0,0,185,0,0),(221,'帽',37,'maozi',0,0,91,0,0,0,0),(222,'戒',37,'jiezhi',0,82,0,0,0,0,0),(223,'剑',38,'wuqi',279,0,0,0,0,0,0),(224,'衣',38,'yifu',0,0,0,1260,0,180,0),(225,'靴',38,'xuezi',0,0,0,0,0,0,42),(226,'带',38,'yaodai',0,0,0,0,190,0,0),(227,'帽',38,'maozi',0,0,93,0,0,0,0),(228,'戒',38,'jiezhi',0,84,0,0,0,0,0),(229,'剑',39,'wuqi',286,0,0,0,0,0,0),(230,'衣',39,'yifu',0,0,0,1285,0,185,0),(231,'靴',39,'xuezi',0,0,0,0,0,0,43),(232,'带',39,'yaodai',0,0,0,0,195,0,0),(233,'帽',39,'maozi',0,0,96,0,0,0,0),(234,'戒',39,'jiezhi',0,86,0,0,0,0,0),(235,'剑',40,'wuqi',332,0,0,0,0,0,0),(236,'衣',40,'yifu',0,0,0,1320,0,190,0),(237,'靴',40,'xuezi',0,0,0,0,0,0,44),(238,'带',40,'yaodai',0,0,0,0,200,0,0),(239,'帽',40,'maozi',0,0,111,0,0,0,0),(240,'戒',40,'jiezhi',0,88,0,0,0,0,0),(241,'剑',41,'wuqi',340,0,0,0,0,0,0),(242,'衣',41,'yifu',0,0,0,1345,0,194,0),(243,'靴',41,'xuezi',0,0,0,0,0,0,45),(244,'带',41,'yaodai',0,0,0,0,204,0,0),(245,'帽',41,'maozi',0,0,114,0,0,0,0),(246,'戒',41,'jiezhi',0,90,0,0,0,0,0),(247,'剑',42,'wuqi',348,0,0,0,0,0,0),(248,'衣',42,'yifu',0,0,0,1380,0,199,0),(249,'靴',42,'xuezi',0,0,0,0,0,0,46),(250,'带',42,'yaodai',0,0,0,0,209,0,0),(251,'帽',42,'maozi',0,0,116,0,0,0,0),(252,'戒',42,'jiezhi',0,92,0,0,0,0,0),(253,'剑',43,'wuqi',356,0,0,0,0,0,0),(254,'衣',43,'yifu',0,0,0,1410,0,204,0),(255,'靴',43,'xuezi',0,0,0,0,0,0,47),(256,'带',43,'yaodai',0,0,0,0,214,0,0),(257,'帽',43,'maozi',0,0,119,0,0,0,0),(258,'戒',43,'jiezhi',0,94,0,0,0,0,0),(259,'剑',44,'wuqi',364,0,0,0,0,0,0),(260,'衣',44,'yifu',0,0,0,1435,0,209,0),(261,'靴',44,'xuezi',0,0,0,0,0,0,48),(262,'带',44,'yaodai',0,0,0,0,219,0,0),(263,'帽',44,'maozi',0,0,122,0,0,0,0),(264,'戒',44,'jiezhi',0,96,0,0,0,0,0),(265,'剑',45,'wuqi',372,0,0,0,0,0,0),(266,'衣',45,'yifu',0,0,0,1470,0,214,0),(267,'靴',45,'xuezi',0,0,0,0,0,0,49),(268,'带',45,'yaodai',0,0,0,0,224,0,0),(269,'帽',45,'maozi',0,0,124,0,0,0,0),(270,'戒',45,'jiezhi',0,98,0,0,0,0,0),(271,'剑',46,'wuqi',380,0,0,0,0,0,0),(272,'衣',46,'yifu',0,0,0,1500,0,218,0),(273,'靴',46,'xuezi',0,0,0,0,0,0,50),(274,'带',46,'yaodai',0,0,0,0,228,0,0),(275,'帽',46,'maozi',0,0,127,0,0,0,0),(276,'戒',46,'jiezhi',0,100,0,0,0,0,0),(277,'剑',47,'wuqi',388,0,0,0,0,0,0),(278,'衣',47,'yifu',0,0,0,1525,0,223,0),(279,'靴',47,'xuezi',0,0,0,0,0,0,51),(280,'带',47,'yaodai',0,0,0,0,233,0,0),(281,'帽',47,'maozi',0,0,130,0,0,0,0),(282,'戒',47,'jiezhi',0,102,0,0,0,0,0),(283,'剑',48,'wuqi',396,0,0,0,0,0,0),(284,'衣',48,'yifu',0,0,0,1560,0,228,0),(285,'靴',48,'xuezi',0,0,0,0,0,0,52),(286,'带',48,'yaodai',0,0,0,0,238,0,0),(287,'帽',48,'maozi',0,0,132,0,0,0,0),(288,'戒',48,'jiezhi',0,104,0,0,0,0,0),(289,'剑',49,'wuqi',404,0,0,0,0,0,0),(290,'衣',49,'yifu',0,0,0,1590,0,233,0),(291,'靴',49,'xuezi',0,0,0,0,0,0,53),(292,'带',49,'yaodai',0,0,0,0,243,0,0),(293,'帽',49,'maozi',0,0,135,0,0,0,0),(294,'戒',49,'jiezhi',0,106,0,0,0,0,0),(295,'剑',50,'wuqi',461,0,0,0,0,0,0),(296,'衣',50,'yifu',0,0,0,1620,0,238,0),(297,'靴',50,'xuezi',0,0,0,0,0,0,54),(298,'带',50,'yaodai',0,0,0,0,248,0,0),(299,'帽',50,'maozi',0,0,154,0,0,0,0),(300,'戒',50,'jiezhi',0,108,0,0,0,0,0),(301,'剑',51,'wuqi',470,0,0,0,0,0,0),(302,'衣',51,'yifu',0,0,0,1650,0,242,0),(303,'靴',51,'xuezi',0,0,0,0,0,0,55),(304,'带',51,'yaodai',0,0,0,0,252,0,0),(305,'帽',51,'maozi',0,0,157,0,0,0,0),(306,'戒',51,'jiezhi',0,110,0,0,0,0,0),(307,'剑',52,'wuqi',479,0,0,0,0,0,0),(308,'衣',52,'yifu',0,0,0,1680,0,247,0),(309,'靴',52,'xuezi',0,0,0,0,0,0,56),(310,'带',52,'yaodai',0,0,0,0,257,0,0),(311,'帽',52,'maozi',0,0,160,0,0,0,0),(312,'戒',52,'jiezhi',0,112,0,0,0,0,0),(313,'剑',53,'wuqi',488,0,0,0,0,0,0),(314,'衣',53,'yifu',0,0,0,1710,0,252,0),(315,'靴',53,'xuezi',0,0,0,0,0,0,57),(316,'带',53,'yaodai',0,0,0,0,262,0,0),(317,'帽',53,'maozi',0,0,163,0,0,0,0),(318,'戒',53,'jiezhi',0,114,0,0,0,0,0),(319,'剑',54,'wuqi',497,0,0,0,0,0,0),(320,'衣',54,'yifu',0,0,0,1740,0,257,0),(321,'靴',54,'xuezi',0,0,0,0,0,0,58),(322,'带',54,'yaodai',0,0,0,0,267,0,0),(323,'帽',54,'maozi',0,0,166,0,0,0,0),(324,'戒',54,'jiezhi',0,116,0,0,0,0,0),(325,'剑',55,'wuqi',506,0,0,0,0,0,0),(326,'衣',55,'yifu',0,0,0,1770,0,262,0),(327,'靴',55,'xuezi',0,0,0,0,0,0,59),(328,'带',55,'yaodai',0,0,0,0,272,0,0),(329,'帽',55,'maozi',0,0,169,0,0,0,0),(330,'戒',55,'jiezhi',0,118,0,0,0,0,0),(331,'剑',56,'wuqi',515,0,0,0,0,0,0),(332,'衣',56,'yifu',0,0,0,1800,0,266,0),(333,'靴',56,'xuezi',0,0,0,0,0,0,60),(334,'带',56,'yaodai',0,0,0,0,276,0,0),(335,'帽',56,'maozi',0,0,172,0,0,0,0),(336,'戒',56,'jiezhi',0,120,0,0,0,0,0),(337,'剑',57,'wuqi',524,0,0,0,0,0,0),(338,'衣',57,'yifu',0,0,0,1830,0,271,0),(339,'靴',57,'xuezi',0,0,0,0,0,0,61),(340,'带',57,'yaodai',0,0,0,0,281,0,0),(341,'帽',57,'maozi',0,0,175,0,0,0,0),(342,'戒',57,'jiezhi',0,122,0,0,0,0,0),(343,'剑',58,'wuqi',533,0,0,0,0,0,0),(344,'衣',58,'yifu',0,0,0,1860,0,276,0),(345,'靴',58,'xuezi',0,0,0,0,0,0,62),(346,'带',58,'yaodai',0,0,0,0,286,0,0),(347,'帽',58,'maozi',0,0,178,0,0,0,0),(348,'戒',58,'jiezhi',0,124,0,0,0,0,0),(349,'剑',59,'wuqi',542,0,0,0,0,0,0),(350,'衣',59,'yifu',0,0,0,1890,0,281,0),(351,'靴',59,'xuezi',0,0,0,0,0,0,63),(352,'带',59,'yaodai',0,0,0,0,291,0,0),(353,'帽',59,'maozi',0,0,181,0,0,0,0),(354,'戒',59,'jiezhi',0,126,0,0,0,0,0),(355,'剑',60,'wuqi',610,0,0,0,0,0,0),(356,'衣',60,'yifu',0,0,0,1915,0,286,0),(357,'靴',60,'xuezi',0,0,0,0,0,0,64),(358,'带',60,'yaodai',0,0,0,0,296,0,0),(359,'帽',60,'maozi',0,0,204,0,0,0,0),(360,'戒',60,'jiezhi',0,128,0,0,0,0,0),(361,'剑',61,'wuqi',620,0,0,0,0,0,0),(362,'衣',61,'yifu',0,0,0,1950,0,290,0),(363,'靴',61,'xuezi',0,0,0,0,0,0,65),(364,'带',61,'yaodai',0,0,0,0,300,0,0),(365,'帽',61,'maozi',0,0,207,0,0,0,0),(366,'戒',61,'jiezhi',0,130,0,0,0,0,0),(367,'剑',62,'wuqi',630,0,0,0,0,0,0),(368,'衣',62,'yifu',0,0,0,1980,0,295,0),(369,'靴',62,'xuezi',0,0,0,0,0,0,66),(370,'带',62,'yaodai',0,0,0,0,305,0,0),(371,'帽',62,'maozi',0,0,210,0,0,0,0),(372,'戒',62,'jiezhi',0,132,0,0,0,0,0),(373,'剑',63,'wuqi',640,0,0,0,0,0,0),(374,'衣',63,'yifu',0,0,0,2005,0,300,0),(375,'靴',63,'xuezi',0,0,0,0,0,0,67),(376,'带',63,'yaodai',0,0,0,0,310,0,0),(377,'帽',63,'maozi',0,0,214,0,0,0,0),(378,'戒',63,'jiezhi',0,134,0,0,0,0,0),(379,'剑',64,'wuqi',650,0,0,0,0,0,0),(380,'衣',64,'yifu',0,0,0,2040,0,305,0),(381,'靴',64,'xuezi',0,0,0,0,0,0,68),(382,'带',64,'yaodai',0,0,0,0,315,0,0),(383,'帽',64,'maozi',0,0,217,0,0,0,0),(384,'戒',64,'jiezhi',0,136,0,0,0,0,0),(385,'剑',65,'wuqi',660,0,0,0,0,0,0),(386,'衣',65,'yifu',0,0,0,2070,0,310,0),(387,'靴',65,'xuezi',0,0,0,0,0,0,69),(388,'带',65,'yaodai',0,0,0,0,320,0,0),(389,'帽',65,'maozi',0,0,220,0,0,0,0),(390,'戒',65,'jiezhi',0,138,0,0,0,0,0),(391,'剑',66,'wuqi',670,0,0,0,0,0,0),(392,'衣',66,'yifu',0,0,0,2095,0,314,0),(393,'靴',66,'xuezi',0,0,0,0,0,0,70),(394,'带',66,'yaodai',0,0,0,0,324,0,0),(395,'帽',66,'maozi',0,0,224,0,0,0,0),(396,'戒',66,'jiezhi',0,140,0,0,0,0,0),(397,'剑',67,'wuqi',680,0,0,0,0,0,0),(398,'衣',67,'yifu',0,0,0,2130,0,319,0),(399,'靴',67,'xuezi',0,0,0,0,0,0,71),(400,'带',67,'yaodai',0,0,0,0,329,0,0),(401,'帽',67,'maozi',0,0,227,0,0,0,0),(402,'戒',67,'jiezhi',0,142,0,0,0,0,0),(403,'剑',68,'wuqi',690,0,0,0,0,0,0),(404,'衣',68,'yifu',0,0,0,2160,0,324,0),(405,'靴',68,'xuezi',0,0,0,0,0,0,72),(406,'带',68,'yaodai',0,0,0,0,334,0,0),(407,'帽',68,'maozi',0,0,230,0,0,0,0),(408,'戒',68,'jiezhi',0,144,0,0,0,0,0),(409,'剑',69,'wuqi',700,0,0,0,0,0,0),(410,'衣',69,'yifu',0,0,0,2185,0,329,0),(411,'靴',69,'xuezi',0,0,0,0,0,0,73),(412,'带',69,'yaodai',0,0,0,0,339,0,0),(413,'帽',69,'maozi',0,0,234,0,0,0,0),(414,'戒',69,'jiezhi',0,146,0,0,0,0,0),(415,'剑',70,'wuqi',779,0,0,0,0,0,0),(416,'衣',70,'yifu',0,0,0,2220,0,334,0),(417,'靴',70,'xuezi',0,0,0,0,0,0,74),(418,'带',70,'yaodai',0,0,0,0,344,0,0),(419,'帽',70,'maozi',0,0,260,0,0,0,0),(420,'戒',70,'jiezhi',0,148,0,0,0,0,0),(421,'剑',71,'wuqi',790,0,0,0,0,0,0),(422,'衣',71,'yifu',0,0,0,2245,0,338,0),(423,'靴',71,'xuezi',0,0,0,0,0,0,75),(424,'带',71,'yaodai',0,0,0,0,348,0,0),(425,'帽',71,'maozi',0,0,264,0,0,0,0),(426,'戒',71,'jiezhi',0,150,0,0,0,0,0),(427,'剑',72,'wuqi',801,0,0,0,0,0,0),(428,'衣',72,'yifu',0,0,0,2280,0,343,0),(429,'靴',72,'xuezi',0,0,0,0,0,0,76),(430,'带',72,'yaodai',0,0,0,0,353,0,0),(431,'帽',72,'maozi',0,0,267,0,0,0,0),(432,'戒',72,'jiezhi',0,152,0,0,0,0,0),(433,'剑',73,'wuqi',812,0,0,0,0,0,0),(434,'衣',73,'yifu',0,0,0,2310,0,348,0),(435,'靴',73,'xuezi',0,0,0,0,0,0,77),(436,'带',73,'yaodai',0,0,0,0,358,0,0),(437,'帽',73,'maozi',0,0,271,0,0,0,0),(438,'戒',73,'jiezhi',0,154,0,0,0,0,0),(439,'剑',74,'wuqi',823,0,0,0,0,0,0),(440,'衣',74,'yifu',0,0,0,2335,0,353,0),(441,'靴',74,'xuezi',0,0,0,0,0,0,78),(442,'带',74,'yaodai',0,0,0,0,363,0,0),(443,'帽',74,'maozi',0,0,275,0,0,0,0),(444,'戒',74,'jiezhi',0,156,0,0,0,0,0),(445,'剑',75,'wuqi',834,0,0,0,0,0,0),(446,'衣',75,'yifu',0,0,0,2370,0,358,0),(447,'靴',75,'xuezi',0,0,0,0,0,0,79),(448,'带',75,'yaodai',0,0,0,0,368,0,0),(449,'帽',75,'maozi',0,0,278,0,0,0,0),(450,'戒',75,'jiezhi',0,158,0,0,0,0,0),(451,'剑',76,'wuqi',845,0,0,0,0,0,0),(452,'衣',76,'yifu',0,0,0,2400,0,362,0),(453,'靴',76,'xuezi',0,0,0,0,0,0,80),(454,'带',76,'yaodai',0,0,0,0,372,0,0),(455,'帽',76,'maozi',0,0,282,0,0,0,0),(456,'戒',76,'jiezhi',0,160,0,0,0,0,0),(457,'剑',77,'wuqi',856,0,0,0,0,0,0),(458,'衣',77,'yifu',0,0,0,2425,0,367,0),(459,'靴',77,'xuezi',0,0,0,0,0,0,81),(460,'带',77,'yaodai',0,0,0,0,377,0,0),(461,'帽',77,'maozi',0,0,286,0,0,0,0),(462,'戒',77,'jiezhi',0,162,0,0,0,0,0),(463,'剑',78,'wuqi',867,0,0,0,0,0,0),(464,'衣',78,'yifu',0,0,0,2460,0,372,0),(465,'靴',78,'xuezi',0,0,0,0,0,0,82),(466,'带',78,'yaodai',0,0,0,0,382,0,0),(467,'帽',78,'maozi',0,0,289,0,0,0,0),(468,'戒',78,'jiezhi',0,164,0,0,0,0,0),(469,'剑',79,'wuqi',878,0,0,0,0,0,0),(470,'衣',79,'yifu',0,0,0,2490,0,377,0),(471,'靴',79,'xuezi',0,0,0,0,0,0,83),(472,'带',79,'yaodai',0,0,0,0,387,0,0),(473,'帽',79,'maozi',0,0,293,0,0,0,0),(474,'戒',79,'jiezhi',0,166,0,0,0,0,0),(475,'剑',80,'wuqi',968,0,0,0,0,0,0),(476,'衣',80,'yifu',0,0,0,2520,0,382,0),(477,'靴',80,'xuezi',0,0,0,0,0,0,84),(478,'带',80,'yaodai',0,0,0,0,392,0,0),(479,'帽',80,'maozi',0,0,323,0,0,0,0),(480,'戒',80,'jiezhi',0,168,0,0,0,0,0),(481,'剑',81,'wuqi',980,0,0,0,0,0,0),(482,'衣',81,'yifu',0,0,0,2550,0,386,0),(483,'靴',81,'xuezi',0,0,0,0,0,0,85),(484,'带',81,'yaodai',0,0,0,0,396,0,0),(485,'帽',81,'maozi',0,0,327,0,0,0,0),(486,'戒',81,'jiezhi',0,170,0,0,0,0,0),(487,'剑',82,'wuqi',992,0,0,0,0,0,0),(488,'衣',82,'yifu',0,0,0,2580,0,391,0),(489,'靴',82,'xuezi',0,0,0,0,0,0,86),(490,'带',82,'yaodai',0,0,0,0,401,0,0),(491,'帽',82,'maozi',0,0,331,0,0,0,0),(492,'戒',82,'jiezhi',0,172,0,0,0,0,0),(493,'剑',83,'wuqi',1004,0,0,0,0,0,0),(494,'衣',83,'yifu',0,0,0,2610,0,396,0),(495,'靴',83,'xuezi',0,0,0,0,0,0,87),(496,'带',83,'yaodai',0,0,0,0,406,0,0),(497,'帽',83,'maozi',0,0,335,0,0,0,0),(498,'戒',83,'jiezhi',0,174,0,0,0,0,0),(499,'剑',84,'wuqi',1016,0,0,0,0,0,0),(500,'衣',84,'yifu',0,0,0,2640,0,401,0),(501,'靴',84,'xuezi',0,0,0,0,0,0,88),(502,'带',84,'yaodai',0,0,0,0,411,0,0),(503,'帽',84,'maozi',0,0,339,0,0,0,0),(504,'戒',84,'jiezhi',0,176,0,0,0,0,0),(505,'剑',85,'wuqi',1028,0,0,0,0,0,0),(506,'衣',85,'yifu',0,0,0,2670,0,406,0),(507,'靴',85,'xuezi',0,0,0,0,0,0,89),(508,'带',85,'yaodai',0,0,0,0,416,0,0),(509,'帽',85,'maozi',0,0,343,0,0,0,0),(510,'戒',85,'jiezhi',0,178,0,0,0,0,0),(511,'剑',86,'wuqi',1040,0,0,0,0,0,0),(512,'衣',86,'yifu',0,0,0,2700,0,410,0),(513,'靴',86,'xuezi',0,0,0,0,0,0,90),(514,'带',86,'yaodai',0,0,0,0,420,0,0),(515,'帽',86,'maozi',0,0,347,0,0,0,0),(516,'戒',86,'jiezhi',0,180,0,0,0,0,0),(517,'剑',87,'wuqi',1052,0,0,0,0,0,0),(518,'衣',87,'yifu',0,0,0,2730,0,415,0),(519,'靴',87,'xuezi',0,0,0,0,0,0,91),(520,'带',87,'yaodai',0,0,0,0,425,0,0),(521,'帽',87,'maozi',0,0,351,0,0,0,0),(522,'戒',87,'jiezhi',0,182,0,0,0,0,0),(523,'剑',88,'wuqi',1064,0,0,0,0,0,0),(524,'衣',88,'yifu',0,0,0,2760,0,420,0),(525,'靴',88,'xuezi',0,0,0,0,0,0,92),(526,'带',88,'yaodai',0,0,0,0,430,0,0),(527,'帽',88,'maozi',0,0,355,0,0,0,0),(528,'戒',88,'jiezhi',0,184,0,0,0,0,0),(529,'剑',89,'wuqi',1076,0,0,0,0,0,0),(530,'衣',89,'yifu',0,0,0,2790,0,425,0),(531,'靴',89,'xuezi',0,0,0,0,0,0,93),(532,'带',89,'yaodai',0,0,0,0,435,0,0),(533,'帽',89,'maozi',0,0,359,0,0,0,0),(534,'戒',89,'jiezhi',0,186,0,0,0,0,0),(535,'剑',90,'wuqi',1177,0,0,0,0,0,0),(536,'衣',90,'yifu',0,0,0,2820,0,430,0),(537,'靴',90,'xuezi',0,0,0,0,0,0,94),(538,'带',90,'yaodai',0,0,0,0,440,0,0),(539,'帽',90,'maozi',0,0,393,0,0,0,0),(540,'戒',90,'jiezhi',0,188,0,0,0,0,0),(541,'剑',91,'wuqi',1190,0,0,0,0,0,0),(542,'衣',91,'yifu',0,0,0,2850,0,434,0),(543,'靴',91,'xuezi',0,0,0,0,0,0,95),(544,'带',91,'yaodai',0,0,0,0,444,0,0),(545,'帽',91,'maozi',0,0,397,0,0,0,0),(546,'戒',91,'jiezhi',0,190,0,0,0,0,0),(547,'剑',92,'wuqi',1203,0,0,0,0,0,0),(548,'衣',92,'yifu',0,0,0,2880,0,439,0),(549,'靴',92,'xuezi',0,0,0,0,0,0,96),(550,'带',92,'yaodai',0,0,0,0,449,0,0),(551,'帽',92,'maozi',0,0,401,0,0,0,0),(552,'戒',92,'jiezhi',0,192,0,0,0,0,0),(553,'剑',93,'wuqi',1216,0,0,0,0,0,0),(554,'衣',93,'yifu',0,0,0,2910,0,444,0),(555,'靴',93,'xuezi',0,0,0,0,0,0,97),(556,'带',93,'yaodai',0,0,0,0,454,0,0),(557,'帽',93,'maozi',0,0,406,0,0,0,0),(558,'戒',93,'jiezhi',0,194,0,0,0,0,0),(559,'剑',94,'wuqi',1229,0,0,0,0,0,0),(560,'衣',94,'yifu',0,0,0,2940,0,449,0),(561,'靴',94,'xuezi',0,0,0,0,0,0,98),(562,'带',94,'yaodai',0,0,0,0,459,0,0),(563,'帽',94,'maozi',0,0,410,0,0,0,0),(564,'戒',94,'jiezhi',0,196,0,0,0,0,0),(565,'剑',95,'wuqi',1242,0,0,0,0,0,0),(566,'衣',95,'yifu',0,0,0,2970,0,454,0),(567,'靴',95,'xuezi',0,0,0,0,0,0,99),(568,'带',95,'yaodai',0,0,0,0,464,0,0),(569,'帽',95,'maozi',0,0,414,0,0,0,0),(570,'戒',95,'jiezhi',0,198,0,0,0,0,0),(571,'剑',96,'wuqi',1255,0,0,0,0,0,0),(572,'衣',96,'yifu',0,0,0,3000,0,458,0),(573,'靴',96,'xuezi',0,0,0,0,0,0,100),(574,'带',96,'yaodai',0,0,0,0,468,0,0),(575,'帽',96,'maozi',0,0,419,0,0,0,0),(576,'戒',96,'jiezhi',0,200,0,0,0,0,0),(577,'剑',97,'wuqi',1268,0,0,0,0,0,0),(578,'衣',97,'yifu',0,0,0,3030,0,463,0),(579,'靴',97,'xuezi',0,0,0,0,0,0,101),(580,'带',97,'yaodai',0,0,0,0,473,0,0),(581,'帽',97,'maozi',0,0,423,0,0,0,0),(582,'戒',97,'jiezhi',0,202,0,0,0,0,0),(583,'剑',98,'wuqi',1281,0,0,0,0,0,0),(584,'衣',98,'yifu',0,0,0,3060,0,468,0),(585,'靴',98,'xuezi',0,0,0,0,0,0,102),(586,'带',98,'yaodai',0,0,0,0,478,0,0),(587,'帽',98,'maozi',0,0,427,0,0,0,0),(588,'戒',98,'jiezhi',0,204,0,0,0,0,0),(589,'剑',99,'wuqi',1294,0,0,0,0,0,0),(590,'衣',99,'yifu',0,0,0,3090,0,473,0),(591,'靴',99,'xuezi',0,0,0,0,0,0,103),(592,'带',99,'yaodai',0,0,0,0,483,0,0),(593,'帽',99,'maozi',0,0,432,0,0,0,0),(594,'戒',99,'jiezhi',0,206,0,0,0,0,0),(595,'剑',100,'wuqi',1406,0,0,0,0,0,0),(596,'衣',100,'yifu',0,0,0,3120,0,478,0),(597,'靴',100,'xuezi',0,0,0,0,0,0,104),(598,'带',100,'yaodai',0,0,0,0,488,0,0),(599,'帽',100,'maozi',0,0,469,0,0,0,0),(600,'戒',100,'jiezhi',0,208,0,0,0,0,0);
/*!40000 ALTER TABLE `s_zhuangbei_all` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_zhuangbei_shengji`
--

DROP TABLE IF EXISTS `s_zhuangbei_shengji`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_zhuangbei_shengji` (
  `num` int(2) NOT NULL AUTO_INCREMENT,
  `zb_name` varchar(20) DEFAULT NULL,
  `zb_min_dj` int(2) DEFAULT NULL,
  `zb_max_dj` int(2) DEFAULT NULL,
  `wp_name` varchar(20) DEFAULT NULL,
  `wp_count` int(2) DEFAULT NULL,
  `xh_money` int(2) DEFAULT NULL,
  PRIMARY KEY (`num`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_zhuangbei_shengji`
--

LOCK TABLES `s_zhuangbei_shengji` WRITE;
/*!40000 ALTER TABLE `s_zhuangbei_shengji` DISABLE KEYS */;
INSERT INTO `s_zhuangbei_shengji` VALUES (1,'剑',1,2,'装备石',3,100),(2,'剑',3,4,'装备石',1,1);
/*!40000 ALTER TABLE `s_zhuangbei_shengji` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'cs_yanxii_com'
--

--
-- Dumping routines for database 'cs_yanxii_com'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-16  9:44:55
