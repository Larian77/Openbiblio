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
$trans["reportsCancel"]            = "\$text = 'Cancel';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'Reports';";
$trans["indexDesc"]                = "\$text = 'Use the report or label list located in the left hand navigation area to produce reports or labels.';";
$trans["Report Errors"]            = "\$text = 'Report Errors';";

#****************************************************************************
#*  Translation text for page report_list.php
#****************************************************************************
$trans["reportListHdr"]            = "\$text = 'Report List';";
$trans["reportListDesc"]           = "\$text = 'Choose from one of the following links to run a report.';";
$trans["reportListXmlErr"]         = "\$text = 'Error occurred parsing report definition xml.';";
$trans["reportListCannotRead"]     = "\$text = 'Cannot read label file: %fileName%';";

#****************************************************************************
#*  Translation text for page label_list.php
#****************************************************************************
$trans["labelListHdr"]             = "\$text = 'Label List';";
$trans["labelListDesc"]            = "\$text = 'Choose from one of the following links to produce labels in pdf format.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Error occurred parsing report definition xml.  Error = ';";

#****************************************************************************
#*  Translation text for page letter_list.php
#****************************************************************************
$trans["letterListHdr"]            = "\$text = 'Letter List';";
$trans["letterListDesc"]           = "\$text = 'Choose from one of the following links to produce letters in pdf format.';";
$trans["displayLettersXmlErr"]      = "\$text = 'Error occurred parsing report definition xml.  Error = ';";

#****************************************************************************
#*  Translation text for page report_criteria.php
#****************************************************************************
$trans["reportCriteriaHead1"]      = "\$text = 'Report Search Criteria (optional)';";
$trans["reportCriteriaHead2"]      = "\$text = 'Report Sort Order (optional)';";
$trans["reportCriteriaHead3"]      = "\$text = 'Report Output Type';";
$trans["reportCriteriaCrit1"]      = "\$text = 'Criteria 1:';";
$trans["reportCriteriaCrit2"]      = "\$text = 'Criteria 2:';";
$trans["reportCriteriaCrit3"]      = "\$text = 'Criteria 3:';";
$trans["reportCriteriaCrit4"]      = "\$text = 'Criteria 4:';";
$trans["reportCriteriaEQ"]         = "\$text = '=';";
$trans["reportCriteriaNE"]         = "\$text = 'not =';";
$trans["reportCriteriaLT"]         = "\$text = '&lt;';";
$trans["reportCriteriaGT"]         = "\$text = '&gt;';";
$trans["reportCriteriaLE"]         = "\$text = '&lt or =';";
$trans["reportCriteriaGE"]         = "\$text = '&gt or =';";
$trans["reportCriteriaBT"]         = "\$text = 'between';";
$trans["reportCriteriaAnd"]        = "\$text = 'and';";
$trans["reportCriteriaRunReport"]  = "\$text = 'Run Report';";
$trans["reportCriteriaSortCrit1"]  = "\$text = 'Sort 1:';";
$trans["reportCriteriaSortCrit2"]  = "\$text = 'Sort 2:';";
$trans["reportCriteriaSortCrit3"]  = "\$text = 'Sort 3:';";
$trans["reportCriteriaAscending"]  = "\$text = 'ascending';";
$trans["reportCriteriaDescending"] = "\$text = 'descending';";
$trans["reportCriteriaStartOnLabel"] = "\$text = 'Start printing on label:';";
$trans["reportCriteriaOutput"]     = "\$text = 'Output Type:';";
$trans["reportCriteriaOutputHTML"] = "\$text = 'HTML';";
$trans["reportCriteriaOutputCSV"]  = "\$text = 'CSV';";
$trans["Reverse"]  		   = "\$text = 'Reverse';";
$trans["Report Criteria"]          = "\$text = 'Report Criteria';";

