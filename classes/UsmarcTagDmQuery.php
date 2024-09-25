<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/Localize.php");

/******************************************************************************
 * UsmarcTagDmQuery data access component for usmarc_tag_dm table
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class UsmarcTagDmQuery extends Query
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
    function execSelect($blockNmbr = "")
    {
        $sql = "select * from usmarc_tag_dm ";
        if ($blockNmbr != "") {
            $sql .= $this->mkSQL("where block_nmbr = %N ", $blockNmbr);
        }
        $sql .= "order by tag ";
        return $this->_query($sql, $this->_loc->getText("usmarcTagDmQueryErr1"));
    }

    /****************************************************************************
     * Formats a tag object from the selected row result
     * @param int $result fetched row
     * @return UsmarcTagDm returns UsMarcTagDm object
     * @access private
     ****************************************************************************
     */
    function _formatTag($result)
    {
        $dm = new UsmarcTagDm();
        $dm->setBlockNmbr($result["block_nmbr"]);
        $dm->setTag($result["tag"]);
        $dm->setDescription($result["description"]);
        $dm->setInd1Description($result["ind1_description"]);
        $dm->setInd2Description($result["ind2_description"]);
        $dm->setRepeatableFlg($result["repeatable_flg"]);
        return $dm;
    }

    /****************************************************************************
     * Executes a query
     * @param int $tag tag of row to fetch
     * @return UsmarcTagDm returns UsMarcTagDm object or false if error occurs
     * @access public
     ****************************************************************************
     */
    function doQuery($tag)
    {
        $sql = $this->mkSQL("select * from usmarc_tag_dm where tag=%N ", $tag);
        if (!$this->_query($sql, $this->_loc->getText("usmarcTagDmQueryErr1"))) {
            return false;
        }
        $result = $this->_conn->fetchRow();
        if ($result == false) {
            return false;
        }
        $dm = $this->_formatTag($result);
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
        $dm = $this->_formatTag($result);
        return $dm;
    }

    /****************************************************************************
     * Fetches all rows from the query result.
     * @return $marcTags returns associative array indexed by tag containing UsmarcTagDm objects.
     * @access public
     ****************************************************************************
     */
    function fetchRows()
    {
        $tagsFound = false;
        while ($result = $this->_conn->fetchRow()) {
            $tagsFound = true;
            $dm = new UsmarcTagDm();
            $dm->setBlockNmbr($result["block_nmbr"]);
            $dm->setTag($result["tag"]);
            $dm->setDescription($result["description"]);
            $dm->setInd1Description($result["ind1_description"]);
            $dm->setInd2Description($result["ind2_description"]);
            $dm->setRepeatableFlg($result["repeatable_flg"]);
            $assoc[$result["tag"]] = $dm;
        }
        if ($tagsFound) {
            return $assoc;
        } else {
            return false;
        }
    }

}

?>