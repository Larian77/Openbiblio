<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");

$tab = "cataloging";
$nav = "edit";

require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,$tab);

if (!isset($_REQUEST['posted'])) {
  require_once("../shared/logincheck.php");
  if (!isset($_REQUEST['bibid'])) {
    header("Location: ../catalog/index.php");
    exit();
  }
  $postVars = bibidToPostVars($_REQUEST['bibid']);
  showForm($postVars);
} else {
  $postVars = $_POST;
  if ($_REQUEST['posted'] == 'media_change') {
    require_once("../shared/logincheck.php");
    # Pull in values for new custom fields from the record.
    $v = bibidToPostVars($_REQUEST['bibid']);
    foreach ($v['values'] as $k=>$v) {
      if (!isset($postVars['values'][$k])) {
        $postVars['values'][$k] = $v;
      }
    }
    showForm($postVars);
  } else {
    $restrictInDemo = true;
    require_once("../shared/logincheck.php");
    $biblio = postVarsToBiblio($postVars);
    $pageErrors = array();
    if (!$biblio->validateData()) {
      $pageErrors = array_merge($pageErrors, biblioToPageErrors($biblio));
    }
    $pageErrors = array_merge($pageErrors, customFieldErrors($biblio));
    if (!empty($pageErrors)) {
      showForm($postVars, $pageErrors);
    } else {
      updateBiblio($biblio);
      $msg = $loc->getText("biblioEditSuccess");
      header("Location: ../shared/biblio_view.php?bibid=".U($postVars['bibid'])."&msg=".U($msg));
    }
  }
}

function bibidToPostVars($bibid) {
  require_once("../classes/BiblioQuery.php");
  
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
  include("biblio_post_conversion.php");
  return $postVars;
}
function postVarsToBiblio($post) {
  require_once("../classes/Biblio.php");
  require_once("../classes/BiblioField.php");
  
  $biblio = new Biblio();
  $biblio->setBibid($post['bibid']);
  $biblio->setMaterialCd($post["materialCd"]);
  $biblio->setCollectionCd($post["collectionCd"]);
  $biblio->setCallNmbr1($post["callNmbr1"]);
  $biblio->setCallNmbr2($post["callNmbr2"]);
  $biblio->setCallNmbr3($post["callNmbr3"]);
  $biblio->setLastChangeUserid($_SESSION["userid"]);
  $biblio->setOpacFlg(isset($post["opacFlg"]));
  $indexes = $post["indexes"];
  foreach($indexes as $index) {
    $value = $post["values"][$index];
    $fieldid = $post["fieldIds"][$index];
    $tag = $post["tags"][$index];
    $subfieldCd = $post["subfieldCds"][$index];
    $requiredFlg = $post["requiredFlgs"][$index];
    $biblioFld = new BiblioField();
    $biblioFld->setBibid($post['bibid']);
    $biblioFld->setFieldid($fieldid);
    $biblioFld->setTag($tag);
    $biblioFld->setSubfieldCd($subfieldCd);
    $biblioFld->setIsRequired($requiredFlg);
    $biblioFld->setFieldData($value);
    $biblio->addBiblioField($index,$biblioFld);
  }
  return $biblio;
}
function biblioToPageErrors($biblio) {
  $pageErrors = array();
  $pageErrors["callNmbr1"] = $biblio->getCallNmbrError();
  $biblioFlds = $biblio->getBiblioFields();
  foreach($biblio->getBiblioFields() as $index => $field) {
    if ($field->getFieldDataError() != "") {
      $pageErrors[$index] = $field->getFieldDataError();
    }
  }
  return $pageErrors;
}
function customFieldErrors($biblio) {
  require_once("../classes/MaterialFieldQuery.php");
  $matQ = new MaterialFieldQuery();
  $matQ->connect_e();
  $rows = $matQ->get($biblio->getMaterialCd());
  $matQ->close();
  $errors = array();
  $fields = $biblio->getBiblioFields();
  foreach ($rows as $row) {
    $idx = sprintf('%03d%s', $row['tag'], $row['subfieldCd']);
    if ($row['required'] == 'Y') {
      if (!isset($fields[$idx]) or $fields[$idx]->getFieldData() == '') {
        $errors[$idx] = 'Field is required.';
      }
    }
  }
  return $errors;
}
function updateBiblio($biblio) {
  require_once("../classes/BiblioQuery.php");
  
  $biblioQ = new BiblioQuery();
  $biblioQ->connect_e();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->update($biblio)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  $biblioQ->close();
}
function showForm($postVars, $pageErrors=array()) {
  global $tab, $nav, $loc;
  $helpPage = "biblioEdit";
  $focus_form_name = "editbiblioform";
  $focus_form_field = "materialCd";
  $bibid=$postVars['bibid'];
  require_once("../shared/header.php");

  $cancelLocation = "../shared/biblio_view.php?bibid=".$postVars["bibid"];
  $headerWording="Edit";
?>
  <script>
    <!--
      function matCdReload(){
        document.editbiblioform.posted.value='media_change';
        document.editbiblioform.submit();
      }
    //-->
  </script>
<form name="editbiblioform" method="POST"
	action="../catalog/biblio_edit.php">
	<input type="hidden" name="bibid"
		value="<?php echo H($postVars["bibid"]);?>">
<?php
  include("../catalog/biblio_fields.php");
  include("../shared/footer.php");
}

?>
