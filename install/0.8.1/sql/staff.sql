drop table if exists %prfx%staff;
create table %prfx%staff (
  userid integer auto_increment primary key
  ,create_dt datetime not null
  ,last_change_dt datetime not null
  ,last_change_userid integer not null
  ,username varchar(20) not null
  ,pwd varchar(255) not null
  ,pwd_timeout datetime not null
  ,pwd_forgotten varchar(255) null
  ,pwd_forgotten_time datetime null
  ,last_name varchar(30) not null
  ,first_name varchar(30) null
  ,email varchar(128) null
  ,suspended_flg char(1) not null
  ,admin_flg char(1) not null
  ,circ_flg char(1) not null
  ,circ_mbr_flg char(1) not null
  ,catalog_flg char(1) not null
  ,reports_flg char(1) not null
  )
  ENGINE=MyISAM
;
