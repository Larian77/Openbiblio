<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "circulation";
$nav = "account";
$focus_form_name = "accttransform";
$focus_form_field = "transactionTypeCd";

require_once ("../functions/inputFuncs.php");
require_once ("../functions/formatFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../shared/get_form_vars.php");
require_once ("../classes/MemberAccountTransaction.php");
require_once ("../classes/MemberAccountQuery.php");
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
$dmQ->connect_e();
$mbrClassifyDm = $dmQ->getAssoc("transaction_type_dm");
$dmQ->close();

# ****************************************************************************
# * Show transaction input form
# ****************************************************************************
require_once ("../shared/header.php");
?>

<?php echo $msg ?>

<form name="accttransform" method="POST"
	action="../circ/mbr_transaction.php">
	<table class="primary">
		<tr>
			<th colspan="2" valign="top" style="white-space: nowrap;"
				align="left">
      <?php echo $loc->getText("mbrAccountLabel"); ?>
    </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
      <?php echo $loc->getText("mbrAccountTransTyp"); ?>
    </td>
			<td valign="top" class="primary">
      <?php printSelect("transactionTypeCd","transaction_type_dm",$postVars); ?>
    </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary" valign="top">
      <?php echo $loc->getText("mbrAccountDesc"); ?>
    </td>
			<td valign="top" class="primary">
      <?php printInputText("description",40,128,$postVars,$pageErrors); ?>
    </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary" valign="top">
      <?php echo $loc->getText("mbrAccountAmount"); ?>
    </td>
			<td valign="top" class="primary">
      <?php printInputText("amount",12,12,$postVars,$pageErrors); ?>
    </td>
		</tr>
		<tr>
			<td colspan="2" class="primary" valign="top" align="center"><input
				type="submit" value="  <?php echo $loc->getText("circAdd"); ?>  "
				class="button"></td>
		</tr>
	</table>
	<input type="hidden" name="mbrid" value="<?php echo H($mbrid);?>">
</form>

<?php
# ****************************************************************************
# * Search database for member account info
# ****************************************************************************
$transQ = new MemberAccountQuery();
$transQ->connect_e();
if ($transQ->errorOccurred()) {
    $transQ->close();
    displayErrorPage($transQ);
}
if (! $transQ->doQuery($mbrid)) {
    $transQ->close();
    displayErrorPage($transQ);
}

?>

<h1><?php echo $loc->getText("mbrAccountHead1"); ?></h1>
<table class="primary">
	<tr>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("mbrAccountHdr1"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("mbrAccountHdr2"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("mbrAccountHdr3"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("mbrAccountHdr4"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("mbrAccountHdr5"); ?>
    </th>
		<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("mbrAccountHdr6"); ?>
    </th>
	</tr>

<?php
if ($transQ->getRowCount() == 0) {
    ?>
  <tr>
		<td class="primary" align="center" colspan="6">
      <?php echo $loc->getText("mbrAccountNoTrans"); ?>
    </td>
	</tr>
<?php
} else {
    $bal = 0;
    ?>
    <tr>
		<td class="primary" colspan="5"><?php echo $loc->getText("mbrAccountOpenBal"); ?></td>
		<td class="primary"><?php echo H(moneyFormat($bal,2));?></td>
	</tr>

    <?php
    while ($trans = $transQ->fetchRow()) {
        $bal = $bal + $trans->getAmount();
        ?>
  <tr>
		<td class="primary" valign="top"><a
			href="../circ/mbr_transaction_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>&amp;transid=<?php echo HURL($trans->getTransid());?>"><?php echo $loc->getText("mbrAccountDel");?></a>
		</td>
		<td class="primary" valign="top">
      <?php echo H($trans->getCreateDt());?>
    </td>
		<td class="primary" valign="top">
      <?php echo H($trans->getTransactionTypeDesc());?>
    </td>
		<td class="primary" valign="top">
      <?php echo H($trans->getDescription());?>
    </td>
		<td class="primary" valign="top">
      <?php echo H(moneyFormat($trans->getAmount(),2));?>
    </td>
		<td class="primary" valign="top">
      <?php echo H(moneyFormat($bal,2));?>
    </td>
	</tr>
<?php
    }
}
$transQ->close();

?>
</table>

<?php require_once("../shared/footer.php"); ?>
