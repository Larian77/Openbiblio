<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once ("../classes/BiblioQuery.php");
require_once("../classes/BiblioSearch.php");
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
class BiblioSearchQuery extends Query
{
    var $_itemsPerPage = 1;
    var $_rowNmbr = 0;
    var $_currentRowNmbr = 0;
    var $_currentPageNmbr = 0;
    var $_rowCount = 0;
    var $_pageCount = 0;
    var $_loc;

    //Changes PVD(8.0.x)
    function __construct()
    {
        //Changes PVD(8.0.x)
        new Query;
        $this->_loc = new Localize(OBIB_LOCALE, "classes");
    }
    function setItemsPerPage($value)
    {
        $this->_itemsPerPage = $value;
    }
    function getLineNmbr()
    {
        return $this->_rowNmbr;
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
     *               OBIB_SEARCH_BARCODE,
     *               OBIB_SEARCH_TITLE,
     *               OBIB_SEARCH_AUTHOR,
     *               or OBIB_SEARCH_SUBJECT
     * @param string @$words pointer to an array containing words to search for
     * @param integer $page What page should be returned if results are more than one page
     * @param string $sortBy column name to sort by.  Can be title or author
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    // function search($type, &$words, $page, $sortBy, $opacFlg=true) {
    function search(
        $type,
        &$words,
        $page,
        $sortBy,
        $collecs = array(),
        $materials = array(),
        $opacFlg = true
    ) {
        # reset stats
        $this->_rowNmbr = 0;
        $this->_currentRowNmbr = 0;
        $this->_currentPageNmbr = $page;
        $this->_rowCount = 0;
        $this->_pageCount = 0;

        # setting sql join clause
        $join = "from biblio left join biblio_copy on biblio.bibid=biblio_copy.bibid ";

        # setting sql where clause
        $bField = false;
        $criteria = "";
        $joins = 0;
        $short = 0;
        $words = array_unique(unserialize(strtolower(serialize($words))));
        if ((sizeof($words) == 0) || ($words[0] == "")) {
            if ($opacFlg)
                $criteria = "where opac_flg = 'Y' ";
        } else {
            if ($type == OBIB_SEARCH_BARCODE) {
                $criteria = $this->_getCriteria($type, array("biblio_copy.barcode_nmbr"), $words);
            } elseif ($type == OBIB_SEARCH_AUTHOR) {
                $drop = 1;
                for ($i = 0; $i < count($words); $i++) {
                    if (strlen($words[$i]) <= $drop)
                        continue;
                    $joins = $joins + 1;
                    $join .= "left join biblio_field as bf" . $i . " on bf" . $i . ".bibid=biblio.bibid ";
                    $join .= "and bf" . $i . ".tag in ('110', '700', '710') ";
                    $join .= "and bf" . $i . ".field_data ";
                    $join .= $this->mkSQL("like %Q ", "%" . $words[$i] . "%");
                    # word boundaries for short words: prevent excessive wildcard matching in WHERE
                    if (strlen($words[$i]) < $drop + 3) {
                        $wordsQ = preg_quote($words[$i]);
                        $join .= "and bf" . $i . ".field_data ";
                        $join .= $this->mkSQL("rlike %Q ", "[[:<:]]" . $wordsQ);
                    }
                    $join .= "and not bf" . $i . ".subfield_cd regexp('[0-9]') ";
                }
                $criteria = $this->_getCriteria($type, array("biblio.author", "biblio.responsibility_stmt"), $words, $bField = true, $drop);
            } elseif ($type == OBIB_SEARCH_SUBJECT) {
                $drop = 1;
                for ($i = 0; $i < count($words); $i++) {
                    if (strlen($words[$i]) <= $drop)
                        continue;
                    if (strlen($words[$i]) <= $drop + 1)
                        $short = $short + 1;
                    $joins = $joins + 1;
                    $join .= "left join biblio_field as bf" . $i . " on bf" . $i . ".bibid=biblio.bibid ";
                    # Tags equal to Locum connector class for III - http://thesocialopac.net/
                    $join .= "and bf" . $i . ".tag in (
            '600', '610', '611', '630', '650', '651',
            '653', '654', '655', '656', '657', '658',
            '690', '691', '692', '693', '694', '695',
            '696', '697', '698', '699'
          ) ";
                    $join .= "and bf" . $i . ".field_data ";
                    $join .= $this->mkSQL("like %Q ", "%" . $words[$i] . "%");
                    if (strlen($words[$i]) < $drop + 3) {
                        $wordsQ = preg_quote($words[$i]);
                        $join .= "and bf" . $i . ".field_data ";
                        $join .= $this->mkSQL("rlike %Q ", "[[:<:]]" . $wordsQ);
                    }
                    $join .= "and not bf" . $i . ".subfield_cd regexp('[0-9]') ";
                }
                $criteria = $this->_getCriteria($type, array("biblio.topic1", "biblio.topic2", "biblio.topic3", "biblio.topic4", "biblio.topic5"), $words, $bField = true, $drop);
            } elseif ($type == OBIB_SEARCH_CALLNO) {
                $criteria = $this->_getCriteria($type, array("biblio.call_nmbr1", "biblio.call_nmbr2", "biblio.call_nmbr3"), $words);
            } elseif ($type == OBIB_SEARCH_KEYWORD) {
                $drop = 1;
                for ($i = 0; $i < count($words); $i++) {
                    if (strlen($words[$i]) <= $drop)
                        continue;
                    if (strlen($words[$i]) <= $drop + 1)
                        $short = $short + 1;
                    $joins = $joins + 1;
                    $join .= "left join biblio_field as bf" . $i . " on bf" . $i . ".bibid=biblio.bibid ";
                    $join .= "and bf" . $i . ".tag in (";
                    if (strlen($words[$i]) > 8)
                        $join .= " '010', '020', '022', '024',";
                    $join .= "
            '110', '130', '245', '250', '260',
            '300', '336', '337', '338', '340',
            '380', '381', '382', '384', '383', '384',
            '400', '410', '440', '490',
            '500', '501', '502', '505', '511', '520',
            '521', '526',
            '600', '610', '611', '630', '650', '651',
            '653', '654', '655', '656', '657', '658',
            '690', '691', '692', '693', '694', '695',
            '696', '697', '698', '699',
            '700', '710', '730',
            '800', '810', '830', '856'
          ) ";
                    $join .= "and bf" . $i . ".field_data ";
                    $join .= $this->mkSQL("like %Q ", "%" . $words[$i] . "%");
                    if (strlen($words[$i]) < $drop + 3) {
                        $wordsQ = preg_quote($words[$i]);
                        $join .= "and bf" . $i . ".field_data ";
                        $join .= $this->mkSQL("rlike %Q ", "[[:<:]]" . $wordsQ);
                    }
                    $join .= "and not (bf" . $i . ".tag = '260' and bf" . $i . ".subfield_cd in ('a', 'e')) ";
                    if ($opacFlg)
                        $join .= "and not (bf" . $i . ".tag in ('526', '856') and bf" . $i . ".subfield_cd = 'x') ";
                    $join .= "and not bf" . $i . ".subfield_cd regexp('[0-9]') ";
                }
                $criteria = $this->_getCriteria($type, array("biblio.author", "biblio.responsibility_stmt", "biblio.title", "biblio.title_remainder", "biblio.topic1", "biblio.topic2", "biblio.topic3", "biblio.topic4", "biblio.topic5"), $words, $bField = true, $drop);
            } elseif ($type == OBIB_SEARCH_ALL) {
                //Changes PVD(8.0.x) Added Type To _getCriteria
                $criteria =
                    $this->_getCriteria(
                        $type,
                        array(
                            "biblio.topic1",
                            "biblio.topic2",
                            "biblio.topic3",
                            "biblio.topic4",
                            "biblio.topic5",
                            "biblio.title",
                            "biblio.title_remainder",
                            "biblio.author",
                            "biblio.responsibility_stmt"
                        ),
                        $words
                    );
            } else {
                // $criteria = $this->_getCriteria(array("biblio.title","biblio.title_remainder"),$words);
                //Changes PVD(8.0.x) Added Type To _getCriteria
                $criteria =
                    $this->_getCriteria($type, array("biblio.title", "biblio.title_remainder"), $words);
            }
            if ($opacFlg)
                $criteria = $criteria . "and opac_flg = 'Y' ";
        }
        if ($collecs) {
            $criteria .= $this->_getCollecCriteria($criteria, "biblio.collection_cd", $collecs);
        }
        if ($materials) {
            $criteria .= $this->_getMaterialCriteria($criteria, "biblio.material_cd", $materials);
        }

