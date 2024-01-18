drop table if exists %prfx%session;
create table %prfx%session (
  userid integer(5) not null
  ,last_updated_dt datetime not null
  ,token integer(5) not null
  )
  ENGINE=MyISAM
;
