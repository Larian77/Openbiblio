<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "staff";
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string.  Go back to staff list if none found.
  #****************************************************************************
  if (!isset($_GET["UID"])){
    header("Location: ../admin/staff_list.php");
    exit();
  }
  $uid = $_GET["UID"];
  $last_name = $_GET["LAST"];
  $first_name = $_GET["FIRST"];

  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delstaffform" method="POST" action="../admin/staff_del.php?UID=<?php echo HURL($uid);?>&amp;LAST=<?php echo HURL($last_name);?>&amp;FIRST=<?php echo HURL($first_name);?>">
<?php echo $loc->getText("adminStaff_del_confirmConfirmText"); ?><?php echo H($first_name);?> <?php echo H($last_name);?>?<br><br>
      <input type="submit" value="  <?php echo $loc->getText("adminDelete"); ?>  " class="button">
      <input type="button" onClick="self.location='../admin/staff_list.php'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
</form>
</center>
<?php include("../shared/footer.php"); ?>
