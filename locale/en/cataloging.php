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
$trans["catalogSubmit"] = "\$text = 'Submit';";
$trans["catalogCancel"] = "\$text = 'Cancel';";
$trans["catalogRefresh"] = "\$text = 'Refresh';";
$trans["catalogDelete"] = "\$text = 'Delete';";
$trans["catalogFootnote"] = "\$text = 'Fields marked with %symbol% are required.';";
$trans["AnswerYes"] = "\$text = 'Yes';";
$trans["AnswerNo"] = "\$text = 'No';";

# ****************************************************************************
# * Translation text for page index.php
# ****************************************************************************
$trans["indexHdr"] = "\$text = 'Cataloging';";
$trans["indexBarcodeHdr"] = "\$text = 'Search Bibliography by Barcode Number';";
$trans["indexBarcodeField"] = "\$text = 'Barcode Number';";
$trans["indexSearchHdr"] = "\$text = 'Search Bibliography by Search Phrase';";
$trans["indexKeyword"] = "\$text = 'Keyword';";
$trans["indexTitle"] = "\$text = 'Title';";
$trans["indexAuthor"] = "\$text = 'Author';";
$trans["indexSubject"] = "\$text = 'Subject';";
$trans["indexAll"] = "\$text = 'All';";
$trans["indexButton"] = "\$text = 'Search';";
$trans["indexSearchInvert"] = "\$text='Invert Selection';";
$trans["indexSearchColl"] = "\$text='Limit Search to Collections';";
$trans["indexSearchMat"] = "\$text='Limit Search to Material Types';";

# ****************************************************************************
# * Translation text for page biblio_fields.php
# ****************************************************************************
$trans["biblioFieldsLabel"] = "\$text = 'Bibliography';";
$trans["biblioFieldsMaterialTyp"] = "\$text = 'Type of Material';";
$trans["biblioFieldsCollection"] = "\$text = 'Collection';";
$trans["biblioFieldsCallNmbr"] = "\$text = 'Call Number';";
$trans["biblioFieldsUsmarcFields"] = "\$text = 'USMarc Fields';";
$trans["biblioFieldsOpacFlg"] = "\$text = 'Show in OPAC';";
$trans["PictDesc"] = "\$text = 'Image files must be located in the openbiblio/pictures directory.';";

# ****************************************************************************
# * Translation text for page biblio_new.php
# ****************************************************************************
$trans["biblioNewFormLabel"] = "\$text = 'Add New';";
$trans["biblioNewSuccess"] = "\$text = 'The following new bibliography has been created.  To add a copy, select \"New Copy\" from the left hand navigation or \"Add New Copy\" from the copy information below.';";

# ****************************************************************************
# * Translation text for page biblio_edit.php
# ****************************************************************************
$trans["biblioEditSuccess"] = "\$text = 'Bibliography successfully updated.';";

# ****************************************************************************
# * Translation text for page biblio_copy_new_form.php and biblio_copy_edit_form.php
# ****************************************************************************
$trans["biblioCopyNewFormLabel"] = "\$text = 'Add New Copy';";
$trans["biblioCopyNewBarcode"] = "\$text = 'Barcode Number';";
$trans["biblioCopyNewDesc"] = "\$text = 'Description';";
$trans["biblioCopyNewAuto"] = "\$text = 'Autogenerate';";
$trans["biblioCopyNewValidBarco"] = "\$text = 'Validate for printing';";
$trans["biblioCopyEditFormLabel"] = "\$text = 'Edit Copy';";
$trans["biblioCopyEditFormStatus"] = "\$text = 'Status';";

# ****************************************************************************
# * Translation text for page biblio_copy_new.php
# ****************************************************************************
$trans["biblioCopyNewSuccess"] = "\$text = 'Copy successfully created.';";

# ****************************************************************************
# * Translation text for page biblio_copy_edit.php
# ****************************************************************************
$trans["biblioCopyEditSuccess"] = "\$text = 'Copy successfully updated.';";

# ****************************************************************************
# * Translation text for page biblio_copy_del_confirm.php
# ****************************************************************************
$trans["biblioCopyDelConfirmErr1"] = "\$text = 'Could not delete copy.  A copy must be checked in before it can be deleted.';";
$trans["biblioCopyDelConfirmMsg"] = "\$text = 'Are you sure you want to delete the copy with barcode %barcodeNmbr%?  This will also delete all status change history for this copy.';";

