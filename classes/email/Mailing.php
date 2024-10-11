<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

#************************************************************************
#* Import PHPMailer classes into the global namespace
#* These must be at the top of your script, not inside a function
#************************************************************************ 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

#************************************************************************
#* Load Composer's autoloader
#************************************************************************
require_once "../lib/vendor/autoload.php"; // important for phpMailer

include_once("../classes/email/EmailSettings.php");
include_once("../classes/email/EmailSettingsQuery.php");
include_once("../classes/email/EmailMessages.php");
include_once("../classes/email/EmailMessagesQuery.php");
include_once("../functions/errorFuncs.php");

#************************************************************************
#* Mail Settings Query
#************************************************************************
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
$MailSet = $mailSetQ->fetchRow();

// Exception: the forget password function is only set here. Necessary because MailSet can only be queried here
if ($mailMessageType == 'password_forgotten_message' || $mailMessageType == 'welcome_message') {
    $mailTextVariables["PwdForgottenCodeDuration"] = $MailSet->getPwdForgottenCodeDuration();
}

#************************************************************************
#* Mail Messages Query
#************************************************************************
$mailMessagesQ = new MailMessagesQuery();
$mailMessagesQ->connect_e();
if ($mailMessagesQ->errorOccurred()) {
  $mailMessagesQ->close();
  displayErrorPage($mailMessagesQ);
}

$mailMessagesQ->execSelect($mailMessageType);

if ($mailMessagesQ->errorOccurred()) {
  $mailMessagesQ->close();
  displayErrorPage($mailMessagesQ);
} 

$MailMessages = $mailMessagesQ->fetchRow();

#************************************************************************
#* Preparation of the mailing
#************************************************************************
if ($MailSet->getMailProcess() == 1) {
//  $mailAdress --> set in the relevant file!
    $betreff = $MailMessages->getMailSubject();
    $from = "From: $MailMessages->_mailFromName <$MailMessages->_mailFromMail>";

    $text =  $loc->getText($MailMessages->getMailBodyPlain(), $mailTextVariables); //$mailTextVariables depends of the type of message!

    $mailSuccess = mail($mailAdress, utf8_decode($betreff), $text, $from . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n");
    if ($mailSuccess == 1) {
        $notice = $noticeSuccess; // set in the relevant file
    } else {
        $notice = $loc->getText('errMailCouldNotBeSent');
    }

} else if ($MailSet->getMailProcess() == 2) {
    #************************************************************************
    #* Create an instance; passing `true` enables exceptions
    #************************************************************************
    $mail = new PHPMailer(true);

    try {
        #************************************************************************
        #* Server settings
        #************************************************************************
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
        $mail->isSMTP();                                           //Send using SMTP
        $mail->Host       = $MailSet->getMailHost();               //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                  //Enable SMTP authentication
        $mail->Username   = $MailSet->getMailUser();               //SMTP username
        $mail->Password   = $MailSet->getMailPwd();                //SMTP password
        if ($MailSet->getMailSmtpSecure() == 1) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    //Enable implicit TLS encryption
            $mail->Port       = 587;                               //TCP port to connect to; use
        } else if($MailSet->getMailSmtpSecure() == 2) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;       //Enable implicit TLS encryption
            $mail->Port       = 465;
        }                           // 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                                    // 465 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_SMTPS
        $mail->SMTPOptions = array( 
            'ssl' => array(
                  'verify_peer' => false,
                  'verify_peer_name' => false,
                  'allow_self_signed' => true
            ),
            'tls' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        #************************************************************************
        #* Recipients
        #************************************************************************
        $mail->setFrom($MailMessages->getMailFromMail(), $MailMessages->getMailFromName()); // Add a sender
        $mail->addAddress($mailAdress);     //Add a recipient

        #************************************************************************
        #* Content 
        #************************************************************************
        $mail->CharSet = "UTF-8";
        $mail->Encoding = 'base64';
        $mail->Subject = $MailMessages->getMailSubject();
        if ($MailMessages->getMailHtml() == 0) {
            $mailMessageBody = $MailMessages->getMailBodyPlain();
        } else {
            $mailMessageBody = $MailMessages->getMailBodyHtml();
            $mail->isHTML(TRUE);
        }

        $mail->Body    = $loc->getText($mailMessageBody, $mailTextVariables);                                
        $mail->AltBody = $loc->getText($MailMessages->getMailBodyPlain(), $mailTextVariables);

        $mail->send();
        $notice = $noticeSuccess; // set in the relevant file
    } catch (Exception $e) {
        $notice = $noticeError . ": " . $mail->ErrorInfo;
}
}

