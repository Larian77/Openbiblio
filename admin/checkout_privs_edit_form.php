<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "admin";
$nav = "checkout_privs";
$focus_form_name = "editprivsform";
$focus_form_field = "checkout_limit";

require_once ("../functions/inputFuncs.php");
require_once ("../shared/logincheck.php");
require_once ("../classes/CheckoutPrivsQuery.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

if (isset($_REQUEST["material_cd"]) and isset($_REQUEST["classification"])) {
    $material_cd = $_REQUEST["material_cd"];
    $classification = $_REQUEST["classification"];
} elseif (isset($_SESSION['postVars']["material_cd"]) and isset($_SESSION['postVars']["classification"])) {
    $material_cd = $_SESSION['postVars']["material_cd"];
    $classification = $_SESSION['postVars']["classification"];
} else {
    header("Location: ../admin/checkout_privs_list.php");
    exit();
}

$privsQ = new CheckoutPrivsQuery();
// Changes PVD(8.0.x)
$privsQ->connect_e();
$priv = $privsQ->get($material_cd, $classification);
$privsQ->close();

require_once ("../shared/header.php");

?>

<form name="editprivsform" method="POST"
	action="../admin/checkout_privs_edit.php">
	<input type="hidden" name="material_cd"
		value="<?php echo H($material_cd); ?>"> <input type="hidden"
		name="classification" value="<?php echo H($classification); ?>">
	<table class="primary">
		<tr>
			<th style="white-space: nowrap;" colspan="2" align="left">
                <?php echo $loc->getText("Edit Checkout Privileges"); ?>
            </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
                <?php echo $loc->getText("Material Type:"); ?>
            </td>
			<td valign="top" class="primary">
                <?php echo H($priv['material_type']) ?>
            </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
                <?php echo $loc->getText("Member Classification:"); ?>
            </td>
			<td valign="top" class="primary">
                <?php echo H($priv['classification_type']) ?>
            </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
                <?php echo $loc->getText("Checkout Limit:"); ?>
            </td>
			<td valign="top" class="primary">
                <?php echo inputField('text', 'checkout_limit', $priv['checkout_limit']); ?>
            </td>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
                <?php echo $loc->getText("Renewal Limit:"); ?>
            </td>
			<td valign="top" class="primary">
                <?php echo inputField('text', 'renewal_limit', $priv['renewal_limit']); ?>
            </td>
		</tr>
		<tr>
			<td align="center" colspan="2" class="primary"><input type="submit"
				value="  <?php echo $loc->getText("adminSubmit"); ?>  "
				class="button"> <input type="button"
				onClick="self.location='../admin/checkout_privs_list.php'"
				value="  <?php echo $loc->getText("adminCancel"); ?>  "
				class="button"></td>
		</tr>

	</table>
</form>

<?php include("../shared/footer.php"); ?>
