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
class MailSettingsQuery extends Query
{  
    /****************************************************************************
     * Executes a query
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function execSelect()
    {
        $sql = "select * from mail_settings";
        
        return $this->_query($sql, "Error accessing mail settings information.");
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
        $MailSet = new MailSettings();
        $MailSet->setPwdForgottenSettings($array["pwd_forgotten_settings"]);
        $MailSet->setMailSmtpSecure($array["mail_smtp_secure"]);
        $MailSet->setMailProcess($array["mail_process"]);
        $MailSet->setPwdForgottenCodeDuration($array["pwd_forgotten_code_duration"]);
        $MailSet->setMailHost($array["mail_host"]);
        $MailSet->setMailUser($array["mail_user"]);
        $MailSet->setMailPwd($array["mail_pwd"]);  

        return $MailSet;
    }

    /****************************************************************************
     * Update a the row in the mail_settings table.
     * @param MailSettings $MailSet settings object to update
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function update($MailSet)
    {
        $sql = $this->mkSQL(
            "update mail_settings set "
            . "pwd_forgotten_settings=%N, pwd_forgotten_code_duration=%N, "
            . "mail_process=%N, mail_host=%Q, "
            . "mail_user=%Q, mail_pwd=%Q, "
            . "mail_smtp_secure=%Q ",    
            $MailSet->getPwdForgottenSettings(),
            $MailSet->getPwdForgottenCodeDuration(),
            $MailSet->getMailProcess(),
            $MailSet->getMailHost(),
            $MailSet->getMailUser(),
            $MailSet->getMailPwd(),
            $MailSet->getMailSmtpSecure()
        );
        
        return $this->_query($sql, "Error updating mail settings information");
    }
    
    function fetchPwdForgottenSettings() 
    {
        $array = $this->_conn->fetchRow();
        if ($array == false) {
            return false;
        }
        $MailSet = new MailSettings();
        $MailSet->setPwdForgottenSettings($array["pwd_forgotten_settings"]);

        return $MailSet->getPwdForgottenSettings();
    }

}

?>