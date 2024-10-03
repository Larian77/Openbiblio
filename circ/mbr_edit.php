<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/common.php");
$tab = "circulation";
$restrictToMbrAuth = TRUE;
$nav = "edit";
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
    header("Location: ../circ/index.php");
    exit();
}

#****************************************************************************
#*  Validate data
#****************************************************************************
$mbrid = $_POST["mbrid"];
  
$mbr = new Member();
 $mbr->setMbrid($_POST["mbrid"]);
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
if (isset($_POST['pwd'])) {
    $mbr->setPwd($_POST["pwd"]);
    $_POST["pwd"] = $mbr->getPwd();
}
if (isset($_POST['pwdRepeat'])) {
    $mbr->setPwdRepeat($_POST["pwdRepeat"]);
    $_POST["pwdRepeat"] = $mbr->getPwdRepeat();
}
#**************************************************************************
#* The structure of the member fields in mbr_fields.php 
#* depends on whether the member is newly created or edited.
#**************************************************************************
if (isset($_GET["FileSource"])) {
    $mbr->setFileSource($_GET["FileSource"]);
} else {
    $mbr->setFileSource('mbr_edit_form');
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
if (!$validData) {
    $pageErrors["barcodeNmbr"] = $mbr->getBarcodeNmbrError();
    $pageErrors["lastName"] = $mbr->getLastNameError();
    $pageErrors["firstName"] = $mbr->getFirstNameError();
    $pageErrors["email"] = $mbr->getEmailError();
    $pageErrors["membershipEnd"] = $mbr->getMembershipEndError();
    $pageErrors["pwdError"] = $mbr->getPwdError();
    $_SESSION["pageErrors"] = $pageErrors;
    $_SESSION["postVars"] = $_POST;
    header("Location: ../circ/mbr_edit_form.php?FileSource=mbr_edit_form");
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
    header("Location: ../circ/mbr_edit_form.php?FileSource=mbr_edit_form");
    exit();
}

#**************************************************************************
#*  Update library member
#**************************************************************************
$mbrQ->update($mbr);
$mbrQ->close();

#**************************************************************************
#*  Destroy form values and errors
#**************************************************************************
unset($_SESSION["postVars"]);
unset($_SESSION["pageErrors"]);

$msg = $loc->getText("mbrEditSuccess");
header("Location: ../circ/mbr_view.php?mbrid=" . U($mbr->getMbrid()) . "&reset=Y&msg=" . U($msg));
  exit();
?>
