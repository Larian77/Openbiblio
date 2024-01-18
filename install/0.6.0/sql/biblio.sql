drop table if exists %prfx%biblio;
create table %prfx%biblio (
  bibid integer auto_increment primary key
  ,create_dt datetime not null
  ,last_change_dt datetime not null
  ,last_change_userid integer not null
  ,material_cd smallint not null
  ,collection_cd smallint not null
  ,call_nmbr1 varchar(20) null
  ,call_nmbr2 varchar(20) null
  ,call_nmbr3 varchar(20) null
  ,title text null
  ,title_remainder text null
  ,responsibility_stmt text null
  ,author text null
  ,topic1 text null
  ,topic2 text null
  ,topic3 text null
  ,topic4 text null
  ,topic5 text null
  ,opac_flg char(1) not null
  )
  ENGINE=MyISAM
;
