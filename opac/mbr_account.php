<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "opac";
$nav = "memberaccount";
$helpPage = "opac";
$focus_form_name = "phrasesearch";
$focus_form_field = "searchText";

require_once ("../functions/inputFuncs.php");
require_once ("../functions/formatFuncs.php");
require_once ("../opac/logincheck.php");
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
    header("Location: ../opac/index.php");
    exit();
}

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
$mbrid = $_SESSION["mbrid"];
$_POST["mbrid"] = $mbrid;
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

# **************************************************************************
# * Show member information
# **************************************************************************
require_once ("../shared/header_opac.php");
?>

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
                        <?php echo H($mbr->getLastName());?>, <?php echo H($mbr->getFirstName());?>
                    </td>
		</tr>
		<tr>
                    <td class="primary" valign="top">
                        <?php echo $loc->getText("mbrViewCardNmbr"); ?>
                    </td>
                    <td valign="top" class="primary">
                        <?php echo H($mbr->getBarcodeNmbr());?>
                    </td>
		</tr>
                <tr>  
                    <td class="primary" valign="top">
                        <?php echo $loc->getText("eMail"); ?>
                    </td>
                    <td valign="top" class="primary"> 
                        <?php echo H($mbr->getEmail());?>
                    </td>
                </tr>

            <?php
                // Types and names of member fields
                foreach ($memberFieldsDm as $name => $title) {
                    if (($mbr->getCustom($name) != NULL)) {
            ?>
                        <tr>
                            <td class="primary" valign="top">
                                <?php echo H($title); ?>
                            </td>
                        <td valign="top" class="primary">
                            <?php echo H($mbr->getCustom($name));?>
                        </td>
                        </tr>
            <?php
                    }
                }
            ?>
                <tr>
                    <td class="primary" valign="top">
                        <?php print $loc->getText("mbrViewMbrShipEnd"); ?>
                    </td>
                    <td valign="top" class="primary">
            <?php
                        if ($mbr->getMembershipEnd() == "0000-00-00")
                            print $loc->getText("mbrViewMbrShipNoEnd");
                        else {
                            echo $mbr->getMembershipEnd();
                        }
            ?>
                    </td>
                </tr>
                <tr>
                    <td class="primary" valign="top">
                        <?php echo $loc->getText("mbrViewPwd"); ?>
                    </td>
                    <td valign="top" class="primary">
                        <?php                            
                            if ($mbr->getPwd() != NULL) {
                                echo '********';
                            } else {
                                echo $loc->getText("mbrNoPassword");
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </td>
	<td class="noborder" valign="top"></td>
    </tr>
</table>

<br>

<?php if (!empty($pageErrors["barcodeNmbr"])) {echo "<font class=\"error\">".$loc->getText($pageErrors["barcodeNmbr"])."</font><br><br>";} ?>

<h1><?php echo $loc->getText("mbrViewHead4"); ?>
  <font class="primary"> 
    <a	href="javascript:popSecondary('../opac/mbr_print_checkouts.php?mbrid=<?php echo H(addslashes(U($mbrid)));?>')">[<?php echo $loc->getText("mbrPrintCheckouts"); ?>]</a>
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
    </tr>

<?php
# ****************************************************************************
# * Search database for BiblioStatus data
# ****************************************************************************
$biblioQ = new BiblioSearchQuery();
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
    $toolate = 0;
    while ($biblio = $biblioQ->fetchRow()) {
?>
  <tr>
    <td class="primary" valign="top" style="white-space: nowrap">
      <?php echo H($biblio->getStatusBeginDt());?>
    </td>
    <td class="primary" valign="top">
        <img
            src="../images/<?php echo HURL($materialImageFiles[$biblio->getMaterialCd()]);?>"
            width="20" height="20" border="0" align="middle"
            alt="<?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?>">
        <?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?>
    </td>
    <td class="primary" valign="top">
        <?php echo H($biblio->getBarcodeNmbr());?>
    </td>
    <td class="primary" valign="top">
        <a
            href="../shared/biblio_view.php?bibid=<?php echo HURL($biblio->getBibid());?>&tab=opac"><?php echo H($biblio->getTitle());?></a>
    </td>
    <td class="primary" valign="top">
        <?php echo H($biblio->getAuthor());?>
    </td>
    <td class="primary" valign="top" style="white-space: nowrap">
        <?php echo H($biblio->getDueBackDt());?>
    </td>
    <td class="primary" valign="top">
        <?php
        if ($biblio->getDaysLate() > 7) {
            echo $loc->getText("Cannot renew item *");
            $toolate = 1;
        } else {
        ?>
        <a href="../opac/renew.php?barcodeNmbr=<?php echo HURL($biblio->getBarcodeNmbr());?>&amp;mbrid=<?php echo HURL($mbrid);?>&amp;renewal"><?php echo $loc->getText("Renew item"); ?></A>
            <?php
            if ($biblio->getRenewalCount() > 0) {
            ?>
                <br>
                (<?php echo H($biblio->getRenewalCount());?> <?php echo $loc->getText("mbrViewOutHdr9"); ?>)
            <?php
            }
            ?>
	<?php
        }
        ?>
    </td>
    <td class="primary" valign="top">
        <?php echo H($biblio->getDaysLate());?>
    </td>
  </tr>
<?php
    }
}
$biblioQ->close();
?>

