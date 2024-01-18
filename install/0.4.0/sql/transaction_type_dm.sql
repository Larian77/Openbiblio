drop table if exists %prfx%transaction_type_dm;
create table %prfx%transaction_type_dm (
  code char(2) primary key
  ,description varchar(40) not null
  ,default_flg char(1) not null
)
  ENGINE=MyISAM
;
