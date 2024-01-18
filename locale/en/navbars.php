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
#*  Translation text shared by various php files under the navbars dir
#****************************************************************************
$trans["login"]                    = "\$text = 'Login';";
$trans["logout"]                   = "\$text = 'Logout';";
$trans["help"]                     = "\$text = 'Help';";

#****************************************************************************
#*  Translation text for page home.php
#****************************************************************************
$trans["homeHomeLink"]             = "\$text = 'Home';";
$trans["homeLicenseLink"]          = "\$text = 'License';";

#****************************************************************************
#*  Translation text for page admin.php
#****************************************************************************
$trans["adminSummary"]             = "\$text = 'Admin Summary';";
$trans["adminStaff"]               = "\$text = 'Staff Admin';";
$trans["adminSettings"]            = "\$text = 'Library Settings';";
$trans["adminMaterialTypes"]       = "\$text = 'Material Types';";
$trans["adminCollections"]         = "\$text = 'Collections';";
$trans["adminThemes"]              = "\$text = 'Themes';";
$trans["adminTranslation"]         = "\$text = 'Translation';";
$trans["Member Types"]             = "\$text = 'Member Types';";
$trans["Member Fields"]            = "\$text = 'Member Fields';";
$trans["Copy Fields"]              = "\$text = 'Copy Fields';";
$trans["Checkout Privs"]           = "\$text = 'Checkout Privs';";

#****************************************************************************
#*  Translation text for page cataloging.php
#****************************************************************************
$trans["catalogSummary"]           = "\$text = 'Catalog Summary';";
$trans["catalogSearch1"]           = "\$text = 'Biblio Search';";
$trans["catalogSearch2"]           = "\$text = 'Bibliography Search';";
$trans["catalogResults"]           = "\$text = 'Search Results';";
$trans["catalogBibInfo"]           = "\$text = 'Biblio Info';";
$trans["catalogBibEdit"]           = "\$text = 'Edit-Basic';";
$trans["catalogBibEditMarc"]       = "\$text = 'Edit-MARC';";
$trans["catalogBibMarcNewFld"]     = "\$text = 'New MARC Field';";
$trans["catalogBibMarcNewFldShrt"] = "\$text = 'New MARC';";
$trans["catalogBibMarcEditFld"]    = "\$text = 'Edit MARC Fld';";
$trans["catalogCopyNew"]           = "\$text = 'New Copy';";
$trans["catalogCopyEdit"]          = "\$text = 'Edit Copy';";
$trans["catalogHolds"]             = "\$text = 'Hold Requests';";
$trans["catalogDelete"]            = "\$text = 'Delete';";
$trans["catalogBibNewLike"]        = "\$text = 'New Like';";
$trans["catalogBibNew"]            = "\$text = 'New Bibliography';";
$trans["Upload Marc Data"]         = "\$text = 'Upload Marc Data';";
$trans["History"]                  = "\$text = 'History';";

#****************************************************************************
#*  Translation text for page reports.php
#****************************************************************************
$trans["reportsSummary"]           = "\$text = 'Reports Summary';";
$trans["reportsReportListLink"]    = "\$text = 'Report List';";
$trans["reportsLabelsLink"]        = "\$text = 'Print Labels';";
$trans["reportsLettersLink"]        = "\$text = 'Print Letters';";
$trans["Report Results"]           = "\$text = 'Report Results';";
$trans["Report List"]              = "\$text = 'Report List';";
$trans["Report Criteria"]          = "\$text = 'Report Criteria';";

#****************************************************************************
#*  Translation text for page opac.php
#****************************************************************************
$trans["catalogSearch1"]           = "\$text = 'Search';";
$trans["catalogSearch2"]           = "\$text = 'Bibliography Search';";
$trans["catalogResults"]           = "\$text = 'Search Results';";
$trans["catalogBibInfo"]           = "\$text = 'Biblio Info';";
$trans["userlogin"]                = "\$text = 'User Login';";
$trans["memberaccount"]            = "\$text = 'Member Account';";

#Added

$trans["memberInfo"]="\$text = 'Member Info';";
$trans["memberSearch"]="\$text = 'Member Search';";
$trans["editInfo"]="\$text = 'Edit Info';";
$trans["checkoutHistory"]= "\$text = 'Checkout History';";
$trans["account"]="\$text = 'Account';";
$trans["checkIn"]="\$text = 'Check In';";
$trans["memberSearch"]= "\$text = 'Member Search';";
$trans["newMember"]= "\$text = 'New Member';";
$trans["Offline Circulation"]= "\$text = 'Offline Circulation';";
//$trans["account"]        	= "\$text = 'Account';";
?>
