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
  
  /****************************************************************************
   * Executes a query to verify a signon username
   * Variable $pwd (Password) was deleted because cannot be verified with password_hash
   * @param string $mbrid to select from member_fields
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function verifySignon($mbrid) {
    $sql = $this->mkSQL("select pwd from member "
                        . "where mbrid = %N ",
                        $mbrid);
    return $this->_query($sql, "Error verifying username.");
  }

}

?>
