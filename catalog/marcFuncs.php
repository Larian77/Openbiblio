<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  #****************************************************************************
  #*  Read for field value descriptions
  #****************************************************************************
  require_once("../classes/UsmarcTagDm.php");
  require_once("../classes/UsmarcTagDmQuery.php");
  require_once("../classes/UsmarcSubfieldDm.php");
  require_once("../classes/UsmarcSubfieldDmQuery.php");

/**********************************************************************************
 * getTagDesc - sets tag, ind, and subfield descriptions
 * @param string $tag input field tag
 * @param string $subfldCd input field subfield code
 * @param string $tagDesc returned tag description
 * @param string $subfldDesc returned subfield description
 * @param string $ind1Desc returned ind1 description
 * @param string $ind2Desc returned ind1 description
 * @return void
 * @access public
 **********************************************************************************
 */
function getTagDesc($tag,$subfldCd,&$tagDesc,&$subfldDesc,&$ind1Desc,&$ind2Desc){
  $tagDesc = "";
  $subfldDesc = "";
  $ind1Desc = "";
  $ind2Desc = "";
  if ($tag != "") {
    $marcTagDmQ = new UsmarcTagDmQuery();
    $marcTagDmQ->connect_e();
    if ($marcTagDmQ->errorOccurred()) {
      $marcTagDmQ->close();
      displayErrorPage($marcTagDmQ);
    }
    $marcTag = $marcTagDmQ->doQuery($tag);
    if ($marcTagDmQ->errorOccurred()) {
      $marcTagDmQ->close();
      displayErrorPage($marcTagDmQ);
    }
    $marcTagDmQ->close();
    if ($marcTag) {
      $tagDesc = $marcTag->getDescription();
      $ind1Desc = $marcTag->getInd1Description();
      $ind2Desc = $marcTag->getInd2Description();

      # reading for subfield description
      $marcSubfldDmQ = new UsmarcSubfieldDmQuery();
      $marcSubfldDmQ->connect_e();
      if ($marcSubfldDmQ->errorOccurred()) {
        $marcSubfldDmQ->close();
        displayErrorPage($marcSubfldDmQ);
      }
      $marcSubfld = $marcSubfldDmQ->doQuery($tag, $subfldCd);
      if ($marcSubfldDmQ->errorOccurred()) {
        $marcSubfldDmQ->close();
        displayErrorPage($marcSubfldDmQ);
      }
      $marcSubfldDmQ->close();
      if (!$marcSubfld) {
        $subfldDesc = "";
      } else {
        $subfldDesc = $marcSubfld->getDescription();
      }
    }
  }
  return true;
}
?>
