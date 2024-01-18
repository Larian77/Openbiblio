<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  /**********************************************************************************
   * Function to read through an sql file executing SQL only when ";" is encountered
   **********************************************************************************/
  function executeSqlFile (&$installQ, $filename, $tablePrfx = "") {
    $fp = fopen($filename, "r");
    # show error if file could not be opened
    if ($fp == false) {
      echo "Error reading file ".H($filename).".<br>\n";
      return false;
    } else {
      $sqlStmt = "";
      while (!feof ($fp)) {
        $char = fgetc($fp);
        if ($char == ";") {
          //replace table prefix
          $sql = str_replace("%prfx%",$tablePrfx,$sqlStmt);
          
          //echo "process sql [".$sqlStmt."]<br>";
          $result = $installQ->exec($sql);
          if ($installQ->errorOccurred()) {
            $installQ->close();
            displayErrorPage($installQ);
            fclose($fp);
            return false;
          }
          $sqlStmt = "";
        } else {
          $sqlStmt = $sqlStmt.$char;
        }
      }
      fclose($fp);
      return true;
    }
  }
?>
