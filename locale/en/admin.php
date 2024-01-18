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
$trans["adminSubmit"]              = "\$text = 'Submit';";
$trans["adminCancel"]              = "\$text = 'Cancel';";
$trans["adminDelete"]              = "\$text = 'Delete';";
$trans["adminUpdate"]              = "\$text = 'Update';";
$trans["adminFootnote"]            = "\$text = 'Fields marked with %symbol% are required.';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'Admin';";
$trans["indexDesc"]                = "\$text = 'Use the functions located in the left hand navigation area to manage your library\'s staff and administrative records.';";

#****************************************************************************
#*  Translation text for page collections*.php
#****************************************************************************
$trans["adminCollections_delReturn"]                 = "\$text = 'return to collection list';";
$trans["adminCollections_delStart"]                 = "\$text = 'Collection, ';";

#****************************************************************************
#*  Translation text for page collections_del.php
#****************************************************************************
$trans["adminCollections_delEnd"]                 = "\$text = ', has been deleted.';";

#****************************************************************************
#*  Translation text for page collections_del_confirm.php
#****************************************************************************
$trans["adminCollections_del_confirmText"]                 = "\$text = 'Are you sure you want to delete collection, ';";

#****************************************************************************
#*  Translation text for page collections_edit.php
#****************************************************************************
$trans["adminCollections_editEnd"]                 = "\$text = ', has been updated.';";

#****************************************************************************
#*  Translation text for page collections_edit_form.php
#****************************************************************************
$trans["adminCollections_edit_formEditcollection"]                 = "\$text = 'Edit Collection:';";
$trans["adminCollections_edit_formDescription"]                 = "\$text = 'Description:';";
$trans["adminCollections_edit_formDaysdueback"]                 = "\$text = 'Days Due Back:';";
$trans["adminCollections_edit_formDailyLateFee"]                 = "\$text = 'Daily Late Fee:';";
$trans["adminCollections_edit_formNote"]                 = "\$text = '*Note:';";
$trans["adminCollections_edit_formNoteText"]                 = "\$text = 'Setting the days due back to zero makes the entire collection unavailable for checkout.';";

#****************************************************************************
#*  Translation text for page collections_list.php
#****************************************************************************
$trans["adminCollections_listAddNewCollection"]                 = "\$text = 'Add New Collection';";
$trans["adminCollections_listCollections"]                 = "\$text = 'Collections:';";
$trans["adminCollections_listFunction"]                 = "\$text = 'Function';";
$trans["adminCollections_listDescription"]                 = "\$text = 'Description';";
$trans["adminCollections_listDaysdueback"]                 = "\$text = 'Days<br>Due Back';";
$trans["adminCollections_listDailylatefee"]                 = "\$text = 'Daily<br>Late Fee';";
$trans["adminCollections_listBibliographycount"]                 = "\$text = 'Bibliography<br>Count';";
$trans["adminCollections_listEdit"]                 = "\$text = 'Edit';";
$trans["adminCollections_listDel"]                 = "\$text = 'del';";
$trans["adminCollections_ListNote"]                 = "\$text = '*Note:';";
$trans["adminCollections_ListNoteText"]                 = "\$text = 'The delete function is only available on collections that have a bibliography count of zero.<br>If you wish to delete a collection with a bibliography count greater than zero you will first need to change the material type on those bibliographies to another material type.';";

#****************************************************************************
#*  Translation text for page collections_new.php
#****************************************************************************
$trans["adminCollections_newAdded"]                 = "\$text = ', has been added.';";

#****************************************************************************
#*  Translation text for page collections_new_form.php
#****************************************************************************
$trans["adminCollections_new_formAddnewcollection"]                 = "\$text = 'Add New Collection:';";
$trans["adminCollections_new_formDescription"]                 = "\$text = 'Description:';";
$trans["adminCollections_new_formDaysdueback"]                 = "\$text = 'Days Due Back:';";
$trans["adminCollections_new_formDailylatefee"]                 = "\$text = 'Daily Late Fee:';";
$trans["adminCollections_new_formNote"]                 = "\$text = '*Note:';";
$trans["adminCollections_new_formNoteText"]                 = "\$text = 'Setting the days due back to zero makes the entire collection unavailable for checkout.';";

