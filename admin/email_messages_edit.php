<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "mail_settings";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/email/EmailMessages.php");
  require_once("../classes/email/EmailMessagesQuery.php");
  require_once("../functions/errorFuncs.php");

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../admin/email_messages_edit_form.php?reset=Y");
    exit();
  }

  #****************************************************************************
  #*  Set datas
  #****************************************************************************
  $MailMessages = new MailMessages();
  $MailMessages->setMailMessageID($_POST["mailMessageID"]);
  $_POST["mailMessageID"] = $MailMessages->getMailMessageID();
  $MailMessages->setMailMessageType($_POST["mailMessageType"]);
  $_POST["mailMessageType"] = $MailMessages->getMailMessageType();
  $MailMessages->setMailFromMail($_POST["mailFromMail"]);
  $_POST["mailFromMail"] = $MailMessages->getMailFromMail();
  if(isset($_POST["mailFromName"])) {
    $MailMessages->setMailFromName($_POST["mailFromName"]);
    $_POST["mailFromName"] = $MailMessages->getMailFromName();
  }
  $MailMessages->setMailSubject($_POST["mailSubject"]);
  $_POST["mailSubject"] = $MailMessages->getMailSubject();
  $MailMessages->setMailBodyHtml($_POST["mailBodyHtml"]);
  $_POST["mailBodyHtml"] = $MailMessages->getMailBodyHtml();
  $MailMessages->setMailBodyPlain($_POST["mailBodyPlain"]);
  $_POST["mailBodyPlain"] = $MailMessages->getMailBodyPlain();
  $MailMessages->setMailHtml($_POST["mailHtml"]);
  $_POST["mailHtml"] = $MailMessages->getMailHtml();

$validData = $MailMessages->validateData();
if (!$validData) {
    $pageErrors["mailFromMail"] = $MailMessages->getMailFromMailErr();
    $pageErrors["mailSubject"] = $MailMessages->getMailSubjectErr();
    $_SESSION["pageErrors"] = $pageErrors;
    $_SESSION["postVars"] = $_POST;
    header("Location: ../admin/email_messages_edit_form.php?id=$MailMessages->_mailMessageID");
    exit();
}
  
  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $mailMessagesQ = new MailMessagesQuery();
  $mailMessagesQ->connect_e();
  if ($mailMessagesQ->errorOccurred()) {
    $mailMessagesQ->close();
    displayErrorPage($mailMessagesQ);
  }
  if (!$mailMessagesQ->update($MailMessages)) {
    $mailMessagesQ->close();
    displayErrorPage($mailMessagesQ);
  }
  $mailMessagesQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  header("Location: ../admin/email_messages_edit_form.php?id=" . $MailMessages->getMailMessageID() . "&updated=Y");
  exit();
?>
