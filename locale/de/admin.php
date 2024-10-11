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
$trans["adminSubmit"]                   = "\$text = 'Übermitteln';";
$trans["adminCancel"]                   = "\$text = 'Abbrechen';";
$trans["adminDelete"]                   = "\$text = 'Löschen';";
$trans["adminUpdate"]                   = "\$text = 'Update';";
$trans["adminFootnote"]                 = "\$text = 'Felder, die mit %symbol% markiert sind, werden benötigt.';";
$trans["function"]                      = "\$text = 'Funktion';";
$trans["edit"]                          = "\$text = 'Bearb.';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                      = "\$text = 'Admin';";
$trans["indexDesc"]                     = "\$text = 'Benutzen Sie die Funktionen im linken Navigationsbereich, um die Mitarbeiter anzulegen und zu bearbeiten und die Programmeinstellungen zu ändern.';";

#****************************************************************************
#*  Translation text for page collections*.php
#****************************************************************************
$trans["adminCollections_delReturn"]    = "\$text = 'kehre zur Genreliste zurück';";
$trans["adminCollections_delStart"]     = "\$text = 'Genre, ';";

#****************************************************************************
#*  Translation text for page collections_del.php
#****************************************************************************
$trans["adminCollections_delEnd"]       = "\$text = ', wurde gelöscht.';";

#****************************************************************************
#*  Translation text for page collections_del_confirm.php
#****************************************************************************
$trans["adminCollections_del_confirmText"] = "\$text = 'Sind Sie sicher folgendes Genre zu löschen: ';";

#****************************************************************************
#*  Translation text for page collections_edit.php
#****************************************************************************
$trans["adminCollections_editEnd"]       = "\$text = ', wurde aktualisiert.';";

#****************************************************************************
#*  Translation text for page collections_edit_form.php
#****************************************************************************
$trans["adminCollections_edit_formEditcollection"] = "\$text = 'Bearbeite Genre:';";
$trans["adminCollections_edit_formDescription"]    = "\$text = 'Beschreibung:';";
$trans["adminCollections_edit_formDaysdueback"]    = "\$text = 'Ausleihdauer in Tagen:';";
$trans["adminCollections_edit_formDailyLateFee"]   = "\$text = 'Tägliche Versäumnisgebühr:';";
$trans["adminCollections_edit_formNote"]           = "\$text = '*Bemerkung:';";
$trans["adminCollections_edit_formNoteText"]       = "\$text = 'Wenn Sie die Ausleihdauer auf 0 setzen, kann man dieses Genre nicht ausleihen.';";

#****************************************************************************
#*  Translation text for page collections_list.php
#****************************************************************************
$trans["adminCollections_listAddNewCollection"]     = "\$text = 'Füge neues Genre hinzu';";
$trans["adminCollections_listCollections"]          = "\$text = 'Genres:';";
$trans["adminCollections_listFunction"]             = "\$text = 'Funktionen';";
$trans["adminCollections_listDescription"]          = "\$text = 'Beschreibung';";
$trans["adminCollections_listDaysdueback"]          = "\$text = 'Ausleih-<br>dauer';";
$trans["adminCollections_listDailylatefee"]         = "\$text = 'Tägliche<br>Versäumnisgebühr';";
$trans["adminCollections_listBibliographycount"]    = "\$text = 'Anzahl der<br>Medien';";
$trans["adminCollections_listDel"]                  = "\$text = 'Lösche';";
$trans["adminCollections_ListNote"]                 = "\$text = '*Bemerkung:';";
$trans["adminCollections_ListNoteText"]             = "\$text = 'Man kann nur Genres löschen, die keine Medien enthalten.<br>Wenn Sie ein Genre löschen möchten, welches Medien enthält, müssen sie diese Medien zuerst einem anderen Genre zuordnen.';";

#****************************************************************************
#*  Translation text for page collections_new.php
#****************************************************************************
$trans["adminCollections_newAdded"]                 = "\$text = ', wurde hinzugefügt.';";

#****************************************************************************
#*  Translation text for page collections_new_form.php
#****************************************************************************
$trans["adminCollections_new_formAddnewcollection"] = "\$text = 'Füge neues Genre hinzu:';";
$trans["adminCollections_new_formDescription"]      = "\$text = 'Beschreibung:';";
$trans["adminCollections_new_formDaysdueback"]      = "\$text = 'Ausleihdauer in Tagen:';";
$trans["adminCollections_new_formDailylatefee"]     = "\$text = 'Tägliche Versäumnisgebühr:';";
$trans["adminCollections_new_formNote"]             = "\$text = '*Bemerkung:';";
$trans["adminCollections_new_formNoteText"]         = "\$text = 'Wenn Sie die Ausleihdauer auf 0 setzen, kann man dieses Genre nicht ausleihen.';";

