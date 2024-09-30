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
$trans["sharedSubmit"]             = "\$text = 'Submit';";
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
$trans["PasswordForgotten"]	   = "\$text = 'Forgotten password?';";

#****************************************************************************
#*  Translation text for page login.php
#****************************************************************************
$trans["loginUserNameReqErr"]      = "\$text = 'Username is required or not correct.';";
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

#**************************************************************************************
#*  Translation text for page 
#   - circ/
#   - opac/
#   -- mbr_pwd_reset_form.php
#   -- mbr_pwd_newset.php
#   -- mbr_pwd_newset_form.php
#   - admin/staff_pwd_newset_form.php
#**************************************************************************************
$trans["mbr_pwd_create_form_Resetheader"]   = "\$text = 'Create member password:';";
$trans["mbr_pwd_reset_form_Resetheader"]    = "\$text = 'Reset member password:';";
$trans["staff_pwd_reset_form_Resetheader"]  = "\$text = 'Reset staff password:';";
$trans["new_form_Password"]                 = "\$text = 'Password:';";
$trans["PwdRequirement"]                    = "\$text = '<p style=\"color: #1a62ac;\">Rules: Password must have between 8 and 20 characters, at least 1 digit(s), <br />"
        . "at least 1 lower case letter(s), at least 1 upper case letter(s), at least 1 non-alphanumeric character(s) (allowed: @_#§%$)</p>';";
$trans["new_form_Reenterpassword"]          = "\$text = 'Repeat password:';";

#****************************************************************************
#*  Translation text for page circ/ and opac/mbr_pwd_reset.php
#****************************************************************************
$trans["mbr_return"]                       = "\$text = 'Return to member profil';";
$trans["PwdResetSuccessfully"]             = "\$text = 'Password was changed successfully.';";

#****************************************************************************
#*  Translation text for page circ/ and shared/timeout.php
#****************************************************************************
$trans["PwdTimeout"]                       = "\$text = 'Your account is blocked for %time% minutes due to too many incorrect entries';";

#****************************************************************************
#*  Translation text for page shared/supsended.php
#****************************************************************************
$trans["staffSuspended"]                   = "\$text = 'Ihr Account ist deaktiviert worden.';";

#****************************************************************************
#*  Translation text for files in folders opac and shared
#   mbr_pwd_forget_form.php, mbr_pwd_forget.php and mbr_pwd_newset_form.php
#   staff_pwd_forget_form.php, staff_pwd_forget.php and staff_pwd_newset.php
#****************************************************************************
$trans["PwdForgottenSettingNone"]          = "\$text = 'Forgot password function is deactivated.';";
$trans["PwdForgotten"]                     = "\$text = 'Request a new password:';";
$trans["PwdForgottenInfo"]                 = "\$text = 'To reset your password, please enter either your user name "
                                                        . "or your e-mail address. If you can be found in the database, "
                                                        . "a message will be sent to your e-mail address.';";
$trans["email"]                            = "\$text = 'E-Mail:';";
$trans["barcodeNmbr"]                      = "\$text = 'Barcode Number:';";
$trans["or"]                               = "\$text = 'or';";
$trans["and"]                              = "\$text = 'and';";
$trans["NewPassword"]                      = "\$text = 'New Password';";
$trans["errEmailMissing"]                  = "\$text = 'Please enter an e-mail address!';";
$trans["errbarcodeNmbrMissing"]            = "\$text = 'Bitte Benutzernummer eingeben!';";
$trans["errNoUserFound"]                   = "\$text = 'No user found!';";
$trans["errNoPwdForgottenCode"]            = "\$text = 'No forgotten password code could be created!';";
$trans["errTooManyUserFound"]              = "\$text = 'Too many users found with the same e-mail. "
                                                        . "Please use the input field for your user name!';";
$trans["errMailCouldNotBeSent"]            = "\$text = 'Message could not be sent.';";
$trans["SendMailForPwdForgottenCode"]      = "\$text = 'If you have entered the user name or the unique e-mail address "
                                                    . "correctly, an automatic e-mail will be sent to you.';";
$trans["TooManyAttempts"]                  = "\$text = 'Too many attempts!';";
$trans["errExpiredPwdForgottenCode"]       = "\$text = 'Unfortunately your code has expired.';";
$trans["errInvalidPwdForgottenURL"]        = "\$text = 'Make sure that you have the exact link in the URL!';";

?>
