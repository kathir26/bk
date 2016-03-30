<?php 
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('productInfo')};
CREATE TABLE IF NOT EXISTS {$this->getTable('productInfo')} (
  `productInfo_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `location` varchar(255) NOT NULL,
  `fk_product_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY (`productInfo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
");
$installer->endSetup();