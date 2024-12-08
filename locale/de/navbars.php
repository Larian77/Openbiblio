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
$trans["help"]                     = "\$text = 'Hilfe';";
$trans["catalogSearch"]            = "\$text = 'Mediensuche';";
$trans["staff"]                    = "\$text = 'Mitarbeiter/-in: ';";

#****************************************************************************
#*  Translation text for page home.php
#****************************************************************************
$trans["homeHomeLink"]             = "\$text = 'Startseite';";
$trans["homeLicenseLink"]          = "\$text = 'Lizenz';";

#****************************************************************************
#*  Translation text for page admin.php
#****************************************************************************
$trans["adminSummary"]             = "\$text = 'Admin-Übersicht';";
$trans["adminStaff"]               = "\$text = 'Mitarbeiter';";
$trans["adminMaterialTypes"]       = "\$text = 'Medienarten';";
$trans["adminCollections"]         = "\$text = 'Genres';";
$trans["adminTranslation"]         = "\$text = 'Übersetzung';";
$trans["Member Types"]             = "\$text = 'Mitgliederarten';";
$trans["Member Fields"]            = "\$text = 'Mitgliederfelder';";
$trans["Copy Fields"]              = "\$text = 'Exemplarfelder';";
$trans["Checkout Privs"]           = "\$text = 'Ausleiheinst.';";
$trans["adminSettings"]            = "\$text = 'Bibliothekseinst.';";
$trans["adminMailSettings"]        = "\$text = 'Mail-Einstellungen';";
$trans["adminMailMessages"]        = "\$text = 'Mail-Nachrichten';";
$trans["adminThemes"]              = "\$text = 'Layout';";

#****************************************************************************
#*  Translation text for page cataloging.php
#****************************************************************************
$trans["catalogSummary"]           = "\$text = 'Katalogisierung';";
$trans["catalogResults"]           = "\$text = 'Suchergebnisse';";
$trans["catalogBibInfo"]           = "\$text = 'Medieninformationen';";
$trans["catalogBibEdit"]           = "\$text = 'Med. bearb.';";
$trans["catalogBibEditMarc"]       = "\$text = 'MARC bearb.';";
$trans["catalogUploadPicture"]     = "\$text = 'Bild hochladen';";
$trans["catalogBibMarcNewFld"]     = "\$text = 'Neues MARC Feld';";
$trans["catalogBibMarcNewFldShrt"] = "\$text = 'Neues MARC';";
$trans["catalogBibMarcEditFld"]    = "\$text = 'Bearb. MARC Feld';";
$trans["catalogCopyNew"]           = "\$text = 'Neues Exem.';";
$trans["catalogCopyEdit"]          = "\$text = 'Bearb. Exem.';";
$trans["catalogHolds"]             = "\$text = 'Vorbestellungen';";
$trans["catalogDelete"]            = "\$text = 'Lösche';";
$trans["catalogBibNewLike"]        = "\$text = 'Ähnliches Neu';";
$trans["catalogBibNew"]            = "\$text = 'Neues Medium';";
$trans["Upload Marc Data"]         = "\$text = 'MARC Daten laden';";
$trans["History"]                  = "\$text = 'Historie';";

#****************************************************************************
#*  Translation text for page reports.php
#****************************************************************************
$trans["reportsSummary"]           = "\$text = 'Berichte Übersicht';";
$trans["reportsReportListLink"]    = "\$text = 'Berichte';";
$trans["reportsLabelsLink"]        = "\$text = 'Etiketten';";
$trans["reportsLettersLink"]       = "\$text = 'Briefe';";
$trans["Report Results"]           = "\$text = 'Berichtsergebnis';";
$trans["Report List"]              = "\$text = 'Berichteübersicht';";
$trans["Report Criteria"]          = "\$text = 'Berichtskriterien';";

#****************************************************************************
#*  Translation text for page opac.php and loginform.php
#****************************************************************************
$trans["catalogResults"]           = "\$text = 'Suchergebnisse';";
$trans["catalogBibInfo"]           = "\$text = 'Medieninfo';";
$trans["userlogin"]      	   = "\$text = 'Benutzer-Login';";
$trans["memberaccount"]      	   = "\$text = 'Benutzerkonto';";

#****************************************************************************
#*  Translation text for page navbar opac for file mbr_pwd_forget_form.php
#****************************************************************************
$trans["PwdNewSet"]           = "\$text='Kennw. neu setzen';";

#Added

$trans["memberInfo"]               = "\$text = 'Benutzerinfos';";
$trans["memberSearch"]             = "\$text = 'Benutzersuche';";
$trans["editInfo"]                 = "\$text = 'Bearb. Profil';";
$trans["PwdCreate"]                = "\$text = 'Kennw. anlegen';";
$trans["PwdReset"]                 = "\$text = 'Kennw. ändern';";
$trans["checkoutHistory"]          = "\$text = 'Ausleih-History';";
$trans["account"]                  = "\$text = 'Gebühren';";
$trans["checkIn"]                  = "\$text = 'Medienrückgabe';";
$trans["memberSearch"]             = "\$text = 'Benutzersuche';";
$trans["newMember"]                = "\$text = 'Neuer Benutzer';";
$trans["Offline Circulation"]      = "\$text = 'Offline Ausleihe';";
?>
