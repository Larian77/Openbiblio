<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "admin";
  $nav = "staff";
  $focus_form_name = "editstaffform";
  $focus_form_field = "last_name";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  require_once("../shared/header.php");

  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #****************************************************************************
  if (isset($_GET["UID"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    $postVars["userid"] = $_GET["UID"];
    include_once("../classes/Staff.php");
    include_once("../classes/StaffQuery.php");
    include_once("../functions/errorFuncs.php");
    $staffQ = new StaffQuery();
    $staffQ->connect_e();
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ);
    }
    $staffQ->execSelect($postVars["userid"]);
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ);
    }
    $staff = $staffQ->fetchStaff();
    $postVars["last_name"] = $staff->getLastName();
    $postVars["first_name"] = $staff->getFirstName();
    $postVars["username"] = $staff->getUsername();
    $postVars["email"] = $staff->getEmail();
    if ($staff->hasCircAuth()) {
      $postVars["circ_flg"] = "CHECKED";
    } else {
      $postVars["circ_flg"] = "";
    }
    if ($staff->hasCircMbrAuth()) {
      $postVars["circ_mbr_flg"] = "CHECKED";
    } else {
      $postVars["circ_mbr_flg"] = "";
    }
    if ($staff->hasCatalogAuth()) {
      $postVars["catalog_flg"] = "CHECKED";
    } else {
      $postVars["catalog_flg"] = "";
    }
    if ($staff->hasAdminAuth()) {
      $postVars["admin_flg"] = "CHECKED";
    } else {
      $postVars["admin_flg"] = "";
    }
    if ($staff->hasReportsAuth()) {
      $postVars["reports_flg"] = "CHECKED";
    } else {
      $postVars["reports_flg"] = "";
    }
    if ($staff->isSuspended()) {
      $postVars["suspended_flg"] = "CHECKED";
    } else {
      $postVars["suspended_flg"] = "";
    }
    $staffQ->close();
  } else {
    require("../shared/get_form_vars.php");
  }

?>

<form name="editstaffform" method="POST" action="../admin/staff_edit.php">
<input type="hidden" name="userid" value="<?php echo H($postVars["userid"]);?>">
<table class="primary">
  <tr>
    <th style="white-space:nowrap;" align="left" colspan="2">
      <?php echo $loc->getText("adminStaff_edit_formHeader"); ?>
    </th>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formLastname"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("last_name",30,30,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formFirstname"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("first_name",30,30,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formLogin"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("username",20,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_email"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("email",30,30,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formAuth"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" name="circ_flg" value="CHECKED"
        <?php if (isset($postVars["circ_flg"])) echo H($postVars["circ_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formCirc"); ?>
      <input type="checkbox" name="circ_mbr_flg" value="CHECKED"
        <?php if (isset($postVars["circ_mbr_flg"])) echo H($postVars["circ_mbr_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formUpdatemember"); ?>
      <input type="checkbox" name="catalog_flg" value="CHECKED"
        <?php if (isset($postVars["catalog_flg"])) echo H($postVars["catalog_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formCatalog"); ?>
      <input type="checkbox" name="admin_flg" value="CHECKED"
        <?php if (isset($postVars["admin_flg"])) echo H($postVars["admin_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formAdmin"); ?>
      <input type="checkbox" name="reports_flg" value="CHECKED"
        <?php if (isset($postVars["reports_flg"])) echo H($postVars["reports_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formReports"); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formSuspended"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" name="suspended_flg" value="CHECKED"
        <?php if (isset($postVars["suspended_flg"])) echo H($postVars["suspended_flg"]); ?> >
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <?php echo $loc->getText("adminSubmit"); ?>  " class="button">
      <input type="button" onClick="self.location='../admin/staff_list.php'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
    </td>
  </tr>
</table>
</form>

<?php include("../shared/footer.php"); ?>
