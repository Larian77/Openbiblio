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
#*  Common translation text shared among multiple pages
#****************************************************************************
$trans["sharedCancel"]             = "\$text = 'Abbrechen';";
$trans["sharedDelete"]             = "\$text = 'Löschen';";

#****************************************************************************
#*  Translation text for page biblio_view.php
#****************************************************************************
$trans["biblioViewTble1Hdr"]       = "\$text = 'Medieninformationen';";
$trans["biblioViewMaterialType"]   = "\$text = 'Medienart';";
$trans["biblioViewCollection"]     = "\$text = 'Genre';";
$trans["biblioViewPictureHeader"]  = "\$text = 'Bild des Mediums';";
$trans["biblioViewCallNmbr"]       = "\$text = 'Standort';";
$trans["biblioViewTble2Hdr"]       = "\$text = 'Exemplarinformationen';";
$trans["biblioViewTble2Col1"]      = "\$text = 'Mediennummer';";
$trans["biblioViewTble2Col2"]      = "\$text = 'Beschreibung';";
$trans["biblioViewTble2Col3"]      = "\$text = 'Status';";
$trans["biblioViewTble2Col4"]      = "\$text = 'Status Datum';";
$trans["biblioViewTble2Col5"]      = "\$text = 'Rückgabe';";
$trans["biblioViewTble2ColFunc"]   = "\$text = 'Funktion';";
$trans["biblioViewTble2Coldel"]    = "\$text = 'Lösche';";
$trans["biblioViewTble2Coledit"]   = "\$text = 'Bearb.';";
$trans["biblioViewTble3Hdr"]       = "\$text = 'Zusätzliche Medieninformationen';";
$trans["biblioViewNoAddInfo"]      = "\$text = 'Keine zusätzliche Medieninformationen verfügbar.';";
$trans["biblioViewNoCopies"]       = "\$text = 'Keine Exemplare wurden erstellt.';";
$trans["biblioViewOpacFlg"]        = "\$text = 'Zeige im OPAC';";
$trans["biblioViewNewCopy"]        = "\$text = 'Füge neues Exemplar hinzu';";
$trans["biblioViewNeweCopy"]       = "\$text = 'Füge neues Exemplar hinzu';";
$trans["biblioViewYes"]            = "\$text = 'Ja';";
$trans["biblioViewNo"]             = "\$text = 'Nein';";

#****************************************************************************
#*  Translation text for page biblio_search.php
#****************************************************************************
$trans["biblioSearchNoResults"]    = "\$text = 'Keine Ergebnisse gefunden.';";
$trans["biblioSearchResults"]      = "\$text = 'Suchergebnisse';";
$trans["biblioSearchResultPages"]  = "\$text = 'Ergebnis-Seiten';";
$trans["biblioSearchPrev"]         = "\$text = 'zurück';";
$trans["biblioSearchNext"]         = "\$text = 'vor';";
$trans["First"]         	   = "\$text = 'Anfang';";
$trans["Last"]         		   = "\$text = 'Ende';";
$trans["biblioSearchResultTxt"]    = "if (%items% == 1) {
                                        \$text = '%items% Ergebnis gefunden.';
                                      } else {
                                        \$text = '%items% Ergebnisse gefunden';
                                      }";
$trans["biblioSearchauthor"]       = "\$text = ' sortiert nach Autor';";
$trans["biblioSearchtitle"]        = "\$text = ' sortiert nach Titel';";
$trans["biblioSearchSortByAuthor"] = "\$text = 'sortiere nach Autor';";
$trans["biblioSearchSortByTitle"]  = "\$text = 'sortiere nach Titel';";
$trans["biblioSearchTitle"]        = "\$text = 'Titel';";
$trans["biblioSearchTitleRemainder"] = "\$text = 'Untertitel';";
$trans["biblioSearchAuthor"]       = "\$text = 'Autor';";
$trans["biblioSearchMaterial"]     = "\$text = 'Medienart';";
$trans["biblioSearchCollection"]   = "\$text = 'Genre';";
$trans["biblioSearchCall"]         = "\$text = 'Standort';";
$trans["biblioSearchCopyBCode"]    = "\$text = 'Mediennummer des Exempl.';";
$trans["biblioSearchCopyStatus"]   = "\$text = 'Status';";
$trans["biblioSearchNoCopies"]     = "\$text = 'Keine Exempl. verfügbar.';";
$trans["biblioSearchHold"]         = "\$text = 'vorbestellen';";
$trans["biblioSearchOutIn"]        = "\$text = 'ein-/ausbuchen';";
$trans["biblioSearchDetail"]       = "\$text = 'Detailierte Medieninfos anzeigen';";
$trans["biblioSearchBCode2Chk"]    = "\$text = 'Barcode zum Ein-/Ausbuchen';";
$trans["biblioSearchBCode2Hold"]   = "\$text = 'Barcode zum Vorbestellen';";

