<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/******************************************************************************
 * Dm represents a domain table row.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Dm {
  var $_code = "";
  var $_description = "";
  var $_descriptionError = "";
  var $_defaultFlg = "";
  var $_daysDueBack = "0";
  var $_daysDueBackError = "";
  var $_dailyLateFee = "0";
  var $_dailyLateFeeError = "";
  var $_imageFile = "";
  var $_checkoutLimit = 0;
  var $_renewalLimit = 0;
  var $_maxFines = 0;
  var $_count = "0";

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   *
   * TODO: Error responses need to be internationalised
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
    if ($this->_description == "") {
      $valid = false;
      $this->_descriptionError = "Description is required.";
    }
    $this->_validateFieldNumericAndPositiveOrZero($valid,
                $this->_daysDueBack,
                $this->_daysDueBackError,
                "Days due back must be numeric.",
                "Days due back can not be less than zero.");
    $this->_validateFieldNumericAndPositiveOrZero($valid,
                $this->_dailyLateFee,
                $this->_dailyLateFeeError,
                "Daily late fee must be numeric.",
                "Daily late fee can not be less than zero.");
    return $valid;
  }

  /****************************************************************************
   * Validation Function. Ensures the specified field is numeric and a positive
   * number (zero is ok).
   *
   * @param boolean $valid                 Set to false if the specified field is not validate
   * @param string  $fieldToValidate       Specified field to validate
   * @param string  $errorResponse         Populated with the appropriate error message if validation fails
   * @param string  $mustBeNumericErrorMsg Error Message to use on a numeric validation failure
   * @param string  $mustBePositiveOrZeroErrorMsg Error Message to use on a positive or zero validation failure
   *
   * @return void
   * @access private
   ****************************************************************************
   */
  function _validateFieldNumericAndPositiveOrZero(&$valid, &$fieldToValidate, &$errorResponse, $mustBeNumericErrorMsg, $mustBePositiveOrZeroErrorMsg) {
    if (!is_numeric($fieldToValidate)) {
      $valid = false;
      $errorResponse = $mustBeNumericErrorMsg;
    } elseif ($fieldToValidate < 0) {
      $valid = false;
      $errorResponse = $mustBeGtErrorMsg;
    }
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getCode() {
    return $this->_code;
  }
  function getDescription() {
    return $this->_description;
  }
  function getDescriptionError() {
    return $this->_descriptionError;
  }
  function getDefaultFlg() {
    return $this->_defaultFlg;
  }
  function getDaysDueBack() {
    return $this->_daysDueBack;
  }
  function getDaysDueBackError() {
    return $this->_daysDueBackError;
  }
  function getDailyLateFee() {
    return $this->_dailyLateFee;
  }
  function getDailyLateFeeError() {
    return $this->_dailyLateFeeError;
  }
  function getImageFile() {
    return $this->_imageFile;
  }
  function getCheckoutLimit() {
    return $this->_checkoutLimit;
  }
  function getRenewalLimit() {
    return $this->_renewalLimit;
  }
  function getMaxFines() {
    return $this->_maxFines;
  }
  function getCount() {
    return $this->_count;
  }

  /****************************************************************************
   * Generic setter method for numeric fields. Ensures the value set is trimmed,
   * and defaulting to 0 if an empty field is passed.
   *
   * @param string $valueToSet New value to set
   * @param string $destinationField The destination field
   *
   * @return void
   * @access private
   ****************************************************************************
   */
  function _setNumeric(&$valueToSet, &$destinationField) {
    if (trim($valueToSet) == "") {
      $destinationField = "0";
    } else {
      $destinationField = trim($valueToSet);
    }
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setCode($value) {
    $this->_code = trim($value);
  }
  function setDescription($value) {
    $this->_description = trim($value);
  }
  function setDescriptionError($value) {
    $this->_descriptionError = trim($value);
  }
  function setDefaultFlg($value) {
    $this->_defaultFlg = trim($value);
  }
  function setDaysDueBack($value) {
    $this->_setNumeric($value, $this->_daysDueBack);
  }
  function setDaysDueBackError($value) {
    $this->_daysDueBackError = trim($value);
  }
  function setDailyLateFee($value) {
    $this->_setNumeric($value, $this->_dailyLateFee);
  }
  function setDailyLateFeeError($value) {
    $this->_dailyLateFeeError = trim($value);
  }
  function setImageFile($value) {
    $temp = trim($value);
    $fileloc = "../images/$temp";
    if (($temp == "") or (!file_exists($fileloc))) {
      $this->_imageFile = "shim.gif";
    } else {
      $this->_imageFile = $temp;
    }
  }
  function setCheckoutLimit($value) {
    $this->_checkoutLimit = trim($value);
  }
  function setRenewalLimit($value) {
    $this->_renewalLimit = trim($value);
  }
  function setMaxFines($value) {
    $this->_maxFines = trim($value);
  }
  function setCount($value) {
    $this->_setNumeric($value, $this->_count);
  }
}

?>
