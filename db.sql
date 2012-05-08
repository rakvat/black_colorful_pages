-- contact datasets
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL auto_increment,
  `name` int(8) NOT NULL,
  `short_description` int(8),
  `description` int(8),
  `resources` int(8),
  `base_address` int(8),
  `addresses` int(8),
  `contact` int(8),
  `group` tinyint(1) default NULL,
  `location` tinyint(1) default NULL,
  `media` tinyint(1) default NULL,
  `e_mail` text,
  `geo_coordinates` varchar(16) default NULL,
  `image_or_logo` text,
  `state` text NOT NULL,
  `released` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1;

-- language table for (currently) two languages
CREATE TABLE `contacts_lang` (
  `id` int(11) NOT NULL auto_increment,
  `language1` text NOT NULL,
  `language2` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1;


