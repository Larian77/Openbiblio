/*!40100 set old_passwords = 1 */;
insert into %prfx%staff
values (null
  ,sysdate()
  ,sysdate()
  ,1
  ,'admin'
  ,password('admin')
  ,'Administrator'
  ,null
  ,'N'
  ,'Y'
  ,'Y'
  ,'Y'
  ,'Y'
  ,'Y'
)
;
