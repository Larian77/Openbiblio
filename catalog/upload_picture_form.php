<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "cataloging";
  $nav = "upload_picture";

  include("../shared/logincheck.php");
  include("../shared/header.php");

  require_once("../classes/Biblio.php");
  require_once("../classes/BiblioQuery.php");

  require_once("../functions/errorFuncs.php");
  require_once("../catalog/inputFuncs.php");
  require_once("../functions/inputFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".H($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }
  
  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new BiblioQuery();
  $biblioQ->connect_e();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblio = $biblioQ->doQuery($bibid, $tab)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  $biblioFlds = $biblio->getBiblioFields();

  #****************************************************************************
  #*  Show picture of the Bibliography if defined
  #****************************************************************************
?>
<h1>
 <?php 
  if (isset($biblioFlds["245a"])) echo H($biblioFlds["245a"]->getFieldData());
?>
</h1>

<?php
  #****************************************************************************
  #*  Show picture of the Bibliography if defined
  #****************************************************************************
if (isset($biblioFlds["902a"]))
{
?>
<table class="primary"> 
  <tr>
    <td valign="top" class="primary">
<img src="../pictures/<?php echo $biblioFlds["902a"]->getFieldData();?>" width="150" >
    </td>
  </tr>
</table>
<?php    
}
?>
<br>

<form enctype="multipart/form-data" action="../catalog/upload_picture.php?bibid=<?php echo HURL($bibid);?>" method="post">

  <?php echo $loc->getText("PictureUploadFileUpload"); ?>: <input type="file" name="picture_data"><br><br>

  <input type=hidden name=userid id=userid value="<?php echo H($_SESSION["userid"])?>">

  <input type="submit" value="<?php echo $loc->getText("UploadFile"); ?>" class="button">
</form>

<?php include("../shared/footer.php"); ?>
