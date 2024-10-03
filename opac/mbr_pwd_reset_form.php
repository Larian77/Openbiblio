<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);
  
  $tab = "opac";
  $restrictToMbrAuth = TRUE;
  $nav = "PwdReset";
  $focus_form_name = "mbrpwdresetform";
  $focus_form_field = "mbrid";
  
  require_once("../functions/inputFuncs.php");
  require_once("../opac/logincheck.php");
  require_once("../shared/header_opac.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,'shared');
  
  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");

  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #****************************************************************************
  
  if (isset($_GET["mbrid"])){
    $mbrid = $_GET["mbrid"];
  } else {
    require("../shared/get_form_vars.php");
    $mbrid = $postVars["mbrid"];
  }
  if (isset($_SESSION["pageErrors"])) {
      $pageErrors = $_SESSION["pageErrors"];
  }
  if (isset($_SESSION["postVars"])) {
      $postVars = $_SESSION["postVars"];
  }
  $mbrQ = new MemberQuery();
  $mbrQ->connect_e();
  $mbr = $mbrQ->get($mbrid);
  $mbrQ->close();
  
  $cancelLocation = "../opac/mbr_account.php?mbrid=$mbr->_mbrid";
?>

<form name="mbrpwdresetform" method="POST" action="../opac/mbr_pwd_reset.php?mbrid=<?php echo U($mbrid); ?>">
<input type="hidden" name="mbrid" value="<?php echo H($mbrid);?>">
<table class="primary">
  <tr>
    <th colspan="2" valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbr_pwd_reset_form_Resetheader"); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("new_form_Password"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $loc->getText("PwdRequirement"); ?>
      <input type="password" name="pwd" size="20" maxlength="20"
      value="<?php if (isset($postVars["pwd"])) echo H($postVars["pwd"]); ?>" ><br>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("new_form_Reenterpassword"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="password" name="pwdRepeat" size="20" maxlength="20"
      value="<?php if (isset($postVars["pwdRepeat"])) echo H($postVars["pwdRepeat"]); ?>" ><br>
      <font class="error">
      <?php if (isset($pageErrors["pwdError"])) echo H($pageErrors["pwdError"]); ?></font>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <?php echo $loc->getText("sharedSubmit"); ?>  " class="button">
      <input type="button" onClick="self.location='<?php echo H(addslashes($cancelLocation));?>'" value="<?php echo $loc->getText("sharedCancel"); ?> " class="button">
    </td>
  </tr>

</table>
</form>

<?php 

include("../shared/footer.php"); ?>
