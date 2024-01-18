<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");

/******************************************************************************
 * BiblioHold represents a hold placed on a library bibliography copy record.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioHold {
  var $_bibid = "";
  var $_copyid = "";
  var $_holdid = "";
  var $_holdBeginDt = "";
  var $_mbrid = "";
  var $_barcodeNmbr = "";
  var $_statusCd = "";
  var $_dueBackDt = "";
  var $_title = "";
  var $_author = "";
  var $_materialCd = "";
  var $_lastName = "";
  var $_firstName = "";
  var $_loc;

  function BiblioCopy () {
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
/*    if ($this->_barcodeNmbr == "") {
      $valid = false;
      $this->_barcodeNmbrError = $this->_loc->getText("biblioCopyError1");
    } else if (!is_numeric($this->_barcodeNmbr)) {
      $valid = false;
      $this->_barcodeNmbrError = $this->_loc->getText("biblioCopyError2");
    }
*/
    return $valid;
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getBibid() {
    return $this->_bibid;
  }
  function getCopyid() {
    return $this->_copyid;
  }
  function getHoldid() {
    return $this->_holdid;
  }
  function getHoldBeginDt() {
    return $this->_holdBeginDt;
  }
  function getMbrid() {
    return $this->_mbrid;
  }
  function getBarcodeNmbr() {
    return $this->_barcodeNmbr;
  }
  function getStatusCd() {
    return $this->_statusCd;
  }
  function getDueBackDt() {
    return $this->_dueBackDt;
  }
  function getTitle() {
    return $this->_title;
  }
  function getAuthor() {
    return $this->_author;
  }
  function getMaterialCd() {
    return $this->_materialCd;
  }
  function getLastName() {
    return $this->_lastName;
  }
  function getFirstName() {
    return $this->_firstName;
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setBibid($value) {
    $this->_bibid = trim($value);
  }
  function setCopyid($value) {
    $this->_copyid = trim($value);
  }
  function setHoldid($value) {
    $this->_holdid = trim($value);
  }
  function setHoldBeginDt($value) {
    $this->_holdBeginDt = trim($value);
  }
  function setStatusCd($value) {
    $this->_statusCd = trim($value);
  }
  function setDueBackDt($value) {
    $this->_dueBackDt = trim($value);
  }
  function setMbrid($value) {
    $this->_mbrid = trim($value);
  }
  function setBarcodeNmbr($value) {
    $this->_barcodeNmbr = trim($value);
  }
  function setTitle($value) {
    $this->_title = trim($value);
  }
  function setAuthor($value) {
    $this->_author = trim($value);
  }
  function setMaterialCd($value) {
    $this->_materialCd = trim($value);
  }
  function setLastName($value) {
    $this->_lastName = trim($value);
  }
  function setFirstName($value) {
    $this->_firstName = trim($value);
  }
}

?>
