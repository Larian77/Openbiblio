drop table if exists %prfx%biblio_hold;
create table %prfx%biblio_hold (
  bibid integer not null
  ,copyid integer not null
  ,holdid integer auto_increment not null
  ,hold_begin_dt datetime not null
  ,mbrid integer not null
  ,index mbr_index (mbrid)
  ,primary key(bibid,copyid,holdid)
  )
  ENGINE=MyISAM
;
