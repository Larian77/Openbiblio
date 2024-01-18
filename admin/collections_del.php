<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "collections";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string.  Go back to collection list if none found.
  #****************************************************************************
  if (!isset($_GET["code"])){
    header("Location: ../admin/collections_list.php");
    exit();
  }
  $code = $_GET["code"];
  $description = $_GET["desc"];

  #**************************************************************************
  #*  Delete row
  #**************************************************************************
  $dmQ = new DmQuery();
  //Changes PVD(8.0.x)
  $dmQ->connect_e();
  $dmQ->delete("collection_dm",$code);
  $dmQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("adminCollections_delStart"); ?>
<?php echo H($description);?>
<?php echo $loc->getText("adminCollections_delEnd"); ?><br><br>
<a href="../admin/collections_list.php"><?php echo $loc->getText("adminCollections_delReturn"); ?></a>

<?php require_once("../shared/footer.php"); ?>
