drop table if exists %prfx%member_fields;
create table %prfx%member_fields (
  mbrid integer NOT NULL,
  code varchar(16) NOT NULL,
  data text NOT NULL,
  PRIMARY KEY (mbrid, code),
  INDEX code_index (code)
) ENGINE=MyISAM;
