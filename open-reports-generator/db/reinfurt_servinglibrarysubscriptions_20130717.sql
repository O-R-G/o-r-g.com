-- MySQL dump 10.13  Distrib 5.1.66, for unknown-freebsd8.2 (x86_64)
--
-- Host: db147b.pair.com    Database: reinfurt_servinglibrarysubscriptions
-- ------------------------------------------------------
-- Server version	5.1.61-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `object` int(10) unsigned DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `rank` int(10) unsigned DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'jpg',
  `caption` blob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objects`
--

DROP TABLE IF EXISTS `objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `rank` int(10) unsigned DEFAULT NULL,
  `name1` tinytext,
  `name2` tinytext,
  `address1` text,
  `address2` text,
  `city` tinytext,
  `state` tinytext,
  `zip` tinytext,
  `country` tinytext,
  `phone` tinytext,
  `fax` tinytext,
  `url` tinytext,
  `email` tinytext,
  `begin` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `head` tinytext,
  `deck` blob,
  `body` blob,
  `notes` blob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objects`
--

LOCK TABLES `objects` WRITE;
/*!40000 ALTER TABLE `objects` DISABLE KEYS */;
INSERT INTO `objects` VALUES (1,1,'2013-07-11 21:05:15','2013-07-15 23:44:49',10,'_Reports','','',NULL,'','','','','',NULL,NULL,'',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL,'',NULL),(2,1,'2013-07-11 21:05:25','2013-07-11 21:05:25',20,'Subscribers','','',NULL,'','','','','',NULL,NULL,'',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL,'',NULL),(3,1,'2013-07-11 00:00:00','2013-07-11 21:08:22',0,'Norwich University College of the Arts','','Francis House \r\n3-7 Redwell St','','Norwich','','NR2 4SN','United Kingdom','01603 751461','','','g.burnett@nuca.ac.uk','2011-06-14 00:00:00','2013-06-14 00:00:00','2011-06-14 00:00:00','','','',NULL),(4,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Indrek','Sirkel','Koskla 12-8','','Tallinn','Harjumaa','10615','Estonia','','','','sirkel@sirkel.ee','2011-06-15 00:00:00','2013-06-15 00:00:00','2011-06-15 00:00:00','','','',NULL),(5,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'John','Steigerwald','174 Helen Street','','Fanwood','NJ','07023-1514','United States','','','','jsarch@mindspring.com','2011-06-21 00:00:00','2013-06-21 00:00:00','2011-06-21 00:00:00','','','',NULL),(6,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Stuart','Geddes','15-25 Keele Street','','Collingwood','Victoria','3066','Australia','','','','mrgeddes@gmail.com','2011-06-21 00:00:00','2023-06-21 00:00:00','2011-06-21 00:00:00','','','',NULL),(7,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'ALIBRI LIBRERIA, SL','','BALMES 26','','BARCELONA','','8007','Spain','','','','alopez@alibri.es','2011-06-27 00:00:00','2015-06-27 00:00:00','2011-06-27 00:00:00','','','',NULL),(8,1,'2013-07-11 00:00:00','2013-07-11 21:08:44',0,'Brett','Gronow','121 Victoria Street\r\nFitzroy','','Melbourne','VICTORIA','3065','Australia','','','','','2011-07-01 00:00:00','2013-07-01 00:00:00','2011-07-01 00:00:00','','','',NULL),(9,1,'2013-07-11 00:00:00','2013-07-16 00:06:54',0,'Vincent','Chan','4 Steorra Mews','','Doncaster East','Victoria','3109','Australia','','','','','2011-07-01 00:00:00','2023-07-01 00:00:00','2011-07-01 00:00:00','','','',NULL),(10,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Alexandra','Peters','262 Central Park West #7F','','New York','NY','10024','United States','','','','','2011-07-01 00:00:00','2023-07-01 00:00:00','2011-07-01 00:00:00','','','',NULL),(11,1,'2013-07-11 00:00:00','2013-07-15 16:09:42',0,'Badminton Bandit','','268 Charles St','','North Perth','Western Australia','6006','Australia','','','','david@badmintonbandit.com','2011-07-04 00:00:00','2015-07-04 00:00:00','0000-00-00 00:00:00','','','',NULL),(12,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Eric','Veit','1242 Gerritt st','','Philadelphia','PA','19147','United States','','','','veit.eric@gmail.com','2011-07-29 00:00:00','2013-07-29 00:00:00','2011-07-29 00:00:00','','','',NULL),(13,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Daniel','Fogarty','21 Mellor Rd','','New Mills','Derbyshire','SK22 4DP','United Kingdom','','','','daniel_fog@hotmail.com','2011-08-01 00:00:00','2013-08-01 00:00:00','2011-08-01 00:00:00','','','',NULL),(14,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Fan','Wu','No.8, Hua Jia Di Nan St.','','Chao Yang District','Beijing','100102','P.R. China','','','','yes_wufan@yahoo.com.cn','2011-08-08 00:00:00','2013-08-08 00:00:00','2011-08-08 00:00:00','','','',NULL),(15,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Jonathan','Zawada','Prism Gallery, 8746 West Sunset Blvd','','West Hollywood','CA','90069','United States','','','','jonathan@zawada.com.au','2011-09-26 00:00:00','2013-09-26 00:00:00','2011-09-26 00:00:00','','','',NULL),(16,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Jason','Alger','3666 Oxford Court','','Hudsonville','MI','49426','United States','','','','jasonalger113@gmail.com','2011-10-10 00:00:00','2013-10-10 00:00:00','2011-10-10 00:00:00','','','',NULL),(17,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Larissa','Hammond','3347 N Willamette Blvd','','Portland','OR','97217','United States','','','','larissa.hammond@gmail.com','2011-10-14 00:00:00','2013-10-14 00:00:00','2011-10-14 00:00:00','','','',NULL),(18,1,'2013-07-11 00:00:00','2013-07-11 21:16:26',0,'S.','Barton','SERIALS UNIT, LIBRARY, PRIVATE BAG 92019','','AUCKLAND','NEW ZEALAND','1142','New Zealand','','','','s.watt@auckland.ac.nz','2011-10-30 00:00:00','2013-10-30 00:00:00','2011-10-30 00:00:00','','','',NULL),(19,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'David','Hilmer Rex','36 W 74TH ST, Apartment 5A','','New York','NY','10023','Denmark','','','','davidhilmerrex@gmail.com','2011-10-31 00:00:00','2013-10-31 00:00:00','2011-10-31 00:00:00','','','',NULL),(20,1,'2013-07-11 00:00:00','2013-07-15 16:58:17',0,'Princeton University Library','','One Washington Road','','Princeton','NJ','8544','United States','','','','ch5@princeton.edu','2011-11-21 00:00:00','2013-11-21 00:00:00','2011-11-21 00:00:00','','','',NULL),(21,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Alec','Appelbaum','212 East Broadway, Apt. G204','','New York','NY','10002','United States','','','','alecappelbaum@rocketmail.com','2011-11-28 00:00:00','2015-11-28 00:00:00','2011-11-28 00:00:00','','','',NULL),(22,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Transmission Gallery','','28 King Street','','Glasgow','Glasgow (City of)','G1 5QP','United Kingdom','','','','info@transmissiongallery.org','2011-12-09 00:00:00','2013-12-09 00:00:00','2011-12-09 00:00:00','','','',NULL),(23,1,'2013-07-11 00:00:00','2013-07-11 21:14:57',0,'ESAD Amiens Metropole','','40 Rue des Teinturiers','','Amiens','','80080','France','','','','','2012-01-01 00:00:00','2014-01-01 00:00:00','2012-01-01 00:00:00','','','',NULL),(24,1,'2013-07-11 00:00:00','2013-07-11 21:16:47',0,'\'Michael\'','Cunningham','246 Sheridan Avenue','','Highwood','IL','60040','United States','','','','quotes@quote-m-unquote.com','2012-01-02 00:00:00','2014-01-02 00:00:00','2012-01-02 00:00:00','','','',NULL),(25,1,'2013-07-11 00:00:00','2013-07-15 17:37:20',0,'Moon','Jung Jang','University of Georgia\r\n270 River Road','','Athens','GA','30602','United States','','','','borderrider@gmail.com','2012-01-16 00:00:00','2014-01-16 00:00:00','2012-01-16 00:00:00','','','',NULL),(26,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Boo','Wallin','1 Independent Place, Basement','','London','','E8 2HE','United Kingdom','','','','boowallin@googlemail.com','2012-01-18 00:00:00','2014-01-18 00:00:00','2012-01-18 00:00:00','','','',NULL),(27,1,'2013-07-11 00:00:00','2013-07-15 17:36:15',0,'Bard College','','ATTN: Ann Butler\r\nCCS Bard Library, Center for Curatorial Studies, Bard College','','Annandale on Hudson','NY','12504-5000','United States','','','','butler@bard.edu','2012-01-26 00:00:00','2014-01-26 00:00:00','2012-01-26 00:00:00','','','',NULL),(28,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Regis','Tosetti','61 Dunlace Road','','London','','E5 0NF','United Kingdom','','','','gregory.ambos@gmail.com','2012-01-26 00:00:00','2014-01-26 00:00:00','2012-01-26 00:00:00','','','',NULL),(29,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Willi','Schmid','Michelbeuerngasse 3','','Wien','','A-1090 ','Austria','','','','mail@willischmid.at','2012-01-30 00:00:00','2014-01-30 00:00:00','2012-01-30 00:00:00','','','',NULL),(30,1,'2013-07-11 00:00:00','2013-07-15 17:33:16',0,'EPCC Ecole Superieure d\'Art','','ATTN: Mme Christelle Kirchstetter\r\nEPCC Ecole Superieure d\'Art\r\n7 Rue du Paon, BP 361','','Cambrai','','59407','France','','','','','2012-03-07 00:00:00','2014-03-07 00:00:00','2012-03-07 00:00:00','','','',NULL),(31,1,'2013-07-11 00:00:00','2013-07-15 17:32:51',0,'Emily Carr University Library','','1399 Johnston Street','','Vancouver','BC','V6H 3R9','Canada','','','','','2012-03-09 00:00:00','2014-03-09 00:00:00','2012-03-09 00:00:00','','','',NULL),(32,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'OTIS College Library','','OTIS College Library, 9045 Lincoln Blvd','','Los Angeles','CA','90045','United States','','','','','2012-03-09 00:00:00','2014-03-09 00:00:00','2012-03-09 00:00:00','','','',NULL),(33,1,'2013-07-11 00:00:00','2013-07-11 21:09:48',0,'Murray Library Periodicals','','Messiah College, Murray Library Periodicals\r\nOne College Avenue, Ste 3002','','Mechanicsburg','PA','17055','United States','','','','','2012-03-21 00:00:00','2014-03-21 00:00:00','2012-03-21 00:00:00','','','',NULL),(34,1,'2013-07-11 00:00:00','2013-07-11 21:14:36',0,'XING','','ATTN: Silvia Fanti \r\nVia Ca\' Selvatica 4/d\r\nc/o Xing/Raum','','Bologna','','40123','Italy','','','','pressoff@xing.it','2012-03-22 00:00:00','2014-03-22 00:00:00','2012-03-22 00:00:00','','','',NULL),(35,1,'2013-07-11 00:00:00','2013-07-11 21:13:53',0,'York University Libraries','','Serials Sctn\r\n4700 Keele Street','','North York','ON','M3J 1P3','Canada','','','','','2012-03-24 00:00:00','2014-03-24 00:00:00','2012-03-24 00:00:00','','','',NULL),(36,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'AMS/ Virginia CW University','','AMS/Virginia CW Univ, PO Box 750','','Aalsmeer','','1430','Netherlands','','','','','2012-05-02 00:00:00','2014-05-02 00:00:00','2012-05-02 00:00:00','','','',NULL),(37,1,'2013-07-11 00:00:00','2013-07-11 21:13:31',0,'Sterling Library','','attn: Terri Boccia\r\nSterling Library\r\n225 South Street','','Williamstown','MA','1267','United States','','','','mslowey@clarkart.edu','2012-05-09 00:00:00','2014-05-09 00:00:00','2012-05-09 00:00:00','','','',NULL),(38,1,'2013-07-11 00:00:00','2013-07-11 21:13:14',0,'Chelsea College of Art & Design','','The Library\r\nChelsea College of Art & Design\r\n16 John Islip Street','','Millbank','London','SW1P 4JU','England','','','','','2012-05-18 00:00:00','2014-05-18 00:00:00','2012-05-18 00:00:00','','','',NULL),(39,1,'2013-07-11 00:00:00','2013-07-11 21:12:51',0,'Resource Room','','ATTN: Daniel Glendening\r\nResource Room \r\n415 SW 10th Avenue (Suite 300)','','Portland','OR','97205','United States','','','','resourceroom@pica.org','2012-06-12 00:00:00','2014-06-12 00:00:00','2012-06-12 00:00:00','','','',NULL),(40,1,'2013-07-11 00:00:00','2013-07-15 17:37:52',0,'Aaron','Van Dyke','Midway Contemporary Art\r\n527 2nd Ave SE','','Minneapolis','MN','55414','United States','','','','aaron@midwayart.org','2012-06-14 00:00:00','2014-06-14 00:00:00','2012-06-14 00:00:00','','','',NULL),(41,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Beverly','Lopez','Beverly Lopez, 145 E. Bonita Avenue, Lebus #103','','Claremont','CA','91711','United States','','','','beverly_lopez@pomona.edu','2012-08-28 00:00:00','2014-08-28 00:00:00','2012-08-28 00:00:00','','','',NULL),(42,1,'2013-07-11 00:00:00','2013-07-11 21:09:35',0,'Murray Library Periodicals','','Messiah College, Murray Library Periodicals\r\nOne College Avenue, Ste 3002','','Mechanicsburg','PA','17055','United States','','','','','2012-10-31 00:00:00','2014-10-31 00:00:00','2012-10-31 00:00:00','','','',NULL),(43,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Library/SCAD-Hong Kong','','Library/SCAD-Hong Kong, 292 Tai PO Road, Sham Shui PO','','Kowloon','','','Hong Kong','','','','','2012-11-07 00:00:00','2014-11-07 00:00:00','2012-11-07 00:00:00','','','',NULL),(44,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'SF MOMA','','SF MOMA Library, 151 Third St','','San Francisco','CA','94103','United States','','','','','2012-11-07 00:00:00','2014-11-07 00:00:00','2012-11-07 00:00:00','','','',NULL),(45,1,'2013-07-11 00:00:00','2013-07-15 17:34:30',0,'Ringling College Library','','2700 N Tamiami Tr','','Sarasota','FL','34234','United States','','','','','2012-11-09 00:00:00','2014-11-09 00:00:00','2012-11-09 00:00:00','','','',NULL),(46,1,'2013-07-11 00:00:00','2013-07-11 21:15:56',0,'Watson Univ of KANSAS','','Retrieval Serv Dept Serl\r\n1425 Jayhawk Blvd R 2105','','Lawrence','KS','66045','United States','','','','','2012-11-14 00:00:00','2014-11-14 00:00:00','2012-11-14 00:00:00','','','',NULL),(47,1,'2013-07-11 00:00:00','2013-07-11 21:11:18',0,'University College London','','University College London\r\nLibrary-Periodicals Dept \r\nGower Street','','London','','WC1E 6BT','England','','','','','2012-11-24 00:00:00','2014-11-24 00:00:00','2012-11-24 00:00:00','','','',NULL),(48,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'JEN Library','','JEN Library, PO Box 3146','','Savannah','GA','31402','United States','','','','','2012-12-12 00:00:00','2014-12-12 00:00:00','2012-12-12 00:00:00','','','',NULL),(49,1,'2013-07-11 00:00:00','2013-07-11 21:09:18',0,'Grace','Robinson-Leo','Vince Leo\r\n51 Melbourne Ave SE','','Minneapolis','MN','55414','United States','','','','grace.robinsonleo@gmail.com','2012-12-16 00:00:00','2014-12-16 00:00:00','2012-12-16 00:00:00','','','',NULL),(50,1,'2013-07-11 00:00:00','2013-07-11 21:11:44',0,'Monash University','','Serials Office\r\nCaulfield Campus Library, \r\nPER 234111\r\nPO Box 197','','Caulfield East','','VIC 3145','Australia','','','','','2013-01-12 00:00:00','2015-01-12 00:00:00','2013-01-12 00:00:00','','','',NULL),(51,1,'2013-07-11 00:00:00','2013-07-15 17:35:10',0,'Rhode Island School of Design','','RISD Library, 2 College Street','','Providence','RI','2903','United States','','','','','2013-02-01 00:00:00','2015-02-01 00:00:00','2013-02-01 00:00:00','','','',NULL),(52,1,'2013-07-11 00:00:00','2013-07-11 21:12:16',0,'Gerrit Rietveld Academie','','Library\r\nt.a.v. de bibliotheek\r\nFrederik Roeskestraat 96','','Amsterdam','','1076ED','The Netherlands','','','','Bibliotheek@grac.nl','2013-02-12 00:00:00','2015-02-12 00:00:00','2013-02-12 00:00:00','','','',NULL),(53,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Sophie','Hardie','3 Hartley Ave','','West Footscray','Victoria','3012','Australia','','','','jonesseg@hotmail.com','2013-02-13 00:00:00','2015-02-13 00:00:00','2013-02-13 00:00:00','','','',NULL),(54,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Abra','Ancliffe','4619 NE 7th Ave','','Portland','OR','97211','United States','','','','personallibraries@gmail.com','2013-05-17 00:00:00','2015-05-17 00:00:00','2013-05-17 00:00:00','','','',NULL),(55,1,'2013-07-11 00:00:00','0000-00-00 00:00:00',0,'Barbara','Rominski','151 Third St','','San Francisco','CA','94103','United States','','','','library@sfmoma.org','2013-07-04 00:00:00','2015-07-04 00:00:00','2013-07-04 00:00:00','','','',NULL),(58,1,'2013-07-15 16:12:25','2013-07-15 17:55:01',NULL,'Test','Case','SELECT * FROM objects ORDER BY id;',NULL,'Chapel Hill','NC','27517','United States','919 929 3318',NULL,NULL,'reinfurt@o-r-g.com','1998-12-01 00:00:00','2015-07-01 00:00:00',NULL,NULL,NULL,'',''),(62,1,'2013-07-16 00:00:12','2013-07-16 00:06:17',NULL,'12-year subscriptions','','',NULL,'','','','','',NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL,NULL,'SELECT *, objects.id AS objectsid FROM objects, wires WHERE objects.active = 1 AND end > \'$now\' AND end > \'2021-01-01\' AND wires.active = 1 AND wires.toid = objects.id AND address1 != \'NULL\' AND wires.fromid = 2 ORDER BY end ASC;',''),(59,1,'2013-07-15 22:05:51','2013-07-15 23:45:36',NULL,'Currently active subscriptions, ordered by NAME','','',NULL,'','','','','',NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL,NULL,'SELECT *, objects.id AS objectsid FROM objects, wires WHERE objects.active = 1 AND begin > \"2012-01-01\" AND wires.active = 1 AND wires.toid = objects.id AND address1 != \'NULL\' AND wires.fromid = 2 ORDER BY name1 ASC;',''),(60,1,'2013-07-15 22:06:07','2013-07-16 00:09:08',NULL,'Expiring in 2013, ordered by END','','',NULL,'','','','','',NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL,NULL,'SELECT *, objects.id AS objectsid FROM objects, wires WHERE objects.active = 1 AND end >= \'$now\' AND wires.active = 1 AND wires.toid = objects.id AND address1 != \'NULL\' AND wires.fromid = 2 ORDER BY end ASC;',''),(61,1,'2013-07-15 22:06:16','2013-07-15 23:45:49',NULL,'New subscriptions, ordered by BEGIN','','',NULL,'','','','','',NULL,NULL,'','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL,NULL,'SELECT *, objects.id AS objectsid FROM objects, wires WHERE objects.active = 1 AND begin > \"2012-01-01\" AND wires.active = 1 AND wires.toid = objects.id AND address1 != \'NULL\' AND wires.fromid = 2 ORDER BY name1 ASC;','');
/*!40000 ALTER TABLE `objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wires`
--

DROP TABLE IF EXISTS `wires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wires` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `fromid` int(10) unsigned DEFAULT NULL,
  `toid` int(10) unsigned DEFAULT NULL,
  `weight` float NOT NULL DEFAULT '1',
  `notes` blob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wires`
