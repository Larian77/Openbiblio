<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "admin";
  $nav = "mail_messages";
  $focus_form_name = "editsettingsform";
  $focus_form_field = "libraryName";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #****************************************************************************
  
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    include_once("../classes/email/EmailMessages.php");
    include_once("../classes/email/EmailMessagesQuery.php");
    include_once("../functions/errorFuncs.php");
    $mailMessagesQ = new MailMessagesQuery();
    $mailMessagesQ->connect_e();
    if ($mailMessagesQ->errorOccurred()) {
      $mailMessagesQ->close();
      displayErrorPage($mailMessagesQ);
    }
    $mailMessagesQ->execSelect();
    if ($mailMessagesQ->errorOccurred()) {
      $mailMessagesQ->close();
      displayErrorPage($mailMessagesQ);
    } 

  #****************************************************************************
  #*  Display update message if coming from settings_edit with a successful update.
  #****************************************************************************
?>
    <div class="left primary formular messagesList">
        <div class="list">
            <div class="function header1"><?php echo $loc->getText('function'); ?></div>
            <div class="descriptionList header1">
            <?php
            echo $loc->getText('admin_mailMessage');
            ?>
            </div>
        </div>
        <div class="formContent">
            <?php
            $row_class = "oddRow";
            while ($MailMessages = $mailMessagesQ->fetchRow()) {
            ?>
                <div class="list <?php echo H($row_class);?>">
                    <div class="function">
                        <a href="./email_messages_edit_form.php?id=<?php echo $MailMessages->getMailMessageID(); ?>">
                            <?php  echo $loc->getText('edit'); ?>
                        </a><br></div>
                    <div class="descriptionList">
                    <?php
                    echo $loc->getText($MailMessages->_mailMessageType);
                    ?>
                    </div>
                </div>
            <?php
                # swap row color
                if ($row_class == "oddRow") {
                  $row_class = "straightRow";
                } else {
                  $row_class = "primary";
                }
            }
            ?>         
        </div>
        </div>
      </div>

<?php include("../shared/footer.php"); ?>
