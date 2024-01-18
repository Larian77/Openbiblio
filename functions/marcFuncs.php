<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 

/*********************************************************************************
 * Draws input html tag of type text.
 * @param string $tag input field tag
 * @param int $occur input field occurance if field is being entered as repeatable
 * @return void
 * @access public
 *********************************************************************************
 */
function printUsmarcText($tag,$subfieldCd,&$marcTags,&$marcSubflds,$showTagDesc){
  $arrayIndex = sprintf("%03d",$tag).$subfieldCd;

  if (($showTagDesc) 
    && (isset($marcTags[$tag]))
    && (isset($marcSubflds[$arrayIndex]))){
    echo H($marcTags[$tag]->getDescription());
    echo " (".H($marcSubflds[$arrayIndex]->getDescription()).")";
  } elseif (isset($marcSubflds[$arrayIndex])){
    echo H($marcSubflds[$arrayIndex]->getDescription());
  }
}

?>
