<?php 
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('partners')};
CREATE TABLE IF NOT EXISTS {$this->getTable('partners')} (
  `partners_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_description` blob NOT NULL,
  `company_logo` varchar(100) NOT NULL,
  `company_language` varchar(100) NOT NULL,
  `company_position` tinyint(3) NOT NULL,
  `company_created_date` datetime NOT NULL,
  `company_updated_date` datetime NOT NULL,
  `company_status` tinyint(2) NOT NULL,
  PRIMARY KEY (`partners_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- DROP TABLE IF EXISTS {$this->getTable('partnersimage')};
CREATE TABLE IF NOT EXISTS {$this->getTable('partnersimage')} (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_company_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_type` varchar(20) NOT NULL,
  `image_status` tinyint(2) NOT NULL,
  `image_created_date` datetime NOT NULL,
  `image_updated_date` datetime NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");
$installer->endSetup();