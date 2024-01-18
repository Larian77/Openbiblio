<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  $postVars["bibid"] = $biblio->getBibid();
  $postVars["collectionCd"] = $biblio->getCollectionCd();
  $postVars["materialCd"] = $biblio->getMaterialCd();
  $postVars["callNmbr1"] = $biblio->getCallNmbr1();
  $postVars["callNmbr2"] = $biblio->getCallNmbr2();
  $postVars["callNmbr3"] = $biblio->getCallNmbr3();
  if ($biblio->showInOpac()) {
    $postVars["opacFlg"] = "CHECKED";
  } else {
    $postVars["opacFlg"] = "";
  }
  $biblioFlds = $biblio->getBiblioFields();
  foreach ($biblioFlds as $key => $biblioFld) {
    // if we allow these tags with a fldid(added from marc screens), we'll get dup data.
    if ( !(($biblioFld->getTag() == 245) && ($biblioFld->getSubfieldCd() == "a") && ($biblioFld->getFieldid() != ""))
      && !(($biblioFld->getTag() == 245) && ($biblioFld->getSubfieldCd() == "b") && ($biblioFld->getFieldid() != ""))
      && !(($biblioFld->getTag() == 245) && ($biblioFld->getSubfieldCd() == "c") && ($biblioFld->getFieldid() != ""))
      && !(($biblioFld->getTag() == 100) && ($biblioFld->getSubfieldCd() == "a") && ($biblioFld->getFieldid() != ""))
      && !(($biblioFld->getTag() == 650) && ($biblioFld->getSubfieldCd() == "a") && ($biblioFld->getFieldid() != "")) ) {
      $postVars['values'][$key] = $biblioFld->getFieldData();
      $postVars['fieldIds'][$key] = $biblioFld->getFieldid();
    }
  }
?>
