/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.2.33-MariaDB-log : Database - vitrineatma
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`vitrineatma` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `vitrineatma`;

/*Table structure for table `acessos` */

DROP TABLE IF EXISTS `acessos`;

CREATE TABLE `acessos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `material_id` bigint(20) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_downloads_materiais1_idx` (`material_id`),
  KEY `fk_downloads_users1_idx` (`user_id`),
  CONSTRAINT `fk_downloads_materiais1` FOREIGN KEY (`material_id`) REFERENCES `materiais` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_downloads_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `acessos` */

/*Table structure for table `aulas` */

DROP TABLE IF EXISTS `aulas`;

CREATE TABLE `aulas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `modulo_id` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `carga_horaria` double DEFAULT NULL,
  `link` varchar(500) NOT NULL,
  `ordem` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_aulas_modulos1_idx` (`modulo_id`),
  CONSTRAINT `fk_aulas_modulos1` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `aulas` */

insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (17,8,'Cuidados com o corpo durante a gestação','<p>Aqui entram os t&oacute;picos a serem tratados na aula em quest&atilde;o</p>',37,'YTrKiSZNzRM',1,'2021-01-05 15:37:31','2021-01-18 10:35:38',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (18,8,'Parto - Plano de parto','<p>Aqui entra a descri&ccedil;&atilde;o da aula 2</p>',24,'YTrKiSZNzRM',2,'2021-01-06 23:46:25','2021-01-18 10:36:38',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (19,8,'A importância de formação de uma rede de apoio e como eles podem te ajudar','<p>Aqui entra a descri&ccedil;&atilde;o da aula 3</p>',28,'YTrKiSZNzRM',3,'2021-01-06 23:48:04','2021-01-18 10:37:49',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (20,8,'O pai - Companheiro','<p>Aqui entra a descri&ccedil;&atilde;o da aula 4</p>',40,'YTrKiSZNzRM',4,'2021-01-06 23:49:28','2021-01-18 10:41:01',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (21,9,'Os desafios da fase do puerpério - Exterogestação','<p>teste</p>',30,'YTrKiSZNzRM',5,'2021-01-06 23:50:59','2021-01-18 10:43:59',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (22,9,'Babyblues','<p>Aqui entra a descri&ccedil;&atilde;o da aula 6</p>',28,'YTrKiSZNzRM',6,'2021-01-06 23:52:12','2021-01-18 10:45:12',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (23,9,'A primeira hora de vida','<p>Aqui entra a descri&ccedil;&atilde;o da aula 1</p>',20,'YTrKiSZNzRM',7,'2021-01-06 23:57:01','2021-01-18 10:45:48',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (24,9,'Amamentação','<p>Aqui entra a descri&ccedil;&atilde;o da aula 2</p>',45,'YTrKiSZNzRM',8,'2021-01-06 23:57:49','2021-01-18 10:46:24',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (25,9,'Cuidados com o bebê','<p>Aqui entra a descri&ccedil;&atilde;o da aula 3</p>',20,'<iframe class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/YTrKiSZNzRM?controls=1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>',9,'2021-01-06 23:58:35','2021-01-18 10:46:49',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (26,10,'Primeiros 1000 dias','<p>Aqui entra a descri&ccedil;&atilde;o da aula 4</p>',30,'YTrKiSZNzRM',10,'2021-01-06 23:59:26','2021-01-18 10:48:52',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (27,10,'A construção do vínculo seguro','<p>Aqui entra a descri&ccedil;&atilde;o da aula 5</p>',38,'jvX9eozwbtU',11,'2021-01-07 00:00:24','2021-01-18 10:49:30',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (28,10,'Mantendo a amamentação após o retorno','<p>Aqui entra a descri&ccedil;&atilde;o da aula 1</p>',25,'YTrKiSZNzRM',12,'2021-01-07 00:01:20','2021-01-18 10:50:14',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (29,10,'Lidando com a culpa e organizando o retorno ao trabalho',NULL,50,'YTrKiSZNzRM',13,'2021-01-07 00:02:38','2021-01-18 10:51:53',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (35,12,'Bônus 1: Nome da aula','<p>Nome do aula bonus 1</p>',2,'jvX9eozwbtU',14,'2021-01-18 21:38:18','2021-01-18 21:38:18',1);
insert  into `aulas`(`id`,`modulo_id`,`titulo`,`descricao`,`carga_horaria`,`link`,`ordem`,`created_at`,`updated_at`,`is_active`) values (36,12,'Bônus 2: Nome da aula','<p>Nome aula 2 b&ocirc;nus</p>',45,'jvX9eozwbtU',15,'2021-01-18 21:39:15','2021-01-18 21:39:15',1);

/*Table structure for table `certificados` */

DROP TABLE IF EXISTS `certificados`;

CREATE TABLE `certificados` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_certificados_users1_idx` (`user_id`),
  KEY `fk_certificados_cursos1_idx` (`curso_id`),
  CONSTRAINT `fk_certificados_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_certificados_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `certificados` */

insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (2,96,3,'2021-01-05 16:26:15','2021-01-05 16:26:15');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (3,96,3,'2021-01-05 16:26:16','2021-01-05 16:26:16');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (4,96,3,'2021-01-05 16:26:30','2021-01-05 16:26:30');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (6,115,3,'2021-01-08 11:43:22','2021-01-08 11:43:22');
insert  into `certificados`(`id`,`user_id`,`curso_id`,`created_at`,`updated_at`) values (7,119,3,'2021-01-08 15:22:41','2021-01-08 15:22:41');

/*Table structure for table `cursos` */

DROP TABLE IF EXISTS `cursos`;

CREATE TABLE `cursos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `descricao` text DEFAULT NULL,
  `certificado` text DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `base_certificado` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `mensagem_conclusao` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `cursos` */

insert  into `cursos`(`id`,`nome`,`descricao`,`certificado`,`banner`,`base_certificado`,`is_active`,`mensagem_conclusao`) values (3,'Programa Corporativo Gestantes e Futuros Pais',NULL,NULL,'cursos/banner-curso.png','base-certificado.png',1,'<strong>Você acabou de finalizar o programa corporativo para gestantes e futuros pais.</strong>\r\n<br>\r\nObrigado por ter participado! \r\n<br>\r\nEsperamos ter contribuído para que sua experiência com a chegada do filho(a) tenha sido mais leve, segura e respeitosa.\r\n');

/*Table structure for table `email` */

DROP TABLE IF EXISTS `email`;

CREATE TABLE `email` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nome_remetente` varchar(255) DEFAULT NULL,
  `email_remetente` varchar(255) NOT NULL,
  `nome_destinatario` varchar(255) DEFAULT NULL,
  `email_destinatario` varchar(255) NOT NULL,
  `corpo` text NOT NULL,
  `enviado` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_email_users1_idx` (`user_id`),
  CONSTRAINT `fk_email_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `email` */

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

CREATE TABLE `empresas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `empresas` */

insert  into `empresas`(`id`,`nome`,`descricao`,`created_at`,`updated_at`,`is_active`) values (4,'Atma Interativa','<p>Campo destinado a observa&ccedil;&otilde;es sobre a contrata&ccedil;&atilde;o</p>','2021-01-05 15:22:14','2021-01-05 15:22:54',1);
insert  into `empresas`(`id`,`nome`,`descricao`,`created_at`,`updated_at`,`is_active`) values (5,'FIAT','<p>Destalhes da contrata&ccedil;&atilde;o</p>','2021-01-06 22:43:49','2021-01-07 18:05:22',1);
insert  into `empresas`(`id`,`nome`,`descricao`,`created_at`,`updated_at`,`is_active`) values (6,'Santander','<p>Descri&ccedil;&atilde;o</p>','2021-01-07 18:17:24','2021-01-07 18:17:24',1);
insert  into `empresas`(`id`,`nome`,`descricao`,`created_at`,`updated_at`,`is_active`) values (7,'Aldeia Consultoria','<p>Observa&ccedil;&otilde;es sobre o processo comercial e contatos da empresa</p>','2021-01-07 21:55:41','2021-01-07 21:55:51',1);
insert  into `empresas`(`id`,`nome`,`descricao`,`created_at`,`updated_at`,`is_active`) values (8,'Lojas Americanas','<p>Data da contrata&ccedil;&atilde;o: 1y1t1tyq</p>\r\n<p>Nome do contato: hgagavbxjdjucbdjdbd</p>','2021-01-08 14:43:00','2021-01-08 14:43:00',1);

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `feedbacks` */

DROP TABLE IF EXISTS `feedbacks`;

CREATE TABLE `feedbacks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `pergunta_id` bigint(20) NOT NULL,
  `resposta_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_curso_pergunta` (`curso_id`,`pergunta_id`,`user_id`),
  KEY `fk_users_has_respostas_respostas1_idx` (`resposta_id`),
  KEY `fk_users_has_respostas_users1_idx` (`user_id`),
  KEY `fk_feedbacks_cursos1_idx` (`curso_id`),
  KEY `fk_feedbacks_perguntas1_idx` (`pergunta_id`),
  CONSTRAINT `fk_feedbacks_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_feedbacks_perguntas1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_respostas_respostas1` FOREIGN KEY (`resposta_id`) REFERENCES `respostas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_respostas_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `feedbacks` */

/*Table structure for table `materiais` */

DROP TABLE IF EXISTS `materiais`;

CREATE TABLE `materiais` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aula_id` bigint(20) DEFAULT NULL,
  `modulo_id` bigint(20) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_table1_aulas1_idx` (`aula_id`),
  KEY `fk_materiais_modulos1_idx` (`modulo_id`),
  CONSTRAINT `fk_materiais_modulos1` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_aulas1` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `materiais` */

/*Table structure for table `matriculas` */

DROP TABLE IF EXISTS `matriculas`;

CREATE TABLE `matriculas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `empresa_id` bigint(20) NOT NULL,
  `plano_id` bigint(20) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `tempo_acesso` int(11) DEFAULT NULL,
  `data_limite` timestamp NULL DEFAULT NULL,
  `data_conclusao` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_matricula` (`user_id`,`curso_id`,`empresa_id`),
  KEY `fk_matriculas_users1_idx` (`user_id`),
  KEY `fk_matriculas_cursos1_idx` (`curso_id`),
  KEY `fk_matriculas_empresas1_idx` (`empresa_id`),
  KEY `fk_matriculas_planos1_idx` (`plano_id`),
  KEY `ix_data_limite` (`data_limite`),
  CONSTRAINT `fk_matriculas_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_matriculas_empresas1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_matriculas_planos1` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_matriculas_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

/*Data for the table `matriculas` */

insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (68,96,3,4,7,1,270,'2021-10-02 15:51:35','2021-01-05 16:25:44','2021-01-05 15:51:35','2021-01-05 16:25:44');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (81,115,3,6,9,1,270,'2021-10-05 11:37:22','2021-01-08 11:43:06','2021-01-08 11:37:22','2021-01-08 11:43:06');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (83,117,3,7,10,1,270,'2021-10-05 14:32:28',NULL,'2021-01-08 14:32:28','2021-01-08 14:32:28');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (84,118,3,8,10,1,270,'2021-10-05 14:53:22',NULL,'2021-01-08 14:53:22','2021-01-08 14:53:22');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (85,115,3,8,10,1,270,'2021-10-05 14:57:25',NULL,'2021-01-08 14:57:25','2021-01-08 14:57:25');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (86,119,3,8,10,1,270,'2021-10-05 15:01:35','2021-01-08 15:21:56','2021-01-08 15:01:35','2021-01-08 15:21:56');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (87,120,3,8,10,1,270,'2021-10-05 15:08:35',NULL,'2021-01-08 15:08:35','2021-01-08 15:08:35');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (88,121,3,8,10,1,270,'2021-10-05 15:08:41',NULL,'2021-01-08 15:08:41','2021-01-08 15:08:41');
insert  into `matriculas`(`id`,`user_id`,`curso_id`,`empresa_id`,`plano_id`,`is_active`,`tempo_acesso`,`data_limite`,`data_conclusao`,`created_at`,`updated_at`) values (89,1,3,8,10,1,270,'2021-10-15 21:05:29',NULL,'2021-01-18 21:05:29','2021-01-18 21:05:29');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
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
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',1);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',84);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',90);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',91);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',92);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',93);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',94);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',96);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\User',117);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',1);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',6);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',11);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',12);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',14);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',15);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',16);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',17);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',18);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',20);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',32);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',33);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',35);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',36);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',37);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',38);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',39);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',40);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',41);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',42);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',43);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',44);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',45);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',46);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',47);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',48);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',49);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',50);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',51);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',52);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',53);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',54);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',55);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',56);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',57);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',58);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',59);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',60);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',61);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',62);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',63);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',64);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',80);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',81);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',96);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',102);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',103);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',109);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',115);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',117);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',118);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',119);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',120);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (2,'App\\Models\\User',121);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (3,'App\\Models\\User',83);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (3,'App\\Models\\User',84);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (3,'App\\Models\\User',89);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (3,'App\\Models\\User',95);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (3,'App\\Models\\User',109);
insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values (3,'App\\Models\\User',118);

