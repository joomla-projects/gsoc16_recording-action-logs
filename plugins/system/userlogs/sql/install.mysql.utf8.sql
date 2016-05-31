CREATE TABLE IF NOT EXISTS `#__user_logs` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`message` text NOT NULL DEFAULT '',
`log_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`extension` varchar(50) NOT NULL DEFAULT '',
`user_id` int(11) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
