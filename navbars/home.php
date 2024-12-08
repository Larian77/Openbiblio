<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");
  $navLoc = new Localize(OBIB_LOCALE,"navbars");

 if (isset($_SESSION["userid"])) {
   $sess_userid = $_SESSION["userid"];
 } else {
   $sess_userid = "";
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
 
 if ($sess_userid == "") { ?>
  <input type="button" onClick="self.location='../shared/loginform.php?RET=../home/index.php'" value="<?php echo $navLoc->getText("login");?>" class="navbutton">
  <br /><br />
<?php } else { ?>
  <input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton">
<?php 
    echo '<p class="loginName">' . $sess_firstName . ' ' . $sess_lastName . '</p>';
} ?>

<?php if ($nav == "home") { ?>
 &raquo; <?php echo $navLoc->getText("homeHomeLink");?><br>
<?php } else { ?>
 <a href="../home/index.php" class="alt1"><?php echo $navLoc->getText("homeHomeLink");?></a><br>
<?php } 

 if ($nav == "pwdforget") {
    echo '&raquo; ' . $navLoc->getText("PwdNewSet") . '<br>';
}
?>

<?php if ($nav == "license") { ?>
 &raquo; <?php echo $navLoc->getText("homeLicenseLink");?><br>
<?php } else { ?>
 <a href="../home/license.php" class="alt1"><?php echo $navLoc->getText("homeLicenseLink");?></a><br>
<?php } ?>

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navLoc->getText("help");?></a>
