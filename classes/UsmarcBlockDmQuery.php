<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/Localize.php");

/******************************************************************************
 * UsmarcBlockDmQuery data access component for usmarc_block_dm table
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class UsmarcBlockDmQuery extends Query {
  var $_loc;

  //Changes PVD(8.0.x)
  function __construct() {
    //Changes PVD(8.0.x)
    $this->connect_e();
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  /****************************************************************************
   * Executes a query
   * @param string $table table name of domain table to query
   * @param int $code (optional) code of row to fetch
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect() {
    $sql = "select * from usmarc_block_dm order by block_nmbr ";
    return $this->_query($sql, $this->_loc->getText("usmarcBlockDmQueryErr1"));
  }

  /****************************************************************************
   * Fetches a row from the query result and populates the Dm object.
   * @return Dm returns domain object or false if no more domain rows to fetch
   * @access public
   ****************************************************************************
   */
  function fetchRow() {
    $result = $this->_conn->fetchRow();
    if ($result == false) {
      return false;
    }
    $dm = new UsmarcBlockDm();
    $dm->setBlockNmbr($result["block_nmbr"]);
    $dm->setDescription($result["description"]);
    return $dm;
  }

  /****************************************************************************
   * Fetches all rows from the query result.
   * @return $marcBlocks returns associative array indexed by block nmbr containing UsmarcBlockDm objects.
   * @access public
   ****************************************************************************
   */
  function fetchRows() {
    while ($result = $this->_conn->fetchRow()) {
      $dm = new UsmarcBlockDm();
      $dm->setBlockNmbr($result["block_nmbr"]);
      $dm->setDescription($result["description"]);
      $assoc[$result["block_nmbr"]] = $dm;
    }
    return $assoc;
  }

}

?>
