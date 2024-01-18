<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "themes";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/ThemeQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  #****************************************************************************
  #*  Checking for query string.  Go back to theme list if none found.
  #****************************************************************************
  if (!isset($_GET["themeid"])){
    header("Location: ../admin/theme_list.php");
    exit();
  }
  $themeid = $_GET["themeid"];
  $name = $_GET["name"];

  #**************************************************************************
  #*  Delete row
  #**************************************************************************
  $themeQ = new ThemeQuery();
  $themeQ->connect_e();
  if ($themeQ->errorOccurred()) {
    $themeQ->close();
    displayErrorPage($themeQ);
  }
  if (!$themeQ->delete($themeid)) {
    $themeQ->close();
    displayErrorPage($themeQ);
  }
  $themeQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("adminTheme_Theme"); ?> <?php echo H($name);?><?php echo $loc->getText("adminTheme_Deleted"); ?><br><br>
<a href="../admin/theme_list.php"><?php echo $loc->getText("adminTheme_Return"); ?></a>

<?php require_once("../shared/footer.php"); ?>
