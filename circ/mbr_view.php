<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "circulation";
$nav = "view";
$helpPage = "memberView";
$focus_form_name = "barcodesearch";
$focus_form_field = "barcodeNmbr";

require_once ("../functions/inputFuncs.php");
require_once ("../functions/formatFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../classes/Member.php");
require_once ("../classes/MemberQuery.php");
require_once ("../classes/BiblioSearch.php");
require_once ("../classes/BiblioSearchQuery.php");
require_once ("../classes/BiblioHold.php");
require_once ("../classes/BiblioHoldQuery.php");
require_once ("../classes/MemberAccountQuery.php");
require_once ("../classes/DmQuery.php");
require_once ("../shared/get_form_vars.php");
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
$mbrid = $_GET["mbrid"];
if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">" . H($_GET["msg"]) . "</font><br><br>";
} else {
    $msg = "";
}

# ****************************************************************************
# * Loading a few domain tables into associative arrays
# ****************************************************************************
$dmQ = new DmQuery();
// Changes PVD(8.0.x)
$dmQ->connect_e();
$mbrClassifyDm = $dmQ->getAssoc("mbr_classify_dm");
$mbrMaxFines = $dmQ->getAssoc("mbr_classify_dm", "max_fines");
$biblioStatusDm = $dmQ->getAssoc("biblio_status_dm");
$materialTypeDm = $dmQ->getAssoc("material_type_dm");
$materialImageFiles = $dmQ->getAssoc("material_type_dm", "image_file");
$memberFieldsDm = $dmQ->getAssoc("member_fields_dm");
$dmQ->close();

# ****************************************************************************
# * Search database for member
# ****************************************************************************
$mbrQ = new MemberQuery();
// Changes PVD(8.0.x)
$mbrQ->connect_e();
$mbr = $mbrQ->get($mbrid);
$mbrQ->close();

# ****************************************************************************
# * Check for outstanding balance due
# ****************************************************************************
$acctQ = new MemberAccountQuery();
$balance = $acctQ->getBalance($mbrid);
$balMsg = "";
if ($balance > 0 && $balance >= $mbrMaxFines[$mbr->getClassification()]) {
    $balText = moneyFormat($balance, 2);
    $balMsg = "<font class=\"error\">" . $loc->getText("mbrViewBalMsg", array(
        "bal" => $balText
    )) . "</font><br><br>";
}

# ****************************************************************************
# * Prüfung auf Hinweis wegen Ablauf der Mitgliedschaft vor Rückgabedatum
# * Derzeit abgedeckt durch Missbrauch des Fehlercodes und Markierung mit !!! davor
# ****************************************************************************
$dueMsg = "";
// Changes PVD(8.0.x)
// * If Case Added If Their Are No Errors
if (isset($_SESSION['pageErrors'])) {
    $pgErrors = $_SESSION['pageErrors'];
} else {
    $pageErrors;
}
// Changes PVD(8.0.x)
if (@substr($pgErrors['barcodeNmbr'], 0, 3) === '!!!') {
    // Changes PVD(8.0.x)
    $dueMsg = "<font class=\"error\">" . substr($pgErrors['barcodeNmbr'], 3) . "</font><br><br>";
    unset($postVars);
    unset($pageErrors);
}

# ****************************************************************************
# * Make sure member does not have expired membership
# ****************************************************************************
$overMsg = "";
if ($mbr->getMembershipEnd() != "0000-00-00") {
    if (strtotime($mbr->getMembershipEnd()) <= strtotime("now")) {
        $overMsg = "<font class=\"error\">" . $loc->getText("checkoutEndErr") . "</font><br><br>";
    }
}
# **************************************************************************
# * Show member information
# **************************************************************************
require_once ("../shared/header.php");
?>

<?php echo $balMsg ?>
<?php echo $dueMsg ?>
<?php echo $overMsg ?>
<?php echo $msg ?>

