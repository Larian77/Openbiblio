drop table if exists %prfx%biblio_status_dm;
create table %prfx%biblio_status_dm (
  code char(3) primary key
  ,description varchar(40) not null
  ,default_flg char(1) not null
)
  ENGINE=MyISAM
;
