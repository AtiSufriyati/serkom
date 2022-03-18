/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 5.7.24 : Database - dev_serkom
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dev_serkom` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `dev_serkom`;

/*Table structure for table `bill` */

DROP TABLE IF EXISTS `bill`;

CREATE TABLE `bill` (
  `IndexBill` int(11) NOT NULL AUTO_INCREMENT,
  `IndexUsage` int(11) NOT NULL,
  `IndexCustomer` int(11) NOT NULL,
  `CustomerID` varchar(20) NOT NULL,
  `Month` varchar(20) NOT NULL,
  `Year` int(11) NOT NULL,
  `TotalMeter` int(11) NOT NULL,
  `Status` enum('PAID','UNPAID','INACTIVE') DEFAULT NULL,
  PRIMARY KEY (`IndexBill`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `bill` */

insert  into `bill`(`IndexBill`,`IndexUsage`,`IndexCustomer`,`CustomerID`,`Month`,`Year`,`TotalMeter`,`Status`) values 
(1,11,4,'CUS004','JANUARY',2022,534,'UNPAID'),
(2,1,1,'CUS001','JANUARY',2022,234,'PAID'),
(3,12,1,'CUS001','MARCH',2022,203,'PAID');

/*Table structure for table `log` */

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `IndexLog` int(11) NOT NULL AUTO_INCREMENT,
  `Module` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `Url` text COLLATE utf8_unicode_ci NOT NULL,
  `Attribute` text COLLATE utf8_unicode_ci NOT NULL,
  `IPAddress` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `CreatedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedByID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CreatedByName` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IndexLog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `log` */

/*Table structure for table `master_customer` */

DROP TABLE IF EXISTS `master_customer`;

CREATE TABLE `master_customer` (
  `IndexCustomer` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerID` varchar(20) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `Address` text,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `KWHNo` varchar(20) DEFAULT NULL,
  `IndexPrice` int(11) NOT NULL,
  `Active` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`IndexCustomer`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `master_customer` */

insert  into `master_customer`(`IndexCustomer`,`CustomerID`,`CustomerName`,`Address`,`UserName`,`Password`,`KWHNo`,`IndexPrice`,`Active`) values 
(1,'CUS001','PRAVINDRA ARDHIMAS','JALAN HALIM PERDANA KUSUMA NO. 66, JAKARTA TIMUR','PRAVINDRA','Password@123','1557 5566 4455 5544',1,'ACTIVE'),
(2,'CUS002','MEGA RINDI','JALAN HALIM PERDANA KUSUMA NO. 45, JAKARTA TIMUR','RINDI','RINDI30','5678 4551 4455 7777',2,'ACTIVE'),
(3,'CUS003','KARTIKA MALASARI','JALAN KEBON PALA NO. 22, JAKARTA TIMUR','KARTIKA','KAR3331','4455 0091 4455 0092',1,'ACTIVE'),
(4,'CUS004','RIVAN ARYAPUTRA','JALAN ASRI NO. 66, JAKARTA TIMUR','RIVAN','RIVAN21','1557 4433 4455 1122',1,'ACTIVE'),
(5,'CUS100','SUFRIYATI','JALAN','ATI','Password@123','0897 4664 7383 7885',1,'ACTIVE');

/*Table structure for table `master_level` */

DROP TABLE IF EXISTS `master_level`;

