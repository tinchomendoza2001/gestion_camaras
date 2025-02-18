/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.62-0ubuntu0.14.04.1 : Database - minseg_novedades
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `camaras_con_lector` */

CREATE TABLE `camaras_con_lector` (
  `Id1` int(11) DEFAULT NULL,
  `ZONA` varchar(255) DEFAULT NULL,
  `SIMB` varchar(255) DEFAULT NULL,
  `ID` varchar(255) DEFAULT NULL,
  `DIR` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `camaras_con_lector` */

insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (1,'ESTE','SM','156','SM-156 Lavalle y RP 50');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (2,'ESTE','SM','181','SM-181 9 de Julio y España');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (3,'ESTE','RV','73 ','RV-73 San Isidro y Belgrano');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (4,'ESTE','RV','80 ','RV-80 Sarmiento y Brandsen');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (5,'ESTE','JU','16 ','JU-16 Rotonda Vista Oeste');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (6,'ESTE','JU','9','JU-09 Isidoro Busquet y Spagnolo');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (7,'GRAN MENDOZA','GC','316','GC-316 Avenida del Trabajo y Panamericana (ubicada en GC32)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (8,'GRAN MENDOZA','CA','73 ','CA-73 La Madrid y Paso de los Andes');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (9,'GRAN MENDOZA','CA','132','CA-132 Emilio Civit y Boulogne Sur Mer');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (10,'GRAN MENDOZA','CA','190','CA- 190 Rondeau y Salta (Ambas Cámaras al Oeste apuntando al Este)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (11,'GRAN MENDOZA','CA','41','CA- 41 Perú y Reta');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (12,'GRAN MENDOZA','CA','89','CA- 89 Champagnat y San José');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (13,'GRAN MENDOZA','CA','151','CA- 151 Costanera y Vicente Zapata (Cámaras apuntando al Oeste)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (14,'GRAN MENDOZA','GC','256','GC-256 Rioja y Brasil Apuntando al ESTE');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (15,'GRAN MENDOZA','GC','DE01','DE01 DESAGUADERO Puesto Limitrofe con San Luis');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (16,'GRAN MENDOZA','GC','194','GC-194 Corredor del Oeste y Lago Hermoso');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (17,'GRAN MENDOZA','GC','112','GC-112 Sarmiento y Primitivo de la Reta');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (18,'GRAN MENDOZA','GC','35 ','GC-35 TAlcahuano y Las Tipas');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (19,'GRAN MENDOZA','GC','23 ','GC-23 Hipolito Irigollen y San Martín');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (20,'GRAN MENDOZA','GU','15','GU- 15 Bandera de los Andes y Mitre');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (21,'GRAN MENDOZA','GU','35','GU- 35 Godoy Cruz y Av Gobernador Videla');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (22,'GRAN MENDOZA','GU','135','GU- 135 Elpidio Gonzalez y Carril Ponce');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (23,'GRAN MENDOZA','GU','9','GU- 9 Godoy Cruz y Tirasso (Ambas al Norte una apuntando al Norte y otra al Sur)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (24,'GRAN MENDOZA','LH','51','LH- 51 Bologne Sur Mer y Cipolletti (Ambas al Norte una apuntando al Norte y la otra al Sur)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (25,'GRAN MENDOZA','LH','149','LH- 149 Independencia y Acceso Norte (Una apuntando al Norte y la otra al Sur)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (26,'GRAN MENDOZA','LH','77','LH- 77 Marquez Aguado e Independencia (Una apuntando al Este y la otra al Oeste)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (27,'SUR','GA','20','GA-020 Ruta 188 y Gral Alvear');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (28,'SUR','ML','14','ML-014 Ruta 40 y Aeropuerto Malargüe ');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (29,'SUR','ML','40','ML-040 Ruta 40 Norte e Ingreso a Malargüe (Ubicada en ML11)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (30,'SUR','ML','33','ML-033 El Sosneado');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (31,'SUR','SR','90','SR-090 Arco de ingreso San Rafael (Ubicada en ML45)');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (32,'SUR','SR','11','SR-011 Ballofet y Los Filtros');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (33,'SUR','SR','89','SR-089 Libertador e Yrigoyen');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (34,'SUR','SR','3','SR-003 Mitre y Salas');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (35,'SUR','SR','215','SR-215 Rotonda el Cristo');
insert  into `camaras_con_lector`(`Id1`,`ZONA`,`SIMB`,`ID`,`DIR`) values (36,'SUR','SR','21 ','SR-21 Irigoyen y Rawson ');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
