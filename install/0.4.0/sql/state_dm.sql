drop table if exists %prfx%state_dm;
create table %prfx%state_dm (
  code char(2) primary key
  ,description varchar(20) not null
  ,default_flg char(1) not null
)
  ENGINE=MyISAM
;
