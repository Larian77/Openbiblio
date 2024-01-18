drop table if exists %prfx%biblio_status_hist;
create table %prfx%biblio_status_hist (
  bibid integer not null
  ,copyid integer not null
  ,status_cd char(3) not null
  ,status_begin_dt datetime not null
  ,due_back_dt date null
  ,mbrid integer null
  ,renewal_count tinyint unsigned not null
  ,index mbr_index (mbrid)
  ,index copy_index (bibid,copyid)
  )
  ENGINE=MyISAM
;
