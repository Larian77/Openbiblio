<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "cataloging";
  $nav = "editmarcfield";
  $focus_form_name = "editmarcform";
  $focus_form_field = "tag";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../catalog/marcFuncs.php");
  require_once("../classes/BiblioField.php");
  require_once("../classes/BiblioFieldQuery.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $postVars = array();
  $pageErrors = array();
  if (isset($_GET["bibid"])) {
    $bibid = $_GET["bibid"];
    if (!isset($_GET['fieldid'])) {
      Fatal::internalError('no fieldid set');
    }
    $fieldid = $_GET["fieldid"];

    #****************************************************************************
    #*  Reading database for subfield values
    #****************************************************************************
    $fieldQ = new BiblioFieldQuery();
    $fieldQ->connect_e();
    if ($fieldQ->errorOccurred()) {
      $fieldQ->close();
      displayErrorPage($fieldQ);
    }
    $field = $fieldQ->doQuery($bibid,$fieldid);
    if ($fieldQ->errorOccurred()) {
      $fieldQ->close();
      displayErrorPage($fieldQ);
    }
    $fieldQ->close();

    $postVars["bibid"] = $bibid;
    $postVars["fieldid"] = $bibid;
    $postVars["tag"] = $field->getTag();
    $postVars["ind1Cd"] = $field->getInd1Cd();
    $postVars["ind2Cd"] = $field->getInd2Cd();
    $postVars["subfieldCd"] = $field->getSubfieldCd();
    $postVars["fieldData"] = $field->getFieldData();
    $selectedTag = $field->getTag();
    $selectedSubfld = $field->getSubfieldCd();
  } else {
    $postVars = $_SESSION['postVars'];
    if (isset($_SESSION['pageErrors'])) {
      $pageErrors = $_SESSION['pageErrors'];
    }
    $bibid = $postVars["bibid"];
    $fieldid = $postVars["fieldid"];
    $selectedTag = $postVars["tag"];
    $selectedSubfld = $postVars["subfieldCd"];
  }
  if (!isset($bibid) || $bibid == "") {
    Fatal::internalError('no bibid set');
  }
  if (!isset($fieldid) || $fieldid == "") {
    Fatal::internalError('no fieldid set');
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
  getTagDesc($selectedTag,$selectedSubfld,$tagDesc,$subfldDesc,$ind1Desc,$ind2Desc);

  $formLabel = $loc->getText("biblioMarcEditFormHdr");
  $returnPg = "../catalog/biblio_marc_edit_form.php?bibid=".U($bibid)."&fieldid=".U($fieldid);

  #****************************************************************************
  #*  Start of body
  #****************************************************************************
  ?>
  
<form name="editmarcform" method="POST" action="../catalog/biblio_marc_edit.php">
<?php include("../catalog/biblio_marc_fields.php"); ?>
<input type="hidden" name="bibid" value="<?php echo H($bibid);?>">
<input type="hidden" name="fieldid" value="<?php echo H($fieldid);?>">
</form>
  


<?php include("../shared/footer.php"); ?>
