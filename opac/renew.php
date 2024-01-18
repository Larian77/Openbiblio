<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "opac";
  $nav = "memberaccount";
  $restrictInDemo = true;
  require_once("../opac/logincheck.php");

  require_once("../classes/MemberQuery.php");
  require_once("../opac/CircQuery.php");
  require_once("../classes/Date.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  if (count($_GET) != 0) {
      $_POST = $_GET;
  }
  if (count($_POST) == 0) {
    header("Location: ../opac/index.php");
    exit();
  }
  $barcode = trim($_POST["barcodeNmbr"]);
  $mbrid = trim($_POST["mbrid"]);
  $mbrQ = new MemberQuery;
  $mbr = $mbrQ->get($mbrid);
  
  $postVars = $_POST;
  $pageErrors = array();
  
  function checkerror($field, $err) {
    global $mbrid, $postVars, $pageErrors;
    if (!$err)
      return;
    $pageErrors[$field] = $err->toStr();
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../opac/mbr_account.php?mbrid=".U($mbrid));
    exit();
  }
  
  $circQ = new CircQuery;
  $err = $circQ->checkout_e($mbr->getBarcodeNmbr(), $barcode);
  checkerror('barcodeNmbr', $err);

  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  header("Location: ../opac/mbr_account.php?mbrid=".U($mbrid));
