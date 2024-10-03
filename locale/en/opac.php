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
$trans["opac_Header"]        = "\$text='Online Public Access Catalog (OPAC)';";
$trans["opac_WelcomeMsg"]    = "\$text=
  'Welcome to our library\'s online public access catalog.  Search our catalog
   to view bibliography information on holdings we have in our library.';";
$trans["opac_SearchTitle"]   = "\$text='Search Bibliography by Search Phrase:';";
$trans["opac_Keyword"]       = "\$text='Keyword';";
$trans["opac_Title"]         = "\$text='Title';";
$trans["opac_Author"]        = "\$text='Author';";
$trans["opac_Subject"]       = "\$text='Subject';";
$trans["opac_All"]           = "\$text='All';";
$trans["opac_Callno"]        = "\$text='Call Number';";
$trans["opac_Search"]        = "\$text='Search';";
$trans["opac_SearchInvert"]  = "\$text='Invert Selection';";
$trans["opac_SearchColl"]    = "\$text='Limit Search to Collections';";
$trans["opac_SearchMat"]     = "\$text='Limit Search to Material Types';";

#****************************************************************************
#*  Translation text for page loginform.php
#****************************************************************************
$trans["loginFormTbleHdr"]         = "\$text = 'Member Login';";
$trans["MemberID"]        	   = "\$text = 'Card Number';";
$trans["Secret Word"]	           = "\$text = 'Secret Word';";
$trans["loginFormLogin"]           = "\$text = 'Login';";
$trans["loginDeactived"]           = "\$text = 'Login is deactivated.';";
$trans["PasswordForgotten"]	   = "\$text = 'Forgotten password?';";

#****************************************************************************
#*  Translation text for page login.php
#****************************************************************************
$trans["MemberID is required."]    = "\$text = 'Card Number is required.';";
$trans["Password is required."] = "\$text = 'Password is required.';";
$trans["Invalid Login!"] = "\$text = 'Invalid Login datas!';";

#****************************************************************************
#*  Translation text for page mbr_account.php
#****************************************************************************
$trans["mbrViewBalMsg"]           = "\$text='Note: Member has an outstanding account balance of %bal%.';";
$trans["mbrViewHead1"]            = "\$text='Member Information:';";
$trans["mbrViewName"]             = "\$text='Name:';";
$trans["mbrViewCardNmbr"]         = "\$text='Card Number:';";
$trans["mbrViewMbrShipEnd"]       = "\$text='paid until:';";
$trans["mbrViewMbrShipNoEnd"]     = "\$text='unlimited/not used';";
$trans["mbrViewHead4"]            = "\$text='Bibliographies Currently Checked Out:';";
$trans["mbrPrintCheckouts"]	  = "\$text='print checkouts';";
$trans["mbrViewOutHdr1"]          = "\$text='Checked Out';";
$trans["mbrViewOutHdr2"]          = "\$text='Material';";
$trans["mbrViewOutHdr3"]          = "\$text='Barcode';";
$trans["mbrViewOutHdr4"]          = "\$text='Title';";
$trans["mbrViewOutHdr5"]          = "\$text='Author';";
$trans["mbrViewOutHdr6"]          = "\$text='Due Back';";
$trans["mbrViewOutHdr7"]          = "\$text='Days Late';";
$trans["mbrViewOutHdr8"]          = "\$text='Renewal';";
$trans["mbrViewNoCheckouts"]      = "\$text='No bibliographies are currently checked out.';";
$trans["Cannot renew item *"]     = "\$text='Cannot renew item *';";
$trans["Renew item"]              = "\$text='Renew item';";
$trans["mbrViewOutHdr9"]          = "\$text='time/s';";
$trans["* You cannot renew, if you are more then 7 days too late"] = "\$text='* You cannot renew, if you are more then 7 days too late';";
$trans["mbrViewHead5"]            = "\$text='Place Hold:';";
$trans["mbrViewBarcode"]          = "\$text='Barcode Number:';";
$trans["indexSearch"]             = "\$text='Search';";
$trans["mbrViewPlaceHold"]        = "\$text='Place Hold';";
$trans["mbrViewHead6"]            = "\$text='Bibliographies Currently On Hold:';";
$trans["mbrViewHoldHdr2"]         = "\$text='Placed On Hold';";
$trans["mbrViewHoldHdr3"]         = "\$text='Material';";
$trans["mbrViewHoldHdr4"]         = "\$text='Barcode';";
$trans["mbrViewHoldHdr5"]         = "\$text='Title';";
$trans["mbrViewHoldHdr6"]         = "\$text='Author';";
$trans["mbrViewHoldHdr7"]         = "\$text='Status';";
$trans["mbrViewHoldHdr8"]         = "\$text='Due Back';";
$trans["mbrViewNoHolds"]          = "\$text='No bibliographies are currently on hold.';";
$trans["Please send a mail to delete holds"] = "\$text='Please send a mail to delete holds';";
$trans["eMail"]                   = "\$text='eMail';";
$trans["mbrViewPwd"]              = "\$text='Password:';";
$trans["mbrNoPassword"]           = "\$text = '<p style=\"font-weight: bold; color: red;\";>No password set!</p>';";

#****************************************************************************
#*  Translation text for page mbr_print_checkouts.php
#****************************************************************************
$trans["mbrPrintCheckoutsTitle"]  = "\$text='Checkouts for %mbrName%';";
$trans["mbrPrintCheckoutsHdr1"]   = "\$text='Current Date:';";
$trans["mbrPrintCheckoutsHdr2"]   = "\$text='Member:';";
$trans["mbrPrintCheckoutsHdr3"]   = "\$text='Card Number:';";
$trans["mbrPrintCloseWindow"]     = "\$text='Close Window';";

#****************************************************************************
#*  Translation text for page place_hold.php
#****************************************************************************
$trans["placeHoldErr2"]           = "\$text='Barcode does not exist.';";
$trans["placeHoldErr3"]           = "\$text='This member already has that item checked out -- not placing hold.';";
$trans["This item is not checked out or on hold."]           = "\$text='This item is not checked out or on hold.';";

?>
