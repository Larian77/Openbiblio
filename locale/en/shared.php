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
$trans["sharedCancel"]             = "\$text = 'Cancel';";
$trans["sharedDelete"]             = "\$text = 'Delete';";

#****************************************************************************
#*  Translation text for page biblio_view.php
#****************************************************************************
$trans["biblioViewTble1Hdr"]       = "\$text = 'Bibliography Information';";
$trans["biblioViewMaterialType"]   = "\$text = 'Material Type';";
$trans["biblioViewCollection"]     = "\$text = 'Collection';";
$trans["biblioViewPictureHeader"]  = "\$text = 'Bibliograhy Picture';";
$trans["biblioViewCallNmbr"]       = "\$text = 'Call Number';";
$trans["biblioViewTble2Hdr"]       = "\$text = 'Bibliography Copy Information';";
$trans["biblioViewTble2Col1"]      = "\$text = 'Barcode #';";
$trans["biblioViewTble2Col2"]      = "\$text = 'Description';";
$trans["biblioViewTble2Col3"]      = "\$text = 'Status';";
$trans["biblioViewTble2Col4"]      = "\$text = 'Status Dt';";
$trans["biblioViewTble2Col5"]      = "\$text = 'Due Back';";
$trans["biblioViewTble2ColFunc"]   = "\$text = 'Function';";
$trans["biblioViewTble2Coldel"]    = "\$text = 'del';";
$trans["biblioViewTble2Coledit"]   = "\$text = 'edit';";
$trans["biblioViewTble3Hdr"]       = "\$text = 'Additional Bibliographic Information';";
$trans["biblioViewNoAddInfo"]      = "\$text = 'No additional bibliographic information available.';";
$trans["biblioViewNoCopies"]       = "\$text = 'No copies have been created.';";
$trans["biblioViewOpacFlg"]        = "\$text = 'Show in OPAC';";
$trans["biblioViewNewCopy"]        = "\$text = 'Add New Copy';";
$trans["biblioViewNeweCopy"]       = "\$text = 'Add New Electronic Copy';";
$trans["biblioViewYes"]            = "\$text = 'yes';";
$trans["biblioViewNo"]             = "\$text = 'no';";

#****************************************************************************
#*  Translation text for page biblio_search.php
#****************************************************************************
$trans["biblioSearchNoResults"]    = "\$text = 'No results found.';";
$trans["biblioSearchResults"]      = "\$text = 'Search Results';";
$trans["biblioSearchResultPages"]  = "\$text = 'Result Pages';";
$trans["biblioSearchPrev"]         = "\$text = 'prev';";
$trans["biblioSearchNext"]         = "\$text = 'next';";
$trans["First"]                    = "\$text = 'First';";
$trans["Last"]                     = "\$text = 'Last';";
$trans["biblioSearchResultTxt"]    = "if (%items% == 1) {
                                        \$text = '%items% result found.';
                                      } else {
                                        \$text = '%items% results found';
                                      }";
$trans["biblioSearchauthor"]       = "\$text = ' sorted by author';";
$trans["biblioSearchtitle"]        = "\$text = ' sorted by title';";
$trans["biblioSearchSortByAuthor"] = "\$text = 'sort by author';";
$trans["biblioSearchSortByTitle"]  = "\$text = 'sort by title';";
$trans["biblioSearchTitle"]        = "\$text = 'Title';";
$trans["biblioSearchTitleRemainder"] = "\$text = 'Title Remainder';";
$trans["biblioSearchAuthor"]       = "\$text = 'Author';";
$trans["biblioSearchMaterial"]     = "\$text = 'Material';";
$trans["biblioSearchCollection"]   = "\$text = 'Collection';";
$trans["biblioSearchCall"]         = "\$text = 'Call Number';";
$trans["biblioSearchCopyBCode"]    = "\$text = 'Copy Barcode';";
$trans["biblioSearchCopyStatus"]   = "\$text = 'Status';";
$trans["biblioSearchNoCopies"]     = "\$text = 'No copies are available.';";
$trans["biblioSearchHold"]         = "\$text = 'hold';";
$trans["biblioSearchOutIn"]        = "\$text = 'check out/in';";
$trans["biblioSearchDetail"]       = "\$text = 'Show detailed Bibliography information';";
$trans["biblioSearchBCode2Chk"]    = "\$text = 'Barcode to Check Out or Check In Form';";
$trans["biblioSearchBCode2Hold"]   = "\$text = 'Barcode to Hold Form';";

#****************************************************************************
#*  Translation text for page loginform.php
#****************************************************************************
$trans["loginFormTbleHdr"]         = "\$text = 'Staff Login';";
$trans["loginFormUsername"]        = "\$text = 'Username';";
$trans["loginFormPassword"]        = "\$text = 'Password';";
$trans["loginFormLogin"]           = "\$text = 'Login';";

#****************************************************************************
#*  Translation text for page login.php
#****************************************************************************
$trans["loginUserNameReqErr"]      = "\$text = 'Username is required.';";
$trans["loginPwdReqErr"]           = "\$text = 'Password is required.';";
$trans["loginPwdInvErr"]           = "\$text = 'Invalid signon.';";

#****************************************************************************
#*  Translation text for page hold_del_confirm.php
#****************************************************************************
$trans["holdDelConfirmMsg"]        = "\$text = 'Are you sure you want to delete this hold request?';";

#****************************************************************************
#*  Translation text for page hold_del.php
#****************************************************************************
$trans["holdDelSuccess"]           = "\$text='Hold request was successfully deleted.';";

#****************************************************************************
#*  Translation text for page help_header.php
#****************************************************************************
$trans["helpHeaderTitle"]          = "\$text='OpenBiblio Help';";
$trans["helpHeaderCloseWin"]       = "\$text='Close Window';";
$trans["helpHeaderContents"]       = "\$text='Contents';";
$trans["helpHeaderPrint"]          = "\$text='Print';";

$trans["catalogResults"]           = "\$text='Search Results';";
$trans["Revise Page"]              = "\$text='Revise Page';";
$trans["wiki updates to this page"] = "\$text='wiki updates to this page';";


#****************************************************************************
#*  Translation text for page header.php and header_opac.php
#****************************************************************************
$trans["headerTodaysDate"]         = "\$text='today\'s date:';";
$trans["headerDateFormat"]         = "\$text='M d, Y';";
$trans["headerLibraryHours"]       = "\$text='library hours:';";
$trans["headerLibraryPhone"]       = "\$text='library phone:';";
$trans["headerHome"]               = "\$text='Home';";
$trans["headerCirculation"]        = "\$text='Circulation';";
$trans["headerCataloging"]         = "\$text='Cataloging';";
$trans["headerAdmin"]              = "\$text='Admin';";
$trans["headerReports"]            = "\$text='Reports';";

#****************************************************************************
#*  Translation text for page footer.php
#****************************************************************************
$trans["footerLibraryHome"]        = "\$text='Library Home';";
$trans["footerOPAC"]               = "\$text='OPAC';";
$trans["footerHelp"]               = "\$text='Help';";
$trans["footerPoweredBy"]          = "\$text='Powered by OpenBiblio version';";
$trans["footerDatabaseVersion"]    = "\$text='database version';";
$trans["footerCopyright"]          = "\$text='Copyright';";
$trans["footerUnderThe"]           = "\$text='under the';";
$trans["footerGPL"]                = "\$text='GNU General Public License';";

?>
