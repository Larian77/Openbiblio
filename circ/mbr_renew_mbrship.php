<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

session_cache_limiter(null);
//Changes PVD(8.0.x)
//use to disable any thing to print
//Buffering Issues:
// If you are using output buffering (for example, with ob_start()), ensure that no content is being echoed or printed before the header() function is called.
ob_start();
$restrictToMbrAuth = TRUE;
require_once("../shared/common.php");
require_once("../functions/inputFuncs.php");
require_once("../functions/formatFuncs.php");
require_once("../shared/logincheck.php");

require_once("../classes/Member.php");
require_once("../classes/MemberQuery.php");
require_once("../classes/BiblioSearch.php");
require_once("../classes/BiblioSearchQuery.php");
require_once("../classes/BiblioHold.php");
require_once("../classes/BiblioHoldQuery.php");
require_once("../classes/MemberAccountQuery.php");
require_once("../classes/DmQuery.php");
require_once("../functions/errorFuncs.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, "circulation");

if (count($_GET) == 0) {
    header("Location: ../circ/index.php");
    exit();
}
if (isset($_GET["mbrid"])) {
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);
    #****************************************************************************
    #*  Retrieving get var
    #****************************************************************************
    $mbrid = $_GET["mbrid"];
    $length = $_GET["length"];

    #****************************************************************************
    #*  Search database
    #****************************************************************************
    $mbrQ = new MemberQuery();
    $mbrQ->connect_e();
    $mbr = $mbrQ->get($mbrid);
    $mbrQ->close();

    if (($mbr->getMembershipEnd() != "0000-00-00") and (strtotime($mbr->getMembershipEnd()) > strtotime("now"))) {
        $year = substr($mbr->getMembershipEnd(), 0, 4);
        $month = (int) substr($mbr->getMembershipEnd(), 5, 2);
        $day = (int) substr($mbr->getMembershipEnd(), 8, 2);
        $month = $month + $length;
        $newdate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
        $mbr->setMembershipEnd($newdate);
    } else {
        $temp = $neu = strtotime("+$length month");
        $newdate = date("Y-m-d", $temp);
        $mbr->setMembershipEnd($newdate);
    }


    $mbrQ->update($mbr);
    $mbrQ->close();
    #**************************************************************************
    #*  Destroy form values and errors
    #**************************************************************************
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    $msg = $loc->getText("mbrRenewSuccess", array("length" => $length));
    $msg = urlencode($msg);
    header("Location: ../circ/mbr_view.php?mbrid=" . $mbr->getMbrid() . "&reset=Y&msg=" . $msg);
    ob_end_flush();
    exit();
}
?>
