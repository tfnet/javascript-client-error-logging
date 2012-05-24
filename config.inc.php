<?php 

/*
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `dev_log`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `js_error`
--

CREATE TABLE IF NOT EXISTS `js_error` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `line` varchar(30) DEFAULT NULL,
  `parent_url` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

*/

$link = mysql_connect('127.0.0.1','develop','develop');
	
$dbres= mysql_select_db('dev_log',$link);
$default_refresh = 30;
?>