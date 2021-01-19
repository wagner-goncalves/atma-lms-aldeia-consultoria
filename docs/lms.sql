/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 8.0.21 : Database - lms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lms` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `lms`;

/*Table structure for table `acessos` */

DROP TABLE IF EXISTS `acessos`;

CREATE TABLE `acessos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `material_id` bigint NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_downloads_materiais1_idx` (`material_id`),
  KEY `fk_downloads_users1_idx` (`user_id`),
  CONSTRAINT `fk_downloads_materiais1` FOREIGN KEY (`material_id`) REFERENCES `materiais` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_downloads_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `acessos` */

/*Table structure for table `aulas` */

DROP TABLE IF EXISTS `aulas`;

CREATE TABLE `aulas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `modulo_id` bigint NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text,
  `carga_horaria` double DEFAULT NULL,
  `link` varchar(500) NOT NULL,
  `ordem` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_aulas_modulos1_idx` (`modulo_id`),
  CONSTRAINT `fk_aulas_modulos1` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `aulas` */

insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (1,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','<p>sadsad</p>',60,'nHSa45qAgIM',1,'2020-12-18 19:36:01','2021-01-08 11:09:17',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (2,1,'Integer felis erat, mollis at elementum nec, ultrices nec ligula.',NULL,2,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',2,'2020-12-18 19:36:23',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (3,1,'Nulla congue viverra magna nec imperdiet.',NULL,3,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',3,'2020-12-18 19:36:36',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (4,1,'In hac habitasse platea dictumst.',NULL,1,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',4,'2020-12-18 19:36:47',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (5,1,'Nam mollis risus at posuere ultricies. Donec aliquet ac sem non interdum.',NULL,2,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',5,'2020-12-18 19:36:58',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (6,1,'Morbi ornare, lacus a finibus varius',NULL,3,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',6,'2020-12-18 19:37:13',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (7,1,'Proin consectetur convallis convallis. ',NULL,1,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',7,'2020-12-18 19:37:25',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (8,1,'Aliquam purus nisi, fringilla vel consequat sed',NULL,1,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',8,'2020-12-18 19:37:34',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (9,1,'Nam consectetur, ex vitae euismod venenatis',NULL,1,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',9,'2020-12-18 19:37:45',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (10,1,'Donec vulputate metus vitae metus congue',NULL,1,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',10,'2020-12-18 19:37:55',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (11,2,'Phasellus tempus, lacus aliquam aliquam consequat',NULL,2,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',11,'2020-12-18 19:38:23',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (12,2,'Curabitur sodales, diam at consequat pretium',NULL,2,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',12,'2020-12-18 19:38:32',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (13,3,'Ut eget volutpat diam',NULL,1,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',13,'2020-12-18 19:38:51',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (14,3,'Curabitur luctus lectus diam, nec efficitur arcu gravida a.',NULL,1,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',14,'2020-12-18 19:39:00',NULL,1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (15,3,'Praesent quam sapien, tincidunt a semper nec',NULL,2,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/nHSa45qAgIM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',15,'2020-12-18 19:39:08',NULL,1);

/*Table structure for table `certificados` */

DROP TABLE IF EXISTS `certificados`;

CREATE TABLE `certificados` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `curso_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_certificados_users1_idx` (`user_id`),
  KEY `fk_certificados_cursos1_idx` (`curso_id`),
  CONSTRAINT `fk_certificados_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_certificados_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `certificados` */

insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (3,1,1,'2021-01-19 12:07:41','2021-01-19 12:07:41');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (4,1,1,'2021-01-19 12:11:12','2021-01-19 12:11:12');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (5,1,1,'2021-01-19 12:12:31','2021-01-19 12:12:31');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (6,1,1,'2021-01-19 12:12:55','2021-01-19 12:12:55');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (7,1,1,'2021-01-19 12:13:31','2021-01-19 12:13:31');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (8,1,1,'2021-01-19 12:15:56','2021-01-19 12:15:56');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (9,1,1,'2021-01-19 12:16:50','2021-01-19 12:16:50');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (10,1,1,'2021-01-19 12:17:04','2021-01-19 12:17:04');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (11,1,1,'2021-01-19 12:18:36','2021-01-19 12:18:36');