#****************************************************************************
#*  Translation text for page loginform.php
#****************************************************************************
$trans["loginFormTbleHdr"]         = "\$text = 'Mitarbeiter Login';";
$trans["loginFormUsername"]        = "\$text = 'Benutzername';";
$trans["loginFormPassword"]        = "\$text = 'Passwort';";
$trans["loginFormLogin"]           = "\$text = 'Login';";

#****************************************************************************
#*  Translation text for page login.php
#****************************************************************************
$trans["loginUserNameReqErr"]      = "\$text = 'Benutzername wird benötigt.';";
$trans["loginPwdReqErr"]           = "\$text = 'Passwort wird benötigt.';";
$trans["loginPwdInvErr"]           = "\$text = 'Anmeldung fehlgeschlagen.';";

#****************************************************************************
#*  Translation text for page hold_del_confirm.php
#****************************************************************************
$trans["holdDelConfirmMsg"]        = "\$text = 'Sind Sie sicher diese Vorbestellung zu löschen?';";

#****************************************************************************
#*  Translation text for page hold_del.php
#****************************************************************************
$trans["holdDelSuccess"]           = "\$text='Die Vorbestellung wurde erfolgreich gelöscht.';";

#****************************************************************************
#*  Translation text for page help_header.php
#****************************************************************************
$trans["helpHeaderTitle"]          = "\$text='OpenBiblio Hilfe';";
$trans["helpHeaderCloseWin"]       = "\$text='Schließe Fenster';";
$trans["helpHeaderContents"]       = "\$text='Inhalte';";
$trans["helpHeaderPrint"]          = "\$text='Drucke';";

$trans["catalogResults"]           = "\$text='Search Results';";
$trans["Revise Page"]              = "\$text='Überarb. S.';";
$trans["wiki updates to this page"] = "\$text='Wiki Updates dieser Seite';";

#****************************************************************************
#*  Translation text for page header.php and header_opac.php
#****************************************************************************
$trans["headerTodaysDate"]         = "\$text='Heutiges Datum:';";
$trans["headerDateFormat"]         = "\$text='d.m.Y';";
$trans["headerLibraryHours"]       = "\$text='Öffnungszeiten:';";
$trans["headerLibraryPhone"]       = "\$text='Telefonnummer:';";
$trans["headerHome"]               = "\$text='Startseite';";
$trans["headerCirculation"]        = "\$text='Ausleihe';";
$trans["headerCataloging"]         = "\$text='Katalogisierung';";
$trans["headerAdmin"]              = "\$text='Admin';";
$trans["headerReports"]            = "\$text='Berichte';";

#****************************************************************************
#*  Translation text for page footer.php
#****************************************************************************
$trans["footerLibraryHome"]        = "\$text='Bibliothekshomepage';";
$trans["footerOPAC"]               = "\$text='OPAC';";
$trans["footerHelp"]               = "\$text='Hilfe';";
$trans["footerPoweredBy"]          = "\$text='Powered by OpenBiblio version';";
$trans["footerDatabaseVersion"]    = "\$text='database version';";
$trans["footerCopyright"]          = "\$text='Copyright';";
$trans["footerUnderThe"]           = "\$text='under the';";
$trans["footerGPL"]                = "\$text='GNU General Public License';";

?>
