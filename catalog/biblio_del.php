<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "cataloging";
  $nav = "deletedone";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $bibid = $_GET["bibid"];
  $title = $_GET["title"];

  #**************************************************************************
  #*  Delete Bibliography
  #**************************************************************************
  $biblioQ = new BiblioQuery();
  $biblioQ->connect_e();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->delete($bibid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  $biblioQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
  <?php echo $loc->getText("biblioDelMsg",array("title"=>$title)); ?>
  <br><br>
  <a href="../catalog/index.php"><?php echo $loc->getText("biblioDelReturn"); ?></a>
</center>

<?php require_once("../shared/footer.php"); ?>
