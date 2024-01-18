<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/******************************************************************************
 * Theme represents a library look and feel theme.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Theme {
  var $_themeid = 0;
  var $_themeName = "";
  var $_themeNameError = "";
  var $_titleBg = "";
  var $_titleBgError = "";
  var $_titleFontFace = "";
  var $_titleFontFaceError = "";
  var $_titleFontSize = 1;
  var $_titleFontSizeError = "";
  var $_titleFontBold = false;
  var $_titleFontColor = "";
  var $_titleFontColorError = "";
  var $_titleAlign = "";
  var $_primaryBg = "";
  var $_primaryBgError = "";
  var $_primaryFontFace = "";
  var $_primaryFontFaceError = "";
  var $_primaryFontSize = 1;
  var $_primaryFontSizeError = "";
  var $_primaryFontColor = "";
  var $_primaryFontColorError = "";
  var $_primaryLinkColor = "";
  var $_primaryLinkColorError = "";
  var $_primaryErrorColor = "";
  var $_primaryErrorColorError = "";
  var $_alt1Bg = "";
  var $_alt1BgError = "";
  var $_alt1FontFace = "";
  var $_alt1FontFaceError = "";
  var $_alt1FontSize = 1;
  var $_alt1FontSizeError = "";
  var $_alt1FontColor = "";
  var $_alt1FontColorError = "";
  var $_alt1LinkColor = "";
  var $_alt1LinkColorError = "";
  var $_alt2Bg = "";
  var $_alt2BgError = "";
  var $_alt2FontFace = "";
  var $_alt2FontFaceError = "";
  var $_alt2FontSize = 1;
  var $_alt2FontSizeError = "";
  var $_alt2FontColor = "";
  var $_alt2FontColorError = "";
  var $_alt2LinkColor = "";
  var $_alt2LinkColorError = "";
  var $_alt2FontBold = false;
  var $_borderColor = "";
  var $_borderColorError = "";
  var $_borderWidth = 1;
  var $_borderWidthError = "";
  var $_tablePadding = 1;
  var $_tablePaddingError = "";

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;

    # required field edits
    if ($this->_themeName == "") {
      $valid = false;
      $this->_themeNameError = "Theme name is required.";
    }
    if ($this->_titleBg == "") {
      $valid = false;
      $this->_titleBgError = "Title background color is required.";
    }
    if ($this->_titleFontFace == "") {
      $valid = false;
      $this->_titleFontFaceError = "Title font face is required.";
    }
    if ($this->_titleFontColor == "") {
      $valid = false;
      $this->_titleFontColorError = "Title font color is required.";
    }
    if ($this->_primaryBg == "") {
      $valid = false;
      $this->_primaryBgError = "Main body background color is required.";
    }
    if ($this->_primaryFontFace == "") {
      $valid = false;
      $this->_primaryFontFaceError = "Main body font face is required.";
    }
    if ($this->_primaryFontColor == "") {
      $valid = false;
      $this->_primaryFontColorError = "Main body font color is required.";
    }
    if ($this->_primaryLinkColor == "") {
      $valid = false;
      $this->_primaryLinkColorError = "Main body link color is required.";
    }
    if ($this->_primaryErrorColor == "") {
      $valid = false;
      $this->_primaryErrorColorError = "Main body error color is required.";
    }
    if ($this->_alt1Bg == "") {
      $valid = false;
      $this->_alt1BgError = "Navigation background color is required.";
    }
    if ($this->_alt1FontFace == "") {
      $valid = false;
      $this->_alt1FontFaceError = "Navigation font face is required.";
    }
    if ($this->_alt1FontColor == "") {
      $valid = false;
      $this->_alt1FontColorError = "Navigation font color is required.";
    }
    if ($this->_alt1LinkColor == "") {
      $valid = false;
      $this->_alt1LinkColorError = "Navigation link color is required.";
    }
    if ($this->_alt2Bg == "") {
      $valid = false;
      $this->_alt2BgError = "Tab background color is required.";
    }
    if ($this->_alt2FontFace == "") {
      $valid = false;
      $this->_alt2FontFaceError = "Tab font face is required.";
    }
    if ($this->_alt2FontColor == "") {
      $valid = false;
      $this->_alt2FontColorError = "Tab font color is required.";
    }
    if ($this->_alt2LinkColor == "") {
      $valid = false;
      $this->_alt2LinkColorError = "Tab link color is required.";
    }
    if ($this->_borderColor == "") {
      $valid = false;
      $this->_borderColorError = "Border color is required.";
    }

    # numeric checks
    if (!is_numeric($this->_titleFontSize)) {
      $valid = false;
      $this->_titleFontSizeError = "Title font size must be numeric.";
    } elseif (strrpos($this->_titleFontSize,".")) {
      $valid = false;
      $this->_titleFontSizeError = "Title font size must not contain a decimal point.";
    } elseif ($this->_titleFontSize <= 0) {
      $valid = false;
      $this->_titleFontSizeError = "Title font size must be greater than zero.";
    }

    if (!is_numeric($this->_primaryFontSize)) {
      $valid = false;
      $this->_primaryFontSizeError = "Main body font size must be numeric.";
    } elseif (strrpos($this->_primaryFontSize,".")) {
      $valid = false;
      $this->_primaryFontSizeError = "Main body font size must not contain a decimal point.";
    } elseif ($this->_primaryFontSize <= 0) {
      $valid = false;
      $this->_primaryFontSizeError = "Main body font size must be greater than zero.";
    }

    if (!is_numeric($this->_alt1FontSize)) {
      $valid = false;
      $this->_alt1FontSizeError = "Navigation font size must be numeric.";
    } elseif (strrpos($this->_alt1FontSize,".")) {
      $valid = false;
      $this->_alt1FontSizeError = "Navigation font size must not contain a decimal point.";
    } elseif ($this->_alt1FontSize <= 0) {
      $valid = false;
      $this->_alt1FontSizeError = "Navigation font size must be greater than zero.";
    }

    if (!is_numeric($this->_alt2FontSize)) {
      $valid = false;
      $this->_alt2FontSizeError = "Tab font size must be numeric.";
    } elseif (strrpos($this->_alt2FontSize,".")) {
      $valid = false;
      $this->_alt2FontSizeError = "Tab font size must not contain a decimal point.";
    } elseif ($this->_alt2FontSize <= 0) {
      $valid = false;
      $this->_alt2FontSizeError = "Tab font size must be greater than zero.";
    }

    if (!is_numeric($this->_borderWidth)) {
      $valid = false;
      $this->_borderWidthError = "Border width must be numeric.";
    } elseif (strrpos($this->_borderWidth,".")) {
      $valid = false;
      $this->_borderWidthError = "Border width must not contain a decimal point.";
    } elseif ($this->_borderWidth <= 0) {
      $valid = false;
      $this->_borderWidthError = "Border width must be greater than zero.";
    }

    if (!is_numeric($this->_tablePadding)) {
      $valid = false;
      $this->_tablePaddingError = "Table padding must be numeric.";
    } elseif (strrpos($this->_tablePadding,".")) {
      $valid = false;
      $this->_tablePaddingError = "Table padding must not contain a decimal point.";
    } elseif ($this->_tablePadding <= 0) {
      $valid = false;
      $this->_tablePaddingError = "Table padding must be greater than zero.";
    }

    return $valid;
  }

  /****************************************************************************
   * getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getThemeid() {
    return $this->_themeid;
  }
  function getThemeName() {
    return $this->_themeName;
  }
  function getTitleBg() {
    return $this->_titleBg;
  }
  function getTitleFontFace() {
    return $this->_titleFontFace;
  }
  function getTitleFontSize() {
    return $this->_titleFontSize;
  }
  function getTitleFontBold() {
    return $this->_titleFontBold;
  }
  function getTitleFontColor() {
    return $this->_titleFontColor;
  }
  function getTitleAlign() {
    return $this->_titleAlign;
  }
  function getPrimaryBg() {
    return $this->_primaryBg;
  }
  function getPrimaryFontFace() {
    return $this->_primaryFontFace;
  }
  function getPrimaryFontSize() {
    return $this->_primaryFontSize;
  }
  function getPrimaryFontColor() {
    return $this->_primaryFontColor;
  }
  function getPrimaryLinkColor() {
    return $this->_primaryLinkColor;
  }
  function getPrimaryErrorColor() {
    return $this->_primaryErrorColor;
  }
  function getAlt1Bg() {
    return $this->_alt1Bg;
  }
  function getAlt1FontFace() {
    return $this->_alt1FontFace;
  }
  function getAlt1FontSize() {
    return $this->_alt1FontSize;
  }
  function getAlt1FontColor() {
    return $this->_alt1FontColor;
  }
  function getAlt1LinkColor() {
    return $this->_alt1LinkColor;
  }
  function getAlt2Bg() {
    return $this->_alt2Bg;
  }
  function getAlt2FontFace() {
    return $this->_alt2FontFace;
  }
  function getAlt2FontSize() {
    return $this->_alt2FontSize;
  }
  function getAlt2FontColor() {
    return $this->_alt2FontColor;
  }
  function getAlt2LinkColor() {
    return $this->_alt2LinkColor;
  }
  function getAlt2FontBold() {
    return $this->_alt2FontBold;
  }
  function getBorderColor() {
    return $this->_borderColor;
  }
  function getBorderWidth() {
    return $this->_borderWidth;
  }
  function getTablePadding() {
    return $this->_tablePadding;
  }
  function getThemeNameError() {
    return $this->_themeNameError;
  }
  function getTitleBgError() {
    return $this->_titleBgError;
  }
  function getTitleFontFaceError() {
    return $this->_titleFontFaceError;
  }
  function getTitleFontSizeError() {
    return $this->_titleFontSizeError;
  }
  function getTitleFontColorError() {
    return $this->_titleFontColorError;
  }
  function getPrimaryBgError() {
    return $this->_primaryBgError;
  }
  function getPrimaryFontFaceError() {
    return $this->_primaryFontFaceError;
  }
  function getPrimaryFontSizeError() {
    return $this->_primaryFontSizeError;
  }
  function getPrimaryFontColorError() {
    return $this->_primaryFontColorError;
  }
  function getPrimaryLinkColorError() {
    return $this->_primaryLinkColorError;
  }
  function getPrimaryErrorColorError() {
    return $this->_primaryErrorColorError;
  }
  function getAlt1BgError() {
    return $this->_alt1BgError;
  }
  function getAlt1FontFaceError() {
    return $this->_alt1FontFaceError;
  }
  function getAlt1FontSizeError() {
    return $this->_alt1FontSizeError;
  }
  function getAlt1FontColorError() {
    return $this->_alt1FontColorError;
  }
  function getAlt1LinkColorError() {
    return $this->_alt1LinkColorError;
  }
  function getAlt2BgError() {
    return $this->_alt2BgError;
  }
  function getAlt2FontFaceError() {
    return $this->_alt2FontFaceError;
  }
  function getAlt2FontSizeError() {
    return $this->_alt2FontSizeError;
  }
  function getAlt2FontColorError() {
    return $this->_alt2FontColorError;
  }
  function getAlt2LinkColorError() {
    return $this->_alt2LinkColorError;
  }
  function getBorderColorError() {
    return $this->_borderColorError;
  }
  function getBorderWidthError() {
    return $this->_borderWidthError;
  }
  function getTablePaddingError() {
    return $this->_tablePaddingError;
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setThemeid($value) {
    $this->_themeid = trim($value);
  }
  function setThemeName($value) {
    $this->_themeName = trim($value);
  }
  function setTitleBg($value) {
    $this->_titleBg = trim($value);
  }
  function setTitleFontFace($value) {
    $this->_titleFontFace = trim($value);
  }
  function setTitleFontSize($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_titleFontSize = 0;
    } else {
      $this->_titleFontSize = $temp;
    }
  }
  function setTitleFontBold($value) {
    if ($value) {
      $this->_titleFontBold = true;
    } else {
      $this->_titleFontBold = false;
    }
  }
  function setTitleFontColor($value) {
    $this->_titleFontColor = trim($value);
  }
  function setTitleAlign($value) {
    $this->_titleAlign = trim($value);
  }
  function setPrimaryBg($value) {
    $this->_primaryBg = trim($value);
  }
  function setPrimaryFontFace($value) {
    $this->_primaryFontFace = trim($value);
  }
  function setPrimaryFontSize($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_primaryFontSize = 0;
    } else {
      $this->_primaryFontSize = $temp;
    }
  }
  function setPrimaryFontColor($value) {
    $this->_primaryFontColor = trim($value);
  }
  function setPrimaryLinkColor($value) {
    $this->_primaryLinkColor = trim($value);
  }
  function setPrimaryErrorColor($value) {
    $this->_primaryErrorColor = trim($value);
  }
  function setAlt1Bg($value) {
    $this->_alt1Bg = trim($value);
  }
  function setAlt1FontFace($value) {
    $this->_alt1FontFace = trim($value);
  }
  function setAlt1FontSize($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_alt1FontSize = 0;
    } else {
      $this->_alt1FontSize = $temp;
    }
  }
  function setAlt1FontColor($value) {
    $this->_alt1FontColor = trim($value);
  }
  function setAlt1LinkColor($value) {
    $this->_alt1LinkColor = trim($value);
  }
  function setAlt2Bg($value) {
    $this->_alt2Bg = trim($value);
  }
  function setAlt2FontFace($value) {
    $this->_alt2FontFace = trim($value);
  }
  function setAlt2FontSize($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_alt2FontSize = 0;
    } else {
      $this->_alt2FontSize = $temp;
    }
  }
  function setAlt2FontColor($value) {
    $this->_alt2FontColor = trim($value);
  }
  function setAlt2LinkColor($value) {
    $this->_alt2LinkColor = trim($value);
  }
  function setAlt2FontBold($value) {
    if ($value) {
      $this->_alt2FontBold = true;
    } else {
      $this->_alt2FontBold = false;
    }
  }
  function setBorderColor($value) {
    $this->_borderColor = trim($value);
  }
  function setBorderWidth($value) {
    $this->_borderWidth = trim($value);
  }
  function setTablePadding($value) {
    $this->_tablePadding = trim($value);
  }

}

?>
