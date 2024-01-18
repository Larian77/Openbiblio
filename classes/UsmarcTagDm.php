<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/******************************************************************************
 * UsmarcTagDm represents a row in usmarc_tag_dm.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class UsmarcTagDm {
  var $_blockNmbr = "";
  var $_tag = "";
  var $_description = "";
  var $_ind1Description = "";
  var $_ind2Description = "";
  var $_repeatableFlg = "";

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getBlockNmbr() {
    return $this->_blockNmbr;
  }
  function getTag() {
    return $this->_tag;
  }
  function getDescription() {
    return $this->_description;
  }
  function getInd1Description() {
    return $this->_ind1Description;
  }
  function getInd2Description() {
    return $this->_ind2Description;
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
  function setBlockNmbr($value) {
    if (trim($value) == "") {
      $this->_blockNmbr = "0";
    } else {
      $this->_blockNmbr = trim($value);
    }
  }
  function setTag($value) {
    if (trim($value) == "") {
      $this->_tag = "0";
    } else {
      $this->_tag = trim($value);
    }
  }
  function setDescription($value) {
    $this->_description = trim($value);
  }
  function setInd1Description($value) {
    $this->_ind1Description = trim($value);
  }
  function setInd2Description($value) {
    $this->_ind2Description = trim($value);
  }
  function setRepeatableFlg($value) {
    $this->_repeatableFlg = trim($value);
  }

}

?>
