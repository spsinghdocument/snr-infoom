/*
SQLyog Enterprise - MySQL GUI v7.12 
MySQL - 5.5.8 : Database - fusedpage
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`fusedpage` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Data for the table `fp_folders` */

insert  into `fp_folders`(`id`,`user_id`,`name`,`status`,`created`,`modified`) values (1,NULL,'Inbox','1','2013-05-15 15:04:00','2013-05-15 15:04:00'),(2,NULL,'Trash','1','2013-05-15 15:04:00','2013-05-15 15:04:00'),(3,NULL,'Archive','1','2013-05-15 15:04:01','2013-05-15 15:04:01');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
