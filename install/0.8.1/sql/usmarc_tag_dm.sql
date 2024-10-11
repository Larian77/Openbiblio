drop table if exists %prfx%usmarc_tag_dm;
CREATE TABLE %prfx%usmarc_tag_dm (
  block_nmbr tinyint NOT NULL
  ,tag smallint NOT NULL
  ,description varchar(80) NOT NULL
  ,ind1_description varchar(80) NOT NULL
  ,ind2_description varchar(80) NOT NULL
  ,repeatable_flg char(1) NOT NULL
  ,PRIMARY KEY  (block_nmbr,tag)
)  ENGINE=MyISAM
;
