<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "cataloging";
$nav = "history";

require_once ("../functions/inputFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../classes/BiblioStatusHist.php");
require_once ("../classes/BiblioStatusHistQuery.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

# ****************************************************************************
# * Checking for get vars. Go back to form if none found.
# ****************************************************************************
if (count($_GET) == 0) {
    header("Location: ../circ/index.php");
    exit();
}

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
$bibid = $_GET["bibid"];

# ****************************************************************************
# * Loading a few domain tables into associative arrays
# ****************************************************************************
$dmQ = new DmQuery();
$dmQ->connect_e();
$biblioStatusDm = $dmQ->getAssoc("biblio_status_dm");
$dmQ->close();

# ****************************************************************************
# * Search database for member history
# ****************************************************************************
$histQ = new BiblioStatusHistQuery();
$histQ->connect_e();
if ($histQ->errorOccurred()) {
    $histQ->close();
    displayErrorPage($histQ);
}
if (! $histQ->queryByBibid($bibid)) {
    $histQ->close();
    displayErrorPage($histQ);
}

# **************************************************************************
# * Show biblio checkout history
# **************************************************************************
require_once ("../shared/header.php");
?>

<h1><?php echo $loc->getText("Bibliography Checkout History:"); ?></h1>
<table class="primary">
	<tr>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("Date"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("Barcode"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("New Status"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("Member"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("Due Date"); ?>
    </th>
	</tr>

<?php
if ($histQ->getRowCount() == 0) {
    ?>
  <tr>
		<td class="primary" align="center" colspan="6">
      <?php echo $loc->getText("No history was found."); ?>
    </td>
	</tr>
<?php
} else {
    while ($hist = $histQ->fetchRow()) {
        ?>
  <tr>
		<td class="primary" valign="top">
      <?php echo H($hist->getStatusBeginDt());?>
    </td>
		<td class="primary" valign="top">
      <?php echo H($hist->getBiblioBarcodeNmbr());?>
    </td>
		<td class="primary" valign="top">
      <?php echo H($biblioStatusDm[$hist->getStatusCd()]);?>
    </td>
		<td class="primary" valign="top">
      <?php if($hist->getMbrid()) { ?>
        <a
			href="../circ/mbr_view.php?mbrid=<?php echo HURL($hist->getMbrid());?>"><?php echo H($hist->getLastName().", ".$hist->getFirstName());?></a>
      <?php } ?>
    </td>
		<td class="primary" valign="top">
      <?php echo H($hist->getDueBackDt());?>
    </td>
	</tr>
<?php
    }
}
$histQ->close();

?>
</table>

<?php require_once("../shared/footer.php"); ?>
