<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/**********************************************************************************
 *   Instructions for translators:
 *
 *   All gettext key/value pairs are specified as follows:
 *     $trans["key"] = "<php translation code to set the $text variable>";
 *   Allowing translators the ability to execute php code withint the transFunc string
 *   provides the maximum amount of flexibility to format the languange syntax.
 *
 *   Formatting rules:
 *   - Resulting translation string must be stored in a variable called $text.
 *   - Input arguments must be surrounded by % characters (i.e. %pageCount%).
 *   - A backslash ('\') needs to be placed before any special php characters 
 *     (such as $, ", etc.) within the php translation code.
 *
 *   Simple Example:
 *     $trans["homeWelcome"]       = "\$text='Welcome to OpenBiblio';";
 *
 *   Example Containing Argument Substitution:
 *     $trans["searchResult"]      = "\$text='page %page% of %pages%';";
 *
 *   Example Containing a PHP If Statment and Argument Substitution:
 *     $trans["searchResult"]      = 
 *       "if (%items% == 1) {
 *         \$text = '%items% result';
 *       } else {
 *         \$text = '%items% results';
 *       }";
 *
 **********************************************************************************
 */


#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHeading"]       = "\$text='Welcome to OpenBiblio';";
$trans["indexIntro"]         = "\$text=
  'Use the navigation tabs at the top of each page to access the following library
  administration sections.';";
$trans["indexTab"]           = "\$text='Tab';";
$trans["indexDesc"]          = "\$text='Description';";
$trans["indexCirc"]          = "\$text='Circulation';";
$trans["indexCircDesc1"]     = "\$text='Use this tab to manage your member records.';";
$trans["indexCircDesc2"]     = "\$text='Member administration (new, search, edit, delete)';";
$trans["indexCircDesc3"]     = "\$text='Member bibliography checkout, holds, account, and history';";
$trans["indexCircDesc4"]     = "\$text='Bibliography checkin and shelving cart list';";
//$trans["indexCircDesc5"]     = "\$text='Member late fee payment';";
$trans["indexCat"]           = "\$text='Cataloging';";
$trans["indexCatDesc1"]      = "\$text='Use this tab to manage your bibliography records.';";
$trans["indexCatDesc2"]      = "\$text='Bibliography administration (new, search, edit, delete)';";
//$trans["indexCatDesc3"]      = "\$text='Import bibliography from USMarc record';";
$trans["indexAdmin"]         = "\$text='Admin';";
$trans["indexAdminDesc1"]    = "\$text='Use this tab to manage staff and administrative records.';";
$trans["indexAdminDesc2"]    = "\$text='Staff administration (new, edit, password, delete)';";
$trans["indexAdminDesc3"]    = "\$text='General library settings';";
$trans["indexAdminDesc5"]    = "\$text='Library material type list';";
$trans["indexAdminDesc4"]    = "\$text='Library collection list';";
$trans["indexAdminDesc6"]    = "\$text='Library theme editor';";
$trans["indexReports"]       = "\$text='Reports';";
$trans["indexReportsDesc1"]  = "\$text='Use this tab to run reports on your library data.';";
$trans["indexReportsDesc2"]  = "\$text='Report.';";
$trans["indexReportsDesc3"]  = "\$text='Labels.';";

?>
