<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  $doing_install = true;
  require_once("../shared/common.php");
  
  require_once("../classes/InstallQuery.php");
  require_once("../classes/Settings.php");
  
  $installQ = new InstallQuery();
  $version = NULL;
  $error = $installQ->connect_e();
  if (!$error) {
    $version = $installQ->getCurrentDatabaseVersion();
    $installQ->close();
  }
  
  include("../install/header.php");
  // 0.7: CircQuery uses PHP to determine current time, other scripts use MySQL
  $link = (new QueryAny)->db();
  $my_date = implode($link->fetch_row($link->query('select sysdate();')));
  $php_date = date('Y-m-d H:i:s');
  if ($php_date != $my_date) {
?>
    <font class="error">Mismatch in date and time configuration.</font><br>
    Recommended: correct before proceeding, else Check Out and Check In might fail temporarily.<br>
    Current date and time (YYYY-MM-DD HH:MM:SS):<br>
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
<h1>OpenBiblio <?php echo H(OBIB_CODE_VERSION); ?> Installation</h1>
<?php
  if ($error) {
?>
    The connection to the database failed with the following error.
    <pre>
      <?php echo H($error->toStr()); ?>
    </pre>
    Please make sure the following has been done before running this
    install script.
    <ol>
      <li>create OpenBiblio database
        (<a href="../install_instructions.html#step4">step 4</a> of the
        install instructions)</li>
      <li>create OpenBiblio database user
        (<a href="../install_instructions.html#step5">step 5</a> of the
        install instructions)</li>
      <li>update openbiblio/database_constants.php with your new database
        username and password
        (<a href="../install_instructions.html#step8">step 8</a> of the install
        instructions)</li>
    </ol>
    See <a href="../install_instructions.html">Install Instructions</a> for more details.
<?php
  } else {
    echo "Database connection is good.<br />";
    if ($version == OBIB_LATEST_DB_VERSION) {
?>
      <blockquote>
        <h2>Your OpenBiblio Installation is up to date</h2>
        <font class="error">No action is required</font><br><br>
        <a href="../home/index.php">start using OpenBiblio</a>
      </blockquote>
<?php
    } elseif ($version == NULL) {
?>
      <h2>New Install:</h2>
      <blockquote>
        <form name="installForm" method="POST" action="../install/install.php">
          <table style="border:none;border-spacing:0px">
            <tr>
              <td style="padding:0px"><font class="primary">Language:</font></td>
              <td style="padding:0px"><select name="locale">
                <?php
                  $stng = new Settings();
                  $arr_lang = $stng->getLocales();
                  foreach ($arr_lang as $langCode => $langDesc) {
                    echo "<option value=\"".H($langCode)."\"";
                    echo ">".H($langDesc)."\n";
                  }
                ?>
              </select></td>
            </tr>
            <tr>
              <td style="padding:0px" rowspan="2" valign="top"><font class="primary">Install Test Data:</font></td>
              <td style="padding:0px"><input type="checkbox" name="installTestData" value="yes"></td>
            </tr>
            <tr>
              <td style="padding:0px"><input type="submit" value="Install"></td>
            </tr>
          </table>
        </form>
      </blockquote>
<?php
    } else {
?>
      <h1>It looks like we need to update  database version <?php echo H($version); ?>
        to version <?php echo H(OBIB_LATEST_DB_VERSION); ?>:</h1>
      <blockquote>
        <font class="error">WARNING - Please back up your database before updating.</font>
        <form name="updateForm" method="POST" action="../install/update.php">
          <input type="submit" value="Update">
        </form>
      </blockquote>
<?php
    }
  }
  include("../install/footer.php");
?>
