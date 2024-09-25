<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

#*********************************************************************************
#*  checklogin.php
#*  Description: Used to verify signon token on every secured page.
#*               Redirects to the login page if token not valid.
#*********************************************************************************

require_once("../classes/SessionQuery.php");
require_once("../functions/errorFuncs.php");

// if (isset($_SERVER['HTTP_REFERER'])) {
//   $referringPage = $_SERVER['HTTP_REFERER'];
//   echo "The referring page is: " . $referringPage;
// } else {
//   echo "No referring page information available.";
// }

#****************************************************************************
#*  Temporarily disabling security for demo since sourceforge.net
#*  seems to be using mirrored servers that do not share session info.
#****************************************************************************
if (!OBIB_DEMO_FLG) {

    // common.php defines an array of pages valid for redirect
    $returnPage = $pages[$tab];
    $_SESSION["returnPage"] = $returnPage;

    #****************************************************************************
    #*  Checking to see if session variables exist
    #****************************************************************************
    if (!isset($_SESSION["userid"]) or ($_SESSION["userid"] == "")) {
        header("Location: ../shared/loginform.php");
        exit();
    }
    if (!isset($_SESSION["token"]) or ($_SESSION["token"] == "")) {
        header("Location: ../shared/loginform.php");
        exit();
    }

    #****************************************************************************
    #*  Checking session table to see if session_id has timed out
    #****************************************************************************
    $sessQ = new SessionQuery();
    //Changes PVD(8.0.x)
    $sessQ->connect_e();
    if ($sessQ->errorOccurred()) {
        displayErrorPage($sessQ);
    }
    if (!$sessQ->validToken($_SESSION["userid"], $_SESSION["token"])) {
        if ($sessQ->errorOccurred()) {
            displayErrorPage($sessQ);
        }
        $sessQ->close();
        header("Location: ../shared/loginform.php?RET=" . U($returnPage));
        exit();
    }
    $sessQ->close();

    #****************************************************************************
    #*  Checking authorization for this tab
    #*  The session authorization flags were set at login in login.php
    #****************************************************************************
    if ($tab == "circulation") {
        if (!$_SESSION["hasCircAuth"]) {
            header("Location: ../circ/noauth.php");
            exit();
        } elseif (isset($restrictToMbrAuth) and !$_SESSION["hasCircMbrAuth"]) {
            header("Location: ../circ/noauth.php");
            exit();
        }
    } elseif ($tab == "cataloging") {
        if (!$_SESSION["hasCatalogAuth"]) {
            header("Location: ../catalog/noauth.php");
            exit();
        }
    } elseif ($tab == "admin") {
        if (!$_SESSION["hasAdminAuth"]) {
            header("Location: ../admin/noauth.php");
            exit();
        }
    } elseif ($tab == "reports") {
        if (!$_SESSION["hasReportsAuth"]) {
            header("Location: ../reports/noauth.php");
            exit();
        }
    }


}

#****************************************************************************
#*  Checking to see if we are in demo mode and if we should not execute this
#*  page.
#****************************************************************************
if (isset($restrictInDemo) && $restrictInDemo && OBIB_DEMO_FLG) {
    include("../shared/demo_msg.php");
}

?>
