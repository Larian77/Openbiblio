drop table if exists %prfx%biblio_field;
create table %prfx%biblio_field (
  bibid integer not null
  ,fieldid integer auto_increment not null
  ,tag smallint not null
  ,ind1_cd char(1) null
  ,ind2_cd char(1) null
  ,subfield_cd char(1) not null
  ,field_data text null
  ,primary key(bibid,fieldid)
  )
  ENGINE=MyISAM
;
