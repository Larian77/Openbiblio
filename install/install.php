<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

  $doing_install = true;
  require_once("../shared/common.php");

  if (count($_POST) == 0) {
    header("Location: ../install/index.php");
    exit();
  }

  require_once("../classes/InstallQuery.php");

  $locale = 'en';
  $installTestData = false;
  $initialAdminPassword = '';

  if (isset($_POST['locale'])) {
    if (!preg_match('/^[-_a-zA-Z0-9]+$/', $_POST['locale'])) {
      Fatal::internalError("Bad locale name.");
    }
    $locale = $_POST['locale'];
  }
  if (isset($_POST['installTestData'])) {
    $installTestData = ($_POST["installTestData"] == "yes");
  }
  if (isset($_POST['initialAdminPassword'])) {
    $initialAdminPassword = $_POST['initialAdminPassword'];
  }

  # Validate admin password (skip on re-confirmation of existing DB, where it was already validated)
  if (!isset($_POST['confirm']) || $_POST['confirm'] !== 'yes') {
    $pwdError = null;
    if ($initialAdminPassword === '') {
      $pwdError = 'Admin password is required.';
    } elseif (strlen($initialAdminPassword) < 8 || strlen($initialAdminPassword) > 20) {
      $pwdError = 'Password must have between 8 and 20 characters.';
    } elseif (substr_count($initialAdminPassword, ' ') > 0) {
      $pwdError = 'Password must not contain any spaces.';
    } elseif (isset($_POST['confirmAdminPassword']) && $_POST['confirmAdminPassword'] !== $initialAdminPassword) {
      $pwdError = 'Passwords do not match.';
    } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[@_#§%$])[0-9A-Za-z@_#§%$]{8,20}$/', $initialAdminPassword)) {
      $pwdError = 'Password must have at least 1 digit, at least 1 letter, at least 1 special character (allowed: @_#§%$).';
    }
    if ($pwdError !== null) {
      header("Location: ../install/index.php?pwdError=" . urlencode($pwdError));
      exit();
    }
  }

  include("../install/header.php");
?>
<br>
<h1>OpenBiblio Installation:</h1>

<?php

  # testing connection and current version
  $installQ = new InstallQuery();
  $err = $installQ->connect_e();
  if ($err) {
    Fatal::dbError($e->sql, $e->msg, $e->dberror);
  }
  $version = $installQ->getCurrentDatabaseVersion();
  echo "Database connection is good.<br>\n";

  #************************************************************************************
  #* show warning message if database exists.
  #************************************************************************************
  if ($version) {
    if (!isset($_POST["confirm"]) or ($_POST["confirm"] != "yes")){
      ?>
        <form method="POST" action="../install/install.php">
        OpenBiblio (version <?php echo H($version);?>) is already installed.
        Are you sure you want to delete all library data and create new OpenBiblio
        tables?<br>
        <input type="hidden" name="confirm" value="yes">
        <input type="hidden" name="locale" value="<?php echo H($locale); ?>">
        <input type="hidden" name="installTestData" value="<?php if (isset($_POST["installTestData"])) echo "yes"; ?>">
        <input type="hidden" name="initialAdminPassword" value="<?php echo H($initialAdminPassword); ?>">
        <input type="submit" value="Continue">
        <input type="button" onClick="self.location='../install/cancel_msg.php'" value="Cancel">
        </form>
      <?php
      if (isset($setQ)) {
        $setQ->close();
      }
      include("../install/footer.php");
      exit();
    }
  }
  echo "Building OpenBiblio tables, please wait...<br>\n";

  $installQ->freshInstall($locale, $installTestData);
  $installQ->createAdminUser($initialAdminPassword);
  $installQ->close();
  $version = $installQ->getCurrentDatabaseVersion();
  if ($version) {
    ?>
<br>
OpenBiblio tables have been created successfully!<br>
OpenBiblio database version: <?php echo H($version);?><br>
<a href="../home/index.php">start using OpenBiblio</a>
  <?php } ?>


<?php include("../install/footer.php"); ?>
