<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");

/******************************************************************************
 * ThemeQuery data access component for library themes
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class ThemeQuery extends Query {
  /****************************************************************************
   * Executes a query
   * @param string $themeid themeid of theme to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect($themeid="") {
    if ($themeid == "") {
      $sql = "select * from theme order by theme_name";
    } else {
      $sql = $this->mkSQL("select * from theme where themeid=%N "
                          . "order by theme_name ", $themeid);
    }
    return $this->_query($sql, "Error accessing theme information.");
  }

  /****************************************************************************
   * Fetches a row from the query result and populates the Theme object.
   * @return Theme returns theme or false if no more themes to fetch
   * @access public
   ****************************************************************************
   */
  function fetchTheme() {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }
    $theme = new Theme();
    $theme->setThemeid($array["themeid"]);
    $theme->setThemeName($array["theme_name"]);
    $theme->setTitleBg($array["title_bg"]);
    $theme->setTitleFontFace($array["title_font_face"]);
    $theme->setTitleFontSize($array["title_font_size"]);
    if ($array["title_font_bold"] == "Y") {
      $theme->setTitleFontBold(true);
    } else {
      $theme->setTitleFontBold(false);
    }
    $theme->setTitleFontColor($array["title_font_color"]);
    $theme->setTitleAlign($array["title_align"]);
    $theme->setPrimaryBg($array["primary_bg"]);
    $theme->setPrimaryFontFace($array["primary_font_face"]);
    $theme->setPrimaryFontSize($array["primary_font_size"]);
    $theme->setPrimaryFontColor($array["primary_font_color"]);
    $theme->setPrimaryLinkColor($array["primary_link_color"]);
    $theme->setPrimaryErrorColor($array["primary_error_color"]);
    $theme->setAlt1Bg($array["alt1_bg"]);
    $theme->setAlt1FontFace($array["alt1_font_face"]);
    $theme->setAlt1FontSize($array["alt1_font_size"]);
    $theme->setAlt1FontColor($array["alt1_font_color"]);
    $theme->setAlt1LinkColor($array["alt1_link_color"]);
    $theme->setAlt2Bg($array["alt2_bg"]);
    $theme->setAlt2FontFace($array["alt2_font_face"]);
    $theme->setAlt2FontSize($array["alt2_font_size"]);
    $theme->setAlt2FontColor($array["alt2_font_color"]);
    $theme->setAlt2LinkColor($array["alt2_link_color"]);
    if ($array["alt2_font_bold"] == "Y") {
      $theme->setAlt2FontBold(true);
    } else {
      $theme->setAlt2FontBold(false);
    }
    $theme->setBorderColor($array["border_color"]);
    $theme->setBorderWidth($array["border_width"]);
    $theme->setTablePadding($array["table_padding"]);

    return $theme;
  }

  /****************************************************************************
   * Inserts a new theme into the theme table.
   * @param Theme $theme theme to insert
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function insert($theme) {
    $sql = $this->mkSQL("insert into theme "
                        . "values (null, %Q, %Q, %Q, %N, %Q, %Q, %Q, %Q, %Q, "
                        . " %N, %Q, %Q, %Q, %Q, %Q, %N, %Q, %Q, %Q, %Q, %N, "
                        . " %Q, %Q, %Q, %Q, %N, %N) ",
                        $theme->getThemeName(), $theme->getTitleBg(),
                        $theme->getTitleFontFace(), $theme->getTitleFontSize(),
                        $theme->getTitleFontBold() ? "Y" : "N",
                        $theme->getTitleFontColor(), $theme->getTitleAlign(),
                        $theme->getPrimaryBg(), $theme->getPrimaryFontFace(),
                        $theme->getPrimaryFontSize(), $theme->getPrimaryFontColor(),
                        $theme->getPrimaryLinkColor(),
                        $theme->getPrimaryErrorColor(), $theme->getAlt1Bg(),
                        $theme->getAlt1FontFace(), $theme->getAlt1FontSize(),
                        $theme->getAlt1FontColor(), $theme->getAlt1LinkColor(),
                        $theme->getAlt2Bg(), $theme->getAlt2FontFace(),
                        $theme->getAlt2FontSize(), $theme->getAlt2FontColor(),
                        $theme->getAlt2LinkColor(),
                        $theme->getAlt2FontBold() ? "Y" : "N",
                        $theme->getBorderColor(), $theme->getBorderWidth(),
                        $theme->getTablePadding());

    return $this->_query($sql, "Error inserting new library look and feel theme.");
  }

  /****************************************************************************
   * Update a theme in the theme table.
   * @param Theme $theme theme to insert
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function update($theme) {
    $sql = $this->mkSQL("update theme set theme_name=%Q, "
                        . " title_bg=%Q, title_font_face=%Q, "
                        . " title_font_size=%N, title_font_bold=%Q, "
                        . " title_font_color=%Q, title_align=%Q, "
                        . " primary_bg=%Q, primary_font_face=%Q, "
                        . " primary_font_size=%N, primary_font_color=%Q, "
                        . " primary_link_color=%Q, primary_error_color=%Q, "
                        . " alt1_bg=%Q, alt1_font_face=%Q, "
                        . " alt1_font_size=%N, alt1_font_color=%Q, "
                        . " alt1_link_color=%Q, alt2_bg=%Q, "
                        . " alt2_font_face=%Q, alt2_font_size=%N, "
                        . " alt2_font_color=%Q, alt2_link_color=%Q, "
                        . " alt2_font_bold=%Q, border_color=%Q, "
                        . " border_width=%Q, table_padding=%Q "
                        . "where themeid = %N",
                        $theme->getThemeName(), $theme->getTitleBg(),
                        $theme->getTitleFontFace(), $theme->getTitleFontSize(),
                        $theme->getTitleFontBold() ? "Y" : "N",
                        $theme->getTitleFontColor(), $theme->getTitleAlign(),
                        $theme->getPrimaryBg(), $theme->getPrimaryFontFace(),
                        $theme->getPrimaryFontSize(),
                        $theme->getPrimaryFontColor(),
                        $theme->getPrimaryLinkColor(),
                        $theme->getPrimaryErrorColor(), $theme->getAlt1Bg(),
                        $theme->getAlt1FontFace(), $theme->getAlt1FontSize(),
                        $theme->getAlt1FontColor(), $theme->getAlt1LinkColor(),
                        $theme->getAlt2Bg(), $theme->getAlt2FontFace(),
                        $theme->getAlt2FontSize(), $theme->getAlt2FontColor(),
                        $theme->getAlt2LinkColor(),
                        $theme->getAlt2FontBold() ? "Y" : "N",
                        $theme->getBorderColor(), $theme->getBorderWidth(),
                        $theme->getTablePadding(), $theme->getThemeid());
    return $this->_query($sql, "Error updating library look and feel theme.");
  }

  /****************************************************************************
   * Deletes a theme from the theme table.
   * @param string $themeid themeid of theme to delete
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function delete($themeid) {
    $sql = $this->mkSQL("delete from theme where themeid=%N ", $themeid);
    return $this->_query($sql, "Error deleting library look and feel theme.");
  }

}

?>
