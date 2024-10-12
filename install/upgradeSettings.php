<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  

  $doing_install = true;
  $tab = 'admin';
  require_once("../shared/common.php");
  require_once ("../classes/Settings.php");
  require_once("../classes/SettingsQuery.php");
  require_once("../functions/inputFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(MAIN_LOCALE, $tab);
  require_once("../classes/UpgradeQuery.php"); //

  if (count($_POST) == 0) {
    header("Location: ../install/index.php");
    exit();
  }
  
  include("../install/header.php");

?>
<br>
<h1 class="headerUpgrade">OpenBiblio Upgrade - New Settings:</h1>

<?php
if ( OBIB_LATEST_DB_VERSION == '0.8.1') {
    // Query the upgrade key before the upgrade begins
    if (isset($_POST["upgradekey"])) {
        $upgradekey = $_POST["upgradekey"];
    }
    if ($upgradekey != OBIB_UPGRADE_KEY) {
        if ($_POST['upgrade'] == NULL) {
            $currentAttempts = 1;
        } else {
            $attempts = $_POST['upgrade'];
            $currentAttempts = intval($attempts);
            $_POST['upgrade'] = $currentAttempts;
        }
        header("Location: ../install/index.php?upgrade=$currentAttempts");
        exit(); 
    }
    echo '<blockquote>';
    echo '<form name="updateSettings" method="POST" action="../install/update.php">';
    echo '<font class="error">WARNING - Please back up your database before updating.</font>';
?>
    <div class="upgradeSettings">
       <div class="upgradeSetting">
        <div style="white-space:nowrap;" class="primary descriptionField">
          <?php echo $loc->getText("admin_settingsMbrAccountOnline");
                echo '<font class="settingLocation"><br /> admin -> Library settings</font>';
          ?>
        </div>
        <div class="primary inputField">
          <input type="checkbox" name="mbrAccountOnline" value="CHECKED" CHECKED>
          <?php echo $loc->getText("admin_settingsMbrAccountOnline_explication"); ?>
          
        </div>
      </div>
      <div class="upgradeSetting">
        <div class="primary descriptionField" >
          <?php echo $loc->getText("admin_settingsLoginAttemps"); 
                echo '<font class="settingLocation"><br /> admin -> Library settings</font>';
          ?>
        </div>
        <div class="primary inputField">
          <select name="loginAttempts">
            <?php
              $arr_loginAttempts = array(3, 5, 7, 9, 11, 13, 15);
              foreach ($arr_loginAttempts as $AttemptsCode => $AttemptsDesc) {
                echo "<option value=\"".H($AttemptsDesc)."\"";
                if ($AttemptsDesc == '9') {
                  echo " selected";
                }
                echo ">".H($AttemptsDesc)."</option>\n";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="upgradeSetting">
        <div class="primary descriptionField">
          <?php echo $loc->getText("admin_settingsPwdTimeout"); 
                echo '<font class="settingLocation"><br /> admin -> Library settings</font>';
          ?>
        </div>
        <div class="primary inputField">
          <select name="pwdTimeout">
            <?php
              $arr_timeout = array(10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60);
              foreach ($arr_timeout as $TimeoutCode => $TimeoutDesc) {
                echo "<option value=\"".H($TimeoutDesc)."\"";
                if ($TimeoutDesc == '30') {
                  echo " selected";
                }
                echo ">".H($TimeoutDesc)."</option>\n";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="upgradeSetting">
        <div class="primary descriptionField">
          <?php echo $loc->getText("admin_PwdForgottenSettings"); 
                echo '<font class="settingLocation"><br /> admin -> E-mail Settings</font>';
          ?>
        </div>
        <div class="primary inputField">
          <select name="pwdForgottenSettings">
            <?php
              $PwdForgottenSettings = array(
                0 => $loc->getText('admin_PwdForgottenNone'),
                1 => $loc->getText('admin_PwdForgottenOr'),
                2 => $loc->getText('admin_PwdForgottenAnd')
              );
              foreach ($PwdForgottenSettings as $PwdForgottenSettingsCode => $PwdForgottenSettingsDesc) {
                echo "<option value=\"".H($PwdForgottenSettingsCode)."\"";
                echo ">".H($PwdForgottenSettingsDesc)."</option>\n";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="upgradeSetting">
        <div class="primary descriptionField">
          <?php echo $loc->getText("admin_PwdForgottenCodeDuration"); 
                echo '<font class="settingLocation"><br /> admin -> E-mail Settings</font>';
          ?>
        </div>
        <div class="primary inputField">
          <select name="pwdForgottenCodeDuration">
            <?php
              $PwdForgottenCodeDuration = array(
                1 => 1,
                2 => 2,
                3 => 12,
                4 => 24,
                5 => 48
              );
              foreach ($PwdForgottenCodeDuration as $PwdForgottenCodeDurationCode => $PwdForgottenCodeDurationDesc) {
                echo "<option value=\"".H($PwdForgottenCodeDurationCode)."\"";
                if ($PwdForgottenCodeDurationCode == '2') {
                  echo " selected";
                }
                echo ">".H($PwdForgottenCodeDurationDesc)."</option>\n";
              }
            ?>
          </select>
        <?php 
          echo '&nbsp;' . $loc->getText('admin_Duration');
        ?>
        </div>
      </div>
      <div class="upgradeSetting">
        <div class="primary descriptionField">
          <?php echo $loc->getText("admin_mailSettingTitle"); 
                echo '<font class="settingLocation"><br /> admin -> E-mail Settings</font>';
          ?>
        </div>
        <div class="primary inputField">
            <?php
                echo $loc->getText("admin_mailService_explication");
            ?>
        </div>
      </div>
      <div class="upgradeSetting">
        <div class="primary descriptionField">
          <?php echo $loc->getText("admin_mailSettingTitle"); 
                echo '<font class="settingLocation"><br /> admin -> E-mail Messages</font>';
          ?>
        </div>
        <div class="primary inputField">
            <?php
                $arrMail = array ('class' => 'inputEmailInfos');
                $mailFromMail = '';
                $mailFromName = '';
                echo $loc->getText("admin_mailFromMail") . "<br />";
                echo inputField('email', "mailFromMail", $mailFromMail, $arrMail) . "<br /><br />";
                echo $loc->getText("admin_mailFromName") . "<br />";
                echo inputField('text', "mailFromName", $mailFromName, $arrMail) . "<br /><br />";
                echo $loc->getText("admin_MailSender_explication");
            ?>
        </div>
      </div>
    </div> 
<?php 
}
    echo '<br /><input type="submit" value="Update">';
    echo '</form>';
echo '</blockquote>';
echo '</table>';

echo '<blockquote>';
    include("../install/footer.php"); 
echo '</blockquote>';

?>