/*Table structure for table `cursos` */

DROP TABLE IF EXISTS `cursos`;

CREATE TABLE `cursos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `descricao` text,
  `certificado` text,
  `banner` varchar(255) DEFAULT NULL,
  `base_certificado` varchar(255) DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `mensagem_conclusao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cursos` */

insert  into `cursos`(`id`,`nome`,`descricao`,`certificado`,`banner`,`base_certificado`,`is_active`,`mensagem_conclusao`) values (1,'Curso básico de segurança','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in auctor erat. Aliquam vitae auctor elit, consequat fringilla nunc. Morbi vel diam mattis, aliquam est id, consectetur nunc. Nullam dictum nibh at tristique commodo. Proin fermentum interdum rhoncus. Sed vulputate consequat vehicula. Nam dignissim, ipsum quis tristique ullamcorper, mi tellus sagittis nisi, sit amet finibus lacus ligula at elit. Proin consectetur dictum venenatis. Nulla blandit at nibh eget efficitur. Aliquam fringilla urna felis, non vestibulum quam egestas sed. Aenean quis fermentum ante. Curabitur sit amet aliquet massa.',NULL,'cursos/banner-curso.png','base-certificado.png',1,'<strong>Você acabou de finalizar o programa corporativo para gestantes e futuros pais.</strong>\r\n<br>\r\nObrigado por ter participado! \r\n<br>\r\nEsperamos ter contribuído para que sua experiência com a chegada do filho(a) tenha sido mais leve, segura e respeitosa.\r\n');

/*Table structure for table `email` */

DROP TABLE IF EXISTS `email`;

CREATE TABLE `email` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nome_remetente` varchar(255) DEFAULT NULL,
  `email_remetente` varchar(255) NOT NULL,
  `nome_destinatario` varchar(255) DEFAULT NULL,
  `email_destinatario` varchar(255) NOT NULL,
  `corpo` text NOT NULL,
  `enviado` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_email_users1_idx` (`user_id`),
  CONSTRAINT `fk_email_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `email` */

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

CREATE TABLE `empresas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `empresas` */

insert  into `empresas`(`id`,`nome`,`descricao`,`created_at`,`updated_at`,`is_active`) values (1,'Atma Interativa',NULL,'2020-12-18 17:24:55',NULL,1);
insert  into `empresas`(`id`,`nome`,`descricao`,`created_at`,`updated_at`,`is_active`) values (2,'Usiminas',NULL,'2020-12-28 12:13:32','2020-12-28 12:13:32',1);

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

/*Table structure for table `feedbacks` */

DROP TABLE IF EXISTS `feedbacks`;

CREATE TABLE `feedbacks` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `curso_id` bigint NOT NULL,
  `pergunta_id` bigint NOT NULL,
  `resposta_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_curso_pergunta` (`curso_id`,`pergunta_id`,`user_id`),
  KEY `fk_users_has_respostas_respostas1_idx` (`resposta_id`),
  KEY `fk_users_has_respostas_users1_idx` (`user_id`),
  KEY `fk_feedbacks_cursos1_idx` (`curso_id`),
  KEY `fk_feedbacks_perguntas1_idx` (`pergunta_id`),
  CONSTRAINT `fk_feedbacks_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_feedbacks_perguntas1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_respostas_respostas1` FOREIGN KEY (`resposta_id`) REFERENCES `respostas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_respostas_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `feedbacks` */

insert  into `feedbacks`(`id`,`user_id`,`curso_id`,`pergunta_id`,`resposta_id`,`created_at`,`updated_at`) values (43,1,1,1,1,'2021-01-19 12:07:34','2021-01-19 12:07:34');
insert  into `feedbacks`(`id`,`user_id`,`curso_id`,`pergunta_id`,`resposta_id`,`created_at`,`updated_at`) values (44,1,1,2,5,'2021-01-19 12:07:34','2021-01-19 12:07:34');
insert  into `feedbacks`(`id`,`user_id`,`curso_id`,`pergunta_id`,`resposta_id`,`created_at`,`updated_at`) values (45,1,1,3,11,'2021-01-19 12:07:34','2021-01-19 12:07:34');

