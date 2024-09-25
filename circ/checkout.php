<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");
$tab = "circulation";
$nav = "view";
$restrictInDemo = true;
require_once("../shared/logincheck.php");

require_once("../classes/MemberQuery.php");
require_once("../classes/CircQuery.php");
require_once("../classes/Date.php");
require_once("../functions/errorFuncs.php");
require_once("../functions/formatFuncs.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

if (count($_GET) != 0) {
    $_POST = $_GET;
}
if (count($_POST) == 0) {
    header("Location: ../circ/index.php");
    exit();
}
$barcode = trim($_POST["barcodeNmbr"]);
$mbrid = trim($_POST["mbrid"]);
$mbrQ = new MemberQuery;
$mbr = $mbrQ->get($mbrid);

$postVars = $_POST;
$pageErrors = array();

function checkerror($field, $err)
{
    global $mbrid, $postVars, $pageErrors;
    if (!$err)
        return;
    $pageErrors[$field] = $err->toStr();
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/mbr_view.php?mbrid=" . U($mbrid));
    exit();
}

$circQ = new CircQuery;
if (isset($_POST['date_from']) && isset($_POST['dueDate']) && $_POST['date_from'] == 'override') {
    //Changes PVD(8.0.x)
    list($dueDate, $err) = (new Date)->read_e($_POST['dueDate']);
    checkerror('dueDate', $err);
    $_SESSION['due_date_override'] = $_POST['dueDate'];
    $err = $circQ->checkout_due_e($mbr->getBarcodeNmbr(), $barcode, $dueDate);
    checkerror('barcodeNmbr', $err);
} else {
    $err = $circQ->checkout_e($mbr->getBarcodeNmbr(), $barcode);
    checkerror('barcodeNmbr', $err);
}

unset($_SESSION["postVars"]);
unset($_SESSION["pageErrors"]);

header("Location: ../circ/mbr_view.php?mbrid=" . U($mbrid));
