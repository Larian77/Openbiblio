<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "copy_fields";
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
    header("Location: ../admin/copy_fields_new_form.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $pageErrors = array();
  if (!isset($_POST['code']) or !$_POST['code']) {
    $pageErrors['code'] = 'This is a required field.';
  }
  if (!isset($_POST['description']) or !$_POST['description']) {
    $pageErrors['description'] = 'This is a required field.';
  }
  if (!empty($pageErrors)) {
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/copy_fields_new_form.php");
    exit();
  }

  #**************************************************************************
  #*  Insert new domain table row
  #**************************************************************************
  $dm = new Dm();
  $dm->setCode($_POST["code"]);
  $dm->setDescription($_POST["description"]);
  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $dmQ->insert("biblio_copy_fields_dm",$dm);
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
<?php echo $loc->getText("Copy field, %desc%, has been added.", array('desc'=>htmlspecialchars($dm->getDescription())));?><br><br>
<a href="../admin/copy_fields_list.php"><?php echo $loc->getText("return to copy fields list"); ?></a>

<?php require_once("../shared/footer.php"); ?>
