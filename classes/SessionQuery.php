<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../classes/Query.php");

/******************************************************************************
 * SessionQuery data access component for signon sessions
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class SessionQuery extends Query {
  /****************************************************************************
   * Executes a query to validate the token
   * @param string $userid userid of staff member to validate
   * @param string $token signon token of staff member to validate
   * @return boolean returns true if token is valid, false if token is not.
   * @access public
   ****************************************************************************
   */
  function validToken($userid, $token) {
    $sql = $this->mkSQL("select last_updated_dt, token from session "
                        . "where userid = %N and token = %N"
                        . " and last_updated_dt >= date_sub(sysdate(), interval %N minute)",
                        $userid, $token, OBIB_SESSION_TIMEOUT);
    if (!$this->_query($sql, "Error accessing session information.")) {
      return false;
    }
    $rowCount = $this->_conn->numRows();
    if ($rowCount > 0) {
      $this->_updateToken($token);
      return true;
    } else {
      return false;
    }
  }
  /****************************************************************************
   * Inserts or updates the session table and returns a new valid signon token
   * @param string $userid userid of staff member to validate
   * @return string returns token or false, if error occurs
   * @access public
   ****************************************************************************
   */
  function getToken($userid) {
    /**************************************************************************
     * Only purpose of the delete is to clean up old session rows so that the
     * session table doesn't get too full.
     **************************************************************************/
    $sql = $this->mkSQL("delete from session where userid = %N"
                        . " and last_updated_dt < date_sub(sysdate(), interval %N minute)",
                        $userid, OBIB_SESSION_TIMEOUT);
    if (!$this->_query($sql, "Error deleting session information.")) {
      return false;
    }
    srand((double) microtime() * 1000000);
    $token = rand(-10000,10000);
    $sql = $this->mkSQL("insert into session "
                        . "values (%N, sysdate(), %N) ",
                        $userid, $token);
    if (!$this->_query($sql, "Error creating a new session.")) {
      return false;
    }
    return $token;
  }
  /****************************************************************************
   * Updates last updated date in session table so that the session will not
   * time out.
   * @param string $token token of session to update
   * @return boolean returns true if successful, false if error occurs.
   * @access private
   ****************************************************************************
   */
  function _updateToken($token) {
    $sql = $this->mkSQL("update session set last_updated_dt=sysdate() "
                        . "where token = %Q ", $token);
    return $this->_query($sql, "Error updating session timeout.");
  }
}

?>
