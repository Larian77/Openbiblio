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
$trans["opac_Header"]        = "\$text='Onlinekatalog (OPAC)';";
$trans["opac_WelcomeMsg"]    = "\$text=
'Willkommen im Onlinekatalog unserer Bibliothek. Durchsuchen Sie unseren Katalog nach Informationen über die Medien in unserem Bestand.';";
$trans["opac_SearchTitle"]   = "\$text='Suche Medium durch:';";
$trans["opac_Keyword"]       = "\$text='Suchbegriff';";
$trans["opac_Title"]         = "\$text='Titel';";
$trans["opac_Author"]        = "\$text='Autor';";
$trans["opac_Subject"]       = "\$text='Schlagwort';";
$trans["opac_All"]           = "\$text='Alle';";
$trans["opac_Callno"]        = "\$text='Standort';";
$trans["opac_Search"]        = "\$text='Suche';";
$trans["opac_SearchInvert"]  = "\$text='Auswahl umkehren';";
$trans["opac_SearchColl"]    = "\$text='Begrenze Suche auf Genres';";
$trans["opac_SearchMat"]     = "\$text='Begrenze Suche auf Medienarten';";

#****************************************************************************
#*  Translation text for page loginform.php
#****************************************************************************
$trans["loginFormTbleHdr"]         = "\$text = 'Benutzer Login';";
$trans["MemberID"]        	   = "\$text = 'Benutzernummer';";
$trans["Secret Word"]	           = "\$text = 'Kennwort';";
$trans["loginFormLogin"]           = "\$text = 'Login';";
$trans["loginDeactived"]           = "\$text = 'Login ist deaktiviert.';";
$trans["PasswordForgotten"]	   = "\$text = 'Kennwort vergessen?';";

#****************************************************************************
#*  Translation text for page login.php
#****************************************************************************
$trans["MemberID is required."]    = "\$text = 'Benutzernummer erforderlich';";
$trans["Password is required."] = "\$text = 'Geheimwort erforderlich';";
$trans["Invalid Login!"] = "\$text = 'Falsche Anmeldedaten!';";

#****************************************************************************
#*  Translation text for page mbr_account.php
#****************************************************************************
$trans["mbrViewBalMsg"]           = "\$text='Bemerkung: Benutzer hat ausstehende Gebühren von %bal%.';";
$trans["mbrViewHead1"]            = "\$text='Benutzerinformation:';";
$trans["mbrViewName"]             = "\$text='Name:';";
$trans["mbrViewCardNmbr"]         = "\$text='Benutzernummer:';";
$trans["mbrViewMbrShipEnd"]       = "\$text='bezahlt bis:';";
$trans["mbrViewMbrShipNoEnd"]     = "\$text='unendlich/nicht benutzt';";
$trans["mbrViewHead4"]            = "\$text='Derzeit ausgeliehene Medien:';";
$trans["mbrPrintCheckouts"]	  = "\$text='Ausgeliehene Medien drucken';";
$trans["mbrViewOutHdr1"]          = "\$text='Ausgeliehen';";
$trans["mbrViewOutHdr2"]          = "\$text='Medienart';";
$trans["mbrViewOutHdr3"]          = "\$text='Mediennummer';";
$trans["mbrViewOutHdr4"]          = "\$text='Titel';";
$trans["mbrViewOutHdr5"]          = "\$text='Autor';";
$trans["mbrViewOutHdr6"]          = "\$text='Rückgabe';";
$trans["mbrViewOutHdr7"]          = "\$text='überfällige<br>Tage';";
$trans["mbrViewOutHdr8"]          = "\$text='Verlängerungen';";
$trans["mbrViewNoCheckouts"]      = "\$text='Derzeit keine Medien ausgeliehen.';";
$trans["Cannot renew item *"]     = "\$text='Kann Medium nicht verlängern *';";
$trans["Renew item"]              = "\$text='Verlängere Medium';";
$trans["mbrViewOutHdr9"]          = "\$text='Mal';";
$trans["* You cannot renew, if you are more then 7 days too late"] = "\$text='* Medien, die mehr als 7 Tage überfällig sind, können nicht verlängert werden.';";
$trans["mbrViewHead5"]            = "\$text='Vorbestellen:';";
$trans["mbrViewBarcode"]          = "\$text='Mediennummer:';";
$trans["indexSearch"]             = "\$text='Suche';";
$trans["mbrViewPlaceHold"]        = "\$text='Vorbestellen';";
$trans["mbrViewHead6"]            = "\$text='Derzeit vorbestellte Medien:';";
$trans["mbrViewHoldHdr2"]         = "\$text='Vorbestellt';";
$trans["mbrViewHoldHdr3"]         = "\$text='Medienart';";
$trans["mbrViewHoldHdr4"]         = "\$text='Mediennummer';";
$trans["mbrViewHoldHdr5"]         = "\$text='Titel';";
$trans["mbrViewHoldHdr6"]         = "\$text='Autor';";
$trans["mbrViewHoldHdr7"]         = "\$text='Status';";
$trans["mbrViewHoldHdr8"]         = "\$text='Rückgabe';";
$trans["mbrViewNoHolds"]          = "\$text='Derzeit keine Medien vorbestellt.';";
$trans["Please send a mail to delete holds"] = "\$text='Wenn Sie Vorbestellungen löschen wollen, mailen Sie uns bitte!';";
$trans["eMail"]                   = "\$text='E-Mail';";
$trans["mbrViewPwd"]              = "\$text='Kennwort:';";
$trans["mbrNoPassword"]                    = "\$text = '<p style=\"font-weight: bold; color: red;\";>Kein Kennwort gesetzt!</p>';";

#****************************************************************************
#*  Translation text for page mbr_print_checkouts.php
#****************************************************************************
$trans["mbrPrintCheckoutsTitle"]  = "\$text='Ausleihen von %mbrName%';";
$trans["mbrPrintCheckoutsHdr1"]   = "\$text='Aktuelles Datum:';";
$trans["mbrPrintCheckoutsHdr2"]   = "\$text='Benutzer:';";
$trans["mbrPrintCheckoutsHdr3"]   = "\$text='Benutzernummer:';";
$trans["mbrPrintCloseWindow"]     = "\$text='Schließe Fenster';";

#****************************************************************************
#*  Translation text for page place_hold.php
#****************************************************************************
$trans["placeHoldErr2"]           = "\$text='Die Mediennummer exitiert nicht.';";
$trans["placeHoldErr3"]           = "\$text='Das Mitglied hat dieses Medium bereits ausgeliehen - keine Vorbestellung angelegt.';";
$trans["This item is not checked out or on hold."]           = "\$text='Dieses Exemplar ist weder vorbestellt noch ausgeliehen.';";

?>
