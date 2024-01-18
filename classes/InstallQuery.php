<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");

class InstallQuery extends Query {
  /* Override constructor so the installer can test the database connection */

  //Changes PVD(8.0.x)
  function __construct() {
    ;
  }
  function dropTable($tableName) {
    $sql = $this->mkSQL("drop table if exists %I ", $tableName);
    $this->exec($sql);
  }
  
  function renameTables($fromTablePrfx, $toTablePrfx = DB_TABLENAME_PREFIX) {
    $fromTableNames = $this->getTableNames($fromTablePrfx.'%');
    foreach($fromTableNames as $fromTableName) {
      $toTableName = str_replace($fromTablePrfx, $toTablePrfx, $fromTableName);
      $this->renameTable($fromTableName, $toTableName);
    }
  }
  
  function renameTable($fromTableName, $toTableName) {
      $this->dropTable($toTableName);
      $sql = "rename table ".$fromTableName." to ".$toTableName;
      $this->exec($sql);
  }

  function getTableNames($pattern = "") {
    if($pattern == "") {
      $pattern = DB_TABLENAME_PREFIX.'%';
    }
    $sql = "show tables like '".$pattern."'";
    $rows = $this->exec($sql, OBIB_NUM);

    $tablenames = array();
    foreach ($rows as $row) {
      $tablenames[] = $row[0];
    }
    return $tablenames;
  }
  
  function _getSettings($tablePrfx) {
    $sql = $this->mkSQL('SHOW TABLES LIKE %Q ', $tablePrfx.'settings');
    $row = $this->select01($sql);
    if (!$row) {
      return false;
    }
    $sql = $this->mkSQL('SELECT * FROM %I ', $tablePrfx.'settings');
    return $this->select1($sql);
  }
  
  function getCurrentLocale($tablePrfx = DB_TABLENAME_PREFIX) {
    $array = $this->_getSettings($tablePrfx);
    if($array == false ||
      !isset($array["locale"])) {
      return 'en'; //Earlier versions of Openbiblio only supported English
    }
    else {
      return $array["locale"];  
    }
  }

  function getCurrentDatabaseVersion($tablePrfx = DB_TABLENAME_PREFIX) {
    $array = $this->_getSettings($tablePrfx);
    if($array == false) {
      return false;
    }
    else {
      return $array["version"];
    }
  }
  
  function freshInstall($locale, $sampleDataRequired = false,
                        $version=OBIB_LATEST_DB_VERSION,
                        $tablePrfx = DB_TABLENAME_PREFIX) {
    $rootDir = '../install/' . $version . '/sql';
    $localeDir = '../locale/' . $locale . '/sql/' . $version;
    
    $this->executeSqlFilesInDir($rootDir, $tablePrfx);
    $this->executeSqlFilesInDir($localeDir . '/domain/', $tablePrfx);
    if($sampleDataRequired) {
      $this->executeSqlFilesInDir($localeDir . '/sample/', $tablePrfx);
    }
  }
  
  function executeSqlFilesInDir($dir, $tablePrfx = "") {
    if (is_dir($dir)) {
      if ($dh = opendir($dir)) {
        while (($filename = readdir($dh)) !== false) {
          if(preg_match('/\\.sql$/', $filename)) {
            $this->executeSqlFile($dir.'/'.$filename, $tablePrfx);
          }
        }
        closedir($dh);
      }
    }
  }

  /**********************************************************************************
   * Function to read through an sql file executing SQL only when ";" is encountered
   **********************************************************************************/
  function executeSqlFile($filename, $tablePrfx = DB_TABLENAME_PREFIX) {
    $fp = fopen($filename, "r");
    # show error if file could not be opened
    if ($fp == false) {
      (new Fatal)->error("Error reading file: ".H($filename));
    } else {
      $sqlStmt = "";
      while (!feof ($fp)) {
        $char = fgetc($fp);
        if ($char == ";") {
          //replace table prefix, we're doing it here as the install script may
          //want to override the required prefix (eg. during upgrade / conversion 
          //process)
          $sql = str_replace("%prfx%",$tablePrfx,$sqlStmt);
          //replace ENGINE with TYPE for old MySQL versions
          $MySQLn = explode('.', implode('', explode('-', $this->_link->get_server_info())));
          if ($MySQLn[0] < '5') {
            $sql = str_replace("ENGINE=","TYPE=",$sql);
            $sql = str_replace("engine=","type=",$sql);
          } else {
            $sql = str_replace("TYPE=","ENGINE=",$sql);
            $sql = str_replace("type=","engine=",$sql);
          }
          $this->exec($sql);
          $sqlStmt = "";
        } else {
          $sqlStmt .= $char;
        }
      }
      fclose($fp);
    }
  }
}

?>
