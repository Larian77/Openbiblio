<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");

/******************************************************************************
 * StaffQuery data access component for library staff members
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class MemberLoginQuery extends Query {

  function checkSecret() {
        $sql = "select * from member_fields_dm";
        $sql .= " where code = 'secret'";
        return $this->_query($sql, "No Memberfield 'secret' defined. Member-Login is deactivated!");
  }

  function fetchRow() {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
   } else {
   return true;
   }
   }

  /****************************************************************************
   * Executes a query to verify a signon username and password
   * @param string $username username of staff member to select
   * @param string $pwd password of staff member to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function verifySignon($username, $pwd) {
    $sql = $this->mkSQL("select * from member_fields "
                        . "where mbrid = %N "
                        . " and code = 'secret' "
                        . " and data = %Q ",
                        $username, $pwd);
    return $this->_query($sql, "Error verifying username and password.");
  }

}

?>
