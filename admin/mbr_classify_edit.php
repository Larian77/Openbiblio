<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "classifications";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../admin/mbr_classify_list.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $dm = new Dm();
  $dm->setCode($_POST["code"]);
  $_POST["code"] = $dm->getCode();
  $dm->setDescription($_POST["description"]);
  $_POST["description"] = $dm->getDescription();
  $dm->setMaxFines($_POST["max_fines"]);
  $_POST["max_fines"] = $dm->getMaxFines();

  if (!$dm->validateData()) {
    $pageErrors["description"] = $dm->getDescriptionError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/mbr_classify_edit_form.php");
    exit();
  }

  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $dmQ->update("mbr_classify_dm",$dm);
  $dmQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("Classification type, %desc%, has been updated.", array('desc'=>$dm->getDescription()));?><br><br>
<a href="../admin/mbr_classify_list.php"><?php echo $loc->getText("return to member classification list"); ?></a>

<?php require_once("../shared/footer.php"); ?>
