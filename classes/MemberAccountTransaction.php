<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");

/******************************************************************************
 * MemberAccountTransaction represents a member account transaction
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class MemberAccountTransaction {
  var $_mbrid = "";
  var $_transid = "";
  var $_createDt = "";
  var $_createUserid = "";
  var $_transactionTypeCd = "";
  var $_transactionTypeDesc = "";
  var $_amount = "";
  var $_amountError = "";
  var $_description = "";
  var $_descriptionError = "";
  var $_loc;

  //Changes PVD(8.0.x)
  function __construct () {
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
    if ($this->_amount == "") {
      $valid = FALSE;
      $this->_amountError = $this->_loc->getText("memberAccountTransError1");
    } else if (!is_numeric($this->_amount)) {
      $valid = FALSE;
      $this->_amountError = $this->_loc->getText("memberAccountTransError2");
    } else if ($this->_amount <= 0) {
      $valid = FALSE;
      $this->_amountError = $this->_loc->getText("Amount must be greater than zero.");
    }
    if ($this->_description == "") {
      $valid = false;
      $this->_descriptionError = $this->_loc->getText("memberAccountTransError3");
    }
    return $valid;
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getMbrid() {
    return $this->_mbrid;
  }
  function getTransid() {
    return $this->_transid;
  }
  function getCreateDt() {
    return $this->_createDt;
  }
  function getCreateUserid() {
    return $this->_createUserid;
  }
  function getTransactionTypeCd() {
    return $this->_transactionTypeCd;
  }
  function getTransactionTypeDesc() {
    return $this->_transactionTypeDesc;
  }
  function getAmount() {
    return $this->_amount;
  }
  function getAmountError() {
    return $this->_amountError;
  }
  function getDescription() {
    return $this->_description;
  }
  function getDescriptionError() {
    return $this->_descriptionError;
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setMbrid($value) {
    $this->_mbrid = trim($value ?? '');
  }
  function setTransid($value) {
    $this->_transid = trim($value ?? '');
  }
  function setCreateDt($value) {
    $this->_createDt = trim($value ?? '');
  }
  function setCreateUserid($value) {
    $this->_createUserid = trim($value ?? '');
  }
  function setTransactionTypeCd($value) {
    $this->_transactionTypeCd = trim($value ?? '');
  }
  function setTransactionTypeDesc($value) {
    $this->_transactionTypeDesc = trim($value ?? '');
  }
  function setAmount($value) {
    $this->_amount = trim($value ?? '');
  }
  function setDescription($value) {
    $this->_description = trim($value ?? '');
  }

}

?>
