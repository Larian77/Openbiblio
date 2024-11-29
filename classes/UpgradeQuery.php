<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../classes/InstallQuery.php");

class UpgradeQuery extends InstallQuery {

  function UpgradeQuery() {
    # Call query constructor so database connection gets made
    $this->Query();
  }
  function insertBiblioFields($tag, $subFieldCd, 
                              $fromTablePrfx, $toTablePrfx,  $colName){
    $sql = "insert into ".$toTablePrfx."biblio_field"
          ."(bibid, fieldid, tag,   ind1_cd,ind2_cd,subfield_cd,     field_data) select "
          ." bibid, null,  ".$tag.",null,   null,'".$subFieldCd."',".$colName
          ." from ".$fromTablePrfx."biblio "
          ."where ".$colName." is not null";
    $this->exec($sql);
   }
   
   function copyDataToNewTable($tableName, $fromTablePrfx, $toTablePrfx, $sqlSelectConversion) {
        $sql = "delete from ".$toTablePrfx.$tableName;
        !$this->exec($sql);
        $conv = "(".implode(", ", array_keys($sqlSelectConversion)).") "
                . "select ".implode(", ", array_values($sqlSelectConversion));
        $sql = "insert into ".$toTablePrfx.$tableName." "
              .$conv
              ." from ".$fromTablePrfx.$tableName;
        $this->exec($sql);
   }
   
   function renamePrfxedTable($tableName, $fromTablePrfx, $toTablePrfx) {
     return $this->renameTable($fromTablePrfx.$tableName, $toTablePrfx.$tableName);
   }

   # Test whether the column $column exists in table $tableName
   function columnExists($tableName, $column) {
     $sql = "describe ".$tableName;
     $rows = $this->exec($sql);
     if (is_array($rows)) {
       $columns = array();
       foreach ($rows as $row) {
         if (is_array($row)) {
           if (!empty($row["Field"])) {
             # mysql 5
             $columns[] = $row["Field"];
           } else {
             # older versions
             $columns[] = $row[0];
         }
         }
       }
       return in_array($column, $columns);
     } else {
       return false;
     }
   }

  # Returns array($notices, $error).
  # On failure, $error is an Error and $notices should not be used.
  # On success, $error is NULL and $notices is an array of strings
  # notifying the user of upgrade changes.
  function performUpgrade_e($fromTablePrfx = DB_TABLENAME_PREFIX, $toTablePrfx = DB_TABLENAME_PREFIX) {
    # Each of these routines should update the given version to the next higher version.
    $upgrades = array(
      '0.3.0' => '_upgrade030_e',
      '0.4.0' => '_upgrade040_e',
      '0.5.2' => '_upgrade052_e',
      '0.6.0' => '_upgrade060_e',
      '0.7.0' => '_upgrade071_e',
      '0.7.1' => '_upgrade081_e'
    );    
    $tmpPrfx = "obiblio_upgrade_";
    # FIXME - translate upgrade messages
    $locale = $this->getCurrentLocale($fromTablePrfx);

    $notices = array();
    # Do this first so new tables always have a prefix, if desired.
    if ($fromTablePrfx != $toTablePrfx) {
      $this->renameTables($fromTablePrfx, $toTablePrfx);
    }
    do {
      $version = $this->getCurrentDatabaseVersion($toTablePrfx);
      if ($version == OBIB_LATEST_DB_VERSION) {
        break;	# Done
      } elseif (isset($upgrades[$version])) {
        $func = $upgrades[$version];
        list($n, $error) = $this->$func($toTablePrfx, $tmpPrfx);
        if ($error) {
          return array(NULL, $error);
        }
        $notices = array_merge($notices, $n);
      } elseif (!$version) {
        $error = new ObibError("No existing OpenBiblio database, please perform a fresh install.");
        return array(NULL, $error);
      } else {
        $error = new ObibError('Unknown database version: '.$version.'.  No automatic upgrade routine available.');
        return array(NULL, $error);
      }
    } while (1);
    return array($notices, NULL);
  }
  # Individual upgrade functions
  # Each of these should upgrade the indicated database version by one version.
  # $prfx is the table prefix to be used by both the original and upgraded databases.
  # $tmpPrfx is a prefix which may be used for temporary tables.
  # Return value is the same as performUpgrade_e()
  
