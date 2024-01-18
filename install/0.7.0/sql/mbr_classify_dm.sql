drop table if exists %prfx%mbr_classify_dm;
create table %prfx%mbr_classify_dm (
  code smallint auto_increment primary key
  ,description varchar(40) not null
  ,default_flg char(1) not null
  ,max_fines decimal(4,2) not null
)
  ENGINE=MyISAM
;
