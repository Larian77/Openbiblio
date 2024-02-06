<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "admin";
$nav = "copy_fields";
$focus_form_name = "editfieldform";
$focus_form_field = "description";

require_once ("../functions/inputFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);
require_once ("../shared/header.php");

# ****************************************************************************
# * Checking for query string flag to read data from database.
# ****************************************************************************
if (isset($_GET["code"])) {
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    $code = $_GET["code"];
    $postVars["code"] = $code;
    include_once ("../classes/Dm.php");
    include_once ("../classes/DmQuery.php");
    include_once ("../functions/errorFuncs.php");
    $dmQ = new DmQuery();
    // Changes PVD(8.0.x)
    $dmQ->connect_e();
    $dm = $dmQ->get1("biblio_copy_fields_dm", $code);
    $postVars["code"] = $dm->getCode();
    $postVars["description"] = $dm->getDescription();
    $dmQ->close();
} else {
    require ("../shared/get_form_vars.php");
}
?>

<form name="editfieldform" method="POST"
	action="../admin/copy_fields_edit.php">
	<input type="hidden" name="code"
		value="<?php echo H($postVars["code"]);?>">
	<table class="primary">
		<tr>
			<th style="white-space: nowrap;" colspan="2" align="left">
      <?php echo $loc->getText("Edit Copy Field"); ?>
    </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
      <?php echo $loc->getText("Code:"); ?>
    </td>
			<td valign="top" class="primary">
      <?php echo H($postVars['code']); ?>
    </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
      <?php echo $loc->getText("Description:"); ?>
    </td>
			<td valign="top" class="primary">
      <?php printInputText("description",40,40,$postVars,$pageErrors); ?>
    </td>
		</tr>
		<tr>
			<td align="center" colspan="2" class="primary"><input type="submit"
				value="  <?php echo $loc->getText("adminSubmit"); ?>  "
				class="button"> <input type="button"
				onClick="self.location='../admin/copy_fields_list.php'"
				value="  <?php echo $loc->getText("adminCancel"); ?>  "
				class="button"></td>
		</tr>

	</table>
</form>

<?php include("../shared/footer.php"); ?>
