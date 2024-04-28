<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "staff";
  $focus_form_name = "pwdresetform";
  $focus_form_field = "pwd";

  include("../shared/logincheck.php");
  include("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #****************************************************************************
  if (isset($_GET["UID"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    $postVars["userid"] = $_GET["UID"];
  } else {
    require("../shared/get_form_vars.php");
  }

?>

<form name="pwdresetform" method="POST" action="../admin/staff_pwd_reset.php">
<input type="hidden" name="userid" value="<?php echo H($postVars["userid"]);?>">
<table class="primary">
  <tr>
    <th style="white-space:nowrap;" colspan="2" valign="top" align="left">
      <?php echo $loc->getText("adminStaff_pwd_reset_form_Resetheader"); ?>
    </th>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_new_form_Password"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $loc->getText("adminStaffPwdRequirement"); ?>
      <input type="password" name="pwd" size="20" maxlength="20"
      value="<?php if (isset($postVars["pwd"])) echo H($postVars["pwd"]); ?>" ><br>
      <font class="error">
      <?php if (isset($pageErrors["pwd"])) echo H($pageErrors["pwd"]); ?></font>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_new_form_Reenterpassword"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="password" name="pwd2" size="20" maxlength="20"
      value="<?php if (isset($postVars["pwd2"])) echo H($postVars["pwd2"]); ?>" ><br>
      <font class="error">
      <?php if (isset($pageErrors["pwd2"])) echo H($pageErrors["pwd2"]); ?></font>
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
