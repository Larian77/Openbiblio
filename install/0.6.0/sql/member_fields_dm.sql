drop table if exists %prfx%member_fields_dm;
create table %prfx%member_fields_dm (
  code varchar(16) NOT NULL,
  description char(32) NOT NULL,
  default_flg char(1) NOT NULL,
  PRIMARY KEY (code)
) ENGINE=MyISAM;
