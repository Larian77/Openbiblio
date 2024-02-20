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
#*  Translation text used on multiple pages
#****************************************************************************
$trans["reportsCancel"]            = "\$text = 'Abbrechen';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'Berichte';";
$trans["indexDesc"]                = "\$text = 'Benutzen Sie Berichte, Etiketten oder Briefe im linken Navigationsbereich um Berichte zu erzeugen oder Etiketten oder Briefe zu drucken.';";
$trans["Report Errors"]            = "\$text = 'Report Fehler';";

#****************************************************************************
#*  Translation text for page report_list.php
#****************************************************************************
$trans["reportListHdr"]            = "\$text = 'Berichte';";
$trans["reportListDesc"]           = "\$text = 'Benutzen Sie bitte einen der folgenden Links um Berichte zu erzeugen.';";
$trans["reportListXmlErr"]         = "\$text = 'Ein Fehler ist aufgetreten beim Lesen der Reportsdefinitionsdatei.';";
$trans["reportListCannotRead"]     = "\$text = 'Kann die Labeldatei %fileName% nicht lesen';";

#****************************************************************************
#*  Translation text for page label_list.php
#****************************************************************************
$trans["labelListHdr"]             = "\$text = 'Etiketten';";
$trans["labelListDesc"]            = "\$text = 'Benutzen Sie bitte einen der folgenden Links um Etiketten im PDF-Format zu erzeugen.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Ein Fehler ist aufgetreten beim Lesen der Reportsdefinitionsdatei. Fehler = ';";

#****************************************************************************
#*  Translation text for page letter_list.php
#****************************************************************************
$trans["letterListHdr"]            = "\$text = 'Briefe';";
$trans["letterListDesc"]           = "\$text = 'Benutzen Sie bitte einen der folgenden Links um Briefe im PDF-Format zu erzeugen.';";
$trans["displayLettersXmlErr"]      = "\$text = 'Ein Fehler ist aufgetreten beim Lesen der Reportsdefinitionsdatei. Fehler = ';";

#****************************************************************************
#*  Translation text for page report_criteria.php
#****************************************************************************
$trans["reportCriteriaHead1"]      = "\$text = 'Suchkriterien (optional)';";
$trans["reportCriteriaHead2"]      = "\$text = 'Sortierreihenfolge (optional)';";
$trans["reportCriteriaHead3"]      = "\$text = 'Report AusgabeTyp';";
$trans["reportCriteriaCrit1"]      = "\$text = 'Kriterium 1:';";
$trans["reportCriteriaCrit2"]      = "\$text = 'Kriterium 2:';";
$trans["reportCriteriaCrit3"]      = "\$text = 'Kriterium 3:';";
$trans["reportCriteriaCrit4"]      = "\$text = 'Kriterium 4:';";
$trans["reportCriteriaEQ"]         = "\$text = '=';";
$trans["reportCriteriaNE"]         = "\$text = 'nicht =';";
$trans["reportCriteriaLT"]         = "\$text = '&lt;';";
$trans["reportCriteriaGT"]         = "\$text = '&gt;';";
$trans["reportCriteriaLE"]         = "\$text = '&lt oder =';";
$trans["reportCriteriaGE"]         = "\$text = '&gt oder =';";
$trans["reportCriteriaBT"]         = "\$text = 'between';";
$trans["reportCriteriaAnd"]        = "\$text = 'und';";
$trans["reportCriteriaRunReport"]  = "\$text = 'Bericht erzeugen';";
$trans["reportCriteriaSortCrit1"]  = "\$text = 'Reihenfolge 1:';";
$trans["reportCriteriaSortCrit2"]  = "\$text = 'Reihenfolge 2:';";
$trans["reportCriteriaSortCrit3"]  = "\$text = 'Reihenfolge 3:';";
$trans["reportCriteriaAscending"]  = "\$text = 'aufsteigend';";
$trans["reportCriteriaDescending"] = "\$text = 'absteigend';";
$trans["reportCriteriaStartOnLabel"] = "\$text = 'Beginne mit Etikett:';";
$trans["reportCriteriaOutput"]     = "\$text = 'Ausgabe Typ:';";
$trans["reportCriteriaOutputHTML"] = "\$text = 'HTML';";
$trans["reportCriteriaOutputCSV"]  = "\$text = 'CSV';";
$trans["Reverse"]  		   = "\$text = 'Rückwärts';";
$trans["Report Criteria"]          = "\$text = 'Berichtskriterien';";

