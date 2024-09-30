<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/**
 * ********************************************************************************
 * Instructions for translators:
 *
 * All gettext key/value pairs are specified as follows:
 * $trans["key"] = "<php translation code to set the $text variable>";
 * Allowing translators the ability to execute php code withint the transFunc string
 * provides the maximum amount of flexibility to format the languange syntax.
 *
 * Formatting rules:
 * - Resulting translation string must be stored in a variable called $text.
 * - Input arguments must be surrounded by % characters (i.e. %pageCount%).
 * - A backslash ('\') needs to be placed before any special php characters
 * (such as $, ", etc.) within the php translation code.
 *
 * Simple Example:
 * $trans["homeWelcome"] = "\$text='Welcome to OpenBiblio';";
 *
 * Example Containing Argument Substitution:
 * $trans["searchResult"] = "\$text='page %page% of %pages%';";
 *
 * Example Containing a PHP If Statment and Argument Substitution:
 * $trans["searchResult"] =
 * "if (%items% == 1) {
 * \$text = '%items% result';
 * } else {
 * \$text = '%items% results';
 * }";
 *
 * *********************************************************************************
 */

# ****************************************************************************
# * Common translation text shared among multiple pages
# ****************************************************************************
$trans["circCancel"] = "\$text = 'Abbrechen';";
$trans["circDelete"] = "\$text = 'Löschen';";
$trans["circLogout"] = "\$text = 'Ausloggen';";
$trans["circAdd"] = "\$text = 'Hinzufügen';";
$trans["mbrDupBarcode"] = "\$text = 'Mediennummer, %barcode%, ist schon in Benutzung.';";

# ****************************************************************************
# * Translation text for page index.php
# ****************************************************************************
$trans["indexHeading"] = "\$text='Ausleihe';";
$trans["indexCardHdr"] = "\$text='Suche Benutzer nach Benutzernummer:';";
$trans["indexCard"] = "\$text='Benutzernummer:';";
$trans["indexSearch"] = "\$text='Suche';";
$trans["indexNameHdr"] = "\$text='Suche Benutzer nach Nachname:';";
$trans["indexName"] = "\$text='Nachname beginnt mit:';";

# ****************************************************************************
# * Translation text for page mbr_new_form.php, mbr_edit_form.php and mbr_fields.php, mbr_search.php
# ****************************************************************************
$trans["Mailing Address:"] = "\$text='Postanschrift:';";
$trans["mbrNewForm"] = "\$text='Füge hinzu neuen ';";
$trans["mbrEditForm"] = "\$text='Bearbeite ';";
$trans["mbrFldsHeader"] = "\$text='Benutzer:';";
$trans["mbrFldsCardNmbr"] = "\$text='Benutzernummer:';";
$trans["mbrFldsLastName"] = "\$text='Nachname:';";
$trans["mbrFldsFirstName"] = "\$text='Vorname:';";
$trans["mbrFldsAddr1"] = "\$text='Adresszeile 1:';";
$trans["mbrFldsAddr2"] = "\$text='Adresszeile 2:';";
$trans["mbrFldsCity"] = "\$text='Stadt:';";
$trans["mbrFldsStateZip"] = "\$text='Bundesland, PLZ:';";
$trans["mbrFldsHomePhone"] = "\$text='Telefon (heim):';";
$trans["mbrFldsWorkPhone"] = "\$text='Telefon (Arbeit):';";
$trans["mbrFldsEmail"] = "\$text='E-Mail-Adresse:';";
$trans["mbrFldsClassify"] = "\$text='Klassifikation:';";
$trans["mbrFldsGrade"] = "\$text='Schulklasse:';";
$trans["mbrFldsTeacher"] = "\$text='Klassenlehrer:';";
$trans["mbrFldsMbrShip"] = "\$text='bezahlt bis (jjjj-mm-dd):';";
$trans["mbrFldsSubmit"] = "\$text='Übermitteln';";
$trans["mbrFldsCancel"] = "\$text='Abbrechen';";
$trans["mbrsearchResult"] = "\$text='Ergebnisseiten: ';";
$trans["mbrsearchprev"] = "\$text='vor';";
$trans["mbrsearchnext"] = "\$text='weiter';";
$trans["First"] = "\$text='Anfang';";
$trans["Last"] = "\$text='Ende';";
$trans["mbrsearchNoResults"] = "\$text='Keine Ergebnisse gefunden.';";
$trans["mbrsearchFoundResults"] = "\$text=' Ergebnisse gefunden.';";
$trans["mbrsearchSearchResults"] = "\$text='Suchergebnisse:';";
$trans["mbrsearchCardNumber"] = "\$text='Benutzernummer:';";
$trans["mbrsearchClassification"] = "\$text='Klassifikation:';";
$trans["PwdRequirement"]                = "\$text = 'Regeln: Kennwort muss zwischen 8 bis 20 Zeichen lang sein, "
        . "mindestens 1 Ziffer, <br />1 Groß- und 1 Kleinbuchstaben und 1 Sonderzeichen (erlaubt: @_#§%$) enthalten.<br />';";