/*Table structure for table `modulos` */

DROP TABLE IF EXISTS `modulos`;

CREATE TABLE `modulos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `curso_id` bigint(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `modulo_padrao` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_modulos_cursos1_idx` (`curso_id`),
  CONSTRAINT `fk_modulos_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `modulos` */

insert  into `modulos`(`id`,`curso_id`,`nome`,`descricao`,`ordem`,`created_at`,`updated_at`,`modulo_padrao`) values (8,3,'Estamos grávidos','<p>A gesta&ccedil;&atilde;o &eacute; um momento &uacute;nico, repleto de expectativas, medos e d&uacute;vidas. Voc&ecirc; e sua fam&iacute;lia ter&atilde;o acesso &agrave; informa&ccedil;&otilde;es sobre as altera&ccedil;&otilde;es do corpo gestante, os cuidados e atividades f&iacute;sicas, o parto, como se preparar e definir sua rede de apoio. Com este m&oacute;dulo, queremos apoiar e estar ao seu lado para que voc&ecirc; vivencie todas as transforma&ccedil;&otilde;es de maneira segura e saud&aacute;vel.</p>',1,'2021-01-05 15:29:04','2021-01-18 21:14:57',1);
insert  into `modulos`(`id`,`curso_id`,`nome`,`descricao`,`ordem`,`created_at`,`updated_at`,`modulo_padrao`) values (9,3,'Nasceu, e agora?','<p>O nascimento &eacute; um encontro muito esperado, especial e acompanha muitas transforma&ccedil;&otilde;es emocionais e hormonais. Voc&ecirc; e sua fam&iacute;lia ter&atilde;o acesso &agrave; informa&ccedil;&otilde;es sobre a primeira hora de vida, os desafios do puerp&eacute;rio, a amamenta&ccedil;&atilde;o e os primeiros cuidados com o beb&ecirc;. Com este m&oacute;dulo, queremos que voc&ecirc; se sinta segura e acolhida para seguir e vivenciar esta nova din&acirc;mica familiar, encontrando a sua pr&oacute;pria maneira de maternar e paternar.</p>',2,'2021-01-06 23:19:36','2021-01-18 21:16:51',1);
insert  into `modulos`(`id`,`curso_id`,`nome`,`descricao`,`ordem`,`created_at`,`updated_at`,`modulo_padrao`) values (10,3,'Parentalidade e a volta ao trabalho','<p>A parentalidade &eacute; uma constru&ccedil;&atilde;o intensa e real. Voc&ecirc; e sua fam&iacute;lia ter&atilde;o acesso &agrave; informa&ccedil;&otilde;es sobre os primeiros 1000 dias, a cria&ccedil;&atilde;o com apego, a volta ao trabalho e como conciliar carreira e a chegada dos filhos. Com este m&oacute;dulo, queremos desconstruir viesses e culpas, apoiando e direcionando voc&ecirc; para uma parentalidade poss&iacute;vel, respeitosa e amorosa.</p>',3,'2021-01-06 23:21:22','2021-01-18 21:18:20',1);
insert  into `modulos`(`id`,`curso_id`,`nome`,`descricao`,`ordem`,`created_at`,`updated_at`,`modulo_padrao`) values (12,3,'Bônus','<p>Aproveitem os b&ocirc;nus&nbsp;</p>',4,'2021-01-18 21:36:20','2021-01-18 21:36:20',1);

/*Table structure for table `parametros` */

DROP TABLE IF EXISTS `parametros`;

CREATE TABLE `parametros` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `questionario_id` bigint(20) NOT NULL,
  `pergunta` varchar(500) NOT NULL,
  `ordem` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_perguntas_questionarios1_idx` (`questionario_id`),
  CONSTRAINT `fk_perguntas_questionarios1` FOREIGN KEY (`questionario_id`) REFERENCES `questionarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `perguntas` */

insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (8,5,'1- Qual o seu gênero?',1,1,'2021-01-18 11:22:42','2021-01-18 11:30:31');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (9,5,'2- Quantos filhos você tem (já nascidos)?',2,1,'2021-01-18 11:26:17','2021-01-18 11:26:17');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (11,5,'3- Qual é o seu momento atual:',3,1,'2021-01-18 11:30:13','2021-01-18 11:30:13');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (12,5,'4- O Programa Corporativo Gestantes e Futuros Pais atendeu às suas expectativas?',4,1,'2021-01-18 11:33:32','2021-01-18 11:35:27');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (13,5,'5- O formato utilizado para os materiais de apoio foram adequados?',5,1,'2021-01-18 11:36:35','2021-01-18 11:36:35');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (14,5,'6- O conteúdo trabalhado nos materiais de apoio atendeu às suas expectativas?',6,1,'2021-01-18 11:38:59','2021-01-18 11:38:59');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (15,5,'7- Sobre as videoaulas: O formato utilizado foi adequado?',7,1,'2021-01-18 15:27:24','2021-01-18 15:27:24');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (16,5,'8- Sobre as videoaulas: A duração foi suficiente?',8,1,'2021-01-18 15:29:47','2021-01-18 15:29:47');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (17,5,'9- Sobre as videoaulas: O conteúdo atendeu a sua expectativa?',9,1,'2021-01-18 15:31:41','2021-01-18 15:31:41');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (18,5,'10- Sobre o módulo I, coloque uma nota de 0 à 7 (sendo 0 péssimo e 7 ótimo):',10,1,'2021-01-18 15:33:58','2021-01-18 15:33:58');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (19,5,'11- Sobre o módulo II, coloque uma nota de 0 à 7 (sendo 0 péssimo e 7 ótimo):',11,1,'2021-01-18 15:37:36','2021-01-18 15:37:36');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (20,5,'12- Sobre o módulo III, coloque uma nota de 0 à 7 (sendo 0 péssimo e 7 ótimo):',12,1,'2021-01-18 15:42:03','2021-01-18 15:42:03');
insert  into `perguntas`(`id`,`questionario_id`,`pergunta`,`ordem`,`is_active`,`created_at`,`updated_at`) values (21,5,'13- Você recomendaria este Programa para outras gestantes e futuros pais?',13,1,'2021-01-18 15:48:40','2021-01-18 15:48:40');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `valor` double(10,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `planos` */

insert  into `planos`(`id`,`nome`,`descricao`,`valor`,`is_active`,`created_at`,`updated_at`) values (7,'Plano Bronze','<p>teste de descri&ccedil;&atilde;o</p>',0.00,1,'2021-01-05 15:18:59','2021-01-05 15:18:59');
insert  into `planos`(`id`,`nome`,`descricao`,`valor`,`is_active`,`created_at`,`updated_at`) values (8,'Plano prata','<p>teste descri&ccedil;&atilde;o plano prata</p>',0.00,1,'2021-01-05 15:19:32','2021-01-05 15:19:32');
insert  into `planos`(`id`,`nome`,`descricao`,`valor`,`is_active`,`created_at`,`updated_at`) values (9,'Plano ouro','<p>teste de dexcri&ccedil;&atilde;o plano ouro</p>',0.00,1,'2021-01-05 15:19:59','2021-01-05 15:19:59');
insert  into `planos`(`id`,`nome`,`descricao`,`valor`,`is_active`,`created_at`,`updated_at`) values (10,'Plano Super Plus','<p>Este &oacute; super plano</p>',0.00,1,'2021-01-07 21:54:47','2021-01-07 21:54:47');

/*Table structure for table `planos_has_cursos` */

DROP TABLE IF EXISTS `planos_has_cursos`;

CREATE TABLE `planos_has_cursos` (
  `plano_id` bigint(20) NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `usuarios` int(11) NOT NULL DEFAULT 0,
  `tempo_acesso` int(11) NOT NULL,
  PRIMARY KEY (`plano_id`,`curso_id`),
  KEY `fk_planos_has_cursos_cursos1_idx` (`curso_id`),
  KEY `fk_planos_has_cursos_planos1_idx` (`plano_id`),
  CONSTRAINT `fk_planos_has_cursos_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_planos_has_cursos_planos1` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `planos_has_cursos` */

insert  into `planos_has_cursos`(`plano_id`,`curso_id`,`usuarios`,`tempo_acesso`) values (7,3,50,270);
insert  into `planos_has_cursos`(`plano_id`,`curso_id`,`usuarios`,`tempo_acesso`) values (8,3,100,270);
insert  into `planos_has_cursos`(`plano_id`,`curso_id`,`usuarios`,`tempo_acesso`) values (9,3,200,270);
insert  into `planos_has_cursos`(`plano_id`,`curso_id`,`usuarios`,`tempo_acesso`) values (10,3,500,270);

/*Table structure for table `planos_has_empresas` */

DROP TABLE IF EXISTS `planos_has_empresas`;

CREATE TABLE `planos_has_empresas` (
  `plano_id` bigint(20) NOT NULL,
  `empresa_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`plano_id`,`empresa_id`),
  KEY `fk_planos_has_empresas_empresas1_idx` (`empresa_id`),
  KEY `fk_planos_has_empresas_planos1_idx` (`plano_id`),
  CONSTRAINT `fk_planos_has_empresas_empresas1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_planos_has_empresas_planos1` FOREIGN KEY (`plano_id`) REFERENCES `planos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `planos_has_empresas` */

insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (7,4,'2021-01-05 15:22:14');
insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (9,5,'2021-01-06 22:43:48');
insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (9,6,'2021-01-07 18:17:24');
insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (10,7,'2021-01-07 21:55:41');
insert  into `planos_has_empresas`(`plano_id`,`empresa_id`,`created_at`) values (10,8,'2021-01-08 14:42:57');

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `empresa_id` bigint(20) DEFAULT NULL,
  `post` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

insert  into `posts`(`id`,`user_id`,`curso_id`,`post_id`,`empresa_id`,`post`,`created_at`,`is_active`,`updated_at`) values (24,96,3,NULL,NULL,'Primeiro post do fórum.','2021-01-05 15:58:36',1,'2021-01-05 15:58:36');
insert  into `posts`(`id`,`user_id`,`curso_id`,`post_id`,`empresa_id`,`post`,`created_at`,`is_active`,`updated_at`) values (25,96,3,24,NULL,'bacana... parabens pelo ppst','2021-01-05 15:59:23',1,'2021-01-05 15:59:23');
insert  into `posts`(`id`,`user_id`,`curso_id`,`post_id`,`empresa_id`,`post`,`created_at`,`is_active`,`updated_at`) values (26,96,3,24,NULL,'Ok','2021-01-05 15:59:29',1,'2021-01-05 15:59:29');
insert  into `posts`(`id`,`user_id`,`curso_id`,`post_id`,`empresa_id`,`post`,`created_at`,`is_active`,`updated_at`) values (30,119,3,24,NULL,'concordo plenamente','2021-01-08 15:38:17',1,'2021-01-08 15:38:17');
insert  into `posts`(`id`,`user_id`,`curso_id`,`post_id`,`empresa_id`,`post`,`created_at`,`is_active`,`updated_at`) values (31,119,3,NULL,NULL,'Que bacana este forum','2021-01-08 15:38:33',1,'2021-01-08 15:38:33');
insert  into `posts`(`id`,`user_id`,`curso_id`,`post_id`,`empresa_id`,`post`,`created_at`,`is_active`,`updated_at`) values (32,119,3,31,NULL,'Complementando','2021-01-08 15:38:48',1,'2021-01-08 15:38:48');
insert  into `posts`(`id`,`user_id`,`curso_id`,`post_id`,`empresa_id`,`post`,`created_at`,`is_active`,`updated_at`) values (33,96,3,31,4,'byxuhsuhijdirjirjir','2021-01-18 16:19:01',1,'2021-01-18 16:19:01');

/*Table structure for table `questionarios` */

DROP TABLE IF EXISTS `questionarios`;

CREATE TABLE `questionarios` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `curso_id` bigint(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionarios_cursos1_idx` (`curso_id`),
  KEY `uq_curso` (`curso_id`),
  CONSTRAINT `fk_questionarios_cursos1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `questionarios` */

insert  into `questionarios`(`id`,`curso_id`,`nome`,`created_at`,`updated_at`) values (5,3,'Pesquisa de Satisfação Programa Corporativo Gestantes e Futuros Pais','2021-01-07 22:43:37','2021-01-18 11:19:11');

/*Table structure for table `respostas` */

DROP TABLE IF EXISTS `respostas`;

CREATE TABLE `respostas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pergunta_id` bigint(20) NOT NULL,
  `resposta` varchar(500) NOT NULL,
  `ordem` char(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_respostas_perguntas1_idx` (`pergunta_id`),
  CONSTRAINT `fk_respostas_perguntas1` FOREIGN KEY (`pergunta_id`) REFERENCES `perguntas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

/*Data for the table `respostas` */

insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (22,8,'Feminino','A','2021-01-18 11:23:44','2021-01-18 11:23:44');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (23,8,'Masculino','B','2021-01-18 11:24:14','2021-01-18 11:24:14');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (24,8,'Prefiro não responder','C','2021-01-18 11:24:56','2021-01-18 11:24:56');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (25,8,'Outro','D','2021-01-18 11:25:24','2021-01-18 11:25:24');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (26,9,'0','A','2021-01-18 11:27:40','2021-01-18 11:27:40');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (27,9,'1','B','2021-01-18 11:28:04','2021-01-18 11:28:04');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (28,9,'2','C','2021-01-18 11:28:32','2021-01-18 11:28:32');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (29,9,'3','D','2021-01-18 11:29:03','2021-01-18 11:29:03');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (30,9,'Mais de 3','E','2021-01-18 11:29:28','2021-01-18 11:29:28');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (31,11,'Esperando um bebê (primeiro trimestre)','A','2021-01-18 11:31:11','2021-01-18 11:31:11');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (32,11,'Esperando um bebê (segundo trimestre)','B','2021-01-18 11:31:45','2021-01-18 11:31:45');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (33,11,'Esperando um bebê (terceiro trimestre)','C','2021-01-18 11:32:07','2021-01-18 11:32:07');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (34,11,'Estou em processo de adoção','D','2021-01-18 11:32:42','2021-01-18 11:32:42');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (35,11,'Outro','E','2021-01-18 11:33:06','2021-01-18 11:33:06');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (36,12,'Sim, mais do que eu esperava.','A','2021-01-18 11:34:01','2021-01-18 11:34:01');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (37,12,'Sim, atendeu à minha expectativa.','B','2021-01-18 11:34:39','2021-01-18 11:34:39');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (38,12,'Não atendeu à minha expectativa.','C','2021-01-18 11:35:06','2021-01-18 11:35:06');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (39,13,'Sim, com certeza','A','2021-01-18 11:37:12','2021-01-18 11:37:12');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (40,13,'Sim, em partes','B','2021-01-18 11:37:36','2021-01-18 11:37:36');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (41,13,'Não','C','2021-01-18 11:37:56','2021-01-18 11:37:56');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (42,14,'Sim, com certeza','A','2021-01-18 11:40:30','2021-01-18 11:40:30');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (43,14,'Sim, em partes','B','2021-01-18 11:40:54','2021-01-18 11:40:54');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (44,14,'Não','C','2021-01-18 11:41:17','2021-01-18 11:41:17');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (45,15,'Sim, com certeza','A','2021-01-18 15:27:57','2021-01-18 15:27:57');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (46,15,'Sim, em partes','B','2021-01-18 15:28:41','2021-01-18 15:28:41');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (47,15,'Não','C','2021-01-18 15:29:01','2021-01-18 15:29:01');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (48,16,'Sim, com certeza','A','2021-01-18 15:30:21','2021-01-18 15:30:21');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (49,16,'Sim, em partes','B','2021-01-18 15:30:41','2021-01-18 15:30:41');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (50,16,'Não','C','2021-01-18 15:31:02','2021-01-18 15:31:02');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (51,17,'Sim, com certeza','A','2021-01-18 15:32:13','2021-01-18 15:32:13');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (52,17,'Sim, em partes','B','2021-01-18 15:32:37','2021-01-18 15:32:37');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (53,17,'Não','C','2021-01-18 15:33:06','2021-01-18 15:33:06');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (54,18,'0','A','2021-01-18 15:34:34','2021-01-18 15:34:34');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (55,18,'1','B','2021-01-18 15:34:52','2021-01-18 15:34:52');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (56,18,'2','C','2021-01-18 15:35:12','2021-01-18 15:35:12');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (57,18,'3','D','2021-01-18 15:35:32','2021-01-18 15:35:32');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (58,18,'4','E','2021-01-18 15:35:53','2021-01-18 15:35:53');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (59,18,'5','F','2021-01-18 15:36:16','2021-01-18 15:36:16');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (60,18,'6','G','2021-01-18 15:36:37','2021-01-18 15:36:37');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (61,18,'7','H','2021-01-18 15:36:56','2021-01-18 15:36:56');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (62,19,'0','A','2021-01-18 15:38:01','2021-01-18 15:39:11');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (63,19,'1','B','2021-01-18 15:38:44','2021-01-18 15:38:44');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (64,19,'2','C','2021-01-18 15:39:33','2021-01-18 15:39:33');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (65,19,'3','D','2021-01-18 15:39:53','2021-01-18 15:39:53');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (66,19,'4','E','2021-01-18 15:40:17','2021-01-18 15:40:17');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (67,19,'5','F','2021-01-18 15:40:37','2021-01-18 15:40:37');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (68,19,'6','G','2021-01-18 15:40:55','2021-01-18 15:40:55');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (69,19,'7','H','2021-01-18 15:41:24','2021-01-18 15:41:24');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (70,20,'0','A','2021-01-18 15:42:33','2021-01-18 15:42:33');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (71,20,'1','B','2021-01-18 15:42:57','2021-01-18 15:42:57');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (72,20,'2','C','2021-01-18 15:43:22','2021-01-18 15:43:22');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (73,20,'3','D','2021-01-18 15:43:55','2021-01-18 15:43:55');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (74,20,'4','E','2021-01-18 15:44:21','2021-01-18 15:44:21');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (75,20,'5','F','2021-01-18 15:45:45','2021-01-18 15:45:45');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (76,20,'6','G','2021-01-18 15:46:06','2021-01-18 15:46:06');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (77,20,'7','E','2021-01-18 15:46:41','2021-01-18 15:46:41');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (78,21,'Sim, com certeza','A','2021-01-18 15:49:58','2021-01-18 15:49:58');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (79,21,'Sim, talvez','B','2021-01-18 15:50:25','2021-01-18 15:50:25');
insert  into `respostas`(`id`,`pergunta_id`,`resposta`,`ordem`,`created_at`,`updated_at`) values (80,21,'Não','C','2021-01-18 15:50:51','2021-01-18 15:50:51');

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `cpf` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_cpf_unique` (`cpf`),
  UNIQUE KEY `users_cpf_email_unique` (`cpf`,`email`),
  KEY `fk_users_empresas1_idx` (`empresa_id`),
  CONSTRAINT `fk_users_empresas1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (1,8,'Wagner (Administrador)','wagnerggg@gmail.com',NULL,'051.666.616-99','(31) 9825-86122','$2y$10$3dcJVpWR4BEbNHUfzHxd3ODyAqTCRnCIxhQvnavDy6FSEU9CiVUF6','7WJBlXyDNRJBwEHc0CBBh3f4sihpHtUJ5rwlhbio4iq7KvbSAUqZ1OJe3Fj7','2020-12-17 23:28:18','2021-01-18 21:04:54',1,'2020-12-29 00:05:48');
insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (96,4,'Alexandre Atma','alexandre@atmainterativa.com.br',NULL,'047.993.476-24','(31) 9870-25257','$2y$10$tE/2JNjzmfEH2z5qpAk71.KL688V.LjBhxtTlSI.n2QbpcTk2lBp2','x14VqvATVCryjnuj5IFDZFNGSbybvLyfWfcGEyvA4zv7cdk2g9dtxS6rtUbr','2021-01-05 15:11:52','2021-01-06 22:04:55',1,'2021-01-05 15:14:42');
insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (115,6,'Aluno Blaster','financeiro@atmainterativa.com.br',NULL,'222.222.222-22','(22) 22222-2222','$2y$10$k79PjRwelB1KCj4.oeM9ne3qXP/cm45Qa75RaNFdRGITRzPq6BMlu',NULL,'2021-01-08 11:37:22','2021-01-08 11:38:24',1,'2021-01-08 11:38:24');
insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (117,7,'Karina Lara','karina.lara@aldeiaconsultoria.com.br',NULL,'047.689.426-36','(31) 99106-6565','$2y$10$yD/N1SEfvRtDjHnAv.4shOEHgxvhzzoI60mBHTpG4BaDH2PIUleJ6','Ttt3ih6URB2oMGq4a3iMfjmaHqfKibkiK8StrZ3mcfZVyl3LePEO9zuTOGVH','2021-01-08 14:32:28','2021-01-08 14:35:07',1,'2021-01-08 14:35:07');
insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (118,8,'RH Lojas Americanas','alex80rp@gmail.com',NULL,'888.888.888-88','(31) 3887-77888','$2y$10$S6pFyARIyO5P4Y6iYg8THudjsWxAIhCVGcoxcVH/cLR41t2W9C262',NULL,'2021-01-08 14:46:03','2021-01-08 14:56:03',1,'2021-01-08 14:48:51');
insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (119,8,'Aluno lojas Americanas 2','contato@atmainterativa.com.br',NULL,'000.000.000-00','(11) 1111-11111','$2y$10$JuqMb7OZgkOXhZZY43KhVulzZ9UwFcSYdVcQErX2l95aRhL0PZuue',NULL,'2021-01-08 15:01:35','2021-01-08 15:02:35',1,'2021-01-08 15:02:35');
insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (120,8,'Teste A','a@atma.com.br',NULL,'866.545.895-54','(55) 3199-84771','$2y$10$rsEG3dZ3nPNYWSYpWf2skOdOwh8zQY9vyoJglojgv7jMCWUReJfF.',NULL,'2021-01-08 15:08:35','2021-01-08 15:08:35',1,NULL);
insert  into `users`(`id`,`empresa_id`,`name`,`email`,`email_verified_at`,`cpf`,`phone`,`password`,`remember_token`,`created_at`,`updated_at`,`is_active`,`password_changed_at`) values (121,8,'Teste B','b@atma.com.br',NULL,'126.545.995-89','(31) 9999-99999','$2y$10$ju/r8v2gATof9LpVKocxDuOdIzeX7gmYn.1gJv7RJjMHv4S4htTma',NULL,'2021-01-08 15:08:41','2021-01-08 15:08:41',1,NULL);

/*Table structure for table `v_historicos` */

DROP TABLE IF EXISTS `v_historicos`;

CREATE TABLE `v_historicos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `aulas_curso` int(11) NOT NULL DEFAULT 0,
  `aulas_concluidas` int(11) NOT NULL DEFAULT 0,
  `certificado` text DEFAULT NULL,
  `pesquisa_respondida` tinyint(4) DEFAULT NULL,
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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aula_id` bigint(20) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_visualizacoes_users1_idx` (`user_id`),
  KEY `fk_visualizacoes_aulas1_idx` (`aula_id`),
  CONSTRAINT `fk_visualizacoes_aulas1` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_visualizacoes_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;