#****************************************************************************
#*  Translation text for page materials_del.php
#****************************************************************************
$trans["admin_materials_delMaterialType"]           = "\$text = 'Medienart, ';";
$trans["admin_materials_delMaterialdeleted"]        = "\$text = ', wurde gelöscht.';";
$trans["admin_materials_Return"]                    = "\$text = 'kehre zur Medienartenliste zurück';";

#****************************************************************************
#*  Translation text for page materials_del_form.php
#****************************************************************************
$trans["admin_materials_delAreyousure"]              = "\$text = 'Sind Sie sicher folgende Medienart zu löschen: ';";

#****************************************************************************
#*  Translation text for page materials_edit_form.php
#****************************************************************************
$trans["admin_materials_delEditmaterialtype"]        = "\$text = 'Bearbeite Medienarten:';";
$trans["admin_materials_delDescription"]             = "\$text = 'Beschreibung:';";
$trans["admin_materials_delunlimited"]               = "\$text = '(0 für unbeschränkt)';";
$trans["admin_materials_delImagefile"]               = "\$text = 'Bilddatei:';";
$trans["admin_materials_delNote"]                    = "\$text = '*Bemerkung:';";
$trans["admin_materials_delNoteText"]                = "\$text = 'Die Bilddatein muß sich im Verzeichnis openbiblio/images befinden.';";

#****************************************************************************
#*  Translation text for page materials_edit.php
#****************************************************************************
$trans["admin_materials_editEnd"]                    = "\$text = ', wurde aktualisiert.';";

#****************************************************************************
#*  Translation text for page materials_list.php
#****************************************************************************
$trans["admin_materials_listAddmaterialtypes"]       = "\$text = 'Füge neue Medienart hinzu';";
$trans["admin_materials_listMaterialtypes"]          = "\$text = 'Medienarten:';";
$trans["admin_materials_listFunction"]               = "\$text = 'Funktionen';";
$trans["admin_materials_listDescription"]            = "\$text = 'Beschreibung';";
$trans["admin_materials_listLimits"]                 = "\$text = 'Limits';";
$trans["admin_materials_listCheckoutlimit"]          = "\$text = 'Ausleihe';";
$trans["admin_materials_listRenewallimit"]           = "\$text = 'Verlängerung';";
$trans["admin_materials_listImageFile"]              = "\$text = 'Bild<br>Datei';";
$trans["admin_materials_listBibcount"]               = "\$text = 'Anzahl der<br>Medien';";
$trans["admin_materials_listDel"]                    = "\$text = 'Lösche';";
$trans["admin_materials_listNote"]                   = "\$text = '*Bemerkung:';";
$trans["admin_materials_listNoteText"]               = "\$text = 'Man kann nur Medienarten löschen, die keine Medien enthalten.<br>Wenn Sie eine Medienart löschen möchten, welche Medien enthält, müssen sie diese Medien zuerst einer anderen Medienart zuordnen.';";
$trans["No fields found!"]                           = "\$text = 'Keine Felder gefunden!';";

#****************************************************************************
#*  Translation text for page materials_new.php
#****************************************************************************
$trans["admin_materials_listNewadded"]               = "\$text = ', wurde hinzugefügt.';";

#****************************************************************************
#*  Translation text for page materials_new_form.php
#****************************************************************************
$trans["admin_materials_new_formNoteText"]           = "\$text = 'Die Bilddatei muß sich im Verzeichnis openbiblio/images befinden.';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["admin_noauth"]                               = "\$text = 'Sie sind nicht berechtigt den Adminbereich zu benutzen.';";