        # limit number of joins and short words
        if ($joins > 29 or $short > 3) {
            $msg = "Enclose adjacent \"words to be found\" with quotation marks.";
            if ($opacFlg)
                header("Location: ../opac/index.php?msg=" . U($msg));
            else
                header("Location: ../catalog/index.php?msg=" . U($msg));
            exit();
        }

        # setting query that will return all the data
        # sql_calc_found_rows is efficient for counting rows on unefficient queries...
        $sql = "select sql_calc_found_rows ";
        if ($bField)
            $sql .= "distinct ";
        $sql .= "biblio.* ";
        $sql .= ",biblio_copy.copyid ";
        $sql .= ",biblio_copy.barcode_nmbr ";
        $sql .= ",biblio_copy.status_cd ";
        $sql .= ",biblio_copy.due_back_dt ";
        $sql .= ",biblio_copy.mbrid ";
        $sql .= $join;
        $sql .= $criteria;
        $sql .= $this->mkSQL(" order by %C ", $sortBy);

        # setting limit so we can page through the results
        $offset = ($page - 1) * $this->_itemsPerPage;
        $limit = $this->_itemsPerPage;
        $sql .= $this->mkSQL(" limit %N, %N", $offset, $limit);

        #exit("sql=[".$sql."]<br>\n");

