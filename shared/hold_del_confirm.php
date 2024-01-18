<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  #****************************************************************************
  #*  Checking for get vars.
  #****************************************************************************
  $bibid = $_GET["bibid"];
  $copyid = $_GET["copyid"];
  $holdid = $_GET["holdid"];
  if (isset($_GET["mbrid"])) {
    $mbrid = $_GET["mbrid"];
    $tab = "circulation";
    $nav = "view";
    $returnUrl = "../circ/mbr_view.php?mbrid=".$mbrid;
  } else {
    $mbrid = "";
    $tab = "cataloging";
    $nav = "holds";
    $returnUrl = "../catalog/biblio_hold_list.php?bibid=".$bibid;
  }
  
  $restrictInDemo = TRUE;
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");

  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delbiblioform" method="POST" action="<?php echo H($returnUrl);?>">
<?php echo $loc->getText("holdDelConfirmMsg"); ?>
<br><br>
      <input type="button" onClick="self.location='../shared/hold_del.php?bibid=<?php echo H(addslashes(U($bibid)));?>&amp;copyid=<?php echo H(addslashes(U($copyid)));?>&amp;holdid=<?php echo H(addslashes(U($holdid)));?>&amp;mbrid=<?php echo H(addslashes(U($mbrid)));?>'" value="<?php echo $loc->getText("sharedDelete"); ?>" class="button">
      <input type="submit" value="<?php echo $loc->getText("sharedCancel"); ?>" class="button">
</form>
</center>

<?php include("../shared/footer.php");?>
