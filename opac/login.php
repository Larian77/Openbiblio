<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  require_once("../opac/MemberLoginQuery.php");
  require_once("../classes/MemberQuery.php");
  require_once("../functions/errorFuncs.php");

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
    $pageErrors["username"] = "MemberID is required.";
  }

  #****************************************************************************
  #*  Password edits
  #****************************************************************************
  $error_found = false;
  $pwd = $_POST["pwd"];
  if (str_replace(' ','',$pwd) == "") {
    $error_found = true;
    $pageErrors["pwd"] = "Secret Word is required.";
  } else {

    $mbrQ = new MemberQuery();
    $mbrQ->connect_e();
    $mbrQ->execSearch(OBIB_SEARCH_BARCODE,$username,1);
    
    if ($mbrQ->getRowCount() == 1) {
    	$mbr = $mbrQ->fetchMember();
	$mbrQ->close();

    	$SecQ = new MemberLoginQuery();
    	$SecQ->connect_e();
    	$SecQ->checkSecret();
    	if ($SecQ->errorOccurred()) {
       		displayErrorPage($SecQ);
    	}
    	$secret = $SecQ->fetchRow();
    	$SecQ->close();
    	if ($secret == false) {
     		$error_found = true;
     		$pageErrors["common"] = "No Memberfield 'secret' defined. Member-Login is deactivated!";
    	} else {
    		$mbrLgQ = new MemberLoginQuery();
    		$mbrLgQ->connect_e();
    		$mbrLgQ->verifySignon($mbr->getMbrid(), $pwd);
    		if ($mbrLgQ->errorOccurred()) {
       			displayErrorPage($mbrLgQ);
    		}
    		$row = $mbrLgQ->fetchRow();
    		$mbrLgQ->close();
    		if ($row == false) {
     			$error_found = true;
     			$pageErrors["common"] = "Invalid Logon. Maybe you don't have a Secret Word? Please ask the Staff!";
    		} else {
  			$token = rand(-10000,10000);;

 			#**************************************************************************
			#*  Destroy form values and errors and reset signon variables
  			#**************************************************************************
  			unset($_SESSION["postVars"]);
  			unset($_SESSION["pageErrors"]);

  			$_SESSION["mbrid"] = $mbr->getMbrid();
  			$_SESSION["mbrtoken"] = $token;
			header("Location: ../opac/mbr_account.php?mbrid=".U($mbr->getMbrid()));
    			exit();
    		}
    	}
    } else {
    	$mbrQ->close();
    	$error_found = true;
    	$pageErrors["common"] = "Invalid Logon. Maybe you don't have a Secret Word? Please ask the Staff!";
    }
  }

  #****************************************************************************
  #*  Redirect back to form if error occured
  #****************************************************************************
  if ($error_found == true) {
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../opac/loginform.php");
    exit();
  }

  if (!isset($_SESSION["returnPage"]) || ($_SESSION["returnPage"] == "")) {
      $_SESSION["returnPage"] = '../opac/loginform.php';
  }
  
  header("Location: ".$_SESSION["returnPage"]);
  exit();

?>
