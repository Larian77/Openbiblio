drop table if exists %prfx%checkout_privs;
create table %prfx%checkout_privs (
  material_cd smallint NOT NULL,
  classification smallint NOT NULL,
  checkout_limit tinyint unsigned NOT NULL,
  renewal_limit tinyint unsigned NOT NULL,
  PRIMARY KEY (material_cd, classification)
)
  ENGINE=MyISAM
;
