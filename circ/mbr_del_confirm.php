<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "circulation";
$restrictToMbrAuth = TRUE;
$nav = "delete";
require_once ("../shared/logincheck.php");
require_once ("../classes/Member.php");
require_once ("../classes/MemberQuery.php");
require_once ("../classes/BiblioSearchQuery.php");
require_once ("../classes/BiblioHoldQuery.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

$mbrid = $_GET["mbrid"];

# ****************************************************************************
# * Getting member name
# ****************************************************************************
$mbrQ = new MemberQuery();
// Changes PVD(8.0.x)
$mbrQ->connect_e();
$mbr = $mbrQ->get($mbrid);
$mbrQ->close();
$mbrName = $mbr->getFirstName() . " " . $mbr->getLastName();

# ****************************************************************************
# * Getting checkout count
# ****************************************************************************
$biblioQ = new BiblioSearchQuery();
// Changes PVD(8.0.x)
$biblioQ->connect_e();
if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
}
if (! $biblioQ->doQuery(OBIB_STATUS_OUT, $mbrid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
}
$checkoutCount = $biblioQ->getRowCount();
$biblioQ->close();

# ****************************************************************************
# * Getting hold request count
# ****************************************************************************
$holdQ = new BiblioHoldQuery();
// Changes PVD(8.0.x)
$holdQ->connect_e();
if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
}
$holdQ->queryByMbrid($mbrid);
if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
}
$holdCount = $holdQ->getRowCount();
$holdQ->close();

# **************************************************************************
# * Show confirm page
# **************************************************************************
require_once ("../shared/header.php");

if (($checkoutCount > 0) or ($holdCount > 0)) {
    ?>
<span style="text-align: center;">
        <?php echo $loc->getText("mbrDelConfirmWarn", array("name" => $mbrName, "checkoutCount" => $checkoutCount, "holdCount" => $holdCount)); ?>
        <br>
<br> <a
	href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid); ?>&amp;reset=Y">
            <?php echo $loc->getText("mbrDelConfirmReturn"); ?>
        </a>
</span>

<?php
} else {
    ?>
<span style="text-align: center;">
	<form name="delbiblioform" method="POST"
		action="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid); ?>&amp;reset=Y">
            <?php echo $loc->getText("mbrDelConfirmMsg", array("name" => $mbrName)); ?>
            <br>
		<br> <input type="button"
			onClick="self.location='../circ/mbr_del.php?mbrid=<?php echo H(addslashes(U($mbrid))); ?>&amp;name=<?php echo H(addslashes(U($mbrName))); ?>'"
			value="<?php echo $loc->getText("circDelete"); ?>" class="button"> <input
			type="submit" value="<?php echo $loc->getText("circCancel"); ?>"
			class="button">
	</form>
</span>
<?php
}
include ("../shared/footer.php");
?>