#****************************************************************************
#*  Translation text for page materials_del.php
#****************************************************************************
$trans["admin_materials_delMaterialType"]                 = "\$text = 'Material type, ';";
$trans["admin_materials_delMaterialdeleted"]                 = "\$text = ', has been deleted.';";
$trans["admin_materials_Return"]                 = "\$text = 'return to material type list';";

#****************************************************************************
#*  Translation text for page materials_del_form.php
#****************************************************************************
$trans["admin_materials_delAreyousure"]                 = "\$text = 'Are you sure you want to delete material type, ';";

#****************************************************************************
#*  Translation text for page materials_edit_form.php
#****************************************************************************
$trans["admin_materials_delEditmaterialtype"]                 = "\$text = 'Edit Material Type:';";
$trans["admin_materials_delDescription"]                 = "\$text = 'Description:';";
$trans["admin_materials_delunlimited"]                 = "\$text = '(enter 0 for unlimited)';";
$trans["admin_materials_delImagefile"]                 = "\$text = 'Image File:';";
$trans["admin_materials_delNote"]                 = "\$text = '*Note:';";
$trans["admin_materials_delNoteText"]                 = "\$text = 'Image files must be located in the openbiblio/images directory.';";

#****************************************************************************
#*  Translation text for page materials_edit.php
#****************************************************************************
$trans["admin_materials_editEnd"]                 = "\$text = ', has been updated.';";

#****************************************************************************
#*  Translation text for page materials_list.php
#****************************************************************************
$trans["admin_materials_listAddmaterialtypes"]                 = "\$text = 'Add New Material Type';";
$trans["admin_materials_listMaterialtypes"]                 = "\$text = 'Material Types:';";
$trans["admin_materials_listFunction"]                 = "\$text = 'Function';";
$trans["admin_materials_listDescription"]                 = "\$text = 'Description';";
$trans["admin_materials_listLimits"]                 = "\$text = 'Limits';";
$trans["admin_materials_listCheckoutlimit"]                 = "\$text = 'Checkout';";
$trans["admin_materials_listRenewallimit"]                 = "\$text = 'Renewal';";
$trans["admin_materials_listImageFile"]                 = "\$text = 'Image<br>File';";
$trans["admin_materials_listBibcount"]                 = "\$text = 'Bibliography<br>Count';";
$trans["admin_materials_listEdit"]                 = "\$text = 'edit';";
$trans["admin_materials_listDel"]                 = "\$text = 'del';";
$trans["admin_materials_listNote"]                 = "\$text = '*Note:';";
$trans["admin_materials_listNoteText"]                 = "\$text = 'The delete function is only available on material types that have a bibliography count of zero.  If you wish to delete a material type with a bibliography count greater than zero you will first need to change the material type on those bibliographies to another material type.';";
$trans["No fields found!"]                 = "\$text = 'No fields found!';";

#****************************************************************************
#*  Translation text for page materials_new.php
#****************************************************************************
$trans["admin_materials_listNewadded"]                 = "\$text = ', has been added.';";

#****************************************************************************
#*  Translation text for page materials_new_form.php
#****************************************************************************
$trans["admin_materials_new_formNoteText"]                 = "\$text = 'Image files must be located in the openbiblio/images directory.';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["admin_noauth"]                 = "\$text = 'You are not authorized to use the Admin tab.';";

#****************************************************************************
#*  Translation text for page settings_edit.php
#****************************************************************************

