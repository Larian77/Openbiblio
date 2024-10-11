<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once ("../shared/common.php");

$tab = "home";
$nav = "pwdforget";

require_once ("../shared/header.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, 'shared');

require_once ("../classes/email/EmailSettings.php");
require_once ("../classes/email/EmailSettingsQuery.php");

if (isset($_SESSION["pageErrors"])) {
    $pageErrors = $_SESSION["pageErrors"];
}
if (isset($_SESSION["postVars"])) {
    $postVars = $_SESSION["postVars"];
}
if (isset($_GET["send"])) {
    $send = $_GET["send"];
} else {
    $send = 1;
}
$mailSetQ = new MailSettingsQuery();
$mailSetQ->connect_e();
if ($mailSetQ->errorOccurred()) {
  $mailSetQ->close();
  displayErrorPage($mailSetQ);
}
$mailSetQ->execSelect();
if ($mailSetQ->errorOccurred()) {
  $mailSetQ->close();
  displayErrorPage($mailSetQ);
}
$PwdForgottenSetting = $mailSetQ->fetchPwdForgottenSettings();

if($PwdForgottenSetting == 0) {
    echo $loc->getText('PwdForgottenSettingNone');
} else if ($send <= 9) {
?>
    <div class="middle primary formular">
        <div class="header1"><?php echo $loc->getText('PwdForgotten'); ?></div>
        <?php if($PwdForgottenSetting == 1) { ?>
            <div class="info"><p><?php echo $loc->getText('PwdForgottenInfo_or'); ?></p>
        <?php } else if ($PwdForgottenSetting == 2) { ?>
            <div class="info"><p><?php echo $loc->getText('PwdForgottenInfo_and'); ?></p>
        <?php } ?>
    </div>

        <?php
        if (isset($pageErrors["pwdForgottenError"]) && !empty($pageErrors)) {
            echo '<div class="errorInfo"><font class="error">' . H($pageErrors["pwdForgottenError"]) . '</font></div>';
        }
        ?>
        <div class="form middle">
            <div class="formContent">
                <form action="../admin/staff_pwd_forget.php" method="post" name="pwd_forgotten">
                    <div class="descriptionField"><?php echo $loc->getText('email'); ?><br></div>
                    <div class="inputField"><input type="email" name="email" 
                                value="<?php echo isset($postVars['email']) ? htmlentities($postVars['email']) : ''; ?>">
                    </div>       
<?php   if ($PwdForgottenSetting == 1) { ?>
                    <div class="inputField hidden">
                        <input type="hidden" name="send" value="
                            <?php if (isset($send)) echo $send; ?>">
                        <input type="hidden" name="emailForm" value="emailForm">
                    </div>
                    <div class="submit"><input type="submit" value="<?php echo $loc->getText('NewPassword'); ?>" class="button"></div>               
                </form>
            </div>
        </div>
        <div class="form middle">
            <div class="choice"><?php echo $loc->getText('or'); ?></div>
            <br />
            <div class="formContent">
                <form action="../admin/staff_pwd_forget.php" method="post" name="pwd_forgotten">
<?php   } 
        if ($PwdForgottenSetting == 2) { ?>
            <div class="choice"><?php echo $loc->getText('and'); ?></div>
            <div class="inputField hidden">
                <input type="hidden" name="send" value="
                    <?php if (isset($send)) echo $send; ?>">
                <input type="hidden" name="emailForm" value="emailForm">
            </div>
<?php   } ?> 
                    <div class="descriptionField"><?php echo $loc->getText('barcodeNmbr'); ?><br></div>
                    <div class="inputField"><input type="text" name="username" 
                                value="<?php echo isset($postVars['username']) ? htmlentities($postVars['username']) : ''; ?>">
                    </div>       
                    <div class="hidden">
                        <input type="hidden" name="send" value="
                            <?php if (isset($send)) echo $send; ?>">
                        <input type="hidden" name="usernameForm" value="usernameForm">
                    </div>
                    <div class="submit"><input type="submit" value="<?php echo $loc->getText('NewPassword'); ?>" class="button"></div>
                </form>
            </div>
        </div>
    </div>
<?php 
} else {
    echo $loc->getText('TooManyAttempts');
}
include("../shared/footer.php"); 
?>
