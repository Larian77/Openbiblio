<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "staff";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../admin/staff_list.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $staff = new Staff();
  $staff->setLastChangeUserid($_SESSION["userid"]);
  $staff->setUserid($_POST["userid"]);
  $staff->setLastName($_POST["last_name"]);
  $_POST["last_name"] = $staff->getLastName();
  $staff->setFirstName($_POST["first_name"]);
  $_POST["first_name"] = $staff->getFirstName();
  $staff->setUsername($_POST["username"]);
  $_POST["username"] = $staff->getUsername();
  $staff->setEmail($_POST["email"]);
  $_POST["email"] = $staff->getEmail();
  $staff->setCircAuth(isset($_POST["circ_flg"]));
  $staff->setCircMbrAuth(isset($_POST["circ_mbr_flg"]));
  $staff->setCatalogAuth(isset($_POST["catalog_flg"]));
  $staff->setAdminAuth(isset($_POST["admin_flg"]));
  $staff->setReportsAuth(isset($_POST["reports_flg"]));
  $staff->setSuspended(isset($_POST["suspended_flg"]));
  if (!$staff->validateData()) {
    $pageErrors["last_name"] = $staff->getLastNameError();
    $pageErrors["username"] = $staff->getUsernameError();
    $pageErrors["email"] = $staff->getEmailError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/staff_edit_form.php");
    exit();
  }

  #**************************************************************************
  #*  Update staff member
  #**************************************************************************
  $staffQ = new StaffQuery();
  $staffQ->connect_e();
  if ($staffQ->errorOccurred()) {
    $staffQ->close();
    displayErrorPage($staffQ);
  }
  if (!$staffQ->update($staff)) {
    $staffQ->close();
    displayErrorPage($staffQ);
  }
  $staffQ->close();

  #**************************************************************************
  #*  Update $_SESSION if editor equals edited staff member
  #**************************************************************************  
  if ($_SESSION["userid"] === $staff->getUserid()) {
    $_SESSION["username"] = $staff->getUsername();
    $_SESSION["userid"] = $staff->getUserid();
    $_SESSION["firstName"] = $staff->getFirstName();
    $_SESSION["lastName"] = $staff->getLastName();
  }

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("adminStaff_Staffmember"); ?> <?php echo H($staff->getFirstName());?> <?php echo H($staff->getLastName());?><?php echo $loc->getText("adminStaff_editUpdated"); ?><br><br>
<a href="../admin/staff_list.php"><?php echo $loc->getText("adminStaff_Return"); ?></a>

<?php require_once("../shared/footer.php"); ?>