#****************************************************************************
#*  Translation text for page run_report.php
#****************************************************************************
$trans["runReportReturnLink1"]     = "\$text = 'report selection criteria';";
$trans["runReportReturnLink2"]     = "\$text = 'report list';";
$trans["runReportTotal"]           = "\$text = 'Total Rows:';";
$trans["Result Pages: "]           = "\$text = 'Result Pages: ';";
$trans["&laquo;Prev"]              = "\$text = '&laquo;Prev';";
$trans["Next&raquo;"]              = "\$text = 'Next&raquo;';";
$trans["&laquo;First"]             = "\$text = '&laquo;First';";
$trans["Last&raquo;"]              = "\$text = 'Last&raquo;';";
$trans["No results found."]        = "\$text = 'No results found.';";
$trans["Report Results:"]          = "\$text = 'Report Results:';";
$trans["results found."]           = "\$text = 'results found.';";
$trans["Print list"]               = "\$text = 'Print list';";

#****************************************************************************
#*  Translation text for page display_labels.php
#****************************************************************************
$trans["displayLabelsStartOnLblErr"] = "\$text = 'Field must be numeric.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Error occurred parsing report definition xml.  Error = ';";
$trans["displayLabelsCannotRead"]  = "\$text = 'Cannot read label file: %fileName%';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["noauthMsg"]                = "\$text = 'You are not authorized to use the Reports tab.';";
$trans["Report Errors"]            = "\$text = 'Report Errors';";
#****************************************************************************
#*  Report TitlesReport Criteria
#****************************************************************************
$trans["reportHolds"]              = "\$text = 'Hold Requests Containing Member Contact Info';";
$trans["reportCheckouts"]          = "\$text = 'Bibliography Checkout Listing';";
$trans["Over Due Letters"]         = "\$text = 'Over Due Letters';";
$trans["reportLabels"]             = "\$text = 'Label Printing Query (used by labels)';";
$trans["popularBiblios"]           = "\$text = 'Most Popular Bibliographies';";
$trans["overdueList"]              = "\$text = 'Over Due Member List';";
$trans["balanceDueList"]           = "\$text = 'Balance Due Member List';";
$trans["Acquisition"]              = "\$text = 'Acquisition';";
$trans["Duplicate Titles"]         = "\$text = 'Duplicate Titles';";
$trans["Periodic Checkout Count"]  = "\$text = 'Periodic Checkout Count';";
$trans["Copy Search"]              = "\$text = 'Copy Search';";
$trans["Inventory List"]           = "\$text = 'Inventory List';";
$trans["Biblio List"]              = "\$text = 'Biblio List';";
$trans["Return"]    	           = "\$text = 'Return';";
$trans["Search for Number of Players"] = "\$text = 'Search for Number of Players';";
$trans["Search for Age of Players"]    = "\$text = 'Search for Age of Players';";
$trans["Search for Playtime"]      = "\$text = 'Search for Playtime';";
$trans["Search for Game"]          = "\$text = 'Search for Game';";
$trans["Item Checkout History"]    = "\$text = 'Item Checkout History';";
$trans["Member Search"]            = "\$text = 'Member Search';";
$trans["Most Popular Authors"]     = "\$text = 'Most Popular Authors';";
$trans["Labels"]                   = "\$text = 'Labels';";
$trans["Call Num."]                = "\$text = 'Call Num.';";
$trans["Barcode"]                  = "\$text = 'Barcode';";
$trans["Title"]                    = "\$text = 'Title';";
$trans["Number"]                   = "\$text = 'Number';";
$trans["Age"]                      = "\$text = 'Age';";
$trans["max. Time"]                = "\$text = 'max. Time';";
$trans["time"]                     = "\$text = 'time';";
$trans["maxPlayer"]                = "\$text = 'max. Player';";
$trans["minPlayer"]                = "\$text = 'min. Player';";
$trans["maxAge"]                   = "\$text = 'max. Age';";
$trans["minAge"]                   = "\$text = 'min. Age';";
$trans["Author"]                   = "\$text = 'Author';";
$trans["Publisher"]                = "\$text = 'Publisher';";
$trans["Description"]              = "\$text = 'Description';";
$trans["Quantity"]                 = "\$text = 'Quantity';";
$trans["Member"]                   = "\$text = 'Member';";
$trans["Checkout"]                 = "\$text = 'Checkout';";
$trans["Due"]                      = "\$text = 'Due';";
$trans["Balance"]                  = "\$text = 'Balance';";
$trans["Member Barcode"]           = "\$text = 'Member Barcode';";
$trans["Status Begin"]             = "\$text = 'Status Begin';";
$trans["Hold Begin"]               = "\$text = 'Hold Begin';";
$trans["Acq. Date"]                = "\$text = 'Acq. Date';";
$trans["Collection"]               = "\$text = 'Collection';";
$trans["Material"]                 = "\$text = 'Material';";
$trans["After (Date or yesterday)"] = "\$text = 'After (Date or yesterday)';";
$trans["Before"]                   = "\$text = 'Before';";
$trans["Minimum balance"]          = "\$text = 'Minimum balance';";
$trans["Remainder of title"]       = "\$text = 'Remainder of title';";
$trans["Record created on"]        = "\$text = 'Record created on';";
$trans["Duplicate Criteria"]       = "\$text = 'Duplicate Criteria';";
$trans["Title, Title Remainder, Author"] = "\$text = 'Title, Title Remainder, Author';";
$trans["Title, Author"]            = "\$text = 'Title, Author';";
$trans["Title, Title Remainder, Date Created"] = "\$text = 'Title, Title Remainder, Date Created';";
$trans["Author, Title, Title Remainder, Date Created"] = "\$text = 'Author, Title, Title Remainder, Date Created';";
$trans["Title Remainder"]          = "\$text = 'Title Remainder';";
$trans["Date Created"]             = "\$text = 'Date Created';";
$trans["Cycle"]                    = "\$text = 'Cycle';";
$trans["# Checkouts"]              = "\$text = '# Checkouts';";
$trans["Time Span"]                = "\$text = 'Time Span';";
$trans["Week"]                     = "\$text = 'Week';";
$trans["Month"]                    = "\$text = 'Month';";
$trans["Quarter"]                  = "\$text = 'Quarter';";
$trans["Due before"]               = "\$text = 'Due before';";
$trans["Out since"]                = "\$text = 'Out since';";
$trans["Barcode Starts With"]      = "\$text = 'Barcode Starts With';";
$trans["List of Barcodes (spaced)"] = "\$text = 'List of Barcodes (spaced)';";
$trans["Newer than (Date or today)"] = "\$text = 'Newer than (Date or today)';";
$trans["Placed before"]            = "\$text = 'Placed before';";
$trans["Placed since"]             = "\$text = 'Placed since';";
$trans["Call Number"]              = "\$text = 'Call Number';";
$trans["Cards"]                    = "\$text = 'Cards';";
$trans["ID Cards, self-laminating"] = "\$text = 'ID Cards, self-laminating';";
$trans["Name"]                     = "\$text = 'Name';";
$trans["Create Date"]              = "\$text = 'Create Date';";
$trans["Date of Return"]           = "\$text = 'Date of Return';";
$trans["Name Contains"]            = "\$text = 'Name Contains';";
$trans["Address or Phone or Email Contains"] = "\$text = 'Address or Phone or Email Contains';";
$trans["Newer than (Date or today)"] = "\$text = 'Newer than (Date or today)';";
$trans["Overdue Letters"]          = "\$text = 'Overdue Letters';";
$trans["As of"]                    = "\$text = 'As of';";
$trans["# Checkouts, Author"]      = "\$text = '# Checkouts, Author';";
$trans["Most Checkouts, Author"]   = "\$text = 'Most Checkouts, Author';";
$trans["Group By"]                 = "\$text = 'Group By';";
$trans["Bibliography"]             = "\$text = 'Bibliography';";
$trans["Bibliography Copy"]        = "\$text = 'Bibliography Copy';";
$trans["# Checkouts, Author, Title"] = "\$text = '# Checkouts, Author, Title';";
$trans["Most Checkouts, Author, Title"] = "\$text = 'Most Checkouts, Author, Title';";
$trans["HTML (page-by-page)"]      = "\$text = 'HTML (page-by-page)';";
$trans["Format"]                   = "\$text = 'Format';";
$trans["HTML (one big page)"]      = "\$text = 'HTML (one big page)';";
$trans["CSV"]                      = "\$text = 'CSV';";
$trans["Sort By"]                  = "\$text = 'Sort By';";
$trans["Cataloging"]               = "\$text = 'Cataloging';";
$trans["Circulation"]              = "\$text = 'Circulation';";
$trans["Statistics"]               = "\$text = 'Statistics';";

