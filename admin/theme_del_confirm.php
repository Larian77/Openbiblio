<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "themes";
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  #****************************************************************************
  #*  Checking for query string.  Go back to theme list if none found.
  #****************************************************************************
  if (!isset($_GET["themeid"])){
    header("Location: ../admin/theme_list.php");
    exit();
  }
  $themeid = $_GET["themeid"];
  $name = $_GET["name"];

  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delstaffform" method="POST" action="../admin/theme_del.php?themeid=<?php echo HURL($themeid);?>&amp;name=<?php echo HURL($name);?>">
<?php echo $loc->getText("adminTheme_Deleteconfirm"); ?><?php echo H($name);?>?<br><br>
      <input type="submit" value="  <?php echo $loc->getText("adminDelete"); ?>  " class="button">
      <input type="button" onClick="self.location='../admin/theme_list.php'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
</form>
</center>
<?php include("../shared/footer.php"); ?>