#****************************************************************************
#*  Translation text for page settings_edit_form.php
#****************************************************************************
$trans["admin_settingsUpdated"]                 = "\$text = 'Data has been updated.';";
$trans["admin_settingsEditsettings"]                 = "\$text = 'Edit Library Settings:';";
$trans["admin_settingsLibName"]                 = "\$text = 'Library Name:';";
$trans["admin_settingsLibimageurl"]                 = "\$text = 'Library Image URL:';";
$trans["admin_settingsOnlyshowimginheader"]                 = "\$text = 'Only Show Image in Header:';";
$trans["admin_settingsLibhours"]                 = "\$text = 'Library Hours:';";
$trans["admin_settingsLibphone"]                 = "\$text = 'Library Phone:';";
$trans["admin_settingsLibURL"]                 = "\$text = 'Library URL:';";
$trans["admin_settingsOPACURL"]                 = "\$text = 'OPAC URL:';";
$trans["admin_settingsSessionTimeout"]                 = "\$text = 'Session Timeout:';";
$trans["admin_settingsMinutes"]                 = "\$text = 'minutes';";
$trans["admin_settingsSearchResults"]                 = "\$text = 'Search Results:';";
$trans["admin_settingsItemsperpage"]                 = "\$text = 'items per page';";
$trans["admin_settingsPurgebibhistory"]                 = "\$text = 'Purge Bibliography History After:';";
$trans["admin_settingsmonths"]                 = "\$text = 'months';";
$trans["admin_settingsBlockCheckouts"]                 = "\$text = 'Block Checkouts When Fines Due:';";
$trans["Max. hold length:"]                 = "\$text = 'Max. hold length:';";
$trans["days"]                              = "\$text = 'days';";
$trans["admin_settingsLocale"]                 = "\$text = 'Locale:';";
$trans["admin_settingsHTMLChar"]                 = "\$text = 'HTML Charset:';";
$trans["admin_settingsHTMLTagLangAttr"]                 = "\$text = 'HTML Tag Lang Attribute:';";
$trans["If the month value for purging history is higher than zero, values in statistics reports shift over time.<br>Data from statistics reports should be saved outside OpenBiblio for future reference."]                 = "\$text = 'If the month value for purging history is higher than zero, values in statistics reports shift over time.<br>Data from statistics reports should be saved outside OpenBiblio for future reference.';";

#****************************************************************************
#*  Translation text for all staff pages
#****************************************************************************
$trans["adminStaff_Staffmember"]                 = "\$text = 'Staff member,';";
$trans["adminStaff_Return"]                 = "\$text = 'return to staff list';";
$trans["adminStaff_Yes"]                 = "\$text = 'Yes';";
$trans["adminStaff_No"]                 = "\$text = 'No';";


#****************************************************************************
#*  Translation text for page staff_del.php
#****************************************************************************
$trans["adminStaff_delDeleted"]                 = "\$text = ', has been deleted.';";

#****************************************************************************
#*  Translation text for page staff_delete_confirm.php
#****************************************************************************
$trans["adminStaff_del_confirmConfirmText"]                 = "\$text = 'Are you sure you want to delete staff member, ';";

#****************************************************************************
#*  Translation text for page staff_edit.php
#****************************************************************************
$trans["adminStaff_editUpdated"]                 = "\$text = ', has been updated.';";

#****************************************************************************
#*  Translation text for page staff_edit_form.php
#****************************************************************************
$trans["adminStaff_edit_formHeader"]                 = "\$text = 'Edit Staff Member Information:';";
$trans["adminStaff_edit_formLastname"]                 = "\$text = 'Last Name:';";
$trans["adminStaff_edit_formFirstname"]                 = "\$text = 'First Name:';";
$trans["adminStaff_edit_formLogin"]                 = "\$text = 'Login Username:';";
$trans["adminStaff_edit_formAuth"]                 = "\$text = 'Authorization:';";
$trans["adminStaff_edit_formCirc"]                 = "\$text = 'Circ';";
$trans["adminStaff_edit_formUpdatemember"]                 = "\$text = 'Update Member';";
$trans["adminStaff_edit_formCatalog"]                 = "\$text = 'Catalog';";
$trans["adminStaff_edit_formAdmin"]                 = "\$text = 'Admin';";
$trans["adminStaff_edit_formReports"]                 = "\$text = 'Reports';";
$trans["adminStaff_edit_formSuspended"]                 = "\$text = 'Suspended:';";

#****************************************************************************
#*  Translation text for page staff_list.php
#****************************************************************************
$trans["adminStaff_list_formHeader"]                 = "\$text = 'Add New Staff Member';";
$trans["adminStaff_list_Columnheader"]                 = "\$text = ' Staff Members:';";
$trans["adminStaff_list_Function"]                 = "\$text = 'Function';";
$trans["adminStaff_list_Edit"]                 = "\$text = 'edit';";
$trans["adminStaff_list_Pwd"]                 = "\$text = 'pwd';";
$trans["adminStaff_list_Del"]                 = "\$text = 'del';";