$trans["PwdRequirementErr"]  = "\$text = 'Kennwort muss mindestens 8 Zeichen, davon mindestens 1 Ziffer, 1 Groß- und 1 Kleinbuchstaben und 1 Sonderzeichen (erlaubt: @_#§%$) enthalten.';";

# ****************************************************************************
# * Translation text for page mbr_new.php (and mbr_view.php)
# ****************************************************************************´
$trans["mbr_new_form_TypeOfPwdCreation"]        = "\$text = 'Kennwort-Erstellung per Mail?&nbsp;';";
$trans["mbr_new_form_TypeOfPwdCreationInfo"]    = "\$text = 'Bei Hinterlegung einer gültigen E-Mail-Adresse, kann per Mail eine Willkommensnachricht "
                                                                . "versandt werden mit einem Link zur Erstellung eines eigenen Kennwortes.';";
$trans["mbr_new_form_Password"]                 = "\$text = 'Kennwort:';";
$trans["mbr_new_form_Reenterpassword"]          = "\$text = 'Kennwort wiederholen:';";
$trans["errNoPwdForgottenCode"]                 = "\$text = 'Es konnte kein Kennwort-Code erstellt werden!';";
$trans["mbrNewSuccess"]                         = "\$text='Benutzer wurde erfolgreich hinzugefügt.';";
$trans["mbrNewMailingSuccessful"]               = "\$text='Willkommen-Mail mit Passwort-Erstellung wurde erfolgreich versandt.';";
$trans["errMailCouldNotBeSent"]                 = "\$text = 'Nachricht konnte nicht versendet werden.';";
$trans["mbrNoPassword"]                         = "\$text = '<p style=\"font-weight: bold; color: red;\";>Kein Kennwort gesetzt!</p>';";

# ****************************************************************************
# * Translation text for page mbr_edit.php
# ****************************************************************************
$trans["mbrEditSuccess"] = "\$text='Benutzer wurde erfolgreich aktualisiert.';";
$trans["mbrRenewSuccess"] = "\$text='Die Mitgliedschaft wurde erfolgreich um %length% Monate verlängert.';";
$trans["All items renewed."] = "\$text='Alle Medien verlängert.';";

