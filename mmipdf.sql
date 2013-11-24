/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.32 : Database - mmipdf
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mmipdf` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `mmipdf`;

/*Table structure for table `cont` */

DROP TABLE IF EXISTS `cont`;

CREATE TABLE `cont` (
  `cont_id` varchar(255) NOT NULL,
  `cont_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cont_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `cont` */

insert  into `cont`(`cont_id`,`cont_pic`) values ('1m','cont_pic/1m.png'),('1f','cont_pic/1f.png'),('2m','cont_pic/2m.png'),('2f','cont_pic/2f.png'),('3m','cont_pic/3m.png'),('3f','cont_pic/3f.png'),('4m','cont_pic/4m.png'),('4f','cont_pic/4f.png'),('5m','cont_pic/5m.png'),('5f','cont_pic/5f.png'),('6m','cont_pic/6m.png'),('6f','cont_pic/6f.png'),('7m','cont_pic/7m.png'),('7f','cont_pic/7f.png'),('8m','cont_pic/8m.png'),('8f','cont_pic/8f.png'),('9m','cont_pic/9m.png'),('9f','cont_pic/9f.png'),('10m','cont_pic/10m.png'),('10f','cont_pic/10f.png');

/*Table structure for table `crit` */

DROP TABLE IF EXISTS `crit`;

CREATE TABLE `crit` (
  `crit_id` int(255) NOT NULL AUTO_INCREMENT,
  `crit_name` varchar(100) DEFAULT NULL,
  `crit_percent` double DEFAULT NULL,
  `event_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`crit_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

/*Data for the table `crit` */

insert  into `crit`(`crit_id`,`crit_name`,`crit_percent`,`event_id`) values (1,'Body Proportion',0.4,'1m'),(2,'Beauty (face, complexion, and hair)',0.3,'1m'),(3,'Poise and Projection',0.2,'1m'),(4,'Bearing',0.1,'1m'),(5,'Body Proportion',0.4,'1f'),(6,'Beauty (face, complexion, and hair)',0.3,'1f'),(7,'Poise and Projection',0.2,'1f'),(8,'Bearing',0.1,'1f'),(9,'Beauty (face, complexion, and hair)',0.4,'2m'),(10,'Body Proportion',0.2,'2m'),(11,'Poise and Projection',0.2,'2m'),(12,'Bearing',0.2,'2m'),(13,'Beauty (face, complexion, and hair)',0.4,'2f'),(14,'Body Proportion',0.2,'2f'),(15,'Poise and Projection',0.2,'2f'),(16,'Bearing',0.2,'2f'),(17,'Poise and Projection',0.3,'3m'),(18,'Beauty (face, complexion, and hair)',0.4,'3m'),(19,'Bearing',0.3,'3m'),(20,'Poise and Projection',0.3,'3f'),(21,'Beauty (face, complexion, and hair)',0.4,'3f'),(22,'Bearing',0.3,'3f'),(23,'Mastery (Skill of the candidate in performing her piece)',0.5,'4m'),(24,'Style of Presentation (Creativity, uniqueness, Originality of piece)',0.4,'4m'),(25,'Impact of the presentation to the Audience',0.1,'4m'),(26,'Mastery (Skill of the candidate in performing her piece)',0.5,'4f'),(27,'Style of Presentation (Creativity, uniqueness, Originality of piece)',0.4,'4f'),(28,'Impact of the presentation to the Audience',0.1,'4f');

/*Table structure for table `event` */

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event` (
  `event_id` int(255) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `event` */

insert  into `event`(`event_id`,`event_name`,`status`) values (1,'Swimwear',1),(2,'Casual Attire',1),(3,'Evening Gown or Formal',1),(4,'Talent',0);

/*Table structure for table `event_crit` */

DROP TABLE IF EXISTS `event_crit`;

CREATE TABLE `event_crit` (
  `event_crit_id` int(255) NOT NULL AUTO_INCREMENT,
  `event_id` int(255) DEFAULT NULL,
  `crit_id` int(255) DEFAULT NULL,
  `score_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`event_crit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `event_crit` */

/*Table structure for table `judge` */

DROP TABLE IF EXISTS `judge`;

CREATE TABLE `judge` (
  `judge_id` int(255) NOT NULL AUTO_INCREMENT,
  `judge_name` varchar(100) DEFAULT NULL,
  `judge_login` varchar(20) DEFAULT NULL,
  `judge_pass` varchar(40) DEFAULT NULL,
  `print_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`judge_id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

/*Data for the table `judge` */

insert  into `judge`(`judge_id`,`judge_name`,`judge_login`,`judge_pass`,`print_name`) values (1,'Judge - A','judgea','password','Rodello L. Pepito'),(2,'Judge - B','judgeb','password','Ruby T.N. Jimeno'),(3,'Judge - C','judgec','password','Rozanne Tuesday G. Flores'),(4,'Judge - D','judged','password','Lincoln V. Tan'),(5,'Judge - E','judgee','password','Niko P. Aldeguer'),(6,'Judge - F','judgef','password','Rodello L. Pepito'),(7,'Judge - G','judgeg','password','Ruby T.N. Jimeno'),(8,'Judge - H','judgeh','password','Rozanne Tuesday G. Flores'),(9,'Judge - I','judgei','password','Lincoln V. Tan'),(10,'Judge - J','judgej','password','Niko P. Aldeguer'),(11,'Judge - K','judgek','password','Rodello L. Pepito'),(12,'Judge - L','judgel','password','Ruby T.N. Jimeno'),(101,'admin','admin','password','Administrator');

/*Table structure for table `rank_fin` */

DROP TABLE IF EXISTS `rank_fin`;

CREATE TABLE `rank_fin` (
  `rank_id` int(255) NOT NULL AUTO_INCREMENT,
  `cont_id` varchar(255) DEFAULT NULL,
  `rank` float DEFAULT NULL,
  `total` decimal(65,1) DEFAULT NULL,
  PRIMARY KEY (`rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `rank_fin` */

/*Table structure for table `rank_one` */

DROP TABLE IF EXISTS `rank_one`;

CREATE TABLE `rank_one` (
  `rank_id` int(255) NOT NULL AUTO_INCREMENT,
  `cont_id` varchar(255) DEFAULT NULL,
  `event_id` varchar(255) DEFAULT NULL,
  `judge_id` int(255) DEFAULT NULL,
  `rank` float DEFAULT NULL,
  `total` decimal(65,2) DEFAULT NULL,
  PRIMARY KEY (`rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `rank_one` */

/*Table structure for table `rank_two` */

DROP TABLE IF EXISTS `rank_two`;

CREATE TABLE `rank_two` (
  `rank_id` int(255) NOT NULL AUTO_INCREMENT,
  `cont_id` varchar(255) DEFAULT NULL,
  `event_id` varchar(255) DEFAULT NULL,
  `rank` float DEFAULT NULL,
  `total` decimal(65,1) DEFAULT NULL,
  PRIMARY KEY (`rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `rank_two` */

/*Table structure for table `score` */

DROP TABLE IF EXISTS `score`;

CREATE TABLE `score` (
  `score_id` int(255) NOT NULL AUTO_INCREMENT,
  `cont_id` varchar(255) DEFAULT NULL,
  `judge_id` int(255) DEFAULT NULL,
  `score` float DEFAULT NULL,
  PRIMARY KEY (`score_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `score` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
