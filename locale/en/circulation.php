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
$trans["circCancel"] = "\$text = 'Cancel';";
$trans["circDelete"] = "\$text = 'Delete';";
$trans["circLogout"] = "\$text = 'Logout';";
$trans["circAdd"] = "\$text = 'Add';";
$trans["mbrDupBarcode"] = "\$text = 'Barcode number, %barcode%, is currently in use.';";

# ****************************************************************************
# * Translation text for page index.php
# ****************************************************************************
$trans["indexHeading"] = "\$text='Circulation';";
$trans["indexCardHdr"] = "\$text='Search Member by Card Number:';";
$trans["indexCard"] = "\$text='Card Number:';";
$trans["indexSearch"] = "\$text='Search';";
$trans["indexNameHdr"] = "\$text='Search Member by Last Name:';";
$trans["indexName"] = "\$text='Last name start with:';";

# ****************************************************************************
# * Translation text for page mbr_new_form.php, mbr_edit_form.php and mbr_fields.php
# ****************************************************************************
$trans["Mailing Address:"] = "\$text='Mailing Address:';";
$trans["mbrNewForm"] = "\$text='Add New';";
$trans["mbrEditForm"] = "\$text='Edit';";
$trans["mbrFldsHeader"] = "\$text='Member:';";
$trans["mbrFldsCardNmbr"] = "\$text='Card Number:';";
$trans["mbrFldsLastName"] = "\$text='Last Name:';";
$trans["mbrFldsFirstName"] = "\$text='First Name:';";
$trans["mbrFldsAddr1"] = "\$text='Address Line 1:';";
$trans["mbrFldsAddr2"] = "\$text='Address Line 2:';";
$trans["mbrFldsCity"] = "\$text='City:';";
$trans["mbrFldsStateZip"] = "\$text='State, Zip:';";
$trans["mbrFldsHomePhone"] = "\$text='Home Phone:';";
$trans["mbrFldsWorkPhone"] = "\$text='Work Phone:';";
$trans["mbrFldsEmail"] = "\$text='Email Address:';";
$trans["mbrFldsClassify"] = "\$text='Classification:';";
$trans["mbrFldsGrade"] = "\$text='School Grade:';";
$trans["mbrFldsTeacher"] = "\$text='School Teacher:';";
$trans["mbrFldsMbrShip"] = "\$text='Membership Ends (yyyy-mm-dd):';";
$trans["mbrFldsSubmit"] = "\$text='Submit';";
$trans["mbrFldsCancel"] = "\$text='Cancel';";
$trans["mbrsearchResult"] = "\$text='Result Pages: ';";
$trans["mbrsearchprev"] = "\$text='prev';";
$trans["mbrsearchnext"] = "\$text='next';";
$trans["First"] = "\$text='First';";
$trans["Last"] = "\$text='Last';";
$trans["mbrsearchNoResults"] = "\$text='No results found.';";
$trans["mbrsearchFoundResults"] = "\$text=' results found.';";
$trans["mbrsearchSearchResults"] = "\$text='Search Results:';";
$trans["mbrsearchCardNumber"] = "\$text='Card Number:';";
$trans["mbrsearchClassification"] = "\$text='Classification:';";
$trans["mbr_new_form_Reenterpassword"]     = "\$text = 'Repeat password:';";
$trans["PwdRequirement"]                = "\$text = 'Rules: Password must have between 8 and 20 characters, at least 1 digit(s), <br />"
        . "at least 1 lower case letter(s), at least 1 upper case letter(s), at least 1 non-alphanumeric character(s) (allowed: @_#§%$)';";
$trans["PwdRequirementErr"]  = "\$text = 'Password must have at least 8 characters, at least 1 digit(s), at least 1 lower case letter(s),"
        . " at least 1 upper case letter(s), at least 1 non-alphanumeric character(s) (allowed: @_#§%$)';";

