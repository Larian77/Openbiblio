drop table if exists %prfx%biblio_copy_fields;
create table %prfx%biblio_copy_fields (
  bibid integer NOT NULL,
  copyid integer NOT NULL,
  code varchar(16) NOT NULL,
  data text NOT NULL,
  PRIMARY KEY (bibid, copyid, code),
  INDEX code_index (code)
) ENGINE=MyISAM;
