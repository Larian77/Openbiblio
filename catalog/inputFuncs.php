<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
define("OBIB_TEXT_CNTRL", "0");
define("OBIB_TEXTAREA_CNTRL", "1");

/*********************************************************************************
 * Draws input html tag of type text.
 * @param string $tag input field tag
 * @param string $subfieldCd input field subfield code
 * @param boolean $required true if field is required
 * @param array_reference &$fieldIds reference to array containing field ids if updating fields
 * @param array_reference &$postVars reference to array containing all input values
 * @param array_reference &$pageErrors reference to array containing all input errors
 * @param array_reference &$marcTags reference to array containing marc tag descriptions
 * @param array_reference &$marcSubflds reference to array containing marc subfield descriptions
 * @param boolean $showTagDesc set to true if the tag description should also show
 * @param string $cntrlType see defined constants OBIB_TEXT_CNTRL & OBIB_TEXTAREA_CNTRL above
 * @param int $occur input field occurance if field is being entered as repeatable
 * @return void
 * @access public
 *********************************************************************************
 */
function printUsmarcInputText($tag,$subfieldCd,$required,&$postVars,&$pageErrors,&$marcTags,&$marcSubflds,$showTagDesc,$cntrlType,$occur=""){
  $arrayIndex = sprintf("%03d",$tag).$subfieldCd;
  $formIndex = $arrayIndex.$occur;
  $size = 40;
  $maxLen = 300;
  $cols = 35;
  $rows = 4;

  if (!isset($postVars)) {
    $value = "";
  } elseif (!isset($postVars['values'][$formIndex])) {
      $value = "";
  } else {
      $value = $postVars['values'][$formIndex];
  }
  if (!isset($postVars['fieldIds'])) {
    $fieldId = "";
  } elseif (!isset($postVars['fieldIds'][$formIndex])) {
      $fieldId = "";
  } else {
      $fieldId = $postVars['fieldIds'][$formIndex];
  }
  if (!isset($pageErrors)) {
    $error = "";
  } elseif (!isset($pageErrors[$formIndex])) {
      $error = "";
  } else {
      $error = $pageErrors[$formIndex];
  }


  echo "<tr><td class=\"primary\" valign=\"top\">\n";
  if ($required) {
    echo "<sup>*</sup> ";
  }
  if (($tag==902) and ($subfieldCd=="a")) {
    echo "<sup>(2)</sup> ";
  }
  if (($showTagDesc) 
    && (isset($marcTags[$tag]))
    && (isset($marcSubflds[$arrayIndex]))){
    echo H($marcTags[$tag]->getDescription());
    echo " (".H($marcSubflds[$arrayIndex]->getDescription()).")";
  } elseif (isset($marcSubflds[$arrayIndex])){
    echo H($marcSubflds[$arrayIndex]->getDescription());
  }
  if ($occur != "") {
    echo " ".H($occur+1);
  }
  echo ":\n</td>\n";
  echo "<td valign=\"top\" class=\"primary\">\n";
  if ($cntrlType == OBIB_TEXTAREA_CNTRL) {
    echo "<textarea name=\"values[".H($formIndex)."]\" cols=\"".H($cols)."\" rows=\"".H($rows)."\">";
    echo H($value)."</textarea>";
  } else {
    echo "<input type=\"text\"";
    echo " name=\"values[".H($formIndex)."]\" size=\"".H($size)."\" maxlength=\"".H($maxLen)."\" ";
    echo "value=\"".H($value)."\" >";
  }
  if ($error != "") {
    echo "<br><font class=\"error\">";
    echo H($error)."</font>";
  }
  echo "<input type=\"hidden\" name=\"indexes[]\" value=\"".H($formIndex)."\" >\n";
  echo "<input type=\"hidden\" name=\"tags[".H($formIndex)."]\" value=\"".H($tag)."\" >\n";
  echo "<input type=\"hidden\" name=\"subfieldCds[".H($formIndex)."]\" value=\"".H($subfieldCd)."\" >\n";
  echo "<input type=\"hidden\" name=\"fieldIds[".H($formIndex)."]\" value=\"".H($fieldId)."\" >\n";
  echo "<input type=\"hidden\" name=\"requiredFlgs[".H($formIndex)."]\" value=\"".H($required)."\" >\n";
  echo "</td></tr>\n";
}

?>
