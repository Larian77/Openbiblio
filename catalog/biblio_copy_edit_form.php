<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "cataloging";
$nav = "editcopy";
$helpPage = "biblioCopyEdit";
$focus_form_name = "editCopyForm";
$focus_form_field = "barcodeNmbr";
require_once ("../functions/inputFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../classes/BiblioCopy.php");
require_once ("../classes/BiblioCopyQuery.php");
require_once ('../classes/DmQuery.php');
require_once ("../functions/errorFuncs.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

$dmQ = new DmQuery();
$dmQ->connect_e();
$customFields = $dmQ->getAssoc('biblio_copy_fields_dm');
$dmQ->close();

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
if (isset($_GET["bibid"])) {
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);
    # ****************************************************************************
    # * Retrieving get var
    # ****************************************************************************
    $bibid = $_GET["bibid"];
    $copyid = $_GET["copyid"];

    # ****************************************************************************
    # * Read copy information
    # ****************************************************************************
    $copyQ = new BiblioCopyQuery();
    // Changes PVD(8.0.x)
    $copyQ->connect_e();
    if ($copyQ->errorOccurred()) {
        $copyQ->close();
        displayErrorPage($copyQ);
    }
    if (! $copy = $copyQ->doQuery($bibid, $copyid)) {
        $copyQ->close();
        displayErrorPage($copyQ);
    }
    $postVars["bibid"] = $bibid;
    $postVars["copyid"] = $copyid;
    $postVars["barcodeNmbr"] = $copy->getBarcodeNmbr();
    $postVars["copyDesc"] = $copy->getCopyDesc();
    $postVars["statusCd"] = $copy->getStatusCd();
    foreach ($customFields as $name => $title) {
        $postVars["custom_" . $name] = $copy->getCustom($name);
    }
} else {
    # **************************************************************************
    # * load up post vars
    # **************************************************************************
    require ("../shared/get_form_vars.php");
    $bibid = $postVars["bibid"];
    $copyid = $postVars["copyid"];
}

# Transitions to and from these status codes aren't allowed on this form.
$disallowed = array(
    OBIB_STATUS_SHELVING_CART,
    OBIB_STATUS_OUT,
    OBIB_STATUS_ON_HOLD
);

require_once ("../shared/header.php");
?>

<font class="small">
<?php echo $loc->getText("catalogFootnote",array("symbol"=>"*")); ?>
</font>

<form name="editCopyForm" method="POST"
	action="../catalog/biblio_copy_edit.php">
	<table class="primary">
		<tr>
			<th colspan="2" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("biblioCopyEditFormLabel"); ?>:
    </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary" valign="top"><sup>*</sup> <?php echo $loc->getText("biblioCopyNewBarcode"); ?>:
    </td>
			<td valign="top" class="primary">
      <?php printInputText("barcodeNmbr",40,40,$postVars,$pageErrors); ?>
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
      <?php printInputText("copyDesc",40,40,$postVars,$pageErrors); ?>
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
			<td style="white-space: nowrap;" class="primary" valign="top">
      <?php echo $loc->getText("biblioCopyEditFormStatus"); ?>:
    </td>
			<td valign="top" class="primary">

<?php
# **************************************************************************
# * only show status codes for valid transitions
# **************************************************************************
$dmQ = new DmQuery();
$dmQ->connect_e();
$dms = $dmQ->get("biblio_status_dm");
$dmQ->close();
echo "<select name=\"statusCd\"";
if (in_array($postVars["statusCd"], $disallowed)) {
    echo " disabled";
}
echo ">\n";
foreach ($dms as $dm) {
    $cd = $dm->getCode();
    # We don't normally show transitions to disallowed states, but
    # we do want to show the correct status, if it's one of those.
    if (in_array($cd, $disallowed) && $cd != $postVars["statusCd"]) {
        continue;
    }
    echo "<option value=\"" . H($dm->getCode()) . "\"";
    if (($postVars["statusCd"] == "") && ($dm->getDefaultFlg() == 'Y')) {
        echo " selected";
    } elseif ($postVars["statusCd"] == $dm->getCode()) {
        echo " selected";
    }
    echo ">" . H($dm->getDescription()) . "</option>\n";
}
echo "</select>\n";
?>


    </td>
		</tr>
		<tr>
			<td align="center" colspan="2" class="primary"><input type="submit"
				value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
				<input type="button"
				onClick="self.location='../shared/biblio_view.php?bibid=<?php echo HURL($bibid); ?>'"
				value="<?php echo $loc->getText("catalogCancel"); ?>" class="button">
			</td>
		</tr>

	</table>
	<input type="hidden" name="bibid" value="<?php echo H($bibid);?>"> <input
		type="hidden" name="copyid" value="<?php echo H($copyid);?>">
</form>


<?php include("../shared/footer.php"); ?>
