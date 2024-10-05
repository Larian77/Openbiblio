<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "settings";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/Settings.php");
  require_once("../classes/SettingsQuery.php");
  require_once("../functions/errorFuncs.php");

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../admin/settings_edit_form.php?reset=Y");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $set = new Settings();
  $set->setLibraryName($_POST["libraryName"]);
  $_POST["libraryName"] = $set->getLibraryName();
  $set->setLibraryImageUrl($_POST["libraryImageUrl"]);
  $_POST["libraryImageUrl"] = $set->getLibraryImageUrl();
  $set->setUseImageFlg(isset($_POST["isUseImageSet"]));
  $set->setLibraryHours($_POST["libraryHours"]);
  $_POST["libraryHours"] = $set->getLibraryHours();
  $set->setLibraryPhone($_POST["libraryPhone"]);
  $_POST["libraryPhone"] = $set->getLibraryPhone();
  $set->setLibraryUrl($_POST["libraryUrl"]);
  $_POST["libraryUrl"] = $set->getLibraryUrl();
  $set->setOpacUrl($_POST["opacUrl"]);
  $_POST["opacUrl"] = $set->getOpacUrl();
  $set->setSessionTimeout($_POST["sessionTimeout"]);
  $_POST["sessionTimeout"] = $set->getSessionTimeout();
  $set->setItemsPerPage($_POST["itemsPerPage"]);
  $_POST["itemsPerPage"] = $set->getItemsPerPage();
  $set->setPurgeHistoryAfterMonths($_POST["purgeHistoryAfterMonths"]);
  $_POST["purgeHistoryAfterMonths"] = $set->getPurgeHistoryAfterMonths();
  $set->setBlockCheckoutsWhenFinesDue(isset($_POST["isBlockCheckoutsWhenFinesDue"]));
  $set->setHoldMaxDays($_POST["holdMaxDays"]);
  $_POST["holdMaxDays"] = $set->getHoldMaxDays();
  $set->setLocale($_POST["locale"]);
  $_POST["locale"] = $set->getLocale();
  $set->setCharset($_POST["charset"]);
  $_POST["charset"] = $set->getCharset();
  $set->setHtmlLangAttr($_POST["htmlLangAttr"]);
  $_POST["htmlLangAttr"] = $set->getHtmlLangAttr();
  $set->setLoginAttempts($_POST["loginAttempts"]);
  $_POST["loginAttempts"] = $set->getLoginAttempts();
  $set->setPwdTimeout($_POST["pwdTimeout"]);
  $_POST["pwdTimeout"] = $set->getPwdTimeout();
  $set->setMbrAccountOnline(isset($_POST["isMbrAccountOnline"]));
  $_POST["isMbrAccountOnline"] = $set->isMbrAccountOnline();


  if (!$set->validateData()) {
    $pageErrors["sessionTimeout"] = $set->getSessionTimeoutError();
    $pageErrors["itemsPerPage"] = $set->getItemsPerPageError();
    $pageErrors["purgeHistoryAfterMonths"] = $set->getPurgeHistoryAfterMonthsError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/settings_edit_form.php");
    exit();
  }


  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $setQ = new SettingsQuery();
  $setQ->connect_e();
  if ($setQ->errorOccurred()) {
    $setQ->close();
    displayErrorPage($setQ);
  }
  if (!$setQ->update($set)) {
    $setQ->close();
    displayErrorPage($setQ);
  }
  $setQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  header("Location: ../admin/settings_edit_form.php?reset=Y&updated=Y");
  exit();
?>
