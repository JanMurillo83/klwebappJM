/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `street_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building_number` int NOT NULL,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint unsigned NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  KEY `audits_user_id_user_type_index` (`user_id`,`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bank_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bank_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clabe` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_details_employee_id_foreign` (`employee_id`),
  CONSTRAINT `bank_details_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `business_directories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_directories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('station','customer','supplier') COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_currency` enum('USD','MXN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfc_tax_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `neighborhood` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_days` int DEFAULT NULL,
  `credit_expiration_date` date DEFAULT NULL,
  `free_loading_unloading_hours` int DEFAULT NULL,
  `factory_company_id` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `add_document` text COLLATE utf8mb4_unicode_ci,
  `document_expiration_date` date DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarifario` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_directories_factory_company_id_foreign` (`factory_company_id`),
  CONSTRAINT `business_directories_factory_company_id_foreign` FOREIGN KEY (`factory_company_id`) REFERENCES `factory_companies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `handling_type` bigint unsigned NOT NULL,
  `material_type` bigint unsigned NOT NULL,
  `class` bigint unsigned NOT NULL,
  `count` int NOT NULL,
  `stackable` tinyint(1) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `uom_weight` bigint unsigned NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `height` decimal(10,2) NOT NULL,
  `uom_dimensions` bigint unsigned NOT NULL,
  `total_yards` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cargo_handling_type_foreign` (`handling_type`),
  KEY `cargo_material_type_foreign` (`material_type`),
  KEY `cargo_class_foreign` (`class`),
  KEY `cargo_uom_weight_foreign` (`uom_weight`),
  KEY `cargo_uom_dimensions_foreign` (`uom_dimensions`),
  CONSTRAINT `cargo_class_foreign` FOREIGN KEY (`class`) REFERENCES `freight_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cargo_handling_type_foreign` FOREIGN KEY (`handling_type`) REFERENCES `handling_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cargo_material_type_foreign` FOREIGN KEY (`material_type`) REFERENCES `material_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cargo_uom_dimensions_foreign` FOREIGN KEY (`uom_dimensions`) REFERENCES `uoms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cargo_uom_weight_foreign` FOREIGN KEY (`uom_weight`) REFERENCES `uoms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `carrier_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrier_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_service_detail` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carrier_details_id_service_detail_foreign` (`id_service_detail`),
  CONSTRAINT `carrier_details_id_service_detail_foreign` FOREIGN KEY (`id_service_detail`) REFERENCES `service_details` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `carriers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carriers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `carrier_detail_id` bigint unsigned NOT NULL,
  `business_directory_id` bigint unsigned NOT NULL,
  `service_date` date DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_details_id` bigint unsigned NOT NULL,
  `equipment_details_id` bigint unsigned DEFAULT NULL,
  `gps_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `port_of_entry` int DEFAULT NULL,
  `pickup_details_id` bigint unsigned DEFAULT NULL,
  `delivery_details_id` bigint unsigned DEFAULT NULL,
  `service_type_carrier_broker_id` bigint unsigned DEFAULT NULL,
  `arrival_requested` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelation_requested` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hand_carrier_detail_id` bigint unsigned DEFAULT NULL,
  `trailer_rental_carrier_detail_id` bigint unsigned DEFAULT NULL,
  `charter_carrier_detail_id` bigint unsigned DEFAULT NULL,
  `transfer_type` enum('Export','Import') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carriers_service_id_foreign` (`service_id`),
  KEY `carriers_carrier_detail_id_foreign` (`carrier_detail_id`),
  KEY `carriers_business_directory_id_foreign` (`business_directory_id`),
  KEY `carriers_cost_details_id_foreign` (`cost_details_id`),
  KEY `carriers_equipment_details_id_foreign` (`equipment_details_id`),
  KEY `carriers_pickup_details_id_foreign` (`pickup_details_id`),
  KEY `carriers_delivery_details_id_foreign` (`delivery_details_id`),
  KEY `carriers_service_type_carrier_broker_id_foreign` (`service_type_carrier_broker_id`),
  KEY `carriers_hand_carrier_detail_id_foreign` (`hand_carrier_detail_id`),
  KEY `carriers_trailer_rental_carrier_detail_id_foreign` (`trailer_rental_carrier_detail_id`),
  KEY `carriers_charter_carrier_detail_id_foreign` (`charter_carrier_detail_id`),
  CONSTRAINT `carriers_business_directory_id_foreign` FOREIGN KEY (`business_directory_id`) REFERENCES `business_directories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carriers_carrier_detail_id_foreign` FOREIGN KEY (`carrier_detail_id`) REFERENCES `carrier_details` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carriers_charter_carrier_detail_id_foreign` FOREIGN KEY (`charter_carrier_detail_id`) REFERENCES `charter_carrier_details` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carriers_cost_details_id_foreign` FOREIGN KEY (`cost_details_id`) REFERENCES `cost_details` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carriers_delivery_details_id_foreign` FOREIGN KEY (`delivery_details_id`) REFERENCES `delivery_details` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carriers_equipment_details_id_foreign` FOREIGN KEY (`equipment_details_id`) REFERENCES `equipment_details` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carriers_hand_carrier_detail_id_foreign` FOREIGN KEY (`hand_carrier_detail_id`) REFERENCES `hand_carrier_details` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carriers_pickup_details_id_foreign` FOREIGN KEY (`pickup_details_id`) REFERENCES `pickup_details` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carriers_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carriers_service_type_carrier_broker_id_foreign` FOREIGN KEY (`service_type_carrier_broker_id`) REFERENCES `service_type_carrier_brokers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carriers_trailer_rental_carrier_detail_id_foreign` FOREIGN KEY (`trailer_rental_carrier_detail_id`) REFERENCES `trailer_rental_carrier_details` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charge_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `charge_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `charges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `carrier_id` bigint unsigned NOT NULL,
  `charge_type_id` bigint unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cost` decimal(10,2) NOT NULL,
  `currency` enum('USD','MXN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `iva` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ret` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT NULL,
  `discount_description` text COLLATE utf8mb4_unicode_ci,
  `claim_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `claim_status` enum('recovered','rejected','under revision') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recovered_amount` decimal(10,2) DEFAULT NULL,
  `broker_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bond_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_info` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `charges_carrier_id_foreign` (`carrier_id`),
  KEY `charges_charge_type_id_foreign` (`charge_type_id`),
  CONSTRAINT `charges_carrier_id_foreign` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `charges_charge_type_id_foreign` FOREIGN KEY (`charge_type_id`) REFERENCES `charge_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `charter_carrier_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `charter_carrier_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pickup_date` date NOT NULL,
  `delivery_date_requested` date NOT NULL,
  `time` time NOT NULL,
  `actual_delivery_time` time NOT NULL,
  `flight_number` int NOT NULL,
  `tail_number` int NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_date` date NOT NULL,
  `arrival_time` time NOT NULL,
  `cost_per_hour` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `total_shipping_cost` decimal(10,2) NOT NULL,
  `exchange_rate` decimal(10,4) NOT NULL,
  `freight_charges` decimal(10,2) NOT NULL,
  `accessory_charges` decimal(10,2) NOT NULL,
  `total_kronos_invoice` decimal(10,2) NOT NULL,
  `gross_profit` decimal(10,2) NOT NULL,
  `commission` decimal(10,2) NOT NULL,
  `net_profit` decimal(10,2) NOT NULL,
  `kronos_invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sat_kronos_invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_sent` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_sent_date` date DEFAULT NULL,
  `kronos_invoice_due_date` date NOT NULL,
  `number_of_days_overdue` decimal(5,2) DEFAULT NULL,
  `payment_status` enum('paid','pending','na') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_addendum_attached` tinyint(1) DEFAULT NULL,
  `payment_sent` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `collections_service_id_foreign` (`service_id`),
  CONSTRAINT `collections_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `consignees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consignees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `delivery_date_requested` date NOT NULL,
  `delivery_time_requested` time NOT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `actual_time` time DEFAULT NULL,
  `withdrawal_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consignees_service_id_foreign` (`service_id`),
  CONSTRAINT `consignees_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `directory_entry_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cellphone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `working_hours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_directory_entry_id_foreign` (`directory_entry_id`),
  CONSTRAINT `contacts_directory_entry_id_foreign` FOREIGN KEY (`directory_entry_id`) REFERENCES `business_directories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cost_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cost_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `freight_rate` decimal(10,2) NOT NULL,
  `currency` enum('USD','MXN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `ret` decimal(10,2) NOT NULL,
  `gps_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `delivery_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `real_delivery_date` date NOT NULL,
  `delivery_in_time` time NOT NULL,
  `delivery_out_time` time NOT NULL,
  `delivery_detention_hours` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charger_cable_recived` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `devices_employee_id_foreign` (`employee_id`),
  CONSTRAINT `devices_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `document_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_service_id_foreign` (`service_id`),
  CONSTRAINT `documents_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `emergency_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emergency_contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emergency_contacts_employee_id_foreign` (`employee_id`),
  CONSTRAINT `emergency_contacts_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `date_of_hire` date NOT NULL,
  `address_id` bigint unsigned NOT NULL,
  `NSS` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_status_certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_ine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_security_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_of_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_user_id_foreign` (`user_id`),
  KEY `employees_address_id_foreign` (`address_id`),
  CONSTRAINT `employees_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `equipment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `equipment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_plates` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailer_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailer_plates` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exchange_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exchange_rates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `currency_from` enum('USD','MXN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_to` enum('USD','MXN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(10,6) NOT NULL,
  `effective_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `factory_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factory_companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `freight_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `freight_classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `hand_carrier_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hand_carrier_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `passenger_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passenger_id_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flight_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_date` date NOT NULL,
  `arrival_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `handling_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `handling_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `material_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `material_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modality` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('SINGLE','FULL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `container` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int NOT NULL,
  `weight` int NOT NULL,
  `uom` bigint unsigned NOT NULL,
  `material_type` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modality_uom_foreign` (`uom`),
  KEY `modality_material_type_foreign` (`material_type`),
  CONSTRAINT `modality_material_type_foreign` FOREIGN KEY (`material_type`) REFERENCES `material_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `modality_uom_foreign` FOREIGN KEY (`uom`) REFERENCES `uoms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pickup_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pickup_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `real_pickup_date` date NOT NULL,
  `in_time` time NOT NULL,
  `out_time` time NOT NULL,
  `detention_hours` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `service_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `service_type_carrier_brokers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_type_carrier_brokers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exchange_rate_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `business_directory_id` bigint unsigned NOT NULL,
  `shipment_status` bigint unsigned NOT NULL,
  `id_service_detail` bigint unsigned NOT NULL,
  `urgency_ltl_id` bigint unsigned DEFAULT NULL,
  `modality_id` bigint unsigned NOT NULL,
  `cargo_id` bigint unsigned NOT NULL,
  `rate_to_customer` decimal(10,2) NOT NULL,
  `currency` enum('USD','MXN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_customer_reference` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickup_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expedited` tinyint(1) NOT NULL DEFAULT '0',
  `hazmat` tinyint(1) NOT NULL DEFAULT '0',
  `team_driver` tinyint(1) NOT NULL DEFAULT '0',
  `round_trip` tinyint(1) NOT NULL DEFAULT '0',
  `un_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manual_status` text COLLATE utf8mb4_unicode_ci,
  `time_status` timestamp NULL DEFAULT NULL,
  `eta_delivery_status` date DEFAULT NULL,
  `notes_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_services` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_exchange_rate_id_foreign` (`exchange_rate_id`),
  KEY `services_user_id_foreign` (`user_id`),
  KEY `services_business_directory_id_foreign` (`business_directory_id`),
  KEY `services_shipment_status_foreign` (`shipment_status`),
  KEY `services_id_service_detail_foreign` (`id_service_detail`),
  KEY `services_urgency_ltl_id_foreign` (`urgency_ltl_id`),
  KEY `services_modality_id_foreign` (`modality_id`),
  KEY `services_cargo_id_foreign` (`cargo_id`),
  CONSTRAINT `services_business_directory_id_foreign` FOREIGN KEY (`business_directory_id`) REFERENCES `business_directories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_cargo_id_foreign` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_exchange_rate_id_foreign` FOREIGN KEY (`exchange_rate_id`) REFERENCES `exchange_rates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_id_service_detail_foreign` FOREIGN KEY (`id_service_detail`) REFERENCES `service_details` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_modality_id_foreign` FOREIGN KEY (`modality_id`) REFERENCES `modality` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_shipment_status_foreign` FOREIGN KEY (`shipment_status`) REFERENCES `shipment_status` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_urgency_ltl_id_foreign` FOREIGN KEY (`urgency_ltl_id`) REFERENCES `urgency_ltl` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services_suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `id_service_detail` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_suppliers_supplier_id_foreign` (`supplier_id`),
  KEY `services_suppliers_id_service_detail_foreign` (`id_service_detail`),
  CONSTRAINT `services_suppliers_id_service_detail_foreign` FOREIGN KEY (`id_service_detail`) REFERENCES `service_details` (`id`) ON DELETE CASCADE,
  CONSTRAINT `services_suppliers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shipment_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipment_status` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shippers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shippers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `requested_pickup_date` date NOT NULL,
  `time` time NOT NULL,
  `scheduled_border_crossing_date` date NOT NULL,
  `drop_reception_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shippers_service_id_foreign` (`service_id`),
  CONSTRAINT `shippers_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `stop_offs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stop_offs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `role` enum('shipper','consignee') COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_directory_id` bigint unsigned NOT NULL,
  `position` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stop_offs_service_id_foreign` (`service_id`),
  KEY `stop_offs_business_directory_id_foreign` (`business_directory_id`),
  CONSTRAINT `stop_offs_business_directory_id_foreign` FOREIGN KEY (`business_directory_id`) REFERENCES `business_directories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stop_offs_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `supplier_equipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_equipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `equipment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_equipments_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `supplier_equipments_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `supplier_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `calification` int NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_reviews_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `supplier_reviews_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `directory_entry_id` bigint unsigned NOT NULL,
  `mc_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usdot` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scac` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caat` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `container_drayage` tinyint(1) NOT NULL DEFAULT '0',
  `hand_carrier` tinyint(1) NOT NULL DEFAULT '0',
  `trailer_rental` tinyint(1) NOT NULL DEFAULT '0',
  `charter` tinyint(1) NOT NULL DEFAULT '0',
  `air_freight` tinyint(1) NOT NULL DEFAULT '0',
  `warehouse` tinyint(1) NOT NULL DEFAULT '0',
  `us_custom_broker` tinyint(1) NOT NULL DEFAULT '0',
  `transfer` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suppliers_directory_entry_id_foreign` (`directory_entry_id`),
  CONSTRAINT `suppliers_directory_entry_id_foreign` FOREIGN KEY (`directory_entry_id`) REFERENCES `business_directories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `to_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `to_pay` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `carrier_id` bigint unsigned NOT NULL,
  `supplier_invoice_amount` decimal(10,2) NOT NULL,
  `supplier_invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_status` enum('accepted','returned','rejected') COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_status_notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_payment_status` enum('Pending','Paid','NA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_due_date` date NOT NULL,
  `invoice_payment_date` date DEFAULT NULL,
  `payment_term` enum('PPD','PUE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_complement_received` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advancement` decimal(10,2) DEFAULT NULL,
  `remanent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `to_pay_carrier_id_foreign` (`carrier_id`),
  CONSTRAINT `to_pay_carrier_id_foreign` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `trailer_rental_carrier_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trailer_rental_carrier_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `monthly_rate` decimal(10,2) NOT NULL,
  `currency_monthly` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iva_monthly` decimal(10,2) DEFAULT NULL,
  `ret_monthly` decimal(10,2) DEFAULT NULL,
  `alocation_rate` decimal(10,2) NOT NULL,
  `currency_alocation` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iva_alocation` decimal(10,2) DEFAULT NULL,
  `ret_alocation` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `uoms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uoms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `urgency_ltl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `urgency_ltl` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` bigint unsigned NOT NULL,
  `emergency_company` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `urgency_ltl_type_foreign` (`type`),
  CONSTRAINT `urgency_ltl_type_foreign` FOREIGN KEY (`type`) REFERENCES `urgency_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `urgency_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `urgency_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `work_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_schedule` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `day_of_week` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_schedule_employee_id_foreign` (`employee_id`),
  CONSTRAINT `work_schedule_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2024_05_29_181739_add_two_factor_columns_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2024_05_29_181751_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2024_06_12_172119_create_permission_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2024_06_29_184729_create_audits_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2024_06_30_101331_create_activity_log_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2024_06_30_101332_add_event_column_to_activity_log_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2024_06_30_101333_add_batch_uuid_column_to_activity_log_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2024_07_03_182750_create_factory_companies_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2024_07_04_104247_create_business_directories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2024_07_07_165240_add_new_fields_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2024_07_08_112650_create_shipment_status_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2024_07_08_113246_create_handling_types_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2024_07_08_174354_create_material_types_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2024_07_10_170717_create_freight_classes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2024_10_07_155535_remove_birthday_and_date_of_hire_from_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2024_10_16_042918_create_contacts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2024_10_16_043132_create_service_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2024_10_16_043309_create_suppliers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2024_10_16_043733_create_services_suppliers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2024_10_16_043829_create_supplier_equipments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2024_10_16_043912_create_supplier_reviews_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2024_10_22_170252_create_uoms_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2024_10_22_170722_create_urgency_types_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2024_10_22_170938_create_addresses_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2024_10_22_171109_create_employees_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2024_10_22_171658_create_bank_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2024_10_22_172006_create_devices_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2024_10_22_173409_create_emergency_contacts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2024_10_22_173533_create_work_schedule_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2024_10_22_174623_create_exchange_rates_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2024_10_22_180201_create_urgency_ltl_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2024_10_22_180531_create_modality_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2024_10_22_180754_create_cargo_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2024_10_22_181020_create_charge_types_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2024_10_22_185533_create_cost_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2024_10_22_190400_create_pickup_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2024_10_22_190522_create_delivery_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2024_10_22_190635_create_equipment_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2024_10_22_190809_create_hand_carrier_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2024_10_22_190925_create_service_type_carrier_brokers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2024_10_23_001428_create_services_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2024_10_23_002923_create_collections_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2024_10_23_003328_create_documents_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2024_10_23_003920_create_carrier_details_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2024_10_23_004150_create_trailer_rental_carrier_details_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2024_10_23_011725_create_charter_carrier_details_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2024_11_26_211121_create_shippers_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2024_11_26_211417_create_carriers_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2024_11_26_212155_create_consignees_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2024_11_26_213313_create_to_pay_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2024_11_26_213532_create_stop_offs_table',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2024_11_26_213718_create_charges_table',13);
