drop table if exists %prfx%usmarc_block_dm;
create table %prfx%usmarc_block_dm (
  block_nmbr tinyint primary key
  ,description varchar(80) not null
)
  ENGINE=MyISAM
;