# ****************************************************************************
# * Translation text for page mbr_new.php (and mbr_view.php)
# ****************************************************************************
$trans["mbr_new_form_TypeOfPwdCreation"]        = "\$text = 'Password creation by e-mail?&nbsp;';";
$trans["mbr_new_form_TypeOfPwdCreationInfo"]    = "\$text = 'If you enter a valid e-mail address, a welcome message "
                                                    . "can be sent by e-mail with a link to create an own password';";
$trans["mbr_new_form_Reenterpassword"]          = "\$text = 'Repeat password:';";
$trans["mbr_new_form_Password"]                 = "\$text = 'Password:';";
$trans["errNoPwdForgottenCode"]                 = "\$text = 'No password code could be created!';";
$trans["mbrNewSuccess"]                         = "\$text='Member has been successfully added.';";
$trans["mbrNewMailingSuccessful"]               = "\$text='Welcome e-mail with password creation was sent successfully.';";
$trans["errMailCouldNotBeSent"]                 = "\$text = 'Message could not be sent.';";
$trans["mbrNoPassword"]                         = "\$text = '<p style=\"font-weight: bold; color: red;\";>No password set!</p>';";

# ****************************************************************************
# * Translation text for page mbr_edit.php
# ****************************************************************************
$trans["mbrEditSuccess"] = "\$text='Member has been successfully updated.';";
$trans["mbrRenewSuccess"] = "\$text='Membership was sucessfully renewed for %length% month.';";
$trans["All items renewed."] = "\$text='All items renewed.';";

#****************************************************************************
# * Translation text for page mbr_view.php
# ****************************************************************************
$trans["mbrViewHead1"] = "\$text='Member Information';";
$trans["mbrViewName"] = "\$text='Name:';";
$trans["mbrViewAddr"] = "\$text='Address:';";
$trans["mbrViewCardNmbr"] = "\$text='Card Number:';";
$trans["mbrViewClassify"] = "\$text='Classification:';";
$trans["mbrViewPhone"] = "\$text='Phone:';";
$trans["mbrViewPhoneHome"] = "\$text='H:';";
$trans["mbrViewPhoneWork"] = "\$text='W:';";
$trans["mbrViewEmail"] = "\$text='Email Address:';";
$trans["mbrViewGrade"] = "\$text='School Grade:';";
$trans["mbrViewTeacher"] = "\$text='School Teacher:';";
$trans["mbrViewMbrShipEnd"] = "\$text='paid until:';";
$trans["mbrViewMbrShipNoEnd"] = "\$text='unlimited/not used';";
$trans["mbrViewHead2"] = "\$text='Checkout Stats';";
$trans["mbrViewStatColHdr1"] = "\$text='Material';";
$trans["mbrViewStatColHdr2"] = "\$text='Count';";
$trans["mbrViewStatColHdr3"] = "\$text='Limits';";
$trans["mbrViewStatColHdr4"] = "\$text='Checkout';";
$trans["mbrViewStatColHdr5"] = "\$text='Renewal';";
$trans["mbrViewHead3"] = "\$text='Bibliography Check Out';";
$trans["mbrViewBarcode"] = "\$text='Barcode Number:';";
$trans["mbrViewCheckOut"] = "\$text='Check Out';";
$trans["mbrViewHead4"] = "\$text='Bibliographies Currently Checked Out:';";
$trans["mbrViewOutHdr1"] = "\$text='Checked Out';";
$trans["mbrViewOutHdr2"] = "\$text='Material';";
$trans["mbrViewOutHdr3"] = "\$text='Barcode';";
$trans["mbrViewOutHdr4"] = "\$text='Title';";
$trans["mbrViewOutHdr5"] = "\$text='Author';";
$trans["mbrViewOutHdr6"] = "\$text='Due Back';";
$trans["mbrViewOutHdr7"] = "\$text='Days Late';";
$trans["mbrViewOutHdr8"] = "\$text='Renewal';";
$trans["mbrViewOutHdr9"] = "\$text='time/s';";
$trans["mbrViewOutHdr10"] = "\$text='Check In';";
$trans["To Shelving Cart"] = "\$text='To Shelving Cart';";
$trans["Renew item"] = "\$text='Renew item';";
$trans["mbrViewNoCheckouts"] = "\$text='No bibliographies are currently checked out.';";
$trans["mbrViewHead5"] = "\$text='Place Hold:';";
$trans["mbrViewHead6"] = "\$text='Bibliographies Currently On Hold:';";
$trans["mbrViewPlaceHold"] = "\$text='Place Hold';";
$trans["mbrViewHoldHdr1"] = "\$text='Function';";
$trans["mbrViewHoldHdr2"] = "\$text='Placed On Hold';";
$trans["mbrViewHoldHdr3"] = "\$text='Material';";
$trans["mbrViewHoldHdr4"] = "\$text='Barcode';";
$trans["mbrViewHoldHdr5"] = "\$text='Title';";
$trans["mbrViewHoldHdr6"] = "\$text='Author';";
$trans["mbrViewHoldHdr7"] = "\$text='Status';";
$trans["mbrViewHoldHdr8"] = "\$text='Due Back';";
$trans["mbrViewNoHolds"] = "\$text='No bibliographies are currently on hold.';";
$trans["mbrViewBalMsg"] = "\$text='Note: Member has an outstanding account balance of %bal%.';";
$trans["mbrViewShipEnd"] = "\$text='Attention: Membership of this member has expired!';";
$trans["mbrPrintCheckouts"] = "\$text='print checkouts';";
$trans["Renew All"] = "\$text='Renew All';";
$trans["mbrViewDel"] = "\$text='del';";
$trans["mbrViewRenew1"] = "\$text='Renew membership for';";
$trans["mbrViewRenew2"] = "\$text='month.<br>Since Today or since Paid-Until-Date, if it\'s in future.';";
$trans["Due Date:"] = "\$text='Due Date:';";
$trans["Override Due Date"] = "\$text='Override Due Date';";
$trans["Cancel"] = "\$text='Cancel';";