#****************************************************************************
#*  Label Titles
#****************************************************************************
$trans["labelsMulti"]              = "\$text = 'Multi Label Example';";
$trans["labelsSimple"]             = "\$text = 'Simple Label Example';";

#****************************************************************************
#*  Column Text
#****************************************************************************
$trans["biblio.bibid"]             = "\$text = 'Biblio ID';";
$trans["biblio.create_dt"]         = "\$text = 'Date Added';";
$trans["biblio.last_change_dt"]    = "\$text = 'Last Changed';";
$trans["biblio.material_cd"]       = "\$text = 'Material Cd';";
$trans["biblio.collection_cd"]     = "\$text = 'Collection';";
$trans["biblio.call_nmbr1"]        = "\$text = 'Call 1';";
$trans["biblio.call_nmbr2"]        = "\$text = 'Call 2';";
$trans["biblio.call_nmbr3"]        = "\$text = 'Call 3';";
$trans["biblio.title_remainder"]   = "\$text = 'Title Remainder';";
$trans["biblio.responsibility_stmt"] = "\$text = 'Stmt of Resp';";
$trans["biblio.opac_flg"]          = "\$text = 'OPAC Flag';";

$trans["biblio_copy.barcode_nmbr"] = "\$text = 'Barcode';";
$trans["biblio.title"]             = "\$text = 'Title';";
$trans["biblio.author"]            = "\$text = 'Author';";
$trans["biblio_copy.status_begin_dt"]   = "\$text = 'Status Begin Date';";
$trans["biblio_copy.due_back_dt"]       = "\$text = 'Due Back Date';";
$trans["member.mbrid"]             = "\$text = 'Member ID';";
$trans["member.barcode_nmbr"]      = "\$text = 'Member Barcode';";
$trans["member.last_name"]         = "\$text = 'Last Name';";
$trans["member.first_name"]        = "\$text = 'First Name';";
$trans["member.address"]           = "\$text = 'Address';";
$trans["biblio_hold.hold_begin_dt"] = "\$text = 'Hold Begin Date';";
$trans["member.home_phone"]        = "\$text = 'Home Phone';";
$trans["member.work_phone"]        = "\$text = 'Work Phone';";
$trans["member.email"]             = "\$text = 'Email';";
$trans["biblio_status_dm.description"] = "\$text = 'Status';";
$trans["settings.library_name"]    = "\$text = 'Library Name';";
$trans["settings.library_hours"]   = "\$text = 'Library Hours';";
$trans["settings.library_phone"]   = "\$text = 'Library Phone';";
$trans["days_late"]                = "\$text = 'Days Late';";
$trans["title"]                    = "\$text = 'Title';";
$trans["author"]                   = "\$text = 'Author';";
$trans["due_back_dt"]              = "\$text = 'Due Back';";
$trans["checkoutCount"]            = "\$text = 'Checkout Count';";

?>
