<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "themes";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/SettingsQuery.php");
  require_once("../functions/errorFuncs.php");

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../admin/theme_list.php");
    exit();
  }

  #**************************************************************************
  #*  Update theme in use
  #**************************************************************************
  $newThemeId = $_POST["themeid"];
  $setQ = new SettingsQuery();
  $setQ->connect_e();
  if ($setQ->errorOccurred()) {
    $setQ->close();
    displayErrorPage($setQ);
  }
  if (!$setQ->updateTheme($newThemeId)) {
    $setQ->close();
    displayErrorPage($setQ);
  }
  $setQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  header("Location: ../admin/theme_list.php");
?>