        # Running search sql statement
        if (!$this->_query($sql, $this->_loc->getText("biblioSearchQueryErr2"))) {
            return false;
        }

        # Calculate stats based on row count
        //Changes PVD(8.0.x)
        $link = (new QueryAny)->db();
        $this->_rowCount = implode($link->fetch_row($link->query('select found_rows();')));
        $this->_pageCount = ceil($this->_rowCount / $this->_itemsPerPage);
        return true;

    }


    /****************************************************************************
     * Utility function to get the selection criteria for a given column and set of values
     * @param string $col bibid of bibliography to select
     * @param array reference &$words array of words to search for
     * @return string returns SQL criteria syntax for the given column and set of values
     * @access private
     ****************************************************************************
     */
    function _getCriteria($type, $cols, &$words, $bField = false, $drop = "")
    {
        # setting selection criteria sql
        $prefix = "where ";
        $criteria = "";
        for ($i = 0; $i < count($words); $i++) {
            # Drop very short words when querying biblio_field
            if ($bField and strlen($words[$i]) > $drop)
                array_push($cols, "bf" . $i . ".field_data");
            $criteria .= $prefix . $this->_getLike($type, $cols, $words[$i]);
            $prefix = " and ";
            if ($bField and strlen($words[$i]) > $drop)
                array_pop($cols);
        }
        return $criteria;
    }

    function _getLike($type, &$cols, $word)
    {
        $prefix = "";
        $suffix = "";
        if (count($cols) > 1) {
            $prefix = "(";
            $suffix = ")";
        }
        $like = "";
        for ($i = 0; $i < count($cols); $i++) {
            $like .= $prefix;
            if ($type == OBIB_SEARCH_CALLNO)
                $like .= $this->mkSQL("%C like %Q ", $cols[$i], $word . "%");
            else
                $like .= $this->mkSQL("%C like %Q ", $cols[$i], "%" . $word . "%");
            $prefix = " or ";
        }
        $like .= $suffix;
        return $like;
    }

    function _getCollecCriteria($criteria, $col, $codes)
    {
        # setting additional selection criteria sql
        if (trim($criteria) == "") {
            $prefix = "where (";
        } else {
            $prefix = "and (";
        }
        $collec_criteria = "";
        for ($i = 0; $i < count($codes); $i++) {
            $collec_criteria .= $prefix . $col . "=" . $codes[$i];
            $prefix = " or ";
        }
        $collec_criteria .= ")";
        return $collec_criteria;
    }

    function _getMaterialCriteria($criteria, $col, $codes)
    {
        # setting additional selection criteria sql
        if (trim($criteria) == "") {
            $prefix = "where (";
        } else {
            $prefix = "and (";
        }
        $material_criteria = "";
        for ($j = 0; $j < count($codes); $j++) {
            $material_criteria .= $prefix . $col . "=" . $codes[$j];
            $prefix = " or ";
        }
        $material_criteria .= ")";
        return $material_criteria;
    }

    /****************************************************************************
     * Executes a query to select ONLY ONE SUBFIELD
     * @param string $bibid bibid of bibliography copy to select
     * @param string $fieldid copyid of bibliography copy to select
     * @return BiblioField returns subfield or false, if error occurs
     * @access public
     ****************************************************************************
     */
    function doQuery($statusCd, $mbrid = "")
    {

        $sql = "select biblio.* ";
        $sql .= ",biblio_copy.copyid ";
        $sql .= ",biblio_copy.barcode_nmbr ";
        $sql .= ",biblio_copy.status_cd ";
        $sql .= ",biblio_copy.status_begin_dt ";
        $sql .= ",biblio_copy.due_back_dt ";
        $sql .= ",biblio_copy.mbrid ";
        $sql .= ",biblio_copy.renewal_count ";
        $sql .= ",greatest(0,to_days(sysdate()) - to_days(biblio_copy.due_back_dt)) days_late ";
        $sql .= "from biblio, biblio_copy ";
        $sql .= "where biblio.bibid = biblio_copy.bibid ";
        if ($mbrid != "") {
            $sql .= $this->mkSQL("and biblio_copy.mbrid = %N ", $mbrid);
        }
        $sql .= $this->mkSQL(" and biblio_copy.status_cd=%Q ", $statusCd);
        $sql .= " order by biblio_copy.status_begin_dt desc";

        if (!$this->_query($sql, $this->_loc->getText("biblioSearchQueryErr3"))) {
            return false;
        }
        $this->_rowCount = $this->_conn->numRows();
        return true;
    }

    /****************************************************************************
     * Fetches a row from the query result and populates the BiblioSearch object.
     * @return BiblioSearch returns bibliography search record or false if no more bibliographies to fetch
     * @access public
     ****************************************************************************
     */
    function fetchRow()
    {
        $array = $this->_conn->fetchRow();
        if ($array == false) {
            return false;
        }

        # increment rowNmbr
        $this->_rowNmbr = $this->_rowNmbr + 1;
        $this->_currentRowNmbr = $this->_rowNmbr + (($this->_currentPageNmbr - 1) * $this->_itemsPerPage);

        $bib = new BiblioSearch();
        $bib->setBibid($array["bibid"]);
        $bib->setCopyid($array["copyid"]);
        $bib->setCreateDt($array["create_dt"]);
        $bib->setLastChangeDt($array["last_change_dt"]);
        $bib->setLastChangeUserid($array["last_change_userid"]);
        $bib->setMaterialCd($array["material_cd"]);
        $bib->setCollectionCd($array["collection_cd"]);
        $bib->setCallNmbr1($array["call_nmbr1"]);
        $bib->setCallNmbr2($array["call_nmbr2"]);
        $bib->setCallNmbr3($array["call_nmbr3"]);
        $bib->setTitle($array["title"]);
        $bib->setTitleRemainder($array["title_remainder"]);
        $bib->setResponsibilityStmt($array["responsibility_stmt"]);
        $bib->setAuthor($array["author"]);
        $bib->setTopic1($array["topic1"]);
        $bib->setTopic2($array["topic2"]);
        $bib->setTopic3($array["topic3"]);
        $bib->setTopic4($array["topic4"]);
        $bib->setTopic5($array["topic5"]);
        if (isset($array["barcode_nmbr"])) {
            $bib->setBarcodeNmbr($array["barcode_nmbr"]);
        }
        if (isset($array["status_cd"])) {
            $bib->setStatusCd($array["status_cd"]);
        }
        if (isset($array["status_begin_dt"])) {
            $bib->setStatusBeginDt($array["status_begin_dt"]);
        }
        if (isset($array["status_mbrid"])) {
            $bib->setStatusMbrid($array["status_mbrid"]);
        }
        if (isset($array["due_back_dt"])) {
            $bib->setDueBackDt($array["due_back_dt"]);
        }
        if (isset($array["days_late"])) {
            $bib->setDaysLate($array["days_late"]);
        }
        if (isset($array["renewal_count"])) {
            $bib->setRenewalCount($array["renewal_count"]);
        }
        # get Picture
        $biblioQ = new BiblioQuery();
        // Changes PVD(8.0.x)
        $biblioQ->connect_e();
        if ($biblioQ->errorOccurred()) {
            $biblioQ->close();
            displayErrorPage($biblioQ);
        }
        if (! $biblio = $biblioQ->doQuery($array["bibid"])) {
            $biblioQ->close();
            displayErrorPage($biblioQ);
        }
        $biblioFlds = $biblio->getBiblioFields();
        
        if (isset($biblioFlds["902a"])) {
            $bib->setPicture($biblioFlds["902a"]->getFieldData());
        } else {
            $bib->setPicture("");
        }
        

        return $bib;
    }


}

?>
