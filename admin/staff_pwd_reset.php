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
$loc = new Localize(OBIB_LOCALE, $tab);

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
$staff->setUserid($_POST["userid"]);
$staff->setPwd($_POST["pwd"]);
$_POST["pwd"] = $staff->getPwd();
$staff->setPwd2($_POST["pwd2"]);
$_POST["pwd2"] = $staff->getPwd2();
if (!$staff->validatePwd()) {
    $pageErrors["pwd"] = $staff->getPwdError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/staff_pwd_reset_form.php");
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
if (!$staffQ->resetPwd($staff)) {
    $staffQ->close();
    displayErrorPage($staffQ);
}
$staffQ->close();

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
<?php echo $loc->getText("adminStaff_pwd_reset_Passwordreset"); ?><br><br>
<a href="../admin/staff_list.php">
    <?php echo $loc->getText("adminStaff_Return"); ?>
</a>

<?php require_once("../shared/footer.php"); ?>
