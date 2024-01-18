<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $nav = "checkin";
  $focus_form_name = "barcodesearch";
  $focus_form_field = "barcodeNmbr";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  $barcode = $_GET["barcode"];
  $params = "?barcode=".U($barcode);
  if (isset($_GET['mbrid'])) {
    $params .= "&mbrid=".U($_GET['mbrid']);
  }
  if (isset($_GET['late'])) {
    $params .= "&late=".U($_GET['late']);
  }
  
?>
<h1><?php echo $loc->getText("holdMessageHdr"); ?></h1>
<?php echo $loc->getText("holdMessageMsg1",array("barcode"=>$barcode)); ?>
<br><br>
<a href="../circ/checkin_form.php<?php echo H($params); ?>"><?php echo $loc->getText("holdMessageMsg2"); ?></a>
<?php require_once("../shared/footer.php"); ?>