# ****************************************************************************
# * Translation text for page mbr_view.php
# ****************************************************************************
$trans["mbrViewHead1"] = "\$text='Benutzerinformation';";
$trans["mbrViewName"] = "\$text='Name:';";
$trans["mbrViewAddr"] = "\$text='Adresse:';";
$trans["mbrViewCardNmbr"] = "\$text='Benutzernummer:';";
$trans["mbrViewClassify"] = "\$text='Klassifikation:';";
$trans["mbrViewPhone"] = "\$text='Telefon:';";
$trans["mbrViewPhoneHome"] = "\$text='P:';";
$trans["mbrViewPhoneWork"] = "\$text='A:';";
$trans["mbrViewEmail"] = "\$text='E-Mail-Adresse:';";
$trans["mbrViewGrade"] = "\$text='Schulklasse:';";
$trans["mbrViewTeacher"] = "\$text='Klassenlehrer:';";
$trans["mbrViewMbrShipEnd"] = "\$text='bezahlt bis:';";
$trans["mbrViewMbrShipNoEnd"] = "\$text='unendlich/nicht benutzt';";
$trans["mbrViewHead2"] = "\$text='Ausleih-Status';";
$trans["mbrViewStatColHdr1"] = "\$text='Medienart';";
$trans["mbrViewStatColHdr2"] = "\$text='Anzahl';";
$trans["mbrViewStatColHdr3"] = "\$text='Limits';";
$trans["mbrViewStatColHdr4"] = "\$text='Ausleihe';";
$trans["mbrViewStatColHdr5"] = "\$text='Verlängerung';";
$trans["mbrViewHead3"] = "\$text='Medienausleihe';";
$trans["mbrViewBarcode"] = "\$text='Mediennummer:';";
$trans["mbrViewCheckOut"] = "\$text='Ausleihen';";
$trans["mbrViewHead4"] = "\$text='Derzeit ausgeliehene Medien:';";
$trans["mbrViewOutHdr1"] = "\$text='Ausgeliehen';";
$trans["mbrViewOutHdr2"] = "\$text='Medienart';";
$trans["mbrViewOutHdr3"] = "\$text='Mediennummer';";
$trans["mbrViewOutHdr4"] = "\$text='Titel';";
$trans["mbrViewOutHdr5"] = "\$text='Autor';";
$trans["mbrViewOutHdr6"] = "\$text='Rückgabe';";
$trans["mbrViewOutHdr7"] = "\$text='überfällige<br>Tage';";
$trans["mbrViewOutHdr8"] = "\$text='Verlängerungen';";
$trans["mbrViewOutHdr9"] = "\$text='Mal';";
$trans["mbrViewOutHdr10"] = "\$text='Rückgabe';";
$trans["To Shelving Cart"] = "\$text='In Eingangsablage';";
$trans["Renew item"] = "\$text='Verlängere Medium';";
$trans["mbrViewNoCheckouts"] = "\$text='Derzeit keine Medien ausgeliehen.';";
$trans["mbrViewHead5"] = "\$text='Vorbestellen:';";
$trans["mbrViewHead6"] = "\$text='Derzeit vorbestellte Medien:';";
$trans["mbrViewPlaceHold"] = "\$text='Vorbestellen';";
$trans["mbrViewHoldHdr1"] = "\$text='Funktion';";
$trans["mbrViewHoldHdr2"] = "\$text='Vorbestellt';";
$trans["mbrViewHoldHdr3"] = "\$text='Medienart';";
$trans["mbrViewHoldHdr4"] = "\$text='Mediennummer';";
$trans["mbrViewHoldHdr5"] = "\$text='Titel';";
$trans["mbrViewHoldHdr6"] = "\$text='Autor';";
$trans["mbrViewHoldHdr7"] = "\$text='Status';";
$trans["mbrViewHoldHdr8"] = "\$text='Rückgabe';";
$trans["mbrViewNoHolds"] = "\$text='Derzeit keine Medien vorbestellt.';";
$trans["mbrViewBalMsg"] = "\$text='Bemerkung: Benutzer hat ausstehende Gebühren von %bal%.';";
$trans["mbrViewShipEnd"] = "\$text='Achtung: Die Mitgliedschaft des Mitglieds ist abgelaufen!';";
$trans["mbrPrintCheckouts"] = "\$text='Ausgeliehene Medien drucken';";
$trans["Renew All"] = "\$text='Alle Medien verlängern';";
$trans["mbrViewDel"] = "\$text='Lösche';";
$trans["mbrViewRenew1"] = "\$text='Verlängere Mitgliedschaft um';";
$trans["mbrViewRenew2"] = "\$text='Monat(e).<br>Ab heute bzw. ab dem Bezahlt-bis-Datum, wenn es in der Zukunft liegt.';";
$trans["Due Date:"] = "\$text='Rückgabedatum';";
$trans["Override Due Date"] = "\$text='Rückgabedatum manuell ändern';";
$trans["Cancel"] = "\$text='Abbrechen';";

