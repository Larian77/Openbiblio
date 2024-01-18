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
  
  if (isset($_POST['locale'])) {
    if (!preg_match('/^[-_a-zA-Z0-9]+$/', $_POST['locale'])) {
      Fatal::internalError("Bad locale name.");
    }
    $locale = $_POST['locale'];
  }
  if (isset($_POST['installTestData'])) {
    $installTestData = ($_POST["installTestData"] == "yes");
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
        <input type="submit" value="Continue">
        <input type="button" onClick="self.location='../install/cancel_msg.php'" value="Cancel">
        </form>
      <?php
      $setQ->close();
      include("../install/footer.php");
      exit();
    }
  }
  echo "Building OpenBiblio tables, please wait...<br>\n";
  
  $installQ->freshInstall($locale, $installTestData);
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
