<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../functions/inputFuncs.php");
require_once ('../classes/DmQuery.php');
$dmQ = new DmQuery();
$dmQ->connect_e();
$mbrClassifyDm = $dmQ->getAssoc('mbr_classify_dm');
$customFields = $dmQ->getAssoc('member_fields_dm');
$dmQ->close();
$fields = array(
    "mbrFldsCardNmbr" => inputField('text', "barcodeNmbr", $mbr->getBarcodeNmbr()),
    "mbrFldsFirstName" => inputField('text', "firstName", $mbr->getFirstName()),
    "mbrFldsLastName" => inputField('text', "lastName", $mbr->getLastName()),
    "Mailing Address:" => inputField('textarea', "address", $mbr->getAddress()),
    "mbrFldsEmail" => inputField('text', "email", $mbr->getEmail()),
    "mbrFldsHomePhone" => inputField('text', "homePhone", $mbr->getHomePhone()),
    "mbrFldsWorkPhone" => inputField('text', "workPhone", $mbr->getWorkPhone())
);

if (isset($_GET['mbrid'])) {
    $mbr->setMbrid($_GET["mbrid"]);
}
if (isset($_GET['FileSource'])) {
    $mbr->setFileSource($_GET["FileSource"]);
}
if ($set->_isLibraryOnline == TRUE && $mbr->getFileSource() != "mbr_edit_form") {
        $fields["mbr_new_form_Password"] = inputField('password', 'pwd', $mbr->getPwd());
        $fields['mbr_new_form_Reenterpassword'] = inputField('password', 'pwdRepeat', $mbr->getPwdRepeat());
}
foreach ($customFields as $name => $title) {
       $fields[$title . ':'] = inputField('text', 'custom_' . $name, $mbr->getCustom($name));
}
$fields["mbrFldsMbrShip"] = inputField('text', "membershipEnd", (!empty($mbr->getMembershipEnd()) ? $mbr->getMembershipEnd() : '') );
$fields["mbrFldsClassify"] = inputField('select', 'classification', $mbr->getClassification(), NULL, $mbrClassifyDm);

?>

<table class="primary">
	<tr>
		<th colspan="2" valign="top" style="white-space: nowrap;" align="left">
      <?php echo H($headerWording);?> <?php echo $loc->getText("mbrFldsHeader"); ?>
    </th>
	</tr>
<?php
foreach ($fields as $title => $html) {  
    ?>
  <tr>
    <td style="white-space: nowrap;" class="primary" valign="top">
      <?php 
        echo $loc->getText($title); ?>
    </td>
    <td valign="top" class="primary">
      <?php 
        if ($title == 'mbr_new_form_Password') {
            echo $loc->getText("mbrPwdRequirement");
        } 
        echo $html; ?>
    </td>
  </tr>
<?php
};
?>
  <tr>
    <td align="center" colspan="2" class="primary"><input type="submit"
			value="<?php echo $loc->getText("mbrFldsSubmit"); ?>" class="button">
			<input type="button"
			onClick="self.location='<?php echo H(addslashes($cancelLocation));?>'"
			value="<?php echo $loc->getText("mbrFldsCancel"); ?>" class="button">
    </td>
  </tr>

</table>
