<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "cataloging";
  $nav = "view";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioFieldQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $bibid = $_GET["bibid"];
  $fieldid = $_GET["fieldid"];

  #**************************************************************************
  #*  Delete bibliography field
  #**************************************************************************
  $fieldQ = new BiblioFieldQuery();
  $fieldQ->connect_e();
  if ($fieldQ->errorOccurred()) {
    $fieldQ->close();
    displayErrorPage($fieldQ);
  }
  if (!$fieldQ->delete($bibid,$fieldid)) {
    $fieldQ->close();
    displayErrorPage($fieldQ);
  }
  $fieldQ->close();

  #**************************************************************************
  #*  Show success message
  #**************************************************************************
  $msg = $loc->getText("biblioMarcDelSuccess");
  header("Location: ../catalog/biblio_marc_list.php?bibid=".U($bibid)."&msg=".U($msg));
  exit();
?>