#****************************************************************************
#*  Translation text for page settings_edit_form.php 
#****************************************************************************
$trans["admin_settingsUpdated"]                 = "\$text = 'Die Daten wurden aktualisiert.';";
$trans["admin_settingsEditsettings"]            = "\$text = 'Bearbeite Bibliothekseinstellungen:';";
$trans["admin_settingsLibName"]                 = "\$text = 'Bibliotheksname:';";
$trans["admin_settingsLibimageurl"]             = "\$text = 'URL des Bibliothekslogo:';";
$trans["admin_settingsOnlyshowimginheader"]     = "\$text = 'Zeige nur das Bild in Kopfzeile:';";
$trans["admin_settingsLibhours"]                = "\$text = 'Öffnungszeiten:';";
$trans["admin_settingsLibphone"]                = "\$text = 'Telefonnummer:';";
$trans["admin_settingsLibURL"]                  = "\$text = 'Homepage:';";
$trans["admin_settingsOPACURL"]                 = "\$text = 'OPAC URL:';";
$trans["admin_settingsSessionTimeout"]          = "\$text = 'Session Timeout:';";
$trans["admin_settingsMinutes"]                 = "\$text = 'Minuten';";
$trans["admin_settingsSearchResults"]           = "\$text = 'Suchergebnisse:';";
$trans["admin_settingsItemsperpage"]            = "\$text = 'Ergebnisse pro Seite';";
$trans["admin_settingsPurgebibhistory"]         = "\$text = 'Lösche vergangene Ausleihvorgänge nach:';";
$trans["admin_settingsmonths"]                  = "\$text = 'Monaten';";
$trans["admin_settingsBlockCheckouts"]          = "\$text = 'Blockiere Ausleihe, wenn Gebühren anstehen:';";
$trans["Max. hold length:"]                     = "\$text = 'Max. Reservierungsdauer:';";
$trans["days"]                                  = "\$text = 'Tage';";
$trans["admin_settingsLocale"]                  = "\$text = 'Sprache:';";
$trans["admin_settingsHTMLChar"]                = "\$text = 'HTML Zeichensatz:';";
$trans["admin_settingsHTMLTagLangAttr"]         = "\$text = 'HTML Tag Sprach Attribut:';";
$trans["If the month value for purging history is higher than zero, values in statistics reports shift over time.<br>Data from statistics reports should be saved outside OpenBiblio for future reference."]                 = "\$text = 'Wenn die Monatsanzahl beim löschen der Historie größer als Null ist, können sich die statistischen Werte verändern.<br>Daten aus statistischen Reporten sollten für zukünftige Referenzen außerhalb von Openbiblio gespeichert werden.';";
$trans["admin_settingsLoginAttemps"]            = "\$text = 'Sperrung nach n Login-Fehlversuchen:';";
$trans["admin_settingsPwdTimeout"]              = "\$text = 'Sperrzeit bei mehrmaligen Fehl-Login (min):';";
$trans["admin_settingsMbrAccountOnline"]           = "\$text = 'Online-Zugriff für Benutzer:';";
$trans["admin_settingsMbrAccountOnline_explication"] = "\$text = 'Durch das Setzen des Häkchens können alle Bibliotheksbenutzer auf ihr eigenes Bibliothekskonto zugreifen. Voraussetzung dafür ist das Setzen eines Kennwortes.<br />"
                    . "Bei Nicht-Setzen des Häkchens können die Benutzer weiterhin in der Bibliothek suchen, jedoch haben keinen Zugriff auf ein eigenes Konto, um Medien bspw. zu verlängern oder vorzubestellen.';";
$trans["admin_mailService_explication"]           = "\$text = 'In der Grundeinstellung für den Mailversand ist die php-Funktion mail() voreingestellt. "
                    . "Soweit von Ihnen gewünscht, können Sie nach dem Upgrade unter admin --> E-Mail Settings PHPMailer auswählen und die dafür notwendigen Einstellungen vornehmen.';";


#****************************************************************************
#*  Translation text for all staff pages
#****************************************************************************
$trans["adminStaff_Staffmember"]               = "\$text = 'Mitarbeiter,';";
$trans["adminStaff_Return"]                    = "\$text = 'kehre zur Mitarbeiterliste zurück';";
$trans["adminStaff_Yes"]                       = "\$text = 'Ja';";
$trans["adminStaff_No"]                        = "\$text = 'Nein';";


#****************************************************************************
#*  Translation text for page staff_del.php
#****************************************************************************
$trans["adminStaff_delDeleted"]                = "\$text = ', wurde gelöscht.';";

#****************************************************************************
#*  Translation text for page staff_delete_confirm.php
#****************************************************************************
$trans["adminStaff_del_confirmConfirmText"]    = "\$text = 'Sind Sie sicher folgenden Mitarbeiter zu löschen: ';";

#****************************************************************************
#*  Translation text for page staff_edit.php
#****************************************************************************
$trans["adminStaff_editUpdated"]               = "\$text = ', wurde aktualisiert.';";

