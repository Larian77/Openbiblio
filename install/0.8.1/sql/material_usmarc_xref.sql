drop table if exists %prfx%material_usmarc_xref;
create table %prfx%material_usmarc_xref (
  `xref_id` int(11) NOT NULL auto_increment,
  `materialCd` int(11) NOT NULL default '0',
  `tag` char(3) NOT NULL default '',
  `subfieldCd` char(1) NOT NULL default '',
  `descr` varchar(64) NOT NULL default '',
  `required` char(1) NOT NULL default '',
  `cntrltype` char(1) NOT NULL default '',
  PRIMARY KEY  (`xref_id`)
) ENGINE=MyISAM;