/*Table structure for table `materiais` */

DROP TABLE IF EXISTS `materiais`;

CREATE TABLE `materiais` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `aula_id` bigint DEFAULT NULL,
  `modulo_id` bigint DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text,
  `arquivo` varchar(255) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_table1_aulas1_idx` (`aula_id`),
  KEY `fk_materiais_modulos1_idx` (`modulo_id`),
  CONSTRAINT `fk_materiais_modulos1` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_aulas1` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `materiais` */

insert  into `materiais`(`id`,`aula_id`,`modulo_id`,`titulo`,`descricao`,`arquivo`,`link`,`ordem`,`is_active`,`created_at`,`updated_at`) values (1,1,1,'Mauris dapibus mattis diam vitae maximus','Praesent sed dolor interdum, tristique tortor vitae, luctus nunc.','materiais/PtYkAQSwuV948In5ZlkC7uuEtWMb3QPZ5mQCl6s2.pdf','aa',0,1,'2020-12-21 14:13:07',NULL);
insert  into `materiais`(`id`,`aula_id`,`modulo_id`,`titulo`,`descricao`,`arquivo`,`link`,`ordem`,`is_active`,`created_at`,`updated_at`) values (2,1,1,'Un auctor sem sed purus suscipit sodales.','<p>Quisque condimentum eleifend lectus, non euismod nunc pulvinar mattis.</p>','materiais/PtYkAQSwuV948In5ZlkC7uuEtWMb3QPZ5mQCl6s2.pdf','bb',0,1,'2020-12-21 14:13:07','2020-12-21 14:23:07');
insert  into `materiais`(`id`,`aula_id`,`modulo_id`,`titulo`,`descricao`,`arquivo`,`link`,`ordem`,`is_active`,`created_at`,`updated_at`) values (10,NULL,1,'Teste 1',NULL,'materiais/DG4iJrtV8y9OQRPQv6SyeDjqoKMGcG6ZnLe0Onvt.pdf',NULL,1,1,'2021-01-09 14:44:54','2021-01-09 14:44:54');

/*Table structure for table `matriculas` */

DROP TABLE IF EXISTS `matriculas`;

CREATE TABLE `matriculas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `curso_id` bigint NOT NULL,
  `empresa_id` bigint NOT NULL,
  `plano_id` bigint NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `tempo_acesso` int DEFAULT NULL,
  `data_limite` timestamp NULL DEFAULT NULL,
  `data_conclusao` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_matricula` (`user_id`,`curso_id`,`empresa_id`),
  KEY `fk_matriculas_users1_idx` (`user_id`),
  KEY `fk_matriculas_cursos1_idx` (`curso_id`),
  KEY `fk_matriculas_empresas1_idx` (`empresa_id`),
  KEY `fk_matriculas_planos1_idx` (`plano_id`),
  KEY `ix_data_limite` (`data_limite`),
  CONSTRAINT `fk_matriculas_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_matriculas_empresas1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_matriculas_planos1` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_matriculas_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

/*Data for the table `matriculas` */

insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (92,123,1,1,1,1,60,'2021-03-20 11:29:16',NULL,'2021-01-19 11:29:16','2021-01-19 11:29:16');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (93,1,1,1,1,1,60,'2021-03-20 11:47:16','2021-01-19 12:07:34','2021-01-19 11:47:16','2021-01-19 12:07:34');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (2,'2014_10_12_100000_create_password_resets_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (3,'2019_08_19_000000_create_failed_jobs_table',1);
insert  into `migrations`(`id`,`migration`,`batch`) values (4,'2020_12_17_230803_create_permission_tables',1);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',1);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',1);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',119);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',121);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',122);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',123);

/*Table structure for table `modulos` */

DROP TABLE IF EXISTS `modulos`;