--

LOCK TABLES `wires` WRITE;
/*!40000 ALTER TABLE `wires` DISABLE KEYS */;
INSERT INTO `wires` VALUES (1,1,'2013-07-11 21:05:15','2013-07-11 21:05:15',0,1,1,NULL),(2,1,'2013-07-11 21:05:25','2013-07-11 21:05:25',0,2,1,NULL),(3,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,3,1,NULL),(4,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,4,1,NULL),(5,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,5,1,NULL),(6,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,6,1,NULL),(7,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,7,1,NULL),(8,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,8,1,NULL),(9,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,9,1,NULL),(10,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,10,1,NULL),(11,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,11,1,NULL),(12,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,12,1,NULL),(13,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,13,1,NULL),(14,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,14,1,NULL),(15,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,15,1,NULL),(16,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,16,1,NULL),(17,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,17,1,NULL),(18,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,18,1,NULL),(19,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,19,1,NULL),(20,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,20,1,NULL),(21,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,21,1,NULL),(22,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,22,1,NULL),(23,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,23,1,NULL),(24,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,24,1,NULL),(25,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,25,1,NULL),(26,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,26,1,NULL),(27,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,27,1,NULL),(28,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,28,1,NULL),(29,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,29,1,NULL),(30,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,30,1,NULL),(31,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,31,1,NULL),(32,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,32,1,NULL),(33,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,33,1,NULL),(34,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,34,1,NULL),(35,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,35,1,NULL),(36,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,36,1,NULL),(37,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,37,1,NULL),(38,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,38,1,NULL),(39,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,39,1,NULL),(40,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,40,1,NULL),(41,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,41,1,NULL),(42,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,42,1,NULL),(43,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,43,1,NULL),(44,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,44,1,NULL),(45,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,45,1,NULL),(46,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,46,1,NULL),(47,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,47,1,NULL),(48,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,48,1,NULL),(49,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,49,1,NULL),(50,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,50,1,NULL),(51,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,51,1,NULL),(52,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,52,1,NULL),(53,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,53,1,NULL),(54,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,54,1,NULL),(55,1,'2013-07-11 00:00:00','2013-07-11 00:00:00',2,55,1,NULL),(58,0,'2013-07-15 16:12:25','2013-07-15 16:12:25',2,58,1,NULL),(59,1,'2013-07-15 22:05:51','2013-07-15 22:05:51',1,59,1,NULL),(60,1,'2013-07-15 22:06:07','2013-07-15 22:06:07',1,60,1,NULL),(61,1,'2013-07-15 22:06:16','2013-07-15 22:06:16',1,61,1,NULL),(62,1,'2013-07-16 00:00:12','2013-07-16 00:00:12',1,62,1,NULL);
/*!40000 ALTER TABLE `wires` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-17 10:40:08
