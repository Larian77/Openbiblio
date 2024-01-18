<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");

/******************************************************************************
 * BiblioQuery data access component for library bibliographies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class VersionQuery extends Query {

  /****************************************************************************
   * Executes a query
   * @param string $mbrid mbrid of member to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect() {
    # setting query that will return all the data
    $sql = "select * from version";
    return $this->_query($sql, "Error accessing version information.");
  }

  /****************************************************************************
   * Returns the version
   * @return string the version number
   * @access public
   ****************************************************************************
   */
  function fetchVersion() {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }
    return $array["version_txt"];
  }

}

?>
