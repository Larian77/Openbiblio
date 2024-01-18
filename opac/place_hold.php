<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "opac";
  $nav = "memberaccount";
  $restrictInDemo = true;
  require_once("../opac/logincheck.php");

  require_once("../classes/BiblioHold.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../opac/index.php");
    exit();
  }
  $barcode = trim($_POST["holdBarcodeNmbr"]);
  $mbrid = trim($_POST["mbrid"]);

  // Check to see if this member already has the item checked out.
  $copyQ = new BiblioCopyQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  $copy = $copyQ->queryByBarcode($barcode);
  if (!$copy) {
    $copyQ->close();
    displayErrorPage($copyQ);
  } else if (!is_a($copy, 'BiblioCopy')) {
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr2");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../opac/mbr_account.php?mbrid=".U($mbrid));
    exit();
  } else if ($copy->getStatusCd() == OBIB_STATUS_OUT
             and $copy->getMbrid() == $mbrid) {
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("placeHoldErr3");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../opac/mbr_account.php?mbrid=".U($mbrid));
    exit();
  } else if ($copy->getStatusCd() != OBIB_STATUS_OUT && $copy->getStatusCd() != OBIB_STATUS_ON_HOLD) {
    $pageErrors["holdBarcodeNmbr"] = $loc->getText("This item is not checked out or on hold.");
    $postVars["holdBarcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../opac/mbr_account.php?mbrid=".U($mbrid));
    exit();
  }

  #**************************************************************************
  #*  Insert hold
  #**************************************************************************
  // we need to also insert into status history table
  $holdQ = new BiblioHoldQuery();
  $holdQ->connect();
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  $rc = $holdQ->insert($mbrid,$barcode);
  if (!$rc) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  $holdQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Go back to member view
  #**************************************************************************
  header("Location: ../opac/mbr_account.php?mbrid=".U($_POST["mbrid"]));
?>
