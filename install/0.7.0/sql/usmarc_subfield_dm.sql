drop table if exists %prfx%usmarc_subfield_dm;
CREATE TABLE %prfx%usmarc_subfield_dm (
  tag smallint NOT NULL
  ,subfield_cd char(1) NOT NULL
  ,description varchar(80) NOT NULL
  ,repeatable_flg char(1) NOT NULL
  ,PRIMARY KEY  (tag,subfield_cd)
)  ENGINE=MyISAM
;
