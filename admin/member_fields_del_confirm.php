<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "member_fields";
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string.  Go back to list if none found.
  #****************************************************************************
  if (!isset($_GET["code"])){
    header("Location: ../admin/member_fields_list.php");
    exit();
  }
  $code = $_GET["code"];
  $description = $_GET["desc"];

  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delstaffform" method="POST" action="../admin/member_fields_del.php">
  <input type="hidden" name="code" value="<?php echo H($code);?>" />
  <input type="hidden" name="desc" value="<?php echo H($description);?>" />
<?php echo $loc->getText("Are you sure you want to delete field '%desc%'?", array('desc'=>$description)); ?><br><br>
      <input type="submit" value="  <?php echo $loc->getText("adminDelete"); ?>  " class="button">
      <input type="button" onClick="self.location='../admin/member_fields_list.php'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
</form>
</center>
<?php include("../shared/footer.php"); ?>
