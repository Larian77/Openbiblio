<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
  
  require_once("../functions/formatFuncs.php");
  require_once("../classes/Localize.php");

/******************************************************************************
 * Settings represents the library settings.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class MailMessages {
  var $_mailMessageID = '';
  var $_mailMessageType = '';
  var $_mailFromMail = '';
  var $_mailFromMailErr = '';
  var $_mailFromName = '';
  var $_mailSubject = '';
  var $_mailSubjectErr = '';
  var $_mailBodyHtml = '';
  var $_mailBodyPlain = '';
  var $_mailHtml = '';
  var $_loc;

  //Changes PVD(8.0.x)
  function __construct () {
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  /****************************************************************************
   * getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getMailMessageID() {
    return $this->_mailMessageID;
  }
  function getMailMessageType() {
    return $this->_mailMessageType;
  }
  function getMailFromMail() {
    return $this->_mailFromMail;
  }
  function getMailFromMailErr() {
      return $this->_mailFromMailErr;
  }
  function getMailFromName() {
      return $this->_mailFromName;
  }
  function getMailSubject() {
    return $this->_mailSubject;
  }
  function getMailSubjectErr() {
      return $this->_mailSubjectErr;
  }
  function getMailBodyHtml() {
    return $this->_mailBodyHtml;
  }
  function getMailBodyPlain() {
      return $this->_mailBodyPlain;
  }
  function getMailHtml() {
    return $this->_mailHtml;
  }
  
  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setMailMessageID($value) {
      $this->_mailMessageID = $value;
  }
  function setMailMessageType($value) {
    $this->_mailMessageType = trim($value);
  }
  function setMailFromMail($value) {
    $this->_mailFromMail = trim($value);
  }
  function setMailFromName($value) {
      $this->_mailFromName = $value;
  }
  function setMailSubject($value) {
    $this->_mailSubject = trim($value);
  }
  function setMailBodyHtml($value) {
    $this->_mailBodyHtml = trim($value);
  }
  function setMailBodyPlain($value) {
    $this->_mailBodyPlain = trim($value);
  }
  function setMailHtml($value) {
      $this->_mailHtml = trim($value);
  }

  /****************************************************************************
  * @return boolean true if data is valid, otherwise false.
  * @access public
  ****************************************************************************
  */
  function validateData() {
    $validData = true;
    if (!filter_var($this->_mailFromMail, FILTER_VALIDATE_EMAIL)) {
        $validData = false;
        $this->_mailFromMailErr = $this->_loc->getText("UserEmailCharErr");
    }
    if ($this->_mailSubject == "") {
      $validData = false;
      $this->_mailSubjectErr = $this->_loc->getText("mailSubjectReqErr");
    }

    return $validData;
  }
  
}

?>
