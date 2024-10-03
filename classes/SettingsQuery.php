<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");

/******************************************************************************
 * SettingsQuery data access component for settings table
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class SettingsQuery extends Query
{

    /****************************************************************************
     * Executes a query
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function execSelect()
    {
        $sql = "select * from settings";
        return $this->_query($sql, "Error accessing library settings information.");
    }

    /****************************************************************************
     * Fetches a row from the query result and populates the Settings object.
     * @return Settings returns settings object or false if no more rows to fetch
     * @access public
     ****************************************************************************
     */
    function fetchRow()
    {
        $array = $this->_conn->fetchRow();
        if ($array == false) {
            return false;
        }
        $set = new Settings();
        $set->setLibraryName($array["library_name"]);
        $set->setLibraryImageUrl($array["library_image_url"]);
        if ($array["use_image_flg"] == 'Y') {
            $set->setUseImageFlg(true);
        } else {
            $set->setUseImageFlg(false);
        }
        $set->setLibraryHours($array["library_hours"]);
        $set->setLibraryPhone($array["library_phone"]);
        $set->setLibraryUrl($array["library_url"]);
        $set->setOpacUrl($array["opac_url"]);
        $set->setSessionTimeout($array["session_timeout"]);
        $set->setItemsPerPage($array["items_per_page"]);
        $set->setVersion($array["version"]);
        $set->setThemeid($array["themeid"]);
        $set->setPurgeHistoryAfterMonths($array["purge_history_after_months"]);
        if ($array["block_checkouts_when_fines_due"] == 'Y') {
            $set->setBlockCheckoutsWhenFinesDue(true);
        } else {
            $set->setBlockCheckoutsWhenFinesDue(false);
        }
        $set->setHoldMaxDays($array["hold_max_days"]);
        $set->setLocale($array["locale"]);
        $set->setCharset($array["charset"]);
        $set->setHtmlLangAttr($array["html_lang_attr"]);
        if (isset($array["login_attempts"])) {
            $set->setLoginAttempts($array["login_attempts"]);
        }
        if (isset($array["pwd_timeout"])) {
            $set->setPwdTimeout($array["pwd_timeout"]);
        }
        if(isset($array["mbraccount_online"])) {
            if ($array["mbraccount_online"] == 'Y') {
                $set->setMbrAccountOnline(true);
            } else {
                $set->setMbrAccountOnline(false);
            }
        }

        return $set;
    }

    /****************************************************************************
     * Update a the row in the settings table.
     * @param Settings $set settings object to update
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function update($set)
    {
        $sql = $this->mkSQL(
            "update settings set "
            . "library_name=%Q, library_image_url=%Q, "
            . "use_image_flg=%Q, library_hours=%Q, "
            . "library_phone=%Q, library_url=%Q, "
            . "opac_url=%Q, session_timeout=%N, "
            . "items_per_page=%N, purge_history_after_months=%N, "
            . "block_checkouts_when_fines_due=%Q, "
            . "hold_max_days=%N, "
            . "locale=%Q, charset=%Q, html_lang_attr=%Q, login_attempts=%N, "
            . "pwd_timeout=%N, mbraccount_online=%Q ",    
            $set->getLibraryName(),
            $set->getLibraryImageUrl(),
            $set->isUseImageSet() ? "Y" : "N",
            $set->getLibraryHours(),
            $set->getLibraryPhone(),
            $set->getLibraryUrl(),
            $set->getOpacUrl(),
            $set->getSessionTimeout(),
            $set->getItemsPerPage(),
            $set->getPurgeHistoryAfterMonths(),
            $set->isBlockCheckoutsWhenFinesDue() ? "Y" : "N",
            $set->getHoldMaxDays(),
            $set->getLocale(),
            $set->getCharset(),
            $set->getHtmlLangAttr(),
            $set->getLoginAttempts(),
            $set->getPwdTimeout(),
            $set->isMbrAccountOnline() ? "Y" : "N"   
        );

        return $this->_query($sql, "Error updating library settings information");
    }

    /****************************************************************************
     * Update a the row in the settings table.
     * @param Settings $set settings object to update
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function updateTheme($themeId)
    {
        $sql = $this->mkSQL("update settings set themeid=%N", $themeId);
        return $this->_query($sql, "Error updating library theme in use");
    }

    function getPurgeHistoryAfterMonths($query)
    {
        $sql = "select purge_history_after_months from settings";
        $rows = $query->exec($sql);
        if (count($rows) != 1) {
            (new Fatal)->internalError("Wrong number of settings rows");
        }
        return $rows[0]["purge_history_after_months"];
    }
}

?>