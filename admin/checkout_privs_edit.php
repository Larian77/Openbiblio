<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");
$tab = "admin";
$nav = "checkout_privs";
$restrictInDemo = true;
require_once("../shared/logincheck.php");

require_once("../classes/CheckoutPrivsQuery.php");
require_once("../functions/errorFuncs.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);
#****************************************************************************
#*  Checking for post vars.  Go back to form if none found.
#****************************************************************************

if (
    !isset($_POST['material_cd'])
    or !isset($_POST['classification'])
    or !isset($_POST['checkout_limit'])
    or !isset($_POST['renewal_limit'])
) {
    header("Location: ../admin/checkout_privs_list.php");
    exit();
}

$privQ = new CheckoutPrivsQuery();
//Changes PVD(8.0.x)
$privQ->connect_e();
$privQ->update(
    $_POST['material_cd'],
    $_POST['classification'],
    $_POST['checkout_limit'],
    $_POST['renewal_limit']
);
$privQ->close();
header("Location: ../admin/checkout_privs_list.php?msg=" . U($loc->getText('Privileges updated')));
?>
