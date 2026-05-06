-- Default admin staff account (password: Administrator#1)
-- Hash generated with: password_hash('Administrator#1', PASSWORD_DEFAULT)
INSERT INTO staff (
  create_dt, last_change_dt, last_change_userid,
  username, pwd, last_name, first_name,
  suspended_flg, admin_flg, circ_flg, circ_mbr_flg, catalog_flg, reports_flg
) VALUES (
  NOW(), NOW(), 0,
  'admin', '$2y$10$9bp7an1FEkeS5YAu5As4yeMD80shIvQBLuDyrltMDdyi.MXAf9hzW',
  'Admin', 'Admin',
  'N', 'Y', 'Y', 'Y', 'Y', 'Y'
);
