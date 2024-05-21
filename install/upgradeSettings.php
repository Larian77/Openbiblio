<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  

  $doing_install = true;
  $tab = 'admin';
  require_once("../shared/common.php");
  require_once ("../classes/Settings.php");
  require_once("../classes/SettingsQuery.php");
  require_once("../classes/Localize.php");
  $loc = new Localize('de',$tab);
  require_once("../classes/UpgradeQuery.php"); // MV wahrscheinlich hier nicht notwednig

  if (count($_POST) == 0) {
    header("Location: ../install/index.php");
    exit();
  }
  
  include("../install/header.php");

?>
<br>
<h1>OpenBiblio Upgrade - New Settings:</h1>

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
    <table class="primary upgrade">
       <tr>
        <td style="white-space:nowrap;" class="primary upgrade">
          <?php echo $loc->getText("admin_settingsLibraryOnline");
                echo '<font class="settingLocation"><br /> admin -> settings</font>';
          ?>
        </td>
        <td class="primary upgrade">
          <?php echo $loc->getText("admin_settingsLibraryOnline_explication"); ?>
          <input type="checkbox" name="libraryOnline" value="CHECKED" CHECKED>
        </td>
      </tr>
      <tr>
        <td class="primary upgrade" >
          <?php echo $loc->getText("admin_settingsLoginAttemps"); 
                echo '<font class="settingLocation"><br /> admin -> settings</font>';
          ?>
        </td>
        <td class="primary upgrade">
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
        </td>
      </tr>
      <tr>
        <td class="primary upgrade">
          <?php echo $loc->getText("admin_settingsPwdTimeout"); 
                echo '<font class="settingLocation"><br /> admin -> settings</font>';
          ?>
        </td>
        <td class="primary upgrade">
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
        </td>
      </tr>
    </table> 
<?php 
}
    echo '<br /><input type="submit" value="Update">';
    echo '</form>';
echo '</blockquote>';

include("../install/footer.php"); ?>
