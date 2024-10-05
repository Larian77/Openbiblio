<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

$tab = 'admin';
require_once ("../shared/common.php");
require_once ("../shared/read_settings.php");
require_once ("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

include ("../install/header.php");


echo '<blockquote>';
    echo '<h2>' . $loc->getText('MaintenanceMode') . '</h2>';
    echo '<p>' . $loc->getText('MaintenanceExplication') , '</p>';
echo '</blockquote>';

include ("../install/footer.php");
?>