#****************************************************************************
#*  Translation text for page staff_edit_form.php
#****************************************************************************
$trans["adminStaff_edit_formHeader"]           = "\$text = 'Bearbeite Mitarbeiterinformationen:';";
$trans["adminStaff_edit_formLastname"]         = "\$text = 'Nachname:';";
$trans["adminStaff_edit_formFirstname"]        = "\$text = 'Vorname:';";
$trans["adminStaff_edit_formLogin"]            = "\$text = 'Benutzername:';";
$trans["adminStaff_edit_email"]                = "\$text = 'E-Mail:';";
$trans["adminStaff_edit_formAuth"]             = "\$text = 'Befugnisse:';";
$trans["adminStaff_edit_formCirc"]             = "\$text = 'Ausleihe';";
$trans["adminStaff_edit_formUpdatemember"]     = "\$text = 'Benutzer bearb.';";
$trans["adminStaff_edit_formCatalog"]          = "\$text = 'Katalog.';";
$trans["adminStaff_edit_formAdmin"]            = "\$text = 'Admin';";
$trans["adminStaff_edit_formReports"]          = "\$text = 'Berichte';";
$trans["adminStaff_edit_formSuspended"]        = "\$text = 'Deakt.:';";

#****************************************************************************
#*  Translation text for page staff_list.php
#****************************************************************************
$trans["adminStaff_list_formHeader"]           = "\$text = 'Füge neue Mitarbeiter hinzu';";
$trans["adminStaff_list_Columnheader"]         = "\$text = ' Mitarbeiter:';";
$trans["adminStaff_list_Function"]             = "\$text = 'Funktionen';";
$trans["adminStaff_list_Pwd"]                  = "\$text = 'Passw.';";
$trans["adminStaff_list_Del"]                  = "\$text = 'Lösche';";

#****************************************************************************
#*  Translation text for page staff_new.php
#****************************************************************************
$trans["adminStaff_new_Added"]                 = "\$text = ', wurde hinzugefügt.';";
$trans["errNoPwdForgottenCode"]                = "\$text = 'Es konnte kein Kennwort-Code erstellt werden!';";
$trans["staffNewMailingSuccessful"]            = "\$text='Willkommen-Mail mit Passwort-Erstellung wurde erfolgreich versandt.';";
$trans["errMailCouldNotBeSent"]                = "\$text = 'Nachricht konnte nicht versendet werden.';";

#****************************************************************************
#*  Translation text for page staff_new_form.php
#****************************************************************************
$trans["adminStaff_new_form_Header"]           = "\$text = 'Füge neuen Mitarbeiter hinzu:';";
$trans["admin_new_form_TypeOfPwdCreation"]     = "\$text = 'Kennwort-Erstellung per Mail?&nbsp;';";
$trans["admin_new_form_TypeOfPwdCreationInfo"] = "\$text = 'Bei Hinterlegung einer gültigen E-Mail-Adresse, kann per Mail eine Willkommensnachricht "
                                                                . "versandt werden mit einem Link zur Erstellung eines eigenen Kennwortes.';";
$trans["adminStaff_new_form_Password"]         = "\$text = 'Kennwort:';";
$trans["adminStaff_new_form_Reenterpassword"]  = "\$text = 'Kennwort wiederholen:';";
$trans["adminStaffPwdRequirement"]             = "\$text = 'Regeln: Kennwort muss zwischen 8 bis 20 Zeichen lang sein, "
        . "mindestens 1 Ziffer, <br />1 Groß- und 1 Kleinbuchstaben und 1 Sonderzeichen (erlaubt: @_#§%$) enthalten.<br />';";

#****************************************************************************
#*  Translation text for page staff_pwd_reset.php
#****************************************************************************
$trans["adminStaff_pwd_reset_Passwordreset"]   = "\$text = 'Kennwort wurde geändert.';";

#****************************************************************************
#*  Translation text for page staff_pwd_reset_form.php
#****************************************************************************
$trans["adminStaff_pwd_reset_form_Resetheader"] = "\$text = 'Ändere Mitarbeiter Kennwort:';";

#****************************************************************************
#*  Translation text for theme pages
#****************************************************************************
$trans["adminTheme_Return"]                    = "\$text = 'kehre zur Layoutliste zurück';";
$trans["adminTheme_Theme"]                     = "\$text = 'Layout, ';";

#****************************************************************************
#*  Translation text for page theme_del.php
#****************************************************************************
$trans["adminTheme_Deleted"]                   = "\$text = ', wurde gelöscht.';";
#****************************************************************************
#*  Translation text for page theme_del_confirm.php
#****************************************************************************
$trans["adminTheme_Deleteconfirm"]             = "\$text = 'Sind Sie sicher folgendes Layout zu löschen: ';";
#****************************************************************************
#*  Translation text for page theme_edit.php
#****************************************************************************
$trans["adminTheme_Updated"]                   = "\$text = ', wurde aktualisiert.';";