# ****************************************************************************
# * Translation text for page checkout.php
# ****************************************************************************
$trans["checkoutBalErr"] = "\$text='Member must pay outstanding account balance before checking out.';";
$trans["checkoutEndErr"] = "\$text='Member must renew membership before checking out.';";
$trans["checkoutErr1"] = "\$text='Barcode number must be all alphanumeric.';";
$trans["checkoutErr2"] = "\$text='No bibliography was found with that barcode number.';";
$trans["checkoutErr3"] = "\$text='Bibliography with barcode number %barcode% is already checked out.';";
$trans["checkoutErr4"] = "\$text='Bibliography with barcode number %barcode% is not available for checkout.';";
$trans["checkoutErr5"] = "\$text='Bibliography with barcode number %barcode% is currently on hold for another member.';";
$trans["checkoutErr6"] = "\$text='Member has reached the checkout limit for the specified bibliography\'s material type.';";
$trans["checkoutErr7"] = "\$text='Bibliography with barcode number %barcode% has reached the member\'s renewal limit.';";
$trans["checkoutErr8"] = "\$text='Bibliography with barcode number %barcode% can not be renew as it is already late.';";

# ****************************************************************************
# * Translation text for page shelving_cart.php
# ****************************************************************************
$trans["shelvingCartErr1"] = "\$text='Barcode number must be all alphanumeric.';";
$trans["shelvingCartErr2"] = "\$text='No bibliography was found with that barcode number.';";
$trans["shelvingCartTrans"] = "\$text='Late fee (barcode=%barcode%)';";

