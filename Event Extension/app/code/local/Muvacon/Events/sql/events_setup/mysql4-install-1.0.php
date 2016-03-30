<?php 
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('events')};
CREATE TABLE IF NOT EXISTS {$this->getTable('events')} (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_description` blob NOT NULL,
  `event_image` varchar(100) NOT NULL,
  `event_place` varchar(255) NOT NULL,
  `event_language` varchar(100) NOT NULL,
  `event_position` tinyint(3) NOT NULL,
  `event_start_date` date NOT NULL,
  `event_end_date` date NOT NULL,
  `event_banner` tinyint(3) NOT NULL,
  `event_url` varchar(255) NOT NULL,
  `event_day1` varchar(255) NOT NULL,
  `event_day2` varchar(255) NOT NULL,
  `event_day3` varchar(255) NOT NULL,
  `event_day4` varchar(255) NOT NULL,
  `event_day5` varchar(255) NOT NULL,
  `event_day6` varchar(255) NOT NULL,
  `event_day7` varchar(255) NOT NULL,
  `event_created_date` datetime NOT NULL,
  `event_updated_date` datetime NOT NULL,
  `event_status` tinyint(2) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
");
$installer->endSetup();