#****************************************************************************
#*  Translation text for page staff_new.php
#****************************************************************************
$trans["adminStaff_new_Added"]                 = "\$text = ', has been added.';";

#****************************************************************************
#*  Translation text for page staff_new_form.php
#****************************************************************************
$trans["adminStaff_new_form_Header"]          	= "\$text = 'Add New Staff Member:';";
$trans["adminStaff_new_form_Password"]          = "\$text = 'Password:';";
$trans["adminStaff_new_form_Reenterpassword"]   = "\$text = 'Re-enter Password:';";

#****************************************************************************
#*  Translation text for page staff_pwd_reset.php
#****************************************************************************
$trans["adminStaff_pwd_reset_Passwordreset"]   = "\$text = 'Password has been reset.';";

#****************************************************************************
#*  Translation text for page staff_pwd_reset_form.php
#****************************************************************************
$trans["adminStaff_pwd_reset_form_Resetheader"]   = "\$text = 'Reset Staff Member Password:';";

#****************************************************************************
#*  Translation text for theme pages
#****************************************************************************
$trans["adminTheme_Return"]                 = "\$text = 'return to theme list';";
$trans["adminTheme_Theme"]                 = "\$text = 'Theme, ';";

#****************************************************************************
#*  Translation text for page theme_del.php
#****************************************************************************
$trans["adminTheme_Deleted"]                 = "\$text = ', has been deleted.';";
#****************************************************************************
#*  Translation text for page theme_del_confirm.php
#****************************************************************************
$trans["adminTheme_Deleteconfirm"]                 = "\$text = 'Are you sure you want to delete theme, ';";
#****************************************************************************
#*  Translation text for page theme_edit.php
#****************************************************************************
$trans["adminTheme_Updated"]                 = "\$text = ', has been updated.';";

#****************************************************************************
#*  Translation text for page theme_edit_form.php
#****************************************************************************
$trans["adminTheme_Preview"]                 = "\$text = 'Preview Theme Changes';";

#****************************************************************************
#*  Translation text for page theme_list.php
#****************************************************************************
$trans["adminTheme_Changetheme"]                 = "\$text = 'Change Theme In Use:';";
$trans["adminTheme_Choosetheme"]                 = "\$text = 'Choose a New Theme:';";
$trans["adminTheme_Addnew"]                 = "\$text = 'Add New Theme';";
$trans["adminTheme_themes"]                 = "\$text = 'Themes:';";
$trans["adminTheme_function"]                 = "\$text = 'Function';";
$trans["adminTheme_Themename"]                 = "\$text = 'Theme Name';";
$trans["adminTheme_Usage"]                 = "\$text = 'Usage';";
$trans["adminTheme_Edit"]                 = "\$text = 'edit';";
$trans["adminTheme_Copy"]                 = "\$text = 'copy';";
$trans["adminTheme_Del"]                 = "\$text = 'del';";
$trans["adminTheme_Inuse"]                 = "\$text = 'in use';";
$trans["adminTheme_Note"]                 = "\$text = '*Note:';";
$trans["adminTheme_Notetext"]                 = "\$text = 'The delete function is not available on the theme that is currently in use.';";

#****************************************************************************
#*  Translation text for page theme_list.php
#****************************************************************************
$trans["adminTheme_Theme2"]                 = "\$text = 'Theme:';";
$trans["adminTheme_Tablebordercolor"]                 = "\$text = 'Table Border Color:';";
$trans["adminTheme_Errorcolor"]                 = "\$text = 'Error Color:';";
$trans["adminTheme_Tableborderwidth"]                 = "\$text = 'Table Border Width:';";
$trans["adminTheme_Tablecellpadding"]                 = "\$text = 'Table Cell Padding:';";
$trans["adminTheme_Title"]                 = "\$text = 'Title';";
$trans["adminTheme_Mainbody"]                 = "\$text = 'Main Body';";
$trans["adminTheme_Navigation"]                 = "\$text = 'Navigation';";
$trans["adminTheme_Tabs"]                 = "\$text = 'Tabs';";
$trans["adminTheme_Backgroundcolor"]                 = "\$text = 'Background Color:';";
$trans["adminTheme_Fontface"]                 = "\$text = 'Font Face:';";
$trans["adminTheme_Fontsize"]                 = "\$text = 'Font Size:';";
$trans["adminTheme_Bold"]                 = "\$text = 'bold';";
$trans["adminTheme_Fontcolor"]                 = "\$text = 'Font Color:';";
$trans["adminTheme_Linkcolor"]                 = "\$text = 'Link Color:';";
$trans["adminTheme_Align"]                 = "\$text = 'Align:';";
$trans["adminTheme_Right"]                 = "\$text = 'Right';";
$trans["adminTheme_Left"]                 = "\$text = 'Left';";
$trans["adminTheme_Center"]                 = "\$text = 'Center';";