#****************************************************************************
#*  Translation text for page theme_edit_form.php
#****************************************************************************
$trans["adminTheme_Preview"]                   = "\$text = 'Vorschau des Layouts';";

#****************************************************************************
#*  Translation text for page theme_list.php
#****************************************************************************
$trans["adminTheme_Changetheme"]               = "\$text = 'Bearbeite benutzes Layout:';";
$trans["adminTheme_Choosetheme"]               = "\$text = 'Wähle ein neues Layout aus:';";
$trans["adminTheme_Addnew"]                    = "\$text = 'Füge neues Layout hinzu';";
$trans["adminTheme_themes"]                    = "\$text = 'Layouts:';";
$trans["adminTheme_function"]                  = "\$text = 'Funktionen';";
$trans["adminTheme_Themename"]                 = "\$text = 'Layout Name';";
$trans["adminTheme_Usage"]                     = "\$text = 'Benutzung';";
$trans["adminTheme_Copy"]                      = "\$text = 'Kopiere';";
$trans["adminTheme_Del"]                       = "\$text = 'Lösche';";
$trans["adminTheme_Inuse"]                     = "\$text = 'benutzt';";
$trans["adminTheme_Note"]                      = "\$text = '*Bemerkung:';";
$trans["adminTheme_Notetext"]                  = "\$text = 'Layouts die gerade benutzt werden können nicht gelöscht werden.';";

#****************************************************************************
#*  Translation text for page theme_list.php
#****************************************************************************
$trans["adminTheme_Theme2"]                    = "\$text = 'Layout:';";
$trans["adminTheme_Tablebordercolor"]          = "\$text = 'Tabellenrahmen Farbe:';";
$trans["adminTheme_Errorcolor"]                = "\$text = 'Fehler Farbe:';";
$trans["adminTheme_Tableborderwidth"]          = "\$text = 'Tabellenrahmen Breite:';";
$trans["adminTheme_Tablecellpadding"]          = "\$text = 'Tabellenzellen Innenabstand:';";
$trans["adminTheme_Title"]                     = "\$text = 'Titelzeile';";
$trans["adminTheme_Mainbody"]                  = "\$text = 'Hauptfenster';";
$trans["adminTheme_Navigation"]                = "\$text = 'Navigation';";
$trans["adminTheme_Tabs"]                      = "\$text = 'Reiter';";
$trans["adminTheme_Backgroundcolor"]           = "\$text = 'Hintergrundfarbe:';";
$trans["adminTheme_Fontface"]                  = "\$text = 'Schriftart:';";
$trans["adminTheme_Fontsize"]                  = "\$text = 'Schriftgröße:';";
$trans["adminTheme_Bold"]                      = "\$text = 'Dick';";
$trans["adminTheme_Fontcolor"]                 = "\$text = 'Schriftfarbe:';";
$trans["adminTheme_Linkcolor"]                 = "\$text = 'Linkfarbe:';";
$trans["adminTheme_Align"]                     = "\$text = 'Ausrichtung:';";
$trans["adminTheme_Right"]                     = "\$text = 'Rechts';";
$trans["adminTheme_Left"]                      = "\$text = 'Links';";
$trans["adminTheme_Center"]                    = "\$text = 'Mitte';";

$trans["adminTheme_HeaderWording"]             = "\$text = 'Bearbeite';";

#****************************************************************************
#*  Translation text for page theme_new.php
#****************************************************************************
$trans["adminTheme_new_Added"]                 = "\$text = ', wurde hinzugefügt.';";

#****************************************************************************
#*  Translation text for page theme_new_form.php
#****************************************************************************

