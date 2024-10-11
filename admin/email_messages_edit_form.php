<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "admin";
  $nav = "mail_messages";
  $focus_form_name = "editMessagesForm";
  $focus_form_field = "libraryName";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #****************************************************************************
  if (isset($_GET["id"])){
    $mailMessageID = $_GET["id"];  

    include_once("../classes/email/EmailMessages.php");
    include_once("../classes/email/EmailMessagesQuery.php");
    include_once("../functions/errorFuncs.php");

    $mailMessagesQ = new MailMessagesQuery();
    $mailMessagesQ->connect_e();
    if ($mailMessagesQ->errorOccurred()) {
      $mailMessagesQ->close();
      displayErrorPage($mailMessagesQ);
    }
    $mailMessagesQ->execSelect($mailMessageID);
    
    if ($mailMessagesQ->errorOccurred()) {
      $mailMessagesQ->close();
      displayErrorPage($mailMessagesQ);
    } 
    
    $MailMessages = $mailMessagesQ->fetchRow();

    $mailMessagesQ->close();
  } else {
      require("../shared/get_form_vars.php");
  }
  
  #****************************************************************************
  #*  Create the Email Message fields.
  #****************************************************************************
  $messageType = '"' . $loc->getText($MailMessages->getMailMessageType()) . '"';
  $mailHtml = array(
    0 => 'Plain',
    1 => 'HTML'
  );
  $mailMessageBody = array(
      'id' => 'tinymce'
  );
  $fields = array(
      "admin_mailHtml" => inputField('select', "mailHtml", $MailMessages->getMailHtml(), NULL, $mailHtml),
      "admin_mailFromMail" => inputField('email', "mailFromMail", $MailMessages->getMailFromMail()),
      "admin_mailFromName" => inputField('text', "mailFromName", $MailMessages->getMailFromName()),
      "admin_mailSubject" => inputField('text', "mailSubject", $MailMessages->getMailSubject()),
      "admin_mailBodyHtml" => inputField('textarea', "mailBodyHtml", $MailMessages->getMailBodyHtml(), $mailMessageBody),
      "admin_mailBodyPlain" => inputField('textarea', "mailBodyPlain", $MailMessages->getMailBodyPlain()),
      "admin_mailMessageID" => inputField('hidden', "mailMessageID", $MailMessages->getMailMessageID()),
      "admin_mailMessageType" => inputField('hidden', "mailMessageType", $MailMessages->getMailMessageType())
    );

  #****************************************************************************
  #*  Display update message if coming from settings_edit with a successful update.
  #****************************************************************************
  if (isset($_GET["updated"])){
?>
  <font class="error"><?php echo $loc->getText("admin_mailSettingsUpdated"); ?></font>
<?php
  }
?>
      <div class="left primary formular">
          <div class="header1"><?php echo $loc->getText('admin_mailMessage_edit', array("message" => $messageType)); ?></div>
        <div class="form">
            <div class="formContent">
                <form name="editEmailMessagesform" method="POST" action="../admin/email_messages_edit.php"> 
                    <?php
                    foreach ($fields as $title => $html) {  
                        if ($title != 'admin_mailMessageID' && $title != 'admin_mailMessageType') {
                            if ($title == 'admin_mailBodyHtml') {
                                echo '<div class="helpInfo notice">' . $loc->getText('admin_mailBodyInfo') . '</div>';
                            }
                    ?>
                            <div class="descriptionField"><?php echo $loc->getText($title); ?><br></div>
                        <?php
                        }
                        if ($title == 'admin_mailMessageID' || $title == 'admin_mailMessageType') {
                        ?> 
                            <div class="inputField hidden">
                  <?php } else { ?>
                            <div class="inputField">
                            <?php
                        }
                            echo $html;
                            if ($title == 'admin_PwdForgottenCodeDuration') {
                                echo '&nbsp;' . $loc->getText('admin_Duration');
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="buttonarea">
                        <div class="submit"><input type="submit" value="<?php echo $loc->getText('adminSubmit'); ?>" class="button">
                        &nbsp;<input type="button" onClick="self.location='../admin/email_messages_list.php'" 
                                     value="<?php echo $loc->getText('adminCancel'); ?>" class="button">
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>

<?php 
unset($_SESSION["postVars"]);
unset($_SESSION["pageErrors"]);

include("../shared/footer.php"); ?>
