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
class Settings {
  var $_libraryName = "";
  var $_libraryImageUrl = "";
  var $_isUseImageSet = false;
  var $_libraryHours = "";
  var $_libraryPhone = "";
  var $_libraryUrl = "";
  var $_opacUrl = "";
  var $_sessionTimeout = 0;
  var $_sessionTimeoutError = "";
  var $_itemsPerPage = 0;
  var $_itemsPerPageError = "";
  var $_version = "";
  var $_themeid = 0;
  var $_purgeHistoryAfterMonths = 0;
  var $_purgeHistoryAfterMonthsError = "";
  var $_isBlockCheckoutsWhenFinesDue = TRUE;
  var $_holdMaxDays = 0;
  var $_locale = "";
  var $_charset = "";
  var $_htmlLangAttr = "";

  /****************************************************************************
  * @return array with code and description of installed locales
  * @access public
  ****************************************************************************
  */
  function getLocales () {
    $dir_handle = opendir(OBIB_LOCALE_ROOT);
    $arr_locale = array();
    
    while (false!==($file=readdir($dir_handle))) {
      if ($file != '.' && $file != '..') {
        if (is_dir (OBIB_LOCALE_ROOT."/".$file)) {
          if (file_exists(OBIB_LOCALE_ROOT.'/'.$file.'/metadata.php')) {
            include(OBIB_LOCALE_ROOT.'/'.$file.'/metadata.php');
	    $arr_temp = array($file => $lang_metadata['locale_description']);
	    $arr_locale = array_merge($arr_locale, $arr_temp);
          }
        }
      }
    }
    closedir($dir_handle);
    return $arr_locale;
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
    if (!is_numeric($this->_sessionTimeout)) {
      $valid = false;
      $this->_sessionTimeoutError = "Session timeout must be numeric.";
    } elseif ($this->_sessionTimeout <= 0) {
      $valid = false;
      $this->_sessionTimeoutError = "Session timeout must be greater than 0.";
    }
    if (!is_numeric($this->_itemsPerPage)) {
      $valid = false;
      $this->_itemsPerPageError = "Items per page must be numeric.";
    } elseif ($this->_itemsPerPage <= 0) {
      $valid = false;
      $this->_itemsPerPageError = "Items per page must be greater than 0.";
    }
    if (!is_numeric($this->_purgeHistoryAfterMonths)) {
      $valid = FALSE;
      $this->_purgeHistoryAfterMonthsError = "Months must be numeric.";
    }
    return $valid;
  }

  /****************************************************************************
   * getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getLibraryName() {
    return $this->_libraryName;
  }
  function getLibraryImageUrl() {
    return $this->_libraryImageUrl;
  }
  function isUseImageSet() {
    return $this->_isUseImageSet;
  }
  function getLibraryHours() {
    return $this->_libraryHours;
  }
  function getLibraryPhone() {
    return $this->_libraryPhone;
  }
  function getLibraryUrl() {
    return $this->_libraryUrl;
  }
  function getOpacUrl() {
    return $this->_opacUrl;
  }
  function getSessionTimeout() {
    return $this->_sessionTimeout;
  }
  function getSessionTimeoutError() {
    return $this->_sessionTimeoutError;
  }
  function getItemsPerPage() {
    return $this->_itemsPerPage;
  }
  function getItemsPerPageError() {
    return $this->_itemsPerPageError;
  }
  function getVersion() {
    return $this->_version;
  }
  function getThemeid() {
    return $this->_themeid;
  }
  function getPurgeHistoryAfterMonths() {
    return $this->_purgeHistoryAfterMonths;
  }
  function getPurgeHistoryAfterMonthsError() {
    return $this->_purgeHistoryAfterMonthsError;
  }
  function isBlockCheckoutsWhenFinesDue() {
    return $this->_isBlockCheckoutsWhenFinesDue;
  }
  function getHoldMaxDays() {
    return $this->_holdMaxDays;
  }
  function getLocale() {
    return $this->_locale;
  }
  function getCharset() {
    return $this->_charset;
  }
  function getHtmlLangAttr() {
    return $this->_htmlLangAttr;
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setLibraryName($value) {
    $this->_libraryName = trim($value);
  }
  function setLibraryImageUrl($value) {
    $this->_libraryImageUrl = trim($value);
  }
  function setUseImageFlg($value) {
    if ($value) {
      $this->_isUseImageSet = true;
    } else {
      $this->_isUseImageSet = false;
    }
  }
  function setLibraryHours($value) {
    $this->_libraryHours = trim($value);
  }
  function setLibraryPhone($value) {
    $this->_libraryPhone = trim($value);
  }
  function setLibraryUrl($value) {
    $this->_libraryUrl = trim($value);
  }
  function setOpacUrl($value) {
    $this->_opacUrl = trim($value);
  }
  function setSessionTimeout($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_sessionTimeout = 0;
    } else {
      $this->_sessionTimeout = $temp;
    }
  }
  function setSessionTimeoutError($value) {
    $this->_sessionTimeoutError = trim($value);
  }
  function setItemsPerPage($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_itemsPerPage = 0;
    } else {
      $this->_itemsPerPage = $temp;
    }
  }
  function setItemsPerPageError($value) {
    $this->_itemsPerPageError = trim($value);
  }
  function setVersion($value) {
    $this->_version = trim($value);
  }
  function setThemeid($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_themeid = 0;
    } else {
      $this->_themeid = $temp;
    }
  }
  function setPurgeHistoryAfterMonths($value) {
    $this->_purgeHistoryAfterMonths = trim($value);
  }
  function setBlockCheckoutsWhenFinesDue($value) {
    if ($value) {
      $this->_isBlockCheckoutsWhenFinesDue = TRUE;
    } else {
      $this->_isBlockCheckoutsWhenFinesDue = FALSE;
    }
  }
  function setHoldMaxDays($value) {
    $this->_holdMaxDays = trim($value);
  }
  function setLocale($value) {
    $this->_locale = trim($value);
  }
  function setCharset($value) {
    $this->_charset = trim($value);
  }
  function setHtmlLangAttr($value) {
    $this->_htmlLangAttr = trim($value);
  }

}

?>
