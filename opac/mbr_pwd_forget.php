<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

//#************************************************************************
//#* Import PHPMailer classes into the global namespace
//#* These must be at the top of your script, not inside a function
//#************************************************************************ 
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;
//
//#************************************************************************
//#* Load Composer's autoloader
//#************************************************************************
//require_once "../lib/vendor/autoload.php"; // important for phpMailer

require_once ("../shared/common.php");

$tab = "opac";
$nav = "userlogin";
$helpPage = "opac";

require_once("../classes/Member.php");
require_once("../classes/MemberQuery.php");
require_once("../classes/email/EmailSettings.php");
require_once("../classes/email/EmailSettingsQuery.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,'shared');

#****************************************************************************
#*  Connect with MemberQuery and set $_POST
#****************************************************************************
$mbr = new Member();
$mbrQ = new MemberQuery();
$mbrQ->connect_e();

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
        header("Location: ../opac/mbr_pwd_forget_form.php?send=$send");
        exit();
    } else {
        $mbr->setPwdForgottenMail($_POST['email']);
        $mbrRow = $mbrQ->getRow($mbr->getPwdForgottenMail());
        if ($mbrRow > 1) {
            $pageErrors["pwdForgottenError"] = $loc->getText('errTooManyUserFound');
            $_SESSION["pageErrors"] = $pageErrors;
            $_SESSION["postVars"] = $_POST;
            if (isset($_POST['send'])) { 
                $attempt = $_POST['send'];
                $send = intval($attempt) + 1;
            }
            header("Location: ../opac/mbr_pwd_forget_form.php?send=".$send);
            exit();
        }
        $db_column_mail = 'email';
    }    
}

if (isset($_POST["barcodeNmbrForm"]) && $_POST["barcodeNmbrForm"] == 'barcodeNmbrForm') {
    if(!isset($_POST['barcodeNmbr']) || empty($_POST['barcodeNmbr'])) {
        $pageErrors["pwdForgottenError"] = $loc->getText('errbarcodeNmbrMissing');
        $_SESSION["pageErrors"] = $pageErrors;
        if (isset($_POST['send'])) { 
            $attempt = $_POST['send'];
            $send = intval($attempt) + 1;
        }
        header("Location: ../opac/mbr_pwd_forget_form.php?send=$send");
        exit();
    } else {
        $mbr->setPwdForgottenbcNmbr($_POST['barcodeNmbr']);
        $db_column_bc_nmbr = 'barcode_nmbr';
    }
}

#************************************************************************
#* e-mail or username
#************************************************************************
if ($PwdForgottenSetting == 1) {
    if(isset($db_column_mail)) {
        $db_column = $db_column_mail;
        $value = $mbr->getPwdForgottenMail();
    } else if (isset($db_column_bc_nmbr)) {
        $db_column = $db_column_bc_nmbr;
        $value = $mbr->getPwdForgottenBcNmbr();
    }    
    $mbr = $mbrQ->getMember_or($db_column, $value);
    unset($db_column_mail);
    unset($db_column_bc_nmbr);
    unset($db_column);

#************************************************************************
#* e-mail and username
#************************************************************************
} else if ($PwdForgottenSetting == 2) {
    if(!isset ($db_column_mail)) {
        $pageErrors["pwdForgottenError"] = $loc->getText('errEmailMissing');
        $_SESSION["pageErrors"] = $pageErrors;
        if (isset($_POST['send'])) { 
            $attempt = $_POST['send'];
            $send = intval($attempt) + 1;
        }
        header("Location: ../opac/mbr_pwd_forget_form.php?send=$send");
        exit();
    } else if ($db_column_mail == 'email' && 
        $db_column_bc_nmbr == 'barcode_nmbr' && $mbr->getPwdForgottenMail() != NULL 
        && $mbr->getPwdForgottenBcNmbr() != NULL) {
            $mbr = $mbrQ->getMember_and($db_column_mail, $db_column_bc_nmbr, 
            $mbr->getPwdForgottenMail(), $mbr->getPwdForgottenBcNmbr());
                unset($db_column_mail);
                unset($db_column_bc_nmbr);     
    }
}
    
if($mbr === false) {
    $notice = $loc->getText('SendMailForPwdForgottenCode');
    #************************************************************************
    #* If you want to display detailed error information, use the following code instead of the line above.
    ##************************************************************************
    //   $pageErrors["pwdForgottenError"] = $loc->getText('errNoUserFound');
    //   $_SESSION["pageErrors"] = $pageErrors;
    //   $_SESSION["postVars"] = $_POST;
    //   if (isset($_POST['send'])) { 
    //      $attempt = $_POST['send'];
    //      $send = intval($attempt) + 1;
    //   }
    //   header("Location: ../opac/mbr_pwd_forget_form.php?send=".$send);
    //   exit();
} else {
    #********************************************************************************
    #* Reference to the required message (DB --> mail_messages --> mail_message_type)
    ##*******************************************************************************
    $mailMessageType = 'password_forgotten_message';

    #********************************************************************************
    #* Creation of the password code, encryption and entry in the DB in table member
    #******************************************************************************** 
    $passwordCode = $mbr->random_string();
    $mbr->setPwdForgotten(hash('sha256', $passwordCode));
    $success = $mbrQ->setPwdForgottenCode($mbr);
    if ($success == NULL) {
        $error = $loc->getText('errNoPwdForgottenCode');
    }
    $mbrQ->close();

    #************************************************************************
    #* Creation of the URL for resetting the password
    #************************************************************************        
    $url_passwordcode = $mbr->createURLPwdCode($mbr, $passwordCode);

    #*************************************************************************
    #* Preparation of the text variables which will be included in the message
    #*************************************************************************
    // PwdForgottenCodeDuration is only set in Mailing.php as an exception, as MailSet is queried there first.
    $mailTextVariables = array(
        "FirstName"=>$mbr->getFirstName(),
        "LastName"=>$mbr->getLastName(),
        "url_pwdcode"=>$url_passwordcode);

    #*************************************************************************
    #* Preparation of further mail components
    #*************************************************************************
    $mailAdress = $mbr->getEmail();
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
