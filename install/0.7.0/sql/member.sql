drop table if exists %prfx%member;
create table %prfx%member (
  mbrid integer auto_increment primary key
  ,barcode_nmbr varchar(20) not null
  ,create_dt datetime not null
  ,last_change_dt datetime not null
  ,last_change_userid integer not null
  ,last_name varchar(50) not null
  ,first_name varchar(50) not null
  ,address text null
  ,home_phone varchar(15) null
  ,work_phone varchar(15) null
  ,email varchar(128) null
  ,classification smallint not null
  ,mbrshipend date not null
  )
  ENGINE=MyISAM
;