<table class="primary">
	<tr>
		<td class="noborder" valign="top"><br>
                    <table class="primary">
                    <tr>
			<th align="left" colspan="2" style="white-space: nowrap">
                            <?php echo $loc->getText("mbrViewHead1"); ?>
                        </th>
                    </tr>
                    <tr>
                    	<td style="white-space: nowrap" class="primary" valign="top">
                            <?php echo $loc->getText("mbrViewName"); ?>
                        </td>
			<td valign="top" class="primary">
                            <?php echo H($mbr->getLastName()); ?>,
                            <?php echo H($mbr->getFirstName()); ?>
                        </td>
                    </tr>
                    <tr>
			<td class="primary" valign="top">
                            <?php echo $loc->getText("mbrViewAddr"); ?>
                        </td>
			<td valign="top" class="primary">
                            <?php
                            echo str_replace("\n", "<br />", H($mbr->getAddress()));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="primary" valign="top">
                            <?php echo $loc->getText("mbrViewCardNmbr"); ?>
                        </td>
                        <td valign="top" class="primary">
                            <?php echo H($mbr->getBarcodeNmbr()); ?>
                        </td>
                    </tr>
                    <tr>
			<td class="primary" valign="top">
                            <?php echo $loc->getText("mbrViewClassify"); ?>
                        </td>
			<td valign="top" class="primary">
                            <?php echo H($mbrClassifyDm[$mbr->getClassification()]); ?>
                        </td>
                    </tr>
                    <tr>
			<td class="primary" valign="top">
                            <?php echo $loc->getText("mbrViewPhone"); ?>
                        </td>
			<td valign="top" class="primary">
                            <?php
                            if ($mbr->getHomePhone() != "") {
                                echo $loc->getText("mbrViewPhoneHome") . $mbr->getHomePhone() . " ";
                            }
                            if ($mbr->getWorkPhone() != "") {
                                echo "<br />" . $loc->getText("mbrViewPhoneWork") . $mbr->getWorkPhone();
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
			<td class="primary" valign="top">
                            <?php echo $loc->getText("mbrViewEmail"); ?>
                        </td>
			<td valign="top" class="primary">
                            <a href=mailto:<?php echo H($mbr->getEmail()); ?>><?php echo H($mbr->getEmail()); ?></a>
			</td>
                    </tr>
                    <tr>
			<td class="primary" valign="top">
                            <?php print $loc->getText("mbrViewMbrShipEnd"); ?>
                        </td>
			<td valign="top" class="primary">
                            <?php
                            if ($mbr->getMembershipEnd() == "0000-00-00") {
                                print $loc->getText("mbrViewMbrShipNoEnd");
                            } else {
                                echo $mbr->getMembershipEnd();
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    foreach ($memberFieldsDm as $name => $title) {
                        if (($value = $mbr->getCustom($name))) {        
                    ?>
                            <tr>
				<td class="primary" valign="top">
                                    <?php echo H($title); ?>
                                </td>
				<td valign="top" class="primary">
                                    <?php echo H($value); ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    if (OBIB_MBR_ACCOUNT_ONLINE == TRUE) {
                    ?>
                    <tr>
			<td class="primary" valign="top">
                            <?php echo $loc->getText("mbr_new_form_Password"); ?>
                        </td>
			<td valign="top" class="primary">
                            <?php                            
                                if ($mbr->getPwd() != NULL) {
                                    echo '********';
                                } else {
                                    echo $loc->getText("mbrNoPassword");
                                }
                    }
                            ?>
			</td>
                    </tr>
			</td>
                    </tr>
                    </table>
                </td>
		<td class="noborder" valign="top">

            <?php
            # ****************************************************************************
            # * Show checkout stats
            # ****************************************************************************
            $dmQ = new DmQuery();
            $dmQ->connect_e();
            $dms = $dmQ->getCheckoutStats($mbr->getMbrid());
            $dmQ->close();
            ?>
            <table id="LendingStatus" class="primary">
                <tr>
                    <th colspan="4">
                       <?php echo $loc->getText("mbrViewHead2"); ?>
                    </th>                  
                </tr>
		<tr>
                    <th class="LendingHeads" align="left" rowspan="2">
                        <?php echo $loc->getText("mbrViewStatColHdr1"); ?>
                    </th>
                    <th class="LendingHeads" align="left" rowspan="2">
                        <?php echo $loc->getText("mbrViewStatColHdr2"); ?>
                    </th>
                    <th class="LendingHeads" align="center" colspan="2" style="white-space: nowrap">
                        <?php echo $loc->getText("mbrViewStatColHdr3"); ?>
                    </th>
		</tr>
		<tr>
                    <th class="LendingHeads" align="left">
                        <?php echo $loc->getText("mbrViewStatColHdr4"); ?>
                    </th>
                    <th class="LendingHeads" align="left">
                        <?php echo $loc->getText("mbrViewStatColHdr5"); ?>
                    </th>
		</tr>
                <?php
                foreach ($dms as $dm) {
                ?>
                    <tr>
			<td style="white-space: nowrap" class="primary" valign="top">
                            <?php echo H($dm->getDescription()); ?>
                        </td>
                        <td valign="top" class="primary">
                            <?php echo H($dm->getCount()); ?>
                        </td>
			<td valign="top" class="primary">
                            <?php echo H($dm->getCheckoutLimit()); ?>
                        </td>
			<td valign="top" class="primary">
                            <?php echo H($dm->getRenewalLimit()); ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
		</td>
	</tr>
</table>

<br />

<?php
# ****************************************************************************
# * Renew MemberShip
# ****************************************************************************

echo $loc->getText("mbrViewRenew1") . "&nbsp;&nbsp;&nbsp;<a href=\"../circ/mbr_renew_mbrship.php?mbrid=$mbrid&length=1\">1</a>&nbsp;&nbsp;&nbsp;<a href=\"../circ/mbr_renew_mbrship.php?mbrid=$mbrid&length=6\">6</a>&nbsp;&nbsp;&nbsp;<a href=\"../circ/mbr_renew_mbrship.php?mbrid=$mbrid&length=12\">12</a>&nbsp;&nbsp;&nbsp;" . $loc->getText("mbrViewRenew2");

?>
<br>
<br>

<!--****************************************************************************
    *  Checkout form
    **************************************************************************** -->
<form name="barcodesearch" method="POST" action="../circ/checkout.php">
	<input type="hidden" name="mbrid" value="<?php echo H($mbrid); ?>"> <input
		type="hidden" name="date_from" id="date_from" value="default" />
	<script type="text/javascript">
        function showDueDate() {
            el = document.getElementById('date_from');
            el.value = "override";
            el = document.getElementById('duedateoverride');
            el.style.display = "none";
            el = document.getElementById('duedate1');
            el.style.display = "inline";
            el = document.getElementById('duedate2');
            el.style.display = "inline";
            el = document.getElementById('duedate3');
            el.style.display = "inline";
        }
        function hideDueDate() {
            el = document.getElementById('date_from');
            el.value = "default";
            el = document.getElementById('duedateoverride');
            el.style.display = "inline";
            el = document.getElementById('duedate1');
            el.style.display = "none";
            el = document.getElementById('duedate2');
            el.style.display = "none";
            el = document.getElementById('duedate3');
            el.style.display = "none";
        }
    </script>
	<table class="primary">
		<tr>
			<th valign="top" style="white-space: nowrap" align="left">
                <?php echo $loc->getText("mbrViewHead3"); ?>
            </th>
		</tr>
		<tr>
			<td style="white-space: nowrap" class="primary">
				<table class="primary">
					<tr>
						<td class="borderless">
                            <?php echo $loc->getText("mbrViewBarcode"); ?>
                        </td>
						<td class="borderless">
                            <?php printInputText("barcodeNmbr", 40, 40, $postVars, $pageErrors,"visible",1); ?>
                            <a
							href="javascript:popSecondaryLarge('../opac/index.php?lookup=Y')">
                                <?php echo $loc->getText("indexSearch"); ?>
                            </a>
						</td>
						<td class="borderless"><input type="submit"
							value="<?php echo $loc->getText("mbrViewCheckOut"); ?>"
							class="button"></td>
					</tr>
					<tr>
						<td class="borderless"><span id="duedate1" style="display: none">
                                <?php echo $loc->getText("Due Date:"); ?>
                        </span></td>
						<td class="borderless"><small id="duedateoverride"><a
								href="javascript:showDueDate()">
                                    <?php echo $loc->getText("Override Due Date"); ?>
                                </a></small> <span id="duedate2"
							style="display: none">
                                <?php
                                if (isset($_SESSION['due_date_override']) && ! isset($postVars['dueDate'])) {
                                    $postVars['dueDate'] = $_SESSION['due_date_override'];
                                }
                                printInputText("dueDate", 18, 18, $postVars, $pageErrors);
                                ?>
                            </span></td>
						<td><span id="duedate3" style="display: none"><input type="button"
								value="<?php echo $loc->getText("Cancel"); ?>" class="button"
								onclick="hideDueDate()" /></span></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
    <?php if (isset($_SESSION['postVars']['date_from']) && $_SESSION['postVars']['date_from'] == 'override') { ?>
        <script type="text/javascript">showDueDate()</script>
    <?php } ?>
</form>

<h1>
    <?php echo $loc->getText("mbrViewHead4"); ?>
    <font class="primary"> <a
		href="javascript:popSecondary('../circ/mbr_print_checkouts.php?mbrid=<?php echo H(addslashes(U($mbrid))); ?>')">[
            <?php echo $loc->getText("mbrPrintCheckouts"); ?>]
        </a> <a
		href="../circ/mbr_renew_all.php?mbrid=<?php echo HURL($mbrid); ?>">[
            <?php echo $loc->getText("Renew All"); ?>]
        </a>
	</font>
</h1>
<table class="primary">
	<tr>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewOutHdr1"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewOutHdr2"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewOutHdr3"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewOutHdr4"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewOutHdr5"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewOutHdr6"); ?>
        </th>
		<th valign="top" align="left">
            <?php echo $loc->getText("mbrViewOutHdr8"); ?>
        </th>
		<th valign="top" align="left">
            <?php echo $loc->getText("mbrViewOutHdr7"); ?>
        </th>
		<th valign="top" align="left">
            <?php echo $loc->getText("mbrViewOutHdr10"); ?>
        </th>
	</tr>

    <?php
    # ****************************************************************************
    # * Search database for BiblioStatus data
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
    if ($biblioQ->getRowCount() == 0) {
        ?>
        <tr>
		<td class="primary" align="center" colspan="9">
                <?php echo $loc->getText("mbrViewNoCheckouts"); ?>
            </td>
	</tr>
        <?php
    } else {
        while ($biblio = $biblioQ->fetchRow()) {
            ?>
            <tr>
		<td class="primary" valign="top" style="white-space: nowrap">
                    <?php echo H($biblio->getStatusBeginDt()); ?>
                </td>
		<td class="primary" valign="top"><img
			src="../images/<?php echo HURL($materialImageFiles[$biblio->getMaterialCd()]); ?>"
			width="20" height="20" border="0" align="middle"
			alt="<?php echo H($materialTypeDm[$biblio->getMaterialCd()]); ?>">
                    <?php echo H($materialTypeDm[$biblio->getMaterialCd()]); ?>
                </td>
		<td class="primary" valign="top">
                    <?php echo H($biblio->getBarcodeNmbr()); ?>
                </td>
		<td class="primary" valign="top"><a
			href="../shared/biblio_view.php?bibid=<?php echo HURL($biblio->getBibid()); ?>">
                        <?php echo H($biblio->getTitle()); ?>
                    </a></td>
		<td class="primary" valign="top">
                    <?php echo H($biblio->getAuthor()); ?>
                </td>
		<td class="primary" valign="top" style="white-space: nowrap">
                    <?php echo H($biblio->getDueBackDt()); ?>
                </td>
		<td class="primary" valign="top"><a
			href="../circ/checkout.php?barcodeNmbr=<?php echo HURL($biblio->getBarcodeNmbr()); ?>&amp;mbrid=<?php echo HURL($mbrid); ?>&amp;renewal">
                        <?php echo $loc->getText("Renew item"); ?>
                    </a>
                    <?php
            if ($biblio->getRenewalCount() > 0) {
                ?>
                        <br>
                        (
                        <?php echo H($biblio->getRenewalCount()); ?>
                        <?php echo $loc->getText("mbrViewOutHdr9"); ?>)
                        <?php
            }
            ?>
                </td>
		<td class="primary" valign="top">
                    <?php echo H($biblio->getDaysLate()); ?>
                </td>
		<td class="primary" valign="top"><a
			href="../circ/shelving_cart.php?barcodeNmbr=<?php echo HURL($biblio->getBarcodeNmbr()); ?>">
                        <?php echo $loc->getText("To Shelving Cart"); ?>
                    </a></td>
	</tr>
            <?php
        }
    }
    $biblioQ->close();
    ?>

</table>

<br>
<!--****************************************************************************
    *  Hold form
    **************************************************************************** -->
<form name="holdForm" method="POST" action="../circ/place_hold.php">
	<table class="primary">
		<tr>
			<th valign="top" style="white-space: nowrap" align="left">
                <?php echo $loc->getText("mbrViewHead5"); ?>
            </th>
		</tr>
		<tr>
			<td style="white-space: nowrap" class="primary">
                <?php echo $loc->getText("mbrViewBarcode"); ?>
                <?php printInputText("holdBarcodeNmbr", 40, 40, $postVars, $pageErrors); ?>
                <a
				href="javascript:popSecondaryLarge('../opac/index.php?lookup=Y')">
                    <?php echo $loc->getText("indexSearch"); ?>
                </a> <input type="hidden" name="mbrid"
				value="<?php echo H($mbrid); ?>"> <input type="hidden"
				name="classification"
				value="<?php echo H($mbr->getClassification()); ?>"> <input
				type="submit"
				value="<?php echo $loc->getText("mbrViewPlaceHold"); ?>"
				class="button">
			</td>
		</tr>
	</table>
</form>

<h1>
    <?php echo $loc->getText("mbrViewHead6"); ?>
</h1>
<table class="primary">
	<tr>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewHoldHdr1"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewHoldHdr2"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewHoldHdr3"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewHoldHdr4"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewHoldHdr5"); ?>
        </th>
		<th valign="top" style="white-space: nowrap" align="left">
            <?php echo $loc->getText("mbrViewHoldHdr6"); ?>
        </th>
		<th valign="top" align="left">
            <?php echo $loc->getText("mbrViewHoldHdr7"); ?>
        </th>
		<th valign="top" align="left">
            <?php echo $loc->getText("mbrViewHoldHdr8"); ?>
        </th>
	</tr>
    <?php
    # ****************************************************************************
    # * Search database for BiblioHold data
    # ****************************************************************************
    $holdQ = new BiblioHoldQuery();
    // Changes PVD(8.0.x)
    $holdQ->connect_e();
    if ($holdQ->errorOccurred()) {
        $holdQ->close();
        displayErrorPage($holdQ);
    }
    if (! $holdQ->queryByMbrid($mbrid)) {
        $holdQ->close();
        displayErrorPage($holdQ);
    }
    if ($holdQ->getRowCount() == 0) {
        ?>
        <tr>
		<td class="primary" align="center" colspan="8">
                <?php echo $loc->getText("mbrViewNoHolds"); ?>
            </td>
	</tr>
        <?php
    } else {
        while ($hold = $holdQ->fetchRow()) {
            ?>
            <tr>
		<td class="primary" valign="top" style="white-space: nowrap"><a
			href="../shared/hold_del_confirm.php?bibid=<?php echo HURL($hold->getBibid()); ?>&amp;copyid=<?php echo HURL($hold->getCopyid()); ?>&amp;holdid=<?php echo HURL($hold->getHoldid()); ?>&amp;mbrid=<?php echo HURL($mbrid); ?>">
                        <?php echo $loc->getText("mbrViewDel"); ?>
                    </a></td>
		<td class="primary" valign="top" style="white-space: nowrap">
                    <?php echo H($hold->getHoldBeginDt()); ?>
                </td>
		<td class="primary" valign="top"><img
			src="../images/<?php echo HURL($materialImageFiles[$hold->getMaterialCd()]); ?>"
			width="20" height="20" border="0" align="middle"
			alt="<?php echo H($materialTypeDm[$hold->getMaterialCd()]); ?>">
                    <?php echo H($materialTypeDm[$hold->getMaterialCd()]); ?>
                </td>
		<td class="primary" valign="top">
                    <?php echo H($hold->getBarcodeNmbr()); ?>
                </td>
		<td class="primary" valign="top"><a
			href="../shared/biblio_view.php?bibid=<?php echo HURL($hold->getBibid()); ?>">
                        <?php echo H($hold->getTitle()); ?>
                    </a></td>
		<td class="primary" valign="top">
                    <?php echo H($hold->getAuthor()); ?>
                </td>
		<td class="primary" valign="top">
                    <?php echo H($biblioStatusDm[$hold->getStatusCd()]); ?>
                </td>
		<td class="primary" valign="top">
                    <?php echo H($hold->getDueBackDt()); ?>
                </td>
	</tr>
            <?php
        }
    }
    $holdQ->close();
    ?>


</table>


<?php require_once("../shared/footer.php"); ?>
