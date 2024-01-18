<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

use MongoDB\BSON\Decimal128;

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/MemberAccountTransaction.php");

/******************************************************************************
 * MemberAccountQuery data access component for member account transactions
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class MemberAccountQuery extends Query
{
  var $_rowCount = 0;
  var $_loc;

  //Changes PVD(8.0.x)
  function __construct()
  {
    //Changes PVD(8.0.x)
    new Query;
    $this->_loc = new Localize(OBIB_LOCALE, "classes");
  }

  function getRowCount()
  {
    return $this->_rowCount;
  }

  /****************************************************************************
   * Executes a query to select account information
   * @param string $mbrid mbrid of member
   * @return BiblioHold returns hold record or false, if error occurs
   * @access public
   ****************************************************************************
   */
  function doQuery($mbrid)
  {
    # setting query that will return all the data
    $sql = $this->mkSQL("select member_account.*, "
      . " transaction_type_dm.description transaction_type_desc "
      . "from member_account, transaction_type_dm "
      . "where member_account.transaction_type_cd = transaction_type_dm.code "
      . " and member_account.mbrid = %N "
      . "order by create_dt ", $mbrid);

    if (!$this->_query($sql, $this->_loc->getText("memberAccountQueryErr1"))) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return true;
  }

  /****************************************************************************
   * Executes a query to select account information
   * @param string $mbrid mbrid of member
   * @return Decimal128 returns balance due
   * @access public
   ****************************************************************************
   */
  function getBalance($mbrid)
  {
    # setting query that will return all the data
    $sql = $this->mkSQL("select sum(member_account.amount) balance "
      . "from member_account "
      . "where member_account.mbrid = %N ", $mbrid);

    $row = $this->select1($sql);
    return $row["balance"];
  }

  /****************************************************************************
   * Fetches a row from the query result and populates the BiblioStatusHist object.
   * @return BiblioStatusHist returns bibliography status history object or false if no more holds to fetch
   * @access public
   ****************************************************************************
   */
  function fetchRow()
  {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }

    $trans = new MemberAccountTransaction();
    $trans->setMbrid($array["mbrid"]);
    $trans->setTransid($array["transid"]);
    $trans->setCreateDt($array["create_dt"]);
    $trans->setCreateUserid($array["create_userid"]);
    $trans->setTransactionTypeCd($array["transaction_type_cd"]);
    $trans->setTransactionTypeDesc($array["transaction_type_desc"]);
    $trans->setAmount($array["amount"]);
    $trans->setDescription($array["description"]);
    return $trans;
  }

  /****************************************************************************
   * Inserts a new account transaction into the member_account table.
   * @param MemberAccountTransaction $trans account transaction to insert
   * @access public
   ****************************************************************************
   */
  function insert($trans)
  {
    // change trans type payment and credit amount to negative
    $transTypeSign = substr($trans->getTransactionTypeCd(), 0, 1);
    if ($transTypeSign == "-") {
      $amt = $trans->getAmount() * -1;
    } else {
      $amt = $trans->getAmount();
    }
    $sql = $this->mkSQL(
      "insert into member_account "
      . "values (%N, null, sysdate(), %N, %Q, %N, %Q) ",
      $trans->getMbrid(),
      $trans->getCreateUserid(),
      $trans->getTransactionTypeCd(),
      $amt,
      $trans->getDescription()
    );
    return $this->_query($sql, $this->_loc->getText("memberAccountQueryErr2"));
  }

  /****************************************************************************
   * Deletes history from the biblio_status_hist table.
   * @param string $mbrid member id of history to delete
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function delete($mbrid, $tranid = "")
  {
    $sql = $this->mkSQL("delete from member_account where mbrid = %N ", $mbrid);
    if ($tranid != "") {
      $sql .= $this->mkSQL(" and transid = %N ", $tranid);
    }
    return $this->_query($sql, $this->_loc->getText("memberAccountQueryErr3"));
  }


}
?>
