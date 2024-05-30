<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "opac";
  $restrictToMbrAuth = TRUE;
  $nav = "PwdReset";
  $restrictInDemo = true;
  require_once("../opac/logincheck.php");

  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php"); 
  $loc = new Localize(OBIB_LOCALE,'shared');
  
  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../opac/index.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $mbrid = $_POST["mbrid"];

  $mbr = new Member();
  $mbr->setMbrid($_POST["mbrid"]);
  $mbr->setPwd($_POST["pwd"]);
  $_POST["pwd"] = $mbr->getPwd();
  $mbr->setPwdRepeat($_POST["pwdRepeat"]);
  $_POST["pwdRepeat"] = $mbr->getPwdRepeat();
  
  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $customFields = $dmQ->getAssoc('member_fields_dm');
  $dmQ->close();
  
  $validData = $mbr->validatePwd();
  if (!$validData) {
    $pageErrors["pwdError"] = $mbr->getPwdError();
    $_SESSION["pageErrors"] = $pageErrors;
    $_SESSION["postVars"] = $_POST;
    header("Location: ../opac/mbr_pwd_reset_form.php?mbrid=$mbrid");
    exit();
  }

  #**************************************************************************
  #*  Reset password in member (fields)
  #**************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect_e();
  $mbrQ->resetPwd($mbr);
  $mbrQ->close();
 
  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");

  echo $loc->getText("mbr_pwd_reset_successfully");?>
  <br><br>
  <a href="../opac/mbr_account.php?mbrid=<?php echo U($mbrid) ?>"> <?php echo $loc->getText("mbr_return") ?> </a>
  

  <?php require_once("../shared/footer.php"); ?>