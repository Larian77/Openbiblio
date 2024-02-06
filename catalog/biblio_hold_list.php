<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "cataloging";
$nav = "holds";
require_once ("../shared/logincheck.php");

require_once ("../classes/BiblioHold.php");
require_once ("../classes/BiblioHoldQuery.php");
require_once ("../classes/DmQuery.php");
require_once ("../functions/errorFuncs.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

# ****************************************************************************
# * Get Status Message
# ****************************************************************************
if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">" . H($_GET["msg"]) . "</font><br><br>";
} else {
    $msg = "";
}

# ****************************************************************************
# * Loading a few domain tables into associative arrays
# ****************************************************************************
$dmQ = new DmQuery();
$dmQ->connect_e();
$biblioStatusDm = $dmQ->getAssoc("biblio_status_dm");
$dmQ->close();

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
$bibid = $_GET["bibid"];

# ****************************************************************************
# * Show page
# ****************************************************************************
require_once ("../shared/header.php");
?>
<h1><?php echo $loc->getText("biblioHoldListHead"); ?></h1>
<?php echo $msg ?>
<table class="primary">
	<tr>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("biblioHoldListHdr1"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("biblioHoldListHdr2"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("biblioHoldListHdr3"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("biblioHoldListHdr4"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("biblioHoldListHdr5"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("biblioHoldListHdr6"); ?>
    </th>
	</tr>
<?php

# ****************************************************************************
# * Search database for BiblioHold data
# ****************************************************************************
$holdQ = new BiblioHoldQuery();
$holdQ->connect_e();
if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
}
if (! $holdQ->queryByBibid($bibid)) {
    $holdQ->close();
    displayErrorPage($holdQ);
}
if ($holdQ->getRowCount() == 0) {

    ?>
    <tr>
		<td class="primary" align="center" colspan="6">
      <?php echo $loc->getText("biblioHoldListNoHolds"); ?>
    </td>
	</tr>
<?php
} else {
    while ($hold = $holdQ->fetchRow()) {
        ?>
  <tr>
		<td class="primary" valign="top" style="white-space: nowrap;"><a
			href="../shared/hold_del_confirm.php?bibid=<?php echo HURL($hold->getBibid());?>&amp;copyid=<?php echo HURL($hold->getCopyid());?>&amp;holdid=<?php echo HURL($hold->getHoldid());?>"><?php echo $loc->getText("biblioHoldListdel"); ?></a>
		</td>
		<td class="primary" valign="top">
      <?php echo H($hold->getBarcodeNmbr());?>
    </td>
		<td class="primary" valign="top" style="white-space: nowrap;">
      <?php echo H($hold->getHoldBeginDt());?>
    </td>
		<td class="primary" valign="top"><a
			href="../circ/mbr_view.php?mbrid=<?php echo HURL($hold->getMbrid());?>&amp;reset=Y"><?php echo H($hold->getFirstName());?>
      <?php echo H($hold->getLastName());?></a></td>
		<td class="primary" valign="top">
      <?php echo H($biblioStatusDm[$hold->getStatusCd()]);?>
    </td>
		<td class="primary" valign="top">
      <?php echo H($hold->getDueBackDt());?>
    </td>
	</tr>
<?php
    }
}
$holdQ->close();
?>

</table>
<?php include("../shared/footer.php"); ?>
