<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "mail_settings";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/email/EmailSettings.php");
  require_once("../classes/email/EmailSettingsQuery.php");
  require_once("../functions/errorFuncs.php");

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../admin/email_settings_edit_form.php?reset=Y");
    exit();
  }

  #****************************************************************************
  #*  Set datas
  #****************************************************************************
  $MailSet = new MailSettings();
  $MailSet->setPwdForgottenSettings($_POST["pwdForgottenSettings"]);
  $_POST["pwdForgottenSettings"] = $MailSet->getPwdForgottenSettings();
  $MailSet->setPwdForgottenCodeDuration($_POST["pwdForgottenCodeDuration"]);
  $_POST["pwdForgottenCodeDuration"] = $MailSet->getPwdForgottenCodeDuration();
  $MailSet->setMailProcess($_POST["mailProcess"]);
  $_POST["mailProcess"] = $MailSet->getMailProcess();
  if(isset($_POST["mailHost"])) {
    $MailSet->setMailHost($_POST["mailHost"]);
    $_POST["mailHost"] = $MailSet->getMailHost();
  }
  if(isset($_POST["mailUser"])) {
    $MailSet->setMailUser($_POST["mailUser"]);
    $_POST["mailUser"] = $MailSet->getMailUser();
  }
  if(isset($_POST["mailPwd"])) {
    $MailSet->setMailPwd($_POST["mailPwd"]);
    $_POST["mailPwd"] = $MailSet->getMailPwd();
  }
  if(isset($_POST["mailSmtpSecure"])) {
    $MailSet->setMailSmtpSecure($_POST["mailSmtpSecure"]);
    $_POST["mailSmtpSecure"] = $MailSet->getMailSmtpSecure();
  }

  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $mailSetQ = new MailSettingsQuery();
  $mailSetQ->connect_e();
  if ($mailSetQ->errorOccurred()) {
    $mailSetQ->close();
    displayErrorPage($mailSetQ);
  }
  if (!$mailSetQ->update($MailSet)) {
    $mailSetQ->close();
    displayErrorPage($mailSetQ);
  }
  $mailSetQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  header("Location: ../admin/email_settings_edit_form.php?reset=Y&updated=Y");
  exit();
?>
