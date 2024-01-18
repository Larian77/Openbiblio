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
$trans["indexHeading"]       = "\$text='Willkommen bei OpenBiblio';";
$trans["indexIntro"]         = "\$text=
  'Benutzen Sie die Navigations-Reiter am oberen Rand jeder Seite um zu den Bereichen zu gelangen.';";
$trans["indexTab"]           = "\$text='Reiter';";
$trans["indexDesc"]          = "\$text='Beschreibung';";
$trans["indexCirc"]          = "\$text='Ausleihe';";
$trans["indexCircDesc1"]     = "\$text='Benutzen Sie diesen Reiter um die Benutzer zu verwalten.';";
$trans["indexCircDesc2"]     = "\$text='Mitglieder-Verwaltung (Neu, Suche, Bearbeiten, Löschen)';";
$trans["indexCircDesc3"]     = "\$text='Ausleihe, Vorbestellungen, Gebührenverwaltung und History der Mitglieder';";
$trans["indexCircDesc4"]     = "\$text='Medienrückgabe und Eingangsablage';";
//$trans["indexCircDesc5"]     = "\$text='Member late fee payment';";
$trans["indexCat"]           = "\$text='Katalogisierung';";
$trans["indexCatDesc1"]      = "\$text='Benutzen Sie diesen Reiter um die Medien zu verwalten.';";
$trans["indexCatDesc2"]      = "\$text='Medien-Verwaltung (Neu, Suche, Bearbeiten, Löschen)';";
//$trans["indexCatDesc3"]      = "\$text='Import bibliography from USMarc record';";
$trans["indexAdmin"]         = "\$text='Admin';";
$trans["indexAdminDesc1"]    = "\$text='Benutzen Sie diesen Reiter um die Mitarbeiter zu verwalten und die Programmeinstellungen zu ändern.';";
$trans["indexAdminDesc2"]    = "\$text='Mitarbeiter Verwaltung (Neu, Bearbeiten, Passwort, Löschen)';";
$trans["indexAdminDesc3"]    = "\$text='Generelle Bibliothekseinstellungen';";
$trans["indexAdminDesc5"]    = "\$text='Liste der Medienarten';";
$trans["indexAdminDesc4"]    = "\$text='Liste der Genres';";
$trans["indexAdminDesc6"]    = "\$text='Layout-Editor';";
$trans["indexReports"]       = "\$text='Berichte';";
$trans["indexReportsDesc1"]  = "\$text='Benutzen Sie diesen Reiter um Berichte über die Daten zu erstellen.';";
$trans["indexReportsDesc2"]  = "\$text='Berichte.';";
$trans["indexReportsDesc3"]  = "\$text='Etiketten.';";

?>