#****************************************************************************
#*  Translation text for page run_report.php
#****************************************************************************
$trans["runReportReturnLink1"]     = "\$text = 'Auswahlkriterium für den Bericht';";
$trans["runReportReturnLink2"]     = "\$text = 'Bericht';";
$trans["runReportTotal"]           = "\$text = 'Gesamtzeilen:';";
$trans["Result Pages: "]           = "\$text = 'Ergebnis-Seiten: ';";
$trans["&laquo;Prev"]              = "\$text = '&laquo;Zurück';";
$trans["Next&raquo;"]              = "\$text = 'Nächster&raquo;';";
$trans["&laquo;First"]             = "\$text = '&laquo;Anfang';";
$trans["Last&raquo;"]              = "\$text = 'Ende&raquo;';";
$trans["No results found."]        = "\$text = 'Keine Ergebnisse gefunden.';";
$trans["Report Results:"]          = "\$text = 'Berichtsergebnis:';";
$trans["results found."]           = "\$text = 'Ergebnisse gefunden.';";
$trans["Print list"]               = "\$text = 'Liste drucken';";

#****************************************************************************
#*  Translation text for page display_labels.php
#****************************************************************************
$trans["displayLabelsStartOnLblErr"] = "\$text = 'Das Feld muß numerisch sein.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Ein Fehler ist aufgetreten beim Lesen der Reportsdefinitionsdatei. Fehler = ';";
$trans["displayLabelsCannotRead"]  = "\$text = 'Kann die Labeldatei %fileName% nicht lesen';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["noauthMsg"]                = "\$text = 'Sie sind nicht berechtigt, den Reportbereich zu benutzen.';";
$trans["Report Errors"]            = "\$text = 'Fehler melden';";
#****************************************************************************
#*  Report Titles
#****************************************************************************
$trans["reportHolds"]              = "\$text = 'Vorbestellungen mit entsprechenden Kontaktdaten zu den Benutzern';";
$trans["reportCheckouts"]          = "\$text = 'Liste der ausgeliehenen Medien';";
$trans["Over Due Letters"]         = "\$text = 'Mahnungsbriefe';";
$trans["reportLabels"]             = "\$text = 'Etikettendruckanfrage (von den Etiketten genutzt)';";
$trans["popularBiblios"]           = "\$text = 'Beliebteste Medien';";
$trans["overdueList"]              = "\$text = 'Benutzer mit überfälligen Medien';";
$trans["balanceDueList"]           = "\$text = 'Benutzer mit offenen Beträgen';";
$trans["Acquisition"]              = "\$text = 'Erwerbungen';";
$trans["Duplicate Titles"]         = "\$text = 'Doppelte Titel';";
$trans["Periodic Checkout Count"]  = "\$text = 'Periodischer Ausleihzähler';";
$trans["Copy Search"]              = "\$text = 'Exemplarsuche';";
$trans["Inventory List"]           = "\$text = 'Inventurliste';";
$trans["Biblio List"]              = "\$text = 'Gesamtübersicht der Medien';";
$trans["Return"]    	           = "\$text = 'Rückgaben';";
$trans["Search for Number of Players"] = "\$text = 'Suche nach Spieleranzahl';";
$trans["Search for Age of Players"]    = "\$text = 'Suche nach Spieleralter';";
$trans["Search for Playtime"]      = "\$text = 'Suche nach Spielzeit';";
$trans["Search for Game"]          = "\$text = 'Spielesuche';";
$trans["Item Checkout History"]    = "\$text = 'Ausleihhistorie';";
$trans["Member Search"]            = "\$text = 'Mitgliedersuche';";
$trans["Member List : Grade, Teacher"] = "\$text = 'Mitgliederliste : Klasse, Lehrer';";
$trans["Classification"]           = "\$text = 'Klassifizierung';";
$trans["Grade"]                    = "\$text = 'Klasse';";
$trans["Teacher"]                  = "\$text = 'Lehrer';";
$trans["1st Character Member Last Name"] = "\$text = 'Erster Buchstabe des Nachnamen des Mitglieds';";
$trans["... or Member Last Name"]  = "\$text = '... oder Nachname Mitglied';";
$trans["Starts With"]              = "\$text = 'Beginn mit';";
$trans["Contains"]                 = "\$text = 'enthält';";
$trans["... or Grade"]             = "\$text = '... oder Klasse';";
$trans["Teacher Name"]             = "\$text = 'Lehrer Name';";
$trans["Grade, Name"]              = "\$text = 'Klasse, Name';";
$trans["Teacher, Grade, Name"]     = "\$text = 'Lehrer, Klasse, Name';";
$trans["Over Due Member List : Grade, Teacher"] = "\$text = 'Mahnungs-Mitgliederliste : Klasse, Lehrer';";
$trans["Most Popular Authors"]     = "\$text = 'Beliebteste Autoren';";
$trans["Labels"]                   = "\$text = 'Etiketten';";
$trans["Call Num."]                = "\$text = 'Standort';";
$trans["Barcode"]                  = "\$text = 'Barcode';";
$trans["Title"]                    = "\$text = 'Titel';";
$trans["Number"]                   = "\$text = 'Anzahl';";
$trans["Age"]                      = "\$text = 'Alter';";
$trans["max. Time"]                = "\$text = 'max. Zeit';";
$trans["time"]                     = "\$text = 'Zeit';";
$trans["maxPlayer"]                = "\$text = 'max. Spieler';";
$trans["minPlayer"]                = "\$text = 'min. Spieler';";
$trans["maxAge"]                   = "\$text = 'max. Alter';";
$trans["minAge"]                   = "\$text = 'min. Alter';";
$trans["Author"]                   = "\$text = 'Autor';";
$trans["Publisher"]                = "\$text = 'Verlag';";
$trans["Description"]              = "\$text = 'Beschreibung';";
$trans["Quantity"]                 = "\$text = 'Anzahl';";
$trans["Member"]                   = "\$text = 'Mitglied';";
$trans["Checkout"]                 = "\$text = 'Ausleihe';";
$trans["Due"]                      = "\$text = 'Rückgabe';";
$trans["Balance"]                  = "\$text = 'Betrag';";
$trans["Member Barcode"]           = "\$text = 'Mitgliedsnummer';";
$trans["Status Begin"]             = "\$text = 'Statusanfang';";
$trans["Hold Begin"]               = "\$text = 'Reservierungsdatum';";
$trans["Acq. Date"]                = "\$text = 'Erwerbungsdatum';";
$trans["Collection"]               = "\$text = 'Genre';";
$trans["Material"]                 = "\$text = 'Medienart';";
$trans["After (Date or yesterday)"] = "\$text = 'Nach (Datum oder \'yesterday\')';";
$trans["Before"]                   = "\$text = 'Vor';";
$trans["Minimum balance"]          = "\$text = 'Minimaler Betrag';";
$trans["Remainder of title"]       = "\$text = 'Untertitel';";
$trans["Record created on"]        = "\$text = 'Eintrag erstellt am';";
$trans["Duplicate Criteria"]       = "\$text = 'Dublettenkriterium';";
$trans["Title, Title Remainder, Author"] = "\$text = 'Titel, Untertitel, Autor';";
$trans["Title, Author"]            = "\$text = 'Titel, Autor';";
$trans["Title, Title Remainder, Date Created"] = "\$text = 'Titel, Untertitel, Erstellungsdatum';";
$trans["Author, Title, Title Remainder, Date Created"] = "\$text = 'Autor, Titel, Untertitel, Erstellungsdatum';";
$trans["Title Remainder"]          = "\$text = 'Untertitel';";
$trans["Date Created"]             = "\$text = 'Erstellungsdatum';";
$trans["Cycle"]                    = "\$text = 'Periode';";
$trans["# Checkouts"]              = "\$text = '# Ausleihen';";
$trans["Time Span"]                = "\$text = 'Zeitraum';";
$trans["Week"]                     = "\$text = 'Woche';";
$trans["Month"]                    = "\$text = 'Monat';";
$trans["Quarter"]                  = "\$text = 'Quartal';";
$trans["Due before"]               = "\$text = 'Zurück vor';";
$trans["Out since"]                = "\$text = 'ausgeliehen seit';";
$trans["Barcode Starts With"]      = "\$text = 'Barcode beginnt mit';";
$trans["List of Barcodes (spaced)"] = "\$text = 'Liste der Barcodes (mit Leerzeichen)';";
$trans["Newer than (Date or today)"] = "\$text = 'Neuer als (Datum oder \'today\')';";
$trans["Validity date (Date)"] = "\$text = 'Gültigkeitsdatum (Datum)';";
$trans["Ablaufdatum"]              = "\$text = 'Ablaufdatum';";
$trans["Email"]                    = "\$text = 'E-Mail';";
$trans["Placed before"]            = "\$text = 'reserviert vor';";
$trans["Placed since"]             = "\$text = 'reserviert nach';";
$trans["Call Number"]              = "\$text = 'Standort';";
$trans["Cards"]                    = "\$text = 'Karten';";
$trans["ID Cards, self-laminating"] = "\$text = 'Visitenkarten, selbstlaminierend';";
$trans["Name"]                     = "\$text = 'Name';";
$trans["Create Date"]              = "\$text = 'Erstellungsdatum';";
$trans["Date of Return"]           = "\$text = 'Rückgabedatum';";
$trans["Name Contains"]            = "\$text = 'Name enthält';";
$trans["Address or Phone or Email Contains"] = "\$text = 'Adresse, Telefonnummer oder Mail enthält';";
$trans["Newer than (Date or today)"] = "\$text = 'Neuer als (Datum oder today)';";
$trans["Overdue Letters"]          = "\$text = 'Mahnungsbriefe';";
$trans["As of"]                    = "\$text = 'Datum';";
$trans["# Checkouts, Author"]      = "\$text = '# Ausleihen pro Autor';";
$trans["Most Checkouts, Author"]   = "\$text = 'Meisten Ausleihen pro Author';";
$trans["Group By"]                 = "\$text = 'Gruppiere nach';";
$trans["Bibliography"]             = "\$text = 'Medium';";
$trans["Bibliography Copy"]        = "\$text = 'Exemplar';";
$trans["# Checkouts, Author, Title"] = "\$text = '# Ausleihen pro Autor und Titel';";
$trans["Most Checkouts, Author, Title"] = "\$text = 'Meisten Ausleihen pro Autor und Titel';";
$trans["HTML (page-by-page)"]      = "\$text = 'HTML (seitenweise)';";
$trans["Format"]                   = "\$text = 'Format';";
$trans["HTML (one big page)"]      = "\$text = 'HTML (eine große Seite)';";
$trans["CSV"]                      = "\$text = 'CSV';";
$trans["Sort By"]                  = "\$text = 'Sortieren nach';";
$trans["Cataloging"]               = "\$text = 'Katalogisierung';";
$trans["Circulation"]              = "\$text = 'Ausleihe';";
$trans["Statistics"]               = "\$text = 'Statistik';";

