<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  #****************************************************************************
  #*  Checking for get vars.
  #****************************************************************************
  $bibid = $_GET["bibid"];
  $copyid = $_GET["copyid"];
  $holdid = $_GET["holdid"];
  $mbrid = $_GET["mbrid"];
  if ($mbrid == "") {
    $tab = "cataloging";
    $nav = "holds";
    $returnNav = "../catalog/biblio_hold_list.php?bibid=".U($bibid);
  } else {
    $tab = "circulation";
    $nav = "view";
    $returnNav = "../circ/mbr_view.php?mbrid=".U($mbrid);
  }
  $restrictInDemo = TRUE;
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");

  #**************************************************************************
  #*  Delete hold
  #**************************************************************************
  // we need to also insert into status history table
  $holdQ = new BiblioHoldQuery();
  $holdQ->connect_e();
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  $rc = $holdQ->delete($bibid,$copyid,$holdid);
  if (!$rc) {
    $holdQ->close();
    displayErrorPage($copyQ);
  }
  $holdQ->close();

  #**************************************************************************
  #*  Go back to member view
  #**************************************************************************
  $msg = $loc->getText("holdDelSuccess");
  header("Location: ".$returnNav."&msg=".U($msg));
?>
