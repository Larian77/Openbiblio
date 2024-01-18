<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");


  $tab = "admin";
  $nav = "new";
  $focus_form_name = "custommarcform";
  $focus_form_field = "tag";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../catalog/marcFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $postVars = array();
  $pageErrors = array();
  if (isset($_GET["materialCd"])) {
    $materialCd = $_GET["materialCd"];
    $postVars["materialCd"] = $materialCd;
    $postVars["tag"] = "";
    $postVars["subfieldCd"] = "";
    $postVars["descr"] = "";
    $postVars["required"] = "";
  } else if (isset($_SESSION['postVars'])) {
    $postVars = $_SESSION['postVars'];
    if (isset($_SESSION['pageErrors'])) {
      $pageErrors = $_SESSION['pageErrors'];
    }
    $materialCd = $postVars['materialCd'];
  }
  if (!isset($materialCd) || $materialCd == "") {
    Fatal::internalError('no material code set');
  }
  if (isset($_GET["tag"])) {
    $postVars["tag"] = $_GET["tag"];
  }
  if (isset($_GET["subfld"])) {
    $postVars["subfieldCd"] = $_GET["subfld"];
  }
  if (isset($_GET["descr"])) {
    $postVars["descr"] = $_GET["descr"];
  }

  require_once("../shared/header.php");

  $returnPg = "../admin/custom_marc_add_form.php?materialCd=".U($materialCd);
  $fieldid = "";
  $cancelLocation ="../admin/custom_marc_view.php?materialCd=$materialCd";
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".H($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }

  #****************************************************************************
  #*  Start of body
  #****************************************************************************
echo $msg;
?>

<form name="custommarcform" action="custom_marc_add.php" method="post">
<input type="hidden" name="materialCd" value="<?php echo H($materialCd); ?>">
<input type="hidden" name="posted" value="posted">
<?php include ("../admin/custom_marc_form_fields.php"); ?>
</FORM>
<?php include("../shared/footer.php");?>
    