/*Data for the table `visualizacoes` */

insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (72,17,96,'2021-01-05 16:15:28','2021-01-05 16:15:28');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (73,17,96,'2021-01-05 16:15:28','2021-01-05 16:15:28');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (74,17,96,'2021-01-06 23:29:42','2021-01-06 23:29:42');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (75,17,96,'2021-01-06 23:37:25','2021-01-06 23:37:25');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (76,17,96,'2021-01-06 23:38:52','2021-01-06 23:38:52');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (77,17,96,'2021-01-06 23:40:44','2021-01-06 23:40:44');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (78,17,96,'2021-01-06 23:41:26','2021-01-06 23:41:26');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (79,17,96,'2021-01-06 23:44:14','2021-01-06 23:44:14');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (80,18,96,'2021-01-06 23:47:01','2021-01-06 23:47:01');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (81,28,96,'2021-01-07 00:11:45','2021-01-07 00:11:45');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (82,28,96,'2021-01-07 00:12:11','2021-01-07 00:12:11');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (83,17,96,'2021-01-07 00:12:56','2021-01-07 00:12:56');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (84,23,96,'2021-01-07 00:13:24','2021-01-07 00:13:24');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (85,23,96,'2021-01-07 00:13:58','2021-01-07 00:13:58');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (86,23,96,'2021-01-07 00:14:36','2021-01-07 00:14:36');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (87,28,96,'2021-01-07 00:14:56','2021-01-07 00:14:56');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (88,18,96,'2021-01-07 00:15:04','2021-01-07 00:15:04');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (91,28,96,'2021-01-07 00:23:44','2021-01-07 00:23:44');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (97,29,96,'2021-01-07 18:01:19','2021-01-07 18:01:19');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (102,28,96,'2021-01-07 18:30:34','2021-01-07 18:30:34');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (103,17,96,'2021-01-07 18:38:51','2021-01-07 18:38:51');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (104,17,96,'2021-01-07 19:48:00','2021-01-07 19:48:00');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (105,17,96,'2021-01-07 19:49:48','2021-01-07 19:49:48');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (127,20,96,'2021-01-08 10:31:34','2021-01-08 10:31:34');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (146,17,115,'2021-01-08 11:38:40','2021-01-08 11:38:40');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (147,18,115,'2021-01-08 11:38:45','2021-01-08 11:38:45');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (148,19,115,'2021-01-08 11:38:48','2021-01-08 11:38:48');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (149,20,115,'2021-01-08 11:38:50','2021-01-08 11:38:50');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (150,21,115,'2021-01-08 11:38:52','2021-01-08 11:38:52');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (151,22,115,'2021-01-08 11:38:54','2021-01-08 11:38:54');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (152,23,115,'2021-01-08 11:38:56','2021-01-08 11:38:56');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (153,24,115,'2021-01-08 11:38:58','2021-01-08 11:38:58');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (154,25,115,'2021-01-08 11:39:00','2021-01-08 11:39:00');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (155,26,115,'2021-01-08 11:39:02','2021-01-08 11:39:02');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (156,27,115,'2021-01-08 11:39:06','2021-01-08 11:39:06');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (157,28,115,'2021-01-08 11:39:09','2021-01-08 11:39:09');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (158,29,115,'2021-01-08 11:39:11','2021-01-08 11:39:11');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (162,17,119,'2021-01-08 15:13:37','2021-01-08 15:13:37');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (163,18,119,'2021-01-08 15:14:28','2021-01-08 15:14:28');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (164,19,119,'2021-01-08 15:15:33','2021-01-08 15:15:33');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (165,20,119,'2021-01-08 15:16:13','2021-01-08 15:16:13');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (166,21,119,'2021-01-08 15:19:18','2021-01-08 15:19:18');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (167,22,119,'2021-01-08 15:19:22','2021-01-08 15:19:22');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (168,23,119,'2021-01-08 15:19:26','2021-01-08 15:19:26');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (169,24,119,'2021-01-08 15:19:29','2021-01-08 15:19:29');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (170,25,119,'2021-01-08 15:19:33','2021-01-08 15:19:33');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (171,26,119,'2021-01-08 15:19:36','2021-01-08 15:19:36');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (172,27,119,'2021-01-08 15:19:38','2021-01-08 15:19:38');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (173,28,119,'2021-01-08 15:19:40','2021-01-08 15:19:40');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (174,29,119,'2021-01-08 15:19:42','2021-01-08 15:19:42');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (178,21,119,'2021-01-08 15:23:35','2021-01-08 15:23:35');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (179,28,96,'2021-01-08 15:27:56','2021-01-08 15:27:56');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (180,27,96,'2021-01-08 15:30:07','2021-01-08 15:30:07');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (183,24,96,'2021-01-08 15:33:58','2021-01-08 15:33:58');
insert  into `visualizacoes`(`id`,`aula_id`,`user_id`,`created_at`,`updated_at`) values (184,20,96,'2021-01-18 16:13:27','2021-01-18 16:13:27');

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
 `Aulas do curso` bigint(21) ,
 `Aulas assistidas` bigint(21) ,
 `Posts realizadoss` bigint(21) ,
 `Feedback realizado` varchar(3) ,
 `Certificado emitido` varchar(3) ,
 `Data limite curso` varchar(10) ,
 `Data conclusão` varchar(10) ,
 `user_id` bigint(20) unsigned ,
 `empresa_id` bigint(20) ,
 `plano_id` bigint(20) ,
 `curso_id` bigint(20) 
)*/;

