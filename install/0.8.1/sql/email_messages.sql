    drop table if exists %prfx%mail_messages;
create table %prfx%mail_messages (
  id integer auto_increment primary key
  ,mail_message_type varchar(64) not null
  ,mail_from_mail varchar(128) null
  ,mail_from_name varchar(128) null
  ,mail_subject varchar(64) null
  ,mail_body_html mediumtext null
  ,mail_body_plain mediumtext null
  ,mail_html integer(5) not null
)
  ENGINE=MyISAM
;