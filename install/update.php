<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  $doing_install = true;
  $tab = 'admin';
  require_once("../shared/common.php"); 
  require_once("../classes/UpgradeQuery.php");
  require_once ("../shared/read_settings.php");
  require_once ("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  include("../install/header.php");
?>
<br>
<h1><?php echo $loc->getText('OpenBiblioUpgrade'); ?></h1>

<?php

  if (OBIB_LATEST_DB_VERSION == '0.8.1') {
      $settings = $_POST;
      if (isset($_POST["mbrAccountOnline"]) == 'checked') {
        $mbrAccountOnline = 'Y';
      } else {
        $mbrAccountOnline = "N";
      }
      $settings["mbrAccountOnline"] = $mbrAccountOnline;
      $_POST = $settings;
  }

  # testing connection and current version
  $upgradeQ = new UpgradeQuery();

  echo '<p class="info">' .$loc->getText('UpdateOpenBiblioTables') . '</p>';
  
  list($notices, $error) = $upgradeQ->performUpgrade_e();
  if ($error) {
    echo '<h1>' . $loc->getText('UpgradeFailed') . '</h1>';
    echo H($error->toStr());
    exit();
  }
  $upgradeQ->close();

  echo '<p class="goodNews">' . $loc->getText('UpdateSuccessfully') . '</p><br>';
  if (!empty($notices)) {
    echo '<h2>NOTICE:</h2>';
    echo '<ul>';
    foreach ($notices as $n) {
    echo '<li>'.H($n).'</li>';
    }
    echo '</ul>';
  }
?>
<a href="../home/index.php"><?php echo $loc->getText('startUsingOpenBiblio'); ?></a>


<?php include("../install/footer.php"); ?>
