-- MariaDB dump 10.19  Distrib 10.5.12-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: applications
-- ------------------------------------------------------
-- Server version	10.5.12-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `PUBACC_AM`
--

DROP TABLE IF EXISTS `PUBACC_AM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PUBACC_AM` (
  `record_type` char(2) NOT NULL,
  `unique_system_identifier` decimal(9,0) NOT NULL,
  `uls_file_num` char(14) DEFAULT NULL,
  `ebf_number` varchar(30) DEFAULT NULL,
  `callsign` char(10) DEFAULT NULL,
  `operator_class` char(1) DEFAULT NULL,
  `group_code` char(1) DEFAULT NULL,
  `region_code` tinyint(4) DEFAULT NULL,
  `trustee_callsign` char(10) DEFAULT NULL,
  `trustee_indicator` char(1) DEFAULT NULL,
  `physician_certification` char(1) DEFAULT NULL,
  `ve_signature` char(1) DEFAULT NULL,
  `systematic_callsign_change` char(1) DEFAULT NULL,
  `vanity_callsign_change` char(1) DEFAULT NULL,
  `vanity_relationship` char(12) DEFAULT NULL,
  `previous_callsign` char(10) DEFAULT NULL,
  `previous_operator_class` char(1) DEFAULT NULL,
  `trustee_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`unique_system_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PUBACC_CO`
--

DROP TABLE IF EXISTS `PUBACC_CO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PUBACC_CO` (
  `record_type` char(2) NOT NULL,
  `unique_system_identifier` decimal(9,0) NOT NULL,
  `uls_file_num` char(14) DEFAULT NULL,
  `callsign` char(10) DEFAULT NULL,
  `comment_date` char(10) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `status_code` char(1) DEFAULT NULL,
  `status_date` datetime DEFAULT NULL,
  PRIMARY KEY (`unique_system_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PUBACC_EN`
--

DROP TABLE IF EXISTS `PUBACC_EN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PUBACC_EN` (
  `record_type` char(2) CHARACTER SET latin1 NOT NULL,
  `unique_system_identifier` decimal(9,0) NOT NULL,
  `uls_file_number` char(14) CHARACTER SET latin1 DEFAULT NULL,
  `ebf_number` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `call_sign` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `entity_type` char(2) CHARACTER SET latin1 DEFAULT NULL,
  `licensee_id` char(9) CHARACTER SET latin1 DEFAULT NULL,
  `entity_name` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `first_name` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `mi` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `last_name` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `suffix` char(3) CHARACTER SET latin1 DEFAULT NULL,
  `phone` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `fax` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `street_address` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
  `city` varchar(22) CHARACTER SET latin1 DEFAULT NULL,
  `state` char(2) CHARACTER SET latin1 DEFAULT NULL,
  `zip_code` char(9) CHARACTER SET latin1 DEFAULT NULL,
  `po_box` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `attention_line` varchar(35) CHARACTER SET latin1 DEFAULT NULL,
  `sgin` char(3) CHARACTER SET latin1 DEFAULT NULL,
  `frn` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `applicant_type_code` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `applicant_type_other` char(40) CHARACTER SET latin1 DEFAULT NULL,
  `status_code` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `status_date` datetime DEFAULT NULL,
  `lic_category_code` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `linked_license_id` decimal(9,0) DEFAULT NULL,
  `linked_callsign` char(10) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`unique_system_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_nopad_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PUBACC_HD`
--

DROP TABLE IF EXISTS `PUBACC_HD`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PUBACC_HD` (
  `record_type` char(2) CHARACTER SET latin1 DEFAULT NULL,
  `unique_system_identifier` decimal(9,0) NOT NULL,
  `uls_file_number` char(14) CHARACTER SET latin1 DEFAULT NULL,
  `ebf_number` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `call_sign` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `license_status` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `radio_service_code` char(2) CHARACTER SET latin1 DEFAULT NULL,
  `grant_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `cancellation_date` date DEFAULT NULL,
  `eligibility_rule_num` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `applicant_type_code_reserved` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `alien` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `alien_government` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `alien_corporation` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `alien_officer` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `alien_control` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `revoked` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `convicted` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `adjudged` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `involved_reserved` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `common_carrier` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `non_common_carrier` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `private_comm` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `fixed` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `mobile` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `radiolocation` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `satellite` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `developmental_or_sta` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `interconnected_service` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `certifier_first_name` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `certifier_mi` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `certifier_last_name` varchar(25) DEFAULT NULL,
  `certifier_suffix` char(3) CHARACTER SET latin1 DEFAULT NULL,
  `certifier_title` char(40) CHARACTER SET latin1 DEFAULT NULL,
  `gender` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `african_american` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `native_american` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `hawaiian` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `asian` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `white` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `ethnicity` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `last_action_date` date DEFAULT NULL,
  `auction_id` int(11) DEFAULT NULL,
  `reg_stat_broad_serv` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `band_manager` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `type_serv_broad_serv` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `alien_ruling` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `licensee_name_change` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `whitespace_ind` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `additional_cert_choice` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `additional_cert_answer` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `discontinuation_ind` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `regulatory_compliance_ind` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `eligibility_cert_900` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `transition_plan_cert_900` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `return_spectrum_cert_900` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `payment_cert_900` char(1) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`unique_system_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PUBACC_HS`
--

DROP TABLE IF EXISTS `PUBACC_HS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PUBACC_HS` (
  `record_type` char(2) NOT NULL,
  `unique_system_identifier` decimal(9,0) NOT NULL,
  `uls_file_number` char(14) DEFAULT NULL,
  `callsign` char(10) DEFAULT NULL,
  `log_date` date NOT NULL,
  `code` char(6) NOT NULL,
  PRIMARY KEY (`unique_system_identifier`,`log_date`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PUBACC_LA`
--

DROP TABLE IF EXISTS `PUBACC_LA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PUBACC_LA` (
  `record_type` char(2) DEFAULT NULL,
  `unique_system_identifier` decimal(9,0) NOT NULL,
  `callsign` char(10) DEFAULT NULL,
  `attachment_code` char(1) DEFAULT NULL,
  `attachment_desc` varchar(60) DEFAULT NULL,
  `attachment_date` char(10) DEFAULT NULL,
  `attachment_filename` varchar(60) DEFAULT NULL,
  `action_performed` char(1) DEFAULT NULL,
  PRIMARY KEY (`unique_system_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PUBACC_SC`
--

DROP TABLE IF EXISTS `PUBACC_SC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PUBACC_SC` (
  `record_type` char(2) DEFAULT NULL,
  `unique_system_identifier` decimal(9,0) NOT NULL,
  `uls_file_number` char(14) DEFAULT NULL,
  `ebf_number` varchar(30) DEFAULT NULL,
  `callsign` char(10) DEFAULT NULL,
  `special_condition_type` char(1) DEFAULT NULL,
  `special_condition_code` int(11) DEFAULT NULL,
  `status_code` char(1) DEFAULT NULL,
  `status_date` date DEFAULT NULL,
  PRIMARY KEY (`unique_system_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PUBACC_SF`
--

DROP TABLE IF EXISTS `PUBACC_SF`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PUBACC_SF` (
  `record_type` char(2) DEFAULT NULL,
  `unique_system_identifier` decimal(9,0) NOT NULL,
  `uls_file_number` char(14) DEFAULT NULL,
  `ebf_number` varchar(30) DEFAULT NULL,
  `callsign` char(10) DEFAULT NULL,
  `lic_freeform_cond_type` char(1) DEFAULT NULL,
  `unique_lic_freeform_id` decimal(9,0) DEFAULT NULL,
  `sequence_number` int(11) DEFAULT NULL,
  `lic_freeform_condition` varchar(255) DEFAULT NULL,
  `status_code` char(1) DEFAULT NULL,
  `status_date` datetime DEFAULT NULL,
  PRIMARY KEY (`unique_system_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-13 21:07:28
