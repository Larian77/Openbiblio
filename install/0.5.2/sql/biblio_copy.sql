drop table if exists %prfx%biblio_copy;
create table %prfx%biblio_copy (
  bibid integer not null
  ,copyid integer auto_increment not null
  ,copy_desc varchar(160) null
  ,barcode_nmbr varchar(20) not null
  ,status_cd char(3) not null
  ,status_begin_dt datetime not null
  ,due_back_dt date null
  ,mbrid integer null
  ,renewal_count tinyint unsigned not null
  ,index barcode_index (barcode_nmbr)
  ,index mbr_index (mbrid)
  ,primary key(bibid,copyid)
  )
  ENGINE=MyISAM
;
