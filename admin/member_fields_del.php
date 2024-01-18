<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "member_fields";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/MemberQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for query string.  Go back to list if none found.
  #****************************************************************************
  if (!isset($_REQUEST["code"])){
    header("Location: ../admin/member_fields_list.php");
    exit();
  }
  $code = $_REQUEST["code"];
  $description = $_REQUEST["desc"];

  #**************************************************************************
  #*  Delete row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $dmQ->delete("member_fields_dm",$code);
  $dmQ->close();

  $memberQ = new MemberQuery();
  $memberQ->connect_e();
  $memberQ->deleteCustomField($code);
  $dmQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("Member field, %desc%, has been deleted.", array('desc'=>$description));?><br><br>
<a href="../admin/member_fields_list.php"><?php echo $loc->getText("return to member field list"); ?></a>

<?php require_once("../shared/footer.php"); ?>