#****************************************************************************
#*  Label Titles
#****************************************************************************
$trans["labelsMulti"]              = "\$text = 'Komplexere Etiketten';";
$trans["labelsSimple"]             = "\$text = 'Einfache Etiketten';";

#****************************************************************************
#*  Column Text
#****************************************************************************
$trans["biblio.bibid"]             = "\$text = 'MedienID';";
$trans["biblio.create_dt"]         = "\$text = 'Erstellungsdatum';";
$trans["biblio.last_change_dt"]    = "\$text = 'Letzte Änderung';";
$trans["biblio.material_cd"]       = "\$text = 'Medienart Nummer';";
$trans["biblio.collection_cd"]     = "\$text = 'Genre Nummer';";
$trans["biblio.call_nmbr1"]        = "\$text = 'Standort 1';";
$trans["biblio.call_nmbr2"]        = "\$text = 'Standort 2';";
$trans["biblio.call_nmbr3"]        = "\$text = 'Standort 3';";
$trans["biblio.title_remainder"]   = "\$text = 'Untertitel';";
$trans["biblio.responsibility_stmt"] = "\$text = 'Verfasserangabe';";
$trans["biblio.opac_flg"]          = "\$text = 'OPAC Flag';";

$trans["biblio_copy.barcode_nmbr"] = "\$text = 'Mediennummer';";
$trans["biblio.title"]             = "\$text = 'Titel';";
$trans["biblio.author"]            = "\$text = 'Autor';";
$trans["biblio_copy.status_begin_dt"]   = "\$text = 'Ausleihdatum';";
$trans["biblio_copy.due_back_dt"]       = "\$text = 'Rückgabedatum';";
$trans["member.mbrid"]             = "\$text = 'Benutzernummer';";
$trans["member.barcode_nmbr"]      = "\$text = 'Benutzernummer';";
$trans["member.last_name"]         = "\$text = 'Nachname';";
$trans["member.first_name"]        = "\$text = 'Vorname';";
$trans["member.address"]          = "\$text = 'Adresse';";
$trans["biblio_hold.hold_begin_dt"] = "\$text = 'Vorbestellungsdatum';";
$trans["member.home_phone"]        = "\$text = 'Telefon(heim)';";
$trans["member.work_phone"]        = "\$text = 'Telefon(Arbeit)';";
$trans["member.email"]             = "\$text = 'E-Mail';";
$trans["biblio_status_dm.description"] = "\$text = 'Status';";
$trans["settings.library_name"]    = "\$text = 'Bibliotheksname';";
$trans["settings.library_hours"]   = "\$text = 'Öffnungszeiten';";
$trans["settings.library_phone"]   = "\$text = 'Bibliothekstelefon';";
$trans["days_late"]                = "\$text = 'überfällige Tage';";
$trans["title"]                    = "\$text = 'Titel';";
$trans["author"]                   = "\$text = 'Autor';";
$trans["due_back_dt"]              = "\$text = 'Rückgabe';";
$trans["checkoutCount"]            = "\$text = 'Anzahl der Ausleihen';";

?>
