drop table if exists %prfx%theme;
create table %prfx%theme (
  themeid smallint auto_increment primary key
  ,theme_name varchar(40) not null
  ,title_bg varchar(20) not null
  ,title_font_face varchar(128) not null
  ,title_font_size tinyint not null
  ,title_font_bold char(1) not null
  ,title_font_color varchar(20) not null
  ,title_align varchar(30) not null
  ,primary_bg varchar(20) not null
  ,primary_font_face varchar(128) not null
  ,primary_font_size tinyint not null
  ,primary_font_color varchar(20) not null
  ,primary_link_color varchar(20) not null
  ,primary_error_color varchar(20) not null
  ,alt1_bg varchar(20) not null
  ,alt1_font_face varchar(128) not null
  ,alt1_font_size tinyint not null
  ,alt1_font_color varchar(20) not null
  ,alt1_link_color varchar(20) not null
  ,alt2_bg varchar(20) not null
  ,alt2_font_face varchar(128) not null
  ,alt2_font_size tinyint not null
  ,alt2_font_color varchar(20) not null
  ,alt2_link_color varchar(20) not null
  ,alt2_font_bold char(1) not null
  ,border_color varchar(20) not null
  ,border_width tinyint not null
  ,table_padding tinyint not null
)
  ENGINE=MyISAM
;