# ****************************************************************************
# * Translation text for page biblio_copy_del.php
# ****************************************************************************
$trans["biblioCopyDelSuccess"] = "\$text = 'Copy with barcode %barcode% was successfully deleted.';";

# ****************************************************************************
# * Translation text for page biblio_marc_list.php
# ****************************************************************************
$trans["biblioMarcListMarcSelect"] = "\$text = 'Add New MARC Field';";
$trans["biblioMarcListHdr"] = "\$text = 'MARC Field Information';";
$trans["biblioMarcListTbleCol1"] = "\$text = 'Function';";
$trans["biblioMarcListTbleCol2"] = "\$text = 'Tag';";
$trans["biblioMarcListTbleCol3"] = "\$text = 'Tag Description';";
$trans["biblioMarcListTbleCol4"] = "\$text = 'Ind 1';";
$trans["biblioMarcListTbleCol5"] = "\$text = 'Ind 2';";
$trans["biblioMarcListTbleCol6"] = "\$text = 'Subfld';";
$trans["biblioMarcListTbleCol7"] = "\$text = 'Subfield Description';";
$trans["biblioMarcListTbleCol8"] = "\$text = 'Field Data';";
$trans["biblioMarcListNoRows"] = "\$text = 'No MARC fields found.';";
$trans["biblioMarcListEdit"] = "\$text = 'edit';";
$trans["biblioMarcListDel"] = "\$text = 'del';";

# ****************************************************************************
# * Translation text for page usmarc_select.php
# ****************************************************************************
$trans["usmarcSelectHdr"] = "\$text = 'MARC Field Selector';";
$trans["usmarcSelectInst"] = "\$text = 'Select a field type';";
$trans["usmarcSelectNoTags"] = "\$text = 'No tags found.';";
$trans["usmarcSelectUse"] = "\$text = 'use';";
$trans["usmarcCloseWindow"] = "\$text = 'Close Window';";

# ****************************************************************************
# * Translation text for page biblio_marc_new_form.php
# ****************************************************************************
$trans["biblioMarcNewFormHdr"] = "\$text = 'Add New Marc Field';";
$trans["biblioMarcNewFormTag"] = "\$text = 'Tag';";
$trans["biblioMarcNewFormSubfld"] = "\$text = 'Subfield';";
$trans["biblioMarcNewFormData"] = "\$text = 'Field Data';";
$trans["biblioMarcNewFormInd1"] = "\$text = 'Indicator 1';";
$trans["biblioMarcNewFormInd2"] = "\$text = 'Indicator 2';";
$trans["biblioMarcNewFormSelect"] = "\$text = 'Select';";

# ****************************************************************************
# * Translation text for page biblio_marc_new.php
# ****************************************************************************
$trans["biblioMarcNewSuccess"] = "\$text = 'Marc field successfully added.';";

# ****************************************************************************
# * Translation text for page biblio_marc_edit_form.php
# ****************************************************************************
$trans["biblioMarcEditFormHdr"] = "\$text = 'Edit Marc Field';";

# ****************************************************************************
# * Translation text for page biblio_marc_edit.php
# ****************************************************************************
$trans["biblioMarcEditSuccess"] = "\$text = 'Marc field successfully updated.';";

# ****************************************************************************
# * Translation text for page biblio_marc_del_confirm.php
# ****************************************************************************
$trans["biblioMarcDelConfirmMsg"] = "\$text = 'Are you sure you want to delete the field with tag %tag% and subfield %subfieldCd%?';";

# ****************************************************************************
# * Translation text for page biblio_marc_del.php
# ****************************************************************************
$trans["biblioMarcDelSuccess"] = "\$text = 'Marc field successfully deleted.';";

# ****************************************************************************
# * Translation text for page biblio_del_confirm.php
# ****************************************************************************
$trans["biblioDelConfirmWarn"] = "\$text = 'This bibliography has %copyCount% copy(ies) and %holdCount% hold request(s).  Please delete these copies and/or hold requests before deleting this bibliography.';";
$trans["biblioDelConfirmReturn"] = "\$text = 'return to bibliography information';";
$trans["biblioDelConfirmMsg"] = "\$text = 'Are you sure you want to delete the bibliography with title %title%?';";

# ****************************************************************************
# * Translation text for page biblio_del_confirm.php
# ****************************************************************************
$trans["biblioDelMsg"] = "\$text = 'Bibliography, %title%, has been deleted.';";
$trans["biblioDelReturn"] = "\$text = 'return to bibliography search';";

