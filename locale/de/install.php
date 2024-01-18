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
#*  Translation text 
#****************************************************************************

$trans["installHeadline"]        = "\$text='OpenBiblio Installation:';";

#****************************************************************************
#*  Translation text for page cancel_msg.php
#****************************************************************************
$trans["cancelMessage"]         = "\$text='Der OpenBiblio-Installationsprozeß wurde angehalten.';";
$trans["cancelShow"]            = "\$text='Zeige Installationsanleitung';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexErr1"]             = "\$text='Die Verbindung zur Datenbank ist fehlgeschlagen mit dem folgenden Fehler.';";
$trans["indexErr2"]             = "\$text='Stellen Sie sicher, das das folgende getan wurde, bevor Sie das Install-Skript laufen lassen.';";
$trans["indexStep"]             = "\$text='Schritt';";
$trans["indexInstInstr"]        = "\$text='der Installationsanleitung';";
$trans["indexInstr1"]           = "\$text='Erstellen Sie die OpenBiblio Datenbank';";
$trans["indexInstr2"]           = "\$text='Erstellen Sie den OpenBiblio Datenbank-Benutzer';";
$trans["indexInstr3"]           = "\$text='Updaten Sie openbibilio/database_constants.php mit dem angelegeten Datenbank-Benutzername und Passwort';";
$trans["indexInstr4"]           = "\$text='Schauen Sie für mehr Details auch';";
$trans["indexInstr5"]           = "\$text='die Installationsanleitung';";
$trans["indexInstr6"]           = "\$text='an.';";
$trans["indexStart"]            = "\$text='Die Datenbankverbindung ist ok. Bitte wählen Sie eine Sprache aus und drücken Sie den Installiere-Knopf.';";
$trans["indexLang"]             = "\$text='Sprache:';";
$trans["indexTest"]             = "\$text='Installiere Testdaten:';";
$trans["indexInstall"]          = "\$text='Installiere';";
$trans["indexUpdateHead"]       = "\$text='Update Version 0.3.x zu Version 0.4.0 / 0.5.0:';";
$trans["indexAttention"]        = "\$text='Warnung - Bitte erstellen sie ein Backup ihrer Datenbank bevor Sie updaten!';";
$trans["indexUpdate"]           = "\$text='Update';";

#****************************************************************************
#*  Translation text for page installFuncs.php
#****************************************************************************
$trans["FuncsErr1"]             = "\$text='Fehler beim Lesen von';";

#****************************************************************************
#*  Translation text for page install.php
#****************************************************************************
$trans["installOK"]             = "\$text='Die Verbindung zur Datenbank ist ok.';";
$trans["installCreate"]         = "\$text='Erstelle OpenBiblio Tabellen...';";
$trans["installAlready"]        = "\$text='ist bereits installiert. Sind Sie sicher, daß sie alle Daten löschen und neue Tabellen erstellen wollen?';";
$trans["installCont"]           = "\$text='Weiter';";
$trans["installStop"]           = "\$text='Abbrechen';";
$trans["installTable"]          = "\$text='Tabelle ';";
$trans["installDel"]            = "\$text=' gelöscht';";
$trans["installTaCrea"]         = "\$text=' erstellt';";
$trans["installTable2"]         = "\$text='Daten für die Tabelle ';";
$trans["installIns"]            = "\$text=' eingefügt.';";
$trans["installReady1"]         = "\$text='Die OpenBiblio Tabellen wurden erfolreich erstellt!';";
$trans["installReady2"]         = "\$text='benutze OpenBiblio';";

#****************************************************************************
#*  Translation text for page update030.php
#****************************************************************************
$trans["UpdateHead"]            = "\$text='OpenBiblio Update:';";
$trans["UpdateOK"]              = "\$text='Die Datenbank-Verbindung ist ok!';";
$trans["UpdateErr1"]            = "\$text='Version 0.3.0 der OpenBiblio Daten konnte nicht gefunden werden.';";
$trans["UpdateAlready"]         = "\$text='ist derzeit installiert. Sind Sie sicher, daß Sie alle Daten zu Version 0.4.0 konvertieren wollen?';";
$trans["UpdateCont"]            = "\$text='Weiter';";
$trans["UpdateStop"]            = "\$text='Abbrechen';";
$trans["UpdateTable"]           = "\$text='Tabelle ';";
$trans["UpdateDel"]             = "\$text=' gelöscht';";
$trans["UpdateTaCrea"]          = "\$text=' erstellt';";
$trans["UpdateTable2"]          = "\$text='Daten für die Tabelle ';";
$trans["UpdateIns"]             = "\$text=' eingefügt.';";
$trans["UpdateConv1"]           = "\$text='Medien-Tabellen konvertiert.';";
$trans["UpdateConv2"]           = "\$text='Exemplartabelle konvertiert.';";
$trans["UpdateConv3"]           = "\$text='Benutzer Tabelle konvertiert.';";
$trans["UpdateConv4"]           = "\$text='Neue Mitarbeiter Tabelle, Zeilen gelöscht.';";
$trans["UpdateConv5"]           = "\$text='Mitarbeiter Tabelle konvertiert.';";
$trans["UpdateConv6"]           = "\$text='Neue Genre Tabelle, Zeilen gelöscht.';";
$trans["UpdateConv7"]           = "\$text='Genre Tabelle konvertiert.';";
$trans["UpdateConv8"]           = "\$text='Neue Medientyp Tabelle, Zeilen gelöscht.';";
$trans["UpdateConv9"]           = "\$text='Medientyp Tabelle konvertiert.';";
$trans["UpdateConv10"]          = "\$text='Neue Einstellungentabelle, Zeilen gelöscht.';";
$trans["UpdateConv11"]          = "\$text='Einstellungen Tabelle konvertiert.';";
$trans["UpdateConv12"]          = "\$text='Statustabelle wurde gelöscht.';";
$trans["UpdateRename"]          = "\$text=' umbenannt in ';";
$trans["UpdateReady1"]          = "\$text='Die OpenBiblio Tabellen wurden erfolreich erstellt!';";
$trans["UpdateReady2"]          = "\$text='benutze OpenBiblio';";

?>