$trans["adminTheme_HeaderWording"]                 = "\$text = 'Edit';";


#****************************************************************************
#*  Translation text for page theme_new.php
#****************************************************************************
$trans["adminTheme_new_Added"]                 = "\$text = ', has been added.';";

#****************************************************************************
#*  Translation text for page theme_new_form.php
#****************************************************************************

#****************************************************************************
#*  Translation text for page theme_preview.php
#****************************************************************************
$trans["adminTheme_preview_Themepreview"]                 = "\$text = 'Theme Preview';";
$trans["adminTheme_preview_Librarytitle"]                 = "\$text = 'Library Title';";
$trans["adminTheme_preview_CloseWindow"]                 = "\$text = 'Close Window';";
$trans["adminTheme_preview_Home"]                 = "\$text = 'Home';";
$trans["adminTheme_preview_Circulation"]   = "\$text = 'Circulation';";
$trans["adminTheme_preview_Cataloging"]    = "\$text = 'Cataloging';";
$trans["adminTheme_preview_Admin"]         = "\$text = 'Admin';";
$trans["adminTheme_preview_Samplelink"]    = "\$text = 'Sample Link';";
$trans["adminTheme_preview_Thisstart"]     = "\$text = 'This is a preview of the ';";
$trans["adminTheme_preview_Thisend"]       = "\$text = 'theme.';";
$trans["adminTheme_preview_Samplelist"]    = "\$text = 'Sample List:';";
$trans["adminTheme_preview_Tableheading"]  = "\$text = 'Table Heading';";
$trans["adminTheme_preview_Sampledatarow1"]= "\$text = 'Sample data row 1';";
$trans["adminTheme_preview_Sampledatarow2"]= "\$text = 'Sample data row 2';";
$trans["adminTheme_preview_Sampledatarow3"]= "\$text = 'Sample data row 3';";
$trans["adminTheme_preview_Samplelink"]    = "\$text = 'sample link';";
$trans["adminTheme_preview_Sampleerror"]   = "\$text = 'sample error';";
$trans["adminTheme_preview_Sampleinput"]   = "\$text = 'Sample Input';";
$trans["adminTheme_preview_Samplebutton"]  = "\$text = 'Sample Button';";
$trans["adminTheme_preview_Poweredby"]     = "\$text = 'Powered by OpenBiblio';";
$trans["adminTheme_preview_Copyright"]     = "\$text = 'Copyright &copy; 2002-2005 Dave Stevens';";
$trans["adminTheme_preview_underthe"]      = "\$text = 'under the';";
$trans["adminTheme_preview_GNU"]           = "\$text = 'GNU General Public License';";

#****************************************************************************
#*  Translation text for page theme_use.php
#****************************************************************************

#****************************************************************************
#*  Translation text for Checkout Privs
#****************************************************************************
$trans["Privileges updated"]               = "\$text = 'Privileges updated';";
$trans["Edit Checkout Privileges"]         = "\$text = 'Edit Checkout Privileges';";
$trans["Material Type:"]                   = "\$text = 'Material Type:';";
$trans["Member Classification:"]           = "\$text = 'Member Classification:';";
$trans["Checkout Limit:"]                  = "\$text = 'Checkout Limit:';";
$trans["Renewal Limit:"]                   = "\$text = 'Renewal Limit:';";
$trans["Checkout Privileges"]              = "\$text = 'Checkout Privileges';";
$trans["function"]                         = "\$text = 'function';";
$trans["Material Type"]                    = "\$text = 'Material Type';";
$trans["Member Classification"]            = "\$text = 'Member Classification';";
$trans["Checkout Limit"]                   = "\$text = 'Checkout Limit';";
$trans["Renewal Limit"]                    = "\$text = 'Renewal Limit';";
$trans["edit"]                             = "\$text = 'edit';";

