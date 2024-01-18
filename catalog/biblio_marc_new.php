<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "cataloging";
  $nav = "view";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/BiblioField.php");
  require_once("../classes/BiblioFieldQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $bibid=$_POST["bibid"];
  $fld = new BiblioField();
  $fld->setBibid($bibid);
  $fld->setTag($_POST["tag"]);
  $_POST["tag"] = $fld->getTag();
  $fld->setSubfieldCd($_POST["subfieldCd"]);
  $_POST["subfieldCd"] = $fld->getSubfieldCd();
  if (isset($_POST["ind1Cd"])) {
    $fld->setInd1Cd("Y");
  } else {
    $fld->setInd1Cd("N");
  }
  if (isset($_POST["ind2Cd"])) {
    $fld->setInd2Cd("Y");
  } else {
    $fld->setInd2Cd("N");
  }
  $fld->setFieldData($_POST["fieldData"]);
  $fld->setIsRequired(true);
  $_POST["fieldData"] = $fld->getFieldData();
  $validData = $fld->validateData();
  if (!$validData) {
    $pageErrors["fieldData"] = $fld->getFieldDataError();
    $pageErrors["tag"] = $fld->getTagError();
    $pageErrors["subfieldCd"] = $fld->getSubfieldCdError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../catalog/biblio_marc_new_form.php");
    exit();
  }

  #**************************************************************************
  #*  Insert new bibliography field
  #**************************************************************************
  $fieldQ = new BiblioFieldQuery();
  $fieldQ->connect_e();
  if ($fieldQ->errorOccurred()) {
    $fieldQ->close();
    displayErrorPage($fieldQ);
  }
  if (!$fieldQ->insert($fld)) {
    $fieldQ->close();
    displayErrorPage($fieldQ);
  }
  $fieldQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  $msg = $loc->getText("biblioMarcNewSuccess");
  header("Location: ../catalog/biblio_marc_list.php?bibid=".U($bibid)."&msg=".U($msg));
  exit();
?>
