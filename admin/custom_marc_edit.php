<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");
$tab = "admin";
$nav = "new";

require_once("../shared/logincheck.php");

require_once("../classes/BiblioField.php");
require_once("../classes/MaterialFieldQuery.php");
require_once("../functions/errorFuncs.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

#****************************************************************************
#*  Checking for post vars.  Go back to form if none found.
#****************************************************************************

if (count($_POST) == 0) {
    header("Location: ../admin/materials_list.php");
    exit();
}

$rec = array();
$rec['materialCd'] = $_POST["materialCd"];
$rec['xref_id'] = $_POST["xref_id"];
$rec['tag'] = $_POST["tag"];
$rec['subfieldCd'] = $_POST["subfieldCd"];
$rec['descr'] = $_POST["descr"];
$rec['required'] = $_POST["required"];
$rec['cntrltype'] = $_POST["cntrltype"];
#****************************************************************************
#*  Validate data
#****************************************************************************
$fld = new BiblioField();
$fld->setTag($_POST["tag"]);
$fld->setSubfieldCd($_POST["subfieldCd"]);
$pageErrors = array();
$validData = $fld->validateData();
if (!$validData) {
    $pageErrors["tag"] = $fld->getTagError();
    $pageErrors["subfieldCd"] = $fld->getSubfieldCdError();
}
if (!$rec['descr']) {
    $pageErrors['descr'] = 'Field is required.';
}
if (!empty($pageErrors)) {
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/custom_marc_edit_form.php");
    exit();
}

$matQ = new MaterialFieldQuery;
//Changes PVD(8.0.x)
$matQ->connect_e();
$matQ->update($rec);
$matQ->close();

$msg = "Field Updated successfully";
header("Location: custom_marc_view.php?materialCd=" . U($rec['materialCd']) . "&msg=" . U($msg));
include("../shared/footer.php");
?>
