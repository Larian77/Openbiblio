<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

$tab = "home";
require_once("../shared/common.php");
require_once("../classes/Staff.php");
require_once("../classes/StaffQuery.php");
require_once("../classes/SessionQuery.php");
require_once("../functions/errorFuncs.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, "shared");

#****************************************************************************
#*  Checking for post vars.  Go back to form if none found.
#****************************************************************************
$pageErrors = array();

if (count($_POST) == 0) {
    header("Location: ../shared/loginform.php");
    exit();
}

#****************************************************************************
#*  Username edits
#****************************************************************************
$username = $_POST["username"];
if ($username == "") {
    $error_found = true;
    $pageErrors["username"] = $loc->getText("loginUserNameReqErr");
}

#****************************************************************************
#*  Password edits
#****************************************************************************
$error_found = false;
$pwd = $_POST["pwd"];
if (str_replace(' ','',$pwd) == "") {
    $error_found = true;
    $pageErrors["pwd"] = $loc->getText("loginPwdReqErr");
} else {
    $staffQ = new StaffQuery();
    $staffQ->connect_e();
    if ($staffQ->errorOccurred()) {
        displayErrorPage($staffQ);
    }
    $PwdHashChange = 0;
    $pwdmd5 = $staffQ->verifySignonMd5($username, $pwd); // Necessary as long as md5 passwords are still available
    if ($pwdmd5->num_rows == 1) {
        $PwdHashChange = 1;
    } else {
        $pwdHash = $staffQ->verifySignonPwdHash($username);    
    }
    if ($staffQ->errorOccurred()) {
        displayErrorPage($staffQ);
    }
    $staff = $staffQ->fetchStaff();
    if ($staff == NULL) {
        $error_found = true;
        $pageErrors["username"] = $loc->getText("loginUserNameReqErr");
        
    } else {
        #****************************************************************************
        # Password timeout query
        #****************************************************************************
        $PwdTimeout = new DateTimeImmutable($staff->getPwdTimeout());
        $PwdTimeon = $PwdTimeout->add(new DateInterval('PT' . OBIB_PWD_TIMEOUT . 'M'));
        $timeCurrent = new DateTime("now");
        if ($PwdTimeon == $timeCurrent || $PwdTimeon < $timeCurrent) {
            if (isset($pwdHash->num_rows) == 1) {
                $validatepassword = '';
                $validatepassword = password_verify($pwd, $staff->_pwd);
                if($validatepassword != 1) {
                    $staff = false;
                }
            }   
            if ($PwdHashChange === 1) {
                $PwdHashNew = $staffQ->Change_Md5_Pwd($staff, $pwd);  //Update md5-Pwd to Pwd-Hash
                if($PwdHashNew != 1) {
                    $staff = false;
                }
            }

            if ($staff == false) { 
                # invalid password.  Add one to login attempts.
                $error_found = true;
                $pageErrors["pwd"] = $loc->getText("loginPwdInvErr");
                if (!isset($_SESSION["loginAttempts"]) || ($_SESSION["loginAttempts"] == "")) {
                    $sess_login_attempts = 1;
                } else {
                    $sess_login_attempts = $_SESSION["loginAttempts"] + 1;
                }
                $_SESSION["loginAttempts"] = $sess_login_attempts;   
                # Suspend userid if there are too many login attempts
                if ($sess_login_attempts >= OBIB_LOGIN_ATTEMPTS ) {
                    $staffQ->LoginTimeoutStaff($username);
                    $staffQ->close();
                    $_SESSION["loginAttempts"] = 0;
                    $_SESSION["loginPage"] = $tab;
                    header("Location: timeout.php");
                    exit();
                }
            }
        } else {
        #****************************************************************************
        #*  Redirect of a message if timeout due to too frequent incorrect login
        #****************************************************************************
            $_SESSION["loginPage"] = $tab;
            header("Location: ../shared/timeout.php");
            exit();
        }
        $staffQ->close();
    }
}

#****************************************************************************
#*  Redirect back to form if error occured
#****************************************************************************
if ($error_found == true) {
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../shared/loginform.php");
    exit();
}

#****************************************************************************
#*  Redirect to suspended message if suspended
#****************************************************************************
if ($staff->isSuspended()) {
    header("Location: ../shared/suspended.php");
    exit();
}

#**************************************************************************
#*  Insert new session row with random token
#**************************************************************************

$sessionQ = new SessionQuery();
$sessionQ->connect_e();
if ($sessionQ->errorOccurred()) {
    $sessionQ->close();
    displayErrorPage($sessionQ);
}
$token = $sessionQ->getToken($staff->getUserid());
if ($token == false) {
    $sessionQ->close();
    displayErrorPage($sessionQ);
}
$sessionQ->close();

#**************************************************************************
#*  Destroy form values and errors and reset signon variables
#**************************************************************************
unset($_SESSION["postVars"]);
unset($_SESSION["pageErrors"]);

$_SESSION["username"] = $staff->getUsername();
$_SESSION["userid"] = $staff->getUserid();
$_SESSION["firstName"] = $staff->getFirstName();
$_SESSION["lastName"] = $staff->getLastName();
$_SESSION["token"] = $token;
$_SESSION["loginAttempts"] = 0;
$_SESSION["hasAdminAuth"] = $staff->hasAdminAuth();
$_SESSION["hasCircAuth"] = $staff->hasCircAuth();
$_SESSION["hasCircMbrAuth"] = $staff->hasCircMbrAuth();
$_SESSION["hasCatalogAuth"] = $staff->hasCatalogAuth();
$_SESSION["hasReportsAuth"] = $staff->hasReportsAuth();


if (! isset($_SESSION["returnPage"]) || ($_SESSION["returnPage"] == "")) {
    $_SESSION["returnPage"] = '../home/index.php';
}

#**************************************************************************
#*  Redirect to return page
#**************************************************************************
header("Location: " . $_SESSION["returnPage"]);
exit();

?>