CREATE TABLE `master_level` (
  `IndexLevel` int(11) NOT NULL AUTO_INCREMENT,
  `LevelID` varchar(20) NOT NULL,
  `LevelName` varchar(100) NOT NULL,
  PRIMARY KEY (`IndexLevel`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `master_level` */

insert  into `master_level`(`IndexLevel`,`LevelID`,`LevelName`) values 
(1,'LVL001','STAFF'),
(2,'LVL002','ADMINISTRATOR'),
(3,'LVL003','SUPERVISOR'),
(4,'LVL004','CUSTOMER');

/*Table structure for table `master_price` */

DROP TABLE IF EXISTS `master_price`;

CREATE TABLE `master_price` (
  `IndexPrice` int(11) NOT NULL AUTO_INCREMENT,
  `PriceID` varchar(20) NOT NULL,
  `Energy` varchar(100) NOT NULL,
  `PricePerKWH` decimal(22,2) NOT NULL,
  PRIMARY KEY (`IndexPrice`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `master_price` */

insert  into `master_price`(`IndexPrice`,`PriceID`,`Energy`,`PricePerKWH`) values 
(1,'R-1/TR','900 VA',1352.00),
(2,'R-1/TR','1300 VA',1444.00),
(3,'R-2/TR','3500 VA',1540.00),
(4,'R-2/TR','3700 VA',1580.00);

/*Table structure for table `master_user` */

DROP TABLE IF EXISTS `master_user`;

CREATE TABLE `master_user` (
  `IndexUser` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `AdminName` varchar(100) NOT NULL,
  `IndexLevel` int(11) DEFAULT NULL,
  PRIMARY KEY (`IndexUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `master_user` */

insert  into `master_user`(`IndexUser`,`UserID`,`UserName`,`Email`,`Phone`,`Password`,`AdminName`,`IndexLevel`) values 
(1,'USR001','ATI SUFRIYATI','sufriyati@gmail.com','087888773732','FRI316','SUFRI',1),
(2,'USR002','ERIKA CANG','erika@gmail.com','08372744242','User@123','ERIKA',1);

/*Table structure for table `payment` */

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `IndexPayment` int(11) NOT NULL AUTO_INCREMENT,
  `IndexBill` int(11) NOT NULL,
  `IndexCustomer` int(11) DEFAULT NULL,
  `CustomerID` varchar(20) NOT NULL,
  `PaymentDate` datetime NOT NULL,
  `Month` varchar(20) NOT NULL,
  `AdminCharge` decimal(22,2) NOT NULL,
  `TotalPayment` decimal(22,2) DEFAULT NULL,
  `IndexUser` int(11) NOT NULL,
  PRIMARY KEY (`IndexPayment`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `payment` */

insert  into `payment`(`IndexPayment`,`IndexBill`,`IndexCustomer`,`CustomerID`,`PaymentDate`,`Month`,`AdminCharge`,`TotalPayment`,`IndexUser`) values 
(1,3,NULL,'CUS001','2022-03-11 15:38:42','MARCH',2500.00,276956.00,1);

/*Table structure for table `usage` */

DROP TABLE IF EXISTS `usage`;

CREATE TABLE `usage` (
  `IndexUsage` int(11) NOT NULL AUTO_INCREMENT,
  `IndexCustomer` int(11) NOT NULL,
  `CustomerID` varchar(20) NOT NULL,
  `Month` varchar(20) NOT NULL,
  `Year` int(11) NOT NULL,
  `StartMeter` varchar(20) NOT NULL,
  `EndMeter` varchar(20) NOT NULL,
  PRIMARY KEY (`IndexUsage`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `usage` */

insert  into `usage`(`IndexUsage`,`IndexCustomer`,`CustomerID`,`Month`,`Year`,`StartMeter`,`EndMeter`) values 
(1,1,'CUS001','JANUARY',2022,'00038206','00038440'),
(2,2,'CUS002','JANUARY',2022,'10038205','10038445'),
(3,3,'CUS003','JANUARY',2022,'10039205','10039475'),
(4,1,'CUS001','FEBRUARY',2022,'00038440','00038639'),
(5,2,'CUS002','FEBRUARY',2022,'10038445','10038655'),
(6,3,'CUS003','FEBRUARY',2022,'10039475','10039704'),
(11,4,'CUS004','JANUARY',2022,'00039206','00039740'),
(12,1,'CUS001','MARCH',2022,'00038639','00038842');

/* Trigger structure for table `usage` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `insert_bill` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `insert_bill` AFTER INSERT ON `usage` FOR EACH ROW 
BEGIN
    INSERT INTO `dev_serkom`.`bill` (`IndexUsage`, `IndexCustomer`,`CustomerID`, `Month`, `Year`, `TotalMeter`,`Status`) 
		VALUES (NEW.IndexUsage, NEW.IndexCustomer,NEW.CustomerID, NEW.Month, NEW.Year, NEW.EndMeter - NEW.StartMeter,'UNPAID');
END */$$


DELIMITER ;

/* Function  structure for function  `usagePerMonth` */

/*!50003 DROP FUNCTION IF EXISTS `usagePerMonth` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `usagePerMonth`(param_id VARCHAR(20), param_month varchar(20)) RETURNS int(11)
    DETERMINISTIC
BEGIN
	DECLARE totalUsage INT;
	set totalUsage = 0 ;
	Select (EndMeter - StartMeter) into totalUsage from `usage` where CustomerID = param_id and `Month` = param_month;
	RETURN totalUsage;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `GetCustomerLevel` */

/*!50003 DROP PROCEDURE IF EXISTS  `GetCustomerLevel` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCustomerLevel`(
    IN  customerNo INT,  
    OUT customerLevel VARCHAR(20)
)
BEGIN

	DECLARE credit DEC(10,2) DEFAULT 0;
    
    -- get credit limit of a customer
    SELECT 
		creditLimit 
	INTO credit
    FROM customers
    WHERE 
		customerNumber = customerNo;
    
    -- call the function 
    SET customerLevel = CustomerLevel(credit);
END */$$
DELIMITER ;

/* Procedure structure for procedure `getPrice` */

/*!50003 DROP PROCEDURE IF EXISTS  `getPrice` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getPrice`(in `Index` INTEGER)
BEGIN
		Select * from master_price where IndexPrice = `Index`;
	END */$$
DELIMITER ;

/*Table structure for table `view_customer` */

DROP TABLE IF EXISTS `view_customer`;

/*!50001 DROP VIEW IF EXISTS `view_customer` */;
/*!50001 DROP TABLE IF EXISTS `view_customer` */;

/*!50001 CREATE TABLE  `view_customer`(
 `IndexCustomer` int(11) ,
 `CustomerID` varchar(20) ,
 `CustomerName` varchar(100) ,
 `Address` text ,
 `UserName` varchar(100) ,
 `Password` varchar(255) ,
 `KWHNo` varchar(20) ,
 `IndexPrice` int(11) 
)*/;

/*Table structure for table `view_usage` */

DROP TABLE IF EXISTS `view_usage`;

/*!50001 DROP VIEW IF EXISTS `view_usage` */;
/*!50001 DROP TABLE IF EXISTS `view_usage` */;

/*!50001 CREATE TABLE  `view_usage`(
 `IndexUsage` int(11) ,
 `IndexCustomer` int(11) ,
 `Month` varchar(20) ,
 `YEAR` int(11) ,
 `StartMeter` varchar(20) ,
 `EndMeter` varchar(20) 
)*/;

/*View structure for view view_customer */

/*!50001 DROP TABLE IF EXISTS `view_customer` */;
/*!50001 DROP VIEW IF EXISTS `view_customer` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_customer` AS (select `master_customer`.`IndexCustomer` AS `IndexCustomer`,`master_customer`.`CustomerID` AS `CustomerID`,`master_customer`.`CustomerName` AS `CustomerName`,`master_customer`.`Address` AS `Address`,`master_customer`.`UserName` AS `UserName`,`master_customer`.`Password` AS `Password`,`master_customer`.`KWHNo` AS `KWHNo`,`master_customer`.`IndexPrice` AS `IndexPrice` from `master_customer`) */;

/*View structure for view view_usage */

/*!50001 DROP TABLE IF EXISTS `view_usage` */;
/*!50001 DROP VIEW IF EXISTS `view_usage` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_usage` AS (select `usage`.`IndexUsage` AS `IndexUsage`,`usage`.`IndexCustomer` AS `IndexCustomer`,`usage`.`Month` AS `Month`,`usage`.`Year` AS `YEAR`,`usage`.`StartMeter` AS `StartMeter`,`usage`.`EndMeter` AS `EndMeter` from `usage`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
