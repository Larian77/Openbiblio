<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../functions/formatFuncs.php");
  require_once("../classes/Localize.php");

/******************************************************************************
 * Member represents a library member.  Contains business rules for
 * member data validation.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Member {
  var $_mbrid = 0;
  var $_barcodeNmbr = 0;
  var $_barcodeNmbrError = "";
  var $_createDt = "";
  var $_lastChangeDt = "";
  var $_lastChangeUserid = "";
  var $_lastChangeUsername = "";
  var $_classification = "";
  var $_lastName = "";
  var $_lastNameError = "";
  var $_firstName = "";
  var $_firstNameError = "";
  var $_email = "";
  var $_address = "";
  var $_homePhone = "";
  var $_workPhone = "";
  var $_membershipEnd = "";
  var $_membershipEndError = "";
  var $_custom = array();
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
    if ($this->_barcodeNmbr == "") {
      $valid = false;
      $this->_barcodeNmbrError = $this->_loc->getText("memberBarcodeReqErr");
    } else if (!preg_match(OBIB_BARCODE_RE, $this->_barcodeNmbr)) {
      $valid = FALSE;
      $this->_barcodeNmbrError = $this->_loc->getText("memberBarcodeCharErr");
    }
    if ($this->_lastName == "") {
      $valid = false;
      $this->_lastNameError = $this->_loc->getText("memberLastNameReqErr");
    }
    if ($this->_firstName == "") {
      $valid = false;
      $this->_firstNameError = $this->_loc->getText("memberFirstNameReqErr");
    }
    if ($this->getMembershipEnd()!="0000-00-00") {
      $year = substr($this->getMembershipEnd(), 0, 4);
      $month = (int)substr($this->getMembershipEnd(), 5, 2);
      $day = (int)substr($this->getMembershipEnd(), 8, 2);
      if (!checkdate($month,$day,$year)) {
        $valid = false;
	$this->_membershipEndError = "The enddate isn't valid.";
      }
    }

    return $valid;
  }
  
  function getCustom($field) {
    if (isset($this->_custom[$field])) {
      return $this->_custom[$field];
    }
    return "";
  }
  function setCustom($field, $value) {
    $this->_custom[$field] = $value;
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
  function getBarcodeNmbr() {
    return $this->_barcodeNmbr;
  }
  function getBarcodeNmbrError() {
    return $this->_barcodeNmbrError;
  }
  function getCreateDt() {
    return $this->_createDt;
  }
  function getLastChangeDt() {
    return $this->_lastChangeDt;
  }
  function getLastChangeUserid() {
    return $this->_lastChangeUserid;
  }
  function getLastChangeUsername() {
    return $this->_lastChangeUsername;
  }
  function getLastName() {
    return $this->_lastName;
  }
  function getLastNameError() {
    return $this->_lastNameError;
  }
  function getFirstName() {
    return $this->_firstName;
  }
  function getFirstNameError() {
    return $this->_firstNameError;
  }
  function getFirstLastName() {
    return $this->_firstName." ".$this->_lastName;
  }
  function getLastFirstName() {
    return $this->_lastName.",".$this->_firstName;
  }
  function getAddress() {
    return $this->_address;
  }
  function getHomePhone() {
    return $this->_homePhone;
  }
  function getWorkPhone() {
    return $this->_workPhone;
  }
  function getEmail() {
    return $this->_email;
  }
  function getMembershipEnd() {
    return $this->_membershipEnd;
  }
  function getMembershipEndError() {
    return $this->_membershipEndError;
  }
  function getClassification() {
    return $this->_classification;
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
  function setBarcodeNmbr($value) {
    $this->_barcodeNmbr = trim($value ?? '');
  }
  function setCreateDt($value) {
    $this->_createDt = trim($value ?? '');
  }
  function setLastChangeDt($value) {
    $this->_lastChangeDt = trim($value ?? '');
  }
  function setLastChangeUserid($value) {
    $this->_lastChangeUserid = trim($value ?? '');
  }
  function setLastChangeUsername($value) {
    $this->_lastChangeUsername = trim($value ?? '');
  }
  function setLastName($value) {
    $this->_lastName = trim($value ?? '');
  }
  function setLastNameError($value) {
    $this->_lastNameError = trim($value ?? '');
  }
  function setFirstName($value) {
    $this->_firstName = trim($value ?? '');
  }
  function setFirstNameError($value) {
    $this->_firstNameError = trim($value ?? '');
  }
  function setAddress($value) {
    $this->_address = trim($value ?? '');
  }
  function setHomePhone($value) {
    $this->_homePhone = trim($value ?? '');
  }
  function setWorkPhone($value) {
    $this->_workPhone = trim($value ?? '');
  }
  function setEmail($value) {
    $this->_email = trim($value ?? '');
  }
  function setMembershipEnd ($value) {
    $temp = trim($value ?? '');
    if ($temp == "") {
      $this->_membershipEnd = "0000-00-00";
    } else {
      $this->_membershipEnd = $temp;
    }
  }
  function setMembershipEndError($value) {
    $this->_membershipEndError = trim($value ?? '');
  }
  function setClassification($value) {
    $this->_classification = trim($value ?? '');
  }
}

?>
