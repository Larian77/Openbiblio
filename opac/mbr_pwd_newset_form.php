<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once ("../shared/common.php");

$tab = "opac";
$nav = "pwdforget";
$helpPage = "opac";

require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, 'shared');

require_once("../classes/Member.php");
require_once("../classes/MemberQuery.php");

if (isset($_SESSION["pageErrors"])) {
    $pageErrors = $_SESSION["pageErrors"];
}
if (isset($_SESSION["postVars"])) {
    $postVars = $_SESSION["postVars"];
}
if(!isset($_GET['mbrid']) || !isset($_GET['code'])) {
    require_once("../shared/header_opac.php");
    echo $loc->getText('errInvalidPwdForgottenURL');
    include("../shared/footer.php");
    exit();
}

#**************************************************************************
#*  Destroy form values and errors
#**************************************************************************
unset($_SESSION["postVars"]);
unset($_SESSION["pageErrors"]);
 
$mbrid = $_GET['mbrid'];
$code = $_GET['code'];
if (isset($_GET['send'])) {
    $send = $_GET['send'];
}
$success = 0;
$error = NULL;

#**************************************************************************
#* Query to table member to get pwd_forgotten and pwd_forgotten_time
#**************************************************************************
$mbrQ = new MemberQuery();
$mbrQ->connect_e();
$result = $mbrQ->getPwdForgottenCode($mbrid);

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
        require_once ("../shared/header_opac.php");
    }
    
    #**************************************************************************
    #* The code is correct, so the member user can set a new password.
    #**************************************************************************
    if(isset($send)) {
        $mbr = new Member();
        $mbr->setMbrid($mbrid);
        $mbr->setPwd($_POST['pwd']);
        $_POST["pwd"] = $mbr->getPwd();
        $mbr->setPwdRepeat($_POST['pwdRepeat']);
        $_POST["pwdRepeat"] = $mbr->getPwdRepeat();

        $validData = $mbr->validatePwd();
        if (!$validData) {
            $pageErrors["pwdError"] = $mbr->getPwdError();
            $_SESSION["pageErrors"] = $pageErrors;
            $_SESSION["postVars"] = $_POST;
            header("Location: ../opac/mbr_pwd_newset_form.php?mbrid=$mbrid&code=$code");
            exit();
        }

        #**************************************************************************
        #*  Reset password in member
        #**************************************************************************
        $success = $mbrQ->resetPwd($mbr);
        $mbrQ->close();
        if($success == 1) {
            #**************************************************************************
            #*  Show success page
            #**************************************************************************
            require_once("../shared/header_opac.php");
            echo $loc->getText("PwdResetSuccessfully");  
        }
    }
}
if (isset($error)) {
    #**************************************************************************
    #*  Show Error page - invalid Code or expired code
    #**************************************************************************
    require_once("../shared/header_opac.php");
    echo $error;
}

if ($success == 0 && $error == NULL) {
?>
    </form>
    <div class="middle primary formular">
        <div class="header1"><?php echo $loc->getText('mbr_pwd_create_form_Resetheader'); ?></div>
        <div class="info">
            <?php echo $loc->getText("PwdRequirement"); ?>
        </div>
        <div class="form middle">
                <div class="formContent">
                <form action="../opac/mbr_pwd_newset_form.php?send=1&amp;mbrid=<?php echo H($mbrid); ?>&amp;code=<?php echo H($code); ?>" method="post">
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