CREATE TABLE `modulos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `curso_id` bigint NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text,
  `ordem` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `modulo_padrao` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_modulos_cursos1_idx` (`curso_id`),
  CONSTRAINT `fk_modulos_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `modulos` */

insert  into `modulos`(`id`,`curso_id`,`nome`,`descricao`,`ordem`,`created_at`,`updated_at`,`modulo_padrao`) values (1,1,'Aliquam quis suscipit nisl. Cras aliquam consectetur magna','Aliquam quis suscipit nisl. Cras aliquam consectetur magna, vitae sodales tellus ullamcorper quis. Nulla in scelerisque dui, in congue elit. Nullam sit amet urna tortor. Vivamus gravida volutpat bibendum. Vivamus nec venenatis ligula. Praesent viverra mauris a tincidunt ornare. Donec erat erat, maximus sit amet varius eget, aliquam ac metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. ',1,'2020-12-21 22:09:34',NULL,1);
insert  into `modulos`(`id`,`curso_id`,`nome`,`descricao`,`ordem`,`created_at`,`updated_at`,`modulo_padrao`) values (2,1,'Vivamus nec venenatis ligula. Praesent viverra mauris a tincidunt ornare','Suspendisse id massa commodo, elementum elit a, rhoncus nulla. Nunc sit amet ornare ipsum. Mauris nibh nulla, malesuada vitae facilisis in, fringilla eu diam. Curabitur eu sodales tellus. ',2,'2020-12-21 22:09:34',NULL,1);
insert  into `modulos`(`id`,`curso_id`,`nome`,`descricao`,`ordem`,`created_at`,`updated_at`,`modulo_padrao`) values (3,1,'Bônus','<p>Aenean congue malesuada bibendum. Integer at enim arcu. Pellentesque luctus eros porta, bibendum quam efficitur, vulputate est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis ullamcorper commodo placerat. Aenean bibendum ultricies libero ut fermentum.</p>',3,'2020-12-21 22:09:34','2021-01-19 10:25:20',0);

/*Table structure for table `parametros` */

DROP TABLE IF EXISTS `parametros`;

CREATE TABLE `parametros` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `parametros` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `perguntas` */

DROP TABLE IF EXISTS `perguntas`;

CREATE TABLE `perguntas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `questionario_id` bigint NOT NULL,
  `pergunta` varchar(500) NOT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_perguntas_questionarios1_idx` (`questionario_id`),
  CONSTRAINT `fk_perguntas_questionarios1` FOREIGN KEY (`questionario_id`) REFERENCES `questionarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `perguntas` */

insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (1,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',1,1,'2021-01-07 10:53:24',NULL);
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (2,1,'Ut ut orci a libero pulvinar vehicula. Aenean eget efficitur dolor, et tristique augue.',2,1,'2021-01-07 10:53:24',NULL);
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (3,1,'Aenean mattis enim id nunc egestas, a ornare erat accumsan.',3,1,'2021-01-07 10:53:24','2021-01-07 11:06:21');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'role-list','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (2,'role-create','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (3,'role-edit','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (4,'role-delete','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (5,'product-list','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (6,'product-create','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (7,'product-edit','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (8,'product-delete','web','2020-12-17 23:25:01','2020-12-17 23:25:01');

/*Table structure for table `planos` */

DROP TABLE IF EXISTS `planos`;

CREATE TABLE `planos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text,
  `valor` double(10,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `planos` */

insert  into `planos`(`id`,`nome`,`descricao`,`valor`,`is_active`,`created_at`,`updated_at`) values (1,'Bronze',NULL,0.00,1,'2021-01-05 11:35:58',NULL);
insert  into `planos`(`id`,`nome`,`descricao`,`valor`,`is_active`,`created_at`,`updated_at`) values (2,'Prata',NULL,0.00,1,'2021-01-05 11:35:58',NULL);
insert  into `planos`(`id`,`nome`,`descricao`,`valor`,`is_active`,`created_at`,`updated_at`) values (3,'Ouro',NULL,0.00,1,'2021-01-05 11:35:58',NULL);

/*Table structure for table `planos_has_cursos` */

DROP TABLE IF EXISTS `planos_has_cursos`;

CREATE TABLE `planos_has_cursos` (
  `plano_id` bigint NOT NULL,
  `curso_id` bigint NOT NULL,
  `usuarios` int NOT NULL DEFAULT '0',
  `tempo_acesso` int NOT NULL,
  PRIMARY KEY (`plano_id`,`curso_id`),
  KEY `fk_planos_has_cursos_cursos1_idx` (`curso_id`),
  KEY `fk_planos_has_cursos_planos1_idx` (`plano_id`),
  CONSTRAINT `fk_planos_has_cursos_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_planos_has_cursos_planos1` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `planos_has_cursos` */

insert  into `planos_has_cursos`(`plano_id`,`curso_id`,`usuarios`,`tempo_acesso`) values (1,1,5,60);

/*Table structure for table `planos_has_empresas` */

DROP TABLE IF EXISTS `planos_has_empresas`;

CREATE TABLE `planos_has_empresas` (
  `plano_id` bigint NOT NULL,
  `empresa_id` bigint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`plano_id`,`empresa_id`),
  KEY `fk_planos_has_empresas_empresas1_idx` (`empresa_id`),
  KEY `fk_planos_has_empresas_planos1_idx` (`plano_id`),
  CONSTRAINT `fk_planos_has_empresas_empresas1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_planos_has_empresas_planos1` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `planos_has_empresas` */

insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (1,1,'2020-12-18 17:25:14');
insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (1,2,'2020-12-28 12:13:32');
insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (2,2,'2020-12-28 12:13:32');
insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (3,1,'2020-12-28 14:17:52');
insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (3,2,'2020-12-28 12:13:32');

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `curso_id` bigint NOT NULL,
  `post_id` bigint DEFAULT NULL,
  `empresa_id` bigint DEFAULT NULL,
  `post` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_users1_idx` (`user_id`),
  KEY `fk_posts_posts1_idx` (`post_id`),
  KEY `fk_posts_cursos1_idx` (`curso_id`),
  KEY `fk_posts_empresas1_idx` (`empresa_id`),
  CONSTRAINT `fk_posts_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_posts_empresas1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_posts_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_posts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

/*Table structure for table `questionarios` */

DROP TABLE IF EXISTS `questionarios`;

CREATE TABLE `questionarios` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `curso_id` bigint NOT NULL,
  `nome` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionarios_cursos1_idx` (`curso_id`),
  KEY `uq_curso` (`curso_id`),
  CONSTRAINT `fk_questionarios_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `questionarios` */

insert  into `questionarios`(`id`,`curso_id`,`nome`,`created_at`,`updated_at`) values (1,1,'Feedback do curso de segurança básica','2021-01-07 10:27:15',NULL);

/*Table structure for table `respostas` */

DROP TABLE IF EXISTS `respostas`;

CREATE TABLE `respostas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pergunta_id` bigint NOT NULL,
  `resposta` varchar(500) NOT NULL,
  `ordem` char(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_respostas_perguntas1_idx` (`pergunta_id`),
  CONSTRAINT `fk_respostas_perguntas1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `respostas` */

insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (1,1,'Integer elementum, nunc a vulputate euismod, lorem elit porttitor justo, vitae lacinia purus leo ac magna.','A','2021-01-07 10:53:25',NULL);
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (2,1,'Mauris vitae posuere est. Nulla vestibulum elit non nunc venenatis mollis.','B','2021-01-07 10:53:25',NULL);
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (3,1,'Nullam nec scelerisque ex, sed efficitur ex. Ut augue eros, condimentum aliquam maximus posuere, tincidunt at magna.','C','2021-01-07 10:53:25',NULL);
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (4,2,'Donec mi justo, tincidunt at fermentum ut, sodales sit amet velit. ','A','2021-01-07 10:53:25',NULL);
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (5,2,'Aenean sed augue egestas, eleifend nunc ut, mattis magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.','B','2021-01-07 10:53:25',NULL);
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (6,2,'Vivamus pharetra, tortor a maximus semper','C','2021-01-07 10:53:25',NULL);
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (10,3,'Vivamus pharetra, tortor a maximus semper','A','2021-01-07 10:53:25',NULL);
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (11,3,'Aenean sed augue egestas, eleifend nunc ut, mattis magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.','B','2021-01-07 10:53:25',NULL);

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_has_permissions` */

insert  into `role_has_permissions`(`permission_id`,`role_id`) values (1,1);
insert  into `role_has_permissions`(`permission_id`,`role_id`) values (2,1);
insert  into `role_has_permissions`(`permission_id`,`role_id`) values (3,1);
insert  into `role_has_permissions`(`permission_id`,`role_id`) values (4,1);
insert  into `role_has_permissions`(`permission_id`,`role_id`) values (5,1);
insert  into `role_has_permissions`(`permission_id`,`role_id`) values (6,1);
insert  into `role_has_permissions`(`permission_id`,`role_id`) values (7,1);
insert  into `role_has_permissions`(`permission_id`,`role_id`) values (8,1);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'Admin','web','2020-12-17 23:28:18','2020-12-17 23:28:18');
insert  into `roles`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (2,'Aluno','web','2020-12-17 23:28:18',NULL);
insert  into `roles`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (3,'Gestor','web',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `cpf` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `password_changed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_cpf_unique` (`cpf`),
  UNIQUE KEY `users_cpf_email_unique` (`cpf`,`email`),
  KEY `fk_users_empresas1_idx` (`empresa_id`),
  CONSTRAINT `fk_users_empresas1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (1,1,'Wagner (Administrador)','wagnerggg@gmail.com',NULL,'051.666.616-99',NULL,'$2y$10$ui3gXV4uYXg8DEikqOk5e.jZIqTgzvJUFTRqqFtT5kwCu3t7kc7Yu',NULL,NULL,'2021-01-19 11:46:15',1,'2021-01-19 11:46:15');
insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (123,1,'Wagner Gomes Gonçalves','wagner@gmail.com',NULL,'111.111.111-11','(55) 3199-84771','$2y$10$oFOylB.8LFul1rQu9DpWye5NbzIIlgkwY2Zb679WX0lpBShUt/AO2',NULL,'2021-01-19 11:29:16','2021-01-19 11:29:16',1,NULL);

/*Table structure for table `v_historicos` */

DROP TABLE IF EXISTS `v_historicos`;

CREATE TABLE `v_historicos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `curso_id` bigint NOT NULL,
  `aulas_curso` int NOT NULL DEFAULT '0',
  `aulas_concluidas` int NOT NULL DEFAULT '0',
  `certificado` text,
  `pesquisa_respondida` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historicos_users1_idx` (`user_id`),
  KEY `fk_historicos_cursos1_idx` (`curso_id`),
  CONSTRAINT `fk_historicos_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_historicos_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `v_historicos` */

/*Table structure for table `visualizacoes` */

DROP TABLE IF EXISTS `visualizacoes`;

CREATE TABLE `visualizacoes` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `aula_id` bigint NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_visualizacoes_users1_idx` (`user_id`),
  KEY `fk_visualizacoes_aulas1_idx` (`aula_id`),
  CONSTRAINT `fk_visualizacoes_aulas1` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_visualizacoes_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

/*Data for the table `visualizacoes` */

insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (94,1,1,'2021-01-19 11:48:10','2021-01-19 11:48:10');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (95,2,1,'2021-01-19 11:48:17','2021-01-19 11:48:17');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (96,3,1,'2021-01-19 11:48:22','2021-01-19 11:48:22');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (97,4,1,'2021-01-19 11:48:29','2021-01-19 11:48:29');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (98,5,1,'2021-01-19 11:48:35','2021-01-19 11:48:35');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (99,6,1,'2021-01-19 11:48:39','2021-01-19 11:48:39');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (100,7,1,'2021-01-19 11:48:45','2021-01-19 11:48:45');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (101,8,1,'2021-01-19 11:48:50','2021-01-19 11:48:50');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (102,9,1,'2021-01-19 11:48:54','2021-01-19 11:48:54');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (103,10,1,'2021-01-19 11:49:00','2021-01-19 11:49:00');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (104,11,1,'2021-01-19 11:49:08','2021-01-19 11:49:08');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (105,12,1,'2021-01-19 11:49:22','2021-01-19 11:49:22');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (106,13,1,'2021-01-19 11:49:28','2021-01-19 11:49:28');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (107,14,1,'2021-01-19 11:49:33','2021-01-19 11:49:33');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (108,15,1,'2021-01-19 11:49:39','2021-01-19 11:49:39');

/*Table structure for table `v_performance` */

DROP TABLE IF EXISTS `v_performance`;

/*!50001 DROP VIEW IF EXISTS `v_performance` */;
/*!50001 DROP TABLE IF EXISTS `v_performance` */;

/*!50001 CREATE TABLE  `v_performance`(
 `Aluno` varchar(255) ,
 `E-mail` varchar(255) ,
 `CPF` char(14) ,
 `Telefone` varchar(15) ,
 `Empresa` varchar(255) ,
 `Plano` varchar(255) ,
 `Curso` varchar(45) ,
 `Aulas do curso` bigint ,
 `Aulas assistidas` bigint ,
 `Posts realizadoss` bigint ,
 `Feedback realizado` varchar(3) ,
 `Certificado emitido` varchar(3) ,
 `Data limite curso` varchar(10) ,
 `Data conclusão` varchar(10) ,
 `user_id` bigint unsigned ,
 `empresa_id` bigint ,
 `plano_id` bigint ,
 `curso_id` bigint 
)*/;

/*View structure for view v_performance */

/*!50001 DROP TABLE IF EXISTS `v_performance` */;
/*!50001 DROP VIEW IF EXISTS `v_performance` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_performance` AS select `u`.`name` AS `Aluno`,`u`.`email` AS `E-mail`,`u`.`cpf` AS `CPF`,`u`.`phone` AS `Telefone`,`e`.`nome` AS `Empresa`,`p`.`nome` AS `Plano`,`c`.`nome` AS `Curso`,(select count(`a1`.`id`) from (`aulas` `a1` join `modulos` `m1` on((`m1`.`id` = `a1`.`modulo_id`))) where (`m1`.`curso_id` = `c`.`id`)) AS `Aulas do curso`,(select count(distinct `v1`.`aula_id`) from ((`visualizacoes` `v1` join `aulas` `a1` on((`a1`.`id` = `v1`.`aula_id`))) join `modulos` `m1` on((`m1`.`id` = `a1`.`modulo_id`))) where ((`m1`.`curso_id` = `c`.`id`) and (`v1`.`user_id` = `u`.`id`))) AS `Aulas assistidas`,(select count(`p1`.`id`) from `posts` `p1` where ((`p1`.`user_id` = `u`.`id`) and (`p1`.`curso_id` = `c`.`id`))) AS `Posts realizadoss`,(select if((count(`f1`.`id`) > 0),'SIM','NÃO') from `feedbacks` `f1` where ((`f1`.`user_id` = `u`.`id`) and (`f1`.`curso_id` = `c`.`id`))) AS `Feedback realizado`,(select if((count(`c1`.`id`) > 0),'SIM','NÃO') from `certificados` `c1` where ((`c1`.`user_id` = `u`.`id`) and (`c1`.`curso_id` = `c`.`id`))) AS `Certificado emitido`,date_format(`m`.`data_limite`,'%d/%m/%Y') AS `Data limite curso`,date_format(`m`.`data_conclusao`,'%d/%m/%Y') AS `Data conclusão`,`m`.`user_id` AS `user_id`,`m`.`empresa_id` AS `empresa_id`,`m`.`plano_id` AS `plano_id`,`m`.`curso_id` AS `curso_id` from ((((`users` `u` join `matriculas` `m` on((`m`.`user_id` = `u`.`id`))) join `cursos` `c` on((`c`.`id` = `m`.`curso_id`))) join `empresas` `e` on((`e`.`id` = `m`.`empresa_id`))) join `planos` `p` on((`p`.`id` = `m`.`plano_id`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