# ****************************************************************************
# * Translation text for page checkout.php
# ****************************************************************************
$trans["checkoutBalErr"] = "\$text='Der Benutzer muß ausstehende Gebühren zahlen, bevor er ausleihen darf.';";
$trans["checkoutEndErr"] = "\$text='Der Benutzer muß die Mitgliedschaft verlängern, bevor er ausleihen darf.';";
$trans["checkoutErr1"] = "\$text='Die Mediennummer darf nur aus Zahlen und Buchstaben bestehen.';";
$trans["checkoutErr2"] = "\$text='Kein Medium mit dieser Nummer wurde gefunden.';";
$trans["checkoutErr3"] = "\$text='Das Medium mit der Nummer %barcode% ist bereits ausgeliehen.';";
$trans["checkoutErr4"] = "\$text='Das Medium mit der Nummer %barcode% kann nicht ausgeliehen werden.';";
$trans["checkoutErr5"] = "\$text='Das Medium mit der Nummer %barcode% wurde von einem anderen Benutzer vorbestellt.';";
$trans["checkoutErr6"] = "\$text='Der Benutzer hat das Ausleihlimit für diese Medienart bereits erreicht.';";
$trans["checkoutErr7"] = "\$text='Das Medium mit der Nummer %barcode% kann vom Benutzer nicht nochmal verlängert werden.';";
$trans["checkoutErr8"] = "\$text='Das Medium mit der Nummer %barcode% kann nicht verlängert werden, weil es schon verspätet ist.';";

# ****************************************************************************
# * Translation text for page shelving_cart.php
# ****************************************************************************
$trans["shelvingCartErr1"] = "\$text='Die Mediennummer darf nur aus Zahlen und Buchstaben bestehen.';";
$trans["shelvingCartErr2"] = "\$text='Kein Medium mit dieser Nummer wurde gefunden.';";
$trans["shelvingCartTrans"] = "\$text='Versäumnisgebühr (Nummer=%barcode%)';";

# ****************************************************************************
# * Translation text for page checkin_form.php
# ****************************************************************************
$trans["checkinFormHdr1"] = "\$text='Medienrückgabe:';";
$trans["checkinFormBarcode"] = "\$text='Mediennummer:';";
$trans["checkinFormShelveButton"] = "\$text='Stelle in Eingangsablage';";
$trans["checkinFormCheckinLink1"] = "\$text='Ausgewählte Medien einbuchen';";
$trans["checkinFormCheckinLink2"] = "\$text='Alle Medien einbuchen';";
$trans["checkinFormHdr2"] = "\$text='derzeitiger Inhalt der Eingangsablage:';";
$trans["checkinFormColHdr1"] = "\$text='Rückgabedatum';";
$trans["checkinFormColHdr2"] = "\$text='Mediennummer';";
$trans["checkinFormColHdr3"] = "\$text='Titel';";
$trans["checkinFormColHdr4"] = "\$text='Autor';";
$trans["checkinFormEmptyCart"] = "\$text='Derzeit sind keine Medien im Eingangsregal.';";
$trans["Checked in %barcode% for "] = "\$text='Exemplar %barcode% zurückgenommen von ';";
$trans["Checked in %barcode%."] = "\$text='Exemplar %barcode% zurückgenommen.';";
$trans["checkinEndErr"] = "\$text='Die Mitgliedschaft ist abgelaufen. Das Mitglied muss entweder die Mitgliedschaft verlängern oder für %monthlate% Monate nachzahlen.';";

