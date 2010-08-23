
CREATE TABLE IF NOT EXISTS `PHPCAL_calendar` (
  `id` int(11) NOT NULL auto_increment,
  `event_id` int(10) NOT NULL default '0',
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `PHPCAL_events` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

