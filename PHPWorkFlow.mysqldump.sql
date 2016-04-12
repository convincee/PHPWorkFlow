-- MySQL dump 10.13  Distrib 5.6.25, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: PHPWorkFlow
-- ------------------------------------------------------
-- Server version	5.6.25-0ubuntu0.15.04.1

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
-- Table structure for table `PHPWF_arc`
--

DROP TABLE IF EXISTS `PHPWF_arc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_arc` (
  `arc_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_flow_id` int(11) NOT NULL,
  `transition_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `direction` varchar(255) NOT NULL,
  `arc_type` varchar(32) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `yasper_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`arc_id`),
  UNIQUE KEY `arc_work_flow_id_transition_id_place_id_direction_i` (`work_flow_id`,`transition_id`,`place_id`,`direction`),
  UNIQUE KEY `arc_work_flow_id_name_i` (`work_flow_id`,`name`),
  UNIQUE KEY `arc_work_flow_id_yasper_name_i` (`work_flow_id`,`yasper_name`),
  KEY `arc_transition_id_i` (`transition_id`),
  KEY `arc_place_id_i` (`place_id`),
  CONSTRAINT `arc_place_id_fk` FOREIGN KEY (`place_id`) REFERENCES `PHPWF_place` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `arc_transition_id_fk` FOREIGN KEY (`transition_id`) REFERENCES `PHPWF_transition` (`transition_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `arc_work_flow_id_fk` FOREIGN KEY (`work_flow_id`) REFERENCES `PHPWF_work_flow` (`work_flow_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_arc`
--

LOCK TABLES `PHPWF_arc` WRITE;
/*!40000 ALTER TABLE `PHPWF_arc` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_arc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_command`
--

DROP TABLE IF EXISTS `PHPWF_command`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_command` (
  `command_id` int(11) NOT NULL AUTO_INCREMENT,
  `transition_id` int(11) NOT NULL,
  `command_string` varchar(255) NOT NULL,
  `command_seq` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`command_id`),
  KEY `fi_mand_transition_id_fk` (`transition_id`),
  CONSTRAINT `command_transition_id_fk` FOREIGN KEY (`transition_id`) REFERENCES `PHPWF_transition` (`transition_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_command`
--

LOCK TABLES `PHPWF_command` WRITE;
/*!40000 ALTER TABLE `PHPWF_command` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_command` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_gate`
--

DROP TABLE IF EXISTS `PHPWF_gate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_gate` (
  `gate_id` int(11) NOT NULL AUTO_INCREMENT,
  `transition_id` int(11) NOT NULL,
  `target_yasper_name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gate_id`),
  UNIQUE KEY `gate_transition_id_value_target_yasper_name_i` (`transition_id`,`value`,`target_yasper_name`),
  CONSTRAINT `gate_transition_id_fk` FOREIGN KEY (`transition_id`) REFERENCES `PHPWF_transition` (`transition_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_gate`
--

LOCK TABLES `PHPWF_gate` WRITE;
/*!40000 ALTER TABLE `PHPWF_gate` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_gate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_notification`
--

DROP TABLE IF EXISTS `PHPWF_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `transition_id` int(11) NOT NULL,
  `notification_type` varchar(32) NOT NULL,
  `notification_string` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`notification_id`),
  UNIQUE KEY `notification_transition_id_notification_type_notification_string` (`transition_id`,`notification_type`,`notification_string`),
  CONSTRAINT `notification_transition_id_fk` FOREIGN KEY (`transition_id`) REFERENCES `PHPWF_transition` (`transition_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_notification`
--

LOCK TABLES `PHPWF_notification` WRITE;
/*!40000 ALTER TABLE `PHPWF_notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_place`
--

DROP TABLE IF EXISTS `PHPWF_place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_place` (
  `place_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_flow_id` int(11) NOT NULL,
  `place_type` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `position_x` int(11) NOT NULL DEFAULT '0',
  `position_y` int(11) NOT NULL DEFAULT '0',
  `dimension_x` int(11) NOT NULL DEFAULT '0',
  `dimension_y` int(11) NOT NULL DEFAULT '0',
  `yasper_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`place_id`),
  UNIQUE KEY `place_work_flow_id_name_i` (`work_flow_id`,`name`),
  UNIQUE KEY `place_work_flow_id_yasper_name_i` (`work_flow_id`,`yasper_name`),
  CONSTRAINT `place_work_flow_id_fk` FOREIGN KEY (`work_flow_id`) REFERENCES `PHPWF_work_flow` (`work_flow_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_place`
--

LOCK TABLES `PHPWF_place` WRITE;
/*!40000 ALTER TABLE `PHPWF_place` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_route`
--

DROP TABLE IF EXISTS `PHPWF_route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_route` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `transition_id` int(11) NOT NULL,
  `route` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`route_id`),
  UNIQUE KEY `route_transition_id_route_i` (`transition_id`,`route`),
  CONSTRAINT `route_transition_id_fk` FOREIGN KEY (`transition_id`) REFERENCES `PHPWF_transition` (`transition_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_route`
--

LOCK TABLES `PHPWF_route` WRITE;
/*!40000 ALTER TABLE `PHPWF_route` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_token`
--

DROP TABLE IF EXISTS `PHPWF_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_token` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `use_case_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `creating_work_item_id` int(11) DEFAULT NULL,
  `consuming_work_item_id` int(11) DEFAULT NULL,
  `token_status` varchar(255) NOT NULL,
  `enabled_date` datetime NOT NULL,
  `cancelled_date` datetime DEFAULT NULL,
  `consumed_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`token_id`),
  KEY `token_place_id_fk` (`place_id`),
  KEY `fi_en_use_case_id_fk` (`use_case_id`),
  KEY `fi_en_creating_work_item_id_fk` (`creating_work_item_id`),
  KEY `fi_en_consuming_work_item_id_fk` (`consuming_work_item_id`),
  CONSTRAINT `token_consuming_work_item_id_fk` FOREIGN KEY (`consuming_work_item_id`) REFERENCES `PHPWF_work_item` (`work_item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `token_creating_work_item_id_fk` FOREIGN KEY (`creating_work_item_id`) REFERENCES `PHPWF_work_item` (`work_item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `token_place_id_fk` FOREIGN KEY (`place_id`) REFERENCES `PHPWF_place` (`place_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `token_use_case_id_fk` FOREIGN KEY (`use_case_id`) REFERENCES `PHPWF_use_case` (`use_case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_token`
--

LOCK TABLES `PHPWF_token` WRITE;
/*!40000 ALTER TABLE `PHPWF_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_transition`
--

DROP TABLE IF EXISTS `PHPWF_transition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_transition` (
  `transition_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_flow_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1023) NOT NULL,
  `transition_type` varchar(255) NOT NULL,
  `transition_trigger_method` varchar(255) NOT NULL,
  `position_x` int(11) NOT NULL DEFAULT '0',
  `position_y` int(11) NOT NULL DEFAULT '0',
  `dimension_x` int(11) NOT NULL DEFAULT '0',
  `dimension_y` int(11) NOT NULL DEFAULT '0',
  `yasper_name` varchar(255) NOT NULL,
  `time_delay` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transition_id`),
  UNIQUE KEY `transition_work_flow_id_name_i` (`work_flow_id`,`name`),
  UNIQUE KEY `transition_work_flow_id_transition_trigger_method_i` (`work_flow_id`,`transition_trigger_method`),
  UNIQUE KEY `transition_work_flow_id_yasper_name_i` (`work_flow_id`,`yasper_name`),
  CONSTRAINT `transition_work_flow_id_fk` FOREIGN KEY (`work_flow_id`) REFERENCES `PHPWF_work_flow` (`work_flow_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_transition`
--

LOCK TABLES `PHPWF_transition` WRITE;
/*!40000 ALTER TABLE `PHPWF_transition` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_transition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_trigger_fulfillment`
--

DROP TABLE IF EXISTS `PHPWF_trigger_fulfillment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_trigger_fulfillment` (
  `trigger_fulfillment_id` int(11) NOT NULL AUTO_INCREMENT,
  `use_case_id` int(11) NOT NULL,
  `transition_id` int(11) NOT NULL,
  `trigger_fulfillment_status` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trigger_fulfillment_id`),
  KEY `fi_gger_fulfillment_use_case_id_fk` (`use_case_id`),
  KEY `fi_gger_fulfillment_transition_id_fk` (`transition_id`),
  CONSTRAINT `trigger_fulfillment_transition_id_fk` FOREIGN KEY (`transition_id`) REFERENCES `PHPWF_transition` (`transition_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `trigger_fulfillment_use_case_id_fk` FOREIGN KEY (`use_case_id`) REFERENCES `PHPWF_use_case` (`use_case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_trigger_fulfillment`
--

LOCK TABLES `PHPWF_trigger_fulfillment` WRITE;
/*!40000 ALTER TABLE `PHPWF_trigger_fulfillment` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_trigger_fulfillment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_use_case`
--

DROP TABLE IF EXISTS `PHPWF_use_case`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_use_case` (
  `use_case_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_flow_id` int(11) NOT NULL,
  `parent_use_case_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `use_case_group` varchar(255) DEFAULT NULL,
  `use_case_status` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`use_case_id`),
  KEY `use_case_work_flow_id_fk` (`work_flow_id`),
  KEY `use_case_use_case_status_in` (`use_case_status`),
  KEY `PHPWF_use_case_fi_580bf5` (`parent_use_case_id`),
  CONSTRAINT `PHPWF_use_case_fk_580bf5` FOREIGN KEY (`parent_use_case_id`) REFERENCES `PHPWF_use_case` (`use_case_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `use_case_work_flow_id_fk` FOREIGN KEY (`work_flow_id`) REFERENCES `PHPWF_work_flow` (`work_flow_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_use_case`
--

LOCK TABLES `PHPWF_use_case` WRITE;
/*!40000 ALTER TABLE `PHPWF_use_case` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_use_case` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_use_case_context`
--

DROP TABLE IF EXISTS `PHPWF_use_case_context`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_use_case_context` (
  `use_case_context_id` int(11) NOT NULL AUTO_INCREMENT,
  `use_case_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`use_case_context_id`),
  UNIQUE KEY `use_case_context_use_case_id_name_i` (`use_case_id`,`name`),
  KEY `use_case_context_use_case_id_fk` (`use_case_id`),
  CONSTRAINT `use_case_context_use_case_id_fk` FOREIGN KEY (`use_case_id`) REFERENCES `PHPWF_use_case` (`use_case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_use_case_context`
--

LOCK TABLES `PHPWF_use_case_context` WRITE;
/*!40000 ALTER TABLE `PHPWF_use_case_context` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_use_case_context` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_work_flow`
--

DROP TABLE IF EXISTS `PHPWF_work_flow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_work_flow` (
  `work_flow_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `trigger_class` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`work_flow_id`),
  UNIQUE KEY `work_flow_on_name_i` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_work_flow`
--

LOCK TABLES `PHPWF_work_flow` WRITE;
/*!40000 ALTER TABLE `PHPWF_work_flow` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_work_flow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PHPWF_work_item`
--

DROP TABLE IF EXISTS `PHPWF_work_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PHPWF_work_item` (
  `work_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `use_case_id` int(11) NOT NULL,
  `transition_id` int(11) NOT NULL,
  `work_item_status` varchar(255) NOT NULL,
  `enabled_date` datetime NOT NULL,
  `cancelled_date` datetime DEFAULT NULL,
  `finished_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified_at` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`work_item_id`),
  KEY `work_item_transition_id_fk` (`transition_id`),
  KEY `fi_k_item_use_case_id_fk` (`use_case_id`),
  CONSTRAINT `work_item_arc_transition_id_fk` FOREIGN KEY (`transition_id`) REFERENCES `PHPWF_arc` (`transition_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `work_item_transition_id_fk` FOREIGN KEY (`transition_id`) REFERENCES `PHPWF_transition` (`transition_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `work_item_use_case_id_fk` FOREIGN KEY (`use_case_id`) REFERENCES `PHPWF_use_case` (`use_case_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PHPWF_work_item`
--

LOCK TABLES `PHPWF_work_item` WRITE;
/*!40000 ALTER TABLE `PHPWF_work_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `PHPWF_work_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-10 12:28:39
