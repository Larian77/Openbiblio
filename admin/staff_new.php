<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "staff";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../admin/staff_new_form.php");
    exit();
  }

  #****************************************************************************
  #*  Set new member datas
  #****************************************************************************
  $staff = new Staff();
  $staff->setLastChangeUserid($_SESSION["userid"]);
  $staff->setLastName($_POST["last_name"]);
  $_POST["last_name"] = $staff->getLastName();
  $staff->setFirstName($_POST["first_name"]);
  $_POST["first_name"] = $staff->getFirstName();
  $staff->setUsername($_POST["username"]);
  $_POST["username"] = $staff->getUsername();
  $staff->setEmail($_POST["email"]);
  $_POST["email"] = $staff->getEmail();
  $staff->setTypeOfPwdCreation(isset($_POST["TypeOfPwdCreation"]));
  $staff->setPwd($_POST["pwd"]);
  $_POST["pwd"] = $staff->getPwd();
  $staff->setPwd2($_POST["pwd2"]);
  $_POST["pwd2"] = $staff->getPwd2();
  $staff->setCircAuth(isset($_POST["circ_flg"]));
  $staff->setCircMbrAuth(isset($_POST["circ_mbr_flg"]));
  $staff->setCatalogAuth(isset($_POST["catalog_flg"]));
  $staff->setAdminAuth(isset($_POST["admin_flg"]));
  $staff->setReportsAuth(isset($_POST["reports_flg"]));
  
  #**************************************************************************
  #*  Validation of the new staff member datas
  #**************************************************************************
  $validData = $staff->validateData();
  if ($staff->getTypeOfPwdCreation() != 1) {
    $validPwd = $staff->validatePwd();
  } else {
      $validPwd = "notSet";
      $staff->setPwd(NULL);
  }
  if (!($validData && $validPwd)) {
    $pageErrors["last_name"] = $staff->getLastNameError();
    $pageErrors["username"] = $staff->getUsernameError();
    $pageErrors["email"] = $staff->getEmailError();
    $pageErrors["pwd"] = $staff->getPwdError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/staff_new_form.php");
    exit();
  }

  #**************************************************************************
  #*  Insert new staff member
  #**************************************************************************
  $staffQ = new StaffQuery();
  $staffQ->connect_e();
  if ($staffQ->errorOccurred()) {
    $staffQ->close();
    displayErrorPage($staffQ);
  }
  $staff->setUserid($staffQ->insert($staff));
  if ($staff->getUserid() == Null) {
    $staffQ->close();
    displayErrorPage($staffQ);
  }
    
#**************************************************************************
#*  If the password will be created by the library member by e-mail.
#**************************************************************************
if($staff->getTypeOfPwdCreation() == 1 && (!$staff->getUserid() == NULL)) {
    #********************************************************************************
    #* Creation of the password code, encryption and entry in the DB in table member
    #******************************************************************************** 
    $passwordCode = $staff->random_string();
    $staff->setPwdForgotten(hash('sha256', $passwordCode));
    $success = $staffQ->setPwdForgottenCode($staff);
    if ($success == NULL) {
        $error = $loc->getText('errNoPwdForgottenCode');
    }
    $staffQ->close();
    
    #************************************************************************
    #* Creation of the URL for resetting the password
    #************************************************************************        
    $url_passwordcode = $staff->createURLPwdCode($staff, $passwordCode);
    
    #********************************************************************************
    #* Reference to the required message (DB --> mail_messages --> mail_message_type)
    #********************************************************************************
    $mailMessageType = 'welcome_message';
    
    #**************************************************************************
    #*  Preparation of the text variables which will be included in the message
    #**************************************************************************
    // PwdForgottenCodeDuration is only set in Mailing.php as an exception, as MailSet is queried there first.
    $mailTextVariables = array(
            "FirstName"   => $staff->getFirstName(),
            "LastName"    => $staff->getLastName(),
            "url_pwdcode" => $url_passwordcode);
    
    #**************************************************************************
    #*  Preparation of fürhter variables for mailing
    #**************************************************************************
    $mailAdress = $staff->getEmail();
    $noticeSuccess = $loc->getText('staffNewMailingSuccessful');
    $noticeError = $loc->getText('errMailCouldNotBeSent');
    
    #**************************************************************************
    #*  Inclusion of the general mailing code
    #**************************************************************************
    include_once('../classes/email/Mailing.php');

}

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("adminStaff_Staffmember"); ?> <?php echo H($staff->getFirstName());?> <?php echo H($staff->getLastName());?><?php echo $loc->getText("adminStaff_new_Added"); ?><br><br>
<a href="../admin/staff_list.php"><?php echo $loc->getText("adminStaff_Return"); ?></a>

<?php require_once("../shared/footer.php"); ?>