# ****************************************************************************
# * Translation text for page checkin_form.php
# ****************************************************************************
$trans["checkinFormHdr1"] = "\$text='Bibliography Check In:';";
$trans["checkinFormBarcode"] = "\$text='Barcode Number:';";
$trans["checkinFormShelveButton"] = "\$text='Add to Shelving Cart';";
$trans["checkinFormCheckinLink1"] = "\$text='Check in selected items';";
$trans["checkinFormCheckinLink2"] = "\$text='Check in all items';";
$trans["checkinFormHdr2"] = "\$text='Current Shelving Cart List:';";
$trans["checkinFormColHdr1"] = "\$text='Date Scanned';";
$trans["checkinFormColHdr2"] = "\$text='Barcode';";
$trans["checkinFormColHdr3"] = "\$text='Title';";
$trans["checkinFormColHdr4"] = "\$text='Author';";
$trans["checkinFormEmptyCart"] = "\$text='No bibliographies are currently in shelving cart status.';";
$trans["Checked in %barcode% for "] = "\$text='Checked in %barcode% for ';";
$trans["Checked in %barcode%."] = "\$text='Checked in %barcode%.';";
$trans["checkinEndErr"] = "\$text='Membership has expired. The member must either extend membership or pay extra for %monthlate% month.';";

# ****************************************************************************
# * Translation text for page checkin.php
# ****************************************************************************
$trans["checkinErr1"] = "\$text='No items have been selected.';";

# ****************************************************************************
# * Translation text for page hold_message.php
# ****************************************************************************
$trans["holdMessageHdr"] = "\$text='Bibliography Has Been Placed On Hold!';";
$trans["holdMessageMsg1"] = "\$text='The bibliography with barcode number %barcode% that you are attempting to check in has one or more hold requests placed on it.  <b>Please file this bibliography with your held items instead of placing it on your shelving cart.</b>  The status code for this bibliography has been set to hold.';";
$trans["holdMessageMsg2"] = "\$text='Return to bibliography check in.';";

# ****************************************************************************
# * Translation text for page place_hold.php
# ****************************************************************************
$trans["placeHoldErr1"] = "\$text='Barcode number must be numeric.';";
$trans["placeHoldErr2"] = "\$text='Barcode does not exist.';";
$trans["placeHoldErr3"] = "\$text='This member already has that item checked out -- not placing hold.';";
$trans["This item is not checked out or on hold."] = "\$text='This item is not checked out or on hold.';";

# ****************************************************************************
# * Translation text for page mbr_del_confirm.php
# ****************************************************************************
$trans["mbrDelConfirmWarn"] = "\$text = 'Member, %name%, has %checkoutCount% checkout(s) and %holdCount% hold request(s).  All checked out materials must be checked in and all hold requests deleted before deleting this member.';";
$trans["mbrDelConfirmReturn"] = "\$text = 'return to member information';";
$trans["mbrDelConfirmMsg"] = "\$text = 'Are you sure you want to delete the member, %name%?  This will also delete all checkout history for this member.';";

# ****************************************************************************
# * Translation text for page mbr_del.php
# ****************************************************************************
$trans["mbrDelSuccess"] = "\$text='Member, %name%, has been deleted.';";
$trans["mbrDelReturn"] = "\$text='return to Member Search';";

# ****************************************************************************
# * Translation text for page mbr_history.php
# ****************************************************************************
$trans["mbrHistoryHead1"] = "\$text='Member Checkout History:';";
$trans["mbrHistoryNoHist"] = "\$text='No history was found.';";
$trans["mbrHistoryHdr1"] = "\$text='Barcode';";
$trans["mbrHistoryHdr2"] = "\$text='Title';";
$trans["mbrHistoryHdr3"] = "\$text='Author';";
$trans["mbrHistoryHdr4"] = "\$text='New Status';";
$trans["mbrHistoryHdr5"] = "\$text='Date of Status Change';";
$trans["mbrHistoryHdr6"] = "\$text='Due Back Date';";

