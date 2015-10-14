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

/*Table structure for table `fp_mails` */

CREATE TABLE `fp_mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text,
  `attachment_ids` varchar(255) DEFAULT NULL,
  `read` int(11) NOT NULL DEFAULT '0' COMMENT '0->No, 1->Yes',
  `deleted` int(11) NOT NULL DEFAULT '0' COMMENT '0->No, 1->Yes',
  `admin_delete` int(11) NOT NULL DEFAULT '0' COMMENT '0->No, 1->Yes',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
