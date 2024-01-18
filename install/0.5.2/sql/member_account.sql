drop table if exists %prfx%member_account;
create table %prfx%member_account (
  mbrid integer not null
  ,transid integer auto_increment not null
  ,create_dt datetime not null
  ,create_userid integer not null
  ,transaction_type_cd char(2) not null
  ,amount decimal(8,2) not null
  ,description varchar(128) null
  ,primary key(mbrid,transid)
  )
  ENGINE=MyISAM
;
