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
`type_title` varchar(255) NOT NULL DEFAULT '',
`type_alias` varchar(255) NOT NULL DEFAULT '',
`title_holder` varchar(255) NULL,
`table_values` varchar(255) NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `#__user_logs_extensions` (`type_title`, `type_alias`, `title_holder`, `table_values`) VALUES
('article', 'com_content.article', 'title' ,'{"table_type":"Content","table_prefix":"JTable"}'),
('article', 'com_content.form', 'title' ,'{"table_type":"Content","table_prefix":"JTable"}'),
('banner', 'com_banners.banner', 'name' ,'{"table_type":"Banner","table_prefix":"BannersTable"}'),
('user_note', 'com_users.note', 'subject' ,'{"table_type":"Note","table_prefix":"UsersTable"}'),
('media', 'com_media.file', 'name' ,'{"table_type":"","table_prefix":""}'),
('category', 'com_categories.category', 'title' ,'{"table_type":"Category","table_prefix":"JTable"}'),
('menu', 'com_menus.menu', 'title' ,'{"table_type":"Menu","table_prefix":"JTable"}'),
('menu_item', 'com_menus.item', 'title' ,'{"table_type":"Menu","table_prefix":"JTable"}'),
('newsfeed', 'com_newsfeeds.newsfeed', 'name' ,'{"table_type":"Newsfeed","table_prefix":"NewsfeedsTable"}'),
('link', 'com_redirect.link', 'old_url' ,'{"table_type":"Link","table_prefix":"RedirectTable"}'),
('tag', 'com_tags.tag', 'title' ,'{"table_type":"Tag","table_prefix":"TagsTable"}'),
('style', 'com_templates.style', 'title' ,'{"table_type":"","table_prefix":""}'),
('plugin', 'com_plugins.plugin', 'name' ,'{"table_type":"Extension","table_prefix":"JTable"}'),
('component_config', 'com_config.component', 'name', '{"table_type":"","table_prefix":""}'),
('contact', 'com_contact.contact', 'name', '{"table_type":"Contact","table_prefix":"ContactTable"}'),
('module', 'com_modules.module', 'title', '{"table_type":"Module","table_prefix":"JTable"}');
