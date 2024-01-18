<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/******************************************************************************
 * UsmarcSubfieldDm represents a row in usmarc_subfield_dm.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class UsmarcSubfieldDm {
  var $_tag = "";
  var $_subfieldCd = "";
  var $_description = "";
  var $_repeatableFlg = "";

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getTag() {
    return $this->_tag;
  }
  function getSubfieldCd() {
    return $this->_subfieldCd;
  }
  function getDescription() {
    return $this->_description;
  }
  function getRepeatableFlg() {
    return $this->_repeatableFlg;
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setTag($value) {
    if (trim($value) == "") {
      $this->_tag = "0";
    } else {
      $this->_tag = trim($value);
    }
  }
  function setSubfieldCd($value) {
    $this->_subfieldCd = substr(trim($value),0,1);
  }
  function setDescription($value) {
    $this->_description = trim($value);
  }
  function setRepeatableFlg($value) {
    $this->_repeatableFlg = trim($value);
  }

}

?>
