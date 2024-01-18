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
#*  Translation text for class Biblio
#****************************************************************************
$trans["biblioError1"]            = "\$text = 'Call number is required.';";

#****************************************************************************
#*  Translation text for class BiblioField
#****************************************************************************
$trans["biblioFieldError1"]       = "\$text = 'Field is required.';";
$trans["biblioFieldError2"]       = "\$text = 'Tag must be numeric.';";

#****************************************************************************
#*  Translation text for class BiblioQuery
#****************************************************************************
$trans["biblioQueryQueryErr1"]    = "\$text = 'Error accessing bibliography information.';";
$trans["biblioQueryQueryErr2"]    = "\$text = 'Error accessing bibliography field information.';";
$trans["biblioQueryInsertErr1"]   = "\$text = 'Error inserting new bibliography information.';";
$trans["biblioQueryInsertErr2"]   = "\$text = 'Error inserting new bibliography field information.';";
$trans["biblioQueryUpdateErr1"]   = "\$text = 'Error updating bibliography information.';";
$trans["biblioQueryUpdateErr2"]   = "\$text = 'Error clearing bibliography field information for update.';";
$trans["biblioQueryDeleteErr"]    = "\$text = 'Error deleting bibliography information.';";

#****************************************************************************
#*  Translation text for class BiblioSearchQuery
#****************************************************************************
$trans["biblioSearchQueryErr1"]   = "\$text = 'Error counting bibliography search results.';";
$trans["biblioSearchQueryErr2"]   = "\$text = 'Error searching bibliography information.';";
$trans["biblioSearchQueryErr3"]   = "\$text = 'Error reading bibliography information.';";

#****************************************************************************
#*  Translation text for class BiblioCopy
#****************************************************************************
$trans["biblioCopyError1"]        = "\$text = 'Barcode number is required.';";
$trans["biblioCopyError2"]        = "\$text = 'Invalid characters in barcode number.';";

#****************************************************************************
#*  Translation text for class BiblioCopyQuery
#****************************************************************************
$trans["biblioCopyQueryErr1"]     = "\$text = 'Error checking for dup barcode.';";
$trans["biblioCopyQueryErr2"]     = "\$text = 'Barcode number %barcodeNmbr% is already in use.';";
$trans["biblioCopyQueryErr3"]     = "\$text = 'Error inserting new bibliography copy information.';";
$trans["biblioCopyQueryErr4"]     = "\$text = 'Error accessing bibliography copy information.';";
$trans["biblioCopyQueryErr5"]     = "\$text = 'Error updating bibliography copy information.';";
$trans["biblioCopyQueryErr6"]     = "\$text = 'Error deleting bibliography information.';";
$trans["biblioCopyQueryErr7"]     = "\$text = 'Error accessing bibliography information to get collection code.';";
$trans["biblioCopyQueryErr8"]     = "\$text = 'Error accessing collection information to check days due back.';";
$trans["biblioCopyQueryErr9"]     = "\$text = 'Error occurred checking copies in';";
$trans["biblioCopyQueryErr10"]    = "\$text = 'Error occurred checking checkout limits';";
$trans["biblioCopyQueryErr11"]    = "\$text = 'Error fetching highest copyid.';";

#****************************************************************************
#*  Translation text for class BiblioFieldQuery
#****************************************************************************
$trans["biblioFieldQueryErr1"]    = "\$text = 'Error reading for a bibliography field.';";
$trans["biblioFieldQueryErr2"]    = "\$text = 'Error reading bibliography fields.';";
$trans["biblioFieldQueryInsertErr"] = "\$text = 'Error inserting new bibliography field.';";
$trans["biblioFieldQueryUpdateErr"] = "\$text = 'Error updating bibliography field.';";
$trans["biblioFieldQueryDeleteErr"] = "\$text = 'Error deleting bibliography field.';";

#****************************************************************************
#*  Translation text for class UsmarcBlockDmQuery
#****************************************************************************
$trans["usmarcBlockDmQueryErr1"]  = "\$text = 'Error accessing the marc block data.';";

#****************************************************************************
#*  Translation text for class UsmarcTagDmQuery
#****************************************************************************
$trans["usmarcTagDmQueryErr1"]    = "\$text = 'Error accessing the marc tag data.';";

#****************************************************************************
#*  Translation text for class UsmarcSubfieldDmQuery
#****************************************************************************
$trans["usmarcSubfldDmQueryErr1"] = "\$text = 'Error accessing the marc subfield data.';";

