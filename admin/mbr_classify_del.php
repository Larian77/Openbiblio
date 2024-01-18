<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "classifications";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/CheckoutPrivsQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string.  Go back to collection list if none found.
  #****************************************************************************
  if (!isset($_GET["code"])){
    header("Location: ../admin/mbr_classify_list.php");
    exit();
  }
  $code = $_GET["code"];
  $description = $_GET["desc"];

  #**************************************************************************
  #*  Delete row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $dmQ->delete("mbr_classify_dm",$code);
  $dmQ->close();
  
  $checkoutPrivsQ = new CheckoutPrivsQuery();
  $checkoutPrivsQ->connect_e();
  $checkoutPrivsQ->delete_by_classification($code);
  $checkoutPrivsQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("Classification type, %desc%, has been deleted.", array('desc'=>$description));?><br><br>
<a href="../admin/mbr_classify_list.php"><?php echo $loc->getText("return to member classification list"); ?></a>

<?php require_once("../shared/footer.php"); ?>
