<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once ("../shared/common.php");

$tab = "home";
$nav = "pwdforget";

require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, 'shared');

require_once("../classes/Staff.php");
require_once("../classes/StaffQuery.php");

if (isset($_SESSION["pageErrors"])) {
    $pageErrors = $_SESSION["pageErrors"];
}
if (isset($_SESSION["postVars"])) {
    $postVars = $_SESSION["postVars"];
}
if(!isset($_GET['username']) || !isset($_GET['code'])) {
    require_once("../shared/header.php");
    echo $loc->getText('errInvalidPwdForgottenURL');
    include("../shared/footer.php");
    exit();
}

#**************************************************************************
#*  Destroy form values and errors
#**************************************************************************
unset($_SESSION["postVars"]);
unset($_SESSION["pageErrors"]);
 
$username = $_GET['username'];
$code = $_GET['code'];
if (isset($_GET['send'])) {
    $send = $_GET['send'];
}
$success = 0;
$error = NULL;

#**************************************************************************
#* Query to table staff to get pwd_forgotten and pwd_forgotten_time
#**************************************************************************
$staffQ = new StaffQuery();
$staffQ->connect_e();
$result = $staffQ->getPwdForgottenCode($username);

#**************************************************************************
#* Check that a user has been found and that they also have a password code
#**************************************************************************
if(isset($result) && $result == null) {
    $error = $loc->getText('errInvalidPwdForgottenURL');
} else {
    #**************************************************************************
    #* Query to table mail_settings to get pwd_forgotten_code_duration
    #**************************************************************************
    include_once("../classes/email/EmailSettings.php");
    include_once("../classes/email/EmailSettingsQuery.php");
    include_once("../functions/errorFuncs.php");
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
    $MailSet = $mailSetQ->fetchRow();
    $PwdDuration = $MailSet->_pwdForgottenCodeDuration;

    #**************************************************************************
    #* Password-Forgotten-time query
    #**************************************************************************
    $DateInterval = "PT" . $PwdDuration . "H";
    $PwdForgottenTime = new DateTimeImmutable($result["pwd_forgotten_time"]);
    $PwdTimeon = $PwdForgottenTime->add(new DateInterval("$DateInterval"));
    $timeCurrent = new DateTime("now");
    if($result['pwd_forgotten_time'] === null || $PwdTimeon < $timeCurrent) {
        $error = $loc->getText('errExpiredPwdForgottenCode');
    }

    #**************************************************************************
    #* Check the password code
    #**************************************************************************
    if(hash('sha256', $code) != $result['pwd_forgotten']) {
        $error = $loc->getText('errInvalidPwdForgottenURL');
    }
    if(!isset($send)) {
        require_once ("../shared/header.php");
    }
    
    #**************************************************************************
    #* The code is correct, so the member user can set a new password.
    #**************************************************************************
    if(isset($send)) {
        $staff = new Staff();
        $staff->setUsername($username);
        $staff->setPwd($_POST['pwd']);
        $_POST["pwd"] = $staff->getPwd();
        $staff->setPwd2($_POST['pwdRepeat']);
        $_POST["pwdRepeat"] = $staff->getPwd2();

        $validData = $staff->validatePwd();
        if (!$validData) {
            $pageErrors["pwdError"] = $staff->getPwdError();
            $_SESSION["pageErrors"] = $pageErrors;
            $_SESSION["postVars"] = $_POST;
            header("Location: ../admin/staff_pwd_newset_form.php?username=$username&code=$code");
            exit();
        }

        #**************************************************************************
        #*  Reset password in member
        #**************************************************************************
        $success = $staffQ->resetPwd($staff);
        $staffQ->close();
        if($success == 1) {
            #**************************************************************************
            #*  Show success page
            #**************************************************************************
            require_once("../shared/header.php");
            echo $loc->getText("PwdResetSuccessfully");  
        }
    }
}
if (isset($error)) {
    #**************************************************************************
    #*  Show Error page - invalid Code or expired code
    #**************************************************************************
    require_once("../shared/header.php");
    echo $error;
}

if ($success == 0 && $error == NULL) {
?>
    </form>
    <div class="middle primary formular">
        <div class="header1"><?php echo $loc->getText('staff_pwd_reset_form_Resetheader'); ?></div>
        <div class="info">
            <?php echo $loc->getText("PwdRequirement"); ?>
        </div>
        <div class="form middle">
                <div class="formContent">
                <form action="../admin/staff_pwd_newset_form.php?send=1&amp;username=<?php echo H($username); ?>&amp;code=<?php echo H($code); ?>" method="post">
                    <div class="descriptionField"><?php echo $loc->getText('new_form_Password'); ?><br></div>
                    <div class="inputField"><input type="password" name="pwd" size="20" maxlength="20" 
                                                    value="<?php echo isset($postVars['pwd']) ? H($postVars['pwd']) : ''; ?>">
                    </div>
                    <div class="descriptionField"><?php echo $loc->getText('new_form_Reenterpassword'); ?><br></div>
                    <div class="inputField"><input type="password" name="pwdRepeat" size="20" maxlength="20" 
                                                   value="<?php echo isset($postVars['pwdRepeat']) ? H($postVars['pwdRepeat']) : ''; ?>">
                    </div>
                     <div class="errorInfo">
                        <font class="error">
                            <?php if (isset($pageErrors["pwdError"])) echo '<br />' . H($pageErrors["pwdError"]); ?>
                        </font>
                    </div>
                    <div class="submit"><input type="submit" value="<?php echo $loc->getText('sharedSubmit'); ?>" class="button"></div>
                </form>
            </div>  
            <br />
        </div>
    </div>
<?php
}

include("../shared/footer.php"); 
?>
