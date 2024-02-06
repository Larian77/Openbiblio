<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "admin";
$nav = "copy_fields";
$focus_form_name = "newfieldform";
$focus_form_field = "code";

require_once ("../functions/inputFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../shared/get_form_vars.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);
require_once ("../shared/header.php");

?>

<form name="newfieldform" method="POST"
	action="../admin/copy_fields_new.php">
	<table class="primary">
		<tr>
			<th style="white-space: nowrap;" colspan="2" align="left">
      <?php echo $loc->getText("Add custom copy field"); ?>
    </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
      <?php echo $loc->getText("Code:"); ?>
    </td>
			<td valign="top" class="primary">
      <?php printInputText("code",40,40,$postVars,$pageErrors); ?>
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