# ****************************************************************************
# * Translation text for page mbr_account.php
# ****************************************************************************
$trans["mbrAccountLabel"] = "\$text='Add a Transaction:';";
$trans["mbrAccountTransTyp"] = "\$text='Transaction Type:';";
$trans["mbrAccountAmount"] = "\$text='Amount:';";
$trans["mbrAccountDesc"] = "\$text='Description:';";
$trans["mbrAccountHead1"] = "\$text='Member Account Transactions:';";
$trans["mbrAccountNoTrans"] = "\$text='No transactions found.';";
$trans["mbrAccountOpenBal"] = "\$text='Opening Balance';";
$trans["mbrAccountDel"] = "\$text='del';";
$trans["mbrAccountHdr1"] = "\$text='Function';";
$trans["mbrAccountHdr2"] = "\$text='Date';";
$trans["mbrAccountHdr3"] = "\$text='Trans Type';";
$trans["mbrAccountHdr4"] = "\$text='Description';";
$trans["mbrAccountHdr5"] = "\$text='Amount';";
$trans["mbrAccountHdr6"] = "\$text='Balance';";

# ****************************************************************************
# * Translation text for page mbr_transaction.php
# ****************************************************************************
$trans["mbrTransactionSuccess"] = "\$text='Transaction successfully completed.';";

# ****************************************************************************
# * Translation text for page mbr_transaction_del_confirm.php
# ****************************************************************************
$trans["mbrTransDelConfirmMsg"] = "\$text='Are you sure you want to delete this transaction?';";

# ****************************************************************************
# * Translation text for page mbr_transaction_del.php
# ****************************************************************************
$trans["mbrTransactionDelSuccess"] = "\$text='Transaction successfully deleted.';";

# ****************************************************************************
# * Translation text for page mbr_print_checkouts.php
# ****************************************************************************
$trans["mbrPrintCheckoutsTitle"] = "\$text='Checkouts for %mbrName%';";
$trans["mbrPrintCheckoutsHdr1"] = "\$text='Current Date:';";
$trans["mbrPrintCheckoutsHdr2"] = "\$text='Member:';";
$trans["mbrPrintCheckoutsHdr3"] = "\$text='Card Number:';";
$trans["mbrPrintCheckoutsHdr4"] = "\$text='Classification:';";
$trans["mbrPrintCloseWindow"] = "\$text='Close Window';";

# ****************************************************************************
# * Translation text for page noauth.php
# ****************************************************************************
$trans["NotAuth"] = "\$text = 'You are not authorized to use this function under the Circulation tab.';";

# ****************************************************************************
# * Translation text for page offline.php
# ****************************************************************************
$trans["Upload Offline Circulation"] = "\$text='Upload Offline Circulation';";
$trans["Upload"] = "\$text='Upload';";
$trans["Date:"] = "\$text='Date:';";
$trans["Command File:"] = "\$text='Command File:';";
$trans["Bad upload file: Expected a command code, but didn't get one"] = "\$text='Bad upload file: Expected a command code, but didn't get one';";
$trans["Couldn't check out %item% to %member%: %error%"] = "\$text='Couldn't check out %item% to %member%: %error%';";
$trans["Couldn't check in %item%: %error%"] = "\$text='Couldn't check in %item%: %error%';";
$trans["Unrecognized command code: %cmd%"] = "\$text='Unrecognized command code: %cmd%';";
$trans["Command Sheet"] = "\$text='Command Sheet';";
$trans["Actions which did not produce an error have completed. Think carefully before uploading the same file again, or some circulations may be recorded twice."] = "\$text='Actions that do not produce an error may have been executed. Think carefully before uploading the same file again, or some circulations may be recorded twice.';";
$trans["Errors"] = "\$text='Errors';";
$trans["Offline Upload Successful."] = "\$text='Offline Upload Successful.';";
$trans["Couldn't read file: "] = "\$text='Couldn't read file: ';";

?>
