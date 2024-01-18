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
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../circ/index.php");
    exit();
  }

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $mbrid = $_POST["mbrid"];

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $trans = new MemberAccountTransaction();
  $trans->setMbrid($mbrid);
  $trans->setCreateUserid($_SESSION["userid"]);
  $trans->setTransactionTypeCd($_POST["transactionTypeCd"]);
  $_POST["transactionTypeCd"] = $trans->getTransactionTypeCd();
  $trans->setAmount($_POST["amount"]);
  $_POST["amount"] = $trans->getAmount();
  $trans->setDescription($_POST["description"]);
  $_POST["description"] = $trans->getDescription();
  $validData = $trans->validateData();
  if (!$validData) {
    $pageErrors["amount"] = $trans->getAmountError();
    $pageErrors["description"] = $trans->getDescriptionError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/mbr_account.php?mbrid=".U($mbrid));
    exit();
  }

  #**************************************************************************
  #*  Insert new member transaction
  #**************************************************************************
  $transQ = new MemberAccountQuery();
  $transQ->connect_e();
  if ($transQ->errorOccurred()) {
    $transQ->close();
    displayErrorPage($transQ);
  }
  $trans = $transQ->insert($trans);
  if ($transQ->errorOccurred()) {
    $transQ->close();
    displayErrorPage($transQ);
  }
  $transQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  $msg = $loc->getText("mbrTransactionSuccess");
  header("Location: ../circ/mbr_account.php?mbrid=".U($mbrid)."&reset=Y&msg=".U($msg));
  exit();
?>
