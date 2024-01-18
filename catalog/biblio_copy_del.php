<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "cataloging";
  $nav = "view";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $bibid = $_GET["bibid"];
  $copyid = $_GET["copyid"];
  $barcode = $_GET["barcode"];

  #**************************************************************************
  #*  Delete Bibliography Copy
  #**************************************************************************
  $copyQ = new BiblioCopyQuery();
  $copyQ->connect_e();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copyQ->delete($bibid,$copyid)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  $copyQ->close();

  #**************************************************************************
  #*  Delete Copy History
  #**************************************************************************
  $histQ = new BiblioStatusHistQuery();
  $histQ->connect_e();
  if ($histQ->errorOccurred()) {
    $histQ->close();
    displayErrorPage($histQ);
  }
  if (!$histQ->deleteByBibid($bibid,$copyid)) {
    $histQ->close();
    displayErrorPage($histQ);
  }
  $histQ->close();

  #**************************************************************************
  #*  Show success message
  #**************************************************************************
  $msg = $loc->getText("biblioCopyDelSuccess",array("barcode"=>$barcode));
  header("Location: ../shared/biblio_view.php?bibid=".U($bibid)."&msg=".U($msg));
  exit();
?>
