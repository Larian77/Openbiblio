<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "summary";

  include("../shared/logincheck.php");
  include("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

?>

<h1><img src="../images/admin.png" border="0" width="30" height="30" align="top"> <?php echo $loc->getText("indexHdr");?></h1>
<?php echo $loc->getText("indexDesc");?>
<br><br><br><br><br>

<?php include("../shared/footer.php"); ?>
