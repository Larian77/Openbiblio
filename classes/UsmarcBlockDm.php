<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/******************************************************************************
 * UsmarcBlockDm represents a row in usmarc_block_dm.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class UsmarcBlockDm {
  var $_blockNmbr = "";
  var $_description = "";

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getBlockNmbr() {
    return $this->_blockNmbr;
  }
  function getDescription() {
    return $this->_description;
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
  function setDescription($value) {
    $this->_description = trim($value);
  }

}

?>
