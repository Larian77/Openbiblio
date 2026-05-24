<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
$doing_install = true;
require_once ("../shared/common.php");

require_once ("../classes/InstallQuery.php");
require_once ("../classes/Settings.php");

$installQ = new InstallQuery();
$version = NULL;
$error = $installQ->connect_e();
if (! $error) {
    $version = $installQ->getCurrentDatabaseVersion();
    $installQ->close();
}

include ("../install/header.php");
// 0.7: CircQuery uses PHP to determine current time, other scripts use MySQL
$link = (new QueryAny())->db();
$my_date = implode($link->fetch_row($link->query('select sysdate();')));
$php_date = date('Y-m-d H:i:s');
if ($php_date != $my_date) {
    ?>
<font class="error">Mismatch in date and time configuration.</font>
<br>
Recommended: correct before proceeding, else Check Out and Check In
might fail temporarily.
<br>
Current date and time (YYYY-MM-DD HH:MM:SS):
<br>
<pre>
      MySQL : <?php echo $my_date; ?>

      PHP   : <?php echo $php_date." | date.timezone = ".ini_get('date.timezone'); ?>
    </pre>
<?php
    if (ini_get('date.timezone') == get_cfg_var('date.timezone')) {
        echo "<b>Suggestion:</b>";
        echo "<ul><li>Using <a href = \"../install/phpinfo.php\">phpinfo</a>, determine the Loaded Configuration File</li>";
        echo "<li>Find this file, use an editor (Notepad etc.) to change <i>date.timezone</i> and save</li>";
        echo "<li>Restart webserver and check install again</li></ul><br>";
    }
}
?>
<div class="content">
<h1>OpenBiblio <?php echo H(OBIB_CODE_VERSION); ?> Installation</h1>
<?php
if ($error) {
    ?>
    The connection to the database failed with the following error.
<pre>
      <?php echo H($error->toStr()); ?>
    </pre>
Please make sure the following has been done before running this install
script.
<ol>
	<li>create OpenBiblio database (<a
		href="../install_instructions.html#step4">step 4</a> of the install
		instructions)
	</li>
	<li>create OpenBiblio database user (<a
		href="../install_instructions.html#step5">step 5</a> of the install
		instructions)
	</li>
	<li>update openbiblio/database_constants.php with your new database
		username and password (<a href="../install_instructions.html#step8">step
			8</a> of the install instructions)
	</li>
</ol>
See
<a href="../install_instructions.html">Install Instructions</a>
for more details.

<?php
} else {
    if ($version == OBIB_LATEST_DB_VERSION) {
        $tab = 'admin';
        require_once ("../shared/read_settings.php");
        require_once ("../classes/Localize.php");
        $loc = new Localize(OBIB_LOCALE,$tab);
    
        echo '<p class="goodNews">' . $loc->getText("DBConnection") . '<br />';
?>
        <p class="info"><?php echo $loc->getText('OpenbiblioUpToDate'); ?></p>

        <font class="error"><?php echo $loc->getText('NoActionRequired'); ?></font><br>
        <br><br>
        <a href="../home/index.php"><?php echo $loc->getText('startUsingOpenBiblio'); ?></a>
<?php
    } elseif ($version == NULL) {
        echo '<p class="goodNews">Database connection is good.<br />';
?>
        <h2>New Install:</h2>
        <blockquote>
            <form name="installForm" method="POST" action="../install/install.php"
                  onsubmit="return validateInstallPwd()">
                <table style="border: none; border-spacing: 0px">
                    <tr>
                        <td style="padding: 5px"><font class="primary">Language:</font></td>
                        <td style="padding: 5px"><select name="locale">
                            <?php
                            $stng = new Settings();
                            $arr_lang = $stng->getLocales();
                            foreach ($arr_lang as $langCode => $langDesc) {
                                echo "<option value=\"" . H($langCode) . "\"";
                                echo ">" . H($langDesc) . "\n";
                            }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr id="pwdErrorRow" style="display:<?php echo isset($_GET['pwdError']) ? 'table-row' : 'none'; ?>">
                        <td colspan="2" style="padding: 5px">
                            <font class="error" id="pwdErrorMsg"><?php echo isset($_GET['pwdError']) ? H($_GET['pwdError']) : ''; ?></font>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px"><font class="primary">Admin Password:</font></td>
                        <td style="padding: 5px">
                            <input type="password" name="initialAdminPassword" id="initialAdminPassword" maxlength="20" required>
                            <br><font class="primary" style="font-size:80%">8–20 characters, at least 1 digit, 1 letter, 1 special character (allowed: @_#§%$)</font>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px"><font class="primary">Confirm Password:</font></td>
                        <td style="padding: 5px"><input type="password" name="confirmAdminPassword" id="confirmAdminPassword" maxlength="20" required></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px" valign="top"><font class="primary"><strong>Important:</strong></font></td>
                        <td style="padding: 5px"><font class="primary">There is no password recovery for the admin account. Please remember this password and store it in a safe place.</font></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px" rowspan="2" valign="top"><font
                                class="primary">Install Test Data:</font></td>
                        <td style="padding: 5px"><input type="checkbox"
                                name="installTestData" value="yes"></td>
                    </tr>
                    <tr>
                        <td style="padding: 5px"><input type="submit" value="Install"></td>
                    </tr>
                </table>
            </form>
        </blockquote>
<script>
function validateInstallPwd() {
    var pwd  = document.getElementById('initialAdminPassword').value;
    var pwd2 = document.getElementById('confirmAdminPassword').value;
    var msg  = null;
    var re   = /^(?=.*\d)(?=.*[A-Za-z])(?=.*[@_#§%$])[0-9A-Za-z@_#§%$]{8,20}$/;

    if (pwd.length === 0) {
        msg = 'Admin password is required.';
    } else if (pwd.length < 8 || pwd.length > 20) {
        msg = 'Password must have between 8 and 20 characters.';
    } else if (pwd.indexOf(' ') !== -1) {
        msg = 'Password must not contain any spaces.';
    } else if (pwd !== pwd2) {
        msg = 'Passwords do not match.';
    } else if (!re.test(pwd)) {
        msg = 'Password must have at least 1 digit, at least 1 letter, at least 1 special character (allowed: @_#§%$).';
    }

    if (msg !== null) {
        document.getElementById('pwdErrorMsg').textContent = msg;
        document.getElementById('pwdErrorRow').style.display = 'table-row';
        return false;
    }
    return true;
}
</script>
<?php
    } else {
        $tab = 'admin';
        require_once ("../shared/read_settings.php");
        require_once ("../classes/Localize.php");
        $loc = new Localize(OBIB_LOCALE,$tab);
        
        echo '<p class="goodNews">' . $loc->getText("DBConnection") . '<br />';
?>
        <p class="info">
            <?php 
            echo $loc->getText("UpdateDatabaseInfo",array("oldDBversion"=>H($version),"newDBversion"=>H(OBIB_LATEST_DB_VERSION)))
            ?></p>

    <font class="error"><?php echo $loc->getText('BackupDatabase'); ?></font>
<?php
    if ( OBIB_LATEST_DB_VERSION == '0.8.1'){ 
   
?>
        <form name="updateForm" method="POST" action="../install/upgradeSettings.php">
            
<?php       #***************************************************************
            #* Protection against attacks
            #***************************************************************
            if (isset($_GET["upgrade"]) && $_GET["upgrade"] != "") {
                $upgradeattempts = $_GET["upgrade"];
                $upgrade = intval($upgradeattempts) +1;
                $_GET["upgrade"] = $upgrade;
            } else {
                $upgrade = 1;
            }
            if ($upgrade <= 9) {
            #***************************************************************
            #* Upgrade only for administrators with upgrade key
            #* The upgrade key OBIB_UPGRADE_KEY is set in the shared/global_settings.php file.
            #* and should be set individually
            #***************************************************************
            echo '<br /><br /><h2>' . $loc->getText('MaintenanceAccess') . '</h2>'; 
?>
                <blockquote>
                    <table style="border: none; border-spacing: 0px">
                        <tr>
                            <td style="padding: 5px;"><font class="primary"><?php echo  $loc->getText('UpgradeKey') . ':'; ?></font></td>
                            <td style="padding: 5px;"><input type="password"
                                            name="upgradekey" value=""></td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;"><input type="hidden" id="upgrade" name="upgrade" value="<?php echo $upgrade ?>"></td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                <input type="hidden" name="update" value="true">
                                <input type="submit" value="Update"></td>
                        </tr>
                    </table>           
    <?php   } else if ( OBIB_LATEST_DB_VERSION != '0.8.1'){?>                
                <form name="updateForm" method="POST" action="../install/update.php">
                    <input type="submit" value="Update">
    <?php
            } else {
                echo '<p><font class="error">' . $loc->getText("UpgradeSuspended") . '</font></p>';
            }
        }
    ?>
	</form>
</blockquote>
<?php
    }
}
echo '</div';
include ("../install/footer.php");
?>
