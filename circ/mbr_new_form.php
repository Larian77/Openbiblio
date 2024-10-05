<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "circulation";
  $restrictToMbrAuth = TRUE;
  $nav = "new";
  $cancelLocation = "../circ/index.php";
  $focus_form_name = "newmbrform";
  $focus_form_field = "barcodeNmbr";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../shared/header.php");
  require_once("../classes/Member.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  $headerWording = $loc->getText("mbrNewForm");
  $mbr = new Member();
?>
<form name="newmbrform" method="POST" action="../circ/mbr_new.php">
<?php 
include("../circ/mbr_fields.php");
include("../shared/footer.php"); 
?>
