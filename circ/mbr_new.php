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
    $pageErrors["membershipEnd"] = $mbr->getMembershipEndError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/mbr_new_form.php");
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
    header("Location: ../circ/mbr_new_form.php");
    exit();
}

#**************************************************************************
#*  Insert new library member
#**************************************************************************
$mbrid = $mbrQ->insert($mbr);
$mbrQ->close();

#**************************************************************************
#*  Destroy form values and errors
#**************************************************************************
unset($_SESSION["postVars"]);
unset($_SESSION["pageErrors"]);

$msg = $loc->getText("mbrNewSuccess");
header("Location: ../circ/mbr_view.php?mbrid=" . U($mbrid) . "&reset=Y&msg=" . U($msg));
exit();
?>
