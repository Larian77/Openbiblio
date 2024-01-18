drop table if exists %prfx%member;
create table %prfx%member (
  mbrid integer auto_increment primary key
  ,barcode_nmbr varchar(20) not null
  ,create_dt datetime not null
  ,last_change_dt datetime not null
  ,last_change_userid integer not null
  ,last_name varchar(50) not null
  ,first_name varchar(50) not null
  ,address1 varchar(128) null
  ,address2 varchar(128) null
  ,city varchar(50) null
  ,state char(2) null
  ,zip mediumint null
  ,zip_ext smallint null
  ,home_phone varchar(15) null
  ,work_phone varchar(15) null
  ,email varchar(128) null
  ,classification char(1) not null
  ,school_grade tinyint null
  ,school_teacher varchar(50) null
  ,mbrshipend date not null
  )
  ENGINE=MyISAM
;
