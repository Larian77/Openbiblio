<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");
$tab = "admin";
$nav = "checkout_privs";

require_once("../classes/CheckoutPrivsQuery.php");
require_once("../functions/errorFuncs.php");
require_once("../shared/logincheck.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

require_once("../shared/header.php");

$privsQ = new CheckoutPrivsQuery();
//Changes PVD(8.0.x)
$privsQ->connect_e();
$privs = $privsQ->getAll();
$privsQ->close();

?>
<h1>
    <?php echo $loc->getText("Checkout Privileges"); ?>
</h1>
<table class="primary">
    <tr>
        <th valign="top">
            <?php echo $loc->getText("function"); ?>
        </th>
        <th valign="top">
            <?php echo $loc->getText("Material Type"); ?>
        </th>
        <th valign="top">
            <?php echo $loc->getText("Member Classification"); ?>
        </th>
        <th valign="top">
            <?php echo $loc->getText("Checkout Limit"); ?>
        </th>
        <th valign="top">
            <?php echo $loc->getText("Renewal Limit"); ?>
        </th>
    </tr>
    <?php
    $row_class = "primary";
    foreach ($privs as $priv) {
        ?>
        <tr>
            <td valign="top" align="center" class="<?php echo H($row_class); ?>">
                <a href="../admin/checkout_privs_edit_form.php?material_cd=<?php echo HURL($priv['material_cd']); ?>&amp;classification=<?php echo HURL($priv['classification']); ?>"
                    class="<?php echo H($row_class); ?>">
                    <?php echo $loc->getText("edit"); ?>
                </a>
            </td>
            <td valign="top" class="<?php echo H($row_class); ?>">
                <?php echo H($priv['material_type']); ?>
            </td>
            <td valign="top" class="<?php echo H($row_class); ?>">
                <?php echo H($priv['classification_type']); ?>
            </td>
            <td valign="top" class="<?php echo H($row_class); ?>">
                <?php echo H($priv['checkout_limit']); ?>
            </td>
            <td valign="top" class="<?php echo H($row_class); ?>">
                <?php echo H($priv['renewal_limit']); ?>
            </td>
        </tr>
        <?php
        # swap row color
        if ($row_class == "primary") {
            $row_class = "alt1";
        } else {
            $row_class = "primary";
        }
    }
    ?>
</table>
<?php include("../shared/footer.php"); ?>
