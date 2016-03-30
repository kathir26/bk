<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn(
	$installer->getTable('events'),
	'event_start_date',
	'date NOT NULL AFTER `event_position`'
);
$installer->getConnection()->addColumn(
	$installer->getTable('events'),
	'event_end_date',
	'date NOT NULL AFTER `event_start_date`'
);
$installer->getConnection()->addColumn(
	$installer->getTable('events'),
	'event_banner',
	'tinyint(3) NOT NULL AFTER `event_end_date`'
);
$installer->getConnection()->addColumn(
	$installer->getTable('events'),
	'event_url',
	'varchar(255) NOT NULL AFTER `event_banner`'
);
$installer->endSetup();

?>