/*View structure for view v_performance */

/*!50001 DROP TABLE IF EXISTS `v_performance` */;
/*!50001 DROP VIEW IF EXISTS `v_performance` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`vitrineatma`@`%` SQL SECURITY DEFINER VIEW `v_performance` AS select `u`.`name` AS `Aluno`,`u`.`email` AS `E-mail`,`u`.`cpf` AS `CPF`,`u`.`phone` AS `Telefone`,`e`.`nome` AS `Empresa`,`p`.`nome` AS `Plano`,`c`.`nome` AS `Curso`,(select count(`a1`.`id`) from (`aulas` `a1` join `modulos` `m1` on(`m1`.`id` = `a1`.`modulo_id`)) where `m1`.`curso_id` = `c`.`id`) AS `Aulas do curso`,(select count(distinct `v1`.`aula_id`) from ((`visualizacoes` `v1` join `aulas` `a1` on(`a1`.`id` = `v1`.`aula_id`)) join `modulos` `m1` on(`m1`.`id` = `a1`.`modulo_id`)) where `m1`.`curso_id` = `c`.`id` and `v1`.`user_id` = `u`.`id`) AS `Aulas assistidas`,(select count(`p1`.`id`) from `posts` `p1` where `p1`.`user_id` = `u`.`id` and `p1`.`curso_id` = `c`.`id`) AS `Posts realizadoss`,(select if(count(`f1`.`id`) > 0,'SIM','NÃO') from `feedbacks` `f1` where `f1`.`user_id` = `u`.`id` and `f1`.`curso_id` = `c`.`id`) AS `Feedback realizado`,(select if(count(`c1`.`id`) > 0,'SIM','NÃO') from `certificados` `c1` where `c1`.`user_id` = `u`.`id` and `c1`.`curso_id` = `c`.`id`) AS `Certificado emitido`,date_format(`m`.`data_limite`,'%d/%m/%Y') AS `Data limite curso`,date_format(`m`.`data_conclusao`,'%d/%m/%Y') AS `Data conclusão`,`m`.`user_id` AS `user_id`,`m`.`empresa_id` AS `empresa_id`,`m`.`plano_id` AS `plano_id`,`m`.`curso_id` AS `curso_id` from ((((`users` `u` join `matriculas` `m` on(`m`.`user_id` = `u`.`id`)) join `cursos` `c` on(`c`.`id` = `m`.`curso_id`)) join `empresas` `e` on(`e`.`id` = `m`.`empresa_id`)) join `planos` `p` on(`p`.`id` = `m`.`plano_id`)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
