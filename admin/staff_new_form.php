<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "admin";
  $nav = "staff";
  $focus_form_name = "newstaffform";
  $focus_form_field = "last_name";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");

?>

<form name="newstaffform" method="POST" action="../admin/staff_new.php">
<table class="primary">
  <tr>
    <th style="white-space:nowrap;" colspan="2" align="left">
      <?php echo $loc->getText("adminStaff_new_form_Header"); ?>
    </th>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formLastname"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("last_name",30,30,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formFirstname"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("first_name",30,30,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formLogin"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("username",20,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_email"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("email",50,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
        <?php echo $loc->getText("admin_new_form_TypeOfPwdCreation"); ?>
    </td>
    <td valign="top" class="primary">
        <?php // Select whether the password should be set manually or by e-mail ?>
        <input type="checkbox" id="TypeOfPwdCreation" name="TypeOfPwdCreation" value="CHECKED"
        <?php if (isset($postVars["TypeOfPwdCreation"])) {
                echo H($postVars["TypeOfPwdCreation"]); 
        }  
        ?> 
        >
        <span class="notice"><?php echo $loc->getText("admin_new_form_TypeOfPwdCreationInfo"); ?> </span>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_new_form_Password"); ?>
    </td>
    <td valign="top" class="<?php echo 'pwdCss">';  
      echo $loc->getText("adminStaffPwdRequirement");
      
      // If an incorrect entry is made (e.g. mail), the password fields would be available again even if TypeOfPwdCreation is checked. 
      // Therefore the use of readonly. If the checkmark is removed, a password can be set manually again.
      if (isset($postVars['TypeOfPwdCreation']) && $postVars['TypeOfPwdCreation'] == 'CHECKED') {
          $readonly = 'readonly';
      } else {
          $readonly = '';
      }
      echo '<input type="password" id="pwd" name="pwd" size="20" maxlength="20" ' . $readonly . ' value="';
           if (isset($postVars["pwd"])) echo H($postVars["pwd"]); ?>" ><br>
      <font class="error">
      <?php if (isset($pageErrors["pwd"])) echo H($pageErrors["pwd"]); ?></font>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_new_form_Reenterpassword"); ?>
    </td>
    <td valign="top" class="<?php echo 'pwdCss">';
      echo '<input type="password" id="pwd2" name="pwd2" size="20" maxlength="20" ' . $readonly . ' value="';
            if (isset($postVars["pwd2"])) echo H($postVars["pwd2"]); ?>" ><br>
      <font class="error">
      <?php if (isset($pageErrors["pwd2"])) echo H($pageErrors["pwd2"]); ?></font>
       <script>
            document.getElementById('TypeOfPwdCreation').addEventListener('click', function() {
                var changeThisPwd = document.getElementById('pwd');
                changeThisPwd.readOnly = this.checked;
                var changeThisPwdRepeat = document.getElementById('pwd2');
                changeThisPwdRepeat.readOnly = this.checked;
                var element1 = document.querySelector('.pwdCss');
                var element2 = document.querySelector('.pwdCss');
                if (element2.style = this.checked) {
                    element1.style.color = 'gray';        
                    element2.style.fontStyle = 'italic';
                }
            });
        </script>
      
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminStaff_edit_formAuth"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" name="circ_flg" value="CHECKED"
        <?php if (isset($postVars["circ_flg"])) echo H($postVars["circ_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formCirc"); ?>
      <input type="checkbox" name="circ_mbr_flg" value="CHECKED"
        <?php if (isset($postVars["circ_mbr_flg"])) echo H($postVars["circ_mbr_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formUpdatemember"); ?>
      <input type="checkbox" name="catalog_flg" value="CHECKED"
        <?php if (isset($postVars["catalog_flg"])) echo H($postVars["catalog_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formCatalog"); ?>
      <input type="checkbox" name="admin_flg" value="CHECKED"
        <?php if (isset($postVars["admin_flg"])) echo H($postVars["admin_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formAdmin"); ?>
      <input type="checkbox" name="reports_flg" value="CHECKED"
        <?php if (isset($postVars["reports_flg"])) echo H($postVars["reports_flg"]); ?> >
      <?php echo $loc->getText("adminStaff_edit_formReports"); ?>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <?php echo $loc->getText("adminSubmit"); ?>  " class="button">
      <input type="button" onClick="self.location='../admin/staff_list.php'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
    </td>
  </tr>

</table>
      </form>


<?php include("../shared/footer.php"); ?>
