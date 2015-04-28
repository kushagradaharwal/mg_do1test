<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('orderfeedback')};
CREATE TABLE {$this->getTable('orderfeedback')} (
  `orderfeedback_id` int(11) unsigned NOT NULL auto_increment,
  `orderid` varchar(255) NOT NULL default '',
  `fullname` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `adminfeedback` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`orderfeedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 