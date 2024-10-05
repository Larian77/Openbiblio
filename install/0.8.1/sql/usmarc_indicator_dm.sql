drop table if exists %prfx%usmarc_indicator_dm;
CREATE TABLE %prfx%usmarc_indicator_dm (
  tag smallint NOT NULL
  ,indicator_nmbr tinyint not null
  ,indicator_cd char(1) NOT NULL
  ,description varchar(80) NOT NULL
  ,PRIMARY KEY  (tag,indicator_nmbr,indicator_cd)
)  ENGINE=MyISAM
;
