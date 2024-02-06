<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "cataloging";
  $nav = "new";
  $helpPage = "biblioEdit";
  $focus_form_name = "newbiblioform";
  $focus_form_field = "materialCd";
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Biblio.php");
  require_once("../classes/BiblioQuery.php");
  require_once("../classes/Localize.php");

  $loc = new Localize(OBIB_LOCALE,$tab);

  if (isset($_GET["bibid"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);
    #****************************************************************************
    #*  Retrieving get var
    #****************************************************************************
    $bibid = $_GET["bibid"];

    #****************************************************************************
    #*  Search database
    #****************************************************************************
    $biblioQ = new BiblioQuery();
    $biblioQ->connect_e();
    if ($biblioQ->errorOccurred()) {
      $biblioQ->close();
      displayErrorPage($biblioQ);
    }
    if (!$biblio = $biblioQ->doQuery($bibid)) {
      $biblioQ->close();
      displayErrorPage($biblioQ);
    }
    foreach ($biblio->getBiblioFields() as $value) {
	$value->setFieldid('');
    }

    #**************************************************************************
    #*  load up post vars
    #**************************************************************************
    include("biblio_post_conversion.php");
  }
  require_once("../shared/header.php");

  $cancelLocation = "../shared/biblio_view.php?bibid=".$postVars["bibid"];
  $headerWording="New";

?>

  <script>
    <!--
      function matCdReload(){
        document.newbiblioform.posted.value='media_change';
        document.newbiblioform.submit();
      }
    //-->
  </script>
<form name="newbiblioform" method="POST"
	action="../catalog/biblio_new.php">
<?php include("../catalog/biblio_fields.php"); ?>
<?php include("../shared/footer.php"); ?>
