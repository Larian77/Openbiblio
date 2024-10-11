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
if ($set->_isMbrAccountOnline == TRUE && $mbr->getFileSource() != "mbr_edit_form") {
    $TypeOfPwdCreation_ID = array('id' => 'TypeOfPwdCreation',
                                  'value' => 'checked');
    
    // If an incorrect entry is made (e.g. mail), the password fields would be available again even if TypeOfPwdCreation is checked. 
    // Therefore the use of readonly. If the checkmark is removed, a password can be set manually again.
    if (isset($postVars['TypeOfPwdCreation']) && $postVars['TypeOfPwdCreation'] == 'CHECKED') {
        $Pwd_ID = array('id' => 'pwd',
                        'readonly' => 'readonly');
        $PwdRepeat_ID = array('id' => 'pwdRepeat',
                              'readonly' => 'readonly');
    } else {
        $Pwd_ID = array('id' => 'pwd');
        $PwdRepeat_ID = array('id' => 'pwdRepeat');
    }
    $fields["mbr_new_form_TypeOfPwdCreation"] = inputField('checkbox', 'TypeOfPwdCreation', NULL, $TypeOfPwdCreation_ID, 'CHECKED');
    $fields["mbr_new_form_Password"] = inputField('password', 'pwd', $mbr->getPwd(), $Pwd_ID);
    $fields['mbr_new_form_Reenterpassword'] = inputField('password', 'pwdRepeat', $mbr->getPwdRepeat(), $PwdRepeat_ID);
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
    <td valign="top" class="<?php
        if ($title == 'mbr_new_form_Password') {
            echo ' pwdCss';
        } else {
            echo 'primary';
        }
        ?>">
      <?php
        if ($title == 'mbr_new_form_TypeOfPwdCreation') {
            echo '<span class="notice">';
        }
        if ($title == 'mbr_new_form_Password') {
            echo $loc->getText("PwdRequirement");
        }
        echo $html; 
        if ($title == 'mbr_new_form_TypeOfPwdCreation') {
            echo $loc->getText("mbr_new_form_TypeOfPwdCreationInfo") . "</span>";
            ?>
            <script>
                document.getElementById('TypeOfPwdCreation').addEventListener('click', function() {
                    var changeThisPwd = document.getElementById('pwd');
                    changeThisPwd.readOnly = this.checked;
                    var changeThisPwdRepeat = document.getElementById('pwdRepeat');
                    changeThisPwdRepeat.readOnly = this.checked;
                    var element1 = document.querySelector('.pwdCss');
                    var element2 = document.querySelector('.pwdCss');
                    if (element1.style = this.checked) {
                        element1.style.color = 'gray';        
                        element2.style.fontStyle = 'italic';
                    }
                });
            </script>
            <?php
        }
        ?>
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
  <tr>
      <td>

      </td>
  </tr>

</table>
