<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
$tab = "opac";
require_once ("../shared/common.php");
require_once ("../opac/MemberLoginQuery.php");
require_once ("../classes/MemberQuery.php");
require_once ("../functions/errorFuncs.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

# ****************************************************************************
# * Checking for post vars. Go back to form if none found.
# ****************************************************************************
$pageErrors = array();
if (count($_POST) == 0) {
    header("Location: ../shared/loginform.php");
    exit();
}

# ****************************************************************************
# * Username edits
# ****************************************************************************
$username = $_POST["username"];
if ($username == "") {
    $error_found = true;
    $pageErrors["username"] = $loc->getText("MemberID is required.");
}

# ****************************************************************************
# * Password edits
# ****************************************************************************
$error_found = false;
$pwd = $_POST["pwd"];
if (str_replace(' ', '', $pwd) == "") {
    $error_found = true;
    $pageErrors["pwd"] = $loc->getText("Password is required.");
} else {
    $mbrQ = new MemberQuery();
    $mbrQ->connect_e();
    $mbrQ->execSearch(OBIB_SEARCH_BARCODE, $username, 1, $login = TRUE);
    if ($mbrQ->getRowCount() == 1) {
        $mbr = $mbrQ->fetchMember();
        if (OBIB_MBR_ACCOUNT_ONLINE == FALSE) {
            $error_found = true;
            $pageErrors["common"] = "Member-Login is deactivated!";
        } else {
            // Password timout query
            $PwdTimeout = new DateTimeImmutable($mbr->getPwdTimeout());
            $PwdTimeon = $PwdTimeout->add(new DateInterval('PT' . OBIB_PWD_TIMEOUT . 'M'));
            $timeCurrent = new DateTime("now");
            if ($PwdTimeon == $timeCurrent || $PwdTimeon < $timeCurrent) {
                $mbrLgQ = new MemberLoginQuery();
                $mbrLgQ->connect_e();
                $pwdHash = $mbrLgQ->verifySignon($mbr->getMbrid());
                if ($mbrLgQ->errorOccurred()) {
                    displayErrorPage($mbrLgQ);
                }
                if (isset($pwdHash->num_rows) == 1) {
                    $validatepassword = '';
                    $validatepassword = password_verify($pwd, $mbr->_pwd);
                    if ($validatepassword == 1) {
                        $row = TRUE;
                    } else {
                        $row = FALSE;
                    }
                }
                $mbrLgQ->close();
                if ($row == false) {
                    $error_found = true;
                    $pageErrors["common"] = "Invalid Login!";
                     if (!isset($_SESSION["mbrloginAttempts"]) || ($_SESSION["mbrloginAttempts"] == "")) {
                        $sess_login_attempts = 1;
                    } else {
                        $sess_login_attempts = $_SESSION["mbrloginAttempts"] + 1;
                    }
                    $_SESSION["mbrloginAttempts"] = $sess_login_attempts;   
                    # Suspend userid if there are too many login attempts
                    if ($sess_login_attempts >= OBIB_LOGIN_ATTEMPTS ) {
                        $mbrQ->LoginTimeoutMember($username);
                        $mbrQ->close();
                        $_SESSION["mbrloginAttempts"] = 0;
                        $_SESSION["loginPage"] = $tab;
                        header("Location: ../shared/timeout.php");
                        exit();
                    }
                } else {
                    $token = rand(- 10000, 10000);
                    $mbrQ->close();

                    # **************************************************************************
                    # * Destroy form values and errors and reset signon variables
                    # **************************************************************************
                    unset($_SESSION["postVars"]);
                    unset($_SESSION["pageErrors"]);

                    $_SESSION["mbrid"] = $mbr->getMbrid();
                    $_SESSION["mbrFirstName"] = $mbr->getFirstName();
                    $_SESSION["mbrLastName"] = $mbr->getLastName();
                    $_SESSION["mbrtoken"] = $token;
                    $_SESSION["mbrloginAttempts"] = 0;
                    header("Location: ../opac/mbr_account.php?mbrid=" . U($mbr->getMbrid()));
                    exit();
                }
            } else {
                #****************************************************************************
                #*  Redirect of a message if timeout due to too frequent incorrect login
                #****************************************************************************
                $_SESSION["loginPage"] = $tab;
                header("Location: ../shared/timeout.php");
                exit();
            }
        }
    } else {
        $mbrQ->close();
        $error_found = true;
        $pageErrors["common"] = "Invalid Logon. Maybe you don't have a password? Please ask the Staff!";
    }
}

# ****************************************************************************
# * Redirect back to form if error occured
# ****************************************************************************
if ($error_found == true) {
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../opac/loginform.php");
    exit();
}

if (! isset($_SESSION["returnPage"]) || ($_SESSION["returnPage"] == "")) {
    $_SESSION["returnPage"] = '../opac/loginform.php';
}

header("Location: " . $_SESSION["returnPage"]);
exit();

?>
