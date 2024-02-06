<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "admin";
$nav = "collections";
$focus_form_name = "newcollectionform";
$focus_form_field = "description";

require_once ("../functions/inputFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../shared/get_form_vars.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

require_once ("../shared/header.php");

?>

<form name="newcollectionform" method="POST"
	action="../admin/collections_new.php">
	<table class="primary">
		<tr>
			<th style="white-space: nowrap;" colspan="2" align="left">
      <?php echo $loc->getText("adminCollections_new_formAddnewcollection"); ?>
    </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
      <?php echo $loc->getText("adminCollections_new_formDescription"); ?>
    </td>
			<td valign="top" class="primary">
      <?php printInputText("description",40,40,$postVars,$pageErrors); ?>
    </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary"><font class="small">*</font><?php echo $loc->getText("adminCollections_new_formDaysdueback"); ?>
    </td>
			<td valign="top" class="primary">
      <?php printInputText("daysDueBack",2,2,$postVars,$pageErrors); ?>
    </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary"><font class="small">*</font><?php echo $loc->getText("adminCollections_new_formDailylatefee"); ?>
    </td>
			<td valign="top" class="primary">
      <?php printInputText("dailyLateFee",7,7,$postVars,$pageErrors); ?>
    </td>
		</tr>
		<tr>
			<td align="center" colspan="2" class="primary"><input type="submit"
				value="  <?php echo $loc->getText("adminSubmit"); ?>  "
				class="button"> <input type="button"
				onClick="self.location='../admin/collections_list.php'"
				value="  <?php echo $loc->getText("adminCancel"); ?>  "
				class="button"></td>
		</tr>

	</table>
</form>
<table>
	<tr>
		<td valign="top"><font class="small"><?php echo $loc->getText("adminCollections_new_formNote"); ?></font></td>
		<td><font class="small"><?php echo $loc->getText("adminCollections_new_formNoteText"); ?><br></font>
		</td>
	</tr>
</table>


<?php include("../shared/footer.php"); ?>
