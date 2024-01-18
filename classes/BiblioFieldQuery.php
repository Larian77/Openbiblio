<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/BiblioField.php");
require_once("../classes/Localize.php");

/******************************************************************************
 * BiblioFieldQuery data access component for library bibliography fields
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioFieldQuery extends Query
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
     * Executes a query to select ONLY ONE SUBFIELD
     * @param string $bibid bibid of bibliography copy to select
     * @param string $fieldid copyid of bibliography copy to select
     * @return BiblioField returns subfield or false, if error occurs
     * @access public
     ****************************************************************************
     */
    function doQuery($bibid, $fieldid)
    {
        # setting query that will return all the data in biblio
        $sql = $this->mkSQL("select biblio_field.* from biblio_field "
            . "where biblio_field.bibid = %N "
            . "and biblio_field.fieldid = %N ", $bibid, $fieldid);

        if (!$this->_query($sql, $this->_loc->getText("biblioFieldQueryErr1"))) {
            return false;
        }
        $this->_rowCount = $this->_conn->numRows();
        return $this->fetchField();
    }

    /****************************************************************************
     * Executes a query
     * @param string $bibid bibid of bibliography fields to select
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function execSelect($bibid)
    {
        # setting query that will return all the data in biblio
        $sql = $this->mkSQL(
            "select biblio_field.* "
            . "from biblio_field "
            . "where biblio_field.bibid = %N "
            . "order by tag, subfield_cd ",
            $bibid
        );
        if (!$this->_query($sql, $this->_loc->getText("biblioFieldQueryErr2"))) {
            return false;
        }
        $this->_rowCount = $this->_conn->numRows();
        return;
    }

    /****************************************************************************
     * Fetches a row from the query result and populates the Theme object.
     * @return Theme returns theme or false if no more themes to fetch
     * @access public
     ****************************************************************************
     */
    function fetchField()
    {
        $array = $this->_conn->fetchRow();
        if ($array == false) {
            return false;
        }
        $fld = new BiblioField();
        $fld->setBibid($array["bibid"]);
        $fld->setFieldid($array["fieldid"]);
        $fld->setTag($array["tag"]);
        $fld->setInd1Cd($array["ind1_cd"]);
        $fld->setInd2Cd($array["ind2_cd"]);
        $fld->setSubfieldCd($array["subfield_cd"]);
        $fld->setFieldData($array["field_data"]);

        return $fld;
    }

    /****************************************************************************
     * Inserts new bibliography field into the biblio_field table.
     * @param BiblioField $field bibliography field to insert
     * @return boolean returns true if insert was successful or false, if error occurs
     * @access public
     ****************************************************************************
     */
    function insert($field)
    {
        # inserting biblio field row
        $sql = $this->mkSQL(
            "insert into biblio_field values "
            . "(%N, null, %N, %Q, %Q, %Q, %Q) ",
            $field->getBibid(),
            $field->getTag(),
            $field->getInd1Cd(),
            $field->getInd2Cd(),
            $field->getSubfieldCd(),
            $field->getFieldData()
        );

        if (!$this->_query($sql, $this->_loc->getText("biblioFieldQueryInsertErr"))) {
            return false;
        }
        return true;
    }


    /****************************************************************************
     * Updates a bibliography field in the biblio_field table.
     * @param BiblioField $field bibliography field to insert
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function update($field)
    {
        # updating biblio table
        $sql = $this->mkSQL(
            "update biblio_field set tag=%N, "
            . "ind1_cd=%Q, ind2_cd=%Q, subfield_cd=%Q, field_data=%Q "
            . "where bibid=%N and fieldid=%N",
            $field->getTag(),
            $field->getInd1Cd(),
            $field->getInd2Cd(),
            $field->getSubfieldCd(),
            $field->getFieldData(),
            $field->getBibid(),
            $field->getFieldid()
        );
        return $this->_query($sql, $this->_loc->getText("biblioFieldQueryUpdateErr"));
    }

    /****************************************************************************
     * Deletes a bibliography field from the biblio_field table.
     * @param string $bibid bibliography id of bibliography field to delete
     * @param string $fieldid field id of bibliography field to delete
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function delete($bibid, $fieldid)
    {
        $sql = $this->mkSQL(
            "delete from biblio_field "
            . "where bibid=%N and fieldid=%N ",
            $bibid,
            $fieldid
        );

        return $this->_query($sql, $this->_loc->getText("biblioFieldQueryDeleteErr"));
    }

}

?>