</table>

<?php
if (isset($toolate) == 1) {
    echo $loc->getText("* You cannot renew, if you are more then 7 days too late");
}
?>

<br>
<br>

<!--****************************************************************************
    *  Hold form
    **************************************************************************** -->
<form name="holdForm" method="POST" action="../opac/place_hold.php">
    <table class="primary">
	<tr>
            <th valign="top" style="white-space: nowrap" align="left">
                <?php echo $loc->getText("mbrViewHead5"); ?>
            </th>
        </tr>
	<tr>
            <td style="white-space: nowrap" class="primary">
                <?php echo $loc->getText("mbrViewBarcode"); ?>
                <?php printInputText("holdBarcodeNmbr",18,18,$postVars,$pageErrors); ?>
                <a
                    href="javascript:popSecondaryLarge('../opac/index.php?lookup=Y')"><?php echo $loc->getText("indexSearch"); ?></a>
                    <input type="hidden" name="mbrid" value="<?php echo H($mbrid);?>"> <input
                    type="hidden" name="classification"
                    value="<?php echo H($mbr->getClassification());?>"> <input
                    type="submit"
                    value="<?php echo $loc->getText("mbrViewPlaceHold"); ?>"
                    class="button">
            </td>
	</tr>
    </table>
</form>

<h1><?php echo $loc->getText("mbrViewHead6"); ?></h1>
<table class="primary">
    <tr>
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
	<td class="primary" valign="top" style="white-space: nowrap">
            <?php echo H($hold->getHoldBeginDt());?>
        </td>
	<td class="primary" valign="top">
            <img
                src="../images/<?php echo HURL($materialImageFiles[$hold->getMaterialCd()]);?>"
                width="20" height="20" border="0" align="middle"
                alt="<?php echo H($materialTypeDm[$hold->getMaterialCd()]);?>">
            <?php echo H($materialTypeDm[$hold->getMaterialCd()]);?>
        </td>
	<td class="primary" valign="top">
            <?php echo H($hold->getBarcodeNmbr());?>
        </td>
	<td class="primary" valign="top">
            <a href="../shared/biblio_view.php?bibid=<?php echo HURL($hold->getBibid());?>&tab=opac"><?php echo H($hold->getTitle());?></a>
	</td>
	<td class="primary" valign="top">
            <?php echo H($hold->getAuthor());?>
        </td>
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

<?php
if ($holdQ->getRowCount() > 0)
    echo $loc->getText("Please send a mail to delete holds");
?>
<?php require_once("../shared/footer.php"); ?>