  /* Upgrade 0.3.0 to 0.4.0 */
  function _upgrade030_e($prfx, $tmpPrfx) {
    # 0.3.0 was English only
    $this->freshInstall('en', false, '0.4.0', $tmpPrfx);

    # marc data conversion
    $fields = array(
      'edition' => array(250, 'a'),
      'isbn_nmbr' => array(20, 'a'),
      'lccn_nmbr' => array(10, 'a'),
      'lc_call_nmbr' => array(50, 'a'),
      'lc_item_nmbr' => array(50, 'b'),
      'udc_nmbr' => array(82, 'a'),
      'udc_ed_nmbr' => array(82, '2'),
      'publication_loc' => array(260, 'a'),
      'publisher' => array(260, 'b'),
      'publication_dt' => array(260, 'c'),
      'summary' => array(520, 'a'),
      'pages' => array(300, 'a'),
      'physical_details' => array(300, 'b'),
      'dimensions' => array(300, 'c'),
      'accompanying' => array(300, 'e'),
      'price' => array(20, 'c'),
    );
    foreach ($fields as $fname => $marc) {
      $this->insertBiblioFields($marc[0], $marc[1], $prfx, $tmpPrfx, $fname);
    }
    
    # biblio table conversion
    $this->copyDataToNewTable("biblio", $prfx, $tmpPrfx,
                              array(
                                "bibid" => "bibid",
                                "create_dt" => "create_dt",
                                "last_change_dt" => "last_updated_dt",
                                //TODO: Currently using 1 for last_change_userid, get real id
                                "last_change_userid" => "1",
                                "material_cd" => "material_cd",
                                "collection_cd" => "collection_cd",
                                "call_nmbr1" => "call_nmbr",
                                "call_nmbr2" => "NULL",
                                "call_nmbr3" => "NULL",
                                "title" => "title",
                                "title_remainder" => "subtitle",
                                "responsibility_stmt" => "trim(concat(author,' ',add_author))",
                                "author" => "author",
                                "topic1" => "NULL",
                                "topic2" => "NULL",
                                "topic3" => "NULL",
                                "topic4" => "NULL",
                                "topic5" => "NULL",
                                "opac_flg" => "'Y'",
                              ));
   
    # biblio_status -> biblio_copy conversion
    $sql = "insert into ".$tmpPrfx."biblio_copy "
."(bibid,  copyid,copy_desc,barcode_nmbr,  status_cd,                status_begin_dt,                       due_back_dt,   mbrid) select"
." b.bibid,null,  null,     b.barcode_nmbr,ifnull(bs.status_cd,'in'),ifnull(bs.status_begin_dt,b.create_dt),bs.due_back_dt,bs.mbrid from "
          .$prfx."biblio as b "
          ."left join ".$prfx."biblio_status as bs on b.bibid=bs.bibid";
    $this->exec($sql);
    
    $sql = "update ".$tmpPrfx."biblio_copy set status_cd = 'hld' where status_cd = 'cll'";
    $this->exec($sql);
    
    $this->dropTable($prfx.'biblio');
    $this->dropTable($prfx.'biblio_copy');

    #collection_dm data conversion
    $this->copyDataToNewTable("collection_dm", $prfx, $tmpPrfx,
                              array(
                                "code" => "code",
                                "description" => "description",
                                "default_flg" => "default_flg",
                                "days_due_back" => "days_due_back",
                                "daily_late_fee" => "0.00",
                              ));
    
    $this->dropTable($prfx.'collection_dm');

    #member table conversion
    $this->copyDataToNewTable("member", $prfx, $tmpPrfx,
                              array(
                                "mbrid" => "mbrid",
                                "barcode_nmbr" => "barcode_nmbr",
                                "create_dt" => "create_dt",
                                "last_change_dt" => "sysdate()",
                                "last_change_userid" => "1",
                                "last_name" => "last_name",
                                "first_name" => "first_name",
                                "address1" => "address1",
                                "address2" => "address2",
                                "city" => "city",
                                "state" => "state",
                                "zip" => "zip",
                                "zip_ext" => "zip_ext",
                                "home_phone" => "home_phone",
                                "work_phone" => "work_phone",
                                "email" => "NULL",
                                "classification" => "classification",
                                "school_grade" => "school_grade",
                                "school_teacher" => "school_teacher",
                              ));

    $this->dropTable($prfx.'member');

    #staff table conversion
    $this->copyDataToNewTable("staff", 
                              $prfx, $tmpPrfx,
                              array(
                                "userid" => "userid",
                                "create_dt" => "create_dt",
                                "last_change_dt" => "last_updated_dt",
                                "last_change_userid" => "1",
                                "username" => "username",
                                "pwd" => "pwd",
                                "last_name" => "last_name",
                                "first_name" => "first_name",
                                "suspended_flg" => "suspended_flg",
                                "admin_flg" => "admin_flg",
                                "circ_flg" => "circ_flg",
                                "circ_mbr_flg" => "circ_flg",
                                "catalog_flg" => "catalog_flg",
                                "reports_flg" => "admin_flg",
                              ));
    
    $this->dropTable($prfx.'staff');

    #settings data conversion
    $this->copyDataToNewTable("settings", 
                              $prfx, $tmpPrfx,
                              array(
                                "library_name" => "library_name",
                                "library_image_url" => "library_image_url",
                                "use_image_flg" => "use_image_flg",
                                "library_hours" => "library_hours",
                                "library_phone" => "library_phone",
                                "library_url" => "library_url",
                                "opac_url" => "opac_url",
                                "session_timeout" => "session_timeout",
                                "items_per_page" => "items_per_page",
                                "version" => "'0.4.0'",
                                "themeid" => "1",
                                "purge_history_after_months" => "6",
                                "block_checkouts_when_fines_due" => "'Y'",
                                "locale" => "'en'",
                                "charset" => "'iso-8859-1'",
                                "html_lang_attr" => "NULL",
                              ));

    $this->dropTable($prfx.'settings');
    
    # moving tables that haven't changed in structure,
    # yet may have been modified by the user
    $this->renamePrfxedTable("material_type_dm", $prfx, $tmpPrfx);
    $this->renamePrfxedTable("theme", $prfx, $tmpPrfx);
    $this->renameTables($tmpPrfx, $prfx);
    $notices = array('Any existing hold requests have been forgotten.');
    return array($notices, NULL); # no error
  }
  /* Upgrade 0.4.0 to 0.5.2 */
  function _upgrade040_e($prfx, $tmpPrfx) {
    $settings = $this->exec('select * from '.$prfx.'settings ');
    if (is_dir('../locale/'.$settings[0]['locale'].'/sql/0.5.2/domain')) {
      $domainDir = '../locale/'.$settings[0]['locale'].'/sql/0.5.2/domain';
    } else {
      $domainDir = '../locale/en/sql/0.5.2/domain';
    }
    $this->exec('alter table '.$prfx.'staff modify pwd char(32)');
    $this->exec('update '.$prfx.'staff set pwd=md5(lower(username))');
    # The openbiblio fork by Marcus Bautze (version 0.5.1.7) claims a database
    # version of 0.4.0 but has already the renewal_count column in biblio_copy
    # and biblio_status_hist, so we only add these columns if they don't exist
    # already.
    if (!$this->columnExists($prfx.'biblio_copy', 'renewal_count')) {
      $this->exec('alter table '.$prfx.'biblio_copy '
                  . 'add renewal_count tinyint unsigned not null default 0 '
                  . 'after mbrid ');
    }
    if (!$this->columnExists($prfx.'biblio_status_hist', 'renewal_count')) {
      $this->exec('alter table '.$prfx.'biblio_status_hist '
                  . 'add renewal_count tinyint unsigned not null default 0 '
                  . 'after mbrid ');
    }
    $this->executeSqlFile('../install/0.5.2/sql/checkout_privs.sql', $prfx);
    $this->exec('insert into '.$prfx.'checkout_privs '
                . 'select mat.code material_cd, 1 classification, '
                . 'mat.adult_checkout_limit checkout_limit, '
                . '0 renewal_limit '
                . 'from material_type_dm mat ');
    $this->exec('insert into '.$prfx.'checkout_privs '
                . 'select mat.code material_cd, 2 classification, '
                . 'mat.juvenile_checkout_limit checkout_limit, '
                . '0 renewal_limit '
                . 'from material_type_dm mat ');
    $this->exec('alter table '.$prfx.'material_type_dm '
                . 'drop adult_checkout_limit, '
                . 'drop juvenile_checkout_limit ');
    $this->executeSqlFile('../install/0.5.2/sql/material_usmarc_xref.sql', $prfx);
    $this->exec("update ".$prfx."mbr_classify_dm set code='1' where code='a' ");
    $this->exec("update ".$prfx."mbr_classify_dm set code='2' where code='j' ");
    $this->exec('alter table '.$prfx.'mbr_classify_dm '
                . 'modify code smallint auto_increment, '
                . 'add max_fines decimal(4,2) not null after default_flg ');
    $this->executeSqlFile('../install/0.5.2/sql/member_fields.sql', $prfx);
    $this->executeSqlFile('../install/0.5.2/sql/member_fields_dm.sql', $prfx);
    $this->exec('insert '.$prfx.'member_fields '
                . "select mbrid, 'schoolGrade' code, school_grade data "
                . "from member where school_grade is not null "
                . "and school_grade <> '' ");
    $this->exec('insert '.$prfx.'member_fields '
                . "select mbrid, 'schoolTeacher' code, school_teacher data "
                . "from member where school_teacher is not null "
                . "and school_teacher <> '' ");
    $this->executeSqlFile($domainDir.'/member_fields_dm.sql', $prfx);
    $this->exec("update ".$prfx."member set classification=1 where classification='a' ");
    $this->exec("update ".$prfx."member set classification=2 where classification='j' ");
    $this->exec('alter table '.$prfx.'member '
                . 'add address text null after first_name, '
                . 'modify classification smallint not null ');
    # What a mess
    $this->exec('update '.$prfx.'member set address= '
                . "concat_ws('\n', nullif(address1, ''), nullif(address2, ''), "
                . "concat_ws('', city, concat(', ', nullif(state, '')), "
                . "concat(' ', nullif(zip, ''), ifnull(concat('-', zip_ext), '')))) ");
    $this->exec('alter table '.$prfx.'member '
                . 'drop address1, drop address2, '
                . 'drop city, drop state, drop zip, drop zip_ext, '
                . 'drop school_grade, drop school_teacher ');
    $this->exec('alter table '.$prfx.'settings '
                . 'add hold_max_days smallint not null '
                . 'after block_checkouts_when_fines_due ');
    $this->exec('update '.$prfx.'settings '
                . 'set hold_max_days=14 ');
    $this->exec('drop table '.$prfx.'state_dm ');

    $this->exec('update '.$prfx.'settings set version=\'0.5.2\'');
    $notices = array('All staff passwords have been reset to be equal to the corresponding usernames.');
    return array($notices, NULL); # no error
  }
  /* Upgrade 0.5.2 to 0.6.0 */
  function _upgrade052_e($prfx, $tmpPrfx) {
    $this->exec('alter table '.$prfx.'biblio_copy '
                . 'add create_dt datetime not null '
                . 'after copyid ');
    $this->exec('update biblio_copy bc, biblio b '
                . 'set bc.create_dt=b.create_dt '
                . 'where b.bibid=bc.bibid ');
    $this->exec("update settings set version='0.6.0'");
    $notices = array();
    return array($notices, NULL);
  }
  /* Upgrade 0.6.0 to 0.7.0 */
  function _upgrade060_e($prfx, $tmpPrfx) {
    $this->executeSqlFile('../install/0.7.0/sql/biblio_copy_fields.sql', $prfx);
    $this->executeSqlFile('../install/0.7.0/sql/biblio_copy_fields_dm.sql', $prfx);
    $this->exec("update settings set version='0.7.0'");
    $notices = array();
    return array($notices, NULL);
  }
/* Upgrade 0.7.0 to 0.7.1 */  
   function _upgrade071_e($prfx, $tmpPrfx) {
    # Lift some restrictions
    $this->exec('alter table '.$prfx.'settings '
                . 'modify locale varchar(30) not null ');
    $this->exec('alter table '.$prfx.'collection_dm '
                . 'modify days_due_back smallint unsigned not null ');
    # No new features, remove orphaned database rows (checkout privileges, custom fields).
    $this->exec('delete '.$prfx.'checkout_privs from '.$prfx.'checkout_privs '
                . 'left join '.$prfx.'mbr_classify_dm on '
                . $prfx.'checkout_privs.classification='.$prfx.'mbr_classify_dm.code '
                . 'where '.$prfx.'mbr_classify_dm.code is null ');
    $this->exec('delete '.$prfx.'checkout_privs from '.$prfx.'checkout_privs '
                . 'left join '.$prfx.'material_type_dm on '
                . $prfx.'checkout_privs.material_cd='.$prfx.'material_type_dm.code '
                . 'where '.$prfx.'material_type_dm.code is null ');
    $this->exec('delete '.$prfx.'member_fields from '.$prfx.'member_fields '
                . 'left join '.$prfx.'member_fields_dm on '
                . $prfx.'member_fields.code='.$prfx.'member_fields_dm.code '
                . 'where '.$prfx.'member_fields_dm.code is null ');
    $this->exec('delete '.$prfx.'biblio_copy_fields from '.$prfx.'biblio_copy_fields '
                . 'left join '.$prfx.'biblio_copy_fields_dm on '
                . $prfx.'biblio_copy_fields.code='.$prfx.'biblio_copy_fields_dm.code '
                . 'where '.$prfx.'biblio_copy_fields_dm.code is null ');
    $this->exec('delete '.$prfx.'material_usmarc_xref from '.$prfx.'material_usmarc_xref '
                . 'left join '.$prfx.'material_type_dm on '
                . $prfx.'material_usmarc_xref.materialCd='.$prfx.'material_type_dm.code '
                . 'where '.$prfx.'material_type_dm.code is null ');
    $this->exec("ALTER TABLE " . $prfx . "member "
                    . "ADD mbrshipend date NOT NULL DEFAULT '1000-01-01' ");
    $this->exec("UPDATE " . $prfx . "member SET mbrshipend = '0000-00-00' WHERE mbrshipend = '1000-01-01' ");
    $this->exec("update settings set version='0.7.1'");
    $notices = array();
    return array($notices, NULL);
  }
  /* Upgrade 0.7.1 to 0.8.1 */
  function _upgrade081_e($prfx, $tmpPrfx) {
    $settings = $_POST;
    
    $result = $this->exec("SHOW COLUMNS FROM " . $prfx . "`member` LIKE 'mbrshipend' ");
    if ($result == FALSE) {
        $this->exec("ALTER TABLE " . $prfx . "member "
                    . "ADD mbrshipend date NOT NULL DEFAULT '1000-01-01' ");
        $this->exec("UPDATE " . $prfx . "member SET mbrshipend = '0000-00-00' WHERE mbrshipend = '1000-01-01' ");
    }
    $this->exec('ALTER TABLE ' . $prfx . 'member '
                    . 'ADD pwd VARCHAR(255) AFTER barcode_nmbr ');
    $this->exec("ALTER TABLE " . $prfx . "member "
                    . "ADD pwd_timeout DATETIME NOT NULL DEFAULT '1970-01-01 00:00:00' AFTER pwd ");
    $this->exec('ALTER TABLE ' . $prfx . 'member '
                    . 'ADD pwd_forgotten varchar(255) NULL AFTER pwd_timeout ');
    $this->exec("ALTER TABLE " . $prfx . "member "
                    . "ADD pwd_forgotten_time DATETIME NULL DEFAULT '1970-01-01 00:00:00' AFTER pwd_forgotten ");
    $this->exec('ALTER TABLE ' . $prfx . 'staff MODIFY pwd VARCHAR(255) ');
    $this->exec("ALTER TABLE " . $prfx . "staff "
                    . "ADD pwd_timeout DATETIME NOT NULL DEFAULT '1970-01-01 00:00:00' AFTER pwd ");
    $this->exec('ALTER TABLE ' . $prfx . 'staff '
                    . 'ADD email VARCHAR(128) NULL AFTER first_name ');
    $this->exec('ALTER TABLE ' . $prfx . 'staff '
                    . 'ADD pwd_forgotten varchar(255) NULL AFTER pwd_timeout ');
    $this->exec("ALTER TABLE " . $prfx . "staff "
                    . "ADD pwd_forgotten_time DATETIME NULL DEFAULT '1970-01-01 00:00:00' AFTER pwd_forgotten ");
    $this->exec("UPDATE " . $prfx . 'settings SET version = "' . OBIB_LATEST_DB_VERSION . '"');
    $this->exec('ALTER TABLE ' . $prfx . 'settings '
                    . 'ADD login_attempts INT(2) NOT NULL AFTER html_lang_attr ');
    $this->exec('UPDATE ' . $prfx . 'settings SET login_attempts = ' . $settings["loginAttempts"]);
    $this->exec('ALTER TABLE ' . $prfx . 'settings '
                    . 'ADD pwd_timeout INT(2) NOT NULL AFTER login_attempts ');
    $this->exec('UPDATE ' . $prfx . 'settings SET pwd_timeout = ' . $settings["pwdTimeout"]);
    $this->exec('ALTER TABLE ' . $prfx . 'settings '
                    . 'ADD mbraccount_online CHAR(1) ');
    $this->exec('UPDATE ' . $prfx . 'settings SET mbraccount_online = "' . $settings["mbrAccountOnline"] . '"');
    $mbrfieldsdm = $this->exec("SELECT * FROM " . $prfx . "member_fields_dm WHERE code = 'secret' ");
    if ($mbrfieldsdm == TRUE) {
        $mbrSecretCodes = $this->exec("SELECT * FROM member_fields WHERE code = 'secret'");
        $mbrCodeCount = count($mbrSecretCodes);
        if ($mbrCodeCount != '' || $mbrCodeCount != NULL) {
            $pwdCopyCount = 0;
            foreach($mbrSecretCodes as $mbrSecretFields => $mbrValue ) {
                $pwdhash = password_hash($mbrValue["data"], PASSWORD_DEFAULT);
                $exit = $this->exec('UPDATE ' . $prfx . 'member SET pwd = "' . $pwdhash . '" WHERE mbrid = ' . $mbrValue["mbrid"] );
                if ($exit == TRUE) {
                   $exit = $this->exec('DELETE FROM ' . $prfx . 'member_fields WHERE mbrid = ' . $mbrValue["mbrid"] . ' AND code = "' . $mbrValue["code"] . '"');
                   $pwdCopyCount = $pwdCopyCount + 1;
                }
            }
            if ($mbrCodeCount == $pwdCopyCount) {
                $this->exec('DELETE FROM ' . $prfx . ' member_fields_dm WHERE code = "secret" '); 
            }
        }
    }
    $this->executeSqlFile('../install/0.8.1/sql/email_settings.sql', $prfx);
    $this->executeSqlFile('../install/0.8.1/sql/email_messages.sql', $prfx);

    $locale = $this->select1('SELECT locale FROM ' . $prfx . 'settings');
    $this->executeSqlFile('../locale/' . $locale['locale'] . '/sql/0.8.1/domain/mail_settings.sql', $prfx);
    $this->executeSqlFile('../locale/' . $locale['locale'] . '/sql/0.8.1/domain/mail_messages.sql', $prfx);
    $this->exec("UPDATE " . $prfx . "mail_settings SET pwd_forgotten_settings = " . $settings["pwdForgottenSettings"] 
                . ", pwd_forgotten_code_duration = " . $settings["pwdForgottenCodeDuration"]);
    $this->exec("UPDATE " . $prfx . "mail_messages SET mail_from_mail = '" . $settings["mailFromMail"] 
                . "', mail_from_name = '" . $settings["mailFromName"] . "' WHERE id < 3");
    
    $notices = array();
    return array($notices, NULL);
  }
}

?>
