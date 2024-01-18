<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/*********************************************************************************
 * explodes a quoted string into words
 * @param string $str String to be exploded
 * @return $elemnts stringArray
 * @access public
 *********************************************************************************
 */
function explodeQuoted($str) {
  if ($str == ""){
    $elements[]="";
    return $elements; 
  }

  $inQuotes=false; 

  $words=explode(" ", $str); 
  foreach($words as $word) { 
    if($inQuotes==true) { 
      // add word to the last element 
      $elements[sizeof($elements)-1].=" ".str_replace('"','',$word); 
      if($word[strlen($word)-1]=="\"") $inQuotes=false; 
    } else { 
      // create a new element 
      $elements[]=str_replace('"','',$word);
      if($word[0]=="\"" && $word[strlen($word)-1]!="\"") $inQuotes=true; 
    } 
  } 
  return $elements; 
}

?>
