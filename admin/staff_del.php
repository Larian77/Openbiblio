<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "staff";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/StaffQuery.php");
  require_once("../functions/errorFuncs.php");
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
  #*  Delete staff member
  #**************************************************************************
  $staffQ = new StaffQuery();
  $staffQ->connect_e();
  if ($staffQ->errorOccurred()) {
    $staffQ->close();
    displayErrorPage($staffQ);
  }
  if (!$staffQ->delete($uid)) {
    $staffQ->close();
    displayErrorPage($staffQ);
  }
  $staffQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("adminStaff_Staffmember"); ?> <?php echo H($first_name);?> <?php echo H($last_name);?><?php echo $loc->getText("adminStaff_delDeleted"); ?><br><br>
<a href="../admin/staff_list.php"><?php echo $loc->getText("adminStaff_Return"); ?></a>

<?php require_once("../shared/footer.php"); ?>
