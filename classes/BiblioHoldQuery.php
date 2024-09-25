<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/BiblioHold.php");

/******************************************************************************
 * BiblioHoldQuery data access component for holds on library bibliography copies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioHoldQuery extends Query
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
     * Executes a query to select holds
     * @param string $bibid bibid of bibliography copy to select
     * @return boolean returns false if error occurs
     * @access public
     ****************************************************************************
     */
    function queryByBibid($bibid)
    {
        # setting query that will return all the data
        $sql = $this->mkSQL(
            "select biblio_hold.*, "
            . " member.last_name, member.first_name, "
            . " biblio_copy.barcode_nmbr, biblio_copy.status_cd, "
            . " biblio_copy.due_back_dt "
            . "from biblio_hold, biblio_copy, member "
            . "where biblio_hold.bibid = biblio_copy.bibid "
            . " and biblio_hold.copyid = biblio_copy.copyid "
            . " and biblio_hold.mbrid = member.mbrid "
            . " and biblio_hold.bibid = %N "
            . "order by barcode_nmbr, hold_begin_dt ",
            $bibid
        );

        if (!$this->_query($sql, $this->_loc->getText("biblioHoldQueryErr1"))) {
            return false;
        }
        $this->_rowCount = $this->_conn->numRows();
        return true;
    }

    /****************************************************************************
     * Executes a query to select holds
     * @param string $mbrid mbrid of member placing holds
     * @return boolean returns false if error occurs
     * @access public
     ****************************************************************************
     */
    function queryByMbrid($mbrid)
    {
        # setting query that will return all the data
        $sql = $this->mkSQL(
            "select biblio_hold.*, "
            . "biblio.title, biblio.author, "
            . "biblio.material_cd, biblio_copy.barcode_nmbr, "
            . "biblio_copy.status_cd, biblio_copy.due_back_dt "
            . "from biblio_hold, biblio_copy, biblio "
            . "where biblio_hold.bibid = biblio_copy.bibid "
            . "and biblio_hold.copyid = biblio_copy.copyid "
            . "and biblio_hold.bibid = biblio.bibid "
            . "and biblio_hold.mbrid = %N "
            . "order by biblio_hold.hold_begin_dt desc",
            $mbrid
        );

        if (!$this->_query($sql, $this->_loc->getText("biblioHoldQueryErr2"))) {
            return false;
        }
        $this->_rowCount = $this->_conn->numRows();
        return true;
    }

    /****************************************************************************
     * Fetches a row from the query result and populates the BiblioHold object.
     * @return BiblioHold returns hold on bibliography copy or false if no more holds to fetch
     * @access public
     ****************************************************************************
     */
    function fetchRow()
    {
        $array = $this->_conn->fetchRow();
        if ($array == false) {
            return false;
        }

        $hold = new BiblioHold();
        $hold->setBibid($array["bibid"]);
        $hold->setCopyid($array["copyid"]);
        $hold->setHoldid($array["holdid"]);
        $hold->setHoldBeginDt($array["hold_begin_dt"]);
        $hold->setMbrid($array["mbrid"]);
        $hold->setBarcodeNmbr($array["barcode_nmbr"]);
        $hold->setStatusCd($array["status_cd"]);
        $hold->setDueBackDt($array["due_back_dt"]);
        if (isset($array["title"])) {
            $hold->setTitle($array["title"]);
        }
        if (isset($array["author"])) {
            $hold->setAuthor($array["author"]);
        }
        if (isset($array["material_cd"])) {
            $hold->setMaterialCd($array["material_cd"]);
        }
        if (isset($array["last_name"])) {
            $hold->setLastName($array["last_name"]);
        }
        if (isset($array["first_name"])) {
            $hold->setFirstName($array["first_name"]);
        }
        return $hold;
    }

    /****************************************************************************
     * Inserts a new bibliography copy hold into the biblio_hold table.
     * @param BiblioHold $hold hold to insert
     * @return int 0 - error
     *             1 - success
     *             2 - invalid barcode
     * @access public
     ****************************************************************************
     */
    function insert($mbrid, $barcode)
    {
        // getting bibid and copyid for a given barcode
        $sql = $this->mkSQL("select bibid, copyid from biblio_copy "
            . "where barcode_nmbr = %Q", $barcode);
        if (!$this->_query($sql, $this->_loc->getText("biblioHoldQueryErr3"))) {
            return 0;
        }
        if ($this->_conn->numRows() == 0) {
            return 2;
        }
        $array = $this->_conn->fetchRow();
        $bibid = $array["bibid"];
        $copyid = $array["copyid"];

        $sql = $this->mkSQL(
            "insert into biblio_hold values "
            . "(%N, %N, null, sysdate(), %N)",
            $bibid,
            $copyid,
            $mbrid
        );
        if (!$this->_query($sql, $this->_loc->getText("biblioHoldQueryErr4"))) {
            return 0;
        }
        return 1;
    }

    /****************************************************************************
     * Deletes a copy from the biblio_copy table.
     * @param string $bibid bibliography id of copy to delete
     * @param string $copyid optional copy id of copy to delete.  If none
     *               supplied then all copies under a given bibid will be deleted.
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function delete($bibid, $copyid, $holdid)
    {
        $sql = $this->mkSQL(
            "delete from biblio_hold where bibid = %N "
            . "and copyid = %N and holdid = %N",
            $bibid,
            $copyid,
            $holdid
        );
        return $this->_query($sql, $this->_loc->getText("biblioHoldQueryErr5"));
    }

    /****************************************************************************
     * Retrieves first entry in hold queue
     * @param string $bibid of bibliography on hold
     * @param string $copyid of bibliography on hold
     * @return BiblioHold first hold in queue or false if error occurs
     * @access public
     ****************************************************************************
     */
    function maybeGetFirstHold($bibid, $copyid)
    {
        $sql = $this->mkSQL(
            "select * from biblio_hold "
            . "where bibid = %N and copyid = %N "
            . "order by hold_begin_dt limit 1",
            $bibid,
            $copyid
        );
        $row = $this->select01($sql);
        if (!$row)
            return NULL;
        $hold = new BiblioHold();
        $hold->setBibid($row["bibid"]);
        $hold->setCopyid($row["copyid"]);
        $hold->setHoldid($row["holdid"]);
        $hold->setHoldBeginDt($row["hold_begin_dt"]);
        $hold->setMbrid($row["mbrid"]);
        return $hold;
    }

}
?>