# ****************************************************************************
# * Translation text for page checkin.php
# ****************************************************************************
$trans["checkinErr1"] = "\$text='Keine Medien wurden ausgewählt.';";

# ****************************************************************************
# * Translation text for page hold_message.php
# ****************************************************************************
$trans["holdMessageHdr"] = "\$text='Medium wurde vorbestellt!';";
$trans["holdMessageMsg1"] = "\$text='Das Medium mit der Mediennummer %barcode% welches Sie einchecken wollen wurde vorbestellt. <b>Bitte das Medium ins Vorbestellfach legen und nicht in die Eingangsablage.</b> Der Statuscode des Medium wurde auf vorbestellt geändert.';";
$trans["holdMessageMsg2"] = "\$text='Kehre zur Medienrückgabe zurück.';";

# ****************************************************************************
# * Translation text for page place_hold.php
# ****************************************************************************
$trans["placeHoldErr1"] = "\$text='Die Mediennummer darf nur aus Zahlen und Buchstaben bestehen.';";
$trans["placeHoldErr2"] = "\$text='Die Mediennummer exitiert nicht.';";
$trans["placeHoldErr3"] = "\$text='Das Mitglied hat dieses Medium bereits ausgeliehen - keine Vorbestellung angelegt.';";
$trans["This item is not checked out or on hold."] = "\$text='Dieses Exemplar ist weder vorbestellt noch ausgeliehen.';";

# ****************************************************************************
# * Translation text for page mbr_del_confirm.php
# ****************************************************************************
$trans["mbrDelConfirmWarn"] = "\$text = 'Der Benutzer, %name%, hat %checkoutCount% Ausleihe(n) und %holdCount% Vorbestellung(en). Alle ausgeliehenen Medien müssen zurückgegeben und alle Vorbestellungen gelöscht werden, um den Benutzer zu löschen.';";
$trans["mbrDelConfirmReturn"] = "\$text = 'Kehre zur Benutzerinformation zurück';";
$trans["mbrDelConfirmMsg"] = "\$text = 'Sind sie sicher, daß sie den Benutzer %name% löschen wollen? Dieses wird auch die Ausleihhistory von ihm löschen.';";

# ****************************************************************************
# * Translation text for page mbr_del.php
# ****************************************************************************
$trans["mbrDelSuccess"] = "\$text='Der Benutzer, %name%, wurde gelöscht.';";
$trans["mbrDelReturn"] = "\$text='kehre zur Benutzersuche zurück';";

# ****************************************************************************
# * Translation text for page mbr_history.php
# ****************************************************************************
$trans["mbrHistoryHead1"] = "\$text='Benutzer Ausleihhistory:';";
$trans["mbrHistoryNoHist"] = "\$text='Keine History gefunden.';";
$trans["mbrHistoryHdr1"] = "\$text='Mediennummer';";
$trans["mbrHistoryHdr2"] = "\$text='Titel';";
$trans["mbrHistoryHdr3"] = "\$text='Autor';";
$trans["mbrHistoryHdr4"] = "\$text='Aktueller Status';";
$trans["mbrHistoryHdr5"] = "\$text='Datum der Statusänderung';";
$trans["mbrHistoryHdr6"] = "\$text='Rückgabedatum';";