#****************************************************************************
#*  Translation text for class BiblioHoldQuery
#****************************************************************************
$trans["biblioHoldQueryErr1"]     = "\$text = 'Error accessing hold data by bibliography id.';";
$trans["biblioHoldQueryErr2"]     = "\$text = 'Error accessing hold data by member id.';";
$trans["biblioHoldQueryErr3"]     = "\$text = 'Error getting bibid and copyid for placing hold.';";
$trans["biblioHoldQueryErr4"]     = "\$text = 'Error inserting hold data.';";
$trans["biblioHoldQueryErr5"]     = "\$text = 'Error deleting hold data.';";
$trans["biblioHoldQueryErr6"]     = "\$text = 'Error getting first hold member for a copy.';";

#****************************************************************************
#*  Translation text for class ReportQuery
#****************************************************************************
$trans["reportQueryErr1"]         = "\$text = 'Error running report.';";

#****************************************************************************
#*  Translation text for class ReportCriteria
#****************************************************************************
$trans["reportCriteriaErr1"]      = "\$text = 'Non numeric value is not valid with numeric column.';";
$trans["reportCriteriaDateTimeErr"] = "\$text = 'Invalid datetime format.';";
$trans["reportCriteriaDateErr"]   = "\$text = 'Invalid date format.';";

#****************************************************************************
#*  Translation text for class Staff
#****************************************************************************
$trans["staffLastNameReqErr"]     = "\$text = 'Last name is required.';";
$trans["staffUserNameLenErr"]     = "\$text = 'Username must be at least 4 characters.';";
$trans["staffUserNameCharErr"]    = "\$text = 'Username must not contain any spaces.';";
$trans["staffPwdLenErr"]          = "\$text = 'Password must be at least 4 characters.';";
$trans["staffPwdCharErr"]         = "\$text = 'Password must not contain any spaces.';";
$trans["staffPwdMatchErr"]        = "\$text = 'Passwords do not match.';";

#****************************************************************************
#*  Translation text for class Member
#****************************************************************************
$trans["memberBarcodeReqErr"]     = "\$text = 'Card number is required.';";
$trans["memberBarcodeCharErr"]    = "\$text = 'Invalid characters in card number.';";
$trans["memberLastNameReqErr"]    = "\$text = 'Last name is required.';";
$trans["memberFirstNameReqErr"]   = "\$text = 'First name is required.';";

#****************************************************************************
#*  Translation text for class LabelFormat and LetterFormat
#****************************************************************************
$trans["labelFormatFontErr"]      = "\$text = 'Invalid font type specified in label definition xml.  Valid font types are Courier, Helvetica, and Times-Roman.';";
$trans["labelFormatFontSizeErr"]  = "\$text = 'Invalid font size specified in label definition xml.  Font size must be numeric.';";
$trans["labelFormatFontSizeErr2"] = "\$text = 'Invalid font size specified in label definition xml.  Font size must be greater than zero.';";
$trans["labelFormatLMarginErr"]   = "\$text = 'Invalid left margin specified in label definition xml.  Left margin must be numeric.';";
$trans["labelFormatLMarginErr2"]  = "\$text = 'Invalid left margin specified in label definition xml.  Left margin must be greater than zero.';";
$trans["labelFormatRMarginErr"]   = "\$text = 'Invalid right margin specified in label definition xml.  Right margin must be numeric.';";
$trans["labelFormatRMarginErr2"]  = "\$text = 'Invalid right margin specified in label definition xml.  Right margin must be greater than zero.';";
$trans["labelFormatTMarginErr"]   = "\$text = 'Invalid top margin specified in label definition xml.  Top margin must be numeric.';";
$trans["labelFormatTMarginErr2"]  = "\$text = 'Invalid top margin specified in label definition xml.  Top margin must be greater than zero.';";
$trans["labelFormatBMarginErr"]   = "\$text = 'Invalid bottom margin specified in label definition xml.  Bottom margin must be numeric.';";
$trans["labelFormatBMarginErr2"]  = "\$text = 'Invalid bottom margin specified in label definition xml.  Bottom margin must be greater than zero.';";
$trans["labelFormatColErr"]       = "\$text = 'Invalid columns specified in label definition xml.  Columns must be numeric.';";
$trans["labelFormatColErr2"]      = "\$text = 'Invalid columns specified in label definition xml.  Columns must be greater than zero.';";
$trans["labelFormatWidthErr"]     = "\$text = 'Invalid width specified in label definition xml.  Width must be numeric.';";
$trans["labelFormatWidthErr2"]    = "\$text = 'Invalid width specified in label definition xml.  Width must be greater than zero.';";
$trans["labelFormatHeightErr"]    = "\$text = 'Invalid height specified in label definition xml.  Height must be numeric.';";
$trans["labelFormatHeightErr2"]   = "\$text = 'Invalid height specified in label definition xml.  Height must be greater than zero.';";
$trans["labelFormatNoLabelsErr"]  = "\$text = 'Invalid label lines specified in label definition xml.';";

