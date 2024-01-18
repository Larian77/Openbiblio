<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
#*********************************************************************************
#*  checklogin.php
#*  Description: Used to verify signon token on every secured page.
#*               Redirects to the login page if token not valid.
#*********************************************************************************

  require_once("../functions/errorFuncs.php");

  #****************************************************************************
  #*  Temporarily disabling security for demo since sourceforge.net
  #*  seems to be using mirrored servers that do not share session info.
  #****************************************************************************
  if (!OBIB_DEMO_FLG) {

    $pages = array(
      'opac'=>'../opac/index.php',
      'home'=>'../home/index.php',
      'circulation'=>'../circ/index.php',
      'cataloging'=>'../catalog/index.php',
      'admin'=>'../admin/index.php',
      'reports'=>'../reports/index.php',
    );
  $returnPage = $pages[$tab];
  $_SESSION["returnPage"] = $returnPage;

  #****************************************************************************
  #*  Checking to see if session variables exist
  #****************************************************************************
  if (!isset($_SESSION["mbrid"]) or ($_SESSION["mbrid"] == "")) {
    header("Location: ../opac/loginform.php");
    exit();
  }
  if (!isset($_SESSION["mbrtoken"]) or ($_SESSION["mbrtoken"] == "")) {
    header("Location: ../opac/loginform.php");
    exit();
  }
  if (($_SESSION["mbrid"] != $_GET["mbrid"]) and ($_SESSION["mbrid"] != trim($_POST["mbrid"]))) {
    header("Location: ../opac/loginform.php");
    exit();
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