# ****************************************************************************
# * Translation text for page biblio_hold_list.php
# ****************************************************************************
$trans["biblioHoldListHead"] = "\$text = 'Bibliography Hold Requests:';";
$trans["biblioHoldListNoHolds"] = "\$text = 'No bibliography copies are currently on hold.';";
$trans["biblioHoldListHdr1"] = "\$text = 'Function';";
$trans["biblioHoldListHdr2"] = "\$text = 'Copy';";
$trans["biblioHoldListHdr3"] = "\$text = 'Placed On Hold';";
$trans["biblioHoldListHdr4"] = "\$text = 'Member';";
$trans["biblioHoldListHdr5"] = "\$text = 'Status';";
$trans["biblioHoldListHdr6"] = "\$text = 'Due Back';";
$trans["biblioHoldListdel"] = "\$text = 'Del';";

# ****************************************************************************
# * Translation text for page noauth.php
# ****************************************************************************
$trans["NotAuth"] = "\$text = 'You are not authorized to use the Cataloging tab';";

# ****************************************************************************
# * Translation text for page upload_usmarc.php and upload_usmarc_form.php
# ****************************************************************************
$trans["MarcUploadTest"] = "\$text = 'Test Load';";
$trans["MarcUploadTestTrue"] = "\$text = 'True';";
$trans["MarcUploadTestFalse"] = "\$text = 'False';";
$trans["MarcUploadTestFileUpload"] = "\$text = 'USMarc Input File';";
$trans["MarcUploadRecordsUploaded"] = "\$text = 'Records Uploaded';";
$trans["MarcUploadMarcRecord"] = "\$text = 'MARC Record';";
$trans["MarcUploadTag"] = "\$text = 'Tag';";
$trans["MarcUploadSubfield"] = "\$text = 'Sub';";
$trans["MarcUploadData"] = "\$text = 'Data';";
$trans["MarcUploadRawData"] = "\$text = 'Raw Data:';";
$trans["UploadFile"] = "\$text = 'Upload File';";

# ****************************************************************************
# * Translation text for page usmarc_select.php
# ****************************************************************************
$trans["PoweredByOB"] = "\$text = 'Powered by OpenBiblio';";
$trans["Copyright"] = "\$text = 'Copyright &copy; 2002-2005';";
$trans["underthe"] = "\$text = 'under the';";
$trans["GNU"] = "\$text = 'GNU General Public License';";

$trans["catalogResults"] = "\$text = 'Search Results';";

# ****************************************************************************
# * Translation text for page biblio_history.php
# ****************************************************************************
$trans["Bibliography Checkout History:"] = "\$text = 'Bibliography Checkout History:';";
$trans["Date"] = "\$text = 'Date';";
$trans["Barcode"] = "\$text = 'Barcode';";
$trans["New Status"] = "\$text = 'New Status';";
$trans["Member"] = "\$text = 'Member';";
$trans["Due Date"] = "\$text = 'Due Date';";
$trans["No history was found."] = "\$text = 'No history was found.';";

# ****************************************************************************
# * Translation text for page upload_usmarc.php
# ****************************************************************************
$trans["File doesn't exist"] = "\$text='The specified file is empty or does not exist!';";

#****************************************************************************
#*  Translation text for pages upload_pciture*.php
#****************************************************************************
$trans["PictureUploadFileUpload"]         = "\$text = 'Image file (jpg, gif, png; max 500kb)\n';";
$trans["PicUploadSize500"]                = "\$text = 'Please do not upload a file larger than 500kB.\n';";
$trans["PicUploadExifType"]               = "\$text = 'This file has no correct exif info, only jpg, gif and png are allowed!\n';";
$trans["PicUploadNoExif"]                 = "\$text = 'Apparently the exif extension for PHP is not installed, can't check image!\n';";
$trans["PicUploadNoDir"]                  = "\$text = 'The directory \'pictures\' in the openbiblio directory cannot be found or the permissions are missing!\n';";
$trans["PicUploadPictureUploaded"]        = "\$text = 'The file was valid and was successfully uploaded.\n';";
$trans["PicUploadInfoMedium"]             = "\$text = 'To the media info';";
$trans["PicUploadAttack"]                 = "\$text = 'The file could not be uploaded because an error occurred!\n';";
$trans["PicUploadNoValidPicture"]         = "\$text = 'File does not contain a valid image!\n';";
$trans["PicUploadNoFile"]                 = "\$text = 'No file was specified!\n';";
$trans["PicUploadNoTmp"]                  = "\$text = 'Something went wrong with the upload! Is the \'upload_max_filesize\' value in PHP too low?\n';";

?>