#****************************************************************************
#*  Translation text for class BiblioStatusHistQuery
#****************************************************************************
$trans["biblioStatusHistQueryErr1"] = "\$text = 'Error getting bibliography status history by bibliography id.';";
$trans["biblioStatusHistQueryErr2"] = "\$text = 'Error getting bibliography status history by member id';";
$trans["biblioStatusHistQueryErr3"] = "\$text = 'Error inserting bibliography status history';";
$trans["biblioStatusHistQueryErr4"] = "\$text = 'Error deleting bibliography status history by copy id';";
$trans["biblioStatusHistQueryErr5"] = "\$text = 'Error deleting bibliography status history by member id';";

#****************************************************************************
#*  Translation text for class MemberAccountTransaction
#****************************************************************************
$trans["memberAccountTransError1"]  = "\$text = 'Amount is required.';";
$trans["memberAccountTransError2"]  = "\$text = 'Amount must be numeric.';";
$trans["memberAccountTransError3"]  = "\$text = 'Description is required.';";
$trans["Amount must be greater than zero."]  = "\$text = 'Amount must be greater than zero.';";

#****************************************************************************
#*  Translation text for class MemberAccountQuery
#****************************************************************************
$trans["memberAccountQueryErr1"]    = "\$text = 'Error accessing member account information.';";
$trans["memberAccountQueryErr2"]    = "\$text = 'Error inserting member account information.';";
$trans["memberAccountQueryErr3"]    = "\$text = 'Error deleting member account information.';";

#****************************************************************************
#*  Translation text for class CircQuery
#****************************************************************************
$trans["Can't understand date: %err%"]                            = "\$text = 'Can't understand date: %err%';";
$trans["Won't do checkouts for future dates."]                    = "\$text = 'Won't do checkouts for future dates.';";
$trans["Bad member barcode: %bcode%"]                             = "\$text = 'Bad member barcode: %bcode%';";
$trans["Member owes fines: checkout not allowed"]                 = "\$text = 'Member owes fines: checkout not allowed';";
$trans["Member must renew membership before checking out."]       = "\$text = 'Member must renew membership before checking out.';";
$trans["Bad copy barcode: %bcode%"]                               = "\$text = 'Bad copy barcode: %bcode%';";
$trans["Item %bcode% has reached its renewal limit."]             = "\$text = 'Item %bcode% has reached its renewal limit.';";
$trans["Item %bcode% is late and cannot be renewed."]             = "\$text = 'Item %bcode% is late and cannot be renewed.';";
$trans["Item %bcode% is on hold."]                                = "\$text = 'Item %bcode% is on hold.';";
$trans["Item %bcode% is already checked out to another member."]  = "\$text = 'Item %bcode% is already checked out to another member.';";
$trans["Item %bcode% isn't out and cannot be renewed."]  	   = "\$text = 'Item %bcode% isn't out and cannot be renewed.';";
$trans["Member has reached checkout limit for this collection."]  = "\$text = 'Member has reached checkout limit for this collection.';";
$trans["Checkouts are disallowed for this collection."]           = "\$text = 'Checkouts are disallowed for this collection.';";
$trans["Item is on hold for another member."]                     = "\$text = 'Item is on hold for another member.';";
$trans["!!!Note : due date is after the end of the membership"] = "\$text = '!!!Note : provided due date is after the end of the membership';";
$trans["Can't change status to an earlier date on item %bcode%."] = "\$text = 'Can't change status to an earlier date on item %bcode%.';";
$trans["Can't change status more than once per second on item %bcode%."]  = "\$text = 'Can't change status more than once per second on item %bcode%.';";
$trans["Won't do checkins for future dates."]                     = "\$text = 'Won't do checkins for future dates.';";
$trans["Late fee (barcode=%barcode%)"]                            = "\$text = 'Late fee (barcode=%barcode%)';";


$trans[""]  = "\$text = '';";

?>
