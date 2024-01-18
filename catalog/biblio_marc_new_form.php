<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "cataloging";
  $nav = "newmarc";
  $focus_form_name = "newmarcform";
  $focus_form_field = "tag";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../catalog/marcFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $postVars = array();
  $pageErrors = array();
  if (isset($_GET["bibid"])) {
    $bibid = $_GET["bibid"];
    $postVars["bibid"] = $bibid;
    $postVars["tag"] = "";
    $postVars["ind1Cd"] = "";
    $postVars["ind2Cd"] = "";
    $postVars["subfieldCd"] = "";
    $postVars["fieldData"] = "";
    $selectedTag = "";
    $selectedSubfld = "";
  } else if (isset($_SESSION['postVars'])) {
    $postVars = $_SESSION['postVars'];
    if (isset($_SESSION['pageErrors'])) {
      $pageErrors = $_SESSION['pageErrors'];
    }
    $bibid = $postVars["bibid"];
    $selectedTag = $postVars["tag"];
    $selectedSubfld = $postVars["subfieldCd"];
  }
  if (!isset($bibid) || $bibid == "") {
    Fatal::internalError('no bibid set');
  }
  if (isset($_GET["tag"])) {
    $selectedTag = $_GET["tag"];
    $postVars["tag"] = $selectedTag;
  }
  if (isset($_GET["subfld"])) {
    $selectedSubfld = $_GET["subfld"];
    $postVars["subfieldCd"] = $selectedSubfld;
  }
    
  require_once("../shared/header.php");

  #****************************************************************************
  #*  Read for field value descriptions
  #****************************************************************************
  if (isset($pageErrors["tag"]) && ($pageErrors["tag"] <> "")){
    $tagDesc = "";
    $subfldDesc = "";
    $ind1Desc = "";
    $ind2Desc = "";
  } else {
    getTagDesc($selectedTag,$selectedSubfld,$tagDesc,$subfldDesc,$ind1Desc,$ind2Desc);
  }

  $formLabel = $loc->getText("biblioMarcNewFormHdr");
  $returnPg = "../catalog/biblio_marc_new_form.php?bibid=".U($bibid);
  $fieldid = "";

  #****************************************************************************
  #*  Start of body
  #****************************************************************************
  ?>
  
<form name="newmarcform" method="POST" action="../catalog/biblio_marc_new.php">
<?php include("../catalog/biblio_marc_fields.php"); ?>
<input type="hidden" name="bibid" value="<?php echo H($bibid);?>">
</form>
  


<?php include("../shared/footer.php"); ?>