# ****************************************************************************
# * Translation text for page mbr_account.php
# ****************************************************************************
$trans["mbrAccountLabel"] = "\$text='Füge eine Transaktion hinzu:';";
$trans["mbrAccountTransTyp"] = "\$text='Transaktions Typ:';";
$trans["mbrAccountAmount"] = "\$text='Betrag:';";
$trans["mbrAccountDesc"] = "\$text='Beschreibung:';";
$trans["mbrAccountHead1"] = "\$text='Transaktionen des Benutzers:';";
$trans["mbrAccountNoTrans"] = "\$text='Keine Transaktionen gefunden.';";
$trans["mbrAccountOpenBal"] = "\$text='Offener Betrag';";
$trans["mbrAccountDel"] = "\$text='Lösche';";
$trans["mbrAccountHdr1"] = "\$text='Funktion';";
$trans["mbrAccountHdr2"] = "\$text='Datum';";
$trans["mbrAccountHdr3"] = "\$text='Trans. Typ';";
$trans["mbrAccountHdr4"] = "\$text='Beschreibung';";
$trans["mbrAccountHdr5"] = "\$text='Betrag';";
$trans["mbrAccountHdr6"] = "\$text='Kontostand';";

# ****************************************************************************
# * Translation text for page mbr_transaction.php
# ****************************************************************************
$trans["mbrTransactionSuccess"] = "\$text='Transaktion erfolgreich durchgeführt.';";

# ****************************************************************************
# * Translation text for page mbr_transaction_del_confirm.php
# ****************************************************************************
$trans["mbrTransDelConfirmMsg"] = "\$text='Sind Sie sicher, daß Sie die Transaktion löschen wollen?';";

# ****************************************************************************
# * Translation text for page mbr_transaction_del.php
# ****************************************************************************
$trans["mbrTransactionDelSuccess"] = "\$text='Transaktion erfolgreich gelöscht.';";

# ****************************************************************************
# * Translation text for page mbr_print_checkouts.php
# ****************************************************************************
$trans["mbrPrintCheckoutsTitle"] = "\$text='Ausleihen von %mbrName%';";
$trans["mbrPrintCheckoutsHdr1"] = "\$text='Aktuelles Datum:';";
$trans["mbrPrintCheckoutsHdr2"] = "\$text='Benutzer:';";
$trans["mbrPrintCheckoutsHdr3"] = "\$text='Benutzernummer:';";
$trans["mbrPrintCheckoutsHdr4"] = "\$text='Klassifikation:';";
$trans["mbrPrintCloseWindow"] = "\$text='Schließe Fenster';";

# ****************************************************************************
# * Translation text for page noauth.php
# ****************************************************************************
$trans["NotAuth"] = "\$text = 'Sie sind nicht berechtigt, diese Funktion im Ausleihbereich zu benutzen.';";

# ****************************************************************************
# * Translation text for page offline.php
# ****************************************************************************
$trans["Upload Offline Circulation"] = "\$text='Offline Ausleihe hochladen';";
$trans["Upload"] = "\$text='Hochladen';";
$trans["Date:"] = "\$text='Datum:';";
$trans["Command File:"] = "\$text='Kommandodatei:';";
$trans["Bad upload file: Expected a command code, but didn't get one"] = "\$text='Fehlerhafte Datei: Kommandocode erwartet, aber keinen erhalten';";
$trans["Couldn't check out %item% to %member%: %error%"] = "\$text='Konnte Exemplar %item% an %member% nicht ausleihen: %error%';";
$trans["Couldn't check in %item%: %error%"] = "\$text='Konnte Exemplar %item% nicht zurücknehmen: %error%';";
$trans["Unrecognized command code: %cmd%"] = "\$text='Nicht erkanntes Kommando: %cmd%';";
$trans["Command Sheet"] = "\$text='Kommandoübersichtsblatt';";
$trans["Actions which did not produce an error have completed. Think carefully before uploading the same file again, or some circulations may be recorded twice."] = "\$text='Eventuell wurden Aktionen die keinen Fehler produzieren ausgeführt. Passen Sie auf, dass Sie keine Datei doppelt hochladen, da sonst einige Ausleihen doppelt erfasst werden.';";
$trans["Errors"] = "\$text='Fehler';";
$trans["Offline Upload Successful."] = "\$text='Offline Hochladeaktion erfolgreich.';";
$trans["Couldn't read file: "] = "\$text='Konnte Datei nicht lesen: ';";

?>
