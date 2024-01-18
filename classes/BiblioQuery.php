<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/Biblio.php");
require_once("../classes/BiblioField.php");
require_once("../classes/Localize.php");

/******************************************************************************
 * BiblioQuery data access component for library bibliographies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioQuery extends Query
{
    var $_itemsPerPage = 1;
    var $_rowNmbr = 0;
    var $_currentRowNmbr = 0;
    var $_currentPageNmbr = 0;
    var $_rowCount = 0;
    var $_pageCount = 0;
    var $_loc;
    var $_fieldsInBiblio;

    //Changes PVD(8.0.x)
    function __construct()
    {
        //Changes PVD(8.0.x)
        new Query();
        $this->_loc = new Localize(OBIB_LOCALE, "classes");
        $this->_fieldsInBiblio = array(
            '100a' => 'author',
            '245a' => 'title',
            '245b' => 'title_remainder',
            //Changes PVD(8.0.x)
            '245c' => 'responsibility_stmt',
            '650a' => 'topic1',
            '650a1' => 'topic2',
            '650a2' => 'topic3',
            '650a3' => 'topic4',
            '650a4' => 'topic5',
        );
    }

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
     * @param string $bibid bibid of bibliography to select
     * @return Biblio a bibliography object or false if error occurs
     * @access public
     ****************************************************************************
     */
    /*###########################
      # WORKS WITH NEW FORMAT   #
      ###########################*/
    function doQuery($bibid, $tab = "cataloging")
    {
        # reset rowNmbr
        $this->_rowNmbr = 0;
        $this->_currentRowNmbr = 1;
        $this->_rowCount = 1;
        $this->_pageCount = 1;
        $exclude = array("363x", "526x", "583x", "754x", "852x", "856x");

        /***********************************************************
         *  Reading biblio data
         ***********************************************************/
        # setting query that will return all the data in biblio
        $sql = $this->mkSQL("select biblio.*, staff.username "
            . "from biblio left join staff "
            . "on biblio.last_change_userid = staff.userid "
            . "where biblio.bibid = %N ", $bibid);
        if (!$this->_query($sql, $this->_loc->getText("biblioQueryQueryErr1"))) {
            return false;
        }

        $array = $this->_conn->fetchRow();
        $bib = new Biblio();
        $bib->setBibid($array["bibid"]);
        $bib->setCreateDt($array["create_dt"]);
        $bib->setLastChangeDt($array["last_change_dt"]);
        $bib->setLastChangeUserid($array["last_change_userid"]);
        if (isset($array["username"])) {
            $bib->setLastChangeUsername($array["username"]);
        }
        $bib->setMaterialCd($array["material_cd"]);
        $bib->setCollectionCd($array["collection_cd"]);
        $bib->setCallNmbr1($array["call_nmbr1"]);
        $bib->setCallNmbr2($array["call_nmbr2"]);
        $bib->setCallNmbr3($array["call_nmbr3"]);
        if ($array["opac_flg"] == "Y") {
            $bib->setOpacFlg(true);
        } else {
            $bib->setOpacFlg(false);
        }

        /***********************************************************
         *  Reading biblio_field data
         ***********************************************************/
        # setting query that will return all the data in biblio
        $sql = $this->mkSQL("select biblio_field.* "
            . "from biblio_field "
            . "where biblio_field.bibid = %N "
            . "order by tag, subfield_cd ", $bibid);
        if (!$this->_query($sql, $this->_loc->getText("biblioQueryQueryErr2"))) {
            return false;
        }

        /***********************************************************
         *  Adding fields from biblio to Biblio object 
         ***********************************************************/
        foreach ($this->_fieldsInBiblio as $key => $name) {
            $tag = substr($key, 0, 3);
            $subfieldCd = substr($key, 3, 1);
            $subfieldIdx = '';
            //Changes PVD(8.0.x) count() Replaced With strlrn()
            if (strlen($key) > 4) {
                $index = substr($key, 4);
            }
            $this->_addField($tag, $subfieldCd, $array[$name], $bib, $subfieldIdx);
        }

        /***********************************************************
         *  Adding fields from biblio_field to Biblio object 
         ***********************************************************/
        # subfieldIdx will be used to construct index
        $subfieldIdx = 0;
        $saveTag = "";
        $saveSubfield = "";
        while ($array = $this->_conn->fetchRow()) {
            $tag = $array["tag"];
            $subfieldCd = $array["subfield_cd"];
            if ($tab == "opac" and in_array($tag . $subfieldCd, $exclude))
                continue;

            # checking for tag and subfield break in order to set the subfield Idx correctly.
            if (($tag == $saveTag) and ($subfieldCd == $saveSubfield)) {
                $subfieldIdx = $subfieldIdx + 1;
            } else {
                $subfieldIdx = 0;
                $saveTag = $tag;
                $saveSubfield = $subfieldCd;
            }

            # setting the index.
            # format is ttts[i] where 
            #    t=tag
            #    s=subfield code
            #    i=subfield index if > 0
            # examples: 020a 650a 650a1 650a2
            $index = sprintf("%03d", $tag) . $subfieldCd;
            if ($subfieldIdx > 0) {
                $index = $index . $subfieldIdx;
            }

            $bibFld = new BiblioField();
            $bibFld->setBibid($array["bibid"]);
            $bibFld->setFieldid($array["fieldid"]);
            $bibFld->setTag($array["tag"]);
            $bibFld->setInd1Cd($array["ind1_cd"]);
            $bibFld->setInd2Cd($array["ind2_cd"]);
            $bibFld->setSubfieldCd($array["subfield_cd"]);
            $bibFld->setFieldData($array["field_data"]);
            $bib->addBiblioField($index, $bibFld);
        }
        return $bib;
    }


    /****************************************************************************
     * Utility function to add a field to a Biblio object
     * @return void
     * @access private
     ****************************************************************************
     */
    /*###########################
      # WORKS WITH NEW FORMAT   #
      ###########################*/
    function _addField($tag, $subfieldCd, $value, &$bib, $seq = "")
    {
        if ($value == "") {
            return;
        }
        $index = sprintf("%03d", $tag) . $subfieldCd;
        if ($seq != "") {
            $index = $index . $seq;
        }
        $bibFld = new BiblioField();
        $bibFld->setTag($tag);
        $bibFld->setSubfieldCd($subfieldCd);
        $bibFld->setFieldData($value);
        $bib->addBiblioField($index, $bibFld);
    }


    /****************************************************************************
     * Returns true if barcode number already exists
     * @param string $barcode Bibliography barcode number
     * @param string $bibid Bibliography id
     * @return boolean returns true if barcode already exists
     * @access private
     ****************************************************************************
     */
    function _dupBarcode($barcode, $bibid = 0)
    {
        $sql = $this->mkSQL(
            "select count(*) from biblio "
            . "where barcode_nmbr = %Q and bibid <> %N ",
            $barcode,
            $bibid
        );
        if (!$this->_query($sql, "Error checking for dup barcode.")) {
            return 0;
        }
        $array = $this->_conn->fetchRow(OBIB_NUM);
        if ($array[0] > 0) {
            return true;
        }
        return false;
    }

    /****************************************************************************
     * Inserts new bibliography info into the biblio and biblio_field tables.
     * @param Biblio $biblio bibliography to insert
     * @return int returns bibid or false, if error occurs
     * @access public
     ****************************************************************************
     */
    /*###########################
      # WORKS WITH NEW FORMAT   #
      ###########################*/
    function insert($biblio)
    {
        // inserting biblio row
        $biblioFlds = $biblio->getBiblioFields();

        $bibfields = array(); // fields in biblio table
        foreach ($this->_fieldsInBiblio as $key => $name) {
            if (array_key_exists($key, $biblioFlds) and $biblioFlds[$key]->getFieldid() == '') {
                $bibfields[$name] = $biblioFlds[$key]->getFieldData();
                unset($biblioFlds[$key]);
            } else {
                $bibfields[$name] = '';
            }
        }

        $sql = $this->mkSQL(
            "insert into biblio values(null, sysdate(), sysdate(), "
            . "%N, %N, %N, %Q, %Q, %Q, %Q, %Q, %Q, %Q, %Q, "
            . "%Q, %Q, %Q, %Q, %Q) ",
            $biblio->getLastChangeUserid(),
            $biblio->getMaterialCd(),
            $biblio->getCollectionCd(),
            $biblio->getCallNmbr1(),
            $biblio->getCallNmbr2(),
            $biblio->getCallNmbr3(),
            $bibfields['title'],
            $bibfields['title_remainder'],
            $bibfields['responsibility_stmt'],
            $bibfields['author'],
            $bibfields['topic1'],
            $bibfields['topic2'],
            $bibfields['topic3'],
            $bibfields['topic4'],
            $bibfields['topic5'],
            $biblio->showInOpac() ? "Y" : "N"
        );
        if (!$this->_query($sql, $this->_loc->getText("biblioQueryInsertErr1"))) {
            return false;
        }
        $bibid = $this->_conn->getInsertId();

        # inserting biblio_field rows
        if (!($this->_insertFields($biblioFlds, $bibid))) {
            return false;
        }

        return $bibid;
    }

    /****************************************************************************
     * Updates a bibliography in the biblio table.
     * @param Biblio $biblio bibliography to update
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    /*###########################
      # WORKS WITH NEW FORMAT   #
      ###########################*/
    function update($biblio)
    {
        $biblioFlds = $biblio->getBiblioFields();

        // updating biblio table
        $sql = $this->mkSQL(
            "update biblio set last_change_dt = sysdate(), "
            . " last_change_userid=%N, material_cd=%N, "
            . " collection_cd=%N, "
            . " call_nmbr1=%Q, call_nmbr2=%Q, call_nmbr3=%Q, ",
            $biblio->getLastChangeUserid(),
            $biblio->getMaterialCd(),
            $biblio->getCollectionCd(),
            $biblio->getCallNmbr1(),
            $biblio->getCallNmbr2(),
            $biblio->getCallNmbr3()
        );
        foreach ($this->_fieldsInBiblio as $key => $name) {
            if (array_key_exists($key, $biblioFlds) and $biblioFlds[$key]->getFieldid() == '') {
                $sql .= $this->mkSQL("%I=%Q, ", $name, $biblioFlds[$key]->getFieldData());
                unset($biblioFlds[$key]);
            } else {
                $sql .= $this->mkSQL("%I='', ", $name);
            }
        }
        $sql .= $this->mkSQL(
            "opac_flg=%Q where bibid=%N ",
            $biblio->showInOpac() ? "Y" : "N",
            $biblio->getBibid()
        );

        if (!$this->_query($sql, $this->_loc->getText("biblioQueryUpdateErr1"))) {
            return false;
        }

        // inserting (or updating) biblio_field rows from update Biblio object.
        if (!($this->_insertFields($biblioFlds, $biblio->getBibid()))) {
            return false;
        }

        return true;
    }


    /****************************************************************************
     * Inserts biblio_field rows
     * @param array reference $biblioFlds an array of BiblioField objects
     * @param int bibid id of bibliography to insert fields into
     * @return boolean returns false if error occurs
     * @access private
     ****************************************************************************
     */
    function _insertFields(&$biblioFlds, $bibid)
    {
        foreach ($biblioFlds as $key => $value) {
            if ($value->getFieldData() == "") {
                // value has been set to spaces, we may need to delete it
                if ($value->getFieldid() == "") {
                    $sql = NULL;
                } else {
                    $sql = $this->mkSQL(
                        "delete from biblio_field "
                        . "where bibid=%N and fieldid=%N ",
                        $value->getBibid(),
                        $value->getFieldid()
                    );
                }
            } elseif ($value->getFieldid() == "") {
                // new value
                $sql = $this->mkSQL(
                    "insert into biblio_field "
                    . "values (%N, null, %Q, 'N','N', %Q, %Q) ",
                    $bibid,
                    $value->getTag(),
                    $value->getSubfieldCd(),
                    $value->getFieldData()
                );
            } else {
                // existing value
                $sql = $this->mkSQL(
                    "update biblio_field set field_data = %Q "
                    . "where bibid=%N and fieldid=%N ",
                    $value->getFieldData(),
                    $value->getBibid(),
                    $value->getFieldid()
                );
            }

            if ($sql != NULL) {
                if (!$this->_query($sql, $this->_loc->getText("biblioQueryInsertErr2"))) {
                    return FALSE;
                }
            }
        }
        return true;
    }

    /****************************************************************************
     * Deletes a bibliography from the biblio table.
     * @param string $bibid bibliography id of bibliography to delete
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function delete($bibid)
    {
        $sql = $this->mkSQL("delete from biblio_field where bibid = %N ", $bibid);
        if (!$this->_query($sql, $this->_loc->getText("biblioQueryDeleteErr"))) {
            return false;
        }
        $sql = $this->mkSQL("delete from biblio where bibid = %N ", $bibid);
        return $this->_query($sql, $this->_loc->getText("biblioQueryDeleteErr"));
    }

}

?>