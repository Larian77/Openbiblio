<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "cataloging";
  $nav = "editmarc";
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);


  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  $fieldid = $_GET["fieldid"];
  $tag = $_GET["tag"];
  $subfieldCd = $_GET["subfieldCd"];

  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delfieldform" method="POST" action="../catalog/biblio_marc_del.php?bibid=<?php echo HURL($bibid);?>&amp;fieldid=<?php echo HURL($fieldid);?>">
  <?php echo $loc->getText("biblioMarcDelConfirmMsg",array("tag"=>$tag,"subfieldCd"=>$subfieldCd)); ?>
  <br><br>
  <input type="submit" value="Delete" class="button">
  <input type="button" onClick="self.location='../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>'" value="Cancel" class="button">
</form>
</center>
<?php include("../shared/footer.php"); ?>
