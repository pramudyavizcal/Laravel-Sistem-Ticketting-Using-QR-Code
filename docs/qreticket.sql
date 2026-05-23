/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 8.0.30 : Database - qr_eticket
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`qr_eticket` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `qr_eticket`;

/*Table structure for table `attendees` */

DROP TABLE IF EXISTS `attendees`;

CREATE TABLE `attendees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `ticket_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seat_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Regular',
  `institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `major` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_checked_in` tinyint(1) NOT NULL DEFAULT '0',
  `registration_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `checked_in_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendees_ticket_code_unique` (`ticket_code`),
  KEY `attendees_event_id_foreign` (`event_id`),
  CONSTRAINT `attendees_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `attendees` */

insert  into `attendees`(`id`,`event_id`,`ticket_code`,`name`,`email`,`phone`,`seat_number`,`ticket_type`,`institution`,`faculty`,`major`,`is_checked_in`,`registration_status`,`payment_status`,`payment_method`,`payment_proof_path`,`admin_note`,`checked_in_at`,`checked_in_by`,`notes`,`created_at`,`updated_at`) values 
(21,3,'A3902EDE-A539-4C4D-811A-3AC78E03AFBD','Budi Santoso','budi.santoso@email.com','0835833439','A-001','VIP','Umum',NULL,NULL,1,'pending','free',NULL,NULL,NULL,'2026-03-06 08:40:02','Staff Scanner',NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(22,3,'20D45191-D826-486F-9020-0ACB78E819E5','Siti Rahayu','siti.rahayu@email.com','0848491771','B-002','VVIP','Umum',NULL,NULL,1,'pending','free',NULL,NULL,NULL,'2026-03-06 08:40:02','Staff Scanner',NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(23,3,'953B0FD7-EBEE-4CDC-BA47-07E10BD28D4D','Ahmad Fauzi','ahmad.fauzi@email.com','0892786387','C-003','Regular','Umum',NULL,NULL,1,'pending','free',NULL,NULL,NULL,'2026-03-06 06:40:02','Staff Scanner',NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(24,3,'FB536052-AA48-4DF7-A17B-C8CAE6ADBD6B','Dewi Lestari','dewi.lestari@email.com','0816079490','D-004','Backstage','Umum',NULL,NULL,1,'pending','free',NULL,NULL,NULL,'2026-03-06 05:40:02','Staff Scanner',NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(25,3,'ABEF2B09-152D-4471-9D11-36FF1A4B3FD9','Rizky Pratama','rizky.pratama@email.com','0837306558','E-005','VIP','Umum',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(26,3,'5BA63B2C-1355-4966-8058-E408C865284C','Eka Putri','eka.putri@email.com','0833356613','A-006','VVIP','Umum',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(27,3,'3ADC55AD-4613-47EC-923B-D7927BE000FE','Fajar Nugroho','fajar.nugroho@email.com','0871251736','B-007','Regular','Umum',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(28,3,'B0B67C95-44F9-48AA-9659-EB9245754451','Gita Wulandari','gita.wulandari@email.com','0873350034','C-008','Backstage','Umum',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(29,3,'224AEFC7-B7FD-41BB-81D3-F308DAA47181','Hendra Wijaya','hendra.wijaya@email.com','0859028765','D-009','VIP','Umum',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(30,3,'C19E64B0-244F-421C-A5C2-941034AA560C','Indah Permata','indah.permata@email.com','0812219429','E-010','VVIP','Umum',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(31,4,'E44E7EE2-F83E-4C4F-BF84-A35A7D9B1712','Budi Santoso','budi.santoso@email.com','0896680666','A-001','Peserta','Freelance Developer',NULL,NULL,1,'pending','free',NULL,NULL,NULL,'2026-03-06 05:40:02','Staff Scanner',NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(32,4,'82C7D0DB-CFCF-4DC8-A958-D1BFC68FE5B8','Siti Rahayu','siti.rahayu@email.com','0831428922','B-002','Mentor','Freelance Developer',NULL,NULL,1,'pending','free',NULL,NULL,NULL,'2026-03-06 06:40:02','Staff Scanner',NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(33,4,'FF8FD45C-EBB6-4E45-ADA0-1FA6B61A1813','Ahmad Fauzi','ahmad.fauzi@email.com','0842621876','C-003','Peserta','Freelance Developer',NULL,NULL,1,'pending','free',NULL,NULL,NULL,'2026-03-06 06:40:02','Staff Scanner',NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(34,4,'0568F94F-E861-4965-8B48-09BDF18F0064','Dewi Lestari','dewi.lestari@email.com','0857069520','D-004','Mentor','Freelance Developer',NULL,NULL,1,'pending','free',NULL,NULL,NULL,'2026-03-06 04:40:02','Staff Scanner',NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(35,4,'2FE08F5F-B0BE-4DA7-A0AA-32A8B71D11C5','Rizky Pratama','rizky.pratama@email.com','0884424499','E-005','Peserta','Freelance Developer',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(36,4,'38543FB2-BF12-4A92-B733-ED6A6A0BBC3C','Eka Putri','eka.putri@email.com','0845431959','A-006','Mentor','Freelance Developer',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(37,4,'66407D43-A8B7-4A20-8A92-062FEB9ED147','Fajar Nugroho','fajar.nugroho@email.com','0863771245','B-007','Peserta','Freelance Developer',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(38,4,'3E62A126-A78D-421E-9CAF-42B64B077F61','Gita Wulandari','gita.wulandari@email.com','0839704620','C-008','Mentor','Freelance Developer',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(39,4,'D3B909C8-DC01-4ED3-91F4-BAF838D34BF2','Hendra Wijaya','hendra.wijaya@email.com','0875941295','D-009','Peserta','Freelance Developer',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(40,4,'62F5954B-853E-42A1-9B73-C87497617894','Indah Permata','indah.permata@email.com','0824421869','E-010','Mentor','Freelance Developer',NULL,NULL,0,'pending','free',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(42,5,'WIS-YDJYUAAR','boiy','admin@qreticket.id','322323232',NULL,'Wisudawan','dasdadasdsadsa',NULL,NULL,0,'approved','paid',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-07 04:57:06','2026-05-23 06:19:22'),
(43,6,'SEM-RMDZL3WQ','boiy','admin@event.com','4242432423434',NULL,'Peserta','dasdadasdsadsa',NULL,NULL,0,'approved','paid','manual','payments/proofs/4Oau2CEEoxyHc0w2K0P4bEitG99YNYsUEfAcmtGp.png',NULL,NULL,NULL,NULL,'2026-03-07 06:12:42','2026-03-07 06:14:59');

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('wisuda','seminar','konser','workshop') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `venue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `quota` int NOT NULL DEFAULT '0',
  `organizer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6C63FF',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_bank_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_bank_holder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_manual_transfer` tinyint(1) NOT NULL DEFAULT '1',
  `allow_xendit` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_created_by_foreign` (`created_by`),
  CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `events` */

insert  into `events`(`id`,`created_by`,`name`,`type`,`description`,`venue`,`event_date`,`event_time`,`quota`,`organizer`,`logo_path`,`banner_path`,`theme_color`,`is_paid`,`price`,`payment_bank_name`,`payment_bank_number`,`payment_bank_holder`,`allow_manual_transfer`,`allow_xendit`,`is_active`,`created_at`,`updated_at`) values 
(3,1,'Konser Musik Nusantara Bersuara','konser','Konser musik spektakuler menampilkan artis-artis terbaik Indonesia dengan nuansa budaya nusantara.','Jakarta Convention Center','2026-06-06','19:00:00',2000,'Promotor Nusantara Entertainment',NULL,NULL,'#FF6B6B',0,0.00,NULL,NULL,NULL,1,0,1,'2026-03-06 09:40:02','2026-03-06 09:40:02'),
(4,1,'Workshop Laravel & Vue.js','workshop','Workshop intensif pengembangan web modern menggunakan Laravel dan Vue.js. Tersedia sertifikat kelulusan.','Coworking Space TechHub, Bandung','2027-06-11','08:30:00',80,'Komunitas Developer Indonesia','events/logos/nFauSw51kNuZsQlYko1QjqW2eWQLs78bBEPrqbQ6.png','events/banners/2EBlKq4Yyde7gprnvFrJ4iSVMVDiqdN3qqQcNAZ2.png','#43e97b',1,12000.00,NULL,NULL,NULL,0,1,1,'2026-03-06 09:40:02','2026-05-22 17:21:36'),
(5,1,'Wisuda Sarjana Universitas Nusantara 2026','wisuda',NULL,'Gedung Graha Utama, Universitas Nusantara','2027-10-07','08:00:00',12,'Biro Akademik Universitas Nusantara','events/logos/1cvNfp47kQxk7FCYR0aYgFekfVkfF3G72V9lWD6f.png','events/banners/16VedO7DuuxwSnJjRgHJKzdcufzMWCgyrkgaASKT.png','#6c63ff',1,35999.00,NULL,NULL,NULL,1,1,1,'2026-03-07 04:55:26','2026-05-22 14:46:18'),
(6,1,'Seminar Nasional Teknologi AI 2027','seminar',NULL,'Ballroom Hotel Grand Sahara, Jakarta','2027-06-03','08:00:00',1,'Ikatan Ahli Teknologi Indonesia','events/logos/wL5B1AUZG6NQum6vnLyVKcrL8cwjYmIPxYD60oiu.png','events/banners/ZSNbmdHleoFOqEjEqJX3rtwsYhy9wGJBRHKTXX8L.png','#00c9ff',1,50000.00,'BCA','12345678','Test Akun',1,0,1,'2026-03-07 06:12:06','2026-05-22 17:20:45');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

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

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

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

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

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

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_03_06_042146_create_events_table',1),
(5,'2026_03_06_042150_create_attendees_table',1),
(6,'2026_03_06_042156_create_scan_logs_table',1),
(7,'2026_03_07_051042_add_payment_to_events_table',2),
(8,'2026_03_07_051042_add_status_and_payment_to_attendees',2),
(9,'2026_03_07_061023_create_personal_access_tokens_table',3),
(10,'2026_05_23_000001_create_site_settings_table',4),
(11,'2026_05_23_000002_add_superadmin_and_event_owner',5);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `scan_logs` */

DROP TABLE IF EXISTS `scan_logs`;

CREATE TABLE `scan_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attendee_id` bigint unsigned NOT NULL,
  `event_id` bigint unsigned NOT NULL,
  `result` enum('success','duplicate','invalid') COLLATE utf8mb4_unicode_ci NOT NULL,
  `scanned_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scan_logs_attendee_id_foreign` (`attendee_id`),
  KEY `scan_logs_event_id_foreign` (`event_id`),
  CONSTRAINT `scan_logs_attendee_id_foreign` FOREIGN KEY (`attendee_id`) REFERENCES `attendees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `scan_logs_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `scan_logs` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

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

/*Data for the table `sessions` */

/*Table structure for table `site_settings` */

DROP TABLE IF EXISTS `site_settings`;

CREATE TABLE `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `site_settings` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`role`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Administrator','admin@qreticket.id',NULL,'$2y$12$eUn/eEQMyqHhDFvU9ToYM..UoUmZ8uE3SJCNHQaeChwfsRWT4nHG.','superadmin',NULL,'2026-03-06 09:40:01','2026-03-06 09:40:01'),
(2,'Indomusik','staff@qreticket.id',NULL,'$2y$12$B8bjyR2s2Fzzj2AGtvkvh.OXSu6viFpiqfsnhljSdtmX0rIcj11ra','admin',NULL,'2026-03-06 09:40:01','2026-05-23 08:24:36');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
