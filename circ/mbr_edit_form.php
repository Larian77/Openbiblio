<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "circulation";
  $restrictToMbrAuth = TRUE;
  $nav = "edit";
  $focus_form_name = "editMbrform";
  $focus_form_field = "barcodeNmbr";
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");

  if (isset($_GET["mbrid"])){
    $mbrid = $_GET["mbrid"];
  } else {
    require("../shared/get_form_vars.php");
    $mbrid = $postVars["mbrid"];
  }
  $mbrQ = new MemberQuery();
  $mbrQ->connect_e();
  $mbr = $mbrQ->get($mbrid);
  $mbrQ->close();

  foreach($mbr->_custom as $name => $value) {
    $mbr->setCustom($name, $value);
    $_POST["$name"] = $mbr->getCustom($name);;
  }
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  $headerWording = $loc->getText("mbrEditForm");

  $cancelLocation = "../circ/mbr_view.php?mbrid=".$mbrid."&reset=Y";
?>

<form name="editMbrform" method="POST" action="../circ/mbr_edit.php">
	<input type="hidden" name="mbrid" value="<?php echo H($mbrid);?>">
<?php include("../circ/mbr_fields.php"); ?>
<?php include("../shared/footer.php"); ?>