#****************************************************************************
#*  Translation text for page theme_preview.php
#****************************************************************************
$trans["adminTheme_preview_Themepreview"]    = "\$text = 'Layout Vorschau';";
$trans["adminTheme_preview_Librarytitle"]    = "\$text = 'Bibliotheksname';";
$trans["adminTheme_preview_CloseWindow"]     = "\$text = 'Schließe Fenster';";
$trans["adminTheme_preview_Home"]            = "\$text = 'Start';";
$trans["adminTheme_preview_Circulation"]     = "\$text = 'Ausleihe';";
$trans["adminTheme_preview_Cataloging"]      = "\$text = 'Katalogisierung';";
$trans["adminTheme_preview_Admin"]           = "\$text = 'Admin';";
$trans["adminTheme_preview_Samplelink"]      = "\$text = 'Beispiel Link';";
$trans["adminTheme_preview_Thisstart"]       = "\$text = 'Dieses ist eine Vorschau des ';";
$trans["adminTheme_preview_Thisend"]         = "\$text = 'Layout.';";
$trans["adminTheme_preview_Samplelist"]      = "\$text = 'Beispiel-Liste:';";
$trans["adminTheme_preview_Tableheading"]    = "\$text = 'Tabellenkopf';";
$trans["adminTheme_preview_Sampledatarow1"]  = "\$text = 'Beispiel Datezeile 1';";
$trans["adminTheme_preview_Sampledatarow2"]  = "\$text = 'Beispiel Datezeile 2';";
$trans["adminTheme_preview_Sampledatarow3"]  = "\$text = 'Beispiel Datezeile 3';";
$trans["adminTheme_preview_Samplelink"]      = "\$text = 'Beispiel Link';";
$trans["adminTheme_preview_Sampleerror"]     = "\$text = 'Beispiel Fehler';";
$trans["adminTheme_preview_Sampleinput"]     = "\$text = 'Beispiel Eingabe';";
$trans["adminTheme_preview_Samplebutton"]    = "\$text = 'Beispiel Knopf';";
$trans["adminTheme_preview_Poweredby"]       = "\$text = 'Powered by OpenBiblio';";
$trans["adminTheme_preview_Copyright"]       = "\$text = 'Copyright &copy; 2002-2005 Dave Stevens';";
$trans["adminTheme_preview_underthe"]        = "\$text = 'under the';";
$trans["adminTheme_preview_GNU"]             = "\$text = 'GNU General Public License';";

#****************************************************************************
#*  Translation text for page theme_use.php
#****************************************************************************

#****************************************************************************
#*  Translation text for Checkout Privs
#****************************************************************************
$trans["Privileges updated"]                = "\$text = 'Einstellungen geändert';";
$trans["Edit Checkout Privileges"]          = "\$text = 'Ausleiheinstellungen bearbeiten';";
$trans["Material Type:"]                    = "\$text = 'Medienart:';";
$trans["Member Classification:"]            = "\$text = 'Mitgliederart:';";
$trans["Checkout Limit:"]                   = "\$text = 'Ausleihlimit:';";
$trans["Renewal Limit:"]                    = "\$text = 'Verlängerunsglimit:';";
$trans["Checkout Privileges"]               = "\$text = 'Ausleiheinstellungen';";
$trans["Material Type"]                     = "\$text = 'Medienart';";
$trans["Member Classification"]             = "\$text = 'Mitgliederart';";
$trans["Checkout Limit"]                    = "\$text = 'Ausleihlimit';";
$trans["Renewal Limit"]                     = "\$text = 'Verlängerungslimit';";

#****************************************************************************
#*  Translation text for Copy Fields 
#****************************************************************************

$trans["Copy field, %desc%, has been deleted."] = "\$text = 'Exemplarfeld, %desc%, wurde gelöscht.';";
$trans["return to copy field list"]             = "\$text = 'Zurück zur Exemplarfeldliste';";
$trans["return to copy fields list"]            = "\$text = 'Zurück zur Exemplarfeldliste';";
$trans["Are you sure you want to delete field '%desc%'?"] = "\$text = 'Sind Sie sicher, dass sie das Feld \'%desc%\' löschen wollen?';";
$trans["Copy field, %desc%, has been updated."] = "\$text = 'Exemplarfeld, %desc%, wurde aktualisiert.';";
$trans["Edit Copy Field"]                       = "\$text = 'Bearbeite Exemplarfeld';";
$trans["Code:"]                                 = "\$text = 'Kennzeichen:';";
$trans["Description:"]                          = "\$text = 'Beschreibung:';";
$trans["Add new custom field"]                  = "\$text = 'Füge neues spezifisches Feld hinzu';";
$trans["Custom Copy Fields"]                    = "\$text = 'Spezifisches Exemplarfeld';";
$trans["Code"]                                  = "\$text = 'Kennzeichen';";
$trans["Description"]                           = "\$text = 'Beschreibung';";
$trans["del"]                                   = "\$text = 'Löschen';";
$trans["Copy field, %desc%, has been added."]   = "\$text = 'Exemplarfeld, %desc%, wurde hinzugefügt.';";
$trans["Add custom copy field"]                 = "\$text = 'Füge spezifisches Exemplarfeld hinzu';";

#****************************************************************************
#*  Translation text for Member Classify 
#****************************************************************************

