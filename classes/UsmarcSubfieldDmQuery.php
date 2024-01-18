<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/Localize.php");

/******************************************************************************
 * UsmarcSubfieldDmQuery data access component for usmarc_subfield_dm table
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class UsmarcSubfieldDmQuery extends Query
{
    var $_loc;

    //Changes PVD(8.0.x)
    function __construct()
    {
        //Changes PVD(8.0.x)
        new Query();
        $this->_loc = new Localize(OBIB_LOCALE, "classes");
    }

    /****************************************************************************
     * Executes a query
     * @param int $code (optional) code of row to fetch
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function execSelect($tag = "")
    {
        $sql = "select * from usmarc_subfield_dm ";
        if ($tag != "") {
            $sql .= $this->mkSQL("where tag = %N ", $tag);
        }
        $sql .= "order by tag, subfield_cd ";
        return $this->_query($sql, $this->_loc->getText("usmarcSubfldDmQueryErr1"));
    }

    /****************************************************************************
     * Formats a subfield object from the selected row result
     * @param int $result fetched row
     * @return UsmarcSubfieldDm returns UsMarcSubfieldDm object
     * @access private
     ****************************************************************************
     */
    function _formatSubfield($result)
    {
        $dm = new UsmarcSubfieldDm();
        $dm->setTag($result["tag"]);
        $dm->setSubfieldCd($result["subfield_cd"]);
        $dm->setDescription($result["description"]);
        $dm->setRepeatableFlg($result["repeatable_flg"]);
        return $dm;
    }

    /****************************************************************************
     * Executes a query
     * @param int $subfld subfield code of row to fetch
     * @return Dm returns SubfieldDm object or false if error occurs
     * @access public
     ****************************************************************************
     */
    function doQuery($tag, $subfld)
    {
        $sql = $this->mkSQL(
            "select * from usmarc_subfield_dm "
            . "where tag=%N and subfield_cd=%Q ",
            $tag,
            $subfld
        );
        if (!$this->_query($sql, $this->_loc->getText("usmarcSubfldDmQueryErr1"))) {
            return false;
        }
        $result = $this->_conn->fetchRow();
        if ($result == false) {
            return false;
        }
        $dm = $this->_formatSubfield($result);
        return $dm;
    }

    /****************************************************************************
     * Fetches a row from the query result and populates the Dm object.
     * @return Dm returns domain object or false if no more domain rows to fetch
     * @access public
     ****************************************************************************
     */
    function fetchRow()
    {
        $result = $this->_conn->fetchRow();
        if ($result == false) {
            return false;
        }
        $dm = $this->_formatSubfield($result);
        return $dm;
    }

    /****************************************************************************
     * Fetches all rows from the query result.
     * @return $marcSubflds returns associative array indexed by tag containing UsmarcsubfieldDm objects.
     * @access public
     ****************************************************************************
     */
    function fetchRows()
    {
        while ($result = $this->_conn->fetchRow()) {
            $dm = new UsmarcSubfieldDm();
            $dm->setTag($result["tag"]);
            $dm->setSubfieldCd($result["subfield_cd"]);
            $dm->setDescription($result["description"]);
            $dm->setRepeatableFlg($result["repeatable_flg"]);
            $index = sprintf("%03d", $result["tag"]) . $result["subfield_cd"];
            $assoc[$index] = $dm;
        }
        return $assoc;
    }

}

?>