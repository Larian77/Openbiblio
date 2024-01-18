drop table if exists %prfx%mbr_classify_dm;
create table %prfx%mbr_classify_dm (
  code char(1) primary key
  ,description varchar(40) not null
  ,default_flg char(1) not null
)
  ENGINE=MyISAM
;
