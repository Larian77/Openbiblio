<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $nav = "account";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/MemberAccountTransaction.php");
  require_once("../classes/MemberAccountQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $mbrid = $_GET["mbrid"];
  $transid = $_GET["transid"];

  #**************************************************************************
  #*  Delete member transaction
  #**************************************************************************
  $transQ = new MemberAccountQuery();
  $transQ->connect_e();
  if ($transQ->errorOccurred()) {
    $transQ->close();
    displayErrorPage($transQ);
  }
  $trans = $transQ->delete($mbrid,$transid);
  if ($transQ->errorOccurred()) {
    $transQ->close();
    displayErrorPage($transQ);
  }
  $transQ->close();

  $msg = $loc->getText("mbrTransactionDelSuccess");
  header("Location: ../circ/mbr_account.php?mbrid=".U($mbrid)."&reset=Y&msg=".U($msg));
  exit();
?>
