<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/BiblioStatusHist.php");
require_once("../classes/SettingsQuery.php");

/******************************************************************************
 * BiblioStatusHistQuery data access component for holds on library bibliography copies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioStatusHistQuery extends Query
{
    var $_rowCount = 0;
    var $_loc;

    //Changes PVD(8.0.x)
    function __construct()
    {
        //Changes PVD(8.0.x)
        new Query();
        $this->_loc = new Localize(OBIB_LOCALE, "classes");
    }

    function getRowCount()
    {
        return $this->_rowCount;
    }


    /****************************************************************************
     * Executes a query to select status history
     * @param string $bibid bibid of bibliography status history to select
     * @return boolean returns false if error occurs
     * @access public
     ****************************************************************************
     */
    function queryByBibid($bibid)
    {
        # setting query that will return all the data
        $sql = $this->mkSQL(
            "select biblio_status_hist.*, "
            . " biblio.title, biblio.author, "
            . " biblio_copy.barcode_nmbr biblio_barcode_nmbr, "
            . " member.last_name, member.first_name, "
            . " member.barcode_nmbr mbr_barcode_nmbr "
            . "from biblio_status_hist, biblio, "
            . " biblio_copy, member "
            . "where biblio_status_hist.bibid = biblio.bibid "
            . " and biblio_status_hist.bibid = biblio_copy.bibid "
            . " and biblio_status_hist.copyid = biblio_copy.copyid "
            . " and biblio_status_hist.mbrid = member.mbrid "
            . " and biblio_status_hist.bibid = %N "
            . "order by status_begin_dt desc, biblio_copy.barcode_nmbr ",
            $bibid
        );

        if (!$this->_query($sql, $this->_loc->getText("biblioStatusHistQueryErr1"))) {
            return false;
        }
        $this->_rowCount = $this->_conn->numRows();
        return true;
    }

    /****************************************************************************
     * Executes a query to select status history
     * @param string $mbrid mbrid of member
     * @return boolean returns false if error occurs
     * @access public
     ****************************************************************************
     */
    function queryByMbrid($mbrid)
    {
        # setting query that will return all the data
        $sql = $this->mkSQL(
            "select biblio_status_hist.*, "
            . " biblio.title, biblio.author, "
            . " biblio_copy.barcode_nmbr biblio_barcode_nmbr, "
            . " member.last_name, member.first_name, "
            . " member.barcode_nmbr mbr_barcode_nmbr "
            . "from biblio_status_hist, biblio, "
            . " biblio_copy, member "
            . "where biblio_status_hist.bibid = biblio.bibid "
            . " and biblio_status_hist.bibid = biblio_copy.bibid "
            . " and biblio_status_hist.copyid = biblio_copy.copyid "
            . " and biblio_status_hist.mbrid = member.mbrid "
            . " and biblio_status_hist.mbrid = %N "
            . "order by status_begin_dt desc ",
            $mbrid
        );

        if (!$this->_query($sql, $this->_loc->getText("biblioStatusHistQueryErr2"))) {
            return false;
        }
        $this->_rowCount = $this->_conn->numRows();
        return true;
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

        $hist = new BiblioStatusHist();
        $hist->setBibid($array["bibid"]);
        $hist->setCopyid($array["copyid"]);
        $hist->setBiblioBarcodeNmbr($array["biblio_barcode_nmbr"]);
        $hist->setTitle($array["title"]);
        $hist->setAuthor($array["author"]);
        $hist->setStatusCd($array["status_cd"]);
        $hist->setStatusBeginDt($array["status_begin_dt"]);
        $hist->setMbrid($array["mbrid"]);
        $hist->setLastName($array["last_name"]);
        $hist->setFirstName($array["first_name"]);
        $hist->setMbrBarcodeNmbr($array["mbr_barcode_nmbr"]);
        $hist->setDueBackDt($array["due_back_dt"]);
        $hist->setRenewalCount($array["renewal_count"]);
        return $hist;
    }

    /****************************************************************************
     * Inserts a new bibliography status history into the biblio_status_hist table.
     * @param BiblioStatusHist $hist history to insert
     * @access public
     ****************************************************************************
     */
    function insert($hist)
    {
        $sql = $this->mkSQL(
            "insert into biblio_status_hist values "
            . "(%N, %N, %Q, ",
            $hist->getBibid(),
            $hist->getCopyid(),
            $hist->getStatusCd()
        );
        if ($hist->getStatusBeginDt() != "") {
            $sql .= $this->mkSQL("%Q, ", $hist->getStatusBeginDt());
        } else {
            $sql .= "sysdate(), ";
        }
        if ($hist->getDueBackDt() != "") {
            $sql .= $this->mkSQL("%Q, ", $hist->getDueBackDt());
        } else {
            $sql .= "null, ";
        }
        $sql .= $this->mkSQL("%N, %N)", $hist->getMbrid(), $hist->getRenewalCount());
        if (!$this->_query($sql, $this->_loc->getText("biblioStatusHistQueryErr3"))) {
            return false;
        }
        $this->_purgeHistory($hist->getMbrid());
        return true;
    }

    /****************************************************************************
     * Deletes history from the biblio_status_hist table.
     * @param string $bibid bibliography id of history to delete
     * @param string $copyid copy id of history to delete.
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function deleteByBibid($bibid, $copyid)
    {
        $sql = $this->mkSQL(
            "delete from biblio_status_hist "
            . "where bibid = %N and copyid = %N",
            $bibid,
            $copyid
        );
        return $this->_query($sql, $this->_loc->getText("biblioStatusHistQueryErr4"));
    }

    /****************************************************************************
     * Deletes history from the biblio_status_hist table.
     * @param string $mbrid member id of history to delete
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function deleteByMbrid($mbrid)
    {
        $sql = $this->mkSQL("delete from biblio_status_hist where mbrid = %N", $mbrid);
        return $this->_query($sql, $this->_loc->getText("biblioStatusHistQueryErr5"));
    }

    /****************************************************************************
     * Deletes history from the biblio_status_hist table.
     * @param string $mbrid member id of history to delete
     * @return boolean returns false, if error occurs
     * @access private
     ****************************************************************************
     */
    function _purgeHistory($mbrid)
    {
        $setQ = new SettingsQuery();
        $purgeMo = $setQ->getPurgeHistoryAfterMonths($this);
        if ($purgeMo == 0) {
            return TRUE;
        }
        // do not purge at all when there might be unpaid overdue fees
        $acctQ = new MemberAccountQuery();
        $balance = $acctQ->getBalance($mbrid);
        if ($balance <> 0) {
            return TRUE;
        }
        $sql = $this->mkSQL(
            "delete biblio_status_hist from biblio_status_hist"
            . " left join biblio_copy on biblio_copy.mbrid = biblio_status_hist.mbrid"
            . "  and biblio_copy.bibid = biblio_status_hist.bibid"
            . "  and biblio_copy.copyid = biblio_status_hist.copyid"
            . " where biblio_status_hist.mbrid = %N"
            . " and biblio_status_hist.status_begin_dt <= date_add(sysdate(),interval - %N month)"
            . " and biblio_copy.mbrid is null",
            $mbrid,
            $purgeMo
        );
        // history is not purged for copies that are not returned
        return $this->_query($sql, $this->_loc->getText("biblioStatusHistQueryErr5"));
    }

}
?>