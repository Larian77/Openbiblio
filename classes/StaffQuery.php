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
class StaffQuery extends Query {
  /****************************************************************************
   * Executes a query
   * @param string $userid (optional) userid of staff member to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect($userid="") {
    $sql = "select * from staff";
    if ($userid != "") {
      $sql .= $this->mkSQL(" where userid=%N ", $userid);
    }
    $sql .= " order by last_name, first_name";
    return $this->_query($sql, "Error accessing staff member information.");
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
    $sql = $this->mkSQL("select * from staff "
                        . "where username = lower(%Q) "
                        . " and pwd = md5(lower(%Q)) ",
                        $username, $pwd);
    return $this->_query($sql, "Error verifying username and password.");
  }

  /****************************************************************************
   * Updates a staff member and sets the suspended flag to yes.
   * @param string $username username of staff member to suspend
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function suspendStaff($username)
  {
    $sql = $this->mkSQL("update staff set suspended_flg='Y' "
                        . "where username = lower(%Q)", $username);
    return $this->_query($sql, "Error suspending staff member.");
  }

  /****************************************************************************
   * Fetches a row from the query result and populates the Staff object.
   * @return Staff returns staff member or false if no more staff members to fetch
   * @access public
   ****************************************************************************
   */
  function fetchStaff() {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }
    $staff = new Staff();
    $staff->setUserid($array["userid"]);
    $staff->setLastName($array["last_name"]);
    $staff->setFirstName($array["first_name"]);
    $staff->setUsername($array["username"]);
    if ($array["circ_flg"] == "Y") {
      $staff->setCircAuth(true);
    } else {
      $staff->setCircAuth(false);
    }
    if ($array["circ_mbr_flg"] == "Y") {
      $staff->setCircMbrAuth(TRUE);
    } else {
      $staff->setCircMbrAuth(FALSE);
    }
    if ($array["catalog_flg"] == "Y") {
      $staff->setCatalogAuth(true);
    } else {
      $staff->setCatalogAuth(false);
    }
    if ($array["admin_flg"] == "Y") {
      $staff->setAdminAuth(true);
    } else {
      $staff->setAdminAuth(false);
    }
    if ($array["reports_flg"] == "Y") {
      $staff->setReportsAuth(TRUE);
    } else {
      $staff->setReportsAuth(FALSE);
    }
    if ($array["suspended_flg"] == "Y") {
      $staff->setSuspended(true);
    } else {
      $staff->setSuspended(false);
    }
    return $staff;
  }

  /****************************************************************************
   * Returns true if username already exists
   * @param string $username staff member username
   * @param string $userid staff member userid
   * @return boolean returns true if username already exists
   * @access private
   ****************************************************************************
   */
  function _dupUserName($username, $userid=0) {
    $sql = $this->mkSQL("select count(*) from staff where username = %Q "
                        . " and userid <> %N", $username, $userid);
    if (!$this->_query($sql, "Error checking for dup username.")) {
      return false;
    }
    $array = $this->_conn->fetchRow(OBIB_NUM);
    if ($array[0] > 0) {
      return true;
    }
    return false;
  }

  /****************************************************************************
   * Inserts a new staff member into the staff table.
   * @param Staff $staff staff member to insert
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function insert($staff) {
    $dupUsername = $this->_dupUserName($staff->getUsername());
    if ($this->errorOccurred()) return false;
    if ($dupUsername) {
      $this->_errorOccurred = true;
      $this->_error = "Username is already in use.";
      return false;
    }
    $sql = $this->mkSQL("insert into staff values (null, sysdate(), sysdate(), "
                        . "%N, %Q, md5(lower(%Q)), %Q, ",
                        $staff->getLastChangeUserid(), $staff->getUsername(),
                        $staff->getPwd(), $staff->getLastName());
    if ($staff->getFirstName() == "") {
      $sql .= "null, ";
    } else {
      $sql .= $this->mkSQL("%Q, ", $staff->getFirstName());
    }
    $sql .= $this->mkSQL("'N', %Q, %Q, %Q, %Q, %Q) ",
                         $staff->hasAdminAuth() ? "Y" : "N",
                         $staff->hasCircAuth() ? "Y" : "N",
                         $staff->hasCircMbrAuth() ? "Y" : "N",
                         $staff->hasCatalogAuth() ? "Y" : "N",
                         $staff->hasReportsAuth() ? "Y" : "N");
    return $this->_query($sql, "Error inserting new staff member information.");
  }

  /****************************************************************************
   * Update a staff member in the staff table.
   * @param Staff $staff staff member to update
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function update($staff) {
    /**************************************************************
     * If changing username check to see if it already exists. 
     **************************************************************/
    $dupUsername = $this->_dupUserName($staff->getUsername(), $staff->getUserid());
    if ($this->errorOccurred()) return false;
    if ($dupUsername) {
      $this->_errorOccurred = true;
      $this->_error = "Username is already in use.";
      return false;
    }

    $sql = $this->mkSQL("update staff set last_change_dt = sysdate(), "
                        . "last_change_userid=%N, username=%Q, last_name=%Q, ",
                        $staff->getLastChangeUserid(), $staff->getUsername(),
                        $staff->getLastName());
    if ($staff->getFirstName() == "") {
      $sql .= "first_name=null, ";
    } else {
      $sql .= $this->mkSQL("first_name=%Q, ", $staff->getFirstName());
    }
    $sql .= $this->mkSQL("suspended_flg=%Q, admin_flg=%Q, circ_flg=%Q, "
                         . "circ_mbr_flg=%Q, catalog_flg=%Q, reports_flg=%Q "
                         . "where userid=%N ",
                         $staff->isSuspended() ? "Y" : "N",
                         $staff->hasAdminAuth() ? "Y" : "N",
                         $staff->hasCircAuth() ? "Y" : "N",
                         $staff->hasCircMbrAuth() ? "Y" : "N",
                         $staff->hasCatalogAuth() ? "Y" : "N",
                         $staff->hasReportsAuth() ? "Y" : "N",
                         $staff->getUserid());
    return $this->_query($sql, "Error updating staff member information.");
  }

  /****************************************************************************
   * Resets a staff member password in the staff table.
   * @param Staff $staff staff member to update
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function resetPwd($staff) {
    $sql = $this->mkSQL("update staff set pwd=md5(lower(%Q)) "
                        . "where userid=%N ",
                        $staff->getPwd(), $staff->getUserid());
    return $this->_query($sql, "Error resetting password.");
  }

  /****************************************************************************
   * Deletes a staff member from the staff table.
   * @param string $userid userid of staff member to delete
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function delete($userid) {
    $sql = $this->mkSQL("delete from staff where userid = %N ", $userid);
    return $this->_query($sql, "Error deleting staff information.");
  }

}

?>
