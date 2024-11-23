<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");
$tab = "circulation";
$restrictToMbrAuth = TRUE;
$nav = "newconfirm";
$restrictInDemo = true;
require_once("../shared/logincheck.php");

require_once("../classes/Member.php");
require_once("../classes/MemberQuery.php");
require_once("../classes/DmQuery.php");
require_once("../functions/errorFuncs.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

#****************************************************************************
#*  Checking for post vars.  Go back to form if none found.
#****************************************************************************
if (count($_POST) == 0) {
    header("Location: ../circ/mbr_new_form.php");
    exit();
}

#****************************************************************************
#*  Validate data
#****************************************************************************
$mbr = new Member();
$mbr->setBarcodeNmbr($_POST["barcodeNmbr"]);
$_POST["barcodeNmbr"] = $mbr->getBarcodeNmbr();
$mbr->setLastChangeUserid($_SESSION["userid"]);
$mbr->setLastName($_POST["lastName"]);
$_POST["lastName"] = $mbr->getLastName();
$mbr->setFirstName($_POST["firstName"]);
$_POST["firstName"] = $mbr->getFirstName();
$mbr->setAddress($_POST["address"]);
$_POST["address"] = $mbr->getAddress();
$mbr->setHomePhone($_POST["homePhone"]);
$_POST["homePhone"] = $mbr->getHomePhone();
$mbr->setWorkPhone($_POST["workPhone"]);
$_POST["workPhone"] = $mbr->getWorkPhone();
$mbr->setEmail($_POST["email"]);
$_POST["email"] = $mbr->getEmail();
$mbr->setMembershipEnd($_POST["membershipEnd"]);
$_POST["membershipEnd"] = $mbr->getMembershipEnd();
$mbr->setClassification($_POST["classification"]);
if (isset($_POST["TypeOfPwdCreation"])) {
    $mbr->setTypeOfPwdCreation($_POST["TypeOfPwdCreation"]);
    $_POST["TypeOfPwdCreation"] = $mbr->getTypeOfPwdCreation();
}
if (isset($_POST['pwd'])) {
    $mbr->setPwd($_POST["pwd"]);
    $_POST["pwd"] = $mbr->getPwd();
}
if (isset($_POST['pwdRepeat'])) {
    $mbr->setPwdRepeat($_POST["pwdRepeat"]);
    $_POST["pwdRepeat"] = $mbr->getPwdRepeat();
}

#********************************************************
#* Depending on whether a new member is created or edited
#********************************************************
if (isset($_GET["FileSource"])) {
    $mbr->setFileSource($_GET["FileSource"]);
} else {
    $mbr->setFileSource('mbr_new_form');
}

$dmQ = new DmQuery();
$dmQ->connect_e();
$customFields = $dmQ->getAssoc('member_fields_dm');
$dmQ->close();
foreach ($customFields as $name => $title) {
    if (isset($_REQUEST['custom_' . $name])) {
        $mbr->setCustom($name, $_REQUEST['custom_' . $name]);
    }
}

$validData = $mbr->validateData();
if ($mbr->getTypeOfPwdCreation() != 1 && $set->_isMbrAccountOnline == TRUE) {
    $validPwd = $mbr->validatePwd();
} else {
    $validPwd = "notSet";
    $mbr->setPwd(NULL);
}
if (!($validData && $validPwd)) {
    $pageErrors["barcodeNmbr"] = $mbr->getBarcodeNmbrError();
    $pageErrors["lastName"] = $mbr->getLastNameError();
    $pageErrors["firstName"] = $mbr->getFirstNameError();
    $pageErrors["email"] = $mbr->getEmailError();
    $pageErrors["membershipEnd"] = $mbr->getMembershipEndError();
    $pageErrors["pwd"] = $mbr->getPwdError();
    $_SESSION["pageErrors"] = $pageErrors;
    $_SESSION["postVars"] = $_POST;
    header("Location: ../circ/mbr_new_form.php?FileSource=mbr_new_form");
    exit();
}

#**************************************************************************
#*  Check for duplicate barcode number
#**************************************************************************
$mbrQ = new MemberQuery();
$mbrQ->connect_e();
$dupBarcode = $mbrQ->DupBarcode($mbr->getBarcodeNmbr(), $mbr->getMbrid());
if ($dupBarcode) {
    $pageErrors["barcodeNmbr"] = $loc->getText("mbrDupBarcode", array("barcode" => $mbr->getBarcodeNmbr()));
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/mbr_new_form.php?FileSource=mbr_new_form");
    exit();
}

#**************************************************************************
#*  Insert new library member
#**************************************************************************
$mbr->setMbrid($mbrQ->insert($mbr));
$mbrQ->close();

#**************************************************************************
#*  If the password will be created by the library member by e-mail.
#**************************************************************************
if($mbr->getTypeOfPwdCreation() == 1 && (!$mbr->getMbrid() == NULL)) {
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
    
    #********************************************************************************
    #* Reference to the required message (DB --> mail_messages --> mail_message_type)
    #********************************************************************************
    $mailMessageType = 'welcome_message';
    
    #**************************************************************************
    #*  Preparation of the text variables which will be included in the message
    #**************************************************************************
    // PwdForgottenCodeDuration is only set in Mailing.php as an exception, as MailSet is queried there first.
    $mailTextVariables = array(
            "FirstName"=>$mbr->getFirstName(),
            "LastName"=>$mbr->getLastName(),
            "url_pwdcode"=>$url_passwordcode);
    
    #**************************************************************************
    #*  Preparation of fürhter variables for mailing
    #**************************************************************************
    $mailAdress = $mbr->getEmail();
    $noticeSuccess = $loc->getText('mbrNewMailingSuccessful');
    $noticeError = $loc->getText('errMailCouldNotBeSent');
    
    #**************************************************************************
    #*  Inclusion of the general mailing code
    #**************************************************************************
    include_once('../classes/email/Mailing.php');

}

#**************************************************************************
#*  Destroy form values and errors
#**************************************************************************
unset($_SESSION["postVars"]);
unset($_SESSION["pageErrors"]);

if ($error != NULL) {
    $msg = $error . ' ' . $notice;
} else {
    $msg = $loc->getText("mbrNewSuccess") . ' ' . $notice;
}
header("Location: ../circ/mbr_view.php?mbrid=" . U($mbr->getMbrid()) . "&reset=Y&msg=" . U($msg));
exit();
?>
