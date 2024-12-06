<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Member.php");
require_once("../classes/Query.php");

/******************************************************************************
 * MemberQuery data access component for library members
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class MemberQuery extends Query
{
    var $_itemsPerPage = 1;
    var $_rowNmbr = 0;
    var $_currentRowNmbr = 0;
    var $_currentPageNmbr = 0;
    var $_rowCount = 0;
    var $_pageCount = 0;

    function setItemsPerPage($value)
    {
        $this->_itemsPerPage = $value;
    }
    function getCurrentRowNmbr()
    {
        return $this->_currentRowNmbr;
    }
    function getRowCount()
    {
        return $this->_rowCount;
    }
    function getPageCount()
    {
        return $this->_pageCount;
    }

    /****************************************************************************
     * Executes a query
     * @param string $type one of the global constants
     *               OBIB_SEARCH_BARCODE or OBIB_SEARCH_NAME
     * @param string $word String to search for
     * @param integer $page What page should be returned if results are more than one page
     * @access public
     ****************************************************************************
     */
    function execSearch($type, $word, $page, $login)
    {
        # reset stats
        $this->_rowNmbr = 0;
        $this->_currentRowNmbr = 0;
        $this->_currentPageNmbr = $page;
        $this->_rowCount = 0;
        $this->_pageCount = 0;

        # Building sql statements
        if ($type == OBIB_SEARCH_BARCODE) {
            $col = "barcode_nmbr";
        } elseif ($type == OBIB_SEARCH_NAME) {    
            $col = "last_name";
        }

        # Building sql statements
        if ($login == TRUE) {
            $sql = $this->mkSQL("from member where %C = %Q ", $col, $word);
        } else {
            $sql = $this->mkSQL("from member where %C like %Q ", $col, $word . "%"); 
        }
        $sqlcount = "select count(*) as rowcount " . $sql;
        $sql = "select * " . $sql;

        $sql .= " order by last_name, first_name";
        # setting limit so we can page through the results
        $offset = ($page - 1) * $this->_itemsPerPage;
        $limit = $this->_itemsPerPage;
        $sql .= $this->mkSQL(" limit %N, %N ", $offset, $limit);
        #echo "sql=[".$sql."]<br>\n";

        # Running row count sql statement
        $rows = $this->exec($sqlcount);
        if (count($rows) != 1) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError("Wrong number of count rows");
        }
        # Calculate stats based on row count
        $this->_rowCount = $rows[0]["rowcount"];
        $this->_pageCount = ceil($this->_rowCount / $this->_itemsPerPage);

        # Running search sql statement
        $this->_exec($sql);
    }

    /****************************************************************************
     * Executes a query
     * @param string $mbrid Member id of library member to select
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function get($mbrid)
    {
        $sql = $this->mkSQL("select member.*, staff.username from member "
            . "left join staff on member.last_change_userid = staff.userid "
            . "where mbrid=%N ", $mbrid);
        $rows = $this->exec($sql);
        if (count($rows) != 1) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError("Bad mbrid");
        }
        return $this->_mkObj($rows[0]);
    }

    function maybeGetByBarcode($bcode)
    {
        $sql = $this->mkSQL("select member.*, staff.username from member "
            . "left join staff on member.last_change_userid = staff.userid "
            . "where barcode_nmbr=%Q ", $bcode);
        $row = $this->select01($sql);
        if ($row)
            return $this->_mkObj($row);
        return NULL;
    }

    /****************************************************************************
     * Fetches a row from the query result and populates the Member object.
     * @return Member returns library member or false if no more members to fetch
     * @access public
     ****************************************************************************
     */
    function fetchMember()
    {
        $array = $this->_conn->fetchRow();
        if ($array == false) {
            return false;
        }
        # increment rowNmbr
        $this->_rowNmbr = $this->_rowNmbr + 1;
        $this->_currentRowNmbr = $this->_rowNmbr + (($this->_currentPageNmbr - 1) * $this->_itemsPerPage);
        return $this->_mkObj($array);
    }
    function _mkObj($array)
    {
        $mbr = new Member();
        $mbr->setMbrid($array["mbrid"]);
        $mbr->setBarcodeNmbr($array["barcode_nmbr"]);
        $mbr->setLastChangeDt($array["last_change_dt"]);
        $mbr->setLastChangeUserid($array["last_change_userid"]);
        if (isset($array["username"])) {
            $mbr->setLastChangeUsername($array["username"]);
        }
        $mbr->setLastName($array["last_name"]);
        $mbr->setFirstName($array["first_name"]);
        $mbr->setPwd($array["pwd"]);
        $mbr->setPwdTimeOut($array["pwd_timeout"]);
        $mbr->setPwdForgotten($array["pwd_forgotten"]);
        $mbr->setPwdForgottenTime($array["pwd_forgotten_time"]);
        $mbr->setAddress($array["address"]);
        $mbr->setHomePhone($array["home_phone"]);
        $mbr->setWorkPhone($array["work_phone"]);
        $mbr->setEmail($array["email"]);
        $mbr->setClassification($array["classification"]);
        $mbr->setMembershipEnd($array["mbrshipend"] ?? '');

        $mbr->_custom = $this->getCustomFields($array['mbrid']);
        return $mbr;
    }

    function getCustomFields($mbrid)
    {
        # KLUDGE to make sure we don't clobber the results handle
        # when we're called from fetchmember().
        # FIXME - redo query stuff to avoid this issue
        $q = new Query();
        //Changes PVD(8.0.x)
        $q->connect_e();
        $sql = $q->mkSQL('select * from member_fields where mbrid=%N', $mbrid);
        $rows = $q->exec($sql);
        $fields = array();
        foreach ($rows as $r) {
            $fields[$r['code']] = $r['data'];
        }
        return $fields;
    }   
    function setCustomFields($mbrid, $fields) {
      foreach ($fields as $code => $data) {
          // Depending on whether values already exist in the database: update or insert
          $queryMbrFields = $this->mkSQL('SELECT `data` FROM `member_fields` WHERE `mbrid` = %N AND `code` = %Q', $mbrid, $code);
          $db_data= $this->select01($queryMbrFields);
          if ($db_data == NULL) {
              $sql = $this->mkSQL('insert into member_fields (mbrid, code, data) '
                             . 'values (%N, %Q, %Q)', $mbrid, $code, $data);
          } else {
              $sql = $this->mkSQL("update member_fields SET data = %Q "
                             . "where mbrid=%N AND code=%Q", $data, $mbrid, $code);
          }
          $this->exec($sql);
      }
    }

    /****************************************************************************
     * Returns true if barcode number already exists
     * @param string $barcode Library member barcode number
     * @param string $mbrid Library member id
     * @return boolean returns true if barcode already exists
     * @access private
     ****************************************************************************
     */
    function DupBarcode($barcode, $mbrid = 0)
    {
        $sql = $this->mkSQL(
            "select count(*) as num from member "
            . "where barcode_nmbr = %Q and mbrid <> %N",
            $barcode,
            $mbrid
        );
        $rows = $this->exec($sql);
        if (count($rows) != 1) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Bad number of rows');
        }
        if ($rows[0]['num'] > 0) {
            return true;
        }
        return false;
    }

    /****************************************************************************
     * Inserts a new library member into the member table.
     * @param Member $mbr library member to insert
     * @return integer the id number of the newly inserted member
     * @access public
     ****************************************************************************
     */
    function insert($mbr)
    {
        $pwdhash = password_hash($mbr->getPwd(), PASSWORD_DEFAULT);
        $sql = $this->mkSQL(
            "insert into member "
            . "(mbrid, barcode_nmbr, create_dt, last_change_dt, "
            . "last_change_userid, last_name, first_name, pwd, pwd_timeout, "
            . "pwd_forgotten, pwd_forgotten_time, address, home_phone, "
            . "work_phone, email, classification, mbrshipend) "
            . "values (null, %Q, sysdate(), sysdate(), "
            . "%N, %Q, %Q, %Q, %Q, "
            . "%Q, %Q, %Q, %Q, "
            . "%Q, %Q, %Q, %Q) ",
            $mbr->getBarcodeNmbr(),
            $mbr->getLastChangeUserid(),
            $mbr->getLastName(),
            $mbr->getFirstName(),
            $pwdhash,
            $mbr->getPwdTimeOut(),
            $mbr->getPwdForgotten(),
            $mbr->getPwdForgotteTime(),
            $mbr->getAddress(),
            $mbr->getHomePhone(),
            $mbr->getWorkPhone(),
            $mbr->getEmail(),
            $mbr->getClassification(),
            $mbr->getMembershipEnd()
        );

        $this->exec($sql);
        $mbrid = $this->_conn->getInsertId();
        $this->setCustomFields($mbrid, $mbr->_custom);
        return $mbrid;
    }

    /****************************************************************************
     * Update a library member in the member table.
     * @param Member $mbr library member to update
     * @access public
     ****************************************************************************
     */
    function update($mbr)
    {
        $sql = $this->mkSQL(
            "update member set "
            . " last_change_dt = sysdate(), last_change_userid=%N, "
            . " barcode_nmbr=%Q, last_name=%Q, first_name=%Q, "
            . " address=%Q, home_phone=%Q, work_phone=%Q, "
            . " email=%Q, classification=%Q, mbrshipend=%Q "
            . "where mbrid=%N",
            $mbr->getLastChangeUserid(),
            $mbr->getBarcodeNmbr(),
            $mbr->getLastName(),
            $mbr->getFirstName(),
            $mbr->getAddress(),
            $mbr->getHomePhone(),
            $mbr->getWorkPhone(),
            $mbr->getEmail(),
            $mbr->getClassification(),
            $mbr->getMembershipEnd(),
            $mbr->getMbrid()
        );

    $query = $this->exec($sql);
    $this->setCustomFields($mbr->getMbrid(), $mbr->_custom);
    return $query;
    }

    /****************************************************************************
     * Deletes a library member from the member table.
     * @param string $mbrid Member id of library member to delete
     * @access public
     ****************************************************************************
     */
    function delete($mbrid)
    {
        $sql = $this->mkSQL("delete from member where mbrid = %N ", $mbrid);
        $this->exec($sql);
        $sql = $this->mkSQL("delete from member_fields where mbrid = %N ", $mbrid);
        $this->exec($sql);
    }
    function deleteCustomField($code)
    {
        $sql = $this->mkSQL("delete from member_fields where code = %Q ", $code);
        $this->exec($sql);
    }
  
  /****************************************************************************
   * Resets a member password in the member_fields table.
   * @param Member $mbr member to update
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function resetPwd($mbr) {
    $pwdhash = password_hash($mbr->getPwd(), PASSWORD_DEFAULT);

        $sql = $this->mkSQL("update `member` set `pwd`=%Q "
                        . "where mbrid = %N ",
                        $pwdhash, $mbr->getMbrid());
  
    return $this->_query($sql, "Error resetting password.");
}

  /****************************************************************************
   * Updates a member and sets the timeout.
   * @param string $mbrid mbrid of member to suspend for some minutes
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function LoginTimeoutMember($username)
  {
    $sql = $this->mkSQL("update member set pwd_timeout = sysdate() "
                        . "where barcode_nmbr = lower(%Q)", $username);
    return $this->_query($sql, "Error suspending member.");
  }

  /****************************************************************************
   * Count members with this email
   * @param string $email email of member
   * @return Reports the number of members with the same email back
   * @access public
   ****************************************************************************
   */
  function getRow($email)
  {
    $sql = $this->mkSQL("select * from member where email=%Q ", $email);
    $memberInfos = $this->exec($sql);
    $rows = count($memberInfos);

    return $rows;
  }
  function getMember_or($db_column, $value)
  {
    $sql = $this->mkSQL("SELECT * FROM member WHERE %q = %Q ", $db_column, $value);
    $rows = $this->exec($sql);
    if (count($rows) == 0) {
        //Changes PVD(8.0.x)
        return false;
    }
    return $this->_mkObj($rows[0]);
  }
  function getMember_and($db_column_mail, $db_column_bc_nmbr, $mail, $bcNmbr)
  {
    $sql = $this->mkSQL("SELECT * FROM member WHERE %q = %Q AND %q = %Q ", 
            $db_column_mail, $mail,
            $db_column_bc_nmbr, $bcNmbr);
    $rows = $this->exec($sql);
    if (count($rows) == 0) {
        //Changes PVD(8.0.x)
        return false;
    }
    return $this->_mkObj($rows[0]);
  }
  function setPwdForgottenCode($mbr)
  {
          $sql = $this->mkSQL("UPDATE member SET pwd_forgotten = %Q, pwd_forgotten_time = sysdate() "
                            . " WHERE mbrid = %N "
                            , $mbr->getPwdForgotten()
                            , $mbr->getMbrid());
        return $this->_query($sql, "Error set Password-Forgotten-Code by member.");;
  }
  function getPwdForgottenCode($mbrid)
  {
      $sql = $this->mkSQL("SELECT pwd_forgotten, pwd_forgotten_time FROM member WHERE mbrid = $mbrid");
      $result = $this->exec($sql);
      if (!isset($result[0])) {
        return false;
      }
      return $result[0];
  }
}

?>
