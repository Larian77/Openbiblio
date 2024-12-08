<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../classes/Localize.php");
require_once("../opac/MemberLoginQuery.php");
$navLoc = new Localize(OBIB_LOCALE,"navbars");

/************************************************************************
 * Session_mbr-Request with reference to login and logout button 
 ************************************************************************/   
if (isset($_SESSION["mbrid"])) {
    $sess_mbrid = $_SESSION["mbrid"];
} else {
    $sess_mbrid = "";
}
if (isset($_SESSION["mbrFirstName"])) {
     $sess_mbrFirstName = $_SESSION["mbrFirstName"];
} else {
    $sess_mbrFirstName = "";
}
if (isset($_SESSION["mbrLastName"])) {
    $sess_mbrLastName = $_SESSION["mbrLastName"];
} else {
    $sess_mbrLastName = "";
}

/************************************************************************
 * Session staff-Request: Is a staff member logged in?
 *  ************************************************************************/ 
if (isset($_SESSION["userid"])) {
    $sess_userid = $_SESSION["userid"];
} else {
    $sess_userid = NULL;
}
if (isset($_SESSION["firstName"])) {
     $sess_firstName = $_SESSION["firstName"];
 } else {
     $sess_firstName = "";
 }
 if (isset($_SESSION["lastName"])) {
     $sess_lastName = $_SESSION["lastName"];
 } else {
     $sess_lastName = "";
 }

// instead of link now buttonn
if (OBIB_MBR_ACCOUNT_ONLINE == TRUE) {
      if ($sess_mbrid > 0) { ?>
            <input type="button" onClick="self.location='./logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton">
<?php 
            echo '<p class="loginName">' . $sess_mbrFirstName . ' ' . $sess_mbrLastName . '</p>';
      } else if ($nav == "userlogin") {
            echo '&raquo; ' . $navLoc->getText("userlogin");;
      } else if ($sess_userid > NULL ) { ?>
            <input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton">
      <?php echo '<p class="loginName"><span class="underline">' .$navLoc->getText("staff") . '</span><br />';
            echo $sess_firstName . ' ' . $sess_lastName . '</p>';
      } else { ?>                    
            <input type="button" onClick="self.location='../opac/loginform.php'" value="<?php echo $navLoc->getText("userlogin");?>" class="navbutton">
            <br /><br />    
<?php } 
 
    if ($nav == "memberaccount") {
        echo '&raquo; ' . $navLoc->getText("memberaccount") . '<br>';
        if (OBIB_MBR_ACCOUNT_ONLINE == TRUE) {
            if ($mbr->getPwd() == "") {
                echo '&nbsp; &nbsp;<a href="../opac/mbr_pwd_reset_form.php?mbrid=' . $sess_mbrid
                        . '" class="alt1">' . $navLoc->getText("PwdCreate") . '</a><br>';
            } else {
                echo '&nbsp; &nbsp; <a href="../opac/mbr_pwd_reset_form.php?mbrid=' . $sess_mbrid 
                        . '" class="alt1">' . $navLoc->getText("PwdReset") . '</a><br>';
            }
        }
    } 

    if (isset($sess_mbrid) && !$sess_mbrid == "" && ($nav != "memberaccount") && (!$nav == "pwdforget")) { 
        echo '<a href="../opac/mbr_account.php?mbrid=' . $sess_mbrid;
        if (isset($lookup) == 'Y') {
            echo '&lookup=Y';
        }
        echo '" class="alt1">' . $navLoc->getText("memberaccount") . '</a><br>';
        echo '&nbsp;&nbsp;&raquo; ' . $navLoc->getText("PwdReset") . '<br>';
    }
    if ($nav == 'PwdReset'){
        echo '<a href="../opac/mbr_account.php?mbrid=' . $sess_mbrid;
    }
}
if ($nav == "home") { 
    echo '&raquo; ' . $navLoc->getText("catalogSearch") . '<br>';
} else { ?>
    <a href="../opac/index.php<?php if (isset($lookup) == 'Y') echo "?lookup=Y"; ?> " class="alt1"><?php echo $navLoc->getText("catalogSearch"); ?></a><br>
<?php 
} 
if ($nav == "search") {
    echo '&raquo; ' . $navLoc->getText("catalogResults") . '<br>';
}
if ($nav == "view") {
    echo '&raquo; ' . $navLoc->getText("catalogBibInfo") . '<br>';
}
if ($nav == "pwdforget") {
    echo '&raquo; ' . $navLoc->getText("PwdNewSet") . '<br>';
}
?>

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navLoc->getText("Help"); ?></a>