$trans["Classification type, %desc%, has been deleted."] = "\$text = 'Mitgliederart, %desc%, wurde gelöscht.';";
$trans["return to member classification list"]           = "\$text = 'Zurück zur Liste der Mitgliederarten';";
$trans["Are you sure you want to delete classification '%desc%'?"] = "\$text = 'Sind Sie sicher die Mitgliederart \'%desc%\' zu löschen?';";
$trans["Classification type, %desc%, has been updated."] = "\$text = 'Mitgliederart, %desc%, wurde aktualisiert.';";
$trans["Edit Classification Type"]                       = "\$text = 'Bearbeite Mitgliederart';";
$trans["Max. Fines:"]                                    = "\$text = 'Max. Gebühren:';";
$trans["Add new member classification"]                  = "\$text = 'Neue Mitgliederart hinzufügen';";
$trans["Member Classifications List"]                    = "\$text = 'Liste der Mitgliederarten';";
$trans["Max. Fines"]                                     = "\$text = 'Max. Gebühren';";
$trans["Members"]                                        = "\$text = 'Mitglieder';";
$trans["*Note:"]                                         = "\$text = '*Bemerkung:';";
$trans["The delete function is only available on classifications that have a member count of zero.  If you wish to delete a classification with a member count greater than zero you will first need to change those members to another classification."]     = "\$text = 'Die Löschfunktion ist nur verfügbar, bei Mitgliederarten, die keine Mitglieder haben. Wenn Sie eine Mitgliederart löschen möchten, die mehr als Null Mitglieder haben, dann müssen Sie diese Mitglieder erst in eine andere Mitgliederart verschieben.';";
$trans["Classification type, %desc%, has been added."]   = "\$text = 'Mitgliederart, %desc%, wurde hinzugefügt.';";
$trans["Add new classification type"]                    = "\$text = 'Füge neue Mitgliederart hinzu';";

#****************************************************************************
#*  Translation text for Member Fields
#****************************************************************************

$trans["Member field, %desc%, has been deleted."] = "\$text = 'Mitgliederfeld, %desc%, wurde gelöscht.';";
$trans["return to member field list"]             = "\$text = 'Zurück zur Mitgliederfeldliste';";
$trans["return to member fields list"]            = "\$text = 'Zurück zur Mitgliederfeldliste';";
$trans["Member field, %desc%, has been updated."] = "\$text = 'Mitgliederfeld, %desc%, wurde aktualisiert.';";
$trans["Edit Member Field"]                       = "\$text = 'Bearbeite Mitgliederfeld';";
$trans["Custom Member Fields"]                    = "\$text = 'Spezifisches Mitgliederfeld';";
$trans["Member field, %desc%, has been added."]   = "\$text = 'Mitgliederfeld, %desc%, wurde hinzugefügt.';";
$trans["Add custom member field"]                 = "\$text = 'Füge spezifisches Mitgliederfeld hinzu';";

#****************************************************************************
#*  Translation text for install/maintenance.php
#****************************************************************************

$trans["MaintenanceMode"]                        = "\$text = 'Wartungsmodus';";
$trans["MaintenanceExplication"]                 = "\$text = 'Ihre Openbiblio befindet sich zurzeit im Wartungsmodus.
Bitte warten Sie die Wartung ab. Sollte diese länger andauern, kontaktieren Sie die Verantwortlichen.';";

#****************************************************************************
#*  Translation text for install/index.php, upgradeSettings.php
#****************************************************************************

$trans["DBConnection"]                           = "\$text = 'Datenbank-Verbindung ist in Ordnung.';";
$trans["NoActionRequired"]                       = "\$text = 'Es ist keine weitere Aktion erforderlich.';";
$trans["OpenbiblioUpToDate"]                     = "\$text = 'Openbiblio-Installation ist aktuell.';";
$trans["startUsingOpenBiblio"]                   = "\$text = 'OpenBiblio jetzt starten.';";
$trans["UpdateDatabaseInfo"]                     = "\$text = 'Es sieht so aus, als müssten wir die Datenbankversion "
                                                            . "aktualisieren %oldDBversion% zu Version %newDBversion%.';";
$trans["BackupDatabase"]                         = "\$text = 'WARNUNG - Bitte sichern Sie Ihre Datenbank vor der Aktualisierung.';";
$trans["MaintenanceAccess"]                      = "\$text = 'Administratorzugang für Upgrade von Openbiblio';";
$trans["UpgradeKey"]                             = "\$text = 'Upgrade-Schlüssel';";
$trans["UpgradeSuspended"]                             = "\$text = 'Aufgrund zu häufiger Fehleingabe des Update-Schlüssels ist das weitere Vorgehen gesperrt.
Um einen neuen Versuch starten zu können, empfiehlt es sich die Sitzung zu beenden und den Browser zu schließen.';";
$trans["admin_MailSender_explication"]                             = "\$text = 'Die hier hinterlegte E-Mail-Adresse wird als Absender für die E-Mails für die neuangelegten Mitteilungen "
                                                    . "\"Passwort vergessen\" und \"Passwort für neue Bibliotheksmitglieder\" verwendet.<br />"
                                                    . "Änderung der Mail-Adresse oder der jeweiligen Mitteilungen oder der Einsatz unterschiedlicher E-Mail-Adressen bei den jeweiligen "
                                                    . "Mitteilungen können unter \"Admin\" --> \"Mail-Nachrichten\" vorgenommen werden.';";

