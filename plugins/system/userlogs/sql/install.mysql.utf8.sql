CREATE TABLE IF NOT EXISTS `#__user_logs` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`message` text NOT NULL DEFAULT '',
`log_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`extension` varchar(50) NOT NULL DEFAULT '',
`user_id` int(11) NOT NULL DEFAULT 0,
`ip_address` VARCHAR(30) NOT NULL DEFAULT 'PLG_SYSTEM_USERLOG_DISABLED',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__user_logs_extensions` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`extension` varchar(50) UNIQUE NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_banners');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_categories');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_config');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_cache');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_contact');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_content');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_installer');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_media');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_menus');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_messages');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_modules');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_newsfeeds');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_plugins');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_redirect');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_tags');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_templates');
INSERT INTO `#__user_logs_extensions` (`extension`) VALUES ('com_users');
