<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "cataloging";
$nav = "newcopy";
$helpPage = "biblioCopyEdit";
$focus_form_name = "newCopyForm";
$focus_form_field = "barcodeNmbr";

# ****************************************************************************
# * Checking for get vars. Go back to form if none found.
# ****************************************************************************
if (count($_GET) == 0) {
    header("Location: ../catalog/index.php");
    exit();
}

require_once ("../functions/inputFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../shared/get_form_vars.php");
require_once ('../classes/DmQuery.php');
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
$bibid = $_GET["bibid"];
require_once ("../shared/header.php");

$dmQ = new DmQuery();
$dmQ->connect_e();
$customFields = $dmQ->getAssoc('biblio_copy_fields_dm');
$dmQ->close();
?>

<font class="small">
  <?php echo $loc->getText("catalogFootnote", array("symbol" => "*")); ?>
</font>

<form name="newCopyForm" method="POST"
	action="../catalog/biblio_copy_new.php">
	<table class="primary">
		<tr>
			<th colspan="2" style="white-space: nowrap;" align="left">
        <?php echo $loc->getText("biblioCopyNewFormLabel"); ?>:
      </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary" valign="top"><sup>*</sup>
        <?php echo $loc->getText("biblioCopyNewBarcode"); ?>:
      </td>
			<td valign="top" class="primary">
        <?php printInputText("barcodeNmbr", 40, 40, $postVars, $pageErrors); ?>
        <input type="checkbox" name="autobarco" />
        <?php echo $loc->getText("biblioCopyNewAuto"); ?>
        <input type="checkbox" name="validBarco" value="CHECKED"
				checked="checked" />
        <?php echo $loc->getText("biblioCopyNewValidBarco"); ?>
      </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary" valign="top">
        <?php echo $loc->getText("biblioCopyNewDesc"); ?>:
      </td>
			<td valign="top" class="primary">
        <?php printInputText("copyDesc", 40, 40, $postVars, $pageErrors); ?>
      </td>
		</tr>
    <?php
    foreach ($customFields as $name => $title) {
        echo '<tr><td style="white-space:nowrap;" class="primary" valign="top">' . H($title) . ':</td>';
        echo '<td valign="top" class="primary">';
        printInputText('custom_' . $name, 40, 40, $postVars, $pageErrors);
        echo '</td></tr>';
    }
    ?>
    <tr>
			<td align="center" colspan="2" class="primary"><input type="submit"
				value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
				<input type="button"
				onClick="self.location='../shared/biblio_view.php?bibid=<?php echo HURL($bibid); ?>'"
				value="<?php echo $loc->getText("catalogCancel"); ?>" class="button">
			</td>
		</tr>

	</table>
	<input type="hidden" name="bibid" value="<?php echo H($bibid); ?>">
</form>


<?php include("../shared/footer.php"); ?>
