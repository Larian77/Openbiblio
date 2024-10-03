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
class MailMessagesQuery extends Query
{  
    
  /****************************************************************************
   * Executes a query
   * @param string could be:
   * - $mailMessageID --> column id (optional)
   * - $mailMessageType --> column mail_message_type (optional) or
   * empty of table mail_messages to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect($messageInfo="") {
    $sql = "select * from mail_messages";
    if ($messageInfo != "") {
        # Check if your variable is an integer
        if ( filter_var($messageInfo, FILTER_VALIDATE_INT) === false ) {;
            $sql .= $this->mkSQL(" where mail_message_type=%Q ", $messageInfo);
        } else {
            $sql .= $this->mkSQL(" where id=%N ", $messageInfo);
        }
    }
    $sql .= " order by mail_message_type";
    
    return $this->_query($sql, "Error about message informations.");
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
        $MailMessages = new MailMessages();
        $MailMessages->setMailMessageID($array["id"]);
        $MailMessages->setMailMessageType($array["mail_message_type"]);
        $MailMessages->setMailFromMail($array["mail_from_mail"]);
        $MailMessages->setMailFromName($array["mail_from_name"]);
        $MailMessages->setMailSubject($array["mail_subject"]);
        $MailMessages->setMailBodyHtml($array["mail_body_html"]);
        $MailMessages->setMailBodyPlain($array["mail_body_plain"]);
        $MailMessages->setMailHtml($array["mail_html"]);

        return $MailMessages;
    }
   
    /****************************************************************************
     * Update a the row in the mail_settings table.
     * @param MailMessages $MailMessages object to update
     * @return boolean returns false, if error occurs
     * @access public
     ****************************************************************************
     */
    function update($MailMessages)
    {
        $sql = $this->mkSQL(
            "update mail_messages set "
            . "mail_message_type=%Q, mail_from_mail=%Q, "
            . "mail_from_name=%Q, mail_subject=%Q, "
            . "mail_body_html=%Q, mail_body_plain=%Q, mail_html=%N "
            . "WHERE id=%N",    
            $MailMessages->getMailMessageType(),
            $MailMessages->getMailFromMail(),
            $MailMessages->getMailFromName(),
            $MailMessages->getMailSubject(),
            $MailMessages->getMailBodyHtml(),
            $MailMessages->getMailBodyPlain(),
            $MailMessages->getMailHtml(),
            $MailMessages->getMailMessageID()
        );
        
        return $this->_query($sql, "Error updating mail settings information");
    }
}

?>