#****************************************************************************
#*  Translation text for Copy Fields 
#****************************************************************************

$trans["Copy field, %desc%, has been deleted."] = "\$text = 'Copy field, %desc%, has been deleted.';";
$trans["return to copy field list"]             = "\$text = 'return to copy field list';";
$trans["return to copy fields list"]             = "\$text = 'return to copy field list';";
$trans["Are you sure you want to delete field '%desc%'?"] = "\$text = 'Are you sure you want to delete field \'%desc%\'?';";
$trans["Copy field, %desc%, has been updated."] = "\$text = 'Copy field, %desc%, has been updated.';";
$trans["Edit Copy Field"]                       = "\$text = 'Edit Copy Field';";
$trans["Code:"]                                 = "\$text = 'Code:';";
$trans["Description:"]                          = "\$text = 'Description:';";
$trans["Add new custom field"]                  = "\$text = 'Add new custom field';";
$trans["Custom Copy Fields"]                    = "\$text = 'Custom Copy Fields';";
$trans["function"]                              = "\$text = 'function';";
$trans["Code"]                                  = "\$text = 'Code';";
$trans["Description"]                           = "\$text = 'Description';";
$trans["del"]                                   = "\$text = 'del';";
$trans["Copy field, %desc%, has been added."]   = "\$text = 'Copy field, %desc%, has been added.';";
$trans["Add custom copy field"]                 = "\$text = 'Add custom copy field';";

#****************************************************************************
#*  Translation text for Member Classify 
#****************************************************************************

$trans["Classification type, %desc%, has been deleted."] = "\$text = 'Classification type, %desc%, has been deleted.';";
$trans["return to member classification list"]           = "\$text = 'return to member classification list';";
$trans["Are you sure you want to delete classification '%desc%'?"] = "\$text = 'Are you sure you want to delete classification \'%desc%\'?';";
$trans["Classification type, %desc%, has been updated."] = "\$text = 'Classification type, %desc%, has been updated.';";
$trans["Edit Classification Type"]                       = "\$text = 'Edit Classification Type';";
$trans["Max. Fines:"]                                    = "\$text = 'Max. Fines:';";
$trans["Add new member classification"]                  = "\$text = 'Add new member classification';";
$trans["Member Classifications List"]                    = "\$text = 'Member Classifications List';";
$trans["Max. Fines"]                                     = "\$text = 'Max. Fines';";
$trans["Members"]                                        = "\$text = 'Members';";
$trans["*Note:"]                                         = "\$text = '*Note:';";
$trans["The delete function is only available on classifications that have a member count of zero.  If you wish to delete a classification with a member count greater than zero you will first need to change those members to another classification."]     = "\$text = 'The delete function is only available on classifications that have a member count of zero.  If you wish to delete a classification with a member count greater than zero you will first need to change those members to another classification.';";
$trans["Classification type, %desc%, has been added."]   = "\$text = 'Classification type, %desc%, has been added.';";
$trans["Add new classification type"]                    = "\$text = 'Add new classification type';";

#****************************************************************************
#*  Translation text for Member Fields
#****************************************************************************

$trans["Member field, %desc%, has been deleted."] = "\$text = 'Member field, %desc%, has been deleted.';";
$trans["return to member field list"]             = "\$text = 'return to member field list';";
$trans["return to member fields list"]             = "\$text = 'return to member field list';";
$trans["Member field, %desc%, has been updated."] = "\$text = 'Member field, %desc%, has been updated.';";
$trans["Edit Member Field"]                       = "\$text = 'Edit Member Field';";
$trans["Custom Member Fields"]                    = "\$text = 'Custom Member Fields';";
$trans["Member field, %desc%, has been added."]   = "\$text = 'Member field, %desc%, has been added.';";
$trans["Add custom member field"]                 = "\$text = 'Add custom member field';";

?>
