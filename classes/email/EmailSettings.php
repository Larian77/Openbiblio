<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/******************************************************************************
 * Settings represents the library settings.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class MailSettings {
  var $_pwdForgottenSettings = 0;
  var $_pwdForgottenCodeDuration = 2;
  var $_mailProcess = 0;
  var $_mailHost = "";
  var $_mailUser = false;
  var $_mailPwd = "";
  var $_mailSmtpSecure = "";
  var $_mailHtml = false;

  /****************************************************************************
   * getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getPwdForgottenSettings() {
      return $this->_pwdForgottenSettings;
  }
  function getPwdForgottenCodeDuration() {
    return $this->_pwdForgottenCodeDuration;
  }
  function getMailProcess() {
    return $this->_mailProcess;
  }
  function getMailHost() {
    return $this->_mailHost;
  }
  function getMailUser() {
      return $this->_mailUser;
  }
  function getMailPwd() {
    return $this->_mailPwd;
  }
  function getMailSmtpSecure() {
    return $this->_mailSmtpSecure;
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
  function setPwdForgottenSettings($value) {
      $this->_pwdForgottenSettings = $value;
  }
  function setPwdForgottenCodeDuration($value) {
    $this->_pwdForgottenCodeDuration = trim($value);
  }
  function setMailProcess($value) {
    $this->_mailProcess = trim($value);
  }
  function setMailHost($value) {
    $this->_mailHost = trim($value);
  }
  function setMailUser($value) {
      $this->_mailUser = $value;
  }
  function setMailPwd($value) {
    $this->_mailPwd = trim($value);
  }
  function setMailSmtpSecure($value) {
    $this->_mailSmtpSecure = trim($value);
  }
  function setMailHtml($value) {
      $this->_mailHtml = $value;
  }

}

?>