#****************************************************************************
#*  Translation text for install/index.php
#****************************************************************************

$trans["OpenBiblioUpgrade"]                      = "\$text = 'OpenBiblio Upgrade';";
$trans["UpdateOpenBiblioTables"]                 = "\$text = 'Aktualisierung der OpenBiblio-Tabellen, bitte warten...';";
$trans["UpgradeFailed"]                          = "\$text = 'Upgrade fehlgeschlagen!';";
$trans["UpdateSuccessfully"]                     = "\$text = 'Die OpenBiblio-Tabellen wurden erfolgreich aktualisiert!';";

#****************************************************************************
#*  Translation text for page email_settings_edit_form.php 
#****************************************************************************
$trans["admin_mailSettingsUpdated"]              = "\$text = 'Die Daten wurden aktualisiert.';";
$trans["admin_mailSettingsEditsettings"]         = "\$text = 'Bearbeite E-Mail-Einstellungen:';";
$trans["admin_PwdForgottenTitle"]                = "\$text = 'Einstellungen für Kennwort-Vergessen-Funktion';";
$trans["admin_PwdForgottenSettings"]             = "\$text = 'Kennwort-Vergessen-Funktion:';";
$trans["admin_PwdForgottenNone"]                 = "\$text = 'deaktivieren';";
$trans["admin_PwdForgottenOr"]                   = "\$text = 'Eingabe von Mail oder Benutzernummer';";
$trans["admin_PwdForgottenAnd"]                  = "\$text = 'Eingabe von Mail und Benutzernummer';";
$trans["admin_PwdForgottenCodeDuration"]         = "\$text = 'Gültigkeit des Kennw.-Vergessen-Code:';";
$trans["admin_Duration"]                         = "\$text = 'Stunde(n)';";
$trans["admin_mailSettingTitle"]                 = "\$text = 'Einstellungen für Mail-Versand';";
$trans["admin_mailProcess"]                      = "\$text = 'Prozessart für Mailversand:';";
$trans["admin_mailHost"]                         = "\$text = 'E-Mail-Server:';";
$trans["admin_mailUser"]                         = "\$text = 'E-Mail-Nutzername:';";
$trans["admin_mailPwd"]                          = "\$text = 'E-Mail-Kennwort:';";
$trans["admin_mailSmtpSecure"]                   = "\$text = 'E-Mail-Verschlüsselung:';";

#****************************************************************************
#*  Translation text for page email_messages_list.php 
#****************************************************************************
$trans["password_forgotten_message"]             = "\$text = 'Kennwort-Vergessen-Nachricht';";
$trans["welcome_message"]                        = "\$text = 'Willkommensnachricht mit Passwort-setzen-Link';";
$trans["admin_mailMessage"]                      = "\$text = 'Nachrichten';";

#****************************************************************************
#*  Translation text for page email_messages_edit_form.php 
#***********************text*****************************************************
$trans["admin_mailMessage_edit"]                 = "\$text = 'Bearbeite %message%:';";
$trans["admin_mailHtml"]                         = "\$text = 'Mail im HTML- oder Plain-Text-Format:';";
$trans["admin_mailFromMail"]                     = "\$text = 'Absender-Mail-Adresse:';";
$trans["admin_mailFromName"]                     = "\$text = 'Absendername:';";
$trans["admin_mailSubject"]                      = "\$text = 'Betreff:';";
$trans["admin_mailBodyHtml"]                     = "\$text = 'Mail-Text im HTML-Format';";
$trans["admin_mailBodyPlain"]                    = "\$text = 'Mail-Text im Text-Format';";
$trans["admin_mailBodyInfo"]                     = "\$text = 'Folgende Variablen konnen in den Mail-Texten im HTML-/Text-Format verwendet werden:<br />"
                                                            . "%LastName% = Nachname, %FirstName% = Vorname, "
                                                            . "%PwdForgottenCodeDuration% = Gültigkeitsdauer des Passwort-Vergessen-Codes, "
                                                            . "%url_pwdcode% = URL für die Seite zum Setzen des neuen Passwortes';";

?>
