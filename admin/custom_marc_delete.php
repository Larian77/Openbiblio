<?php 
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab='admin';
  require_once("../shared/logincheck.php");
  require_once("../classes/MaterialFieldQuery.php");

  if (!isset($_GET["xref_id"])) {
(new Fatal)->internalError('xfref_id not set');
  }
  
  $matQ = new MaterialFieldQuery;
$matQ->connect_e();
  $matQ->delete($_GET["xref_id"]);
  $matQ->close();
  $msg = "Field Successfully Deleted";
  header("Location: custom_marc_view.php?materialCd=".U($_GET["materialCd"])."&msg=".U($msg));
?>
