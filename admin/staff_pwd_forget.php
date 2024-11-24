<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once ("../shared/common.php");

$tab = "opac";
$nav = "userlogin";
$helpPage = "opac";

require_once("../classes/Staff.php");
require_once("../classes/StaffQuery.php");
require_once("../classes/email/EmailSettings.php");
require_once("../classes/email/EmailSettingsQuery.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,'shared');

#****************************************************************************
#*  Connect with StaffQuery and set $_POST
#****************************************************************************
$staff = new Staff();
$staffQ = new StaffQuery();
$staffQ->connect_e();

$mailSetQ = new MailSettingsQuery();
$mailSetQ->connect_e();
if ($mailSetQ->errorOccurred()) {
  $mailSetQ->close();
  displayErrorPage($mailSetQ);
}
$mailSetQ->execSelect();
if ($mailSetQ->errorOccurred()) {
  $mailSetQ->close();
  displayErrorPage($mailSetQ);
}
$PwdForgottenSetting = $mailSetQ->fetchPwdForgottenSettings();

if (isset($_POST["send"])) {
    $send = $_POST["send"];
}
if(isset($_POST["emailForm"]) && $_POST["emailForm"] == 'emailForm') {
    if(!isset($_POST['email']) || empty($_POST['email'])) {
        $pageErrors["pwdForgottenError"] = $loc->getText('errEmailMissing');
        $_SESSION["pageErrors"] = $pageErrors;
        if (isset($_POST['send'])) { 
            $attempt = $_POST['send'];
            $send = intval($attempt) + 1;
        }
        header("Location: ../admin/staff_pwd_forget_form.php?send=$send");
        exit();
    } else {
        $staff->setPwdForgottenMail($_POST['email']);
        $staffRow = $staffQ->getRow($staff->getPwdForgottenMail());
        if ($staffRow > 1) {
            $pageErrors["pwdForgottenError"] = $loc->getText('errTooManyUserFound');
            $_SESSION["pageErrors"] = $pageErrors;
            $_SESSION["postVars"] = $_POST;
            if (isset($_POST['send'])) { 
                $attempt = $_POST['send'];
                $send = intval($attempt) + 1;
            }
            header("Location: ../admin/staff_pwd_forget_form.php?send=".$send);
            exit();
        }
        $db_column_mail = 'email';
    }    
}

if (isset($_POST["usernameForm"]) && $_POST["usernameForm"] == 'usernameForm') {
    if(!isset($_POST['username']) || empty($_POST['username'])) {
        $pageErrors["pwdForgottenError"] = $loc->getText('errbarcodeNmbrMissing');
        $_SESSION["pageErrors"] = $pageErrors;
        if (isset($_POST['send'])) { 
            $attempt = $_POST['send'];
            $send = intval($attempt) + 1;
        }
        header("Location: ../admin/staff_pwd_forget_form.php?send=$send");
        exit();
    } else {
        $staff->setPwdForgottenUsername($_POST['username']);
        $db_column_username = 'username';
    }
}

#************************************************************************
#* e-mail or username
#************************************************************************
if ($PwdForgottenSetting == 1) {
    if(isset($db_column_mail)) {
        $db_column = $db_column_mail;
        $value = $staff->getPwdForgottenMail();
    } else if (isset($db_column_username)) {
        $db_column = $db_column_username;
        $value = $staff->getPwdForgottenUsername();
    }    
    $staff = $staffQ->getStaff_or($db_column, $value);
    unset($db_column_mail);
    unset($db_column_username);
    unset($db_column);
} 

#************************************************************************
#* e-mail and username
#************************************************************************
else if ($PwdForgottenSetting == 2) {
    if(!isset ($db_column_mail)) {
        $pageErrors["pwdForgottenError"] = $loc->getText('errEmailMissing');
        $_SESSION["pageErrors"] = $pageErrors;
        if (isset($_POST['send'])) { 
            $attempt = $_POST['send'];
            $send = intval($attempt) + 1;
        }
        header("Location: ../admin/staff_pwd_forget_form.php?send=$send");
        exit();
    } else if ($db_column_mail == 'email' && 
        $db_column_username == 'username' && $staff->getPwdForgottenMail() != NULL 
        && $staff->getPwdForgottenUsername() != NULL) {
            $staff = $staffQ->getStaff_and($db_column_mail, $db_column_username, 
            $staff->getPwdForgottenMail(), $staff->getPwdForgottenUsername());
                unset($db_column_mail);
                unset($db_column_username);     
    }
}
    
if($staff === false) {
    $notice = $loc->getText('SendMailForPwdForgottenCode');
    #************************************************************************
    #* If you want to display detailed error information, use the following code instead of the line above.
    #************************************************************************
    //   $pageErrors["pwdForgottenError"] = $loc->getText('errNoUserFound');
    //   $_SESSION["pageErrors"] = $pageErrors;
    //   $_SESSION["postVars"] = $_POST;
    //   if (isset($_POST['send'])) { 
    //      $attempt = $_POST['send'];
    //      $send = intval($attempt) + 1;
    //   }
    //   header("Location: ../admin/staff_pwd_forget_form.php?send=".$send);
    //   exit();
} else {
    #********************************************************************************
    #* Reference to the required message (DB --> mail_messages --> mail_message_type)
    #********************************************************************************
    $mailMessageType = 'password_forgotten_message';

    #********************************************************************************
    #* Creation of the password code, encryption and entry in the DB in table staff
    #******************************************************************************** 
    $passwordCode = $staff->random_string();
    $staff->setPwdForgotten(hash('sha256', $passwordCode));
    $success = $staffQ->setPwdForgottenCode($staff);
    $staffQ->close();

    #************************************************************************
    #* Creation of the URL for resetting the password
    #************************************************************************ 
    $url_passwordcode = $staff->createURLPwdCode($staff, $passwordCode);

    #*************************************************************************
    #* Preparation of the text variables which will be included in the message
    #*************************************************************************
    // PwdForgottenCodeDuration is only set in Mailing.php as an exception, as MailSet is queried there first.
    $mailTextVariables = array(
        "FirstName"=>$staff->getFirstName(),
        "LastName"=>$staff->getLastName(),
        "url_pwdcode"=>$url_passwordcode);

    #*************************************************************************
    #lud* Preparation of further mail components
    #*************************************************************************
    $mailAdress = $staff->getEmail();
    $noticeSuccess = $loc->getText('SendMailForPwdForgottenCode');
    $noticeError = $loc->getText('errMailCouldNotBeSent');

    #*************************************************************************
    #* Inclusion of the general mailing code
    #*************************************************************************        
    include_once("../classes/email/Mailing.php");

}

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
  echo $notice;
  include("../shared/footer.php"); ?>
