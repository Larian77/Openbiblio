drop table if exists %prfx%material_type_dm;
create table %prfx%material_type_dm (
  code smallint auto_increment primary key
  ,description varchar(40) not null
  ,default_flg char(1) not null
  ,adult_checkout_limit tinyint unsigned not null
  ,juvenile_checkout_limit tinyint unsigned not null
  ,image_file varchar(128) null
)
  ENGINE=MyISAM
;
