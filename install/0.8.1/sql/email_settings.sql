drop table if exists %prfx%mail_settings;
create table %prfx%mail_settings (
  id integer auto_increment primary key
  ,pwd_forgotten_settings int(1) not null
  ,pwd_forgotten_code_duration integer(3) not null
  ,mail_process integer(1) not null
  ,mail_host varchar(64) null
  ,mail_user varchar(64) null
  ,mail_pwd varchar(128) null
  ,mail_smtp_secure varchar(32) null
)
  ENGINE=MyISAM
;
