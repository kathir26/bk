<?php 
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('testimonials')};
CREATE TABLE IF NOT EXISTS {$this->getTable('testimonials')} (
  `testimonials_id` int(11) NOT NULL AUTO_INCREMENT,
  `testimonials_name` varchar(255) NOT NULL,
  `testimonials_content` blob NOT NULL,
  `testimonials_color` varchar(20) NOT NULL,
  `testimonials_language` varchar(100) NOT NULL,
  `testimonials_position` tinyint(3) NOT NULL,
  `testimonials_image` varchar(100) NOT NULL,
  `testimonials_created_date` datetime NOT NULL,
  `testimonials_updated_date` datetime NOT NULL,
  `testimonials_status` tinyint(2) NOT NULL,
  PRIMARY KEY (`testimonials_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
");
$installer->endSetup();